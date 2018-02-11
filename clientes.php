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
          $idProyecto = $_POST['idProyecto'];     
          $proyecto = $_POST['proyecto'];
          $idActividad = $_POST['actividad'];
          $tipoProyecto = $_POST['tipoProyecto'];
          $celula = $_POST['celula'];
          $liderProyecto = $_POST['liderProyecto'];
          $etapa = $_POST['etapa'];
          $status = $_POST['status'];     
          $fechaEntregado = "";
          $descripcion = $_POST['descripcion'];

          modifyProjectInfo($idProyecto,$proyecto,$idActividad,$tipoProyecto,$celula,$liderProyecto,$status,$fechaEntregado,$descripcion);
          header('Location: clientes.php?exito&var='.$idProyecto);
          exit();
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
          header('Location: clientes.php?exito&var='.$idProyecto);
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
          	<h2><i class="fa fa-angle-right"></i> Clientes</h2>
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
          		<div class="col-lg-5">
          		  <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Lista de clientes</h4>
                  <form class="form-horizontal style-form">
                    <div class="form-group">
                      <label class="col-sm-4 col-sm-4 control-label">*Escoja el cliente</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="nombreCliente" id="nombreCliente">
                          <option value="0"></option>
                          <?php
                            $result = nameClients();
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idNombreCliente']?>"><?=$row['nombreCliente']?></option>
                          <?php
                            }
                          ?>
                        </select>                                                                              
                      </div>
                    </div>
                  </form>
                </div>
          		</div>
              <div class="col-lg-3 col-md-3 col-sm-3 mb" id="divHoursClient">
                <div class="weather-3 pn centered">
                  <!-- **********************************************************************************************************************************************************
                    A TRAVÉS DE AJAX IMPRIME EL NÚMERO DE HORAS TRABAJADAS POR CLIENTE
                  *********************************************************************************************************************************************************** -->                        
                  <i class="fa fa-hourglass"></i>
                  <h1 id="hoursClient"></h1>
                  <div class="info">
                    <div class="row">
                        <h3 class="centered">TOTAL DE HORAS</h3>
                      <div class="col-sm-6 col-xs-6 pull-left">
                        <p class="goleft"></p>
                      </div>
                      <div class="col-sm-6 col-xs-6 pull-right">
                        <p class="goright"></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                if ($user_data['idtipoUsuario'] === "2") {?>
                <div class="col-lg-3 col-md-3 col-sm-3 mb" id="divCostClient">
                  <div class="weather-3 pn centered" style="background: #00ff42;">
                    <!-- **********************************************************************************************************************************************************
                      A TRAVÉS DE AJAX IMPRIME EL COSTO TOTAL POR CLIENTE
                    *********************************************************************************************************************************************************** -->                        
                    <i class="fa fa-usd"></i>
                    <h1 id="costClient"></h1>
                    <div class="info">
                      <div class="row">
                          <h3 class="centered">COSTO TOTAL</h3>
                        <div class="col-sm-6 col-xs-6 pull-left">
                          <p class="goleft"></p>
                        </div>
                        <div class="col-sm-6 col-xs-6 pull-right">
                          <p class="goright"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
                }
              ?>
          	</div>	
            <!-- **********************************************************************************************************************************************************
              A TRAVÉS DE AJAX SE IMPRIME EL COSTO POR MES DE LA SUMA DE EVENTOS POR PROYECTO A PARTIR DEL ID DEL CLIENTE
            *********************************************************************************************************************************************************** -->                        
            <div id="morris">
                <div class="row mt">
                    <div class="col-lg-12">
                        <div class="content-panel">
                            <h4><i class="fa fa-angle-right"></i> Chart Example 2</h4>
                            <div class="panel-body">
                                <div id="monthsGraph" class="graph"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- **********************************************************************************************************************************************************
              A TRAVÉS DE AJAX SE IMPRIME LA LISTA DE PROYECTO A PARTIR DEL ID DEL C
            *********************************************************************************************************************************************************** -->                        
            <div class="row mt" id="listaCliente">
              <div class="col-lg-12">
                <div class="content-panel">
                    <table class="display" id="proyectsTableClient">
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
                            <th><i class=" fa fa-edit"></i> Status</th>              
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
                        <tbody id="listProyects">
                        <!-- **********************************************************************************************************************************************************
                        A TRAVÉS DE AJAX IMPRIME LA LISTA PROYECTOS POR CLIENTE
                        *********************************************************************************************************************************************************** -->                        
                        </tbody>
                    </table>                    
                    <div id="modalModify">
                      <!-- **********************************************************************************************************************************************************
                      MODAL PARA MODIFICAR DATOS DE UN PROYECTO
                      *********************************************************************************************************************************************************** -->                       
                    </div>
                </div><!-- /content-panel -->
              </div>
            </div>		
		      </section>
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->
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
  <?php
    include "includes/html/footer.php";
  ?>
  </section>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#proyectsTableClient').DataTable();
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
  <!-- Script para llamar las diferentes funciones AJAX que muestran la información del Cliente. -->
  <script src="assets/js/proyectsClient.js"></script>
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
  <script type="text/javascript">
    // función de JQuery que nos ayuda a mostrar mensaje de warning al momento que
    // el usuario haya seleccionado Status del proyecto "Entregado"
    $(document).ready(function() {    
      $('#status').change(function() {            
          var selectedValue = $(this).val();            
          if ( selectedValue == '3' ) {
              $('.mensajeF').fadeIn(1500);
              // $('.mensajeE').fadeOut(2500);
          } else if ( selectedValue != '3' ){
              $('.mensajeE').fadeIn(1500);
              // $('.mensajeF').fadeOut(2500);

          }            
      });
    });
  </script>
  <!--common script for all pages-->
  <script src="assets/js/common-scripts.js"></script>
  <!--common script for all pages-->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>

    <!--script for this page-->
    <!-- // <script src="assets/js/morris-conf.js"></script> -->
  <script type="text/javascript" id="costGraph">
    
  </script>
  <?php
    ob_end_flush();
  ?>
  </body>
</html>
