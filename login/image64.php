<?php
$imagen_rute = "image/logo.jpg";
$binary = fread(fopen($imagen_rute, "r"), filesize($imagen_rute));// open the file and put it in read
$imagen = base64_encode($binary);
echo("the base 64 of the code shown Labs Jaguar logo"."</br>");
echo $imagen;
//echo("holas img");

?>