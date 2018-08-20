<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/giftcard/header.jpg)">
            <div class="header-content white">
                <h2>GIFT CARDS</h2>
                <p class="giftcard-header-description">the perfect present every time</p>
            </div>
            <div class="header-bg-overlay"></div>
        </div>
    </section>

    <section id="general-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <img src="<?= base_url(); ?>assets/images/giftcard/printed.png" alt="" class="giftcard-image">
                    <div class="giftcard-description">
                        <h3>Printed</h3>
                        <p>Shipped in our luxury signature packaging</p>
                        <button class="btn btn-custom" data-toggle="modal" data-target="#printed-giftcard-modal">BUY NOW</button>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <img src="<?= base_url(); ?>assets/images/giftcard/virtual.png" alt="" class="giftcard-image">
                    <div class="giftcard-description">
                        <h3>Virtual</h3>
                        <p>Delivered directly into your recipient’s inbox</p>
                        <button class="btn btn-custom" data-toggle="modal" data-target="#virtual-giftcard-modal">BUY NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="printed-giftcard-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/giftcard/printed-modal.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <h3 class="normal">PRINTED GIFT CARDS</h3>
                                <div class="modal-form-wrapper">
                                    <div class="form-group form-group-custom">
                                        <label for="sign-in-email">VALUE <span class="error"> * Required</span></label>
                                        <select class="form-control input-custom" id="printed-giftcard-value">
                                            <option value="0">-- SELECT VOUCHER --</option>

                                            <? foreach ($arr_voucher as $voucher): ?>
                                                <? if ($voucher->type == 'Virtual'): ?>
                                                    <? continue; ?>
                                                <? endif; ?>

                                                <option value="<?= $voucher->id; ?>"><?= $voucher->name; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="printed-giftcard-quantity">Quantity</label>
                                        <div class="input-group input-group-stepper">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="minus" onclick="updateQuantity('printed', 'minus');">
                                                    <span class="minus-sign"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="printed-giftcard-quantity" class="form-control input-number" value="1" min="1" max="10" id="printed-giftcard-quantity">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="plus" onclick="updateQuantity('printed', 'plus');">
                                                    <span class="plus-sign"></span>
                                                </button>
                                          </span>
                                        </div>
                                    </div>

                                    <ul id="printed-message-tab" class="nav nav-tabs nav-tabs-custom small">
                                        <li id="printed-message-tab-1" class="active printed-message-tab" data-id="1" class="active"><a data-toggle="tab" href="#printed-message-1">Message 1</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="printed-message-1" class="tab-pane fade in active">
                                            <div class="form-group form-group-custom">
                                                <textarea name="name" rows="5" class="form-control input-custom noborder-top printed-message" id="printed-message-1-textbox" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                        <div id="printed-message-2" class="tab-pane fade">
                                            <div class="form-group form-group-custom">
                                                <textarea name="name" rows="5" class="form-control input-custom noborder-top printed-message" id="printed-message-2-textbox" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                        <div id="printed-message-3" class="tab-pane fade">
                                            <div class="form-group form-group-custom">
                                                <textarea name="name" rows="5" class="form-control input-custom noborder-top printed-message" id="printed-message-3-textbox" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                        <div id="printed-message-4" class="tab-pane fade">
                                            <div class="form-group form-group-custom">
                                                <textarea name="name" rows="5" class="form-control input-custom noborder-top printed-message" id="printed-message-4-textbox" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox-wrapper">
                                        <input type="checkbox" name="applies-to-all-printed" id="applies-to-all-printed" class="checkbox-custom" />
                                        <label for="applies-to-all-printed" class="checkbox-custom-label">Apply to All</label>
                                    </div>
                                </div>
                                <div class="modal-button-wrapper">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <button class="btn btn-custom small" data-dismiss="modal">CANCEL</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <button id="printed-add-to-cart-button" class="btn btn-custom dark small" onclick="voucherPrintedAddtoCart()">ADD TO SHOPPING BAG</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="virtual-giftcard-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/giftcard/virtual-modal.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <h3 class="normal">VIRTUAL GIFT CARDS</h3>
                                <div class="modal-form-wrapper">
                                    <div class="form-group form-group-custom">
                                        <label for="virtual-giftcard-value">VALUE <span class="error"> * Required</span></label>
                                        <select class="form-control input-custom" id="virtual-giftcard-value">
                                            <option value="0">-- SELECT VOUCHER --</option>

                                            <? foreach ($arr_voucher as $voucher): ?>
                                                <? if ($voucher->type != 'Virtual'): ?>
                                                    <? continue; ?>
                                                <? endif; ?>

                                                <option value="<?= $voucher->id; ?>"><?= $voucher->name; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="printed-giftcard-quantity">Quantity</label>
                                        <div class="input-group input-group-stepper">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="minus" onclick="updateQuantity('virtual', 'minus');">
                                                    <span class="minus-sign"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="virtual-giftcard-quantity" class="form-control input-number" value="1" id="virtual-giftcard-quantity">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="plus" onclick="updateQuantity('virtual', 'plus');">
                                                    <span class="plus-sign"></span>
                                                </button>
                                          </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="virtual-recipient-email">Recipient Email</label>
                                                <input type="text" class="form-control input-custom" id="virtual-recipient-email" placeholder="Your Recipient Email">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="virtual-recipient-name">Recipient Name</label>
                                                <input type="text" class="form-control input-custom" id="virtual-recipient-name" placeholder="Your Recipient Name">
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs nav-tabs-custom small">
                                        <li class="active"><a data-toggle="tab" href="#virtual-message-1">Message</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="virtual-message-1" class="tab-pane fade in active">
                                            <div class="form-group form-group-custom">
                                                <textarea name="name" rows="5" class="form-control input-custom noborder-top" id="virtual-message-textbox" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-button-wrapper">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <button class="btn btn-custom small" data-dismiss="modal">CANCEL</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <button id="virtual-add-to-cart-button" class="btn btn-custom dark small" onclick="voucherVirtualAddtoCart()">ADD TO SHOPPING BAG</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? $this->load->view('footer'); ?>
