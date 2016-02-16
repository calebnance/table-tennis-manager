$(document).ready(function(){
	/**
	*	vars
	*/
	$wizard = $('#wizard');

	/**
	* on
	*/

	// on check connection click
	$wizard.on('click', '#check-connection', function(e){
		e.preventDefault();
		// working
		if($(this).hasClass('working')) {
			return false;
		}
		$(this).addClass('working').html('<i class="fa fa-spinner fa-spin"></i> Checking...');
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
			url : 'wizard-ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'checkConnection',
				args : args
			}
		}).done(function(data){
			// any errors?
			if(data.error) {
				// remove class of working
				$('#check-connection').removeClass('working');
				$('#errorMsg').html('<div class="alert alert-danger bs3-btn-padding margin-t-20 margin-b-0" role="alert">' + data.msg + '</div>');
				$('#check-connection').html('Check Connection');
				// create the DB?
				if(data.extra == 'showCreateDB') {
					$('#create-database').fadeIn();
				}
			} else {
				$('#check-connection').removeClass('btn-default').addClass('btn-success').html('Connection Success!');
				$('#step1').attr('data-complete', 1);
				$('#gotoStep2').fadeIn();
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			// remove class of working
			$('#check-connection').removeClass('working');
		});
	});

	// on create database click
	$wizard.on('click', '#create-database', function(e){
		e.preventDefault();
		// working
		if($(this).hasClass('working')) {
			return false;
		}
		$(this).addClass('working').html('<i class="fa fa-spinner fa-spin"></i> Creating...');
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
			url : 'wizard-ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'createDatabase',
				args : args
			}
		}).done(function(data){
			// remove class of working
			$('#create-database').removeClass('working');
			// any errors?
			if(data.error) {
				$('#errorMsg').html('<div class="alert alert-danger bs3-btn-padding margin-t-20 margin-b-0" role="alert">' + data.msg + '</div>');
				$('#create-database').html('Create Database');
			} else {
				$('#create-database').fadeOut();
				$('#check-connection').trigger('click');
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			// remove class of working
			$('#create-database').removeClass('working');
		});
	});

	// on wizard field input/keyup/blur
	$wizard.on('input keyup blur', '.required', function(e) {
		// steps to pass
		var pass1 = pass2 = pass3 = true;

		// are we on step1?
		if($(this).closest('[role="tabpanel"]').hasClass('step1')) {
			// step1 check
			$step1 = $('#step1 .required');
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
				$('#check-connection').slideDown();
			} else {
				$('#check-connection').slideUp();
			}
		}

		// are we on step2?
		if($(this).closest('[role="tabpanel"]').hasClass('step2')) {
			// step2 check
			$step2 = $('#step2 .required');
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
				$('#gotoStep3').fadeIn();
			} else {
				$('#gotoStep3').fadeOut();
			}
		}

		// are we on step3?
		if($(this).closest('[role="tabpanel"]').hasClass('step3')) {
			// step3 check
			$step3 = $('#step3 .required');
			$step3Count = $step3.length;
			// are there required fields in step 3?
			if($step3Count > 1) {
				// parse through the required fields for step 3
				$.each($step3, function(i, input) {
					// is it empty?
					if($(input).val() == '' || $(input).val() === null) {
						pass3 = false;
					}
				});
			}

			// is pass1 good?
			if(pass3 == true) {
				$('#complete-install').fadeIn();
			} else {
				$('#complete-install').fadeOut();
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

	// go back to step1
	$wizard.on('click', '#gobackStep2', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(0) a').tab('show');
	});

	// go to step2
	$wizard.on('click', '#gotoStep2', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(1) a').tab('show');
		$('[href="#step1"]').addClass('completed').html('<span class="label label-success">Connect Database</span>');
	});

	// go back to step2
	$wizard.on('click', '#gobackStep3', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(1) a').tab('show');
	});

	// go to step3
	$wizard.on('click', '#gotoStep3', function(e){
		e.preventDefault();
		$('#tab-wizard li:eq(2) a').tab('show');
		$('[href="#step2"]').addClass('completed').html('<span class="label label-success">Administrator Setup</span>');
		$('#ptsToWin').blur();
	});

	// quck/standard game buttons
	// quick game clicked
	$('#quickGame').on('click', function(e){
		$('#quickStandGame').find('button').removeClass('active');
		$(this).addClass('active');
		// set values
		$('#ptsToWin').val(11);
		$('#ptsPerTurn').val(2);
		$('#skunk').val(5);
		$('#weeksPerSeason').val(2);
	});

	// standard game clicked
	$('#standGame').on('click', function(e){
		$('#quickStandGame').find('button').removeClass('active');
		$(this).addClass('active');
		// set values
		$('#ptsToWin').val(21);
		$('#ptsPerTurn').val(5);
		$('#skunk').val(7);
		$('#weeksPerSeason').val(2);
	});

	// complete installation
	$wizard.on('click', '#complete-install', function(e){
		e.preventDefault();
		// fadeout wizard
		$wizard.fadeOut(400, function(e){
			$('#installing').fadeIn();
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
			url : 'wizard-ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'install',
				args : args
			}
		}).done(function(data){
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').addClass('progress-bar-warning progress-bar-striped active').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// next step
			setUpDB();
		}).fail(function(jqXHR, textStatus, errorThrown){

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
			url : 'wizard-ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'setUpDatabaseTables',
				args : args
			}
		}).done(function(data){
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-info').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// next step
			seedContent();
		}).fail(function(jqXHR, textStatus, errorThrown){

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
			url : 'wizard-ajax.php',
			dataType : 'json',
			data : {
				ajax : true,
				function : 'seedDatabaseTables',
				args : args
			}
		}).done(function(data){
			// update text
			$('#installation-text').html(data.msg);
			// update progress
			$('#installing .progress-bar').removeClass('progress-bar-info').addClass('progress-bar-success').attr('aria-valuenow', data.progress).attr('style', 'width:' + data.progress + '%;').html(data.progress + '%');
			// show complete
			setTimeout(function(){
				$('#installing').fadeOut(400, function(e){
					$('#complete').fadeIn();
				});
			}, 3000);
		}).fail(function(jqXHR, textStatus, errorThrown){

		});
	}

});
