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
		
		$this->load->model('konten_halaman_model', 'models');
	}

	public function index()
	{
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
				anchor("backend/konten_halaman/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/konten_halaman/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'konten_halaman/list_konten_halaman', 
		);

		$this->load->view('include/template', $data);
	}

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'konten_halaman/form_add_konten_halaman',
			'form_action' 	=> 'backend/konten_halaman/add',
			'dropdown_status' => $this->models->dropdown_status(),
		);

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
				$this->load->view('include/template', $this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_konten_halaman($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$this->load->view('include/template', $this->data);
		}
	}

	public function edit($id = NULL){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'konten_halaman/form_edit_konten_halaman',
			'form_action' 	=> "backend/konten_halaman/edit/$id",
			'dropdown_status' => $this->models->dropdown_status(),
		);

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
				$this->load->view('include/template', $this->data);

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
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$search = $this->models->cari_konten_halaman($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				$this->load->view('include/template', $this->data);
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