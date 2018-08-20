<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="cart-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <ul class="shipping-steps">
                        <li class="active">
                            <div class="shipping-steps-number-wrapper">
                                <div class="shipping-steps-number">1</div>
                            </div>
                            <div class="shipping-steps-text">shipping</div>
                        </li>
                        <li class="active">
                            <div class="shipping-steps-number-wrapper">
                                <div class="shipping-steps-number">2</div>
                            </div>
                            <div class="shipping-steps-text">review</div>
                        </li>
                        <li class="active">
                            <div class="shipping-steps-number-wrapper">
                                <div class="shipping-steps-number">3</div>
                            </div>
                            <div class="shipping-steps-text">payment</div>
                        </li>
                        <li>
                            <div class="shipping-steps-number-wrapper">
                                <div class="shipping-steps-number">4</div>
                            </div>
                            <div class="shipping-steps-text">Confirmation</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr class="shipping-steps-line">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="cart-section-inner">
                        <div class="table-responsive hidden-xs">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="cart-product-title">Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($arr_cart as $cart): ?>
                                        <tr id="cart-all-<?= $cart->id; ?>">
                                            <td class="col-xs-12 col-sm-6 cart-product">
                                                <img <? if ($cart->product_id > 0): ?>src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $cart->image_name; ?>"<? else: ?>src="<?= $cart->image_name; ?>"<? endif; ?> alt="Product 1"><!--
                                                --><h4>
                                                    <?= $cart->product_name; ?>
                                                </h4>
                                            </td>
                                            <td class="col-xs-12 col-sm-3 cart-quantity">
                                                <div class="input-group input-group-stepper center">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number" data-type="minus" onclick="updateQuantity('minus', '<?= $cart->id; ?>');">
                                                            <span class="minus-sign"></span>
                                                        </button>
                                                    </span>
                                                    <input id="cart-quantity-desktop-<?= $cart->id; ?>" data-cart-id="<?= $cart->id; ?>" data-product-id="<?= $cart->product_id; ?>" data-voucher-id="<?= $cart->voucher_id; ?>" data-price="<?= $cart->product_price; ?>" data-max-quantity="<?= $cart->product_max_quantity; ?>" data-currency-name="<?= $cart->currency_name; ?>" type="text" class="form-control input-number input-quantity-cart" value="1">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number" data-type="plus" onclick="updateQuantity('plus', '<?= $cart->id; ?>');">
                                                            <span class="plus-sign"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="col-xs-12 col-sm-3 cart-price cart-price-<?= $cart->id; ?>"><h4><?= $cart->total_display; ?>,-</h4></td>
                                        </tr>
                                    <? endforeach; ?>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal-text">
                                            <h4>Subtotal</h4>
                                        </td>
                                        <td class="col-xs-3 cart-total cart-subtotal">
                                            <h4></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal-text">
                                            <h4>Discount</h4>
                                        </td>
                                        <td id="cart-discount" class="col-xs-3 cart-total">
                                            <h4><?= $discount_display; ?>,-</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal-text">
                                            <h4>Shipping</h4>
                                        </td>
                                        <td class="col-xs-3 cart-total cart-shipping">
                                            <h4><?= $shipping->price_fix_display; ?>,-</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal-text">
                                            <h4>Grand Total</h4>
                                        </td>
                                        <td class="col-xs-3 cart-total cart-grand-total">
                                            <h4></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-mobile">
                            <div class="cart-mobile-product">
                                <? foreach ($arr_cart as $cart): ?>
                                    <div class="cart-mobile-section">
                                        <div class="cart-mobile-section-title">
                                            <p>Product</p>
                                        </div>
                                        <div class="cart-mobile-section-content cart-product">
                                            <img <? if ($cart->product_id > 0): ?>src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $cart->image_name; ?>"<? else: ?>src="<?= $cart->image_name; ?>"<? endif; ?> alt="Product 1"><!--
                                            --><h4>
                                                <?= $cart->product_name; ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="cart-mobile-section">
                                        <div class="cart-mobile-section-title">
                                            <p>Quantity</p>
                                        </div>
                                        <div class="cart-mobile-section-content">
                                            <div class="input-group input-group-stepper center">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-number" data-type="minus" onclick="updateQuantity('minus', '<?= $cart->id; ?>');">
                                                        <span class="minus-sign"></span>
                                                    </button>
                                                </span>
                                                <input id="cart-quantity-mobile-<?= $cart->id; ?>" data-max-quantity="<?= $cart->product_max_quantity; ?>" type="text" class="form-control input-number">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-number" data-type="plus" onclick="updateQuantity('plus', '<?= $cart->id; ?>');">
                                                        <span class="plus-sign"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-mobile-section">
                                        <div class="cart-mobile-section-title">
                                            <p>Price</p>
                                        </div>
                                        <div class="cart-mobile-section-content cart-price cart-price-<?= $cart->id; ?>">
                                            <h4><?= $cart->total_display; ?>,-</h4>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                                <div class="cart-mobile-section">
                                    <div class="cart-mobile-section-content">
                                        <div class="row">
                                            <hr class="no-margin-top-mobile">
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5 cart-subtotal-text v-center">
                                                <h4>Subtotal</h4>
                                            </div><!--
                                         --><div class="col-xs-7 cart-subtotal text-right v-center">
                                                <h4></h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5 cart-subtotal-text v-center">
                                                <h4>Discount</h4>
                                            </div><!--
                                         --><div id="cart-discount" class="col-xs-7 cart-discount cart-subtotal text-right v-center">
                                                <h4><?= $discount_display; ?>,-</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5 cart-subtotal-text v-center">
                                                <h4>Shipping</h4>
                                            </div><!--
                                         --><div class="col-xs-7 cart-shipping cart-subtotal text-right v-center">
                                                <h4><?= $shipping->price_fix_display; ?>,-</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5 cart-subtotal-text v-center">
                                                <h4>Grand Total</h4>
                                            </div><!--
                                         --><div class="col-xs-7 cart-total cart-grand-total text-right v-center">
                                                <h4></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="cart-section-inner white">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4>PAYMENT OPTION</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
								<div class="row payment-method-row">
									<div class="col-xs-12">
										<div class="checkbox-wrapper">
											<input type="radio" name="checkbox-alter" id="checkbox-payment-1" value="midtrans" class="checkbox-custom radio-payment-method" />
											<label for="checkbox-payment-1" class="checkbox-custom-label">
												Credit Card / Virtual Account
											</label>
											<img src="<?= base_url(); ?>assets/images/payment/visa-logo.png" alt="Credit Card" class="payment-logo">
											<img src="<?= base_url(); ?>assets/images/payment/mastercard-logo.png" alt="Credit Card" class="payment-logo">
										</div>
										<div class="checkbox-wrapper">
											<input type="radio" name="checkbox-alter" id="checkbox-payment-2" value="manual" class="checkbox-custom radio-payment-method" />
											<label for="checkbox-payment-2" class="checkbox-custom-label">
												Manual Transfer
											</label>
											<img src="<?= base_url(); ?>assets/images/payment/bca-logo.png" alt="Credit Card" class="payment-logo bank">
										</div>
									</div>
								</div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <hr class="payment-bottom-line">
                                        <div class="cart-button-action-wrapper">
                                            <a href="<?= base_url(); ?>cart/review">
                                                <buttton class="btn btn-custom small full-mobile">
                                                    BACK
                                                </buttton>
                                            </a>
                                            <a onclick="confirmPayment();">
                                                <button class="btn btn-custom small dark full-mobile">
                                                    CONFIRM
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('js'); ?>

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $setting->setting__third_party_midtrans_client_key; ?>"></script>

