<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kitchen_chat extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Kitchen_chat');
        $this->load->model('User_model', 'User');
    }

    public function index() {
        
        $this->viewData['title'] = "Kitchen Chat";
        $this->viewData['module'] = "kitchen_chat/Kitchen_chat";

        $this->viewData['kitchenlist'] = $this->User->getKitchenList(0); 

        $this->admin_headerlib->add_javascript("kitchen_chat", "pages/kitchen_chat.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }
    public function get_recent_kitchens() {
        
        $return['kitchenslist'] = $this->User->getRecentKitchensList();
        $return['count_sidebar_kitchen_msg'] = $this->User->countUnReadMessageForAdmin("kitchen");
        // $this->data['count_unread_rider_messages'] = $this->User->countUnReadMessageForAdmin("rider"); 
        echo json_encode($return);
    }
    public function get_kitchen_chat(){
        $PostData = $this->input->post();
        $kitchenid = trim($PostData['kitchenid']);

        $this->User->unReadChat($kitchenid);

        $this->User->_table = "user";
        $kitchen = $this->User->getUserDataByID($kitchenid);
        $chat = $this->User->getKitchenChat($kitchenid);

        if ($kitchen['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $kitchen['profile_image'])) {
            $img = USER_PROFILE . $kitchen['profile_image'];
        } else {
            $img = NOPROFILEIMAGE;
        }
        $profile_image = $img;

        $return = array(
            "kitchenid"=>$kitchen['id'],
            "kitchenname"=>$kitchen['kitchenname'],
            "email"=>$kitchen['email'],
            "mobilenumber"=>$kitchen['mobilenumber'],
            "profile_image"=> $profile_image,
            "chat"=>$chat,
        );
        echo json_encode($return);
    }
    public function add_chat_message() {
        $PostData = $this->input->post();
		$kitchenid = trim($PostData['kitchenid']);
		$message = trim($PostData['message']);
        $msg_type = "admintouser";

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

?>