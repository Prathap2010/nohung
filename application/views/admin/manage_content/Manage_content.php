<div class="page-content">
    <div class="page-heading">    
        <h1>Manage Content</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Manage Content</li>
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
                  <a class="<?=addbtn_class?>" href="<?=ADMIN_URL?>manage-content/add-content" title="Create Codes"><i class="fa fa-plus"></i> Add Content</a>
                </div>
              </div>
              <div class="panel-body">
                <table id="managecontenttable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">No.</th>
                      <th>Page Name</th>
                      <th>Page Title</th>
                      <th>Description</th>
                      <th>Section</th>
                      <th class="width15">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($contentdata as $row){ ?>
                      <tr>
                        <td><?=$srno; ?></td>
                        <td><?=$row['pagename']?></td>
                        <td><?=$row['title']?></td>
                        <td><a data-toggle="modal" data-target="#myModal" onclick="getcontent(<?=$row['id']; ?>)">View Description</a></td>
                        <td><?=$row['section']?></td>
                        <td>
                          <a class="<?=edit_class;?>" href="<?=ADMIN_URL?>manage-content/edit-content/<?=$row['id']; ?>" title="<?=edit_title?>"><?=edit_text;?></a>
                          <a href="javascript:void(0)" onclick="deleterow(<?=$row['id']; ?>,'<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>manage-content/delete-content')"  class="<?=delete_class?>" title="<?=delete_title?>"><?=stripslashes(delete_text);?></a>

                          <?php if($row['status']==1){ ?>
                            <span id="span<?=$row['id']; ?>"><a href="javascript:void(0)" onclick="enabledisable(0,<?=$row['id']; ?>,'<?=ADMIN_URL; ?>manage-content/content-enable-disable','<?=disable_title?>','<?=disable_class?>','<?=enable_class?>','<?=disable_title?>','<?=enable_title?>','<?=disable_text?>','<?=enable_text?>')" class="<?=disable_class?>" title="<?=disable_title?>"><?=stripslashes(disable_text)?></a></span>
                          <?php }else{ ?>
                            <span id="span<?=$row['id']; ?>"><a href="javascript:void(0)" onclick="enabledisable(1,<?=$row['id']; ?>,'<?=ADMIN_URL; ?>manage-content/content-enable-disable','<?=enable_title?>','<?=disable_class?>','<?=enable_class?>','<?=disable_title?>','<?=enable_title?>','<?=disable_text?>','<?=enable_text?>')" class="<?=enable_class?>" title="<?=enable_title?>"><?=stripslashes(enable_text)?></a></span>
                          <?php } ?>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 950px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
        <h4 class="modal-title" id="pagename"></h4>
      </div>
      <div class="modal-body">
          <div id="description"></div>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
function getcontent(id){

  var uurl = SITE_URL+"manage-content/getcontentbyid";
  $.ajax({
    url: uurl,
    type: 'POST',
    data: {id:String(id)},
    async: false,
    success: function(response){
      var JSONObject = JSON.parse(response);
      
      $('#pagename').html(JSONObject['pagename']+" Page Description");
      $('#description').html(JSONObject['description'].replace(/&nbsp;/g, ' '));
    },
    error: function(xhr) {
    //alert(xhr.responseText);
    },
  });
}

  
$(document).ready(function() {
    oTable = $('#managecontenttable').DataTable({
        "language": {
            "lengthMenu": "_MENU_"
        },
        "columnDefs": [ {
          "targets": [-1,-2],
          "orderable": false
        } ],
        responsive: true,
       
    });
    $('.dataTables_filter input').attr('placeholder','Search...');

    //DOM Manipulation to move datatable elements integrate to panel
    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left pr-sm")).find("label").addClass("panel-ctrls-center");

    $('.panel-footer').append($(".dataTable+.row"));
    $('.dataTables_paginate>ul.pagination').addClass("pull-right pagination-lg");
    
});
</script>