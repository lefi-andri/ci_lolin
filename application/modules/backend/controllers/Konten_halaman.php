<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konten_halaman extends Backend_Controller {

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
		//set model
		$this->load->model('konten_halaman_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Konten Halaman');
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

		$this->table->set_heading('No', 'Judul', 'Permalink','Perbolehkan Tampil', 'Peta Situs', 'Status Halaman', '');

		$konten_halaman = $this->models->get_data_konten_halaman();

		$no = 1;
		foreach ($konten_halaman->result() as $value) {
			$id = $value->id;
			$nama = $value->judul;
			$this->table->add_row(
				$no,
				$value->judul,
				$value->slug,
				($value->perbolehkan_tampil == '1') ? 'Ya' : 'Tidak',
				($value->peta_situs == '1') ? 'Ya' : 'Tidak',
				$value->nama_status,
				anchor("backend/konten_halaman/edit/$id",'<i class="fa fa-edit"></i> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-default btn-sm'))." ".
				anchor("backend/konten_halaman/delete/$id",'<i class="fa fa-trash"></i> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-default btn-sm', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
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
			'label'	=> 'Konten Halaman',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('konten_halaman/list_konten_halaman',$data);
	}

	public function add(){

		//set title
		$this->stencil->title('Tambah Konten Halaman');
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
			'label'			=> 'Tambah Konten Halaman',
			'form_action' 	=> 'backend/konten_halaman/add',
			'dropdown_status' => $this->models->dropdown_status(),
		);

		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'konten_halaman/form_add_konten_halaman',
			'form_action' 	=> 'backend/konten_halaman/add',
			'dropdown_status' => $this->models->dropdown_status(),
		);*/

		$this->form_validation->set_rules('judul', 'Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|xss_clean');
		$this->form_validation->set_rules('deskripsi_seo', 'Deskripsi Seo', 'trim|xss_clean');
		$this->form_validation->set_rules('keyword_seo', 'Keyword Seo', 'trim|xss_clean');
		$this->form_validation->set_rules('status_id', 'Status', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Perbolehkan Tampil', 'trim|required|xss_clean');
		$this->form_validation->set_rules('peta_situs', 'Peta Situs', 'trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('konten_halaman/form_add_konten_halaman',$this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_konten_halaman($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('konten_halaman/form_add_konten_halaman',$this->data);
				}

			}

		}else{
			//set view
			$this->stencil->paint('konten_halaman/form_add_konten_halaman',$this->data);
		}
	}

	public function edit($id = NULL){
		//set title
		$this->stencil->title('Edit Konten Halaman');
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
			'label'			=> "Edit Konten Halaman",
			'form_action' 	=> "backend/konten_halaman/edit/$id",
			'dropdown_status' => $this->models->dropdown_status(),
		);

		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'konten_halaman/form_edit_konten_halaman',
			'form_action' 	=> "backend/konten_halaman/edit/$id",
			'dropdown_status' => $this->models->dropdown_status(),
		);*/

		$this->form_validation->set_rules('judul', 'Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|xss_clean');
		$this->form_validation->set_rules('deskripsi_seo', 'Deskripsi Seo', 'trim|xss_clean');
		$this->form_validation->set_rules('keyword_seo', 'Keyword Seo', 'trim|xss_clean');
		$this->form_validation->set_rules('status_id', 'Status', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Perbolehkan Tampil', 'trim|required|xss_clean');
		$this->form_validation->set_rules('peta_situs', 'Peta Situs', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('konten_halaman/form_edit_konten_halaman',$this->data);

			} else {

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_konten_halaman($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('konten_halaman/form_edit_konten_halaman',$this->data);
				}

			}

		}else{
			$search = $this->models->cari_konten_halaman($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				//set view
				$this->stencil->paint('konten_halaman/form_edit_konten_halaman',$this->data);
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

			if ($this->models->hapus_konten_halaman($id) === TRUE) {

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

/* End of file Konten_halaman.php */
/* Location: ./application/modules/backend/controllers/Konten_halaman.php */