<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="general-section" class="account-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2 class="section-title">MY ACCOUNT</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <ul class="my-account-navigation">
                            <li>
                                <a href="<?= base_url(); ?>account">My Profile</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/address">Address</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/order-status">Status Order</a>
                            </li>
                            <li class="active">
                                <a href="<?= base_url(); ?>account/wishlist">My Wishlist</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/giftcard">Gift Cards</a>
                            </li>
                        </ul>
                    <? else: ?>
                        <ul class="my-account-navigation">
                            <li>
                                <a href="<?= base_url(); ?>account">Profil Saya</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/address">Alamat</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/order-status">Status Pemesanan</a>
                            </li>
                            <li class="active">
                                <a href="<?= base_url(); ?>account/wishlist">My Wishlist</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>account/giftcard">Gift Cards</a>
                            </li>
                        </ul>
                    <? endif; ?>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="my-account-content">
                                <h4>MY WISHLIST</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="my-account-content">
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
                                                        <div class="product-hover-image" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>)"></div>
                                                    </a>
                                                    <p class="product-hover-name"><?= $product->name; ?></p>
                                                    <p class="product-hover-price"><?= $product->price_display; ?>,-</p>
                                                    <button class="btn btn-custom dark">QUICKSHOP</button>
                                                </div>
                                            </div>
                                        </div>
                                    <? endforeach; ?>
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

<? $this->load->view('js'); ?>

</html>
