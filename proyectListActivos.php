<?php

ob_start();

?>
<!DOCTYPE html>
<html lang="es">
  <?php
    include "includes/html/head.php";
    include "core/init.php";
    if ($user_data['idtipoUsuario'] === "1") {
      administrador();
    }elseif ($user_data['idtipoUsuario'] === "2") {
      jefe();
    }
    if (isset($_POST['cambiar'])) {
      if (empty($errors) === true) {
        if ($_POST['status'] === '3' && $_POST['fechaEntregado'] == NULL) {
          $errors[] ='<div class="alert alert-danger col-sm-6 col-sm-6 control-label" id="quitar">Si el estatus del Proyecto es <strong>Entregado</strong> indiqué la fecha de entregado.</div>';
        }elseif ($_POST['status'] !== '3' && $_POST['fechaEntregado'] != NULL) {
          $errors[] ='<div class="alert alert-danger col-sm-6 col-sm-6 control-label" id="quitar">Si ha ingresado una <strong>fecha de entregado</strong> cambie el status a entregado.</div>';
        }else{
          $idProyecto = $_POST['idProyecto'];     
          $proyecto = $_POST['proyecto'];
          $idActividad = $_POST['actividad'];
          $tipoProyecto = $_POST['tipoProyecto'];
          $celula = $_POST['celula'];
          $liderProyecto = $_POST['liderProyecto'];
          $etapa = $_POST['etapa'];
          $status = $_POST['status'];     
          $fechaEntregado = $_POST['fechaEntregado'];
          $descripcion = $_POST['descripcion'];

          modifyProjectInfo($idProyecto,$proyecto,$idActividad,$tipoProyecto,$celula,$liderProyecto,$etapa,$status,$fechaEntregado,$descripcion);
          header('Location: proyectListActivos.php?exito&var='.$idProyecto);
          exit();
        }
      }           
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
          	<h3><i class="fa fa-angle-right"></i> Lista de Proyectos <span style="color: #41CAC0;"><strong>Activos</strong></span></h3>
            <?php
            if (isset($_GET['exito']) && empty($_GET['exito'])) {
                $idProyecto = $_GET['var'];
                $project_data = project_data($idProyecto, 'nombreProyecto', 'actividadProyecto', 'nombreCliente', 'marcaCliente');
              ?>
              <div class="row mt">
                <div class="col-lg-8">
                  <div class="form-group">
                    <div class="alert alert-success col-sm-8 col-sm-8 control-label" id="quitar"><b>¡Genial!</b> El proyecto <strong><?php echo nombreCliente($project_data['nombreCliente']); ?>-<?php echo nombreProyecto($project_data['nombreProyecto']);?>-<?php echo marcaCliente($project_data['marcaCliente']); ?>-<?php echo actividadProyecto($project_data['actividadProyecto']); ?></strong> ha sido modificado.</div>
                  </div>
                </div>
              </div>
            <?php
            }
            elseif (empty($errors) === false) {
              echo output_errors($errors);
            }
            ?>
          	<div class="row mt">
          		<div class="col-lg-12">
          		  <div class="content-panel">
                    <table class="display" id="proyectsTable">
                      <h4><i class="fa fa-angle-right"></i> ¡Proyectos BAMF!</h4>                      
                      <hr>
                        <thead>
                        <tr>
                            <!-- Al momento de mostrar el nombre del proyecto, mostrar también el color del proyecto -->
                            <th><i class="fa fa-bullhorn"></i> Nombre</th>
                            <th><i class="fa fa-pencil"></i> Editar</th>
                            <th class="hidden-phone"><i class="fa fa-question-circle"></i> Categoría de Proyecto</th>
                            <th><i class="fa fa-user"></i> Cliente</th>
                            <th><i class="fa fa-calendar-plus-o"></i> Fecha Creación</th>
                            <th><i class="fa fa-tasks"></i> Etapa</th>
                            <th><i class="fa fa-users"></i> Célula</th>
                            <th><i class="fa fa-star"></i> Líder del Proyecto</th>                 
                            <th><i class="fa fa-calendar-check-o"></i> Fecha de Entrega</th>
                            <th><i class="fa fa-hourglass-end"></i> Horas Trabajadas</th>
                            <?php
                            if ($user_data['idtipoUsuario'] === "2") {?>
                            <th><i class="fa fa-usd"></i> Costo Total</th>
                            <?php                          
                            }
                            ?>                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                          $result = listProjects();
                          while ($row = mysql_fetch_array($result)) {?>
                            <tr>
                              <td><a href="projectDescr.php?var=<?=$row['idProyecto']?>" style="color: #F0FFF0;"><button class="btn btn-xs" style="background: #<?=$row['colorProyecto']?>;"><?php echo nombreCliente($row['nombreCliente']); ?>-<?php echo marcaCliente($row['marcaCliente']); ?>-<?php echo nombreProyecto($row['nombreProyecto']);?></button></a></td>
                              <td>
                                <button class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editar<?=$row['idProyecto']?>"><i class="fa fa-pencil"></i></button>
                              </td>
                              <td><?php echo typeProject($row['tipoProyecto']); ?></td>
                              <td><?php echo nombreCliente($row['nombreCliente']); ?></td>
                              <td><?=$row['fechaProyecto']?></td>
                              <td><?php 
                                  if ($row['idEtapa'] === '1') {
                                    echo "<span class='label label-info label-mini'>".stageProject($row['idEtapa'])."</span>";      
                                  }elseif ($row['idEtapa'] === '2') {
                                    echo "<span class='label label-warning label-mini'>".stageProject($row['idEtapa'])."</span>";      
                                  }elseif ($row['idEtapa'] === '3') {
                                    echo "<span class='label label-success label-mini'>".stageProject($row['idEtapa'])."</span>";      
                                  }
                               ?></td>
                              <td><?php
                                  if ($row['celula'] === '0') {
                                    echo "Consumo";
                                  }elseif ($row['celula'] === '1') {
                                    echo "Corporativo";
                                  }
                                  ?>
                              </td>
                              <td><a href="mailto:<?=$row['liderProyecto']?>"> <?php $result2 = userData($row['liderProyecto']); 
                                while ($row2 = mysql_fetch_array($result2)) {
                                  echo $row2['nombre'].' '.$row2['apellidoP'].' '.$row2['apellidoM'];
                                }
                              ?></a>
                              </td>
                              <td>
                                <?php
                                  if ($row['fechaEntregado'] === NULL) {
                                    echo "--";
                                  }else{
                                    echo $row['fechaEntregado'];
                                  }
                                ?>
                              </td>
                              <td><?=$row['horasTrabajadas']?> hrs.</td>
                              <?php
                              if ($user_data['idtipoUsuario'] === "2") {?>
                              <td>
                                <?php
                                  if ($row['costoTotal'] === NULL) {
                                    echo "--";
                                  }else{
                                    echo '$'.number_format($row['costoTotal'],2);
                                  }
                                ?>
                              </td>
                              <?php                          
                              }
                              ?>                              
                            </tr>                            
                        <?php
                          }
                        ?>
                        </tbody>
                    </table>
                    <?php
                      $result = listProjects();
                      while ($row = mysql_fetch_array($result)) {?>
                       <!-- **********************************************************************************************************************************************************
                        MODAL PARA MODIFICAR DATOS DE UN PROYECTO
                        *********************************************************************************************************************************************************** -->
                      
                  <?php
                        include "includes/modals/modifyDataProject.php";
                      }
                    ?>
                </div><!-- /content-panel -->
          		</div>
          	</div>			
		      </section>
      </section><!-- /MAIN CONTENT -->     
<!-- **********************************************************************************************************************************************************
LISTA DE MODALS PARA AGREGAR INFORMACIÓN A LA BD Y A SU VEZ AL PROYECTO
*********************************************************************************************************************************************************** -->       
<?php
  include "includes/modals/addProject.php";
  include "includes/modals/addActivity.php";
  include "includes/modals/addTypeProject.php";
?>   
  <script type="text/javascript">
    // Add the following into your HEAD section
    var timer = 0;
    function set_interval() {
      // the interval 'timer' is set as soon as the page loads
      timer = setInterval("auto_logout()", 900000);
      // the figure '10000' above indicates how many milliseconds the timer be set to.
      // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
      // So set it to 300000
      // En este caso se establece el tiempo en 15 min = 15x60 = 900 sec, por lo tanto
      // 900000
    }

    function reset_interval() {
      //resets the timer. The timer is reset on each of the below events:
      // 1. mousemove   2. mouseclick   3. key press 4. scroliing
      //first step: clear the existing timer

      if (timer != 0) {
        clearInterval(timer);
        timer = 0;
        // second step: implement the timer again
        timer = setInterval("auto_logout()", 900000);
        // completed the reset of the timer
      }
    }

    function auto_logout() {
      // this function will redirect the user to the logout script
      window.location = "logout.php";
    }

    function validate(e) {
        var regex = new RegExp("[a-zA-Z0-9 -_]");
        var key = e.keyCode || e.which;
        key = String.fromCharCode(key);
        
        if(!regex.test(key)) {
            e.returnValue = false;
            if(e.preventDefault) {
                e.preventDefault();
            }
        }
    }
  </script> 
  <script type="text/javascript">
    // función de JQuery que nos ayuda a mostrar mensaje de warning al momento que
    // el usuario haya seleccionado Status del proyecto "Entregado"
    $(document).ready(function() {    
      $('#status').change(function() {            
          var selectedValue = $(this).val();            
          if ( selectedValue == '3' ) {
              $('.mensaje').fadeIn(1500);
          } else {
              $('.mensaje').fadeOut(2500);
          }            
      });
    });
  </script>
  <?php
    include "includes/html/footer.php";
  ?>
  </section>  
  <script type="text/javascript">
    $(document).ready(function(){
      $('#proyectsTable').DataTable();
    });
  </script>
  <script type="text/javascript" src="assets/js/ajaxProyecto.js"></script>
  <script type="text/javascript" src="assets/js/ajaxActividad.js"></script>
  <script type="text/javascript" src="assets/js/ajaxTipo.js"></script>
  <script type="text/javascript" src="assets/js/ajaxUpdateSelect.js"></script>
  <script type="text/javascript" src="media/js/jquery.js"></script>
  <script type="text/javascript" src="media/js/jquery.dataTables.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/bootstrap-datetimepicker.js"></script>
  <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
  <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="assets/js/jqueryCustoms.js"></script>
  <script src="assets/js/bootstrap-datetimepicker.es.js"></script>
  <script type="text/javascript">
    $('.form_date').datetimepicker({
        language:  'es',
        daysOfWeekDisabled: [0, 6],
        endDate: '+0d',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
  </script>

  <!--common script for all pages-->
  <script src="assets/js/common-scripts.js"></script>
  <?php
    ob_end_flush();
  ?>
  </body>
</html>
