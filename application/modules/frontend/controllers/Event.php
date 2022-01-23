<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends Frontend_Controller {	

	public function __construct()
	{
		parent::__construct();

		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('event_model');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Event');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Event', 'event');
		//url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'Event',
            'contentEvent'			=> $this->db->get_where('events',array('eventsShow'=>'y')),
        );

		//set view
		$this->stencil->paint('event/index',$data);
	}

	public function IntervalDays($CheckIn,$CheckOut)
	{
		$CheckInX = explode("-", $CheckIn);
		$CheckOutX = explode("-", $CheckOut);
		$date1 = mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
		$date2 = mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
		$interval =($date2 - $date1)/(3600*24);
		// returns numberofdays
		return  $interval ;
	}

	public function detail($id)
	{
		//set title
		$this->stencil->title('Detail Event');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Event', 'event');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//get data
		$query = $this->db->get_where('events',array('eventsSlug'=>$id));
		if ($query->num_rows() == 0) {
			$url = $this->session->userdata('lolin_urlback_frontend');
			redirect($url);
		}
		$get_id = $this->event_model->cari_id($id)->row();
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->deskripsi_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'About Us',
            'contentEventSelected'	=> $query->row(),
			'contentEvent'			=> $this->db->get_where('events',array('eventsShow'=>'y')),
			'contentPicture' 		=> $this->db->get_where('eventspic', array('eventsId'=>$get_id->eventsId))->result(),
        );

		//set view
		$this->stencil->paint('event/detail_event',$data);
	}

}

/* End of file Event.php */
/* Location: ./application/modules/frontend/controllers/Event.php */