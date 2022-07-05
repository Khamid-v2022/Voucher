<script type="text/javascript" src="<?=base_url()?>assets/js/login.js"></script>
<!-- Page container -->

<div class="page-container login-container">
	<!-- Page content -->
	<div class="page-content">
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

				<!-- Simple login form -->
				<form action="<?=site_url()?>auth/login" id="login_form" method="post" autocomplete="off">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
							<h5 class="content-group" style="font-size: 31px">Expense 
								<small class="display-block"><?php echo date("m/d/Y")?></small>
							</h5>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="first_name" autocomplete="off" autofill="off">
						</div>

						<div class="form-group">
							<input type="text" class="form-control"id="last_name" autocomplete="off" autofill="off">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="district" autocomplete="off" autofill="off">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Login <i class="icon-circle-right2 position-right"></i></button>
						</div>
					</div>
				</form>
				<!-- /simple login form -->
		
