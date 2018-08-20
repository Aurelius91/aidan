    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <section id="footer">
        <div class="container-fluid">
            <div class="footer-inner">
                <div class="row">
                    <div class="col-xs-6 col-sm-3">
                        <h5>our stockist</h5>
                        <a href="<?= base_url(); ?>stockist"><p>See our stockist worldwide</p></a>

                        <div class="margin-top-25-mobile visible-xs">
                            <h5>SOCIAL MEDIA</h5>
                            <ul class="footer-social-media-wrapper">
                                <? if ($setting->setting__social_media_facebook_link != ''): ?>
                                    <li>
                                        <a href="<?= $setting->setting__social_media_facebook_link; ?>" target="_blank">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-facebook fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                <? endif; ?>

                                <? if ($setting->setting__social_media_twitter_link != ''): ?>
                                    <li>
                                        <a href="<?= $setting->setting__social_media_twitter_link; ?>" target="_blank">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-twitter fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                <? endif; ?>

                                <? if ($setting->setting__social_media_skype_link != ''): ?>
                                    <li>
                                        <a href="<?= $setting->setting__social_media_skype_link; ?>" target="_blank">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-skype fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                <? endif; ?>

                                <? if ($setting->setting__social_media_instagram_link != ''): ?>
                                    <li>
                                        <a href="<?= $setting->setting__social_media_instagram_link; ?>" target="_blank">
                                            <div class="footer-social-media-box">
                                                <i class="fa fa-instagram fa-fw" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </li>
                                <? endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <h5>CLIENT RELATIONS</h5>
                        <ul class="footer-contact-list">
                            <? if ($setting->company_phone != ''): ?>
                                <li><a href="tel:<?= $setting->company_phone; ?>"><img src="<?= base_url(); ?>assets/images/main/phone.png" alt="" class="footer-contact-icon"><p><?= $setting->company_phone; ?></p></a></li>
                            <? endif; ?>

                            <? if ($setting->company_phone2 != ''): ?>
                                <li><a href="tel:<?= $setting->company_phone2; ?>"><img src="<?= base_url(); ?>assets/images/main/phone.png" alt="" class="footer-contact-icon visibility-hidden"><p><?= $setting->company_phone2; ?></p></a></li>
                            <? endif; ?>

                            <? if ($setting->company_opening_time != ''): ?>
                                <li><img src="<?= base_url(); ?>assets/images/main/home.png" alt="" class="footer-contact-icon"><p><?= $setting->company_opening_time; ?></p></li>
                            <? endif; ?>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-4">
                        <h5>SUBSCRIBE</h5>
                        <div class="input-group input-group-subscribe">
                            <input id="subscribe-email" type="text" class="form-control input-custom data-subscribe-important" placeholder="Your Email Address">
                            <span class="input-group-btn">
                                <button id="btn-subscribe-footer" class="btn btn-default" type="button" onclick="addSubscribe();">
                                    <img src="<?= base_url(); ?>assets/images/main/arrow-next.png" alt="Arrow Next" class="arrow-next">
                                </button>
                            </span>
                        </div>
                        <div class="success-subscribe-footer" style="display: none;">Thank you for Subscribing!</div>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-2 hidden-xs">
                        <h5>SOCIAL MEDIA</h5>
                        <ul class="footer-social-media-wrapper">
                            <? if ($setting->setting__social_media_facebook_link != ''): ?>
                                <li>
                                    <a href="<?= $setting->setting__social_media_facebook_link; ?>">
                                        <div class="footer-social-media-box">
                                            <i class="fa fa-facebook fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                            <? endif; ?>

                            <? if ($setting->setting__social_media_twitter_link != ''): ?>
                                <li>
                                    <a href="<?= $setting->setting__social_media_twitter_link; ?>">
                                        <div class="footer-social-media-box">
                                            <i class="fa fa-twitter fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                            <? endif; ?>

                            <? if ($setting->setting__social_media_skype_link != ''): ?>
                                <li>
                                    <a href="<?= $setting->setting__social_media_skype_link; ?>">
                                        <div class="footer-social-media-box">
                                            <i class="fa fa-skype fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                            <? endif; ?>

                            <? if ($setting->setting__social_media_instagram_link != ''): ?>
                                <li>
                                    <a href="<?= $setting->setting__social_media_instagram_link; ?>">
                                        <div class="footer-social-media-box">
                                            <i class="fa fa-instagram fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                            <? endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
            <div class="footer-inner">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="footer-links">
                            <? foreach ($arr_header as $header): ?>
                                <? if ($header->type != 'Footer'): ?>
                                    <? continue; ?>
                                <? endif; ?>

                                <li class="<? if ($header->id == 13): ?>col-xs-12<? else: ?>col-xs-6<? endif; ?> col-sm-20 no-padding-mobile"><a href="<?= base_url(); ?><?= $header->link; ?>"><?= $header->name; ?></a></li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer-copyright">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6">
                    <p><?= $setting->system_copyright; ?></p>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="<?= $setting->system_vendor_link; ?>" target="_blank"><p>Imagined by <?= $setting->system_vendor_name; ?></p></a>
                </div>
            </div>
        </div>
    </footer>
