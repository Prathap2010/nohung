<?php

class Manage_content_model extends Common_model {

    public $_table = "managecontent";
    public $_fields = "*";
    public $_where = array();
    public $_except_fields = array();

    function __construct() {
        parent::__construct();
    }

    function getContentsBySection($section=""){
        
        $query = $this->db->select('id,pagename,slug,title,description,section,status,createddate')
                    ->from($this->_table)
                    ->where("status=1 AND section='".$section."'")
                    ->get();

        return $query->result_array();
    }

    function getContentData(){

		$query = $this->db->select("id,pagename,slug,title,description,section,status,createddate")
				->from($this->_table)
				->order_by("id","DESC")
				->get();
	
		return $query->result_array();
	}
    function getContentDataByID($ID){
		$query = $this->db->select("id,pagename,slug,title,description,section,metadescription,metakeywords,status")
							->from($this->_table)
							->where("id='".$ID."'")
							->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}
    function getContentDetailBySlug($slug){
		$query = $this->db->select("id,pagename,slug,title,description,section,metadescription,metakeywords,status")
							->from($this->_table)
							->where("slug='".$slug."' AND status=1")
							->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}
    function CheckContent($slug,$id=''){

        if (isset($id) && $id != '') {
            $query = $this->db->query("SELECT id FROM ".$this->_table." WHERE slug ='".$slug."' AND id <> '".$id."'");
        }else{
            $query = $this->db->query("SELECT id FROM ".$this->_table." WHERE slug ='".$slug."'");
        }
       
        if($query->num_rows()  > 0){
            return 0;
        }
        else{
            return 1;
        }
    }
    
}
