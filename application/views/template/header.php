<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expense Voucher</title>

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
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/plugin/js/plugins/pickers/daterangepicker.js"></script> -->

	<!-- <script type="text/javascript" src="<?=base_url()?>assets/plugin/js/core/app.min.js"></script> -->

	<script type="text/javascript">
		var SITE_URL = "<?=site_url()?>";
    	var BASE_URL = "<?=base_url()?>";
	</script>

	<!-- custom -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/global.js"></script>
	<link href="<?=base_url()?>assets/css/main_layout.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?=base_url()?>assets/js/main_layout.js"></script>
</head>

<body>
<?php 
	if(isset($this->session->user_data)){
?>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-primary">
		<div class="navbar-header">
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile" class="collapsed" aria-expanded="false"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
		
		<div class="navbar-collapse collapse" id="navbar-mobile">
			
			<ul class="nav navbar-nav navbar-right">
				
				<li class="dropdown dropdown-user">
					
					<a class="dropdown-toggle" data-toggle="dropdown">
						<span style="font-size: 18px"><?=$this->session->user_data['first_name'] . " " . $this->session->user_data['last_name']?> [<?=$this->session->user_data['district']?>]</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a data-toggle="modal" data-target="#change_profile_modal"><i class="icon-profile"></i>Profile</a></li>
						<li><a href="<?=site_url()?>auth/logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>

				
			</ul>
		</div>
	</div>

<div id="change_profile_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Change Profile</h5>
			</div>

			<form action="#" class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-sm-3">Name: <span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" placeholder="firstname" class="form-control" id="m_firstname" value="<?=$this->session->user_data['first_name']?>">
						</div>
						<div class="col-sm-5">
							<input type="text" placeholder="lastname" class="form-control" id="m_lastname" value="<?=$this->session->user_data['last_name']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">District: <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" placeholder="district" class="form-control" id="m_district" value="<?=$this->session->user_data['district']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Email: </label>
						<div class="col-sm-9">
							<input type="text" placeholder="email" class="form-control" id="m_email" value="<?=$this->session->user_data['email']?>">
						</div>
					</div>
				</div>

				<div class="modal-footer text-center">
					<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="change_profile(<?=$this->session->user_data['id']?>)">Change <i class="icon-sync"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php }?>
