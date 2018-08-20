<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $choosen_collection->image_name; ?>)">
            <div class="header-content">
                <h2><?= $choosen_collection->name; ?></h2>
            </div>
            <div class="header-bg-overlay"></div>
        </div>
    </section>

    <section id="all-product-wrapper">
        <div class="container-fluid">
            <div class="all-product-inner">
                <button class="filter-toggle-mobile">
                    <h4>
                        FILTER
                    </h4>
                    <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter">
                </button>
                <div class="all-product-filter-wrapper">
                    <button class="btn btn-nav-mobile-back" id="btn-filter-back">
                        <img src="<?= base_url(); ?>assets/images/main/arrow-back.png" alt="" class="arrow-back">
                    </button>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-custom">
                            <div class="panel-heading " role="tab" id="filter-alter-ego-heading" data-toggle="collapse" href="#filter-alter-ego" aria-expanded="true" aria-controls="filterAlterEgoHeading">
                                <h4 class="panel-title">
                                    Collections
                                </h4>
                                <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                            </div>
                            <div id="filter-alter-ego" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterAlterEgo" aria-expanded="true">
                                <div class="panel-body">
                                    <? foreach ($arr_collection as $collection): ?>
                                        <div class="checkbox-wrapper">
                                            <input type="radio" name="checkbox-alter" id="checkbox-alter-<?= $collection->id; ?>" value="<?= $collection->id; ?>" class="checkbox-custom radio-alter-ego" />
                                            <label for="checkbox-alter-<?= $collection->id; ?>" class="checkbox-custom-label"><?= $collection->name; ?></label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-custom">
                            <div class="panel-heading <? if ($mobile == true): ?>collapsed<? endif; ?>" role="tab" id="filter-collection-heading" data-toggle="collapse" href="#filter-collection" aria-expanded="<? if ($mobile == true): ?>false<? else: ?>true<? endif; ?>" aria-controls="filterCollectionHeading">
                                <h4 class="panel-title">
                                    the alter ego
                                </h4>
                                <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                            </div>
                            <div id="filter-collection" class="panel-collapse <? if ($mobile == true): ?>collapse<? else: ?>collapse in<? endif; ?>" role="tabpanel" aria-labelledby="filterCollection" aria-expanded="<? if ($mobile == true): ?>false<? else: ?>true<? endif; ?>">
                                <div class="panel-body">
                                    <? foreach ($arr_alterego as $filter_alterego): ?>
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="checkbox-collection-<?= $filter_alterego->id; ?>" id="checkbox-collection-<?= $filter_alterego->id; ?>" value="<?= $filter_alterego->id; ?>" class="checkbox-custom checkbox-collection" />
                                            <label for="checkbox-collection-<?= $filter_alterego->id; ?>" class="checkbox-custom-label"><?= $filter_alterego->name; ?></label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-custom">
                            <div class="panel-heading" role="tab" id="filter-category-heading" data-toggle="collapse" href="#filter-category" aria-expanded="true" aria-controls="filterCategoryHeading">
                                <h4 class="panel-title">
                                    Categories
                                </h4>
                                <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                            </div>
                            <div id="filter-category" class="panel-collapse panel-collapse collapse in" role="tabpanel" aria-labelledby="filterCategory" aria-expanded="true">
                                <div class="panel-body">
                                    <? foreach ($arr_category as $filter_category): ?>
                                        <? if ($filter_category->type != 'category'): ?>
                                            <? continue; ?>
                                        <? endif; ?>

                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="checkbox-category-<?= $filter_category->id; ?>" id="checkbox-category-<?= $filter_category->id; ?>" value="<?= $filter_category->id; ?>" class="checkbox-custom checkbox-category" />
                                            <label for="checkbox-category-<?= $filter_category->id; ?>" class="checkbox-custom-label"><?= $filter_category->name; ?></label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-custom">
                            <div class="panel-heading" role="tab" id="filter-color-heading" data-toggle="collapse" href="#filter-color" aria-expanded="true" aria-controls="filterColorHeading">
                                <h4 class="panel-title">
                                    Colors
                                </h4>
                                <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                            </div>
                            <div id="filter-color" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterColor" aria-expanded="true">
                                <div class="panel-body">
                                    <? foreach ($arr_color as $color): ?>
                                        <div class="pick-color <? if ($color_id == $color->id): ?>active<? endif; ?>" data-color-id="<?= $color->id; ?>" style="background-color: <?= $color->hex; ?>"></div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-custom">
                            <div class="panel-heading <? if ($mobile == true): ?>collapsed<? endif; ?>" role="tab" id="filter-looks-heading" data-toggle="collapse" href="#filter-looks" aria-expanded="<? if ($mobile == true): ?>false<? else: ?>true<? endif; ?>" aria-controls="filterLooksHeading">
                                <h4 class="panel-title">
                                    Looks
                                </h4>
                                <img src="<?= base_url(); ?>assets/images/products/arrow-filter.png" alt="Filter" class="filter-arrow">
                            </div>
                            <div id="filter-looks" class="panel-collapse <? if ($mobile == true): ?>collapse<? else: ?>collapse in<? endif; ?>" role="tabpanel" aria-labelledby="filterLooks" aria-expanded="<? if ($mobile == true): ?>false<? else: ?>true<? endif; ?>">
                                <div class="panel-body">
                                    <? foreach ($arr_category as $filter_category): ?>
                                        <? if ($filter_category->type == 'category'): ?>
                                            <? continue; ?>
                                        <? endif; ?>

                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="checkbox-looks-<?= $filter_category->id; ?>" id="checkbox-looks-<?= $filter_category->id; ?>" value="<?= $filter_category->id; ?>" class="checkbox-custom checkbox-looks" />
                                            <label for="checkbox-looks-<?= $filter_category->id; ?>" class="checkbox-custom-label"><?= $filter_category->name; ?></label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="all-product-grid">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <div class="dropdown" id="dropdown-sort">
                                <button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown">SORT BY
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="filter-sort <? if ($sort == 'newest'): ?>active<? endif; ?>" data-sort="newest"><a onclick="filterProduct(1, 'newest');">Newest</a></li>
                                    <li class="filter-sort <? if ($sort == 'best-seller'): ?>active<? endif; ?>" data-sort="best-seller"><a onclick="filterProduct(1, 'best-seller');">Best Seller</a></li>
                                    <li class="filter-sort <? if ($sort == 'price-desc'): ?>active<? endif; ?>" data-sort="price-desc"><a onclick="filterProduct(1, 'price-desc');">Price High to Low</a></li>
                                    <li class="filter-sort <? if ($sort == 'price-asc'): ?>active<? endif; ?>" data-sort="price-asc"><a onclick="filterProduct(1, 'price-asc');">Price Low to High</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <? foreach ($arr_product as $product): ?>
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
                        <? endforeach; ?>
                    </div>

                    <? if ($count_page > 1): ?>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <ul class="pagination pagination-custom">
                                    <? if ($page > 1): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>product/filter/<?= $page - 1; ?>/<?= $sort; ?>/<?= $collection_id; ?>/<?= $category; ?>/<?= $look; ?>/<?= $alterego; ?>/<?= $color_id; ?>#all-product-wrapper" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <? endif; ?>

                                    <? for ($i = 1; $i <= $count_page; $i++): ?>
                                        <li class="product-pagination <? if ($page == $i): ?>active<? endif; ?>"><a href="<?= base_url(); ?>product/filter/<?= $i; ?>/<?= $sort; ?>/<?= $collection_id; ?>/<?= $category; ?>/<?= $look; ?>/<?= $alterego; ?>/<?= $color_id; ?>#all-product-wrapper"><?= $i; ?></a></li>
                                    <? endfor; ?>

                                    <? if ($page < $count_page): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>product/filter/<?= $page + 1; ?>/<?= $sort; ?>/<?= $collection_id; ?>/<?= $category; ?>/<?= $look; ?>/<?= $alterego; ?>/<?= $color_id; ?>#all-product-wrapper" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <? endif; ?>
                                </ul>
                            </div>
                        </div>
                    <? endif; ?>
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
    timeline.to("section#small-header .header-bg-overlay", 0.5, {x: '100%'})
            .from("section#small-header .header-content h2", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .from("section#small-header .header-content button.btn-custom", 0.3, {y: 30, autoAlpha: 0},'-=0.1')

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $('button.filter-toggle-mobile').on('click', function(event) {
        $('.all-product-filter-wrapper').addClass('active');
    });

    $('button#btn-filter-back').on('click', function(event) {
        $('.all-product-filter-wrapper').removeClass('active');
    });
</script>

<script type="text/javascript">
    $(function() {
        resetFilter();
        productClick();
    });

    function filterProduct(page, sort) {
        var alterEgo = '';
        var category = '';
        var looks = '';
        var collectionId = 0;
        var colorId = 0;

        $.each($('.radio-alter-ego'), function(key, radioAlterEgo) {
            if ($(radioAlterEgo).is(':checked')) {
                collectionId = $(radioAlterEgo).val();
            }
        });

        $.each($('.checkbox-category'), function(key, checkboxCategory) {
            if ($(checkboxCategory).is(':checked')) {
                category += $(checkboxCategory).val() + '-';
            }
        });

        $.each($('.checkbox-looks'), function(key, checkboxLooks) {
            if ($(checkboxLooks).is(':checked')) {
                looks += $(checkboxLooks).val() + '-';
            }
        });

        $.each($('.checkbox-collection'), function(key, checkboxCollection) {
            if ($(checkboxCollection).is(':checked')) {
                alterEgo += $(checkboxCollection).val() + '-';
            }
        });

        $.each($('.pick-color'), function(key, pickColor) {
            if ($(pickColor).hasClass('active')) {
                colorId = $(pickColor).attr('data-color-id');
            }
        });

        category = (category == '') ? 0 : category;
        looks = (looks == '') ? 0 : looks;
        alterEgo = (alterEgo == '') ? 0 : alterEgo;

        window.location.href = '<?= base_url(); ?>product/filter/'+ page +'/'+ sort +'/'+ collectionId +'/'+ category +'/'+ looks +'/'+ alterEgo +'/'+ colorId +'#all-product-wrapper'
    }

    function resetFilter() {
        $('#checkbox-alter-<?= $collection_id; ?>').prop("checked", true);

        <? foreach ($arr_choosen_category as $choosen_category): ?>
            $('#checkbox-category-<?= $choosen_category; ?>').prop('checked', true);
        <? endforeach; ?>

        <? foreach ($arr_choosen_look as $choosen_look): ?>
            $('#checkbox-looks-<?= $choosen_look; ?>').prop('checked', true);
        <? endforeach; ?>

        <? foreach ($arr_choosen_alterego as $choosen_alterego): ?>
            $('#checkbox-collection-<?= $choosen_alterego; ?>').prop('checked', true);
        <? endforeach; ?>
    }

    function productClick() {
        $('.checkbox-custom').click(function() {
            var page = 1;
            var sort = '';

            $.each($('.filter-sort'), function(key, filterSort) {
                if ($(filterSort).hasClass('active')) {
                    sort = $(filterSort).attr('data-sort');
                }
            });

            filterProduct(page, sort);
        });

        $('.pick-color').click(function() {
            $('.pick-color').removeClass('active');
            $(this).addClass('active');

            var page = 1;
            var sort = '';

            $.each($('.filter-sort'), function(key, filterSort) {
                if ($(filterSort).hasClass('active')) {
                    sort = $(filterSort).attr('data-sort');
                }
            });

            filterProduct(page, sort);
        });
    }
</script>

</html>
