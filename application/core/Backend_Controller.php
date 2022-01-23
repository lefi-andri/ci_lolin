<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_Controller extends Core {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('security');
				
		$this->load->library('ion_auth');

		$this->load->helper(array('url', 'form'));
		
		$this->load->library(array('form_validation'));
		$this->form_validation->CI =& $this;
		
	}


}

/* End of file Backend_Controller.php */
/* Location: ./application/core/Backend_Controller.php */