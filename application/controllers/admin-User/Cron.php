<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public $viewData = array();
	function __construct(){
		parent::__construct();
	}
	public function disable_expired_user_licence(){
        
        date_default_timezone_set('Asia/Kolkata');

        $UserData = $this->db->select("*")
                            ->from(tbl_user)
                            ->where("(DATE_ADD(createddate, INTERVAL expiredays DAY) < CURDATE()) AND status=1")
                            ->get()
                            ->result_array();
		
        if(!empty($UserData)){
            $userids = implode(",",array_column($UserData, "id"));
            $this->db->set("status", 0);
            $this->db->set("modifieddate", date('Y-m-d H:i:s'));
            $this->db->where("id IN (".$userids.")");
            $this->db->update(tbl_user);
        }
	}
}