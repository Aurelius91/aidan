<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <h2 class="small-header-title"><?= $muse->name; ?></h2>
        <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image_name; ?>)">
            <div class="header-bg-overlay"></div>
        </div>
    </section>

    <section id="general-section" class="no-padding-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-5">
                    <div class="muse-detail-profile-img">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image2_name; ?>)"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-7">
                    <div class="muse-detail-profile-information">
                        <h3><?= $muse->title_1; ?></h3>
                        <div class="point">
                            <?= $muse->description_1; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="muse-detail-image">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image3_name; ?>)"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="muse-detail-image">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image4_name; ?>)"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="muse-about-person-title"><?= $muse->title_2; ?></h3>
                </div>
            </div>
            <div class="row">
                <div style="column-count: 2;">
                    <?= $muse->description_2; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="no-padding-top">
        <div class="muse-detail-image-long">
            <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image5_name; ?>)"></div>
        </div>
    </section>
    <section id="general-bottom-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="muse-detail-person-quote">
                        <p class="subtitle"><?= $muse->custom_text_1; ?></p>
                        <h4><?= $muse->custom_text_2; ?></h4>
                        <button class="btn btn-custom dark" data-toggle="modal" data-target="#journal-muse-detail-modal">view more photos</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr class="no-margin">
                </div>
            </div>
            <? if (count($muse->arr_product) > 0): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="muse-detail-shop-their-look">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h3>shop their look</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 product-slider-wrapper">
                                    <div class="product-slider">
                                        <? foreach ($muse->arr_product as $product): ?>
                                            <div>
                                                <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
                                                    <div class="product-grid">
                                                        <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="product-grid-image">
                                                        <p><?= $product->name; ?></p>
                                                    </div>
                                                </a>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </section>

    <div id="journal-muse-detail-modal" class="modal modal-custom media event fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-close" data-dismiss="modal">
                        <div class="close-icon"></div>
                    </button>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h3>ALL PHOTO COLLECTION</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="responsive-gallery-outer">
                                <ul class="responsiveGallery-wrapper">
                                    <? foreach ($arr_image as $image): ?>
                                        <li class="responsiveGallery-item">
                                            <div class="gambar">
                                                <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $image->image_name; ?>);"></div>
                                            </div>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                                <div class="navigation-wrapper">
                                    <button class="prev">
                                        <img src="<?= base_url(); ?>assets/images/main/arrow-left.png" alt="">
                                    </button>
                                    <button class="next">
                                        <img src="<?= base_url(); ?>assets/images/main/arrow-right.png" alt="">
                                    </button>
                                </div>
                            </div>
                            <!-- <div class="journal-events-thumbnail-normal" data-toggle="modal" data-target="#journal-events-modal">
                                <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-1.jpg)"></div>
                            </div> -->

                            <? if (count($muse->arr_product) > 0): ?>
                                <div class="row margin-top-3">
                                    <div class="col-xs-12 text-center">
                                        <? foreach ($muse->arr_product as $product): ?>
                                            <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
                                                <div class="product-grid muse-detail">
                                                    <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="product-grid-image">
                                                    <p><?= $product->name; ?></p>
                                                </div>
                                            </a>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            <? endif; ?>
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
        container: '.product-slider',
        items: 2,
        mouseDrag: true,
        swipeAngle: false,
        arrowKeys: true,
        autoplay: false,
        loop: true,
        nav: false,
        controls: true,
        controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
        responsive: {
            "768": {
              "items": 3,
            },
            "1080": {
              "items": 4
            }
        }
    });
</script>

<? $this->load->view('scrollmagic'); ?>

<script>
    // small-header
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#small-header'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.to("section#small-header .header-bg-overlay", 0.6, {x: '100%'})

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // general section
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".muse-detail-profile-img", 0.3, {y: 30, autoAlpha:0})
    timeline.from(".muse-detail-profile-information h3", 0.3, {y: 30, autoAlpha:0}, '-=0.2')
    timeline.staggerFrom(".muse-detail-profile-information .point", 0.3, {y: 30, autoAlpha:0},0.1, '-=0.2')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // general section
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-image'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.staggerFrom(".muse-detail-image", 0.3, {y: 30, autoAlpha:0},0.15)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.muse-about-person-title'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".muse-about-person-title", 0.3, {y: 30, autoAlpha:0})
    timeline.staggerFrom(".muse-about-person-point", 0.3, {y: 30, autoAlpha:0},0.1,'-=0.2')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-image-long'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".muse-detail-image-long", 0.3, {y: 30, autoAlpha:0})
    timeline.from(".muse-detail-person-quote", 0.3, {y: 30, autoAlpha:0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-shop-their-look'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".muse-detail-shop-their-look h3", 0.3, {y: 30, autoAlpha:0})
    timeline.from(".muse-detail-shop-their-look .product-slider-wrapper", 0.3, {y: 30, autoAlpha:0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>


<? $this->load->view('js'); ?>

<script src="<?= base_url(); ?>assets/plugin/responsive-gallery/jquery.responsiveGallery.js"></script>
<script type="text/javascript">
    $('#journal-muse-detail-modal').on('shown.bs.modal', function () {
        $('.responsiveGallery-wrapper').responsiveGallery({
            animatDuration: 400,
            $btn_prev: $('.responsive-gallery-outer .navigation-wrapper button.prev'),
            $btn_next: $('.responsive-gallery-outer .navigation-wrapper button.next')
        });
    });
</script>

</html>
