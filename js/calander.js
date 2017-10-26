	$(document).ready(function() {
		var replacer = function(key, value) {
			if (value != null && typeof value == "object") {
				if (seen.indexOf(value) >= 0) {
					return;
				}
				seen.push(value);
			}
			return value;
		};
		var selected_hand = "green";
		$('#green-dot').click(function() {
			selected_hand = "green";
			$("#calendar *").css('cursor', "url('../assets/images/cur/green.ico'), url('../assets/images/cur/green.ico'), n-resize");
			$("#calendar *").css('*cursor', "url('../assets/images/cur/green.ico'), n-resize");
			$("#calendar *").css('_cursor', "url('../assets/images/cur/green.ico'), n-resize");
			$("#calendar *").css('_cursor', "url('../assets/images/cur/green.ico'), n-resize\9");
		});
		$('#red-dot').click(function() {
			selected_hand = "red";
			$("#calendar *").css('cursor', "url('../assets/images/cur/red.ico'), url('../assets/images/cur/red.ico'), n-resize");
			$("#calendar *").css('*cursor', "url('../assets/images/cur/red.ico'), n-resize");
			$("#calendar *").css('_cursor', "url('../assets/images/cur/red.ico'), n-resize");
			$("#calendar *").css('_cursor', "url('../assets/images/cur/red.ico'), n-resize\9");
		});
		$("*:not(#calendar .fc-event)").click(function() {
			//$("html").css('cursor', 'auto');
		});
		/* initialize the external events
		-----------------------------------------------------------------*/
		$('#external-events .fc-event').each(function() {
			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true, // maintain when user navigates (see docs on the renderEvent method)
				backgroundColor: (($(this).text() == 'ساعت حضور' || $(this).text() == 'ساعت حضور') ? "#65bd77" : "#fea223")
			});
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});
		function SendCalData() {
			var dtv = $('#calendar').fullCalendar('getView');
			var eventsFromCalendar = $('#calendar').fullCalendar('clientEvents');
			seen = [];
			json = JSON.stringify(eventsFromCalendar, replacer);
			$.ajax({
					type: 'POST',
					data: {
						token: "",
						end: moment(dtv.end._d).format(),
						start: moment(dtv.start._d).format(),
						eventsJson: json },
					url: '/ajax/calender.php',
					dataType: 'json',
					success: function(result) {
									//result = JSON.parse(result);
									var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
									$("#could_pass").html($elm);
									setTimeout(function() {
															$elm.remove();
													}, 5000);
									$('#calendar').fullCalendar( 'removeEvents');
									$('#calendar').fullCalendar( 'refresh' );
					}
			});
		}
		$("#clear-events").click(function() {
			var dtv = $('#calendar').fullCalendar('getView');
			$.ajax({
					type: 'POST',
					data: {
						rm: 'la',
						end: moment(dtv.end._d).format(),
						start: moment(dtv.start._d).format(),
						eventstart: event.start._i,
						eventend: event.end._i
					},
					url: '/ajax/calender.php',
					dataType: 'json',
					success: function(result) {
									var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
									$("#could_pass").html($elm);
									setTimeout(function() {
															$elm.remove();
													}, 5000);
									// $('#calendar').fullCalendar( 'removeEvents');
					}
			});
		});
		$("#reg-events").click(function() {
			SendCalData();
		});
		/* initialize the calendar
		-----------------------------------------------------------------*/
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
			editable: true,
			eventSources: [{
            url: '/ajax/getCalender.php',
						type: 'POST',
            data: function() {
											var dtv = $('#calendar').fullCalendar('getView');
					            return {
													end: moment(dtv.end._d).format(),
													start: moment(dtv.start._d).format()
					            };
					        }
        }],
			eventLimit: true,
            isJalaali : true,
            locale: 'fa',
			minTime: '07:00:00',
            firstDay: 1,
			droppable: true,
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
			drop: function(date, allDay) {
				var event = $(this).data('event');
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event._id = idi;
					event.title = event.title+idi;
					idi += 1;
					$('#calendar').fullCalendar('rerenderEvents');
					SendCalData();
				}
			},
			selectable: true,
			selectHelper: false,
			select: function(start, end) {
				var title = ((selected_hand == 'green') ? "ساعت حضور" : "ساعت ثبت شده");
				var eventData;
				if (title) {
					eventData = {
						id: idi,
						title: title+idi,
						start: start,
						end: end,
						backgroundColor: ((selected_hand == 'green') ? "#65bd77" : "#fea223"),
					};
					idi = idi+1;
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
					SendCalData();
				}
				$('#calendar').fullCalendar('unselect');
			},
			eventDragStop: function(event,jsEvent) {
				var trashEl = jQuery('#calendarTrash');
				var ofs = trashEl.offset();
				var x1 = ofs.left;
				var x2 = ofs.left + trashEl.outerWidth(true);
				var y1 = ofs.top;
				var y2 = ofs.top + trashEl.outerHeight(true);
				var dtv = $('#calendar').fullCalendar('getView');
				if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
					jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {

					$.ajax({
							type: 'POST',
							data: {
								rm: '',
								eventid: event.id,
								eventtitle: event.title,
								end: moment(dtv.end._d).format(),
								start: moment(dtv.start._d).format(),
								eventstart: event.start._i,
								eventend: event.end._i
							},
							url: '/ajax/calender.php',
							dataType: 'json',
							success: function(result) {
											var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
											$("#could_pass").html($elm);
											setTimeout(function() {
																	$elm.remove();
															}, 5000);
							}
					});

					$('#calendar').fullCalendar('removeEvents', event.id);
				} else {

				}
			}
		});
	});
