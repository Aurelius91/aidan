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
                    <h2 class="section-title text-only">
                        MY CART
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="cart-section-inner white">
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
                                                    <br>
                                                    <a onclick="removeCart('<?= $cart->id; ?>', '<?= $cart->product_id; ?>', '<?= $cart->voucher_id; ?>');" class="cart-product-description">Remove</a>
                                                </h4>
                                            </td>
                                            <td class="col-xs-12 col-sm-3 cart-quantity">
                                                <? if ($cart->product_id > 0): ?>
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
                                                <? else: ?>
                                                    <div class="input-group input-group-stepper center">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number disabled" data-type="minus">
                                                                <span class="minus-sign"></span>
                                                            </button>
                                                        </span>
                                                        <input id="cart-quantity-desktop-<?= $cart->id; ?>" data-cart-id="<?= $cart->id; ?>" data-product-id="<?= $cart->product_id; ?>" data-voucher-id="<?= $cart->voucher_id; ?>" data-price="<?= $cart->product_price; ?>" data-max-quantity="<?= $cart->product_max_quantity; ?>" data-currency-name="<?= $cart->currency_name; ?>" type="text" class="form-control input-number input-quantity-cart" value="1" disabled>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number disabled" data-type="plus">
                                                                <span class="plus-sign"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                <? endif; ?>
                                            </td>
                                            <td class="col-xs-12 col-sm-3 cart-price cart-price-<?= $cart->id; ?>"><h4><?= $cart->total_display; ?>,-</h4></td>
                                        </tr>
                                    <? endforeach; ?>

                                    <tr>
                                        <td class="col-xs-6 cart-agreement">
                                            By checking out, you are agreeing to Aidan and Ice's <a href="<?= base_url(); ?>terms-and-conditions/">Terms and Conditions</a>
                                        </td>
                                        <td class="col-xs-3 cart-subtotal">
                                            <h4>Sub Total</h4>
                                        </td>
                                        <td class="col-xs-3 cart-total cart-subtotal-value">
                                            <h4>IDR 0,-</h4>
                                        </td>
                                    </tr>

                                    <? if ($customer): ?>
                                        <tr>
                                            <td class="col-xs-6 cart-empty-placeholder"></td>
                                            <td class="col-xs-3 cart-promo-code">
                                                <input id="voucher-input-code" type="text" class="form-control input-custom" placeholder="Add Promo Code">
                                            </td>
                                            <td class="col-xs-3 cart-promo-code-apply cart-total">
                                                <h4 data-voucher="<?= $voucher_value; ?>">IDR 0,-</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-xs-6 cart-empty-placeholder"></td>
                                            <td class="col-xs-3 cart-subtotal">
                                                <h4>Grand Total</h4>
                                            </td>
                                            <td class="col-xs-3 cart-total cart-grand-total">
                                                <h4>IDR 0,-</h4>
                                            </td>
                                        </tr>
                                    <? endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-mobile">
                            <? foreach ($arr_cart as $cart): ?>
                                <div id="cart-all-<?= $cart->id; ?>" class="cart-mobile-product">
                                    <div class="cart-mobile-section">
                                        <div class="cart-mobile-section-title">
                                            <p>Product</p>
                                        </div>
                                        <div class="cart-mobile-section-content cart-product">
                                            <img <? if ($cart->product_id > 0): ?>src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $cart->image_name; ?>"<? else: ?>src="<?= $cart->image_name; ?>"<? endif; ?> alt="Product 1"><!--
                                            --><h4>
                                                <?= $cart->product_name; ?>
                                                <br>
                                                <a onclick="removeCart('<?= $cart->id; ?>', '<?= $cart->product_id; ?>', '<?= $cart->voucher_id; ?>');" class="cart-product-description">Remove</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="cart-mobile-section">
                                        <div class="cart-mobile-section-title">
                                            <p>Quantity</p>
                                        </div>
                                        <div class="cart-mobile-section-content">
                                            <? if ($cart->product_id > 0): ?>
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
                                            <? else: ?>
                                                <div class="input-group input-group-stepper center">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number disabled" data-type="minus" onclick="updateQuantity('minus', '<?= $cart->id; ?>');">
                                                            <span class="minus-sign"></span>
                                                        </button>
                                                    </span>
                                                    <input id="cart-quantity-mobile-<?= $cart->id; ?>" data-max-quantity="<?= $cart->product_max_quantity; ?>" type="text" class="form-control input-number" disabled>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number disabled" data-type="plus" onclick="updateQuantity('plus', '<?= $cart->id; ?>');">
                                                            <span class="plus-sign"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            <? endif; ?>
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
                                </div>
                            <? endforeach; ?>
                            <div class="cart-mobile-section">
                                <div class="cart-mobile-section-title">
                                    <p>Promo Code</p>
                                </div>
                                <div class="cart-mobile-section-content cart-promo-code">
                                    <div class="row">
                                        <div class="col-xs-7 v-center cart-promo-code"><input id="voucher-mobile-input-code" type="text" class="form-control input-custom" placeholder="Add Promo Code"></div><div class="col-xs-5 v-center cart-promo-code-apply"><button class="btn btn-apply-promo-code-mobile">Apply</button></div>
                                    </div>
                                    <div class="row">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-5 cart-subtotal v-center">
                                            <h4>Total</h4>
                                        </div><!--
                                     --><div class="col-xs-7 cart-total cart-grand-total text-right v-center">
                                            <h4>IDR 0,-</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 cart-agreement">
                                            <p>By checking out, you are agreeing to Aidan and Ice's <a href="<?= base_url(); ?>terms-and-conditions/">Terms and Conditions</a></p>
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
                    <div class="cart-button-action-wrapper">
                        <a href="<?= base_url(); ?>">
                            <button class="btn btn-custom small full-mobile">Continue Shopping</button>
                        </a>
                        <a href="<?= base_url(); ?>cart/shipping">
                            <button class="btn btn-custom small dark full-mobile">Checkout</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetQuantity();
        calculateTotal();
        cartClick();
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
        $('.cart-subtotal-value h4').html(subtotalDisplay);

        var voucher = parseInt($('.cart-promo-code-apply h4').attr('data-voucher'));
        var voucherDisplay = currencyName + ' ' + $.number(voucher, 0, ',', '.') + ',-';
        $('.cart-promo-code-apply h4').html(voucherDisplay);

        var grandTotal = subtotal - voucher;
        var grandTotalDisplay = currencyName + ' ' + $.number(grandTotal, 0, ',', '.') + ',-';
        $('.cart-grand-total h4').html(grandTotalDisplay);
    }

    function cartClick() {
        $('.btn-apply-promo-code-mobile').click(function() {
            var voucherCode = $('#voucher-mobile-input-code').val();

            getVoucher(voucherCode);
        });

        $('#voucher-mobile-input-code').keypress(function(e) {
            if (e.which == 13) {
                var voucherCode = $('#voucher-mobile-input-code').val();

                getVoucher(voucherCode);
            }
        });

        $('.btn-apply-promo-code').click(function() {
            var voucherCode = $('#voucher-input-code').val();

            getVoucher(voucherCode);
        });

        $('#voucher-input-code').keypress(function(e) {
            if (e.which == 13) {
                var voucherCode = $('#voucher-input-code').val();

                getVoucher(voucherCode);
            }
        });
    }

    function getVoucher(voucherCode) {
        $.ajax({
            data :{
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    var value = data.value;

                    $('.cart-promo-code-apply h4').attr('data-voucher', value);

                    calculateTotal();
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_get_voucher/'+ voucherCode +'/',
        });
    }

    function removeCart(cartId, productId, voucherId) {
        $.ajax({
            data :{
                product_id: productId,
                voucher_id: voucherId,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('#cart-all-'+ cartId).remove();

                    calculateTotal();
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_remove_cart/',
        });
    }

    function resetQuantity() {
        <? foreach ($arr_cart as $cart): ?>
            $('#cart-quantity-desktop-<?= $cart->id; ?>, #cart-quantity-mobile-<?= $cart->id; ?>').val("<?= $cart->quantity; ?>");
        <? endforeach; ?>

        $('#voucher-input-code, #voucher-mobile-input-code').val("<?= $voucher_number; ?>");
    }

    function updateCart(cartId, productId, voucherId, quantity) {
        $.ajax({
            data :{
                product_id: productId,
                voucher_id: voucherId,
                quantity: quantity,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    calculateTotal();
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_update_cart/',
        });
    }

    function updateQuantity(type, cartId) {
        var quantity = parseInt($('#cart-quantity-desktop-'+ cartId).val());
        var maxQuantity = parseInt($('#cart-quantity-desktop-'+ cartId).attr('data-max-quantity'));
        var cartId = $('#cart-quantity-desktop-'+ cartId).attr('data-cart-id');
        var productId = $('#cart-quantity-desktop-'+ cartId).attr('data-product-id');
        var voucherId = $('#cart-quantity-desktop-'+ cartId).attr('data-voucher-id');

        if (type == 'minus') {
            quantity = quantity - 1;

            if (quantity <= 0)
            {
                quantity = 1;
            }
        }
        else {
            quantity = quantity + 1;

            if (quantity > maxQuantity)
            {
                quantity = maxQuantity;
            }
        }

        $('#cart-quantity-desktop-'+ cartId + ', #cart-quantity-mobile-' + cartId).val(quantity);
        updateCart(cartId, productId, voucherId, quantity);
    }
</script>

</html>
