<div class="page-content">
    <div class="page-heading">    
        <h1>Rider Withdraw Payment</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Rider Withdraw Payment</li>
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
                <table id="withdrawpaymenttbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">No.</th>
                      <th>Rider Name</th>
                      <th>Rider Email</th>
                      <th>Rider Contact No.</th>
                      <th class="text-right">Amount</th>
                      <th class="text-center">Status</th>
                      <th>Created Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($withdrawpaymentdata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><a href="<?=ADMIN_URL?>rider/view-rider/<?=$row['userid']?>" target="_blank" title="View Rider"><?=$row['ridername'];?></a></td>
                        <td><?=$row['rideremail'];?></td>
                        <td><?=$row['ridercontactno'];?></td>
                        <td class="text-right"><?=number_format($row['amount'],2,'.',',')?></td>
                        <td class="text-center">
                        <?php 
                            if($row['status']=='pending'){
                                $status = '<button class="btn btn-warning btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Pending <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="dropdown-menu">
                                                    <a onclick="changestatus(\'paid\','.$row['id'].')">Paid</a>
                                                </li>
                                                <li id="dropdown-menu">
                                                    <a onclick="changestatus(\'rejected\','.$row['id'].')">Reject</a>
                                                </li>
                                            </ul>';
                            }else if($row['status']=='paid'){
                                $status = '<button class="btn btn-success btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Paid <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li id="dropdown-menu">
                                        <a onclick="changestatus(\'pending\','.$row['id'].')">Pending</a>
                                    </li>
                                    <li id="dropdown-menu">
                                        <a onclick="changestatus(\'rejected\','.$row['id'].')">Reject</a>
                                    </li>
                                </ul>';
                            }else if($row['status']=='rejected'){
                                $status = '<button class="btn btn-danger btn-xs btn-raised dropdown-toggle" data-toggle="dropdown" id="btndropdown'.$row['id'].'">Rejected <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li id="dropdown-menu">
                                        <a onclick="changestatus(\'pending\','.$row['id'].')">Pending</a>
                                    </li>
                                    <li id="dropdown-menu">
                                        <a onclick="changestatus(\'paid\','.$row['id'].')">Paid</a>
                                    </li>
                                </ul>';
                            }
                            
                            echo '<div class="dropdown">'.$status.'</div>';
                        ?>
                        </td>
                        <td><?=$this->general_model->displaydatetime($row['createddate']);?></td>
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
        oTable = $('#withdrawpaymenttbl').DataTable({
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
    function changestatus(status, id){
        var uurl = SITE_URL+"withdraw-payment/update-status";
        if(id!=''){
            swal({    
                title: "Are you sure to change status ?",
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