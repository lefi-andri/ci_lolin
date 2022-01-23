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
		
		$this->load->model('faq_model', 'models');
	}

	public function index()
	{
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
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'faq/list_faq', 
		);

		$this->load->view('include/template', $data);
	}

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'faq/form_add_faq',
			'form_action' 	=> 'backend/faq/add'
		);

		$this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('jawaban', 'Jawaban', 'trim|required|xss_clean');
		$this->form_validation->set_rules('label', 'Label', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Ditampilkan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_faq($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
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
			'main_view' 	=> 'faq/form_add_faq',
			'form_action' 	=> "backend/faq/edit/$id"
		);

		$this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('jawaban', 'Jawaban', 'trim|required|xss_clean');
		$this->form_validation->set_rules('label', 'Label', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Ditampilkan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

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
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$search = $this->models->cari_faq($id);
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