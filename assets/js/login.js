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
	if(!$("#first_name").val() || $('#first_name').val() == ""){	
		return;
	}
	if(!$("#last_name").val() || $('#last_name').val() == ""){
		return;
	}
	if(!$("#district").val() || $('#district').val() == ""){
		return;
	}

	$.post(SITE_URL + 'auth/login', 
		{
			first_name: $("#first_name").val(),
			last_name: $("#last_name").val(),
			district: $("#district").val()
		}, 
		function(resp) {
			if(resp == "yes"){
				location.href = SITE_URL + 'voucher';
				return;
			}else{
				// swal({
				// 	title: "incorrect",
				// 	text: "",
				// 	type: "warning"});
			}
		});
}
