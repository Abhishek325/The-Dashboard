<?php
/**
 * @package Routes
 * @Caution Heavy use of closures Ahead
 **/
 
/**
 * @route www.vtuacademy.com/Status/
 **/
$Router->get('/Status/', function() use ($Config) {
	if($Config->debug_mode_is_on()){
		echo "Monkey Do.";
	}
	else
	{
		echo "All Systems Are Go!";
	}
});
