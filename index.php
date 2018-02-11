<?php

ob_start();

?>
<!DOCTYPE html>
<html lang="es">
   <?php
    include "includes/html/head.php";
    include "core/init.php";
    logged_in_redirect();

    // Proceso del formulario de inicio de sessión

    if (isset($_POST['enviar'])) {
    	$email = $_POST['correo'];
    	$password = $_POST['password'];
    	//valida que tenga un usuario y contraseña
    	if (empty($email) === true || empty($password) === true){
			$errors[] = '<br><div class="alert alert-danger">Necesita ingresar un usuario y contraseña.</div>';
		}
		//valida que el usuario exista atraves de su correo 
		else if (email_exists($email) === false){
			$errors[] = '<br><div class="alert alert-danger">No pudimos encontrar su usuario. Necesita estar registrado en el sistema.</div>';
		}
		//si pasa las validaciones entra;
		else{
			//llama la funcion login para ver si los datos son correctos 
			$login = login($email,$password);
			//si los datos son falsos manda error
			if($login === false){
				$errors[] = '<br><div class="alert alert-danger">La contraseña es incorrecta.</div>';
			}
			// si son verdaderos checa el tipo de usuario que es y manda el index al que pertenece
			else{
				$_SESSION['correoElectronico'] = $login;
				user_type();
			}
		}
    }

    // Recuperación de contraseña

    if (isset($_POST['recuperar'])) {
    	$email = $_POST["emailRecu"];
    	if (empty($email) === true) {
    		$errorsModal[] = '<br><div class="alert alert-danger">Necesita ingresar un correo.</div>';
    	}
    	elseif (email_exists($email) === false) {
    		$errorsModal[] = '<br><div class="alert alert-danger">No pudimos encontrar su usuario. Necesita estar registrado en el sistema.</div>';
    	}
    	elseif (selectStatusActivo($email) === '0') {
    		$errorsModal[] = '<br><div class="alert alert-danger">¡Su registro no ha sido activado, consulte el admninistrador!.</div>';
    	}
    	else{
    		$newPassword = generate_password();
    		change_password($email,$newPassword);
    		$user_data = user_data($email, 'nombre', 'apellidoP', 'apellidoM');
    		$message = "<table>
							<tr>
								<th><h4>Recuperación de contraseña</h4></th>
							</tr>
							<tr>
								<td>
									<p>Estimado/a Sr/a. ".$user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'].":</p><br>
									<p>Su nueva contraseña es la siguiente: <span style='color:blue;font-weight:bold; font-size: 1.1em;'>".$newPassword."</span>  <a href='http://kistu.mx/index.php' target='_blank'>Ingresar</a></p>
									<p>Cualquier duda o aclaración, favor de contactar al siguiente correo: <a href='mailto:coordinacion@bamf.com.mx?Subject=Pregunta Sistema Kistu' target='_top'>coordinacion@bamf.com.mx</a></p>
								</td>
							</tr>";	
			send_mail($message,"Recuperacion de contrasena", $email);
			header('Location: index.php?exitoRecu');
			exit();
    	}
    }
  ?>
  <body onload="getTime()">

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" method="post" action="">
		        <h2 class="form-login-heading">sistema bamf</h2>
		        <div class="login-wrap">
		            <input type="email" name="correo" class="form-control" placeholder="Email" autofocus>
		            <br>
		            <input type="password" class="form-control" name="password" placeholder="Contraseña">
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> ¿Olvidaste tu contraseña?</a>
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" type="submit" name="enviar"><i class="fa fa-lock"></i> INGRESAR</button>
		            <?php
						if (empty($errors) === false) {
							//imprime los errores que encuentre del formulario
							echo output_errors($errors);
						}
					?>
		            <hr>		           		
		        </div>
		      </form>			
	  	</div>
	  </div>
	<!-- Modal Recuperación de contraseña -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
	  <div class="modal-dialog">
	      <div class="modal-content">
	      	<form method="post" action="">
	          <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	              <h4 class="modal-title">¿Olvidaste tu contraseña?</h4>
	          </div>
	          <?php
	          	if (isset($_GET['exitoRecu']) && empty($_GET['exitoRecu'])) {?>
	          		<div class="modal-body">
						<div class="alert alert-success">¡Se ha cambiado su contraseña, consulte su correo!.</div>
	                </div>		
	          <?php
	          	}
	          ?>
	          <div class="modal-body">
	              <p>Ingresa tu email para poder resetear tu contraseña.</p>
	              <input type="text" name="emailRecu" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

	          </div>
	          <?php
					if (empty($errorsModal) === false) {
						//imprime los errores que encuentre del formulario
						echo output_errors($errorsModal);
					}
				?>
	          <div class="modal-footer">
	              <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
	              <button class="btn btn-theme" type="submit" name="recuperar">Enviar</button>
	          </div>
	         </form>
	      </div>
	  </div>
	</div>
	<!-- Modal Recuperación de contraseña -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login_BAMF3.png", {speed: 500});
    </script>

    <?php

    	ob_end_flush();
    	
    ?>
  </body>
</html>
