<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_terdaftar extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('reseller_terdaftar_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Registered member');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('registered member', 'registered_member');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));

        $data = $this->models->get_reseller_terdaftar();

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama Toko');
		$no = 1;
		foreach ($data->result() as $value) {
			$this->table->add_row(
				$no, 
				anchor($value->link_toko, '<b>'.$value->nama_toko.'</b>', array('title' => 'Reseller Terdaftar', 'target'=>'_blank', 'rel'=>'nofollow'))
			);
			$no++;
		}
		
		$template = array(
	        'table_open'            => '<table border="0" cellpadding="4" cellspacing="0">',

	        'thead_open'            => '<thead>',
	        'thead_close'           => '</thead>',

	        'heading_row_start'     => '<tr>',
	        'heading_row_end'       => '</tr>',
	        'heading_cell_start'    => '<th>',
	        'heading_cell_end'      => '</th>',

	        'tbody_open'            => '<tbody>',
	        'tbody_close'           => '</tbody>',

	        'row_start'             => '<tr>',
	        'row_end'               => '</tr>',
	        'cell_start'            => '<td>',
	        'cell_end'              => '</td>',

	        'row_alt_start'         => '<tr>',
	        'row_alt_end'           => '</tr>',
	        'cell_alt_start'        => '<td>',
	        'cell_alt_end'          => '</td>',

	        'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		//set data
		$data = array(
            'label'					=> 'Registered member',
            'main_view'				=> 'reseller_terdaftar/list_reseller_terdaftar',
            'table'					=> $this->table->generate(),
        );

        //set url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('reseller_terdaftar/list_reseller_terdaftar', $data);
	}

}

/* End of file Reseller_terdaftar.php */
/* Location: ./application/modules/frontend/controllers/Reseller_terdaftar.php */