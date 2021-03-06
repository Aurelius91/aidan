	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			saleKeypress();
			saleClick();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function deletesale() {
			var saleId = $('.delete-sale-button').attr('data-sale-id');
			var saleUpdated = $('.delete-sale-button').attr('data-sale-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: saleUpdated,
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
				url : '<?= base_url() ?>sale/ajax_delete/'+ saleId +'/',
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

		function filter(page) {
			var searchQuery = ($('.input-search').val() == '') ? '' : $.base64('encode', $('.input-search').val());

			window.location.href = '<?= base_url(); ?>sale/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function init() {
			$('.dropdown-search, .dropdown-filter').dropdown({
				allowAdditions: true
			});

			$('table').tablesort();
		}

		function reset() {
			$('.input-search').val("<?= $query; ?>");
			$('#input-page').val("<?= $page; ?>");
		}

		function saleClick() {
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

			$('.open-modal-warning-delete').click(function() {
				var saleId = $(this).attr('data-sale-id');
				var saleName = $(this).attr('data-sale-name');
				var saleUpdated = $(this).attr('data-sale-updated');

				$('.delete-sale-title').html('Delete sale ' + saleName);
				$('.delete-sale-button').attr('data-sale-id', saleId);
				$('.delete-sale-button').attr('data-sale-updated', saleUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function saleKeypress() {
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
			<span class="delete-sale-title">Delete Sale</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this sale. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-sale-button" onclick="deletesale();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item item-add-button">
				Inventory - Sale Lists
			</div>
			<div class="right menu">
				<? if (isset($acl['sale']) && $acl['sale']->add > 0): ?>
					<a class="item item-add-button" href="<?= base_url(); ?>sale/add/">
						<i class="add circle icon"></i> Add Sale
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
				<div class="ui right aligned category search item search-item-container">
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
						<th>Number</th>
						<th>Customer</th>
						<th>Date</th>
						<th>Location</th>
						<th>Total</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_sale) <= 0): ?>
						<tr>
							<td colspan="11">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_sale as $sale): ?>
							<tr>
								<td class="td-icon">
									<? if ($setting->system_mac != 'webshop_2_aidan'): ?>
										<? if (isset($acl['sale']) && $acl['sale']->edit > 0): ?>
											<a href="<?= base_url(); ?>sale/edit/<?= $sale->id; ?>/">
												<span class="table-icon" data-content="Edit sale">
													<i class="edit icon"></i>
												</span>
											</a>
										<? endif; ?>
									<? else: ?>
										<a href="<?= base_url(); ?>sale/edit/<?= $sale->id; ?>/">
											<span class="table-icon" data-content="View sale">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>


									<? if (isset($acl['sale']) && $acl['sale']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-sale-id="<?= $sale->id; ?>" data-sale-name="<?= $sale->name; ?>" data-sale-updated="<?= $sale->updated; ?>">
											<span class="table-icon" data-content="Delete sale">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['payment']) && $acl['payment']->list > 0): ?>
										<a href="<?= base_url(); ?>payment/view/sale/<?= $sale->id; ?>/">
											<span class="table-icon" data-content="Payment">
												<i class="credit card outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><? if ($sale->draft > 0): ?>[DRAFT]<? endif; ?> <?= $sale->number; ?></td>

								<? if ($sale->customer_id > 0): ?>
									<td><?= $sale->customer_name; ?></td>
								<? else: ?>
									<td><?= $sale->shipping_name; ?></td>
								<? endif; ?>

								<td><?= $sale->date_display; ?></td>
								<td><?= $sale->location_name; ?></td>
								<td>Rp. <?= $sale->total; ?></td>
								<td><?= $sale->status; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="11">
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