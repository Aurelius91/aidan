<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Aidan | Confirmation Email</title>
    <style>
        /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */

        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
            border-spacing: 0;
        }

        table td {
            font-family: 'Lato Regular', 'Helvetica', sans-serif;
            font-size: 13px;
            vertical-align: top;
            border-spacing: 0;
        }
        /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

        .body {
            background-color: #f6f6f6;
            width: 100%;
        }
        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */

        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px;
        }
        /* This should also be a block element, so that it will fill 100% of the .container */

        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px;
        }
        /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */

        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
            border-spacing: 0;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 12px;
        }

        .wrapper-table {
            border-width: 1px;
            border-style: solid;
            border-color: #7d7d7d;
            padding: 35px 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }
        /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */

        h1,
        h2,
        h3,
        h4 {
            color: #454545;
            font-family: 'Montserrat Light', 'Helvetica', sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
        }

        h1 {
            font-size: 38px;
            font-weight: 300;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 0;
            margin-bottom: 24px;
        }

        p,
        ul,
        ol {
            font-family: 'Lato Regular', 'Helvetica', sans-serif;
            font-size: 13px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }
        /* -------------------------------------
          BUTTONS
      ------------------------------------- */

        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn > tbody > tr > td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 1px #242424;
            border-radius: 5px;
            box-sizing: border-box;
            color: #242424;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 10px 60px;
            text-decoration: none;
            text-transform: uppercase;
            display: block;
        }

        .btn-primary {
            margin-top: 28px;
        }

        .btn-primary table td {
            background-color: #fff;
        }

        .btn-primary a {
            background-color: #fff;
            border-color: #242424;
            color: #242424;
            border-radius: 0;
            transition-property: all;
            transition-duration: 0.4s;
            transition-timing-function: ease;
        }
        /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .small {
            text-transform: none !important;
        }

        .center-block {
            margin-left: auto;
            margin-right: auto;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        img.logo {
            display: block;
            width: 100%;
            max-width: 350px;
            margin-left: auto;
            margin-right: auto;
            transform: translate3d(0,0,0);
            margin-bottom: 12px;
        }

        .grey {
            color: #7d7d7d;
        }

        .table-product {
            margin-top: 40px;
            margin-bottom: 40px;
            text-align: left;
            background-color: #f4f4f4;
            background-color: #f4f4f4;
            padding: 6px 15px;
        }

        .table-product thead tr th {
            padding: 8px 0;
            border-bottom-style: solid;
            border-bottom-color: #d7d7d7;
            border-bottom-width: 1px;
            color: #272727;
        }

        .table-product tbody tr td {
            padding: 8px 0;
            vertical-align: middle;
        }

        .table-product tbody tr td p {
            margin-bottom: 0;
            font-size: 13px;
        }

        p.order-number {
            margin-top: 35px;
        }

        table.transfer-to {
            margin-top: 25px;
            margin-bottom: 25px;
            text-align: left;
            width: 100%;
            max-width: 360px;
        }

        table.transfer-to tbody tr td {
            vertical-align: middle;
        }

        table.transfer-to tbody tr td p {
            margin-bottom: 0;
        }

        img.bank-logo {
            width: 100%;
            max-width: 100px;
            transform: translate3d(0,0,0);
            margin-right: 5px;
        }

        img.product-image {
            width: 100%;
            display: block;
            max-width: 60px;
            transform: translate3d(0,0,0);
            margin-bottom: 5px;
        }

        /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */

        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }
            table[class=body] .content {
                padding: 0 !important;
            }
            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }
            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }
            table[class=body] .btn table {
                width: 100% !important;
            }
            table[class=body] .btn a {
                width: 100% !important;
            }
            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }

            img.logo {
                max-width: 90px;
            }

            .hide-mobile {
                display: none;
            }

            .wrapper-table {
                padding: 20px 10px;
            }

            .table-product tbody tr td {
                vertical-align: top;
            }

            .table-product thead tr th {
                padding: 8px 5px;
            }
        }
        /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */

        @media all {
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }
            .btn-primary table td:hover {
                background-color: #242424 !important;
                color: #fff !important;
            }
            .btn-primary a:hover {
                background-color: #242424 !important;
                border-color: #242424 !important;
                color: #fff !important;
            }
        }
    </style>
