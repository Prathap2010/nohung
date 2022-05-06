<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_content extends Admin_Controller {

    public $viewData = array();
    public $contenttype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Manage_content');
        $this->load->model('Manage_content_model', 'Manage_content');
    }

    public function index() {
        $this->viewData['title'] = "Manage Content";
        $this->viewData['module'] = "manage_content/Manage_content";  

        $this->viewData['contentdata'] = $this->Manage_content->getContentData();

        $this->admin_headerlib->add_javascript("content", "pages/manage_content.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function add_content() {
        $this->viewData['title'] = "Add Content";
        $this->viewData['module'] = "manage_content/Add_content";

        $this->admin_headerlib->add_javascript("content", "pages/add_content.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function content_add() {

        $PostData = $this->input->post();
        $createddate = $this->general_model->getCurrentDateTime();
        $pagename = trim($PostData['pagename']);
        $slug = str_replace(" ","-",strtolower($pagename));
        $title = trim($PostData['title']);
        $description = trim($PostData['description']);
        $section = trim($PostData['section']); 
        $status = trim($PostData['status']);

        $CheckContent = $this->Manage_content->CheckContent($slug);
        if ($CheckContent != 0) {
    
            $insertdata = array(
                "pagename" => $pagename,
                "title" => $title,
                "description" => $description,
                "slug" => $slug,
                "section" => $section,
                // "metakeywords" => $PostData['metakeywords'],
                // "metadescription" => $PostData['metadescription'],
                "status" => $status,
                "createddate" => $createddate,
                "modifieddate" => $createddate,
              );
            
            $Add = $this->Manage_content->Add($insertdata);

            if ($Add) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function edit_content($id) {
        $this->viewData['title'] = "Edit Content";
        $this->viewData['module'] = "manage_content/Add_content";
        $this->viewData['action'] = "1"; //Edit
        
        $this->viewData['contentdata'] = $this->Manage_content->getContentDataByID($id);
     
        $this->admin_headerlib->add_javascript("content", "pages/add_content.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function update_content() {

        $PostData = $this->input->post();
        $createddate = $this->general_model->getCurrentDateTime();
        $contentid = trim($PostData['contentid']);
        $pagename = trim($PostData['pagename']);
        $slug = str_replace(" ","-",strtolower($pagename));
        $title = trim($PostData['title']);
        $description = trim($PostData['description']);
        $section = trim($PostData['section']); 
        $status = trim($PostData['status']);

        $CheckContent = $this->Manage_content->CheckContent($slug,$contentid);
        if ($CheckContent != 0) {
            
            $updatedata = array("pagename" => $pagename,
                                "title" => $title,
                                "description" => $description,
                                "slug" => $slug,
                                "section" => $section,
                                // "metakeywords" => $PostData['metakeywords'],
                                // "metadescription" => $PostData['metadescription'],
                                "status" => $status,
                                "modifieddate" => $createddate,
                            );

            $this->Manage_content->_where = array('id' => $contentid);
            $this->Manage_content->Edit($updatedata);
            echo 1;
        } else {
            echo 2;
        }
    }
    public function content_enable_disable(){
		$val = (isset($_REQUEST['val']))?$_REQUEST['val']:'';
		$id = (isset($_REQUEST['id']))?$_REQUEST['id']:'';
		$updatedata = array('status'=>$val);
		$this->Manage_content->_where = "id=".$id;
		$result=$this->Manage_content->Edit($updatedata);
		if($result){
			echo $id;
		}
	}
    function getcontentbyid(){
        $PostData = $this->input->post();
        
        $this->Manage_content->_fields = "pagename,slug,title,description";
        $this->Manage_content->_where = "id=".$PostData['id'];
        $data = $this->Manage_content->getRecordsByID();

        echo json_encode(array('pagename'=>$data['pagename'],'description'=>$data['description']));
    }
    
    public function delete_content(){
        $PostData = $this->input->post();
        $ids = explode(",",$PostData['ids']);
        foreach($ids as $row){
            $this->Manage_content->Delete(array('id'=>$row));
        }
    }
}
?>