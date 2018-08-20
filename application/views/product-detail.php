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
                    <!-- <div class="product-detail-image">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>)"  data-zoom-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>"></div>
                    </div> -->
                    <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="product-detail-image" data-zoom-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>"><!--
                 --><div class="product-detail-carousel-wrapper hidden-xs">
                        <div class="product-detail-carousel">
                            <div>
                                <div class="product-detail-carousel-item">
                                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>);" data-zoom-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>"></div>
                                </div>
                            </div>

                            <? if ($product->image_hover_name != ''): ?>
                                <div>
                                    <div class="product-detail-carousel-item">
                                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_hover_name; ?>);" data-zoom-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_hover_name; ?>"></div>
                                    </div>
                                </div>
                            <? endif; ?>

                            <? foreach ($product->arr_slider_image as $slider_image): ?>
                                <div>
                                    <div class="product-detail-carousel-item">
                                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $slider_image; ?>);" data-zoom-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $slider_image; ?>"></div>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>

                    <div class="product-detail-carousel-wrapper visible-xs">
                       <div class="product-detail-carousel mobile">
                           <div>
                               <div class="product-detail-carousel-item">
                                   <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>);"></div>
                               </div>
                           </div>

                           <? if ($product->image_hover_name != ''): ?>
                               <div>
                                   <div class="product-detail-carousel-item">
                                       <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_hover_name; ?>);"></div>
                                   </div>
                               </div>
                           <? endif; ?>

                           <? foreach ($product->arr_slider_image as $slider_image): ?>
                                <div>
                                   <div class="product-detail-carousel-item">
                                       <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $slider_image; ?>);"></div>
                                   </div>
                               </div>
                            <? endforeach; ?>
                       </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="product-detail-description">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3><?= $product->name; ?></h3>
                                <? if ($product->price_discount > 0): ?>
                                    <h4 class="price">
										<span class="normal-price-slash">
											<span class="normal-price-color">
												<?= $product->price_display; ?>,-
											</span>
										</span>
										<span><?= $product->price_discount_display; ?></span>
									</h4>
                                <? else: ?>
                                    <h4 class="price"><?= $product->price_display; ?>,-</h4>
                                <? endif; ?>
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

                                    <? foreach ($arr_color as $color): ?>
                                        <div class="product-material">
                                            <div class="product-material-thumbnail" style="background: <?= $color->hex; ?>;"></div>
                                            <p class="product-material-text"><?= $color->name; ?></p>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                            <div class="col-xs-12- col-sm-8">
                                <div class="description-section">
                                    <p class="sub-heading">Speak To Our Expert:</p>
                                    <p>Call us <a href="tel:<?= $setting->company_phone2; ?>"><span class="grey"><?= $setting->company_phone2; ?></span></a> or Send us an <a href="mailto:sales@aidanandice.com">email</a></p>
                                </div>
                            </div>
                        </div>

                        <? if ($product->inventory > 0): ?>
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
                        <? endif; ?>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="description-action">
                                    <? if ($customer): ?>
                                        <button class="btn btn-custom small full-mobile" onclick="addWishlist();">ADD TO WISHLIST</button>
                                    <? else: ?>
                                        <button class="btn btn-custom small full-mobile" data-toggle="modal" data-target="#sign-in-modal">ADD TO WISHLIST</button>
                                    <? endif; ?>

                                    <? if ($product->inventory > 0): ?>
                                        <button class="btn btn-custom dark small full-mobile no-margin-left-mobile" onclick="addToCart();">ADD TO CART</button>
                                    <? else: ?>
                                        <button class="btn btn-custom dark small full-mobile no-margin-left-mobile" data-toggle="modal" data-target="#preorder-modal">PRE ORDER</button>
                                    <? endif; ?>
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
                <? foreach ($arr_related_product as $related_product): ?>
                    <div class="col-xs-6 col-sm-3">
                        <a href="<?= base_url(); ?>product/detail/<?= $related_product->url_name; ?>/">
                            <div class="product-grid">
                                <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $related_product->image_name; ?>" alt="" class="product-grid-image">
                                <p><?= $related_product->name; ?></p>
                                <div class="product-hover">
                                    <a href="<?= base_url(); ?>product/detail/<?= $related_product->url_name; ?>/">
                                        <? if ($related_product->image_hover_name == ''): ?>
                                            <div class="product-hover-image" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $related_product->image_name; ?>)"></div>
                                        <? else: ?>
                                            <div class="product-hover-image" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $related_product->image_hover_name; ?>)"></div>
                                        <? endif; ?>
                                    </a>
                                    <p class="product-hover-name"><?= $related_product->name; ?></p>

                                    <? if ($related_product->price_discount > 0): ?>
                                        <p class="product-hover-price"><span class="normal-price-slash" style="text-decoration: line-through;"><?= $related_product->price_display; ?>,-</span> <?= $related_product->price_discount_display; ?></p>
                                    <? else: ?>
                                        <p class="product-hover-price"><?= $related_product->price_display; ?>,-</p>
                                    <? endif; ?>

                                    <button class="btn btn-add-to-wishlist">
                                        <svg class="heart" viewBox="0 0 32 32">
                                            <path id="heart-icon" d="M16,28.261c0,0-14-7.926-14-17.046c0-9.356,13.159-10.399,14-0.454c1.011-9.938,14-8.903,14,0.454 C30,20.335,16,28.261,16,28.261z"/>
                                        </svg>
                                    </button>
                                    <a href="<?= base_url(); ?>product/detail/<?= $related_product->url_name; ?>/">
                                        <button class="btn btn-custom dark">QUICKSHOP</button>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </section>

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
                            <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="preorder-modal-image">
                            <p class="description">*Will take approx us 1 month for all pre - orders</p>
                            <input type="text" class="form-control input-custom" placeholder="Your Email Address" style="max-width: 400px;margin-right: auto;margin-left: auto;margin-top: 24px;margin-bottom: 0px;">
                            <a href="<?= base_url(); ?>cart"><button class="btn btn-custom dark small">Send</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? $this->load->view('footer'); ?>
