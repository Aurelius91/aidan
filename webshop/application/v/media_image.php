	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			reset();
			init();
			mediaImageKeypress();
			mediaImageClick();
		});

		function changeFilter(f) {
			filterQuery = f;
		}

		function addmediaImage() {
			var mediaImageName = $('#media-image-name-add').val();
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

			$('.add-media-image-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: mediaImageName,
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

						$('.add-media-image-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>media_image/ajax_add/',
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

		function deletemediaImage() {
			var mediaImageId = $('.delete-media-image-button').attr('data-media-image-id');
			var mediaImageUpdated = $('.delete-media-image-button').attr('data-media-image-updated');

			$('.ui.basic.modal.modal-warning-delete').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					updated: mediaImageUpdated,
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
				url : '<?= base_url() ?>image/ajax_delete/'+ mediaImageId +'/',
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

		function editmediaImage() {
			var mediaImageName = $('#media-image-name-edit').val();
			var mediaImageId = $('#media-image-name-edit').data('media_image_id');
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

			$('.edit-media-image-modal').modal('hide');
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					name: mediaImageName,
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

						$('.edit-media-image-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>media_image/ajax_edit/'+ mediaImageId +'/',
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

			window.location.href = '<?= base_url(); ?>media_image/view/'+ page +'/'+ filterQuery +'/'+ searchQuery +'/';
		}

		function getmediaImage(mediaImageId) {
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

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
						$('.ui.dimmer.all-loader').dimmer('hide');

						$('#media-image-name-edit').val(data.media_image.name);
						$('#media-image-name-edit').data('media_image_id', mediaImageId);

						$('.edit-media-image-modal').modal({
							inverted: true,
						}).modal('show');
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-media-image-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>media_image/ajax_get/'+ mediaImageId +'/',
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
		}

		function reset() {
			$('#media-image-name-add').val("");
		}

		function mediaImageClick() {
			$('.item-add-button').click(function() {
				$('#media-image-name-add').val("");
				$('.color-red.warning').html("");

				$('.add-media-image-modal').modal({
					inverted: true,
				}).modal('show');
			});

			$('.open-modal-warning-delete').click(function() {
				var mediaImageId = $(this).attr('data-media-image-id');
				var mediaImageName = $(this).attr('data-media-image-name');
				var mediaImageUpdated = $(this).attr('data-media-image-updated');

				$('.delete-media-image-title').html('Delete media_image ' + mediaImageName);
				$('.delete-media-image-button').attr('data-media-image-id', mediaImageId);
				$('.delete-media-image-button').attr('data-media-image-updated', mediaImageUpdated);

				$('.ui.basic.modal.modal-warning-delete').modal('show');
			});
		}

		function mediaImageKeypress() {
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

		function uploadmediaImage() {
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			var file_data = $('#media-image-name-add').prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append("<?= $csrf['name'] ?>", "<?= $csrf['hash'] ?>");

			$('.bar').width(0);
			$('#loading').modal('show');

			$.ajax({
				cache: false,
				contentType: false,
				data: form_data,
				dataType: 'JSON',
				error: function() {
					$('.ui.dimmer.all-loader').dimmer('hide');
					$('.ui.basic.modal.all-error').modal('show');
					$('.all-error-text').html('Server Error.');
				},
				processData: false,
				type: 'post',
				success: function(data) {
					if (data.status == 'success') {
						$('.ui.text.loader').html('Redirecting...');

						window.location.reload();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.color-red.warning').html(data.message);

						$('.add-media-image-modal').modal({
							inverted: true,
						}).modal('show');
					}
				},
				url: '<?= base_url(); ?>image/ajax_upload_media/<?= $media->id; ?>',
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
		}
	</script>

	<!-- Dashboard Here -->
	<div class="ui basic modal modal-warning-delete">
		<div class="ui icon header">
			<i class="trash outline icon delete-icon"></i>
			<span class="delete-media-image-title">Delete media Image</span>
		</div>
		<div class="content text-center">
			<p>You're about to delete this media Image. You will not be able to undo this action. Are you sure?</p>
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">
				<i class="remove icon"></i>
				No
			</div>
			<div class="ui green ok inverted button delete-media-image-button" onclick="deletemediaImage();">
				<i class="checkmark icon"></i>
				Yes
			</div>
		</div>
	</div>

	<div class="ui modal add-media-image-modal">
		<i class="close icon"></i>
		<div class="header">Add media Image - <?= $media->name; ?></div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="ui form">
						<div class="field">
							<label>Name <span class="color-red warning"></label>
							<input id="media-image-name-add" type="file" accept="image/*" class="data-important-add" placeholder="Name..">
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-right">
				<div class="ui deny button form-button">Exit</div>
				<div class="ui button form-button" onclick="uploadmediaImage();">Submit</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<a class="item" href="<?= base_url(); ?>media/view/1/">
				<i class="arrow left icon"></i> Back
			</a>
			<div class="item">
				Media Image - <?= $media->name; ?>
			</div>
			<div class="right menu">
				<? if (isset($acl['website']) && $acl['website']->add > 0): ?>
					<a class="item item-add-button">
						<i class="add circle icon"></i> Add Media Image
					</a>
				<? endif; ?>
			</div>
		</div>
		<div class="ui bottom attached segment table-segment">
			<table class="ui striped selectable celled table">
				<thead>
					<tr>
						<th class="td-icon">Action</th>
						<th>Image</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_image) <= 0): ?>
						<tr>
							<td colspan="3">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_image as $image): ?>
							<tr>
								<td class="td-icon">
									<? if (isset($acl['website']) && $acl['website']->delete > 0): ?>
										<a class="open-modal-warning-delete" data-media-image-id="<?= $image->id; ?>" data-media-image-name="<?= $image->name; ?>" data-media-image-updated="<?= $image->updated; ?>">
											<span class="table-icon">
												<i class="trash outline icon"></i>
											</span>
										</a>
									<? endif; ?>
								</td>
								<td>
									<a href="<?= base_url(); ?>images/website/<?= $image->image_name; ?>" target="_blank">
										<img src="<?= base_url(); ?>images/website/<?= $image->image_name; ?>" style="height: 75px;">
									</a>
								</td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>