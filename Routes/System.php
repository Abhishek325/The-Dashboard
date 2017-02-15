<?php
/**
 * @package Routes
 * @Caution Heavy use of closures Ahead
 **/
 
/**
 * @route www.vtuacademy.com/Status/
 **/

$Router->get('/Status/', function() use ($Service) {
	if($Service->Config()->debug_mode_is_on()){

		echo "Monkey Do.";
	}
	else
	{
		echo "All Systems Are Go!";
	}
});


$Router->post('/info/secure',function() use ($Service) {
	phpinfo();
});

$Router->get('/system.install', function() use ($Service) { 
		   //////////////////////////////////////////////////////
		   /////INSTALLATION STARTS HERE//////////////////////////  
		  	$Service->Prote()->DBI()->Func()->acct()->install();
		  	$Service->Prote()->DBI()->Func()->alarm()->install();
		  	$Service->Prote()->DBI()->Func()->activity()->install();
		  	$Service->Prote()->DBI()->Func()->comment()->install();
		  	$Service->Prote()->DBI()->Func()->custom()->install();
		  	$Service->Prote()->DBI()->Func()->data()->install();
		  	$Service->Prote()->DBI()->Func()->event()->install(); 
		  	$Service->Prote()->DBI()->Func()->notes()->install();
		  	$Service->Prote()->DBI()->Func()->notification()->install(); 
		  	$Service->Prote()->DBI()->Func()->rate()->install();  
		  	$Service->Prote()->DBI()->Func()->reminder()->install();
		  	$Service->Prote()->DBI()->Func()->thought()->install();
		  	$Service->Prote()->DBI()->Func()->web()->install();
		  	$Service->Prote()->DBI()->Func()->projects()->install();		   
		  	echo "<h3><a href='/login'>Click here</a> to login.</h3>";  
});

$Router->get('/update/0.0.1/', function() use ($Service) {
		// $auth=$Service->Auth();
		// $auth->install();
	
});

