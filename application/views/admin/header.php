<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expense Voucher Admin</title>

	<!-- Global stylesheets -->
	<link href="<?=base_url()?>assets/plugin/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/plugin/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/plugin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/plugin/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/plugin/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/plugin/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/plugin/js/core/app.min.js"></script>

	<script type="text/javascript">
		var SITE_URL = "<?=site_url()?>";
    	var BASE_URL = "<?=base_url()?>";
	</script>

	<!-- custom -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/global.js"></script>
	<link href="<?=base_url()?>assets/css/main_layout.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		$(function() {
			$('#change_password_modal').on('hidden.bs.modal', function() {
			    $(this).find('form').trigger('reset');
			});

			$('#change_profile_modal').on('hidden.bs.modal', function() {
			    $(this).find('form').trigger('reset');
			});
		});

		function change_admin_password(id){
			var old_pass = $("#old_pass").val();
			var new_pass = $("#new_pass").val();
			var confirm_pass = $("#confirm_pass").val();
			if(!old_pass){
				swal({
					title: "Please enter the currenct password",
		            text: "",
		            type: "warning"}, function(){
		            	setTimeout(function(){
		            		$("#old_pass").focus();
		            	}, 100);
		            });
				return;
			}

			if(!new_pass || !confirm_pass || new_pass != confirm_pass){
				swal({
					title: "Please check the inputed value",
		            text: "",
		            type: "warning"});
				return;
			}

			$.post(SITE_URL + 'admin/login/update_password', 
				{
					id: id,
					old_pass: old_pass,
					new_pass: new_pass
				}, 
				function(resp){
					if(resp=="yes"){
						swal({
							title: "Updated",
				            text: "",
				            type: "success"},function(){
				            	$('#change_password_modal').modal('toggle');
				        });
					}else{
						swal({
							title: "Please check your current password",
				            text: "",
				            type: "warning"});
						return;
					}
			});
		}


		function change_admin_profile(id){
			var user_name = $("#m_user_name").val();
			if(user_name == ""){
				swal({
					title: "Please enter the user name",
		            text: "",
		            type: "error"}, function(){
		            	setTimeout(function(){
		            		$("#m_user_name").focus();
		            	}, 100);
		            });
				return;
			}

			$.post(SITE_URL + 'admin/login/update_profile', 
				{
					id: id,
					user_name: user_name
				}, 
				function(resp){
					if(resp=="yes"){
						swal({
							title: "Updated",
				            text: "",
				            type: "success"},function(){
				            	location.reload();
				        });
					}else if(resp=="no"){
						swal({
							title: "Please enter the another name",
				            text: "",
				            type: "error"});
					}
			});
		}

	</script>
</head>

<body>

	<!-- change password modal -->
	<div id="change_password_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Password</h5>
				</div>

				<form action="#" class="form-horizontal">
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label class="control-label col-sm-3">Current password: </label>
							<div class="col-sm-9">
								<input type="password" placeholder="Please enter the current password" class="form-control" id="old_pass">
								<div class="form-control-feedback">
									<i class="icon-unlocked2 text-muted"></i>
								</div>
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="control-label col-sm-3">New password: </label>
							<div class="col-sm-9">
								<input type="password" placeholder="new password" class="form-control" id="new_pass">
								<div class="form-control-feedback">
									<i class="icon-lock text-muted"></i>
								</div>
							</div>
						</div>
						<div class="form-group has-feedback">
							<label class="control-label col-sm-3">Confirm password: </label>
							<div class="col-sm-9">
								<input type="password" placeholder="Confirm password" class="form-control" id="confirm_pass">
								<div class="form-control-feedback">
									<i class="icon-lock text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer text-center">
						<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" onclick="change_admin_password(<?=$this->session->admin_data['id']?>)">Change <i class="icon-sync"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="change_profile_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Profile</h5>
				</div>

				<form action="#" class="form-horizontal">
					<div class="modal-body">

						<div class="form-group has-feedback">
							<label class="control-label col-sm-3">User name: </label>
							<div class="col-sm-9">
								<input type="text" placeholder="username" class="form-control" id="m_user_name" value="<?=$this->session->admin_data['user_name']?>" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer text-center">
						<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" onclick="change_admin_profile(<?=$this->session->admin_data['id']?>)">Change <i class="icon-sync"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<?php if(isset($this->session->admin_data)) { ?>
		<!-- Main navbar -->
		<div class="navbar navbar-inverse navbar-primary">
			<div class="navbar-header">
				<ul class="nav navbar-nav pull-right visible-xs-block">
					<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				</ul>
			</div>
			
			<div class="navbar-collapse collapse" id="navbar-mobile">
				<?php if(isset($primary_menu)) {?>
					<ul class="nav navbar-nav">
						<li class="dropdown <?php if($primary_menu == 'Submittals') echo 'active'?>">
							<a href="<?=site_url()?>admin/Submittals">
								<i class="icon-file-text2"></i>
								<span class="position-right">Submittals</span>
							</a>
						</li>
						<li class="dropdown <?php if($primary_menu == 'Supervisors') echo 'active'?>">
							<a href="<?=site_url()?>admin/Supervisor_manage">
								<i class="icon-users4"></i>
								<span class="position-right">Supervisors</span>
							</a>
						</li>
						<li class="dropdown <?php if($primary_menu == 'Committees') echo 'active'?>">
							<a href="<?=site_url()?>admin/Committees_manage">
								<i class="icon-office"></i>
								<span class="position-right">Committees</span>
							</a>
						</li>
						<li class="dropdown <?php if($primary_menu == 'Hours Pay') echo 'active'?>">
							<a href="<?=site_url()?>admin/Hourspay_manage">
								<i class="icon-cash3"></i>
								<span class="position-right">Hours Pay</span>
							</a>
						</li>
						
						<li class="<?php if($primary_menu == 'Settings') echo 'active'?>">
							<a href="<?=site_url()?>admin/Settings">
								<i class="icon-cog3"></i>
								<span class="position-right">Settings</span>
							</a>
						</li>
					</ul>
				<?php }?>
				<ul class="nav navbar-nav navbar-right">						
					<li class="dropdown dropdown-user">					
						<a class="dropdown-toggle" data-toggle="dropdown">
							<span style="font-size: 18px"><?=$this->session->admin_data['user_name']?></span>
							<i class="caret"></i>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a data-toggle="modal" data-target="#change_profile_modal"><i class="icon-profile"></i> Profile</a></li>
							<li><a data-toggle="modal" data-target="#change_password_modal"><i class="icon-lock5"></i> Change password</a></li>
							<li><a href="<?=site_url()?>admin/login/sign_out"><i class="icon-switch2"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	<?php }?>
	
	<?php if(isset($this->session->admin_data) && isset($primary_menu)) {?>
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold"><?=$primary_menu?></span></h4>
						</div>

					</div>					
				</div>
				<!-- /page header -->
				<?php }?>


