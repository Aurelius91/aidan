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
                            <li class="active">
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
                            <li>
                                <a href="<?= base_url(); ?>account">Profil Saya</a>
                            </li>
                            <li class="active">
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
                                <? if ($lang == $setting->setting__system_language): ?>
                                    <h4>ADDRESS LIST</h4>
                                <? else: ?>
                                    <h4>DAFTAR ALAMAT</h4>
                                <? endif; ?>
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="my-account-content">
                                        <p class="nav-address-text">See this address as:</p>
                                        <ul class="nav nav-pills nav-pills-custom">
                                            <li <? if (count($arr_address) <= 0): ?>class="active"<? endif; ?>><a data-toggle="pill" href="#address-new">New Address</a></li>

                                            <? foreach ($arr_address as $key => $address): ?>
                                                <li <? if ($key <= 0): ?>class="active"<? endif; ?>><a data-toggle="pill" href="#address-<?= $address->id; ?>"><?= $address->name; ?></a></li>
                                            <? endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content tab-content-custom">
                                <div id="address-new" class="tab-pane fade <? if (count($arr_address) <= 0): ?>in active<? endif; ?>">
                                    <div class="my-account-content">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom no-margin">
                                                    <label for="save-address-as">Save Address as <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-name" placeholder="Ex: Home, Office">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <hr class="address-line">
                                        </div>
                                    </div>
                                    <div class="my-account-content address-content">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="first-name">First Name <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-first-name" placeholder="Your First Name">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="last-name">Last Name <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-last-name" placeholder="Your Last Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="email">Email Address <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="phone-number">Phone Number <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-phone-number" placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="address">Address <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-new-address" placeholder="Your Address">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="zip-code">Zip Code <span class="error"> * Required</span></label>
                                                    <input type="text" class="form-control input-custom data-address-important" id="address-zip-code" placeholder="Your Zip Code">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 country-area">
                                                <div class="form-group form-group-custom ">
                                                    <label for="country">Country <span class="error"> * Required</span></label>
                                                    <select class="form-control input-custom data-address-important" id="country">
                                                        <option value="0">-- SELECT COUNTRY --</option>

                                                        <? foreach ($arr_country as $country): ?>
                                                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 indonesia-area">
                                                <div class="form-group form-group-custom">
                                                    <label for="province">Province <span class="error"> * Required</span></label>
                                                    <select class="form-control input-custom" id="province">
                                                        <option value="0">-- SELECT PROVINCE --</option>

                                                        <? foreach ($arr_province as $province): ?>
                                                            <option value="<?= $province->id; ?>"><?= $province->name; ?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row indonesia-area">
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="city">City <span class="error"> * Required</span></label>
                                                    <select class="form-control input-custom" id="city">
                                                        <option value="0">-- SELECT CITY --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group form-group-custom">
                                                    <label for="district">District <span class="error"> * Required</span></label>
                                                    <select class="form-control input-custom" id="district">
                                                        <option value="0">-- SELECT DISTRICT --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="address-line">
                                    <div class="my-account-content">
                                        <div class="row">
                                            <div class="col-xs-12 text-right">
                                                <button id="submit-address-button" class="btn btn-custom btn-full-mobile dark">SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <? foreach ($arr_address as $address): ?>
                                    <div id="address-<?= $address->id; ?>" class="tab-pane fade <? if ($key <= 0): ?>in active<? endif; ?>">
                                        <div class="my-account-content address-content">
                                            <p><?= $address->first_name; ?> <?= $address->last_name; ?></p>
                                            <p><?= $address->address; ?></p>
                                            <p><?= $address->district_name; ?>, <?= $address->city_name; ?></p>
                                            <p><?= $address->province_name; ?>, <?= $address->country_name; ?>, <?= $address->zip_code; ?></p>
                                            <p>Phone: <?= $address->phone; ?></p>
                                            <p>Email: <?= $address->email; ?></p>
                                        </div>
                                        <hr class="address-line">
                                        <div class="my-account-content">
                                            <div class="row">
                                                <? if ($lang == $setting->setting__system_language): ?>
                                                    <div class="col-xs-12 text-right">
                                                        <button id="delete-address-button" data-address-id="<?= $address->id; ?>" class="btn btn-custom small">DELETE</button>
                                                        <!-- <button class="btn btn-custom dark small">EDIT</button> -->
                                                    </div>
                                                <? else: ?>
                                                    <div class="col-xs-12 text-right">
                                                        <button id="delete-address-button" data-address-id="<?= $address->id; ?>" class="btn btn-custom small">HAPUS</button>
                                                        <!-- <button class="btn btn-custom dark small">EDIT</button> -->
                                                    </div>
                                                <? endif; ?>
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
    </section>

    <? $this->load->view('footer'); ?>
</body>

<? $this->load->view('js'); ?>

