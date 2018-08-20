<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body data-spy="scroll" data-target="#asd">
    <? $this->load->view('navigation'); ?>

    <section id="general-section" class="bigger-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="section-title text-only">
                        Terms & Conditions
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3">
					<nav id="asd">
						<ol class="nav terms-and-conditions-nav" >
							<? foreach ($arr_section as $section): ?>
								<li><a href="#section-tnc-<?= $section->id; ?>"><?= $section->title; ?></a></li>
							<? endforeach; ?>
						</ol>
					</nav>
                </div>
                <div class="col-xs-12 col-sm-9">
                	<? foreach ($arr_section as $section): ?>
	                    <div class="row terms-and-conditions-point">
	                        <div class="col-xs-12">
	                        	<? if ($lang == $setting->setting__system_language || $section->title_lang == ''): ?>
	                            	<h5 class="subtitle" id="section-tnc-<?= $section->id; ?>"><?= $section->title; ?></h5>
	                            <? else: ?>
	                            	<h5 class="subtitle" id="section-tnc-<?= $section->id; ?>"><?= $section->title_lang; ?></h5>
	                            <? endif; ?>

	                            <div class="subpoint">
									<? if ($lang == $setting->setting__system_language || $section->description_lang == ''): ?>
		                            	<h5 class="subtitle" id="section-tnc-<?= $section->id; ?>"><?= $section->description; ?></h5>
		                            <? else: ?>
		                            	<h5 class="subtitle" id="section-tnc-<?= $section->id; ?>"><?= $section->description_lang; ?></h5>
		                            <? endif; ?>
								</div>
	                        </div>
	                    </div>
	                <? endforeach; ?>
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
            .staggerFrom("ol.terms-and-conditions-nav > li", 0.3, {y: 30, autoAlpha: 0},0.1)
            .staggerFrom(".terms-and-conditions-point", 0.3, {y: 30, autoAlpha: 0},0.1,'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
	var offsetTop = $('ol.terms-and-conditions-nav').offset().top;

	$( document ).ready(function() {
		if ($(window).width() > 767) {
			$('ol.terms-and-conditions-nav').affix({
				offset: {
					top: offsetTop,
				}
			})
		}
	});

	$("ol.terms-and-conditions-nav li a[href^='#']").on('click', function(e) {
	    e.preventDefault();

		// var hash = this.hash;
	    // $('html, body').animate({
	    //    scrollTop: $(hash).offset().top
	    // }, 1000, function(){
	    // 	window.location.hash = hash;
	    // });

	    var hash = this.hash;
		if( $(window).width() > 767) {
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 1000, function(){
				window.location.hash = hash;
			});
		}
		else {
			$('html, body').animate({
				scrollTop: $(hash).offset().top - 70
			});
		}
	});
</script>


</html>
