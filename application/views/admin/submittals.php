<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/tables/datatables/datatables.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/js/admin/submittals.js"></script>

<style type="text/css">
	.daterangepicker .table-condensed tr>td, .daterangepicker .table-condensed tr>th {
		padding: 6px;
	}
	.daterangepicker th {
		min-width: 20px;
	}
	@media (max-width: 769px){
		.daterangepicker th {
			min-width: 20px;
		}
		.daterangepicker.opensleft .calendar, .daterangepicker.opensleft .calendars, .daterangepicker.opensleft .ranges, .daterangepicker.opensright .calendar, .daterangepicker.opensright .calendars, .daterangepicker.opensright .ranges, .opensleft .calendars, .opensright .calendars {
			float: left;
		}
		.daterangepicker .ranges {
			max-width: 150px;
		    width: unset; 
		}
		.daterangepicker .table-condensed tr>td, .daterangepicker .table-condensed tr>th {
			padding:  3px;
		}
	}

</style>

<!-- Content area -->
<div class="content">
	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">
			<!-- Traffic sources -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="form-group" style="margin-bottom: 0px;">
						<label>Date range: </label>
						<div class="input-group" style="max-width: 230px">
							<span class="input-group-addon"><i class="icon-calendar22"></i></span>
							<input type="text" class="form-control daterange-basic" value="<?=$from_date . ' - ' . $to_date ?>" id="date_range"> 
						</div>
					</div>
				</div>
				
				<table class="table datatable-ajax" id="data_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Supervisor</th>
							<th>Note</th>
							<th>Payperiod Total</th>
							<th>Is Corrected</th>
							<th>Initial</th>
						</tr>
					</thead>
					<tbody id="table_content">	
					</tbody>
				</table>
			</div>
			<!-- /traffic sources -->
		</div>
	</div>
	<!-- /main charts -->

	<div id="info_modal" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title" id="modal_title"></h5>
				</div>
				<div class="modal-body">
					<div class="col-lg-12">
						<fieldset>
							<legend class="text-semibold">
								<i class="icon-reading position-left"></i>
								Committee Meetings
							</legend>									
							
							<div class="table-wrap">
								<table class="table table-xs table-bordered table-striped mt-10">
									<thead>
										<tr class="success">
											<th class="text-center">Committee Meeting</th>
											<th class="text-center">Date</th>
											<th class="text-center">Hours</th>
											<th class="text-center">Miles</th>
											<th class="text-center">HoursPay</th>
											<th class="text-center">MileagePay</th>
											<th class="text-center">TotalPay</th>
										</tr>
									</thead>
									<tbody id="m_committee_table_container">	
										
									</tbody>
									<tfoot>
										<tr class="info">
											<td colspan="6" class="text-center">Totals</td>
											<td class="text-right" id="m_committee_total"></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</fieldset>

						<fieldset class="mt-10">
							<!-- Event sources -->
							<legend class="text-semibold">
								<i class="icon-calendar position-left"></i>
								Events
							</legend>									
							
							<div class="table-wrap">
								<table class="table table-xs table-bordered table-striped event-table mt-10">
									<thead>
										<tr class="success">
											<th class="text-center">Event</th>
											<th class="text-center">Date</th>
											<th class="text-center">Breakfast</th>
											<th class="text-center">Lunch</th>
											<th class="text-center">Dinner</th>
											<th class="text-center">Other Amount</th>
											<th class="text-center">TotalPay</th>
										</tr>
									</thead>
									<tbody id="m_event_table_container">	
										
									</tbody>
									<tfoot>
										<tr class="info">
											<td colspan="6" class="text-center">Totals</td>
											<td class="text-right" id="m_event_total"></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<!-- /Event sources -->
							<div class="table-wrap">
								<table class="table table-bordered mt-10 mb-20">
									<tr class="danger">
										<th class="text-center" width="80%"><b>Pay Period Total</b></th>
										<th class="text-right" width="20%"><b id="m_total"></b></th>
									</tr>
								</table>
							</div>

						</fieldset>
						<fieldset>
							<div class="form-group mb-20">
								<label class="control-label col-sm-4">Notes/Explanations: </label>
								<div class="col-sm-8">
									<textarea rows="3" id="m_note" maxlength="254" class="form-control" readonly></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-6" style="margin-top:10px">This is a correction of a previously submitted form</label>
								<div class="col-sm-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" class="styled" id="m_is_corrected">
											Corrected
										</label>
									</div>
								</div>
							</div>
							<div class="row mb-20">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label col-sm-5" >Initials:</label>
										<div class="col-sm-6">
											<input type="text" maxlength="3" minlength="2" required class="form-control" id="m_initial" readonly>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label col-sm-5" >Date:</label>
										<div class="col-sm-6">
											<input type="text" value="" readonly class="form-control" id="m_submit_date">
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>