</head>

<body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">

                    <!-- START CENTERED WHITE CONTAINER -->
<!--                    <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>-->
                    <table class="main">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper">
                                <table class="wrapper-table" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?= base_url(); ?>assets/images/main/logo-email.png" alt="Aidan & Ice" class="logo">
                                                <h2 class="text-center">THANK YOU</h2>
                                                <p class="grey text-center">For your order. Kindly find attached the details of your order below.</p>
                                                <p class="order-number text-center"><span class="grey">Order Number:</span> <?= $sale->number; ?></p>

                                                <table class="table table-product">
                                                    <thead>
                                                        <tr>
                                                            <th class="cart-product-title">Product Detail</th>
                                                            <th class="hide-mobile"></th>
                                                            <th>Quantity</th>
                                                            <th class="reviews-steps-price">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <? foreach ($arr_sale_item as $sale_item): ?>
                                                            <? if ($sale_item->product_id): ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $sale_item->image_name; ?>" alt="Product 1" class="product-image">
                                                                        <p><?= $sale_item->product_name; ?></p>
                                                                    </td>
                                                                    <td class="hide-mobile"></td>
                                                                    <td>
                                                                        <p class="grey"><?= $sale_item->quantity_display; ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="grey">IDR <?= $sale_item->price_display; ?>,-</p>
                                                                    </td>
                                                                </tr>
                                                            <? else: ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $sale_item->image_name; ?>" alt="Product 1" class="product-image">
                                                                        <p><?= $sale_item->voucher_name; ?></p>
                                                                    </td>
                                                                    <td class="hide-mobile"></td>
                                                                    <td>
                                                                        <p class="grey"><?= $sale_item->quantity_display; ?></p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="grey">IDR <?= $sale_item->price_display; ?>,-</p>
                                                                    </td>
                                                                </tr>
                                                            <? endif; ?>
                                                        <? endforeach; ?>
                                                        <tr>
                                                            <td></td>
                                                            <td class="hide-mobile"></td>
                                                            <td class="cart-subtotal">
                                                                <p>Subtotal</p>
                                                            </td>
                                                            <td class="reviews-steps-price">
                                                                <p class="grey">IDR <?= $sale->subtotal_display; ?>,-</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="hide-mobile"></td>
                                                            <td class="cart-subtotal">
                                                                <p>Discount</p>
                                                            </td>
                                                            <td class="reviews-steps-price">
                                                                <p class="grey">IDR <?= $sale->discount_display; ?>,-</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="hide-mobile"></td>
                                                            <td class="cart-subtotal">
                                                                <p>Shipping</p>
                                                            </td>
                                                            <td class="reviews-steps-price">
                                                                <p class="grey">IDR <?= $sale->shipping_display; ?>,-</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="hide-mobile"></td>
                                                            <td class="cart-subtotal">
                                                                <p>Grand Total</p>
                                                            </td>
                                                            <td class="cart-total">
                                                                <p>IDR <?= $sale->total_display; ?>,-</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <? if ($type == 'manual'): ?>
                                                    <p class="grey">Please make your payment to the below account</p>
                                                    <div>
                                                        <img src="<?= base_url(); ?>assets/images/main/bca-logo.png" alt="BCA" class="bank-logo">
                                                    </div>
                                                    <div>
                                                        <p class="grey">006.366.9889 a/n PT Sardana Astama Duo</p>
                                                    </div>
                                                <? endif; ?>

                                                <div>
                                                    <p class="grey">Thank you for shopping with AIDAN & ICE</p>
                                                    <p class="grey">NO REFUND</p>
                                                    <p class="grey">Exchanges may be permitted for unused items with the same or higher value,<br>with the original invoice within 7 days from the purchase date</p>
                                                    <p class="grey">You are responsible for the return shipping cost</p>
                                                    <p class="grey">CUSTOM and/or SALE ITEMS are final and may not be returned,<br>exchanged or refunded</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- START FOOTER -->
                    <div class="footer">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <span class="apple-link">Aidan &amp; Ice </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>
