<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penukaran_poin extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		
		$this->load->model('penukaran_poin_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('penukaran poin', 'reseller/penukaran_poin');

		$id_reseller = $this->session->userdata('user_id');

		$user = $this->ion_auth->get_user();
		$group = $user->group;
		$email_reseller = $user->email;
		//$alamat_reseller = $user_alamat_reseleer;

		$this->load->library('table');

		$this->table->set_heading('No', 'Jenis Bonus', 'Nilai Bonus', 'Poin Penukaran', 'Tanggal Permintaan','Status');

		
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->where('users.id', $id_reseller);
		$this->db->order_by('tukar_poin.tanggal_tukar_poin', 'desc');
		$query = $this->db->get();

		$no = 1;
		foreach ($query->result() as $key => $value) {

			list($tanggal, $waktu) = explode(' ', $value->tanggal_tukar_poin);
			$tanggal_tukar_poin = indonesian_date($tanggal).' --- '.$waktu;

			$this->table->add_row(
				$no, 
				$value->kode_tukar_poin,
				$value->nama_jenis_bonus,
				'<span class="badge badge-info badge-pill">'.$value->poin_bonus.' point</span>',
				$tanggal_tukar_poin,
				($value->acc_tukar_poin == 0) ? "Request" : "Acc"." ".$value->tanggal_acc
			);
			$no++;
		}

		reseller_controller::buat_tabel();

		$tabel_penukaran_anda = $this->table->generate();

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Penukaran poin - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Penukaran Poin',            
            'main_view'				=> 'penukaran_poin/list_penukaran_poin',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			#'table'					=> $this->table->generate(),
			'table'					=> $tabel_penukaran_anda,
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

			'form_action'			=> 'frontend/penukaran_poin/index',
			'dd_tukar_poin' 		=> $this->models->dd_tukar_poin($group),

			'dropdown_bank' 		=> $this->models->dropdown_bank(),
        );

		$this->form_validation->set_rules('bonus_poin_id', 'Bonus', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_id', 'Bank', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekeing', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_pemilik_rekening', 'Nama Pemilik Rekening', 'trim|required|xss_clean');

		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_password_check');

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {

			if ($this->form_validation->run() == FALSE) {

				$data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template/main', $data);
			} else {
				$input = $this->input->post(null, TRUE);

				$user = $this->ion_auth->get_user();
				$reseller_id = $user->id;

				$tipe = 'reseller_pribadi';
				$kode_tukar_poin = reseller_controller::create_tukar_poin_code($tipe);

				$saved_tukar_poin = $this->models->simpan_tukar_poin($reseller_id, $input, $kode_tukar_poin);

				if ($saved_tukar_poin === TRUE) {					

					

					$pengaturan_email = frontend_controller::get_pengaturan_email();

					if ($pengaturan_email == 1) {

						$email_to = $email_reseller;
						$email_template = "template_email_order"; // Samakan dengan nama method template
						$subjek = "Penukaran Poin";

						$email_konten = "";
						$email_konten .= "Anda telah malakukan penukaran poin";

						// Kirim email ke peng order
						$kirim = reseller_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						if ($kirim) {
							#INFO
							$email_to = email_fordward(); //email_fordward lihat di config lolin
							$email_template = "template_email_order_info"; // Samakan dengan nama method template
							$subjek = "Reseller Order";
							$email_konten = "Baru-baru ini pengunjung website Lolin Kids Care yang melakukan penukaran poin dengan detail :";
							$email_konten .= "<br><br>";

							reseller_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
						}

						//Berhasil melakukan pengiriman email
						$this->session->set_flashdata('message_success', 'Berhasil melakukan penukaran poin.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);


					}else{
						$this->session->set_flashdata('message_success', 'Berhasil melakukan penukaran poin.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);
					}

				}else{
					
					$data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template/main', $data);
				}
			}
		}else{
			$this->load->view('include/template/main', $data);
		}
	}

	public function tukar_poin(){

		

		
	}

	public function password_check()
    {
    	if ($this->input->post('password') === '') {
    		$this->form_validation->set_message('password_check', 'Tolong input password anda.');
    		return FALSE;
    	}else{
    		//return TRUE;
    		$user = $this->ion_auth->get_user();
    		$identity = $user->username;
    		$password = $this->input->post('password');
    		$remember = FALSE;
    		$cek = $this->ion_auth->login($identity, $password, $remember);

			if ($cek) {
				return TRUE;
			}else {
				$this->form_validation->set_message('password_check', 'Password salah.');
    			return FALSE;
			}
    	}
    }

    public function penukaran_poin_berhasil(){

    	$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('penukaran poin', 'reseller/penukaran_poin');

		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Penukaran poin - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Penukaran Poin',            
            'main_view'				=> 'penukaran_poin/penukaran_poin_berhasil',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );

        $this->load->view('include/template/main', $data);
    }

}

/* End of file Penukaran_poin.php */
/* Location: ./application/modules/frontend/controllers/Penukaran_poin.php */