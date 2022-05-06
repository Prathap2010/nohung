<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kitchen_detail extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        // $this->checkUserSession();
        $this->load->model("User_model","User");
    }

    public function index($kitchenid) {

        $title = "Kitchen Detail";

        $this->viewData['page'] = "Kitchen_detail";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Kitchen_detail";
        $this->viewData['headerclass'] = "deliverHeader";

        if (empty($kitchenid)) {
            show_404();
        }
        $this->viewData['kitchendata'] = $this->User->getKitchenDetailByKitchenID($kitchenid);

        $this->load->model("Offer_model","Offer");
        $where = " AND (userid=0 OR userid IN (SELECT id FROM user WHERE kitchenid='".$kitchenid."'))";
        $this->viewData['offerdata'] = $this->Offer->getOffers("live",$where);

        if(empty($this->viewData['kitchendata'])){
            show_404();
        }
        if(!empty($this->session->userdata(base_url().'FOODIESUSERID'))) {
            $this->session->unset_userdata("redirect_url");
        }else{
            $this->session->set_userdata(array("redirect_url"=>FRONT_URL.'kitchen-detail/'.$kitchenid));
        }

        // $user_ip = getenv('REMOTE_ADDR');
        // $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
        // echo "<pre>"; print_r($geo); exit;
        /* $addressFrom = 'MAvdi Chowk';
        $addressTo   = 'Gondal';

        // Get distance in km
        $dist = $this->getDistance($addressFrom, $addressTo, "K");
        echo $dist;
        $ts = ($dist / 74.08) * 3600; // in seconds

        $h = floor($ts/3600);
        $m = floor(($ts / 60) % 60);
        $s = $ts % 60;

        echo "$h:$m:$s";

        exit; */
        $this->foodies_headerlib->add_javascript("kitchen_detail","kitchen_detail.js");
        $this->load->view('template', $this->viewData);
    }

    /* public function load_trial_meal() {
        $PostData = $this->input->post();
        $tab = $PostData['tab'];
        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        
        $where = "userid=".$PostData['userid'];
        if($PostData['itemtype'] != 2){
            if($tab != "breakfast"){
                if($PostData['itemtype']==0){
                    $where .= " AND m.category!='Non Veg'";
                }else{
                    $where .= " AND m.category='Non Veg'";
                }
            }else{
                $where .= " AND m.itemtype=".$PostData['itemtype'];
            }
        }
        if($tab == "breakfast"){
            $where .= " AND m.menutype=0";
        }else if($tab == "lunch"){
            $where .= " AND m.menutype=1";
        }else if($tab == "dinner"){
            $where .= " AND m.menutype=2";
        }
        $limit = 10;
        $this->viewData['trialmealdata'] = $this->User->getTrialMealList($limit, $offset, $where);
        
        $return['totalrows'] = $this->User->getTrialMealList($limit, $offset, $where, "1");
        
        $return['html'] = $this->load->view(FOODIESFOLDER.'trial-meal-ajax-data', $this->viewData, true);

        echo json_encode($return);
    } */
    public function load_trial_meal() {
        $PostData = $this->input->post();
        $breakfast_offset = (!isset($PostData['trial_breakfast_offset']))?0:$PostData['trial_breakfast_offset'];
        $lunch_offset = (!isset($PostData['trial_lunch_offset']))?0:$PostData['trial_lunch_offset'];
        $dinner_offset = (!isset($PostData['trial_dinner_offset']))?0:$PostData['trial_dinner_offset'];
        
        $limit = 10;

        $where = "userid=".$PostData['userid']." AND m.menutype=0";
        if($PostData['itemtype'] != 2){
            $where .= " AND m.itemtype=".$PostData['itemtype'];
        }
        $this->viewData['trialmealdata'] = $this->User->getTrialMealList($limit, $breakfast_offset, $where);
        
        $return['breakfast'] = array(
            "totalrows" => $this->User->getTrialMealList($limit, $breakfast_offset, $where, "1"),
            "html"      => $this->load->view('trial-meal-ajax-data', $this->viewData, true)
        );
        
        $where = "userid=".$PostData['userid']. " AND (m.menutype=1 OR m.menutype=3)";
        if($PostData['itemtype'] != 2){
            if($PostData['itemtype']==0){
                $where .= " AND m.category!='Non Veg'";
            }else{
                $where .= " AND m.category='Non Veg'";
            }
        }
        $this->viewData['trialmealdata'] = $this->User->getTrialMealList($limit, $lunch_offset, $where);
        
        $return['lunch'] = array(
            "totalrows" => $this->User->getTrialMealList($limit, $lunch_offset, $where, "1"),
            "html"      => $this->load->view('trial-meal-ajax-data', $this->viewData, true)
        );


        $where = "userid=".$PostData['userid']. " AND (m.menutype=2 OR m.menutype=3)";
        if($PostData['itemtype'] != 2){
            if($PostData['itemtype']==0){
                $where .= " AND m.category!='Non Veg'";
            }else{
                $where .= " AND m.category='Non Veg'";
            }
        }
        $this->viewData['trialmealdata'] = $this->User->getTrialMealList($limit, $dinner_offset, $where);
        
        $return['dinner'] = array(
            "totalrows" => $this->User->getTrialMealList($limit, $dinner_offset, $where, "1"),
            "html"      => $this->load->view('trial-meal-ajax-data', $this->viewData, true)
        );

        echo json_encode($return);
    }
    public function load_package() {
        $PostData = $this->input->post();
        $breakfast_offset = (!isset($PostData['breakfast_offset']))?0:$PostData['breakfast_offset'];
        $lunch_offset = (!isset($PostData['lunch_offset']))?0:$PostData['lunch_offset'];
        $dinner_offset = (!isset($PostData['dinner_offset']))?0:$PostData['dinner_offset'];
        $limit = 10;

        $where = "p.userid=".$PostData['userid'];

        if($PostData['plantype'] == 'weekly'){
            $where .= " AND p.weeklyplantype=1";
        }else if($PostData['plantype'] == 'monthly'){
            $where .= " AND p.monthlyplantype=1";
        }
        if($PostData['itemtype'] != 2){
            if($PostData['itemtype']==0){
                $where .= " AND p.mealtype=0";
            }else{
                $where .= " AND p.mealtype=1";
            }
        }
        $breakfast_where = $where." AND p.mealfor=0";
        $lunch_where = $where." AND p.mealfor=1";
        $dinner_where = $where." AND p.mealfor=2";
        
        $this->load->model("Package_model","Package");
        $this->viewData['plantype'] = $PostData['plantype'];
        
        $this->viewData['packagedata'] = $this->Package->getPackageListInFoodies($limit, $breakfast_offset, $breakfast_where);
        
        $return['breakfast'] = array(
            "totalrows" => $this->Package->getPackageListInFoodies($limit, $breakfast_offset, $breakfast_where, "1"),
            "html"      => $this->load->view('package-ajax-data', $this->viewData, true)
        );

        $this->viewData['packagedata'] = $this->Package->getPackageListInFoodies($limit, $lunch_offset, $lunch_where);
        
        $return['lunch'] = array(
            "totalrows" => $this->Package->getPackageListInFoodies($limit, $lunch_offset, $lunch_where, "1"),
            "html"      => $this->load->view('package-ajax-data', $this->viewData, true)
        );
        
        $this->viewData['packagedata'] = $this->Package->getPackageListInFoodies($limit, $dinner_offset, $dinner_where);
        
        $return['dinner'] = array(
            "totalrows" => $this->Package->getPackageListInFoodies($limit, $dinner_offset, $dinner_where, "1"),
            "html"      => $this->load->view('package-ajax-data', $this->viewData, true)
        );

        echo json_encode($return);
    }
    public function get_reviews() {
        $PostData = $this->input->post();
        $userid = $PostData['userid'];
        $limit = 10;
        
        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];

        $where = "f.kitchen_id='".$userid."'";
        
        $reviews = $this->User->getReviewsInFoodies($limit, $offset, $where);
        
        $return['reviews'] = array();
        if(!empty($reviews)){
            foreach($reviews as $val){
                
                $createdtime = (string)$this->general_model->time_Ago(strtotime($val['createddate']));
                
                if($val['profile_image']!="" && file_exists(USER_PROFILE_PATH.$val['profile_image'])) {
                    $customerimage = USER_PROFILE.$val['profile_image'];
                }else{
                    $customerimage = NOPROFILEIMAGE;
                }

                $return['reviews'][] = array(
                    "id"=>$val['id'], 
                    "kitchen_id"=>$val['kitchen_id'], 
                    "customer_id"=>$val['customer_id'], 
                    "customername"=>$val['customername'],
                    "customerimage"=>$customerimage, 
                    "rating"=>$val['rating'], 
                    "message"=>$val['message'], 
                    "foodquality"=>$val['foodquality'], 
                    "taste"=>$val['taste'], 
                    "quantity"=>$val['quantity'], 
                    "createddate"=>$createdtime
                );
                
            } //exit;
        }
        $return['totalrows'] = $this->User->getReviewsInFoodies($limit, $offset, $where, "1");

        echo json_encode($return);
    }

    public function add_review(){
        $PostData = $this->input->post();
        $userid = $PostData['userid'];
        $review_rating = $PostData['review_rating'];
        $review_message = $PostData['review_message'];
        $foodquality = $PostData['radioQuality'];
        $taste = $PostData['radioTaste'];
        $quantity = $PostData['radioQuantity'];
        $createddate = $this->general_model->getCurrentDateTime();

        $insertdata = array(
            "kitchen_id"    => $userid,
            "customer_id"   => $this->session->userdata(base_url().'FOODIESUSERID'),
            "rating"        => $review_rating,
            "message"       => $review_message,
            "submittype"    => 1,
            "foodquality"   => $foodquality,
            "taste"         => $taste,
            "quantity"      => $quantity,
            "createddate"   => $createddate,
            "modifieddate"  => $createddate
        );
            
        $this->load->model("Feedback_model","Feedback");
        $ID = $this->Feedback->Add($insertdata);

        if ($ID) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function get_package_detail() {
        $PostData = $this->input->post();
        $kitchenid = $PostData['userid'];
        $packageid = $PostData['packageid'];
        $userid = $this->session->userdata(base_url() . 'FOODIESUSERID');
        $this->load->model("Package_model", "Package");

        if(!is_null($userid)){
            $this->Package->_table = 'order_customized_package_item';
            $this->Package->Delete(array("userid" => $userid, "packageid" => $packageid));
        }
        $this->session->set_userdata(array("CART_CUSTOMISABLE_ITEMS" => array()));

        $this->Package->_table = 'packages';
        $json['packagedetail'] = $this->Package->get_package_detail($kitchenid, $packageid);
        $json['weeklypackage'] = $this->Package->getWeeklyPackageData($packageid);

        echo json_encode($json);
    }
    public function addtocart() { 
        $PostData = $this->input->post();
        $kitchen_id = $PostData['kitchen_id'];
        $menuid = $PostData['menuid'];
        // $itemname = $PostData['itemname'];
        // $itemprice = $PostData['itemprice'];
        $quantity = $PostData['quantity'];
        $cal_type = $PostData['cal_type'];

        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        
        $this->load->model("Menu_model","Menu");

        $insertdata = $updatedata = $DeleteData = array();
        $this->User->_table = 'cart';
        if(!is_null($foodiesid)){
            $cartdata = $this->getCartItems($foodiesid);
        }else{
            $cartdata = $this->getCartItemsInSession();
        }
        $cart_kitchen_ids = !empty($cartdata)?array_unique(array_column($cartdata, 'kitchen_id')):array();
        $cart_mealtype = !empty($cartdata)?array_column($cartdata, 'type'):array();
        
        $count = count($cartdata);
        
        if(empty($cart_kitchen_ids) || (!empty($cart_kitchen_ids) && count($cart_kitchen_ids)==1 && $cart_kitchen_ids[0] == $kitchen_id)){
            if((!empty($cart_mealtype) && (in_array(0, $cart_mealtype) || in_array(1, $cart_mealtype)))){
                //while add meal
                echo json_encode(array("type"=>3,"cartcount"=>$count)); 
                exit;
            }

            $res_menu = $this->Menu->getMasterMenuDataById($menuid);
            
            if (!is_null($foodiesid)) {
                $this->User->_fields = "id,quantity";
                $this->User->_where = ('user_id="'.$foodiesid.'" AND type=2 AND typeid="'.$menuid.'"');
                $db_cartdata = $this->User->getRecordsById();

                if(!empty($db_cartdata)){
                    
                    if($cal_type==1){
                        $qty = $db_cartdata['quantity'] + 1;
                    }else if($cal_type==0){
                        $qty = $db_cartdata['quantity'] - 1;
                    }else{
                        $qty = $quantity;
                    }

                    if($qty > 0){

                        $updatedata = array("quantity"=>$qty,
                                            "delivery_date" => date("Y-m-d"),
                                            "delivery_fromtime" => date("H:i:s"),
                                            "delivery_totime"   => '23:59:59',
                                            "modifieddate"=>$createddate
                                        ); 

                        $this->User->_where = array("id"=>$db_cartdata['id']);
                        $this->User->Edit($updatedata);

                    }else{
                        
                        $this->User->Delete(array("id"=>$db_cartdata['id']));
                    }
                }else{
                    
                    $insertdata = array(
                        "kitchen_id"    => $kitchen_id,
                        "user_id"       => $foodiesid,
                        "type"          => 2,
                        "typeid"        => $menuid,
                        "name"          => $res_menu['itemname'],
                        "quantity"      => $quantity,
                        "price"         => $res_menu['itemprice'],
                        "delivery_date" => date("Y-m-d"),
                        "delivery_fromtime" => date("H:i:s"),
                        "delivery_totime"   => '23:59:59',
                        "createddate"   => $createddate,
                        "modifieddate"  => $createddate,
                    );

                    $this->User->Add($insertdata);
                }
                $cartdata = $this->getCartItems($foodiesid);
            }else{
                $cart_array = array();
                
                $is_exist = 0;
                if(!empty($cartdata)){
                    foreach($cartdata as $i=>$item){
                        $qty = $item['quantity'];
                        if($item['type']==2 && $item['typeid'] == $menuid){
                            if ($cal_type == 1) {
                                $qty = $item['quantity'] + 1;
                            } else if ($cal_type == 0) {
                                $qty = $item['quantity'] - 1;
                            } else {
                                $qty = $quantity;
                            }

                            if ($qty > 0) {
                                $item['quantity'] = $qty;                                
                            }
                            $is_exist = 1;
                        }
                        if ($qty > 0) {
                            $cart_array[] = $item;
                        }
                    }
                }
                if($is_exist == 0){
                    $cart_array[] = array(
                        "kitchen_id"    => $kitchen_id,
                        "type"          => 2,
                        "typeid"        => $menuid,
                        "quantity"      => $quantity
                    );
                }
                $this->session->set_userdata(array("CART_ITEMS" => $cart_array));

                $cartdata = $cart_array;
            }
            $count = count($cartdata);
            echo json_encode(array("type"=>1,"cartcount"=>$count));
        }else{
            echo json_encode(array("type"=>2,"cartcount"=>$count));
        }
    }
    public function editcart(){
        $PostData = $this->input->post();
        $cart_id = $PostData['cart_id'];
        $quantity = $PostData['quantity'];
        $cal_type = $PostData['cal_type'];

        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $modifieddate = $this->general_model->getCurrentDateTime();
        
        $this->load->model("Menu_model","Menu");
        
        $this->User->_table = 'cart';
        $this->User->_fields = "id,quantity";
        $this->User->_where = ('user_id="'.$foodiesid.'" AND type=2 AND id="'.$cart_id.'"');
        $db_cartdata = $this->User->getRecordsById();
        
        if(!empty($db_cartdata)){
                
            if($cal_type==1){
                $qty = $db_cartdata['quantity'] + 1;
            }else if($cal_type==0){
                $qty = $db_cartdata['quantity'] - 1;
            }else{
                $qty = $quantity;
            }

            if($qty > 0){

                $updatedata = array("quantity"          => $qty,
                                    "delivery_date"     => date("Y-m-d"),
                                    "delivery_fromtime" => date("H:i:s"),
                                    "delivery_totime"   => '23:59:59',
                                    "modifieddate"      => $modifieddate
                                ); 

                $this->User->_where = array("id"=>$db_cartdata['id']);
                $this->User->Edit($updatedata);

            }else{
                
                $this->User->Delete(array("id"=>$db_cartdata['id']));
            }
        }
        $cartdata = $this->getCartItems($foodiesid);
        $count = count($cartdata);
        echo json_encode(array("type"=>1,"cartcount"=>$count));
    }
    
    
    public function cardItemCheck()
    {
        $kitchen_id = $this->input->post('kitchenId');
        $packageid = $this->input->post('ordPackageid');
        $foodiesid = $this->session->userdata(base_url() . 'FOODIESUSERID');

        $this->load->model("Package_model", "Package");

        $this->User->_table = 'cart';
        if (!is_null($foodiesid)) {
            $cartdata = $this->getCartItems($foodiesid);
        } else {
            $cartdata = $this->getCartItemsInSession();
        }
        $count = count($cartdata);
        $cart_kitchen_ids = !empty($cartdata) ? array_unique(array_column($cartdata, 'kitchen_id')) : array();
        $cart_mealtype = !empty($cartdata) ? array_column($cartdata, 'type') : array();
        $cart_mealfor = !empty($cartdata) ? array_column($cartdata, 'mealfor') : array();
        if (empty($cart_kitchen_ids) || (!empty($cart_kitchen_ids) && count($cart_kitchen_ids) == 1 && $cart_kitchen_ids[0] == $kitchen_id)) {

            $res_pkg = $this->Package->getPackageDataById($packageid);

            if ((!empty($cart_mealtype) && in_array(2, $cart_mealtype))) {
                //while add package
                echo json_encode(array("type" => 3, "cartcount" => $count));
                exit;
            }
            if ((!empty($cart_mealtype) && !in_array(2, $cart_mealtype))) {
                if (in_array($res_pkg['mealfor'], $cart_mealfor)) {
                    echo json_encode(array("type" => 4, "cartcount" => $count, "mealfor" => $res_pkg['mealfor']));
                    exit;
                }
            }
            echo json_encode(array("type" => 1, "cartcount" => $count));
        } else {
            echo json_encode(array("type" => 2, "cartcount" => $count));
        }
    }
    
    
    
    
    public function addtocart_package() {
        $PostData = $this->input->post();
        
        $kitchen_id = $PostData['ord_kitchenid'];
        $mealplan = ($PostData['ord_mealplan']=='weekly' ? 0 : 1);
        
        $packageid = $PostData['ord_packageid'];
        $delivery_startdate = $this->general_model->convertdate($PostData['ord_delivery_startdate']);
        $delivery_enddate = $this->general_model->convertdate($PostData['ord_delivery_enddate']);

        $delivery_fromtime = trim(date("H:i:s",strtotime($PostData['ord_delivery_fromtime'])));
        $delivery_totime = trim(date("H:i:s",strtotime($PostData['ord_delivery_totime'])));

        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $createddate = $this->general_model->getCurrentDateTime();

        $this->load->model("Package_model","Package");
        
        $items_array = array();
        $this->User->_table = 'cart';
        if(!is_null($foodiesid)){
            $cartdata = $this->getCartItems($foodiesid);
        }else{
            $cartdata = $this->getCartItemsInSession();
        }
        $cart_kitchen_ids = !empty($cartdata)?array_unique(array_column($cartdata, 'kitchen_id')):array();
        $cart_mealtype = !empty($cartdata)?array_column($cartdata, 'type'):array();
        $cart_mealfor = !empty($cartdata)?array_column($cartdata, 'mealfor'):array();
        $count = count($cartdata);

        if(empty($cart_kitchen_ids) || (!empty($cart_kitchen_ids) && count($cart_kitchen_ids)==1 && $cart_kitchen_ids[0] == $kitchen_id)){

            $res_pkg = $this->Package->getPackageDataById($packageid);

            if((!empty($cart_mealtype) && in_array(2, $cart_mealtype))){
                //while add package
                echo json_encode(array("type"=>3,"cartcount"=>$count)); 
                exit;
            }
            if((!empty($cart_mealtype) && !in_array(2, $cart_mealtype))){
                if(in_array($res_pkg['mealfor'], $cart_mealfor)){
                    echo json_encode(array("type"=>4,"cartcount"=>$count,"mealfor"=>$res_pkg['mealfor'])); 
                    exit;
                }
            }
            $date_array = $this->general_model->dateRange($delivery_startdate, $delivery_enddate);

            if (!is_null($foodiesid)) {
                $this->User->_table = "cart_package_menu_items";
                $this->User->Delete("cart_id IN (SELECT id FROM cart WHERE user_id=".$foodiesid." AND type=".$mealplan." AND typeid='".$packageid."')");
                
                $this->User->_table = "cart";
                $this->User->Delete(array("user_id"=>$foodiesid,"type"=>$mealplan,"typeid"=>$packageid));
                
                if(count($date_array) > 0){
                    foreach($date_array as $date){
                        
                        $dayname = date('l', strtotime($date));
                        $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
                        $day_index = array_search($dayname, $days);
    
                        $this->Package->_table = "weeklypackage";
                        $this->Package->_fields = "id,price,image";
                        $this->Package->_where = array("packageid"=>$packageid,"days"=>$day_index); 
                        $res_weekpkg = $this->Package->getRecordsById();
    
                        if(!empty($res_weekpkg)){
    
                            $insert_array = array(
                                "kitchen_id"        => $kitchen_id,
                                "user_id"           => $foodiesid,
                                "type"              => $mealplan,
                                "typeid"            => $packageid,
                                "weeklypackageid"   => $res_weekpkg['id'],
                                "name"              => $res_pkg['packagename'],
                                "price"             => $res_weekpkg['price'],
                                "delivery_date"     => $date,
                                "delivery_fromtime" => $delivery_fromtime,
                                "delivery_totime"   => $delivery_totime,
                                "including_saturday"=> $res_pkg['including_saturday'],
                                "including_sunday"  => $res_pkg['including_sunday'],
                                "createddate"       => $createddate,
                                "modifieddate"      => $createddate,
                            );
                            
                            $cart_id = $this->User->add($insert_array);
    
                            if($cart_id){
    
                                /* $this->Package->_table = "weeklypackagemenu";
                                $this->Package->_fields = "id,menuid,itemname,qty,price";
                                $this->Package->_where = array("weeklypackageid"=>$res_weekpkg['id']); 
                                $res_weekpkg_menu = $this->Package->getRecordById();
                                
                                if(!empty($res_weekpkg_menu)){
                                    foreach($res_weekpkg_menu as $val){  */
    
                                        $this->Package->_table = "order_customized_package_item";
                                        $this->Package->_fields = "id,userid,packageid,weeklypackageid,menuid,qty,itemprice, (SELECT itemname FROM mastermenu WHERE id=menuid) as itemname";
                                        $this->Package->_where = array("userid"=>$foodiesid,"packageid"=>$packageid,"weeklypackageid"=>$res_weekpkg['id']); 
                                        $res_extra_item = $this->Package->getRecordById();
                                        
                                        if (!empty($res_extra_item)) {
                                            foreach ($res_extra_item as $val) {
                                                $items_array[] = array(
                                                    "cart_id"       => $cart_id,
                                                    "menuid"        => $val['menuid'],
                                                    "itemname"      => $val['itemname'],
                                                    "qty"           => $val['qty'],
                                                    "price"         => $val['itemprice']
                                                );
                                            }
                                        }
                                        /* $qty = $val['qty'];
                                        if(!empty($res_extra_item)){
                                            $qty = ($qty == 0) ? ($res_extra_item['qty'] + 1) : ($qty + $res_extra_item['qty']);
                                        } */
    
                                        /* $items_array[] = array(
                                            "cart_id"       => $cart_id,
                                            "menuid"        => $val['menuid'],
                                            "itemname"      => $val['itemname'],
                                            "qty"           => $qty,
                                            "price"         => $val['price']
                                        );
                                    }
                                } */
                            }
    
                        }
                    }
                }
                if(!empty($items_array)){
                    $this->Package->_table = "cart_package_menu_items";
                    $this->Package->add_batch($items_array);
                }
                $this->Package->_table = "order_customized_package_item";
                $this->Package->Delete(array("userid"=>$foodiesid, "packageid"=>$packageid));

                $cartdata = $this->getCartItems($foodiesid);
            }else{
                $cart_array = array();
                
                $is_exist = 0;
                if(!empty($cartdata)){
                    foreach($cartdata as $i=>$item){
                        
                        if($item['type']==$mealplan && $item['typeid'] == $packageid){
                            
                            $item['delivery_startdate'] = $delivery_startdate;
                            $item['delivery_enddate'] = $delivery_enddate;
                            $item['delivery_fromtime'] = $delivery_fromtime;
                            $item['delivery_totime'] = $delivery_totime;

                            $is_exist = 1;
                        }
                        $cart_array[] = $item;
                    }
                }
                
                if($is_exist == 0){
                    $cart_array[] = array(
                        "kitchen_id"    => $kitchen_id,
                        "type"          => $mealplan,
                        "typeid"        => $packageid,
                        "name"          => $res_pkg['packagename'],
                        "mealfor"       => $res_pkg['mealfor'],
                        "delivery_startdate" => $delivery_startdate,
                        "delivery_enddate"   => $delivery_enddate,
                        "delivery_fromtime" => $delivery_fromtime,
                        "delivery_totime"   => $delivery_totime,
                    );
                }
                $this->session->set_userdata(array("CART_ITEMS" => $cart_array));
                
                $cartdata = $cart_array;
            }
            
            $count = count($cartdata);
            echo json_encode(array("type"=>1,"cartcount"=>$count));
        }else{
            echo json_encode(array("type"=>2,"cartcount"=>$count));
        }
    }

    function remove_cart_items(){
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');

        if(!is_null($foodiesid)){
            $this->User->_table = "cart_package_menu_items";
            $this->User->Delete("cart_id IN (SELECT id FROM cart WHERE user_id=".$foodiesid.")");
    
            $this->User->_table = 'cart';
            $this->User->Delete(array("user_id"=>$foodiesid));
        }else{
            $this->session->unset_userdata('CART_ITEMS');
        }

        echo 1;
    }
    public function addfavoritekitchen() {
        $PostData = $this->input->post();
        $kitchen_id = $PostData['kitchen_id'];
        $customerid = $this->session->userdata(base_url().'FOODIESUSERID');
        $createddate = $this->general_model->getCurrentDateTime();
        
        $insertdata = array("kitchenid" => $kitchen_id,
                            "customerid" => $customerid,
                            "createddate" => $createddate
                        );

        $this->User->_table = 'favorite_kitchen';
        $this->User->Add($insertdata);
                
        echo 1;
    }

    public function removefavoritekitchen() {
        $PostData = $this->input->post();
        $kitchen_id = $PostData['kitchen_id'];
        $customerid = $this->session->userdata(base_url().'FOODIESUSERID');
        $createddate = $this->general_model->getCurrentDateTime();

        $this->User->_table = 'favorite_kitchen';
        $this->User->Delete(array("kitchenid" => $kitchen_id,"customerid" => $customerid));
                
        echo 1;
    }

    public function addextraitem(){
        $PostData = $this->input->post();
        $userid = $this->session->userdata(base_url().'FOODIESUSERID');
        $packageid = $PostData['packageid'];
        $weeklypackageid = $PostData['weeklypackageid'];
        $extra_item = json_decode($PostData['extra_item'], true);
        $this->load->model("Package_model","Package");
        $this->Package->_table = 'order_customized_package_item';

        if(!is_null($userid)){
            $ids = array();
            if(!empty($extra_item)){
                foreach($extra_item as $value){

                    $menuid = $value['menuid'];
                    $itemprice = $value['itemprice'];
                    $qty = $value['qty'];

                    $this->Package->_where = array("userid"=>$userid,"packageid"=>$packageid,"weeklypackageid"=>$weeklypackageid,"menuid"=>$menuid);
                    $itemdata = $this->Package->getRecordsById();

                    if(!empty($itemdata)){

                        $updatedata = array(
                            "qty"=>$qty,
                            "itemprice"=>$itemprice
                        );
                        
                        $this->Package->_where = array("id"=>$itemdata['id']);
                        $this->Package->Edit($updatedata);
                        
                        $ids[] = $itemdata['id'];
                    }else{
                        
                        $insertdata = array(
                            "userid"=>$userid,
                            "packageid"=>$packageid,
                            "weeklypackageid"=>$weeklypackageid,
                            "menuid"=>$menuid,
                            "qty"=>$qty,
                            "itemprice"=>$itemprice
                        );

                        $id = $this->Package->Add($insertdata);
                        
                        $ids[] = $id;
                    }
                }
                
                if(count($ids) > 0){
                    $this->Package->Delete(array("id NOT IN (".implode(",", $ids).")"=>null,"userid"=>$userid,"packageid"=>$packageid,"weeklypackageid"=>$weeklypackageid));    
                }else{
                    $this->Package->Delete(array("userid"=>$userid,"packageid"=>$packageid,"weeklypackageid"=>$weeklypackageid));    
                }
            }else{
                $this->Package->Delete(array("userid"=>$userid,"packageid"=>$packageid,"weeklypackageid"=>$weeklypackageid));
            }

            $this->Package->_fields = ("(SELECT (weeklyprice + SUM(IFNULL((qty * itemprice),0))) FROM packages WHERE id=packageid) as price");
            $this->Package->_where = array("userid"=>$userid,"packageid"=>$packageid);
            $ex_items = $this->Package->getRecordsById();

            $order_price = $ex_items['price'];
            echo json_encode(array("status" => 1, "order_price" => $order_price));
        }else{
            $item_array = array();
            if(!empty($extra_item)){

                $index = $packageid . "_" . $weeklypackageid;

                $items = $this->session->userdata("CART_CUSTOMISABLE_ITEMS");
                $is_exist = 0;
                if(!empty($items)){
                    foreach($items as $key=>$item){
                        if($key == $index){
                            $item = $extra_item;
                            $is_exist = 1;
                        }

                        $item_array[$key] = ($item);
                    }
                }
                if ($is_exist == 0) {
                    $item_array[$index] = ($extra_item);
                }
                $this->session->set_userdata(array("CART_CUSTOMISABLE_ITEMS" => $item_array));               
            }

            $items = $this->session->userdata("CART_CUSTOMISABLE_ITEMS");
            
            $amount = 0;
            if (!empty($items)) {
                foreach ($items as $key => $item) {
                    
                    $json = ($item);
                    
                    if(!empty($json)){
                        foreach($json as $val){
                            $amount += ($val['itemprice'] * $val['qty']); 
                        }
                    }
                }
            }

            $this->Package->_table = 'packages';
            $this->Package->_fields = ("weeklyprice as price");
            $this->Package->_where = array("id" => $packageid);
            $package = $this->Package->getRecordsById();
            $order_price = number_format($package['price'] + $amount,2,'.','');
            echo json_encode(array("status"=>1, "order_price"=>$order_price));
        }        
    }
}