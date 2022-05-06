<div class="page-content">
	
    <div class="page-heading">            
        <h1>Change Password</h1>
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">User</a></li>
              <li class="active">Change Password</li>
            </ol>
        </small>
    </div>

    <div class="container-fluid">
    	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
		        	<div class="col-sm-12 col-md-8 col-lg-8 col-lg-offset-3 col-md-offset-3">
		        		<form id="changepasswordform" class="form-horizontal">
		        			<div class="form-group" id="oldpassword_div">
								<label class="col-sm-3 control-label" for="oldpassword">Old Password <span class="mandatoryfield">*</span></label>
								<div class="col-sm-6">
									<input id="oldpassword" type="password" name="oldpassword" class="form-control">
								</div>
							</div>
							<div class="form-group" id="newpassword_div">
								<label class="col-sm-3 control-label" for="newpassword">New Password <span class="mandatoryfield">*</span></label>
								<div class="col-sm-6">
									<input id="newpassword" type="password" name="newpassword" class="form-control">
								</div>
							</div>
							<div class="form-group" id="confirmpassword_div">
								<label class="col-sm-3 control-label" for="confirmpassword">Confirm Password <span class="mandatoryfield">*</span></label>
								<div class="col-sm-6">
									<input id="confirmpassword" type="password" name="confirmpassword" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-3 control-label"></label>
								<div class="col-sm-6">
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="SUBMIT" class="btn btn-primary btn-raised">
									<a href="<?=ADMIN_URL?>dashboard" title="<?=cancellink_title?>" class="<?=cancellink_class?>"><?=cancellink_text?></a>
								</div>
							</div>
		        		</form>
		        	</div>
				</div>
		      </div>
		    </div>
		  </div>
		</div>
    </div>
</div>