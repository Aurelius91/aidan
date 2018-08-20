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
                    <? if ($lang == $setting->setting__system_language): ?>
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
                            <li>
                                <a href="<?= base_url(); ?>account/wishlist">My Wishlist</a>
                            </li>
                            <li class="active">
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
                            <li>
                                <a href="<?= base_url(); ?>account/wishlist">My Wishlist</a>
                            </li>
                            <li class="active">
                                <a href="<?= base_url(); ?>account/giftcard">Gift Cards</a>
                            </li>
                        </ul>
                    <? endif; ?>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="my-account-content">
                                <div class="table-responsive">
                                    <table class="table table-gift-card">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Value</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($arr_voucher_code as $voucher_code): ?>
                                                <tr>
                                                    <td class="col-xs-3 giftcard-code"><?= $voucher_code->number; ?></td>
                                                    <td class="col-xs-3 giftcard-value">IDR <?= $voucher_code->value_display; ?>,-</td>
                                                    <td class="col-xs-3"><?= $voucher_code->type; ?></td>
                                                    <td class="col-xs-3"><?= $voucher_code->status; ?></td>
                                                </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
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
