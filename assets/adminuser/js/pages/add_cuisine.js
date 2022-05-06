  function resetdata(){
    
    $("#cuisinename_div").removeClass("has-error is-focused");
    $("#order_div").removeClass("has-error is-focused");
    
    if(ACTION==0){
      $('#cuisinename').val('');
      $('#order').val('');
      
      $('#yes').prop("checked", true);
    }
    $('html, body').animate({scrollTop:0},'slow');
  }
  function checkvalidation(){
    
    var cuisinename = $("#cuisinename").val().trim();
    var order = $("#order").val().trim();
    
    var isvalidcuisinename = isvalidorder = 0;
    PNotify.removeAll();
    
    if(cuisinename == ''){
      $("#cuisinename_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter cuisine name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
      if(cuisinename.length<2){
        $("#cuisinename_div").addClass("has-error is-focused");
        new PNotify({title: 'Cuisine name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      }else{
        $("#cuisinename_div").removeClass("has-error is-focused");
        isvalidcuisinename = 1;
      }
    }
    if(order == ''){
      $("#order_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter order !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#order_div").removeClass("has-error is-focused");
      isvalidorder = 1;
    }
    if(isvalidcuisinename==1 && isvalidorder==1){
    
      var formData = new FormData($('#cuisineform')[0]);
      if(ACTION==0){
  
        var uurl = SITE_URL+"manage-cuisine/cuisine-add";
        
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
              new PNotify({title: 'Cuisine successfully added.',styling: 'fontawesome',delay: '3000',type: 'success'});
              resetdata();              
            }else if(response==2){
              new PNotify({title: 'Cuisine name already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#cuisinename_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'Cuisine not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
        
        var uurl = SITE_URL+"manage-cuisine/update-cuisine";
  
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
              new PNotify({title: 'Cuisine successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
              setTimeout(function() { window.location=SITE_URL+"manage-cuisine"; }, 1500);
            }else if(response==2){
              new PNotify({title: 'Cuisine name already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#cuisinename_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'Cuisine not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  