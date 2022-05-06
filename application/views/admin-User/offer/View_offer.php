<div class="page-content">
    <div class="page-heading">    
        <h1>View Offer</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li>Offer Management</li>
            <li class="active">View Offer</li>
          </ol>
        </small>                
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                
                <h2>Offer Details</h2>
                
              </div>
              <div class="panel-body">

                <table class="table mb-n" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                        <th width="20%">Offer Title</th>
                        <td><?=$offerdata['title']?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?=($offerdata['description']!=""?$offerdata['description']:"-")?></td>
                    </tr>
                    <tr>
                        <th>Offer Code</th>
                        <td><?=$offerdata['offercode']?></td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td><?=$offerdata['discount'].($offerdata['discounttype']==0?" %":" &#8377;")." Off";?></td>
                    </tr>
                    <tr>
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
                        <th>Usage Limit</th>
                        <td><?=($offerdata['usagelimit']>0?$offerdata['usagelimit']:"-")?></td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td><?=$this->general_model->displaydate($offerdata['startdate'])." ".date("h:i A", strtotime($offerdata['starttime']));?></td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td><?=$this->general_model->displaydate($offerdata['enddate'])." ".date("h:i A", strtotime($offerdata['endtime']));?></td>
                    </tr>
                    <tr>
                        <th>Added By</th>
                        <td><?=$offerdata['addedbyname'];?></td>
                    </tr>
                    <tr>
                        <th>Created Date</th>
                        <td><?=$this->general_model->displaydatetime($offerdata['createddate']);?></td>
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