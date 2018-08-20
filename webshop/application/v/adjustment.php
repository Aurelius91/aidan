	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			adjustmentKeypress();
			adjustmentClick();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function deleteAdjustment() {
			var adjustmentId = $('.delete-adjustment-button').attr('data-adjustment-id');
			var adjustmentUpdated = $('.delete-adjustment-button').attr('data-adjustment-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: adjustmentUpdated,
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
				url : '<?= base_url() ?>adjustment/ajax_delete/'+ adjustmentId +'/',
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

			window.location.href = '<?= base_url(); ?>adjustment/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
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

		function adjustmentClick() {
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
				var adjustmentId = $(this).attr('data-adjustment-id');
				var adjustmentName = $(this).attr('data-adjustment-name');
				var adjustmentUpdated = $(this).attr('data-adjustment-updated');

				$('.delete-adjustment-title').html('Delete adjustment ' + adjustmentName);
				$('.delete-adjustment-button').attr('data-adjustment-id', adjustmentId);
				$('.delete-adjustment-button').attr('data-adjustment-updated', adjustmentUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function adjustmentKeypress() {
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
			<span class="delete-adjustment-title">Delete adjustment</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this adjustment. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-adjustment-button" onclick="deleteAdjustment();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item item-add-button">
				Inventory - Adjustment Lists
			</div>
			<div class="right menu">
				<? if (isset($acl['adjustment']) && $acl['adjustment']->add != ''): ?>
					<a class="item item-add-button" href="<?= base_url(); ?>adjustment/add/">
						<i class="add circle icon"></i> Add Adjustment
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
						<th>Date</th>
						<th>Location</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_adjustment) <= 0): ?>
						<tr>
							<td colspan="4">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_adjustment as $adjustment): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['adjustment']) && $acl['adjustment']->edit > 0): ?>
										<a href="<?= base_url(); ?>adjustment/edit/<?= $adjustment->id; ?>/">
											<span class="table-icon" data-content="Edit adjustment">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['adjustment']) && $acl['adjustment']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-adjustment-id="<?= $adjustment->id; ?>" data-adjustment-name="<?= $adjustment->name; ?>" data-adjustment-updated="<?= $adjustment->updated; ?>">
											<span class="table-icon" data-content="Delete adjustment">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $adjustment->number; ?></td>
								<td><?= $adjustment->date; ?></td>
								<td><?= $adjustment->location_name; ?></td>
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