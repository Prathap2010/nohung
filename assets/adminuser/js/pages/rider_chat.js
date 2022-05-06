$(document).ready(function(){
    get_recent_riders();
});
$(document).on("click",".send_message",function(){
    send_message();
});
$(document).on("keypress", "#message", function(event) {
    if (event.which == 13){
        event.preventDefault();
        send_message();
    }
});
var load_rider_id = 0;
//Send message
function send_message(){
    var message = $('#message').val(); //user message text
    var riderid = $('#riderid').val();
    
    if(message == ""){ //empty name?
        new PNotify({title: 'Please enter message !',styling: 'fontawesome',delay: '3000',type: 'error'});
        return;
    }

    $.ajax({
        url: SITE_URL+'rider-chat/add-chat-message',
        type: 'POST',
        data: {riderid: riderid, message:message},
        dataType: 'json',
        // async: false,
        success: function(response){
            get_rider_chat(riderid);
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    $('#message').val('');  
}
function get_recent_riders(){
    $.ajax({
        url: SITE_URL+'rider-chat/get-recent-riders',
        type: 'POST',
        dataType: 'json',
        // async: false,
        success: function(response){

            var rider_list = response.riderslist;
            var html = "";
            var riderid = $("#riderid").val();
            if(rider_list.length > 0){
                for(var i=0; i<rider_list.length; i++){
                    html += '<div class="row sideBar-body '+(riderid == rider_list[i]['id'] ? "active" : "")+'" onclick="get_rider_chat('+rider_list[i]['id']+')">\
                                <div class="col-sm-3 col-xs-3 sideBar-avatar">\
                                    <div class="avatar-icon">\
                                        <img src="'+rider_list[i]['profile_image']+'">\
                                    </div>\
                                </div>\
                                <div class="col-sm-9 col-xs-9 sideBar-main">\
                                    <div class="row">\
                                        <div class="col-sm-8 col-xs-8 pl-xs pr-xs">\
                                            <span class="name-meta">'+rider_list[i]['kitchenname']+'</span>\
                                            <p style="color:#b1b1b1;padding:5px" class="text-ellipsis mb-n">'+rider_list[i]['lastmsg']+'</p>\
                                        </div>\
                                        <div class="col-sm-4 col-xs-4 pull-right pl-xs pr-xs">\
                                            <span class="time-meta pull-right">'+rider_list[i]['time']+'</span>\
                                            <label class="badge badge-success pull-right" id="msg_badges'+rider_list[i]['id']+'">'+(rider_list[i]['new_msg'] > 0 ? rider_list[i]['new_msg'] : "")+'</label>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';
                }
            }else{
                html += '<div class="row sideBar-body">No Riders Found.</div>';
            }   
            $("#riderlist").html(html);

            $(".sideBar-body").on("click", function(){
                $(".sideBar-body").removeClass("active");
                $(this).addClass("active");
            });
            if(response.count_sidebar_rider_msg > 0){
                $("#count_sidebar_rider_msg").html(response.count_sidebar_rider_msg);
            }else{
                $("#count_sidebar_rider_msg").html('');
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    setTimeout(() => {
        get_recent_riders();
    }, 5000);
}

function get_rider_chat(rider_id,load=""){
    $.ajax({
        url: SITE_URL+'rider-chat/get-rider-chat',
        type: 'POST',
        data: {riderid: rider_id},
        dataType: 'json',
        // async: false,
        success: function(response){

            var html = "";
            if(load==""){

                html += '<div class="row heading">\
                            <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">\
                                <div class="heading-avatar-icon">\
                                    <img src="'+response.profile_image+'">\
                                </div>\
                            </div>\
                            <div class="col-sm-8 col-xs-7 heading-name">\
                                <a class="heading-name-meta">'+response.ridername+'</a>\
                                <p class="mb-n p-xs">'+response.email+'</p>\
                                <input type="hidden" name="riderid" id="riderid" value="'+response.riderid+'">\
                            </div>\
                        </div>';
                        html += '<div class="row message" id="conversation">';
            }

            if(response['chat'].length > 0){
                
                for(var i=0; i<response['chat'].length; i++){

                    if(response['chat'][i]['msg_type'] == 'admintouser'){
                        
                        html += '<div class="row message-body">\
                                    <div class="col-sm-12 message-main-sender">\
                                        <div class="sender">\
                                            <div class="message-text">'+response['chat'][i]['message']+'</div>\
                                            <span class="message-time pull-right">'+response['chat'][i]['time']+'</span>\
                                        </div>\
                                    </div>\
                                </div>';

                    }else{
                        
                        html += '<div class="row message-body">\
                                    <div class="col-sm-12 message-main-receiver">\
                                        <div class="receiver">\
                                            <div class="message-text">'+response['chat'][i]['message']+'</div>\
                                            <span class="message-time pull-right">'+response['chat'][i]['time']+'</span>\
                                        </div>\
                                    </div>\
                                </div>';
                        
                    }

                }
            }
            
            if(load==""){
                html += '</div>';
                html += '<div class="row reply">\
                            <div class="col-sm-11 col-xs-11 reply-main">\
                                <div class="form-group m-n p-n">\
                                    <textarea name="message" class="form-control" rows="1" id="message" style="background-color: #ffffff;" placeholder="type here..."></textarea>\
                                </div>\
                            </div>\
                            <div class="col-sm-1 col-xs-1 reply-send send_message">\
                                <i class="fa fa-send fa-2x" aria-hidden="true"></i>\
                            </div>\
                        </div>';
                
                $("#chatbox").html(html);
            }else{
                $("#conversation").html(html);
            }

            $("#msg_badges"+rider_id).html('');
            // get_recent_riders();
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    load_rider_id = rider_id;
    setTimeout(() => {
        get_rider_chat(load_rider_id,"chat");
    }, 5000);
}