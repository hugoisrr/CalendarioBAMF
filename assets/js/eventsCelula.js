$(document).ready(function(){

	// Célula del calendario
	var celulaCalendario = celula; 

	/* Función Ajax para obtener los eventos de la BD e insertarlos en
	   el calendario
	 -----------------------------------------------------------------*/

	$.ajax({
	  url: 'processCalendarCelula.php',    
	  type: 'POST', // Send post data   
	  data: 'type=fetch&celula='+celulaCalendario,  
	  async: false,
	  success: function(s){
	      json_events = s;
	  }
	});

	/* Declaramos la variable calendar usando la librería de 
	Fullcalendar de Boostrap, usando funciones de JQuery
	-----------------------------------------------------------------*/

	var calendar = $('#calendarCelula').fullCalendar({
		events: JSON.parse(json_events),	    
	    utc: true,
	    header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'month,basicWeek,agendaWeek,agendaDay'
	    },
	    defaultView: 'agendaDay',
	    droppable: true, // this allows things to be dropped onto the calendar !!!      
	    slotDuration: '00:30:00', 
	    firstDay: Monday = 1,
	    weekends: false,
	    editable: true,
	    selectable: true,
	    /* Función 'eventoDrop' de Fullcalendar, nos entrega los nuevos 
	    tiempos de inicio y final ya que el evento ha sido modificado, por 
	    medio de la función ajax se actuliza la información en la BD.
	    -----------------------------------------------------------------*/
	    eventDrop: function(event, jsEvent, ui, view){
	      console.log(event);
	      $.ajax({
	        url: 'processCalendarCelula.php',
	        data: 'type=move&idevent='+event.id+'&enddate='+event.end+'&startdate='+event.start,
	        type: 'POST',
	        dataType: 'json',
	        success: function(response){
	          console.log(response);
	          // window.alert('Se ha modificado el evento!');
	        },
	        error: function(e){
	          console.log(e.responseText);
	        }
	      });
	      // Se manda a reimprimir el evento en el calendario.
	      $('#calendarCelula').fullCalendar('renderEvent', event, true);
	      console.log(event);
	    },
	    /* Función 'eventResize' de Fullcalendar, ayuda a determinar nuevos 
	    tiempos de inicio y final de un evento que se le hizo resize. Se 
	    utilizo una librería de Fullcalendar 'Moment' para determinar la 
	    diferencia de los tiempos y así obtener las horas empleadas en el 
	    evento 
	    -----------------------------------------------------------------*/
	    eventResize: function(event, delta, revertFunc) {
	      console.log('Id del evento: '+event.id);
	      console.log('Tiempo Inicial: '+event.start);
	      console.log('Final: '+event.end);
	      var ms = moment(event.end,"DD/MM/YYYY HH:mm:ss").diff(moment(event.start,"DD/MM/YYYY HH:mm:ss"));
	      var d = moment.duration(ms);
	      var horas = parseInt(d.hours());
	      console.log('Horas: '+horas);
	      $.ajax({
	          url: 'processCalendarCelula.php',
	          data:  'type=resize&idevent='+event.id+'&enddate='+event.end+'&startdate='+event.start+'&horas='+horas,
	          type: 'POST',
	          dataType: 'json',
	          success: function(response){
	            console.log(response);
	             window.alert('Se modifico el evento! Horas: '+horas);
	          },
	          error: function(e){
	              console.log(e.responseText);
	          }
	      });  
	      // Se manda a reimprimir el evento en el calendario.
	      $('#calendarCelula').fullCalendar('renderEvent', event, true);
	      console.log(event);                               
	    },
	    /* Función 'eventClick' de Fullcalendar, nos ayuda a realizar una
	    acción al momento del click, en este caso se llama el Modal 
	    #calendarEventModal, se obtiene la información del evento y se 
	    imprime en el Modal, si el usuario oprime el botón eliminar, se 
	    llama la función deleteEvent().
	    -----------------------------------------------------------------*/
	    eventClick:  function(event, jsEvent, view) {
	      endtime = $.fullCalendar.formatDate(event.end,'h:mm tt');
	      starttime = $.fullCalendar.formatDate(event.start,'ddd, MMM d, h:mm tt');
	      var whenEvent = starttime + ' - ' + endtime;
	      console.log(whenEvent);
	      var ms = moment(event.end,"DD/MM/YYYY HH:mm:ss").diff(moment(event.start,"DD/MM/YYYY HH:mm:ss"));
	      var d = moment.duration(ms);
	      var horas = parseInt(d.hours());
	      console.log('Horas: '+horas);
	      $('#modalTitle').html(event.title);
	      // $('#modalBody').html(event.id);
	      $('#calendarEventModal #when').html(whenEvent);
	      $('#calendarEventModal #hoursEvent').html(horas);
	      $('#modalBody #idEvent').val(event.id);
	      $('#eventUrl').attr('href',event.description);
	      $('#calendarEventModal').modal();
	    }
	});

	$('#deleteEvent').on('click', function(e){
		// We don't want this to act as a link so cancel the link action
		e.preventDefault();
		// Se llama la función deleteEventCal().
		deleteEventCal();
	});

	function deleteEventCal(){
		// se oculta el modal, se llama la función ajax para borrar el evento de la BD, se imprime todos los eventos.
		$("#calendarEventModal").modal('hide');
		console.log('idEventoBorrar: '+$('#idEvent').val());
		$.ajax({
		  url: 'processCalendar.php',
		  data: 'type=remove&eventid='+$('#idEvent').val(),
		  type: 'POST',
		  dataType: 'json',
		  success: function(response){
		    console.log(response);
		    $('#calendarCelula').fullCalendar('removeEvents', $('#idEvent').val());
		  },
		  error: function(e){ 
		      alert('Ha ocurrido un error al procesar la peticion: '+e.responseText);
		  }
		});
	}
});