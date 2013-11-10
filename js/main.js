
// set current date
	var date = new Date();
	$('#date').val($.datepicker.formatDate('dd.mm.yy', new Date()));

	// datepicker setup
	$('#date').datepicker({
		dayNamesMin: [ "Ned", "Pon", "Uto", "Sri", "Čet", "Pet", "Sub" ],
		monthNames: [ "Siječanj", "Veljača", "Ožujak", "Travanj", "Svibanj", "Lipanj", "Srpanj", "Kolovoz", "Rujan", "Listopad", "Studeni", "Prosinac" ],
		dateFormat: 'dd.mm.yy',
		firstDay: 1
	});

	// timepicker setup
	$('#start').timepicker({
		hourText: 'Početak smjene',
		showMinutes: false
	});
	
	$('#end').timepicker({
		hourText: 'Kraj smjene',
		showMinutes: false
	});

// shift report
	$('td.date, td.time, td.total, th.total').click(function(event) {
		$(this).parent().next('tr.details').fadeToggle();
	});
	
	$('tr.details').click(function(event) {
		$(this).fadeOut();
	});

// dialog setup
	$('td.edit').click(function() {
		var date = $(this).siblings('td.date').html();
		var time = $(this).siblings('td.time').html();
		var id = $(this).parent().attr('id');
		var comment = $(this).parent().next('tr.details').find('li.comment').children('.value').html();

		console.log(date);
		time = time.split(' - ');
		if (typeof comment == 'undefined') {
			comment = '';
		}
		
		$('#test')
			.find('#date').val(date).end()
			.find('#start').val(time[0]).end()
			.find('#end').val(time[1]).end()
			.find('#note').val(comment).end()
			.data('id', id)
			.modal('show');
	})