<div class="page-content">
    <div class="page-heading">    
        <h1>Email Template</h1>    
        <small>
          <ol class="breadcrumb">                        
            <li><a href="<?=base_url(); ?><?=ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li class="active">Email Template</li>
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
                    <a class="<?=addbtn_class?>" title="<?=addbtn_title?>" href="<?=ADMIN_URL?>email-template/add-email-template"><?=addbtn_text?> Email Template</a>
                </div>
              </div>
              <div class="panel-body">
                <table id="emailtemplatetable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>            
                      <th class="width8">Sr. No.</th>
                      <th>Email Type</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Created Date</th>
                      <th class="width15">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $srno=1;
                      foreach($emailtemplatedata as $row){ ?>
                      <tr id="tr<?=$row['id']; ?>">
                       
                        <td><?=$srno; ?></td>
                        <td><?=isset($this->Emailtype[$row['emailtype']])?$this->Emailtype[$row['emailtype']]:"-"?></td>
                        <td><?=$row['subject'];?></td>
                        <td><a href='javascript:void(0)' title='View Message' onclick='viewmessage(<?=$row['id']?>)'>View Message</a></td>
                        <td><?=$this->general_model->displaydatetime($row['createddate'])?></td>
                        <td>
                          <a class="<?=edit_class;?>" href="<?=ADMIN_URL?>email-template/edit-email-template/<?=$row['id']; ?>" title="<?=edit_title?>"><?=edit_text;?></a>
                          <a href="#" onclick="deleterow(<?=$row['id']; ?>,'<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>email-template/delete-email-template')"  class="<?=delete_class?>" title="<?=delete_title?>"><?=stripslashes(delete_text);?></a>
                        </td>
                      </tr>
                      <?php $srno++; } ?>
                  </tbody>
                </table>
              </div>
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
                <h4 class="modal-title" id="emailsubject"></h4>
            </div>
            <div class="modal-body" id="message">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div> 