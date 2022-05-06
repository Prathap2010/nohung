<?php

class Foodies_Controller extends MY_Controller {

    public $viewData = array();
    
    function __construct() {
        
        parent::__construct();
        $this->load->library("Foodies_headerlib");
        // echo "<pre>"; print_r($_SESSION); exit;
        $this->viewData['is_logged_in'] = 0; 
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        if(!is_null($foodiesid)){

            $this->addCartItemsBySession($foodiesid);

            $this->viewData['cart_items_array'] = $this->getCartItems($foodiesid);

            $this->viewData['is_logged_in'] = 1; 
        }else{
            $this->viewData['cart_items_array'] = $this->getCartItemsInSession();
        }

        $this->load->library('facebook');

        // Authenticate user with facebook 
        if($this->facebook->is_authenticated()){ 
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture'); 
 
            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'facebook'; 
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';; 
            $userData['kitchenname']    = (!empty($fbUser['first_name'])?$fbUser['first_name']:'')." ".(!empty($fbUser['last_name'])?$fbUser['last_name']:''); 
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['password'] = "123456"; 
            $userData['userstatus'] = 1; 
            $userData['status'] = 1; 
            $userData['usertype'] = 1; 
            // $userData['image']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:''; 
             
            // Insert or update user data to the database 
            $userID = $this->User->checkUser($userData); 
             
            // Check user data insert or update status 
            if(!empty($userID)){ 
                $userdata = array(
                    base_url().'FOODIESUSERID' => $userID,
                    base_url().'FOODIESMOBILENO' => "",
                    base_url().'FOODIESFULLNAME' => $userData['kitchenname'],
                    base_url().'FOODIESEMAIL' => $userData['email'],
                );
                $this->session->set_userdata($userdata);
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

        if (isset($_GET['code'])) {

            // Authenticate user with google 
            if ($this->google->getAuthenticate()) {

                // Get user info from google 
                $gpInfo = $this->google->getUserInfo();

                // Preparing data for database insertion 
                $userData['oauth_provider'] = 'google';
                $userData['oauth_uid']      = $gpInfo['id'];
                $userData['kitchenname']    = $gpInfo['name'];
                $userData['email']          = $gpInfo['email'];
                $userData['password'] = "123456"; 
                $userData['userstatus'] = 1;
                $userData['status'] = 1;
                $userData['usertype'] = 1;

                // Insert or update user data to the database 
                $this->load->model("User_model", "User");
                $userID = $this->User->checkUser($userData);

                // Store the status and user profile info into session 
                $userdata = array(
                    base_url() . 'FOODIESUSERID' => $userID,
                    base_url() . 'FOODIESMOBILENO' => "",
                    base_url() . 'FOODIESFULLNAME' => $userData['kitchenname'],
                    base_url() . 'FOODIESEMAIL' => $userData['email'],
                );
                $this->session->set_userdata($userdata);

                // Redirect to profile page 
                redirect(FRONT_URL);
            }
        }    
         
        // Google authentication url 
        $this->viewData['GoogleLoginURL'] = $this->google->loginURL(); 
        // echo $this->viewData['GoogleLoginURL']; exit;
        $this->load->model('Manage_content_model', 'Manage_content');
        $this->viewData['company_section_content'] = $this->Manage_content->getContentsBySection('Company');
        $this->viewData['forfoodies_section_content'] = $this->Manage_content->getContentsBySection('For Foodies');
        $this->viewData['forkitchen_section_content'] = $this->Manage_content->getContentsBySection('For Kitchens');
        $this->viewData['forrider_section_content'] = $this->Manage_content->getContentsBySection('For Riders');
        $this->viewData['foryou_section_content'] = $this->Manage_content->getContentsBySection('For You');
    }

    function checkUserSession(){
        
        $arrSessionDetails = $this->session->userdata;
        if(isset($arrSessionDetails) && empty($arrSessionDetails[base_url().'FOODIESUSERID'])){
            redirect("login");
        }
    }

    function getCartItemsInSession(){
        $return = $this->session->userdata("CART_ITEMS");

        return !empty($return) ? $return : array();
    }
    function getCartItems($foodiesid){
        
        $query = $this->db->select('c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,
        
                IF(c.type=2,c.price,
                    IFNULL((SELECT (IF(c.type=0,weeklyprice,monthlyprice) + IFNULL((SELECT SUM(price * IF(qty>0,qty,1)) FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id="' . $foodiesid . '" GROUP BY c.type,c.typeid)),0)) FROM packages WHERE id=c.typeid),0)
                ) as price,
        
                c.createddate,c.modifieddate,
                IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),""),"") menuimage,

