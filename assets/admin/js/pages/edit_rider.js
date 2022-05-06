function validfile(obj){
  var val = obj.val();
  // var id = obj.attr('id').match(/\d+/);
  var id = obj.attr('id');
  var filename = obj.val().replace(/C:\\fakepath\\/i, '');
  var filesize = obj[0].files[0].size;
  
  switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
    case 'pdf': case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': 
      
      isvalidfile = 1;
      $("#text"+id).val(filename);
      $("#"+id+"_div").removeClass("has-error is-focused");
      $("#isvalid"+id).val(1);
      break;
    default:
      
      $("#text"+id).val("");
      $("#"+id+"_div").addClass("has-error is-focused");
      $("#isvalid"+id).val(0);
      new PNotify({title: 'Accept only image or pdf file !',styling: 'fontawesome',delay: '3000',type: 'error'});
      break;
  }
}
function resetdata(){
  
    $("#ridername_div").removeClass("has-error is-focused");
    $("#email_div").removeClass("has-error is-focused");
    $("#email_div").removeClass("has-error is-focused");

    if(ACTION==1){
    }else{
      
      $('#ridername,#email,#address').val('');
      
      $('#yes').prop("checked", true);
    }
    $('html, body').animate({scrollTop:0},'slow');
}
  function checkvalidation(){
    
    var ridername = $("#ridername").val().trim();
    var email = $("#email").val().trim();
    var mobilenumber = $("#mobilenumber").val();
    var city = $("#city").val();
    var licencefile = $("#licencefile").val();
    var rcbookfile = $("#rcbookfile").val();
    var passportfile = $("#passportfile").val();
    var idprooffile = $("#idprooffile").val();

    var isvalidridername = isvalidemail = isvalidmobilenumber = isvalidcity = isvalidlicencefile = isvalidrcbookfile = isvalidpassportfile = isvalididprooffile = 0;
    PNotify.removeAll();
    
    if(ridername == ''){
      $("#ridername_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter rider name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
      if(ridername.length<2){
        $("#ridername_div").addClass("has-error is-focused");
        new PNotify({title: 'Rider name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
      }else{
        $("#ridername_div").removeClass("has-error is-focused");
        isvalidridername = 1;
      }
    }
    if(email == ''){
      $("#email_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter email !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
      if(!ValidateEmail(email)){
        $("#email_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter valid email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
      }else{
        $("#email_div").removeClass("has-error is-focused");
        isvalidemail = 1;
      }
    }
   
    if(mobilenumber == ''){
      $("#mobilenumber_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter mobile number !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#mobilenumber_div").removeClass("has-error is-focused");
      isvalidmobilenumber = 1;
    }
    
    if(city == 0){
      $("#city_div").addClass("has-error is-focused");
      new PNotify({title: 'Please select city !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#city_div").removeClass("has-error is-focused");
      isvalidcity = 1;
    }
    
    if(licencefile == '' && $("#isvalidlicencefile").val()==0){
      $("#licencefile_div").addClass("has-error is-focused");
      new PNotify({title: 'Please upload licence !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else if(licencefile != '' && $("#isvalidlicencefile").val()==0){
      $("#licencefile_div").addClass("has-error is-focused");
      new PNotify({title: 'Accept only image or pdf file in Licence !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#licencefile_div").removeClass("has-error is-focused");
      isvalidlicencefile = 1;
    }
    if(rcbookfile == '' && $("#isvalidrcbookfile").val()==0){
      $("#rcbookfile_div").addClass("has-error is-focused");
      new PNotify({title: 'Please upload RC book !',styling: 'fontawesome',delay: '3000',type: 'error'});  
    }else if(rcbookfile != '' && $("#isvalidrcbookfile").val()==0){
      $("#rcbookfile_div").addClass("has-error is-focused");
      new PNotify({title: 'Accept only image or pdf file in RC book !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    }else{
      $("#rcbookfile_div").removeClass("has-error is-focused");
      isvalidrcbookfile = 1;
    }
    if(passportfile == '' && $("#isvalidpassportfile").val()==0){
      $("#passportfile_div").addClass("has-error is-focused");
      new PNotify({title: 'Please upload passport !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    }else if(passportfile != '' && $("#isvalidpassportfile").val()==0){
      $("#passportfile_div").addClass("has-error is-focused");  
      new PNotify({title: 'Accept only image or pdf file in passport !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    }else{
      $("#passportfile_div").removeClass("has-error is-focused");
      isvalidpassportfile = 1;
    }
    if(idprooffile == '' && $("#isvalididprooffile").val()==0){
      $("#idprooffile_div").addClass("has-error is-focused");  
      new PNotify({title: 'Please upload ID proof !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    }else if(idprooffile != '' && $("#isvalididprooffile").val()==0){
      $("#idprooffile_div").addClass("has-error is-focused");    
      new PNotify({title: 'Accept only image or pdf file in ID proof !',styling: 'fontawesome',delay: '3000',type: 'error'});    
    }else{
      $("#idprooffile_div").removeClass("has-error is-focused");
      isvalididprooffile = 1;
    }

    if(isvalidridername==1 && isvalidemail==1 && isvalidmobilenumber==1 && isvalidcity==1 && isvalidlicencefile==1 && isvalidrcbookfile==1 && isvalidpassportfile==1 && isvalididprooffile==1){
    
        var formData = new FormData($('#riderform')[0]);
      
        
        var uurl = SITE_URL+"rider/update-rider";

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
                    new PNotify({title: 'Rider successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                    setTimeout(function() { window.location=SITE_URL+"rider"; }, 1500);
                }else if(response==2){
                    new PNotify({title: 'Rider email already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else if(response==3){
                    new PNotify({title: 'Rider mobile number already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else if(response==0){
                    new PNotify({title: 'Rider not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else{
                  new PNotify({title: response,styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  