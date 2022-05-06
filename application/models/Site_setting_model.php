<?php
class Site_setting_model extends Common_model{
	
    public $_table = 'sitesetting';
    public $_fields = "*";
    public $_where = array();
    public $_except_fields = array();

    function __construct() {
        parent::__construct();
    }

    function getsitesetting()
    {
        $this->db->select('*');
        $this->db->from('sitesetting'." as s");
        $this->db->where('s.id',1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }   

}