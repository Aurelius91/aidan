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
                                    <tr>
                                        <td class="col-xs-6 cart-product">
                                            <img src="<?= base_url(); ?>assets/images/products/product-1.jpg" alt="Product 1"><h4>ROSEMARY CHAIN</h4>
                                        </td>
                                        <td class="col-xs-3 cart-quantity">
                                            <div class="input-group input-group-stepper center">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-number" data-type="minus">
                                                        <span class="minus-sign"></span>
                                                    </button>
                                                </span>
                                                <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-number" data-type="plus">
                                                        <span class="plus-sign"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="col-xs-3 cart-price"><h4>IDR 2.300.000,-</h4></td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-6 cart-empty-placeholder"></td>
                                        <td class="col-xs-3 cart-subtotal">
                                            <h4>Sub Total</h4>
                                        </td>
                                        <td class="col-xs-3 cart-total">
                                            <h4>IDR 2.300.000,-</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-mobile">
                            <div class="cart-mobile-product">
                                <div class="cart-mobile-section">
                                    <div class="cart-mobile-section-title">
                                        <p>Product</p>
                                    </div>
                                    <div class="cart-mobile-section-content cart-product">
                                        <img src="<?= base_url(); ?>assets/images/products/product-1.jpg" alt="Product 1"><h4>ROSEMARY CHAIN</h4>
                                    </div>
                                </div>
                                <div class="cart-mobile-section">
                                    <div class="cart-mobile-section-title">
                                        <p>Quantity</p>
                                    </div>
                                    <div class="cart-mobile-section-content">
                                        <div class="input-group input-group-stepper center">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="minus">
                                                    <span class="minus-sign"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="plus">
                                                    <span class="plus-sign"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-mobile-section bottom-small">
                                    <div class="cart-mobile-section-title">
                                        <p>Price</p>
                                    </div>
                                    <div class="cart-mobile-section-content cart-price">
                                        <h4>IDR 2.300.000,-</h4>
                                    </div>
                                </div>
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
                                                <h4>IDR 2.300.000,-</h4>
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
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="first-name">First Name</label>
                                                <input type="text" class="form-control input-custom" id="first-name" placeholder="Your First Name">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="last-name">Last Name</label>
                                                <input type="text" class="form-control input-custom" id="last-name" placeholder="Your Last Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="address-1">Address 1</label>
                                                <input type="text" class="form-control input-custom" id="address-1" placeholder="Your Address">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="address-2">Address 2 (Optional)</label>
                                                <input type="text" class="form-control input-custom" id="address-2" placeholder="Your Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="zip-code">Zip Code</label>
                                                <input type="text" class="form-control input-custom" id="zip-code" placeholder="Your Zip Code">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group form-group-custom">
                                                <label for="state">State</label>
                                                <select class="form-control input-custom" id="state">
                                                    <option value="" selected disabled>Select Your State</option>
                                                    <option value="Jawa-Barat">Jawa Barat</option>
                                                    <option value="DKI-Jakarta">DKI Jakarta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group form-group-custom">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control input-custom" id="city" placeholder="Your City">
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
                                    <h4>CONTACT INFORMATION</h4>
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
                                                <label for="phone-number">Phone Number</label>
                                                <input type="text" class="form-control input-custom" id="phone-number" placeholder="Your Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="email-address">Email Address</label>
                                                <input type="text" class="form-control input-custom" id="email-address" placeholder="Your Email Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group form-group-custom">
                                                <label for="password">Password (To Make an Account)</label>
                                                <input type="password" class="form-control input-custom" id="password" placeholder="Your Password">
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
                                        <div class="col-xs-12">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" name="checkbox-jne" id="checkbox-jne" class="checkbox-custom" />
                                                <label for="checkbox-jne" class="checkbox-custom-label">JNE (Only Indonesia)</label>
                                            </div>
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" name="checkbox-gojek" id="checkbox-gojek" class="checkbox-custom" />
                                                <label for="checkbox-gojek" class="checkbox-custom-label">Gojek (Only Jakarta)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" name="checkbox-fedex" id="checkbox-fedex" class="checkbox-custom" />
                                                <label for="checkbox-fedex" class="checkbox-custom-label">Fedex (International)</label>
                                            </div>
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" name="checkbox-pick-up" id="checkbox-pick-up" class="checkbox-custom" />
                                                <label for="checkbox-pick-up" class="checkbox-custom-label">Pick Up (Near SCBD Area)</label>
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
										<div class="col-xs-12 col-sm-6">
											<p>All purchases come with a blank gift message card and envelope.</p>
											<button class="btn btn-custom dark small btn-customize-message" data-toggle="modal" data-target="#customize-message-modal">Customize my gift message</button>
											<button class="btn btn-custom dark small btn-customize-message">
												<span class="vertical-center">Remove</span>
												<span class="vertical-center"><img src="<?= base_url(); ?>assets/images/main/delete.png" alt="Delete" class="delete"></span>
											</button>
										</div>
										<div class="col-xs-12 col-sm-6">
											<div class="giftcard-custom">
												<img src="<?= base_url(); ?>assets/images/main/logo-emboss.png" alt="Aidan & Ice" class="giftcard-custom-image">
												<h3>Happy Birthday!</h3>
												<h3>Wish You all The Best</h3>
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
                                    <a href="<?= base_url(); ?>cart/review">
                                        <button class="btn btn-custom small dark full-mobile">
                                            CONTINUE
                                        </button>
                                    </a>
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
                            <textarea name="" id="" rows="10" class="form-control input-custom" placeholder="Enter Your Message Here"></textarea>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="checkbox-gift-wrapping" id="checkbox-gift-wrapping" class="checkbox-custom" />
                                <label for="checkbox-gift-wrapping" class="checkbox-custom-label">Gift Wrapping</label>
                            </div>
                            <p>*Messages are limited to 8 lines of text with 35 characters per line.</p>
                            <p>*The gift card will be handwritten</p>
                            <button class="btn btn-custom small">CANCEL</button>
                            <button class="btn btn-custom small dark">DONE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('js'); ?>


</html>
