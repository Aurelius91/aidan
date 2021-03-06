	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			brandKeypress();
			brandClick();
			onChange();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function addbrand() {
			var brandName = $('#brand-name-add').val();
			var brandNameLang = $('#brand-name-lang-add').val();
			var brandImage = $('#brand-image-add').data('image_id');
			var found = 0;

			$.each($('.data-important-add'), function(key, data) {console.log($(this));
				if ($(data).val() == '') {
					found += 1;

					$('.color-red.warning').html('This Field Must Be Filled');
				}
			});

			if (found > 0) {
				return;
			}

			$('.add-brand-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: brandName,
					name_lang: brandNameLang,
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

						window.location.reload();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-brand-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>brand/ajax_add/',
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

		function deletebrand() {
			var brandId = $('.delete-brand-button').attr('data-brand-id');
			var brandUpdated = $('.delete-brand-button').attr('data-brand-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: brandUpdated,
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

						window.location.reload();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.ui.basic.modal.all-error').modal('show');
						$('.all-error-text').html(data.message);
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>brand/ajax_delete/'+ brandId +'/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Validating Data..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Delete Data from Database...');
					}, false);

					return xhr;
				},
			});
		}

		function editbrand() {
			var brandName = $('#brand-name-edit').val();
			var brandNameLang = $('#brand-name-lang-edit').val();

			var brandId = $('#brand-name-edit').data('brand_id');
			var brandUpdated = $('#brand-name-edit').data('updated');
			var found = 0;

			$.each($('.data-important-edit'), function(key, data) {
				if ($(data).val() == '') {
					found += 1;

					$('.color-red.warning').html('This Field Must Be Filled');
				}
			});

			if (found > 0) {
				return;
			}

			$('.edit-brand-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: brandName,
					name_lang: brandNameLang,
					updated: brandUpdated,
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

						window.location.reload();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.edit-brand-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>brand/ajax_edit/'+ brandId +'/',
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

		function filter(page) {
			var searchQuery = ($('.input-search').val() == '') ? '' : $.base64('encode', $('.input-search').val());

			window.location.href = '<?= base_url(); ?>brand/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function getbrand(brandId) {
			$('.ui.text.loader').html('Connecting to Database...');

			$.ajax({
				data :{
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
						$('#brand-name-edit').val(data.brand.name);
						$('#brand-name-lang-edit').val(data.brand.name_lang);
						$('#brand-type-container-edit').dropdown('set selected', data.brand.type);
						$('#brand-image-edit').val("");
						$('#brand-image-edit').data('image_id', 0);

						$('#brand-name-edit').data('brand_id', brandId);
						$('#brand-name-edit').data('updated', data.brand.updated);

						$('.edit-brand-modal').modal({
							inverted: false,
						}).modal('show');
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-brand-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>brand/ajax_get/'+ brandId +'/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Checking Data..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Retrieving Data...');
					}, false);

					return xhr;
				},
			});
		}

		function init() {
			$('.dropdown-search, .dropdown-filter').dropdown({
				allowAdditions: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('table').tablesort();
		}

		function onChange() {
			$('#brand-image-add').change(function() {
				var file_data = $('#brand-image-add').prop('files')[0];
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
							$('#brand-image-add').data('image_id', data.image_id);

							alert('Image Uploaded');
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

			$('#brand-image-edit').change(function() {
				var file_data = $('#brand-image-edit').prop('files')[0];
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
							$('#brand-image-edit').data('image_id', data.image_id);

							alert('Image Uploaded');
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

		function reset() {
			$('.input-search').val("<?= $query; ?>");
			$('#input-page').val("<?= $page; ?>");

			$('#brand-name-add').val("");
			$('#brand-name-lang-add').val("");
		}

		function brandClick() {
			$('.button-prev').click(function() {
				var page = parseInt('<?= $page; ?>');

				page = page - 1 ;

				if (page <= 0) {
					return;
				}

				filter(page);
			});

			$('.button-next').click(function() {
				var page = parseInt('<?= $page; ?>');
				var maxPage = parseInt('<?= $count_page; ?>');

				page = page + 1 ;

				if (page > maxPage) {
					return;
				}

				filter(page);
			});

			$('.item-add-button').click(function() {
				$('#brand-name-add').val("");
				$('.color-red.warning').html("");

				$('.add-brand-modal').modal({
					inverted: false,
				}).modal('show');
			});

			$('.open-modal-warning-delete').click(function() {
				var brandId = $(this).attr('data-brand-id');
				var brandName = $(this).attr('data-brand-name');
				var brandUpdated = $(this).attr('data-brand-updated');

				$('.delete-brand-title').html('Delete brand ' + brandName);
				$('.delete-brand-button').attr('data-brand-id', brandId);
				$('.delete-brand-button').attr('data-brand-updated', brandUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function brandKeypress() {
			$('.input-search').keypress(function(e) {
				if (e.which == 13) {
					var page = 1;

					filter(page);
				}
			});

			$('#input-page').keypress(function(e) {
				if (e.which == 13) {
					var page = $('#input-page').val();

					filter(page);
				}
			});
		}
	</script>

	<!-- Dashboard Here -->
	<div class="ui basic modal modal-warning-delete">
		<div class="ui icon header">
			<i class="trash outline icon delete-icon"></i>
			<span class="delete-brand-title">Delete Brand</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this brand. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-brand-button" onclick="deletebrand();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="ui modal add-brand-modal">
		<i class="close icon"></i>
		<div class="header">Add Brand</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<? if ($setting->setting__website_enabled_dual_language > 0): ?>
							<div class="two fields">
								<div class="field">
									<label>Name - <?= $setting->setting__system_language; ?> <span class="color-red warning"></span></label>
									<input id="brand-name-add" type="text" class="data-important-add" placeholder="Name..">
								</div>
								<div class="field">
									<label>Name - <?= $setting->setting__system_language2; ?> <span class="color-red warning"></span></label>
									<input id="brand-name-lang-add" type="text" class="data-important-add" placeholder="Name..">
								</div>
							</div>
						<? else: ?>
							<div class="field">
								<label>Name<span class="color-red warning"></span></label>
								<input id="brand-name-add" type="text" class="data-important-add" placeholder="Name..">
							</div>
						<? endif; ?>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="addbrand();">Submit</div>
			</div>
		</div>
	</div>

	<div class="ui modal edit-brand-modal">
		<i class="close icon"></i>
		<div class="header">Edit Brand</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<? if ($setting->setting__website_enabled_dual_language > 0): ?>
							<div class="two fields">
								<div class="field">
									<label>Name - <?= $setting->setting__system_language; ?> <span class="color-red warning"></span></label>
									<input id="brand-name-edit" class="data-important-edit" placeholder="Name..">
								</div>
								<div class="field">
									<label>Name - <?= $setting->setting__system_language2; ?> <span class="color-red warning"></span></label>
									<input id="brand-name-lang-edit" class="data-important-edit" placeholder="Name..">
								</div>
							</div>
						<? else: ?>
							<div class="field">
								<label>Name<span class="color-red warning"></span></label>
								<input id="brand-name-edit" class="data-important-edit" placeholder="Name..">
							</div>
						<? endif; ?>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="editbrand();">Submit</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item">
				Data - Product - Brand List
			</div>
			<div class="right menu">
				<? if (isset($acl['brand']) && $acl['brand']->add > 0): ?>
					<a class="item item-add-button">
						<i class="add circle icon"></i> Add Brand
					</a>
				<? endif; ?>
				<div class="item">
					<div class="ui dropdown dropdown-filter">
						<div class="text"><?= ucwords($filter); ?></div>
						<i class="dropdown icon"></i>
						<div class="menu">
							<div class="item" onclick="changeFilter('all');">All</div>
						</div>
					</div>
				</div>
				<div class="ui right aligned brand search item search-item-container">
					<div class="ui transparent icon input">
						<input class="input-search" placeholder="Search..." type="text">
						<i class="search link icon"></i>
					</div>
					<div class="results"></div>
				</div>
			</div>
		</div>
		<div class="ui bottom attached segment table-segment">
			<table class="ui striped selectable sortable celled table">
				<thead>
					<tr>
						<th class="td-icon">Action</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_brand) <= 0): ?>
						<tr>
							<td colspan="2">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_brand as $brand): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['brand']) && $acl['brand']->edit > 0): ?>
										<a onclick="getbrand('<?= $brand->id; ?>');">
											<span class="table-icon">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['brand']) && $acl['brand']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-brand-id="<?= $brand->id; ?>" data-brand-name="<?= $brand->name; ?>" data-brand-updated="<?= $brand->updated; ?>">
											<span class="table-icon">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $brand->name; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">
							<button class="ui button button-prev">Prev</button>
							<span>
								<div class="ui input input-page">
									<input id="input-page" placeholder="" type="text">
								</div> / <?= $count_page; ?>
							</span>
							<button class="ui button button-next">Next</button>
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</body>
</html>