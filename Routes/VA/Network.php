<?php

$Router->get('/curl/ping/([a-z0-9]+\.\w+)',function($url) use ($Config) {
	$Curl=new \Curl\Curl($Config);
$a=$Curl->ping("http://".$url);
if($a){
	echo "Successfully pinged ".$url;
}
else{
	echo "Unsuccessful - ".$url;
}

});