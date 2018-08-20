<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="header">
        <div id="header-slider">
            <? if (count($arr_slideshow) > 0): ?>
                <? foreach ($arr_slideshow as $slideshow): ?>
                    <div>
                        <div class="header-slider-item hidden-xs" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $slideshow->image_name; ?>)">
                            <? if ($slideshow->description != ''): ?>
                                <div class="header-content">
                                    <h1><?= $slideshow->name; ?></h1>

                                    <? if ($lang == $setting->setting__system_language || $slideshow->description_lang == ''): ?>
                                        <?= $slideshow->description; ?>
                                    <? else: ?>
                                        <?= $slideshow->description_lang; ?>
                                    <? endif; ?>

                                    <a href="<?= base_url(); ?>about-us">
                                        <? if ($lang == $setting->setting__system_language): ?>
                                            <button class="btn btn-custom">READ MORE</button>
                                        <? else: ?>
                                            <button class="btn btn-custom">SELENGKAPNYA</button>
                                        <? endif; ?>
                                    </a>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="header-slider-item visible-xs" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $slideshow->image_mobile_name; ?>)"></div>
                    </div>
                <? endforeach; ?>
            <? else: ?>
                <div>
                    <div class="header-slider-item" style="background-image:url(<?= base_url(); ?>assets/images/main/header-bg.jpg)">
                        <div class="header-content">
                            <h1>The Inside</h1>
                            <p>Aidan and Ice is a handmade fashion accessories maker specializing in one-of-a-kind statement pieces. Established in 2013, Aidan and Ice offers a lifestyle collection of handcrafted wearable arts and lightweight necklaces, earrings, brooches, scarfs and shawls for woman of all ages</p>

                            <a href="<?= base_url(); ?>about-us">
                                <? if ($lang == $setting->setting__system_language): ?>
                                    <button class="btn btn-custom">READ MORE</button>
                                <? else: ?>
                                    <button class="btn btn-custom">SELENGKAPNYA</button>
                                <? endif; ?>
                            </a>
                        </div>
                    </div>
                    <div class="header-slider-item visible-xs" style="background-image:url(<?= base_url(); ?>assets/images/main/header-slide-1-mobile.jpg)"></div>
                </div>
            <? endif; ?>
        </div>
    </section>

    <section id="your-alter-ego">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <? if ($lang == $setting->setting__system_language || $arr_section[1]->title_lang == ''): ?>
                        <h2 class="section-title"><?= $arr_section[1]->title; ?></h2>
                    <? else: ?>
                        <h2 class="section-title"><?= $arr_section[1]->title_lang; ?></h2>
                    <? endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <ul class="nav nav-tabs alter-ego-tabs" role="tablist">
                        <? foreach ($arr_alterego as $key => $alterego): ?>
                            <li role="presentation" <? if ($key <= 0): ?>class="active"<? endif; ?>><a data-toggle="tab"  aria-controls="alter-ego-<?= $alterego->id; ?>" href="#alter-ego-<?= $alterego->id; ?>"><?= $alterego->name; ?></a></li>
                        <? endforeach; ?>
                    </ul>

                    <div class="tab-content">
                        <? foreach ($arr_alterego as $key => $alterego): ?>
                            <div role="tabpanel" id="alter-ego-<?= $alterego->id; ?>" class="tab-pane fade <? if ($key <= 0): ?>in active<? endif; ?>">
                                <div class="product-slider-wrapper">
                                    <div class="product-slider" id="alter-ego-slider-<?= $alterego->id; ?>">
                                        <? foreach ($arr_alterego_lookup[$alterego->id] as $product): ?>
                                            <div>
                                                <a href="<?= base_url(); ?>product/detail/<?= $product->url_name; ?>/">
                                                    <img src="<?= $setting->setting__system_admin_url; ?>images/website/<?= $product->image_name; ?>" alt="" class="img-responsive">
                                                    <p><?= $product->name; ?></p>
                                                </a>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="our-journal" class="scroll-general-section">
        <? if ($arr_section[2]->image_name == ''): ?>
            <div class="section-bg"></div>
        <? else: ?>
            <div class="section-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[2]->image_name; ?>)"></div>
        <? endif; ?>

        <div class="our-journal-inner">
            <div class="our-journal-content">
                <? if ($lang == $setting->setting__system_language || $arr_section[2]->title_lang == ''): ?>
                    <h2 class="section-title"><?= $arr_section[2]->title; ?></h2>
                <? else: ?>
                    <h2 class="section-title"><?= $arr_section[2]->title_lang; ?></h2>
                <? endif; ?>

                <? if ($lang == $setting->setting__system_language || $arr_section[2]->description_lang == ''): ?>
                    <?= $arr_section[2]->description; ?>
                <? else: ?>
                    <?= $arr_section[2]->description_lang; ?>
                <? endif; ?>

                <? if ($arr_section[2]->custom_text_1 != ''): ?>
                    <a href="<?= base_url(); ?>journal">
                        <? if ($lang == $setting->setting__system_language): ?>
                            <button class="btn btn-custom transparent"><?= $arr_section[2]->custom_text_1; ?></button>
                        <? else: ?>
                            <button class="btn btn-custom transparent"><?= $arr_section[2]->custom_text_1_lang; ?></button>
                        <? endif; ?>
                    </a>
                <? endif; ?>
            </div>
        </div>
    </section>

    <section id="trending-and-new">
        <div class="whats-trending-wrapper">
            <? if ($lang == $setting->setting__system_language || $arr_section[3]->title_lang == ''): ?>
                <h3><?= $arr_section[3]->title; ?></h3>
            <? else: ?>
                <h3><?= $arr_section[3]->title_lang; ?></h3>
            <? endif; ?>

            <div class="whats-trending">
                <? if ($arr_section[3]->image_name == ''): ?>
                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/main/whats-trending-bg.jpg)">
                <? else: ?>
                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[3]->image_name; ?>)">
                <? endif; ?>

                    <div class="whats-content">
                        <? if ($lang == $setting->setting__system_language || $arr_section[3]->subtitle_lang == ''): ?>
                            <p><?= $arr_section[3]->subtitle; ?></p>
                        <? else: ?>
                            <p><?= $arr_section[3]->subtitle_lang; ?></p>
                        <? endif; ?>

                        <? if ($arr_section[3]->custom_text_1 != ''): ?>
                            <a href="<?= base_url(); ?>product/filter/1/best-seller/1/0/0/0/0">
                                <? if ($lang == $setting->setting__system_language): ?>
                                    <button class="btn btn-custom transparent"><?= $arr_section[3]->custom_text_1; ?></button>
                                <? else: ?>
                                    <button class="btn btn-custom transparent"><?= $arr_section[3]->custom_text_1_lang; ?></button>
                                <? endif; ?>
                            </a>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="whats-new-wrapper">
            <? if ($lang == $setting->setting__system_language || $arr_section[4]->title_lang == ''): ?>
                <h3><?= $arr_section[4]->title; ?></h3>
            <? else: ?>
                <h3><?= $arr_section[4]->title_lang; ?></h3>
            <? endif; ?>

            <div class="whats-new">
                <? if ($arr_section[4]->image_name == ''): ?>
                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/main/whats-new-bg.jpg)">
                <? else: ?>
                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[4]->image_name; ?>)">
                <? endif; ?>

                    <div class="whats-content">
                        <? if ($lang == $setting->setting__system_language || $arr_section[4]->subtitle_lang == ''): ?>
                            <p><?= $arr_section[4]->subtitle; ?></p>
                        <? else: ?>
                            <p><?= $arr_section[4]->subtitle_lang; ?></p>
                        <? endif; ?>

                        <? if ($arr_section[4]->custom_text_1 != ''): ?>
                            <a href="<?= base_url(); ?>product/filter/1/newest/1/0/0/0/0">
                                <? if ($lang == $setting->setting__system_language): ?>
                                    <button class="btn btn-custom transparent"><?= $arr_section[4]->custom_text_1; ?></button>
                                <? else: ?>
                                    <button class="btn btn-custom transparent"><?= $arr_section[4]->custom_text_1_lang; ?></button>
                                <? endif; ?>
                            </a>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gift-voucher">
        <!-- <div class="gift-voucher-bg" style="background-image:url(<?= base_url(); ?>assets/images/main/gift-vouchers-bg.jpg)"> -->
