
$(function() {
    highlight_dates = JSON.parse($("#dates").val());
    

    $('.daterange-single').daterangepicker({ 
        singleDatePicker: true,
        locale: {
            format: 'MM/DD/YYYY', 
        }
    });

    $(".select-date").daterangepicker({ 
        singleDatePicker: true,
        locale: {
            format: 'MM/DD/YYYY', 
        },
        isInvalidDate : function(date){
            if(highlight_dates.includes(date.format('YYYY-MM-DD')) || $("#today").val() == date.format('MM/DD/YYYY')){
                return false;
            }
            else
                return true;
        },
        isCustomDate : function(date){
            if(highlight_dates.includes(date.format('YYYY-MM-DD'))){
                return "hightlight";
            }
            else
                return "";
        },
    });

    $('#add_committee_modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');

        $("#add_committee_modal .modal-title").html("Add Committee Meeting");
        $("#m_edited_meeting_id").val(0);
        $("#m_submit_btn").html("Save");
    });

    $("#add_event_modal").on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');

        $("#add_event_modal .modal-title").html("Add Event");
        $("#m_event_id").val(0);
        $("#m_event_submit_btn").html("Save");
    });
    

    $("#sel_date").on('change', function(){
        document.getElementById("history_log_date_form").submit();
    })

    $("#document_form").submit(function(event) {
        event.preventDefault();

        if (!event.target.checkValidity()) {
            return false;
        }

        submit_document();
    });

    $("#committee_modal_form").submit(function(event) {
        event.preventDefault();

        if (!event.target.checkValidity()) {
            return false;
        }

        add_update_committe_meeting();
    });

    $("#event_modal_form").submit(function(event) {
        event.preventDefault();

        if (!event.target.checkValidity()) {
            return false;
        }

        add_update_event();
    });


    // meeting log edit
    $(".meeting_edit_btn").on('click', function(){
        let meeting_id = $(this).parents('tr').attr('committee_meeting_id');
        $("#add_committee_modal .modal-title").html("Edit Committee Meeting");
        $("#m_edited_meeting_id").val(meeting_id);
        $("#m_submit_btn").html("Update");

        $.post(SITE_URL + 'voucher/get_meeting/' + meeting_id, function(resp){
            resp = JSON.parse(resp);
            if(resp.status){
                $("#m_committee").val(resp.msg.committee_id);
                $("#m_committee_date").val(resp.msg.formated_date);
                $("#m_committee_hours").val(resp.msg.hours);
                $("#m_committee_miles").val(resp.msg.miles);
            }
        })

        $("#add_committee_modal").modal();
    });


    // meeting log delete
    $(".meeting_delete_btn").on('click', function(){
        let meeting_id = $(this).parents('tr').attr('committee_meeting_id');
        swal({
            title: "Are you sure?",
            text: "Do you want to delete?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false
        },
        function() {
            $.post(SITE_URL + 'voucher/delete_meeting/' + meeting_id, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    swal({
                        title: "deleted",
                        type: "success",
                        confirmButtonColor: "#2196F3"
                    }, function(){
                        location.reload();
                    });
                }
            });
        });
    });


    $(".event_edit_btn").on('click', function(){
        let event_id = $(this).parents('tr').attr('event_id');
        $("#add_event_modal .modal-title").html("Edit Event");
        $("#m_event_id").val(event_id);
        $("#m_event_submit_btn").html("Update");

        $.post(SITE_URL + 'voucher/get_event/' + event_id, function(resp){
            resp = JSON.parse(resp);
            if(resp.status){
                // console.log(resp);
                $("#m_event_name").val(resp.msg.event_name);
                $("#m_event_date").val(resp.msg.formated_date);
                $("#m_other_amount").val(resp.msg.other_amount);
                $("#m_breakfast").prop('checked', resp.msg.breakfast=="y"?true:false);
                $("#m_lunch").prop('checked', resp.msg.lunch=="y"?true:false);
                $("#m_dinner").prop('checked', resp.msg.dinner=="y"?true:false);
            }
        })

        $("#add_event_modal").modal();
    });

    $(".event_delete_btn").on('click', function(){
        let event_id = $(this).parents('tr').attr('event_id');
        swal({
            title: "Are you sure?",
            text: "Do you want to delete?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false
        },
        function() {
            $.post(SITE_URL + 'voucher/delete_event/' + event_id, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    swal({
                        title: "deleted",
                        type: "success",
                        confirmButtonColor: "#2196F3"
                    }, function(){
                        location.reload();
                    });
                }
            });
        });
    });

    $("#is_corrected").on("click", function(){
        
        if($("#is_submitted").val() == "1" && $("#is_today").val() == "y"){
            $.post(SITE_URL + 'voucher/update_document_as_corrected',
                {
                    ticket_id: $("#ticket_id").val(),
                    is_corrected: $("#is_corrected").is(':checked') ? "y" : "n"
                }, function(resp){
                    location.reload();
            })
        }
    })

});

