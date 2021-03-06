	<style type="text/css">
	</style>

	<script type="text/javascript">
		$(function() {
			init();
			reset();
			change();
		});

		function change() {
			$('#report-product-search, #report-location-search').change(function() {
				filter();
			});
		}

		function exportExcel() {
			var month = $('#report-month-search').val();
			var year = $('#report-year-search').val();

			var locationId = $('#report-location-search').val();
			var productId = $('#report-product-search').val();

			window.location.href = '<?= base_url(); ?>report/export_purchase/'+ month +'/'+ year +'/';
		}

		function filter() {
			var month = $('#report-month-search').val();
			var year = $('#report-year-search').val();

			var locationId = $('#report-location-search').val();
			var productId = $('#report-product-search').val();

			window.location.href = '<?= base_url(); ?>report/report_purchase/'+ month +'/'+ year +'/';
		}

		function init() {
			$('.dropdown-search, .dropdown-filter').dropdown({
				allowAdditions: true
			});

			$('.ui.search.dropdown.form-input').dropdown('clear');

			$('.item-filter-button').popup({
				inline: true,
				hoverable: true,
				position : 'bottom left',
				on: 'click',
			});
		}

		function reset() {
			$('#report-month-search').val("<?= $month; ?>");
			$('#report-month-search-container').dropdown('set selected', "<?= $month; ?>");

			$('#report-year-search').val("<?= $year; ?>");
			$('#report-year-search-container').dropdown('set selected', "<?= $year; ?>");
		}
	</script>

	<!-- Dashboard Here -->
	<div class="main-content">
		<div class="ui top attached menu table-menu">
			<div class="item">
				Report Purchase
			</div>
			<div class="right menu">
				<a class="item item-add-button item-export-button" onclick="exportExcel();">
					<i class="file excel icon"></i> Export
				</a>
				<div class="ui right aligned report search item search-item-container">
					<div id="report-month-search-container" class="ui search selection dropdown form-input">
						<input id="report-month-search" type="hidden">
						<i class="dropdown icon"></i>
						<div class="default text">-- Select Month --</div>
						<div class="menu">
							<div class="item" data-value="01">January</div>
							<div class="item" data-value="02">February</div>
							<div class="item" data-value="03">March</div>
							<div class="item" data-value="04">April</div>
							<div class="item" data-value="05">May</div>
							<div class="item" data-value="06">June</div>
							<div class="item" data-value="07">July</div>
							<div class="item" data-value="08">August</div>
							<div class="item" data-value="09">September</div>
							<div class="item" data-value="10">October</div>
							<div class="item" data-value="11">November</div>
							<div class="item" data-value="12">December</div>
						</div>
					</div>
				</div>

				<div class="ui right aligned report search item search-item-container">
					<div id="report-year-search-container" class="ui search selection dropdown form-input">
						<input id="report-year-search" type="hidden">
						<i class="dropdown icon"></i>
						<div class="default text">-- Select Year --</div>
						<div class="menu">
							<? for ($i = $setting->setting__webshop_default_year; $i <= date('Y', time()); $i++): ?>
								<div class="item" data-value="<?= $i; ?>"><?= $i; ?></div>
							<? endfor; ?>
						</div>
					</div>
					<button id="report-filter" class="ui button form-button" onclick="filter();">Filter</button>
				</div>
			</div>
		</div>
		<div class="ui bottom attached segment table-segment">
			<table class="ui striped selectable celled table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Number</th>
						<th>Payment Method</th>
						<th class="align-right">Total</th>
						<th>Status</th>
						<th>Location</th>
						<th>Vendor</th>
					</tr>
				</thead>
				<tbody>
					<? if (count($arr_result) <= 0): ?>
						<tr>
							<td colspan="7">No Result Founds</td>
						</tr>
					<? else: ?>
						<? foreach ($arr_result as $result): ?>
							<tr>
								<td><?= $result->date_display; ?></td>
								<td><?= $result->number; ?></td>
								<td><?= $result->type; ?></td>
								<td class="align-right">Rp <?= $result->total_display; ?></td>
								<td><?= $result->status; ?></td>
								<td><?= $result->location_name; ?></td>
								<td><?= $result->vendor_name; ?></td>
							</tr>
						<? endforeach; ?>
					<? endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>