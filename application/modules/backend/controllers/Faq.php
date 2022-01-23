<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Backend_Controller {

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
		$this->load->model('faq_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Faq');
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

		$this->table->set_heading('No', 'Label', 'Perbolehkan Tampil', 'Urutan', '');

		$kategori = $this->models->get_data_faq();

		$no = 1;
		foreach ($kategori->result() as $value) {
			$id = $value->id;
			$nama = $value->label;
			$this->table->add_row(
				$no, 
				$value->label,
				($value->perbolehkan_tampil == '1') ? 'Ya' : 'Tidak',
				$value->urutan,
				anchor("backend/faq/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/faq/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
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
			'label'	=> 'Faq',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('faq/list_faq',$data);
	}

	public function add(){
		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'faq/form_add_faq',
			'form_action' 	=> 'backend/faq/add'
		);*/

		//set title
		$this->stencil->title('Tambah faq');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		//set breadcrumb
		$this->load->library('breadcrumb');

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$this->data = array(
			'label'			=> 'Tambah Faq',
			'form_action' 	=> 'backend/faq/add'
		);

		//set validation
		$this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('jawaban', 'Jawaban', 'trim|required|xss_clean');
		$this->form_validation->set_rules('label', 'Label', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Ditampilkan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan Pengisian";
				//set view
				$this->stencil->paint('faq/form_add_faq',$this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_faq($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('faq/form_add_faq',$this->data);
				}

			}

		}else{
			//set view
			$this->stencil->paint('faq/form_add_faq',$this->data);
		}
	}

	public function edit($id = NULL){
		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'faq/form_add_faq',
			'form_action' 	=> "backend/faq/edit/$id"
		);*/
		//set title
		$this->stencil->title('Edit Faq');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$this->data = array(
			'label'			=> "Edit Faq",
			'form_action' 	=> "backend/faq/edit/$id"
		);

		//set validation
		$this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('jawaban', 'Jawaban', 'trim|required|xss_clean');
		$this->form_validation->set_rules('label', 'Label', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Ditampilkan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('faq/form_add_faq',$this->data);

			} else {

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_faq($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('faq/form_add_faq',$this->data);
				}

			}

		}else{
			$search = $this->models->cari_faq($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				//set view
				$this->stencil->paint('faq/form_add_faq',$this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

	public function delete($id = NULL){
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		} else {
			if ($this->models->hapus_faq($id) === TRUE) {
	
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

/* End of file Faq.php */
/* Location: ./application/modules/backend/controllers/Faq.php */