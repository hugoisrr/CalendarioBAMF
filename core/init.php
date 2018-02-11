<?php
	session_start();
	// ini_set('error_reporting', E_ALL);
	error_reporting(0);
	require "core/database/connect.php";
	require "core/functions/general.php";
	require "core/functions/users.php";
	require "core/functions/queries.php";
	header('Content-Type: text/html; charset=ISO-8859-1');
	//si el usuario tiene activa su sesion toma sus datos guardados en la BD
	if (logged_in() === true) {
		$session_user_id = $_SESSION['correoElectronico'];
		$user_data = user_data($session_user_id, 'correoElectronico', 'idtipoUsuario', 'nombre', 'apellidoP', 'apellidoM', 'contrasena','foto','activo');
	}
	$errors = array();
?>