<?php
	// ob_start();
	include "core/init.php";

	$type = $_POST['type'];

	if($type == 'new')
	{
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		// $title = $_POST['title'];
		$email = $_POST['email'];
		$horas = $_POST['horas'];
		$idProyecto = $_POST['idProject'];
		$project_data = project_data($idProyecto, 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'idEtapa', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status');
		$idEtapa = $project_data['idEtapa'];
		insertNewEvent($idProyecto,$idEtapa,$email,$startdate,$enddate,$horas);
		$idEvento = id();
		$horasTrabajadas = horasTrabajadas($idProyecto);
		$horasTrabajadas = $horasTrabajadas + $horas;
		// calcular el costoXHoras del proyecto
		$tipo = tipoUsuario($email);
		if ($tipo === '3') {
			$costoXhora = costoHoraD($email);
			$costoTotal = costoTotal($idProyecto);
			$costoTotal = ($costoTotal + ($costoXhora * $horas));
		}elseif ($tipo === '5') {
			$costoXhora = costoHoraP($email);
			$costoTotal = costoTotal($idProyecto);
			$costoTotal = ($costoTotal + ($costoXhora * $horas));
		}
		// inserta las horas trabajadas y el costo total en cada Proyecto		
		insertHours($idProyecto,$horasTrabajadas);
		insertCostoTotal($idProyecto,$costoTotal);	
		/****************************************************************************************/
		/*SE DECIDIO QUITAR LA ALERTA DE EVENTO CREADO YA QUE ES MOLESTO, ADEM�S SATURA EL EMAIL*/
		/****************************************************************************************/
		// env�a un correo indicando la creaci�n del evento y la informaci�n del evento creado.
		/*
		$user_data = user_data($email, 'nombre', 'apellidoP', 'apellidoM');
		$message = "
					<table>
						<tr>
							<th><h2>Nuevo Evento en Kistu</h2></th>
							<th><img src='http://icdn.pro/images/fr/n/o/nomination-nouveaux-icone-8922-96.png' alt='NEW EVENT'/></th>
						</tr>
						<tr>
							<td colspan='2'>
								<p>Compa�ero/a ".$user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'].":</p><br>
								<p>Se ha agregado un nuevo evento a tu calendario en <a href='http://kistu.mx/index.php' target='_blank'>Kistu</a>.</p>
								<h4>Informaci�n del evento:</h4>
								<ul style='list-style-type:square'>		
								  <li><b>Proyecto:</b> <span style='color: #".$project_data['colorProyecto'].";'>".nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto'])."</span></li>
								  <li><b>Inicio: </b> ".$startdate."</li>
								  <li><b>Finaliza: </b> ".$enddate."</li>
								  <li><b>Duraci�n:</b> ".$horas." hrs.</li>
								</ul>
							</td>
						</tr>";
		send_mail($message,"Nuevo Evento en Kistu", $email);*/		
		echo json_encode(array('status'=>'success','eventid'=>$idEvento));
	}

	if ($type == 'projectInfo') 
	{
		$idProyecto = $_POST['idProject'];
		$project_data = project_data($idProyecto, 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status', 'fechaEntregado', 'horasTrabajadas', 'costoTotal');
		$projectName = nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto']); 
		$colorProject = $project_data['colorProyecto'];
		echo json_encode(array('status'=>'success','nombreProyecto'=>$projectName,'colorProyecto'=>$colorProject));
	}

	if($type == 'fetch')
	{
		$email = $_POST['email'];
		$events = array();
		$result = eventsCalendar($email);
		while($fetch = mysql_fetch_array($result))
		{
			$project_data = project_data($fetch['idProyecto'], 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto');
			$projectName = nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto']); 
			$e = array();
		    $e['id'] = $fetch['idEvento'];
		    $e['title'] = $projectName;
		    $e['backgroundColor'] = '#'.$project_data['colorProyecto'];
		    $e['start'] = $fetch['startdate'];
		    $e['end'] = $fetch['enddate'];
		    $e['description'] = 'projectDescr.php?var='.$fetch['idProyecto'];		  

		    $allday = ($fetch['allDay'] == "true") ? true : false;
		    $e['allDay'] = $allday;		    		    

		    array_push($events, $e);
		}
		echo json_encode($events);
	}

	if($type == 'resize')
	{
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		$eventid = $_POST['idevent'];
		$horas = $_POST['horas'];
		$event_data = event_data($eventid, 'idProyecto', 'correoElectronico', 'startdate', 'enddate', 'horas', 'allDay');
		$horasPasadas = $event_data['horas'];
		$update = modifyEventCalendar($startdate,$enddate,$eventid,$horas);
		// obtner idProyecto a partir del id del evento
		$idProyecto = $event_data['idProyecto'];
		// contar las horas de cada evento y acumularlas y actualizar el total
		$horasTrabajadas = 0;
		$result = hoursProject($idProyecto);
		while ($row = mysql_fetch_array($result)) {
			$horasTrabajadas = $horasTrabajadas + $row['horas'];
		}		
		// inserta las horas trabajadas en cada Poryecto
		insertHours($idProyecto,$horasTrabajadas);
		// Calculamos el costo del proyecto
		$email = $event_data['correoElectronico'];
		$tipo = tipoUsuario($email);
		if ($tipo === '3') {
			$costoXhora = costoHoraD($email);
			$costoEvento = ($costoXhora * $horasPasadas);
			$costoTotalP = (costoTotal($idProyecto) - $costoEvento);
			$costoEvento = ($costoXhora * $horas);
			$costoTotal = $costoTotalP + $costoEvento;
		}elseif ($tipo === '5') {
			$costoXhora = costoHoraP($email);
			$costoEvento = ($costoXhora * $horasPasadas);
			$costoTotalP = (costoTotal($idProyecto) - $costoEvento);
			$costoEvento = ($costoXhora * $horas);
			$costoTotal = $costoTotalP + $costoEvento;
		}
		// env�a un correo indicando la modificaci�n del evento y la informaci�n del evento.
		$user_data = user_data($email, 'nombre', 'apellidoP', 'apellidoM');
		$project_data = project_data($idProyecto, 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'idEtapa', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status');
		$message = "
					<table>
						<tr>
							<th><h2>Modificaci�n de Evento en Kistu</h2></th>
							<th><img src='http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-7/256/Calendar-icon.png' alt='RESIZE EVENT' width='96'/></th>
						</tr>
						<tr>
							<td colspan='2'>
								<p>Compa�ero/a ".$user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'].":</p><br>
								<p>Se ha modificado un evento en tu calendario en <a href='http://kistu.mx/index.php' target='_blank'>Kistu</a>.</p>
								<h4>Informaci�n del evento:</h4>
								<ul style='list-style-type:square'>		
								  <li><b>Proyecto:</b> <span style='color: #".$project_data['colorProyecto'].";'>".nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto'])."</span></li>
								  <li><b>Inicio: </b> ".$startdate."</li>
								  <li><b>Finaliza: </b> ".$enddate."</li>
								  <li><b>Duraci�n:</b> ".$horas." hrs.</li>
								</ul>
							</td>
						</tr>";
		send_mail($message,"Modificaci�n de Evento en Kistu", $email);
		// insertamos el costo Total del proyecto
		insertCostoTotal($idProyecto,$costoTotal);
		if($update)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	if ($type == 'move') {
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		$eventid = $_POST['idevent'];
		// Informaci�n del evento.
		$event_data = event_data($eventid, 'idProyecto', 'correoElectronico', 'startdate', 'enddate', 'horas', 'allDay');
		// env�a un correo indicando la modificaci�n del evento y la informaci�n del evento.
		$user_data = user_data($event_data['correoElectronico'], 'nombre', 'apellidoP', 'apellidoM');
		$project_data = project_data($event_data['idProyecto'], 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'idEtapa', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status');
		$message = "
					<table>
						<tr>
							<th><h2>Modificaci�n de Evento en Kistu</h2></th>
							<th><img src='http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-7/256/Calendar-icon.png' alt='RESIZE EVENT' width='96'/></th>
						</tr>
						<tr>
							<td colspan='2'>
								<p>Compa�ero/a ".$user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'].":</p><br>
								<p>Se ha modificado un evento en tu calendario en <a href='http://kistu.mx/index.php' target='_blank'>Kistu</a>.</p>
								<h4>Informaci�n del evento:</h4>
								<ul style='list-style-type:square'>		
								  <li><b>Proyecto:</b> <span style='color: #".$project_data['colorProyecto'].";'>".nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto'])."</span></li>
								  <li><b>Inicio: </b> ".$startdate."</li>
								  <li><b>Finaliza: </b> ".$enddate."</li>
								  <li><b>Duraci�n:</b> ".$event_data['horas']." hrs.</li>
								</ul>
							</td>
						</tr>";
		send_mail($message,"Modificaci�n de Evento en Kistu", $event_data['correoElectronico']);
		// Funci�n para actualizar el evento.
		$update = moveEventCalendar($startdate,$enddate,$eventid);
		if (!$update) {
			echo json_encode(array('status'=>'success'));
		}else{
			echo json_encode(array('status'=>'failed'));		
		}
	}

	if($type == 'remove')
	{
		$eventid = $_POST['eventid'];
		$event_data = event_data($eventid, 'idProyecto', 'correoElectronico', 'startdate', 'enddate', 'horas', 'allDay');
		$horasPasadas = $event_data['horas'];
		$email = $event_data['correoElectronico'];
		$idProyecto = $event_data['idProyecto'];
		$horasTrabajadas = horasTrabajadas($idProyecto);
		// env�a un correo indicando la eliminaci�n del evento y la informaci�n del evento.
		$user_data = user_data($email, 'nombre', 'apellidoP', 'apellidoM');
		$project_data = project_data($idProyecto, 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'idEtapa', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status');
		$message = "
					<table>
						<tr>
							<th><h2>Eliminaci�n de un Evento en Kistu</h2></th>
							<th><img src='https://cdn4.iconfinder.com/data/icons/pretty-office-part-4-simple-style/256/Remove-event.png' alt='DELETE EVENT' width='96'/></th>
						</tr>
						<tr>
							<td colspan='2'>
								<p>Compa�ero/a ".$user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'].":</p><br>
								<p>Se ha eliminado un evento en tu calendario en <a href='http://kistu.mx/index.php' target='_blank'>Kistu</a>.</p>
								<h4>Informaci�n del evento:</h4>
								<ul style='list-style-type:square'>		
								  <li><b>Proyecto:</b> <span style='color: #".$project_data['colorProyecto'].";'>".nombreCliente($project_data['nombreCliente'])."-".marcaCliente($project_data['marcaCliente'])."-".nombreProyecto($project_data['nombreProyecto'])."-".actividadProyecto($project_data['actividadProyecto'])."</span></li>
								  <li><b>Inicio: </b> ".$event_data['startdate']."</li>
								  <li><b>Finaliza: </b> ".$event_data['enddate']."</li>
								  <li><b>Duraci�n:</b> ".$horasPasadas." hrs.</li>
								</ul>
							</td>
						</tr>";
		send_mail($message,"Eliminaci�n de un Evento en Kistu", $email);
		// �liminaci�n del evento, adem�s se obtiene las horas del evento que fue eliminado.
		$horasEvento = deleteEvent($eventid);
		$horasTrabajadas = $horasTrabajadas - $horasEvento;
		// Calculamos nuevo costo Total del proyecto		
		$tipo = tipoUsuario($email);
		if ($tipo === '3') {
			$costoXhora = costoHoraD($email);
			$costoEvento = ($costoXhora * $horasPasadas);
			$costoTotal = (costoTotal($idProyecto) - $costoEvento);
		}elseif ($tipo === '5') {
			$costoXhora = costoHoraP($email);
			$costoEvento = ($costoXhora * $horasPasadas);
			$costoTotal = (costoTotal($idProyecto) - $costoEvento);
		}
		// inserta el nuevo total de horas trabajadas
		$delete = insertHours($idProyecto,$horasTrabajadas);		
		// insertamos el costo Total del proyecto
		insertCostoTotal($idProyecto,$costoTotal);
		// obtener las horas que fueron borradas de la tabla participantes y actualizar las horastrabajas en la tabla de proyecto
		if(!$delete)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}
	// ob_end_flush();
?>