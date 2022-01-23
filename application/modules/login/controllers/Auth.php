<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->stencil->slice(array('head', 'footer'));

		$this->load->model('auth_model', 'models');
	}

	public function index()
	{
		if ($this->ion_auth->is_admin())
		{
			redirect('backend/dashboard/index','refresh');
		}

		//set title
		$this->stencil->title('Login');
		//set layout
		$this->stencil->layout('login_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set data
		$this->data = array(
			'form_action' => 'login/auth/index',
			//'main_view'	=> 'auth/form_login'
		);

		$this->data['email'] = array('name' => 'email',
			'id' => 'email',
			'type' => 'text',
			'class' => 'form-control',
			'value' => set_value('email', isset($form_value['email']) ? $form_value['email'] : ''),
			'placeholder' => 'E-Mail'
		);
		$this->data['password'] = array('name' => 'password',
			'id' => 'password',
			'type' => 'password',
			'class' => 'form-control',
			'value' => set_value('password', isset($form_value['password']) ? $form_value['password'] : ''),
			'placeholder' => 'Password'
		);
		//set url back
		$url = $this->session->userdata('url_back');
		$this->data['url_back'] = $url;

		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('secutity_code', 'Security Code', 'trim|required|callback_recaptcha_check');
		$this->form_validation->set_error_delimiters('<div style="color:#B04442;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE){
				$this->captcha();
				$this->data['pesan_error'] = "Terjadi Kesalahan";
				//$this->load->view('template/main_template', $this->data, FALSE);
				//set view
				$this->stencil->paint('login/index',$this->data);
			}else{

				$remember = (bool) $this->input->post('remember');

				$inputCaptcha = $this->input->post('secutity_code');
				$sessCaptcha = $this->session->userdata('mycaptcha');

				if($inputCaptcha === $sessCaptcha){
					if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
					{
						# jika login sukses
						
						if ($this->ion_auth->is_admin())
						{
							$this->data['message_success'] = $this->ion_auth->messages();
							redirect('backend/dashboard/index','refresh');
						}else{
							$this->data['message_success'] = $this->ion_auth->messages();
							redirect('member','refresh');
						}
					}
					else
					{
						# jika login gagal
						$this->captcha();
						$this->data['pesan_error'] = $this->ion_auth->errors();
						//$this->load->view('template/main_template', $this->data, FALSE);
						//set view
						$this->stencil->paint('login/index',$this->data);
					}
				}

				

			}
		}else{
			$this->captcha();
			//$this->load->view('template/main_template', $this->data, FALSE);
			//set view
			$this->stencil->paint('login/index',$this->data);
		}
	}

	public function logout()
	{
		$logout = $this->ion_auth->logout();

		redirect('login/auth/index', 'refresh');
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

	public function captcha()
	{
		$this->load->helper(array('captcha'));
		$config_captcha = array(
			'img_path'  => './captcha/',
			'img_url'  => base_url().'captcha/',
			'font_path' => './assets/fonts/OpenSans-Light.ttf',
			'img_width'  => 200,
			'img_height' => 50,
			'border' => 0, 
			'expiration' => 7200,
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
			'img_path'  => './captcha/',
			'img_url'  => base_url().'captcha/',
			'font_path'     => './assets/fonts/OpenSans-Light.ttf',
			'img_width'  => 200,
			'img_height' => 50,
			'border' => 0, 
			'expiration' => 7200,
			'word_length'   => 4,
			'font_size'     => 50,
		);
		// create captcha image
		$cap = create_captcha($config_captcha);
		// store the captcha word in a session
		$this->session->unset_userdata('mycaptcha');
		$this->session->set_userdata('mycaptcha', $cap['word']);
		// store image html code in a variable
		echo $cap['image'];
	}

}

/* End of file Auth.php */
/* Location: ./application/modules/login/controllers/Auth.php */