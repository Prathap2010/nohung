<div class="page-content">
    <div class="page-heading">    
        <h1>View Rider</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li>User Management</li>
            <li><a href="<?php echo ADMIN_URL; ?>iider">Rider</a></li>
            <li class="active">View Rider</li>
          </ol>
        </small>                
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading panel-gray">
                
                <h2>Rider Details</h2>
                
              </div>
              <div class="panel-body p-n">

                <table class="table" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                        <th width="20%">Rider Name</th>
                        <td width="30%"><?=$riderdata['kitchenname']?></td>
                        <th width="20%">Contact Noumber</th>
                        <td width="30%"><?=$riderdata['mobilenumber']?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?=$riderdata['email']?></td>
                        <th>City</th>
                        <td><?=$riderdata['city']?></td>
                    </tr>
                    <tr>
                        <th>What type of bike you have ?</th>
                        <td><?php if($riderdata['biketype']==0) {
                          echo "Regular";
                        }else if($riderdata['biketype']==1) {
                          echo "E-bike";
                        }else if($riderdata['biketype']==2) {
                          echo "Bicycle";
                        }
                        ?></td>
                        <th>Do you have License ?</th>
                        <td><?=($riderdata['youhavelicense']==0 ? "No" : "Yes")?></td>
                    </tr>
                    
                    <tr>
                        <th>Licence</th>
                        <td>
                          <?php if($riderdata['licencefile']!=""){ ?>
                            <a href="<?=DOCUMENT.$riderdata['licencefile']?>" target="_blank" title="View Licence">View Licence File</a>
                            <?php }else{ echo "-"; 
                          } ?>
                        </td> 
                        <th>RC Book</th>
                        <td>
                          <?php if($riderdata['rcbookfile']!=""){ ?>
                            <a href="<?=DOCUMENT.$riderdata['rcbookfile']?>" target="_blank" title="View RC Book">View RC Book File</a>
                            <?php }else{ echo "-"; 
                          } ?>
                        </td> 
                    </tr>
                        
                    <tr>
                        <th>Passport</th>
                        <td>
                          <?php if($riderdata['passportfile']!=""){ ?>
                            <a href="<?=DOCUMENT.$riderdata['passportfile']?>" target="_blank" title="View Passport">View Passport File</a>
                            <?php }else{ echo "-"; 
                          } ?>
                        </td> 
                        <th>ID Proof</th>
                        <td>
                          <?php if($riderdata['idprooffile']!=""){ ?>
                            <a href="<?=DOCUMENT.$riderdata['idprooffile']?>" target="_blank" title="View ID Proof">View ID Proof File</a>
                            <?php }else{ echo "-"; 
                          } ?>
                        </td> 
                    </tr>

                    <tr>
                        <th>User Status</th>
                        <td><?php if($riderdata['userstatus']==1){
                            echo "<span class='label label-success'>Approved</span>";
                        }else if($riderdata['userstatus']==2){
                          echo "<span class='label label-danger'>Rejected</span>";
                        }else if($riderdata['userstatus']==0){
                          echo "<span class='label label-warning'>Pending</span>";
                        } ?></td>
                        <th>Status</th>
                        <td><?php if($riderdata['status']==1){
                            echo "<span class='label label-success'>Active</span>";
                        }else{
                          echo "<span class='label label-danger'>Deactive</span>";
                        } ?></td>
                    </tr>
                    
                    <tr>
                        <th>Created Date</th>
                        <td><?=$this->general_model->displaydatetime($riderdata['createddate']);?></td>
                    </tr>
                  </thead>
                  
                </table>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->