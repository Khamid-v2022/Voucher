$(function() { 
	$("#login_form").submit(function(event) {
	  	/* stop form from submitting normally */
	  	event.preventDefault();

	  	if (!event.target.checkValidity()) {
	    	return false;
	  	}
	  	login();
	});
});

function login(){
	$.post(SITE_URL + 'admin/login/sign_in', 
		{
			user_name: $("#user_name").val(),
			user_pass: $("#user_pass").val()
		}, 
		function(resp) {
			if(resp == "yes"){
				location.href = SITE_URL + 'admin/submittals';
				return;
			}else{
			}
		});
}
