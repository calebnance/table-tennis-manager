$(document).ready(function(){
	/**
	*	vars
	*/
	$wizard = $('#wizard');

	/**
	* on
	*/

	// on wizard field keyup/blur
	$wizard.on('keyup blur', '.required', function(e) {
		// steps to pass
		var pass1 = pass2 = true;

		// are we in step1?
		if($(this).closest('[role="tabpanel"]').hasClass('step1')) {
			// step1 check
			$step1 		  = $('#step1 .required');
			$step1Count = $step1.length;
			// are there required fields in step 1?
			if($step1Count > 1) {
				// if connection button had success already?
				if($('#check-connection').hasClass('btn-success')) {
					$('#check-connection').removeClass('btn-success').addClass('btn-default').html('Check Connection');
					$('#gotoStep2').fadeOut(400);
					$('[href="#step1"]').removeClass('completed').html('Step 1');
					$('#step1').attr('data-complete', 0);
				}
				// clear errorMsg
				$('#errorMsg').html('');
				// parse through the required fields for step 1
				$.each($step1, function(i, input) {
					// is it empty?
					if($(input).val() == '' || $(input).val() === null) {
						pass1 = false;
					}
				});
			}

			// is pass1 good?
			if(pass1 == true) {
				$('#check-connection').slideDown(400);
			} else {
				$('#check-connection').slideUp(400);
			}
		}

		// are we in step2?
		if($(this).closest('[role="tabpanel"]').hasClass('step2')) {
			// step2 check
			$step2 		  = $('#step2 .required');
			$step2Count = $step2.length;
			// are there required fields in step 2?
			if($step2Count > 1) {
				// parse through the required fields for step 2
				$.each($step2, function(i, input) {
					// is it empty?
					if($(input).val() == '' || $(input).val() === null) {
						pass2 = false;
					}
				});
			}

			// is pass1 good?
			if(pass2 == true) {
				$('#complete-install').fadeIn(400);
			} else {
				$('#complete-install').fadeOut(400);
			}
		}
	});

	// on steppers for wizard clicked
	$wizard.on('click', '[href="#step1"], [href="#step2"], [href="#step3"], [href="#step4"]', function(e) {
		// not completed, no go
		if(!$(this).hasClass('completed')) {
			e.preventDefault();
			e.stopPropagation();
		}
	});

	// on check connection click
	$wizard.on('click', '#check-connection', function(e){
		e.preventDefault();
		// working
		if($(this).hasClass('working')) {
			return false;
		}
		$(this).addClass('working').html('<i class="fa fa-spinner fa-spin"></i> Checking..');
		// set args
		var args = {
			host : $('#dbHost').val(),
			table : $('#dbTable').val(),
			user : $('#dbUser').val(),
			pass : $('#dbPass').val(),
			responseType : 'json'
		};

		// clear errorMsg
		$('#errorMsg').html('');

		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'checkConnection',
				args : args
			}
		}).done(function(data){
			// remove class of working
			$('#check-connection').removeClass('working');
			// any errors?
			if(data.error) {
				$('#errorMsg').html('<div class="alert alert-danger bs3-btn-padding margin-t-20 margin-b-0" role="alert">' + data.msg + '</div>');
				$('#check-connection').html('Check Connection');
			} else {
				$('#check-connection').removeClass('btn-default').addClass('btn-success').html('Connection Success!');
				$('#step1').attr('data-complete', 1);
				$('#gotoStep2').fadeIn(400);
			}
		}).fail(function( jqXHR, textStatus, errorThrown ){
			// remove class of working
			$('#check-connection').removeClass('working');
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	// go back to step1
	$wizard.on('click', '#gobackStep2', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(0) a').tab('show');
	});

	// go to step2
	$wizard.on('click', '#gotoStep2', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(1) a').tab('show');
		$('[href="#step1"]').addClass('completed').html('<span class="label label-success">Step 1</span>');
	});

	// complete installation
	$wizard.on('click', '#complete-install', function(e){
		e.preventDefault();
		// fadeout wizard
		$wizard.fadeOut(400, function(e){
			$('#installing').fadeIn(400);
		});

		// setInterval
		setInterval(function(){
			var html = $('#dot-loader').html();
			if(html == '') {
				html = '.';
			} else if(html == '.') {
				html = '..';
			} else if(html == '..') {
				html = '';
			}

			$('#dot-loader').html(html);
		}, 1000);

		// set args
		var args = {
			host : $('#dbHost').val(),
			table : $('#dbTable').val(),
			user : $('#dbUser').val(),
			pass : $('#dbPass').val(),
			responseType : 'json'
		};

		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'install',
				args : args
			}
		}).done(function(data){
			console.log('install() returned');
			console.log(data);
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// next step
			setUpDB();
		}).fail(function( jqXHR, textStatus, errorThrown ){
			console.log('error');
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	/**
	* functions
	*/
	function setUpDB(){
		// set args
		var args = {
			responseType : 'json'
		};

		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'setUpDatabaseTables',
				args : args
			}
		}).done(function(data){
			console.log('setUpDatabaseTables() returned');
			console.log(data);
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// next step
			seedContent();
		}).fail(function( jqXHR, textStatus, errorThrown ){
			console.log('error');
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		});
	}

	function seedContent(){
		// set args
		var args = {
			name : $('#name').val(),
			username : $('#username').val(),
			password : $('#password').val(),
			email : $('#email').val(),
			responseType : 'json'
		};

		$.ajax({
			type : 'POST',
			url : '../ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'seedDatabaseTables',
				args : args
			}
		}).done(function(data){
			console.log('seedDatabaseTables() returned');
			console.log(data);
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// show complete
			setTimeout(function(){
				$('#installing').fadeOut(400, function(e){
					$('#complete').fadeIn(400);
				});
			}, 3000);
		}).fail(function( jqXHR, textStatus, errorThrown ){
			console.log('error');
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		});
	}

	// set args
	/*
	var args = {
		host : $('#dbHost').val(),
		table : $('#dbTable').val(),
		user : $('#dbUser').val(),
		pass : $('#dbPass').val(),
		username : $('#username').val(),
		password : $('#password').val(),
		email : $('#email').val(),
		responseType : 'json'
	};
	*/

});
