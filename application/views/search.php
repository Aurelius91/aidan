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
                    <h2 class="section-title text-only">
                        Product Result
                    </h2>
                </div>
            </div>
            <div class="row">
				<div class="col-xs-12">
					<div class="search-result product">
						<div class="row">
							<? foreach ($arr_result['product'] as $key => $product): ?>
	                            <div class="col-xs-6 col-sm-4">
	                                <div class="product-grid">
	                                    <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
	                                        <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="product-grid-image">
	                                    </a>
	                                    <p><?= $product->name; ?></p>
	                                    <div class="product-hover">
	                                        <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
	                                            <? if ($product->image_hover_name == ''): ?>
	                                                <div class="product-hover-image" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>)"></div>
	                                            <? else: ?>
	                                                <div class="product-hover-image" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_hover_name; ?>)"></div>
	                                            <? endif; ?>
	                                        </a>
	                                        <p class="product-hover-name"><?= $product->name; ?></p>

	                                        <? if ($product->price_discount > 0): ?>
	                                            <p class="product-hover-price">
													<span class="normal-price-slash">
														<span class="normal-price-color">
															<?= $product->price_display; ?>,-
														</span>
													</span>
													<span><?= $product->price_discount_display; ?></span>
												</p>
	                                        <? else: ?>
	                                            <p class="product-hover-price"><?= $product->price_display; ?>,-</p>
	                                        <? endif; ?>

											<button class="btn btn-add-to-wishlist">
												<svg class="heart" viewBox="0 0 32 32">
													<path id="heart-icon" d="M16,28.261c0,0-14-7.926-14-17.046c0-9.356,13.159-10.399,14-0.454c1.011-9.938,14-8.903,14,0.454 C30,20.335,16,28.261,16,28.261z"/>
												</svg>
											</button>
	                                        <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
	                                            <button class="btn btn-custom dark">QUICKSHOP</button>
	                                        </a>
	                                    </div>
	                                </div>
	                            </div>

	                            <? if (($key + 1) % 2 <= 0): ?>
	                            	<div class="clearfix visible-xs-block"></div>
	                            <? endif; ?>

	                            <? if (($key + 1) % 3 <= 0): ?>
	                            	<div class="clearfix visible-sm-block visible-md-block visible-lg-block"></div>
	                            <? endif; ?>
	                        <? endforeach; ?>
						</div>
					</div>
				</div>
            </div>
			<div class="row">
                <div class="col-xs-12">
                    <h2 class="section-title text-only">
                        Search Result
                    </h2>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-12">
					<div class="search-result">
						<div class="row">
							<div class="col-xs-12">
								<? foreach ($arr_result['other']['muse'] as $muse): ?>
									<a href="<?= base_url(); ?>journal/muse_detail/<?= $muse->url_name; ?>/">
										<div class="search-point">
											<h4><?= $muse->name; ?></h4>
											<p><?= $muse->short_description; ?></p>
										</div>
									</a>
								<? endforeach; ?>

								<? foreach ($arr_result['other']['events'] as $events): ?>
									<a href="<?= base_url(); ?>journal/events/">
										<div class="search-point">
											<h4><?= $events->name; ?></h4>
											<p><?= $events->subtitle; ?></p>
										</div>
									</a>
								<? endforeach; ?>

								<? foreach ($arr_result['other']['media'] as $media): ?>
									<a href="<?= base_url(); ?>journal/media/">
										<div class="search-point">
											<h4><?= $media->name; ?></h4>
											<p><?= $media->subtitle; ?></p>
										</div>
									</a>
								<? endforeach; ?>
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
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#general-section h2", 0.3, {y: 30, autoAlpha: 0})
            .staggerFrom(".shipping-exchange-point", 0.3, {y: 30, autoAlpha: 0},0.1)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>


</html>
