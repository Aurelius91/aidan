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
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/about-us/header.jpg)">
                <div class="header-bg-overlay"></div>
            </div>
        <? else: ?>
            <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[0]->image_name; ?>)">
                <div class="header-bg-overlay"></div>
            </div>
        <? endif; ?>
    </section>

    <section id="general-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="about-us-container">
                        <div class="about-us-title">
                            <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                                <h2 class="section-title"><?= $arr_section[0]->title; ?></h2>
                            <? else: ?>
                                <h2 class="section-title"><?= $arr_section[0]->title_lang; ?></h2>
                            <? endif; ?>
                        </div>
                        <div class="about-us-center">
                            <img src="<?= base_url(); ?>assets/images/about-us/quote.jpg" alt="" class="img-responsive hidden-xs">
                            <img src="<?= base_url(); ?>assets/images/about-us/quote-mobile.jpg" alt="" class="img-responsive visible-xs">

                            <? if ($lang == $setting->setting__system_language || $arr_section[0]->description_lang == ''): ?>
                                <?= $arr_section[0]->description; ?>
                            <? else: ?>
                                <?= $arr_section[0]->description_lang; ?>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    timeline.from(".about-us-title h2", 0.3, {y: 30, autoAlpha: 0})
            .from(".about-us-center img", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .staggerFrom(".about-us-center p", 0.3, {y: 30, autoAlpha: 0},0.1,'-=0.1')

    scene.setTween(timeline)
    .addTo(controller);
</script>

<? $this->load->view('js'); ?>


</html>
