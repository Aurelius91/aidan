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
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/journal/muse/header.jpg)">
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
            <? if (count($arr_muse) > 0): ?>
                <div class="row row-eq-height-tablet">
                    <div class="col-xs-12 col-sm-6">
                        <div class="muse-of-the-month-thumbnail">
                            <a href="<?= base_url(); ?>journal/muse_detail/<?= $arr_muse[0]->url_name; ?>/">
                                <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_muse[0]->image_name; ?>)"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 column-relative">
                        <div class="muse-of-the-month-filter">
                            <ul class="muse-of-the-month-list">
                                <li <? if ($this_year == ''): ?>class="active"<? endif; ?>><a href="<?= base_url(); ?>journal/muse/">All</a></li>

                                <? foreach ($arr_year as $year): ?>
                                    <li <? if ($year == $this_year): ?>class="active"<? endif; ?>><a href="<?= base_url(); ?>journal/muse/<?= $year; ?>/"><?= $year; ?></a></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                        <div class="muse-of-the-month-description">
                            <h2><?= $arr_muse[0]->name; ?></h2>
                            <p class="subtitle"><?= $arr_muse[0]->subtitle; ?></p>
                            <p><?= $arr_muse[0]->short_description; ?></p>
                            <a href="<?= base_url(); ?>journal/muse_detail/<?= $arr_muse[0]->url_name; ?>">
                                <button class="btn btn-custom">Read More</button>
                            </a>
                        </div>
                    </div>
                </div>
            <? endif; ?>
            <div class="journal-muse-grid">
                <div class="row">
                    <? unset($arr_muse[0]); ?>
                    <? foreach ($arr_muse as $key => $muse): ?>
                        <? if ($key <= 0): ?>
                            <? continue; ?>
                        <? endif; ?>

                        <div class="col-xs-6 col-sm-4">
                            <div class="journal-muse-thumbnail-wrapper">
                                <div class="journal-muse-thumbnail">
                                    <a href="<?= base_url(); ?>journal/muse_detail/<?= $muse->url_name; ?>/">
                                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $muse->image_name; ?>)"></div>
                                    </a>
                                </div>
                                <h4><?= $muse->name; ?></h4>
                                <a href="<?= base_url(); ?>journal/muse_detail/<?= $muse->url_name; ?>/">
                                    <button class="btn btn-custom">Read More</button>
                                </a>
                            </div>
                        </div>

                        <? if (($key) % 2 == 0): ?>
                            <div class="clearfix visible-xs-block"></div>
                        <? endif; ?>

                        <? if (($key) % 3 == 0): ?>
                            <div class="clearfix visible-sm-block visible-md-block visible-lg-block"></div>
                        <? endif; ?>
                    <? endforeach; ?>
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
            .from("section#small-header .header-content h2", 0.3, {y: 30, autoAlpha: 0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // muse of the month
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".muse-of-the-month-thumbnail", 0.3, {y: 30, autoAlpha:0})
            .from(".muse-of-the-month-filter", 0.3, {y: 30, autoAlpha:0}, '-=0.1')
            .from(".muse-of-the-month-description h2", 0.3, {y: 30, autoAlpha:0}, '-=0.2')
            .from(".muse-of-the-month-description p", 0.3, {y: 30, autoAlpha:0}, '-=0.2')
            .from(".muse-of-the-month-description button.btn-custom", 0.3, {y: 30, autoAlpha:0}, '-=0.2')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // muse of the month
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '.journal-muse-grid'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.staggerFrom(".journal-muse-thumbnail-wrapper", 0.3, {y: 30, autoAlpha:0},0.15)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

</html>
