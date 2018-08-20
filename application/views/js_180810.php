<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>if (!window.jQuery) { document.write('<script src="<?= base_url(); ?>assets/js/jquery-2.1.4.min.js"><\/script>'); }</script>
<script src="<?= base_url(); ?>assets/js/number.min..js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" async defer></script>
<script src="<?= base_url(); ?>assets/js/app.js"></script>

<script type="text/javascript">
	$(function() {
		resetNavbar();
	    resetFormLogin();
	    resetFormRegister();
	    navbarClick();
	    navbarKeypress();
	});

	function addSubscribe() {
        var emailSubscribe = $('#subscribe-modal-email').val();
        var found = 0;

        $.each($('.data-subscribe-important'), function(key, subscribe) {
            if ($(subscribe).val() == '') {
                found += 1;

                $(subscribe).css('border', '1px solid red');
            }
        });

        if (emailSubscribe != '' && !isEmail(emailSubscribe)) {
            found += 1;

            $('#subscribe-email').css('border', '1px solid red');
        }

        if (found > 0) {
        	return;
        }

        $.ajax({
            data :{
                email: emailSubscribe,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('.success-subscribe-footer').show();
                }
                else {
                    $(subscribe).css('border', '1px solid red');
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>main/ajax_subscribe/',
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

	function changeCurrency(currencyId) {
       	$.ajax({
            data: {
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            success: function(data) {
               window.location.reload();
            },
            type : 'POST',
            url : '<?= base_url(); ?>main/ajax_set_currency/'+ currencyId +'/'
       });
   }

	function changeLanguage(lang) {
       	$.ajax({
            data: {
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            success: function(data) {
               window.location.reload();
            },
            type : 'POST',
            url : '<?= base_url(); ?>main/ajax_set_language/'+ lang +'/'
       });
   }

	function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

	function navbarClick() {
		$('#navbar-forgot-password-button').click(function() {
			navbarResetPassword();
		});

		$('#navbar-login-button').click(function() {
			navbarLogin();
		});

		$('#navbar-register-button').click(function() {
			navbarRegister();
		});

		$('#select-currency').change(function() {
			var currencyId = $('#select-currency').val();

			changeCurrency(currencyId);
		});

		$('#select-currency-mobile').change(function() {
			var currencyId = $('#select-currency-mobile').val();

			changeCurrency(currencyId);
		});

		$('#select-language').change(function() {
			var lang = $('#select-language').val();

			changeLanguage(lang);
		});
	}

	function navbarResetPassword() {
		$('#navbar-forgot-password-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Resetting...</span>');

		$('.data-forgot-password-important').prev().children().html(' * Required').hide();
		$('.data-forgot-password-important').css('border', '1px solid #d9d9d9');

		var found = 0;
		var email = $('#forgot-password-email').val();

		$.each($('.data-forgot-password-important'), function(key, forgotPassword) {
			if ($(forgotPassword).val() == '') {
				found += 1;

				$(forgotPassword).prev().children().html(' * Required').show();
				$(forgotPassword).css('border', '1px solid red');
			}
		});

		if (email != '' && !isEmail(email)) {
			found += 1;

			$('#forgot-password-email').prev().children().html(' * Wrong Email or Password').show();
			$('#forgot-password-email').css('border', '1px solid red');
		}

		if (found > 0) {
			$('#navbar-forgot-password-button').html('SUBMIT');

			return;
		}

		$.ajax({
			data :{
				email: email,
				"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
			},
			dataType: 'JSON',
			error: function() {
				alert('Server Error');

				$('#navbar-login-button').html('LOGIN');
			},
			success: function(data){
				if (data.status == 'success') {
					alert('Your new password will be sent to your email..');
				}
				else {
					$('#forgot-password-email').prev().children().html(' * '+ data.message).show();
					$('#forgot-password-email').css('border', '1px solid red');
				}

				$('#navbar-login-button').html('LOGIN');
			},
			type : 'POST',
			url : '<?= base_url(); ?>main/ajax_reset_password/',
		});
	}

	function navbarKeypress() {
		$('#sign-in-email, #sign-in-password').keypress(function(e) {
			if (e.which == 13) {
				navbarLogin();
			}
		});
	}

	function navbarLogin() {
		$('#navbar-login-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Logging In...</span>');

		$('.data-login-important').prev().children().html(' * Required').hide();
		$('.data-login-important').css('border', '1px solid #d9d9d9');

		var found = 0;
		var email = $('#sign-in-email').val();
		var password = $('#sign-in-password').val();

		$.each($('.data-login-important'), function(key, login) {
			if ($(login).val() == '') {
				found += 1;

				$(login).prev().children().html(' * Required').show();
				$(login).css('border', '1px solid red');
			}
		});

		if (email != '' && !isEmail(email)) {
			found += 1;

			$('#sign-in-email').prev().children().html(' * Wrong Email or Password').show();
			$('#sign-in-email').css('border', '1px solid red');
		}

		if (found > 0) {
			$('#navbar-login-button').html('LOGIN');

			return;
		}

		$.ajax({
			data :{
				email: email,
				password: password,
				"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
			},
			dataType: 'JSON',
			error: function() {
				alert('Server Error');

				$('#navbar-login-button').html('LOGIN');
			},
			success: function(data){
				if (data.status == 'success') {
					window.location.reload();
				}
				else {
					$('#sign-in-email').prev().children().html(' * '+ data.message).show();
					$('#sign-in-email').css('border', '1px solid red');
				}

				$('#navbar-login-button').html('LOGIN');
			},
			type : 'POST',
			url : '<?= base_url(); ?>main/ajax_login/',
		});
	}

	function navbarRegister() {
		$('#navbar-register-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> CREATING YOUR ACCOUNT...</span>');

		$('.data-register-important').prev().children().html(' * Required').hide();
		$('.data-register-important').css('border', '1px solid #d9d9d9');

		var found = 0;
		var name = $('#register-name').val();
		var phone = $('#register-phone').val();
	    var email = $('#register-email').val();
		var password = $('#register-password').val();

		$.each($('.data-register-important'), function(key, register) {
			if ($(register).val() == '') {
				found += 1;

				$(register).prev().children().html(' * Required').show();
				$(register).css('border', '1px solid red');
			}
		});

		if (email != '' && !isEmail(email)) {
			found += 1;

			$('#register-email').prev().children().html(' * Wrong Email Format!').show();
			$('#register-email').css('border', '1px solid red');
		}

		if (found > 0) {
			$('#navbar-register-button').html('SUBMIT');

			return;
		}

		$.ajax({
			data :{
				name: name,
				phone: phone,
				email: email,
				password: password,
				"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
			},
			dataType: 'JSON',
			error: function() {
				alert('Server Error');

				$('#navbar-register-button').html('SUBMIT');
			},
			success: function(data){
				if (data.status == 'success') {
					window.location.reload();
				}
				else {
					$('#sign-in-email').prev().children().html(' * '+ data.message).show();
					$('#sign-in-email').css('border', '1px solid red');
				}

				$('#navbar-register-button').html('SUBMIT');
			},
			type : 'POST',
			url : '<?= base_url(); ?>main/ajax_register/',
		});
	}

	function resetFormLogin() {
	    $('#sign-in-email').val("");
	    $('#sign-in-password').val("");
	}

	function resetFormRegister() {
	    $('#register-name').val("");
	    $('#register-phone').val("");
	    $('#register-email').val("");
	    $('#register-password').val("");
	}

	function resetNavbar() {
		$('#select-language').val("<?= $lang; ?>");
		$('#select-currency, #select-currency-mobile').val("<?= $curr; ?>");
	}
</script>
