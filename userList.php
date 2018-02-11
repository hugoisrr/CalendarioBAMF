<?php

ob_start();

?>
<!DOCTYPE html>
<html lang="es">
  <?php
    include "includes/html/head.php";
    include "core/init.php"; 
    if (isset($_POST['cambiar'])) {
      $idDisenador = $_POST['idDisenador'];
      $celula = $_POST['celula'];
      $status = $_POST['status'];
      $costo = $_POST['costxhora'];
      $puesto = $_POST['puesto'];

      modifyUserDiseno($idDisenador,$celula,$status,$costo,$puesto);
      header('Location: userList.php?exito&var='.$idDisenador);
      exit();
    }elseif (isset($_POST['cambiarPro'])) {
      $idProgramador = $_POST['idProgramador'];
      $celula = $_POST['celula'];
      $status = $_POST['status'];
      $costo = $_POST['costxhora'];
      $puesto = $_POST['puesto'];

      modifyUserProgra($idProgramador,$celula,$status,$costo,$puesto);
      header('Location: userList.php?exito&var='.$idProgramador);
      exit();
    }          
  ?>
  <body onload="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <?php
        include "includes/html/header.php";
        include "includes/html/sideBar.php";
      ?>          
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Lista de Usuarios</h3>
          	<div class="row mt">
          		<div class="col-lg-6">
                <h4 class="mb"><i class="fa fa-angle-right"></i> Célula Consumo</h4>
                <!-- **********************************************************************************************************************************************************
                Célula Consumo Diseñadores
                *********************************************************************************************************************************************************** -->
                <?php                          
                  $result = usersDiseno(0);
                  while ($row = mysql_fetch_array($result)) {
                ?>
                <div class="col-lg-5 col-md-5 col-sm-5 mb">
                  <!-- WHITE PANEL - TOP USER -->
                  <div class="white-panel pn">
                    <div class="white-header">
                      <h5><?php
                      if ($row['tipoDisenador'] === '1') {
                        echo "Diseñador Sr.";
                      }
                      elseif ($row['tipoDisenador'] === '0') {
                        echo "Diseñador Jr.";
                      }
                      ?> <button class='btn btn-primary btn-xs' data-toggle="modal" data-target="#editar<?=$row['idDisenador']?>"><i class='fa fa-pencil'></i></button></h5>
                      <!-- Modal de edición -->
                      <div class="modal fade" id="editar<?=$row['idDisenador']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Modificar datos de <?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></h4>
                            </div>
                            <div class="modal-body">
                              <div class="row mt">
                                <div class="col-lg-12">
                                    <div class="form-panel">
                                        <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
                                        <form class="form-horizontal style-form" method="POST" id="datos<?=$row['idDisenador']?>">
                                            <!-- Celula de produccion -->
                                            <input value="<?=$row['idDisenador']?>" type="hidden" name="idDisenador">
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Célula de producción</label>
                                              </div>
                                              <div class="col-sm-4">
                                                <?php
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
                                                          Corporativo
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
                                                          Corporativo
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
                                                          Corporativo
                                                        </label>
                                                      </div>";
                                                      break;
                                                  }
                                                ?>                                                                        
                                              </div>
                                            </div>
                                            <!-- Status del usuario -->
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Status</label>
                                              </div>
                                              <div class="col-sm-4">
                                                  <select class="form-control" name="status">
                                                    <?php
                                                    switch ($row['status']) {
                                                        case "1":
                                                            echo "<option value='1' selected>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "2":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2' selected>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "0":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0' selected>Suspendido</option>";
                                                            break;
                                                        default:
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                    }
                                                    ?>                                                    
                                                  </select>
                                              </div>
                                            </div>
                                            <?php
                                            if ($user_data['idtipoUsuario'] === "2") {?>
                                              <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-1">
                                                  <label class="control-label">Costo por Hora</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="focusedInput" type="number" name="costxhora" step="any" placeholder="$<?= number_format($row['costoHora'],2)?>" value="<?= number_format($row['costoHora'],2)?>">
                                                </div>
                                              </div>
                                              <?php
                                              if ($row['tipoDisenador'] !== '1') {
                                              ?>
                                                <div class="form-group">
                                                  <label class="col-sm-4 col-sm-4 col-sm-offset-1 control-label">Puesto</label>
                                                    <div class="checkbox">
                                                      <div class="col-sm-4">
                                                      <label class="control-label">
                                                        <input type="checkbox" value="1" name="puesto">
                                                        Diseñador Sr.
                                                      </label>
                                                      </div>
                                                    </div>
                                                </div> 
                                              <?php
                                              }
                                            }
                                            ?>                                            
                                        <?php
                                        if (isset($_GET['exito']) && empty($_GET['exito']) && $row['idDisenador'] === $_GET['var']){?>
                                          <div class="alert alert-success" id="quitar"><b>¡Genial!</b> Se han modificado los datos.</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div><!-- col-lg-12-->       
                              </div><!-- /row -->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" class="btn btn-primary" name="cambiar">Cambiar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    <!-- Contenido e información del usuario -->
                    <p><img src="<?=$row['foto']?>" class="img-circle" width="50"></p>
                    <p><b><a href="mailto:<?=$row['correoElectronico']?>" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #<?=$row['color']?>;"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></button></a></b></p>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="small mt">Fecha Ingreso</p>
                          <p><?=$row['fechaIngreso']?></p>
                        </div>
                        <div class="col-md-6">
                          <p class="small mt">Status</p>
                          <?php
                          switch ($row['status']) {
                              case "1":
                                  echo "<span class='label label-success label-mini'>Activo</span>";
                                  break;
                              case "2":
                                  echo "<span class='label label-warning label-mini'>No Activo</span>";
                                  break;
                              case "0":
                                  echo "<span class='label label-danger label-mini'>Suspendido</span>";
                                  break;
                              default:
                                  echo "Sin status";
                          }
                          ?>
                        </div>
                        <?php
                        if ($user_data['idtipoUsuario'] === "2") {?>
                          <div class="col-md-6">
                            <p class="small mt">Costo por Hora</p>
                            <p>$<?= number_format($row['costoHora'],2)?></p>
                          </div>
                        <?php                          
                        }
                        ?>
                      </div>
                  </div>
                </div><!-- /col-md-4 -->
                <?php
                  }
                ?>
                <?php                          
                  $result = usersProgramador(0);
                  while ($row = mysql_fetch_array($result)) {
                ?>
                <!-- **********************************************************************************************************************************************************
                Célula Consumo Programadores
                *********************************************************************************************************************************************************** -->
                <div class="col-lg-5 col-md-5 col-sm-5 mb">
                  <!-- WHITE PANEL - TOP USER -->
                  <div class="white-panel pn">
                    <div class="white-header">
                      <h5><?php
                      if ($row['tipoProgramador'] === '1') {
                        echo "Programador Sr.";
                      }
                      elseif ($row['tipoProgramador'] === '0') {
                        echo "Programador Jr.";
                      }
                      ?> <button class='btn btn-primary btn-xs' data-toggle="modal" data-target="#editarPro<?=$row['idProgramador']?>"><i class='fa fa-pencil'></i></button></h5>
                    <!-- Modal de edición -->
                      <div class="modal fade" id="editarPro<?=$row['idProgramador']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Modificar datos de <?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></h4>
                            </div>
                            <div class="modal-body">
                              <div class="row mt">
                                <div class="col-lg-12">
                                    <div class="form-panel">
                                        <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
                                        <form class="form-horizontal style-form" method="POST" id="datos<?=$row['idProgramador']?>">
                                            <!-- Celula de produccion -->
                                            <input value="<?=$row['idProgramador']?>" type="hidden" name="idProgramador">
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Célula de producción</label>
                                              </div>
                                              <div class="col-sm-4">
                                                <?php
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
                                                          Corporativo
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
                                                          Corporativo
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
                                                          Corporativo
                                                        </label>
                                                      </div>";
                                                      break;
                                                  }
                                                ?>                                                                        
                                              </div>
                                            </div>
                                            <!-- Status del usuario -->
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Status</label>
                                              </div>
                                              <div class="col-sm-4">
                                                  <select class="form-control" name="status">
                                                    <?php
                                                    switch ($row['status']) {
                                                        case "1":
                                                            echo "<option value='1' selected>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "2":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2' selected>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "0":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0' selected>Suspendido</option>";
                                                            break;
                                                        default:
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                    }
                                                    ?>                                                    
                                                  </select>
                                              </div>
                                            </div>
                                            <?php
                                            if ($user_data['idtipoUsuario'] === "2") {?>
                                              <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-1">
                                                  <label class="control-label">Costo por Hora</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="focusedInput" type="number" name="costxhora" step="any" placeholder="$<?= number_format($row['costoHora'],2)?>" value="<?= number_format($row['costoHora'],2)?>">
                                                </div>
                                              </div>
                                              <?php
                                              if ($row['tipoProgramador'] !== '1') {
                                              ?>
                                                <div class="form-group">
                                                  <label class="col-sm-4 col-sm-4 col-sm-offset-1 control-label">Puesto</label>
                                                    <div class="checkbox">
                                                      <div class="col-sm-4">
                                                      <label class="control-label">
                                                        <input type="checkbox" value="1" name="puesto">
                                                        Programador Sr.
                                                      </label>
                                                      </div>
                                                    </div>
                                                </div> 
                                              <?php
                                              }
                                            }
                                            ?>                                            
                                        <?php
                                        if (isset($_GET['exito']) && empty($_GET['exito']) && $row['idProgramador'] === $_GET['var']){?>
                                          <div class="alert alert-success" id="quitar"><b>¡Genial!</b> Se han modificado los datos.</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div><!-- col-lg-12-->       
                              </div><!-- /row -->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" class="btn btn-primary" name="cambiarPro">Cambiar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    <!-- Contenido e información del usuario -->
                    <p><img src="<?=$row['foto']?>" class="img-circle" width="50"></p>
                    <p><b><a href="mailto:<?=$row['correoElectronico']?>" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #<?=$row['color']?>;"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></button></a></b></p>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="small mt">Fecha Ingreso</p>
                          <p><?=$row['fechaIngreso']?></p>
                        </div>
                        <div class="col-md-6">
                          <p class="small mt">Status</p>
                          <?php
                          switch ($row['status']) {
                              case "1":
                                  echo "<span class='label label-success label-mini'>Activo</span>";
                                  break;
                              case "2":
                                  echo "<span class='label label-warning label-mini'>No Activo</span>";
                                  break;
                              case "0":
                                  echo "<span class='label label-danger label-mini'>Suspendido</span>";
                                  break;
                              default:
                                  echo "Sin status";
                          }
                          ?>
                        </div>
                        <?php
                        if ($user_data['idtipoUsuario'] === "2") {?>
                          <div class="col-md-6">
                            <p class="small mt">Costo por Hora</p>
                            <p>$<?= number_format($row['costoHora'],2)?></p>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                  </div>
                </div><!-- /col-md-4 -->
                <?php
                  }
                ?>
          		</div>
              <div class="col-lg-6">
                <h4 class="mb"><i class="fa fa-angle-right"></i> Célula Corporativo</h4>
                <!-- **********************************************************************************************************************************************************
                Célula Corporativo Diseñadores
                *********************************************************************************************************************************************************** -->
                <?php                          
                  $result = usersDiseno(1);
                  while ($row = mysql_fetch_array($result)) {
                ?>
                <div class="col-lg-5 col-md-5 col-sm-5 mb">
                  <!-- WHITE PANEL - TOP USER -->
                  <div class="white-panel pn">
                    <div class="white-header">
                      <h5><?php
                      if ($row['tipoDisenador'] === '1') {
                        echo "Diseñador Sr.";
                      }
                      elseif ($row['tipoDisenador'] === '0') {
                        echo "Diseñador Jr.";
                      }
                      ?> <button class='btn btn-primary btn-xs' data-toggle="modal" data-target="#editar<?=$row['idDisenador']?>"><i class='fa fa-pencil'></i></button></h5>
                    <!-- Modal de edición -->
                      <div class="modal fade" id="editar<?=$row['idDisenador']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Modificar datos de <?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></h4>
                            </div>
                            <div class="modal-body">
                              <div class="row mt">
                                <div class="col-lg-12">
                                    <div class="form-panel">
                                        <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
                                        <form class="form-horizontal style-form" method="POST" id="datos<?=$row['idDisenador']?>">
                                            <!-- Celula de produccion -->
                                            <input value="<?=$row['idDisenador']?>" type="hidden" name="idDisenador">
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Célula de producción</label>
                                              </div>
                                              <div class="col-sm-4">
                                                <?php
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
                                                          Corporativo
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
                                                          Corporativo
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
                                                          Corporativo
                                                        </label>
                                                      </div>";
                                                      break;
                                                  }
                                                ?>                                                                        
                                              </div>
                                            </div>
                                            <!-- Status del usuario -->
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Status</label>
                                              </div>
                                              <div class="col-sm-4">
                                                  <select class="form-control" name="status">
                                                    <?php
                                                    switch ($row['status']) {
                                                        case "1":
                                                            echo "<option value='1' selected>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "2":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2' selected>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "0":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0' selected>Suspendido</option>";
                                                            break;
                                                        default:
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                    }
                                                    ?>                                                    
                                                  </select>
                                              </div>
                                            </div>
                                            <?php
                                            if ($user_data['idtipoUsuario'] === "2") {?>
                                              <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-1">
                                                  <label class="control-label">Costo por Hora</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="focusedInput" type="number" name="costxhora" step="any" placeholder="$<?= number_format($row['costoHora'],2)?>" value="<?= number_format($row['costoHora'],2)?>">
                                                </div>
                                              </div>
                                              <?php
                                              if ($row['tipoDisenador'] !== '1') {
                                              ?>
                                                <div class="form-group">
                                                  <label class="col-sm-4 col-sm-4 col-sm-offset-1 control-label">Puesto</label>
                                                    <div class="checkbox">
                                                      <div class="col-sm-4">
                                                      <label class="control-label">
                                                        <input type="checkbox" value="1" name="puesto">
                                                        Diseñador Sr.
                                                      </label>
                                                      </div>
                                                    </div>
                                                </div> 
                                              <?php
                                              }
                                            }
                                            ?>                                            
                                        <?php
                                        if (isset($_GET['exito']) && empty($_GET['exito']) && $row['idDisenador'] === $_GET['var']){?>
                                          <div class="alert alert-success" id="quitar"><b>¡Genial!</b> Se han modificado los datos.</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div><!-- col-lg-12-->       
                              </div><!-- /row -->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" class="btn btn-primary" name="cambiar">Cambiar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    <!-- Contenido e información del usuario -->
                    <p><img src="<?=$row['foto']?>" class="img-circle" width="50"></p>
                    <p><b><a href="mailto:<?=$row['correoElectronico']?>" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #<?=$row['color']?>;"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></button></a></b></p>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="small mt">Fecha Ingreso</p>
                          <p><?=$row['fechaIngreso']?></p>
                        </div>
                        <div class="col-md-6">
                          <p class="small mt">Status</p>
                          <?php
                          switch ($row['status']) {
                              case "1":
                                  echo "<span class='label label-success label-mini'>Activo</span>";
                                  break;
                              case "2":
                                  echo "<span class='label label-warning label-mini'>No Activo</span>";
                                  break;
                              case "0":
                                  echo "<span class='label label-danger label-mini'>Suspendido</span>";
                                  break;
                              default:
                                  echo "Sin status";
                          }
                          ?>
                        </div>
                        <?php
                        if ($user_data['idtipoUsuario'] === "2") {?>
                          <div class="col-md-6">
                            <p class="small mt">Costo por Hora</p>
                            <p>$<?= number_format($row['costoHora'],2)?></p>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                  </div>
                </div><!-- /col-md-4 -->
                <?php
                  }
                ?>
                <?php                          
                  $result = usersProgramador(1);
                  while ($row = mysql_fetch_array($result)) {
                ?>
                <!-- **********************************************************************************************************************************************************
                Célula Corporativo Programadores
                *********************************************************************************************************************************************************** -->
                <div class="col-lg-5 col-md-5 col-sm-5 mb">
                  <!-- WHITE PANEL - TOP USER -->
                  <div class="white-panel pn">
                    <div class="white-header">
                      <h5><?php
                      if ($row['tipoProgramador'] === '1') {
                        echo "Programador Sr.";
                      }
                      elseif ($row['tipoProgramador'] === '0') {
                        echo "Programador Jr.";
                      }
                      ?> <button class='btn btn-primary btn-xs' data-toggle="modal" data-target="#editarPro<?=$row['idProgramador']?>"><i class='fa fa-pencil'></i></button></h5>
                    <!-- Modal de edición -->
                      <div class="modal fade" id="editarPro<?=$row['idProgramador']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Modificar datos de <?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></h4>
                            </div>
                            <div class="modal-body">
                              <div class="row mt">
                                <div class="col-lg-12">
                                    <div class="form-panel">
                                        <h4 class="mb"><i class="fa fa-angle-right"></i> Cambiar datos</h4>
                                        <form class="form-horizontal style-form" method="POST" id="datos<?=$row['idProgramador']?>">
                                            <!-- Celula de produccion -->
                                            <input value="<?=$row['idProgramador']?>" type="hidden" name="idProgramador">
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Célula de producción</label>
                                              </div>
                                              <div class="col-sm-4">
                                                <?php
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
                                                          Corporativo
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
                                                          Corporativo
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
                                                          Corporativo
                                                        </label>
                                                      </div>";
                                                      break;
                                                  }
                                                ?>                                                                        
                                              </div>
                                            </div>
                                            <!-- Status del usuario -->
                                            <div class="form-group">
                                              <div class="col-sm-4 col-sm-offset-1">
                                                <label class="control-label">Status</label>
                                              </div>
                                              <div class="col-sm-4">
                                                  <select class="form-control" name="status">
                                                    <?php
                                                    switch ($row['status']) {
                                                        case "1":
                                                            echo "<option value='1' selected>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "2":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2' selected>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                            break;
                                                        case "0":
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0' selected>Suspendido</option>";
                                                            break;
                                                        default:
                                                            echo "<option value='1'>Activo</option>
                                                                  <option value='2'>No Activo</option>
                                                                  <option value='0'>Suspendido</option>";
                                                    }
                                                    ?>                                                    
                                                  </select>
                                              </div>
                                            </div>
                                            <?php
                                            if ($user_data['idtipoUsuario'] === "2") {?>
                                              <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-1">
                                                  <label class="control-label">Costo por Hora</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" id="focusedInput" type="number" name="costxhora" step="any" placeholder="$<?= number_format($row['costoHora'],2)?>" value="<?= number_format($row['costoHora'],2)?>">
                                                </div>
                                              </div>
                                              <?php
                                              if ($row['tipoProgramador'] !== '1') {
                                              ?>
                                                <div class="form-group">
                                                  <label class="col-sm-4 col-sm-4 col-sm-offset-1 control-label">Puesto</label>
                                                    <div class="checkbox">
                                                      <div class="col-sm-4">
                                                      <label class="control-label">
                                                        <input type="checkbox" value="1" name="puesto">
                                                        Programador Sr.
                                                      </label>
                                                      </div>
                                                    </div>
                                                </div> 
                                              <?php
                                              }
                                            }
                                            ?>                                            
                                        <?php
                                        if (isset($_GET['exito']) && empty($_GET['exito']) && $row['idProgramador'] === $_GET['var']){?>
                                          <div class="alert alert-success" id="quitar"><b>¡Genial!</b> Se han modificado los datos.</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div><!-- col-lg-12-->       
                              </div><!-- /row -->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" class="btn btn-primary" name="cambiarPro">Cambiar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> 
                    </div>
                    <!-- Contenido e información del usuario -->
                    <p><img src="<?=$row['foto']?>" class="img-circle" width="50"></p>
                    <p><b><a href="mailto:<?=$row['correoElectronico']?>" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #<?=$row['color']?>;"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></button></a></b></p>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="small mt">Fecha Ingreso</p>
                          <p><?=$row['fechaIngreso']?></p>
                        </div>
                        <div class="col-md-6">
                          <p class="small mt">Status</p>
                          <?php
                          switch ($row['status']) {
                              case "1":
                                  echo "<span class='label label-success label-mini'>Activo</span>";
                                  break;
                              case "2":
                                  echo "<span class='label label-warning label-mini'>No Activo</span>";
                                  break;
                              case "0":
                                  echo "<span class='label label-danger label-mini'>Suspendido</span>";
                                  break;
                              default:
                                  echo "Sin status";
                          }
                          ?>
                        </div>
                        <?php
                        if ($user_data['idtipoUsuario'] === "2") {?>
                          <div class="col-md-6">
                            <p class="small mt">Costo por Hora</p>
                            <p>$<?= number_format($row['costoHora'],2)?></p>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                  </div>
                </div><!-- /col-md-4 -->
                <?php
                  }
                ?>
              </div>
          	</div>			
		      </section>
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->
  <?php
    include "includes/html/footer.php";
  ?>
  </section>
  <?php
    include "includes/html/scripts.php";
    ob_end_flush();
  ?>
  </body>
</html>
