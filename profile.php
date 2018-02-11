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
    if (isset($_POST['enviar'])) {
      if (empty($errors) === true) {
        if($_POST['nombre']==NULL  || $_POST['apellidoP']==NULL ) {
          $errors[] ='<div class="alert alert-danger">Todos los campos con * deben ser llenados.</div>'; 
        }else{

          if($_FILES["fotos"]["name"] == NULL){

            $url=$user_data['foto'];

            $errorfoto=0;

          }

          else {

            $namefile = $_FILES["fotos"]["name"];

            $temporary = $_FILES["fotos"]["tmp_name"];

            $tam = $_FILES['fotos']['size'];

            //obtiene la extencion del archivo

            $extension=extension($namefile);

            // guarda en un arreglo las extenciones que permitiran subir

            $ext = array ("gif","png","jpg" ,"jpeg","PNG","GIF","JPG","JPEG");

            //renombramos el archivo subido

            $foto='/fotoDe'.$user_data['nombre'].'.'.$extension;

            //direccion donde se guardara el archivo

            $newUrl = "usuarios/admin".$foto;   

            if (is_uploaded_file($temporary) ){ 

              //compara la extencion del documento con las que permitimos 

              if(($tam <= 5000000) && in_array($extension,$ext) ){

                // copIa el documento temporal a la carpeta del usuario

                copy($temporary,$newUrl);

                $url = $newUrl;

                $errorfoto=0;

              }

              else{

                  $errors[] = '<div class="alert alert-danger">El tamaño o la extension de la imagen no son correctas (5 megas o extención jpg, png, gif) </div>';

                $errorfoto=1;

              }

            }

            else{

            $errors[] =  '<div class="alert alert-danger">Cambie el nombre de la imagen. <br>El tamaño o la extension de la imagen no son correctas (5 megas como maximo o extención jpg, png, gif) </div>';

                $errorfoto=1;

            }

          }

          if($errorfoto===0){ 

            modify_data($user_data['correoElectronico'],$_POST['nombre'],$_POST['apellidoP'],$_POST['apellidoM'],$url);

            header('Location: profile.php?exito');

            exit();

          } 

        }
      }
    }
    // Formulario de cambio de contraseña
    if (isset($_POST['cambiar'])) {
      if (empty($errors) === true) {
          //comprueba que los todos los campos esten llenados
        if($_POST['contra']==NULL || $_POST['actual']==NULL || $_POST['confir']==NULL) {
          $errors[] ='<div class="alert alert-danger">Todos los campos con * deben ser llenados.</div>'; 
        }   
        //comprueba que el correo sea válido
        else if (md5 ($_POST['actual'])!== $user_data['contrasena']) {
          $errors[] ='<div class="alert alert-danger">&iexcl;La contraseña actual es incorrecta!</div';
        }
        //comprueba que la contrase??ea del tama??olicitado.
        else if(strlen($_POST['contra']) < 8){
          $errors[] = '<div class="alert alert-danger">Su contraseña debe tener al menos 8 caracteres.</div>';
        }
        //comprueba que las contrase??coincidan
        else if($_POST['contra'] !== $_POST['confir']){
          $errors[] = '<div class="alert alert-danger">La nueva contraseña no coincide.</div>';
        }
        else{
          //si pasa las pruebas de seguridad entra
          change_password($user_data['correoElectronico'],$_POST['contra']);
          header('Location: profile.php?exitoContra');
          exit();
        }
      }
    }
  ?>
  <body onload="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">
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
          	<h3><i class="fa fa-angle-right"></i> Modificación de Perfil Administrador</h3>
          	<div class="row mt">
              <div class="col-lg-6">
                  <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Perfil</h4>
                      <?php
                      if (isset($_GET['exito']) && empty($_GET['exito'])){?>
                        <div class="alert alert-success"><b>¡Genial!</b> Se han modificado sus datos de perfil.</div>
                        <a href="index.php"><button type="button" class="btn btn-primary">Aceptar</button></a>
                      <?php
                        }else{?>
                        <form class="form-horizontal style-form"  method="post" action="" ENCTYPE="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">*Nombre(s)</label>
                                <div class="col-sm-10">
                                    <input type="text" id="disabledInput" class="form-control" value='<?php echo $user_data['nombre'];?>' placeholder='<?php echo $user_data['nombre'];?>' name="nombre"  required="required" onkeypress="validate(event)" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">*Apellido Paterno</label>
                                <div class="col-sm-10">
                                    <input type="text" id="disabledInput" class="form-control" value='<?php echo $user_data['apellidoP'];?>' placeholder='<?php echo $user_data['apellidoP'];?>' name="apellidoP" required="required" onkeypress="validate(event)" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Apellido Materno</label>
                                <div class="col-sm-10">
                                    <input type="text" id="disabledInput" class="form-control" value='<?php echo $user_data['apellidoM'];?>'  placeholder='<?php echo $user_data['apellidoM'];?>' name="apellidoM" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Foto</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" value='<?php echo $user_data['apellidoM'];?>' name="fotos">
                                    <span class="help-block">Es recomendable usar una imagen de 128 x 128 pixeles.</span>
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
                                <button type="submit" name="enviar" class="btn btn-primary">Modificar</button>
                              </div>                            
                            </div>
                        </form>		
                      <?php
                        }
                      ?>	
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Cambio de Contraseña</h4>
                      <?php
                        if (isset($_GET['exitoContra']) && empty($_GET['exitoContra'])){?>
                          <div class="alert alert-success"><b>¡Genial!</b> Se han cambiado su contraseña.</div>
                          <a href="index.php"><button type="button" class="btn btn-primary">Aceptar</button></a>
                        <?php
                          }else{?>                
                      <form class="form-horizontal style-form"  method="post" action="" ENCTYPE="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Contraseña actual</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="actual"  required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Nueva contraseña</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="contra" placeholder="(mínimo 8 caracteres)" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">*Confirmar contraseña</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confir" placeholder="(mínimo 8 caracteres)" required="required">
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
                            <button type="submit" name="cambiar" class="btn btn-primary">Cambiar</button>
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
