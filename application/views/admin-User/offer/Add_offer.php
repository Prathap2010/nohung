<div class="page-content">
    <div class="page-heading">            
        <h1><?php if(isset($offerdata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Offer</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">Offer Management</a></li>
			  <li><a href="<?php echo ADMIN_URL; ?>user">Offer</a></li>
              <li class="active"><?php if(isset($offerdata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Offer</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
					<form action="#" id="offerform" class="form-horizontal">
						<input type="hidden" name="offerid" value="<?php if(isset($offerdata)){ echo $offerdata['id']; } ?>">
						<div class="col-md-12 p-n">
							<div class="col-md-6">
								<div class="form-group row" id="title_div">
									<label class="control-label col-md-3" for="title">Title <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="title" class="form-control" name="title" value="<?php if(isset($offerdata)){ echo $offerdata['title']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="offercode_div">
									<label class="control-label col-md-3" for="offercode">Offer Code <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="offercode" class="form-control" name="offercode" value="<?php if(isset($offerdata)){ echo $offerdata['offercode']; } ?>" type="text" tabindex="1">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="startdate_div">
									<label class="control-label col-md-3" for="startdate">Start Date <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="startdate" name="startdate" type="text" class="form-control" value="<?php if(isset($offerdata)){ echo $this->general_model->displaydate($offerdata['startdate']); } ?>" readonly>            							    
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="enddate_div">
									<label class="control-label col-md-3" for="enddate">End Date <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="enddate" name="enddate" type="text" class="form-control" value="<?php if(isset($offerdata)){ echo $this->general_model->displaydate($offerdata['enddate']); } ?>" readonly>            							    
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="starttime_div">
									<label class="control-label col-md-3" for="starttime">Start Time <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="starttime" name="starttime" type="text" class="form-control" value="<?php if(isset($offerdata)){ echo $offerdata['starttime']; } ?>" readonly>            							    
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="endtime_div">
									<label class="control-label col-md-3" for="endtime">End Time <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="endtime" name="endtime" type="text" class="form-control" value="<?php if(isset($offerdata)){ echo $offerdata['endtime']; } ?>" readonly>            							    
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="description_div">
									<label class="control-label col-md-3" for="description">Description</label>
									<div class="col-md-9">
										<textarea rows="4" id="description" class="form-control" name="description" tabindex="2"><?php if(isset($offerdata)){ echo $offerdata['description']; } ?></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="focusedinput" class="col-sm-3 control-label text-right">Discount Type</label>
									<div class="col-sm-9">
										<div class="col-sm-4 col-xs-6" style="padding-left: 0px;">
											<div class="radio">
											<input type="radio" name="discounttype" id="Percentage" value="0" <?php if(isset($offerdata) && $offerdata['discounttype']==0){ echo 'checked'; }else{ echo 'checked'; }?>>
											<label for="Percentage">Percentage</label>
											</div>
										</div>
										<div class="col-sm-4 col-xs-6">
											<div class="radio">
											<input type="radio" name="discounttype" id="Amount" value="1" <?php if(isset($offerdata) && $offerdata['discounttype']==1){ echo 'checked'; }?>>
											<label for="Amount">Amount</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="discount_div">
									<label class="control-label col-md-3" for="discount">Discount (<span id="percentlabel"><?php if(isset($offerdata) && $offerdata['discounttype']==1){ echo "&#8377;"; }else{ echo "%"; } ?></span>) <span class="mandatoryfield">*</span></label>
									<div class="col-md-9">
										<input id="discount" class="form-control" name="discount" value="<?php if(isset($offerdata)){ echo $offerdata['discount']; } ?>" type="text" tabindex="1" onkeypress="return float_validation(event,this.value,8)">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="focusedinput" class="col-sm-3 control-label text-right">Applies To</label>
									<div class="col-sm-9">
										<div class="col-sm-3 col-xs-6" style="padding-left: 0px;">
											<div class="radio">
											<input type="radio" name="appliesto" id="breakfast" value="1" <?php if(isset($offerdata) && $offerdata['appliesto']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
											<label for="breakfast">Breakfast</label>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="radio">
											<input type="radio" name="appliesto" id="Lunch" value="2" <?php if(isset($offerdata) && $offerdata['appliesto']==2){ echo 'checked'; }?>>
											<label for="Lunch">Lunch</label>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="radio">
											<input type="radio" name="appliesto" id="Dinner" value="3" <?php if(isset($offerdata) && $offerdata['appliesto']==3){ echo 'checked'; }?>>
											<label for="Dinner">Dinner</label>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="radio">
											<input type="radio" name="appliesto" id="All" value="0" <?php if(isset($offerdata) && $offerdata['appliesto']==0){ echo 'checked'; }?>>
											<label for="All">All</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row" id="usagelimit_div">
									<label class="control-label col-md-3" for="usagelimit">Usage Limit</label>
									<div class="col-md-9">
										<input id="usagelimit" name="usagelimit" type="text" class="form-control" value="<?php if(isset($offerdata)){ echo $offerdata['usagelimit']; } ?>">            							    
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label for="focusedinput" class="col-sm-3 control-label text-right" style="padding-left: 0px;">Min Requirement</label>
									<div class="col-sm-9">
										<div class="col-sm-3 col-xs-6" style="padding-left: 0px;">
											<div class="radio">
											<input type="radio" name="minrequirement" id="none" value="0" <?php if(isset($offerdata) && $offerdata['minrequirement']==0){ echo 'checked'; }else{ echo 'checked'; }?>>
											<label for="none">None</label>
											</div>
										</div>
										<div class="col-sm-5 col-xs-6" style="padding-left: 0px;">
											<div class="radio">
											<input type="radio" name="minrequirement" id="minamount" value="1" <?php if(isset($offerdata) && $offerdata['minrequirement']==1){ echo 'checked'; }?>>
											<label for="minamount">Min. Amount</label>
											</div>
										</div>
										<div class="col-sm-4 col-xs-6" style="padding-left: 0px;">
											<div class="radio">
											<input type="radio" name="minrequirement" id="minitems" value="2" <?php if(isset($offerdata) && $offerdata['minrequirement']==2){ echo 'checked'; }?>>
											<label for="minitems">Min. Items</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<div class="form-group">
								<?php if(isset($offerdata)){ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
									<input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php }else{ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="ADD" class="btn btn-primary btn-raised">
								  <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php } ?>
								<a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>offer" title=<?=cancellink_title?>><?=cancellink_text?></a>
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
