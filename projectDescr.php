<?php

ob_start();
$idProyecto = $_GET['var'];
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
    if (isset($_POST['cambiar'])) {
      if (empty($errors) === true) {
        if ($_POST['status'] === '3' && $_POST['fechaEntregado'] == NULL) {
          $errors[] ='
          <div class="row mt">
            <div class="col-lg-8">
              <div class="form-group">
                <div class="alert alert-danger col-sm-6 col-sm-6 control-label" id="quitar">Si el estatus del Proyecto es <strong>Entregado</strong> indiqué la fecha de entregado.</div>
              </div>
            </div>
          </div>';
        }elseif ($_POST['status'] !== '3' && $_POST['fechaEntregado'] != NULL) {
          $idProyecto = $_POST['idProyecto'];     
          $proyecto = $_POST['proyecto'];
          $idActividad = $_POST['actividad'];
          $tipoProyecto = $_POST['tipoProyecto'];
          $celula = $_POST['celula'];
          $liderProyecto = $_POST['liderProyecto'];
          $etapa = $_POST['etapa'];
          $status = $_POST['status'];     
          $descripcion = $_POST['descripcion'];
          $fechaEntregado = " ";          

          modifyProjectInfo($idProyecto,$proyecto,$idActividad,$tipoProyecto,$celula,$liderProyecto,$status,$fechaEntregado,$descripcion);
          header('Location: projectDescr.php?&var='.$idProyecto);
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
          header('Location: projectDescr.php?&var='.$idProyecto);
          exit();
        }
      }           
    }
    $project_data = project_data($idProyecto, 'idProyecto', 'nombreProyecto', 'actividadProyecto', 'tipoProyecto', 'colorProyecto', 'nombreCliente', 'marcaCliente', 'idEtapa', 'descripcion', 'fechaProyecto', 'celula', 'liderProyecto', 'status', 'fechaEntregado', 'horasTrabajadas', 'costoTotal');    
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
          	<h3><i class="fa fa-angle-right"></i> Proyecto <strong><font color="<?php echo $project_data['colorProyecto']?>"><?php echo nombreCliente($project_data['nombreCliente']);?>-<?php echo marcaCliente($project_data['marcaCliente']); ?>-<?php echo nombreProyecto($project_data['nombreProyecto']); ?></font></strong></h3>
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
                <div class="content-panel">      	
                  <table class="table table-striped table-advance table-hover">
                    <h4><i class="fa fa-angle-right"></i> Detalles del proyecto<?php 
                      if ($user_data['idtipoUsuario'] === "2" || $user_data['idtipoUsuario'] === "1"){?>
                        <button class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editar<?=$idProyecto?>"><i class="fa fa-pencil"></i></button>
                    <?php
                      }
                    ?></h4>
                    <hr>
                      <tbody>
                      <tr>
                          <th><i class="fa fa-question-circle"></i> Categoría de Proyeto</th>
                          <td><?php echo typeProject($project_data['tipoProyecto']) ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-user"></i> Cliente</th>
                          <td><?php echo nombreCliente($project_data['nombreCliente']); ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-hand-paper-o"></i> Actividad</th>
                          <td><?php echo actividadProyecto($project_data['actividadProyecto']); ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-calendar-plus-o"></i> Fecha Creación</th>
                          <td><?php echo dateProject($idProyecto); ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-tasks"></i> Etapa</th>
                          <td><?php 
                                  if ($project_data['idEtapa'] === '1') {
                                    echo "<span class='label label-info label-mini'>".stageProject($project_data['idEtapa'])."</span>";      
                                  }elseif ($project_data['idEtapa'] === '2') {
                                    echo "<span class='label label-warning label-mini'>".stageProject($project_data['idEtapa'])."</span>";      
                                  }elseif ($project_data['idEtapa'] === '3') {
                                    echo "<span class='label label-success label-mini'>".stageProject($project_data['idEtapa'])."</span>";      
                                  }
                               ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-users"></i> Célula</th>
                          <td><?php
                                if ($project_data['celula']  === '0') {
                                  echo "Consumo";
                                }elseif ($project_data['celula'] === '1') {
                                  echo "Corporativo";
                                }
                              ?>
                          </td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-star"></i> Líder del Proyecto</th>
                          <td><a href="mailto:<?php echo $project_data['liderProyecto'] ?>"> <?php $result2 = userData($project_data['liderProyecto']); 
                                while ($row2 = mysql_fetch_array($result2)) {
                                  echo $row2['nombre'].' '.$row2['apellidoP'].' '.$row2['apellidoM'];
                                }
                              ?></a>
                          </td>
                      </tr>
                      <tr>
                          <th><i class=" fa fa-edit"></i> Status</th>
                          <td><?php
                                  if ($project_data['status'] === '0') {
                                    echo "<span class='label label-warning label-mini'>No activo</span>";
                                  }
                                  elseif ($project_data['status'] === '1') {
                                    echo "<span class='label label-info label-mini'>Activo</span>";
                                  }
                                  elseif ($project_data['status'] === '2') {
                                    echo "<span class='label label-danger label-mini'>Suspendido</span>";
                                  }
                                  elseif ($project_data['status'] === '3') {
                                    echo "<span class='label label-success label-mini'>Entregado</span>";
                                  }
                              ?>
                          </td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-calendar-check-o"></i> Fecha de Entrega</th>
                          <td><?php 
                          if ($project_data['fechaEntregado'] === NULL) {
                            echo "--";
                          }else{
                            echo $project_data['fechaEntregado'];
                          } ?></td>
                      </tr>
                      <tr>
                          <th><i class="fa fa-hourglass-end"></i> Horas Trabajadas</th>
                          <td><?php echo $project_data['horasTrabajadas'] ?> hrs.</td>
                      </tr>
                      <?php
                        if ($user_data['idtipoUsuario'] === "2") {?>
                      <tr>
                          <th><i class="fa fa-usd"></i> Costo Total</th>
                          <td><?php 
                          if ($project_data['costoTotal'] === NULL) {
                            echo "--";
                          }else{
                            echo '$'.number_format($project_data['costoTotal'],2);
                          } ?></td>
                      </tr>
                      <?php                          
                        }
                        ?>
                      </tbody>
                  </table>
                </div>
          		</div>
              <div class="col-lg-3 ds">
                <!-- USERS ONLINE SECTION -->
            <h3>MIEMBROS</h3>
              <?php
                $result = projectMembers($idProyecto);
                $num_rows = mysql_num_rows($result);
                if ($num_rows < 1) {
                  echo "<div class='alert alert-danger'><b>¡Oh diantres!</b> No hay miembros asignados a este proyecto.</div> ";
                }else{
                  while ($row = mysql_fetch_array($result)) {?>
                    <div class="desc">
                      <div class="thumb">
                        <?php
                          $result2 = userData($row['correoElectronico']); 
                          while ($row2 = mysql_fetch_array($result2)) {
                        ?>
                        <img class="img-circle" src="<?=$row2['foto']?>" width="35px" height="35px" align="">
                      </div>
                      <div class="details">
                        <p><a href="mailto:<?=$row['correoElectronico']?>" style="color: #9932CC;"><?=$row2['nombre']?> <?=$row2['apellidoP']?> <?=$row2['apellidoM']?></a><br/>
                           <!-- <muted>Available</muted> -->
                        <?php
                          }
                        ?>
                        </p>
                      </div>
                    </div>
                <?php
                  }                
                }
                  ?>             
              </div>
          	</div>	
            <h3><i class="fa fa-angle-right"></i> Gráficas</h3>
              <!-- page start-->
              <div id="morris">
                  <div class="row mt">
                      <div class="col-lg-6">
                          <div class="content-panel">
                              <h4><i class="fa fa-angle-right"></i> Horas por Miembro</h4>
                              <div class="panel-body">
                                  <div id="hero-donut" class="graph">                                    
                                    <?php
                                      $result = projectMembers($idProyecto);
                                      $num_rows = mysql_num_rows($result);
                                      if ($num_rows < 1) {
                                        echo "<div class='alert alert-danger'><b>¡Oh diantres!</b> No hay miembros asignados a este proyecto.</div> ";
                                      }else{?>
                                        <script type="text/javascript">
                                        var Script = function () {

                                        //morris chart

                                        $(function () {      

                                              Morris.Donut({
                                                element: 'hero-donut',
                                                data: [
                                        <?php
                                        $cont = 0;
                                        while ($row = mysql_fetch_array($result)) {
                                          $cont = $cont + 1;
                                          $result2 = hoursWorkerProject($idProyecto, $row['correoElectronico']);
                                          $horas = 0;
                                          while ($row2 = mysql_fetch_array($result2)) {
                                            $horas = $horas + $row2['horas'];
                                          }
                                          $user_data = user_data($row['correoElectronico'], 'correoElectronico', 'idtipoUsuario', 'nombre');
                                          // echo "correo: ".$user_data['correoElectronico']." tipo: ".$user_data['idtipoUsuario']." nombre: ".$user_data['nombre']." color: ".colorDisenador($user_data['correoElectronico'])." horas: ".$horas."<br>";
                                          if ($cont < $num_rows) {
                                            echo "{label: '".$user_data['nombre']."', value: ".$horas." },";
                                          }elseif ($cont == $num_rows) {
                                            echo "{label: '".$user_data['nombre']."', value: ".$horas." }";
                                          };
                                        }//cierra while?>
                                        ],
                                              colors: [
                                              <?php
                                              $cont = 0;
                                              $result = projectMembers($idProyecto);
                                              while ($row = mysql_fetch_array($result)) {
                                                $cont = $cont + 1;
                                                $user_data = user_data($row['correoElectronico'], 'correoElectronico', 'idtipoUsuario', 'nombre');
                                                if ($cont < $num_rows && $user_data['idtipoUsuario'] == 3) {
                                                  echo "'#".colorDisenador($user_data['correoElectronico'])."', ";
                                                }elseif ($cont < $num_rows && $user_data['idtipoUsuario'] == 5) {
                                                  echo "'#".colorProgramador($user_data['correoElectronico'])."', ";
                                                }elseif ($cont == $num_rows && $user_data['idtipoUsuario'] == 3) {
                                                  echo "'#".colorDisenador($user_data['correoElectronico'])."'";
                                                }elseif ($cont == $num_rows && $user_data['idtipoUsuario'] == 5) {
                                                  echo "'#".colorProgramador($user_data['correoElectronico'])."'";
                                                }
                                              }
                                              ?>],
                                              formatter: function (y) { return y + "hrs" }
                                            });

                                            $('.code-example').each(function (index, el) {
                                              eval($(el).text());
                                            });
                                          });

                                      }();
                                    </script>
                                      <?php
                                      }//cierra else
                                    ?>                                   
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-5">    
                        <div class="content-panel">
                          <h4><i class="fa fa-angle-right"></i> Descripción</h4>
                          <hr>
                          <p style="margin: 15px;"><font size="3"><?php echo $project_data['descripcion'];?></font></p>
                        </div>
                      </div>                      
                  </div>
                  <div class="row mt">
                    <div class="col-lg-6">
                      <div class="content-panel">
                        <h4><i class="fa fa-angle-right"></i> Horas por Etapa</h4>
                        <div class="panel-body">
                          <div id="stages-donut" class="graph">
                            <?php
                              $result = projectStagesEtapa($idProyecto);
                              $num_rows = mysql_num_rows($result);                              
                              if ($num_rows < 1) {
                                echo "<div class='alert alert-danger'><b>¡Oh diantres!</b> No hay eventos asignados a este proyecto.</div> ";
                              }else{?>
                                <script type="text/javascript">
                                var Script = function () {

                                //morris chart

                                $(function () {      

                                      Morris.Donut({
                                        element: 'stages-donut',
                                        data: [
                                <?php
                                $cont = 0;                                
                                while ($row = mysql_fetch_array($result)) {
                                  $cont = $cont + 1;
                                  $result2 = hoursStageProject($idProyecto, $row['idEtapa']);
                                  $horas = 0;
                                  while ($row2 = mysql_fetch_array($result2)) {
                                    $horas = $horas + $row2['horas'];
                                  }
                                  // $user_data = user_data($row['correoElectronico'], 'correoElectronico', 'idtipoUsuario', 'nombre');
                                  // echo "correo: ".$user_data['correoElectronico']." tipo: ".$user_data['idtipoUsuario']." nombre: ".$user_data['nombre']." color: ".colorDisenador($user_data['correoElectronico'])." horas: ".$horas."<br>";
                                  if ($cont < $num_rows) {                                    
                                    echo "{label: '".stageProject($row['idEtapa'])."', value: ".$horas." },";
                                  }elseif ($cont == $num_rows) {
                                    echo "{label: '".stageProject($row['idEtapa'])."', value: ".$horas." }";
                                  };
                                }//cierra while?>
                                ],
                                      colors: ['#3498db', '#2980b9', '#34495e'],
                                      formatter: function (y) { return y + "hrs" }
                                    });

                                    $('.code-example').each(function (index, el) {
                                      eval($(el).text());
                                    });
                                  });

                              }();
                            </script>
                              <?php
                              }//cierra else
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
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
      include "includes/modals/modifyDataProjectDescrip.php";
    ?>
    <!-- **********************************************************************************************************************************************************
    LISTA DE MODALS PARA AGREGAR INFORMACIÓN A LA BD Y A SU VEZ AL PROYECTO
    *********************************************************************************************************************************************************** -->       
    <?php
      include "includes/modals/addProject.php";
      include "includes/modals/addActivity.php";
      include "includes/modals/addTypeProject.php";
    ?> 
    <!-- js placed at the end of the document so the pages load faster -->
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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <!-- <script src="assets/js/jqueryCustoms.js"></script> -->

    <!--script for this page-->
    <!-- // <script src="assets/js/graph-conf.js"></script> -->

    <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

    </script>
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
    ob_end_flush();
  ?>
  </body>
</html>
