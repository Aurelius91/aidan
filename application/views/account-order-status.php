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
                            <li class="active">
                                <a href="<?= base_url(); ?>account/order-status">Status Order</a>
                            </li>
                            <li>
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
                            <li class="active">
                                <a href="<?= base_url(); ?>account/order-status">Status Pemesanan</a>
                            </li>
                            <li>
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
                                <div class="table-responsive">
                                    <table class="table table-order-status">
                                        <thead>
                                            <tr>
                                                <!-- <th>Product</th> -->
                                                <th>No. Order</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Delivery Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($arr_sale as $sale): ?>
                                                <tr>
                                                    <td class="col-xs-2 order-number" data-toggle="modal" data-target="#order-status-<?= $sale->id; ?>-modal"><?= $sale->number; ?></td>
                                                    <td><?= $sale->date_display; ?></td>
                                                    <td class="col-xs-2 order-total">IDR <?= $sale->total_display?>,-</td>
                                                    <td class="col-xs-2 order-status <?= $sale->status_display; ?>"><?= $sale->status_display; ?></td>
                                                    <td class="col-xs-2 order-track"><a href="#">Track delivery</a></td>
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

    <? foreach ($arr_sale as $sale): ?>
        <div id="order-status-<?= $sale->id; ?>-modal" class="modal modal-custom order-status fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn btn-close" data-dismiss="modal">
                            <div class="close-icon"></div>
                        </button>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="title-bold text-center">ORDER NO <?= $sale->number; ?></p>
                                <table class="table table-order-status">
                                    <thead>
                                        <tr>
                                            <th class="col-xs-3">Product</th>
                                            <th class="col-xs-3">Price</th>
                                            <th class="col-xs-3">Quantity</th>
                                            <th class="col-xs-3">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($sale->arr_sale_item as $sale_item): ?>
                                            <tr>
                                                <td class="col-xs-3"><?= ($sale_item->product_id > 0) ? $sale_item->product_name : $sale_item->voucher_name; ?></td>
                                                <td class="col-xs-3">IDR <?= $sale_item->price_display; ?></td>
                                                <td class="col-xs-3"><?= $sale_item->quantity_display; ?></td>
                                                <td class="col-xs-3">Rp <?= $sale_item->total_display; ?></td>
                                            </tr>
                                        <? endforeach; ?>
                                    </tbody>
                                </table>
                                <table class="table table-order-status popup">
                                    <tbody>
                                        <tr>
                                            <td class="col-xs-9 text-center title-bold">Subtotal</td>
                                            <td class="col-xs-3 title-bold">IDR <?= $sale->subtotal_display?>,-</td>
                                        </tr>
                                        <tr>
                                            <td class="col-xs-9 text-center title-bold">Shipping</td>
                                            <td class="col-xs-3 title-bold">IDR <?= $sale->shipping_display?>,-</td>
                                        </tr>
                                        <tr>
                                            <td class="col-xs-9 text-center title-bold">Discount</td>
                                            <td class="col-xs-3 title-bold">IDR <?= $sale->discount_display?>,-</td>
                                        </tr>
                                        <tr>
                                            <td class="col-xs-9 text-center title-bold">Total</td>
                                            <td class="col-xs-3 title-bold">IDR <?= $sale->total_display?>,-</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="order-status-description">
                                            <p class="title-bold">
                                                Shipping Address
                                            </p>
                                            <p>
                                                <?= $sale->shipping_name; ?><br>
                                                <?= $sale->shipping_address; ?><br>
                                                <?= $sale->shipping_district; ?>, <?= $sale->shipping_city; ?><br>
                                                <?= $sale->shipping_province; ?>, <?= $sale->shipping_province; ?>, <?= $sale->shipping_zip_code; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="order-status-description">
                                            <p class="title-bold">
                                                Shipping Method
                                            </p>
                                            <p><?= $sale->shipping_courier; ?>, <?= $sale->shipping_etd; ?> Days</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="order-status-description">
                                            <p class="title-bold">
                                                Customer Info
                                            </p>
                                            <p>
                                                <?= $customer->name; ?>
                                                P: <?= $customer->phone; ?><br>
                                                e: <?= $customer->email; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="order-status-description">
                                            <p class="title-bold">Gift Message</p>
                                            <p>
                                                <?= $sale->message; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>

</body>

<? $this->load->view('js'); ?>


</html>
