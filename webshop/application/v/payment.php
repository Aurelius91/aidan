	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			paymentKeypress();
			paymentClick();
			onChange();
		});

		var filterQuery = '';

		function changeFilter(f) {
			filterQuery = f;
		}

		function addPayment() {
			var paymentDate = $('#payment-date-add').val();
			var paymentAmount = $('#payment-amount-add').val();
			var paymentStatement = $('#payment-statement-add').val();
			var found = 0;

			$.each($('.data-important-add'), function(key, data) {
				if ($(data).val() == '') {
					found += 1;

					$('.color-red.warning').html('This Field Must Be Filled');
				}
			});

			if (parseInt(paymentAmount) <= 0) {
				found += 1;

				$('#payment-amount-add').prev().children().html('Amount Must not be 0').show();
			}

			if (found > 0) {
				return;
			}

			$('.add-payment-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					date: paymentDate,
					amount: paymentAmount,
					statement_id: paymentStatement,
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

						$('.add-payment-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>payment/ajax_add/<?= strtolower($type); ?>/<?= $content->id; ?>',
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

		function deletePayment() {
			var paymentId = $('.delete-payment-button').attr('data-payment-id');
			var paymentUpdated = $('.delete-payment-button').attr('data-payment-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: paymentUpdated,
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
				url : '<?= base_url() ?>payment/ajax_delete/'+ paymentId +'/',
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

		function editPayment() {
			var paymentName = $('#payment-name-edit').val();
			var paymentNameLang = $('#payment-name-lang-edit').val();

			var paymentId = $('#payment-name-edit').data('payment_id');
			var paymentUpdated = $('#payment-name-edit').data('updated');
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

			$('.edit-payment-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: paymentName,
					name_lang: paymentNameLang,
					updated: paymentUpdated,
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

						$('.edit-payment-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>payment/ajax_edit/'+ paymentId +'/',
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

			window.location.href = '<?= base_url(); ?>payment/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function getPayment(paymentId) {
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
						$('#payment-name-edit').val(data.payment.name);
						$('#payment-name-lang-edit').val(data.payment.name_lang);
						$('#payment-type-container-edit').dropdown('set selected', data.payment.type);
						$('#payment-image-edit').val("");
						$('#payment-image-edit').data('image_id', 0);

						$('#payment-name-edit').data('payment_id', paymentId);
						$('#payment-name-edit').data('updated', data.payment.updated);

						$('.edit-payment-modal').modal({
							inverted: false,
						}).modal('show');
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-payment-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>payment/ajax_get/'+ paymentId +'/',
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

			$('#payment-date-add').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });

            $('table').tablesort();
		}

		function onChange() {
			$('#payment-image-add').change(function() {
				var file_data = $('#payment-image-add').prop('files')[0];
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
							$('#payment-image-add').data('image_id', data.image_id);

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

			$('#payment-image-edit').change(function() {
				var file_data = $('#payment-image-edit').prop('files')[0];
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
							$('#payment-image-edit').data('image_id', data.image_id);

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
			$('#payment-number-add').val("<?= $content->number; ?>");
			$('#payment-remain-add').val("<?= $remain_display; ?>");
			$('#payment-date-add').val("<?= $date_display; ?>");
			$('#payment-amount-add').val("0");

			$('#payment-statement-add').val("<?= $arr_statement[0]->id; ?>");
			$('#payment-statement-container-add').dropdown('set selected', "<?= $arr_statement[0]->id; ?>");
		}

		function paymentClick() {
			$('.button-prev').click(function() {
				var page = 0;

				page = page - 1 ;

				if (page <= 0) {
					return;
				}

				filter(page);
			});

			$('.button-next').click(function() {
				var page = 0;
				var maxPage = 0;

				page = page + 1 ;

				if (page > maxPage) {
					return;
				}

				filter(page);
			});

			$('.item-add-button').click(function() {
				$('#payment-number-add').val("<?= $content->number; ?>");
				$('#payment-remain-add').val("<?= $remain_display; ?>");
				$('#payment-date-add').val("<?= $date_display; ?>");
				$('#payment-amount-add').val("0");

				$('#payment-statement-add').val("<?= $arr_statement[0]->id; ?>");
				$('#payment-statement-container-add').dropdown('set selected', "<?= $arr_statement[0]->id; ?>");

				$('.color-red.warning').html("");

				$('.add-payment-modal').modal({
					inverted: false,
				}).modal('show');
			});

			$('.open-modal-warning-delete').click(function() {
				var paymentId = $(this).attr('data-payment-id');
				var paymentName = $(this).attr('data-payment-name');
				var paymentUpdated = $(this).attr('data-payment-updated');

				$('.delete-payment-title').html('Delete payment ' + paymentName);
				$('.delete-payment-button').attr('data-payment-id', paymentId);
				$('.delete-payment-button').attr('data-payment-updated', paymentUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function paymentKeypress() {
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
			<span class="delete-payment-title">Delete payment</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this payment. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-payment-button" onclick="deletePayment();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="ui modal add-payment-modal">
		<i class="close icon"></i>
		<div class="header">Add Payment</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="two fields">
							<div class="field">
								<label><?= $type; ?> Number</label>
								<input id="payment-number-add" type="text" placeholder="Name.." disabled>
							</div>
							<div class="field">
								<label>Remaining</label>
								<input id="payment-remain-add" type="text" placeholder="Name.."disabled>
							</div>
						</div>

						<div class="three fields">
							<div class="field">
								<label>Account</label>
								<div id="payment-statement-container-add" class="ui search selection dropdown form-input">
									<input id="payment-statement-add" type="hidden" class="data-important">
									<i class="dropdown icon"></i>
									<div class="default text">-- Select Account --</div>
									<div class="menu">
										<? foreach ($arr_statement as $statement): ?>
											<div class="item" data-value="<?= $statement->id; ?>"><?= $statement->name; ?></div>
										<? endforeach; ?>
									</div>
								</div>
							</div>
							<div class="field">
								<label>Date <span class="color-red warning"></span></label>
								<input id="payment-date-add" type="text" class="data-important-add" placeholder="Date..">
							</div>
							<div class="field">
								<label>Amount Paid <span class="color-red warning"></span></label>
								<input id="payment-amount-add" type="text" class="data-important-add" placeholder="Amount..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="addPayment();">Submit</div>
			</div>
		</div>
	</div>

	<div class="ui modal edit-payment-modal">
		<i class="close icon"></i>
		<div class="header">Edit Payment</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="two fields">
							<div class="field">
								<label>Name - <?= $setting->setting__system_language; ?> <span class="color-red warning"></span></label>
								<input id="payment-name-edit" class="data-important-edit" placeholder="Name..">
							</div>
							<div class="field">
								<label>Name - <?= $setting->setting__system_language2; ?> <span class="color-red warning"></span></label>
								<input id="payment-name-lang-edit" class="data-important-edit" placeholder="Name..">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="editPayment();">Submit</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<a class="item" href="<?= base_url(); ?><?= strtolower($type); ?>/view/1/">
				<i class="arrow left icon"></i> Back
			</a>
			<div class="item">
				<?= $type; ?> - Payment (<?= $content->number ;?>)
			</div>
			<div class="right menu">
				<? if ($remain > 0): ?>
					<? if (isset($acl['payment']) && $acl['payment']->add > 0): ?>
						<a class="item item-add-button">
							<i class="add circle icon"></i> Add Payment
						</a>
					<? endif; ?>
				<? endif; ?>
			</div>
		</div>
		<div class="ui bottom attached segment table-segment">
			<table class="ui striped selectable sortable celled table">
				<thead>
					<tr>
						<th class="td-icon">Action</th>
						<th>Date</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_payment) <= 0): ?>
						<tr>
							<td colspan="3">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_payment as $payment): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['payment']) && $acl['payment']->edit > 0): ?>
										<a onclick="getPayment('<?= $payment->id; ?>');">
											<span class="table-icon">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['payment']) && $acl['payment']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-payment-id="<?= $payment->id; ?>" data-payment-name="<?= $payment->name; ?>" data-payment-updated="<?= $payment->updated; ?>">
											<span class="table-icon">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $payment->date_display; ?></td>
								<td><?= $payment->amount_display; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>