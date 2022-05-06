<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends Admin_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper('form');
    }

	function index(){
		$this->session->sess_destroy();
		redirect(ADMINFOLDER.'Login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */