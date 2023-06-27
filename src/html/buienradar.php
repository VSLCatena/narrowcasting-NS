<?php
$settings = array();

if (isset($_GET['width'])) $settings['width'] = intval($_GET['width']);
if (isset($_GET['height'])) $settings['height'] = intval($_GET['height']);
if (isset($_GET['bottomPart'])) $settings['bottomPart'] = intval($_GET['bottomPart']);
if (isset($_GET['darkMode'])) $settings['darkMode'] = boolval($_GET['darkMode']);
if (isset($_GET['debug'])) $settings['debug'] = boolval($_GET['debug']);
if (isset($_GET['useRaw'])) $settings['useRaw'] = boolval($_GET['useRaw']);
if (isset($_GET['padding'])) $settings['padding'] = intval($_GET['padding']);
if (isset($_GET['borderSize'])) $settings['borderSize'] = intval($_GET['borderSize']);
if (isset($_GET['textSize'])) $settings['textSize'] = intval($_GET['textSize']);
if (isset($_GET['bottomPadding'])) $settings['bottomPadding'] = intval($_GET['bottomPadding']);
if (isset($_GET['textPadding'])) $settings['textPadding'] = intval($_GET['textPadding']);

class BuienRadar {
    public $width;   
    public $height;   
    public $bottomPart;   
    public $darkMode;   
    public $useRaw;   
    public $debug;   
    public $padding;   
    public $borderSize;   
    public $bottomPadding;
    public $textSize;
    public $textPadding;   
    public $trueWidth;
    public $trueHeight;
    public $mainBorderColor;
    public $subBorderColor;
    public $textColor;
    public $precipitationColor;
    public $image;
    
    function __construct($settings = array()) {
        $this->width = 700;
        $this->height = 200;
        $this->bottomPart = 20;
        $this->darkMode = false;
        $this->useRaw = true;
        $this->debug = false;
        $this->padding = 5;
        $this->borderSize = 2;
        $this->bottomPadding = 18;
        $this->textSize = 15;
        $this->textPadding = 5;

        foreach ($settings as $key => $value) {
            $this->$key = $value;
        }

        $this->trueWidth = $this->width;
        $this->trueHeight = $this->height;
        
        $this->width = $this->trueWidth - ($this->padding * 2);
        $this->height = $this->trueHeight - ($this->padding * 2);


        // Define colors
        $this->mainBorderColor = '#c4c4c4';
        $this->subBorderColor = '#e7e7e7';
        $this->textColor = '#152b81';
        $this->precipitationColor = '#5A9BD3';

        if ($this->darkMode) {
            $this->mainBorderColor = '#777';
            $this->subBorderColor = '#555';
            $this->textColor = '#EEE';
        }

        $this->image = new Imagick();
        $this->image->newImage($this->trueWidth, $this->trueHeight, new ImagickPixel('transparent'));
    }

    private function getFromApi() {
        if ($this->useRaw) {
            $data = file_get_contents('https://graphdata.buienradar.nl/2.0/forecast/geo/Rain3Hour?lat=52.16&lon=4.49');
            $data = $this->convertDataRaw($data);
        } else {
            $data = file_get_contents('https://gpsgadget.buienradar.nl/data/raintext?lat=52.16&lon=4.49');
            $data = $this->convertDataApi($data);
        }

        return $data;
    }

    function render() {
        $data = $this->getFromApi();

        $this->drawPrecipitation($data);
        $this->drawGrid($data);
        $this->drawExtras($data);

        $this->image->setImageFormat('png');

        if (!$this->debug) {
            header('Content-Type: image/png');
            echo $this->image;
        }
    }

    private function drawPrecipitation($weathers) {
        $draw = new ImagickDraw();
        $draw->translate($this->padding, $this->padding);

        $widthPart = $this->width / (count($weathers) - 1);
        $maxHeight = $this->height - $this->bottomPart;
        $heightPart = $maxHeight / 100;

        $path = array();
        foreach ($weathers as $key => $weather) {
            // Invert intensity
            $intensity = 100 - intval($weather[0]);
            // Now times the height every part should take
            $intensity = $intensity * $heightPart;

            $path[] = array('x' => $key * $widthPart, 'y' => $intensity);
        }

        $path[] = array('x' => $this->width, 'y' => $maxHeight);
        $path[] = array('x' => 0, 'y' => $maxHeight);
        


        if ($this->debug) {
            var_dump($path);
        }

        $draw->setFillColor($this->precipitationColor);
        $draw->polygon($path);

        $this->image->drawImage($draw);
    }

