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
			window.location.href = '<?= base_url(); ?>muse/view/1/';
		}

		function change() {
			$('#main-image-cover').change(function() {
				var file_data = $('#main-image-cover').prop('files')[0];
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
							$('.preview-cover').remove();

							var image = '<img class="preview-cover" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview-cover').append(image);
                            $('#preview-cover').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/cover/',
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
					url: '<?= base_url(); ?>image/ajax_upload_all/1/',
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

			$('#main-image2').change(function() {
				var file_data = $('#main-image2').prop('files')[0];
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
							$('.preview2').remove();

							var image = '<img class="preview2" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview2').append(image);
                            $('#preview2').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/2/',
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

			$('#main-image3').change(function() {
				var file_data = $('#main-image3').prop('files')[0];
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
							$('.preview3').remove();

							var image = '<img class="preview3" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview3').append(image);
                            $('#preview3').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/3/',
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

			$('#main-image4').change(function() {
				var file_data = $('#main-image4').prop('files')[0];
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
							$('.preview4').remove();

							var image = '<img class="preview4" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview4').append(image);
                            $('#preview4').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/4/',
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

			$('#main-image5').change(function() {
				var file_data = $('#main-image5').prop('files')[0];
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
							$('.preview5').remove();

							var image = '<img class="preview5" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview5').append(image);
                            $('#preview5').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/5/',
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

			$('#main-image6').change(function() {
				var file_data = $('#main-image6').prop('files')[0];
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
							$('.preview6').remove();

							var image = '<img class="preview6" style="width: 100%;" src="<?= base_url(); ?>images/website/'+ data.image_id +'.'+ data.ext +'">';
							$('#preview6').append(image);
                            $('#preview6').data('image_id', data.image_id);
						}
						else {
							alert(data.message);
						}
					},
					url: '<?= base_url(); ?>image/ajax_upload_all/6/',
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
				selector: 'textarea#muse-description-1',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			tinymce.init({
				selector: 'textarea#muse-description-2',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			tinymce.init({
				selector: 'textarea#muse-description-3',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('#muse-date, #muse-date-end').datepicker({
                dateFormat: 'yy-mm-dd'
            });
		}

		function reset() {
			$('#muse-name').val("<?= $muse->name; ?>");
			$('#muse-subtitle').val("<?= $muse->subtitle; ?>");
			$('#muse-short-description').val("<?= $muse->short_description; ?>");
			$('#muse-date').val("<?= $muse->date_display; ?>");

			$('#muse-title-1').val("<?= $muse->title_1; ?>");
			$('#muse-title-3').val("<?= $muse->title_3; ?>");

			$('#muse-product').val("");
			$('#muse-product-container').dropdown('set selected', [<? foreach ($muse->arr_muse_product as $muse_product): ?>'<?= $muse_product->product_id; ?>',<? endforeach; ?>]);

			$('#muse-youtube-url').val("<?= $muse->youtube_url; ?>");

			$('#muse-metatag-title').val("<?= $muse->metatag_title; ?>");
			$('#muse-metatag-author').val("<?= $muse->metatag_author; ?>");
			$('#muse-metatag-keywords').val("<?= $muse->metatag_keywords; ?>");
			$('#muse-metatag-description').val("<?= $muse->metatag_description; ?>");

			$('#main-image-cover').val("");
			$('#preview-cover').data('image_id', 0);

			$('.preview-cover').remove();
			var imageCover = '<img class="preview-cover" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image_cover_name; ?>">';
			$('#preview-cover').append(imageCover);

			$('#main-image').val("");
			$('#preview').data('image_id', 0);

			$('.preview').remove();
			var image = '<img class="preview" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image_name; ?>">';
			$('#preview').append(image);

			$('#main-image2').val("");
			$('#preview2').data('image_id', 0);

			$('.preview2').remove();
			var image2 = '<img class="preview2" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image2_name; ?>">';
			$('#preview2').append(image2);

			$('#main-image3').val("");
			$('#preview3').data('image_id', 0);

			$('.preview3').remove();
			var image3 = '<img class="preview3" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image3_name; ?>">';
			$('#preview3').append(image3);

			$('.preview4').remove();
			$('#main-image4').val("");
			$('#preview4').data('image_id', 0);

			var image4 = '<img class="preview4" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image4_name; ?>">';
			$('#preview4').append(image4);

			$('#main-image5').val("");
			$('#preview5').data('image_id', 0);

			$('.preview5').remove();
			var image5 = '<img class="preview5" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image5_name; ?>">';
			$('#preview5').append(image5);

			$('#main-image6').val("");
			$('#preview6').data('image_id', 0);

			$('.preview6').remove();
			var image6 = '<img class="preview6" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $muse->image6_name; ?>">';
			$('#preview6').append(image6);
		}

		function submit() {
			var museName = $('#muse-name').val();
			var museSubtitle = $('#muse-subtitle').val();
			var museShortDescription = $('#muse-short-description').val();
			var museDate = $('#muse-date').val();
			var museTitle1 = $('#muse-title-1').val();
			var museTitle3 = $('#muse-title-3').val();
			var museDescription1 = tinyMCE.get('muse-description-1').getContent();
			var museDescription2 = tinyMCE.get('muse-description-2').getContent();
			var museDescription3 = tinyMCE.get('muse-description-3').getContent();

			var museProduct = $('#muse-product').val();
			var museYoutube = $('#muse-youtube-url').val();

			var museMetatagTitle = $('#muse-metatag-title').val();
			var museMetatagAuthor = $('#muse-metatag-author').val();
			var museMetatagKeywords = $('#muse-metatag-keywords').val();
			var museMetatagDescription = $('#muse-metatag-description').val();

			var imageCover = $('#preview-cover').data('image_id');
			var imageId = $('#preview').data('image_id');
			var imageId2 = $('#preview2').data('image_id');
			var imageId3 = $('#preview3').data('image_id');
			var imageId4 = $('#preview4').data('image_id');
			var imageId5 = $('#preview5').data('image_id');
			var imageId6 = $('#preview6').data('image_id');

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
					type: 2,
					name: museName,
					subtitle: museSubtitle,
					short_description: museShortDescription,
					date: museDate,
					title_1: museTitle1,
					title_3: museTitle3,
					description_1: museDescription1,
					description_2: museDescription2,
					description_3: museDescription3,
					product_id_product_id: museProduct,
					youtube_url: museYoutube,
					metatag_title: museMetatagTitle,
					metatag_author: museMetatagAuthor,
					metatag_keywords: museMetatagKeywords,
					metatag_description: museMetatagDescription,
					image_cover_id: imageCover,
					image_id: imageId,
					image2_id: imageId2,
					image3_id: imageId3,
					image4_id: imageId4,
					image5_id: imageId5,
					image6_id: imageId6,
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
				url : '<?= base_url() ?>muse/ajax_edit/<?= $muse->id; ?>/',
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
					<div class="header">Add New Muse - Template 2</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<h4 class="ui dividing header">muse - Details</h4>
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Name <span class="color-red">*</span></label>
									<input id="muse-name" class="form-input data-important" placeholder="Name.." type="text">
								</div>
								<div class="field">
									<label>Subtitle <span class="color-red">*</span></label>
									<input id="muse-subtitle" class="form-input data-important" placeholder="Subtitle.." type="text">
								</div>
							</div>
						</div>

						<div class="two fields">
							<div class="field">
								<label>Short Description <span class="color-red">*</span></label>
								<input id="muse-short-description" class="form-input data-important" placeholder="Short Description.." type="text">
							</div>
							<div class="field">
								<label>Date <span class="color-red">*</span></label>
								<input id="muse-date" class="form-input data-important" placeholder="Date.." type="text">
							</div>
						</div>

						<div class="field">
							<label>Title</label>
							<input id="muse-title-1" class="form-input" placeholder="Title.." type="text">
						</div>

						<div class="two fields">
							<div class="field">
								<label>Content 1</label>
								<textarea id="muse-description-1" placeholder="Content 1.."><?= $muse->description_1; ?></textarea>
							</div>
							<div class="field">
								<label>Content 2</label>
								<textarea id="muse-description-2" placeholder="Content 2.."><?= $muse->description_2; ?></textarea>
							</div>
						</div>

						<div class="field">
							<label>Title 3</label>
							<input id="muse-title-3" class="form-input" placeholder="Title 3.." type="text">
						</div>

						<div class="field">
							<label>Content 3</label>
							<textarea id="muse-description-3" placeholder="Content 3.."><?= $muse->description_3; ?></textarea>
						</div>

						<div class="two fields">
							<div class="field">
								<label>Product</label>
								<div id="muse-product-container" class="ui multiple search selection dropdown form-input multiple">
									<input id="muse-product" type="hidden">
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
								<label>Youtube URL</label>
								<input id="muse-youtube-url" class="form-input" placeholder="Youtube URL.." type="text">
							</div>
						</div>

						<h4 class="ui dividing header">Muse - SEO Meta Tag</h4>
						<div class="three fields">
							<div class="field">
								<label>Metatag Title</label>
								<input id="muse-metatag-title" class="form-input" placeholder="Metatag Title.." type="text">
							</div>
							<div class="field">
								<label>Metatag Author</label>
								<input id="muse-metatag-author" class="form-input" placeholder="Metatag Author.." type="text">
							</div>
							<div class="field">
								<label>Metatag Keywords</label>
								<input id="muse-metatag-keywords" class="form-input" placeholder="Metatag Keywords.." type="text">
							</div>
						</div>
						<div class="field">
							<label>Metatag Description</label>
							<input id="muse-metatag-description" class="form-input" placeholder="Metatag Description.." type="text">
						</div>

						<h4 class="ui dividing header">Upload Image</h4>
						<div class="four fields">
							<div class="field">
								<label>Upload Image Cover <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image-cover" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Image <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Image 2 <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image2" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Image 3 <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image3" class="form-input" placeholder="Upload Image.." type="File">
							</div>
						</div>

						<div class="four fields">
							<div class="field">
								<label>Preview Image Cover </label>
								<div id="preview-cover"></div>
							</div>

							<div class="field">
								<label>Preview Image </label>
								<div id="preview"></div>
							</div>

							<div class="field">
								<label>Preview Image 2</label>
								<div id="preview2"></div>
							</div>

							<div class="field">
								<label>Preview Image 3</label>
								<div id="preview3"></div>
							</div>
						</div>

						<div class="three fields">
							<div class="field">
								<label>Upload Image 4 <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image4" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Image 5 <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image5" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Image 6 <span class="color-red">*</span></label>
								<div>Recommended Size: 1920px x 880px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image6" class="form-input" placeholder="Upload Image.." type="File">
							</div>
						</div>

						<div class="three fields">
							<div class="field">
								<label>Preview Image 4</label>
								<div id="preview4"></div>
							</div>

							<div class="field">
								<label>Preview Image 5</label>
								<div id="preview5"></div>
							</div>

							<div class="field">
								<label>Preview Image 6</label>
								<div id="preview6"></div>
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