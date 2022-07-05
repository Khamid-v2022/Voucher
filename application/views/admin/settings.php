<script type="text/javascript" src="<?=base_url()?>assets/js/admin/settings.js"></script>

<!-- Content area -->
<div class="content">
	<!-- Main charts -->
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" action="#" id="setting_form">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Settings</h5>
					</div>

					<div class="panel-body">
						<fieldset>
							<legend class="text-semibold">
								<i class="icon-coins position-left"></i>
								Mileage Rate
								<a class="control-arrow" data-toggle="collapse" data-target="#rate">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>

							<div class="collapse in" id="rate">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Rate:</label>
											<div class="col-sm-9">
												<input type="number" class="form-control" placeholder="Mileage rate" step="any" value="<?=$settings['mileagerate']?>" required id="mileagerate">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Daily Limit:</label>
											<div class="col-sm-9">
												<input type="number" class="form-control" placeholder="Daliy Limit" value="<?=$settings['daily_limit']?>" required id="daily_limit">
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<legend class="text-semibold">
								<i class="icon-envelop3 position-left"></i>
								Payroll Email
								<a class="control-arrow" data-toggle="collapse" data-target="#email">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>

							<div class="collapse in" id="email">
	                			<div class="form-group">
									<label class="col-sm-3 control-label">Email:</label>
									<div class="col-sm-9">
	                                    <input type="email" class="form-control" placeholder="Email" value="<?=$settings['payrollemail']?>" required id="payrollemail">
                                    </div>
	                			</div>
                			</div>
						</fieldset>

						<fieldset>
							<legend class="text-semibold">
								<i class="icon-cup2 position-left"></i>
								Meals Reimbursement
								<a class="control-arrow" data-toggle="collapse" data-target="#meals">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>

							<div class="collapse in" id="meals">
	                			<div class="form-group">
									<label class="col-sm-3 control-label">Brakfast:</label>
									<div class="col-sm-9">
	                                    <input type="number" class="form-control" placeholder="Brakfast" step="any" value="<?=$settings['breakfast']?>" required id="breakfast">
                                    </div>
	                			</div>
	                			<div class="form-group">
									<label class="col-sm-3 control-label">Lunch:</label>
									<div class="col-sm-9">
	                                    <input type="number" class="form-control" placeholder="Lunch" step="any" value="<?=$settings['lunch']?>" required id="lunch">
                                    </div>
	                			</div>
	                			<div class="form-group">
									<label class="col-sm-3 control-label">Dinner:</label>
									<div class="col-sm-9">
	                                    <input type="number" class="form-control" placeholder="Dinner" step="any" value="<?=$settings['dinner']?>" required id="dinner">
                                    </div>
	                			</div>
                			</div>
						</fieldset>

						<fieldset>
							<legend class="text-semibold">
								<i class="icon-server position-left"></i>
								SMTP SETTINGS
								<a class="control-arrow" data-toggle="collapse" data-target="#smtp">
									<i class="icon-circle-down2"></i>
								</a>
							</legend>

							<div class="collapse in" id="smtp">
	                			<div class="form-group">
									<label class="col-sm-3 control-label">SMTP HOST:</label>
									<div class="col-sm-9">
	                                    <input type="text" class="form-control" placeholder="SMTP HOST" value="<?=$settings['smtp_server']?>" required id="smtp_server">
                                    </div>
	                			</div>
	                			<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Username:</label>
									<div class="col-sm-9">
	                                    <input type="text" class="form-control" placeholder="SMTP USER NAME" value="<?=$settings['smtp_userid']?>" required id="smtp_userid">
                                    </div>
	                			</div>
	                			<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Password:</label>
									<div class="col-sm-9">
	                                    <input type="text" class="form-control" placeholder="SMTP PASSWORD"  value="<?=$settings['smtp_pass']?>" required id="smtp_pass">
                                    </div>
	                			</div>
	                			<div class="form-group">
									<label class="col-sm-3 control-label">Sending Email:</label>
									<div class="col-sm-9">
	                                    <input type="text" class="form-control" placeholder="Sending Email"  value="<?=$settings['sending_email']?>" required id="sending_email">
                                    </div>
	                			</div>
                			</div>
						</fieldset>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Update <i class="icon-sync position-right"></i></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>