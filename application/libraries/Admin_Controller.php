<?php

class Admin_Controller extends MY_Controller {

    public $data = array();
    function __construct() {
        
        parent::__construct();
        $this->load->library("admin_headerlib");
        $this->load->library('form_validation');

        $this->chk_admin_session();   
    }
    function getLoginSettings(){
        $this->db->reconnect();
        $this->load->database();
        
        $arrSessionDetails = $this->session->userdata;
        if(isset($arrSessionDetails[base_url().'USERLOGIN']) && $arrSessionDetails[base_url().'USERLOGIN']){
            // redirect(ADMIN_URL."dashboard");           
        }
        return $this->data;

    }

    function getUserSettings($Controller){
        $this->db->reconnect();
        $this->load->database();
        $arrSessionDetails = $this->session->userdata;
        // echo $Controller; exit;
        $this->data['page'] = $Controller;
        if(isset($arrSessionDetails) && !empty($arrSessionDetails[base_url().'USERLOGIN'])){
            if(!$arrSessionDetails[base_url().'USERLOGIN']){
                redirect(ADMIN_URL."login");           
            }
            else if($arrSessionDetails[base_url().'USERLOGIN']  === TRUE){

                $this->load->model('User_model', 'User');
                $this->data['count_unread_kitchen_messages'] = $this->User->countUnReadMessageForAdmin("kitchen");
                $this->data['count_unread_rider_messages'] = $this->User->countUnReadMessageForAdmin("rider"); 
            }
        }
        
        return $this->data;
    }
   
    function chk_admin_session() {
        $arrSessionDetails = $this->session->userdata;        
        $session_login = isset($arrSessionDetails[base_url().'USERLOGIN']) ? $arrSessionDetails[base_url().'USERLOGIN'] : "";
        
        $arrAllowedWithoutLogin = array('login','forgot-password','reset-password');
        $arrNotAllowedAfterLogin = array('login','forgot-password','reset-password');
        
        if (!$session_login) {
            
            if (!in_array($this->uri->segment(2), $arrAllowedWithoutLogin) && !in_array($this->uri->segment(1), $arrAllowedWithoutLogin)) {
                redirect(ADMINFOLDER.'login/');
            }
            
        } else if ($session_login && $session_login == TRUE) {
            
            $arrSegment2WithoutAjax = array('dashboard', 'logout');
            if($this->uri->segment(2)=='login'){
                $this->session->unset_userdata(base_url().'USERLOGIN');
                $this->session->unset_userdata(base_url().'USERID');
                $this->session->unset_userdata(base_url().'USEREMAIL');
                $this->session->unset_userdata(base_url().'USERPROFILE');
                redirect(ADMINFOLDER.'login/');
            }else if (in_array($this->uri->segment(2), $arrNotAllowedAfterLogin)) {
                //redirect(ADMINFOLDER.'dashboard');
            }
        }
    }
    function crop_image() {
        
        require_once APPPATH."third_party/Crop.php";
        $crop = new Crop(
            isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
            isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
            isset($_FILES['file']) ? $_FILES['file'] : null,
            isset($_POST['height']) ? $_POST['height'] : 100,
            isset($_POST['width']) ? $_POST['width'] : 200,
            $_POST['dest_site_folder'],
            $_POST['dest_dir_folder']
        );
    
        $imgName = $crop->get_imagename();
        //imageinterlace($imgName, 1);
        $response = array(
            'state'  => 200,
            'message' => $crop -> getMsg(),
            'result' => $crop -> getResult(),
            'source' => $crop->get_source(),
            'image' => $crop->get_imagename()
        );
    
        echo json_encode($response);
    }
}
