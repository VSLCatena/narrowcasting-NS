<?php
if(file_exists('/run/secrets/NS_API_KEY')){
   define('NS_API_KEY',file_get_contents('/run/secrets/NS_API_KEY'));
} else {
    define('NS_API_KEY',null);
}
define('NS_STATION_ID',getenv('NS_STATION_ID'));

