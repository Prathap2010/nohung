<?php

class Kitchen_Controller extends MY_Controller {

    public $viewData = array();
    
    function __construct() {
        
        parent::__construct();
        $this->load->library("Kitchen_headerlib");
        // Load facebook oauth library 
        $this->load->library('facebook');

        // Authenticate user with facebook 
        if($this->facebook->is_authenticated()){ 
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture'); 
 
            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'facebook'; 
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';; 
            $userData['firstname']    = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
            $userData['lastname']    = !empty($fbUser['last_name'])?$fbUser['last_name']:''; 
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:''; 
            // $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:''; 
            $userData['image']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:''; 
            // $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'https://www.facebook.com/'; 
             
            // Insert or update user data to the database 
            $userID = $this->User->checkUser($userData); 
             
            // Check user data insert or update status 
            if(!empty($userID)){ 
                $userdata = array(
                    base_url().'FRONTUSERID' => $userID,
                    base_url().'FRONTUSERNAME' => $userData['firstname']." ".$userData['lastname'],
                    base_url().'FRONTUSEREMAIL' => $userData['email'],
                ); 
                 
                // Store the user profile info into session 
                $this->session->set_userdata('userdata', $userdata); 
            } 
             
            // Facebook logout URL 
            $this->viewData['FacebookAuthURL'] = $this->facebook->logout_url(); 
        }else{ 
            // Facebook authentication url 
            $this->viewData['FacebookAuthURL'] =  $this->facebook->login_url(); 
        } 

        // Load google oauth library 
        $this->load->library('google');
        // Redirect to profile page if the user already logged in 
        if($this->session->userdata(base_url().'FRONTUSERID') == true){ 
            // redirect(FRONT_URL); 
        } 
         
        if(isset($_GET['code'])){ 
             
            // Authenticate user with google 
            if($this->google->getAuthenticate()){ 
             
                // Get user info from google 
                $gpInfo = $this->google->getUserInfo(); 
                 
                // Preparing data for database insertion 
                $userData['oauth_provider'] = 'google'; 
                $userData['oauth_uid']         = $gpInfo['id']; 
                $userData['firstname']     = $gpInfo['given_name']; 
                $userData['lastname']         = $gpInfo['family_name']; 
                $userData['email']             = $gpInfo['email']; 
                // $userData['gender']         = !empty($gpInfo['gender'])?$gpInfo['gender']:''; 
                // $userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:''; 
                $userData['image']         = !empty($gpInfo['picture'])?$gpInfo['picture']:''; 
                 
                // Insert or update user data to the database 
                $userID = $this->user->checkUser($userData); 
                 
                // Store the status and user profile info into session 
                $userdata = array(
                    base_url().'FRONTUSERID' => $userID,
                    base_url().'FRONTUSERNAME' => $userData['firstname']." ".$userData['lastname'],
                    base_url().'FRONTUSEREMAIL' => $userData['email'],
                ); 
                $this->session->set_userdata('userdata', $userdata); 
                 
                // Redirect to profile page 
                redirect(KITCHEN_URL); 
            } 
        }  
         
        // Google authentication url 
        $this->viewData['GoogleLoginURL'] = $this->google->loginURL();

        if (!empty($this->session->userdata(base_url() . 'FRONTUSERID'))) {
            // redirect(FRONT_URL); 
            $kitchenid = $this->session->userdata(base_url() . 'FRONTUSERID');
            $this->load->model('User_model', 'User');
            $this->viewData['count_unread_admin_messages'] = $this->User->countUnReadMessageForKitchen($kitchenid);
        } 
        
        // $this->load->model("Manage_content_model");
        // $this->viewData['aboutuscontent'] = $this->Manage_content_model->getContentDetailBySlug("about-us");
    }

    function checkUserSession(){
        
        $arrSessionDetails = $this->session->userdata;
        if(isset($arrSessionDetails) && empty($arrSessionDetails[base_url().'FRONTUSERID'])){
            redirect(KITCHENFOLDER."login");
        }
    }
}
