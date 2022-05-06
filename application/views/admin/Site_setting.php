<style>
    .panel-gray h2{
        color: #fff !important;
    }
</style>
<div class="page-content">
    <div class="page-heading">            
        <h1>Site Setting</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li class="active">Site Setting</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body p-n">
					<form action="#" id="settingform" class="form-horizontal">
                        <div class="panel-heading panel-gray"><h2>General Setting</h2></div>
						<div class="col-md-6">
							<div class="form-group row" id="sitename_div">
								<label class="control-label col-md-4" for="sitename">Site Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
								    <input id="sitename" class="form-control" name="sitename" value="<?php if(isset($settingdata)){ echo $settingdata['sitename']; } ?>" type="text" tabindex="1">
								</div>
							</div>
							<div class="form-group row" id="email_div">
								<label class="control-label col-md-4" for="email">Site Email <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
								    <input id="email" class="form-control" name="email" value="<?php if(isset($settingdata)){ echo $settingdata['email']; } ?>" type="text" tabindex="2">
								</div>
							</div>
                            <div class="form-group row" id="mapapikey_div">
								<label class="control-label col-md-4" for="email">Maps API Key <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
								    <input id="mapapikey" class="form-control" name="mapapikey" value="<?php if(isset($settingdata)){ echo $settingdata['mapapikey']; } ?>" type="text" tabindex="2">
								</div>
							</div>
                        </div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="focusedinput" class="col-md-4 control-label">Site Logo <span
															class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input type="hidden" name="oldlogo" id="oldlogo" value="<?php if(isset($settingdata)){ echo $settingdata['logo']; }?>">
									<input type="hidden" name="removeoldlogo" id="removeoldlogo" value="0">
									<?php if(isset($settingdata) && $settingdata['logo']!=''){ ?>
										<div class="imageupload" id="logo">
											<div class="file-tab"><img src="<?php echo SETTING.$settingdata['logo']; ?>" alt="Image preview" class="thumbnail" style="max-width: 150px; max-height: 150px">
												<label id="logolabel" class="btn btn-sm btn-primary btn-raised btn-file">
													<span id="logobtn">Change</span>
													<!-- The file is stored here. -->
													<input type="file" name="logo" id="logo" accept=".bmp,.bm,.gif,.ico,.jfif,.jfif-tbnl,.jpe,.jpeg,.jpg,.pbm,.png,.svf,.tif,.tiff,.wbmp,.x-png">
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
													<span id="logobtn">Select Image</span>
													<input type="file" name="logo" id="logo" accept=".bmp,.bm,.gif,.ico,.jfif,.jfif-tbnl,.jpe,.jpeg,.jpg,.pbm,.png,.svf,.tif,.tiff,.wbmp,.x-png">
												</label>
												<button type="button" class="btn btn-sm btn-danger btn-raised" id="remove">Remove</button>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
                        <div class="col-md-12 p-n">
                            <div class="col-md-6">
                                <div class="form-group row" id="taxonorder_div">
                                    <label class="control-label col-md-4" for="taxonorder">GST Tax on Order (%) </label>
                                    <div class="col-md-8">
                                        <input id="taxonorder" class="form-control" name="taxonorder" value="<?php if(isset($settingdata)){ echo $settingdata['taxonorder']; } ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group row" id="delivery_charge_per_km_div">
                                    <label class="control-label col-md-4" for="delivery_charge_per_km">Delivery Charge / KM </label>
                                    <div class="col-md-8">
                                        <input id="delivery_charge_per_km" class="form-control" name="delivery_charge_per_km" value="<?php if(isset($settingdata)){ echo $settingdata['delivery_charge_per_km']; } ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" id="radius_in_km_div">
                                    <label class="control-label col-md-4" for="radius_in_km">Radius in KM </label>
                                    <div class="col-md-8">
                                        <input id="radius_in_km" class="form-control" name="radius_in_km" value="<?php if(isset($settingdata)){ echo $settingdata['radius_in_km']; } ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group row" id="radius_in_km_div">
                                    <label class="control-label col-md-4" for="points_per_km">Points / KM </label>
                                    <div class="col-md-8">
                                        <input id="points_per_km" class="form-control" name="points_per_km" value="<?php if(isset($settingdata)){ echo $settingdata['points_per_km']; } ?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n mt-md">
                            <div class="panel-heading panel-gray"><h2>Mail Setting</h2></div>
                            <div class="col-md-6">
                                <div class="form-group row" id="portemail_div">
                                    <label class="control-label col-md-4" for="portemail">Email</label>
                                    <div class="col-md-8">
                                        <input id="portemail" type="text" name="portemail" value="<?php if(isset($settingdata)){ echo $settingdata['portemail']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                                <div class="form-group row" id="password_div">
                                    <label class="control-label col-md-4" for="password">Password</label>	
                                    <div class="col-md-8">
                                        <input id="password" type="text" name="password" value="<?php if(isset($settingdata)){ echo $settingdata['password']; } ?>" class="form-control" tabindex="4">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" id="portno_div">
                                    <label class="control-label col-md-4" for="portno">Port No.</label>	
                                    <div class="col-md-8">
                                        <input id="portno" type="text" name="portno" value="<?php if(isset($settingdata)){ echo $settingdata['portno']; } ?>" class="form-control" tabindex="3" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group row" id="mailserver_div">
                                    <label class="control-label col-md-4" for="mailserver">Mail Server</label>	
                                    <div class="col-md-8">
                                        <input id="mailserver" type="text" name="mailserver" value="<?php if(isset($settingdata)){ echo $settingdata['mailserver']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" id="mailhost_div">
                                    <label class="control-label col-md-4" for="mailhost">Mail Host</label>
                                    <div class="col-md-8">
                                        <input id="mailhost" type="text" name="mailhost" value="<?php if(isset($settingdata)){ echo $settingdata['mailhost']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n mt-md">
                            <div class="panel-heading panel-gray"><h2>Facebook Login Setting</h2></div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4" for="facebook_app_id">Facebook App ID</label>
                                    <div class="col-md-8">
                                        <input id="facebook_app_id" type="text" name="facebook_app_id" value="<?php if(isset($settingdata)){ echo $settingdata['facebook_app_id']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4" for="facebook_app_secret">Facebook App SECRET</label>
                                    <div class="col-md-8">
                                        <input id="facebook_app_secret" type="text" name="facebook_app_secret" value="<?php if(isset($settingdata)){ echo $settingdata['facebook_app_secret']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n mt-md">
                            <div class="panel-heading panel-gray"><h2>Google Login Setting</h2></div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4" for="google_client_id">Google Client ID</label>
                                    <div class="col-md-8">
                                        <input id="google_client_id" type="text" name="google_client_id" value="<?php if(isset($settingdata)){ echo $settingdata['google_client_id']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4" for="google_api_key">Google API Key</label>
                                    <div class="col-md-8">
                                        <input id="google_api_key" type="text" name="google_api_key" value="<?php if(isset($settingdata)){ echo $settingdata['google_api_key']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4" for="google_client_secret">Google Client SECRET</label>
                                    <div class="col-md-8">
                                        <input id="google_client_secret" type="text" name="google_client_secret" value="<?php if(isset($settingdata)){ echo $settingdata['google_client_secret']; } ?>" class="form-control" tabindex="3">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-12 p-n mt-md">
                            <div class="panel-heading panel-gray"><h2>Social Media Link</h2></div>
                            <div class="col-md-12">
                                <div class="form-group row" id="facebooklink_div">
                                    <label class="control-label col-md-2" for="facebooklink">Facebook Link</label>
                                    <div class="col-md-9">
                                        <input id="facebooklink" class="form-control" name="facebooklink" value="<?php if(isset($settingdata)){ echo $settingdata['facebooklink']; } ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group row" id="instagramlink_div">
                                    <label class="control-label col-md-2" for="instagramlink">Instagram Link</label>
                                    <div class="col-md-9">
                                        <input id="instagramlink" class="form-control" name="instagramlink" value="<?php if(isset($settingdata)){ echo $settingdata['instagramlink']; } ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group row" id="twitterlink_div">
                                    <label class="control-label col-md-2" for="twitterlink">Twitter Link</label>
                                    <div class="col-md-9">
                                        <input id="twitterlink" class="form-control" name="twitterlink" value="<?php if(isset($settingdata)){ echo $settingdata['twitterlink']; } ?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
							<div class="form-group">
                                <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="Save Settings" class="btn btn-primary btn-raised">
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
<script>
$(document).ready(function() {
  
  if($('#oldlogo').val()!=''){
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
    $('#removeoldoldlogo').val('1');
  });
  $("#taxonorder").on("keyup", function(){
      if(this.value > 100){
        $(this).val("100");
      }
  });
});
function checkvalidation(){
  
    var sitename = $("#sitename").val().trim();
    var email = $("#email").val().trim();
    var logobtn = $("#logobtn").html();
    var portemail = $("#portemail").val();
    var mapapikey = $("#mapapikey").val();

    var isvalidsitename = isvalidemail = isvalidlogo = isvalidmapapikey = 0;
    var isvalidpassword = isvalidportemail = 1;
    PNotify.removeAll();
    
    if(sitename == ''){
        $("#sitename_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter site name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
        if(sitename.length<2){
        $("#sitename_div").addClass("has-error is-focused");
        new PNotify({title: 'Site name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
        $("#sitename_div").removeClass("has-error is-focused");
        isvalidsitename = 1;
        }
    }
    
    if(email == ''){
        $("#email_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter email !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidemail = 0;
    }else{
        if(!ValidateEmail(email)){
            $("#email_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter valid email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
            isvalidemail = 0;
        }else{
            $("#email_div").removeClass("has-error is-focused");
            isvalidemail = 1;
        }
    }
    if(mapapikey == ''){
        $("#mapapikey_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter map api key !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidmapapikey = 0;
    }else{
        $("#mapapikey_div").removeClass("has-error is-focused");
        isvalidmapapikey = 1;
    }
    
    if(logobtn.trim() == 'Select Image'){
        $('#logo img').css({"border":"1px solid #FFB9BD"});
        new PNotify({title: 'Please select site logo !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidlogo = 0;
    }else { 
        isvalidlogo = 1;
    }
    if(portemail != '' && !ValidateEmail(email)){
        $("#portemail_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter valid port email address !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidportemail = 0;
    }else{
        $("#portemail_div").removeClass("has-error is-focused");
        isvalidportemail = 1;
    }
  
    if(isvalidsitename==1 && isvalidemail==1 && isvalidlogo == 1 && isvalidmapapikey == 1 && isvalidportemail == 1){
    
        var formData = new FormData($('#settingform')[0]);
    
        var uurl = SITE_URL+"site-setting/update-settings";
        
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
                    new PNotify({title: 'Site setting successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                    setTimeout(function() { window.location.reload(); }, 1500);
                }else if(response==2){
                    new PNotify({title: 'Logo image not uploaded !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else if(response==3){
                    new PNotify({title: 'Invalid type of logo image !',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else  if(response==0){
                    new PNotify({title: 'Site setting not update !',styling: 'fontawesome',delay: '3000',type: 'error'});
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