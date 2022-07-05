<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/tables/datatables/datatables.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/js/admin/supervisor_manage.js"></script>

<!-- Content area -->
<div class="content">
	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">
			<!-- Traffic sources -->
			<div class="panel panel-flat">

				<div class="panel-heading" style="padding-top: 40px">
					<div class="heading-elements">
						<button type="button" class="btn btn-primary" onclick="show_modal()"><i class="icon-add position-left"></i>Add Supervisor</button>
					</div>	
				</div>
				
				<table class="table datatable-ajax" id="data_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>District</th>
							<th>Email</th>
							<th>Action..</th>
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
				<form action="#" class="form-horizontal" id="m_supervisor_form">
					<div class="modal-body">
						<input type="hidden" value="0" id="m_supervisor_id">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label col-sm-5">Firstname: </label>
									<div class="col-sm-7">
										<input type="text" placeholder="Firstname" class="form-control" id="m_firstname" required>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label col-sm-5">Lastname: </label>
									<div class="col-sm-7">
										<input type="text" placeholder="Lastname" class="form-control" id="m_lastname" required>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Email: </label>
							<div class="col-sm-9">
								<input type="text" placeholder="Email" class="form-control" id="m_email" required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">District: </label>
							<div class="col-sm-9">
								<input type="number" placeholder="District" class="form-control" id="m_discrict" maxlength="5" required>
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