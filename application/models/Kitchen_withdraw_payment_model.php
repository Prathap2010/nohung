<?php

class Kitchen_withdraw_payment_model extends Common_model {

	//put your code here
	public $_table = 'kitchenwithdrawpayment';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function getWithdrawPaymentList(){

		$query = $this->db->select("wp.id,wp.kitchen_id,wp.amount,wp.status,wp.createddate,
                    u.kitchenname,u.email,u.mobilenumber
                ")
				->from($this->_table." as wp")
                ->join("user as u","u.id=wp.kitchen_id","LEFT")
                ->order_by("wp.id","DESC")
				->get();
	
		return $query->result_array();
	}
	
}
