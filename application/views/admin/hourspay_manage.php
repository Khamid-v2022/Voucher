<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/admin/hourspay_manage.js"></script>

<!-- Content area -->
<div class="content">
	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">
			<!-- Traffic sources -->
			<div class="panel panel-flat">

				<div class="panel-heading" style="padding-top: 40px">
					<div class="heading-elements">
						
					</div>	
				</div>
				
				<table class="table datatable-ajax" id="data_table">
					<thead>
						<tr>
							<th>Hours</th>
							<th>Pay</th>
							<th>Action</th>
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
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title" id="modal_title"></h5>
				</div>
				<form action="#" class="form-horizontal" id="m_form">
					<div class="modal-body">
						<input type="hidden" value="0" id="m_hours">
						<div class="form-group">
							<label class="control-label col-sm-3">Hours: </label>
							<div class="col-sm-9">
								<input type="text" placeholder="Hour" class="form-control" id="m_hour" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Pay: </label>
							<div class="col-sm-9">
								<input type="number" placeholder="pay" class="form-control" id="m_pay" required max="1000" min="0">
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>