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
                        Our Stockist
                    </h2>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-12 stockist-big-wrapper">
					<h3 class="stockist-country"><?= $arr_stockist[0]->country; ?>, </h3><h4 class="stockist-city"><?= $arr_stockist[0]->city; ?></h4>
					<div class="stockist-big-wrapper">
						<div class="stockist-big">
							<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/stockist/stockist-big.jpg)"></div>
						</div>
						<div class="stockist-big-information">
							<div class="row">
								<div class="col-xs-12">
									<h3 class="stockist-location"><?= $arr_stockist[0]->name; ?></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<hr class="stockist-big-information-line">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-4">
									<div class="store-information-grid">
										<h4>STORE HOURS:</h4>
										<img src="<?= base_url(); ?>assets/images/main/home-white-stockist.png" alt="Store Hours" class="store-hours-img hidden-xs">
										<p class="store-hours-text"><?= $arr_stockist[0]->hours; ?></p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3">
									<div class="store-information-grid">
										<h4>STORE PHONES:</h4>
										<img src="<?= base_url(); ?>assets/images/main/phone-white-stockist.png" alt="Store Phone" class="store-phone-img hidden-xs">
										<p class="store-phone-text"><?= $arr_stockist[0]->phone; ?></p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-5">
									<div class="store-information-grid">
										<h4>STORE ADDRESS:</h4>
										<img src="<?= base_url(); ?>assets/images/main/location-white-stockist.png" alt="Store Location" class="store-location-img hidden-xs">
										<p class="store-location-text"><?= $arr_stockist[0]->address; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
                <? foreach ($arr_stockist as $key => $stockist): ?>
	                <div class="col-xs-12 col-sm-2">
	                    <div class="stockist-grid <? if ($key <= 0): ?>active<? endif; ?>" data-store-title="<?= $stockist->name; ?>" data-store-city="<?= $stockist->city; ?>" data-store-country="<?= $stockist->country; ?>" data-store-hours="<?= $stockist->hours; ?>" data-store-address="<?= $stockist->address; ?>" data-store-phone="<?= $stockist->phone; ?>" data-store-image="<?= $setting->setting__system_admin_url; ?>images/website/<?= $stockist->image_name; ?>">
							<div class="stockist-image">
								<div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $stockist->image_name; ?>)"></div>
							</div>
	                        <h3 class="stockist-country"><?= $stockist->country; ?>, </h3><h4 class="stockist-city"><?= $stockist->city; ?></h4>
	                    </div>
	                </div>
	            <? endforeach; ?>
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
			.from(".stockist-big-wrapper", 0.3, {y: 30, autoAlpha: 0})
            .staggerFrom(".stockist-grid", 0.3, {y: 30, autoAlpha: 0},0.1)

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script type="text/javascript">
	var stockistGrids = document.querySelectorAll('.stockist-grid');

	stockistGrids.forEach(function(stockistGrid)  {
		stockistGrid.addEventListener('click', function() {

			//loop to remove active class
			stockistGrids.forEach(function(stockistGrid)  {
				stockistGrid.classList.remove('active');
			});

			//add active class to current
			this.classList.add('active');
			var storeTitle = this.getAttribute('data-store-title');
			var storeCountry = this.getAttribute('data-store-country');
			var storeCity = this.getAttribute('data-store-city');
			var storeHour = this.getAttribute('data-store-hours');
			var storePhoneNumber = this.getAttribute('data-store-phone');
			var storeAddress = this.getAttribute('data-store-address');
			var storeImage = this.getAttribute('data-store-image');

			document.querySelector('h3.stockist-location').textContent = storeTitle;
			document.querySelector('.stockist-big-wrapper .stockist-country').textContent = storeCountry + ', ';
			document.querySelector('.stockist-big-wrapper .stockist-city').textContent = storeCity;
			document.querySelector('p.store-hours-text').textContent = storeHour;
			document.querySelector('p.store-phone-text').textContent = storePhoneNumber;
			document.querySelector('p.store-location-text').textContent = storeAddress;
			document.querySelector('.stockist-big .content-inside').style.backgroundImage = 'url('+ storeImage +')';
		});
	})
</script>

<? $this->load->view('js'); ?>

</html>
