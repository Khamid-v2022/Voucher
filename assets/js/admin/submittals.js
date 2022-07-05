var table = null;
$(function() { 
    $('.daterange-basic').daterangepicker({
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default'
    });
	$('#info_modal').on('hidden.bs.modal', function() {
	    $(this).find('form').trigger('reset');
	});

	$.extend( $.fn.dataTable.defaults, {
        autoWidth: true,
        columnDefs: [{
        	width: '100px',
        	targets: [0, 3, 4, 5]
        },{
            width: '150px',
            targets: [1]
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
    $("#date_range").on("change", function(){
        reload_table();
    })

});

var reload_table = function(){
    if(table)
        table.destroy();
    let dates = $("#date_range").val().split(" - ");

    // let from_date = dates[0].replaceAll('/', '-');
    // let to_date = dates[1].replaceAll('/', '-');

    table = $('.datatable-ajax').DataTable({
        "ajax":{
            "url": SITE_URL + 'admin/submittals/get_submittals',
            "data": {
                "from_date": dates[0],
                "to_date": dates[1]
            },
        },        
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

var view_info = function(id){
    let tr_o = "<tr>";
    let tr_c = "</tr>";
    let td_o = "<td>";
    let td_c_o = "<td class='text-center'>";
    let td_r_o = "<td class='text-right'>";
    let td_c = "</td>";

    $.post(SITE_URL + 'admin/submittals/get_submittal_info/' + id, function(resp){
        resp = JSON.parse(resp);
        if(resp.status){
            let ticket_info = resp.msg.ticket_info;
            let meeting_list = resp.msg.meeting_list;
            let event_list = resp.msg.event_list;
            
            $("#modal_title").html(ticket_info.supervisor_name + " - " + ticket_info.submit_date);

            let meeting_table_container_html = "";
            
            let meeting_total = 0;
            meeting_list.forEach(item => {
                meeting_total += parseFloat(item.totalpay);
                meeting_table_container_html += tr_o;
                meeting_table_container_html += td_o + item.committee + td_c;
                meeting_table_container_html += td_c_o + item.date + td_c;
                meeting_table_container_html += td_r_o + item.hours + td_c;
                meeting_table_container_html += td_r_o + numberWithCommas(item.miles) + td_c;
                meeting_table_container_html += td_r_o + item.hourspay + td_c;
                meeting_table_container_html += td_r_o + numberWithCommas(item.mileagepay) + td_c;
                meeting_table_container_html += td_r_o + numberWithCommas(item.totalpay) + td_c;
                meeting_table_container_html += tr_c;
            })

            $("#m_committee_table_container").html(meeting_table_container_html);
            $("#m_committee_total").html(numberWithCommas(meeting_total));


            let event_table_container_html = "";
            
            let event_total = 0;
            event_list.forEach(item => {
                event_total += parseFloat(item.totalpay);
                event_table_container_html += tr_o;
                event_table_container_html += td_o + item.event_name + td_c;
                event_table_container_html += td_c_o + item.date + td_c;
                
                event_table_container_html += td_c_o;
                if(item.breakfast=="y"){
                    event_table_container_html += "Y";
                }
                event_table_container_html += td_c;

                event_table_container_html += td_c_o;
                if(item.lunch=="y"){
                    event_table_container_html += "Y";
                }
                event_table_container_html += td_c;

                event_table_container_html += td_c_o;
                if(item.dinner=="y"){
                    event_table_container_html += "Y";
                }
                event_table_container_html += td_c;

                event_table_container_html += td_r_o + numberWithCommas(item.other_amount) + td_c;
                event_table_container_html += td_r_o + numberWithCommas(item.totalpay) + td_c;
                event_table_container_html += tr_c;
            })

            $("#m_event_table_container").html(event_table_container_html);
            $("#m_event_total").html(numberWithCommas(event_total));

            $("#m_total").html(ticket_info.payperiod_total);
            $("#m_note").val(ticket_info.note);
            $("#m_is_corrected").prop('checked', ticket_info.is_corrected=="y"?true:false);
            $("#m_initial").val(ticket_info.initial);
            $("#m_submit_date").val(ticket_info.submit_date);
        }else{

        }
    })

    
    $("#info_modal").modal();
}