<script type="text/javascript">
    $(function() {
        resetQuantity();
        calculateTotal();
        resetPaymentMethod();
    });

    var canclose = 0;

    $(window).on('beforeunload', function(){
        if (canclose > 0)  {
            return 'Are you sure you want to leave? Your purchase may not be saved if you close this window now.';
        }
    });

    function calculateTotal() {
        var subtotal = 0;

        $.each($('.input-quantity-cart'), function(key, qty) {
            var cartId = $(qty).attr('data-cart-id');
            var price = parseInt($(qty).attr('data-price'));
            var quantity = parseInt($(qty).val());
            currencyName = $(qty).attr('data-currency-name');

            var total = price * quantity;
            var totalDisplay = currencyName + ' ' + $.number(total, 0, ',', '.') + ',-';

            $('.cart-price-'+ cartId +' h4').html(totalDisplay);

            subtotal += total;
            currencyName = currencyName
        });

        var subtotalDisplay = currencyName + ' ' + $.number(subtotal, 0, ',', '.') + ',-';
        $('.cart-subtotal h4').html(subtotalDisplay);

        var discount = parseInt("<?= $discount; ?>");
        var discountPercentage = parseInt("<?= $discount_percentage; ?>");

        if (discount <= 0)
        {
            discount = (discountPercentage / 100) * subtotal;
        }

        var discountDisplay = currencyName + ' ' + $.number(discount, 0, ',', '.') + ',-';
        $('#cart-discount h4').html(discountDisplay);

        var subtotalDiscount = subtotal - discount;

        var shipping = parseInt("<?= $shipping->price_fix; ?>");
        var total = subtotalDiscount + shipping;
        var totalDisplay = currencyName + ' ' + $.number(total, 0, ',', '.') + ',-';

        $('.cart-grand-total h4').html(totalDisplay);
        $('.cart-grand-total h4').data('amount-total', total);
    }

    function confirmPayment() {
        var payment = '';

        $.each($('.radio-payment-method'), function(key, paymentMethod) {
            if ($(paymentMethod).is(':checked')) {
                payment = $(paymentMethod).val();
            }
        });

        if (payment == 'midtrans') {
            generateOrderNumber();
        }
        else {
            window.location.href = "<?= base_url(); ?>cart/confirm/";
        }
    }

    function generateOrderNumber() {
        $('#cart-review-continue-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Generating...</span>');
        var amountTotal = $('.cart-grand-total h4').data('amount-total');

        $.ajax({
            data :{
                gross_amount: amountTotal,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#cart-review-continue-button').html('CONTINUE');
            },
            success: function(data){
                if (data.status == 'success') {
                    canclose = 1;
                    $('#cart-review-continue-button').html('CONTINUE');

                    snap.pay(data.token, {
                        onSuccess: function(result){
                            console.log('success');
                            console.log(result);
                            canclose = 0;

                            window.location.href = result.finish_redirect_url;
                        },
                        onPending: function(result){
                            console.log('pending');
                            console.log(result);
                            canclose = 0;

                            window.location.href = result.finish_redirect_url;
                        },
                        onError: function(result){
                            console.log('error');
                            console.log(result);
                            canclose = 0;

                            window.location.href = result.finish_redirect_url;
                        },
                        onClose: function(){
                            console.log('customer closed the popup without finishing the payment');
                            canclose = 1;
                        }
                    });
                }
                else {
                    alert(data.message);

                    $('#cart-review-continue-button').html('CONTINUE');
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_generate_order_number/',
        });
    }

    function resetPaymentMethod() {
        $('#checkbox-payment-1').prop("checked", true);
    }

    function resetQuantity() {
        <? foreach ($arr_cart as $cart): ?>
            $('#cart-quantity-desktop-<?= $cart->id; ?>, #cart-quantity-mobile-<?= $cart->id; ?>').val("<?= $cart->quantity; ?>");
        <? endforeach; ?>
    }
</script>

</html>
