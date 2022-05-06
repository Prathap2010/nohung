<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Email_template');
        $this->load->model('Email_template_model', 'Email_template');
    }

    public function index() {
        
        $this->viewData['title'] = "Email Template";
        $this->viewData['module'] = "email_template/Email_template";

        $this->viewData['emailtemplatedata'] = $this->Email_template->getEmailtemplateListData(); 

        $this->admin_headerlib->add_bottom_javascripts("email_template", "pages/email_template.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }
    public function add_email_template(){

		$this->viewData['title'] = "Add Email Template";
        $this->viewData['module'] = "email_template/Add_email_template";

		$this->admin_headerlib->add_javascript("email_template","pages/add_email_template.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
    
    public function email_template_add() {

        $PostData = $this->input->post();
       
        $emailtype = trim($PostData['emailtype']);
        $subject = trim($PostData['subject']);
        $message = trim($PostData['message']);

        $createddate = $this->general_model->getCurrentDateTime();
        $Check = $this->Email_template->CheckMailtemplateAvailable($emailtype);

        if ($Check != 0) {

            $insertdata = array(
                "emailtype" => $emailtype,
                "subject" => $subject,
                "message" => $message,
                "createddate" => $createddate,
                "modifieddate" => $createddate);
            
            $EmailtemplatesID = $this->Email_template->Add($insertdata);

            if ($EmailtemplatesID) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function edit_email_template($id) {
        $this->viewData['title'] = "Edit Email Template";
        $this->viewData['module'] = "email_template/Add_email_template";
        $this->viewData['action'] = "1"; //Edit
        
        $this->Email_template->_where = array('id' => $id);
        $this->viewData['emailtemplatedata'] = $this->Email_template->getRecordsByID();
        
       $this->admin_headerlib->add_javascript("email_template", "pages/add_email_template.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function update_email_template() {

        $PostData = $this->input->post();

        $emailtemplateid = trim($PostData['emailtemplateid']);
        $emailtype = trim($PostData['emailtype']);
        $subject = trim($PostData['subject']);
        $message = trim($PostData['message']);

        $CheckMailTemplatesCode = $this->Email_template->CheckMailtemplateAvailable($emailtype,$emailtemplateid);
        
        if ($CheckMailTemplatesCode != 0) {
            
            $modifieddate = $this->general_model->getCurrentDateTime();

            $updatedata = array(
                "emailtype" => $emailtype,
                "subject" => $subject,
                "message" => $message,
                "modifieddate" => $modifieddate);

            $this->Email_template->_where = array('id' => $emailtemplateid);
            $this->Email_template->Edit($updatedata);
                
            echo 1;
        } else {
            echo 2;
        }
    }

    function getemailmessage(){
        $PostData = $this->input->post();
        
        $query = $this->db->select("et.message,et.subject")
                ->from('emailtemplate as et')
                ->where("et.id",$PostData['id'])
                ->get();
          
        echo json_encode($query->row_array());
    }
    public function delete_email_template(){
        $PostData = $this->input->post();
        $ids = explode(",",$PostData['ids']);
        foreach($ids as $row){
            $this->Email_template->Delete(array('id'=>$row));
        }
    }  
}

?>