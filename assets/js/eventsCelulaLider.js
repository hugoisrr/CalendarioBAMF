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
	    slotDuration: '00:30:00', 
	    firstDay: Monday = 1,
	    weekends: false,
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
});