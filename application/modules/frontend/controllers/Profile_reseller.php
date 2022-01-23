<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_reseller extends Member_Controller {

	public function __construct()
	{
		parent::__construct();

		//set auth
		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer','user_info_menu'));
		//load model
		$this->load->model('profile_reseller_model', 'models');
		
	}

	public function index()
	{
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);
		//set title
		$this->stencil->title('Profile Member');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('poin', 'reseller/poin');

		//set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		//set id member
		$id_reseller = $this->session->userdata('user_id');
		//get meta data
		$meta = member_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
            'label'					=> 'Profile Member',
            'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
			'poin_saat_ini'			=> member_controller::poin_member(),
			'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

			'dropdown_bank' 		=> $this->models->dropdown_bank(),
			'dropdown_tanggal' 		=> $this->models->dropdown_tanggal(),
			'dropdown_bulan' 		=> $this->models->dropdown_bulan(),
			'dropdown_tahun' 		=> $this->models->dropdown_tahun(),

			'form_action' 			=> 'member/profile',


        );

        if ($this->input->post('grup_reseller') == 'reseller_pribadi') {
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Reseller', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('alamat_reseller', 'Alamat', 'trim|required|xss_clean');
	        
	        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|xss_clean');
		}

		//$this->form_validation->set_rules('bank_id', 'Nama Bank', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'trim|required|xss_clean');
        
        if ($this->input->post('grup_reseller') == 'reseller_organisasi') {
        	$this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('alamat_organisasi', 'Alamat Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_telepon_organisasi', 'Nomor Telepon Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon Pribadi', 'trim|required|xss_clean');
        }

        if ($this->input->post('password')) {
        	$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        }

        $this->form_validation->set_error_delimiters('<div style="color:red; font-size: 10px">', '</div>');

        if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {
				$this->data['pesan_error'] = 'Terjadi kesalahan input ';
				//set view
				$this->stencil->paint('profile_reseller/list_profile',$this->data);

			}else{

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_profile_reseller($input, $id_reseller);
					
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Sukses mengupdate data member.');
					$url = $this->session->userdata('lolin_urlback_frontend');
					redirect($url);
				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('profile_reseller/list_profile',$this->data);
				}

			}
		}else{

			$search = $this->ion_auth->get_user();

			if ($search) {
					
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}

					//set view
					$this->stencil->paint('profile_reseller/list_profile',$this->data);

			}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_frontend');
					redirect($url);
			}
				
		}

		

		/*$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('profile', 'reseller/profile');

		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);

		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);
		
		$meta = reseller_controller::get_meta(2);
		
		$this->data = array(
			
            'title' 				=> "Profil - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'dropdown_bank' 		=> $this->models->dropdown_bank(),
			'dropdown_tanggal' 		=> $this->models->dropdown_tanggal(),
			'dropdown_bulan' 		=> $this->models->dropdown_bulan(),
			'dropdown_tahun' 		=> $this->models->dropdown_tahun(),

			'label'					=> 'Profile',
			'form_action' 			=> 'reseller/profile',
            'main_view'				=> 'profile_reseller/list_profile',
            'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );

		if ($this->input->post('grup_reseller') == 'reseller_pribadi') {
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Reseller', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('alamat_reseller', 'Alamat', 'trim|required|xss_clean');
	        
	        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required|xss_clean');
	        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|xss_clean');
		}

		$this->form_validation->set_rules('bank_id', 'Nama Bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'trim|required|xss_clean');
        
        if ($this->input->post('grup_reseller') == 'reseller_organisasi') {
        	$this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('alamat_organisasi', 'Alamat Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_telepon_organisasi', 'Nomor Telepon Organisasi', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_ktp', 'Nomor KTP', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('nomor_telepon_reseller', 'Nomor Telepon Pribadi', 'trim|required|xss_clean');
        }

        if ($this->input->post('password')) {
        	$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        }

        $this->form_validation->set_error_delimiters('<div style="color:red; font-size: 10px">', '</div>');

        if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {
				$this->data['pesan_error'] = 'Terjadi kesalahan input ';
				$this->load->view('include/template/main', $this->data);

			}else{

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_profile_reseller($input, $id_reseller);
					
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Sukses mengupdate data reseller.');
					$url = $this->session->userdata('lolin_urlback_frontend');
					redirect($url);
				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template/main', $this->data);
				}

			}
		}else{

			$search = $this->ion_auth->get_user();

			if ($search) {
					
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}

					$this->load->view('include/template/main', $this->data);

			}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_frontend');
					redirect($url);
			}
				
		}
		*/
	}

}

/* End of file Profile_reseller.php */
/* Location: ./application/modules/frontend/controllers/Profile_reseller.php */