<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale = 1.0">
	<meta charset="utf-8">
	<meta name="description" content="">
    <meta name="author" content="">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?= base_url(); ?>images/favicon/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>images/favicon/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>images/favicon/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>images/favicon/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?= base_url(); ?>images/favicon/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= base_url(); ?>images/favicon/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?= base_url(); ?>images/favicon/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= base_url(); ?>images/favicon/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="<?= base_url(); ?>images/favicon/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?= base_url(); ?>images/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?= base_url(); ?>images/favicon/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?= base_url(); ?>images/favicon/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?= base_url(); ?>images/favicon/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="&nbsp;"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?= base_url(); ?>images/favicon/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?= base_url(); ?>images/favicon/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?= base_url(); ?>images/favicon/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?= base_url(); ?>images/favicon/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?= base_url(); ?>images/favicon/mstile-310x310.png" />

	<script src="<?= base_url(); ?>js/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url(); ?>plugin/semantic/dist/semantic.min.js"></script>

	<link href="<?= base_url(); ?>plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>plugin/semantic/dist/semantic.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>css/reset.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>css/core.css" rel="stylesheet" type="text/css">

	<title><?= $setting->setting__website_title; ?> | Login</title>

	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			change();
			click();
			focus();
			keypress();
			reset();
		});

		function change() {
			$('.login-username, .login-password').change(function() {
				$(this).css('border', '');
			});
		}

		function click() {
			$('.login-button').click(function() {
				login();
			});
		}

		function focus() {
			$('.login-username, .login-password').focus(function() {
				$(this).css('border', '');
			});
		}

		function keypress() {
			$('.login-username, .login-password').keypress(function(e) {
				if (e.which == 13) {
					login();
				}
			});
		}

		function reset() {
			$('.login-username').val("").focus();
			$('.login-password').val("");
		}

		function login() {
			var username = $('.login-username').val();
			var password = $('.login-password').val();
			var error = 0;

			$.each($('.important'), function(key, login) {
				if ($(login).val() == '') {
					$(login).css('border', '1px solid red');

					error += 1;
				}
			});

			if (error > 0) {
				return;
			}

			$('.ui.dimmer.login-loader').addClass('active');
			$('.ui.text.loader').html('Connecting to Database...');

			$.ajax({
				data :{
					username: username,
					password: password,
					"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
				},
				dataType: 'JSON',
				error: function() {
					$('.ui.dimmer.login-loader').removeClass('active');
					$('.ui.basic.modal.login-error').modal('show');
					$('.login-error-text').html('Server Error.');
				},
				success: function(data){
					if (data.status == 'success') {
						$('.ui.text.loader').html('Preparing Your Dashboard...');

						if (data.user.type == 'Admin') {
							window.location.href = '<?= base_url(); ?>';
						}
						else {
							window.location.href = '<?= base_url(); ?>pos/';
						}
					}
					else {
						$('.ui.dimmer.login-loader').removeClass('active');
						$('.ui.basic.modal.login-error').modal('show');
						$('.login-error-text').html(data.message);
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>login/ajax_login/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Checking Username and Password..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Verifying Data...');
					}, false);

					return xhr;
				},
			});
		}
	</script>
</head>

<body>
	<!--Dimmer-->
	<div class="ui dimmer login-loader">
		<div class="ui text loader">Loading</div>
	</div>

	<!-- Modal -->
	<div class="ui basic modal login-error">
		<div class="ui icon header">WARNING</div>
		<div class="content">
			<div class="login-error-text"></div>
		</div>
		<div class="actions text-center">
			<div class="ui basic cancel inverted button">
				<i class="remove icon"></i>
				Return
			</div>
		</div>
	</div>

	<div class="ui center aligned grid container login">
		<div class="column">
			<div class="login-container">
				<div>
					<img style="width: 30%;" src="<?= base_url(); ?>images/admin/logo.png">
				</div>
				<h4 class="ui horizontal divider header login-header">
					<i class="sign in icon"></i>
					<?= $setting->system_product_title; ?> Login
				</h4>
				<div class="login-input-container">
					<input class="login-username important error" type="text" placeholder="Your Username">
					<div class="login-icon">
						<i class="user icon"></i>
					</div>
				</div>
				<div class="login-input-container">
					<input class="login-password important error" type="password" placeholder="Your Password">
					<div class="login-icon">
						<i class="unlock icon"></i>
					</div>
				</div>
				<div class="login-input-container">
					<button class="login-button">Login</button>
				</div>
			</div>
		</div>
	</div>
	<div class="login-footer">
		V. <?= $setting->system_version; ?> <?= ucfirst($setting->system_product); ?> | Powered by <a class="login-footer-link" href="<?= $setting->system_vendor_link; ?>" target="_blank"><?= $setting->system_vendor_name; ?></a>
	</div>
</body>
</html>