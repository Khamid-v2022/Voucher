$(function() { 
	$("#setting_form").submit(function(event) {
	  	/* stop form from submitting normally */
	  	event.preventDefault();

	  	if (!event.target.checkValidity()) {
	    	return false;
	  	}
	  	update_setting();
	});
});

function update_setting(){
	swal({
        title: "Are you sure?",
        text: "Do you want to update?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false
    },
    function() {
		$.post(SITE_URL + 'admin/settings/update_setting', 
			{
				mileagerate: $("#mileagerate").val(),
				daily_limit: $("#daily_limit").val(),
				payrollemail: $("#payrollemail").val(),
				breakfast: $("#breakfast").val(),
				lunch: $("#lunch").val(),
				dinner: $("#dinner").val(),
				smtp_server: $("#smtp_server").val(),
				smtp_userid: $("#smtp_userid").val(),
				smtp_pass: $("#smtp_pass").val(),
				sending_email: $("#sending_email").val()
			}, 
			function(resp) {
				resp = JSON.parse(resp)
				if(resp.status){
					swal({
			            title: "Updated!",
			            type: "success",
			            confirmButtonColor: "#2196F3"
			        });
				}
			});
	});
}

