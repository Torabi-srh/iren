	$(document).ready(function() {
		var dtv = $('#calendar').fullCalendar('getView');
		alert(moment(dtv.end._d).format());
		alert(moment(dtv.start._d).format());
		alert($('#uname').val());
		var replacer = function(key, value) {
			if (value != null && typeof value == "object") {
				if (seen.indexOf(value) >= 0) {
					return;
				}
				seen.push(value);
			}
			return value;
		};
		var idi = 1;
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek'
			},
            defaultView: 'agendaWeek',
			buttonIcons: true,
			weekNumbers: false ,
			navLinks: true,
			editable: false,
			eventSources: [{
            url: '/ajax/getCalender.php',
						type: 'POST',
            data: function() {
											var dtv = $('#calendar').fullCalendar('getView');
					            return {
													end: moment(dtv.end._d).format(),
													start: moment(dtv.start._d).format(),
													uname: $('#uname').val() 
					            };
					        }
        }],
			eventLimit: true,
            isJalaali : true,
            locale: 'fa',
			minTime: '07:00:00',
            firstDay: 1,
			droppable: false,
			viewRender: function() {
				$('#calendar').fullCalendar('rerenderEvents');
				//$('#calendar').fullCalendar( 'removeEvents');
				//$('#calendar').fullCalendar( 'refresh' );
			},
			eventAfterRender: function(event) {
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event.title += idi;
					event._id = idi;
					idi = idi+1;
					SendCalData();
				} else {
					idi = (event.id+1>idi ? event.id+1 : idi);
				}
			},
			selectable: false,
			selectHelper: false
		});
	});
