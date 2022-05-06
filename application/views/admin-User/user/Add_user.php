<script type="text/javascript">
	var profileimgpath = '<?php echo PROFILE;?>';
	var cityid = "<?php if(isset($userdata)){ echo $userdata['cityid']; }else{ echo '0'; } ?>";
</script>
<div class="page-content">
    <div class="page-heading">            
        <h1>Edit Kitchen</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">User Management</a></li>
			  <li><a href="<?php echo ADMIN_URL; ?>user">Kitchen</a></li>
              <li class="active">Edit Kitchen</li>
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
							<div class="form-group row" id="kitchenname_div">
								<label class="control-label col-md-4" for="kitchenname">Kitchen Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="kitchenname" class="form-control" name="kitchenname" value="<?php if(isset($userdata)){ echo $userdata['kitchenname']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
								</div>
							</div>
							<div class="form-group row" id="email_div">
								<label class="control-label col-md-4" for="email">Email <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="email" class="form-control" name="email" value="<?php if(isset($userdata)){ echo $userdata['email']; } ?>" type="text" tabindex="1">
								</div>
							</div>
							<div class="form-group row" id="address_div">
								<label class="control-label col-md-4" for="address">Address <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<textarea id="address" class="form-control" name="address" tabindex="2"><?php if(isset($userdata)){ echo $userdata['address']; } ?></textarea>
								</div>
							</div>
							<div class="form-group row" id="state_div">
								<label class="control-label col-md-4" for="state">State <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<select id="state" data-live-search="true" name="state" class="selectpicker form-control" data-size="8">
										<option value="0">Select State</option>
										<?php if(!empty($provincedata)){
											foreach($provincedata as $state){ ?>
												<option value="<?=$state['id']?>" <?=isset($userdata) && $userdata['stateid']==$state['id']?"selected":""?>><?=$state['name']?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group row" id="city_div">
								<label class="control-label col-md-4" for="city">City <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<select id="city" data-live-search="true" name="city" class="selectpicker form-control" data-size="5">
										<option value="0">Select City</option>
										<?php if(!empty($citydata)){
											foreach($citydata as $city){ ?>
												<option value="<?=$city['id']?>" <?=isset($userdata) && $userdata['cityid']==$city['id']?"selected":""?>><?=$city['name']?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group row" id="pincode_div">
								<label class="control-label col-md-4" for="pincode">Pincode <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="pincode" class="form-control" name="pincode" value="<?php if(isset($userdata)){ echo $userdata['pincode']; } ?>" type="text" tabindex="1" onkeypress="return isNumber(event)">
								</div>
							</div>
							<div class="form-group row" id="panno_div">
								<label class="control-label col-md-4" for="panno">PAN Card</label>
								<div class="col-md-8">
									<input id="panno" class="form-control" name="panno" value="<?php if(isset($userdata)){ echo $userdata['panno']; } ?>" type="text" tabindex="1">
								</div>
							</div>
						</div>
						<div class="col-md-6 p-n">
							<div class="form-group row" id="contactname_div">
								<label class="control-label col-md-4" for="contactname">Contact Person's Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="contactname" class="form-control" name="contactname" value="<?php if(isset($userdata)){ echo $userdata['contactname']; } ?>" type="text" tabindex="1">
								</div>
							</div>
							<div class="form-group row" id="role_div">
								<label class="control-label col-md-4" for="role">Contact Person's Role <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="role" class="form-control" name="role" value="<?php if(isset($userdata)){ echo $userdata['role']; } ?>" type="text" tabindex="1">
								</div>
							</div>
							<div class="form-group row" id="mobilenumber_div">
								<label class="control-label col-md-4" for="mobilenumber">Mobile Number <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="mobilenumber" class="form-control" name="mobilenumber" value="<?php if(isset($userdata)){ echo $userdata['mobilenumber']; } ?>" type="text" tabindex="1" onkeypress="return isNumber(event)">
								</div>
							</div>
							<div class="form-group row" id="kitchencontactnumber_div">
								<label class="control-label col-md-4" for="kitchencontactnumber">Kitchen's Contact Number <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="kitchencontactnumber" class="form-control" name="kitchencontactnumber" value="<?php if(isset($userdata)){ echo $userdata['kitchencontactnumber']; } ?>" type="text" tabindex="1" onkeypress="return isNumber(event)">
								</div>
							</div>
							<div class="form-group row" id="fssai_div">
								<label class="control-label col-md-4" for="fssailicenceno">FSSAI License No.</label>
								<div class="col-md-8">
									<input id="fssailicenceno" class="form-control" name="fssailicenceno" value="<?php if(isset($userdata)){ echo $userdata['fssailicenceno']; } ?>" type="text" tabindex="1">
								</div>
							</div>
							<div class="form-group row" id="expirydate_div">
								<label class="control-label col-md-4" for="expirydate">Expiry Date</label>
								<div class="col-md-8">
									<input id="expirydate" class="form-control" name="expirydate" value="<?php if(isset($userdata) && $userdata['expirydate']!="0000-00-00"){ echo $this->general_model->displaydate($userdata['expirydate']); } ?>" type="text" tabindex="1" readonly>
								</div>
							</div>
							<div class="form-group row" id="gstno_div">
								<label class="control-label col-md-4" for="gstno">GST Registration No.</label>
								<div class="col-md-8">
									<input id="gstno" class="form-control" name="gstno" value="<?php if(isset($userdata)){ echo $userdata['gstno']; } ?>" type="text" tabindex="1">
								</div>
							</div>
						</div>
						<div class="col-md-12 p-n">
							<div class="form-group row" id="description_div">
								<label class="control-label col-md-2" for="description">Description <span class="mandatoryfield">*</span></label>
								<div class="col-md-10">
									<textarea rows="5" id="description" class="form-control" name="description"><?php if(isset($userdata)){ echo $userdata['description']; } ?></textarea>
								</div>
							</div>
							<div class="form-group row" id="menufile_div">
								<input type="hidden" name="oldmenufile" id="oldmenufile" value="<?php if(isset($userdata)){ echo $userdata['menufile']; } ?>">    
								<input type="hidden" id="isvalidmenufile" value="<?php if(isset($userdata) && $userdata['menufile']!=""){ echo 1; }else{ echo 0; } ?>"> 
								<label for="menufile" class="col-md-2 control-label">Upload Menu <span class="mandatoryfield">*</span></label>
								<div class="col-md-6">
									<div class="input-group" id="fileupload">
										<span class="input-group-btn">
											<span class="btn btn-primary btn-raised btn-file">Browse...
												<input type="file" name="menufile" id="menufile" onchange="validfile($(this))">
											</span>
										</span>
										<input type="text" readonly="" id="textmenufile" class="form-control" value="<?php if(isset($userdata)){ echo $userdata['menufile']; } ?>">
									</div>
								</div>
							</div>
							<div class="form-group row" id="documentfile_div">
								<input type="hidden" name="olddocumentfile" id="olddocumentfile" value="<?php if(isset($userdata)){ echo $userdata['documentfile']; } ?>">    
								<input type="hidden" id="isvaliddocumentfile" value="<?php if(isset($userdata) && $userdata['documentfile']!=""){ echo 1; }else{ echo 0; } ?>"> 
								<label for="documentfile" class="col-md-2 control-label">Upload Document <span class="mandatoryfield">*</span></label>
								<div class="col-md-6">
									<div class="input-group" id="fileupload">
										<span class="input-group-btn">
											<span class="btn btn-primary btn-raised btn-file">Browse...
												<input type="file" name="documentfile" id="documentfile" onchange="validfile($(this))">
											</span>
										</span>
										<input type="text" readonly="" id="textdocumentfile" class="form-control" value="<?php if(isset($userdata)){ echo $userdata['documentfile']; } ?>">
									</div>
								</div>
							</div>
							<div class="form-group row" id="profile_image_div">
								<input type="hidden" name="oldprofile_image" id="oldprofile_image" value="<?php if(isset($userdata)){ echo $userdata['profile_image']; } ?>">    
								<input type="hidden" id="isvalidprofile_image" value="<?php if(isset($userdata) && $userdata['profile_image']!=""){ echo 1; }else{ echo 0; } ?>"> 
								<label for="profile_image" class="col-md-2 control-label">Profile Image</label>
								<div class="col-md-6">
									<div class="input-group" id="fileupload">
										<span class="input-group-btn">
											<span class="btn btn-primary btn-raised btn-file">Browse...
												<input type="file" name="profile_image" id="profile_image" onchange="validimage($(this))">
											</span>
										</span>
										<input type="text" readonly="" id="textprofile_image" class="form-control" value="<?php if(isset($userdata)){ echo $userdata['profile_image']; } ?>">
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-6 p-n">
							<div class="form-group">
								<label for="focusedinput" class="col-md-4 control-label">Profile Image</label>
								<div class="col-md-8">
									<input type="hidden" name="oldprofileimage" id="oldprofileimage" value="<?php if(isset($userdata)){ echo $userdata['image']; }?>">
									<input type="hidden" name="removeoldImage" id="removeoldImage" value="0">
									<?php if(isset($userdata) && $userdata['image']!=''){ ?>
										<div class="imageupload" id="profileimage">
											<div class="file-tab"><img src="<?php echo PROFILE.$userdata['image']; ?>" alt="Image preview" class="thumbnail" style="max-width: 150px; max-height: 150px">
												<label id="profileimagelabel" class="btn btn-sm btn-primary btn-raised btn-file">
													<span id="profileimagebtn">Change</span>
													<input type="file" name="image" id="image" accept=".bmp,.bm,.gif,.ico,.jfif,.jfif-tbnl,.jpe,.jpeg,.jpg,.pbm,.png,.svf,.tif,.tiff,.wbmp,.x-png">
												</label>
												<button type="button" class="btn btn-sm btn-danger btn-raised" id="remove" style="display: inline-block;">Remove</button>
											</div>
										</div>
									<?php }else{ ?>
										<div class="imageupload">
											<div class="file-tab">
												<img src="" alt="Image preview" class="thumbnail" style="max-width: 150px; max-height: 150px;">
												<label id="logolabel" class="btn btn-sm btn-primary btn-raised btn-file">
													<span id="profileimagebtn">Select Image</span>
													<input type="file" name="image" id="image" accept=".bmp,.bm,.gif,.ico,.jfif,.jfif-tbnl,.jpe,.jpeg,.jpg,.pbm,.png,.svf,.tif,.tiff,.wbmp,.x-png">
												</label>
												<button type="button" class="btn btn-sm btn-danger btn-raised" id="remove">Remove</button>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div> -->
						<div class="col-md-12 text-center">
							<div class="form-group">
								<label for="focusedinput" class="col-sm-5 control-label text-right">Status</label>
								<div class="col-sm-6">
									<div class="col-sm-2 col-xs-6" style="padding-left: 0px;">
										<div class="radio">
										<input type="radio" name="status" id="yes" value="1" <?php if(isset($userdata) && $userdata['status']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
										<label for="yes">Enable</label>
										</div>
									</div>
									<div class="col-sm-4 col-xs-6">
										<div class="radio">
										<input type="radio" name="status" id="no" value="0" <?php if(isset($userdata) && $userdata['status']==0){ echo 'checked'; }?>>
										<label for="no">Disable</label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<?php if(isset($userdata)){ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
									<input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php }else{ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="ADD" class="btn btn-primary btn-raised">
								  <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php } ?>
								<a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>user" title=<?=cancellink_title?>><?=cancellink_text?></a>
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
