<div class="page-content">
    <div class="page-heading">    
        <h1>Manage Owner Request</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li><a href="javascript:void(0)">User Management</a></li>
            <li class="active">Manage Owner Request</li>
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
                  
                </div>
              </div>
              <div class="panel-body">
                <table id="user" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">No.</th>
                      <th>Owner Name</th>
                      <th>Restaurant Name</th>
                      <th>Email</th>
                      <th>Mobile No.</th>
                      <th class="width12">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($ownerpendingdata as $row){ ?>
                      <tr>
                        <td><?=$srno; ?></td>
                        <td><?=$row['firstname']." ".$row['lastname']?></td>
                        <td><?=$row['restaurantname']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['mobileno']?></td>
                        <td>
                            <?php 
                                if($row['status']==0){
                                    $status = '<button class="btn btn-warning btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Pending <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(1,'.$row['id'].')">Approve</a>
                                        </li>
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(2,'.$row['id'].')">Reject</a>
                                        </li>
                                    </ul>';
                                }else if($row['status']==1){
                                    $status = '<button class="btn btn-success btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Approved <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(0,'.$row['id'].')">Pending</a>
                                        </li>
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(2,'.$row['id'].')">Reject</a>
                                        </li>
                                    </ul>';
                                }else if($row['status']==2){
                                    $status = '<button class="btn btn-danger btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Rejected <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(0,'.$row['id'].')">Pending</a>
                                        </li>
                                        <li id="dropdown-menu">
                                            <a onclick="chagestatus(1,'.$row['id'].')">Approve</a>
                                        </li>
                                    </ul>';
                                }
                                
                                echo '<div class="dropdown" style="float: left;">'.$status.'</div>';
                            ?>
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
    oTable = $('#user').DataTable({
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
function chagestatus(status, id){
  var uurl = SITE_URL+"manage-owner-request/update-status";
  if(id!=''){
    swal({    title: "Are you sure to change status?",
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Yes, change it!",   
      closeOnConfirm: false }, 
      function(isConfirm){   
        if (isConfirm) {   
          $.ajax({
            url: uurl,
            type: 'POST',
            data: {status:status,id:id},
            beforeSend: function(){
              $('.mask').show();
              $('#loader').show();
            },
            success: function(response){
              if(response==1){
                location.reload();
              }
            },
            complete: function(){
              $('.mask').hide();
              $('#loader').hide();
            },
            error: function(xhr) {
            //alert(xhr.responseText);
            }
          });  
        }
      });
  }           
}
</script>