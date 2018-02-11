// JavaScript document
// Lista de funciones Ajax, ya sea para inserciones o consultas a la BD.
// Ajax para eliminar categoría que NO este vìnculado a un proyecto
$(document).ready(function() {
  $('.error').hide();
  $("#quitarCP").click(function(){
    // Obtenemos el valor del campo categoria
    var categoria = $("select#categoryNOproject").val();

    // Validamos el campo categoria, que no este vacío.
    if (categoria == "") {
      $("div#categoriaError").fadeIn(1500);
      $("select#categoryNOproject").focus();
      $("div#categoriaError").fadeOut(5500);
      return false;
    }

    // Construimos la variable que se guardará en el data del Ajax para pasar el archivo php que procesará los datos
    var dataString = 'categoriaEliminar=' + categoria;

    $.ajax({
      type: "POST",
      url: "insertBD.php",
      data: dataString,
      success: function(){
        console.log('Se ha eliminado la categoria: '+categoria);
        updateListCategoryNOProject();        
        updateCategorySelect();
        $("select#categoryNOproject").val('');
        $("#quitarCategoria").modal('hide');
      }        
    });
    return false;
  });
});
