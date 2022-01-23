<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('contact_model');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Contact Us');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('contact us', 'contact_us');
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
            'label'					=> 'Contact',
            'content_profile' 		=> $this->db->get_where('content', ["contentId" => "2"])->row()->contentDesc,
            'form_action' 			=> 'contact',
        );
		//set form validation
		$this->form_validation->set_rules('conNama', 'Nama Lengkap', 'trim|required|xss_clean');
		$this->form_validation->set_rules('conAddress', 'Alamat', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('conTelp', 'Telpon', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('conEmail', 'Alamat Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('conMessage', 'Kritik dan Saran', 'trim|required|min_length[10]|xss_clean');
		$this->form_validation->set_error_delimiters('<div style="color:#FF5252;">', '</div>');

		if (isset($_POST['submit'])) {
			// Jika disubmit
			if ($this->form_validation->run() == FALSE) {
				$this->data['pesan_error'] = "Upss.. Ada Kesalahan Pengisian.";
				//set view
				$this->stencil->paint('contact/index',$this->data);
			}else{

				$tanggal = date("Y-m-d h:i:s");
				$info = array(					
					'conNama' 		=> $this->input->post('conNama'),					
					'conAddress' 	=> $this->input->post('conAddress'),
					'conTelp' 		=> $this->input->post('conTelp'),
					'conEmail' 		=> $this->input->post('conEmail'),
					'conMessage' 	=> $this->input->post('conMessage'),
					'conTime' 		=> $tanggal,
					'conStatus' 	=> 'tidak',
				);

				if ($this->contact_model->simpan_contact($info) === TRUE) {

					$pengaturan_email = frontend_controller::get_pengaturan_email();

					// Cek pengaturan email
					if ($pengaturan_email == 1) {

						# KIRIMKAN EMAIL NOTIFIKASI KOMENTAR PENGUNJUNG
						$email_to = $this->input->post('conEmail');

						$email_konten = 'Anda baru saja mengirim pada kotak lolin, kami akan segera menanggapi pesan anda. Terima Kasih.';

						$email_template = "template_email_kontak"; // Samakan dengan nama method template
						$subjek = "Hubungi Lolin";
						
						$kirim = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						if ($kirim) {

							#INFO
							$email_to = email_fordward();
							$email_konten = "Baru-baru ini ada pengunjung web menghubungi kontak Lolin dengan detail : <br>";
							$email_konten .= "Nama : '".$this->input->post('conNama')."'<br>";
							$email_konten .= "Alamat : '".$this->input->post('conAddress')."'<br>";
							$email_konten .= "Telepon : '".$this->input->post('conTelp')."'<br>";
							$email_konten .= "Email : '".$this->input->post('conEmail')."'<br>";
							$email_konten .= "Pesan : '".$this->input->post('conMessage')."'<br>";
							$email_konten .= "Waktu Pengiriman : '".$tanggal."'<br>";
							$email_konten .= "<br><br>Dimohon untuk ditinjau lagi.";

							$email_template = "template_email_pendaftaran_reseller_info"; // Samakan dengan nama method template
							$subjek = "Hubungi Lolin";
							
							frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

							$this->session->set_flashdata('message_success', 'Sukses.. Pesan berhasil dikirim. Kami akan segera menanggapi pesan saudara.');
							$url = $this->session->userdata('lolin_urlback_frontend');
							redirect($url);
						}
						
					}else{

						$this->session->set_flashdata('message_success', 'Sukses.. Pesan berhasil dikirim. Kami akan segera menanggapi pesan saudara.');
						$url = $this->session->userdata('lolin_urlback_frontend');
						redirect($url);

					}

					

				}else{
					$this->data['pesan_error'] = "Upss.. Ada Kesalahan Pengisian.";
					//set view
					$this->stencil->paint('contact/index',$this->data);
				}

			}
		}else{
			// Jika tidak disubmit
			//set view
			$this->stencil->paint('contact/index',$this->data);
		}
	}

	

}

/* End of file Contact.php */
/* Location: ./application/modules/frontend/controllers/Contact.php */