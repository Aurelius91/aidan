<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="general-section" class="bigger-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                        <h2 class="section-title text-only"><?= $arr_section[0]->title; ?></h2>
                    <? else: ?>
                        <h2 class="section-title text-only"><?= $arr_section[0]->title_lang; ?></h2>
                    <? endif; ?>
                </div>
            </div>
            <div class="row privacy-policy-point">
                <div class="col-xs-12">
                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->description_lang == ''): ?>
                        <?= $arr_section[0]->description; ?>
                    <? else: ?>
                        <?= $arr_section[0]->description_lang; ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </section>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('scrollmagic'); ?>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#general-section h2", 0.3, {y: 30, autoAlpha: 0})
            .staggerFrom(".privacy-policy-point", 0.3, {y: 30, autoAlpha: 0},0.1)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>


</html>
