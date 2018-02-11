<?php
/*******************************************/
/*    funcion para devolver todos los	   */
/*    tipos de proyectos      			   */
/*******************************************/
function typesPojects(){
	$typesPojects = "SELECT `idTipoProyecto`, 
						    `tipoProyecto` 
						    FROM `tipoproyecto`";
	$result = mysql_query($typesPojects);
	return ($result);
}
/*******************************************/
/*    funcion para devolver todos los	   */
/*    nombres de proyectos     			   */
/*******************************************/
function nameProjects(){
	$nameProjects = "SELECT `idNombreProyecto`, 
						    `nombreProyecto` 
						    FROM `nombreproyecto`";
	$result = mysql_query($nameProjects);
	return ($result);
}
/*******************************************/
/*    funcion para devolver todos los	   */
/*    nombres de clientes     			   */
/*******************************************/
function nameClients(){
	$nameClients = "SELECT `idNombreCliente`, 
						    `nombreCliente` 
						    FROM `nombrecliente`";
	$result = mysql_query($nameClients);
	return ($result);
}
/*******************************************/
/*    funcion para devolver todas las	   */
/*    marcas de clientes     			   */
/*******************************************/
function marcasClients(){
	$marcaClients = "SELECT `idMarcaCliente`, 
						    `marcaCliente` 
						    FROM `marcacliente`";
	$result = mysql_query($marcaClients);
	return ($result);
}
/*******************************************/
/*    funcion para devolver todas las	   */
/*    actividades de clientes     		   */
/*******************************************/
function activitiesClients(){
	$activitiesClients = "SELECT `idActividadProyecto`, 
						    `actividadProyecto` 
						    FROM `actividadproyecto`";
	$result = mysql_query($activitiesClients);
	return ($result);
}
/*******************************************/
/*    funcion para devolver todas las	   */
/*    etapas de un Proyecto     		   */
/*******************************************/
function projectStages(){
	$stages = "SELECT `idEtapa`, 
						    `etapa` 
						    FROM `etapa`";
	$result = mysql_query($stages);
	return ($result);
}
/*******************************************/
/*funcion para devolver todos los usuarios,*/
/*ya sean diseñadores o programadores  	   */
/* además que sean activos.*/
/*******************************************/
function usersBAMF(){
	$usersBAMF = "SELECT `correoElectronico`, 
						 `nombre`, 
						 `apellidoP`, 
						 `apellidoM` 
						 FROM `usuario` 
						 WHERE `activo` = 1 
						 AND `idtipoUsuario` = 3 
						 OR `idtipoUsuario` = 5";
	$result = mysql_query($usersBAMF);
	return ($result);
}
/*******************************************/
/*funcion para devolver todos los usuarios,*/
/*ya sean diseñadores o programadores  	   */
/* además que sean activos. Diseñadores    */
/* Célula coorporativo Toño, Laura         */
/*******************************************/
function usersBAMFCoorporativoD(){
	$usersBAMF = "SELECT DISTINCT `usuario`.`correoElectronico`, 
						 `usuario`.`nombre`, 
						 `usuario`.`apellidoP`, 
						 `usuario`.`apellidoM` 
						 FROM `usuario`, `disenador`
						 WHERE `disenador`.`status` = 1 
						 AND `disenador`.`celula` = 1
						 AND `usuario`.`correoElectronico` = `disenador`.`correoElectronico`
						 AND `usuario`.`idtipoUsuario` = 3";
	$result = mysql_query($usersBAMF);
	return ($result);
}
/*******************************************/
/*funcion para devolver todos los usuarios,*/
/*ya sean diseñadores o programadores  	   */
/* además que sean activos. Programadores  */
/* Célula coorporativo Toño, Laura         */
/*******************************************/
function usersBAMFCoorporativoP(){
	$usersBAMF = "SELECT DISTINCT `usuario`.`correoElectronico`, 
						 `usuario`.`nombre`, 
						 `usuario`.`apellidoP`, 
						 `usuario`.`apellidoM` 
						 FROM `usuario`, `programador`
						 WHERE `programador`.`status` = 1 
						 AND `programador`.`celula` = 1
						 AND `usuario`.`correoElectronico` = `programador`.`correoElectronico`
						 AND `usuario`.`idtipoUsuario` = 5";
	$result = mysql_query($usersBAMF);
	return ($result);
}
/*******************************************/
/*funcion para devolver todos los usuarios,*/
/*ya sean diseñadores o programadores  	   */
/* además que sean activos.                */
/* Célula consumo Pablo, Ana               */
/*******************************************/
function usersBAMFConsumoD(){
	$usersBAMF = "SELECT DISTINCT `usuario`.`correoElectronico`, 
						 `usuario`.`nombre`, 
						 `usuario`.`apellidoP`, 
						 `usuario`.`apellidoM` 
						 FROM `usuario`, `disenador`
						 WHERE `disenador`.`status` = 1 
						 AND `disenador`.`celula` = 0
						 AND `usuario`.`correoElectronico` = `disenador`.`correoElectronico`
						 AND `usuario`.`idtipoUsuario` = 3";
	$result = mysql_query($usersBAMF);
	return ($result);
}
/*******************************************/
/*funcion para devolver todos los usuarios,*/
/*ya sean diseñadores o programadores  	   */
/* además que sean activos. Programadores  */
/* Célula coorporativo Toño, Laura         */
/*******************************************/
function usersBAMFConsumoP(){
	$usersBAMF = "SELECT DISTINCT `usuario`.`correoElectronico`, 
						 `usuario`.`nombre`, 
						 `usuario`.`apellidoP`, 
						 `usuario`.`apellidoM` 
						 FROM `usuario`, `programador`
						 WHERE `programador`.`status` = 1 
						 AND `programador`.`celula` = 0
						 AND `usuario`.`correoElectronico` = `programador`.`correoElectronico`
						 AND `usuario`.`idtipoUsuario` = 5";
	$result = mysql_query($usersBAMF);
	return ($result);
}
/*******************************************/
/*Función para mostrar datos del usuario   */
/*******************************************/
function userData($email){
	$userData = "SELECT `nombre`, 
					    `apellidoP`, 
					    `apellidoM`, 
					    `foto` 
					    FROM `usuario` 
					    WHERE `correoElectronico` = '$email'";
	$result = mysql_query($userData);
	return ($result);
}
/*******************************************/
/*Función los miembros que han participado */
/*en un proyecto, por id del proyecto      */
/*******************************************/
function projectMembers($idProyecto){
	$members = "SELECT DISTINCT 
					  `correoElectronico` 
					  FROM `participantes` 
					  WHERE `idProyecto` = $idProyecto";
	$result = mysql_query($members);
	return ($result);
}
/*******************************************/
/*Función las etapas que ha pasado  */
/*un proyecto, por id del proyecto      */
/*******************************************/
function projectStagesEtapa($idProyecto){
	$stages = "SELECT DISTINCT `idEtapa` FROM `participantes` WHERE `idProyecto` = $idProyecto";
	$result = mysql_query($stages);
	return ($result);
}
/*******************************************/
/*Obtenemos el nombre del proyecto		   */
/*******************************************/
function nombreProyecto($idNombreProyecto){
	$nombreProyecto = "SELECT `nombreProyecto` 
					FROM `nombreproyecto` 
					WHERE `idNombreProyecto` = '$idNombreProyecto'";
	$result = mysql_fetch_array(mysql_query($nombreProyecto));

	$nombre = $result["nombreProyecto"];
	return ($nombre);
}
/*******************************************/
/*Obtenemos el color del diseñador		   */
/*******************************************/
function colorDisenador($correoElectronico){
	$color = "SELECT `color` 
					FROM `disenador` 
					WHERE `correoElectronico` = '$correoElectronico'";
	$result = mysql_fetch_array(mysql_query($color));

	$colorD = $result["color"];
	return ($colorD);
}
/*******************************************/
/*Obtenemos el color del programador		   */
/*******************************************/
function colorProgramador($correoElectronico){
	$color = "SELECT `color` 
					FROM `programador` 
					WHERE `correoElectronico` = '$correoElectronico'";
	$result = mysql_fetch_array(mysql_query($color));

	$colorP = $result["color"];
	return ($colorP);
}
/*******************************************/
/*Obtenemos el nombre del cliente		   */
/*******************************************/
function nombreCliente($idNombreCliente){
	$nombreCliente = "SELECT `nombreCliente` 
					FROM `nombrecliente` 
					WHERE `idNombreCliente` = '$idNombreCliente'";
	$result = mysql_fetch_array(mysql_query($nombreCliente));

	$nombre = $result["nombreCliente"];
	return ($nombre);
}
/*******************************************/
/*Obtenemos la marca del cliente		   */
/*******************************************/
function marcaCliente($idMarcaCliente){
	$marcaCliente = "SELECT `marcaCliente` 
					FROM `marcacliente` 
					WHERE `idMarcaCliente` = '$idMarcaCliente'";
	$result = mysql_fetch_array(mysql_query($marcaCliente));

	$nombre = $result["marcaCliente"];
	return ($nombre);
}
/*******************************************/
/*Obtenemos la actividad el proyecto	   */
/*******************************************/
function actividadProyecto($idactividadProyecto){
	$actividadProyecto = "SELECT `actividadProyecto` 
					FROM `actividadproyecto` 
					WHERE `idActividadProyecto` = '$idactividadProyecto'";
	$result = mysql_fetch_array(mysql_query($actividadProyecto));

	$marca = $result["actividadProyecto"];
	return ($marca);
}
/*******************************************/
/*Obtenemos el costoXhora del diseñador    */
/*******************************************/
function costoHoraD($email){
	$costoxhora = "SELECT `costoHora` FROM `disenador` WHERE `correoElectronico` = '$email' ";
	$result = mysql_fetch_array(mysql_query($costoxhora));

	$costo = $result["costoHora"];
	return ($costo);
}
/*******************************************/
/*Obtenemos el costoTotal del Proyecto    */
/*******************************************/
function costoTotal($idProyecto){
	$costoTotal = "SELECT `costoTotal` FROM `proyecto` WHERE `idProyecto` = $idProyecto";
	$result = mysql_fetch_array(mysql_query($costoTotal));

	$costo = $result["costoTotal"];
	return ($costo);
}
/*******************************************/
/*Obtenemos el costoXhora del programador  */
/*******************************************/
function costoHoraP($email){
	$costoxhora = "SELECT `costoHora` FROM `programador` WHERE `correoElectronico` = '$email' ";
	$result = mysql_fetch_array(mysql_query($costoxhora));

	$costo = $result["costoHora"];
	return ($costo);
}
/*******************************************/
/*Obtenemos el tipo de usuario del email   */
/*******************************************/
function tipoUsuario($email){
	$tipoUsuario = "SELECT `idtipoUsuario` FROM `usuario` WHERE `correoElectronico` = '$email'";
	$result = mysql_fetch_array(mysql_query($tipoUsuario));

	$tipo = $result["idtipoUsuario"];
	return ($tipo);
}
/*******************************************/
/*Obtenemos el tipo de Proyecto a partir del ID*/
/*******************************************/
function typeProject($idTipoProyecto){
	$typeProject = "SELECT `tipoProyecto` FROM `tipoproyecto` WHERE `idTipoProyecto`= $idTipoProyecto ";
	$result = mysql_fetch_array(mysql_query($typeProject));

	$id = $result["tipoProyecto"];
	return ($id);
}
/*******************************************/
/*Obtenemos la etapa del Proyecto a partir del ID*/
/*******************************************/
function stageProject($idEtapa){
	$stageProject = "SELECT `etapa` FROM `etapa` WHERE `idEtapa`= $idEtapa";
	$result = mysql_fetch_array(mysql_query($stageProject));

	$id = $result["etapa"];
	return ($id);
}
/*******************************************/
/*Obtenemos las horas trabajadas por  ID   */
/*  de Proyecto 				           */
/*******************************************/
function horasTrabajadas($idProyecto){
	$horas = "SELECT `horasTrabajadas` 
				FROM `proyecto` 
				WHERE `idProyecto` = $idProyecto";
	$result = mysql_fetch_array(mysql_query($horas));

	$query = $result["horasTrabajadas"];
	return ($query);
}
/*******************************************/
/*Fecha de creación del proyecto*/
/*******************************************/
function dateProject($idProyecto){
	$fecha = "SELECT DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`
					FROM `proyecto`
					WHERE `idProyecto` = '$idProyecto' ";
	$result = mysql_fetch_array(mysql_query($fecha));

	$query = $result["fechaProyecto"];
	return ($query);
}
/*******************************************/
/*Fecha de entrega del proyecto*/
/*******************************************/
function deliverProject($idProyecto){
	$fecha = "SELECT `fechaEntregado`
					FROM `proyecto`
					WHERE `idProyecto` = '$idProyecto' ";
	$result = mysql_fetch_array(mysql_query($fecha));

	$query = $result["fechaEntregado"];
	return ($query);
}
/*******************************************/
/*Función para mostrar info del proyecto   */
/*por célula							   */
/*******************************************/
function proyectoCelula($celula){
	$infoProyecto = "SELECT `idProyecto`, 
							`nombreProyecto`, 
							`actividadProyecto`,
							`nombreCliente`,
							`marcaCliente`,
							`colorProyecto` 
							FROM `proyecto` 
							WHERE `celula`= $celula 
							AND `status` = 1";
	$result = mysql_query($infoProyecto);
	return ($result);
}
/*******************************************/
/*Función para mostrar las horas de un Proyecto */
/*******************************************/
function hoursProject($idProyecto){
	$hours = "SELECT `horas` 
				FROM `participantes` 
				WHERE `idProyecto` = $idProyecto";
	$result = mysql_query($hours);
	return ($result);
}
/*******************************************/
/*Función para mostrar las horas           */
/*y correo Electrónico de un Evento        */
/*******************************************/
function hoursCostProject($idProyecto){
	$cost = "SELECT `horas`,`correoElectronico` FROM `participantes` WHERE `idProyecto` = $idProyecto";
	$result = mysql_query($cost);
	return ($result);
}
/*******************************************/
/*Función para mostrar las horas           */
/*trabajadas por trabajador y proyecto     */
/*******************************************/
function hoursWorkerProject($idProyecto, $correoElectronico){
	$hours = "SELECT `horas` FROM `participantes` WHERE `idProyecto` = $idProyecto AND `correoElectronico` = '$correoElectronico'";
	$result = mysql_query($hours);
	return ($result);
}
/*******************************************/
/*Función para mostrar las horas           */
/*trabajadas por etapa y proyecto          */
/*******************************************/
function hoursStageProject($idProyecto, $idEtapa){
	$hours = "SELECT `horas` FROM `participantes` WHERE `idProyecto` = $idProyecto AND `idEtapa` = $idEtapa";
	$result = mysql_query($hours);
	return ($result);
}
/*******************************************/
/*funcion para devolver los usuarios,      */
/*diseñadores de una determinada célula    */
/*muestra el status                        */
/*******************************************/
function usersDiseno($celula){
	$usersDiseno = "SELECT `disenador`.`tipoDisenador`,
						   `disenador`.`idDisenador`,
						   `disenador`.`color`,
						   `usuario`.`foto`,
						   `usuario`.`correoElectronico`,  
						   `usuario`.`nombre`, 
						   `usuario`.`apellidoP`, 
						   `usuario`.`apellidoM`, 	 
						   DATE_FORMAT(`disenador`.`fechaIngreso`,'%d %b %y') AS `fechaIngreso`,
						   `disenador`.`celula`,
						   `disenador`.`status`, 
						   `disenador`.`costoHora` 
						   FROM `usuario`,`disenador` 
						   WHERE `usuario`.`idtipoUsuario` = 3 
						   AND `disenador`.`celula` = $celula 
						   AND `disenador`.`correoElectronico` = `usuario`.`correoElectronico`";
	$result = mysql_query($usersDiseno);
	return ($result);
}
/*******************************************/
/*funcion para obtener los eventos en el   */
/*calendario de cada integrante.           */
/*******************************************/
function eventsCalendar($email){
	$events = "SELECT `participantes`.`idEvento`, 
					  `participantes`.`idProyecto`, 
					  `participantes`.`startdate`, 
					  `participantes`.`enddate`, 
					  `participantes`.`allDay`
					  FROM `participantes`, `proyecto` 
					  WHERE `proyecto`.`idProyecto` = `participantes`.`idProyecto` 
					  AND `participantes`.`correoElectronico` = '$email'";
	$result = mysql_query($events);
	return ($result);
}
/*******************************************/
/*funcion para obtener los eventos en el   */
/*calendario de cada Célula                */
/*******************************************/
function eventsCalendarCelula($celula){
	$events = "SELECT `participantes`.`idEvento`
					  FROM `participantes`, `proyecto` 
					  WHERE `proyecto`.`idProyecto` = `participantes`.`idProyecto` 
					  AND `proyecto`.`celula` = $celula
					  AND `proyecto`.`status` = 1";
	$result = mysql_query($events);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*proyectos activos 					   */
/*******************************************/
function listProjects(){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` 
						WHERE `status` = 1";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*proyectos NO activos 					   */
/*******************************************/
function listProjectsNOactivos(){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` 
						WHERE `status` = 0";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*proyectos suspendidos 				   */
/*******************************************/
function listProjectsSuspendidos(){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` 
						WHERE `status` = 2";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*proyectos entregados   				   */
/*******************************************/
function listProjectsEntregados(){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` 
						WHERE `status` = 3";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*todos los proyectos 					   */
/*******************************************/
function listProjectsTotales(){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` ";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar la lista de         */
/*todos los proyectos por Cliente		   */
/*******************************************/
function listProjectsClient($idCliente){
	$projects = "SELECT `idProyecto`, 
						`nombreProyecto`,
						`actividadProyecto`, 
						`tipoProyecto`, 
						`colorProyecto`, 
						`nombreCliente`, 
						`marcaCliente`,
						`descripcion`,
						DATE_FORMAT(`fechaProyecto`,'%d %b %y') AS `fechaProyecto`, 
						`idEtapa`,
						`celula`, `liderProyecto`, 
						`status`,
						`fechaEntregado`, 
						`horasTrabajadas`, 
						`costoTotal` 
						FROM `proyecto` 
						WHERE `nombreCliente` = $idCliente";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para mostrar los eventos a partir*/
/*del ID de un Proyecto, esta función será */
/*utilizada para generar la información de */
/*la gráfica de Morris.					   */
/*******************************************/
function eventsPerProjects($idProyecto){
	$events = "SELECT * FROM `participantes` 
					WHERE `idProyecto` = $idProyecto 
					AND YEAR(`startdate`) = YEAR(NOW()) 
					AND MONTH(`startdate`) >= 1 
					AND MONTH(`startdate`) <= MONTH(NOW()) 
					ORDER BY `startdate` ASC";
	$result = mysql_query($events);
	return ($result);
}
/*******************************************/
/*    funcion para obtener los datos de    */
/*                 un proyecto              */
/*******************************************/
//datos de proyecto
function project_data($id_project){
	$data = array();
	$id_project;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if ($func_num_args > 1){
		unset($func_get_args[0]);
		$fields = '`' . implode('`,  `', $func_get_args) . '`';
		$data =mysql_fetch_assoc(mysql_query("SELECT $fields FROM `proyecto` WHERE `idProyecto` = $id_project"));
		return $data;
	}
}
/*******************************************/
/*    funcion para obtener los datos de    */
/*                 un evento               */
/*******************************************/
//datos de un evento
function event_data($id_event){
	$data = array();
	$id_event;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if ($func_num_args > 1){
		unset($func_get_args[0]);
		$fields = '`' . implode('`,  `', $func_get_args) . '`';
		$data =mysql_fetch_assoc(mysql_query("SELECT $fields FROM `participantes` WHERE `idEvento` = $id_event"));
		return $data;
	}
}
/*******************************************/
/*funcion para obtener los proyectos por   */
/*miembro de cada Célula                   */
/*******************************************/
function projectsMember($email){
	$projects = "SELECT DISTINCT `proyecto`.`idProyecto`,
								 `proyecto`.`nombreProyecto`,
								 `proyecto`.`colorProyecto` 
								 FROM `proyecto`,`participantes` 
								 WHERE `proyecto`.`status` = 1 
								 AND `participantes`.`correoElectronico` = '$email' 
								 AND `participantes`.`idProyecto` = `proyecto`.`idProyecto`";
	$result = mysql_query($projects);
	return ($result);
}
/*******************************************/
/*funcion para devolver los usuarios,      */
/*programadores de una determinada célula  */
/*muestra el status                        */
/*******************************************/
function usersProgramador($celula){
	$usersProgramador = "SELECT `programador`.`tipoProgramador`,
								`programador`.`idProgramador`,
								`programador`.`color`,
							    `usuario`.`foto`,
							    `usuario`.`correoElectronico`,  
							    `usuario`.`nombre`, 
							    `usuario`.`apellidoP`, 
							    `usuario`.`apellidoM`, 		
							    DATE_FORMAT(`programador`.`fechaIngreso`,'%d %b %y') AS `fechaIngreso`,
							    `programador`.`celula`,
							    `programador`.`status`, 
							    `programador`.`costoHora` 
							    FROM `usuario`,`programador` 
							    WHERE `usuario`.`idtipoUsuario` = 5 
							    AND `programador`.`celula` = $celula 
							    AND `programador`.`correoElectronico` = `usuario`.`correoElectronico`";
	$result = mysql_query($usersProgramador);
	return ($result);
}
/*******************************************/
/*Inserta nuevo envento en Participantes   */
/*******************************************/
function insertNewEvent($idProyecto,$idEtapa,$email,$startdate,$enddate,$horas){
	$query = "INSERT INTO participantes(`idProyecto`,
	 									`idEtapa`,
										`correoElectronico`,
										`startdate`,
										`enddate`,
										`horas`,
										`allDay`) 
						VALUES($idProyecto,
							   $idEtapa,
							  '$email',
							  '$startdate',
							  '$enddate',
							  $horas,
							  'false')";
	mysql_query($query);
}
/*******************************************/
/*actualiza información del diseñador      */
/*******************************************/
function modifyUserDiseno($idDisenador,$celula,$status,$costoxhora,$puesto){	
	$query = "UPDATE `disenador` SET 
					 `celula` = '".sanitize($celula)."',
					 `status` = '".sanitize($status)."',
					 `costoHora` = '".sanitize($costoxhora)."',
					 `tipoDisenador` = '".sanitize($puesto)."' 
					 WHERE `idDisenador` = $idDisenador";
	mysql_query($query);
}
/*******************************************/
/*actualiza información del programador    */
/*******************************************/
function modifyUserProgra($idProgramador,$celula,$status,$costoxhora,$puesto){	
	$query = "UPDATE `programador` SET 
					 `celula` = '".sanitize($celula)."',
					 `status` = '".sanitize($status)."',
					 `costoHora` = '".sanitize($costoxhora)."',
					 `tipoProgramador` = '".sanitize($puesto)."' 
					 WHERE `idProgramador` = $idProgramador";
	mysql_query($query);
}
/*******************************************/
/*actualiza un evento en la tabla de       */
/*Participantes                            */
/*******************************************/
function modifyEventCalendar($startdate,$enddate,$idEvento,$horas){
	$query = "UPDATE `participantes` SET 
				     `startdate` = '$startdate', 
				     `enddate` = '$enddate',
				     `horas` = $horas
				     WHERE `idEvento` = $idEvento";
	mysql_query($query);
}
/*******************************************/
/*actualiza un evento que ha sido movido en*/
/*el calendario                            */
/*******************************************/
function moveEventCalendar($startdate,$enddate,$idEvento){
	$query = "UPDATE `participantes` SET 
				     `startdate` = '$startdate', 
				     `enddate` = '$enddate'
				     WHERE `idEvento` = $idEvento";
	mysql_query($query);
}
/*******************************************/
/*actualiza un evento en la tabla de       */
/*Participantes, inserta hora final        */
/*Formato: Wed Jul 22 2015 21:00:00 GMT-0500+*/
/*******************************************/
function modifyEventFinalHour($enddate,$idEvento){
	$query = "UPDATE `participantes` SET 
					 `enddate` = '$enddate' 
					 WHERE `idEvento` = $idEvento";
	mysql_query($query);					 
}
/*******************************************/
/*actualiza la información de un Proyecto  */
/*******************************************/
function modifyProjectInfo($idProyecto,$proyecto,$idActividad,$tipoProyecto,$celula,$liderProyecto,$etapa,$status,$fechaEntregado,$descripcion){
	$query = "UPDATE `proyecto` SET 
					 `nombreProyecto` = '".sanitize($proyecto)."', 
					 `actividadProyecto` = '".sanitize($idActividad)."',
					 `tipoProyecto` = '".sanitize($tipoProyecto)."',
					 `descripcion` = '".sanitize($descripcion)."',
					 `celula` = '".sanitize($celula)."',
					 `idEtapa` = '".sanitize($etapa)."', 
					 `liderProyecto` = '".sanitize($liderProyecto)."', 
					 `status` = '".sanitize($status)."',
					 `fechaEntregado` = '".$fechaEntregado."'
					 WHERE `idProyecto` = $idProyecto";
	mysql_query($query);
}
/*******************************************/
/*Inserta las horas trabajadas en el proyecto*/
/*******************************************/
function insertHours($idProyecto,$hours){
	$query = "UPDATE `proyecto` 
				SET `horasTrabajadas` = '$hours' 
				WHERE `idProyecto` = $idProyecto ";
	mysql_query($query);
}
/*******************************************/
/*Inserta costo total del proyecto proyecto*/
/*******************************************/
function insertCostoTotal($idProyecto,$costoTotal){
	$query = "UPDATE `proyecto` 
				SET `costoTotal` = '$costoTotal' 
				WHERE `idProyecto` = $idProyecto ";
	mysql_query($query);
}
/*******************************************/
/*Elimina un evento del calendario         */
/*******************************************/
function deleteEvent($idEvento){
	$horas = "SELECT `horas` FROM `participantes` WHERE `idEvento` = $idEvento";
	$result = mysql_fetch_array(mysql_query($horas));

	$query = $result["horas"];
	$query2 = "DELETE FROM `participantes` WHERE `idEvento`= $idEvento";
	mysql_query($query2);					 
	return($query);
}
/*******************************************/
/*Elimina cliente de la tabla nombrecliente*/
/*******************************************/
function deleteCliente($idCliente){
	$query = "DELETE FROM `nombrecliente` WHERE `nombrecliente`.`idNombreCliente` = $idCliente";
	mysql_query($query);	
}
/*******************************************/
/*Elimina marca de la tabla marcacliente*/
/*******************************************/
function deleteMarca($idMarca){
	$query = "DELETE FROM `marcacliente` WHERE `marcacliente`.`idMarcaCliente` = $idMarca";
	mysql_query($query);	
}
/*******************************************/
/*Elimina nombre de proyecto de la tabla nombreproyecto*/
/*******************************************/
function deleteProject($idNombreProyecto){
	$query = "DELETE FROM `nombreproyecto` WHERE `nombreproyecto`.`idNombreProyecto` = $idNombreProyecto";
	mysql_query($query);	
}
/*******************************************/
/*Elimina actividad de la tabla actividadproyecto*/
/*******************************************/
function deleteActivity($idActivity){
	$query = "DELETE FROM `actividadproyecto` WHERE `actividadproyecto`.`idActividadProyecto` = $idActivity";
	mysql_query($query);	
}
/*******************************************/
/*Elimina categoía de la tabla tipoproyecto*/
/*******************************************/
function deleteCategory($idCategory){
	$query = "DELETE FROM `tipoproyecto` WHERE `tipoproyecto`.`idTipoProyecto` = $idCategory";
	mysql_query($query);	
}
/*******************************************/
/*Consulta la lista de clientes que NO esten*/
/*ligados a un Poryecto                    */
/*******************************************/
function clientsListNOTINproyect(){
	$clientsList = "SELECT DISTINCT `idNombreCliente`, `nombreCliente` FROM `nombrecliente` WHERE `idNombreCliente` NOT IN (SELECT `nombreCliente` FROM `proyecto`) ORDER BY `nombrecliente`.`idNombreCliente` DESC";
	$result = mysql_query($clientsList);
	return ($result);
}
/*******************************************/
/*Consulta la lista de marcas que NO esten */
/*ligados a un Poryecto                    */
/*******************************************/
function marcasListNOTINproyect(){
	$marcasList = "SELECT DISTINCT `idMarcaCliente`, `marcaCliente` FROM `marcacliente` WHERE `idMarcaCliente` NOT IN (SELECT `marcaCliente` FROM `proyecto`) ORDER BY `marcacliente`.`idMarcaCliente` DESC";
	$result = mysql_query($marcasList);
	return ($result);
}
/*******************************************/
/*Consulta la lista de proyectos que NO esten*/
/*ligados a un Poryecto                    */
/*******************************************/
function projectsListNOTINproyect(){
	$projectsList = "SELECT DISTINCT `idNombreProyecto`, `nombreProyecto` FROM `nombreproyecto` WHERE `idNombreProyecto` NOT IN (SELECT `nombreProyecto` FROM `proyecto`) ORDER BY `nombreproyecto`.`idNombreProyecto` DESC";
	$result = mysql_query($projectsList);
	return ($result);
}
/*******************************************/
/*Consulta la lista de actividades que NO esten*/
/*ligados a un Proyecto                    */
/*******************************************/
function activitiesListNOTINproyect(){
	$activitiesList = "SELECT DISTINCT `idActividadProyecto`, `actividadProyecto` FROM `actividadproyecto` WHERE `idActividadProyecto` NOT IN (SELECT `actividadProyecto` FROM `proyecto`) ORDER BY `actividadproyecto`.`idActividadProyecto` DESC";
	$result = mysql_query($activitiesList);
	return ($result);
}
/*******************************************/
/*Consulta la lista de categorias que NO esten*/
/*ligados a un Proyecto                    */
/*******************************************/
function categoriesListNOTINproyect(){
	$categoryList = "SELECT DISTINCT `idTipoProyecto`, `tipoProyecto` FROM `tipoproyecto` WHERE `idTipoProyecto` NOT IN (SELECT `tipoProyecto` FROM `proyecto`) ORDER BY `tipoproyecto`.`idTipoProyecto` DESC";
	$result = mysql_query($categoryList);
	return ($result);
}
?>