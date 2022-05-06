<div class="page-content">
    <div class="page-heading">    
        <h1>Order Management</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Order Management</li>
          </ol>
        </small>                
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                
                <div class="col-md-6">
                  <div class="panel-ctrls"></div>
                </div>
                <div class="col-md-6 form-group" style="text-align: right;">
                  <!-- <a class="<?=addbtn_class?>" href="<?=ADMIN_URL?>offer/add-offer" title="Add New Offer"><i class="fa fa-plus"></i> Add New Offer</a> -->
                </div>
              </div>
              <div class="panel-body">
                <table id="ordertbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width5">No.</th>
                      <th>Kitchen</th>
                      <th>Customer Name</th>
                      <th>Order Type</th>
                      <th>OrderID</th>
                      <th>Order Date</th>
                      <th class="text-right">Amount</th>
                      <th class="text-center">Status</th>
                      <th class="width5">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($orderdata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><?=$row['kitchenname'];?></td>
                        <td><?=$row['customer_name'];?></td>
                        <td><?=ucwords($row['ordertype']);?></td>
                        <td><?=$row['orderid'];?></td>
                        <td><?=$this->general_model->displaydate($row['orderdate']);?></td>
                        <td class="text-right"><?=number_format($row['netamount'],2,'.',',')?></td>
                        <td class="text-center">
                            <?php if($row['status']==0){
                                echo '<span class="label label-warning">Pending</span>';
                            }else if($row['status']==1){
                                echo '<span class="label label-success">Approved</span>';
                            }else if($row['status']==2){
                                echo '<span class="label label-danger">Rejected</span>';
                            }else if($row['status']==3){
                                echo '<span class="label label-gray">Ready to Pick</span>';
                            }else if($row['status']==4){
                                echo '<span class="label label-info">Assign to rider</span>';
                            }else if($row['status']==5){
                                echo '<span class="label label-orange">Start delivery</span>';
                            }else if($row['status']==6){
                                echo '<span class="label label-green">Delivered</span>';
                            }else if($row['status']==7){
                                echo '<span class="label label-danger">Cancelled</span>';
                            }
                            ?>
                        </td>
                        <td>
                          <a class="<?=view_class;?>" href="<?=ADMIN_URL?>order/view-order/<?=$row['id']; ?>" title="<?=view_title?>"><?=view_text;?></a>
                        </td>
                      </tr>
                      <?php $srno++; } ?>
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

<script>
    $(document).ready(function() {
        oTable = $('#ordertbl').DataTable({
            "language": {
                "lengthMenu": "_MENU_"
            },
            "columnDefs": [ {
            "targets": [2,-1,-2],
            "orderable": false
            } ],
            responsive: true
        });
        $('.dataTables_filter input').attr('placeholder','Search...');

        //DOM Manipulation to move datatable elements integrate to panel
        $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
        $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left pr-sm")).find("label").addClass("panel-ctrls-center");

        $('.panel-footer').append($(".dataTable+.row"));
        $('.dataTables_paginate>ul.pagination').addClass("pull-right pagination-lg");
    });
</script>