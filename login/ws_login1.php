<?php
/*define('USER', 'efra');
define('PASS', 'margarito');*/
$link = mysql_connect('localhost:3306', 'root', '')// abrimos una nueva conxion
    or die('No se pudo conectar: ' . mysql_error());
	echo 'conexion exitosa';
	echo '<br>';
	mysql_select_db('loading') or die('No se pudo seleccionar la base de datos');


$query = "SELECT * FROM usuario";
$resultados = mysql_query($query) or die('Consulta fallida: ' . mysql_error());//ejecutamos la consulta

/*$user = trim($_POST['user']);
$pass = trim($_POST['pass']);*/

//Password ans Username received
$data = json_decode(file_get_contents("php://input"));//recibimos el json que se envio con los datos de usuario y password
$user = $data->user;//obtenemos el usuario del json
$pass = $data->pass;//obtenemos el password del json

$error = array();// se declara un arreglo para los errores de autentificacion de usuario.
$error['user'] = '404 Error el usuario es incorrecto';
$error['pass'] = '404 Error el password es incorecto';
$error['two'] = '404 Error cheque su usuario y password';
$datos = array();// se declara el arreglo detos para guardar lso datos ha ocupar quetrae la consulta a la base de datos como id user etc.
$i=0;// inicialisamos una variable para cada registro de la consulta.
while ($ROW = mysql_fetch_array($resultados, MYSQL_ASSOC))// se pasa toda la consulta por el while para desglosarla
{
	echo("si entra al while");
	$consulta[$i] = json_decode($ROW['json'],true);//se obtiene el valor del campo json que es un josn con el nombre de usuario y password.
	//Check username and password
	if($user == $consulta[$i]['user'])// se compara si el usuario que se optubo por post coincide con el nombre de usuario que trae el json.
	{
		if($pass == $consulta[$i]['pass'])// s compara se el password es correcto.
		{
			echo("all correct");
			$datos['id'] = $ROW['id_usuario'];// guardamos el id del usuario en el arrglo datos 
			//echo($datos['id']);
			break;
		}
		else
		{// ingresa a el else si el password es incorrecto.
			//wrong pass
			echo("wrong pass");
			die(json_encode($error['pass']));// se regresa un error del arreglo combirtiendolo en json con json_encode y detenemos el servicio con el DIE.
			
			break;
		}
	}
	else
		if($pass == $consulta[$i]['pass'])// comprobamos el usuario mal y regresamos el error en formato json y detenemos la ejecucion con DIE
		{
			//wrong username
			echo("wrong username");
			die(json_encode($error['user']));
			break;
		}
		else
		{// si ambos estan mal.
			//all wrong
			echo("all wrong");
			die(json_encode($error['two']));
		}
	$i++;
}

$result = generate_access_token(json_encode($user), $datos['id']);
/* se manda llamar el metodo de generar token
 pasandole commo parametros el nombre de usuario y el id obtenido por medio de la consulta.*/
echo json_encode($result);// regresamos el access token que geeramos por medio del metodo generate_access_token en formato json con json_encode.
$user1 = array();
function generate_access_token($str_user, $id_user){// funcion para generar los access token.
	//Get from database
	
	$user1[] = $str_user;
	$user1[] = $id_user;
	$user1[] = time() + 3600;// el tiempo que se genera hasta que tiempo mas se le ba sumar para que el token se expire.
	$user1[] = md5(implode('',$user1));// encriptamos el user todo el arreglo.
	return array('res' => implode('|', $user1));// regresamos el array guntandolo con implode
}