    private function drawGrid($weathers) {
        $widthPart = $this->width / (count($weathers) - 1);
        $maxHeight = $this->height - $this->bottomPart;
        $heightPart = $maxHeight / 100;

        $draw = new ImagickDraw();
        $draw->translate($this->padding, $this->padding);
        $draw->setStrokeColor($this->subBorderColor);
        $draw->setFontSize($this->textSize);
        $draw->setStrokeWidth(2);
        
        // Add the two sub horizontal lights. We do this here so the main lines will be drawn over it
        $draw->line(0, $heightPart * 30, $this->width, $heightPart * 30);
        $draw->line(0, $heightPart * 60, $this->width, $heightPart * 60);

        // Adding vertical main grid
        $draw->setFillColor($this->textColor);
        for ($i = 0; $i < count($weathers); $i += 2) {
            if ($i % 6 == 0 && $i != count($weathers) - 1) {
                $draw->setStrokeColor(new ImagickPixel('transparent'));
                if ($i == 0) {
                    $draw->setTextAlignment(imagick::ALIGN_LEFT);
                    $draw->annotation($i * $widthPart, $maxHeight + $this->bottomPadding, 'Nu');
                } else {
                    $draw->setTextAlignment(imagick::ALIGN_CENTER);
                    $draw->annotation($i * $widthPart, $maxHeight + $this->bottomPadding, $weathers[$i][1]);
                }

                $draw->setStrokeColor($this->mainBorderColor);
            } else {
                $draw->setStrokeColor($this->subBorderColor);
            }

            $draw->line($i * $widthPart, 0, $i * $widthPart, $maxHeight);
        }

        // Add last line
        $draw->setStrokeColor($this->mainBorderColor);
        $draw->line($this->width, 0, $this->width, $maxHeight);

        // Vertical lines
        $draw->line(0, 0, $this->width, 0);
        $draw->line(0, $maxHeight, $this->width, $maxHeight);

        
        // And add last text
        if ((count($weathers) - 2) % 6 > 2) {
            $draw->setStrokeColor(new ImagickPixel('transparent'));
            $draw->setTextAlignment(imagick::ALIGN_RIGHT);
            $draw->annotation($this->width, $maxHeight + $this->bottomPadding, $weathers[count($weathers) - 1][1]);
        }

        $this->image->drawImage($draw);
    }

    private function drawExtras($data) {
        $widthPart = $this->width / (count($data) - 1);
        $maxHeight = $this->height - $this->bottomPart;
        $heightPart = $maxHeight / 100;

        $draw = new ImagickDraw();
        $draw->translate($this->padding, $this->padding);

        $draw->setTextAlignment(imagick::ALIGN_RIGHT);
        $draw->setFontSize($this->textSize);
        $draw->setFillColor($this->textColor);
        $draw->setFontWeight(800);
        
        $textPadding = $this->borderSize + $this->textPadding;
        $draw->annotation($this->width - $textPadding, $this->textPadding + $this->textSize, 'Zwaar');
        $draw->annotation($this->width - $textPadding, $maxHeight - $this->textPadding*2, 'Licht');


        $hasPrecipitation = false;
        foreach ($data as $weather) {
            if ($weather[0] != 0) {
                $hasPrecipitation = true;
                break;
            }
        }

        if (!$hasPrecipitation) {
            $draw->setTextAlignment(imagick::ALIGN_CENTER);
            $draw->annotation($this->width / 2, $maxHeight/2-$this->textSize/2, 'Geen neerslag verwacht');
        }


        $this->image->drawImage($draw);
    }


    private function convertDataRaw($data) {
        $forecasts = json_decode($data)->forecasts;

        $weathers = array();
        foreach ($forecasts as $forecast) {
            $weathers[] = array(
                $forecast->value,
                $this->toTime($forecast->datetime)
            );
        }

        return $weathers;
    }

    private function convertDataApi($data) {
        $data = preg_split("/[\\r\\n]+/", $data);
        $weathers = array();

        foreach ($data as $line) {
            if (!empty($line))
                $weathers[] = explode('|', $line);
        }

        // Map the 0-255 to 0-100
        $newWeathers = [];
        foreach ($weathers as $weather) {
            $newWeathers[] = array(
                $weather[0] / 255 * 100,
                $weather[1]
            );
        }

        if ($this->debug) {
            var_dump($newWeathers);
        }

        return $newWeathers;
    }


    private function toTime($dateString) {
        $date = date_create($dateString);
        return date_format($date, 'H:i');
    }
}



$buienRadar = new BuienRadar($settings);
$buienRadar->render();
