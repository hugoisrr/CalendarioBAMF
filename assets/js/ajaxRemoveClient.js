// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para eliminar cliente que NO este vincula a un proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#quitarC").click(function(){
    // Obtenemos el valor del campo Cliente
    var cliente = $("select#clientNOproject").val();

    // Validamos el campo cliente, que no este vacío.
    if (cliente == "") {
      $("div#clienteError").fadeIn(1500);
      $("select#clientNOproject").focus();
      $("div#clienteError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'clienteEliminar=' + cliente;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha eliminado el cliente: '+cliente);
        updateListClientsNOProject();
        updateClienteSelect();
        $("select#clientNOproject").val('');
        $("#quitarCliente").modal('hide');
      }        
    });
    return false;
  });
});
