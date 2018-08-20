	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			alteregoKeypress();
			alteregoClick();
		});

		var filterQuery = '<?= $filter; ?>';

		function changeFilter(f) {
			filterQuery = f;
		}

		function deletealterego() {
			var alteregoId = $('.delete-alterego-button').attr('data-alterego-id');
			var alteregoUpdated = $('.delete-alterego-button').attr('data-alterego-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: alteregoUpdated,
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
				url : '<?= base_url() ?>alterego/ajax_delete/'+ alteregoId +'/',
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

			window.location.href = '<?= base_url(); ?>alterego/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
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

		function alteregoClick() {
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
				var alteregoId = $(this).attr('data-alterego-id');
				var alteregoName = $(this).attr('data-alterego-name');
				var alteregoUpdated = $(this).attr('data-alterego-updated');

				$('.delete-alterego-title').html('Delete alterego ' + alteregoName);
				$('.delete-alterego-button').attr('data-alterego-id', alteregoId);
				$('.delete-alterego-button').attr('data-alterego-updated', alteregoUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function alteregoKeypress() {
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
			<span class="delete-alterego-title">Delete Alter Ego</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this alterego. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-alterego-button" onclick="deletealterego();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item item-add-button">
				Data - Alter Ego Lists
			</div>
			<div class="right menu">
				<? if (isset($acl['alterego']) && $acl['alterego']->add != ''): ?>
					<a class="item item-add-button" href="<?= base_url(); ?>alterego/add/">
						<i class="add circle icon"></i> Add Alter Ego
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
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_alterego) <= 0): ?>
						<tr>
							<td colspan="4">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_alterego as $alterego): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['alterego']) && $acl['alterego']->edit > 0): ?>
										<a href="<?= base_url(); ?>alterego/edit/<?= $alterego->id; ?>/">
											<span class="table-icon" data-content="Edit alterego">
												<i class="edit icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['alterego']) && $acl['alterego']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-alterego-id="<?= $alterego->id; ?>" data-alterego-name="<?= $alterego->name; ?>" data-alterego-updated="<?= $alterego->updated; ?>">
											<span class="table-icon" data-content="Delete alterego">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>

									<? if (isset($acl['room']) && $acl['room']->list > 0): ?>
										<a href="<?= base_url(); ?>alterego_room/view/<?= $alterego->id; ?>/">
											<span class="table-icon" data-content="View Room">
												<i class="clipboard check icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td><?= $alterego->name; ?></td>
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