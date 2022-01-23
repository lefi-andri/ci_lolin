<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_order_reseller_organisasi extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('login/auth/index','refresh');
        }

        if (!$this->ion_auth->is_admin())
        {
           $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
           redirect('login/auth/index','refresh');
        }
		
		$this->load->model('rekaman_order_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Nama Organisasi', 'Alamat', 'Nama Perwakilan', 'Reseller Aktif', ''));

		$group = 'reseller_organisasi';
		$users = $this->ion_auth->get_users($group);

		$no = 1;
		foreach ($users as $value) {
			$this->table->add_row(array(
				$no, 
				$value->nama_organisasi,
				$value->alamat_organisasi,
				$value->nama_lengkap,
				($value->active == '1') ? 'Ya' : 'Tidak',
				anchor(base_url().'backend/rekaman_order_reseller_organisasi/data_rekaman/'.$value->id, 'Lihat Data', array('class'=>'btn btn-warning btn-xs')),
			));
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'rekaman_order_reseller_organisasi/list_reseller',
			'table' 		=> $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function data_rekaman($id = NULL){

		$this->load->library('breadcrumb');

		$this->load->helper('indonesiandate');

		$this->load->library('pagination');

		$config['base_url'] = base_url().'backend/rekaman_order_reseller_organisasi/data_rekaman/'.$id.'/page/';
        $config['total_rows'] = $this->models->total_record($id);
        $config['per_page'] = 2;
        $config['uri_segment'] = 6;
        $config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:0px">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['first_url'] = site_url('backend/rekaman_order_reseller_organisasi/data_rekaman/'.$id);

        $this->pagination->initialize($config);

        $start = $this->uri->segment(6);
        $rows = $this->models->user_limit($config['per_page'],$start,$id)->result();



		$this->data = array(
			'main_view' 	=> 'rekaman_order_reseller_organisasi/list_rekaman',
			'data' 			=> $rows,
            'pagination' 	=> $this->pagination->create_links(),
            'data_rekaman' 	=> $this->models->get_rekaman($id),
            'reseller_id'	=> $id,
		);

		$this->load->view('include/template', $this->data);
	}

}

/* End of file Rekaman_order_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Rekaman_order_reseller_organisasi.php */