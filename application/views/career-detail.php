<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $career->image_name; ?>)">
            <div class="header-bg-overlay"></div>
        </div>
    </section>

    <section id="general-section">
        <div class="container-fluid">
            <div class="row">
                <div class="career-wrapper detail">
                    <div class="career-detail-left">
                        <h3><?= $career->name; ?></h3>
                        <p class="job-description">Job Description:</p>
                        <div class="job-description-list">
                            <?= $career->description; ?>
                        </div>

                        <p class="job-qualification">Qualification:</p>
                        <div class="job-qualification-list">
                            <?= $career->qualification; ?>
                        </div>
                    </div>
                    <div class="career-detail-right">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="career-detail-right-inner">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p>If you have what it takes to be a part of our tea, please our fill out the form below:</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group form-group-custom">
                                                <label for="first-name">First Name</label>
                                                <input type="text" class="form-control input-custom" id="first-name" placeholder="First Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group form-group-custom">
                                                <label for="email">Email Address</label>
                                                <input type="text" class="form-control input-custom" id="email" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group form-group-custom">
                                                <label for="phone-number">Phone Number</label>
                                                <input type="text" class="form-control input-custom" id="phone-number" placeholder="Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group form-group-custom">
                                                <label for="cv">Upload CV</label>
                                                <input id="sv" type="file" class="form-control input-custom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <button class="btn btn-custom">BACK</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <button class="btn btn-custom dark">SEND</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    // career list
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from(".career-detail-left h3", 0.3, {y: 30, autoAlpha:0})
            .from(".career-detail-left p.job-description", 0.3, {y: 30, autoAlpha:0},'-=0.1')
            .from(".career-detail-left div.job-description-list", 0.3, {y: 30, autoAlpha:0},'-=0.2')
            .from(".career-detail-left p.job-qualification", 0.3, {y: 30, autoAlpha:0},'-=0.1')
            .from(".career-detail-left div.job-qualification-list", 0.3, {y: 30, autoAlpha:0},'-=0.2')
            .from(".career-detail-right p", 0.3, {y: 30, autoAlpha:0},'-=0.1')
            .staggerFrom(".career-detail-right .form-group-custom", 0.3, {y: 30, autoAlpha:0},0.1,'-=0.1')
            .from(".career-detail-right button.btn-custom", 0.3, {y: 30, autoAlpha:0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>


</html>
