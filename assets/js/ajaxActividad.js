// Ajax para agregar actividad
$(document).ready(function() {
  $('.error').hide();
  $("#agregarA").click(function(){
    // Obtenemos el valor del campo Actividad
    var actividad = $("input#actividad").val();

    // Validamos el campo actividad, que no este vacío.
    if (actividad == "") {
      $("div#actividadError").fadeIn(1500);
      $("input#actividad").focus();
      $("div#actividadError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'actividad=' + actividad;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha insertado: '+actividad);        
        updateListActivityNOProject();
        updateActivitySelect();
        $("input#actividad").val('');
        $("#agregarActividad").modal('hide');
      }        
    });
    return false;
  });
});