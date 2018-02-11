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
        if ( $_POST['correo']==NULL || $_POST['nombre'] == NULL || $_POST['apellidoP'] == NULL || $_POST['tipoUsuario'] == NULL || $_POST['celula'] == NULL) {
          $errors[] ='<div class="alert alert-danger">Todos los campos con * deben ser llenados.</div>';
        }else if (!(trueMail($_POST['correo']))) {
          $errors[] ='<div class="alert alert-danger">Ingrese un correo válido.</div>';
        }else if(email_exists($_POST['correo']) === true){
          $errors[] = '<div class="alert alert-danger">Disculpe, el email \'' . $_POST['correo'] . '\' esta siendo usado.</div>';
        }else{

          mkdir("usuarios/userBamf/".$_POST['correo'], 0777);
          $url = "assets/img/USER.jpg";

          $register_data = array(
            'correoElectronico' => $_POST['correo'],
            'idtipoUsuario' => $_POST['tipoUsuario'],
            'nombre' => $_POST['nombre'],
            'apellidoP' => $_POST['apellidoP'],
            'apellidoM' => $_POST['apellidoM'],
            'foto' => $url,
            'activo' => 1
          );

          register($register_data, "usuario");

          if ($_POST['tipoUsuario'] === '3') {
            $rand = dechex(rand(0x000000, 0xFFFFFF));
            $colorUser = $rand;
            $register_data = array(
              'correoElectronico' => $_POST['correo'],
              'color' => $colorUser,
              'celula' => $_POST['celula']
            );

            register($register_data, "disenador");
          }elseif ($_POST['tipoUsuario'] === '5') {
            $rand = dechex(rand(0x000000, 0xFFFFFF));
            $colorUser = $rand;
            $register_data = array(
              'correoElectronico' => $_POST['correo'],
              'color' => $colorUser,
              'celula' => $_POST['celula']
            );

            register($register_data, "programador");
          }   

          $newPassword = generate_password();
          change_password($_POST['correo'], $newPassword);   

          $message = "<table>

                        <tr>

                          <th>Adhesión de registro en Sistema BAMF</th>

                        </tr>

                        <tr>

                          <td>

                            <p>Estimado/a Sr/a. ".$_POST['nombre']." ".$_POST['apellidoP']." ".$_POST['apellidoM'].":</p><br></p>

                            <p>Su contraseña para ingresar al sistema BAMF es la siguiente: <span style='color:blue;font-weight:bold; font-size: 1.1em;'>".$newPassword."</span> <a href='http://kistu.mx/' target='_blank'>Ingresar</a></p>

                            <p>Si tienes alguna duda o un problema, te pedimos nos contates vía correo electrónico a <a href='mailto:h.ramirez@bamf.com.mx?Subject=Pregunta' target='_top'>h.ramirez@bamf.com.mx</a></p>

                            <p>&iexcl;Bienvenido!</p>

                          </td>

                        </tr>";

          send_mail($message, "Registro Sistema BAMF", $_POST['correo']);

          header('Location: registerUser.php?exito');
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
          	<h3><i class="fa fa-angle-right"></i> Registro de Usuario</h3>
          	<div class="row mt">
          		<div class="col-lg-6">
          		  <div class="form-panel">
                  <?php
                  if (isset($_GET['exito']) && empty($_GET['exito'])) {?>
                    <div class="alert alert-success"><b>¡Genial!</b> Se ha agregado nuevo usuario al Sistema BAMF.</div>
                        <a href="index.php"><button type="button" class="btn btn-primary">Aceptar</button></a>
                    <?php
                      }else{?>
                  <h4 class="mb"><i class="fa fa-angle-right"></i> Usuario nuevo</h4>
                   <form class="form-horizontal style-form"  method="post" action="" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" name="correo"  required="required">
                        </div>
                        <label class="col-sm-2 col-sm-2 control-label">*Nombre(s)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="nombre" required="required" onkeypress="validate(event)">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">*Apellido Paterno</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="apellidoP" required="required" onkeypress="validate(event)">
                        </div>
                        <label class="col-sm-2 col-sm-2 control-label">Apellido Materno</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="apellidoM">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                      <!-- tipo de usuario -->
                        <label class="col-sm-2 col-sm-2 control-label">*Tipo de usuario</label>
                      <div class="col-sm-3">
                        <div class="radio">
                          <label>
                            <input type="radio" name="tipoUsuario" id="tipoUsuario1" value="3">
                            Diseñador
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="tipoUsuario" id="tipoUsuario2" value="5">
                            Programador
                          </label>
                        </div>
                      </div>           
                      <!-- Celula de produccion -->
                      <div class="col-sm-2 col-sm-offset-1 col-md-offset-0">
                        <label class="control-label">*Célula de producción</label>
                      </div>
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
                    <hr>
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
                  <?php
                      }
                    ?>
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
    include "includes/html/scripts.php";
    ob_end_flush();
  ?>
  </body>
</html>