// meeting log add
function add_update_committe_meeting(){
    let committee = $("#m_committee").val();
    let date = $("#m_committee_date").val();
    let hours = $("#m_committee_hours").val();
    let miles = $("#m_committee_miles").val();
    // let log_date = $("#sel_date").val();

    let add_or_update = parseInt($("#m_edited_meeting_id").val()) > 0 ? 'update' : 'add';

    if(add_or_update === 'add'){
        $.post(SITE_URL + 'voucher/add_update_committe_meeting', 
            {
                ticket_id: $("#ticket_id").val(),
                committe: committee,
                date: date,
                hours: hours,
                miles: miles
            }, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    location.reload();
                }
        });
    } else {
        $.post(SITE_URL + 'voucher/add_update_committe_meeting', 
            {
                ticket_id: $("#ticket_id").val(),
                id: $("#m_edited_meeting_id").val(),
                committe: committee,
                date: date,
                hours: hours,
                miles: miles
            }, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    swal({
                        title: "Updated",
                        type: "success",
                        confirmButtonColor: "#2196F3"
                    }, function(){
                        location.reload();
                    });
                }
        });
    }
    
}

function add_update_event(){
    let event_name = $("#m_event_name").val();
    let date = $("#m_event_date").val();
    let breakfast = $("#m_breakfast").is(':checked')?"y":"n";
    let lunch = $("#m_lunch").is(':checked')?"y":"n";
    let dinner = $("#m_dinner").is(':checked')?"y":"n";
    let other_amount = $("#m_other_amount").val();

    let add_or_update = parseInt($("#m_event_id").val()) > 0 ? 'update' : 'add';

    if(add_or_update === 'add'){
        $.post(SITE_URL + 'voucher/add_update_event', 
            {
                ticket_id: $("#ticket_id").val(),
                event_name: event_name,
                date: date,
                breakfast: breakfast,
                lunch: lunch,
                dinner: dinner,
                other_amount: other_amount ? other_amount : 0
            }, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    location.reload();
                }
        });
    }else {
        $.post(SITE_URL + 'voucher/add_update_event', 
            {
                ticket_id: $("#ticket_id").val(),
                id: $("#m_event_id").val(),
                event_name: event_name,
                date: date,
                breakfast: breakfast,
                lunch: lunch,
                dinner: dinner,
                other_amount: other_amount ? other_amount : 0
            }, function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    swal({
                        title: "Updated",
                        type: "success",
                        confirmButtonColor: "#2196F3"
                    }, function(){
                        location.reload();
                    });
                }
        });
    }
}

function goto_today(){
    $("#sel_date").val($("#today").val());
    document.getElementById("history_log_date_form").submit();
}


function submit_document(){

    swal({
        title: "Are you sure?",
        text: "Once submitted, this ticket cannot be modified later.",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false
    },
    function() {
        $.post(SITE_URL + 'voucher/submit_document',
            {
                ticket_id: $("#ticket_id").val(),
                note: $("#note").val(),
                payperiod_total: $("#total_pay").val(),
                is_corrected: $("#is_corrected").is(':checked') ? "y" : "n",
                initial: $("#initial").val(),
                submit_date: $("#submit_date").val(),
                is_submited: 'y'
            },
            function(resp){
                resp = JSON.parse(resp);
                if(resp.status){
                    // email send
                    let ticket_id = resp.msg;
                    $.post(SITE_URL + 'voucher/email_send/' + ticket_id, function(resp){
                        // resp = JSON.parse(resp);
                        console.log(resp);
                    })

                    swal({
                        title: "Submited",
                        type: "success",
                        confirmButtonColor: "#2196F3"
                    }, function(){
                        location.reload();
                    });
                }
        });
    });
}