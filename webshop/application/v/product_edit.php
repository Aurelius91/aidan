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
			window.location.href = '<?= base_url(); ?>product/view/1/';
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
					url: '<?= base_url(); ?>image/ajax_upload_all/hover/',
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
				selector: 'textarea#product-description',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			tinymce.init({
				selector: 'textarea#product-description-lang',
				height: 300,
				width: '100%',
				plugins: ["advlist autolink lists link charmap preview", "searchreplace visualblocks code", "table contextmenu paste"],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				paste_as_text: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('#product-discount-start, #product-discount-end').datepicker({
                dateFormat: 'yy-mm-dd'
            });
		}

		function reset() {
			$('#product-number').val("<?= $product->number; ?>");
			$('#product-name').val("<?= $product->name; ?>");
			$('#product-price').val("<?= $product->price_display; ?>");
			$('#product-discount').val("<?= $product->discount_display; ?>");
			$('#product-weight').val("<?= $product->weight_display; ?>");

			$('#product-discount-start').val("<?= $product->discount_period_start_display; ?>");
			$('#product-discount-end').val("<?= $product->discount_period_end_display; ?>");

			$('#product-status').val("Active");
			$('#product-status-container').dropdown('set selected', "<?= $product->status; ?>");

			$('#product-category').val("<?= $product->category; ?>");
			$('#product-category-container').dropdown('set selected', "<?= $product->category; ?>");

			$('#product-category-looks').val("");
			$('#product-category-looks-container').dropdown('set selected', [<? foreach ($product->arr_looks as $looks): ?>'<?= $looks ?>',<? endforeach; ?>]);

			$('#product-collection').val("<?= $product->collection_id; ?>");
			$('#product-collection-container').dropdown('set selected', "<?= $product->collection_id; ?>");

			$('#product-alterego').val("<?= $product->alterego_id; ?>");
			$('#product-alterego-container').dropdown('set selected', "<?= $product->alterego_id; ?>");

			$('#product-color').val("");
			$('#product-color-container').dropdown('set selected', [<? foreach ($product->arr_color_id as $color_id): ?>'<?= $color_id ?>',<? endforeach; ?>]);

			$('#product-metatag-title').val("<?= $product->metatag_title; ?>");
			$('#product-metatag-author').val("<?= $product->metatag_author; ?>");
			$('#product-metatag-keywords').val("<?= $product->metatag_keywords; ?>");
			$('#product-metatag-description').val("<?= $product->metatag_description; ?>");

			$('#main-image').val("");
			$('#preview').data('image_id', 0);

			$('.preview').remove();

			var image = '<img class="preview" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $product->image_name; ?>">';
			$('#preview').append(image);

			$('#main-image2').val("");
			$('#preview2').data('image_id', 0);

			$('.preview2').remove();

			var image2 = '<img class="preview2" style="width: 100%;" src="<?= base_url(); ?>images/website/<?= $product->image_hover_name; ?>">';
			$('#preview2').append(image2);
		}

		function submit() {
			var productNumber = $('#product-number').val();
			var productName = $('#product-name').val();
			var productPrice = $('#product-price').val();
			var productDiscount = $('#product-discount').val();
			var productWeight = $('#product-weight').val();
			var productStatus = $('#product-status').val();
			var productDiscountStart = $('#product-discount-start').val();
			var productDiscountEnd = $('#product-discount-end').val();
			var productDescription = tinyMCE.get('product-description').getContent();
			var productDescriptionLang = tinyMCE.get('product-description-lang').getContent();
			var imageId = $('#preview').data('image_id');
			var image2Id = $('#preview2').data('image_id');
			var productCollection = $('#product-collection').val();
			var productAlterego = $('#product-alterego').val();
			var productColor = $('#product-color').val();
			var productMetatagTitle = $('#product-metatag-title').val();
			var productMetatagAuthor = $('#product-metatag-author').val();
			var productMetatagKeywords = $('#product-metatag-keywords').val();
			var productMetatagDescription = $('#product-metatag-description').val();

			var productCategory = $('#product-category').val() + ',' + $('#product-category-looks').val();

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
					number: productNumber,
					name: productName,
					category_id_category_id: productCategory,
					discount: productDiscount,
					price: productPrice,
					weight: productWeight,
					status: productStatus,
					discount_period_start: productDiscountStart,
					discount_period_end: productDiscountEnd,
					description: productDescription,
					description_lang: productDescriptionLang,
					image_id: imageId,
					image2_id: image2Id,
					collection_id: productCollection,
					alterego_id: productAlterego,
					color_id_color_id: productColor,
					metatag_title: productMetatagTitle,
					metatag_author: productMetatagAuthor,
					metatag_keywords: productMetatagKeywords,
					metatag_description: productMetatagDescription,
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
				url : '<?= base_url() ?>product/ajax_edit/<?= $product->id; ?>',
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
					<div class="header">Add New Product</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<h4 class="ui dividing header">Product - Details</h4>
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Number (SKU)</label>
									<input id="product-number" class="form-input" placeholder="AUTO" type="text">
								</div>
								<div class="field">
									<label>Name <span class="color-red">*</span></label>
									<input id="product-name" class="form-input data-important" placeholder="Name.." type="text">
								</div>
							</div>
							<div class="three fields">
								<div class="field">
									<label>Status</label>
									<div id="product-status-container" class="ui search selection dropdown form-input">
										<input id="product-status" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Status --</div>
										<div class="menu">
											<div class="item" data-value="Active">Active</div>
											<div class="item" data-value="Void">Void</div>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Category</label>
									<div id="product-category-container" class="ui search selection dropdown form-input">
										<input id="product-category" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Category --</div>
										<div class="menu">
											<? foreach ($arr_category as $category): ?>
												<? if ($category->type != 'category'): ?>
													<? continue; ?>
												<? endif; ?>

												<div class="item" data-value="<?= $category->id; ?>"><?= $category->name; ?></div>
											<? endforeach; ?>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Alter Ego</label>
									<div id="product-alterego-container" class="ui search selection dropdown form-input">
										<input id="product-alterego" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Alter Ego --</div>
										<div class="menu">
											<? foreach ($arr_alterego as $alterego): ?>
												<div class="item" data-value="<?= $alterego->id; ?>"><?= $alterego->name; ?></div>
											<? endforeach; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="three fields">
								<div class="field">
									<label>Looks</label>
									<div id="product-category-looks-container" class="ui multiple search selection dropdown form-input multiple">
										<input id="product-category-looks" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Looks --</div>
										<div class="menu">
											<? foreach ($arr_category as $category): ?>
												<? if ($category->type != 'looks'): ?>
													<? continue; ?>
												<? endif; ?>

												<div class="item" data-value="<?= $category->id; ?>"><?= $category->name; ?></div>
											<? endforeach; ?>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Collection</label>
									<div id="product-collection-container" class="ui search selection dropdown form-input">
										<input id="product-collection" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Collection --</div>
										<div class="menu">
											<? foreach ($arr_collection as $collection): ?>
												<div class="item" data-value="<?= $collection->id; ?>"><?= $collection->name; ?></div>
											<? endforeach; ?>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Color</label>
									<div id="product-color-container" class="ui multiple search selection dropdown form-input multiple">
										<input id="product-color" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Color --</div>
										<div class="menu">
											<? foreach ($arr_color as $color): ?>
												<div class="item" data-value="<?= $color->id; ?>"><?= $color->name; ?></div>
											<? endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h4 class="ui dividing header">Product - Description</h4>
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Description - <?= $setting->setting__system_language; ?></label>
									<textarea id="product-description" class="form-input" placeholder="Description - <?= $setting->setting__system_language; ?>.."><?= $product->description; ?></textarea>
								</div>
								<div class="field">
									<label>Description - <?= $setting->setting__system_language2; ?></label>
									<textarea id="product-description-lang" class="form-input" placeholder="Description - <?= $setting->setting__system_language2; ?>.."><?= $product->description_lang; ?></textarea>
								</div>
							</div>
						</div>

						<h4 class="ui dividing header">Product - Additional Detail</h4>
						<div class="field">
							<div class="three fields">
								<div class="field">
									<label>Price</label>
									<input id="product-price" class="form-input" placeholder="Price.." type="text">
								</div>
								<div class="field">
									<label>Discount (%)</label>
									<input id="product-discount" class="form-input" placeholder="Discount (%).." type="text">
								</div>
								<div class="field">
									<label>Weight (KG)</label>
									<input id="product-weight" class="form-input" placeholder="Weight.." type="text">
								</div>
							</div>

							<div class="two fields">
								<div class="field">
									<label>Discount Start</label>
									<input id="product-discount-start" class="form-input" placeholder="Discount Start.." type="text">
								</div>
								<div class="field">
									<label>Discount End</label>
									<input id="product-discount-end" class="form-input" placeholder="Discount End.." type="text">
								</div>
							</div>
						</div>

						<h4 class="ui dividing header">Product - SEO Meta Tag</h4>
						<div class="three fields">
							<div class="field">
								<label>Metatag Title</label>
								<input id="product-metatag-title" class="form-input" placeholder="Metatag Title.." type="text">
							</div>
							<div class="field">
								<label>Metatag Author</label>
								<input id="product-metatag-author" class="form-input" placeholder="Metatag Author.." type="text">
							</div>
							<div class="field">
								<label>Metatag Keywords</label>
								<input id="product-metatag-keywords" class="form-input" placeholder="Metatag Keywords.." type="text">
							</div>
						</div>
						<div class="field">
							<label>Metatag Description</label>
							<input id="product-metatag-description" class="form-input" placeholder="Metatag Description.." type="text">
						</div>

						<h4 class="ui dividing header">Upload Image</h4>
						<div class="three fields">
							<div class="field">
								<label>Upload Image <span class="color-red">*</span></label>
								<div>Recommended Size: 500px x 500px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image" class="form-input" placeholder="Upload Image.." type="File">
							</div>

							<div class="field">
								<label>Upload Hover Image <span class="color-red">*</span></label>
								<div>Recommended Size: 500px x 500px</div>
								<div style="padding-bottom: 5px;">Max File Size: 500kb</div>
								<input id="main-image2" class="form-input" placeholder="Upload Image.." type="File">
							</div>
						</div>

						<div class="three fields">
							<div class="field">
								<label>Preview Image </label>
								<div id="preview"></div>
							</div>
							<div class="field">
								<label>Preview Hover Image </label>
								<div id="preview2"></div>
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