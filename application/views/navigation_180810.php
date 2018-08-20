<? if ($setting->setting__website_promo_text != ''): ?>
	<div class="promo-banner">
		<p class="hidden-xs"><?= $setting->setting__website_promo_text; ?></p>
		<marquee behavior="scroll" direction="left" class="visible-xs">
			<p><?= $setting->setting__website_promo_text; ?></p>
		</marquee>
	</div>
<? endif; ?>
<section id="navigation">
	<div class="navigation-inner">
		<div class="nav-logo">
			<div class="nav-logo-inner">
				<div class="nav-top-left">
					<ul class="hidden-xs">
						<? if ($setting->setting__website_enabled_dual_language > 0): ?>
						<li class="hidden-xs">
							<select class="form-control select-currency-language" id="select-language">
								<option value="<?= $setting->setting__system_language; ?>"><?= $setting->setting__system_language; ?></option>
								<option value="<?= $setting->setting__system_language2; ?>"><?= $setting->setting__system_language2; ?></option>
							</select>
						</li>
						<? endif; ?>
						<li class="hidden-xs">
							<select class="form-control select-currency-language" id="select-currency">
								<? foreach ($arr_currency as $currency): ?>
									<option value="<?= $currency->id; ?>"><?= $currency->name; ?></option>
								<? endforeach; ?>
							</select>
						</li>
					</ul>
					<button class="btn btn-menu">
						<span class="stripe"></span>
						<span class="stripe"></span>
						<span class="stripe"></span>
					</button>
				</div>
				<a href="<?= base_url(); ?>" class="center-logo visible-xs">
					<h1>AIDAN AND ICE <span style="font-size: 8px; letter-spacing: 1px; position: absolute; right: -30px; top: 8px;">BETA</span></h1>
				</a>
				<div class="nav-top-right visible-xs">
					<ul>
						<li class="visible-xs">
							<img src="<?= base_url(); ?>assets/images/main/cart.png" alt="Search" class="nav-top-left-icon" id="cart-icon" data-toggle="modal" data-target="#cart-modal">
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="nav-menu-bar">
			<a href="<?= base_url(); ?>" class="center-logo hidden-xs">
				<h1>AIDAN AND ICE <span style="font-size: 10px; letter-spacing: 1px; position: absolute; right: -30px; top: 5px;">BETA</span></h1>
			</a>
			<ul class="navbar-main-menu">
				<li><a href="<?= base_url(); ?>about-us">About Us</a></li><!--
			 --><li class="dropdown">
					<a class="dropdown-toggle" href="<?= base_url(); ?>collections">Collections
						<span class="caret"></span></a>
						<div class="dropdown-menu">
							<div class="dropdown-menu-navigation collection">
								<div class="submenu-list-wrapper">
									<h5>our collections</h5>
									<ul>
										<? foreach ($arr_navbar_menu['arr_navbar_collection'] as $navbar_collection): ?>
											<li><a href="<?= base_url(); ?>product/filter/1/newest/<?= $navbar_collection->id; ?>/0/0/0/0/"><?= $navbar_collection->name; ?></a></li>
										<? endforeach; ?>
									</ul>
							</div>
							<div class="thumbnail">
								<a href="<?= base_url(); ?>collections">
									<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/collection-1.jpg)">
										<div class="black-gradient-overlay">
											<h4>SEE ALL COLLECTION</h4>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li><!--
			 --><li class="dropdown">
					<a class="dropdown-toggle" href="<?= base_url(); ?>product">Shop
						<span class="caret"></span>
					</a>
					<div class="dropdown-menu">
						<div class="dropdown-menu-navigation product">
							<div class="submenu-list-wrapper">
								<h5>The Alter Ego</h5>
								<ul>
									<? foreach ($arr_navbar_menu['arr_navbar_alterego'] as $navbar_alterego): ?>
										<li><a href="<?= base_url(); ?>product/filter/1/newest/0/0/0/<?= $navbar_alterego->id; ?>-/0/"><?= $navbar_alterego->name; ?></a></li>
									<? endforeach; ?>
								</ul>
							</div>
							<div class="submenu-list-wrapper">
								<h5>Categories</h5>
								<ul>
									<? foreach ($arr_navbar_menu['arr_navbar_category'] as $navbar_category): ?>
										<? if ($navbar_category->type == 'looks'): ?>
											<? continue; ?>
										<? endif; ?>

										<li><a href="<?= base_url(); ?>product/filter/1/newest/0/<?= $navbar_category->id; ?>-/0/0/0/"><?= $navbar_category->name; ?></a></li>
									<? endforeach; ?>
								</ul>
							</div>
							<div class="submenu-list-wrapper">
								<h5>Looks</h5>
								<ul>
									<? foreach ($arr_navbar_menu['arr_navbar_category'] as $navbar_category): ?>
										<? if ($navbar_category->type != 'looks'): ?>
											<? continue; ?>
										<? endif; ?>
									<li><a href="<?= base_url(); ?>product/filter/1/newest/0/0/<?= $navbar_category->id; ?>-/0/0/"><?= $navbar_category->name; ?></a></li>
									<? endforeach; ?>
								</ul>
							</div>
							<div class="submenu-list-wrapper">
								<h5>Gift Cards</h5>
								<ul>
									<li><a href="<?= base_url(); ?>giftcard">Printed Gift Cards</a></li>
									<li><a href="<?= base_url(); ?>giftcard">Virtual Gift Cards</a></li>
								</ul>
							</div>
							<div class="thumbnail">
								<a href="<?= base_url(); ?>product">
									<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/shop-1.jpg)">
										<div class="black-gradient-overlay">
											<h4>Pearl nation collections</h4>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li><!--
			 --><li class="dropdown">
			 		<a class="dropdown-toggle" href="<?= base_url(); ?>journal">Journal
						<span class="caret"></span>
					</a>
					<div class="dropdown-menu">
						<div class="dropdown-menu-navigation collection">
							<div class="journal-thumbnail-wrapper">
								<a href="<?= base_url(); ?>journal/muse">
									<div class="thumbnail journal">
										<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-1.jpg)">
											<div class="black-gradient-overlay">
												<h4>MUSE</h4>
											</div>
										</div>
									</div>
								</a>
							</div><!--
							--><div class="journal-thumbnail-wrapper">
								<a href="<?= base_url(); ?>journal/media">
									<div class="thumbnail journal">
										<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-2.jpg)">
											<div class="black-gradient-overlay">
												<h4>MEDIA</h4>
											</div>
										</div>
									</div>
								</a>
							</div><!--
							--><div class="journal-thumbnail-wrapper">
								<a href="<?= base_url(); ?>journal/events">
									<div class="thumbnail journal">
										<div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-3.jpg)">
											<div class="black-gradient-overlay">
												<h4>EVENTS</h4>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li>
			</ul>

			<div class="nav-top-right hidden-xs">
				<ul>
					<!-- <li class="hidden-xs">
						<button class="btn-search" id="btn-open-search-desktop">
							<img src="<?= base_url(); ?>assets/images/main/search.png" alt="Search" class="search-icon">
						</button>
					</li> -->
					<? if ($customer): ?>
						<li class="hidden-xs">
							<div class="dropdown">
								<button class="btn btn-custom-dropdown dropdown-toggle" type="button" data-toggle="dropdown">
									<img src="<?= base_url(); ?>assets/images/main/user.png" alt="Search" class="nav-top-left-icon">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="<?= base_url(); ?>account/">My Profile</a></li>
									<li><a href="<?= base_url(); ?>account/address/">Address</a></li>
									<li><a href="<?= base_url(); ?>account/order-status/">Status Order</a></li>
									<li><a href="<?= base_url(); ?>account/wishlist">My Wishlist</a></li>
									<li><a href="<?= base_url(); ?>account/giftcard">My Gift Cards</a></li>
									<li><a href="<?= base_url(); ?>logout/">Log Out</a></li>
								</ul>
							</div>
						</li>
					<? else: ?>
						<li class="hidden-xs "><img src="<?= base_url(); ?>assets/images/main/user.png" alt="Search" class="nav-top-left-icon" data-toggle="modal" data-target="#sign-in-modal"></li>
					<? endif; ?>

					<li id="navbar-dropdown-cart" class="dropdown cart-dropdown">
						<img src="<?= base_url(); ?>assets/images/main/cart.png" alt="Search" class="nav-top-left-icon" id="cart-icon" data-toggle="dropdown">
						<div class="cart-backdrop"></div>
						<div class="dropdown-menu cart-wrapper">
							<h5>recently added item</h5>
							<div>
								<hr>
								<div id="navbar-cart-list">
									<div class="row">
									<? if ($last_cart != null): ?>
										<div class="col-xs-8 v-center cart-item-left">
											<div class="cart-item-thumbnail">
												<? if ($last_cart->product_id > 0): ?>
												<div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $last_cart->image_name; ?>)"></div>
												<? else: ?>
												<div class="content-inside" style="background-image:url(<?= $last_cart->image_name; ?>)"></div>
												<? endif; ?>
											</div><!--
									--><div class="cart-item-description">
											<h5 class="cart-item-name"><?= $last_cart->name; ?></h5>
											<div class="cart-item-quantity">Qty: <?= $last_cart->quantity; ?></div>
											<div class="cart-item-quantity">Price: <?= $last_cart->price_display; ?></div>
										</div>
									</div><!--
								 --><div class="col-xs-4 v-center">
										<h5 class="cart-price"><?= $last_cart->total_display; ?>,-</h5>
									</div>
									<? else: ?>
										<div class="col-xs-12">
											<div>Empty Cart</div>
										</div>
									<? endif; ?>
									</div>
								</div>
								<hr>
								<div class="text-right">
									<a href="<?= base_url(); ?>cart">
										<button class="btn btn-custom dark small">PROCEED TO CHECKOUT</button>
									</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<div class="search-overlay">
	<button class="btn-close">
		<div class="close-icon"></div>
	</button>
	<div class="input-wrapper">
		<input type="text" class="form-control" placeholder="Search for...">
		<div class="search-button-wrapper">
			<button class="btn btn-custom dark" id="btn-search-desktop" type="button">Search</button>
		</div>
    </div>
