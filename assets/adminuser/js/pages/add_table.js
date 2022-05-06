$(document).ready(function() {
  
  });
  
  function resetdata(){
  
    $("#restaurantname_div").removeClass("has-error is-focused");
    $("#restaurantowner_div").removeClass("has-error is-focused");
    $("#seatingcapacity_div").removeClass("has-error is-focused");
    
    if(ACTION==1){
  
    }else{
  
      $('#restaurantname,#seatingcapacity').val('');
      $('#restaurantownerid').val('0');
      
      $('#available').prop("checked", true);
      $('#yes').prop("checked", true);
      $('.selectpicker').selectpicker('refresh');
    }
    $('html, body').animate({scrollTop:0},'slow');
  }
  function checkvalidation(){
    
    var restaurantname = $("#restaurantname").val().trim();
    var restaurantownerid = $("#restaurantownerid").val();
    var seatingcapacity = $("#seatingcapacity").val().trim();
    
    var isvalidrestaurantname = isvalidrestaurantownerid = isvalidseatingcapacity = 0;
    PNotify.removeAll();
    
    if(restaurantname == ''){
      $("#restaurantname_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter restaurant name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
      if(restaurantname.length<2){
        $("#restaurantname_div").addClass("has-error is-focused");
        new PNotify({title: 'Restaurant name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      }else{
        $("#restaurantname_div").removeClass("has-error is-focused");
        isvalidrestaurantname = 1;
      }
    }
    if(restaurantownerid == 0){
        $("#restaurantowner_div").addClass("has-error is-focused");
        new PNotify({title: 'Please select restaurant owner !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else { 
        $("#restaurantowner_div").removeClass("has-error is-focused");
        isvalidrestaurantownerid = 1;
    }
    if(seatingcapacity == 0){
        $("#seatingcapacity_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter seating capacity !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#seatingcapacity_div").removeClass("has-error is-focused");
        isvalidseatingcapacity = 1;
    }
    if(isvalidrestaurantname==1 && isvalidrestaurantownerid==1 && isvalidseatingcapacity==1){
    
      var formData = new FormData($('#tableform')[0]);
      if(ACTION==0){
  
        var uurl = SITE_URL+"manage-table/table-add";
        
        $.ajax({
          url: uurl,
          type: 'POST',
          data: formData,
          //async: false,
          beforeSend: function(){
            $('.mask').show();
            $('#loader').show();
          },
          success: function(response){
            if(response==1){
              new PNotify({title: 'Table successfully created.',styling: 'fontawesome',delay: '3000',type: 'success'});
              resetdata();              
            }else if(response==2){
              new PNotify({title: 'Table already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else  if(response==0){
              new PNotify({title: 'Table not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }
          },
          error: function(xhr) {
          //alert(xhr.responseText);
          },
          complete: function(){
            $('.mask').hide();
            $('#loader').hide();
          },
          cache: false,
          contentType: false,
          processData: false
        });
      }else{
        
        var uurl = SITE_URL+"manage-table/update-table";
  
        $.ajax({
          url: uurl,
          type: 'POST',
          data: formData,
          //async: false,
          beforeSend: function(){
            $('.mask').show();
            $('#loader').show();
          },
          success: function(response){
            if(response==1){
              new PNotify({title: 'Table successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
              setTimeout(function() { window.location=SITE_URL+"manage-table"; }, 1500);
            }else if(response==2){
              new PNotify({title: 'Table already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }else  if(response==0){
              new PNotify({title: 'Table not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
            }
          },
          error: function(xhr) {
            //alert(xhr.responseText);
          },
          complete: function(){
            $('.mask').hide();
            $('#loader').hide();
          },
          cache: false,
          contentType: false,
          processData: false
        });
      }
    }
  }
  
  