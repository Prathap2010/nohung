<?php

/**
 * Description of common_model
 *
 * @author Femina Agravat : yudizsolution
 */
class Common_model extends CI_Model {

	//put your code here

	protected $_table;
	protected $_fields;
	protected $_where;
	protected $_except_fields = array();
	protected $_order;

	function __construct() {
		parent::__construct();
	}

	function insertRow($postData = array(), $key = '', $id = '') {

		if ($id == '') {
			$id = $this->add($postData);
		} else {
			$this->_where = array($key => $id);
			$id = $this->Edit($postData);
		}
		return $id;
	}

	function add($PostData) {

		$postArray = $this->getDatabseFields($PostData);

		$query = $this->db->insert($this->_table, $postArray);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return '';
		}

	}

	function add_batch($PostData) {

		$this->db->insert_batch($this->_table, $PostData,null,10000);
	}

	function edit_batch($PostData,$where) {

		$this->db->update_batch($this->_table, $PostData,$where);
	}
	
	function Edit($PostData) {

		$postArray = $this->getDatabseFields($PostData, $this->_table);
		
		$query = $this->db->update($this->_table, $postArray, $this->_where);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}

	}

	function Delete($PostData) {

		$this->db->where($PostData);
		$this->db->delete($this->_table);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	function changeDeleted($FieldName, $FieldValue, $UpdateData = array()) {

		$query = $this->db->query("UPDATE " . $this->_table . " SET eDelete = '1' WHERE  " . $FieldName . "=" . $FieldValue);

		if ($this->db->affected_rows() > 0) {
			return $query;
		} else {
			return '';
		}

	}

	function changeStatus($FieldName, $FieldValue, $UpdateData = array()) {

		$query = $this->db->query("UPDATE " . $this->_table . " SET eStatus = IF (eStatus = 'Active', 'Inactive','Active') WHERE  " . $FieldName . "=" . $FieldValue);
		if ($this->writedb->affected_rows() > 0) {
			return $query;
		} else {
			return '';
		}

	}

	protected function getDatabseFields($postData) {
		$table_fields = $this->getFields($this->_table);

		$final = array_intersect_key($postData, $table_fields);

		return $final;
	}

	function getFields() {

		$query = $this->db->query("SHOW COLUMNS FROM " . $this->_table);

		foreach ($query->result() as $row) {
			$table_fields[$row->Field] = $row->Field;
		}

		return $table_fields;
	}

	function getExceptFields() {
		$query = $this->db->query("SHOW COLUMNS FROM " . $this->_table);
		$this->_fields = array();
		foreach ($query->result() as $row) {
			if (!in_array($row->Field, $this->_except_fields)) {
				$this->_fields[$row->Field] = $row->Field;
			}

		}

		return implode(",", $this->_fields);
	}

	function getDBDateTime() {

		$result = $this->db->query("SELECT now() as dt");

		if ($result->num_rows() > 0) {
			$row = $result->row_array();
			return $row['dt'];
		} else {
			return '';
		}
	}

	public function CountRecords() {
		$this->db->where($this->_where);
		$this->db->from($this->_table);
		
		return $this->db->count_all_results();
	}

	function get_all() {
		$this->db->select($this->_fields, FALSE);
		$this->db->from($this->_table);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return '';
		}

	}

	function get_all_listdata($id='id',$order='DESC') {
		$this->db->select($this->_fields, FALSE);
		$this->db->from($this->_table);
		$this->db->order_by($id,$order);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}

	}

	function get_many_by() {
		
		$this->db->select($this->_fields, FALSE);
		$this->db->from($this->_table);
		$this->db->where($this->_where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}

	}

	function getRecordByID() {
		
		$result = $this->db->select($this->_fields)
			->from($this->_table)
			->where($this->_where)
			->order_by($this->_order)
			->get()->result_array();
	
		if (!empty($result)) {
			return $result;
		} else {
			return array();
		}

	}

	function getRecordsByID() {

		$result = $this->db->select($this->_fields)
			->from($this->_table)
			->where($this->_where)
			->get()->row_array();
		if (!empty($result)) {
			return $result;
		} else {
			return array();
		}

	}

	public function dropdownList() {

		$this->db->select($this->_fields, FALSE);
		$this->db->from($this->_table);
		$this->db->where($this->_where);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result();

			$arrDropdown = array('' => ' Select ');
			foreach ($result as $row) {
				$arrDropdown[$row->dKey] = $row->dValue;
			}

			return $arrDropdown;
		} else {
			return array();
		}
	}
	
	function curl_get_contents($url,$data='') {
	    $ch = curl_init();
	    //echo $data;exit;
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	    if($data!=''){
	    	//header includes Content type and api key

		    $headers = array(
		        'Content-Type:multipart/form-data'
		    );
	    	curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }

	    $data = curl_exec($ch);
	    curl_close($ch);

	    return $data;
	}
	public function GetEmailTemplateByID($iTemplateID) {

		$query = $this->db->get_where('emailtemplate', array("emailtype" => $iTemplateID));

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return '';
		}

	}

	function sendMail($tempId, $toEmail = NULL, $mailBodyArr = array(), $subjectArr = array()) {
		$this->load->library('email');

		if($tempId==0){
			$subjectTxt = $subjectArr[0];
			$strEmail1 = $mailBodyArr[0];
		}else{
			$getTemplate = $this->GetEmailTemplateByID($tempId);

			$subjectTxt = $getTemplate->subject;

			if (is_array($subjectArr) && !empty($subjectArr)) {
				foreach ($subjectArr as $key => $val) {
					$subjectTxt = str_replace($key, $val, $subjectTxt);
				}
			}

			/* REPLACE MAIL BODY KEY AND VALUES */
			$strEmail1 = str_replace('\"', '"', $getTemplate->message);
			//$strEmail1 = str_replace('\r\n', '', $strEmail1);
			$strEmail1 = str_replace('&nbsp;', ' ', $strEmail1);

			if (is_array($mailBodyArr) && !empty($mailBodyArr)) {
				foreach ($mailBodyArr as $key => $val) {
					$strEmail1 = str_replace($key, $val, $strEmail1);
				}
			}
		}
		// echo $strEmail1; exit;
		//return 0;
		$this->email->initialize(unserialize(EMAIL_CONFIG));
		$this->email->set_newline("\r\n");
		$this->email->from(SITE_EMAIL);
		$this->email->reply_to(SITE_EMAIL);
		$this->email->to($toEmail);
		$this->email->subject($subjectTxt);
		$this->email->message($strEmail1);
		
		if($this->email->send()){
			return 1;
		}else{
			return 0;
		}
	}
}
