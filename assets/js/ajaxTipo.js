// Ajax para agregar categoría
$(document).ready(function() {
  $('.error').hide();
  $("#agregarTipo").click(function(){
    // Obtenemos el valor del campo tipo
    var tipo = $("input#tipo").val();

    // Validamos el campo tipo, que no este vacío.
    if (tipo == "") {
      $("div#tipoProyeError").fadeIn(1500);
      $("input#tipo").focus();
      $("div#tipoProyeError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'tipo=' + tipo;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha insertado: '+tipo);
        updateListCategoryNOProject();
        updateCategorySelect();
        $("input#tipo").val('');
        $("#agregarCategoria").modal('hide');
      }        
    });
    return false;
  });
});
