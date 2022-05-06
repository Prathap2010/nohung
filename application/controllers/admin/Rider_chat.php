<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rider_chat extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Rider_chat');
        $this->load->model('Rider_model', 'Rider');
    }

    public function index() {
        
        $this->viewData['title'] = "Rider Chat";
        $this->viewData['module'] = "rider_chat/Rider_chat";

        // $this->viewData['riderslist'] = $this->Rider->getRiderList(); 

        $this->admin_headerlib->add_javascript("rider_chat","pages/rider_chat.js");
        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }
    public function get_recent_riders() {

        $return['riderslist'] = $this->Rider->getRecentRidersList();

        $this->load->model('User_model', 'User');
        $return['count_sidebar_rider_msg'] = $this->User->countUnReadMessageForAdmin("rider");

        echo json_encode($return);
    }
    public function get_rider_chat(){
        $PostData = $this->input->post();
        $riderid = trim($PostData['riderid']);

        $this->Rider->unReadChat($riderid);

        $this->Rider->_table = "user";
        $rider = $this->Rider->getRiderDataByID($riderid);
        $chat = $this->Rider->getRiderChat($riderid);

        if ($rider['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $rider['profile_image'])) {
            $img = USER_PROFILE . $rider['profile_image'];
        } else {
            $img = NOPROFILEIMAGE;
        }
        $profile_image = $img;

        $return = array(
            "riderid"=>$rider['id'],
            "ridername"=>$rider['kitchenname'],
            "email"=>$rider['email'],
            "mobilenumber"=>$rider['mobilenumber'],
            "profile_image" => $profile_image,
            "chat"=>$chat,
        );
        echo json_encode($return);
    }
    public function add_chat_message() {
        $PostData = $this->input->post();
		$riderid = trim($PostData['riderid']);
		$message = trim($PostData['message']);
        $msg_type = "admintouser";

        $insertdata = array(
            "msg_type"	=> $msg_type,
            "userid"	=> $riderid,
            "message"	=> $message,
            "isread"	=> 'n',
            "createddate"=> $this->general_model->getCurrentDateTime()
        );

        $this->Rider->_table = "adminmessages";
        $this->Rider->Add($insertdata);

        echo 1;
    }
    
}

?>