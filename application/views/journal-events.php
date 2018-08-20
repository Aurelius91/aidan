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
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/header.jpg)">
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
            <div class="row">
                <? foreach ($arr_events as $key => $events): ?>
                    <? if ($key > 1): ?>
                        <? break; ?>
                    <? endif; ?>

                    <div class="col-xs-12 <? if ($key <= 0): ?>col-sm-7<? else: ?>col-sm-5<? endif; ?> journal-events-thumbnail-wrapper-special">
                        <div class="journal-events-thumbnail-special" onclick="getEventsDetail('<?= $events->id; ?>');">
                            <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $events->image_name; ?>);"></div>
                        </div>
                        <div class="journal-events-thumbnail-description">
                            <p class="journal-events-thumbnail-date"><?= $events->date_display; ?></p>
                            <h4 class="journal-events-thumbnail-title"><?= $events->name; ?></h4>
                            <p><?= $events->subtitle; ?></p>
                            <button class="btn btn-custom" onclick="getEventsDetail('<?= $events->id; ?>');">READ MORE</button>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="row">
                <? foreach ($arr_events as $key => $events): ?>
                    <? if ($key <= 1): ?>
                        <? continue; ?>
                    <? endif; ?>

                    <div class="col-xs-12 col-sm-6 journal-events-thumbnail-wrapper">
                        <div class="journal-events-thumbnail-normal" onclick="getEventsDetail('<?= $events->id; ?>');">
                            <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $events->image_name; ?>)"></div>
                        </div>
                        <div class="journal-events-thumbnail-description">
                            <p class="journal-events-thumbnail-date"><?= $events->date_display; ?></p>
                            <h4 class="journal-events-thumbnail-title"><?= $events->name; ?></h4>
                            <p><?= $events->subtitle; ?></p>
                            <button class="btn btn-custom" onclick="getEventsDetail('<?= $events->id; ?>');">READ MORE</button>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="journal-events-modal" class="modal modal-custom media event fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn btn-close" data-dismiss="modal">
                        <div class="close-icon"></div>
                    </button>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="responsive-gallery-outer">
                                <ul class="responsiveGallery-wrapper">
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-1.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-2.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-3.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-4.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-5.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-6.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-1.jpg);"></div>
                                        </div>
                                    </li>
                                    <li class="responsiveGallery-item">
                                        <div class="gambar">
                                            <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/journal/events/events-1.jpg);"></div>
                                        </div>
                                    </li>
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
                            <div class="journal-events-thumbnail-description modal-desc">
                                <p class="journal-events-thumbnail-date">01 November 2017  |  by Aisyah Sutin</p>
                                <h4 class="journal-events-thumbnail-title">Meet founder of aidan and ice</h4>
                                <div id="events-description">
                                    <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.</p>
                                    <p>Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>
                                    <p>Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.</p>
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
    timeline.staggerFrom(".journal-events-thumbnail-wrapper-special", 0.3, {y: 30, autoAlpha: 0},0.15)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // general section
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.journal-events-thumbnail-wrapper'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.staggerFrom(".journal-events-thumbnail-wrapper", 0.3, {y: 30, autoAlpha: 0},0.15)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script src="<?= base_url(); ?>assets/plugin/responsive-gallery/jquery.responsiveGallery.js"></script>
<script type="text/javascript">
    $(function() {
        generateSlider();
    });

    function generateSlider() {
        $('#journal-events-modal').on('shown.bs.modal', function () {
            $('.responsiveGallery-wrapper').responsiveGallery({
                animatDuration: 400,
                $btn_prev: $('.responsive-gallery-outer .navigation-wrapper button.prev'),
                $btn_next: $('.responsive-gallery-outer .navigation-wrapper button.next')
            });
        });

        $('#journal-events-modal').on('hidden.bs.modal', function () {
            $('.responsive-gallery-outer').empty();
        });
    }

    function getEventsDetail(eventsId) {
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
                    $('.journal-events-thumbnail-date').html(data.events.date_display);
                    $('.journal-events-thumbnail-title').html(data.events.name);
                    $('#events-description').html(data.events.description);

                    $('.responsive-gallery-outer').empty();
                    var sliderImage = '<ul class="responsiveGallery-wrapper">';

                    $.each(data.arr_slider_image, function(key, slider) {
                        sliderImage += '<li class="responsiveGallery-item"><div class="gambar"><div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/'+ slider.image_name +');"></div></div></li>';
                    });

                    sliderImage += '</ul><div class="navigation-wrapper"><button class="prev"><img src="<?= base_url(); ?>assets/images/main/arrow-left.png" alt=""></button><button class="next"><img src="<?= base_url(); ?>assets/images/main/arrow-right.png" alt=""></button></div>';

                    $('.responsive-gallery-outer').append(sliderImage);
                    $('#journal-events-modal').modal('show');

                    $('.responsiveGallery-wrapper').responsiveGallery({
                        animatDuration: 400,
                        $btn_prev: $('.responsive-gallery-outer .navigation-wrapper button.prev'),
                        $btn_next: $('.responsive-gallery-outer .navigation-wrapper button.next')
                    });
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>journal/ajax_get_events/'+ eventsId +'/',
        });
    }
</script>


</html>
