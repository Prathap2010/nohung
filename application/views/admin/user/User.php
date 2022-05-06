<div class="page-content">
    <div class="page-heading">    
        <h1>Manage Kitchen</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li><a href="javascript:void(0)">User Management</a></li>
            <li class="active">Manage Kitchen</li>
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
                      <th class="width5">No.</th>
                      <th>Kitchen Name</th>
                      <th>Kitchen ID</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>State</th>
                      <th>City</th>
                      <th>Status</th>
                      <th class="width15">Action</th>
                    </tr>
                  </thead>
                  <tbody>
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
          "targets": [4,-1,-2],
          "orderable": false
        } ],
        responsive: true,
        "serverSide": true,
        "ajax": {
            "url": SITE_URL+'user/get-user-list',
            "type": "POST",
            "data": function ( data ) {  
            },
            beforeSend: function(){
              $('.mask').show();
              $('#loader').show();
            },
            error: function(xhr) {
              //alert(xhr.responseText);
            },
            complete: function(){
              $('.mask').hide();
              $('#loader').hide();
            },
        },
    });
    $('.dataTables_filter input').attr('placeholder','Search...');

    //DOM Manipulation to move datatable elements integrate to panel
    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left pr-sm")).find("label").addClass("panel-ctrls-center");

    $('.panel-footer').append($(".dataTable+.row"));
    $('.dataTables_paginate>ul.pagination').addClass("pull-right pagination-lg");
    
    $("#usertype").change(function(){
      oTable.ajax.reload();
    });
});

function chagestatus(userstatus, id){
  var uurl = SITE_URL+"user/update-status";
  if(id!=''){
    swal({    title: "Are you sure to change status ?",
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
            data: {userstatus:userstatus,id:id},
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