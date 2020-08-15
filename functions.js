$(window).ready(function() {
	var debug = false;
	var msgdetail="";
	var msg = document.getElementById("msg");
	if(debug){$("#msg").show();}
	if(!debug){$("#msg").hide();}
     
	var clock = document.getElementById("clock");
	var url = 1;

	var format = 'HH:mm:ss'
	var dateTimeNow = moment().format(); //default  
	var time = moment(moment(),format); //custom
	var timePlusMin = moment().add(20, 'minutes')
	var timePlusMax = moment().add(80, 'minutes')
	var early = moment('06:00:00', format);
	var late = moment('22:00:00', format);

	night = true
	if (time.isBetween(early, late)) { night = false }
	
	console.log("Night:"+night)
	
	msgdetail += "Initialized \n"
	msg.innerHTML = msgdetail



		
	 //Randomize array element order in-place.
	 //Using Durstenfeld shuffle algorithm.
	 
	function shuffleArray(array) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}

	
	//get NS-data departures
	$(function() {
		var params = {
		dateTime:dateTimeNow,
		maxJourneys:'7',
		lang:'nl',
		uicCode:'8400390'
		};
		msgdetail += "initialized function departure\n"
		msg.innerHTML = msgdetail
		//console.log($.param(params))
		$.ajax({
			url: "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?" + $.param(params),
       			headers: {
 	     			"accept": "application/json",
  				"Access-Control-Allow-Origin":"http://narrowcasting-ns.vslcatena.lan"
      	  		},
			//url: "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?dateTime=2019-09-07 22:02:00&maxJourneys=25&lang=nl&uicCode=8400390",
			beforeSend: function(xhrObj){
				// Request headers
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
			},
			type: "GET",
			// Request body
			//data: "{body}",
		})
		.done(function(data) {
			//alert("success");
			msgdetail +=  "function departures success\n"
			msg.innerHTML = msgdetail
			console.log(data.payload.departures);
			clock.innerHTML = moment(dateTimeNow).format("HH:mm")
			i = 0;
			data.payload.departures.forEach(function loop(value,key) {
					if(loop.stop){ return; }
					//console.log(value,key);
					//console.log(moment(value.actualDateTime))
					if(moment(value.actualDateTime).isBefore(timePlusMin)) return;
					//console.log(i);
					
					var newRowData = ""
					+"<td id='"+ i +"-time' class='dept-time'></td>"
					+"<td id='"+ i +"-dest' class='dept-dest'></td>"
					+"<td id='"+ i +"-track' class='dept-track'></td>"
					+"<td id='"+ i +"-extra' class='dept-extra'></td>"
					+"<td id='"+ i +"-walk' class='dept-walk'></td>"
					+"";
					$('#'+i).html(newRowData);
					
					$('tbody').append('<tr id="'+(i+1)+'"></tr>');
					
					
					var time = document.getElementById(i+"-time");
					var dest = document.getElementById(i+"-dest");
					var track = document.getElementById(i+"-track");
					var extra = document.getElementById(i+"-extra");
					var walk = document.getElementById(i+"-walk");
					
					var vertraging =  moment(value.actualDateTime).diff(moment(value.plannedDateTime),"minutes")
					
					if(vertraging >0) {$(time).css('color', 'red');}
					time.innerHTML = moment(value.actualDateTime).format("HH:mm") + " (" + vertraging + ")"
					dest.innerHTML = value.direction
					track.innerHTML = value.plannedTrack
					extra.innerHTML = value.product.categoryCode
					walk.innerHTML = moment(moment(value.actualDateTime).subtract(20,"minutes")).format("HH:mm")
					
					//var reachPlusMax = moment(value.actualDateTime).isBefore(timePlusMax)
					//console.log(vertraging)
					i =  i + 1
					
					//if(reachPlusMax = false || i > 8){ loop.stop = true; }
					if(i > 8){ loop.stop = true; }
				
			});
		
		//end of successful script
		
		//day/night script
		if(night){
			$("#background").removeClass('bg-dark').addClass('background-night');
			$("table").removeClass('table-light').addClass('table-dark');
			$("thead").removeClass('text-light').addClass('text-dark');
			$("#feedbase").removeClass('bg-light').addClass('bg-dark');
			$("#feed").removeClass('text-dark').addClass('text-light');
			}
		else {
			$("#background").removeClass('bg-dark').addClass('background-day');
			$("table").removeClass('table-dark').addClass('table-light');
			$("thead").removeClass('text-dark').addClass('text-light');
			$("#feedbase").removeClass('bg-dark').addClass('bg-light');
			$("#feed").removeClass('text-light').addClass('text-dark');
			}
			

		
		var $classtd = $('.table td');

		function activate() {
		$classtd.removeClass('fontparty')
		 .eq([Math.floor(Math.random()*$classtd.length)])
		 .addClass('fontparty');
		setTimeout(activate, 60000);
		}
		if(Math.floor(Math.random()*10) <=2){
			activate();
			console.log("fontparty")
			
		}
		
		
		// show the data
		$("#container").show();	
		if(debug==true){
			$("#container").hide();				
		}
		$("#loading").hide();

		
		})
		.fail(function(xhr) {
			//alert("error");
			//console.log(xhr)

			msgdetail += "Departures error:" + xhr.responseText+ "\n"
			msg.innerHTML = msgdetail
			console.log("Error");
			// show the data

		
			
		});
		

		
	});


	//get NS-data disruptions
	$(function() {
		//console.log($.param(params))
		msgdetail += "function disruptions initialized \n"
		msg.innerHTML =msgdetail
		
		$.ajax({
			url: "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/disruptions/station/8400390",
      			headers: {
		          "accept": "application/json",
		          "Access-Control-Allow-Origin":"http://narrowcasting-ns.vslcatena.lan"
      	  		},
			beforeSend: function(xhrObj){
				// Request headers
				xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apikey);
			},
			type: "GET",
			// Request body
			//data: "{body}",
		})
		.done(function(data) {
			//alert("success");
			msgdetail += "function disruptions success \n"
			msg.innerHTML = msgdetail
			console.log(data.payload);
			var delays = document.getElementById("delays");
			data.payload.forEach(function loop(value,key) {
								
				var ul = document.createElement('ul');
				delays.appendChild(ul)
			
				$("#delays ul:nth-last-child(1)").append('<li><b>'+value.titel+'</b></li><li class="li-nobullet">'+value.verstoring.oorzaak+'</li><li class="li-nobullet">'+value.verstoring.verwachting+'</li>');
				console.log(value)			
			})
			
			
		})
		.fail(function(xhr) {
			msgdetail += "Disruptions error:" + xhr.responseText+ "\n"
			msg.innerHTML =msgdetail
			console.log("Error");
			
		});
		

		
	});
	if(Math.floor(Math.random()*10) <=1){
		var url = 2
		console.log("humor")
	}
	function news(url) {
		var feed = "feed.php?url="+url;
		var divfeed = document.getElementById("feed");
		var newsarray = [];
		$.get(feed, function (data) {
			if(data == null){
				msgdetail += "news error:" + data+ "\n"
				msg.innerHTML = msgdetail
			}
			//console.log(data);
			$(data).find("item").each(function () { // or "item" or whatever suits your feed
				var el = $(this);
				//console.log(el);
				newsarray.push(el.find("title").text());

			});
			msgdetail += "news success:" + data + "\n"
			msg.innerHTML = msgdetail
			newsarray = shuffleArray(newsarray);
			var newsstring = newsarray.join("  |  ");
			divfeed.innerHTML = newsstring; //newsarray
			//console.log(newsarray);
			//console.log(newsstring);

		});
	}
    news(url);

	/*
	//BUIENRADAR <3 Tnx Thomas
     function request() {
		msg.innerHTML = "function request started"
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                doDraw(xmlHttp.responseText);
        }
        xmlHttp.open("GET", "https://graphdata.buienradar.nl/forecast/json/?lat=52.156178&lon=4.485454", true); // true for asynchronous 
        xmlHttp.send(null);
		console.log("send BR request");
    }

    function doDraw(text) {
        let data = JSON.parse(text);
        console.debug(data);

        var canvas = document.getElementById("buienradar");
        var ctx = canvas.getContext("2d");
		ctx.canvas.width  = window.innerWidth*0.85;
		ctx.canvas.height = window.innerHeight*0.2;
		
		ctx.canvas.graphStart = canvas.height*0.1;
		ctx.canvas.graphEnd = canvas.height*0.85;
		
		console.log("canvas.width:"+canvas.width)
		console.log("canvas.height:"+canvas.height)
		
		ctx.font = "2.5vw Arial";
        ctx.fillStyle = data.color;
        ctx.save();
        ctx.translate(0, -20);
        drawGraph(canvas, ctx, data.forecasts);
        ctx.restore();
    }

    function drawGraph(canvas, ctx, forecasts) {
        const partSize = canvas.width / (Math.floor(forecasts.length / 2) * 2);
        // Save the state so we don't screw up later
        ctx.save();
        // Translate and scale so we can draw with the bottom-left being the origin
        ctx.translate(0, canvas.height);
        ctx.scale(1, -1);

        //We start at 0,0
        ctx.beginPath();
        ctx.moveTo(0, canvas.graphStart);

        // And then for each line we move to the corresponding value
        var x = 0;
        forecasts.forEach(function(item) {
            //console.log(item.value/100);
			ctx.lineTo(x++ * partSize, item.value/100*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        });
        // Then we make a line to the start and fill it
        ctx.lineTo((x-1) * partSize, canvas.graphStart);
        ctx.fill();

        const verticals = forecasts.length/2;
        // Vertical lines
        for(var i = 1; i < verticals; i++) {
            // Every non%3 line we want dim
            if (i % 3 != 0) {
                ctx.strokeStyle = "#e7e7e7"
            } else {
                ctx.strokeStyle = "#c4c4c4"
            }

            ctx.beginPath();
            ctx.moveTo(i * partSize * 2, canvas.graphStart);
            ctx.lineTo(i * partSize * 2, canvas.graphEnd);
            ctx.stroke();
        }

        ctx.strokeStyle = "#c4c4c4";

        // Horizontal lines
        ctx.beginPath();
        ctx.moveTo(0, 0.4*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        ctx.lineTo(canvas.width, 0.4*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        ctx.moveTo(0, 0.7*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        ctx.lineTo(canvas.width, 0.7*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        ctx.stroke();

        // Border around the field
        ctx.beginPath();
        ctx.lineTo(0, canvas.graphStart);
        ctx.lineTo(0, canvas.graphEnd);
        ctx.lineTo(canvas.width, canvas.graphEnd);
        ctx.lineTo(canvas.width, canvas.graphStart);
        ctx.lineTo(0, canvas.graphStart);
        ctx.stroke();

        // Draw the time text
        drawTimeText(canvas, ctx, forecasts, partSize);

        // Draw the light, heavy text
        drawLightHeavyText(canvas, ctx);

        // And restore the state
        ctx.restore();
    }

    function drawTimeText(canvas, ctx, forecasts, partSize) {
        ctx.save();
        // We position ourselves
        ctx.translate(0, -0.8*canvas.graphStart);

        ctx.textAlign = "left";
        drawText(ctx, "Nu", 10)

        ctx.textAlign = "center";
        for (var i = 1; i < forecasts.length/6-1; i++) {
            // We set all the times at the bottom except the last one
            drawText(ctx, timeFromString(forecasts[i * 6].datetime), partSize * i * 6);
        }

        // If the last one is a %3 then we want to align the text to the right of the border
        if (Math.floor(forecasts.length/2)%3 == 0) {
            ctx.textAlign = "right";
            drawText(ctx, timeFromString(forecasts[forecasts.length-1].datetime), canvas.width);
        } else {
            // Otherwise we want to center it under the last vertical lign
            ctx.textAlign = "center";
            drawText(ctx, timeFromString(forecasts[Math.floor(forecasts.length/6)*6].datetime), partSize * 6 * Math.floor(forecasts.length/6));
        }

        ctx.restore();
    }

    function drawLightHeavyText(canvas, ctx) {
        ctx.save();
		ctx.translate(0,0);
        ctx.translate(canvas.width*0.995, 0.05*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        ctx.textAlign = "right";
        ctx.shadowBlur=7;

        // Here we draw light and heavy
        drawText(ctx, "Licht", 0);
        ctx.translate(0, 0.55*(canvas.graphEnd-canvas.graphStart)+canvas.graphStart);
        drawText(ctx, "Zwaar", 0);

        ctx.shadowBlur=0;
        ctx.restore();
    }

    function drawText(ctx, text, x) {
        ctx.save();
        ctx.translate(x, 0);
        ctx.scale(1, -1);
        ctx.fillStyle = "white";
        ctx.fillText(text, 0, 0);
        ctx.restore();
    }

    function timeFromString(text) {
        let date = new Date(text);
        return date.getHours().pad()+":"+date.getMinutes().pad();
    }

    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }

   request(); 
   */


});

