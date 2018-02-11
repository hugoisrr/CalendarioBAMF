<?php
	include "core/init.php";	

	// variable POST nombre del cliente
	$cliente = $_POST['cliente'];

	// registro del nuevo cliente
	if ($cliente != NULL) {
		$register_data = array(
			'nombreCliente' => $cliente
		);

		register($register_data, "nombrecliente");
	}

	// variable POST eliminar cliente
	$clienteEli = $_POST['clienteEliminar'];

	// eliminar cliente
	if ($clienteEli != NULL) {
		deleteCliente($clienteEli);
	}

	// variable POST marca
	$marca = $_POST['marca'];

	// registro del nuevo marca
	if ($marca != NULL) {
		$register_data = array(
			'marcaCliente' => $marca
		);

		register($register_data, "marcacliente");
	}

	// variable POST eliminar marca
	$marcaEli = $_POST['marcaEliminar'];

	// eliminar marca
	if ($marcaEli != NULL) {
		deleteMarca($marcaEli);
	}

	// variable POST proyecto
	$proyectoCal = $_POST['proyectoCal'];

	// registro del nuevo proyecto
	if ($proyectoCal != NULL) {
		$register_data = array(
			'nombreProyecto' => $proyectoCal
		);

		register($register_data, "nombreproyecto");
	}

	// variable POST eliminar proyecto
	$proyectoEli = $_POST['proyectoEliminar'];

	// eliminar proyecto
	if ($proyectoEli != NULL) {
		deleteProject($proyectoEli);
	}

	// variable POST actividad
	$actividad = $_POST['actividad'];

	// registro de actividad
	if ($actividad != NULL) {
		$register_data = array(
			'actividadProyecto' => $actividad
		);

		register($register_data, "actividadproyecto");
	}

	// variable POST eliminar actividad
	$actividadEli = $_POST['actividadEliminar'];

	// eliminar actividad
	if ($actividadEli != NULL) {
		deleteActivity($actividadEli);
	}

	// variables POST enviadas por Ajax
	$tipo = utf8_decode($_POST['tipo']);

	// registro de tipo de Proyecto
	if ($tipo != NULL) {
		$register_data = array(
			'tipoProyecto' => $tipo
		);

		register($register_data, "tipoproyecto");
	}

	// variable POST eliminar categoría
	$categoryEli = $_POST['categoriaEliminar'];

	// eliminar actividad
	if ($categoryEli != NULL) {
		deleteCategory($categoryEli);
	}

	// variable updateClient in select
	$updateClient  = $_POST['newClient'];
	if ($updateClient === "true") {
		$result = nameClients();
        while ($row = mysql_fetch_array($result)) {
        	echo "<option value=".$row['idNombreCliente'].">".$row['nombreCliente']."</option>";
        }
	}

	// variable updateEliClient in select
	$updateEliClient = $_POST['elimClient'];
	if ($updateEliClient === "true") {
		$result = clientsListNOTINproyect();
		while ($row = mysql_fetch_array($result)) {
			echo "<option value=".$row['idNombreCliente'].">".$row['nombreCliente']."</option>";
		}
	}

	// variable updateMarca in select
	$updateMarca  = $_POST['newMarca'];
	if ($updateMarca === "true") {
		$result = marcasClients();
        while ($row = mysql_fetch_array($result)) {
        	echo "<option value=".$row['idMarcaCliente'].">".$row['marcaCliente']."</option>";
        }
	}

	// variable updateEliMarca in select
	$updateEliMarca = $_POST['elimMarca'];
	if ($updateEliMarca === "true") {
		$result = marcasListNOTINproyect();
		while ($row = mysql_fetch_array($result)) {
			echo "<option value=".$row['idMarcaCliente'].">".$row['marcaCliente']."</option>";
		}
	}

	// variable updateProject in select
	$updateProject  = $_POST['newProject'];
	if ($updateProject === "true") {
		$result = nameProjects();
        while ($row = mysql_fetch_array($result)) {
        	echo "<option value=".$row['idNombreProyecto'].">".$row['nombreProyecto']."</option>";
        }
	}

	// variable updateEliProjecto in select
	$updateEliProjecto = $_POST['elimProject'];
	if ($updateEliProjecto === "true") {
		$result = projectsListNOTINproyect();
		while ($row = mysql_fetch_array($result)) {
			echo "<option value=".$row['idNombreProyecto'].">".$row['nombreProyecto']."</option>";
		}
	}

	// variable updateActivity in select
	$updateActivity  = $_POST['newActivity'];
	if ($updateActivity === "true") {
		$result = activitiesClients();
        while ($row = mysql_fetch_array($result)) {
        	echo "<option value=".$row['idActividadProyecto'].">".$row['actividadProyecto']."</option>";
        }
	}

	// variable updateEliActivity in select
	$updateEliActivity = $_POST['elimActivity'];
	if ($updateEliActivity === "true") {
		$result = activitiesListNOTINproyect();
		while ($row = mysql_fetch_array($result)) {
			echo "<option value=".$row['idActividadProyecto'].">".$row['actividadProyecto']."</option>";
		}
	}

	// variable updateCategory in select
	$updateCategory  = $_POST['newCategory'];
	if ($updateCategory === "true") {
		$result = typesPojects();
        while ($row = mysql_fetch_array($result)) {
        	echo "<option value=".$row['idTipoProyecto'].">".$row['tipoProyecto']."</option>";
        }
	}

	// variable updateEliCategory in select
	$updateEliCategory = $_POST['elimCategory'];
	if ($updateEliCategory === "true") {
		$result = categoriesListNOTINproyect();
		while ($row = mysql_fetch_array($result)) {
			echo "<option value=".$row['idTipoProyecto'].">".$row['tipoProyecto']."</option>";
		}
	}
?>