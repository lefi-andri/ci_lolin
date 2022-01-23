<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto_profile extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer','user_info_menu'));
		//load model
		$this->load->model('foto_profile_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Foto Profile');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('foto_profile', 'reseller/foto_profile');
		//get meta data
		$meta = reseller_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));

        $id_reseller = $this->session->userdata('user_id');
		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		//set data
		$this->data = array(
            'label'					=> 'Foto Profile',
            'form_action'			=> 'member/photo_profile',
            'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );

        //set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set validation
        $this->form_validation->set_rules('nama_file', 'File gambar', 'trim|callback_check_file_gambar_foto_profile');
        $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
				
		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('foto_profile/list_foto_profile', $this->data);
			} else {


				if ($_FILES['nama_file']['name'] != NULL) {

					$data_profile = $this->models->cari_gambar_foto_profile($id_reseller);
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
					
					

					# UPLOAD GAMBAR caption
					$gambar_foto_profile = $_FILES['nama_file']['name'];

					if ($gambar_foto_profile !="") {

						$config['upload_path']     	= './assets/images/foto_profile/';
					    $config['allowed_types']   	= 'jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nama_file 					= strtolower($data_profile->row()->nama_lengkap);
						$config['file_name'] 		= $nama_file."_".time();

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('nama_file')){
							//print_r($this->upload->display_errors());

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							//set view
							$this->stencil->paint('foto_profile/list_foto_profile', $this->data);

						}else{

							$images = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/foto_profile/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/foto_profile/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/foto_profile/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 200,
				                'height' 			=> 200,
				                'new_image' 		=> './assets/images/foto_profile/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}

						$data = array(
				    		'foto_profile' => $images['file_name']
				    	);

				        $this->db->where('user_id', $id_reseller);
				        $query = $this->db->update('meta', $data);
					}
				}

				if ($query === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update foto reseller.');
					$url = $this->session->userdata('lolin_urlback_frontend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('foto_profile/list_foto_profile', $this->data);
				}

			}

		}else{
			//set view
			$this->stencil->paint('foto_profile/list_foto_profile', $this->data);
		}
	}

	public function check_file_gambar_foto_profile($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['nama_file']['name']);
        if(isset($_FILES['nama_file']['name']) && $_FILES['nama_file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_file_gambar_foto_profile', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_file_gambar_foto_profile', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

    public function delete(){
    	$id_reseller = $this->session->userdata('user_id');

    	if ($id_reseller) {
    		$data_profile = $this->models->cari_gambar_foto_profile($id_reseller);
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

			$data = array(
	    		'foto_profile' => '',
	    	);

	        $this->db->where('user_id', $id_reseller);
	        $query = $this->db->update('meta', $data);

	        redirect(base_url('member/photo_profile'),'refresh');

	    }else{
	    	$this->session->set_flashdata('message_danger', 'No reseller identity.');
			$url = $this->session->userdata('lolin_urlback_frontend');
			redirect($url);
	    }
	}

}

/* End of file Foto_profile.php */
/* Location: ./application/modules/frontend/controllers/Foto_profile.php */