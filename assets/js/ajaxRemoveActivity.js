// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para eliminar actividad que NO este vìnculado a un proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#quitarA").click(function(){
    // Obtenemos el valor del campo actividad
    var actividad = $("select#activityNOproject").val();

    // Validamos el campo actividad, que no este vacío.
    if (actividad == "") {
      $("div#actividadError").fadeIn(1500);
      $("select#activityNOproject").focus();
      $("div#actividadError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'actividadEliminar=' + actividad;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha eliminado la actividad: '+actividad);
        updateListActivityNOProject();
        updateActivitySelect();
        $("select#activityNOproject").val('');
        $("#quitarActividad").modal('hide');
      }        
    });
    return false;
  });
});
