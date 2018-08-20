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
                        <li>
                            <div class="shipping-steps-number-wrapper">
                                <div class="shipping-steps-number">2</div>
                            </div>
                            <div class="shipping-steps-text">review</div>
                        </li>
                        <li>
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
                                        <td class="col-xs-3 cart-subtotal">
                                            <h4>Sub Total</h4>
                                        </td>
                                        <td class="col-xs-3 cart-subtotal-value cart-total">
                                            <h4>IDR 0,-</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal">
                                            <h4>Discount </h4>
                                        </td>
                                        <td class="col-xs-3 cart-total cart-promo-code-apply">
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
                                            <div class="col-xs-5 cart-subtotal v-center">
                                                <h4>Sub Total</h4>
                                            </div><!--
                                         --><div class="col-xs-7 cart-total text-right v-center">
                                                <h4>IDR 0,-</h4>
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
                                <div class="cart-content">
                                    <h4>SHIPPING ADDRESS</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="cart-content">
                                    <? if ($customer): ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div style="padding: 15px 0 25px;">
													<p class="no-margin v-center-tablet">
														Ship To:
													</p>
                                                    <span class="new-address-button">
                                                        <a href="<?= base_url(); ?>cart/shipping/"><buttton id="address-0" class="btn btn-custom small <? if ($address_id <= 0): ?>dark<? endif; ?> full-mobile">NEW ADDRESS</buttton></a>
                                                        <? foreach ($arr_address as $address): ?>
                                                            <a href="<?= base_url(); ?>cart/shipping/<?= $address->id; ?>"><buttton id="address-<?= $address->id; ?>" class="btn btn-custom small <? if ($address->id == $address_id): ?>dark<? endif; ?> full-mobile">HOME</buttton></a>
                                                        <? endforeach; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <? endif; ?>
                                    <div class="row">
                                        <? if ($address_id <= 0 && $customer): ?>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="first-name">Save this address as:</label>
                                                    <input type="text" class="form-control input-custom" id="shipping-address-name" placeholder="Address Name">
                                                </div>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="first-name">First Name <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-first-name" placeholder="Your First Name">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="last-name">Last Name <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-last-name" placeholder="Your Last Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="email">Email Address <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="phone-number">Phone Number <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-phone-number" placeholder="Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="address">Address <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-new-address" placeholder="Your Address">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="zip-code">Zip Code <span class="error"> * Required</span></label>
                                                <input type="text" class="form-control input-custom data-address-important" id="address-zip-code" placeholder="Your Zip Code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 country-area">
                                            <div class="form-group form-group-custom ">
                                                <label for="country">Country <span class="error"> * Required</span></label>
                                                <select class="form-control input-custom data-address-important" id="country">
                                                    <? foreach ($arr_country as $country): ?>
                                                        <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                                    <? endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 indonesia-area">
                                            <div class="form-group form-group-custom">
                                                <label for="province">Province <span class="error"> * Required</span></label>
                                                <select class="form-control input-custom" id="province">
                                                    <option value="0">-- SELECT PROVINCE --</option>

                                                    <? foreach ($arr_province as $province): ?>
                                                        <option value="<?= $province->id; ?>"><?= $province->name; ?></option>
                                                    <? endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row indonesia-area">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="city">City <span class="error"> * Required</span></label>
                                                <select class="form-control input-custom" id="city">
                                                    <option value="0">-- SELECT CITY --</option>

                                                    <? foreach ($arr_city as $city): ?>
                                                        <option value="<?= $city->id; ?>"><?= $city->name; ?></option>
                                                    <? endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="district">District <span class="error"> * Required</span></label>
                                                <select class="form-control input-custom" id="district">
                                                    <option value="0">-- SELECT DISTRICT --</option>

                                                    <? foreach ($arr_district as $district): ?>
                                                        <option value="<?= $district->id; ?>"><?= $district->name; ?></option>
                                                    <? endforeach; ?>
                                                </select>
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
                                <div class="cart-content">
                                    <h4>SHIPPING METHOD</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="cart-content">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="shipping">SHIPPING OPTIONS <span class="error"> * Required</span></label>
                                                <select class="form-control input-custom" id="shipping">
                                                    <option value="0">-- SELECT SHIPPING OPTIONS --</option>

                                                    <? foreach ($arr_shipping as $shipping): ?>
                                                        <option value="<?= $shipping->id; ?>"><?= $shipping->type; ?> <?= $shipping->name; ?> - <?= $shipping->price_display; ?> - ETA: <?= $shipping->etd; ?> days</option>
                                                    <? endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <? if (!$customer): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="cart-section-inner white">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="cart-content">
                                        <h4>CONTACT INFORMATION (OPTIONAL)</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="cart-content">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="password">Password (To Make an Account) <span class="error"> * Required</span></label>
                                                    <input type="password" class="form-control input-custom data-address-signup-important" id="cart-sign-in-password" placeholder="Your Password">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="confirm-password">Confirm Password <span class="error"> * Required</span></label>
                                                    <input type="password" class="form-control input-custom data-address-signup-important" id="cart-sign-in-confirm-password" placeholder="Your Password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="cart-section-inner white">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="cart-content">
                                    <h4>GIFT MESSAGE (OPTIONAL)</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="cart-content">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-7">
                                            <p>All purchases come with a blank gift message card and envelope.</p>
                                            <button class="btn btn-custom dark small btn-customize-message" data-toggle="modal" data-target="#customize-message-modal">Customize my gift message</button>
                                            <button id="cart-shipping-remove-message-button" class="btn btn-custom dark small btn-customize-message <? if ($message == ''): ?>hidden<? endif; ?>" onclick="removeMessage();">
                                                <span class="vertical-center">Remove</span>
                                                <span class="vertical-center"><img src="<?= base_url(); ?>assets/images/main/delete.png" alt="Delete" class="delete"></span>
                                            </button>
                                        </div>
                                        <div id="cart-message-container" class="col-xs-12 col-sm-5 <? if ($message == ''): ?>hidden<? endif; ?>">
                                            <div class="giftcard-custom">
                                                <img src="<?= base_url(); ?>assets/images/main/logo-emboss.png" alt="Aidan & Ice" class="giftcard-custom-image">
                                                <div id="message-final-container">
                                                    <? if ($message != ''): ?>
                                                        <?= $message; ?>
                                                    <? endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                <div class="cart-button-action-wrapper">
                                    <a href="<?= base_url(); ?>cart">
                                        <buttton class="btn btn-custom small full-mobile">
                                            BACK
                                        </buttton>
                                    </a>

                                    <button id="submit-shipping-address" class="btn btn-custom small dark full-mobile">
                                        CONTINUE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="customize-message-modal" class="modal modal-custom gift-message fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-close" data-dismiss="modal">
                        <div class="close-icon"></div>
                    </button>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h3>GIFT MESSAGE</h3>
                            <textarea name="" id="cart-shipping-message" rows="10" class="form-control input-custom" placeholder="Enter Your Message Here"></textarea>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="checkbox-gift-wrapping" id="checkbox-gift-wrapping" class="checkbox-custom" />
                                <label for="checkbox-gift-wrapping" class="checkbox-custom-label">Gift Wrapping</label>
                            </div>
                            <p>*Messages are limited to 8 lines of text with 35 characters per line.</p>
                            <p>*The gift card will be handwritten</p>
                            <button class="btn btn-custom small">CANCEL</button>
                            <button class="btn btn-custom small dark" onclick="setMessage();">DONE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetAddress();
        clickAddress();
        resetQuantity();
        calculateTotal();
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

    function clickAddress() {
        $('#city').change(function() {
            getDistrict();
        });

        $('#country').change(function() {
            if ($('#country').val() != 233) {
                $('.indonesia-area').hide();

                $('#province').val('0');
                $('#city').val('0').prop('disabled', true);
                $('#district').val('0').prop('disabled', true);

                getShipping();
            }
            else {
                $('.indonesia-area').show();
                $('#shipping').val('0').prop('disabled', true);
            }
        });

        $('#district').change(function() {
            getShipping();
        });

        $('#province').change(function() {
            getCity();
        });

        $('#submit-shipping-address').click(function() {
            setShipping();
        });
    }

    function getCity() {
        var provinceId = $('#province').val();

        $('#city').prop('disabled', true);
        $('#city').empty();

        $('#district').val(0).prop('disabled', true);
        $('#shipping').val(0).prop('disabled', true);

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
                    var cityList = '<option value="0">-- SELECT CITY --</option>';

                    $.each(data.arr_city, function(key, city) {
                        cityList += '<option value="'+ city.id +'">'+ city.name +'</option>';
                    });

                    $('#city').append(cityList);
                    $('#city').val('0').prop('disabled', false);
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_get_city/'+ provinceId +'/',
        });
    }

    function getDistrict() {
        var cityId = $('#city').val();

        $('#district').prop('disabled', true);
        $('#district').empty();

        $('#shipping').val(0).prop('disabled', true);

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
                    var districtList = '<option value="0">-- SELECT DISTRICT --</option>';

                    $.each(data.arr_district, function(key, district) {
                        districtList += '<option value="'+ district.id +'">'+ district.name +'</option>';
                    });

                    $('#district').append(districtList);
                    $('#district').val('0').prop('disabled', false);
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_get_district/'+ cityId +'/',
        });
    }

    function getShipping() {
        var countryId = $('#country').val();
        var provinceId = $('#province').val();
        var cityId = $('#city').val();
        var districtId = $('#district').val();

        $('#shipping').prop('disabled', true);
        $('#shipping').empty();

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
                    var shippingList = '<option value="0">-- SELECT SHIPPING OPTIONS --</option>';

                    $.each(data.arr_shipping, function(key, shipping) {
                        shippingList += '<option value="'+ shipping.id +'">'+ shipping.type +' '+ shipping.name +' - '+ shipping.price_display +' - ETA: '+ shipping.etd +' days</option>';
                    });

                    $('#shipping').append(shippingList);
                    $('#shipping').val('0').prop('disabled', false);
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_get_shipping/'+ countryId +'/'+ provinceId +'/'+ cityId +'/'+ districtId +'/',
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

    function removeMessage() {
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
                    $('#cart-shipping-remove-message-button, #cart-message-container').addClass('hidden');
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_remove_message/',
        });
    }

    function resetAddress() {
        $('.data-address-signup-important').val();

        <? if ($address_id <= 0): ?>
            $('.indonesia-area').show();

            $('.data-address-important').val("");

            $('#country').val('233');
            $('#province').val('0');
            $('#city').val('0').prop('disabled', true);
            $('#district').val('0').prop('disabled', true);
            $('#shipping').val('0').prop('disabled', true);
        <? else: ?>
            $('#address-first-name').val("<?= $selected_address->first_name; ?>");
            $('#address-last-name').val("<?= $selected_address->last_name; ?>");
            $('#address-email').val("<?= $selected_address->email; ?>");
            $('#address-phone-number').val("<?= $selected_address->phone; ?>");
            $('#address-new-address').val("<?= $selected_address->address; ?>");
            $('#address-zip-code').val("<?= $selected_address->zip_code; ?>");

            $('#country').val("<?= $selected_address->country_id;?>");
            $('#province').val("<?= $selected_address->province_id;?>");
            $('#city').val("<?= $selected_address->city_id;?>").prop('disabled', false);
            $('#district').val("<?= $selected_address->district_id;?>").prop('disabled', false);
            $('#shipping').val('0').prop('disabled', false);
        <? endif; ?>
    }

    function resetQuantity() {
        <? foreach ($arr_cart as $cart): ?>
            $('#cart-quantity-desktop-<?= $cart->id; ?>, #cart-quantity-mobile-<?= $cart->id; ?>').val("<?= $cart->quantity; ?>");
        <? endforeach; ?>
    }

    function setMessage() {
        var message = $('#cart-shipping-message').val();
        var arrMessage = message.split("\n");
        var newMessage = '';

        $('#message-final-container').empty();

        $.each(arrMessage, function(key, msg) {
            newMessage += '<h3>'+ msg +'</h3>'
        });

        $.ajax({
            data :{
                message: newMessage,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-address-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('#message-final-container').append(newMessage);
                    $('#cart-shipping-remove-message-button, #cart-message-container').removeClass('hidden');
                    $('#customize-message-modal').modal('hide');
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_set_message/',
        });
    }

    function setShipping() {
        $('#submit-shipping-address').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');

        $('.data-address-important, .data-address-signup-important, #province, #city, #district').prev().children().html(' * Required').hide();
        $('.data-address-important, .data-address-signup-important, #province, #city, #district').css('border', '1px solid #d9d9d9');

        var found = 0;
        var name = $('#shipping-address-name').val();
        var firstName = $('#address-first-name').val();
        var lastName = $('#address-last-name').val();
        var phone = $('#address-phone-number').val();
        var email = $('#address-email').val();
        var address = $('#address-new-address').val();
        var zipcode = $('#address-zip-code').val();

        var countryId = $('#country').val();
        var provinceId = $('#province').val();
        var cityId = $('#city').val();
        var districtId = $('#district').val();
        var shippingId = $('#shipping').val();

        var password = $('#cart-sign-in-password').val();
        var confirmPassword = $('#cart-sign-in-confirm-password').val();

        $.each($('.data-address-important'), function(key, address) {
            if ($(address).val() == '' || $(address).val() == 0) {
                found += 1;

                $(address).prev().children().html(' * Required').show();
                $(address).css('border', '1px solid red');
            }
        });

        if (email != '' && !isEmail(email)) {
            found += 1;

            $('#address-email').prev().children().html(' * Wrong Email Format').show();
            $('#address-email').css('border', '1px solid red');
        }

        if (countryId <= 0) {
            found += 1;

            $('#country').prev().children().html(' * Required').show();
            $('#country').css('border', '1px solid red');
        }

        if (shippingId <= 0) {
            found += 1;

            $('#shipping').prev().children().html(' * Required').show();
            $('#shipping').css('border', '1px solid red');
        }

        /* if not login check password */
        <? if (!$customer): ?>
            if (password != '' && password != confirmPassword) {
                found += 1;

                $('#cart-sign-in-confirm-password').prev().children().html(' * Password not Match').show();
                $('#cart-sign-in-confirm-password').css('border', '1px solid red');
            }
        <? endif; ?>

        if (found > 0) {
            $('#submit-shipping-address').html('CONTINUE');

            return;
        }

        $.ajax({
            data :{
                city_id: cityId,
                country_id: countryId,
                district_id: districtId,
                province_id: provinceId,
                shipping_id: shippingId,
                name: name,
                first_name: firstName,
                last_name: lastName,
                phone: phone,
                email: email,
                address: address,
                zip_code: zipcode,
                password: password,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-address-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.href = "<?= base_url(); ?>cart/review/";
                }
                else {
                    if (data.message == 'Email already exist.') {
                        $('#address-email').prev().children().html(' * '+ data.message).show();
                        $('#address-email').css('border', '1px solid red');
                    }
                    else {
                        alert(data.message);
                    }

                    $('#submit-shipping-address').html('CONTINUE');
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>cart/ajax_set_shipping/',
        });
    }
</script>

</html>
