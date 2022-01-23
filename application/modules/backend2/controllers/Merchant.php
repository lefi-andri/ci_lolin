<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends Backend_Controller {

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
		
		$this->load->model('merchant_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('testimonial', 'adm_testimonial');		

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$data_data_merchant = $this->models->ambil_data_merchant();

		$this->load->library('table');

		$this->table->set_heading('No.', 'Nama Merchant', 'Deskripsi Merchant', 'Gambar', 'Link', 'Urutan', 'Tampikan', '');

		$no = 1;
		foreach ($data_data_merchant->result() as $key => $value) {
			$id = $value->id_merchant;
			$this->table->add_row(
				$no, 
				$value->nama_merchant,
				$value->deskripsi_merchant,
				'<img src="../assets/images/merchant/small_'.$value->gambar_logo_merchant.'" alt="gambar">',
				$value->link_merchant,
				$value->urutan_merchant,
				($value->tampilkan_merchant == '1') ? 'Ya' : 'Tidak',
				anchor("backend/merchant/edit_merchant/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).''.
				anchor("backend/merchant/delete_merchant/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'title'=>'hapus data', 'onclick' => "return confirm('Anda yakin ingin menghapus data $value->nama_merchant ?')"))
			);
			$no++;
		}

		backend_controller::buat_tabel();

		$data = array(
			'main_view' => 'merchant/list_merchant',
			'table' => $this->table->generate(),
		);
		$this->load->view('include/template', $data);
	}

	public function file_check_merchant($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['gambar_logo_merchant']['name']);
        if(isset($_FILES['gambar_logo_merchant']['name']) && $_FILES['gambar_logo_merchant']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_merchant', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_merchant', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function add_merchant()
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->breadcrumb->add('Badan Usaha', 'adm_merchant');
		$this->breadcrumb->add('Tambah Badan Usaha', 'adm_merchant/add_merchant');

		$this->data = array(
			'main_view' 	=> 'merchant/form_add_merchant',
			'form_action' 	=> 'backend/merchant/add_merchant'
		);

		# URLBACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		
		

		if (isset($_POST['submit'])) {

			# UPLOAD GAMBAR LOGO
			$filename = $_FILES['gambar_logo_merchant']['name'];

			if ($filename !="") {
				$this->form_validation->set_rules('gambar_logo_merchant', 'Gambar Logo', 'trim|callback_file_check_merchant');
			}

			$this->form_validation->set_rules('nama_merchant', 'Nama Merchant', 'trim|required|xss_clean');
			$this->form_validation->set_rules('deskripsi_merchant', 'Deskripsi Merchant', 'trim|required|xss_clean');
			$this->form_validation->set_rules('link_merchant', 'Link Merchant', 'trim|required|xss_clean');
			$this->form_validation->set_rules('urutan_merchant', 'Urutan Merchant', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_rules('tampilkan_merchant', 'Tampilkan Merchant', 'trim|numeric|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				if ($filename !="") {

					$config['upload_path']     	= './assets/images/merchant/';
				    $config['allowed_types']   	= 'gif|jpg|png';	    
				    $config['detect_mime']		= TRUE;
				    $config['max_size']        	= 20000;
				    $nmfile 					= $this->input->post('nama_merchant');
				    $time 						= time();		    
					$config['file_name'] 		= $nmfile."_".$time;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('gambar_logo_merchant')){
						print_r($this->upload->display_errors());
						
						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						$this->load->view('include/template', $this->data);

					}else{

						$images = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/merchant/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 40,
			                'height' 			=> 40,
			                'new_image' 		=> './assets/images/merchant/small_'. $images['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/merchant/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 153,
			                'height' 			=> 47,
			                'new_image' 		=> './assets/images/merchant/middle_'. $images['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();							
					
					}
				}
			
				$input = $this->input->post(null, TRUE);

				$gambar_logo_merchant	= $images['file_name'];

				$saved_hashtag = $this->models->simpan_merchant($input,$gambar_logo_merchant);

				if ($saved_hashtag === TRUE) {					

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

	public function edit_merchant($id)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->breadcrumb->add('News', 'adm_merchant');
		$this->breadcrumb->add('Edit News Kategori', 'adm_merchant/edit_kliencat');

		$this->data = array(
			'main_view' 	=> 'merchant/form_edit_merchant',
			'form_action' 	=> 'backend/merchant/edit_merchant/'.$id
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {

				# UPLOAD GAMBAR LOGO
				$filename = $_FILES['gambar_logo_merchant']['name'];

				if ($filename !="") {
					$this->form_validation->set_rules('gambar_logo_merchant', 'Gambar Logo', 'trim|callback_file_check_merchant');
				}

				$this->form_validation->set_rules('nama_merchant', 'Nama Merchant', 'trim|required|xss_clean');
				$this->form_validation->set_rules('deskripsi_merchant', 'Deskripsi Merchant', 'trim|required|xss_clean');
				$this->form_validation->set_rules('link_merchant', 'Link Merchant', 'trim|required|xss_clean');
				$this->form_validation->set_rules('urutan_merchant', 'Urutan Merchant', 'trim|numeric|required|xss_clean');
				$this->form_validation->set_rules('tampilkan_merchant', 'Tampilkan Merchant', 'trim|numeric|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE) {

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					$this->load->view('include/template', $this->data);

				} else {

					$id = $this->session->userdata('id_sekarang');

					if ($filename !="") {

						$remove_images 	= $this->models->cari_gambar($id)->row();
						$temp_images 	= $remove_images->gambar_logo_merchant;
						# Menghapus gambar
						unlink('./assets/images/merchant/'.$temp_images);
						unlink('./assets/images/merchant/small_'.$temp_images);
						unlink('./assets/images/merchant/middle_'.$temp_images);

						$config['upload_path']     	= './assets/images/merchant/';
					    $config['allowed_types']   	= 'gif|jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nmfile 					= $this->input->post('nama_merchant');
					    $time 						= time();		    
						$config['file_name'] 		= $nmfile."_".$time;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('gambar_logo_merchant')){
							print_r($this->upload->display_errors());
							
							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							$this->load->view('include/template', $this->data);

						}else{

							$images = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/merchant/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/merchant/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/merchant/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 153,
				                'height' 			=> 47,
				                'new_image' 		=> './assets/images/merchant/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}
					}

					$input = $this->input->post(null, TRUE);

					if ($filename !="") {
						$gambar_logo_merchant	= $images['file_name'];
					}else{
						$gambar_logo_merchant = "";
					}
					

					$saved_merchant = $this->models->update_merchant($id,$input,$gambar_logo_merchant);

					if ($saved_merchant === TRUE) {

						$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);

					}else{
						
						$this->data['pesan_error'] = "Terjadi Kesalahan ";
						$this->load->view('include/template', $this->data);
					}
				}

			}else{
				$search = $this->models->search_merchant($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->id_merchant);

					$this->load->view('include/template', $this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}

	public function delete_merchant($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$remove_images 	= $this->models->cari_gambar($id)->row();
			$temp_images 	= $remove_images->gambar_logo_merchant;

			if ($this->models->hapus_merchant($id) === TRUE) {

				# Menghapus gambar
				unlink('./assets/images/merchant/'.$temp_images);
				unlink('./assets/images/merchant/small_'.$temp_images);
				unlink('./assets/images/merchant/middle_'.$temp_images);

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

/* End of file Merchant.php */
/* Location: ./application/modules/backend/controllers/Merchant.php */