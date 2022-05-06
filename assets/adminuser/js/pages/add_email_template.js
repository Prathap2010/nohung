function resetdata(){

    $("#emailtype_div").removeClass("has-error is-focused");
    $("#subject_div").removeClass("has-error is-focused");
    $("#message_div").removeClass("has-error is-focused");
    $('.cke_inner').css({"border":"none"});

    if(ACTION==1){
        $('.cke_inner').css({"background-color":"#FFF","border":"1px solid #D2D2D2"});
        var message = $('#message').val();
        CKEDITOR.instances['message'].setData(message);
    }else{
        $('#emailtype').val('0');
        $('#subject').val('');
        $('.cke_inner').css({"background-color":"#FFF","border":"1px solid #D2D2D2"});
        CKEDITOR.instances['message'].setData("");
    }
    $('.selectpicker').selectpicker('refresh');  
    $('html, body').animate({scrollTop:0},'slow');
}

function checkvalidation(btntype){

    var emailtype = $("#emailtype").val() == undefined ? '' : $("#emailtype").val();
    var subject = $("#subject").val().trim();

    var message = CKEDITOR.instances['message'].getData();
    message = encodeURIComponent(message);
    CKEDITOR.instances['message'].updateElement();
    
    var isvalidsubject = isvalidemailtype = isvalidmessage = 0;
    
    if(emailtype == 0){
      $("#emailtype_div").addClass("has-error is-focused");
      new PNotify({title: "Please select email type !",styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalidemailtype = 0;
    }else { 
      isvalidemailtype = 1;
    }

    if(subject == ''){ 
        $("#subject_div").addClass("has-error is-focused");
        new PNotify({title: "Please enter email subject !",styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidsubject = 0;      
    }else {
      if(subject.length<3){
        $("#subject_div").addClass("has-error is-focused");
        new PNotify({title: "Subject require minimum 3 characters !",styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidsubject = 0;
      }else{
        isvalidsubject = 1;
      }
    }
    if(message.trim() == 0 || message.length < 4){
        $("#message_div").addClass("has-error is-focused");
        $('.cke_inner').css({"background-color":"#FFECED","border":"1px solid #e51c23"});
        new PNotify({title: 'Please enter email content !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidmessage = 0;
    }else { 
        isvalidmessage = 1;
        $('.cke_inner').css({"border":"none"});
    }
                        
    if(isvalidsubject==1 && isvalidemailtype==1 &&  isvalidmessage==1){
                            
        var formData = new FormData($('#emailtemplateform')[0]);
        if(ACTION == 0){    
          var uurl = SITE_URL+"email-template/email-template-add";
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
                new PNotify({title: "Email template successfully added.",styling: 'fontawesome',delay: '3000',type: 'success'});
                if(btntype == 1){              
                  setTimeout(function() { window.location=SITE_URL+"email-template"; }, 1500);
                } 
                else if(btntype == 0){              
                  resetdata();              
                }                 
              }else if(response==2){
                new PNotify({title: "Email template already exists !",styling: 'fontawesome',delay: '3000',type: 'error'});
              }else{
                new PNotify({title: "Email template not added !",styling: 'fontawesome',delay: '3000',type: 'error'});
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
          var uurl = SITE_URL+"email-template/update-email-template";
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
                    new PNotify({title: "Email template successfully updated.",styling: 'fontawesome',delay: '3000',type: 'success'});
                    setTimeout(function() { window.location=SITE_URL+"email-template"; }, 1500);
                  }else if(response==2){
                    new PNotify({title: "Email template already exists !",styling: 'fontawesome',delay: '3000',type: 'error'});
                  }else{
                    new PNotify({title: "Email template not updated !",styling: 'fontawesome',delay: '3000',type: 'error'});
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