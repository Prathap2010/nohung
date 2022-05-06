var offset = 0;
$(document).ready(function(){
    $("#wallettable").DataTable();
    $('.dataTables_filter input').attr('placeholder','Search...');
    $('.dataTables_paginate>ul.pagination').addClass("pull-right pagination-lg");

    load_transaction_history();
});
function openaddaccountmodal(){
    $(".validation-msg").html("");

    $("#addaccountform input.form-control").val("");
}
function openwithdrawmodal(){
    $(".validation-msg").html("");

    $("#withdrawal_amount_error").val("");
}
function save_account_detail(){

    var account_name = $("#account_name").val().trim();
    var bank_name = $("#bank_name").val().trim();
    var ifsc = $("#ifsc").val().trim();
    var account_number = $("#account_number").val();

    var isvalid = 1;

    if(account_name == ''){
        $("#account_name_error").html("Please enter account name !");
        isvalid = 0;
    }else {
        if(account_name.length<2){
            $("#account_name_error").html("Account name require minimum 2 characters !");
            isvalid = 0;
        }else{
            $("#account_name_error").html("");
        }
    }
    if(bank_name == ''){
        $("#bank_name_error").html("Please enter bank name !");
        isvalid = 0;
    }else {
        if(bank_name.length<2){
            $("#bank_name_error").html("Bank name require minimum 2 characters !");
            isvalid = 0;
        }else{
            $("#bank_name_error").html("");     
        }
    }
    if(ifsc == ''){
        $("#ifsc_error").html("Please enter ifsc code !");
        isvalid = 0;
    }else {
        $("#ifsc_error").html("");
    }
    if(account_number == ''){
        $("#account_number_error").html("Please enter account number !");
        isvalid = 0;
    }else {
        $("#account_number_error").html("");
    }
    if(isvalid == 1){

        var formData = new FormData($('#addaccountform')[0]);
      
        var uurl = SITE_URL+"payment/add-bank-account";
    
        $.ajax({
          url: uurl,
          type: 'POST',
          data: formData,
          //async: false
          success: function(response){
            if(response==1){
                $("#form-error").html('<div class="alert alert-success">Account successfully added.</div>');
                setTimeout(function() { window.location.reload(); }, 1500);
            }else if(response==2){
                $("#form-error").html('<div class="alert alert-danger">Account number already exists !</div>');
            }else{
                $("#form-error").html('<div class="alert alert-danger">Account not added !</div>');
            } 
          },
          error: function(xhr) {
            //alert(xhr.responseText);
          },
          cache: false,
          contentType: false,
          processData: false
        });
    }
}
function send_withdrawal_request(){

    var withdrawal_amount = $("#withdrawal_amount").val().trim();
    
    var isvalid = 1;

    if(withdrawal_amount == ''){
        $("#withdrawal_amount_error").html("Please enter withdrawal amount !");
        isvalid = 0;
    }else{
        $("#withdrawal_amount_error").html("");
    }
    
    if(isvalid == 1){

        var formData = new FormData($('#withdrawalform')[0]);
      
        var uurl = SITE_URL+"payment/send-withdrawal-request";
    
        $.ajax({
          url: uurl,
          type: 'POST',
          data: formData,
          //async: false
          success: function(response){
            if(response==1){
                $("#withdrawal-form-error").html('<div class="alert alert-success">Withdrawal request send successfully.</div>');
                setTimeout(function() { window.location.reload(); }, 1500);
            }else{
                $("#withdrawal-form-error").html("<div class='alert alert-danger'>You don't have enough balance for withdrawal !</div>");
            } 
          },
          error: function(xhr) {
            //alert(xhr.responseText);
          },
          cache: false,
          contentType: false,
          processData: false
        });
    }
}
function load_transaction_history(){
    
    $.ajax({
        url: SITE_URL+'payment/load-transaction-history',
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
                $("#transactionlist").html(response.html);
            }else{
                $("#transactionlist").append(response.html);
            }
            offset = parseInt(offset) + parseInt(PER_PAGE_TRANSACTION);
            
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