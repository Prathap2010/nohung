function resetdata(){
    
    $("#title_div").removeClass("has-error is-focused");
    $("#description_div").removeClass("has-error is-focused");
    $("#sort_div").removeClass("has-error is-focused");
    
    if(ACTION==0){
      $('#title,#description').val('');
      $('#sort').val('');
    }
    $('html, body').animate({scrollTop:0},'slow');
  }
  function checkvalidation(){
    
    var title = $("#title").val().trim();
    var description = $("#description").val().trim();
    var sort = $("#sort").val().trim();
    
    var isvalid = 1;
    PNotify.removeAll();
    
    if(title == ''){
      $("#title_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter title !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else {
      if(title.length<2){
        $("#title_div").addClass("has-error is-focused");
        new PNotify({title: 'Title require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalid = 0;
      }else{
        $("#title_div").removeClass("has-error is-focused");
      }
    }
    if(description == ''){
        $("#description_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter description !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalid = 0;
      }else {
        if(description.length<2){
          $("#description_div").addClass("has-error is-focused");
          new PNotify({title: 'Description require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
          isvalid = 0;
        }else{
          $("#description_div").removeClass("has-error is-focused");
        }
      }
    if(sort == ''){
      $("#sort_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter order !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#sort_div").removeClass("has-error is-focused");
    }
    if(isvalid==1){
    
      var formData = new FormData($('#faqform')[0]);
      if(ACTION==0){
  
        var uurl = SITE_URL+"faq/faq-add";
        
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
              new PNotify({title: 'FAQs successfully added.',styling: 'fontawesome',delay: '3000',type: 'success'});
              resetdata();              
            }else if(response==2){
              new PNotify({title: 'FAQs already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#title_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'FAQs not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
        
        var uurl = SITE_URL+"faq/update-faq";
  
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
              new PNotify({title: 'FAQs successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
              setTimeout(function() { window.location=SITE_URL+"faq"; }, 1500);
            }else if(response==2){
              new PNotify({title: 'FAQs already exist !',styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#title_div").addClass("has-error is-focused");
            }else  if(response==0){
              new PNotify({title: 'FAQs not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  