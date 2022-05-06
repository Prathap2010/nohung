<div class="page-content">
    <div class="page-heading">            
        <h1><?php if(isset($contentdata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Content</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>manage-content">Manage Content</a></li>
              <li class="active"><?php if(isset($contentdata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Content</li>
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
      					<form class="form-horizontal" id="contentform">
      						<input type="hidden" name="contentid" id="contentid" value="<?php if(isset($contentdata)){ echo $contentdata['id']; } ?>">
      						
      						<div class="form-group" id="pagename_div">
                                <label for="pagename" class="col-sm-3 control-label">Page Name <span class="mandatoryfield">*</span></label>
                                <div class="col-sm-8">
                                    <input autofocus id="pagename" type="text" name="pagename" value="<?php if(!empty($contentdata)){ echo $contentdata['pagename']; } ?>" class="form-control">
                                </div>
      						</div>
                            <div class="form-group" id="title_div">
                                <label for="title" class="col-sm-3 control-label">Page Title <span class="mandatoryfield">*</span></label>
                                <div class="col-sm-8">
                                    <input autofocus id="title" type="text" name="title" value="<?php if(!empty($contentdata)){ echo $contentdata['title']; } ?>" class="form-control">
                                </div>
      						</div>
      						<div class="form-group" id="description_div">               
								<label for="description" class="col-sm-3 control-label">Page Description <span class="mandatoryfield">*</span></label>
								<div class="col-sm-9">
								<?php $data['controlname']="description";if(isset($contentdata) && !empty($contentdata)){$data['controldata']=$contentdata['description'];} ?>
								<?php $this->load->view(ADMINFOLDER.'includes/ckeditor',$data);?>
								</div>
							</div>      
                            <div class="form-group row">
								<label class="control-label col-md-3" for="Section">Section</label>
								<div class="col-md-9">
									<select id="section" data-live-search="true" name="section" class="selectpicker form-control" data-size="8">
										<option value="">Select Section</option>
										<option value="Company" <?php if(!empty($contentdata) && $contentdata['section'] == "Company"){ echo "selected"; } ?>>Company</option>
                                        <option value="For Foodies" <?php if(!empty($contentdata) && $contentdata['section'] == "For Foodies"){ echo "selected"; } ?>>For Foodies</option>
                                        <option value="For Kitchens" <?php if(!empty($contentdata) && $contentdata['section'] == "For Kitchens"){ echo "selected"; } ?>>For Kitchens</option>
                                        <option value="For Riders" <?php if(!empty($contentdata) && $contentdata['section'] == "For Riders"){ echo "selected"; } ?>>For Riders</option>
                                        <option value="For You" <?php if(!empty($contentdata) && $contentdata['section'] == "For You"){ echo "selected"; } ?>>For You</option>
									</select>
								</div>
							</div>
                            <!-- <div class="form-group" id="metakeywords_div">
                                <label for="metakeywords" class="col-sm-3 control-label">Meta Keywords</label>
                                <div class="col-sm-9">                      
                                <input id="metakeywords" type="text" name="metakeywords" value="<?php if(isset($contentdata)){ echo $contentdata['metakeywords']; } ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group" id="metadescription_div">
                                <label for="metadescription" class="col-md-3 control-label">Meta Description</label>
                                <div class="col-md-9">
                                <textarea id="metadescription" name="metadescription" class="form-control"><?php if(isset($contentdata)){ echo $contentdata['metadescription']; } ?></textarea>
                                </div>
                            </div> -->		
                            <div class="form-group">
                                <label for="focusedinput" class="col-md-3 control-label">Activate</label>
                                <div class="col-md-8">
                                    <div class="col-md-2 col-xs-4" style="padding-left: 0px;">
                                        <div class="radio">
                                        <input type="radio" name="status" id="yes" value="1" <?php if(isset($contentdata) && $contentdata['status']==1){ echo 'checked'; }else{ echo 'checked'; }?>>
                                        <label for="yes">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-4">
                                        <div class="radio">
                                        <input type="radio" name="status" id="no" value="0" <?php if(isset($contentdata) && $contentdata['status']==0){ echo 'checked'; }?>>
                                        <label for="no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>					
      						<div class="col-sm-9 col-sm-offset-3">
      							<div class="form-group">
                                    <?php if(!empty($contentdata)){ ?>
                                        <input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised">
                                    <?php }else{ ?>
                                        <input type="button" id="submit" onclick="checkvalidation(0)" name="submit" value="ADD" class="btn btn-primary btn-raised">
                                        <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised">
                                    <?php } ?>
                                    <a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>manage-content" title=<?=cancellink_title?>><?=cancellink_text?></a>
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
