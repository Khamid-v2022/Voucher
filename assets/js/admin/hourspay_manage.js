var table = null;
$(function() { 
	$('#info_modal').on('hidden.bs.modal', function() {
	    $(this).find('form').trigger('reset');
	});

	$.extend( $.fn.dataTable.defaults, {
        autoWidth: true,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 2 ]
        }, {
        	width: '100px',
        	targets: [0]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Search:</span> _INPUT_',
            lengthMenu: '<span>rows per page:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    reload_table();

    $("#m_form").submit(function(event) {
        /* stop form from submitting normally */
        event.preventDefault();

        if (!event.target.checkValidity()) {
            return false;
        }
        save();
    });

});

var reload_table = function(){
    if(table)
        table.destroy();
    table = $('.datatable-ajax').DataTable({
        ajax: SITE_URL + 'admin/hourspay_manage/get_hourspays',
        "order": [[ 0, "asc" ]]
    });

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Please enter the keyword');

    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
}

var change_info = function(hour){
    $("#m_hour").val(hour);

	$.post(SITE_URL + 'admin/hourspay_manage/get_hourspay_info/' + hour, function(resp){
		resp = JSON.parse(resp);
		if(resp.status){
			$("#modal_title").html("Edit HoursPay");
			$("#m_hours").val(hour);
			
			$("#m_pay").val(resp.msg.pay);
			$("#info_modal").modal();
		}
	});
}


var save = function(){
    if($("#m_pay").val() == ""){
        swal({
            title: "Please fill in all fields",
            type: "warning",
            confirmButtonColor: "#2196F3"
        }, function(){
            setTimeout(function(){
                $("#m_pay").focus();
            }, 100);
        });
        return;
    }

	$.post(SITE_URL + 'admin/hourspay_manage/update_info', 
		{
			hours: $("#m_hours").val(),
			pay: $("#m_pay").val()
		}, 
		function(resp){
			resp = JSON.parse(resp);
			if(resp.status){
				swal({
		            title: "Updated!",
		            type: "success",
		            confirmButtonColor: "#2196F3"
		        }, function(){
		        	$('#info_modal').modal('toggle');
		        	reload_table();
		        });
			} else {
                
            }
	});
}
