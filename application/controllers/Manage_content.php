<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_content extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Manage_content_model', 'Manage_content');
    }

    public function index($page="") {

        $this->viewData["contentdata"] = $this->Manage_content->getContentDetailBySlug($page);
        
        if(empty($this->viewData["contentdata"])){
            show_404();
        }
        // $metakeyword = ($this->viewData["contentdata"]["metakeywords"]!='')?$this->viewData["contentdata"]["metakeywords"]:$this->viewData["contentdata"]["title"];
        // $metadescription = ($this->viewData["contentdata"]["metadescription"]!='')?$this->viewData["contentdata"]["metadescription"]:$this->viewData["contentdata"]["title"];

        // $this->frontend_headerlib->add_content_meta_tags("keywords",$metakeyword);
        // $this->frontend_headerlib->add_content_meta_tags("description",$metadescription);

        $title = $this->viewData["contentdata"]['title'];

        $this->viewData['page'] = $page;
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Manage_content";
        $this->viewData['headerclass'] = "deliverHeader";
        
        $this->load->view('template', $this->viewData);
    }

}