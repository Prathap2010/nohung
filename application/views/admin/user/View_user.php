<div class="page-content">
    <div class="page-heading">    
        <h1>View Kitchen</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li>User Management</li>
            <li><a href="<?php echo ADMIN_URL; ?>user">Kitchen</a></li>
            <li class="active">View Kitchen</li>
          </ol>
        </small>                
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading panel-gray">
                
                <h2>Kitchen Details</h2>
                
              </div>
              <div class="panel-body p-n">

                <table class="table" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                        <th width="20%">Kitchen Name</th>
                        <td width="30%"><?=$userdata['kitchenname']?></td>
                        <th width="20%">Kitchen Address</th>
                        <td width="30%"><?=$userdata['address']?></td>
                    </tr>
                    <tr>
                        <th>Kitchen ID</th>
                        <td><?=$userdata['kitchenid']?></td>
                        <th>City</th>
                        <td><?=$userdata['city']?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?=$userdata['password']?></td>
                        <th>State</th>
                        <td><?=$userdata['state']?></td>
                    </tr>
                    
                    <tr>
                        <th>Email</th>
                        <td><?=$userdata['email']?></td>
                        <th>Pincode</th>
                        <td><?=$userdata['pincode']?></td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td><?=$userdata['mobilenumber']?></td>
                        <th>FSSAI License No.</th>
                        <td><?=$userdata['fssailicenceno']?></td>
                    </tr>
                    <tr>
                        <th>Kitchen's Contact Number</th>
                        <td><?=$userdata['kitchencontactnumber']?></td>
                        <th>Expiry Date</th>
                        <td><?=($userdata['expirydate']!="0000-00-00"?$this->general_model->displaydate($userdata['expirydate']):"-")?></td>
                    </tr>
                    <tr>
                        <th>PAN Card</th>
                        <td><?=$userdata['panno']?></td>
                        <th>Contact Person's Name</th>
                        <td><?=$userdata['contactname']?></td>
                    </tr>
                    
                    <tr>
                        <th>GST Registration No.</th>
                        <td><?=$userdata['gstno']?></td>
                        <th>Contact Person's Role</th>
                        <td><?=$userdata['role']?></td>
                    </tr>
                    <tr>
                      <th style="vertical-align: top;">Profile Image</th>
                      <td><?php if($userdata['profile_image']!=""){ ?><img class="thumbwidth" src="<?=USER_PROFILE.$userdata['profile_image']?>"><?php }else{ echo "-"; } ?></td>
                      <th style="vertical-align: top;">User Status</th>
                        <td><?php if($userdata['userstatus']==1){
                            echo "<span class='label label-success'>Approved</span>";
                        }else if($userdata['userstatus']==2){
                          echo "<span class='label label-danger'>Rejected</span>";
                        }else if($userdata['userstatus']==0){
                          echo "<span class='label label-warning'>Pending</span>";
                        } ?></td>
                    </tr>
                    <tr>
                        <th>Menu</th>
                        <td><?php if($userdata['menufile']!=""){ ?><a href="<?=MENU.$userdata['menufile']?>" target="_blank">View Menu File</a><?php }else{ echo "-"; } ?></td>
                        <th>Status</th>
                        <td><?php if($userdata['status']==1){
                            echo "<span class='label label-success'>Active</span>";
                        }else{
                          echo "<span class='label label-danger'>Deactive</span>";
                        } ?></td>
                    </tr>
                    <tr>
                      <th style="vertical-align: top;">Description</th>
                      <td colspan="3"><?=($userdata['description']!="" ? $userdata['description'] : "-")?></td>
                    </tr>
                    <tr>
                        <th>Created Date</th>
                        <td><?=$this->general_model->displaydatetime($userdata['createddate']);?></td>
                        <td colspan="2"></td>
                    </tr>
                    
                  </thead>
                  
                </table>
                
                <table class="table" cellspacing="0" width="100%">
                  <thead>
                    <tr class="panel-gray">            
                        <th colspan="3">Documents</th>
                    </tr>
                    <tr>            
                        <th width="6%">Sr. No.</th>
                        <th>File</th>
                        <th>View File</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($documentdata)){
                          foreach($documentdata as $k=>$document){ ?>
                            <tr>
                                <td width="6%"><?=($k+1)?></td>
                                <td><?=(strlen($document['file'])>120 ? substr($document['file'],0,120)."..." : $document['file']) ?></td>
                                <th><?php if($document['file']!=""){ ?><a href="<?=DOCUMENT.$document['file']?>" target="_blank">View File</a><?php } ?></th>
                            </tr>
                    <?php }
                    }else{ ?>
                      <tr>
                        <td colspan="3" class="text-center">No Documents Available.</td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

                <table class="table" cellspacing="0" width="100%">
                  <thead>
                    <tr class="panel-gray">            
                        <th colspan="6">Account Details</th>
                    </tr>
                    <tr>            
                        <th>Sr. No.</th>
                        <th>Name of Account</th>
                        <th>Bank Name</th>
                        <th>IFSC Code</th>
                        <th>Account Number</th>
                        <th>Created Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($bankaccountdata)){
                          foreach($bankaccountdata as $k=>$account){ ?>
                            <tr>
                                <td width="6%"><?=($k+1)?></td>
                                <td><?=$account['account_name']?></td>
                                <td><?=$account['bank_name']?></td>
                                <td><?=$this->general_model->decrypt($account['ifsc_code'])?></td>
                                <td><?=$this->general_model->decrypt($account['account_number'])?></td>
                                <td><?=$this->general_model->displaydatetime($account['createddate'])?></td>
                            </tr>
                      <?php }
                    }else{ ?>
                      <tr>
                        <td colspan="6" class="text-center">No Account Available.</td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->