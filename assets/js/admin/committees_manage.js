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
        ajax: SITE_URL + 'admin/committees_manage/get_committees',
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

var delete_info = function(id){
	swal({
        title: "Are you sure?",
        text: "Do you want to delete?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false
    },
    function() {
    	$.post(SITE_URL + 'admin/committees_manage/delete_committee/' + id, function(resp){
    		resp = JSON.parse(resp);
    		if(resp.status){
    			swal({
		            title: "Deleted",
		            type: "success",
		            confirmButtonColor: "#2196F3"
		        }, function(){
		        	reload_table();
		        });
    		}
    	});
    });
}

var change_info = function(id){
	$.post(SITE_URL + 'admin/committees_manage/get_committee_info/' + id, function(resp){
		resp = JSON.parse(resp);
		if(resp.status){
			$("#modal_title").html("Edit Committee");
			$("#m_committee_id").val(id);
			
			$("#m_committee").val(resp.msg.committee);
			$("#info_modal").modal();
		}
	});
}

var show_modal = function(){
    $("#modal_title").html("Add Committee");
    $("#m_committee_id").val(0);
    $("#info_modal").modal();
}


var save = function(){
    if($("#m_committee").val() == ""){
        swal({
            title: "Please fill in all fields",
            type: "warning",
            confirmButtonColor: "#2196F3"
        }, function(){
            setTimeout(function(){
                $("#m_committee").focus();
            }, 100);
        });
        return;
    }

	$.post(SITE_URL + 'admin/committees_manage/add_update_info', 
		{
			id: $("#m_committee_id").val(),
			committee: $("#m_committee").val()
		}, 
		function(resp){
			resp = JSON.parse(resp);
			if(resp.status){
				swal({
		            title: "Added / Updated!",
		            type: "success",
		            confirmButtonColor: "#2196F3"
		        }, function(){
		        	$('#info_modal').modal('toggle');
		        	reload_table();
		        });
			} else {
                if(resp.msg == "0"){
                    swal({
                        title: "Already registred!",
                        type: "warning",
                        confirmButtonColor: "#2196F3"
                    });
                }
            }
	});
}
