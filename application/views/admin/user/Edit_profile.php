<script type="text/javascript">
	var PROFILE = '<?php echo PROFILE;?>';
</script>
<div class="page-content">
   
    <div class="page-heading">            
        <h1>Edit Profile</h1>
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">User</a></li>
              <li class="active">Edit Profile</li>
            </ol>
        </small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
              <form action="#" id="userform" class="form-horizontal">
                <input type="hidden" name="userid" value="<?php if(isset($userdata)){ echo $userdata['id']; } ?>">
                <div class="col-md-6 p-n">
                  <div class="form-group row" id="firstname_div">
                    <label class="control-label col-md-4" for="firstname">First Name <span class="mandatoryfield">*</span></label>
                    <div class="col-md-8">
                      <input id="firstname" class="form-control" name="firstname" value="<?php if(isset($userdata)){ echo $userdata['firstname']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
                    </div>
                  </div>
                  <div class="form-group row" id="lastname_div">
                    <label class="control-label col-md-4" for="lastname">Last Name <span class="mandatoryfield">*</span></label>
                    <div class="col-md-8">
                      <input id="lastname" class="form-control" name="lastname" value="<?php if(isset($userdata)){ echo $userdata['lastname']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
                    </div>
                  </div>
                  <div class="form-group row" id="email_div">
                    <label class="control-label col-md-4" for="email">Email <span class="mandatoryfield">*</span></label>
                    <div class="col-md-8">
                      <input id="email" type="text" name="email" value="<?php if(isset($userdata)){ echo $userdata['email']; } ?>" class="form-control" tabindex="6">
                    </div>
                  </div>
                  <div class="form-group row" id="mobile_div">
                    <label class="control-label col-md-4" for="mobileno">Mobile No <span class="mandatoryfield">*</span></label>	
                    <div class="col-md-8">
                      <input id="mobileno" type="text" name="mobileno" value="<?php if(isset($userdata)){ echo $userdata['mobileno']; } ?>" class="form-control" maxlength="10"  onkeypress="return isNumber(event)" tabindex="8">
                    </div>
                  </div>
                </div>
                <div class="col-md-6 p-n">
                  <div class="form-group row">
                    <label for="focusedinput" class="col-md-4 control-label">Profile Image</label>
                    <div class="col-md-8">
                      <input type="hidden" name="oldprofileimage" id="oldprofileimage" value="<?php if(isset($userdata)){ echo $userdata['image']; }?>">
                      <input type="hidden" name="removeoldImage" id="removeoldImage" value="0">
                      <?php if(isset($userdata) && $userdata['image']!=''){ ?>
                        <div class="imageupload" id="profileimage">
                            <div class="file-tab"><img src="<?php echo PROFILE.$userdata['image']; ?>" alt="Image preview" class="thumbnail" style="max-width: 150px; max-height: 150px">
                                <label id="profileimagelabel" class="btn btn-sm btn-primary btn-raised btn-file">
                                    <span id="profileimagebtn">Change</span>
                                    <!-- The file is stored here. -->
                                    <input type="file" name="image" id="image"  accept=".jpeg,.png,.jpg,.ico,.JPEG,.PNG,.JPG">
                                </label>
                                <button type="button" class="btn btn-sm btn-danger btn-raised" id="remove" style="display: inline-block;">Remove</button>
                            </div>
                        </div>
                      <?php }else{ ?>
                        <!-- <script type="text/javascript"> var ACTION = 0;</script> -->
                        <div class="imageupload">
                            <div class="file-tab">
                              <img src="" alt="Image preview" class="thumbnail" style="max-width: 150px; max-height: 150px;">
                                <label id="logolabel" class="btn btn-sm btn-primary btn-raised btn-file">
                                    <span id="profileimagebtn">Select Image</span>
                                    <input type="file" name="image" id="image"  accept=".jpeg,.png,.jpg,.ico,.JPEG,.PNG,.JPG">
                                </label>
                                <button type="button" class="btn btn-sm btn-danger btn-raised" id="remove">Remove</button>
                            </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12" style="text-align: center;">
                      <hr>
                  <div class="form-group">
                    <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
                    <a href="<?=ADMIN_URL?>dashboard" title="<?=cancellink_title?>" class="<?=cancellink_class?>"><?=cancellink_text?></a>
                  </div>
                </div>
              </form>
            </div>
		      </div>
		    </div>
		  </div>
		</div>
		
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->
<script type="text/javascript">
$(document).ready(function() {
  
  if($('#oldprofileimage').val()!=''){
    var $imageupload = $('.imageupload');
    $imageupload.imageupload({
      url: SITE_URL,
      type: '1',
      allowedFormats: [ 'jpg', 'jpeg', 'png','ico']
    });
  }else{
    var $imageupload = $('.imageupload');
    $imageupload.imageupload({
      url: SITE_URL,
      type: '0',
      allowedFormats: [ 'jpg', 'jpeg', 'png','ico']
    });
  }

  $('#remove').click(function(){
    $('#removeoldImage').val('1');
  });
});

function resetdata(){

	$("#firstname_div").removeClass("has-error is-focused");
	$("#lastname_div").removeClass("has-error is-focused");
	$("#email_div").removeClass("has-error is-focused");
	$("#mobile_div").removeClass("has-error is-focused");

  if(ACTION==1){
    var temp = new Array();
    temp = oldbranchid.split(',');

    if($('#oldprofileimage').val()!=''){
      var $imageupload = $('.imageupload');
      $('.imageupload img').attr('src',profileimgpath+'/'+$('#oldprofileimage').val());
      $imageupload.imageupload({
        url: SITE_URL,
        type: '1'
      });
    }else{
      $('.imageupload').imageupload({
        url: SITE_URL,
        type: '0',
      });
    }
    
    $('#removeoldImage').val('0');
    
    $('.selectpicker').selectpicker('refresh');
    $('html, body').animate({scrollTop:0},'slow');
  }
}
function checkvalidation(){

  var firstname = $("#firstname").val().trim();
  var lastname = $("#lastname").val().trim();
  var mobileno = $("#mobileno").val();
  var email = $("#email").val().trim();

  var isvalidfirstname = isvalidlastname = isvalidmobileno = isvalidemail = 0;

  PNotify.removeAll();
  if(firstname == ''){
    $("#firstname_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter first name !',styling: 'fontawesome',delay: '3000',type: 'error'});
  }else {
    if(firstname.length<2){
      $("#firstname_div").addClass("has-error is-focused");
      new PNotify({title: 'First name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#firstname_div").removeClass("has-error is-focused");
      isvalidfirstname = 1;
    }
  }
  if(lastname == ''){
    $("#lastname_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter last name !',styling: 'fontawesome',delay: '3000',type: 'error'});
  }else {
    if(lastname.length<2){
      $("#lastname_div").addClass("has-error is-focused");
      new PNotify({title: 'Last name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#lastname_div").removeClass("has-error is-focused");
      isvalidlastname = 1;
    }
  }
  if(mobileno == ''){
    $("#mobile_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter mobile no. !',styling: 'fontawesome',delay: '3000',type: 'error'});
  }else{
    if(mobileno.length != 10){
      $("#mobile_div").addClass("has-error is-focused");
      new PNotify({title: 'Mobile number require only 10 digits !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
      $("#mobile_div").removeClass("has-error is-focused");
      isvalidmobileno = 1;
    }
  }
  if(email == ''){
    $("#email_div").addClass("has-error is-focused");
    new PNotify({title: 'Please enter email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
  }else{
    if(!ValidateEmail(email)){
        $("#email_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter valid email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else{
        $("#email_div").removeClass("has-error is-focused");
        isvalidemail = 1;
    }
  }
  
  if(isvalidfirstname==1 && isvalidlastname==1 && isvalidmobileno==1 && isvalidemail==1){

    var formData = new FormData($('#userform')[0]);
   
    var uurl = SITE_URL+"user/update-profile";

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
          new PNotify({title: "Profile successfully updated !",styling: 'fontawesome',delay: '3000',type: 'success'});
          setTimeout(function() { location.reload(); }, 1500);
        }else if(response==2){
          new PNotify({title: 'Email already register !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else if(response==3){
          new PNotify({title: 'Profile image not uploaded !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else if(response==4){
          new PNotify({title: 'Invalid type of profile image !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
          new PNotify({title: 'Profile not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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


</script>