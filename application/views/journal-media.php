<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <? if ($arr_section[0]->image_name == ''): ?>
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/journal/media/header.jpg)">
                <div class="header-content white">
                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                        <h2><?= $arr_section[0]->title; ?></h2>
                    <? else: ?>
                        <h2><?= $arr_section[0]->title_lang; ?></h2>
                    <? endif; ?>
                </div>
                <div class="header-bg-overlay"></div>
            </div>
        <? else: ?>
            <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[0]->image_name; ?>)">
                <div class="header-content white">
                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                        <h2><?= $arr_section[0]->title; ?></h2>
                    <? else: ?>
                        <h2><?= $arr_section[0]->title_lang; ?></h2>
                    <? endif; ?>
                </div>
                <div class="header-bg-overlay"></div>
            </div>
        <? endif; ?>
    </section>

    <section id="general-section">
        <div class="container-fluid">
<!--
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div class="section-description margin-bottom">
                        <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris</p>
                    </div>
                </div>
            </div>
-->
            <div class="row">
                <div class="col-xs-12 col-sm-2">
                    <h4 id="filter-text">FILTER</h4>
                    <hr class="journal-media-line">
                    <ul class="journal-media-filter">
                        <li <? if ($this_year == ''): ?>class="active"<? endif; ?>><a href="<?= base_url(); ?>journal/media/">All</a></li>

                        <? foreach ($arr_year as $year): ?>
                            <li <? if ($this_year == $year): ?>class="active"<? endif; ?>><a href="<?= base_url(); ?>journal/media/<?= $year; ?>"><?= $year; ?></a></li>
                        <? endforeach; ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-10">
                    <div class="row">
                        <? foreach ($arr_media as $media): ?>
                            <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="journal-media-thumbnail" onclick="getMediaDetail('<?= $media->id; ?>');">
                                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $media->image_name; ?>)"></div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="journal-media-modal" class="modal modal-custom media fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-close visible-xs" data-dismiss="modal">
                        <div class="close-icon"></div>
                    </button>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 journal-media-slider-wrapper">

                            <div class="journal-media-slider">
                                <div>
                                    <div class="journal-media-modal-img">
                                        <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/media/carousel.jpg)">
                                            <div class="black-gradient-overlay"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="journal-media-modal-img">
                                        <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/media/carousel.jpg)">
                                            <div class="black-gradient-overlay"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <button class="btn btn-close hidden-xs" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <h4 id="media-title">Cleo Magazine Cover - September 2016</h4>
                                <p id="media-subtitle" class="subtitle">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
                                <div id="media-description">
                                    <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>
                                    <p>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo.</p>
                                    <p>Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc.</p>
                                </div>
                                <hr>
                                <h5>SHOP THEIR LOOKS</h5>
                                <!-- <div class="shop-their-looks-wrapper">
									<a href="<?= base_url(); ?>product/detail">
										<img src="<?= base_url(); ?>assets/images/main/jewelerry-1.jpg" alt="" class="shop-their-looks-img">
										<p>N Green Troops</p>
									</a>
                                </div>
                                <div class="shop-their-looks-wrapper">
									<a href="<?= base_url(); ?>product/detail">
	                                    <img src="<?= base_url(); ?>assets/images/main/jewelerry-2.jpg" alt="" class="shop-their-looks-img">
	                                    <p>N Pearl Affair</p>
									</a>
                                </div> -->
								<div class="product-slider-wrapper shop-their-looks">
									<div class="product-slider" id="shop-their-looks-carousel">
										<div>
											<a href="<?= base_url(); ?>product/detail">
												<img src="<?= base_url(); ?>assets/images/main/jewelerry-1.jpg" alt="" class="img-responsive">
												<p>Bo Artemis Rain</p>
											</a>
										</div>
										<div>
											<a href="<?= base_url(); ?>product/detail">
												<img src="<?= base_url(); ?>assets/images/main/jewelerry-2.jpg" alt="" class="img-responsive">
												<p>Bo Bronxe Aphrodite</p>
											</a>
										</div>
										<div>
											<a href="<?= base_url(); ?>product/detail">
												<img src="<?= base_url(); ?>assets/images/main/jewelerry-3.jpg" alt="" class="img-responsive">
												<p>N Ivy Choker</p>
											</a>
										</div>
										<div>
											<a href="<?= base_url(); ?>product/detail">
												<img src="<?= base_url(); ?>assets/images/main/jewelerry-1.jpg" alt="" class="img-responsive">
												<p>Bo Artemis Rain</p>
											</a>
										</div>
										<div>
											<a href="<?= base_url(); ?>product/detail">
												<img src="<?= base_url(); ?>assets/images/main/jewelerry-2.jpg" alt="" class="img-responsive">
												<p>Bo Bronxe Aphrodite</p>
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
    </div>

    <? $this->load->view('footer'); ?>
