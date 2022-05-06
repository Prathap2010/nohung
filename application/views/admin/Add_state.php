<div class="page-content">
    <div class="page-heading">            
        <h1><?php if(isset($statedata)){ echo 'Edit'; }else{ echo 'Add'; } ?> State</h1>                    
        <small>
            <ol class="breadcrumb">                        
              <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
              <li><a href="javascript:void(0)">Region / Area</a></li>
			  <li><a href="<?php echo ADMIN_URL; ?>state">State</a></li>
              <li class="active"><?php if(isset($statedata)){ echo 'Edit'; }else{ echo 'Add'; } ?> State</li>
            </ol>
		</small>
    </div>

    <div class="container-fluid">
                                    
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default">
		        <div class="panel-body">
					<form action="#" id="stateform" class="form-horizontal">
						<input type="hidden" name="stateid" value="<?php if(isset($statedata)){ echo $statedata['id']; } ?>">
						<div class="col-md-12 p-n">
							<div class="form-group row" id="name_div">
								<label class="control-label col-md-4" for="name">Name <span class="mandatoryfield">*</span></label>
								<div class="col-md-4">
									<input id="name" class="form-control" name="name" value="<?php if(isset($statedata)){ echo $statedata['name']; } ?>" type="text" tabindex="1" onkeypress="return onlyAlphabets(event)">
								</div>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<div class="form-group">
								<?php if(isset($statedata)){ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="UPDATE" class="btn btn-primary btn-raised">
									<input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php }else{ ?>
									<input type="button" id="submit" onclick="checkvalidation()" name="submit" value="ADD" class="btn btn-primary btn-raised">
								  <input type="reset" name="reset" value="RESET" class="btn btn-info btn-raised" onclick="resetdata()">
								<?php } ?>
								<a class="<?=cancellink_class;?>" href="<?=ADMIN_URL?>state" title=<?=cancellink_title?>><?=cancellink_text?></a>
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
function resetdata(){

    $("#name_div").removeClass("has-error is-focused");
    
    if(ACTION==1){
    }else{
    
        $('#name').val('');
        
        // $('.selectpicker').selectpicker('refresh');
    }
    $('html, body').animate({scrollTop:0},'slow');
}
function checkvalidation(){

    var name = $("#name").val().trim();
    
    var isvalidname = 0;
    PNotify.removeAll();

    if(name == ''){
        $("#name_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter state name !',styling: 'fontawesome',delay: '3000',type: 'error'});
    }else {
        if(name.length<2){
            $("#name_div").addClass("has-error is-focused");
            new PNotify({title: 'State Name require minimum 2 characters !',styling: 'fontawesome',delay: '3000',type: 'error'});
        }else{
            $("#name_div").removeClass("has-error is-focused");
            isvalidname = 1;
        }
    }
    
    if(isvalidname==1){

    var formData = new FormData($('#stateform')[0]);
    if(ACTION==0){

        var uurl = SITE_URL+"state/state-add";
       
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
                    new PNotify({title: 'State successfully created.',styling: 'fontawesome',delay: '3000',type: 'success'});
                    resetdata();              
                }else if(response==2){
                    new PNotify({title: 'State already exist.',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else if(response==0){
                    new PNotify({title: 'State not create !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
        
        var uurl = SITE_URL+"state/update-state";

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
                    new PNotify({title: 'State successfully updated.',styling: 'fontawesome',delay: '3000',type: 'success'});
                    setTimeout(function() { window.location=SITE_URL+"state"; }, 1500);
                }else if(response==2){
                    new PNotify({title: 'State already exist.',styling: 'fontawesome',delay: '3000',type: 'error'});
                }else if(response==0){
                    new PNotify({title: 'State not updated !',styling: 'fontawesome',delay: '3000',type: 'error'});
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
</script>