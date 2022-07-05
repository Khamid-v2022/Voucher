<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/tables/datatables/datatables.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/js/admin/committees_manage.js"></script>

<!-- Content area -->
<div class="content">
	<!-- Main charts -->
	<div class="row">
		<div class="col-lg-12">
			<!-- Traffic sources -->
			<div class="panel panel-flat">

				<div class="panel-heading" style="padding-top: 40px">
					<div class="heading-elements">
						<button type="button" class="btn btn-primary" onclick="show_modal()"><i class="icon-add position-left"></i>Add Committee</button>
					</div>	
				</div>
				
				<table class="table datatable-ajax" id="data_table">
					<thead>
						<tr>
							<th>No</th>
							<th>Committee</th>
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
						<input type="hidden" value="0" id="m_committee_id">
						
						<div class="form-group">
							<label class="control-label col-sm-3">Committee: </label>
							<div class="col-sm-9">
								<input type="text" placeholder="Committee" class="form-control" id="m_committee" required>
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