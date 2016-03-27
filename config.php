<?php namespace config;

/* CONSTANTS */
define('CONFIG_FILENAME', 'config');
define('PARAMETER_REGEX_PATTERN', '/(.*)(=)(.*)/');

/* DO THE WORK */
class Config{
	static function getParams(){
		// get the raw contents
		$raw_contents = file(CONFIG_FILENAME);
		// declare the paramaters array ...
		$params = array();
		// ... now build it
		foreach($raw_contents as $raw_line){
			#echo "$raw_line <br/>";
			if (preg_match(PARAMETER_REGEX_PATTERN, $raw_line)) {
				#echo "$raw_line<br/>";
				// process the raw line
				$parts = explode('=', $raw_line);
				$name = trim($parts[0]);
				$value = trim($parts[1]);
				// add to params array
				$params[$name] = $value;
			}
		}
		// test loop
		#echo "testing params array<br/>";
		#foreach($params as $key => $value){
		#	echo "$key => $value<br/>";	
		#}
		return $params; 
	}
}

/* USAGE */
// paste the following code where config param's are required.
/*
include 'config.php';
use config as conf;
$params = conf\Config::getParams();
*/

/* TESTING */
// test lines
#$params = Config::getParams();
#echo "testing params array<br/>";
#foreach($params as $key => $value){
#	echo "$key => $value<br/>";	
#}





?>
