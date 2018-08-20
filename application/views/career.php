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
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/career/header.jpg)">
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
                <div class="col-xs-12 text-center">
                    <div class="section-description">
                        <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                            <h3><?= $arr_section[0]->title; ?></h3>
                        <? else: ?>
                            <h3><?= $arr_section[0]->title_lang; ?></h3>
                        <? endif; ?>

                        <? if ($lang == $setting->setting__system_language || $arr_section[0]->description_lang == ''): ?>
                            <?= $arr_section[0]->description; ?>
                        <? else: ?>
                            <?= $arr_section[0]->description_lang; ?>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <? foreach ($arr_career as $career): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <hr class="career-line">
                    </div>
                </div>
                <div class="row">
                    <div class="career-wrapper">
                        <div class="col-xs-12 col-sm-3">
                            <h3><?= $career->name; ?></h3>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <p class="job-description">Job Description:</p>
                                    <?= $career->description; ?>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <p class="job-qualification">Qualification:</p>
                                    <?= $career->qualification; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="<?= base_url(); ?>career/detail/<?= $career->url_name; ?>/"><button class="btn btn-custom">READ MORE</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
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
    // career list
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#general-section h3", 0.3, {y: 30, autoAlpha:0})
            .from("section#general-section p", 0.3, {y: 30, autoAlpha:0},'-=0.1')
            .staggerFrom('.career-line',0.3, {y: 30, autoAlpha:0},0.2)
            .staggerFrom('.career-wrapper',0.3, {y: 30, autoAlpha:0},0.2,'-=0.2')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>


</html>
