	$(document).ready(function() {
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

		$("#clear-events").click(function() {
			$('#calendar').fullCalendar( 'removeEvents');
		});
		$("#reg-events").click(function() {
			var eventsFromCalendar = $('#calendar').fullCalendar('clientEvents');
			seen = [];
			json = JSON.stringify(eventsFromCalendar, function(key, val) {
						   if (typeof val == "object") {
						        if (seen.indexOf(val) >= 0)
						            return
						        seen.push(val);
						    }
						    return val;
						});
			// var _data = JSON.stringify(eventsFromCalendar);
			console.log(eventsFromCalendar);
			$.ajax({
					type: 'POST',
					data: { eventsJson: json },
					dataType: "json",
					url: '/ajax/calender.php',
					success: function(result) {
						console.log(result);
									var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
									$("#could_pass").html($elm);
									setTimeout(function() {
															$elm.remove();
													}, 5000);
					} ,
			      error: function (xhr, ajaxOptions, thrownError) {
			        alert(xhr.status);
			        alert(thrownError);
			      }
			});
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
			buttonIcons: true, // show the prev/next text
			weekNumbers: false ,
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
            isJalaali : true,
            locale: 'fa',
			minTime: '07:00:00',
            firstDay: 1,
			droppable: true, // this allows things to be dropped onto the calendar
			eventAfterRender: function(event){
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event._id = idi;
					idi = idi+1;
				}
			},
			drop: function(date, allDay) {
				var event = $(this).data('event');
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event._id = idi;
					idi = idi+1;
				}
			},
			eventAfterRender: function(event){
				if (event.id == 'undefined' || event.id == null || event.id == '') {
					event.id = idi;
					event._id = idi;
					idi = idi+1;
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
						title: title,
						start: start,
						end: end,
						backgroundColor: ((selected_hand == 'green') ? "#65bd77" : "#fea223"),
					};
					idi = idi+1;
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
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

				if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
					jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
					$('#calendar').fullCalendar('removeEvents', event.id);
				}
			}
		});
	});
