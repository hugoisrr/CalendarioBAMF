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
    }elseif ($user_data['idtipoUsuario'] === "3") {
      disenador();
    }elseif ($user_data['idtipoUsuario'] === "5") {
      programador();
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
          <section class="wrapper site-min-height" style="padding: 0px;">
          	<!-- <h3><i class="fa fa-angle-right"></i> ¡Bienvenid@!</h3> -->
            <iframe src="http://kistu.mx/wp/" style="width: 100%; height: 900px;">
              <p>Your browser does not support iframes.</p>
            </iframe>			
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
