// Parameters
$(window).ready(() => {
    var debug = true;
    var useRaw = true; // Raw is better
    var width = 910; // I found out that w=70,h=12,bp=3 is a good ratio
    var height = 156;
    var bottomPart = 39;
    var viewBoxPadding = 2;
    var svgId = "buienradar";

    var mainBorderColor = '#c4c4c4';
    var subBorderColor = '#e7e7e7';
    var textColor = '#152b81';
    var precipitationColor = '#5A9BD3';

    if ($("body").hasClass("night")) {
        mainBorderColor = '#777';
        subBorderColor = '#555';
        textColor = '#CCC';
    }
    // End Parameters
    
    
    
    // Split up all weathers rows and split them further so:
    // [0] is precipitation intensity
    // [1] is time
    function doDraw(weathers) {
        // Create SVG
        var svg = document.getElementById(svgId);
        svg.setAttribute('viewBox', '-' + viewBoxPadding + ' -' + viewBoxPadding + ' ' + (width + viewBoxPadding) + ' ' + (height + viewBoxPadding));
        svg.style.overflow = 'visible';
        
        if (debug) console.debug(weathers);
    
        // Define some ease-of-use variables
        var widthPart = width / (weathers.length - 1);
        var height100 = height - bottomPart;
        var heightPart = height100 / 100;
        var maxHeight = heightPart * 100;
    
    
        // Create points
        var points = [];
        
    
        var path = weathers.map((item, index) => {
            // Invert intensity
            var intensity = 100 - parseInt(item);
            // Now times the height every part should take
            intensity = intensity * heightPart;
    
            return (index * widthPart) + ',' + intensity;
        });
    
        // Add path back to origin
        path.push(width + ',' + maxHeight);
        path.push('0,' + maxHeight);
    
        // Join the array completely back
        path = path.join(' ');
    
        var polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        polygon.setAttribute('points', path);
        polygon.style.fill = precipitationColor;
    
        svg.appendChild(polygon);
    
        
        // Add the two sub horizontal lights. We do this here so the main lines will be rendered over it
        svg.appendChild(createLine(0, heightPart * 30, width, heightPart * 30, subBorderColor));
        svg.appendChild(createLine(0, heightPart * 60, width, heightPart * 60, subBorderColor));
    
    
        // Adding vertical main grid
        for (var x = 0; x < weathers.length; x += 2) {
            var line = createLine(
                x * widthPart,
                0,
                x * widthPart,
                height100
            )
    
            if (x % 6 == 0 && x != weathers.length - 1) {
                line.style.stroke = mainBorderColor;
                
                // Also add text
                svg.appendChild(createText(
                    x * widthPart,
                    height100 + 20,
                    x == 0 ? 'Nu' : weathers[x][1],
                    x == 0 ? 'start' : 'middle'
                ));
            } else {
                line.style.stroke = subBorderColor;
            }
            svg.appendChild(line);
            
        }
        // Add last line
        svg.appendChild(createLine(width, 0, width, height100, mainBorderColor));
        
        // And last text
        if ((weathers.length - 2) % 6 > 4) {
            svg.appendChild(createText(
                width, height100 + 20, weathers[weathers.length - 1][1], 'end'
            ));
        }
    
        // Vertical lines
        svg.appendChild(createLine(0, 0, width, 0, mainBorderColor))
        svg.appendChild(createLine(0, height100, width, height100, mainBorderColor));
    
    
        // Add Light and heavy text
        svg.appendChild(createText(width - 5, 15, 'Zwaar', 'end'));
        svg.appendChild(createText(width - 5, height100 - 7, 'Licht', 'end'));
    
        // If there is no precipitation at all, we show a text for that
        if (weathers.every(item => item[0] == 0))
            svg.appendChild(createText(width/2, height100/2, 'Geen neerslag verwacht', 'middle'));
    }
    
    
    
    function request() {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                var data;
    
                if (useRaw) data = convertDataRaw(xmlHttp.responseText);
                else data = convertDataAPI(xmlHttp.responseText);
                
                doDraw(data);
            }
        }
    
        if (useRaw)
            xmlHttp.open('GET', 'https://graphdata.buienradar.nl/2.0/forecast/geo/Rain3Hour?lat=52.16&lon=4.49', true); // true for asynchronous 
        else
            xmlHttp.open('GET', 'https://gpsgadget.buienradar.nl/data/raintext?lat=52.16&lon=4.49', true); // true for asynchronous 
        xmlHttp.send(null);
    }
    
    
    function convertDataAPI(data) {
        var weathers = data.split(/[\r\n]+/g).map(str => str.split('|'));
        
        // We get an extra item (which is empty) so we pop it off
        weathers.pop();
    
        // Map the 0-255 to 0-100
        weathers = weathers.map(weather => {
            return [
                weather[0] / 255 * 100,
                weather[1]
            ]
        });
    
        return weathers;
    }
    
    function convertDataRaw(data) {
        var forecasts = JSON.parse(data).forecasts;
        var weathers = forecasts.map(forecast => {
            return [
                forecast.value,
                toTime(forecast.datetime)
            ];
        })
        
        return weathers;
    }
    
    
    function createLine(x1, y1, x2, y2, color) {
        var line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('x1', x1);
        line.setAttribute('y1', y1);
        line.setAttribute('x2', x2);
        line.setAttribute('y2', y2);
    
        if (color !== undefined) {
            line.style.stroke = color;
        }
    
        return line;
    }
    
    function createText(x, y, text, anchor) {
        var element = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        element.setAttribute('x', x);
        element.setAttribute('y', y);
        element.setAttribute('text-anchor', anchor);
        element.setAttribute('fill', textColor);
        element.innerHTML = text;
        return element
    }
    
    function toTime(dateString) {
        var date = new Date(dateString);
        return (date.getHours() + "").padStart(2, '0') + ':' + (date.getMinutes() + "").padStart(2, '0');
    } 
    
    
    
    
    var test = `000|20:00
    050|20:05
    100|20:10
    080|20:15
    200|20:20
    255|20:25
    160|20:30
    130|20:35
    050|20:40
    020|20:45
    040|20:50
    000|20:55
    000|21:00
    000|21:05
    000|21:10
    000|21:15
    020|21:20
    040|21:25
    070|21:30
    010|21:35
    000|21:40
    000|21:45
    000|21:50
    060|21:55
    `;
    
    // doDraw(convertDataAPI(test));
    
    request();
});