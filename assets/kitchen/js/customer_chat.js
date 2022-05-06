$(document).ready(function(){
    get_recent_riders();
});
$(document).on("click",".msg_send_btn",function(){
    send_message();
});
var load_rider_id = 0;
//Send message
function send_message(){
    var message = $('#message').val(); //user message text
    var riderid = $('#riderid').val();
    
    if(message == ""){ //empty name?
        toastr.error('Please enter message !');
        return;
    }

    $.ajax({
        url: SITE_URL+'customer-chat/add-chat-message',
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
        url: SITE_URL+'customer-chat/get-recent-riders',
        type: 'POST',
        dataType: 'json',
        // async: false,
        success: function(response){

            var html = "";
            if(response.length > 0){
                for(var i=0; i<response.length; i++){
                    
                    html += '<div class="chat_list" onclick="get_rider_chat('+response[i]['id']+')">\
                                <div class="chat_people">\
                                <div class="chat_img"> <img src="'+SITE_URL+'assets/image/userprofile/noimage.png" alt="sunil"> </div>\
                                    <div class="chat_ib">\
                                        <h5>'+response[i]['kitchenname']+' <span class="chat_date">'+response[i]['time']+'</span></h5>\
                                        <label class="badge badge-success" style="float: right;" id="msg_badges'+response[i]['id']+'">'+(response[i]['new_msg'] > 0 ? response[i]['new_msg'] : "")+'</label>\
                                        <p>'+response[i]['lastmsg']+'</p>\
                                    </div>\
                                </div>\
                            </div>';
                }
            }else{
                html += '<div class="chat_list">No Customers Found.</div>';
            }   
            $("#riderlist").html(html);

            $(".chat_list").on("click", function(){
                $(".chat_list").removeClass("active_chat");
                $(this).addClass("active_chat");
                $(".type_msg").show();
            });
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}

function get_rider_chat(rider_id,load=""){
    $.ajax({
        url: SITE_URL+'customer-chat/get-rider-chat',
        type: 'POST',
        data: {riderid: rider_id},
        dataType: 'json',
        // async: false,
        success: function(response){

            var html = "";
            
            html += '<input type="hidden" name="riderid" id="riderid" value="'+response.riderid+'">';
            if(response['chat'].length > 0){
                
                for(var i=0; i<response['chat'].length; i++){

                    if(response['chat'][i]['msg_type'] == 'kitchentofoodies'){
                        
                        html += '<div class="outgoing_msg">\
                                    <div class="sent_msg">\
                                    <p>'+response['chat'][i]['message']+'</p>\
                                    <span class="time_date">'+response['chat'][i]['time']+'</span> </div>\
                                </div>';

                    }else{
                        
                        html += '<div class="incoming_msg">\
                                    <div class="incoming_msg_img"> <img src="'+SITE_URL+'assets/image/userprofile/noimage.png" alt="sunil"> </div>\
                                    <div class="received_msg">\
                                        <div class="received_withd_msg">\
                                            <p>'+response['chat'][i]['message']+'</p>\
                                            <span class="time_date">'+response['chat'][i]['time']+'</span>\
                                        </div>\
                                    </div>\
                                </div>';
                        
                    }

                }
            }
            
            $("#chat_conversation").html(html);
           
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