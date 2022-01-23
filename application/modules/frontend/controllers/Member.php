<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Member_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//set auth
		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }		
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer','user_info_menu'));
		//load model
		$this->load->model('member_model', 'models');
	}

	public function index()
	{
		//set indonesia helper
		$this->load->helper('indonesiandate');
		//set title
		$this->stencil->title('Dashboard');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('member', 'member');
		$this->breadcrumb->add('dashboard', 'member/index');

		//set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		//set id member
		$id_reseller = $this->session->userdata('user_id');
		//get meta data
		$meta = member_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'Dashboard',
            'data_reseller'			=> $this->ion_auth->get_user(),
			'poin_saat_ini'			=> member_controller::poin_member(),
			'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );

		//set view
		$this->stencil->paint('dashboard/list_dashboard',$data);
	}

}

/* End of file Member.php */
/* Location: ./application/modules/frontend/controllers/Member.php */