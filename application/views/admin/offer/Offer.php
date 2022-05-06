<div class="page-content">
    <div class="page-heading">    
        <h1>Offer Management</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Offer Management</li>
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
                  <a class="<?=addbtn_class?>" href="<?=ADMIN_URL?>offer/add-offer" title="Add New Offer"><i class="fa fa-plus"></i> Add New Offer</a>
                </div>
              </div>
              <div class="panel-body">
                <table id="offertbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width5">No.</th>
                      <th>Offer Title</th>
                      <th class="text-center">Offer Code</th>
                      <th class="text-center">Discount</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Added By</th>
                      <th class="width12">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($offerdata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><?=$row['title'];?></td>
                        <td class="text-center"><?=$row['offercode']?></td>
                        <td class="text-center"><?=$row['discount']. ($row['discounttype']==0 ? " %" : " &#8377;");?></td>
                        <td><?=$this->general_model->displaydate($row['startdate']);?></td>
                        <td><?=$this->general_model->displaydate($row['enddate']);?></td>
                        <td><?=$row['addedbyname'];?></td>
                        <td>
                          <a class="<?=view_class;?> m-n" href="<?=ADMIN_URL?>offer/view-offer/<?=$row['id']; ?>" title="<?=view_title?>"><?=view_text;?></a>
                          <a class="<?=edit_class;?> m-n" href="<?=ADMIN_URL?>offer/edit-offer/<?=$row['id']; ?>" title="<?=edit_title?>"><?=edit_text;?></a>
                          <a href="#" onclick="deleterow(<?=$row['id']; ?>,'<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>offer/delete-offer')"  class="<?=delete_class?> m-n" title="<?=delete_title?>"><?=stripslashes(delete_text);?></a>
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
        oTable = $('#offertbl').DataTable({
            "language": {
                "lengthMenu": "_MENU_"
            },
            "columnDefs": [ {
            "targets": [-1,-2],
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