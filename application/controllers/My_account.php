<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_account extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("User_model","User");
        $this->load->model("Order_model","Order");
    }

    public function index() {

        $title = "My Account";

        $this->viewData['page'] = "My_account";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "my_account";
        $this->viewData['headerclass'] = "deliverHeader";

        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        
        // $this->viewData['wallet_amount'] = $this->User->getFoodiesWalletBalance($foodiesid);

        $this->viewData['userdata'] = $this->User->getUserDataByID($foodiesid);

        $this->viewData['favorite_orderdata'] = $this->Order->getFoodiesFavoriteOrders($foodiesid);

        if(empty($this->viewData['userdata'])){
            show_404();
        }
        $this->foodies_headerlib->add_javascript("my_account","my_account.js");
        $this->load->view('template', $this->viewData);
    }

    public function add_card() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $this->User->_table = "cards";
        
        $is_default = isset($PostData['default-payment-card']) ? 'y' : 'n';

        if(!is_dir(CARD_PATH)){
            @mkdir(CARD_PATH);
        }

        if(!empty($PostData['card_id'])){

            $oldcardimg = trim($PostData['oldcardimg']);
            $cardimg = $oldcardimg;
			if(isset($_FILES['cardimg']['name']) && $_FILES['cardimg']['name']!=""){
				if(!empty($oldcardimg)){
					$cardimg = reuploadFile('cardimg', 'image', $oldcardimg, CARD_PATH ,"*", '', 0);
				}else{
					$cardimg = uploadFile('cardimg', 'image' ,CARD_PATH ,"*", '', 0);
				}
				if($cardimg !== 0){	
					if ($cardimg == 2) {
						echo "Image not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid image type !";//INVALID FILE TYPE
					exit;
				}
			}
            if($is_default == 'y'){
                $this->User->_where = array("userid"=>$foodiesid);
                $this->User->Edit(array('is_default'=>'n'));
            }

            $data_array = array(
                "card_name" => $PostData['card_name'],
                "card_number" => $this->general_model->encrypt($PostData['card_number']),
                "holder_name" => $PostData['cardholder_name'],
                "valid_thru"  => $this->general_model->encrypt($PostData['validthru']),
                "image" => $cardimg,
                "is_default"  => $is_default,
            );
            
            $this->User->_where = array("id"=>$PostData['card_id']);
            $this->User->Edit($data_array);
            
            $id = $PostData['card_id'];
        }else{

            $cardimg = "";
			if(isset($_FILES['cardimg']['name']) && $_FILES['cardimg']['name']!=""){
                $cardimg = uploadFile('cardimg', 'image' ,CARD_PATH ,"*", '', 0);
				if($cardimg !== 0){	
					if ($cardimg == 2) {
						echo "Image not uploaded !";//FILE NOT UPLOADED
						exit;
					}
				}else{
					echo "Invalid image type !";//INVALID FILE TYPE
					exit;
				}
			}

            if($is_default == 'y'){
                $this->User->_where = array("userid"=>$foodiesid);
                $this->User->Edit(array('is_default'=>'n'));
            }

            $data_array = array(
                "userid"      => $foodiesid,
                "card_name" => $PostData['card_name'],
                "card_number" => $this->general_model->encrypt($PostData['card_number']),
                "holder_name" => $PostData['cardholder_name'],
                "valid_thru"  => $this->general_model->encrypt($PostData['validthru']),
                "image" => $cardimg,
                "is_default"  => $is_default,
                "created_date"=> date("Y-m-d H:i:s")
            );
            
            $this->User->_table = "cards";
            $id = $this->User->Add($data_array);
        }
		
        if($id){
            echo 1;
        }else{
            echo 0;
        }
    }
    public function remove_card() {
        $PostData = $this->input->post();

        $this->User->_table = "cards";
        $this->User->Delete(array("id"=>$PostData['card_id']));
        
        echo 1;
    }
    public function get_cards() {
        $PostData = $this->input->post();
		$customer_id = $PostData['customer_id'];

        $cards = $this->User->getFoodiesCards($customer_id);

        $return = array();
        if(count($cards) > 0){
            foreach($cards as $value){

                if($value['image']!="" && file_exists(CARD_PATH.$value['image'])){
                    $image = CARD.$value['image'];
                }else{
                    $image = NOIMAGE;
                }

                $return[] = array(
                    "id" => $value['id'],
                    "card_name" => $value['card_name'],
                    "card_number" => $this->general_model->decrypt($value['card_number']),
                    "holder_name" => $value['holder_name'],
                    "valid_thru" => $this->general_model->decrypt($value['valid_thru']),
                    "image" => $image,
                    "is_default" => $value['is_default'],
                    "created_date" => $this->general_model->displaydatetime($value['created_date'])
                );
            }
        }
        echo json_encode($return);
    }
    public function get_card_detail() {
        $PostData = $this->input->post();
		$card_id = $PostData['card_id'];

        $card = $this->User->getCardDataById($card_id);

        $return = array();
        if(!empty($card)){
            
            $return = array(
                "id" => $card['id'],
                "card_name" => $card['card_name'],
                "card_number" => $this->general_model->decrypt($card['card_number']),
                "holder_name" => $card['holder_name'],
                "valid_thru" => $this->general_model->decrypt($card['valid_thru']),
                "image" => $card['image'],
                "is_default" => $card['is_default'],
                "created_date" => $this->general_model->displaydatetime($card['created_date'])
            );
        }
        echo json_encode($return);
    }
    public function load_order_history() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['customerid'] = $foodiesid;

        $this->viewData['order_history'] = $this->Order->getFoodiesOrdersHistory(PER_PAGE_ORDER, $offset, $PostData);

        // print_r($this->viewData['order_history']); exit;
        $return['totalrows'] = $this->Order->getFoodiesOrdersHistory(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view('order-history-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function load_active_orders() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['customerid'] = $foodiesid;

        $this->viewData['active_orders'] = $this->Order->getFoodiesActiveOrders(PER_PAGE_ORDER, $offset, $PostData);

        // print_r($this->viewData['order_history']); exit;
        $return['totalrows'] = $this->Order->getFoodiesActiveOrders(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view('active-order-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }

    public function add_address() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $this->User->_table = "customer_address";
        
        $is_delivery = isset($PostData['default-address']) ? 'y' : 'n';

        if(!empty($PostData['address_id'])){

            if($is_delivery == 'y'){
                $this->User->_where = array("user_id"=>$foodiesid);
                $this->User->Edit(array('is_delivery'=>'n'));
            }

            $data_array = array(
                "address"     => $PostData['address'],
                "latitude"    => $PostData['address_latitude'],
                "longitude"   => $PostData['address_longitude'],
                "is_delivery" => $is_delivery,
                "modifieddate"=> date("Y-m-d H:i:s")
            );
            
            $this->User->_where = array("id"=>$PostData['address_id']);
            $this->User->Edit($data_array);
            
            $id = $PostData['address_id'];
        }else{

            if($is_delivery == 'y'){
                $this->User->_where = array("user_id"=>$foodiesid);
                $this->User->Edit(array('is_delivery'=>'n'));
            }

            $data_array = array(
                "user_id"     => $foodiesid,
                "address"     => $PostData['address'],
                "latitude"    => $PostData['address_latitude'],
                "longitude"   => $PostData['address_longitude'],
                "is_delivery" => $is_delivery,
                "createddate" => date("Y-m-d H:i:s"),
                "modifieddate"=> date("Y-m-d H:i:s")
            );
            
            $this->User->_table = "customer_address";
            $id = $this->User->Add($data_array);
        }
		
        if($id){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function get_address() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['customerid'] = $foodiesid;
        $this->viewData['offset'] = $offset;

        $this->viewData['addresses'] = $this->User->getCustomerAddress(PER_PAGE_ADDRESS, $offset, $PostData);

        // print_r($this->viewData['order_history']); exit;
        $return['totalrows'] = $this->User->getCustomerAddress(PER_PAGE_ADDRESS, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view('address-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function add_deposit_amount() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $amount = $PostData['depositamount'];
        $this->User->_table = "customer_address";
        
        $data_array = array(
            "user_id" => $foodiesid,
            "amount" => $amount,
            "payment_status"  => 'pending',
            "createddate" => date("Y-m-d H:i:s")
        );
        
        $this->User->_table = "foodies_deposit_amount";
        $id = $this->User->Add($data_array);
        
        if($id){
            echo json_encode(array("status"=>"success","id"=>base64_encode($id)));
        }else{
            echo json_encode(array("status"=>"failed"));
        }
    }
    public function update_account() {
        $PostData = $this->input->post();
        $foodiesid = $this->session->userdata(base_url() . 'FOODIESUSERID');
        $name = $PostData['user_name'];
        $email = $PostData['user_email'];
        $oldprofileimage = $PostData['oldprofileimage'];
        $modifieddate = $this->general_model->getCurrentDateTime();

        $Check = $this->User->CheckEmailAvailable($email, $foodiesid);

        if (empty($Check)) {

            if (!is_dir(USER_PROFILE_PATH)) {
                @mkdir(USER_PROFILE_PATH);
            }
            $profile_image = $oldprofileimage;
            if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
                if (!empty($oldprofileimage)) {
                    $profile_image = reuploadFile('profile_image', 'image', $oldprofileimage, USER_PROFILE_PATH, "*", '', 0);
                } else {
                    $profile_image = uploadFile('profile_image', 'image', USER_PROFILE_PATH, "*", '', 0);
                }
                if ($profile_image !== 0) {
                    if ($profile_image == 2) {
                        echo 3; //FILE NOT UPLOADED
                        exit;
                    }
                } else {
                    echo 4; //INVALID FILE TYPE
                    exit;
                }
            }

            $updatedata = array(
                "kitchenname" => $name,
                "email" => $email,
                "profile_image" => $profile_image,
                "modifieddate" => $modifieddate
            );

            $this->User->_where = array("id"=>$foodiesid);
            $edit = $this->User->Edit($updatedata);
            
            if ($edit) {

                $userdata = array(
                    base_url() . 'FOODIESFULLNAME' => $name,
                    base_url() . 'FOODIESEMAIL' => $email,
                    base_url() . 'FOODIESPROFILEIMAGE' => $profile_image,
                );
                $this->session->set_userdata($userdata);

                echo 1;
            } else {
                echo 0;
            }
        }
        else
        {
            echo 2;
        }
    }
}