</body>

<? $this->load->view('scrollmagic'); ?>

<script>
    // small-header
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#small-header'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.to("section#small-header .header-bg-overlay", 0.5, {x: '100%'})
            .from("section#small-header .header-content h2", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .from("section#small-header .header-content p", 0.3, {y: 30, autoAlpha: 0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#general-section h2", 0.3, {y: 30, autoAlpha: 0})
            .staggerFrom("section#general-section .row > .col-xs-12.col-sm-6", 0.3, {y: 30, autoAlpha: 0},0.1)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetAll();
    });

    function resetAll() {
        $('#virtual-giftcard-quantity').val(1);
        $('#printed-giftcard-quantity').val(1);

        $('#virtual-giftcard-value').val(0);
        $('#printed-giftcard-value').val(0);
    }

    function updateQuantity(voucher, type) {
        if (voucher == 'virtual') {
            var quantity = parseInt($('#virtual-giftcard-quantity').val());

            if (type == 'minus') {
                quantity = quantity - 1;

                if (quantity <= 0) {
                    quantity = 1;
                }
            }
            else {
                quantity = quantity + 1;
            }

            $('#virtual-giftcard-quantity').val(quantity);
        }
        else {
            var quantity = parseInt($('#printed-giftcard-quantity').val());
            var oldQuantity = quantity;

            if (type == 'minus') {
                quantity = quantity - 1;

                if (quantity <= 0) {
                    quantity = 1;
                }

                if (oldQuantity > 1) {
                    $('#printed-message-tab-'+ oldQuantity).remove();
                }
            }
            else {
                quantity = quantity + 1;

                if (quantity <= 4) {
                    var messageTab = '<li id="printed-message-tab-'+ quantity +'" class="printed-message-tab" data-id="'+ quantity +'"><a data-toggle="tab" href="#printed-message-'+ quantity +'">Message '+ quantity +'</a></li>';
                    $('#printed-message-tab').append(messageTab);
                }

                if (quantity >= 4) {
                    quantity = 4;
                }
            }

            $('#printed-giftcard-quantity').val(quantity);
        }
    }

    function voucherVirtualAddtoCart() {
        $('#virtual-add-to-cart-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');
        $('#virtual-giftcard-value').prev().children().html(' * Required').hide();
        $('#virtual-giftcard-value').css('border', '1px solid #d9d9d9');

        var voucherId = $('#virtual-giftcard-value').val();
        var quantity = $('#virtual-giftcard-quantity').val();
        var email = $('#virtual-recipient-email').val();
        var name = $('#virtual-recipient-name').val();
        var message = $('#virtual-message-textbox').val();

        if (voucherId <= 0) {
            $('#virtual-add-to-cart-button').html('ADD TO SHOPPING BAG');

            $('#virtual-giftcard-value').prev().children().html(' * Required').show();
            $('#virtual-giftcard-value').css('border', '1px solid red');

            return;
        }

        $.ajax({
            data :{
                voucher_id: voucherId,
                quantity: quantity,
                email: email,
                name: name,
                message: message,
                type: 'Virtual',
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('#navbar-cart-list').empty();
                    $('#virtual-giftcard-modal').modal('hide');

                    var lastCart = '<div class="row"><div class="col-xs-8 v-center cart-item-left"><div class="cart-item-thumbnail"><div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/giftcard/virtual.png)"></div></div><!----><div class="cart-item-description"><h5 class="cart-item-name">'+ data.voucher.name +'</h5><div class="cart-item-quantity">Qty: '+ data.voucher.quantity +'</div><div class="cart-item-quantity">Price: '+ data.voucher.price_display +'</div></div></div><!----><div class="col-xs-4 v-center"><h5 class="cart-price">'+ data.voucher.total_display +',-</h5></div>';

                    $('#navbar-cart-list').append(lastCart);
                    $('#navbar-cart-list-mobile').append(lastCart);
                    $('#navbar-dropdown-cart').addClass('open');
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>giftcard/ajax_add_to_cart/',
        });
    }

    function voucherPrintedAddtoCart() {
        $('#printed-add-to-cart-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');
        $('#printed-giftcard-value').prev().children().html(' * Required').hide();
        $('#printed-giftcard-value').css('border', '1px solid #d9d9d9');

        var voucherId = $('#printed-giftcard-value').val();
        var quantity = $('#printed-giftcard-quantity').val();
        var email = $('#printed-recipient-email').val();
        var name = $('#printed-recipient-name').val();
        var message = $('#printed-message-textbox').val();

        if (voucherId <= 0) {
            $('#printed-add-to-cart-button').html('ADD TO SHOPPING BAG');

            $('#printed-giftcard-value').prev().children().html(' * Required').show();
            $('#printed-giftcard-value').css('border', '1px solid red');

            return;
        }

        var arrMessage = [];

        $.each($('.printed-message-tab'), function(key, msg) {
            var messageCount = $(msg).attr('data-id');

            var text = $('#printed-message-'+ messageCount +'-textbox').val();
            arrMessage.push(text);
        });

        $.ajax({
            data :{
                voucher_id: voucherId,
                quantity: quantity,
                email: email,
                name: name,
                message: JSON.stringify(arrMessage),
                type: 'Printed',
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('#navbar-cart-list').empty();
                    $('#printed-giftcard-modal').modal('hide');

                    var lastCart = '<div class="row"><div class="col-xs-8 v-center cart-item-left"><div class="cart-item-thumbnail"><div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/giftcard/printed.png)"></div></div><!----><div class="cart-item-description"><h5 class="cart-item-name">'+ data.voucher.name +'</h5><div class="cart-item-quantity">Qty: '+ data.voucher.quantity +'</div><div class="cart-item-quantity">Price: '+ data.voucher.price_display +'</div></div></div><!----><div class="col-xs-4 v-center"><h5 class="cart-price">'+ data.voucher.total_display +',-</h5></div>';

                    $('#navbar-cart-list').append(lastCart);
                    $('#navbar-cart-list-mobile').append(lastCart);
                    $('#navbar-dropdown-cart').addClass('open');
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>giftcard/ajax_add_to_cart/',
        });
    }
</script>

</html>
