<?php
$link = mysql_connect('localhost:3306', 'root', '')// open a new connection
    or die('No se pudo conectar: ' . mysql_error());
	mysql_select_db('loading') or die('Unable to select database');


$query = "SELECT * FROM usuario";
$resultados = mysql_query($query) or die('Consulta fallida: ' . mysql_error());//ejecutamos la consulta

//Password ans Username received
$data = json_decode(file_get_contents("php://input"));//receive the json that was sent with the user data and password
$user = $data->user;//get the user json
$pass = $data->pass;

$error = array();// an arrangement for user authentication error is declared.
$error['user'] = '404 Error el usuario es incorrecto';
$error['pass'] = '404 Error el password es incorecto';
$error['two'] = '404 Error cheque su usuario y password';
$datos = array();//declares the array data to save data you fill quetrae lso consulting the database as user id etc.
$i=0;// initialize .
while ($ROW = mysql_fetch_array($resultados, MYSQL_ASSOC))// entire query is passed by while to break it down
{
	$consulta[$i] = json_decode($ROW['json'],true);//the value of the field is a json Josn with the username and password is obtained.
	//Check username and password
	if($user == $consulta[$i]['user'])// compared if the user was obtained by post matches the user name that brings json.
	{
		if($pass == $consulta[$i]['pass'])
		{
			$datos['id'] = $ROW['id_usuario'];// save the user id in the array datos
			//echo($datos['id']);
			break;
		}
		else
		{// enters the else if the password is incorrect.
			die(json_encode($error['pass']));
			break;
		}
	}
	else
		if($pass == $consulta[$i]['pass'])
		{
			//wrong username
			die(json_encode($error['user']));
			break;
		}
		else
		{// if both are wrong.
			die(json_encode($error['two']));
		}
	$i++;
}

$result = generate_access_token(json_encode($user), $datos['id']);
/* are commanded to call the method of generating token passing as parameters the user name and the id obtained through query.*/
echo json_encode($result);// returned the access token generated by the method generate_access_token format json with json_encode.
$user1 = array();
function generate_access_token($str_user, $id_user){//function to generate the access token.
	//Get from database
	
	$user1[] = $str_user;
	$user1[] = $id_user;
	$user1[] = time() + 3600;
	$user1['hora'] = date("H:i:s", strtotime('+30 minutes'));// time expires the access token
	echo($user1['hora']);
	$user1[] = md5(implode('',$user1));// user encrypt the whole arrangement.
	return array('res' => implode('|', $user1));// fusing it back the array implode
}