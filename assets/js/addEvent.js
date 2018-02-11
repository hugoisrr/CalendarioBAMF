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
    /* Se determinan la estructura inicial del calendario, los valores
    son los siguientes:
    visualización: agendaWeek,
    droppable: true, // this allows things to be dropped onto the calendar !!!      
    slotDuration: '00:30:00', 
    firstDay: Monday = 1,
    weekends: false,
    editable: true,
    selectable: true
    -----------------------------------------------------------------*/
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
    droppable: true, // this allows things to be dropped onto the calendar !!!      
    slotDuration: '00:30:00', 
    firstDay: Monday = 1,
    weekends: false,
    editable: true,
    selectable: true,
    /* Función 'select' de Fullcalendar, ayuda a determinar el tiempo
    seleccionado en el calendario y obtenemos el tiempo inicial y 
    el final de la selección, llamamos los diferentes inputs y div del
    modal y asignamos los valores, después se manda a llamar el modal
    #createEventModal, donde obtenemos el idProyecto, si el usuario 
    oprime el botón crear se manda a llamar la función doSubmit()
    -----------------------------------------------------------------*/
    select: function(start, end, allDay) {         
      endtime = $.fullCalendar.formatDate(end,'h:mm tt');
      starttime = $.fullCalendar.formatDate(start,'ddd, MMM d, h:mm tt');
      var mywhen = starttime + ' - ' + endtime;
      $('#createEventModal #apptStartTime').val(start);
      $('#createEventModal #apptEndTime').val(end);
      $('#createEventModal #apptAllDay').val(allDay);
      $('#createEventModal #when').text(mywhen);
      $('#createEventModal').modal('show');
      $('#errorClient').hide();
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
          url: 'processCalendar.php',
          data:  'type=resize&idevent='+event.id+'&enddate='+moment(event.end).format('YYYY-MM-DD HH:mm:ss')+'&startdate='+moment(event.start).format('YYYY-MM-DD HH:mm:ss')+'&horas='+horas,
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
      $('#calendar').fullCalendar('renderEvent', event, true);
      console.log(event);                               
    },
    /* Función 'eventoDrop' de Fullcalendar, nos entrega los nuevos 
    tiempos de inicio y final ya que el evento ha sido modificado, por 
    medio de la función ajax se actuliza la información en la BD.
    -----------------------------------------------------------------*/
    eventDrop: function(event, jsEvent, ui, view){
      console.log(event);
      $.ajax({
        url: 'processCalendar.php',
        data: 'type=move&idevent='+event.id+'&enddate='+moment(event.end).format('YYYY-MM-DD HH:mm:ss')+'&startdate='+moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
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
      $('#calendar').fullCalendar('renderEvent', event, true);
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
    // En el modal de la creación del Evento, al momento de dar click en el botón createEvent
  $('#createEvent').on('click', function(e){
    // We don't want this to act as a link so cancel the link action
    e.preventDefault();
    // Se llama función doSubmit()
    doSubmit();
  });

  $('#deleteEvent').on('click', function(e){
    // We don't want this to act as a link so cancel the link action
    e.preventDefault();
    // Se llama la función deleteEventCal().
    deleteEventCal();
  });

  function doSubmit(){
    if (($('#projectList').val() == '0') || $('#nombreCliente').val() == '0') {
      $('#errorClient').show();
    }else{
      // Se oculta el modal y se obtiene los datos para crear el evento
      $("#createEventModal").modal('hide');
      // Formato de tiempo en 'Timestampt' para que pueda ser insertado en la BD y así determinar el mes y año del evento.
      console.log("Tiempo Inicial: "+moment($('#apptStartTime').val()).format('YYYY-MM-DD HH:mm:ss'));
      console.log("Tiempo Final: "+moment($('#apptEndTime').val()).format('YYYY-MM-DD HH:mm:ss'));
      console.log($('#apptAllDay').val());
      console.log($('#correo').val());
      var eventoMS = moment($('#apptEndTime').val(),"DD/MM/YYYY HH:mm:ss").diff(moment($('#apptStartTime').val(),"DD/MM/YYYY HH:mm:ss"));
      var eventoD = moment.duration(eventoMS);
      var horasEvento = parseInt(eventoD.hours());
      console.log("horas: "+horasEvento);
      var email = $('#correo').val();    
      var idProject = $('#projectList').val();
      console.log("idProject: "+idProject);      
      var nameProject = "";
      var colorProject = "#";
      var idEvento = "";

      // función ajax sincrona, por lo tanto puede guardar los resultados en otras variables.
      $.ajax({
        url: 'processCalendar.php',
        type: 'POST',
        data: 'type=projectInfo&idProject='+idProject,
        dataType: 'json',
        async: false,
        success: function(response){
          console.log(response);
          nameProject = response.nombreProyecto;
          console.log(nameProject);
          colorProject = colorProject.concat(response.colorProyecto);
          console.log(colorProject);
        },
        error: function(e){
          console.log(e.responseText);
        }  
      });            

      // función ajax asincrona, por lo tanto guarda los resultados directamente en la BD
      $.ajax({
        url: 'processCalendar.php',
        type: 'POST',
        data: 'type=new&idProject='+idProject+'&startdate='+moment($('#apptStartTime').val()).format('YYYY-MM-DD HH:mm:ss')+'&enddate='+moment($('#apptEndTime').val()).format('YYYY-MM-DD HH:mm:ss')+'&email='+email+'&horas='+horasEvento,
        dataType: 'json',
        async: false,
        success: function(response){
          console.log(response);
          console.log("Id Evento: "+response.eventid);
          idEvento = response.eventid;
        },
        error: function(e){
            console.log(e.responseText);
        }
      });

      // se imprime el nuevo evento en el calendario
      $("#calendar").fullCalendar('renderEvent',
        {
            title: nameProject,
            backgroundColor: colorProject,
            id: idEvento,
            // url: 'projectDescr.php?var='.concat(idProject),
            description: 'projectDescr.php?var='.concat(idProject),
            start: new Date($('#apptStartTime').val()),
            end: new Date($('#apptEndTime').val()),
            allDay: ($('#apptAllDay').val() == "true"),
        },
        true);
    };
  }

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
        $('#calendar').fullCalendar('removeEvents', $('#idEvent').val());
      },
      error: function(e){ 
          alert('Ha ocurrido un error al procesar la peticion: '+e.responseText);
      }
    });
  }
});