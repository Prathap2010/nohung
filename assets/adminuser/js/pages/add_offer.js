$(document).ready(function() {
  
    $('input[name=discounttype]').on('change', function (e) {
      if(this.value==0){
        $("#percentlabel").html("%");
        $('#discount').val("100");
      }else{
        $("#percentlabel").html("&#8377;");
      }
    });
    $('#discount').on('keyup', function (e) {
        if($("#Percentage").is(":checked")==true){
          if(this.value > 100){
              $(this).val("100");
          }
        }
    });
    $('#startdate,#enddate').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn:"linked"
    });
    $('#starttime,#endtime').datetimepicker({
      format: 'hh:ii:ss',
      autoclose: true,
      showMeridian: true,
      startView: 1,
      maxView: 1,
      pickDate: false

    });
      
  });
  
  function resetdata(){
  
    $("#title_div").removeClass("has-error is-focused");
    $("#offercode_div").removeClass("has-error is-focused");
    $("#startdate_div").removeClass("has-error is-focused");
    $("#enddate_div").removeClass("has-error is-focused");
    $("#discount_div").removeClass("has-error is-focused");
    
    if(ACTION==1){
    }else{
      
      $('#title,#offercode,#startdate,#enddate,#discount').val('');
      
      $('#Percentage').prop("checked", true);
      $("#percentlabel").html("%");
      $('.selectpicker').selectpicker('refresh');
    }
    $('html, body').animate({scrollTop:0},'slow');
  }
  function checkvalidation(){
    
    var title = $("#title").val().trim();
    var offercode = $("#offercode").val().trim();
    var startdate = $("#startdate").val().trim();
    var enddate = $("#enddate").val();
    var discount = $("#discount").val();
    
    var isvalid = 1;
    PNotify.removeAll();
    
    if(title == ''){
      $("#title_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter offer title !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else {
      if(title.length<2){
        $("#title_div").addClass("has-error is-focused");
        new PNotify({title: 'Offer title require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalid = 0;
      }else{
        $("#title_div").removeClass("has-error is-focused");
      }
    }
    if(offercode == ''){
      $("#offercode_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter offer code !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else {
        $("#offercode_div").removeClass("has-error is-focused");
    }
    if(startdate == ''){
      $("#startdate_div").addClass("has-error is-focused");
      new PNotify({title: 'Please select start date !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else {
        $("#startdate_div").removeClass("has-error is-focused");
    }
    if(enddate == ''){
      $("#enddate_div").addClass("has-error is-focused");
      new PNotify({title: 'Please select end date !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#enddate_div").removeClass("has-error is-focused");
    }
    if(discount == 0){
      $("#discount_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter discount !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalid = 0;
    }else{
      $("#discount_div").removeClass("has-error is-focused");
    }
    
    if(isvalid==1){
        var formData = new FormData($('#offerform')[0]);
        if(ACTION==0){
            var uurl = SITE_URL+"offer/offer-add";
      
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
                  new PNotify({title: 'Offer successfully added.',styling: 'fontawesome',delay: '3000',type: 'success'});
                  setTimeout(function() { window.location=SITE_URL+"offer"; }, 1500);
                }else if(response==2){
                  new PNotify({title: 'Offer already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else  if(response==0){
                  new PNotify({title: 'Offer not added !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
            
            var uurl = SITE_URL+"offer/update-offer";
      
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
                  new PNotify({title: 'Offer successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                  setTimeout(function() { window.location=SITE_URL+"offer"; }, 1500);
                }else if(response==2){
                  new PNotify({title: 'Offer already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else  if(response==0){
                  new PNotify({title: 'Offer not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
  
  