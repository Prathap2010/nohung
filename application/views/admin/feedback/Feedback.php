<style>
    .star-rating .fa-star {
        color: #ff9f00;
    }
</style>
<div class="page-content">
    <div class="page-heading">    
        <h1>Feedback / Reviews</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Feedback / Reviews</li>
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
                  <!-- <a class="<?=addbtn_class?>" href="<?=ADMIN_URL?>feedback/add-feedback" title="Add New Feedback"><i class="fa fa-plus"></i> Add New Feedback</a> -->
                </div>
              </div>
              <div class="panel-body">
                <table id="feedbacktbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">No.</th>
                      <th>Kitchen Name</th>
                      <th>Customer Name</th>
                      <th>Rating</th>
                      <th>Message</th>
                      <th>Created Time</th>
                      <th class="width15">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($feedbackdata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><?=$row['kitchenname'];?></td>
                        <td><?=$row['customername']?></td>
                        <td>
                        <div id="rating_div">
                            <div class="star-rating">
                                <span class="fa divya <?=($row['rating']<1?"fa-star-o":"fa-star")?>" data-rating="1" style="font-size:20px;"></span>
                                <span class="fa <?=($row['rating']<2?"fa-star-o":"fa-star")?>" data-rating="2" style="font-size:20px;"></span>
                                <span class="fa <?=($row['rating']<3?"fa-star-o":"fa-star")?>" data-rating="3" style="font-size:20px;"></span>
                                <span class="fa <?=($row['rating']<4?"fa-star-o":"fa-star")?>" data-rating="4" style="font-size:20px;"></span>
                                <span class="fa <?=($row['rating']<5?"fa-star-o":"fa-star")?>" data-rating="5" style="font-size:20px;"></span>
                                <!-- <input type="hidden" name="whatever3" class="rating-value" value="1"> -->
                            </div>
                        </div>    
                        </td>
                        <td><a href="javascript:void(0)" title='View Message' onclick="viewmessage(<?=$row['id']?>)">View Message</a></td>
                        <td><?=$this->general_model->displaydatetime($row['createddate']);?></td>
                        <td>
                          <a href="#" onclick="deleterow(<?=$row['id']; ?>,'<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>feedback/delete-feedback')"  class="<?=delete_class?>" title="<?=delete_title?>"><?=stripslashes(delete_text);?></a>
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
    <div class="modal-dialog" role="document" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></button>
                <h4 class="modal-title">Feedback Message</h4>
            </div>
            <div class="modal-body" id="message">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div> 

<script>
    $(document).ready(function() {
        oTable = $('#feedbacktbl').DataTable({
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
    function viewmessage(id){
        var uurl = SITE_URL+"feedback/gefeedbackmessage";
        $("#myModal").modal('show');
        $.ajax({
            url: uurl,
            type: 'POST',
            data: {id:id},
            success: function(response){
                var data = JSON.parse(response);
                $('#message').html(data['message']);
            }
        });
    }
</script>