<script type="text/javascript">
    $(function() {
        resetAddress();
        clickAddress();
    });

    function clickAddress() {
        $('#city').change(function() {
            getDistrict();
        });

        $('#country').change(function() {
            if ($('#country').val() != 233) {
                $('.indonesia-area').hide();

                $('#province').val('0');
                $('#city').val('0').prop('disabled', true);
                $('#district').val('0').prop('disabled', true);
            }
            else {
                $('.indonesia-area').show();
            }
        });

        $('#delete-address-button').click(function() {
            deleteAddress();
        });

        $('#province').change(function() {
            getCity();
        });

        $('#submit-address-button').click(function() {
            submitAddress();
        });
    }

    function deleteAddress() {
        var addressId = $('#delete-address-button').attr('data-address-id');

        $.ajax({
            data :{
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.reload();
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_delete_address/'+ addressId +'/',
        });
    }

    function getCity() {
        var provinceId = $('#province').val();

        $('#city').prop('disabled', true);
        $('#city').empty();

        $('#district').val(0).prop('disabled', true);

        $.ajax({
            data :{
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    var cityList = '<option value="0">-- SELECT CITY --</option>';

                    $.each(data.arr_city, function(key, city) {
                        cityList += '<option value="'+ city.id +'">'+ city.name +'</option>';
                    });

                    $('#city').append(cityList);
                    $('#city').val('0').prop('disabled', false);
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_get_city/'+ provinceId +'/',
        });
    }

    function getDistrict() {
        var cityId = $('#city').val();

        $('#district').prop('disabled', true);
        $('#district').empty();

        $.ajax({
            data :{
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');
            },
            success: function(data){
                if (data.status == 'success') {
                    var districtList = '<option value="0">-- SELECT DISTRICT --</option>';

                    $.each(data.arr_district, function(key, district) {
                        districtList += '<option value="'+ district.id +'">'+ district.name +'</option>';
                    });

                    $('#district').append(districtList);
                    $('#district').val('0').prop('disabled', false);
                }
                else {
                    alert(data.message);
                }
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_get_district/'+ cityId +'/',
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    }

    function resetAddress() {
        $('.indonesia-area').show();

        $('.data-address-important').val("");

        $('#country').val('233');
        $('#province').val('0');
        $('#city').val('0').prop('disabled', true);
        $('#district').val('0').prop('disabled', true);
    }

    function submitAddress() {
        $('#submit-address-button').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span> Saving...</span>');

        $('.data-address-important, #province, #city, #district').prev().children().html(' * Required').hide();
        $('.data-address-important, #province, #city, #district').css('border', '1px solid #d9d9d9');

        var found = 0;
        var name = $('#address-name').val();
        var firstName = $('#address-first-name').val();
        var lastName = $('#address-last-name').val();
        var phone = $('#address-phone-number').val();
        var email = $('#address-email').val();
        var address = $('#address-new-address').val();
        var zipcode = $('#address-zip-code').val();

        var countryId = $('#country').val();
        var provinceId = $('#province').val();
        var cityId = $('#city').val();
        var districtId = $('#district').val();

        $.each($('.data-address-important'), function(key, address) {
            if ($(address).val() == '' || $(address).val() == 0) {
                found += 1;

                $(address).prev().children().html(' * Required').show();
                $(address).css('border', '1px solid red');
            }
        });

        /* check kalo country = indonesia */
        if (countryId == 233)  {
            if (provinceId <= 0) {
                found += 1;

                $('#province').prev().children().html(' * Required').show();
                $('#province').css('border', '1px solid red');
            }

            if (cityId <= 0) {
                found += 1;

                $('#city').prev().children().html(' * Required').show();
                $('#city').css('border', '1px solid red');
            }

            if (districtId <= 0) {
                found += 1;

                $('#district').prev().children().html(' * Required').show();
                $('#district').css('border', '1px solid red');
            }
        }

        if (found > 0) {
            $('#submit-address-button').html('SAVE');

            return;
        }

        /* submit address */
        $.ajax({
            data :{
                city_id: cityId,
                country_id: countryId,
                customer_id: '<?= $customer->id; ?>',
                district_id: districtId,
                province_id: provinceId,
                name: name,
                first_name: firstName,
                last_name: lastName,
                phone: phone,
                email: email,
                address: address,
                zip_code: zipcode,
                "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
            },
            dataType: 'JSON',
            error: function() {
                alert('Server Error');

                $('#submit-address-button').html('SAVE');
            },
            success: function(data){
                if (data.status == 'success') {
                    window.location.reload();
                }
                else {
                    alert(data.message);
                }

                $('#submit-address-button').html('SAVE');
            },
            type : 'POST',
            url : '<?= base_url(); ?>account/ajax_save_address/',
        });
    }
</script>

</html>
