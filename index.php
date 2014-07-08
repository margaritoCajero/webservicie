<?php
/* en este archivo funciona como Enrutamiento de URLs para generar las URI cuanquien url que se escriba se riderecciona
por medio de .htacces ha index.php para que entre en esta funcion de Enrutamiento.*/ 
echo("hola"."<br>");

$urls = $_SERVER['REQUEST_URI'];// obtenemos la url en escrita en el navegador.
$swhic_uri = array(//generamos un arreglo para definir las URI apuntando hacia su respectiva ruta real.
	"/semillerophp/loginaccess/" => "login/ws_login1.php",//apuntamos a el login.php
	
);

foreach($swhic_uri as $key => $value){// se pasa todo el arreglo de uri's generado para hacer las validaciones y cargar su respectivo archivo.
	
	if($key == $urls){
		//echo ($value."<br>");
		require_once($value);// requerimos el archivo que fue coinsidencia con la URI.
	}
}


?>