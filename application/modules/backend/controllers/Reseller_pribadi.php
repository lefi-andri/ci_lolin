<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_pribadi extends Backend_Controller {

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
		$this->load->model('reseller_pribadi_model', 'models');
	}

	public function index(){

		$this->load->helper('indonesiandate');
		//set title
		$this->stencil->title('Reseller Pribadi');
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

		$this->table->set_heading(array('No.', 'Nama Lengkap', 'Alamat', 'Email','Telepon Reseller', 'Terdaftar', 'Token', 'Aktif', ''));

		$reseller_pribadi_group = 'reseller_pribadi';
		$reseller_pribadi_users = $this->ion_auth->get_users($reseller_pribadi_group);
		
		$no = 1;
		foreach ($reseller_pribadi_users as $key => $user) {
			$id = $user->id;
			$name = $user->nama_lengkap;

			if ($user->tanggal_daftar_reseller) {
				list($tanggal, $waktu) = explode(' ', $user->tanggal_daftar_reseller);
			}
			

			$this->table->add_row(
				$no,
				$user->nama_lengkap.' --- '.$user->reseller_id,
				$user->alamat_reseller,
				$user->email,
				$user->nomor_telepon_reseller,
				($user->tanggal_daftar_reseller != '')? indonesian_date($tanggal).' --- '.$waktu : '',
				$user->token,
				($user->active) ? anchor("backend/reseller_pribadi/deactivate/".$user->id, 'Active', array('class'=>'btn btn-success btn-xs')) : anchor("backend/reseller_pribadi/activate/". $user->id, 'Inactive', array('class'=>'btn btn-danger btn-xs')),
				anchor("backend/reseller_pribadi/edit_user/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).''.
				anchor("backend/reseller_pribadi/delete_user/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'title'=>'Hapus data user', 'onclick' => "return confirm('Anda yakin ingin menghapus data $name ?')"))
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
			'label'	=> 'Reseller Pribadi',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('reseller_pribadi/list_reseller_pribadi',$data);
	}

	public function add_reseller_pribadi()
	{
		/*if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'reseller_pribadi/form_add_reseller_pribadi',
			'form_action' 	=> 'backend/reseller_pribadi/add_reseller_pribadi',
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_tanggal' => $this->models->dropdown_tanggal(),
			'dropdown_bulan' => $this->models->dropdown_bulan(),
			'dropdown_tahun' => $this->models->dropdown_tahun(),
			'dropdown_paket_reseller' => $this->models->dropdown_paket_reseller(),
		);
		*/

		//set title
		$this->stencil->title('Tambah Reseller');
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
			'label'			=> 'Tambah Reseller',
			'form_action' 	=> 'backend/reseller_pribadi/add_reseller_pribadi',
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_tanggal' => $this->models->dropdown_tanggal(),
			'dropdown_bulan' => $this->models->dropdown_bulan(),
			'dropdown_tahun' => $this->models->dropdown_tahun(),
			'dropdown_paket_reseller' => $this->models->dropdown_paket_reseller(),
		);

		//set validation
		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
			$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'required');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('bulan', 'Bulan Lahir', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun Lahir', 'required');
			$this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon Reseller', 'required');
			$this->form_validation->set_rules('alamat_reseller', 'Alamat Reseller', 'required');
			$this->form_validation->set_rules('bank_id', 'Nama Bank', 'required');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required');
			$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'required');

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

			$tipe = 'reseller_pribadi';
			$buat_id_reseller = core::buat_kode_reseller($tipe);

			$tanggal = $this->input->post('tanggal');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$tanggal_lahir = $tahun.'-'.$bulan.'-'.$tanggal;

			$additional_data = array(
				'nama_lengkap' => $this->input->post('nama_lengkap'),
				'nomor_ktp' => $this->input->post('nomor_ktp'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $tanggal_lahir,
				'nomor_telepon_reseller' => $this->input->post('nomor_telepon_reseller'),
				'alamat_reseller' => $this->input->post('alamat_reseller'),
				'bank_id' => $this->input->post('bank_id'),
				'nomor_rekening' => $this->input->post('nomor_rekening'),
				'nama_pemilik_rekening' => $this->input->post('nama_pemilik_rekening'),
				'reseller_id' => $buat_id_reseller,
				'tanggal_daftar_reseller' => $waktu_sekarang,
				'tanggal_kedaluwarsa_poin_reseller' => core::tambah_masa_poin($tanggal_sekarang), // Tambah 12 Bulan Masa Aktif Poin
				'paket_reseller_id' => $this->input->post('paket_id'),
			);

			$group_name = 'reseller_pribadi';

			if ($this->ion_auth->email_check($email))
			{
				$this->data['pesan_error'] = "Email telah digunakan";
				//set view
				$this->stencil->paint('reseller_pribadi/form_add_reseller_pribadi',$this->data);
			}else{
				if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $group_name)){

					$this->session->set_flashdata('message_success', 'Berhasil menambah user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{
					$this->data['pesan_error'] = "Terjadi Kesalahan Pengisian";
					//set view
					$this->stencil->paint('reseller_pribadi/form_add_reseller_pribadi',$this->data);
				}
			}

			

		}else{
			//set view
			$this->stencil->paint('reseller_pribadi/form_add_reseller_pribadi',$this->data);
		}

	}

	public function edit_user($id)
	{
		/*$this->load->library('breadcrumb');

		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->data = array(
			'main_view' 	=> 'reseller_pribadi/form_edit_reseller_pribadi',
			'form_action' 	=> "backend/reseller_pribadi/edit_user/$id",
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_tanggal' => $this->models->dropdown_tanggal(),
			'dropdown_bulan' => $this->models->dropdown_bulan(),
			'dropdown_tahun' => $this->models->dropdown_tahun(),
			'dropdown_paket_reseller' => $this->models->dropdown_paket_reseller(),
		);*/

		//set title
		$this->stencil->title('Edit Reseller');
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
			'label'			=> "Edit Reseller",
			'form_action' 	=> "backend/reseller_pribadi/edit_user/$id",
			'dropdown_bank' => $this->models->dropdown_bank(),
			'dropdown_tanggal' => $this->models->dropdown_tanggal(),
			'dropdown_bulan' => $this->models->dropdown_bulan(),
			'dropdown_tahun' => $this->models->dropdown_tahun(),
			'dropdown_paket_reseller' => $this->models->dropdown_paket_reseller(),
		);

		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
			$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'required');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('bulan', 'Bulan Lahir', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun Lahir', 'required');
			$this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon Reseller', 'required');
			$this->form_validation->set_rules('alamat_reseller', 'Alamat Reseller', 'required');
			$this->form_validation->set_rules('bank_id', 'Nama Bank', 'required');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required');
			$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'required');

			if ($this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			}

			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			}
			
			$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

			if ($this->form_validation->run() == true){

				$email = $this->input->post('email');
				if ($this->ion_auth->email_check($email))
				{
					$this->data['pesan_error'] = "Email telah digunakan";
					//set view
					$this->stencil->paint('reseller_pribadi/form_edit_reseller_pribadi',$this->data);
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
						//set view
						$this->stencil->paint('reseller_pribadi/form_edit_reseller_pribadi',$this->data);
					}

				}

				
			}else{
				$this->data['pesan_error'] = "Terjadi Kesalahan Pengisian";
				//set view
				$this->stencil->paint('reseller_pribadi/form_edit_reseller_pribadi',$this->data);
			}

			
		}else{
			
			$user = $this->ion_auth->get_user_array($id);
			foreach ($user as $key => $value) {
				$this->data['form_value'][$key] = $value;
			}

			$this->session->set_userdata('id_sekarang', $user['id']);

			//set view
				$this->stencil->paint('reseller_pribadi/form_edit_reseller_pribadi',$this->data);
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
		/*if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->load->library('breadcrumb');*/

		//set title
		$this->stencil->title('Deaktivasi Reseller');
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

		$id = (int) $id;

		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|is_natural');

		if ($this->form_validation->run() == FALSE)
		{
			$this->data = array(
				'label'			=> "Deaktivasi Reseller",
				'form_action' => "backend/admin/deactivate/$id",
				'csrf' => $this->_get_csrf_nonce(),
				'user' => $this->ion_auth->get_user_array($id),
			);
			//set view
			$this->stencil->paint('reseller_pribadi/deactivate_reseller_pribadi',$this->data);
			
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

			$reseller = $this->db->get_where('meta', array('id' => $id))->row();
			$foto_profile = $reseller->foto_profile;
			
			if ($foto_profile != "") {
				unlink('./assets/images/foto_profile/'.$foto_profile);
				unlink('./assets/images/foto_profile/small_'.$foto_profile);
				unlink('./assets/images/foto_profile/middle_'.$foto_profile);
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

}

/* End of file Reseller_pribadi.php */
/* Location: ./application/modules/backend/controllers/Reseller_pribadi.php */