<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('reseller_organisasi_model', 'models');
	}

	public function index(){

		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}
		
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Nama organisasi & Id','Alamat', 'Telepon Organisasi','Perwakilan', 'Email','Telepon perwakilan', 'Terdaftar', 'Token','Aktif', ''));

		$reseller_organisasi_group = 'reseller_organisasi';
		$reseller_organisasi_users = $this->ion_auth->get_users($reseller_organisasi_group);
		
		$no = 1;
		foreach ($reseller_organisasi_users as $key => $user) {
			$id = $user->id;
			$name = $user->nama_organisasi;
			$this->table->add_row(
				$no,
				$user->nama_organisasi.' --- '.$user->reseller_id,
				$user->alamat_organisasi,
				$user->nomor_telepon_organisasi,
				$user->nama_lengkap,
				$user->email,
				$user->nomor_telepon_reseller,
				$user->tanggal_daftar_reseller,
				$user->token,
				($user->active) ? anchor("backend/reseller_organisasi/deactivate/".$user->id, 'Active', array('class'=>'btn btn-success btn-xs')) : anchor("backend/reseller_organisasi/activate/". $user->id, 'Inactive', array('class'=>'btn btn-danger btn-xs')),
				anchor("backend/reseller_organisasi/edit_user/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).''.
				anchor("backend/reseller_organisasi/delete_user/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'title'=>'Hapus data user', 'onclick' => "return confirm('Anda yakin ingin menghapus data $name ?')"))
			);
			$no++;
		}

		core:: buat_tabel_responsive();

		$this->data = array(
			'main_view' => 'reseller_organisasi/list_reseller_organisasi',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
		
	}

	public function add_reseller_organisasi()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'reseller_organisasi/form_add_reseller_organisasi',
			'form_action' 	=> 'backend/reseller_organisasi/add_reseller_organisasi',
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_paket_distributor' => $this->models->dropdown_paket_distributor(),
		);

		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('alamat_organisasi', 'Alamat Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_telepon_organisasi', 'Telepon Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Perwakilan', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'required|xss_clean');
			$this->form_validation->set_rules('bank_id', 'Nama Bank', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required|xss_clean');
			$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			
			$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

			$username = $this->input->post('email');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			date_default_timezone_get('Asia/Jakarta');
			$waktu_sekarang = date("Y-m-d h:i:s");
			$tanggal_sekarang = date('Y-m-d');
			$tambah_tanggal = date('Y-m-d', strtotime('+1 year', strtotime($tanggal_sekarang)));

			$tipe = 'reseller_organisasi';
			$buat_id_reseller = core::buat_kode_reseller($tipe);

			$additional_data = array(
				'nama_organisasi' => $this->input->post('nama_organisasi'),
				'alamat_organisasi' => $this->input->post('alamat_organisasi'),
				'nomor_telepon_organisasi' => $this->input->post('nomor_telepon_organisasi'),
				'nama_lengkap' => $this->input->post('nama_lengkap'),
				'nomor_ktp' => $this->input->post('nomor_ktp'),
				'bank_id' => $this->input->post('bank_id'),
				'nomor_rekening' => $this->input->post('nomor_rekening'),
				'nama_pemilik_rekening' => $this->input->post('nama_pemilik_rekening'),
				'tanggal_daftar_reseller' => $waktu_sekarang,
				'reseller_id' => $buat_id_reseller,
				'tanggal_kedaluwarsa_poin_reseller' => core::tambah_masa_poin($tanggal_sekarang), // Tambah 12 Bulan Masa Aktif Poin
				'paket_reseller_id' => $this->input->post('paket_id'),
			);

			$group_name = 'reseller_organisasi';

			if ($this->ion_auth->email_check($email))
			{
				$this->data['pesan_error'] = "Email telah digunakan";
				$this->load->view('include/template', $this->data);
			}else{
				if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $group_name)){

					$this->session->set_flashdata('message_success', 'Berhasil menambah user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{
					$this->data['pesan_error'] = "Terjadi Kesalahan Pengisian";
					$this->load->view('include/template', $this->data);
				}
			}

		}else{
			$this->load->view('include/template', $this->data);
		}

	}

	public function edit_user($id)
	{
		$this->load->library('breadcrumb');

		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->data = array(
			'main_view' 	=> 'reseller_organisasi/form_edit_reseller_organisasi',
			'form_action' 	=> "backend/reseller_organisasi/edit_user/$id",
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_paket_distributor' => $this->models->dropdown_paket_distributor(),
		);

		

		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('alamat_organisasi', 'Alamat Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_telepon_organisasi', 'Telepon Organisasi', 'required|xss_clean');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Perwakilan', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'required|xss_clean');
			$this->form_validation->set_rules('bank_id', 'Nama Bank', 'required|xss_clean');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required|xss_clean');
			$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'required|xss_clean');

			if ($this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			}

			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');

			if ($this->form_validation->run() == true){

				$email = $this->input->post('email');
				if ($this->ion_auth->email_check($email))
				{
					$this->data['pesan_error'] = "Email telah digunakan";
					$this->load->view('include/template', $this->data);
				}else{

					$id = $this->session->userdata('id_sekarang');
					$input = $this->input->post(null, TRUE);

					$update = $this->models->update_user($id, $input);
					
					if ($update === TRUE) {

						$this->session->unset_userdata('id_sekarang');

						$this->session->set_flashdata('message_success', 'Berhasil update data user.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);

					}else{

						$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
						$this->load->view('include/template', $this->data);
					}

				}

				
			}else{
				$this->data['pesan_error'] = "Terjadi Kesalahan Pengisian";
				$this->load->view('include/template', $this->data);
			}

			
		}else{
			
			$user = $this->ion_auth->get_user_array($id);
			foreach ($user as $key => $value) {
				$this->data['form_value'][$key] = $value;
			}

			$this->session->set_userdata('id_sekarang', $user['id']);

			$this->load->view('include/template', $this->data);
		}

	}

	function activate($id, $code=false)
	{
		if ($code !== false)
			$activation = $this->ion_auth->activate($id, $code);
		else if ($this->ion_auth->is_admin())
			$activation = $this->ion_auth->activate($id);


		if ($activation)
		{
			$this->session->set_flashdata('message_success', $this->ion_auth->messages());
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}
		else
		{
			$this->session->set_flashdata('message_warning', $this->ion_auth->errors());
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}
	}

	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->load->library('breadcrumb');

		$id = (int) $id;

		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|is_natural');

		if ($this->form_validation->run() == FALSE)
		{
			$this->data = array(
				'form_action' => "backend/admin/deactivate/$id",
				'main_view'	=> 'reseller_organisasi/deactivate_reseller_organisasi',
				'csrf' => $this->_get_csrf_nonce(),
				'user' => $this->ion_auth->get_user_array($id),
			);
			$this->load->view('include/template', $this->data);
			
		}
		else
		{
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				/*if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}*/

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}

		
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function delete_user($id)
	{
		if ($id) {
			$data_profile = $this->models->cari_gambar_foto_profile($id);
			if ($data_profile->num_rows() > 0) {
				if ($data_profile->row()->foto_profile != "") {

					$temp_gambar_foto_profile 	= $data_profile->row()->foto_profile;

					# Menghapus gambar caption
					if ($temp_gambar_foto_profile) {
						unlink('./assets/images/foto_profile/'.$temp_gambar_foto_profile);
						unlink('./assets/images/foto_profile/small_'.$temp_gambar_foto_profile);
						unlink('./assets/images/foto_profile/middle_'.$temp_gambar_foto_profile);
					}
				}
			}

			if ($this->ion_auth->delete_user($id)) {
				$this->session->set_flashdata('message_success', 'Proses hapus data berhasil.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			} else {
				$this->session->set_flashdata('message_success', 'Proses hapus data gagal.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		} else {
			$this->session->set_flashdata('message_success', 'Data reseller tidak ada.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}
		
	}

	public function tes(){
		$tanggal_kedaluwarsa = "2019-06-23";

		# Menambah 12 Bulan
		$ceks = core::tambah_masa_poin($tanggal_kedaluwarsa);
		echo $ceks;

		echo '<hr>';

		# Hitung tanggal kedaluwarsa
		$cek = core::cek_selisih_tanggal_kedaluwarsa($tanggal_kedaluwarsa);
		echo $cek;


	}

}

/* End of file Reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Reseller_organisasi.php */