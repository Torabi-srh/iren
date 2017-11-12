	$(document).ready(function() {

		var idi = 1;
		var uname = $('#uname').val();
		function refreshevents() {
			var events = {
          url: '/ajax/getCalender.php',
					type: 'POST',
					data: function() {
										var dtv = $('#calendar').fullCalendar('getView');
										return {
												end: moment(dtv.end._d).format(),
												start: moment(dtv.start._d).format(),
												uname: uname
										};
								}
			}

			$('#calendar').fullCalendar( 'removeEvents');
			$('#calendar').fullCalendar( 'removeEventSource', events);
			$('#calendar').fullCalendar( 'addEventSource', events);
			$('#calendar').fullCalendar( 'refetchEvents' );
		}
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
											uname: uname
							      };
							    },
        }],
			eventLimit: true,
            isJalaali : true,
            locale: 'fa',
			minTime: '07:00:00',
            firstDay: 1,
			droppable: false,
			viewRender: function() {
				$('#calendar').fullCalendar('rerenderEvents');
			},
			eventClick: function(calEvent, jsEvent, view) {
				var stime = moment(calEvent.start).format();
        var etime = moment(calEvent.end).format();
				var dtv = $('#calendar').fullCalendar('getView');
				$.ajax({
						type: 'POST',
						data: {
							end: moment(dtv.end._d).format(),
							start: moment(dtv.start._d).format(),
							stime: stime,
							etime: etime,
							uname: uname
						},
						url: '/ajax/reserve.php',
						dataType: 'json',
						success: function(result) {
										var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
										$("#could_pass").html($elm);
										setTimeout(function() {
																$elm.remove();
														}, 5000);
										refreshevents();
						}
				});
	    },
			eventAfterRender: function(event) {
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event.title += idi;
					event._id = idi;
					idi = idi+1;
				} else {
					idi = (event.id+1>idi ? event.id+1 : idi);
				}
			},
			selectable: false,
			selectHelper: false
		});
		refreshevents();
	});
