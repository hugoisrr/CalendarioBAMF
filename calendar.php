<?php

ob_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calendario y sistema de administrativo interno BAMF.">
    <meta name="author" content="Hugo Israel Ram�rez Soto">
    <meta name="keyword" content="BAMF, calendario, sistema, control, proyectos, equipo">

    <title>[BAMF] | Sistema de Control</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="shortcut icon" href="assets/img/bamf-star.png">
    <link rel="apple-touch-icon" href="assets/img/57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/114.png">
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- JQuery Google CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php
    include "core/init.php";
    if ($user_data['idtipoUsuario'] === "2") {
      jefe();
    }
    $email = $_GET['var'];
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
            <?php
              $result = userData($email);
              while ($row = mysql_fetch_array($result)) {
            ?>            
          	<h3><i class="fa fa-angle-right"></i> Calendario de Proyectos de <strong><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></strong> <img src="<?=$row['foto']?>" class="img-circle" width="45"></h3>
            <?php                           
               }           
            ?>
          	<div class="row mt">               
               <!-- **********************************************************************************************************************************************************
              CALENDAR CONTENT
              *********************************************************************************************************************************************************** -->
              <aside class="col-lg-12 mt">
                  <section class="panel">
                      <div class="panel-body">
                          <div id="calendar" class="has-toolbar"></div>
                      </div>
                  </section>
              </aside>
          	</div>			
		      </section>
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->
      <!-- **********************************************************************************************************************************************************
      NEW MODAL TO CREATE EVENT IN CALENDAR USING SELECT OF CLIENTS
      *********************************************************************************************************************************************************** -->
      <!-- Modal creates event starts -->
      <div id="createEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel1">Creaci�n de Evento</h3>
            </div>
            <div class="modal-body">
              <form class="form-horizontal style-form">
                <div class="form-group" id="errorClient">
                  <div class="col-sm-8">
                    <div class='alert alert-danger'>Seleccione un proyecto, por favor.</div>
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                  <input type="hidden" id="apptStartTime"/>
                  <input type="hidden" id="apptEndTime"/>
                  <input type="hidden" id="apptAllDay" />
                  <input type="hidden" id="correo" value="<?= $email ?>" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="when">Fecha y tiempo:</label>
                  <div class="controls controls-row" id="when" style="margin-top:5px;">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 col-sm-3 control-label" for="nombreCliente">*Escoja el cliente</label>
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
                <div class="form-group" id="projectsByClient">
                  <label class="col-sm-3 col-sm-3 control-label" for="projectList">*Lista de proyectos</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="projectList" id="projectList">
                      <option value="0"></option>                    
                      <!-- A trav�s de la funci�n AJAX muestra la lista de proyectos por cliente. -->
                    </select>
                  </div>
                </div>                
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="createEvent">Crear</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal creates event ends -->
      <!-- **********************************************************************************************************************************************************
      MODAL CREATE EVENT IN CALENDAR
      *********************************************************************************************************************************************************** -->
      <!-- Modal creates event starts 
      <div id="createEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel1">Creaci�n de Evento</h3>
            </div>
            <div class="modal-body">
              <form id="createAppointmentForm" class="form-horizontal">
                <div class="control-group">
                  <div class="controls">
                  <input type="hidden" id="apptStartTime"/>
                  <input type="hidden" id="apptEndTime"/>
                  <input type="hidden" id="apptAllDay" />
                  <input type="hidden" id="correo" value="<?= $email ?>" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="when">Fecha y tiempo:</label>
                  <div class="controls controls-row" id="when" style="margin-top:5px;">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="projectList">Proyectos:</label>
                  <div class="controls">
                      <?php
                        $result = proyectoCelula(0);
                        $num_rows = mysql_num_rows($result);
                        $result2 = proyectoCelula(1);
                        $num_rows2 = mysql_num_rows($result2);
                        if ($num_rows < 1 && $num_rows2 < 1){
                          echo "<div class='alert alert-danger'><b>�Oh diantres!</b> No hay proyectos creados.</div> ";
                        }else{?>
                          <select class="form-control" id="projectList">
                            <option value="0">--- Proyectos C�lula Consumo ---</option>
                        <?php
                          while ($row = mysql_fetch_array($result)) {
                        ?>                           
                            <option style="color: #<?=$row['colorProyecto']?>;" id="<?=$row['idProyecto']?>" value="<?=$row['idProyecto']?>"><?php echo nombreCliente($row['nombreCliente']); ?>-<?php echo marcaCliente($row['marcaCliente']); ?>-<?php echo nombreProyecto($row['nombreProyecto']);?>-<?php echo actividadProyecto($row['actividadProyecto']); ?></option>                            
                        <?php
                          }
                          ?>
                            <option value="0">--- Proyectos C�lula Corporativo ---</option>
                        <?php
                            while ($row = mysql_fetch_array($result2)) {
                          ?>
                            <option style="color: #<?=$row['colorProyecto']?>;" id="<?=$row['idProyecto']?>" value="<?=$row['idProyecto']?>"><?php echo nombreCliente($row['nombreCliente']); ?>-<?php echo marcaCliente($row['marcaCliente']); ?>-<?php echo nombreProyecto($row['nombreProyecto']);?>-<?php echo actividadProyecto($row['actividadProyecto']); ?></option>
                        <?php
                          }
                          ?>
                          </select>
                        <?php
                        }
                      ?>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="submitButton">Crear</button>
            </div>
          </div>
        </div>
      </div> -->
      <!-- Modal creates event ends -->
      <!-- **********************************************************************************************************************************************************
      SHOWS MODAL OF A CREATED EVENT IN CALENDAR
      *********************************************************************************************************************************************************** -->
      <!-- Modal Info Event starts -->
      <div id="calendarEventModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">�</span> <span class="sr-only">close</span></button>
                      <h4 id="modalTitle" class="modal-title"></h4>
                  </div>
                  <div id="modalBody" class="modal-body">
                    <input type="hidden" id="idEvent" />
                    <h4>Fecha y tiempo</h4>
                    <div class="controls controls-row" id="when" style="margin-top:5px; font-size: 16px;">
                    </div>
                    <h4>N�mero de Horas</h4>
                    <div class="controls controls-row" id="hoursEvent" style="margin-top:5px; font-size: 16px;">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-danger" id="deleteEvent">Eliminar Evento</button>
                      <a id="eventUrl" style="color: white;"><button class="btn btn-primary">Info-Proyecto</button></a>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal Info Event ends -->
  <?php
    include "includes/html/footer.php";
  ?>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/fullcalendar/fullcalendar.min.js"></script>  
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/fullcalendar/language/es-Es.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jqueryCustoms.js"></script>  

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!-- **********************************************************************************************************************************************************
    NECESSARY SCRIPTS FOR THE CORRECT FUNCTION OF BAMF CALENDAR
    *********************************************************************************************************************************************************** -->
    <!-- variable para llamar el calendario espec�fico de un miembro de una c�lula -->
    <script type="text/javascript">var email = "<?= $email ?>";</script>
    <!-- Se hacen llamar las funciones para la creaci�n de eventos y/o modificaci�n en el calendario -->
    <script src="assets/js/addEvent.js"></script> 
    <!-- Librer�a nos sirve para determinar la duraci�n de un evento -->
    <script src="assets/js/moment.js"></script>
    <!-- Funci�n AJAX para mostrar Select proyectos por Cliente -->
    <script src="assets/js/projectsByClient.js"></script>
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
    </script>
  <?php    
    ob_end_flush();
  ?>
  </body>
</html>
