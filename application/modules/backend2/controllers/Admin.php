<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Backend_Controller {

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
		
		$this->load->model('admin_model', 'models');
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

		$this->table->set_heading(array('No.', 'Nama Lengkap', 'Email', 'Aktif', ''));

		$admin_group = 'admin';
		$admin_users = $this->ion_auth->get_users($admin_group);
		
		$no = 1;
		foreach ($admin_users as $key => $user) {
			$id = $user->id;
			$name = $user->nama_lengkap;
			$this->table->add_row(
				$no,
				$user->nama_lengkap,
				$user->email,
				($user->active) ? anchor("backend/admin/deactivate/$user->id", 'Active', array('class'=>'btn btn-success btn-xs')) : anchor("backend/admin/activate/$user->id", 'Inactive', array('class'=>'btn btn-danger btn-xs')),
				anchor("backend/admin/edit_user/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).''.
				anchor("backend/admin/delete_user/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'title'=>'Hapus data user', 'onclick' => "return confirm('Anda yakin ingin menghapus data $name ?')"))
			);
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 		=> 'admin/list_admin',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
		
	}

	public function add_admin()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('login/auth/index','refresh');
		}

		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'admin/form_add_admin',
			'form_action' 	=> 'backend/admin/add_admin'
		);

		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
			
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');

			$username = $this->input->post('email');#strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$additional_data = array('first_name' => $this->input->post('first_name'),
				#'last_name' => $this->input->post('last_name'),
				#'company' => $this->input->post('company'),
				'nama_lengkap' => $this->input->post('nama_lengkap')
			);

			$group_name = 'admin';

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
			'main_view' 	=> 'admin/form_edit_admin',
			'form_action' 	=> "backend/admin/edit_user/$id",
		);

		

		if (isset($_POST['submit'])){

			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|xss_clean');

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
				'main_view'	=> 'admin/deactivate_user',
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

/* End of file Admin.php */
/* Location: ./application/modules/backend/controllers/Admin.php */