                IF(c.type=2,
                    IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),""),
                    IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),"")
                ) as cuisinetype,

                IF(c.type=2,
                    "",
                    IFNULL((SELECT mealfor FROM packages WHERE id=c.typeid),"")
                ) as mealfor,

                c.including_saturday,c.including_sunday,

                c.delivery_date,

                (SELECT delivery_date FROM cart WHERE user_id=c.user_id AND type=c.type AND typeid=c.typeid ORDER BY delivery_date ASC LIMIT 1) as fromdate,
                (SELECT delivery_date FROM cart WHERE user_id=c.user_id AND type=c.type AND typeid=c.typeid ORDER BY delivery_date DESC LIMIT 1) as todate,
                
                c.delivery_fromtime,c.delivery_totime
            ')
                    ->from('cart as c')
                    ->where('c.user_id="'.$foodiesid.'"')
                    ->group_by("c.type,c.typeid")
                    ->get();
        
        return $query->result_array();
    }
    function addCartItemsBySession($foodiesid){
        $session_cart_items = $this->getCartItemsInSession();
        $session_cart_customisable_items = $this->session->userdata('CART_CUSTOMISABLE_ITEMS');

        $createddate = $this->general_model->getCurrentDateTime();
        
        $this->load->model("User_model","User");
        $this->load->model("Menu_model", "Menu");
        $this->load->model("Package_model", "Package");

        if(!empty($session_cart_items)){
            
            $this->User->_table = "cart_package_menu_items";
            $this->User->Delete("cart_id IN (SELECT id FROM cart WHERE user_id=" . $foodiesid . ")");

            $this->User->_table = 'cart';
            $this->User->Delete(array("user_id" => $foodiesid));

            $this->User->_table = 'cart';
            $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
            $items_array = array();

            foreach($session_cart_items as $item){

                if($item['type'] == 2){
                    $res_menu = $this->Menu->getMasterMenuDataById($item['typeid']);
    
                    $insertdata = array(
                        "kitchen_id"    => $item['kitchen_id'],
                        "user_id"       => $foodiesid,
                        "type"          => 2,
                        "typeid"        => $item['typeid'],
                        "name"          => $res_menu['itemname'],
                        "quantity"      => $item['quantity'],
                        "price"         => $res_menu['itemprice'],
                        "delivery_date" => date("Y-m-d"),
                        "delivery_fromtime" => date("H:i:s"),
                        "delivery_totime"   => '23:59:59',
                        "createddate"   => $createddate,
                        "modifieddate"  => $createddate,
                    );

                    $this->User->Add($insertdata);
                }else{

                    $res_pkg = $this->Package->getPackageDataById($item['typeid']);
                    $date_array = $this->general_model->dateRange($item['delivery_startdate'], $item['delivery_enddate']);

                    if(count($date_array) > 0){
                        foreach($date_array as $date){
                            
                            $dayname = date('l', strtotime($date));
                            $day_index = array_search($dayname, $days);
        
                            $this->Package->_table = "weeklypackage";
                            $this->Package->_fields = "id,price,image";
                            $this->Package->_where = array("packageid"=>$item['typeid'],"days"=>$day_index); 
                            $res_weekpkg = $this->Package->getRecordsById();
        
                            if(!empty($res_weekpkg)){
        
                                $insert_array = array(
                                    "kitchen_id"        => $item['kitchen_id'],
                                    "user_id"           => $foodiesid,
                                    "type"              => $item['type'],
                                    "typeid"            => $item['typeid'],
                                    "weeklypackageid"   => $res_weekpkg['id'],
                                    "name"              => $res_pkg['packagename'],
                                    "price"             => $res_weekpkg['price'],
                                    "delivery_date"     => $date,
                                    "delivery_fromtime" => $item['delivery_fromtime'],
                                    "delivery_totime"   => $item['delivery_totime'],
                                    "including_saturday"=> $res_pkg['including_saturday'],
                                    "including_sunday"  => $res_pkg['including_sunday'],
                                    "createddate"       => $createddate,
                                    "modifieddate"      => $createddate,
                                );
                                
                                $cart_id = $this->User->add($insert_array);
        
                                if($cart_id){
        
                                    $this->Package->_table = "weeklypackagemenu";
                                    $this->Package->_fields = "id,menuid,itemname,qty,price";
                                    $this->Package->_where = array("weeklypackageid"=>$res_weekpkg['id']); 
                                    $res_weekpkg_menu = $this->Package->getRecordById();
                                    
                                    if(!empty($res_weekpkg_menu)){
                                        foreach($res_weekpkg_menu as $val){

                                            $key = $item['typeid'] . '_' . $res_weekpkg['id'];
                                            $extra_item = !empty($session_cart_customisable_items[$key]) ? json_decode($session_cart_customisable_items[$key], true) : "";
                                            // $this->Package->_table = "order_customized_package_item";
                                            // $this->Package->_fields = "id,userid,packageid,weeklypackageid,menuid,qty,itemprice";
                                            // $this->Package->_where = array("userid"=>$foodiesid,"packageid"=>$packageid,"weeklypackageid"=>$res_weekpkg['id'],"menuid"=>$val['menuid']); 
                                            // $res_extra_item = $this->Package->getRecordsById();
                                            
                                            $qty = $val['qty'];
                                            if (!empty($extra_item)) {
                                                foreach ($extra_item as $menu_item) {
                                                    if ($menu_item['menuid'] == $val['menuid']) {
                                                        $qty = ($qty == 0) ? ($menu_item['qty'] + 1) : ($qty + $menu_item['qty']);
                                                    }
                                                }
                                            }
        
                                            $items_array[] = array(
                                                "cart_id"       => $cart_id,
                                                "menuid"        => $val['menuid'],
                                                "itemname"      => $val['itemname'],
                                                "qty"           => $qty,
                                                "price"         => $val['price']
                                            );
                                        }
                                    }
                                }
        
                            }
                        }
                    }
                }
            }

            if(!empty($items_array)){
                $this->Package->_table = "cart_package_menu_items";
                $this->Package->add_batch($items_array);
            }
        }
        $this->session->unset_userdata('CART_ITEMS');
        $this->session->unset_userdata('CART_CUSTOMISABLE_ITEMS');
        $this->User->_table = 'user';
    } 
    function get_location(){
        
        if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
            //Send request and receive latitude and longitude
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false&key='.GOOGLE_MAP_API_KEY;
            $json = @file_get_contents($url);
            $data = json_decode($json);
            // print_r($data);
            $status = $data->status;
            if($status=="OK"){
                $location = $data->results[0]->formatted_address;

                $city = "";
                for ($j = 0; $j < count($data->results[0]->address_components); $j++) {
                    $cn = array($data->results[0]->address_components[$j]->types[0]);
                    if (in_array("locality", $cn)) {
                        $city = $data->results[0]->address_components[$j]->long_name;
                    }
                }
                $response = array("location"=> $location, "city" => $city);
            }else{
                $location =  'No location found.';
                $response = array("location" => $location, "city" => "No result found.");
            }
            echo json_encode($response); 
        } 
        
    }

    /* public function getDistance(){
        $PostData = $this->input->post();
        
        $latitude_1 = $PostData['latitude_1'];
        $longitude_1 = $PostData['longitude_1'];
        $latitude_2 = $PostData['latitude_2'];
        $longitude_2 = $PostData['longitude_2'];
        
        $this->load->model("User_model","User");
        $distance = $this->User->getDistance($latitude_1,$longitude_1,$latitude_2,$longitude_2);

        echo $distance;
    } */

    public function getDistance(){
        $PostData = $this->input->post();
        
        $origin = $PostData['origin'];
        $destination = $PostData['destination'];
        $type = $PostData['type'];
        $return = $PostData['return_with_km'];

        $this->load->model("User_model","User");
        
        echo get_duration_between_two_places($origin,$destination,$type,$return);
    }

    function send_text_sms($numbers=array(), $message){
        
        $apiKey = urlencode('NTk0ODY4NWE3NTU3MzM1NzQ2NTU0NjcwNGUzNjQ3NDg=');
        $hash = '1bb38b82e41f4c625d834094532dd6ad3e29b2eeb5a2a99ea88bf8d5f371ca4c';
        $sender = urlencode('nohung');
        $message = rawurlencode($message);
        $numbers = implode(',', $numbers);
        $test = 1;
        return 1;
        $data = array('apikey' => $apiKey, 'numbers' => $numbers,"sender" => $sender, "message" => $message, "test" => $test);
        // $data = array('apikey' => $apiKey, 'message_id' => "13245322017");
        // $data = array('apikey' => $apiKey, 'batch_id' => "2357612160");

        $ch = curl_init('https://api.textlocal.in/send/');
        // $ch = curl_init('https://api.textlocal.in/status_message/');
        // $ch = curl_init('https://api.textlocal.in/status_batch/');
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        // echo $response;

    }
}
