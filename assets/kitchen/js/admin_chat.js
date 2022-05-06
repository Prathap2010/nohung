$(document).ready(function(){
    get_admin_detail();
});
$(document).on("click",".msg_send_btn",function(){
    send_message();
});
$(document).on("keypress", "#message", function(event) {
    if (event.which == 13){
        event.preventDefault();
        send_message();
    }
});
//Send message
function send_message(){
    var message = $('#message').val(); //user message text
    
    if(message == ""){ //empty name?
        toastr.error('Please enter message !');
        return;
    }

    $.ajax({
        url: SITE_URL+'admin-chat/add-chat-message',
        type: 'POST',
        data: {message:message},
        dataType: 'json',
        // async: false,
        success: function(response){
            get_admin_chat();
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    $('#message').val(''); 
    
    $("#chat_conversation").animate({ scrollTop: $('#chat_conversation')[0].scrollHeight }, 1000);
}
function get_admin_detail(){
    $.ajax({
        url: SITE_URL+'admin-chat/get-admin-detail',
        type: 'POST',
        dataType: 'json',
        // async: false,
        success: function(response){

            var admin = response.adminlist;
            var html = "";
            if(response){
                    
                html += '<div class="chat_list" onclick="get_admin_chat()">\
                            <div class="chat_people">\
                            <div class="chat_img"> <img src="'+admin['image']+'" alt="sunil"> </div>\
                                <div class="chat_ib">\
                                    <h5>'+admin['name']+' <span class="chat_date">'+admin['time']+'</span></h5>\
                                    <label class="badge badge-success" style="float: right;" id="msg_badges">'+(admin['new_msg'] > 0 ? admin['new_msg'] : "")+'</label>\
                                    <p class="text-ellipsis">'+admin['lastmsg']+'</p>\
                                </div>\
                            </div>\
                        </div>';
            }   
            $("#adminlist").html(html);

            $(".chat_list").on("click", function(){
                $(".chat_list").removeClass("active_chat");
                $(this).addClass("active_chat");
                $(".type_msg").show();
            });
            $(".chat_list").click();
            if(response.count_sidebar_admin_msg > 0){
                $("#count_sidebar_admin_msg").html(response.count_sidebar_admin_msg);
            }else{
                $("#count_sidebar_admin_msg").html('');
            }
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    setTimeout(() => {
        get_admin_detail();
    }, 5000);
}

function get_admin_chat(){
    $.ajax({
        url: SITE_URL+'admin-chat/get-admin-chat',
        type: 'POST',
        /* data: {adminid: admin_id}, */
        dataType: 'json',
        // async: false,
        success: function(response){

            var html = "";
            if(response['chat'].length > 0){
                
                for(var i=0; i<response['chat'].length; i++){

                    if(response['chat'][i]['msg_type'] == 'usertoadmin'){
                        
                        html += '<div class="outgoing_msg">\
                                    <div class="sent_msg">\
                                    <p>'+response['chat'][i]['message']+'</p>\
                                    <span class="time_date">'+response['chat'][i]['time']+'</span> </div>\
                                </div>';

                    }else{
                        
                        html += '<div class="incoming_msg">\
                                    <div class="incoming_msg_img"> <img src="'+response['image']+'" alt="sunil"> </div>\
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
           
            $("#msg_badges").html('');
            // $("#chat_conversation").animate({ scrollTop: $('#chat_conversation')[0].scrollHeight }, 2000);
            $("#chat_conversation")[0].scrollTop = $("#chat_conversation")[0].scrollHeight;
            // get_recent_riders();
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
    
    setTimeout(() => {
        get_admin_chat();
    }, 5000);
}