<!--        <div class="section-bg"></div>-->
        <div class="gift-voucher-inner">
            <div class="gift-voucher-content">
                <? if ($lang == $setting->setting__system_language || $arr_section[5]->title_lang == ''): ?>
                    <h2 class="section-title"><?= $arr_section[5]->title; ?></h2>
                <? else: ?>
                    <h2 class="section-title"><?= $arr_section[5]->title_lang; ?></h2>
                <? endif; ?>

                <? if ($lang == $setting->setting__system_language || $arr_section[5]->subtitle_lang == ''): ?>
                    <p><?= $arr_section[5]->subtitle; ?></p>
                <? else: ?>
                    <p><?= $arr_section[5]->subtitle_lang; ?></p>
                <? endif; ?>

                <? if ($arr_section[5]->custom_text_1 != ''): ?>
                    <a href="<?= base_url(); ?>giftcard">
                        <? if ($lang == $setting->setting__system_language): ?>
                            <button class="btn btn-custom"><?= $arr_section[5]->custom_text_1; ?></button>
                        <? else: ?>
                            <button class="btn btn-custom"><?= $arr_section[5]->custom_text_1_lang; ?></button>
                        <? endif; ?>
                    </a>
                <? endif; ?>
            </div>
        </div>
    </section>

    <section id="customize-order" class="scroll-general-section">
        <? if ($arr_section[6]->image_name == ''): ?>
            <div class="section-bg"></div>
        <? else: ?>
            <div class="section-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[6]->image_name; ?>)"></div>
        <? endif; ?>

        <div class="customize-order-inner">
            <div class="customize-order-content">
                <? if ($lang == $setting->setting__system_language || $arr_section[6]->title_lang == ''): ?>
                    <h2 class="section-title"><?= $arr_section[6]->title; ?></h2>
                <? else: ?>
                    <h2 class="section-title"><?= $arr_section[6]->title_lang; ?></h2>
                <? endif; ?>

                <? if ($lang == $setting->setting__system_language || $arr_section[6]->subtitle_lang == ''): ?>
                    <p><?= $arr_section[6]->subtitle; ?></p>
                <? else: ?>
                    <p><?= $arr_section[6]->subtitle_lang; ?></p>
                <? endif; ?>

                <? if ($arr_section[6]->custom_text_1 != ''): ?>
                    <? if ($lang == $setting->setting__system_language): ?>
                        <button class="btn btn-custom transparent" data-toggle="modal" data-target="#customize-order-modal"><?= $arr_section[6]->custom_text_1; ?></button>
                    <? else: ?>
                        <button class="btn btn-custom transparent" data-toggle="modal" data-target="#customize-order-modal"><?= $arr_section[6]->custom_text_1_lang; ?></button>
                    <? endif; ?>
                <? endif; ?>
            </div>
        </div>
    </section>

    <section id="social-media-feed">
        <? if ($lang == $setting->setting__system_language || $arr_section[7]->title_lang == ''): ?>
            <h4 class="text-center"><?= $arr_section[7]->title; ?></h4>
        <? else: ?>
            <h4 class="text-center"><?= $arr_section[7]->title_lang; ?></h4>
        <? endif; ?>

        <script src="//lightwidget.com/widgets/lightwidget.js"></script>
        <iframe src="//lightwidget.com/widgets/5137f1883ca3598e8f31952ce896ce42.html" id="lightwidget_5137f1883c" name="lightwidget_5137f1883c"  scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>
    </section>

    <? $this->load->view('footer'); ?>

    <!-- Modal -->
    <div id="customize-order-modal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row row-eq-height-tablet">
                        <div class="col-xs-12 col-sm-6 no-padding">
                            <div class="modal-left-image" style="background-image:url(<?= base_url(); ?>assets/images/main/customize-modal.jpg)"></div>
                        </div>
                        <div class="col-xs-12 col-sm-6" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="modal-right-wrapper">

                                <? if ($lang == $setting->setting__system_language): ?>
                                    <h3 class="text-center normal">BOOK AN APPOINTMENT</h3>
                                <? else: ?>
                                    <h3 class="text-center normal">JADWALKAN PERTEMUAN</h3>
                                <? endif; ?>

                                <? if ($lang == $setting->setting__system_language): ?>
                                    <div class="description-wrapper">
                                        <p>Fill out your details and we’ll get back to you shortly</p>
                                    </div>
                                <? else: ?>
                                    <div class="description-wrapper">
                                        <p>Isi data berikut dan kami akan menghubungi anda</p>
                                    </div>
                                <? endif; ?>

                                <? if ($lang == $setting->setting__system_language): ?>
                                    <div class="modal-form-wrapper">
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-name">Name <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-name" placeholder="Your Name">
                                        </div>
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-email">Email <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-email" placeholder="Your Email">
                                        </div>
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-phone-number">Phone Number <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-phone-number" placeholder="Your Phone Number">
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group form-group-custom label-only">
                                                            <label for="customize-order-date">DATE </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-customize-modal">
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-date" placeholder="dd">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-month" placeholder="mm">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-year" placeholder="yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="customize-order-time">TIME</label>
                                                    <select class="form-control input-custom" id="customize-order-time">
                                                        <option value="11.00">11.00 AM</option>
                                                        <option value="12.00">12.00 AM</option>
                                                        <option value="13.00">13.00 PM</option>
                                                        <option value="14.00">14.00 PM</option>
                                                        <option value="15.00">15.00 PM</option>
                                                        <option value="16.00">16.00 PM</option>
                                                        <option value="17.00">17.00 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-button-wrapper">
                                        <button id="send-appointment-button" class="btn btn-custom dark small" onclick="sendAppointment();">SUBMIT</button>
                                        <button class="btn btn-custom small" data-dismiss="modal">CANCEL</button>
                                    </div>
                                <? else: ?>
                                    <div class="modal-form-wrapper">
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-name">Nama <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-name" placeholder="Nama Kamu">
                                        </div>
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-email">Email <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-email" placeholder="Email Kamu">
                                        </div>
                                        <div class="form-group form-group-custom">
                                            <label for="customize-order-phone-number">Nomor Telepon <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-phone-number" placeholder="Nomor Telepon Kamu">
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group form-group-custom label-only">
                                                            <label for="customize-order-date">Tanggal </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-customize-modal">
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-date" placeholder="dd">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-month" placeholder="mm">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <div class="form-group form-group-custom">
                                                            <input type="text" class="form-control input-custom data-appointment-important" id="customize-order-year" placeholder="yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="customize-order-time">Jam</label>
                                                    <select class="form-control input-custom" id="customize-order-time">
                                                        <option value="11.00">11.00 AM</option>
                                                        <option value="12.00">12.00 AM</option>
                                                        <option value="13.00">13.00 PM</option>
                                                        <option value="14.00">14.00 PM</option>
                                                        <option value="15.00">15.00 PM</option>
                                                        <option value="16.00">16.00 PM</option>
                                                        <option value="17.00">17.00 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-button-wrapper">
                                        <button id="send-appointment-button" class="btn btn-custom dark small" onclick="sendAppointment();">KUMPUL</button>
                                        <button class="btn btn-custom small" data-dismiss="modal">BATAL</button>
                                    </div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscribe Modal -->
    <div id="subscribe-modal" class="modal modal-custom modal-subscribe fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 no-padding" style="position:relative">
                            <button class="btn btn-close" data-dismiss="modal">
                                <div class="close-icon"></div>
                            </button>
                            <div class="subscribe-modal-image">
                                <? if ($arr_section[0]->image_name == ''): ?>
                                    <div class="content-inside" style="background-image:url(<?= base_url(); ?>assets/images/main/subscribe-modal.jpg)"></div>
                                <? else: ?>
                                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[0]->image_name; ?>)"></div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="modal-right-wrapper subscribe">
                                <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                                    <h3 class="text-center"><?= $arr_section[0]->title; ?></h3>
                                <? else: ?>
                                    <h3 class="text-center"><?= $arr_section[0]->title_lang; ?></h3>
                                <? endif; ?>

                                <div class="description-wrapper">
                                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->subtitle_lang == ''): ?>
                                        <p><?= $arr_section[0]->subtitle; ?></p>
                                    <? else: ?>
                                        <p><?= $arr_section[0]->subtitle_lang; ?></p>
                                    <? endif; ?>

                                </div>
                                <div class="modal-form-wrapper subscribe">
                                    <div class="form-group form-group-custom">
                                        <input type="text" class="form-control input-custom data-subscribe-modal-important" id="subscribe-modal-email" placeholder="Your Email">
                                    </div>
                                    <div class="success-subscribe" style="display: none;">Thank you for Subscribing!</div>
                                </div>
                                <div class="text-center">
                                    <button id="btn-subscribe" class="btn btn-custom dark small" onclick="insertSubscribe();">SUBSCRIBE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!--[if (lt IE 9)]><script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.helper.ie8.js"></script><![endif]-->
