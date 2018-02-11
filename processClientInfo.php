<?php
	// ob_start();
	include "core/init.php";

	$type = $_POST['type'];

	if ($type == 'proyects') {
		$idNombreCliente = $_POST['idNombreCliente'];
		$result = listProjectsClient($idNombreCliente);
		while ($row = mysql_fetch_array($result)) {
			echo '
			<tr>
				<td><a href="projectDescr.php?var='.$row['idProyecto'].'" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #'.$row['colorProyecto'].';">'.nombreCliente($row['nombreCliente']).'-'.marcaCliente($row['marcaCliente']).'-'.nombreProyecto($row['nombreProyecto']).'</button></a>
				</td>
				<td>
					<button class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editar'.$row['idProyecto'].'"><i class="fa fa-pencil"></i></button>
				</td>
				<td>'.typeProject($row['tipoProyecto']).'</td>
				<td>'.nombreCliente($row['nombreCliente']).'</td>
				<td>'.$row['fechaProyecto'].'</td>
				<td>';
				if ($row['idEtapa'] === '1') {
			        echo "<span class='label label-info label-mini'>".stageProject($row['idEtapa'])."</span>";      
			      }elseif ($row['idEtapa'] === '2') {
			        echo "<span class='label label-warning label-mini'>".stageProject($row['idEtapa'])."</span>";      
			      }elseif ($row['idEtapa'] === '3') {
			        echo "<span class='label label-success label-mini'>".stageProject($row['idEtapa'])."</span>";      
			      }
			echo '
				</td>
				<td>';
				if ($row['celula'] === '0') {
					echo "Consumo";
				}elseif ($row['celula'] === '1') {
					echo "Corporativo";
				}
			echo '
				</td>
				<td>
					<a href="mailto:'.$row['liderProyecto'].'">';
					$result2 = userData($row['liderProyecto']); 
			    	while ($row2 = mysql_fetch_array($result2)) {
			      	echo $row2['nombre'].' '.$row2['apellidoP'].' '.$row2['apellidoM'];
			    	}
			    	echo '
			  		</a>
			  	</td>
			  	<td>';
			  	if ($row['status'] === '0') {
			        echo "<span class='label label-warning label-mini'>No activo</span>";
			      }
			      elseif ($row['status'] === '1') {
			        echo "<span class='label label-info label-mini'>Activo</span>";
			      }
			      elseif ($row['status'] === '2') {
			        echo "<span class='label label-danger label-mini'>Suspendido</span>";
			      }
			      elseif ($row['status'] === '3') {
			        echo "<span class='label label-success label-mini'>Entregado</span>";
			      }
			echo '
				</td>
				<td>';
				if ($row['fechaEntregado'] === NULL) {
			        echo "--";
			      }else{
			        echo $row['fechaEntregado'];
			      }
			echo '
				</td>
				<td>'
					.$row['horasTrabajadas'].' hrs.
				</td>';
				if ($user_data['idtipoUsuario'] === "2") {
					echo '<td>';
							if ($row['costoTotal'] === NULL) {
				        echo "--";
				      }else{
				        echo '$'.number_format($row['costoTotal'],2);
				      }
				     echo '</td>';
				}
			echo '
			</tr>';
		}
	}

	if ($type == 'selectProjects') {
		$idNombreCliente = $_POST['idNombreCliente'];
		$result = listProjectsClient($idNombreCliente);
		while ($row = mysql_fetch_array($result)) {
			echo '
				<option style="color: #'.$row['colorProyecto'].';" id="'.$row['idProyecto'].'" value="'.$row['idProyecto'].'">'.nombreCliente($row['nombreCliente']).'-'.marcaCliente($row['marcaCliente']).'-'.nombreProyecto($row['nombreProyecto']).'-'.actividadProyecto($row['actividadProyecto']).'</option>
			';
		}
	}                       

	if ($type == 'graficaMeses') {
      $idNombreCliente = $_POST['idNombreCliente'];
      $result = listProjectsClient($idNombreCliente);
      while ($row = mysql_fetch_array($result)) {
      	$result2 = eventsPerProjects($row['idProyecto']);
      	while ($row2 = mysql_fetch_array($result2)) {
      		echo "idEvento: ".$row2['idEvento']."<br>".
      			 "Correo: ".$row2['correoElectronico']."<br>".
      			 "Startdate: ".date('m',$row2['startdate'])."<br><br>";
      	}

        // echo "<br>".$row['idProyecto'];
        // eventsPerProjects($idProyecto)
        	/*echo '
        		var d = new Date();
			    var currentYear = d.getFullYear();
			    var Script = function () {

			    //morris chart

			    $(function () {
			      var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

			      Morris.Bar({
			        element: 'monthsGraph',
			        data: [{
			        m: '2015-01',
			        b: 270
			    }, {
			        m: '2015-02',
			        b: 256
			    }, {
			        m: '2015-03',
			        b: 334
			    }, {
			        m: '2015-04',
			        b: 282
			    }, {
			        m: '2015-05',
			        b: 58
			    }, {
			        m: '2015-06',
			        b: 5433
			    }, {
			        m: '2015-07',
			        b: 2344
			    }, {
			        m: '2015-08',
			        b: 1234
			    }, {
			        m: '2015-09',
			        b: 2348
			    }, {
			        m: '2015-10',
			        b: 534
			    }, {
			        m: '2015-11',
			        b: 435
			    }, {
			        m: '2015-12',
			        b: 234
			    }, ],
			    xkey: 'm',
			    ykeys: ['b'],
			    labels: [currentYear+' $'],
			    xLabelFormat: function (x) { // <-- changed
			        console.log("Este es el nuevo objeto:" + x);
			        var month = months[x.x];
			        return month;
			    },
			      });
			    });

			}();
        	';    */    	
      }
    }

	if ($type == 'hours') {
		$idNombreCliente = $_POST['idNombreCliente'];
		$result = listProjectsClient($idNombreCliente);
		$totalHours = 0;
		while ($row = mysql_fetch_array($result)) {
			$totalHours += $row['horasTrabajadas'];
		}
		echo $totalHours.' hrs.';
	}

	if ($type == 'cost') {
		$idNombreCliente = $_POST['idNombreCliente'];
		$result = listProjectsClient($idNombreCliente);
		$totalCost = 0;
		while ($row = mysql_fetch_array($result)) {
			$totalCost += $row['costoTotal'];
		}
		echo number_format($totalCost,2);
	}

	if ($type == 'modals') {
		$idNombreCliente = $_POST['idNombreCliente'];
		$result = listProjectsClient($idNombreCliente);
		while ($row = mysql_fetch_array($result)) {
			echo '
			<div class="modal fade" id="editar'.$row['idProyecto'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Modificar datos del Proyecto <strong>'.nombreCliente($row['nombreCliente']).'-'.nombreProyecto($row['nombreProyecto']).'-'.marcaCliente($row['marcaCliente']).'-'.actividadProyecto($row['actividadProyecto']).'</strong></h4>
			      </div>
			      <div class="modal-body">
			        <div class="row mt">
			          <div class="col-lg-12">
			            <div class="form-panel">
			            <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
			            <form class="form-horizontal style-form" method="POST" id="datos'.$row['idProyecto'].'">
			              <input value="'.$row['idProyecto'].'" type="hidden" name="idProyecto">
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Cliente</label>
			                </div>
			                <div class="col-sm-4">
			                  <input class="form-control" id="disabledInput" type="text" name="nombreCliente" placeholder="'.nombreCliente($row['nombreCliente']).'" disabled>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Proyecto</label>
			                </div>
			                <div class="col-sm-4">
			                 <select class="form-control" name="proyecto" id="proyecto">';			                  
			                    $result6 = nameProjects();
			                    while ($row6 = mysql_fetch_array($result6)) {
			                      if ($row6['idNombreProyecto'] === $row['nombreProyecto']) {
			                        echo '<option value="'.$row6['idNombreProyecto'].'" selected>'.$row6['nombreProyecto'].'</option>';			                  
			                      }else{
			                        echo '<option value="'.$row6['idNombreProyecto'].'">'.$row6['nombreProyecto'].'</option>';			                  
			                      }
			                    }
			                echo '			                  
			                </select>
			                </div>
			                <div class="col-sm-1">
			                  <a href="#" data-toggle="modal" data-target="#agregarProyecto" data-dismiss="modal">
			                    <img src="assets/img/add.png">
			                  </a>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Marca</label>
			                </div>
			                <div class="col-sm-4">
			                  <input class="form-control" id="disabledInput" type="text" name="marca"  placeholder="'.marcaCliente($row['marcaCliente']).'" disabled>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Actividad</label>
			                </div>
			                <div class="col-sm-4">
			                  <select class="form-control" name="actividad" id="actividad">';			                    
			                      $result7 = activitiesClients();
			                      while ($row7 = mysql_fetch_array($result7)) {
			                        if ($row7['idActividadProyecto'] === $row['actividadProyecto']) {
			                          echo '<option value="'.$row7['idActividadProyecto'].'" selected>'.$row7['actividadProyecto'].'</option>';			                    
			                        }else{
			                          echo '<option value="'.$row7['idActividadProyecto'].'">'.$row7['actividadProyecto'].'</option>';			                    
			                        }
			                      }
			                  echo '			                   
			                  </select>
			                </div>
			                <div class="col-sm-1">
			                  <a href="#" data-toggle="modal" data-target="#agregarActividad" data-dismiss="modal">
			                    <img src="assets/img/add.png">
			                  </a>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Categoría de Proyecto</label>
			                </div>
			                <div class="col-sm-4">
			                  <select class="form-control" name="tipoProyecto" id="tipoProyecto">';			                    
			                      $result3 = typesPojects();
			                      while ($row3 = mysql_fetch_array($result3)) {
			                        if ($row['tipoProyecto'] === $row3['idTipoProyecto']) {
			                          echo '<option value="'.$row3['idTipoProyecto'].'" selected>'.$row3['tipoProyecto'].'</option>';			                    
			                        }else{
			                          echo '<option value="'.$row3['idTipoProyecto'].'">'.$row3['tipoProyecto'].'</option>';			                    
			                        }                                                                                                  
			                      }
			                    echo '			                    
			                  </select> 
			                </div>
			                <div class="col-sm-1">
			                  <a href="#" data-toggle="modal" data-target="#agregarCategoria" data-dismiss="modal">
			                    <img src="assets/img/add.png">
			                  </a>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Etapa</label>
			                </div>
			                <div class="col-sm-4">
			                  <select class="form-control" name="etapa" id="etapa">';			                    
			                    switch ($row['idEtapa']) {
			                      case '1':
			                        echo "<option value='1' selected>Propuesta</option>
			                              <option value='2'>Ajustes</option>
			                              <option value='3'>Producción</option>";
			                        break;

			                      case '2':
			                        echo "<option value='1'>Propuesta</option>
			                              <option value='2' selected>Ajustes</option>
			                              <option value='3'>Producción</option>";
			                        break;

			                      case '3':
			                        echo "<option value='1'>Propuesta</option>
			                              <option value='2'>Ajustes</option>
			                              <option value='3' selected>Producción</option>";
			                        break;
			                      
			                      default:
			                        echo "<option value='1'>Propuesta</option>
			                              <option value='2'>Ajustes</option>
			                              <option value='3'>Producción</option>";
			                        break;
			                    }
			                    echo '			                    
			                  </select>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Status</label>
			                </div>
			                <div class="col-sm-4">
			                  <select class="form-control" name="status" id="status" onchange="admSelectCheck(this);">';			                    
			                    switch ($row['status']) {
			                        case "1":
			                            echo "<option value='1' selected>Activo</option>
			                                  <option value='0'>No Activo</option>
			                                  <option value='2'>Suspendido</option>
			                                  <option value='3' id='admOption'>Entregado</option>";
			                            break;
			                        case "2":
			                            echo "<option value='1'>Activo</option>
			                                  <option value='0'>No Activo</option>
			                                  <option value='2' selected>Suspendido</option>
			                                  <option value='3' id='admOption'>Entregado</option>";
			                            break;
			                        case "3":
			                            echo "<option value='1'>Activo</option>
			                                  <option value='0'>No Activo</option>
			                                  <option value='2'>Suspendido</option>
			                                  <option value='3' id='admOption' selected>Entregado</option>";
			                            break;
			                        case "0":
			                            echo "<option value='1'>Activo</option>
			                                  <option value='0' selected>No Activo</option>
			                                  <option value='2'>Suspendido</option>
			                                  <option value='3' id='admOption'>Entregado</option>";
			                            break;
			                        default:
			                            echo "<option value='1'>Activo</option>
			                                  <option value='0'>No Activo</option>
			                                  <option value='2'>Suspendido</option>
			                                  <option value='3' id='admOption'>Entregado</option>";
			                      }
			                    echo '
			                  </select>
			                </div>    
			              </div>                                                                                                          
			              <div id="fechaEntregado">
			                <div class="form-group">
			                  <div class="col-sm-4 col-sm-offset-1">
			                    <label class="control-label">Fecha de Entregado</label>
			                  </div>
			                  <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
			                    <input class="form-control" size="16" type="text" value="'.$row['fechaEntregado'].'" name="fechaEntregado" placeholder="'.$row['fechaEntregado'].'" readonly>
			                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
			                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                  </div>
			                  <span class="mensaje"><div class="alert alert-warning col-sm-5 col-sm-5 col-sm-offset-5 control-label" id="quitar">Indiqué la fecha de entrega.</div></span>
			                </div>
			              </div>                                     
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Célula de producción</label>
			                </div>
			                <div class="col-sm-4">';			                  
			                    switch ($row['celula']) {
			                      case '0':
			                        echo "
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula1' value='0' checked>
			                            Consumo
			                          </label>
			                        </div>
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula2' value='1'>
			                            Coorporativo
			                          </label>
			                        </div>";
			                        break;

			                      case '1':
			                        echo "
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula1' value='0'>
			                            Consumo
			                          </label>
			                        </div>
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula2' value='1' checked>
			                            Coorporativo
			                          </label>
			                        </div>";
			                        break;
			                      
			                      default:
			                        echo "
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula1' value='0'>
			                            Consumo
			                          </label>
			                        </div>
			                        <div class='radio'>
			                          <label>
			                            <input type='radio' name='celula' id='celula2' value='1'>
			                            Coorporativo
			                          </label>
			                        </div>";
			                        break;
			                    }
			                echo '                                                    
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Líder de Proyecto</label>
			                </div>
			                <div class="col-sm-4">
			                  <select class="form-control" name="liderProyecto">';			                    
			                      $result2 = usersBAMF();
			                      while ($row2 = mysql_fetch_array($result2)) {
			                        if ($row2['correoElectronico'] === $row['liderProyecto']) {
			                          echo '<option value="'.$row2['correoElectronico'].'" selected>'.$row2['nombre'].' '.$row2['apellidoP'].' '.$row2['apellidoM'].'</option>';			                    
			                        }else{			                    
			                        echo '<option value="'.$row2['correoElectronico'].'">'.$row2['nombre'].' '.$row2['apellidoP'].' '.$row2['apellidoM'].'</option>';			                    
			                        }
			                      }
			                    echo '			                    
			                  </select>
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-sm-4 col-sm-offset-1">
			                  <label class="control-label">Descripción</label>
			                </div>
			                <div class="col-sm-6">
			                  <textarea class="form-control" row="4" name="descripcion">'.$row['descripcion'].'</textarea>
			                </div>
			              </div>                                    
			            </div>
			          </div>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="submit" class="btn btn-primary" name="cambiar">Cambiar</button>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			';
		}
	}
?>