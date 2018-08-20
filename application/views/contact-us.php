<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="small-header">
        <? if ($arr_section[0]->image_name == ''): ?>
            <div class="header-bg" style="background-image:url(<?= base_url(); ?>assets/images/contact-us/header.jpg)">
                <div class="header-bg-overlay"></div>
            </div>
        <? else: ?>
            <div class="header-bg" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $arr_section[0]->image_name; ?>)">
                <div class="header-bg-overlay"></div>
            </div>
        <? endif; ?>
    </section>

    <section id="general-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <? if ($lang == $setting->setting__system_language || $arr_section[0]->title_lang == ''): ?>
                        <h2 class="section-title"><?= $arr_section[0]->title; ?></h2>
                    <? else: ?>
                        <h2 class="section-title"><?= $arr_section[0]->title_lang; ?></h2>
                    <? endif; ?>

                    <ul class="contact-us-info-list">
                        <? if ($setting->company_email != ''): ?>
                            <li>
                                <a href="mailto:<?= $setting->company_email; ?>" target="_top">
                                    <img src="<?= base_url(); ?>assets/images/main/mail-white.png" alt="Mail" class="info-list-mail"><p><?= $setting->company_email; ?></p>
                                </a>
                            </li>
                        <? endif; ?>

                        <? if ($setting->company_email2 != ''): ?>
                            <li>
                                <a href="mailto:<?= $setting->company_email2; ?>" target="_top">
                                    <img src="<?= base_url(); ?>assets/images/main/mail-white.png" alt="Mail" class="info-list-mail"><p><?= $setting->company_email2; ?></p>
                                </a>
                            </li>
                        <? endif; ?>

                        <? if ($setting->company_phone != ''): ?>
                            <li>
                                <a href="tel:<?= $setting->company_phone; ?>" target="_top">
                                    <img src="<?= base_url(); ?>assets/images/main/phone-white.png" alt="Phone" class="info-list-phone"><p><?= $setting->company_phone; ?></p>
                                </a>
                            </li>
                        <? endif; ?>

                        <? if ($setting->company_phone2 != ''): ?>
                            <li>
                                <a href="tel:<?= $setting->company_phone2; ?>" target="_top">
                                    <img src="<?= base_url(); ?>assets/images/main/phone-white.png" alt="Phone" class="info-list-phone"><p><?= $setting->company_phone2; ?></p>
                                </a>
                            </li>
                        <? endif; ?>

                        <? if ($setting->company_opening_time != ''): ?>
                            <li>
                                <img src="<?= base_url(); ?>assets/images/main/home-white.png" alt="Open Hours" class="info-list-open-hours"><p><?= $setting->company_opening_time; ?></p>
                            </li>
                        <? endif; ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group form-group-custom">
                                <label for="first-name">First Name <span class="error"> * Required</span></label>
                                <input type="text" class="form-control input-custom data-contact-important" id="first-name" placeholder="Your First Name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group form-group-custom">
                                <label for="last-name">Last Name <span class="error"> * Required</span></label>
                                <input type="text" class="form-control input-custom data-contact-important" id="last-name" placeholder="Your Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group form-group-custom">
                                <label for="email">Email Address <span class="error"> * Required</span></label>
                                <input type="text" class="form-control input-custom data-contact-important" id="email" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group form-group-custom">
                                <label for="subject">Subject <span class="error"> * Required</span></label>
                                <select class="form-control input-custom data-contact-important" id="subject">
                                    <option value="">-- SELECT SUBJECT --</option>
                                    <option value="1">Customer Care</option>
                                    <option value="2">Private Concierge (Home Shopping/Appointment at the office)</option>
                                    <option value="3">Press & Media</option>
                                    <option value="4">Collaborations or Contributors</option>
                                    <option value="5">Feedback & Suggestions</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-custom">
                                <label for="message">Message <span class="error"> * Required</span></label>
                                <textarea type="text" class="form-control input-custom data-contact-important" id="message" placeholder="Your Message" rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button id="contact-us-send-button" class="btn btn-custom dark full-mobile" onclick="sendContact();">SEND</button>
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
    // small-header
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#small-header'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.to("section#small-header .header-bg-overlay", 0.6, {x: '100%'})

    scene.setTween(timeline)
	.addTo(controller);
</script>

<script>
    // career list
    // create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: 'section#general-section'
    })

    // add multiple tweens, wrapped in a timeline.
    var timeline = new TimelineMax();
    timeline.from("section#general-section h2.section-title", 0.1, {y: 30, autoAlpha:0})
            .staggerFrom('ul.contact-us-info-list li',0.1, {y: 30, autoAlpha:0},0.1)
            .staggerFrom('div.form-group.form-group-custom',0.1, {y: 30, autoAlpha:0},0.1, '-=0.6')
            .from('button.btn-custom',0.1, {y: 30, autoAlpha:0})

    scene.setTween(timeline)
	.addTo(controller);
</script>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetContactForm();
    });

    function resetContactForm() {
        $('#first-name').val("");
        $('#last-name').val("");
        $('#email').val("");
        $('#subject').val("");
        $('#message').val("");
    }

    function sendContact() {
        $('#contact-us-send-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');

        $('.data-contact-important').prev().children().html(' * Required').hide();
        $('.data-contact-important').css('border', '1px solid #d9d9d9');

        var found = 0;
        var firstName = $('#first-name').val();
        var lastName = $('#last-name').val();
        var email = $('#email').val();
        var subject = $('#subject').val();
        var message = $('#message').val();

        $.each($('.data-contact-important'), function(key, contact) {
            if ($(contact).val() == '' || $(contact).val() == 0) {
                found += 1;

                $(contact).prev().children().html(' * Required').show();
                $(contact).css('border', '1px solid red');
            }
        });

        if (found > 0) {
            $('#submit-address-button').html('SAVE');

            return;
        }

        $.ajax({
            data :{
                first_name: firstName,
                last_name: lastName,
                email: email,
                subject: subject,
                message: message,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-address-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    alert('Email Sent. Please press ok to reload the pages.');

                    alert(data.message);
                }
                else {
                    alert(data.message);
                }

                $('#submit-address-button').html('SAVE');
            },
            type : 'POST',
            url : '<?= base_url(); ?>contact_us/ajax_send_contact/',
        });
    }
</script>

</html>
