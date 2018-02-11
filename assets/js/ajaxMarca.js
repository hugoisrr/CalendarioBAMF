// Ajax para agregar marca
$(document).ready(function() {
  $('.error').hide();
  $("#agregarM").click(function(){
    // Obtenemos el valor del campo Cliente
    var marca = $("input#marca").val();

    // Validamos el campo marca, que no este vacío.
    if (marca == "") {
      $("div#marcaError").fadeIn(1500);
      $("input#marca").focus();
      $("div#marcaError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'marca=' + marca;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha insertado: '+marca);
        updateListMarcaNOProject();
        updateMarcaSelect();
        $("input#marca").val('');
        $("#agregarMarca").modal('hide');
      }        
    });
    return false;
  });
});
