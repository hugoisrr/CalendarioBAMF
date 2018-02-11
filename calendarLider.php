<?php

ob_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calendario y sistema de administrativo interno BAMF.">
    <meta name="author" content="Hugo Israel Ramírez Soto">
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
      SHOWS MODAL OF A CREATED EVENT IN CALENDAR
      *********************************************************************************************************************************************************** -->
      <!-- Modal starts -->
      <div id="calendarEventModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                      <h4 id="modalTitle" class="modal-title"></h4>
                  </div>
                  <div id="modalBody" class="modal-body">
                    <input type="hidden" id="idEvent" />
                    <h4>Fecha y tiempo</h4>
                    <div class="controls controls-row" id="when" style="margin-top:5px; font-size: 16px;">
                    </div>
                    <h4>Número de Horas</h4>
                    <div class="controls controls-row" id="hoursEvent" style="margin-top:5px; font-size: 16px;">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <a id="eventUrl" style="color: white;"><button class="btn btn-primary">Info-Proyecto</button></a>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal ends -->
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

    <!--scripts for this page-->
    <!-- variable para llamar el calendario específico de un miembro de una célula -->
    <script type="text/javascript">var email = "<?= $email ?>";</script>
    <!-- Se hacen llamar las funciones para la creación de eventos y/o modificación en el calendario -->
    <script src="assets/js/eventsLider.js"></script> 
    <!-- Librería nos sirve para determinar la duración de un evento -->
    <script src="assets/js/moment.js"></script>
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
