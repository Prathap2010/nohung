<div class="page-content">
    <div class="page-heading">            
        <h1><?php if(isset($emailtemplatedata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Email Template</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>email-template">Email Template</a></li>
              <li class="active"><?php if(isset($emailtemplatedata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Email Template</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
                    <div class="col-sm-12 col-md-9 col-lg-9 col-md-offset-1" style="padding-left: 0px;">
      					<form class="form-horizontal" id="emailtemplateform">
      						<input type="hidden" name="emailtemplateid" id="emailtemplateid" value="<?php if(isset($emailtemplatedata)){ echo $emailtemplatedata['id']; } ?>">
      						
      						<div class="form-group" id="emailtype_div">
      							<label class="col-sm-3 control-label" for="emailtype">Mail <span class="mandatoryfield">*</span></label>
      							<div class="col-sm-6">
      								<select id="emailtype" name="emailtype" data-live-search="true"  class="selectpicker form-control" data-select-on-tab="true" data-size="5">
                        				<option value="0">Select Email Type</option>
                        					<?php foreach ($this->Emailtype as $key => $value) { ?>
      									   		<option value="<?=$key?>" <?php if(isset($emailtemplatedata)){ if(in_array($key, explode(',',$emailtemplatedata['emailtype']))){ echo 'selected'; } } ?> ><?=$value?></option>
                        					<?php }?>
      								</select>									  
      							</div>
      						</div>
      						<div class="form-group" id="subject_div">								
      							<label for="subject" class="col-sm-3 control-label" for="subject">Email Subject <span class="mandatoryfield">*</span></label>
      							<div class="col-sm-6">
      								<input type="text" id="subject" name="subject" value="<?php if(isset($emailtemplatedata)){ echo $emailtemplatedata['subject']; } ?>" maxlength="150" class="form-control">
      							</div>
      						</div>
      						<div class="form-group" id="message_div">               
								<label for="message" class="col-sm-3 control-label">Email Content <span class="mandatoryfield">*</span></label>
								<div class="col-sm-9">
								<?php $data['controlname']="message";if(isset($emailtemplatedata) && !empty($emailtemplatedata)){$data['controldata']=$emailtemplatedata['message'];} ?>
								<?php $this->load->view(ADMINFOLDER.'includes/ckeditor',$data);?>
								</div>
							</div>      							
      						<div class="col-sm-9 col-sm-offset-3">
      							<div class="form-group">
                                    <?php if(!empty($emailtemplatedata)){ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised">
                                    <?php }else{ ?>
                                        <input type="button" id="submit" onclick="checkvalidation(0)" name="submit" value="ADD" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised">
                                    <?php } ?>
                                    <a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>email-template" title=<?=cancellink_title?>><?=cancellink_text?></a>
      							</div>
      						</div>
      						
      					</form>
      				</div>
				</div>
		      </div>
		    </div>
		  </div>
		</div>
		
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->
