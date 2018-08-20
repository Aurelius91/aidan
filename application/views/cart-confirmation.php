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
                        <li class="active">
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
                    <div class="cart-section-inner nopadding">
                        <div class="row row-eq-height-tablet">
                            <div class="col-xs-12 col-sm-6 no-margin no-padding-right-tablet">
                                <div class="cart-confirmation-image">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/payment/confirmation.jpg)"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="cart-confirmation-content">
                                    <div class="cart-confirmation-content-inner">
                                        <h2>Thank you <br> for shopping with us!</h2>
                                        <hr>
                                        <p>Your order number is <span class="title-bold"><?= $order_number; ?></span> and a confirmation email is on its way.</p>
                                        <p>Orders cannot be modified or cancelled at this time.</p>
                                        <p>Questions or problems? Please let us know!</p>
                                        <p>Email us at <a href="mailto:hello@aidanandice.com" target="_top">hello@aidanandice.com</a> or request a call back.</p>
                                        <p>We will get back to you within <span class="title-bold">3x24 hours.</span></p>
                                        <a href="<?= base_url(); ?>cart/"><button class="btn btn-custom dark small">Continue Shopping</button></a>
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


</html>
