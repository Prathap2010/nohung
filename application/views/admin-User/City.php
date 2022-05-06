<div class="page-content">
    <div class="page-heading">    
        <h1>City</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li><a href="javascript:void(0)">Region / Area</a></li>
            <li class="active">City</li>
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
                  <a class="<?=addbtn_class?>" href="<?=ADMIN_URL?>city/add-city" title="Add New City"><i class="fa fa-plus"></i> Add New City</a>
                </div>
              </div>
              <div class="panel-body">
                <table id="citytbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">Sr.No.</th>
                      <th>City Name</th>
                      <th>State</th>
                      <th class="width12">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($citydata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><?=$row['name'];?></td>
                        <td><?=$row['state']?></td>
                        <td>
                          <a class="<?=edit_class;?>" href="<?=ADMIN_URL?>city/edit-city/<?=$row['id']; ?>" title="<?=edit_title?>"><?=edit_text;?></a>
                          <a href="#" onclick="deleterow(<?=$row['id']; ?>,'<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>city/delete-city')"  class="<?=delete_class?>" title="<?=delete_title?>"><?=stripslashes(delete_text);?></a>
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
    oTable = $('#citytbl').DataTable({
        "language": {
            "lengthMenu": "_MENU_"
        },
        "columnDefs": [ {
          "targets": [-1],
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