</body>

<!--[if (lt IE 9)]><script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.helper.ie8.js"></script><![endif]-->
<script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.js"></script>

<script>
    var slider = tns({
        container: '.product-detail-carousel',
        items: 4,
        mouseDrag: true,
        swipeAngle: false,
        arrowKeys: true,
        autoplay: false,
        axis: "vertical",
        loop: true,
        nav: false,
        gutter: 15,
        controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
    });
</script>

<script>
    var slider = tns({
        container: '.product-detail-carousel.mobile',
        items: 3,
        mouseDrag: true,
        swipeAngle: false,
        arrowKeys: true,
        autoplay: false,
        loop: true,
        nav: false,
        gutter: 15,
        controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
    });
</script>

<? $this->load->view('js'); ?>

<script src="<?= base_url(); ?>assets/plugin/elevateZoom/jquery.elevateZoom-3.0.8.min.js"></script>

<script>
    var zoomConfig = {};
    var image = $('.product-detail-carousel .product-detail-carousel-item .content-inside');
    var zoomImage = $('.product-detail-image');

    if ($(window).width() > 990) {
        zoomImage.elevateZoom(zoomConfig);//initialise zoom
    }

    image.on('click', function(){
        // Remove old instance od EZ
        $('.zoomContainer').remove();
        zoomImage.removeData('elevateZoom');
        // Update source for images
        zoomImage.attr('src', $(this).data('zoom-image'));
        // zoomImage.attr('data-zoom-image', $(this).data('zoom-image'));
        zoomImage.data('zoom-image', $(this).data('zoom-image'));

        if ($(window).width() > 990) {
            //Reinitialize EZ
            zoomImage.elevateZoom(zoomConfig);
        }
    });
</script>


<script type="text/javascript">
    $(function() {
        resetQuantity();
    });

    function addToCart() {
        var quantity = $('#product-quantity').val();
        var productId = "<?= $product->id; ?>";

        $.ajax({
            data :{
                product_id: productId,
                quantity: quantity,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('#navbar-cart-list, #navbar-cart-list-mobile').empty();

                    var lastCart = '<div class="row"><div class="col-xs-8 v-center cart-item-left"><div class="cart-item-thumbnail"><div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/'+ data.product.image_name +')"></div></div><!----><div class="cart-item-description"><h5 class="cart-item-name">'+ data.product.name +'</h5><div class="cart-item-quantity">Qty: '+ data.product.quantity +'</div><div class="cart-item-quantity">Price: '+ data.product.price_display +'</div></div></div><!----><div class="col-xs-4 v-center"><h5 class="cart-price">'+ data.product.total_display +',-</h5></div>';

                    $('#navbar-cart-list').append(lastCart);
                    $('#navbar-cart-list-mobile').append(lastCart);
                    $('#navbar-dropdown-cart').addClass('open');

                    if ($(window).width() < 768) {
                        $('#cart-modal').modal('show');
                    }
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>product/ajax_add_to_cart/',
        });
    }

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
            url : '<?= base_url(); ?>product/ajax_add_wishlist/<?= $product->id; ?>/',
        });
    }

    function resetQuantity() {
        $('#product-quantity').val(1).prop('disabled', true);
    }

    function updateQuantity(type) {
        var quantity = parseInt($('#product-quantity').val());
        var maxQuantity = parseInt("<?= $product->inventory; ?>");

        if (type == 'minus') {
            quantity = quantity - 1;

            if (quantity <= 0) {
                quantity = 1;
            }

            $('#product-quantity').val(quantity);
        }
        else {
            quantity = quantity + 1;

            if (quantity >= maxQuantity) {
                quantity = maxQuantity;
            }

            $('#product-quantity').val(quantity);
        }
    }
</script>

</html>
