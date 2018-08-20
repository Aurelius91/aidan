<!DOCTYPE html>
<html lang="en">

<head>
    <? $this->load->view('header'); ?>
        <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="product-detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="product-detail-image">
                        <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-detail.jpg)"></div>
                    </div><!--
                 --><div class="product-detail-carousel-wrapper">
                        <div class="product-detail-carousel">
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-1.jpg)"></div>
                                </div>
                            </div>
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-2.jpg)"></div>
                                </div>
                            </div>
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-3.jpg)"></div>
                                </div>
                            </div>
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-4.jpg)"></div>
                                </div>
                            </div>
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-5.jpg)"></div>
                                </div>
                            </div>
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/products/product-6.jpg)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="product-detail-description">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3><?= $product->name; ?></h3>
                                <h4 class="price"><?= $product->price_display; ?>,-</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="description-section">
                                    <p class="sub-heading">Description:</p>
                                    <div class="description-text">
                                        <? if ($lang == $setting->setting__system_language || $product->description_lang == ''): ?>
                                            <p><?= $product->description; ?></p>
                                        <? else: ?>
                                            <p><?= $product->description_lang; ?></p>
                                        <? endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="description-section">
                                    <p class="sub-heading">Color</p>
                                    <div class="product-material">
                                        <div class="product-material-thumbnail" style="background-image:url(<?= base_url(); ?>assets/images/products/pearl.png)"></div>
                                        <p class="product-material-text">Pearl</p>
                                    </div>
                                    <div class="product-material">
                                        <div class="product-material-thumbnail" style="background-image:url(<?= base_url(); ?>assets/images/products/gold.png)"></div>
                                        <p class="product-material-text">Gold</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12- col-sm-8">
                                <div class="description-section">
                                    <p class="sub-heading">Speak To Our Expert:</p>
                                    <p>Call us at: <span class="grey">+62816970555</span> or Send us an <a href="mailto:someone@example.com">email</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="description-section">
                                    <p class="sub-heading">Quantity:</p>
                                    <div class="input-group input-group-stepper">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-number" data-type="minus" onclick="updateQuantity('minus');">
                                                <span class="minus-sign"></span>
                                            </button>
                                        </span>
                                        <input id="product-quantity" type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-number" data-type="plus" onclick="updateQuantity('plus');">
                                                <span class="plus-sign"></span>
                                            </button>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="description-action">
                                    <? if ($customer): ?>
                                        <button class="btn btn-custom small full-mobile" onclick="addWishlist();">ADD TO WISHLIST</button>
                                    <? else: ?>
                                        <button class="btn btn-custom small full-mobile" data-toggle="modal" data-target="#sign-in-modal">ADD TO WISHLIST</button>
                                    <? endif; ?>

                                    <button class="btn btn-custom dark small full-mobile no-margin-left-mobile" data-toggle="modal" data-target="#preorder-modal">PRE ORDER</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr class="product-detail-line">
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-xs-12 text-right">
                                <p class="share-text">SHARE</p>
                                <ul class="footer-social-media-wrapper inline">
                                    <li>
                                        <a href="#">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-facebook fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-twitter fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-skype fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-instagram fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="product-similar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3>YOU MIGHT ALSO LIKE</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3">
                    <div class="product-grid">
                        <img src="<?= base_url(); ?>assets/images/products/product-1.jpg" alt="" class="product-grid-image">
                        <p>When In Pearls</p>
                        <div class="product-hover">
                            <div class="product-hover-image" style="background-image:url(<?= base_url(); ?>assets/images/products/product-hover.jpg)"></div>
                            <p class="product-hover-name">When In Pearls</p>
                            <p class="product-hover-price">IDR 2.300.000,-</p>
                            <button class="btn btn-custom dark">QUICKSHOP</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="product-grid">
                        <img src="<?= base_url(); ?>assets/images/products/product-2.jpg" alt="" class="product-grid-image">
                        <p>Como Pearl Sunglasses</p>
                        <div class="product-hover">
                            <div class="product-hover-image" style="background-image:url(<?= base_url(); ?>assets/images/products/product-hover.jpg)"></div>
                            <p class="product-hover-name">When In Pearls</p>
                            <p class="product-hover-price">IDR 2.300.000,-</p>
                            <button class="btn btn-custom dark">QUICKSHOP</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="product-grid">
                        <img src="<?= base_url(); ?>assets/images/products/product-3.jpg" alt="" class="product-grid-image">
                        <p>Hemera Pearls</p>
                        <div class="product-hover">
                            <div class="product-hover-image" style="background-image:url(<?= base_url(); ?>assets/images/products/product-hover.jpg)"></div>
                            <p class="product-hover-name">When In Pearls</p>
                            <p class="product-hover-price">IDR 2.300.000,-</p>
                            <button class="btn btn-custom dark">QUICKSHOP</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="product-grid">
                        <img src="<?= base_url(); ?>assets/images/products/product-4.jpg" alt="" class="product-grid-image">
                        <p>C Pearl Ruff</p>
                        <div class="product-hover">
                            <div class="product-hover-image" style="background-image:url(<?= base_url(); ?>assets/images/products/product-hover.jpg)"></div>
                            <p class="product-hover-name">When In Pearls</p>
                            <p class="product-hover-price">IDR 2.300.000,-</p>
                            <button class="btn btn-custom dark">QUICKSHOP</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <? $this->load->view('footer'); ?>

    <div id="preorder-modal" class="modal modal-custom preorder fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-close" data-dismiss="modal">
                        <div class="close-icon"></div>
                    </button>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h2>PRE - ORDER</h2>
                            <h4>Thank You For The Interest In Our Product!</h4>
                            <p>We will let you know exactly when the product has been shipped</p>
                            <img src="<?= base_url(); ?>assets/images/products/product-detail.jpg" alt="" class="preorder-modal-image">
                            <p class="description">*Will take approx us 1 month for all pre - orders</p>
                            <a href="<?= base_url(); ?>cart"><button class="btn btn-custom dark small">Continue to payment</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!--[if (lt IE 9)]><script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.helper.ie8.js"></script><![endif]-->
<script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.js"></script>

<script>
    var slider = tns({
        container: '.product-detail-carousel',
        items: 3,
        mouseDrag: true,
        swipeAngle: false,
        arrowKeys: true,
        autoplay: false,
        loop: true,
        nav: false,
        gutter: 15,
        controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
        responsive: {
            "768": {
              // "items": 3,
              items: 4,
              axis: "vertical",
            }
        }
    });
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetQuantity();
    });

    function addWishlist() {
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
                    alert('success');
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>product/ajax_add_wishlist/<?= $product->id; ?>',
        });
    }

    function resetQuantity() {
        $('#product-quantity').val(1).prop('disabled', true);
    }

    function updateQuantity(type) {
        var quantity = parseInt($('#product-quantity').val());

        if (type == 'minus') {
            quantity = quantity - 1;

            if (quantity <= 0) {
                quantity = 1;
            }

            $('#product-quantity').val(quantity);
        }
        else {
            quantity = quantity + 1;

            $('#product-quantity').val(quantity);
        }
    }
</script>

</html>
