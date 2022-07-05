<script type="text/javascript" src="<?=base_url()?>assets/js/voucher.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/pickers/daterangepicker.js"></script>
<style type="text/css">
	table .btn.btn-rounded {
		margin-left: 10px;
	}
	
	.table-wrap {
		overflow-x: auto;
	}

	legend .control-arrow {
		color: #fff;
	}

</style>

<div class="page-container">
	<div class="page-content">
		<div class="content-wrapper">
			<div class="page-header page-header-default">
				<div class="page-header-content">
					<div class="page-title">
						<h4>Sawyer County Board of Supervisors Expense Voucher</h4>
					</div>
					<div class="heading-elements">
						<div class="heading-btn-group">
							<form action="<?=site_url()?>voucher" id="history_log_date_form" method="post">
								<input type="hidden" id="today" value="<?=$today?>">
								<div style="display: inline-flex;">
									<div class="input-group" style="width: 150px" >
										<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										<input type="text" class="form-control select-date" id="sel_date" name="sel_date" value="<?=$sel_date?>">
									</div>
									<button type="button" class="btn btn-primary" onclick="goto_today()">today</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-lg-12">
						<input type="hidden" id="ticket_id" value="<?=empty($ticket_info) ? 0 : $ticket_info['id'] ?>">
						<input type="hidden" id="is_submitted" value="<?=empty($ticket_info) ? 0 : ($ticket_info['is_submited']=='n'?0:1) ?>">
						<input type="hidden" id="is_today" value="<?=$is_today?>">
                        <input type="hidden" id="dates" value='<?=json_encode($submitted_dates)?>'>

						<div class="panel panel-flat">

							<div class="panel-body">
								<?php 
								if(!empty($ticket_info) && $ticket_info['is_submited'] == 'y') {
								?>
								<div class="row">
									<div class="form-group">
										<label class="control-label col-sm-6" style="margin-top:10px">This is a correction of a previously submitted form</label>
										<div class="col-sm-6">
											<div class="checkbox">
												<label>
													<input type="checkbox" class="styled" id="is_corrected" <?=!empty($ticket_info)?$ticket_info['is_corrected']=='y' ? "checked='checked'" : "" : ""?>>
													Corrected
												</label>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
								<!-- Commiittee meeting sources -->
								<fieldset>
									<legend class="text-semibold">
										<i class="icon-reading position-left"></i>
										Committee Meetings
										<?php if($is_editable == 'y' && count($meeting_list) <= 50){ ?>
										
											<a class="control-arrow btn btn-primary" data-toggle="modal" data-target="#add_committee_modal"><i class="icon-plus3 mr-5" ></i>Add Committee Meeting</a>
												
										<?php }?>
									</legend>		

									<?php 
									$is_message = false;
									foreach($meeting_list as $item){
										if($item['hourspay_more'] > 0){
											$is_message = true;
											break;
										}
									}
									if($is_message) { ?>
										<div class="alert text-violet-800 alpha-violet border-0 alert-reduce">
											<span class="font-weight-semibold"><span class="text-danger">*</span> (Asterisk) indicates payment reduced . $<?=$setting['daily_limit']?> is daily cap.</span>
									    </div>
									<?php }
									?>
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
													<?php if($is_editable == 'y'){ ?>
														<th class="text-center">Actions</th>
													<?php }?>
												</tr>
											</thead>
											<tbody>	
												<?php 
												$hourspay_total = 0;
												$mileagepay_total = 0;
												$totalpay_total = 0;
												if(count($meeting_list) > 0){
													foreach($meeting_list as $item){
														$hourspay_total += $item['hourspay'];
														$mileagepay_total += $item['mileagepay'];
														$totalpay_total += $item['totalpay'];
														echo '<tr committee_meeting_id="' . $item['id'] . '">';
															echo '<td>' . $item['committee'] . '</td>';
															echo '<td class="text-center">' . $item['date'] . '</td>';
															echo '<td class="text-right">' . $item['hours'] . '</td>';
															echo '<td class="text-right">' . number_format($item['miles']) . '</td>';
															if($item['hourspay_more'] > 0){
																echo '<td class="text-right" title="' . $item['hourspay_more'] . '">' . number_format($item['hourspay']) . '&nbsp&nbsp<span class="text-danger">*</span></td>';
															}else{
																echo '<td class="text-right">' . number_format($item['hourspay']) . '</td>';
															}
															
															echo '<td class="text-right">' . number_format($item['mileagepay'], 2) . '</td>';
															echo '<td class="text-right">' . number_format($item['totalpay'], 2) . '</td>';
															if($is_editable == 'y'){
																echo '<td class="text-center">';
																	echo '<button type="button" class="btn border-slate text-slate btn-flat btn-icon btn-rounded meeting_edit_btn" title="edit"><i class="icon-pencil5"></i></button>';
																	echo '<button type="button" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded meeting_delete_btn" title="delete"><i class="icon-trash-alt"></i></button>';
																echo '</td>';
															}
														echo '</tr>';
													}
												} else {
													echo '<tr><td colspan="';
													if($is_editable == 'y')
														echo '8';
													else
														echo '7';
													echo '" class="text-center">No records</td></tr>';
												}
												?>
											</tbody>
											<?php 
											if(count($meeting_list) > 0){
											?>
											<tfoot>
												<tr class="info">
													<td colspan="4" class="text-center">Totals</td>
													<td class="text-right"><?=number_format($hourspay_total)?></td>
													<td class="text-right"><?=number_format($mileagepay_total, 2)?></td>
													<td class="text-right"><?=number_format($totalpay_total, 2)?></td>
													<?php if($is_editable == 'y'){ ?>
														<td></td>
													<?php }?>
												</tr>
											</tfoot>
											<?php }?>
										</table>
									</div>
									<!-- /Commiittee meeting  sources -->
								</fieldset>
								<fieldset class="mt-10">
									<!-- Event sources -->
									<legend class="text-semibold">
										<i class="icon-calendar position-left"></i>
										Meal Reimbursement
										<?php if($is_editable == 'y' && count($meeting_list) <= 14){ ?>
											
											<a class="control-arrow btn btn-info" data-toggle="modal" data-target="#add_event_modal"><i class="icon-plus3 mr-5" ></i>Add Event</a>	
										<?php }?>
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
													<?php if($is_editable == 'y'){ ?>
														<th class="text-center">Actions</th>
													<?php }?>
												</tr>
											</thead>
											<tbody>	
												<?php 
												$totalpay_total_event = 0;
												if(count($event_list) > 0){
													foreach($event_list as $item){
														$totalpay_total_event += $item['totalpay'];
														echo '<tr event_id="' . $item['id'] . '">';
															echo '<td>' . $item['event_name'] . '</td>';
															echo '<td class="text-center">' . $item['formated_date'] . '</td>';
															echo '<td class="text-center">';
																echo '<input type="checkbox" ';
																echo $item['breakfast']=="y"?'checked':''; 
																echo ' disabled>';
															echo '</td>';
															echo '<td class="text-center">';
																echo '<input type="checkbox" ';
																echo $item['lunch']=="y"?'checked':''; 
																echo ' disabled>';
															echo '</td>';
															echo '<td class="text-center">';
																echo '<input type="checkbox" ';
																echo $item['dinner']=="y"?'checked':''; 
																echo ' disabled>';
															echo '</td>';
															
															echo '<td class="text-right">' . number_format($item['other_amount'], 2) . '</td>';
															echo '<td class="text-right">' . number_format($item['totalpay'], 2) . '</td>';
															if($is_editable == 'y'){
																echo '<td class="text-center">';
																	echo '<button type="button" class="btn border-slate text-slate btn-flat btn-icon btn-rounded event_edit_btn" title="edit"><i class="icon-pencil5"></i></button>';
																	echo '<button type="button" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded event_delete_btn" title="delete"><i class="icon-trash-alt"></i></button>';
																echo '</td>';
															}
														echo '</tr>';
													}
												}else{
													echo '<tr><td colspan="';
													if($is_editable == 'y')
														echo '8';
													else
														echo '7';
													echo '" class="text-center">No records</td></tr>';
												}
												?>
											</tbody>
											<?php if(count($event_list) > 0){ ?>
											<tfoot>
												<tr class="info">
													<td colspan="6" class="text-center">Totals</td>
													<td class="text-right"><?=number_format($totalpay_total_event, 2)?></td>
													<?php if($is_editable == 'y'){ ?>
														<td></td>
													<?php }?>
												</tr>
											</tfoot>
											<?php }?>
										</table>
									</div>
									<!-- /Event sources -->
									<div class="table-wrap">
										<table class="table table-bordered mt-10 mb-20">
											<tr class="danger">
												<th class="text-center" width="80%"><b>Pay Period Total</b></th>
												<th class="text-right" width="20%"><b><?=number_format($totalpay_total + $totalpay_total_event, 2)?></b></th>
											</tr>
										</table>
									</div>

								</fieldset>
								<form action="#" id="document_form">
									<fieldset>
										<input type="hidden" id="total_pay" value="<?=$totalpay_total + $totalpay_total_event?>">
										<div class="row">
											<div class="form-group mb-20">
												<label class="control-label col-sm-4">Notes/Explanations: </label>
												<div class="col-sm-8">
													<textarea rows="3" id="note" maxlength="254" class="form-control"><?=!empty($ticket_info)?$ticket_info['note']:""?></textarea>
												</div>
											</div>
										</div>

										<div class="row mb-20 mt-20">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label col-sm-5" >Initials:</label>
													<div class="col-sm-6">
														<input type="text" maxlength="3" minlength="2" required class="form-control" id="initial" value="<?=!empty($ticket_info)?$ticket_info['initial']:''?>">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label col-sm-5" >Date:</label>
													<div class="col-sm-6">
														<input type="text" value="<?=$today?>" readonly class="form-control" id="submit_date">
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<div class="text-right">
										<?php 
										if($is_editable == 'y') { ?>
											<button type="submit" class="btn btn-danger"><i class="icon-file-upload position-left"></i>Submit</button>
										<?php }?>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>


<!-- add update committee meeting modal -->
<div id="add_committee_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Add Committee Meeting</h5>
			</div>
			<form action="#" class="form-horizontal" id="committee_modal_form">
				<input type="hidden" value="0" id="m_edited_meeting_id">
				<div class="modal-body">
					<h6><b>If meeting attended is not in this list, please select "Per Diem"</b></h6>
					<div class="form-group">
						<label class="control-label col-sm-3">Committee Meeting: </label>
						<div class="col-sm-9">
							<select data-placeholder="Committee Meeting" class="form-control simple-select" data-fouc name="m_committee" id="m_committee">
                    			<?php 
                    			foreach($committees as $item){
                    				echo '<option value="' . $item['id'] . '">' . $item['committee'] . '</option>';
                    			}
                    			?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Date: </label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-calendar22"></i></span>
								<input type="text" class="form-control daterange-single" id="m_committee_date" name="m_committee_date" value="<?=$sel_date?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label col-sm-6">Hours: </label>
								<div class="col-sm-6">
									<input type="number" class="form-control" id="m_committee_hours" name="m_committee_hours" min="1" max="24" required>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label col-sm-6">Miles: </label>
								<div class="col-sm-6">
									<input type="number" class="form-control" id="m_committee_miles" name="m_committee_miles" min="0" max="5000">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" id="m_submit_btn" class="btn btn-success">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- add update Event modal -->
<div id="add_event_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Add Event</h5>
			</div>
			<form action="#" class="form-horizontal" id="event_modal_form">
				<input type="hidden" value="0" id="m_event_id">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-3">Event: </label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="m_event_name" name="m_event_name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Date: </label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-calendar22"></i></span>
								<input type="text" class="form-control daterange-single" id="m_event_date" name="m_event_date" value="<?=$sel_date?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Breakfast: </label>
						<div class="col-sm-9">
							<input type="checkbox" id="m_breakfast" name="m_breakfast">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Lunch: </label>
						<div class="col-sm-9">
							<input type="checkbox" id="m_lunch" name="m_lunch">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Dinner: </label>
						<div class="col-sm-9">
							<input type="checkbox" id="m_dinner" name="m_dinner">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Other Amount: </label>
						<div class="col-sm-9">
							<input type="number" class="form-control" id="m_other_amount" name="m_other_amount" step="any" max="9999.99" min="0">
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" id="m_event_submit_btn" class="btn btn-success">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
