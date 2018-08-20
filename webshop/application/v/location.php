	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			locationKeypress();
			locationClick();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function deleteLocation() {
			var locationId = $('.delete-location-button').attr('data-location-id');
			var locationUpdated = $('.delete-location-button').attr('data-location-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: locationUpdated,
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
				url : '<?= base_url() ?>location/ajax_delete/'+ locationId +'/',
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

			window.location.href = '<?= base_url(); ?>location/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
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

		function locationClick() {
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
				var locationId = $(this).attr('data-location-id');
				var locationName = $(this).attr('data-location-name');
				var locationUpdated = $(this).attr('data-location-updated');

				$('.delete-location-title').html('Delete location ' + locationName);
				$('.delete-location-button').attr('data-location-id', locationId);
				$('.delete-location-button').attr('data-location-updated', locationUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function locationKeypress() {
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
			<span class="delete-location-title">Delete Location</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this location. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-location-button" onclick="deleteLocation();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item item-add-button">
				Data - Location Lists
			</div>
			<div class="right menu">
				<? if (isset($acl['location']) && $acl['location']->add != ''): ?>
					<a class="item item-add-button" href="<?= base_url(); ?>location/add/">
						<i class="add circle icon"></i> Add Location
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
						<th>Name</th>
						<th>Phone</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_location) <= 0): ?>
						<tr>
							<td colspan="4">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_location as $location): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['location']) && $acl['location']->edit > 0): ?>
										<a href="<?= base_url(); ?>location/edit/<?= $location->id; ?>/">
											<span class="table-icon" data-content="Edit location">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['location']) && $acl['location']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-location-id="<?= $location->id; ?>" data-location-name="<?= $location->name; ?>" data-location-updated="<?= $location->updated; ?>">
											<span class="table-icon" data-content="Delete location">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['room']) && $acl['room']->list > 0): ?>
										<a href="<?= base_url(); ?>location_room/view/<?= $location->id; ?>/">
											<span class="table-icon" data-content="View Room">
												<i class="clipboard check icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $location->name; ?></td>
								<td><?= $location->phone; ?></td>
								<td><?= $location->email; ?></td>
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