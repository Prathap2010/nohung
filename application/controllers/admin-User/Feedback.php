<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Feedback');
        $this->load->model('Feedback_model', 'Feedback');
    }

    public function index() {
        
        $this->viewData['title'] = "Feedback Management";
        $this->viewData['module'] = "feedback/Feedback";

        $this->viewData['feedbackdata'] = $this->Feedback->getFeedbackListData(); 

        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }
    public function delete_feedback(){
        $PostData = $this->input->post();
        $ids = explode(",",$PostData['ids']);
        foreach($ids as $row){
            $this->Feedback->Delete(array('id'=>$row));
        }
    }  
    public function gefeedbackmessage(){
        $PostData = $this->input->post();
        
        $query = $this->db->select("f.message")
                ->from('feedback as f')
                ->where("f.id",$PostData['id'])
                ->get();
          
        echo json_encode($query->row_array());
    }
}

?>