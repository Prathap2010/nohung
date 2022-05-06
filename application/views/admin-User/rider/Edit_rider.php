<div class="page-content">
    <div class="page-heading">            
        <h1>Edit Rider</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">User Management</a></li>
			  <li><a href="<?php echo ADMIN_URL; ?>user">Rider</a></li>
              <li class="active">Edit Rider</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
					<form action="#" id="riderform" class="form-horizontal">
						<input type="hidden" name="riderid" value="<?php if(isset($riderdata)){ echo $riderdata['id']; } ?>">
						<div class="col-md-6 p-n">
							<div class="form-group row" id="ridername_div">
								<label class="control-label col-md-4" for="ridername">Rider Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="ridername" class="form-control" name="ridername" value="<?php if(isset($riderdata)){ echo $riderdata['kitchenname']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
								</div>
							</div>
							<div class="form-group row" id="mobilenumber_div">
                                <label class="control-label col-md-4" for="mobilenumber">Mobile Number <span class="mandatoryfield">*</span></label>
                                <div class="col-md-8">
                                    <input id="mobilenumber" class="form-control" name="mobilenumber" value="<?php if(isset($riderdata)){ echo $riderdata['mobilenumber']; } ?>" type="text" tabindex="1" onkeypress="return isNumber(event)">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-n">
                            <div class="form-group row" id="email_div">
								<label class="control-label col-md-4" for="email">Email <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<input id="email" class="form-control" name="email" value="<?php if(isset($riderdata)){ echo $riderdata['email']; } ?>" type="text" tabindex="1">
								</div>
							</div>
                            <div class="form-group" id="city_div">
                                <label class="control-label col-md-4" for="city">City <span class="mandatoryfield">*</span></label>
								<div class="col-md-8">
									<select id="city" data-live-search="true" name="city" class="selectpicker form-control" data-size="8">
										<option value="0">Select City</option>
										<?php if(!empty($citydata)){
											foreach($citydata as $city){ ?>
												<option value="<?=$city['id']?>" <?=isset($riderdata) && $riderdata['cityid']==$city['id']?"selected":""?>><?=$city['name']?></option>
										<?php }
										} ?>
									</select>
								</div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n">
                            <div class="col-md-6 p-n">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-4 control-label text-right">What type of bike you have?</label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-4 col-xs-6" style="padding-left: 0px;">
                                            <div class="radio">
                                                <input type="radio" name="biketype" id="regularbike" value="0" <?php if(isset($riderdata) && $riderdata['biketype']==0){ echo 'checked'; }else{ echo 'checked'; }?>>
                                                <label for="regularbike">Regular Bike</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-6 pr-n">
                                            <div class="radio">
                                                <input type="radio" name="biketype" id="ebike" value="1" <?php if(isset($riderdata) && $riderdata['biketype']==1){ echo 'checked'; }?>>
                                                <label for="ebike">E-Bike</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6 p-n">
                                            <div class="radio">
                                                <input type="radio" name="biketype" id="bicycle" value="2" <?php if(isset($riderdata) && $riderdata['biketype']==2){ echo 'checked'; }?>>
                                                <label for="bicycle">Bicycle</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-n">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-4 control-label text-right">Do you have License?</label>
                                    <div class="col-sm-6">
                                        <div class="col-sm-2 col-xs-6" style="padding-left: 0px;">
                                            <div class="radio">
                                                <input type="radio" name="youhavelicense" id="licenseyes" value="1" <?php if(isset($riderdata) && $riderdata['youhavelicense']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
                                                <label for="licenseyes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="radio">
                                                <input type="radio" name="youhavelicense" id="licenseno" value="0" <?php if(isset($riderdata) && $riderdata['youhavelicense']==0){ echo 'checked'; }?>>
                                                <label for="licenseno">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n">
                            <div class="col-md-6 p-n">
                                <div class="form-group row" id="licencefile_div">
                                    <input type="hidden" name="oldlicencefile" id="oldlicencefile" value="<?php if(isset($riderdata)){ echo $riderdata['licencefile']; } ?>">    
                                    <input type="hidden" id="isvalidlicencefile" value="<?php if(isset($riderdata) && $riderdata['licencefile']!=""){ echo 1; }else{ echo 0; } ?>"> 
                                    <label for="licencefile" class="col-md-4 control-label">Licence</label>
                                    <div class="col-md-8">
                                        <div class="input-group" id="fileupload">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-raised btn-file">Browse...
                                                    <input type="file" name="licencefile" id="licencefile" onchange="validfile($(this))">
                                                </span>
                                            </span>
                                            <input type="text" readonly="" id="textlicencefile" class="form-control" value="<?php if(isset($riderdata)){ echo $riderdata['licencefile']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="passportfile_div">
                                    <input type="hidden" name="oldpassportfile" id="oldpassportfile" value="<?php if(isset($riderdata)){ echo $riderdata['passportfile']; } ?>">    
                                    <input type="hidden" id="isvalidpassportfile" value="<?php if(isset($riderdata) && $riderdata['passportfile']!=""){ echo 1; }else{ echo 0; } ?>"> 
                                    <label for="passportfile" class="col-md-4 control-label">Passport</label>
                                    <div class="col-md-8">
                                        <div class="input-group" id="fileupload">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-raised btn-file">Browse...
                                                    <input type="file" name="passportfile" id="passportfile" onchange="validfile($(this))">
                                                </span>
                                            </span>
                                            <input type="text" readonly="" id="textpassportfile" class="form-control" value="<?php if(isset($riderdata)){ echo $riderdata['passportfile']; } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-n">
                                <div class="form-group row" id="rcbookfile_div">
                                    <input type="hidden" name="oldrcbookfile" id="oldrcbookfile" value="<?php if(isset($riderdata)){ echo $riderdata['rcbookfile']; } ?>">    
                                    <input type="hidden" id="isvalidrcbookfile" value="<?php if(isset($riderdata) && $riderdata['rcbookfile']!=""){ echo 1; }else{ echo 0; } ?>"> 
                                    <label for="rcbookfile" class="col-md-4 control-label">RC Book</label>
                                    <div class="col-md-8">
                                        <div class="input-group" id="fileupload">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-raised btn-file">Browse...
                                                    <input type="file" name="rcbookfile" id="rcbookfile" onchange="validfile($(this))">
                                                </span>
                                            </span>
                                            <input type="text" readonly="" id="textrcbookfile" class="form-control" value="<?php if(isset($riderdata)){ echo $riderdata['rcbookfile']; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="idprooffile_div">
                                    <input type="hidden" name="oldidprooffile" id="oldidprooffile" value="<?php if(isset($riderdata)){ echo $riderdata['idprooffile']; } ?>">    
                                    <input type="hidden" id="isvalididprooffile" value="<?php if(isset($riderdata) && $riderdata['idprooffile']!=""){ echo 1; }else{ echo 0; } ?>"> 
                                    <label for="idprooffile" class="col-md-4 control-label">ID Proof</label>
                                    <div class="col-md-8">
                                        <div class="input-group" id="fileupload">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-raised btn-file">Browse...
                                                    <input type="file" name="idprooffile" id="idprooffile" onchange="validfile($(this))">
                                                </span>
                                            </span>
                                            <input type="text" readonly="" id="textidprooffile" class="form-control" value="<?php if(isset($riderdata)){ echo $riderdata['idprooffile']; } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-n">
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-5 control-label text-right">Status</label>
                                <div class="col-sm-6">
                                    <div class="col-sm-2 col-xs-6" style="padding-left: 0px;">
                                        <div class="radio">
                                            <input type="radio" name="status" id="yes" value="1" <?php if(isset($riderdata) && $riderdata['status']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
                                            <label for="yes">Enable</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="radio">
                                            <input type="radio" name="status" id="no" value="0" <?php if(isset($riderdata) && $riderdata['status']==0){ echo 'checked'; }?>>
                                            <label for="no">Disable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="focusedinput" class="col-sm-5 control-label"></label>
                                <div class="col-sm-6">
                                    <?php if(isset($riderdata)){ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
                                    <?php }else{ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="ADD" class="btn btn-primary btn-raised">
                                    <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
                                    <?php } ?>
                                    <a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>rider" title=<?=cancellink_title?>><?=cancellink_text?></a>
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
