	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			currencyKeypress();
			currencyClick();
			onChange();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function addCurrency() {
			var currencyName = $('#currency-name-add').val();
			var currencyExchange = $('#currency-exchange-add').val();
			var currencyReal = $('#currency-exchange-real-add').val();
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

			$('.add-currency-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: currencyName,
					currency_exchange: currencyExchange,
					currency_real: currencyReal,
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

						$('.add-currency-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>currency/ajax_add/',
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

		function deleteCurrency() {
			var currencyId = $('.delete-currency-button').attr('data-currency-id');
			var currencyUpdated = $('.delete-currency-button').attr('data-currency-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: currencyUpdated,
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
				url : '<?= base_url() ?>currency/ajax_delete/'+ currencyId +'/',
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

		function editCurrency() {
			var currencyName = $('#currency-name-edit').val();
			var currencyExchange = $('#currency-exchange-edit').val();
			var currencyReal = $('#currency-exchange-real-edit').val();

			var currencyId = $('#currency-name-edit').data('currency_id');
			var currencyUpdated = $('#currency-name-edit').data('updated');
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

			$('.edit-currency-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: currencyName,
					currency_exchange: currencyExchange,
					currency_real: currencyReal,
					updated: currencyUpdated,
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

						$('.edit-currency-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>currency/ajax_edit/'+ currencyId +'/',
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

			window.location.href = '<?= base_url(); ?>currency/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function getCurrency(currencyId) {
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
						$('#currency-name-edit').val(data.currency.name);
						$('#currency-exchange-edit').val(data.currency.currency_exchange);
						$('#currency-exchange-real-edit').val(data.currency.currency_real);

						$('#currency-image-edit').val("");
						$('#currency-image-edit').data('image_id', 0);

						$('#currency-name-edit').data('currency_id', currencyId);
						$('#currency-name-edit').data('updated', data.currency.updated);

						$('.edit-currency-modal').modal({
							inverted: false,
						}).modal('show');
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-currency-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>currency/ajax_get/'+ currencyId +'/',
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
			$('#currency-image-add').change(function() {
				var file_data = $('#currency-image-add').prop('files')[0];
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
							$('#currency-image-add').data('image_id', data.image_id);

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

			$('#currency-image-edit').change(function() {
				var file_data = $('#currency-image-edit').prop('files')[0];
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
							$('#currency-image-edit').data('image_id', data.image_id);

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

			$('#currency-name-add').val("");
			$('#currency-exchange-add').val("1");
		}

		function currencyClick() {
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
				$('#currency-name-add').val("");
				$('#currency-exchange-add').val("1");
				$('.color-red.warning').html("");

				$('.add-currency-modal').modal({
					inverted: false,
				}).modal('show');
			});

			$('.open-modal-warning-delete').click(function() {
				var currencyId = $(this).attr('data-currency-id');
				var currencyName = $(this).attr('data-currency-name');
				var currencyUpdated = $(this).attr('data-currency-updated');

				$('.delete-currency-title').html('Delete currency ' + currencyName);
				$('.delete-currency-button').attr('data-currency-id', currencyId);
				$('.delete-currency-button').attr('data-currency-updated', currencyUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function currencyKeypress() {
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
			<span class="delete-currency-title">Delete currency</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this currency. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-currency-button" onclick="deleteCurrency();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="ui modal add-currency-modal">
		<i class="close icon"></i>
		<div class="header">Add Currency</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="three fields">
							<div class="field">
								<label>Name <span class="color-red warning"></span></label>
								<input id="currency-name-add" type="text" class="data-important-add" placeholder="Name..">
							</div>
							<div class="field">
								<label>Currency Exchange to IDR <span class="color-red warning"></span></label>
								<input id="currency-exchange-add" type="text" class="data-important-add" placeholder="Currency Exchange to IDR..">
							</div>
							<div class="field">
								<label>Currency Exchange to IDR (Real)<span class="color-red warning"></span></label>
								<input id="currency-exchange-real-add" type="text" class="data-important-add" placeholder="Currency Exchange to IDR..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="addCurrency();">Submit</div>
			</div>
		</div>
	</div>

	<div class="ui modal edit-currency-modal">
		<i class="close icon"></i>
		<div class="header">Edit Currency</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="three fields">
							<div class="field">
								<label>Name <span class="color-red warning"></span></label>
								<input id="currency-name-edit" class="data-important-edit" placeholder="Name..">
							</div>
							<div class="field">
								<label>Currency Exchange to IDR <span class="color-red warning"></span></label>
								<input id="currency-exchange-edit" class="data-important-edit" placeholder="Currency Exchange to IDR..">
							</div>
							<div class="field">
								<label>Currency Exchange to IDR (Real)<span class="color-red warning"></span></label>
								<input id="currency-exchange-real-edit" type="text" class="data-important-edit" placeholder="Currency Exchange to IDR..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="editCurrency();">Submit</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item">
				Data - Currency
			</div>
			<div class="right menu">
				<? if (isset($acl['currency']) && $acl['currency']->add > 0): ?>
					<a class="item item-add-button">
						<i class="add circle icon"></i> Add Currency
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
				<div class="ui right aligned currency search item search-item-container">
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
						<th>Currency Exchange to IDR</th>
						<th>Real Currency Exchange to IDR</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_currency) <= 0): ?>
						<tr>
							<td colspan="4">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_currency as $currency): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['currency']) && $acl['currency']->edit > 0): ?>
										<a onclick="getCurrency('<?= $currency->id; ?>');">
											<span class="table-icon">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['currency']) && $acl['currency']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-currency-id="<?= $currency->id; ?>" data-currency-name="<?= $currency->name; ?>" data-currency-updated="<?= $currency->updated; ?>">
											<span class="table-icon">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $currency->name; ?></td>
								<td>Rp <?= $currency->currency_exchange; ?></td>
								<td>Rp <?= $currency->currency_real; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4">
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