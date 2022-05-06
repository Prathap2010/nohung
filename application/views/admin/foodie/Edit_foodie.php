<div class="page-content">
    <div class="page-heading">            
        <h1>Edit Foodie</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">User Management</a></li>
			  <li><a href="<?php echo ADMIN_URL; ?>user">Foodie</a></li>
              <li class="active">Edit Foodie</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
					<form action="#" id="foodieform" class="form-horizontal">
						<input type="hidden" name="foodieid" value="<?php if(isset($foodiedata)){ echo $foodiedata['id']; } ?>">
						<div class="col-md-12 p-n">
							<div class="form-group row" id="foodiename_div">
								<label class="control-label col-md-5" for="foodiename">Foodie Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-4">
									<input id="foodiename" class="form-control" name="foodiename" value="<?php if(isset($foodiedata)){ echo $foodiedata['kitchenname']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
								</div>
							</div>
							<div class="form-group row" id="email_div">
								<label class="control-label col-md-5" for="email">Email <span class="mandatoryfield">*</span></label>
								<div class="col-md-4">
									<input id="email" class="form-control" name="email" value="<?php if(isset($foodiedata)){ echo $foodiedata['email']; } ?>" type="text" tabindex="1">
								</div>
							</div>
                            <div class="form-group row" id="mobilenumber_div">
                                <label class="control-label col-md-5" for="mobilenumber">Mobile Number <span class="mandatoryfield">*</span></label>
                                <div class="col-md-4">
                                    <input id="mobilenumber" class="form-control" name="mobilenumber" value="<?php if(isset($foodiedata)){ echo $foodiedata['mobilenumber']; } ?>" type="text" tabindex="1" onkeypress="return isNumber(event)">
                                </div>
                            </div>
                            <div class="form-group row" id="password_div">
                                <label class="control-label col-md-5" for="password">Password <span class="mandatoryfield">*</span></label>
                                <div class="col-md-4">
                                    <input id="password" class="form-control" name="password" value="<?php if(isset($foodiedata)){ echo $foodiedata['password']; } ?>" type="password" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row" id="confirmpassword_div">
                                <label class="control-label col-md-5" for="confirmpassword">Confirm Password <span class="mandatoryfield">*</span></label>
                                <div class="col-md-4">
                                    <input id="confirmpassword" class="form-control" name="confirmpassword" value="<?php if(isset($foodiedata)){ echo $foodiedata['password']; } ?>" type="text" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row" id="profile_image_div">
								<input type="hidden" name="oldprofile_image" id="oldprofile_image" value="<?php if(isset($userdata)){ echo $userdata['profile_image']; } ?>">    
								<input type="hidden" id="isvalidprofile_image" value="<?php if(isset($userdata) && $userdata['profile_image']!=""){ echo 1; }else{ echo 0; } ?>"> 
								<label for="profile_image" class="col-md-5 control-label">Profile Image</label>
								<div class="col-md-4">
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
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-5 control-label text-right">Status</label>
                                <div class="col-sm-6">
                                    <div class="col-sm-2 col-xs-6" style="padding-left: 0px;">
                                        <div class="radio">
                                            <input type="radio" name="status" id="yes" value="1" <?php if(isset($foodiedata) && $foodiedata['status']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
                                            <label for="yes">Enable</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="radio">
                                            <input type="radio" name="status" id="no" value="0" <?php if(isset($foodiedata) && $foodiedata['status']==0){ echo 'checked'; }?>>
                                            <label for="no">Disable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-5 control-label"></label>
                                <div class="col-sm-6">
                                    <?php if(isset($foodiedata)){ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
                                    <?php }else{ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="ADD" class="btn btn-primary btn-raised">
                                    <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
                                    <?php } ?>
                                    <a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>foodie" title=<?=cancellink_title?>><?=cancellink_text?></a>
                                </div>
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
