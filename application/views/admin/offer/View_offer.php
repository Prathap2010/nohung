<div class="page-content">
    <div class="page-heading">    
        <h1>View Offer</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>offer">Offer Management</a></li>
            <li class="active">View Offer</li>
          </ol>
        </small>                
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading panel-gray">
                
                <h2 class="text-white">Offer Details</h2>
                
              </div>
              <div class="panel-body pl-n pr-n">

                <table class="table mb-n" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                        <th width="15%">Offer Title</th>
                        <td width="35%"><?=$offerdata['title']?></td>
                        <th width="15%">Discount</th>
                        <td width="35%"><?=$offerdata['discount'].($offerdata['discounttype']==0?" %":" &#8377;")." Off";?></td>
                    </tr>
                    <tr>
                        <th>Offer Code</th>
                        <td><?=$offerdata['offercode']?></td>
                        <th>Applies To</th>
                        <td><?php if($offerdata['appliesto']==1){
                            echo "Breakfast";
                        }else if($offerdata['appliesto']==2){
                          echo "Lunch";
                        }else if($offerdata['appliesto']==3){
                          echo "Dinner";
                        }else if($offerdata['appliesto']==0){
                          echo "All";
                        } ?></td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td><?=$this->general_model->displaydate($offerdata['startdate'])." ".date("h:i A", strtotime($offerdata['starttime']));?></td>
                        <th>Minimum Requirement</th>
                        <td><?php if($offerdata['minrequirement']==1){
                            echo "Minimum Amount";
                        }else if($offerdata['minrequirement']==2){
                          echo "Minimum Items";
                        }else if($offerdata['minrequirement']==0){
                          echo "None";
                        } ?></td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td><?=$this->general_model->displaydate($offerdata['enddate'])." ".date("h:i A", strtotime($offerdata['endtime']));?></td>
                        <th>Usage Limit</th>
                        <td><?=($offerdata['usagelimit']>0?$offerdata['usagelimit']:"-")?></td>
                    </tr>
                    
                    <tr>
                      <th>Added By</th>
                      <td><?=$offerdata['addedbyname'];?></td>
                      <th>Created Date</th>
                      <td><?=$this->general_model->displaydatetime($offerdata['createddate']);?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td colspan="3"><?=($offerdata['description']!=""?$offerdata['description']:"-")?></td>
                    </tr>
                  </thead>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->