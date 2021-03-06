	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			posReset();
			posKeypress();
			posClick();
			posChange();
		});

		function calculateChange() {
			var amountPaid = ($('#payment-amount-add').val() == '') ? 0 :  $('#payment-amount-add').val();
			var grandTotal = $('#pos-grand-total').attr('data-grand-total');

			var change = parseInt(amountPaid) - parseInt(grandTotal);
			$('#payment-change-add').val(change);
		}

		function calculateTotal() {
			var subtotal = 0;
			var taxPercentage = "<?= $setting->setting__webshop_default_tax; ?>";

			$.each($('.pos-table-item-list'), function(key, productList) {
				var productId = $(productList).attr('data-product-id');
				var price = $(productList).attr('data-product-price');
				var quantity = $('#pos-product-qty-'+ productId).val();

				var totalItem = parseInt(price) * parseInt(quantity);
				var totalItemDisplay = $.number(totalItem, 0, ',', '.');

				$('#pos-product-price-'+ productId).html('Rp '+ totalItemDisplay);

				subtotal += totalItem;
			});

			var subtotalDisplay = $.number(subtotal, 0, ',', '.');
			$('#pos-subtotal').html('Rp '+ subtotalDisplay);
			$('#pos-subtotal').attr('data-subtotal', subtotal);

			var tax = (parseInt(taxPercentage) / 100) * subtotal;
			var taxDisplay = $.number(tax, 0, ',', '.');
			$('#pos-tax').html('Rp '+ taxDisplay);
			$('#pos-tax').attr('data-tax', tax);

			var grandTotal = subtotal + tax;
			var grandTotalDisplay = $.number(grandTotal, 0, ',', '.');
			$('#pos-grand-total').html('Rp '+ grandTotalDisplay);
			$('#pos-grand-total').attr('data-grand-total', grandTotal);

			posClick();
		}

		function posChange() {
			$('#payment-amount-add').change(function() {
				calculateChange();
			});

			$('#payment-amount-add').keyup(function (e) {
				calculateChange();
			});
		}

		function posClick() {
			$('#btn-cancel').click(function() {
				posUnbind();

				$('#pos-item-product-list-table > tbody').empty();

				calculateTotal();
				posReset();
			});

			$('#btn-pay').click(function() {
				var found = 0;
				$.each($('.pos-table-item-list'), function(key, productList) {
					found += 1;
				});

				if (found <= 0) {
					return;
				}

				var grandTotal = $('#pos-grand-total').attr('data-grand-total');
				var grandTotalDisplay = $.number(grandTotal, 0, ',', '.');

				$('.pos-payment-total-display-popup').html('Rp '+ grandTotalDisplay);
				$('#payment-amount-add').val(0);

				calculateChange();

				$('.add-payment-modal').modal({
					inverted: false,
				}).modal('show');
			});

			$('.icon-delete-item').click(function() {
				posUnbind();

				var productId = $(this).attr('data-product-id');

				$('#pos-product-'+ productId).remove();

				calculateTotal();
			});

			$('.inventory-product-list').click(function() {
				posUnbind();

				var productId = $(this).attr('data-product-id');
				var price = $(this).attr('data-product-price');
				var barcode = $(this).attr('data-product-barcode');
				var productName = $(this).attr('data-product-name');
				var priceDisplay = $.number(price, 0, ',', '.');
				var found = 0;

				/* Search barcode */
				$.each($('.pos-table-item-list'), function(key, productList) {
					var productBarcode = $(productList).attr('data-product-barode');

					if (productBarcode == barcode){
						found += 1;

						productId = $(productList).attr('data-product-id');

						var qty = $('#pos-product-qty-'+ productId).val();
						var quantity = parseInt(qty) + 1;

						$('#pos-product-qty-'+ productId).val(quantity);

						calculateTotal();
					}
				});

				if (found > 0) {
					posReset();

					return;
				}

				var addItem = '<tr id="pos-product-'+ productId +'" class="pos-table-item-list" data-product-id="'+ productId +'" data-product-barode="'+ barcode +'" data-product-price="'+ price +'"><td class="pos-icon"><span class="table-icon icon-delete-item" data-product-id="'+ productId +'"><i class="trash outline icon"></i></span></td><td><div class="pos-table-product-header">'+ productName +'</div><div>Price: Rp '+ priceDisplay +'</div></td><td class="pos-qty"><div class="ui action input"><button data-product-id="'+ productId +'" class="ui button text-center pos-btn-quantity-minus"><i class="minus icon"></i></button><input id="pos-product-qty-'+ productId +'" class="input-pos-quantity" placeholder="Search..." type="text"><button data-product-id="'+ productId +'" class="ui button text-center pos-btn-quantity-plus"><i class="plus icon"></i></button></div></td><td id="pos-product-price-'+ productId +'" class="pos-price">Rp. 15.000</td></tr>';

				$('#pos-item-product-list-table > tbody').append(addItem);
				$('#pos-product-qty-'+ productId).val("1");
				calculateTotal();
			});

			$('.pos-btn-quantity-minus').click(function() {
				posUnbind();

				var productId = $(this).attr('data-product-id');

				var qty = $('#pos-product-qty-'+ productId).val();
				var quantity = (parseInt(qty) <= 1) ? parseInt(qty) : parseInt(qty) - 1;

				$('#pos-product-qty-'+ productId).val(quantity);

				calculateTotal();
			});

			$('.pos-btn-quantity-plus').click(function() {
				posUnbind();

				var productId = $(this).attr('data-product-id');

				var qty = $('#pos-product-qty-'+ productId).val();
				var quantity = parseInt(qty) + 1;

				$('#pos-product-qty-'+ productId).val(quantity);

				calculateTotal();
			});
		}

		function posKeypress() {
			$('#pos-product-barcode-search').keypress(function(e) {
				if (e.which == 13) {
					searchBarcode();
				}
			});
		}

		function posReset() {
			$('#pos-product-barcode-search').val("");
			$('#pos-product-barcode-search').focus();
		}

		function posSubmit() {
			var saleNumber = '';
			var saleDate = "<?= $date_display; ?>";
			var saleTerm = "0";
			var saleLocation = "<?= $setting->setting__webshop_default_pos_location_id; ?>";
			var saleCustomer = "<?= $setting->setting__webshop_default_pos_customer_id; ?>";
			var saleStatus = "Cash";
			var salestatement = "<?= $setting->setting__webshop_default_pos_statement_id; ?>";
			var saleSubtotal = $('#pos-subtotal').attr('data-subtotal');
			var saleDiscount = "0";
			var saleTax = "<?= $setting->setting__webshop_default_tax; ?>";
			var saleShipping = "0";
			var saleTotal = $('#pos-grand-total').attr('data-grand-total');
			var saleAmountPaid = $('#payment-amount-add').val();
			var saleAmountChange = $('#payment-change-add').val();
			var found = 0;

			$.each($('.data-important'), function(key, data) {
				if ($(data).val() == '') {
					found += 1;

					$(data).addClass('input-error');
				}
			});

			/* get all sale product list */
			var arrsaleItem = [];
			var saleItem = {};

			$.each($('.pos-table-item-list'), function(key, productList) {
				saleItem = {};
				saleItem.customer_id  = saleCustomer;
				saleItem.location_id = saleLocation;
				saleItem.product_id = $(productList).attr('data-product-id');
				saleItem.quantity = $('#pos-product-qty-'+ saleItem.product_id).val();
				saleItem.price = $(productList).attr('data-product-price');

				arrsaleItem.push(saleItem);
			});

			if (arrsaleItem.length <= 0) {
				found += 1;

				$('.ui.dimmer.all-loader').dimmer('hide');
				$('.ui.basic.modal.all-error').modal('show');
				$('.all-error-text').html('Item cannot be empty.');
			}

			if (parseInt(saleAmountPaid) < parseInt(saleTotal)) {
				found += 1;

				$('#payment-amount-add').addClass('input-error');
			}

			if (found > 0) {
				return;
			}

			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			$.ajax({
				data :{
					number: saleNumber,
					date: saleDate,
					term: saleTerm,
					location_id: saleLocation,
					customer_id: saleCustomer,
					statement_id: salestatement,
					type: saleStatus,
					sale_item_sale_item: JSON.stringify(arrsaleItem),
					subtotal: saleSubtotal,
					discount: saleDiscount,
					tax: saleTax,
					shipping: saleShipping,
					total: saleTotal,
					amount_paid: saleAmountPaid,
					amount_change: saleAmountChange,
					draft: "0",
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
				url : '<?= base_url() ?>sale/ajax_add/',
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

		function posUnbind() {
			$('.pos-btn-quantity-minus').unbind('click');
			$('.pos-btn-quantity-plus').unbind('click');
			$('.inventory-product-list').unbind('click');
			$('.icon-delete-item').unbind('click');
			$('#btn-pay, #btn-cancel').unbind('click');
		}

		function searchBarcode() {
			posUnbind();

			var barcode = $('#pos-product-barcode-search').val();
			var found = 0;

			if (barcode == '') {
				return;
			}

			var productId = 0;

			/* Search barcode */
			$.each($('.pos-table-item-list'), function(key, productList) {
				var productBarcode = $(productList).attr('data-product-barode');

				if (productBarcode == barcode){
					found += 1;

					productId = $(productList).attr('data-product-id');

					var qty = $('#pos-product-qty-'+ productId).val();
					var quantity = parseInt(qty) + 1;

					$('#pos-product-qty-'+ productId).val(quantity);

					calculateTotal();
				}
			});

			if (found > 0) {
				posReset();

				return;
			}

			$.ajax({
				data :{
					"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
				},
				dataType: 'JSON',
				error: function() {
					$('.ui.dimmer.pos-loader').removeClass('active');
					$('.ui.basic.modal.pos-error').modal('show');
					$('.pos-error-text').html('Server Error.');
				},
				success: function(data){
					if (data.status == 'success') {
						posReset();

						/* update item on right */
						var addItem = '<tr id="pos-product-'+ data.product.id +'" class="pos-table-item-list" data-product-id="'+ data.product.id +'" data-product-barode="'+ data.product.barcode +'" data-product-price="'+ data.product.price +'"><td class="pos-icon"><span class="table-icon icon-delete-item" data-product-id="'+ data.product.id +'"><i class="trash outline icon"></i></span></td><td><div class="pos-table-product-header">'+ data.product.name +'</div><div>Price: Rp '+ data.product.price_display +'</div></td><td class="pos-qty"><div class="ui action input"><button data-product-id="'+ data.product.id +'" class="ui button text-center pos-btn-quantity-minus"><i class="minus icon"></i></button><input id="pos-product-qty-'+ data.product.id +'" class="input-pos-quantity" placeholder="Search..." type="text"><button data-product-id="'+ data.product.id +'" class="ui button text-center pos-btn-quantity-plus"><i class="plus icon"></i></button></div></td><td id="pos-product-price-'+ data.product.id +'" class="pos-price">Rp. 15.000</td></tr>';

						$('#pos-item-product-list-table > tbody').append(addItem);
						$('#pos-product-qty-'+ data.product.id).val("1");
						calculateTotal();
					}
					else {
						$('.ui.dimmer.pos-loader').removeClass('active');
						$('.ui.basic.modal.pos-error').modal('show');
						$('.pos-error-text').html(data.message);
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>product/ajax_get/0/'+ barcode +'/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Checking Username and Password..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Verifying Data...');
					}, false);

					return xhr;
				},
			});
		}
	</script>

	<!-- Dashboard Here -->
	<!-- Modal -->
	<div class="ui basic modal pos-error">
		<div class="ui icon header">WARNING</div>
		<div class="content">
			<div class="pos-error-text"></div>
		</div>
		<div class="actions text-center">
			<div class="ui basic cancel inverted button">
				<i class="remove icon"></i>
				Return
			</div>
		</div>
	</div>

	<div class="ui modal add-payment-modal">
		<i class="close icon"></i>
		<div class="header">PAYMENT</div>
		<div class="form-content content">
			<div class="form-add">
				<div class="form-content">
					<div class="text-center">Grand Total</div>
					<div class="pos-payment-total-display-popup"></div>
					<div class="ui form">
						<div class="three fields">
							<div class="field"></div>
							<div class="field">
								<label class="text-center">Paid Amount <span class="color-red warning"></span></label>
								<input id="payment-amount-add" type="text" class="text-center data-important-add" placeholder="Name..">
							</div>
							<div class="field"></div>
						</div>
						<div class="three fields">
							<div class="field"></div>
							<div class="field">
								<label class="text-center">Change</label>
								<input id="payment-change-add" type="text" class="text-center" placeholder="Name.." disabled>
							</div>
							<div class="field"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="actions text-center">
				<div class="ui deny button form-button">ADD OTHER ITEM</div>
				<div class="ui button form-button" onclick="posSubmit();">PAY</div>
			</div>
		</div>
	</div>

	<div class="main-content">
		<div class="pos-content">
			<div class="ui grid">
				<div class="six wide computer column" style="padding-right: 0;">
					<div class="ui icon input barcode-input">
						<i class="search icon"></i>
						<input id="pos-product-barcode-search" placeholder="Scan Barcode Here..." type="text">
					</div>
					<div class="pos-product-list">
						<table class="ui striped selectable celled blue table">
							<thead>
								<tr>
									<th>PRODUCT LIST</th>
								</tr>
							</thead>
							<tbody>
								<? foreach ($arr_inventory as $inventory): ?>
									<tr class="inventory-product-list" data-product-id="<?= $inventory->product_id; ?>" data-product-price="<?= $inventory->product_price; ?>" data-product-barcode="<?= $inventory->product_barcode; ?>" data-product-name="<?= $inventory->product_name; ?>">
										<td>
											<div class="pos-table-product-header"><?= $inventory->product_name; ?></div>
											<div>Quantity: <?= $inventory->quantity_display; ?></div>
											<div>price: Rp <?= $inventory->product_price_display; ?></div>
										</td>
									</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="ten wide computer column" style="padding-left: 0;">
					<div class="pos-table-product-list">
						<table id="pos-item-product-list-table" class="ui striped selectable celled red table">
							<thead>
								<tr>
									<th class="pos-icon"></th>
									<th>Item</th>
									<th class="pos-qty">Qty</th>
									<th class="pos-price">Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="pos-table-total-display">
						<div class="ui grid">
							<div class="four wide computer column">
								<div class="ui vertical basic buttons pos-button-group">
									<button id="btn-cancel" class="ui button btn-red-bg">RESET</button>
									<button id="btn-pay" class="ui button btn-blue-bg">PAY</button>
								</div>
							</div>
							<div class="twelve wide computer column">
								<div class="ui grid">
									<div class="eight wide computer column pos-subtotal-column">SUBTOTAL</div>
									<div id="pos-subtotal" data-subtotal="0" class="eight wide computer column pos-subtotal-column text-right">Rp 0</div>

									<div class="eight wide computer column pos-subtotal-column">TAX (<?= $setting->setting__webshop_default_tax; ?> %)</div>
									<div id="pos-tax" data-tax="0" class="eight wide computer column pos-subtotal-column text-right">Rp 0</div>

									<div class="eight wide computer column pos-subtotal-column pos-total-display">GRAND TOTAL</div>
									<div id="pos-grand-total" data-grand-total="0" class="eight wide computer column pos-subtotal-column pos-total-display text-right">Rp 0</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>