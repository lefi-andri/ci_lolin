<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('reseller_model', 'models');
	}

	public function index()
	{
		if ($this->ion_auth->is_admin())
		{
			return show_error('Kamu harus keluar dari akun admin untuk melihat halaman ini.');
		}
		if ($this->ion_auth->logged_in()){
			redirect('member/dashboard','refresh');
		}

		//load_helper
		$this->load->helper('security');
		//set title
		$this->stencil->title('Member Area');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('member area', 'reseller');
		//url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
            'label'					=> 'Reseller Area',
            'content_profile' 		=> $this->db->get_where('content', ["contentId" => "2"])->row()->contentDesc,
        );

        $tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
       
		# L O G I N
		if (isset($_POST['login'])) {

			$this->form_validation->set_rules('username_login', 'E Mail', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password_login', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('secutity_code_login', 'Security Code', 'trim|required|callback_captcha_login_check');
			$this->form_validation->set_error_delimiters('<div style="color:#FF5252;">', '</div>');

			if ($this->form_validation->run() == FALSE) {
				$this->captcha_login();
				$this->captcha();

	      		$this->data['pesan_error'] = "Terjadi Kesalahan Input";
				//set view
				$this->stencil->paint('reseller/index',$this->data);

	      	}else{

				$remember = (bool) $this->input->post('remember');

				$inputCaptcha = $this->input->post('secutity_code_login');
				$sessCaptcha = $this->session->userdata('captcha_login');

				if ($this->ion_auth->login($this->input->post('username_login'), $this->input->post('password_login'), $remember))
				{

					if($inputCaptcha === $sessCaptcha){

						//if the login is successful
						//redirect them back to the home page
						$this->captcha_login();
						$this->captcha();
						$this->session->set_flashdata('message', $this->ion_auth->messages());

						# BUAT SESSION JENIS RESELLER
						#$user_id = $this->session->userdata('user_id');
						#$grup_reseller = $this->models->cari_jenis_reseller($user_id)->name;

						#$this->session->set_userdata('grup_reseller', $grup_reseller);
						redirect('member/dashboard', 'refresh');
					}else{
						#echo 'Captcha code was not match, please try again.';
						$this->captcha_login();
						$this->captcha();
						$this->data['pesan_error'] = "Terjadi Kesalahan Input";
						//set view
						$this->stencil->paint('reseller/index',$this->data);
					}					
				}else{
					// if the login was un-successful
					// redirect them back to the login page
					$this->captcha_login();
					$this->captcha();
					$this->data['pesan_error'] = "Akun tidak terdaftar";
					//set view
					$this->stencil->paint('reseller/index',$this->data);
				}
	      	}
		}else{
			$this->captcha_login();
			$this->captcha();
	      	//set view
			$this->stencil->paint('reseller/index',$this->data);
	    }
	}

	public function captcha_login()
	{
		$this->load->helper(array('captcha'));
		$config_captcha = array(
			'img_path'  	=> './captcha/',
			'img_url'  		=> base_url().'captcha/',
			'font_path'     => './assets/fonts/OpenSans-Light.ttf',
			'img_width'  	=> 200,
			'img_height' 	=> 50,
			'border' 		=> 0, 
			'expiration' 	=> 7200,
			'word_length'   => 4,
			'font_size'     => 50,
		);
		// create captcha image
		$cap = create_captcha($config_captcha);
		// store image html code in a variable
		$this->data['gambar_captcha_login'] = $cap['image'];
		// store the captcha word in a session
		$this->session->set_userdata('captcha_login', $cap['word']);
	}

	public function refresh_captcha_login()
	{
		$this->load->helper(array('captcha'));
		$config_captcha = array(
			'img_path'  	=> './captcha/',
			'img_url'  		=> base_url().'captcha/',
			'font_path'     => './assets/fonts/OpenSans-Light.ttf',
			'img_width'  	=> 200,
			'img_height' 	=> 50,
			'border' 		=> 0, 
			'expiration' 	=> 7200,
			'word_length'   => 4,
			'font_size'     => 50,
		);
		// create captcha image
		$cap = create_captcha($config_captcha);
		// store the captcha word in a session
		$this->session->unset_userdata('captcha_login');
		$this->session->set_userdata('captcha_login', $cap['word']);
		// store image html code in a variable
		#echo $this->data['gambar_captcha_login'] = $cap['image'];

		echo $cap['image'];
	}

	public function captcha()
	{
		$this->load->helper(array('captcha'));
		$config_captcha = array(
			'img_path'  	=> './captcha/',
			'img_url'  		=> base_url().'captcha/',
			'font_path' 	=> './assets/fonts/OpenSans-Light.ttf',
			'img_width'  	=> 200,
			'img_height' 	=> 50,
			'border' 		=> 0, 
			'expiration' 	=> 7200,
			'word_length'   => 4,
			'font_size'     => 50,
		);
		// create captcha image
		$cap = create_captcha($config_captcha);
		// store image html code in a variable
		$this->data['gambar_captcha'] = $cap['image'];
		// store the captcha word in a session
		$this->session->set_userdata('mycaptcha', $cap['word']);
	}

	public function refresh_captcha()
	{
		$this->load->helper(array('captcha'));
		$config_captcha = array(
			'img_path'  	=> './captcha/',
			'img_url'  		=> base_url().'captcha/',
			'font_path'     => './assets/fonts/OpenSans-Light.ttf',
			'img_width'  	=> 200,
			'img_height' 	=> 50,
			'border' 		=> 0, 
			'expiration' 	=> 7200,
			'word_length'   => 4,
			'font_size'     => 50,
		);
		// create captcha image
		$cap = create_captcha($config_captcha);
		// store the captcha word in a session
		$this->session->unset_userdata('mycaptcha');
		$this->session->set_userdata('mycaptcha', $cap['word']);
		// store image html code in a variable
		#echo $this->data['gambar_captcha'] = $cap['image'];

		echo $cap['image'];
	}

	public function test_email(){
		$token = frontend_controller::buat_token();
		
		# KIRIMKAN EMAIL AKTIVASI
		$email_to = "lefi.andri@beesafe.co.id";
		$email_konten = base_url()."reseller/activation/".$token;

		$email_template = "template_email_pendaftaran_reseller"; // Samakan dengan nama method template
		$subjek = "Test Pendaftaran";
		
		frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
	}

	public function create_reseller_pribadi()
	{
		//set title
		$this->stencil->title('About Us');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add(strtolower('reseller'), 'reseller');
		$this->breadcrumb->add(strtolower('pendaftaran member reseller'), 'reseller/pribadi/register');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
            'label'						=> 'Registrasi Reseller',
            'form_action' 				=> 'reseller/pribadi/register',
            'dropdown_paket_reseller' 	=> $this->models->dropdown_paket_reseller(),
        );

        //set url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->form_validation->set_rules('paket_id', 'Paket', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Handphone Reseller', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		$this->form_validation->set_rules('secutity_code', 'Security Code', 'trim|required|callback_recaptcha_check');

		$this->form_validation->set_error_delimiters('<div style="color:#FF5252; font_size:7px;">', '</div>');
		
		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->captcha();
				$this->data['pesan_error'] = "Terjadi Kesalahan Input";
				//$this->load->view('include/template/main', $this->data);
				//set view
				$this->stencil->paint('reseller/form_add_reseller_pribadi', $this->data);
			} else {

				$tipe = "reseller_pribadi";
				$buat_id_reseller = frontend_controller::create_reseller_code($tipe);

				$token = frontend_controller::buat_token();

				$input = $this->input->post(null, TRUE);

				if ($this->models->check_username($this->input->post('email')) === TRUE) {
					if ($this->form_validation->run() === TRUE && $this->models->create_reseller_pribadi($input, $token, $buat_id_reseller)){

						$post_last_id = $this->db->insert_id();

						$data = array(
							'active' => 0,
						);

						$this->db->where('id', $post_last_id);
						$this->db->update('users', $data);

						$inputCaptcha = $this->input->post('secutity_code');
						$sessCaptcha = $this->session->userdata('mycaptcha');
						if($inputCaptcha === $sessCaptcha){

							$pengaturan_email = frontend_controller::get_pengaturan_email();

							// Cek pengaturan email
							if ($pengaturan_email == 1) {

								# KIRIMKAN EMAIL AKTIVASI
								$email_to = $this->input->post('email');
								$email_konten = "Selamat anda berhasil terdaftar sebagai member.  Segera aktifkan akun anda dengan mengikuti tautan atau link berikut ini. <br>";
								$email_konten .= base_url()."reseller/activation/".$token;
								$email_konten .= "<br><br>Terima Kasih";
								$email_konten .= "<p><b>Lolin Kids Care Product</b></p>";

								#$email_template = "template_email_pendaftaran_reseller"; // Samakan dengan nama method template
								$email_template = "template_email_pendaftaran_reseller_info";
								$subjek = "Pendaftaran Reseller";
								
								$register = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

								if ($register) {
									
									#INFO
									$email_to = email_fordward();
									$email_konten = "Baru-baru ini ada pengunjung web melakukan pendaftaran reseller dengan detail : <br>";
									$email_konten .= "Nama : ".$this->input->post('nama_lengkap')."<br>";
									$email_konten .= "Nomor Telepon : ".$this->input->post('nomor_telepon_reseller')."<br>";
									$email_konten .= "Email : ".$this->input->post('email')."<br>";
									$email_konten .= "<br><br>Dimohon untuk ditinjau melalui panel admin. <br><a href='".base_url()."login/auth/index'>Login</a>";

									$email_template = "template_email_pendaftaran_reseller_info"; // Samakan dengan nama method template
									$subjek = "Info Pendaftaran Reseller";
									
									$kirim_ke_admin = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
									
									if ($kirim_ke_admin) {
										#Arahkan ke halaman berhasil
										$this->session->set_flashdata('pesan', 'Sukses mendaftar.');
										redirect(base_url().'registrasi-sukses');
									}	
								}

							}else{
								
								$this->session->set_flashdata('pesan', 'Sukses mendaftar.');
								redirect(base_url().'registrasi-sukses');
							}
							

						}else{
							$this->captcha();
							$this->data['pesan_error'] = "Terjadi Kesalahan Input";
							//set view
							$this->stencil->paint('reseller/form_add_reseller_pribadi', $this->data);
						}

						
					}else{
						
						$this->captcha();
						$this->data['pesan_error'] = "Tidak dapat menambah data. ";
						//set view
						$this->stencil->paint('reseller/form_add_reseller_pribadi', $this->data);
					}
				}else{
					
					$this->captcha();
					$this->data['pesan_error'] = "Email ini telah terdaftar, silahkan input email lain.";
					//set view
					$this->stencil->paint('reseller/form_add_reseller_pribadi', $this->data);
				}
			}
		}else{

			$this->captcha();
			//set view
			$this->stencil->paint('reseller/form_add_reseller_pribadi', $this->data);
		}
	}

	public function sukses_mendaftar(){
		//set title
		$this->stencil->title('Successfully register');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('successfully register', 'successfully_register');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> '',
        );

		//set view
		$this->stencil->paint('reseller/pendaftaran_berhasil', $data);	
	}



	public function create_reseller_organisasi()
	{
		//set title
		$this->stencil->title('Registrasi Distributor');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add(strtolower('reseller'), 'reseller');
		$this->breadcrumb->add(strtolower('pendaftaran member distributor'), 'reseller/organisasi/register');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
            'label'					=> 'Registrasi Distributor',
            'form_action' 			=> 'reseller/organisasi/register',
            'dropdown_paket_distributor' => $this->models->dropdown_paket_distributor(),
        );

        //set url back
        $url = $this->session->userdata('lolin_urlback_frontend');
		$this->data['lolin_urlback_frontend'] = $url;

		$this->form_validation->set_rules('paket_id', 'Paket', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'trim|required|xss_clean');
		$this->form_validation->set_rules('alamat_organisasi', 'Alamat Organisasi', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nomor_telepon_organisasi', 'Nomor Telepon Organisasi', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Reseller', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
		$this->form_validation->set_rules('secutity_code', 'Security Code', 'trim|required|callback_recaptcha_check');

		$this->form_validation->set_error_delimiters('<div style="color:#FF5252;">', '</div>');
		
		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->captcha();
				$this->data['pesan_error'] = "Terjadi Kesalahan Input";
				//set view
				$this->stencil->paint('reseller/form_add_reseller_organisasi', $this->data);
			} else {

				$tipe = "reseller_organisasi";
				$buat_id_reseller = frontend_controller::create_reseller_code($tipe);

				$token = frontend_controller::buat_token();

				$input = $this->input->post(null, TRUE);

				if ($this->models->check_username($this->input->post('email')) === TRUE) {
					if ($this->form_validation->run() === TRUE && $this->models->create_reseller_organisasi($input, $token, $buat_id_reseller)){

						$post_last_id = $this->db->insert_id();

						$data = array(
							'active' => 0,
						);
						$this->db->where('id', $post_last_id);
						$this->db->update('users', $data);

						$inputCaptcha = $this->input->post('secutity_code');
						$sessCaptcha = $this->session->userdata('mycaptcha');
						if($inputCaptcha === $sessCaptcha){

						$pengaturan_email = frontend_controller::get_pengaturan_email();

							// Cek pengaturan email
							if ($pengaturan_email == 1) {
								
								# KIRIMKAN EMAIL AKTIVASI
								$email_to = $this->input->post('email');
								$email_konten = "Selamat anda berhasil terdaftar sebagai member.  Segera aktifkan akun anda dengan mengikuti tautan atau link berikut ini. <br>";
								$email_konten .= base_url()."reseller/activation/".$token;
								$email_konten .= "<br><br>Terima Kasih";
								$email_konten .= "<p><b>Lolin Kids Care Product</b></p>";
								#$email_konten = base_url()."reseller/activation/".$token;

								#$email_template = "template_email_pendaftaran_reseller"; // Samakan dengan nama method template
								$email_template = "template_email_pendaftaran_reseller_info";
								$subjek = "Pendaftaran Distributor";
								
								$register = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

								if ($register) {

									#INFO
									$email_to = email_fordward();
									$email_konten = "Baru-baru ini ada pengunjung web melakukan pendaftaran distributor dengan detail : <br>";
									$email_konten .= "Nama Organisasi : ".$this->input->post('nama_organisasi')."<br>";
									$email_konten .= "Alamat Organisasi : ".$this->input->post('alamat_organisasi')."<br>";
									$email_konten .= "Nomor Telepon Organisasi : ".$this->input->post('nomor_telepon_organisasi')."<br>";
									$email_konten .= "Nama Perwakilan : ".$this->input->post('nama_lengkap')."<br>";
									$email_konten .= "Email : ".$this->input->post('email')."<br>";
									$email_konten .= "<br><br>Dimohon untuk ditinjau melalui panel admin. <br><a href='".base_url()."login/auth/index'>Login</a>";

									$email_template = "template_email_pendaftaran_reseller_info"; // Samakan dengan nama method template
									$subjek = "Info Pendaftaran Distributor";
									
									/*frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

									$this->session->set_flashdata('registrasi_berhasil', 'aktifkan akun Anda dengan mengikuti tautan yang telah kami kirimkan melalui email Anda.');
									redirect(base_url()."registration-successful", 'refresh');*/
									$kirim_ke_admin = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
									
									if ($kirim_ke_admin) {
										#Arahkan ke halaman berhasil
										$this->session->set_flashdata('pesan', 'Sukses mendaftar.');
										redirect(base_url().'registrasi-sukses');
									}
								}
								
							}else{

								#$this->session->set_flashdata('registrasi_berhasil', 'aktifkan akun Anda dengan mengikuti tautan yang telah kami kirimkan melalui email Anda.');
								#redirect(base_url()."registration-successful", 'refresh');
								$this->session->set_flashdata('pesan', 'Sukses mendaftar.');
								redirect(base_url().'registrasi-sukses');

							}

						}else{
							$this->captcha();
							$this->data['pesan_error'] = "Terjadi Kesalahan Input";
							//set view
							$this->stencil->paint('reseller/form_add_reseller_organisasi', $this->data);
						}

						
					}else{
						
						$this->captcha();
						$this->data['pesan_error'] = "Tidak dapat menambah data. ";
						//set view
						$this->stencil->paint('reseller/form_add_reseller_organisasi', $this->data);
					}
				}else{
					
					$this->captcha();
					$this->data['pesan_error'] = "Email ini telah terdaftar, silahkan input email lain.";
					//set view
					$this->stencil->paint('reseller/form_add_reseller_organisasi', $this->data);
				}
			}
		}else{
			$this->captcha();
			//set view
			$this->stencil->paint('reseller/form_add_reseller_organisasi', $this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		if ($logout) {
			//echo "<script>window.alert('Sukses keluar dari akun member');document.location.href = '".base_url('reseller')."';</script>";
			redirect(base_url('reseller'),'refresh');
		}

	}










	# ===========================================================

	public function aktivasi_akun($id = NULL)
	{
		if($id==""){
			return show_error('Kode aktivasi tidak boleh kosong.');
		}

		//set title
		$this->stencil->title('Account Activation');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('account activation', 'account_activation');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		
		$check = $this->models->cek_kode_aktivasi($id);

		if ($check === TRUE) {

			# Cek type organisasi atau pribadi
			#$tipe = $this->models->cek_nama_organisasi($id);
			#$buat_id_reseller = frontend_controller::create_reseller_code($tipe);

			date_default_timezone_get('Asia/Jakarta');
			$waktu_sekarang = date("Y-m-d h:i:s");
			$tanggal_sekarang = date('Y-m-d');

			$tambah_masa_poin = frontend_controller::tambah_masa_poin($tanggal_sekarang); // Tambah 12 Bulan Masa Aktif Poin,

			#$ubah_status = $this->models->ubah_status_aktivasi($id, $buat_id_reseller, $tambah_masa_poin);
			$ubah_status = $this->models->ubah_status_aktivasi($id, $tambah_masa_poin);

			if ($ubah_status === TRUE) {

				$pengaturan_email = frontend_controller::get_pengaturan_email();

				// Cek pengaturan email
				if ($pengaturan_email == 1) {
					# KIRIMKAN EMAIL KONFIRMASI
					$check_email = $this->models->cek_data_kode_aktivasi($id)->row();

					$email_to = $check_email->email;
					$email_konten = "Sukses, akun anda berhasil diaktifkan. Silahkan login melalui <a href='http://www.lolin.co.id/reseller'>http://www.lolin.co.id/reseller</a>";
					$email_konten .= "<br><br>Terima Kasih";
					$email_konten .= "<p><b>Lolin Kids Care Product</b></p>";

					$email_template = "template_email_aktivasi_registrasi_sukses"; // Samakan dengan nama method template
					$subjek = "Aktivasi Akun";
					
					$sukses = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

					if ($sukses) {

						#INFO
						$email_to = email_fordward();
						$email_konten = "Baru-baru ini ada pendaftar melakukan aktivasi akun dengan detail : <br>";
						$email_konten .= "Nama Lengkap : ".$check_email->nama_lengkap."<br>";
						$email_konten .= "Email : ".$check_email->email."<br>";
						$email_konten .= "<br><br>Dimohon untuk ditinjau melalui panel admin. <br><a href='".base_url()."login/auth/index'>Login</a>";
						

						$email_template = "template_email_pendaftaran_reseller_info"; // Samakan dengan nama method template
						$subjek = "Info Pendaftaran";
						
						frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						#return show_error('Akun telah aktif.');
						/*$this->data = array(
							'title' 				=> "Account Activation",
				            'description'			=> $meta->deskripsi_seo,
				            'keyword'				=> $meta->keyword_seo,
				            'label'					=> 'Account Activation',
				            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
							'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
							'pesan'					=> 'Sukses, akun anda berhasil diaktifkan. sekarang anda bisa login melalui tautan berikut '.anchor(base_url().'reseller', base_url().'reseller', array(''=>'')),
				            'main_view'				=> 'aktivasi_reseller/aktivasi_sukses',
				        );
				        $this->load->view('include/template/main', $this->data);*/
				        //set data
						$this->data = array(
				            'label'					=> 'Account Activation',
				            'pesan'					=> 'Sukses, akun anda berhasil diaktifkan. sekarang anda bisa login melalui tautan berikut '.anchor(base_url().'reseller', base_url().'reseller', array(''=>'')),
				        );

						//set view
						$this->stencil->paint('aktivasi_reseller/aktivasi_sukses', $this->data);
					}
				}else{
					/*$this->data = array(
						'title' 				=> "Account Activation",
			            'description'			=> $meta->deskripsi_seo,
			            'keyword'				=> $meta->keyword_seo,
			            'label'					=> 'Account Activation',
			            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
						'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
						'pesan'					=> 'Akun berhasil diaktifkan.',
			            'main_view'				=> 'aktivasi_reseller/aktivasi_sukses',
			        );
			        $this->load->view('include/template/main', $this->data);*/
					#return show_error('Akun telah aktif.');
					//set data
					$this->data = array(
			            'label'					=> 'Account Activation',
			            'pesan'					=> "Akun berhasil diaktifkan.",
			        );

					//set view
					$this->stencil->paint('aktivasi_reseller/aktivasi_sukses', $this->data);
				}
				
			}else{
				// Ini kalau kode verifikasi tidak sesuai
				/*$this->data = array(
					'title' 				=> "Account Activation",
		            'description'			=> $meta->deskripsi_seo,
		            'keyword'				=> $meta->keyword_seo,
		            'label'					=> 'Account Activation',
		            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
					'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
					'pesan'					=> 'Kesalahan memproses kode verifikasi.',
		            'main_view'				=> 'aktivasi_reseller/aktivasi_gagal',
		        );
		        $this->load->view('include/template/main', $this->data);
		        #return show_error('Kesalahan memproses kode verifikasi.');*/
		        //set data
				$this->data = array(
		            'label'					=> 'Account Activation',
		            'pesan'					=> "Kesalahan memproses kode verifikasi.",
		        );

				//set view
				$this->stencil->paint('aktivasi_reseller/aktivasi_gagal', $this->data);
			}

		}else{
			// Ini kalau sudah diaktifkan
			/*$this->data = array(
				'title' 				=> "Account Activation",
	            'description'			=> $meta->deskripsi_seo,
	            'keyword'				=> $meta->keyword_seo,
	            'label'					=> 'Account Activation',
	            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
				'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
				'pesan'					=> 'Akun ini telah aktif atau kode verifikasi tidak sesuai.',
	            'main_view'				=> 'aktivasi_reseller/aktivasi_sukses',
	        );
	        $this->load->view('include/template/main', $this->data);*/
	        //set data
			$this->data = array(
	            'label'					=> 'Account Activation',
	            'pesan'					=> "Akun ini telah aktif atau kode verifikasi tidak sesuai.",
	        );

			//set view
			$this->stencil->paint('aktivasi_reseller/aktivasi_sukses', $this->data);
	        #return show_error('Akun ini telah aktif atau kode verifikasi tidak sesuai. <a href="'.base_url('reseller').'">Lolin Kids Care Product</a>.');
		}
	}

	public function tes_kode(){

		#------------------------------------------------------------------------------------------------------- ID RESELLER
		/*$tipe = 'reseller_organisasi';

		if ($tipe == 'reseller_pribadi') {
            $ekstensi = 'RSP';
        } elseif($tipe == 'reseller_organisasi'){
            $ekstensi = 'RSO';
        }

        $this->db->select('MAX(meta.id) AS max_code');
        $this->db->from('meta');
        $this->db->join('users', 'users.id = meta.user_id');
        $this->db->like('meta.reseller_id', $ekstensi);
        $this->db->where('users.group_id >', '2');
        $query = $this->db->get()->row();

        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('reseller_id');
        $this->db->select('SUBSTRING(meta.reseller_id, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(meta.reseller_id, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(meta.reseller_id, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('meta');
        $this->db->join('users', 'users.id = meta.user_id');
        $this->db->where('users.group_id >', '2');
        $this->db->where('users.id', $maximal_id);
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah
        $id_reseller = $get_val->row()->reseller_id;
        $kode_depan = $get_val->row()->kode_depan;
        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

        if ($get_val->num_rows() > 0) {

            #$tanggal_dari_data_terakhir = substr($id_reseller, 4, 8); //4 kosong dari depan, 8 nilai yang diambil
            #$nomor_urut_dari_data_terakhir = substr($id_reseller, 13, 4); // 13 kosong dari depan, 4 nilai yang diambil

            if (($today == $tanggal_dari_data_terakhir) && ($kode_depan == $ekstensi)) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);

        }
        echo $reseller_id;*/

        


        #------------------------------------------------------------------------------------------------------- ID TEMPORARY ORDER

        /*$this->db->select('MAX(id_temporary) AS max_code');
        $this->db->from('temporary_purchase_order');
        $query = $this->db->get()->row();

        # maximal_id adalah id paling akhir
        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('kode_temporary');
        $this->db->select('SUBSTRING(kode_temporary, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(kode_temporary, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(kode_temporary, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('temporary_purchase_order');
        $this->db->where('id_temporary', $maximal_id);
        $this->db->group_by('kode_temporary');
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah

        if ($get_val->num_rows() > 0) {

        	$kode_temporary = $get_val->row()->kode_temporary;
	        $kode_depan = $get_val->row()->kode_depan;
	        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
	        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

            if ($today == $tanggal_dari_data_terakhir) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);

        }

        echo $kode_temporary;*/

        #------------------------------------------------------------------------------------------------------- ID ORDER
        
        $this->db->select('MAX(order_id) AS max_code');
        $this->db->from('purchase_order');
        $query = $this->db->get()->row();

        # maximal_id adalah id paling akhir
        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('order_code');
        $this->db->select('SUBSTRING(order_code, 1, 2) AS kode_depan');
        $this->db->select('SUBSTRING(order_code, 4, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(order_code, 13, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('purchase_order');
        $this->db->where('order_id', $maximal_id);
        $this->db->group_by('order_code');
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
	    $today = date("dmY"); // Tanpa pemisah

        if ($get_val->num_rows() > 0) {

        	$order_code = $get_val->row()->order_code;
	        $kode_depan = $get_val->row()->kode_depan;
	        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
	        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

            if ($today == $tanggal_dari_data_terakhir) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $id_invoice = "PO-".$today."-".sprintf("%04s", $no_urut); // PO : Purchase Order
            
        }else{

            $no_urut=1;
            $id_invoice = "PO-".$today."-".sprintf("%04s", $no_urut); // PO : Purchase Order

        }

        echo $id_invoice;
	}

	public function captcha_login_check()
    {
    	$inputCaptcha = $this->input->post('secutity_code_login');
		$sessCaptcha = $this->session->userdata('captcha_login');

    	if($inputCaptcha !== $sessCaptcha){
			$this->form_validation->set_message('captcha_login_check', 'Captcha tidak sama, Silahkan ulangi kembali.');
    		return FALSE;
		}else{
    		return TRUE;
    	}
    }

    public function recaptcha_check()
    {
    	$inputCaptcha = $this->input->post('secutity_code');
		$sessCaptcha = $this->session->userdata('mycaptcha');
    	if($inputCaptcha !== $sessCaptcha){
			$this->form_validation->set_message('recaptcha_check', 'Captcha tidak sama, Silahkan ulangi kembali.');
    		return FALSE;
		}else{
    		return TRUE;
    	}
    }

    public function email_check()
    {
    	$post_email = $this->input->post('email');
    	$cek_email = $this->db->get_where('users', array('email'=>$post_email));
    	if ($cek_email->num_rows() > 0) {
    		$this->form_validation->set_message('email_check', 'Email ini telah digunakan');
    		return FALSE;
    	}else{
    		return TRUE;
    	}
    }

}

/* End of file Reseller.php */
/* Location: ./application/modules/frontend/controllers/Reseller.php */