</body>

<!--[if (lt IE 9)]><script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.helper.ie8.js"></script><![endif]-->
<script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.js"></script>

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
            .from("section#small-header .header-content h2", 0.3, {y: 30, autoAlpha: 0},'-=0.1')

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
    timeline.from(".section-description p", 0.3, {y: 30, autoAlpha:0})
    timeline.from("section#general-section #filter-text", 0.3, {y: 30, autoAlpha:0}, '-=0.2')
    timeline.from("section#general-section .journal-media-line", 0.3, {y: 30, autoAlpha:0}, '-=0.2')
    timeline.staggerFrom("ul.journal-media-filter li", 0.3, {y: 30, autoAlpha:0},0.1, '-=0.2')
    timeline.staggerFrom(".journal-media-thumbnail", 0.3, {y: 30, autoAlpha:0}, 0.15, '-=0.2')


    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
    });

    var shopTheirLooksSlider;
    var journalMediaSlider;

    function getMediaDetail(mediaId) {
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
                    $('#media-title').html(data.media.name);
                    $('#media-subtitle').html(data.media.subtitle);
                    $('#media-description').html(data.media.description);

                    var sliderImage = '';
                    var productList = '';

                    $('.journal-media-slider').empty();
                    $('#shop-their-looks-carousel').empty();

                    $.each(data.arr_slider_image, function(key, slider) {
                        sliderImage += '<div><div class="journal-media-modal-img"><div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/'+ slider.image_name +')"><div class="black-gradient-overlay"></div></div></div></div>';
                    });

                    $.each(data.arr_product, function(key, product) {
                        productList += '<div><a href="<?= base_url(); ?>product/detail/'+ product.url_name +'/"><img src="<?= $setting->setting__system_admin_url; ?>images/website/'+ product.image_name +'" alt="" class="img-responsive"><p>'+ product.name +'</p></a></div>';
                    });

                    $('.journal-media-slider').append(sliderImage);
                    $('#shop-their-looks-carousel').append(productList);

                    $('#journal-media-modal').modal('show');
                    initSlider();

                    $('#journal-media-modal').on('hidden.bs.modal', function () {
                        shopTheirLooksSlider.destroy();
                        journalMediaSlider.destroy();
                    });
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>journal/ajax_get_media/'+ mediaId +'/',
        });
    }

    function generateSlider() {
        $('#journal-media-modal').on('show.bs.modal', function (e) {
            initSlider();
        })

        $('#journal-media-modal').on('hidden.bs.modal', function () {
            shopTheirLooksSlider.destroy();
            journalMediaSlider.destroy();
        });
    }

    function initSlider() {
        shopTheirLooksSlider = tns({
            container: '#shop-their-looks-carousel',
            autoplay: false,
            items: 2,
            mouseDrag: true,
            swipeAngle: false,
            arrowKeys: true,
            autoplay: false,
            loop: true,
            nav: false,
            controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
        });

        journalMediaSlider = tns({
            container: '.journal-media-slider',
            items: 1,
            mouseDrag: true,
            swipeAngle: false,
            arrowKeys: true,
            autoplay: false,
            loop: true,
            controls: false,
            nav: true,
            controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "]
        });
    }
</script>

</html>
