$(function() {
	$('#projectsByClient').hide();
	$('#nombreCliente').change(function(){
		var idNombreCliente = $('#nombreCliente').val();
		$.ajax({
			type: 'POST',
			url: 'processClientInfo.php',
			data: 'type=selectProjects&idNombreCliente=' + idNombreCliente,
			success: function(proyectos){
				$('#projectList').html(proyectos);
				$('#projectsByClient').show();
			}
		});
	});
});