	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			click();
			init();
			reset();
		});

		function click() {
			$('#form-back').click(function() {
				window.location.href = '<?= base_url(); ?>';
			});

			$('#form-submit').click(function() {
				submit();
			});
		}

		function init() {
			$('.ui.search.dropdown.form-input').dropdown('clear');
		}

		function reset() {
			$('#setting-website-enable-subscribe-container').dropdown('set selected', "<?= $setting->setting__website_enabled_subscribe; ?>");
			$('#setting-promo-text').val("<?= $setting->setting__website_promo_text; ?>");

			$('#setting-promo-container').dropdown('set selected', "<?= $setting->setting__webshop_promo; ?>");

			$('#setting-promo-value').val("<?= $setting->setting__webshop_promo_value; ?>");
			$('#setting-promo-count-sale').val("<?= $setting->setting__webshop_promo_count_sale; ?>");
			$('#setting-registration-promo-value').val("<?= $setting->setting__webshop_registration_promo; ?>");

			$('#setting-email-sent-to').val("<?= $setting->system_email_send_to; ?>");
			$('#setting-email-sent-cc').val("<?= $setting->system_email_send_cc; ?>");

			$('#setting-email-sent2-to').val("<?= $setting->system_email_send2_to; ?>");
			$('#setting-email-sent2-cc').val("<?= $setting->system_email_send2_cc; ?>");

			$('#setting-email-sent3-to').val("<?= $setting->system_email_send3_to; ?>");
			$('#setting-email-sent3-cc').val("<?= $setting->system_email_send3_cc; ?>");

			$('#setting-email-sent4-to').val("<?= $setting->system_email_send4_to; ?>");
			$('#setting-email-sent4-cc').val("<?= $setting->system_email_send4_cc; ?>");

			$('#setting-email-sent5-to').val("<?= $setting->system_email_send5_to; ?>");
			$('#setting-email-sent5-cc').val("<?= $setting->system_email_send5_cc; ?>");

			$('#setting-email-sent6-to').val("<?= $setting->system_email_send6_to; ?>");
			$('#setting-email-sent6-cc').val("<?= $setting->system_email_send6_cc; ?>");
		}

		function submit() {
			$('.ui.text.loader').html('Connecting to Database...');
			$('.ui.dimmer.all-loader').dimmer('show');

			var settingEnableSubscribe = $('#setting-website-enable-subscribe-container').val();
			var settingPromoText = $('#setting-promo-text').val();

			var emailSentTo = $('#setting-email-sent-to').val();
			var emailSentCC = $('#setting-email-sent-cc').val();

			var emailSent2To = $('#setting-email-sent2-to').val();
			var emailSent2CC = $('#setting-email-sent2-cc').val();

			var emailSent3To = $('#setting-email-sent3-to').val();
			var emailSent3CC = $('#setting-email-sent3-cc').val();

			var emailSent4To = $('#setting-email-sent4-to').val();
			var emailSent4CC = $('#setting-email-sent4-cc').val();

			var emailSent5To = $('#setting-email-sent5-to').val();
			var emailSent5CC = $('#setting-email-sent5-cc').val();

			var emailSent6To = $('#setting-email-sent6-to').val();
			var emailSent6CC = $('#setting-email-sent6-cc').val();

			$.ajax({
				data :{
					setting__website_enabled_subscribe: settingEnableSubscribe,
					setting__website_promo_text: settingPromoText,
					system_email_send_to: emailSentTo,
					system_email_send_cc: emailSentCC,
					system_email_send2_to: emailSent2To,
					system_email_send2_cc: emailSent2CC,
					system_email_send3_to: emailSent3To,
					system_email_send3_cc: emailSent3CC,
					system_email_send4_to: emailSent4To,
					system_email_send4_cc: emailSent4CC,
					system_email_send5_to: emailSent5To,
					system_email_send5_cc: emailSent5CC,
					system_email_send6_to: emailSent6To,
					system_email_send6_cc: emailSent6CC,
					"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
				},
				dataType: 'JSON',
				error: function() {
					$('.ui.dimmer.all-loader').dimmer('hide');
					$('.ui.basic.modal.all-error').modal('show');
					$('.all-error-text').html('Server Error.');
				},
				success: function(data){
					if (data.status == 'success') {
						$('.ui.text.loader').html('Refreshing your page...');

						window.location.reload();
					}
					else {
						$('.ui.dimmer.all-loader').dimmer('hide');
						$('.ui.basic.modal.all-error').modal('show');
						$('.all-error-text').html(data.message);
					}
				},
				type : 'POST',
				url : '<?= base_url() ?>setting/ajax_update/',
				xhr: function() {
					var percentage = 0;
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Checking Data..');
					}, false);

					xhr.addEventListener('progress', function(evt) {
						$('.ui.text.loader').html('Updating Database...');
					}, false);

					return xhr;
				},
			});
		}
	</script>

	<!-- Dashboard Here -->
	<div class="main-content">
		<div class="ui stackable one column centered grid">
			<div class="column">
				<div class="ui attached message setting-header">
					<div class="header">System Settings</div>
				</div>
				<div class="form-content">
					<div class="ui form">
						<h4 class="ui dividing header">Website Settings</h4>
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Enabled Subscribe Popup</label>
									<div id="setting-website-enable-subscribe-container" class="ui search selection dropdown form-input">
										<input id="setting-website-enable-subscribe-container" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Enabled Subscribe --</div>
										<div class="menu">
											<div class="item" data-value="1">Enabled</div>
											<div class="item" data-value="0">Disabled</div>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Promo Text</label>
									<input id="setting-promo-text" class="form-input" placeholder="Promo Text.." type="text">
								</div>
							</div>
						</div>

						<h4 class="ui dividing header">Promo Setting</h4>
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Promo</label>
									<div id="setting-promo-container" class="ui search selection dropdown form-input">
										<input id="setting-promo" type="hidden">
										<i class="dropdown icon"></i>
										<div class="default text">-- Promo --</div>
										<div class="menu">
											<div class="item" data-value="None">None</div>
											<div class="item" data-value="Free Shipping">Free Shipping</div>
											<div class="item" data-value="Discount">Discount</div>
											<div class="item" data-value="Price">Price</div>
										</div>
									</div>
								</div>
								<div class="field">
									<label>Promo Value</label>
									<input id="setting-promo-value" class="form-input" placeholder="Promo value.." type="text">
								</div>
							</div>

							<div class="two fields">
								<div class="field">
									<label>Promo Count Sale</label>
									<input id="setting-promo-count-sale" class="form-input" placeholder="Promo Count Sale.." type="text">
								</div>
								<div class="field">
									<label>Registration Promo Value</label>
									<input id="setting-registration-promo-value" class="form-input" placeholder="Registration Promo Value.." type="text">
								</div>
							</div>
						</div>

						<h4 class="ui dividing header">Enquiry Email Settings</h4>
						<!-- Customer Care -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Customer Care Email Sent To</label>
									<input id="setting-email-sent-to" class="form-input" placeholder="Customer Care Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Customer Care Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent-cc" class="form-input" placeholder="Customer Care Email Sent CC.." type="text">
								</div>
							</div>
						</div>

						<!-- Private Concierge -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Private Concierge Email Sent To</label>
									<input id="setting-email-sent2-to" class="form-input" placeholder="Private Concierge Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Private Concierge Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent2-cc" class="form-input" placeholder="Private Concierge Email Sent CC.." type="text">
								</div>
							</div>
						</div>

						<!-- Press and Media -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Press and Media Email Sent To</label>
									<input id="setting-email-sent3-to" class="form-input" placeholder="Press and Media Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Press and Media Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent3-cc" class="form-input" placeholder="Press and Media Email Sent CC.." type="text">
								</div>
							</div>
						</div>

						<!-- Collaborations or Contributors -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Collaborations or Contributors Email Sent To</label>
									<input id="setting-email-sent4-to" class="form-input" placeholder="Collaborations or Contributors Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Collaborations or Contributors Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent4-cc" class="form-input" placeholder="Collaborations or Contributors Email Sent CC.." type="text">
								</div>
							</div>
						</div>

						<!-- Feedback & Suggestions -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Feedback & Suggestions Email Sent To</label>
									<input id="setting-email-sent5-to" class="form-input" placeholder="Feedback & Suggestions Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Feedback & Suggestions Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent5-cc" class="form-input" placeholder="Feedback & Suggestions Email Sent CC.." type="text">
								</div>
							</div>
						</div>

						<!-- Appointment -->
						<div class="field">
							<div class="two fields">
								<div class="field">
									<label>Appointment Email Sent To</label>
									<input id="setting-email-sent6-to" class="form-input" placeholder="Appointment Email Sent To.." type="text">
								</div>
								<div class="field">
									<label>Appointment Email Sent CC (separated by ';')</label>
									<input id="setting-email-sent6-cc" class="form-input" placeholder="Appointment Email Sent CC.." type="text">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ui bottom attached message text-right setting-header">
					<div class="ui buttons">
						<button id="form-back" class="ui left attached button form-button">Back</button>
						<button id="form-submit" class="ui right attached button form-button">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>