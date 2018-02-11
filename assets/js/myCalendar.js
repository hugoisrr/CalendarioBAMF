$(document).ready(function() {
	
	var emailCalendario = email;  // Email del calendario

	/* Función Ajax para obtener los eventos de la BD e insertarlos en
	el calendario
	-----------------------------------------------------------------*/

	$.ajax({
	  url: 'processCalendar.php',    
	  type: 'POST', // Send post data   
	  data: 'type=fetch&email='+emailCalendario,  
	  async: false,
	  success: function(s){
	      json_events = s;
	  }
	});

	/* Declaramos la variable calendar usando la librería de 
	    Fullcalendar de Boostrap, usando funciones de JQuery
	  -----------------------------------------------------------------*/

	var calendar = $('#calendar').fullCalendar({
		// Tomando el arreglo Json se imprimen los eventos en el calendario
		events: JSON.parse(json_events),
		//events: [{"id":"2","title":"Etiqueta Ciel","backgroundColor":"#1e0200","start":"Tue Jul 14 2015 14:30:00 GMT-0500","end":"Tue Jul 14 2015 14:30:00 GMT-0500","url":"projectDescr.php?var=4","allDay":false},{"id":"3","title":"Etiqueta Coca Cola","backgroundColor":"#c34c00","start":"Wed Jul 15 2015 10:30:00 GMT-0500","end":"Wed Jul 15 2015 14:30:00 GMT-0500","url":"projectDescr.php?var=5","allDay":false}]
		utc: true,
		header: {
		    left: 'prev,next today',
		    center: 'title',
		    right: 'month,basicWeek,agendaWeek,agendaDay'
		},
		defaultView: 'agendaWeek',   
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