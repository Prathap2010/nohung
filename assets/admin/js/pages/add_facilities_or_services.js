function resetdata(){
    
    $("#facilitiesorservice_div").removeClass("has-error is-focused");
    $("#order_div").removeClass("has-error is-focused");
    
    if(ACTION==0){
      $('#facilitiesorservice').val('');
      $('#order').val('');
      
      $('#yes').prop("checked", true);
    }
    $('html, body').animate({scrollTop:0},'slow');
  }
  function checkvalidation(){
    
    var facilitiesorservice = $("#facilitiesorservice").val().trim();
    var order = $("#order").val().trim();
    
    var isvalidfacilitiesorservice = isvalidorder = 0;
    PNotify.removeAll();
    
    if(facilitiesorservice == ''){
      $("#facilitiesorservice_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter facilities / service name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
      if(facilitiesorservice.length<2){
        $("#facilitiesorservice_div").addClass("has-error is-focused");
        new PNotify({title: 'Facilities / service name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      }else{
        $("#facilitiesorservice_div").removeClass("has-error is-focused");
        isvalidfacilitiesorservice = 1;
      }
    }
    if(order == ''){
      $("#order_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter order !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#order_div").removeClass("has-error is-focused");
      isvalidorder = 1;
    }
    if(isvalidfacilitiesorservice==1 && isvalidorder==1){
    
      var formData = new FormData($('#facilitiesorservicesform')[0]);
      if(ACTION==0){
  
        var uurl = SITE_URL+"manage-facilities-or-services/facilities-or-services-add";
        
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
              new PNotify({title: 'Facilities / service successfully added.',styling: 'fontawesome',delay: '3000',type: 'success'});
              resetdata();              
            }else if(response==2){
              new PNotify({title: 'Facilities / service name already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#facilitiesorservice_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'Facilities / service not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
        
        var uurl = SITE_URL+"manage-facilities-or-services/update-facilities-or-services";
  
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
              new PNotify({title: 'Facilities / service successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
              setTimeout(function() { window.location=SITE_URL+"manage-facilities-or-services"; }, 1500);
            }else if(response==2){
              new PNotify({title: 'Facilities / service name already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#facilitiesorservice_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'Facilities / service not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  