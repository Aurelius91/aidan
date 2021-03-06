	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			click();
			init();
			reset();
			change();
			changeProduct();
			keyUpAdjustment();
		});

		function addProduct() {
			var number = 0;
			$('.adjustment-add-product').remove();

			$.each($('.adjustment-product-list'), function(key, item) {
				number = $(item).attr('data-number');
			});

			var nextNumber = parseInt(number) + 1;

			var newItemList = '<tr id="adjustment-item-list-'+ nextNumber +'" class="adjustment-product-list" data-number="'+ nextNumber +'"><td class="td-icon"><span class="table-icon" data-content="Remove Item" onclick="removeItem('+ nextNumber +');"><i class="trash outline icon"></i></span></td><td><div id="adjustment-product-selection-'+ nextNumber +'" class="ui search selection dropdown form-input"><input id="adjustment-product-'+ nextNumber +'" class="adjustment-product-list-selection" data-number="'+ nextNumber +'" type="hidden" class="data-important"><i class="dropdown icon"></i><div class="default text">-- Select Product --</div><div class="menu"><? foreach ($arr_product as $product): ?><div class="item" data-value="<?= $product->id; ?>"><?= $product->name; ?></div><? endforeach; ?></div></div></td><td style="text-align: right;"><input id="adjustment-product-quantity-'+ nextNumber +'" type="text" class="adjustment-item-quantity" data-number="'+ nextNumber +'" placeholder="Quantity.."></td></tr><tr><td class="adjustment-add-product" style="cursor: pointer;" colspan="3" onclick="addProduct();"><span><i class="plus circle icon"></i></span> Add Product</td></tr>';

			$('#adjustment-item-list').append(newItemList);
			$('#adjustment-product-quantity-'+ nextNumber).val("0");
			$('#adjustment-product-selection-'+ nextNumber).dropdown('clear');

			changeProduct();
			keyUpAdjustment();
		}

		function back() {
			window.location.href = '<?= base_url(); ?>adjustment/view/1/';
		}

		function calculateQuantity(number) {
			var inventoryQuantity = $('#data-inventory-quantity-'+ number).html();
			var inputQuantity = ($('#adjustment-product-quantity-'+ number).val() != '') ? $('#adjustment-product-quantity-'+ number).val() : 0;

			var fixedQuantity = parseInt(inventoryQuantity) - parseInt(inputQuantity);

			$('#data-inventory-quantity-fix-'+ number).html(fixedQuantity);
		}

		function change() {
			$('#adjustment-status').change(function() {
				if ($('#adjustment-status').val() == 'Shipped') {
					$('#adjustment-shipping-receipt').prop('disabled', false);
				}
				else {
					$('#adjustment-shipping-receipt').prop('disabled', true);
				}
			});

			$('#adjustment-location').change(function() {
				$('#adjustment-item-list').empty();

				var resetItemList = '<tr id="adjustment-item-list-1" class="adjustment-product-list" data-number="1"><td class="td-icon"><span class="table-icon" data-content="Remove Item" onclick="removeItem(1);"><i class="trash outline icon"></i></span></td><td><div id="adjustment-product-selection-1" class="ui search selection dropdown form-input"><input id="adjustment-product-1" class="adjustment-product-list-selection" data-number="1" type="hidden" class="data-important"><i class="dropdown icon"></i><div class="default text">-- Select Product --</div><div class="menu"><? foreach ($arr_product as $product): ?><div class="item" data-value="<?= $product->id; ?>"><?= $product->name; ?></div><? endforeach; ?></div></div></td><td style="text-align: right;"><span id="data-inventory-quantity-1">0</span></td><td style="text-align: right;"><input id="adjustment-product-quantity-1" type="text" class="adjustment-item-quantity" data-number="1" placeholder="Quantity.."></td><td style="text-align: right;"><span id="data-inventory-quantity-fix-1">0</span></td></tr><tr><td class="adjustment-add-product" style="cursor: pointer;" colspan="5" onclick="addProduct();"><span><i class="plus circle icon"></i></span> Add Product</td></tr>';

				$('#adjustment-item-list').append(resetItemList);
				$('#adjustment-product-quantity-1').val("0");
				$('#adjustment-product-selection-1').dropdown('clear');

				changeProduct();
				keyUpAdjustment();
			});
		}

		function changeProduct() {
			$('.adjustment-product-list-selection').change(function() {
				var number = $(this).attr('data-number');
				var productId = $(this).val();
				var locationId = $('#adjustment-location').val();

				if (productId > 0) {
					$.ajax({
						data :{
							"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
						},
						dataType: 'JSON',
						error: function() {
							alert('Server Error.');
						},
						success: function(data){
							if (data.status == 'success') {
								$('#data-inventory-quantity-'+ number).html(data.inventory.quantity_display);

								calculateQuantity(number);
							}
							else {
								alert(data.message);
							}
						},
						type : 'POST',
						url : '<?= base_url() ?>inventory/ajax_get/'+ productId +'/'+ locationId +'/',
					});
				}
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

			$('.shipping-address-button').click(function() {
				$('.ui.modal.shipping-address-modal').modal({
					inverted: false,
				}).modal('show');
			});
		}

		function init() {
			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('#adjustment-date').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
		}

		function keyUpAdjustment() {
			$('.adjustment-item-quantity').keyup(function (e) {
				var number = $(this).attr('data-number');

				calculateQuantity(number);
			});
		}

		function removeItem(number) {
			$('#adjustment-item-list-'+ number).remove();
		}

		function reset() {
			$('#adjustment-number').val("<?= $adjustment->number; ?>");
			$('#adjustment-date').val("<?= $adjustment->date_display; ?>");

			$('#adjustment-location').val("<?= $adjustment->location_id; ?>");
			$('#adjustment-location-selection').dropdown('set selected', "<?= $adjustment->location_id; ?>");

			<? foreach ($adjustment->arr_adjustment_item as $key => $adjustment_item): ?>
				$('#adjustment-product-selection-<?= $key + 1; ?>').dropdown('set selected', "<?= $adjustment_item->product_id; ?>");
				$('#adjustment-product-quantity-<?= $key + 1; ?>').val('<?= $adjustment_item->quantity_display; ?>');
			<? endforeach; ?>
		}

		function submit() {
			var adjustmentNumber = $('#adjustment-number').val();
			var adjustmentDate = $('#adjustment-date').val();
			var adjustmentLocation = $('#adjustment-location').val();
			var found = 0;

			$.each($('.data-important'), function(key, data) {
				if ($(data).val() == '') {
					found += 1;

					$(data).addClass('input-error');
				}
			});

			/* get all adjustment product list */
			var arrAdjustmentItem = [];
			var adjustmentItem = {};

			$.each($('.adjustment-product-list'), function(key, item) {
				var number = $(item).attr('data-number');

				if ($('#adjustment-product-'+ number).val() > 0 || $('#adjustment-product-'+ number).val() != '') {
					adjustmentItem = {};
					adjustmentItem.location_id = adjustmentLocation;
					adjustmentItem.product_id = $('#adjustment-product-'+ number).val();
					adjustmentItem.quantity = $('#adjustment-product-quantity-'+ number).val();

					if ($('#adjustment-product-quantity-'+ number).val() == 0 || $('#adjustment-product-quantity-'+ number).val() == '') {
						found += 1;

						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.ui.basic.modal.all-error').modal('show');
						$('.all-error-text').html('Quantity must not be empty.');
					}

					arrAdjustmentItem.push(adjustmentItem);
				}
			});

			if (arrAdjustmentItem.length <= 0) {
				found += 1;

				$('.ui.dimmer.all-loader').dimmer('hide');
				$('.ui.basic.modal.all-error').modal('show');
				$('.all-error-text').html('Item cannot be empty.');
			}

			if (found > 0) {
				return;
			}

			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					number: adjustmentNumber,
					date: adjustmentDate,
					location_id: adjustmentLocation,
					adjustment_item_adjustment_item: JSON.stringify(arrAdjustmentItem),
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
				url : '<?= base_url() ?>adjustment/ajax_edit/<?= $adjustment->id; ?>/',
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
					<div class="header">Edit Adjustment</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<div class="field">
							<div class="three fields">
								<div class="field">
									<label>Adjustment Number</label>
									<input id="adjustment-number" class="form-input" placeholder="AUTO.." type="text">
								</div>
								<div class="field">
									<label>Date</label>
									<input id="adjustment-date" class="form-input" placeholder="Date.." type="text">
								</div>
								<div class="field">
									<label>Location</label>
									<div id="adjustment-location-selection" class="ui search selection dropdown form-input">
										<input id="adjustment-location" type="hidden" class="data-important">
										<i class="dropdown icon"></i>
										<div class="default text">-- Select Location --</div>
										<div class="menu">
											<div class="item" data-value="<?= $adjustment->location_id; ?>"><?= $adjustment->location_name; ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="field">
								<table class="ui striped selectable celled table" style="border: 1px solid rgba(34, 36, 38, 0.15); border-radius: 0;">
									<thead>
										<tr>
											<th class="td-icon">Action</th>
											<th>Product</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody id="adjustment-item-list">
										<? foreach ($adjustment->arr_adjustment_item as $key => $adjustment_item): ?>
											<tr id="adjustment-item-list-<?= $key + 1; ?>" class="adjustment-product-list" data-number="<?= $key + 1; ?>">
												<td class="td-icon">
													<span class="table-icon" data-content="Remove Item" onclick="removeItem('<?= $key + 1; ?>');">
														<i class="trash outline icon"></i>
													</span>
												</td>
												<td>
													<div id="adjustment-product-selection-<?= $key + 1; ?>" class="ui search selection dropdown form-input">
														<input id="adjustment-product-<?= $key + 1; ?>" class="adjustment-product-list-selection" data-number="<?= $key + 1; ?>" type="hidden" class="data-important">
														<i class="dropdown icon"></i>
														<div class="default text">-- Select Product --</div>
														<div class="menu">
															<? foreach ($arr_product as $product): ?>
																<div class="item" data-value="<?= $product->id; ?>"><?= $product->name; ?></div>
															<? endforeach; ?>
														</div>
													</div>
												</td>
												<td style="text-align: right;">
													<input id="adjustment-product-quantity-<?= $key + 1; ?>" type="text" class="adjustment-item-quantity" data-number="<?= $key + 1; ?>" placeholder="Quantity..">
												</td>
											</tr>
										<? endforeach; ?>
										<tr>
											<td class="adjustment-add-product" style="cursor: pointer;" colspan="3" onclick="addProduct();">
												<span>
													<i class="plus circle icon"></i>
												</span> Add Product
											</td>
										</tr>
									</tbody>
								</table>
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