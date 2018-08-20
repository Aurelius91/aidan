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
			window.location.href = '<?= base_url(); ?>media/view/1/';
		}

		function change() {
			$('#main-image').change(function() {
				var file_data = $('#main-image').prop('files')[0];
				var form_data = new FormData();
				form_data.append('file', file_data);
				form_data.append("<?= $csrf['name'] ?>", "<?= $csrf['hash'] ?>");

				$.ajax({
					cache: false,
					contentType: false,
					data: form_data,
					dataType: 'JSON',
					error: function() {
						alert('Server Error.');
					},
					processData: false,
					type: 'post',
					success: function(data) {
						if (data.status == 'success') {
							$('.preview').remove();

							var image = '<img class="preview" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview').append(image);
                            $('#preview').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/',
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
					}
				});
			});
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
				selector: 'textarea#media-description',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			tinymce.init({
				selector: 'textarea#media-qualification',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('#media-date, #media-date-end').datepicker({
                dateFormat: 'yy-mm-dd'
            });
		}

		function reset() {
			$('#media-name').val("");
			$('#media-subtitle').val("");
			$('#media-date').val("");
			$('#media-description').val("");

			$('#media-product').val("");
			$('#media-product-container').dropdown('set selected', "");

			$('#main-image').val("");
			$('#preview').data('image_id', 0);
		}

		function submit() {
			var mediaName = $('#media-name').val();
			var mediaSubtitle = $('#media-subtitle').val();
			var mediaDescription = tinyMCE.get('media-description').getContent();
			var mediaDate = $('#media-date').val();
			var mediaProduct = $('#media-product').val();

			var imageId = $('#preview').data('image_id');

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
					name: mediaName,
					subtitle: mediaSubtitle,
					date: mediaDate,
					description: mediaDescription,
					image_id: imageId,
					product_id_product_id: mediaProduct,
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
				url : '<?= base_url() ?>media/ajax_add/',
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
					<div class="header">Add New Media</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<h4 class="ui dividing header">Media - Details</h4>
						<div class="field">
							<div class="three fields">
								<div class="field">
									<label>Title <span class="color-red">*</span></label>
									<input id="media-name" class="form-input data-important" placeholder="Name.." type="text">
								</div>
								<div class="field">
									<label>Subtitle <span class="color-red">*</span></label>
									<input id="media-subtitle" class="form-input data-important" placeholder="Subtitle.." type="text">
								</div>
								<div class="field">
									<label>Date<span class="color-red">*</span></label>
									<input id="media-date" class="form-input data-important" placeholder="Date.." type="text">
								</div>
							</div>
						</div>

						<div class="field">
							<label>Product</label>
							<div id="media-product-container" class="ui multiple search selection dropdown form-input multiple">
								<input id="media-product" type="hidden">
								<i class="dropdown icon"></i>
								<div class="default text">-- Select Product --</div>
								<div class="menu">
									<? foreach ($arr_product as $product): ?>
										<div class="item" data-value="<?= $product->id; ?>"><?= $product->name; ?></div>
									<? endforeach; ?>
								</div>
							</div>
						</div>

						<div class="field">
							<label>Content</label>
							<textarea id="media-description" placeholder="Content.."></textarea>
						</div>

						<h4 class="ui dividing header">Upload Image (Cover)</h4>
						<div class="three fields">
							<div class="field">
								<label>Upload Image <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image" class="form-input data-important" placeholder="Upload Image.." type="File">
							</div>
						</div>

						<div class="three fields">
							<div class="field">
								<label>Preview Image </label>
								<div id="preview"></div>
							</div>
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