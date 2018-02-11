// funciones de JQuery creadas
$(document).ready(function(){
    $("#quitar").click(function(){
        $("#quitar").fadeOut("slow")
    });
    $("#aparecer").click(function(){
        $("#aparecer").fadeIn();
    });
});

// Despúes de haber insertado los elementos en el input limpia el campo
// Formularío de insertar tipo de Proyecto
function clearInput() {
    $("#nuevoTipo :input").each( function() {
       $(this).val('');
    });
}