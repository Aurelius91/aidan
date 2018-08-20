<script src="<?= base_url(); ?>assets/plugin/gsap/TweenMax.min.js"></script>
<script src="<?= base_url(); ?>assets/plugin/scrollmagic/ScrollMagic.min.js"></script>
<script src="<?= base_url(); ?>assets/plugin/scrollmagic/animation.gsap.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/plugin/scrollmagic/debug.addIndicators.js"></script> -->

<script>
    // init controller
    var controller = new ScrollMagic.Controller({
        globalSceneOptions: { // options for every scene
            triggerHook: 0.4,
            reverse: false
        }
    });
</script>

<script>
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#footer',
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.staggerFrom("section#footer .footer-inner .row > div", 0.3, {y: 30, autoAlpha: 0},0.1)

    scene.setTween(timeline)
	.addTo(controller)
    .triggerHook(0.9);
</script>
