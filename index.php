<?php
/* in this file works as Routing URLs to generate the URI which type any url that redirects 
through. htacces index.php has to come into this function Routing.*/ 
echo("hello"."<br>");
$urls = $_SERVER['REQUEST_URI'];// get the url in the browser written in.
$swhic_uri = array(//generate an array to define the URI pointing to the respective actual path.
	"/webservice/" => "login/ws_login1.php",
	"/webservice/image/" => "login/image64.php",
	"/webservice/image/about" => "login/imagen.php",
);

foreach($swhic_uri as $key => $value){// entire array of uri's generated is passed to make validations and load the respective file.
	if($key == $urls){
		//echo ($value."<br>");
		require_once($value);//require the file was coinsidencia with URI.
	}
}


?>