<script src="<?= base_url(); ?>assets/plugin/tinyslider/tiny-slider.js"></script>

<script>
    var slider = tns({
        container: '#header-slider',
        items: 1,
        mouseDrag: true,
        swipeAngle: false,
        arrowKeys: true,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayButtonOutput: false,
        loop: true,
        nav: true,
        controls: false
    });
</script>

<? foreach ($arr_alterego as $alterego): ?>
    <script>
        var slider = tns({
            container: '#alter-ego-slider-<?= $alterego->id; ?>',
            items: 2,
            mouseDrag: true,
            swipeAngle: false,
            arrowKeys: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayButtonOutput: false,
            loop: true,
            nav: false,
            controlsText: [" <img src='<?= base_url(); ?>assets/images/main/arrow-left.png'> ", " <img src='<?= base_url(); ?>assets/images/main/arrow-right.png'> "],
            responsive: {
                "768": {
                  "items": 3,
                },
                "1080": {
                  "items": 4
                }
            }
        });
    </script>
<? endforeach; ?>

<? $this->load->view('scrollmagic'); ?>

<script>
    // your alter ego
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#your-alter-ego'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#your-alter-ego h2.section-title", 0.3, {y: 30, autoAlpha: 0})
            .from("section#your-alter-ego .alter-ego-tabs", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .from("section#your-alter-ego .tab-content", 0.3, {y: 30, autoAlpha: 0})

    scene.setTween(timeline)
    .addTo(controller);
</script>

<script>
    // whats trending and whats new
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#trending-and-new'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#trending-and-new > div > h3", 0.3, {y: 30, autoAlpha: 0})
            .from("section#trending-and-new .content-inside", 0.4, {y: 30, autoAlpha: 0})
           .from("section#trending-and-new .whats-content p", 0.3, {y: 30, autoAlpha: 0},'-=0.1')
            .from("section#trending-and-new .whats-content button.btn-custom", 0.3, {y: 30, autoAlpha: 0})

    scene.setTween(timeline)
    .addTo(controller);
</script>

<script>
    // loop for general section which has same structure
    var elements = document.getElementsByClassName('scroll-general-section');

    for(var i = 0; i < elements.length; i++){
        var section = 'section#' + elements[i].id;

        // create a scene
        var scene = new ScrollMagic.Scene({
            triggerElement: section
        })

        // add multiple tweens, wrapped in a timeline.
        var timeline = new TimelineMax();
        timeline.from(section + " h2", 0.3, {y: 30, autoAlpha: 0})
                .from(section + " p", 0.3, {y: 30, autoAlpha: 0},'-=0.2')
                .from(section + " button.btn-custom", 0.3, {y: 30, autoAlpha: 0},'-=0.2')

        scene.setTween(timeline)
        .addTo(controller);
    }
</script>

<script>
    // loop for general section which has same structure
    var elements = document.getElementsByClassName('scroll-general-section');

    for(var i = 0; i < elements.length; i++){
        var section = 'section#' + elements[i].id;

        // create a scene
        var scene = new ScrollMagic.Scene({
            triggerElement: section
        })

        // add multiple tweens, wrapped in a timeline.
        var tweenlite = TweenMax.to(section + " .section-bg", 1, {y: "25%", ease: Linear.easeNone});

        scene.setTween(tweenlite)
            .addTo(controller)
            .duration('200%')
            .reverse(true);
    }
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        <? if (!$customer && $setting->setting__website_enabled_subscribe > 0): ?>
            $('#subscribe-modal').modal('show');
        <? endif; ?>

        resetAppointment();
    });

    function insertSubscribe() {
        $('#btn-subscribe').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> SUBMITTING...</span>');
        var emailSubscribe = $('#subscribe-modal-email').val();
        var found = 0;

        $.each($('.data-subscribe-modal-important'), function(key, subscribe) {
            if ($(subscribe).val() == '') {
                found += 1;

                $(subscribe).css('border', '1px solid red');
            }
        });

        if (emailSubscribe != '' && !isEmail(emailSubscribe)) {
            found += 1;

            $('#subscribe-modal-email').css('border', '1px solid red');
        }

        if (found > 0) {
            $('#btn-subscribe').html('SUBMIT');

            return;
        }

        $.ajax({
            data :{
                email: emailSubscribe,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#btn-subscribe').html('SUBMIT');
            },
            success: function(data){
                if (data.status == 'success') {
                    $('.success-subscribe').show();
                }
                else {
                    $(subscribe).css('border', '1px solid red');
                }

                $('#btn-subscribe').html('SUBMIT');
            },
            type : 'POST',
            url : '<?= base_url(); ?>main/ajax_subscribe/',
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

    function resetAppointment() {
        $('.data-appointment-important').val("");

        $('#customize-order-date').val("<?= $day; ?>");
        $('#customize-order-month').val("<?= $month; ?>");
        $('#customize-order-year').val("<?= $year; ?>");
    }

    function sendAppointment() {
        $('#send-appointment-button').val('<i class="fa fa-spinner fa-spin fa-fw"></i><span> SENDING...</span>');

        var name = $('#customize-order-name').val();
        var email = $('#customize-order-email').val();
        var phone = $('#customize-order-phone-number').val();

        var day = $('#customize-order-date').val();
        var month = $('#customize-order-month').val();
        var year = $('#customize-order-year').val();
        var time = $('#customize-order-time').val();
        var found = 0;

        $.each($('.data-appointment-important'), function(key, appointment) {
            if ($(appointment).val() == '') {
                found += 1;

                $(appointment).prev().children().html(' * Required').show();
                $(appointment).css('border', '1px solid red');
            }
        });

        if (found > 0) {
            $('#send-appointment-button').html('SUBMIT');

            return;
        }

        $.ajax({
            data :{
                name: name,
                phone: phone,
                email: email,
                day: day,
                month: month,
                year: year,
                time: time,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#navbar-register-button').html('SUBMIT');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.reload();
                }
                else {
                    $('#sign-in-email').prev().children().html(' * '+ data.message).show();
                    $('#sign-in-email').css('border', '1px solid red');
                }

                $('#navbar-register-button').html('SUBMIT');
            },
            type : 'POST',
            url : '<?= base_url(); ?>main/ajax_send_appointment/',
        });
    }
</script>

</html>
