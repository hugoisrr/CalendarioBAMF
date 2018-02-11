<?php
	/* Seleccion de base de datos */
	require("core/database/configBD.php");
	error_reporting(0);
	$connect_error = 'Error de conexión\n';
	/* Conexion */
	$enlace = mysql_connect("$host", "$usuario", "$contra")	or die($connect_error.mysql_error() );
	mysql_select_db("$base") or die($connect_error."No pudo seleccionarse la BD.\n".mysql_error() );
?>