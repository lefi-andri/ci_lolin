<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan extends Backend_Controller {

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
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//load model
		$this->load->model('pertanyaan_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Pertanyaan');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama', 'Email', 'Telpon', 'Pertanyaan', 'Waktu', '');

		$pertanyaan = $this->models->get_data_pertanyaan();

		$no = 1;
		foreach ($pertanyaan->result() as $value) {
			$id = $value->id;
			$nama = $value->nama;
			$this->table->add_row(
				$no, 
				$value->nama,
				$value->email,
				$value->telepon,
				$value->isi_pertanyaan,
				$value->waktu,
				anchor("backend/pertanyaan/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}

		$template = array(
	        'table_open'            => '<table id="dt-opt" class="table table-lg table-hover">',
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

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$data = array(
			'label'	=> 'Pertanyaan',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('pertanyaan/list_pertanyaan',$data);
		/*$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama', 'Email', 'Telpon', 'Pertanyaan', 'Waktu', '');

		$pertanyaan = $this->models->get_data_pertanyaan();

		$no = 1;
		foreach ($pertanyaan->result() as $value) {
			$id = $value->id;
			$nama = $value->nama;
			$this->table->add_row(
				$no, 
				$value->nama,
				$value->email,
				$value->telepon,
				$value->isi_pertanyaan,
				$value->waktu,
				anchor("backend/pertanyaan/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'pertanyaan/list_pertanyaan', 
		);

		$this->load->view('include/template', $data);*/
	}

	public function delete($id = NULL){
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		} else {
			if ($this->models->hapus_pertanyaan($id) === TRUE) {
	
				$this->session->set_flashdata('message_success', 'Proses hapus data berhasil.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);

			}else{
				$this->session->set_flashdata('message_error', 'Gagal menghapus data!');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

}

/* End of file Pertanyaan.php */
/* Location: ./application/modules/backend/controllers/Pertanyaan.php */