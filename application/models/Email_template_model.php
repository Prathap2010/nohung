<?php

class Email_template_model extends Common_model {

	//put your code here
	public $_table = 'emailtemplate';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function getEmailtemplateListData(){

		$query = $this->db->select("id, emailtype, subject, message,createddate")
				->from('emailtemplate')
				->order_by("id","DESC")
				->get();
	
		return $query->result_array();
	}

    function CheckMailtemplateAvailable($emailtype,$id='')
    {
        if (isset($id) && $id != '') {
            $query = $this->db->query("SELECT id FROM emailtemplate WHERE emailtype ='".$emailtype."' AND id <> '".$id."'");
        }else{
            $query = $this->db->query("SELECT id FROM emailtemplate WHERE emailtype ='".$emailtype."'");
        }
       
        if($query->num_rows()  > 0){
            return 0;
        }
        else{
            return 1;
        }
	}
	
}
