// Ajax para agregar proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#agregarP").click(function(){
    // Obtenemos el valor del campo Cliente
    var proyectoCal = $("input#proyectoCal").val();

    // Validamos el campo proyectoCal, que no este vacío.
    if (proyectoCal == "") {
      $("div#proyectoError").fadeIn(1500);
      $("input#proyectoCal").focus();
      $("div#proyectoError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'proyectoCal=' + proyectoCal;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha insertado: '+proyectoCal);
        updateListProjectNOProject();
        updateProyectoSelect();
        $("input#proyectoCal").val('');
        $("#agregarProyecto").modal('hide');
      }        
    });
    return false;
  });
});
