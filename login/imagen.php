<?php
//echo("hola");
require_once("image64.php");// require the image64 that is where we have the image 
//echo $imagen;
echo '<img src="data:img/jpg;base64,'.$imagen.'" />';// present the image we bring base-64 encoded image in the variable $ this imagen64 declared and presented in img.
?>
