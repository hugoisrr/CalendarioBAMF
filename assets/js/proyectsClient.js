$(function() {
    // Oculta los diferentes elementos que muestran la información del Cliente
    $('#listaCliente').hide(); 
    $('#divHoursClient').hide();
    $('#divCostClient').hide();
    // $('#morris').hide();
    // Funciones AJAX para mostrar los elementos de información del Cliente
    $('#nombreCliente').change(function(){
    	var idNombreCliente = $('#nombreCliente').val();
    	$.ajax({
    		type: 'POST',
    		url: 'processClientInfo.php',
    		data: 'type=proyects&idNombreCliente='+idNombreCliente,
    		success: function(listas){
    			$('#listProyects').html(listas);
    			$('#listaCliente').show();	    			
    		}
    	}); 
        $.ajax({
            type: 'POST',
            url: 'processClientInfo.php',
            data: 'type=hours&idNombreCliente='+idNombreCliente,
            success: function(hours){
                $('#hoursClient').html(hours);
                $('#divHoursClient').show();
            }
        });
        $.ajax({
            type: 'POST',
            url: 'processClientInfo.php',
            data: 'type=cost&idNombreCliente='+idNombreCliente,
            success: function(cost){
                $('#costClient').html(cost);
                $('#divCostClient').show();
            }
        });
        $.ajax({
            type: 'POST',
            url: 'processClientInfo.php',
            data: 'type=modals&idNombreCliente='+idNombreCliente,
            success: function(modals){
                $('#modalModify').html(modals);                
            }
        });
        $.ajax({
            type: 'POST',
            url: 'processClientInfo.php',
            data: 'type=graficaMeses&idNombreCliente='+idNombreCliente,
            success: function(graph){
                $('script#costGraph').html(graph);
                // $('#morris').show();
            }
        });
    });
});