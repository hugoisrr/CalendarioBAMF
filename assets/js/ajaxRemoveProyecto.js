// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para eliminar proyecto que NO este vìnculado a un proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#quitarP").click(function(){
    // Obtenemos el valor del campo proyecto
    var proyecto = $("select#projectNOproject").val();

    // Validamos el campo proyecto, que no este vacío.
    if (proyecto == "") {
      $("div#proyectoError").fadeIn(1500);
      $("select#projectNOproject").focus();
      $("div#proyectoError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'proyectoEliminar=' + proyecto;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha eliminado el proyecto: '+proyecto);
        updateListProjectNOProject();
        updateProyectoSelect();
        $("select#projectNOproject").val('');
        $("#quitarProyecto").modal('hide');
      }        
    });
    return false;
  });
});
