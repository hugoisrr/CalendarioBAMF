var Script = function () {

	var celulaBamf = celula;

	/* Función Ajax para obtener los eventos de la BD e insertarlos en
       el calendario
     -----------------------------------------------------------------*/

    $.ajax({
        url: 'processCalendar.php',    
        type: 'POST', // Send post data   
        data: 'type=fetchCelula&celula='+celulaBamf,  
        async: false,
        success: function(s){
            json_events = s;
        }
    });

    var currentMousePos = {
        x: -1,
        y: -1
    };
        jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

    /* Inicializa el listado de Proyectos disponibles, a partir de la célula
     -----------------------------------------------------------------*/

    $('#external-events div.external-event').each(function() {

        var eventObject = {
            title: $.trim($(this).text()).concat(' ').concat($(this).attr("id").split(" ").pop()), // use the element's text as the event title
            backgroundColor: $(this).css("background-color"), // obtiene el color del elemento
            url: 'projectDescr.php?var='.concat($(this).attr("id").split(" ",1)), // obtiene el id del evento, que es también el id del proyecto
            // stick: true // maintain when user navigates (see docs on the renderEvent method)
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

    $('#calendar').fullCalendar({
        events: JSON.parse(json_events),
        //events: [{"id":"2","title":"Etiqueta Ciel","backgroundColor":"#1e0200","start":"Tue Jul 14 2015 14:30:00 GMT-0500","end":"Tue Jul 14 2015 14:30:00 GMT-0500","url":"projectDescr.php?var=4","allDay":false},{"id":"3","title":"Etiqueta Coca Cola","backgroundColor":"#c34c00","start":"Wed Jul 15 2015 10:30:00 GMT-0500","end":"Wed Jul 15 2015 14:30:00 GMT-0500","url":"projectDescr.php?var=5","allDay":false}]
        utc: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,agendaWeek,agendaDay'
        },
        editable: true,
        defaultView: 'basicWeek',
        droppable: true, // this allows things to be dropped onto the calendar !!!      
        slotDuration: '00:30:00',
        firstDay: Monday = 1,
        weekends: false,
        defaultEventMinutes: 240,
        drop: function(date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
                    
            // se pregunta si se trabaja en la mañana
            var con = confirm('Evento en la mañana 10am - 2pm?');

            if (con == true) {
                // assign it the date at the morning that was reported
                date.setHours(10);
                copiedEventObject.start = date;           
                copiedEventObject.allDay = allDay;
                copiedEventObject.end = (copiedEventObject.end == null) ? copiedEventObject.start : copiedEventObject.end.format();            
                $.ajax({
                    url: 'processCalendar.php',
                    data:  'type=new&title='+copiedEventObject.title.split(" ",1)+'&startdate='+copiedEventObject.start+'&enddate='+copiedEventObject.end+'&email='+copiedEventObject.title.split(" ").pop(),
                    type: 'POST',
                    dataType: 'json',
                    success: function(response){
                        originalEventObject.id = response.eventid;
                        // location.reload();
                        // window.alert('Se inserto el evento con id:'+originalEventObject.id);
                        // update event, insertar hora final
                    },
                    error: function(e){
                        console.log(e.responseText);
                    }
                });
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                console.log(originalEventObject);
            }else{
                var con2 = confirm('Evento en la tarde 3pm - 7pm?');
                if (con2 == true) {
                    // assign it the date in the afternoon that was reported
                    date.setHours(15);
                    copiedEventObject.start = date;           
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.end = (copiedEventObject.end == null) ? copiedEventObject.start : copiedEventObject.end.format();            
                    $.ajax({
                        url: 'processCalendar.php',
                        data:  'type=new&title='+copiedEventObject.title.split(" ",1)+'&startdate='+copiedEventObject.start+'&enddate='+copiedEventObject.end+'&email='+copiedEventObject.title.split(" ").pop(),
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            originalEventObject.id = response.eventid;
                            // location.reload();
                            // window.alert('Se inserto el evento con id:'+originalEventObject.id);
                            // update event, insertar hora final
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                    console.log(originalEventObject);
                }else{
                    alert('Se cancelo la inserción del evento!');
                }
            }
             
        },
        eventResize: function(event, delta, revertFunc) {
            console.log(event);
            // window.alert('Id del evento:'+event.id);
            // window.alert('Inicial:'+event.start);
            // window.alert('Final:'+event.end);
            // var title = event.title;
            var ms = moment(event.end,"DD/MM/YYYY HH:mm:ss").diff(moment(event.start,"DD/MM/YYYY HH:mm:ss"));
            var d = moment.duration(ms);
            var horas = parseInt(d.hours());
            // window.alert('Horas: '+horas);
            $.ajax({
                url: 'processCalendar.php',
                data:  'type=resize&idevent='+event.id+'&enddate='+event.end+'&startdate='+event.start+'&horas='+horas,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    window.alert('Se modifico el evento! Horas: '+horas);
                },
                error: function(e){
                    console.log(e.responseText);
                }
            });  
            $('#calendar').fullCalendar('renderEvent', event, true);
            console.log(event);                               
        },
        eventDragStop: function (event, jsEvent, ui, view) {
            if (isElemOverDiv()) {
                var con = confirm('Seguro que desea eliminar el evento?');
                if(con == true) {
                    $.ajax({
                        url: 'processCalendar.php',
                        data: 'type=remove&eventid='+event.id+'&title='+event.title,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                            if(response.status == 'success')
                                jQuery('#calendar').fullCalendar('removeEvents', event.id);
                                location.reload();
                        },
                        error: function(e){ 
                            alert('Ha ocurrido un error al procesar la peticion: '+e.responseText);
                        }
                    });
                }
            }            
        } 
    });

    function isElemOverDiv() {
    var trashEl = jQuery('#trash');

    var ofs = trashEl.offset();

    var x1 = ofs.left;
    var x2 = ofs.left + trashEl.outerWidth(true);
    var y1 = ofs.top;
    var y2 = ofs.top + trashEl.outerHeight(true);

    if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
        currentMousePos.y >= y1 && currentMousePos.y <= y2) {
        return true;
    }
    return false;
    }

}();