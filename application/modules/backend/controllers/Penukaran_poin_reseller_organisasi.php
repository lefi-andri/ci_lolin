<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penukaran_poin_reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('penukaran_poin_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Kode Penukaran','Id Reseller', 'Nama Organisasi','Nama Perwakilan', 'Bonus', 'Penukaran', 'Tanggal Tukar', ''));

		$data_tukar_poin = $this->models->get_data_tukar_poin();

		$no = 1;
		foreach ($data_tukar_poin->result() as $value) {
			$this->table->add_row(array(
				$no, 
				$value->kode_tukar_poin,
				$value->reseller_id, 
				$value->nama_organisasi,
				$value->nama_lengkap,
				$value->poin_bonus,
				$value->nama_jenis_bonus,
				$value->tanggal_tukar_poin,
				anchor(base_url().'backend/penukaran_poin_reseller_organisasi/edit_tukar_poin/'.$value->tukar_poin_id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).' '.
				anchor(base_url().'backend/penukaran_poin_reseller_organisasi/delete_tukar_poin/'.$value->tukar_poin_id, '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $value->reseller_id ?')")),
			));
			$no++;
		}

		core:: buat_tabel();


		$this->data = array(
			'main_view' 		=> 'penukaran_poin_reseller_organisasi/list_penukaran_poin',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function add_tukar_poin()
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'penukaran_poin_reseller_organisasi/form_add_penukaran_poin',
			'form_action' 	=> 'backend/penukaran_poin_reseller_organisasi/add_tukar_poin',
			'data_reseller_organisasi' => $this->models->get_data_reseller_organisasi(),
			'data_bonus_poin' => $this->models->get_data_bonus_poin(),
		);

		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;

		$this->form_validation->set_rules('user_id', 'Reseller', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bonus_poin_id', 'Bonus', 'trim|required|xss_clean');
		

		if (isset($_POST['submit'])) {

			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {

				$input = $this->input->post(null, TRUE);

				$tipe = 'reseller_organisasi';
				$kode_tukar_poin = core::buat_kode_tukar_poin($tipe);

				$saved_tukar_poin = $this->models->simpan_tukar_poin($input, $kode_tukar_poin);

				if ($saved_tukar_poin === TRUE) {					

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

	public function edit_tukar_poin($id)
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'penukaran_poin_reseller_organisasi/form_edit_penukaran_poin',
			'form_action' 	=> "backend/penukaran_poin_reseller_organisasi/edit_tukar_poin/$id",
			'data_reseller_organisasi' => $this->models->get_data_reseller_organisasi(),
			'data_bonus_poin' => $this->models->get_data_bonus_poin(),
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {

				$this->form_validation->set_rules('user_id', 'Reseller', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bonus_poin_id', 'Bonus', 'trim|required|xss_clean');

				if ($this->form_validation->run() == FALSE) {

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					$this->load->view('include/template', $this->data);
				} else {

					$id = $this->session->userdata('id_sekarang');

					$input = $this->input->post(null, TRUE);

					$saved_tukar_poin = $this->models->update_tukar_poin($input,$id);

					if ($saved_tukar_poin === TRUE) {					

						$this->session->set_flashdata('message_success', 'Berhasil mengubah data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);

					}else{
						
						$this->data['pesan_error'] = "Terjadi Kesalahan ";
						$this->load->view('include/template', $this->data);
					}
					
				}
			}else{
				$search = $this->models->cari_tukar_poin($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->tukar_poin_id);

					$this->load->view('include/template', $this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}

	public function delete_tukar_poin($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{
			if ($this->models->hapus_tukar_poin($id) === TRUE) {
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

/* End of file Penukaran_poin_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Penukaran_poin_reseller_organisasi.php */