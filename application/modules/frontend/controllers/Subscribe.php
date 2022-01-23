<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('subscribe_model');
	}

	public function index()
	{
		if (empty($this->input->post('your_email'))) {
			redirect('home','refresh');
		}

		$this->session->set_userdata('your_email', $this->input->post('your_email'));
		$subscriber_email = $this->session->userdata('your_email');
		$subs = $this->db->get_where('newsletter_subscriber', array('email_subscriber'=>$subscriber_email));

		//set title
		$this->stencil->title('Subscribe');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('subscribe', 'subscribe');
		//get meta data
		$meta = frontend_controller::get_meta(7);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));

		//set data
		$data = array(
            'label'					=> 'Subscribe',
            'subscriber_email'		=> $subscriber_email,
        );

        if ($subs->num_rows() > 0) {
        	//set view
			$this->stencil->paint('subscribe/subscribe_is_exist',$data);
        }else{
        	if (isset($_POST['submit'])) {
				//set view
				$this->stencil->paint('subscribe/index',$data);
			}
        }
	}

}

/* End of file Subscribe.php */
/* Location: ./application/modules/frontend/controllers/Subscribe.php */