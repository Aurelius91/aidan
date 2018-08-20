	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			colorKeypress();
			colorClick();
			onChange();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function addcolor() {
			var colorName = $('#color-name-add').val();
			var colorhex = $('#color-hex-add').val();
			var colorImage = $('#color-image-add').data('image_id');
			var found = 0;

			$.each($('.data-important-add'), function(key, data) {
				if ($(data).val() == '') {
					found += 1;

					$('.color-red.warning').html('This Field Must Be Filled');
				}
			});

			if (found > 0) {
				return;
			}

			$('.add-color-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: colorName,
					hex: colorhex,
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

						$('.add-color-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>color/ajax_add/',
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

		function deletecolor() {
			var colorId = $('.delete-color-button').attr('data-color-id');
			var colorUpdated = $('.delete-color-button').attr('data-color-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: colorUpdated,
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
				url : '<?= base_url() ?>color/ajax_delete/'+ colorId +'/',
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

		function editcolor() {
			var colorName = $('#color-name-edit').val();
			var colorhex = $('#color-hex-edit').val();

			var colorId = $('#color-name-edit').data('color_id');
			var colorUpdated = $('#color-name-edit').data('updated');
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

			$('.edit-color-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: colorName,
					hex: colorhex,
					updated: colorUpdated,
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

						$('.edit-color-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>color/ajax_edit/'+ colorId +'/',
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

			window.location.href = '<?= base_url(); ?>color/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function getcolor(colorId) {
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
						$('#color-name-edit').val(data.color.name);
						$('#color-hex-edit').val(data.color.hex);
						$('#color-image-edit').val("");
						$('#color-image-edit').data('image_id', 0);

						$('#color-name-edit').data('color_id', colorId);
						$('#color-name-edit').data('updated', data.color.updated);

						$('.edit-color-modal').modal({
							inverted: false,
						}).modal('show');
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-color-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>color/ajax_get/'+ colorId +'/',
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
			$('#color-image-add').change(function() {
				var file_data = $('#color-image-add').prop('files')[0];
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
							$('#color-image-add').data('image_id', data.image_id);

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

			$('#color-image-edit').change(function() {
				var file_data = $('#color-image-edit').prop('files')[0];
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
							$('#color-image-edit').data('image_id', data.image_id);

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

			$('#color-name-add').val("");
			$('#color-name-lang-add').val("");
		}

		function colorClick() {
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
				$('#color-name-add').val("");
				$('.color-red.warning').html("");

				$('.add-color-modal').modal({
					inverted: false,
				}).modal('show');
			});

			$('.open-modal-warning-delete').click(function() {
				var colorId = $(this).attr('data-color-id');
				var colorName = $(this).attr('data-color-name');
				var colorUpdated = $(this).attr('data-color-updated');

				$('.delete-color-title').html('Delete color ' + colorName);
				$('.delete-color-button').attr('data-color-id', colorId);
				$('.delete-color-button').attr('data-color-updated', colorUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function colorKeypress() {
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
			<span class="delete-color-title">Delete color</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this color. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-color-button" onclick="deletecolor();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="ui modal add-color-modal">
		<i class="close icon"></i>
		<div class="header">Add color</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="two fields">
							<div class="field">
								<label>Name <span class="color-red warning"></span></label>
								<input id="color-name-add" type="text" class="data-important-add" placeholder="Name..">
							</div>
							<div class="field">
								<label>Hex <span class="color-red warning"></span></label>
								<input id="color-hex-add" type="text" class="data-important-add" placeholder="Hex..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="addcolor();">Submit</div>
			</div>
		</div>
	</div>

	<div class="ui modal edit-color-modal">
		<i class="close icon"></i>
		<div class="header">Edit color</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="two fields">
							<div class="field">
								<label>Name <span class="color-red warning"></span></label>
								<input id="color-name-edit" class="data-important-edit" placeholder="Name..">
							</div>
							<div class="field">
								<label>Hex <span class="color-red warning"></span></label>
								<input id="color-hex-edit" type="text" class="data-important-edit" placeholder="Hex..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="editcolor();">Submit</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item">
				Data - Product - color
			</div>
			<div class="right menu">
				<? if (isset($acl['color']) && $acl['color']->add > 0): ?>
					<a class="item item-add-button">
						<i class="add circle icon"></i> Add color
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
				<div class="ui right aligned color search item search-item-container">
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
					<? if (count($arr_color) <= 0): ?>
						<tr>
							<td colspan="3">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_color as $color): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['color']) && $acl['color']->edit > 0): ?>
										<a onclick="getcolor('<?= $color->id; ?>');">
											<span class="table-icon">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['color']) && $acl['color']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-color-id="<?= $color->id; ?>" data-color-name="<?= $color->name; ?>" data-color-updated="<?= $color->updated; ?>">
											<span class="table-icon">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $color->name; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3">
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