</div>

	<script type="text/javascript">
        var supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;
        var toggle = document.querySelectorAll('ul.navbar-main-menu .dropdown');
        var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var navbar = document.querySelector('#navigation');
        var dropdownMenu = document.querySelectorAll('ul.navbar-main-menu .dropdown-menu');

        if(width > 768) {
            for(var i = 0; i<toggle.length; i++) {
                toggle[i].addEventListener('mouseover', slideToggle);
                toggle[i].addEventListener('mouseout',makeMouseOutFn(toggle[i]),true);
            }
        } else {
            for(var i = 0; i<toggle.length; i++) {
                toggle[i].addEventListener('click', slideToggle);
            }

            document.addEventListener('click', function(event) {
                var found = 0;

                for(var i = 0; i<dropdownMenu.length; i++) {
                    if (!dropdownMenu[i].contains(event.target) && !navbar.contains(event.target)) {
                        found += 1;
                    }
                }

                if (found > 0) {
                    for(var i = 0; i<dropdownMenu.length; i++) {
                        dropdownMenu[i].style.height = "0px";
                    }
                }
            })
        }

        function slideToggle() {
            var EL = this.querySelector('.dropdown-menu'),
                ch = EL.clientHeight,
                sh = EL.scrollHeight,
                isCollapsed = !ch,
                noHeightSet = !EL.style.height;

            for(var i = 0; i<dropdownMenu.length; i++) {
                dropdownMenu[i].style.height = "0px";
            }
            if(supportsTouch == undefined) {
                EL.style.height = sh+"px";
            }
            else {
                if(isCollapsed || noHeightSet) {
                    EL.style.height = sh+"px";
                }
            }
        }

        function makeMouseOutFn(elem){
            var list = traverseChildren(elem);
            return function onMouseOut(event) {
                var e = event.toElement || event.relatedTarget;
                if (!!~list.indexOf(e)) {
                    return;
                }

                var EL = this.querySelector('.dropdown-menu');
                EL.style.height = "0px";
            };
        }

        //quick and dirty BFS children traversal, Im sure you could find a better one
        function traverseChildren(elem){
            var children = [];
            var q = [];
            q.push(elem);
            while (q.length>0)
            {
                var elem = q.pop();
                children.push(elem);
                pushAll(elem.children);
            }

            function pushAll(elemArray){
                for(var i=0;i<elemArray.length;i++)
                {
                    q.push(elemArray[i]);
                }
            }
            return children;
        }

		// search Function
		var openSearchButtonDesktop = document.querySelector('#btn-open-search-desktop');
		var searchOverlay			= document.querySelector('.search-overlay');
		var closeSearch				= searchOverlay.querySelector('button.btn-close');
		var btnSearchDesktop		= searchOverlay.querySelector('button#btn-search-desktop');
		var btnSearchMobile			= searchOverlay.querySelector('button#btn-search-mobile');

		openSearchButtonDesktop.addEventListener('click', function() {
			searchOverlay.classList.add('active');
		});

		closeSearch.addEventListener('click', function() {
			searchOverlay.classList.remove('active');
		});

		btnSearchDesktop.addEventListener('click', function() {
			// search function
		});

		btnSearchMobile.addEventListener('click', function() {
			// search function
		});
    </script>

    <div class="nav-menu-mobile">
        <div class="main-menu">
            <ul>
                <li><a href="<?= base_url(); ?>about-us">About Us</a></li>
                <li><a href="#" class="mobile-link-submenu" data-submenu="#submenu-collection">Collection<img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Arrow"></a></li>
                <li><a href="#" class="mobile-link-submenu" data-submenu="#submenu-shop">Shop<img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Arrow"></a></li>
                <li><a href="#" class="mobile-link-submenu" data-submenu="#submenu-journal">Journal<img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Arrow"></a></li>
            </ul>
            <!-- <div class="input-group input-group-search">
                <input type="text" class="form-control input-custom" id="search-mobile" placeholder="Search Here">
                <span class="input-group-btn">
                    <button class="btn btn-custom" type="button" id="btn-search-mobile"><i class="fa fa-search" aria-hidden="true"></i></button>
                </span>
            </div> -->

            <div class="menu-mobile-button-bottom">
                <div class="select-mobile-wrapper">
                    <? if ($setting->setting__website_enabled_dual_language > 0): ?>
                        <ul id="select-language-mobile">
                            <li onclick="changeLanguage('<?= $setting->setting__system_language; ?>');" <? if ($lang == $setting->setting__system_language): ?>class="active"<? endif; ?>><?= $setting->setting__system_language; ?></li>
                            <li onclick="changeLanguage('<?= $setting->setting__system_language2; ?>');" <? if ($lang == $setting->setting__system_language2): ?>class="active"<? endif; ?>><?= $setting->setting__system_language2; ?></li>
                        </ul>
                    <? endif; ?>
					<select class="form-control select-currency-language auto" id="select-currency-mobile">
						<? foreach ($arr_currency as $currency): ?>
							<option <? if ($currency->id == $curr): ?>class="active"<? endif; ?> value="<?= $currency->id; ?>"><?= $currency->name; ?></option>
						<? endforeach; ?>
					</select>
                </div>
                <div class="mobile-button-wrapper">
                    <button class="btn btn-mobile-bottom" data-toggle="modal" data-target="#sign-in-modal">SIGN IN</button>
                    <div class="line-seperate"></div>
                    <button class="btn btn-mobile-bottom" data-toggle="modal" data-target="#sign-up-modal">SIGN UP</button>
                </div>
            </div>
        </div>
        <div class="sub-menu" id="submenu-collection">
            <button class="btn btn-nav-mobile-back">
                <img src="<?= base_url(); ?>assets/images/main/arrow-back.png" alt="" class="arrow-back">
            </button>
            <div class="panel-group" id="submenu-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-custom mobile-menu">
                    <div class="panel-heading " role="tab" data-toggle="collapse" href="#collection-submenu" aria-expanded="true">
                        <h4 class="panel-title">
                            Our Collections
                        </h4>
                        <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                    </div>
                    <div id="collection-submenu" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true">
                        <div class="panel-body">
                            <ul class="submenu-list">
								<? foreach ($arr_navbar_menu['arr_navbar_collection'] as $navbar_collection): ?>
									<li><a href="<?= base_url(); ?>product/filter/1/newest/<?= $navbar_collection->id; ?>/0/0/0/0/"><?= $navbar_collection->name; ?></a></li>
								<? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-menu" id="submenu-journal">
            <button class="btn btn-nav-mobile-back">
                <img src="<?= base_url(); ?>assets/images/main/arrow-back.png" alt="" class="arrow-back">
            </button>
            <a href="<?= base_url(); ?>journal/muse">
                <div class="thumbnail">
                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-1.jpg)">
                        <div class="black-gradient-overlay">
                            <h4>MUSE</h4>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?= base_url(); ?>journal/media">
                <div class="thumbnail">
                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-2.jpg)">
                        <div class="black-gradient-overlay">
                            <h4>MEDIA</h4>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?= base_url(); ?>journal/events">
                <div class="thumbnail">
                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/navigation/journal-3.jpg)">
                        <div class="black-gradient-overlay">
                            <h4>EVENTS</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="sub-menu" id="submenu-shop">
            <button class="btn btn-nav-mobile-back">
                <img src="<?= base_url(); ?>assets/images/main/arrow-back.png" alt="" class="arrow-back">
            </button>
            <div class="panel-group" id="submenu-accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-custom mobile-menu">
                    <div class="panel-heading " role="tab" data-toggle="collapse" href="#submenu-alter-ego" aria-expanded="true">
                        <h4 class="panel-title">
                            The Alter Ego
                        </h4>
                        <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                    </div>
                    <div id="submenu-alter-ego" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true">
                        <div class="panel-body">
                            <ul class="submenu-list">
                                <? foreach ($arr_navbar_menu['arr_navbar_alterego'] as $navbar_alterego): ?>
									<li><a href="<?= base_url(); ?>product/filter/1/newest/0/0/0/<?= $navbar_alterego->id; ?>-/0/"><?= $navbar_alterego->name; ?></a></li>
								<? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-custom mobile-menu">
                    <div class="panel-heading collapsed" role="tab" data-toggle="collapse" href="#submenu-categories" aria-expanded="false">
                        <h4 class="panel-title">
                            Categories
                        </h4>
                        <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                    </div>
                    <div id="submenu-categories" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                        <div class="panel-body">
                            <ul class="submenu-list">
                               	<? foreach ($arr_navbar_menu['arr_navbar_category'] as $navbar_category): ?>
									<? if ($navbar_category->type == 'looks'): ?>
										<? continue; ?>
									<? endif; ?>

									<li><a href="<?= base_url(); ?>product/filter/1/newest/0/<?= $navbar_category->id; ?>-/0/0/0/"><?= $navbar_category->name; ?></a></li>
								<? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-custom mobile-menu">
                    <div class="panel-heading collapsed" role="tab" data-toggle="collapse" href="#submenu-looks" aria-expanded="false">
                        <h4 class="panel-title">
                            Looks
                        </h4>
                        <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                    </div>
                    <div id="submenu-looks" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                        <div class="panel-body">
                            <ul class="submenu-list">
                                <? foreach ($arr_navbar_menu['arr_navbar_category'] as $navbar_category): ?>
									<? if ($navbar_category->type != 'looks'): ?>
										<? continue; ?>
									<? endif; ?>

									<li><a href="<?= base_url(); ?>product/filter/1/newest/0/<?= $navbar_category->id; ?>-/0/0/0/"><?= $navbar_category->name; ?></a></li>
								<? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-custom mobile-menu">
                    <div class="panel-heading collapsed" role="tab" data-toggle="collapse" href="#submenu-gift-cards" aria-expanded="false">
                        <h4 class="panel-title">
                            Gift Cards
                        </h4>
                        <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                    </div>
                    <div id="submenu-gift-cards" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                        <div class="panel-body">
                            <ul class="submenu-list">
                                <li><a href="<?= base_url(); ?>giftcard">Printed Gift Cards</a></li>
                                <li><a href="<?= base_url(); ?>giftcard">Virtual Gift Cards</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript">
        var navbar              = document.querySelector('#navigation');
        var mobileMenuButton    = document.querySelector('button.btn-menu');
        var mobileMenu          = document.querySelector('.nav-menu-mobile');
        var mobileMainmenu      = document.querySelector('.main-menu');
        var mobileSubmenu       = document.querySelectorAll('.mobile-link-submenu');
        var backButton          = document.querySelectorAll('.btn-nav-mobile-back');
        var submenu             = document.querySelectorAll('.sub-menu');

        // Open Mobile Menu function
        mobileMenuButton.onclick = function(event) {
            mobileMenu.classList.toggle('active');
        }

        // Open Mobile Submenu Function
        // add click event to each .mobile-link-submenu
        // add active class to selected link
        for(var i = 0; i<mobileSubmenu.length; i++) {
            mobileSubmenu[i].onclick = function(event) {
                event.preventDefault();

                var submenuTarget = event.target.getAttribute("data-submenu");
                document.querySelector(submenuTarget).classList.add("active");

                // close main-menu
                mobileMainmenu.classList.add('submenu-open');
            };
        }

        // Close Mobile Submenu Function
        // add click event to each back backButton
        // remove active class from submenu
        for(var i = 0; i<backButton.length; i++) {
            backButton[i].onclick = function(event) {
                event.preventDefault();

                // remove active class all submenu

                for(var i = 0; i<submenu.length; i++) {
                    submenu[i].classList.remove("active");
                }

                // open main-menu
                mobileMainmenu.classList.remove('submenu-open');
            };
        }

        // detect if click outside mobile menu / navigation
        document.addEventListener('click', function(event) {
            if(mobileMenu.classList.contains('active')) {
                if (!mobileMenu.contains(event.target) && !navbar.contains(event.target)) {

                    //close mobile menu
                    mobileMenu.classList.remove('active');

                    // close submenu if open
                    if(mobileMainmenu.classList.contains('submenu-open')) {
                        setTimeout(function() {
                            for(var i = 0; i<submenu.length; i++) {
                                submenu[i].classList.remove("active");
                            }
                            // open main-menu
                            mobileMainmenu.classList.remove('submenu-open');
                        },300);
                    }
                }
            }
        })
    </script>

    <!-- Modal -->
    <div id="sign-in-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding hidden-xs">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/main/sign-in.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <h3 class="text-center">SIGN IN</h3>
                                <div class="description-wrapper">
                                    <p><span class="title-bold">Hello Again!</span> Please enter your email address and password below</p>
                                </div>
                                <div class="modal-form-wrapper">
                                    <div class="form-group form-group-custom">
                                        <label for="sign-in-email">Email <span class="error"> * Required</span></label>
                                        <input type="text" class="form-control input-custom data-login-important" id="sign-in-email" placeholder="Email">
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="sign-in-password">Password <span class="error"> * Required</span></label>
                                        <input type="password" class="form-control input-custom data-login-important" id="sign-in-password" placeholder="Password">
                                    </div>

									<p id="forgot-password-toggle" class="forgot-password">Forgot Password?</p>
                                </div>
                                <div class="modal-button-wrapper">
                                    <button id="navbar-login-button" class="btn btn-custom dark small">LOGIN</button>
                                    <button id="create-an-account-button" class="btn btn-custom small">CREATE AN ACCOUNT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- Modal -->
    <div id="forgot-password-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding hidden-xs">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/main/sign-in.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <h3 class="text-center">Forgot Your Password</h3>
                                <div class="description-wrapper">
                                    <p>Input your email address and we will send you an email to reset your password.</p>
                                </div>
                                <div class="modal-form-wrapper">
                                    <div class="form-group form-group-custom">
                                        <label for="forgot-password-email">Email <span class="error"> * Required</span></label>
                                        <input type="text" class="form-control input-custom data-forgot-password-important" id="forgot-password-email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="modal-button-wrapper">
                                    <button id="navbar-forgot-password-button" class="btn btn-custom dark small">SUBMIT</button>
                                    <button class="btn btn-custom small" data-dismiss="modal">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="sign-up-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding hidden-xs">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/main/sign-up.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper register">
                                <h3 class="text-center">REGISTER</h3>
                                <div class="description-wrapper register">
                                    <p>Stay in touch to see what we’ve been working on. You’ll be of the first to know about new products and promotions</p>
                                </div>
                                <div class="modal-form-wrapper">
                                    <div class="form-group form-group-custom">
                                        <label for="register-name">Name <span class="error"> * Required</span></label>
                                        <input type="text" class="form-control input-custom data-register-important" id="register-name" placeholder="Your Name">
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="register-phone-number">Phone Number <span class="error"> * Required</span></label>
                                        <input type="text" class="form-control input-custom data-register-important" id="register-phone" placeholder="Your Phone Number">
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="register-email">Email Address <span class="error"> * Required</span></label>
                                        <input type="text" class="form-control input-custom data-register-important" id="register-email" placeholder="Your Email">
                                    </div>
                                    <div class="form-group form-group-custom">
                                        <label for="register-password">Password <span class="error"> * Required</span></label>
                                        <input type="password" class="form-control input-custom data-register-important" id="register-password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="modal-button-wrapper">
                                    <button id="navbar-register-button" class="btn btn-custom dark small">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div id="cart-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">
                                <div class="cart-wrapper mobile">
                                    <h5>recently added item</h5>
                                    <hr>
									<div id="navbar-cart-list-mobile">
										<? if ($last_cart != null): ?>
		                                    <div class="row" style="margin-bottom:25px;">
	                                            <div class="col-xs-8 cart-item-left">
	                                                <div class="cart-item-thumbnail">
	                                                    <? if ($last_cart->product_id > 0): ?>
	                                                        <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $last_cart->image_name; ?>)"></div>
	                                                    <? else: ?>
	                                                        <div class="content-inside" style="background-image:url(<?= $last_cart->image_name; ?>)"></div>
	                                                    <? endif; ?>
	                                                </div><!--
	                                             --><div class="cart-item-description">
	                                                    <h5 class="cart-item-name"><?= $last_cart->name; ?></h5>
	                                                    <div class="cart-item-quantity">Qty: <?= $last_cart->quantity; ?></div>
	                                                    <div class="cart-item-quantity">Price: <?= $last_cart->price_display; ?></div>
	                                                </div>
	                                            </div><!--
	                                         --><div class="col-xs-4 v-center">
	                                            	<h5 class="cart-price"><?= $last_cart->total_display; ?>,-</h5>
	                                        	</div>
		                                	</div>
										<? else: ?>
											<div class="row">
												<div class="col-xs-12">Empty Cart</div>
											</div>
										<? endif; ?>
	                            	</div>
                                    <hr>
                                    <div class="text-right">
                                        <a href="<?= base_url(); ?>cart">
                                            <button class="btn btn-custom dark small">PROCEED TO CHECKOUT</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--
    <script type="application/javascript">
        document.querySelector('.navbar-toggle').onclick = function() {
            document.querySelector('.navbar-menu-mobile').className += " active";
        }
        document.querySelector('.close-navbar-mobile').onclick = function() {
            document.querySelector('.navbar-menu-mobile.active').className = "navbar-menu-mobile";
        }
    </script>
-->
