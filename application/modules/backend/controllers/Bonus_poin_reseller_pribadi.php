<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus_poin_reseller_pribadi extends Backend_Controller {

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
		
		$this->load->model('bonus_poin_reseller_pribadi_model', 'models');
	}

	public function index()
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Jenis Bonus', 'Nilai Bonus', 'Poin', 'Bonus Aktif', ''));

		$data_bonus_poin = $this->models->get_data_bonus_poin();

		$no = 1;
		foreach ($data_bonus_poin->result() as $value) {
			$this->table->add_row(array(
				$no, 
				$value->nama_jenis_bonus, 
				$value->nilai_bonus,
				$value->poin_bonus,
				($value->bonus_aktif == 1)? 'Ya' : 'Tidak',
				anchor(base_url()."backend/bonus_poin_reseller_pribadi/edit_bonus_poin/$value->bonus_poin_id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).' '.
				anchor(base_url()."backend/bonus_poin_reseller_pribadi/delete_bonus_poin/$value->bonus_poin_id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $value->nama_jenis_bonus ?')")),
			));
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 		=> 'bonus_poin_reseller_pribadi/list_bonus_poin',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function add_bonus_poin()
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'bonus_poin_reseller_pribadi/form_add_bonus_poin',
			'form_action' 	=> 'backend/bonus_poin_reseller_pribadi/add_bonus_poin',
		);

		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		
		$this->form_validation->set_rules('nama_jenis_bonus', 'Nama Jenis Bonus', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nilai_bonus', 'Nilai Bonus', 'trim|required|xss_clean');
		$this->form_validation->set_rules('poin_bonus', 'Poin Bonus', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bonus_aktif', 'Bonus Aktif', 'trim|required|xss_clean');
		

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {

				$input = $this->input->post(null, TRUE);

				$saved_bonus_poin = $this->models->simpan_bonus_poin($input);

				if ($saved_bonus_poin === TRUE) {					

					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}
			}
		}else{

			$this->load->view('include/template', $this->data);
		}
	}

	public function edit_bonus_poin($id)
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'bonus_poin_reseller_pribadi/form_edit_bonus_poin',
			'form_action' 	=> "backend/bonus_poin_reseller_pribadi/edit_bonus_poin/$id",
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {
				
				$this->form_validation->set_rules('nama_jenis_bonus', 'Nama Jenis Bonus', 'trim|required|xss_clean');
				$this->form_validation->set_rules('nilai_bonus', 'Nilai Bonus', 'trim|required|xss_clean');
				$this->form_validation->set_rules('poin_bonus', 'Poin Bonus', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bonus_aktif', 'Bonus Aktif', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE) {

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					$this->load->view('include/template', $this->data);
				} else {

					$id = $this->session->userdata('id_sekarang');

					$input = $this->input->post(null, TRUE);

					$saved_bonus_poin = $this->models->update_bonus_poin($input,$id);

					if ($saved_bonus_poin === TRUE) {					

						$this->session->set_flashdata('message_success', 'Berhasil mengubah data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);

					}else{

						$this->data['pesan_error'] = "Terjadi Kesalahan ";
						$this->load->view('include/template', $this->data);
					}
					
				}
			}else{
				$search = $this->models->cari_bonus_poin($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->bonus_poin_id);

					$this->load->view('include/template', $this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}

	public function delete_bonus_poin($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{
			if ($this->models->hapus_bonus_poin($id) === TRUE) {
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

/* End of file Bonus_poin_reseller_pribadi.php */
/* Location: ./application/modules/backend/controllers/Bonus_poin_reseller_pribadi.php */