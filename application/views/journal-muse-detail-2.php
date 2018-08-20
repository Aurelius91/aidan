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
        <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image2_name; ?>)">
            <? if ($muse->youtube_url != ''): ?>
                <div class="header-content">
                    <img src="<?= base_url(); ?>assets/images/main/play-button.png" alt="" class="play-button">
                    <p class="play-video-text">Play Video</p>
                </div>
            <? endif; ?>

            <div class="header-bg-overlay"></div>
            <div class="muse-detail-video-wrapper">
                <iframe id="muse-detail-video" src="<?= $muse->youtube_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <section id="general-section" class="no-padding-side">
        <div class="container-fluid">
            <div class="row muse-detail-alternative-image-1">
                <div class="col-xs-12 col-sm-6 v-center-tablet">
                    <div class="muse-detail-alternative-image no-1">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image_name; ?>)"></div>
                    </div>
                </div><!--
             --><div class="col-xs-12 col-sm-6 v-center-tablet">
                    <div class="muse-detail-alternative-information">
                        <h3><?= $muse->title_1; ?></h3>
                        <?= $muse->description_1; ?>
                    </div>
                </div>
            </div>
            <div class="row muse-detail-alternative-image-2">
                <div class="col-xs-12 col-sm-6 col-sm-push-6 v-center-tablet">
                    <div class="muse-detail-alternative-image">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image3_name; ?>)"></div>
                    </div>
                </div><!--
             --><div class="col-xs-12 col-sm-6 col-sm-pull-6 v-center-tablet">
                    <div class="muse-detail-alternative-information">
                        <?= $muse->description_2; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="muse-detail-shop-their-look side-padding bottom-padding" id="top">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h3 class="margin-top-0-mobile">shop their look</h3>
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="muse-detail-alternative-image-long">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image4_name; ?>)"></div>
                    </div>
                </div>
            </div>
            <div class="row row-muse-detail-2">
                <div class="col-xs-6 col-sm-6 padding-right-mobile">
                    <div class="muse-detail-alternative-image-2 left">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image5_name; ?>)"></div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 padding-left-mobile">
                    <div class="muse-detail-alternative-image-2">
                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image6_name; ?>)"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="muse-detail-alternative-information-2">
                        <p class="subtitle"><?= $muse->title_3; ?></p>
                        <?= $muse->description_3; ?>
                        <button class="btn btn-custom dark" data-toggle="modal" data-target="#journal-muse-detail-modal">view more photos</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="section-side-padding">
                        <hr class="no-margin">
                    </div>
                </div>
            </div>
            <? if (count($muse->arr_product) > 0): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="muse-detail-shop-their-look side-padding bottom-padding" id="bottom">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <h3>shop their look</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 product-slider-wrapper">
                                    <div class="product-slider-2">
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
                            <h3>All PHOTO COLLECTION</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <hr class="muse-detail-popup-line">
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
              "items": 5
            }
        }
    });
</script>

<script>
    var slider = tns({
        container: '.product-slider-2',
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
              "items": 5
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
            .from("section#small-header .header-content img.play-button", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .from("section#small-header .header-content .play-video-text", 0.3, {y: 30, autoAlpha: 0},'-=0.2')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script type="text/javascript">
    // muse-detail-alternative-image 1
    // create a scene
    var scene1 = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-alternative-image-1'
    });

    // add multiple tweens, wrapped in a timeline.
    var timeline1 = new TimelineMax();
    timeline1.from(".muse-detail-alternative-image-1 .muse-detail-alternative-image", 0.3, {y: 30, autoAlpha: 0})
             .from(".muse-detail-alternative-image-1 .muse-detail-alternative-information h3", 0.3, {y: 30, autoAlpha: 0},'-=0.2')
             .staggerFrom(".muse-detail-alternative-image-1 .muse-detail-alternative-information .point", 0.3, {y: 30, autoAlpha: 0},0.1,'-=0.2');

    scene1.setTween(timeline1)
    .addTo(controller);
</script>

<script type="text/javascript">
    // muse-detail-alternative-image 2
    // create a scene
    var scene2 = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-alternative-image-2'
    });

    var timeline2 = new TimelineMax();
    timeline2.from(".muse-detail-alternative-image-2 .muse-detail-alternative-image", 0.3, {y: 30, autoAlpha: 0})
             .staggerFrom(".muse-detail-alternative-image-2 .muse-detail-alternative-information .point", 0.3, {y: 30, autoAlpha: 0},0.1,'-=0.2');

    scene2.setTween(timeline2)
    .addTo(controller);
</script>

<script>
    // loop for general section which has same structure
    var elements = document.getElementsByClassName('muse-detail-shop-their-look');

    for(var i = 0; i < elements.length; i++){
        var section = '.muse-detail-shop-their-look#' + elements[i].id;

        // create a scene
        var scene = new ScrollMagic.Scene({
            triggerElement: section
        })

        // add multiple tweens, wrapped in a timeline.
        var timeline = new TimelineMax();
        timeline.from(section + " h3", 0.3, {y: 30, autoAlpha: 0})
                .from(section + " .product-slider-wrapper", 0.3, {y: 30, autoAlpha: 0})

        scene.setTween(timeline)
    	.addTo(controller);
    }
</script>

<script type="text/javascript">
    // muse-detail-alternative-image 2
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.muse-detail-alternative-image-long'
    });

    var timeline = new TimelineMax();
    timeline.from(".muse-detail-alternative-image-long > .content-inside", 0.3, {y: 30, autoAlpha: 0})
            .staggerFrom(".row-muse-detail-2 .muse-detail-alternative-image-2", 0.3, {y: 30, autoAlpha: 0},0.1,'-=0.1')
            .from(".muse-detail-alternative-information-2", 0.3, {y: 30, autoAlpha: 0})

    scene.setTween(timeline)
    .addTo(controller);
</script>

<script type="text/javascript">
    document.querySelector('.play-button').addEventListener('click', function(e) {
        document.querySelector('.muse-detail-video-wrapper').classList.add('active');
        document.querySelector('iframe#muse-detail-video').src += "&autoplay=1";
    })
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

    // $('.play-button').on('click', function(ev) {
    //     $('.muse-detail-video-wrapper').addClass('active');
    //     $("iframe#muse-detail-video")[0].src += "&autoplay=1";
    //     ev.preventDefault();
    // });
</script>

</html>
