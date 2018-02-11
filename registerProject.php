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
    if (isset($_POST['crear'])) {
      if (empty($errors) === true) {
        if ( $_POST['nombreCliente'] == NULL || $_POST['proyecto'] == NULL || $_POST['actividad'] == NULL || $_POST['tipoProyecto'] == NULL || $_POST['liderProyecto'] == NULL || $_POST['celula'] == NULL || $_POST['etapa'] == NULL) {
          $errors[] ='<div class="alert alert-danger col-sm-6 col-sm-6 control-label" id="quitar">Todos los campos con * deben ser llenados.</div>';
        }else{
          $rand = dechex(rand(0x000000, 0xFFFFFF));
          $colorProject = $rand;

          $register_data = array(
            'nombreProyecto' => $_POST['proyecto'],
            'actividadProyecto' => $_POST['actividad'],
            'tipoProyecto' => $_POST['tipoProyecto'],
            'colorProyecto' => $colorProject,
            'nombreCliente' => $_POST['nombreCliente'],
            'marcaCliente' => $_POST['marca'],
            'idEtapa' => $_POST['etapa'],
            'celula' => $_POST['celula'],
            'liderProyecto' => $_POST['liderProyecto'],
            'descripcion' => $_POST['descripcion']
          );

          register($register_data, "proyecto");
  
          header('Location: registerProject.php?exito');
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
      <script>
          // función que válida los inputs para NO insertar carácteres latinos.
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
      <section id="main-content">
          <section class="wrapper site-min-height">
            <h3><i class="fa fa-angle-right"></i> Registro de Proyecto</h3>            
                  <?php
                  if (isset($_GET['exito']) && empty($_GET['exito'])) {?>
                    <div class="row mt">
                      <div class="col-lg-8">
                        <div class="form-group">
                          <div class="alert alert-success col-sm-8 col-sm-8 control-label" id="quitar"><b>¡Genial!</b> Se ha agregado un nuevo Proyecto al Sistema BAMF.</div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-8">
                          <a href="registerProject.php"><button type="button" class="btn btn-primary">Nuevo Proyecto</button></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      }else{?>
            <div class="row mt">
              <div class="col-lg-8">
                <div class="form-panel">
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Proyecto nuevo</h4>
                   <form class="form-horizontal style-form"  method="post" action="" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Nombre del cliente</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="nombreCliente" id="nombreCliente">
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
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#agregarCliente">
                          <img src="assets/img/add.png">
                        </a>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#quitarCliente">
                          <img src="assets/img/minus.png">
                        </a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">Marca o Departamento</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="marca" id="marca">
                          <?php
                            $result = marcasClients();
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idMarcaCliente']?>"><?=$row['marcaCliente']?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#agregarMarca">
                          <img src="assets/img/add.png">
                        </a>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#quitarMarca">
                          <img src="assets/img/minus.png">
                        </a>
                      </div>
                    </div>  
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Proyecto</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="proyecto" id="proyecto">
                          <?php
                            $result = nameProjects();
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idNombreProyecto']?>"><?=$row['nombreProyecto']?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div> 
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#agregarProyecto">
                          <img src="assets/img/add.png">
                        </a>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#quitarProyecto">
                          <img src="assets/img/minus.png">
                        </a>
                      </div> 
                    </div> 
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Actividad</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="actividad" id="actividad">
                          <?php
                            $result = activitiesClients();
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idActividadProyecto']?>"><?=$row['actividadProyecto']?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div> 
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#agregarActividad">
                          <img src="assets/img/add.png">
                        </a>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#quitarActividad">
                          <img src="assets/img/minus.png">
                        </a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Categoría de Proyecto</label>                        
                      <div class="col-sm-4">
                          <select class="form-control" name="tipoProyecto" id="tipoProyecto">
                            <?php
                              $result = typesPojects();
                              while ($row = mysql_fetch_array($result)) {
                            ?>
                            <option value="<?=$row['idTipoProyecto']?>"><?=$row['tipoProyecto']?></option>
                            <?php
                              }
                            ?>
                          </select>                            
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#agregarCategoria">
                          <img src="assets/img/add.png">
                        </a>
                      </div>
                      <div class="col-sm-1">
                        <a href="#" data-toggle="modal" data-target="#quitarCategoria">
                          <img src="assets/img/minus.png">
                        </a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Etapa</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="etapa" id="etapa">
                          <?php
                            $result = projectStages();
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idEtapa']?>"><?=$row['etapa']?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">*Líder de Proyecto</label>
                      <div class="col-sm-4">
                          <select class="form-control" name="liderProyecto">
                            <?php
                              $result = usersBAMF();
                              while ($row = mysql_fetch_array($result)) {
                            ?>
                            <option value="<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></option>
                            <?php
                              }
                            ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">        
                      <label class="col-sm-3 col-sm-3 control-label">*Célula de producción</label>
                      <div class="col-sm-2">
                        <div class="radio">
                          <label>
                            <input type="radio" name="celula" id="celula1" value="0">
                            Consumo
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="celula" id="celula2" value="1">
                            Corporativo
                          </label>
                        </div>                        
                      </div>                                    
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 col-sm-3 control-label">Descripción</label>
                      <div class="col-sm-5">
                        <textarea class="form-control" row="4" name="descripcion"></textarea>
                      </div>
                    </div>
                      <?php
                        if (empty($errors) === false) {
                          //imprime los errores que encuentre del formulario
                          echo "<div class='form-group'>";
                          echo output_errors($errors);
                          echo "</div>";
                        }
                      ?>
                    <div class="form-group">
                      <div class="col-sm-8">
                        <button type="reset" class="btn btn-warning">Borrar</button>
                        <button type="submit" name="crear" class="btn btn-primary">Crear</button>
                      </div>                            
                    </div>                    
                  </form>
                </div>
              </div>
            </div>
            <?php
                }
              ?>                      
          </section>
      </section><!-- /MAIN CONTENT --> 
<!-- **********************************************************************************************************************************************************
LISTA DE MODALS PARA AGREGAR INFORMACIÓN A LA BD Y A SU VEZ AL PROYECTO
*********************************************************************************************************************************************************** -->

<?php
  include "includes/modals/addClient.php";
  include "includes/modals/removeClient.php";
  include "includes/modals/addBrand.php";
  include "includes/modals/removeMarca.php";
  include "includes/modals/addProject.php";
  include "includes/modals/removeProject.php";
  include "includes/modals/addActivity.php";
  include "includes/modals/removeActivity.php";
  include "includes/modals/addTypeProject.php";
  include "includes/modals/removeCategory.php";
  include "includes/html/footer.php";
?>
  </section>
  <script type="text/javascript" src="assets/js/ajaxCliente.js"></script>
  <script type="text/javascript" src="assets/js/ajaxMarca.js"></script>
  <script type="text/javascript" src="assets/js/ajaxProyecto.js"></script>
  <script type="text/javascript" src="assets/js/ajaxActividad.js"></script>
  <script type="text/javascript" src="assets/js/ajaxTipo.js"></script>
  <script type="text/javascript" src="assets/js/ajaxRemoveClient.js"></script>
  <script type="text/javascript" src="assets/js/ajaxRemoveMarca.js"></script>
  <script type="text/javascript" src="assets/js/ajaxRemoveProyecto.js"></script>
  <script type="text/javascript" src="assets/js/ajaxRemoveActivity.js"></script>
  <script type="text/javascript" src="assets/js/ajaxRemoveCategory.js"></script>
  <script type="text/javascript" src="assets/js/ajaxUpdateSelect.js"></script>
  <?php
    include "includes/html/scripts.php";
    ob_end_flush();
  ?>
  </body>
</html>
