var Script = function () {
    /* Inicializa el listado de Proyectos disponibles, a partir de la célula
     -----------------------------------------------------------------*/

    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()), // use the element's text as the event title
            backgroundColor: $(this).css("background-color"), // obtiene el color del elemento
            url: 'projectDescr.php?var='.concat($(this).attr("id")) // obtiene el id del evento, que es también el id del proyecto
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var zone = "06:00";  //Change this to your timezone Mexico's time zone
    var emailCalendario = email;


    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        timezone: zone,
        defaultView: 'agendaWeek',
        droppable: true, // this allows things to be dropped onto the calendar !!!      
        drop: function(date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.end = (copiedEventObject.end == null) ? copiedEventObject.start : copiedEventObject.end.format();
            copiedEventObject.allDay = allDay;
            
            // alert('Titulo: '+copiedEventObject.title);
            // alert('Start: '+copiedEventObject.start);
            // alert("Correo: "+emailCalendario);
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            $.ajax({
                url: 'processCalendar.php',
                data:  'type=new&title='+copiedEventObject.title+'&startdate='+copiedEventObject.start+'&email='+emailCalendario,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    originalEventObject.id = response.eventid;
                    $('#calendar').fullcalendar('updateEvent',originalEventObject);
                },
                error: function(e){
                    console.log(e.responseText);
                }
            });
            $('#calendar').fullCalendar('updateEvent',originalEventObject);
            console.log(originalEventObject); 
        },        
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1)
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d-5),
                end: new Date(y, m, d-2)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d-3, 16, 0),
                allDay: false
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d+4, 16, 0),
                backgroundColor: 'green',
                allDay: false
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d+1, 19, 0),
                end: new Date(y, m, d+1, 22, 30),
                allDay: false
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }
        ]
    });


}();