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
                            <li class="active">
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
                            <li>
                                <a href="<?= base_url(); ?>account/giftcard">Gift Cards</a>
                            </li>
                        </ul>
                    <? else: ?>
                        <ul class="my-account-navigation">
                            <li class="active">
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
                                <h4>EDIT PROFILE</h4>
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
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="first-name">Name <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-profile-important" id="profile-name" placeholder="Your Full Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="last-name">Phone <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-profile-important" id="profile-phone" placeholder="Your Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="email">Email Address <span class="error"> * Required</span></label>
                                            <input type="text" class="form-control input-custom data-profile-important" id="profile-email" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group form-group-custom label-only">
                                                    <label>Birthday <span class="error"> * Required</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="form-group form-group-custom">
                                                    <select class="form-control input-custom" id="profile-birthday-date">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                     </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group form-group-custom">
                                                    <select class="form-control input-custom" id="profile-birthday-month">
                                                        <option value="01">January</option>
                                                        <option value="02">February</option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group form-group-custom">
                                                    <select class="form-control input-custom" id="profile-birthday-year">
                                                        <? for ($i = 1945; $i <= $year_now; $i++): ?>
                                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                                        <? endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-right">
                                        <button id="submit-profile-button" class="btn btn-custom btn-full-mobile dark margin-top-15-mobile">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-7">
                        <div class="col-xs-12">
                            <div class="my-account-content">
                                <h4>CHANGE PASSWORD</h4>
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
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="old-password">Old Password <span class="error"> * Required</span></label>
                                            <input type="password" class="form-control input-custom data-password-important" id="old-password" placeholder="Your Old Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="new-password">New Password <span class="error"> * Required</span></label>
                                            <input type="password" class="form-control input-custom data-password-important" id="new-password" placeholder="Your New Password">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group form-group-custom">
                                            <label for="new-password-confirmation">New Password Confirmation <span class="error"> * Required</span></label>
                                            <input type="password" class="form-control input-custom data-password-important" id="new-password-confirmation" placeholder="Your New Password Confirmation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-right">
                                        <button id="submit-password-button" class="btn btn-custom btn-full-mobile dark margin-top-15-mobile">SAVE</button>
                                    </div>
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

<script type="text/javascript">
    $(function() {
        resetProfile();
        resetPassword();
        profileClick();
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

    function profileClick() {
        $('#submit-profile-button').click(function() {
            saveProfile();
        });

        $('#submit-password-button').click(function() {
            savePassword();
        });
    }

    function resetPassword() {
        $('#old-password').val("");
        $('#new-password').val("");
        $('#new-password-confirmation').val("");
    }

    function resetProfile() {
        $('#profile-name').val("<?= $customer->name; ?>");
        $('#profile-phone').val("<?= $customer->phone; ?>");
        $('#profile-email').val("<?= $customer->email; ?>");

        $('#profile-birthday-date').val("<?= $customer->birthday_day; ?>");
        $('#profile-birthday-month').val("<?= $customer->birthday_month; ?>");
        $('#profile-birthday-year').val("<?= $customer->birthday_year; ?>");
    }

    function savePassword() {
        $('#submit-password-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');

        $('.data-password-important').prev().children().html(' * Required').hide();
        $('.data-password-important').css('border', '1px solid #d9d9d9');

        var found = 0;
        var oldPassword = $('#old-password').val();
        var newPassword = $('#new-password').val();
        var newPasswordConfirmation = $('#new-password-confirmation').val();

        $.each($('.data-password-important'), function(key, password) {
            if ($(password).val() == '') {
                found += 1;

                $(password).prev().children().html(' * Required').show();
                $(password).css('border', '1px solid red');
            }
        });

        if (newPassword != newPasswordConfirmation) {
            found += 1;

            $('#new-password-confirmation').prev().children().html(' * Password not Match').show();
            $('#new-password-confirmation').css('border', '1px solid red');
        }

        if (found > 0) {
            $('#submit-password-button').html('SAVE');

            return;
        }

        $.ajax({
            data :{
                old_password: oldPassword,
                new_password: newPassword,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-password-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.reload();
                }
                else {
                    $('#old-password').prev().children().html(' * Password not Match').show();
                    $('#old-password').css('border', '1px solid red');
                }

                $('#submit-password-button').html('SAVE');
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_edit_password/<?= $customer->id; ?>/',
        });
    }

    function saveProfile() {
        $('#submit-profile-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');

        $('.data-profile-important').prev().children().html(' * Required').hide();
        $('.data-profile-important').css('border', '1px solid #d9d9d9');

        var found = 0;
        var name = $('#profile-name').val();
        var phone = $('#profile-phone').val();
        var email = $('#profile-email').val();
        var birthday = $('#profile-birthday-year').val() + '-' + $('#profile-birthday-month').val() + '-' + $('#profile-birthday-date').val();

        $.each($('.data-profile-important'), function(key, profile) {
            if ($(profile).val() == '') {
                found += 1;

                $(profile).prev().children().html(' * Required').show();
                $(profile).css('border', '1px solid red');
            }
        });

        if (email != '' && !isEmail(email)) {
            found += 1;

            $('#sign-in-email').prev().children().html(' * Wrong Email or Password').show();
            $('#sign-in-email').css('border', '1px solid red');
        }

        if (found > 0) {
            $('#submit-profile-button').html('SAVE');

            return;
        }

        $.ajax({
            data :{
                name: name,
                phone: phone,
                email: email,
                birthday: birthday,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-profile-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.reload();
                }
                else {
                    alert(data.message);
                }

                $('#submit-profile-button').html('SAVE');
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_edit_customer/<?= $customer->id; ?>/',
        });
    }
</script>

</html>
