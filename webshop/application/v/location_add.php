	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			click();
			init();
			reset();
			change();
		});

		function back() {
			window.location.href = '<?= base_url(); ?>location/view/1/';
		}

		function change() {
		}

		function click() {
			$('#form-back').click(function() {
				back();
			});

			$('#form-submit').click(function() {
				submit();
			});

			$('.form-input').click(function() {
				$(this).removeClass('input-error');
			});
		}

		function init() {
			tinymce.init({
				selector: 'textarea#location-address',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');
		}

		function reset() {
			$('#location-name').val("");
			$('#location-email').val("");
			$('#location-phone').val("");
			$('#location-address').val("");
		}

		function submit() {
			var locationName = $('#location-name').val();
			var locationEmail = $('#location-email').val();
			var locationPhone = $('#location-phone').val();
			var locationAddress = tinyMCE.get('location-address').getContent();

			var found = 0;

			$.each($('.data-important'), function(key, data) {
				if ($(data).val() == '' || $(data).val() <= 0) {
					found += 1;

					$(data).addClass('input-error');
				}
			});

			if (found > 0) {
				return;
			}

			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: locationName,
					email: locationEmail,
					phone: locationPhone,
					address: locationAddress,
					"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
				},
				dataType: 'JSON',
				error: function() {
					$('.ui.dimmer.all-loader').dimmer('hide');
					$('.ui.basic.modal.all-error').modal('show');
					$('.all-error-text').html('Server Error.');
				},
				success: function(data){
					if (data.status == 'success') {
						$('.ui.text.loader').html('Redirecting...');

						back();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.ui.basic.modal.all-error').modal('show');
						$('.all-error-text').html(data.message);
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>location/ajax_add/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Checking Data..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Updating Database...');
					}, false);

					return xhr;
				},
			});
		}
	</script>

	<!-- Dashboard Here -->
	<div class="main-content">
		<div class="ui stackable one column centered grid">
			<div class="column">
				<div class="ui attached message setting-header">
					<div class="header">Add New Location</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<h4 class="ui dividing header">Location - Details</h4>
						<div class="field">
							<div class="three fields">
								<div class="field">
									<label>Name <span class="color-red">*</span></label>
									<input id="location-name" class="form-input data-important" placeholder="Name.." type="text">
								</div>
								<div class="field">
									<label>Phone <span class="color-red">*</span></label>
									<input id="location-phone" class="form-input data-important" placeholder="Phone.." type="text">
								</div>
								<div class="field">
									<label>Email</label>
									<input id="location-email" class="form-input" placeholder="Email.." type="text">
								</div>
							</div>
						</div>

						<div class="field">
							<label>Address</label>
							<textarea id="location-address" placeholder="Description.."></textarea>
						</div>
					</div>
				</div>
				<div class="ui bottom attached message text-right setting-header">
					<div class="ui buttons">
						<button id="form-back" class="ui left attached button form-button">Back</button>
						<button id="form-submit" class="ui right attached button form-button">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>