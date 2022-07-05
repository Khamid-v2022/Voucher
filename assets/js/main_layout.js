$(function() {
	// input field init when close modal
	$('#change_password_modal').on('hidden.bs.modal', function() {
	    $(this).find('form').trigger('reset');
	});

	$('#change_profile_modal').on('hidden.bs.modal', function() {
	    $(this).find('form').trigger('reset');
	});
});

function change_profile(id){
	var firstname = $("#m_firstname").val();
	if(!firstname){
		swal({
			title: "Please enter the firstname",
            text: "",
            type: "warning"}, function(){
            	setTimeout(function(){
					$('#m_firstname').focus();
            	}, 100);
            });
		return;
	}

	var lastname = $("#m_lastname").val();
	if(!lastname){
		swal({
			title: "Please enter the lastname",
            text: "",
            type: "warning"}, function(){
            	setTimeout(function(){
					$('#m_lastname').focus();
            	}, 100);
            });
		return;
	}
	var district = $("#m_district").val();
	if(!district){
		swal({
			title: "Please enter the district",
            text: "",
            type: "warning"}, function(){
            	setTimeout(function(){
					$('#m_district').focus();
            	}, 100);
            });
		return;
	}

	if(district != parseInt(district)){
		swal({
			title: "Please enter the valid district",
            text: "",
            type: "warning"}, function(){
            	setTimeout(function(){
					$('#m_district').focus();
            	}, 100);
            });
		return;
	}

	$.post(SITE_URL + 'auth/update_profile', 
		{
			id: id,
			first_name: firstname,
			last_name: lastname,
			district: district,
			email: $("#m_email").val()
		}, 
		function(resp){
			if(resp=="yes"){
				swal({
					title: "Updated.",
		            text: "",
		            type: "success"},function(){
		            	location.reload();
		        });
			}else if(resp=="no"){
				swal({
					title: "please enter the anothe name.",
		            text: "This name is already in use by someone else.",
		            type: "error"});
			}
	});
}