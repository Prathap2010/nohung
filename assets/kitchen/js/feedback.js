var offset = 0;
$(document).ready(function(){
    get_reviews();
});
function get_reviews(){
    
    $.ajax({
        url: SITE_URL+'feedback/get-reviews',
        type: 'POST',
        data: {offset:parseInt(offset)},
        dataType: 'json',
        // async: false,
        beforeSend: function(){
            $(".load_more_btn").css({'opacity':'0.3',"pointer-events":"none"}).prop("disabled",true);
            $(".load_more_btn a").text('Loading...');
        },
        success: function(response){

            if(parseInt(offset)==0){
                $("#list").html(response.html);
            }else{
                $("#list").append(response.html);
            }
            offset = parseInt(offset) + parseInt(PER_PAGE_FEEDBACK);
            
            if(parseInt(offset) >= parseInt(response.totalrows)){
                $(".load_more_btn").hide();
            }else{
                $(".load_more_btn").show();
            }
            
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
        complete: function(){
            $(".load_more_btn").css({'opacity':'1',"pointer-events":"unset"}).prop("disabled",false);
            $(".load_more_btn a").text('Load More');
        },
    });
}