<div class="modal fade" id="editar<?php echo $project_data['idProyecto']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modificar datos del Proyecto <strong><?php echo nombreCliente($project_data['nombreCliente']); ?>-<?php echo nombreProyecto($project_data['nombreProyecto']);?>-<?php echo marcaCliente($project_data['marcaCliente']); ?>-<?php echo actividadProyecto($project_data['actividadProyecto']); ?></strong></h4>
      </div>
      <div class="modal-body">
        <div class="project_data mt">
          <div class="col-lg-12">
            <div class="form-panel">
            <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
            <form class="form-horizontal style-form" method="POST" id="datos<?php echo $project_data['idProyecto'];?>">
              <input value="<?php echo $project_data['idProyecto'];?>" type="hidden" name="idProyecto">
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Cliente</label>
                </div>
                <div class="col-sm-4">
                  <input class="form-control" id="disabledInput" type="text" name="nombreCliente" placeholder="<?php echo nombreCliente($project_data['nombreCliente']); ?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Proyecto</label>
                </div>
                <div class="col-sm-4">
                 <select class="form-control" name="proyecto" id="proyecto">
                  <?php
                    $result6 = nameProjects();
                    while ($row6 = mysql_fetch_array($result6)) {
                      if ($row6['idNombreProyecto'] === $project_data['nombreProyecto']) {?>
                        <option value="<?=$row6['idNombreProyecto']?>" selected><?=$row6['nombreProyecto']?></option>
                  <?php
                      }else{?>
                        <option value="<?=$row6['idNombreProyecto']?>"><?=$row6['nombreProyecto']?></option>
                  <?php
                      }
                    }
                  ?>
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
                  <input class="form-control" id="disabledInput" type="text" name="marca"  placeholder="<?php echo marcaCliente($project_data['marcaCliente']);?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Actividad</label>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" name="actividad" id="actividad">
                    <?php
                      $result7 = activitiesClients();
                      while ($row7 = mysql_fetch_array($result7)) {
                        if ($row7['idActividadProyecto'] === $project_data['actividadProyecto']) {?>
                          <option value="<?=$row7['idActividadProyecto']?>" selected><?=$row7['actividadProyecto']?></option>
                    <?php
                        }else{?>
                          <option value="<?=$row7['idActividadProyecto']?>"><?=$row7['actividadProyecto']?></option>
                    <?php
                        }
                      }
                    ?>
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
                  <select class="form-control" name="tipoProyecto" id="tipoProyecto">
                    <?php
                      $result3 = typesPojects();
                      while ($row3 = mysql_fetch_array($result3)) {
                        if ($project_data['tipoProyecto'] === $row3['idTipoProyecto']) {?>
                          <option value="<?=$row3['idTipoProyecto']?>" selected><?=$row3['tipoProyecto']?></option>
                    <?php    
                        }else{?>
                          <option value="<?=$row3['idTipoProyecto']?>"><?=$row3['tipoProyecto']?></option>
                    <?php
                        }                                                                                                  
                      }
                    ?>
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
                  <select class="form-control" name="etapa" id="etapa">
                    <?php
                    switch ($project_data['idEtapa']) {
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
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Status</label>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" name="status" id="status" onchange="admSelectCheck(this);">
                    <?php
                    switch ($project_data['status']) {
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
                      ?>
                  </select>
                </div>    
              </div>                                                                                                          
              <div id="fechaEntregado">
                <div class="form-group">
                  <div class="col-sm-4 col-sm-offset-1">
                    <label class="control-label">Fecha de Entregado</label>
                  </div>
                  <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?=$project_data['fechaEntregado']?>" name="fechaEntregado" placeholder="<?php echo $project_data['fechaEntregado'];?>" readonly>
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
                <div class="col-sm-4">
                  <?php
                    switch ($project_data['celula']) {
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
                  ?>                                                                        
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Líder de Proyecto</label>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" name="liderProyecto">
                    <?php
                      $result2 = usersBAMF();
                      while ($row2 = mysql_fetch_array($result2)) {
                        if ($row2['correoElectronico'] === $project_data['liderProyecto']) {?>
                          <option value="<?=$row2['correoElectronico']?>" selected><?=$row2['nombre']?> <?=$row2['apellidoP']?> <?=$row2['apellidoM']?></option>
                    <?php      
                        }else{
                    ?>
                        <option value="<?=$row2['correoElectronico']?>"><?=$row2['nombre']?> <?=$row2['apellidoP']?> <?=$row2['apellidoM']?></option>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-1">
                  <label class="control-label">Descripción</label>
                </div>
                <div class="col-sm-6">
                  <textarea class="form-control" row="4" name="descripcion"><?php echo $project_data['descripcion'];?></textarea>
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