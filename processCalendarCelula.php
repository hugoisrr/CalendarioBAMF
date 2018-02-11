<?php
	include "core/init.php";

	$type = $_POST['type'];

	if($type == 'fetch')
	{
		$celula = $_POST['celula'];
        $events = array();
        $result = eventsCalendarCelula($celula);
        while ($row = mysql_fetch_array($result)) {
          $e = array();
          $e['id'] = $row['idEvento'];
          $event_data = event_data($row['idEvento'], 'idProyecto', 'correoElectronico', 'startdate', 'enddate', 'horas', 'allDay');          
          $user_data = user_data($event_data['correoElectronico'], 'correoElectronico', 'idtipoUsuario', 'nombre', 'apellidoP', 'apellidoM');
          $project_data = project_data($event_data['idProyecto'], 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto');
		  $projectName = nombreCliente($project_data['nombreCliente']).'-'.marcaCliente($project_data['marcaCliente']).'-'.nombreProyecto($project_data['nombreProyecto']).'-'.actividadProyecto($project_data['actividadProyecto']);
          $e['title'] = $user_data['nombre'].' '.$user_data['apellidoP'].'   ||   '.$projectName;
          if (tipoUsuario($event_data['correoElectronico']) == 3) {
            $e['backgroundColor'] = '#'.colorDisenador($event_data['correoElectronico']);
          }elseif (tipoUsuario($event_data['correoElectronico']) == 5) {
            $e['backgroundColor'] = '#'.colorProgramador($event_data['correoElectronico']);
          }
          $e['start'] = $event_data['startdate'];
          $e['end'] = $event_data['enddate'];
          $e['description'] = 'projectDescr.php?var='.$event_data['idProyecto'];     

          $allday = ($row['allDay'] == "true") ? true : false;
          $e['allDay'] = $allday;               

          array_push($events, $e);
        }
        echo json_encode($events);
	}

	if ($type == 'move') {
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		$eventid = $_POST['idevent'];
		$update = moveEventCalendar($startdate,$enddate,$eventid);
		if (!$update) {
			echo json_encode(array('status'=>'success'));
		}else{
			echo json_encode(array('status'=>'failed'));		
		}
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
		// insertamos el costo Total del proyecto
		insertCostoTotal($idProyecto,$costoTotal);
		if($update)
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}
?>