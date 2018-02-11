// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para eliminar marca que NO este vincula a un proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#quitarM").click(function(){
    // Obtenemos el valor del campo marca
    var marca = $("select#marcaNOproject").val();

    // Validamos el campo marca, que no este vacío.
    if (marca == "") {
      $("div#marcaError").fadeIn(1500);
      $("select#marcaNOproject").focus();
      $("div#marcaError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'marcaEliminar=' + marca;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha eliminado la marca: '+marca);
        updateListMarcaNOProject();
        updateMarcaSelect();
        $("select#marcaNOproject").val('');
        $("#quitarMarca").modal('hide');
      }        
    });
    return false;
  });
});
