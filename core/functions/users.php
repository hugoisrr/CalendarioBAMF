<?php
/*******************************************/
/*   funcion para cambiar la contrasena    */
/*******************************************/
function change_password($id,$password){
	$password = md5($password);
	mysql_query("UPDATE `usuario` SET `contrasena` = '$password' WHERE `correoElectronico`= '$id'");
}
/*******************************************/
/*    funcion para ver si existe el correo */
/*           en la base de datos           */
/*******************************************/
function email_exists($email){
	$email = sanitize($email);
	return (mysql_result(mysql_query("SELECT COUNT(`correoElectronico`) FROM `usuario` WHERE `correoElectronico` = '$email'"), 0) == 1) ? true : false;
}
/*******************************************/
/*    funcion para saber el id de un dato  */
/*                insertado                */
/*******************************************/
function id(){
	return (mysql_insert_id());
}
/*******************************************/
/*      funcion para ver si los datos      */
/*    enviados en el index son validos     */
/*******************************************/
function login($username, $password){
	$username = sanitize($username);
	$password = md5 ($password);
	return(mysql_result(mysql_query("SELECT COUNT(`correoElectronico`) FROM `usuario` WHERE `correoelectronico` = '$username' AND `contrasena` = '$password'"), 0) == 1)? $username : false;
}
/********************************************/
/*      funcion para ver si un usuario      */
/*          tiene activa su sesion          */
/********************************************/
function logged_in(){
	return (isset($_SESSION['correoElectronico'])) ? true : false;
}
/********************************************/
/*      funcion para modificar los datos    */
/*      			del usuario             */
/********************************************/
function modify_data($id,$name,$ap,$am,$foto){
	$n = sanitize($name);
	$p = sanitize($ap);
	$m = sanitize($am);
	$f = sanitize($foto);
	$name="UPDATE usuario SET 
		nombre = '".$n."',
		apellidoP = '".$p."',
		apellidoM = '".$m."',		
		foto = '".$f."'		
		WHERE correoElectronico ='".$id."'";	
	mysql_query($name);
}
/********************************************/
/*    funcion para registrar un dato        */
/********************************************/
function register($register,$table){
	//recorre todo el arreglo para limpiar  de caracteres raros
	array_walk($register, 'array_sanitize');
	// une todos los nombres del arreglo $register
	$fields = '`'.implode('`, `', array_keys($register)).'`';
	// une todos los valores del arreglo $register
	$data = '\''.implode('\', \'', $register).'\'';
	mysql_query("INSERT INTO `".$table."` ($fields) VALUES ($data)");
}
/********************************************/
/*funcion para mostrar el status del        */
/*usuario Activo o No Activo 		        */
/********************************************/
function selectStatusActivo($email){
	$status = "SELECT `activo` 
					FROM `usuario` 
					WHERE `correoElectronico`= '$email'";
	$result = mysql_fetch_array(mysql_query($status));
	$valor = $result["activo"];
	return ($valor);	
}
/*******************************************/
/*    funcion para guardar los datos de    */
/*                 un usuario              */
/*******************************************/
//datos de usuario
function user_data($id_usuario){
	$data = array();
	$id_usuario;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if ($func_num_args > 1){
		unset($func_get_args[0]);
		$fields = '`' . implode('`,  `', $func_get_args) . '`';
		$data =mysql_fetch_assoc(mysql_query("SELECT $fields FROM `usuario` WHERE `correoElectronico` = '$id_usuario'"));
		return $data;
	}
}
/********************************************/
/* funcion para seleccionar tipo de usuario */
/********************************************/
function user_type(){
	global $user_data;
	//echo $user_data['idtipoUsuario'];
	header('Location: index.php');
	if($user_data['idtipoUsuario']==1){
		header ('location: bienvenida.php');
		exit();
	}
	else if($user_data['idtipoUsuario']==2){
		header ('location: bienvenida.php');
		exit();
	}
	else if($user_data['idtipoUsuario']==3){
		header ('location: bienvenida.php');
		exit();
	}
	else if($user_data['idtipoUsuario']==5){
		header ('location: bienvenida.php');
		exit();
	}
}
?>