<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends Kitchen_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper('form');
    }

	function index(){
		$this->session->sess_destroy();
		redirect(KITCHENFOLDER . 'login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */