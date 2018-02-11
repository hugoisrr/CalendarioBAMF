// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para agregar cliente
$(document).ready(function() {
  $('.error').hide();
  $("#agregarC").click(function(){
    // Obtenemos el valor del campo Cliente
    var cliente = ($("input#cliente").val()).toUpperCase();

    // Validamos el campo cliente, que no este vacío.
    if (cliente == "") {
      $("div#clienteError").fadeIn(1500);
      $("input#cliente").focus();
      $("div#clienteError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'cliente=' + cliente;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha insertado: '+cliente);
        updateListClientsNOProject();
        updateClienteSelect();
        $("input#cliente").val('');
        $("#agregarCliente").modal('hide');
      }        
    });
    return false;
  });
});
