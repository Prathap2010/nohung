function resetdata(){

    $("#pagename_div").removeClass("has-error is-focused");
    $("#title_div").removeClass("has-error is-focused");
    $("#description_div").removeClass("has-error is-focused");
    $("#metakeywords_div").removeClass("has-error is-focused");
    $("#metadescription_div").removeClass("has-error is-focused");
    $('.cke_inner').css({"border":"none"});        

    if(ACTION==1){
      $('html, body').animate({scrollTop:0},'slow');
    }else{
      $('#title').val('');
      $('#pagename').val('');
      $('#section').val('').selectpicker("refresh") ;
      $('#metakeywords').val('');
      $('#metadescription').val('');
     
      $('#pagename').focus();
      $('#yes').prop('checked',true);  
      $('html, body').animate({scrollTop:0},'slow');   
    }

    if(ACTION==1){
        $('.cke_inner').css({"background-color":"#FFF","border":"1px solid #D2D2D2"});
        var description = $('#description').val();
        CKEDITOR.instances['description'].setData(description);
    }else{
        $('.cke_inner').css({"background-color":"#FFF","border":"1px solid #D2D2D2"});
        CKEDITOR.instances['description'].setData("");
    }
}

function checkvalidation(){

    var pagename = $("#pagename").val().trim();
    var title = $("#title").val().trim();
    var description = CKEDITOR.instances['description'].getData();
    description = encodeURIComponent(description);
    CKEDITOR.instances['description'].updateElement();
    
    // var metakeyword = $("#metakeywords").val();
    // var metadescription = $("#metadescription").val();
    
    var isvaliddescription= isvalidtitle = isvalidpagename = 0;
    // var isvalidmetakeyword = isvalidmetadescription = 1;
    
    if(pagename == ''){
        $("#pagename_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter page name !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidpagename = 0;
    }else { 
        if(pagename.length<3){
          $("#pagename_div").addClass("has-error is-focused");
          new PNotify({title: "Page name require minimum 3 characters !",styling: 'fontawesome',delay: '3000',type: 'error'});
          isvalidpagename = 0;
        }else{
          isvalidpagename = 1;  
        }
    }
    if(title == ''){
      $("#title_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter page title !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalidtitle = 0;
    }else { 
      if(title.length<3){
        $("#title_div").addClass("has-error is-focused");
        new PNotify({title: "Page title require minimum 3 characters !",styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidtitle = 0;
      }else{
        isvalidtitle = 1;  
      }
    }
    if(description.trim() == 0 || description.length < 4){
        $("#description_div").addClass("has-error is-focused");
        $('.cke_inner').css({"background-color":"#FFECED","border":"1px solid #e51c23"});
        new PNotify({title: 'Please enter page description !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvaliddescription = 0;
    }else { 
        isvaliddescription = 1;
        $('.cke_inner').css({"border":"none"});
    }
    /* var totalkeyword = metakeyword.split(',').length;
    if(metakeyword.trim() != ''){
      if( totalkeyword < 5 || totalkeyword > 25){
        $('#s2id_metakeywords > ul').css({"background-color":"#FFECED","border":"1px solid #FFB9BD"});
        new PNotify({title: "Enter meta keyword between 5 to 25 !",styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidmetakeyword = 0;
      }else{
        isvalidmetakeyword = 1;
        $('#s2id_metakeywords > ul').css({"background-color":"#FFF","border":"1px solid #cccccc"});
      }
    }
    if(metadescription != ''){
      if(metadescription.length < 100 || metadescription.length > 185){
        $("#metadescription_div").addClass("has-error is-focused");
        new PNotify({title: "Enter meta description between 100 to 185 characters !",styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidmetadescription = 0;
      }else{
        isvalidmetadescription = 1;
      }
    } */
                        
    if(isvaliddescription==1 && isvalidtitle==1 && isvalidpagename==1){
                            
    var formData = new FormData($('#contentform')[0]);
      if(ACTION == 0){    
        var uurl = SITE_URL+"manage-content/content-add";
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
                new PNotify({title: "Content successfully added.",styling: 'fontawesome',delay: '3000',type: 'success'});
                resetdata();              
            }else if(response==2){
              new PNotify({title: "Page already exists !",styling: 'fontawesome',delay: '3000',type: 'error'});
              $("#pagename_div").addClass("has-error is-focused");
            }else{
              new PNotify({title: "Content not added !",styling: 'fontawesome',delay: '3000',type: 'error'});
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
        var uurl = SITE_URL+"manage-content/update-content";
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
                  new PNotify({title: "Content successfully updated.",styling: 'fontawesome',delay: '3000',type: 'success'});
                  setTimeout(function() { window.location=SITE_URL+"manage-content"; }, 1500);
                }else if(response==2){
                  new PNotify({title: "Page already exists !",styling: 'fontawesome',delay: '3000',type: 'error'});
                  $("#pagename_div").addClass("has-error is-focused");
                }else{
                  new PNotify({title: "Content not updated !",styling: 'fontawesome',delay: '3000',type: 'error'});
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