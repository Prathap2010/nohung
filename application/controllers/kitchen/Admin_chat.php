<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chat extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Admin Chat";

        $this->viewData['page'] = "Admin_chat";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Admin_chat";

        $this->kitchen_headerlib->add_javascript("admin_chat","admin_chat.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function get_admin_detail() {
        
        $userid = $this->session->userdata(base_url().'FRONTUSERID');
        $adminlist = $this->User->getAdminChatDetail($userid);
        
        if ($adminlist['image'] != "" && file_exists(PROFILE_PATH . $adminlist['image'])) {
            $adminlist['image'] = PROFILE . $adminlist['image'];
        } else {
            $adminlist['image'] = NOPROFILEIMAGE;
        }
        $return['adminlist'] = $adminlist;
        $return['count_sidebar_admin_msg'] = $this->User->countUnReadMessageForKitchen($userid);

        echo json_encode($return);
    }
    public function get_admin_chat(){
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->User->unReadAdminChat($kitchenid);

        $this->User->_table = "user";
        $admin = $this->User->getAdminChatDetail($kitchenid);
        $chat = $this->User->getKitchenChat($kitchenid);
        if ($admin['image'] != "" && file_exists(PROFILE_PATH . $admin['image'])) {
            $img = PROFILE . $admin['image'];
        } else {
            $img = NOPROFILEIMAGE;
        }
        
        $return = array(
            "id"=> $admin['id'],
            "name"=> $admin['name'],
            "email"=> $admin['email'],
            "mobileno"=> $admin['mobileno'],
            "image"=>$img,
            "chat"=>$chat,
        );
        echo json_encode($return);
    }
    public function add_chat_message() {
        $PostData = $this->input->post();
        $message = trim($PostData['message']);
        $msg_type = "usertoadmin";
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $insertdata = array(
            "msg_type"	=> $msg_type,
            "userid"	=> $kitchenid,
            "message"	=> $message,
            "isread"	=> 'n',
            "createddate"=> $this->general_model->getCurrentDateTime()
        );

        $this->User->_table = "adminmessages";
        $this->User->Add($insertdata);

        echo 1;
    }
}