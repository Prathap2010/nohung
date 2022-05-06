$(document).ready(function(){

    if(is_payment_success == 1 || is_payment_failed == 1){
        $("#checkout-modal").modal("show");

        if(is_payment_success == 1){
            $("#title_payment_status").html("Payment Completed Successfully !");
        }else{
            $("#title_payment_status").html("Payment failed !");
        }
    }
    
});
function search_kitchen(){
    /* if($("#search_kitchen").val()!=""){
    } */
    window.location.href = SITE_URL+"search/"+$("#search_kitchen").val().trim();
}