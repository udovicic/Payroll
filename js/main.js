function init() {
	// set current date
	var d=new Date();
	var day = d.getDate();
	var month = d.getMonth() + 1;
	var year = d.getFullYear();
	$('#date').val(day + '.' + month + '.' + year);
	$('#month').val(month);


	// datepicker setup
	$('#date').datetimepicker({
		autoclose: true,
		format: 'dd.mm.yyyy',
		todayHighlight: true,
		minView: 2,
		weekStart: 1,
		language: $('#date').attr('lang')
	});

	// month picker setup
	$('#month').datetimepicker({
		autoclose: true,
		format: 'mm',
		startView: 3,
		minView: 3,
		language: $('#month').attr('lang')
	});

	// timepicker setup
	$('#start').datetimepicker({
		autoclose: true,
		format: 'hh',
		startView: 1,
		minView: 1,
		language: $('#start').attr('lang')
	});

	$('#end').datetimepicker({
		autoclose: true,
		format: 'hh',
		startView: 1,
		minView: 1,
		language: $('#end').attr('lang')
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
		var bonus = $(this).siblings('td.bonus').html();
		var id = $(this).parent().attr('id');
		var comment = $(this).parent().next('tr.details').find('li.comment').children('.value').html();
		var bonus = $(this).parent().next('tr.details').find('li.bonus').children('.value').html();

		time = time.split(' - ');
		if (typeof comment == 'undefined') {
			comment = '';
		}
		if (typeof bonus == 'undefined') {
			bonus = '';
		}
		
		$('#edit')
			.find('#date').val(date).end()
			.find('#start').val(time[0]).end()
			.find('#end').val(time[1]).end()
			.find('#bonus').val(bonus).end()
			.find('#note').val(comment).end()
			.find('#shift_id').val(id).end()
			.modal('show');
	})

	$('td.delete').click(function() {
		var id = $(this).parent().attr('id');
		var date = $(this).siblings('td.date').html();
		var total = $(this).siblings('td.total').html();

		$('#delete')
			.find('#shift_id').val(id).end()
			.find('span.date').html(date).end()
			.find('span.total').html(total).end()
			.modal('show');
	});

	// ajax
	// period select
	$('#menu-report, #menu-pdf').click(function(e) {
		e.preventDefault();
		var posting = $.get($(this).children('a').attr('href') + '/ajax');
		posting.done(function(data) {
			$('#ajax-body').html(data);
			init(); // populate fields and reattach callbacks
			$('#ajax-modal').modal('show');
		})
	});

	// period select hack
	$('#period-submit').click(function() {
		var month = $('#month').val();
		var action = $('#period-select').attr('action') + '/' + month;
		$('#period-select').attr('action', action);
		$('#ajax-modal').modal('hide');
	})

	// form validation info
	$('#form-shift-add, #user-login, #user-reset, #user-register').submit(function(e) {
		e.preventDefault();
		$.post(
			$(this).attr('action') + '/ajax',
			$(this).serialize()
		).done( function(data) {
			if (data == '') window.location.reload(true);
			$('#result').html(data);
		});
	});
}

init();
