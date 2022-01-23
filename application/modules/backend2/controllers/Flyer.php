<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flyer extends Backend_Controller {

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
		
		$this->load->model('flyer_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Gambar', 'Caption', 'Perbolehkan Tampil', 'Kelas Aktif', 'Urutan', '');

		$flyer = $this->models->get_data_flyer();

		$no = 1;
		foreach ($flyer->result() as $value) {
			$id = $value->id;
			$nama = $value->caption;
			$this->table->add_row(
				$no, 
				"<img src='".base_url()."assets/images/flyer/small_".$value->nama_file."' alt='$value->nama_file'>",
				$value->caption,
				($value->perbolehkan_tampil == '1') ? 'Ya' : 'Tidak',
				($value->class_active == '1') ? 'Ya' : 'Tidak',
				$value->urutan,
				anchor("backend/flyer/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/flyer/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'flyer/list_flyer', 
		);

		$this->load->view('include/template', $data);
	}

	public function check_file_gambar_flyer($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['nama_file']['name']);
        if(isset($_FILES['nama_file']['name']) && $_FILES['nama_file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_file_gambar_flyer', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_file_gambar_flyer', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'flyer/form_add_flyer',
			'form_action' 	=> 'backend/flyer/add',
		);

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|xss_clean');
		$this->form_validation->set_rules('link', 'Link', 'trim|xss_clean');
		$this->form_validation->set_rules('class_active', 'Kelas Aktif', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Perbolehkan Tampil', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_file', 'File gambar', 'trim|callback_check_file_gambar_flyer');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				# UPLOAD GAMBAR caption
				$gambar_flyer = $_FILES['nama_file']['name'];

				if ($gambar_flyer !="") {

					$config['upload_path']     	= './assets/images/flyer/';
				    $config['allowed_types']   	= 'jpg|png';	    
				    $config['detect_mime']		= TRUE;
				    $config['max_size']        	= 20000;
				    $nama_file 					= strtolower($this->input->post('caption'));
					$config['file_name'] 		= $nama_file."_".time();

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('nama_file')){
						print_r($this->upload->display_errors());

						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						$this->load->view('include/template', $this->data);

					}else{

						$images = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/flyer/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 40,
			                'height' 			=> 40,
			                'new_image' 		=> './assets/images/flyer/small_'. $images['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/flyer/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 950,
			                'height' 			=> 633,
			                'new_image' 		=> './assets/images/flyer/middle_'. $images['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();							
					
					}
				}
				

				$input = $this->input->post(null, TRUE);

				$nama_file = $images['file_name'];

				$insert = $this->models->simpan_flyer($input, $nama_file);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$this->load->view('include/template', $this->data);
		}
	}

	public function edit($id = NULL){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'flyer/form_edit_flyer',
			'form_action' 	=> "backend/flyer/edit/$id",
		);

		$this->data['flyer_id'] = $id;

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|xss_clean');
		$this->form_validation->set_rules('link', 'Link', 'trim|xss_clean');
		$this->form_validation->set_rules('class_active', 'Kelas Aktif', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Perbolehkan Tampil', 'trim|required|xss_clean');
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|required|xss_clean');

		if ($this->input->post('nama_file')) {
			$this->form_validation->set_rules('nama_file', 'Gambar caption', 'callback_check_file_gambar_flyer');
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {


				if ($_FILES['nama_file']['name'] != NULL) {

					$hapus_gambar_flyer = $this->models->cari_gambar_flyer($id)->row();
					$temp_gambar_flyer 	= $hapus_gambar_flyer->nama_file;

					# Menghapus gambar caption
					if ($temp_gambar_flyer) {
						unlink('./assets/images/flyer/'.$temp_gambar_flyer);
						unlink('./assets/images/flyer/small_'.$temp_gambar_flyer);
						unlink('./assets/images/flyer/middle_'.$temp_gambar_flyer);
					}
					

					# UPLOAD GAMBAR caption
					$gambar_flyer = $_FILES['nama_file']['name'];

					if ($gambar_flyer !="") {

						$config['upload_path']     	= './assets/images/flyer/';
					    $config['allowed_types']   	= 'jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nama_file 					= strtolower($this->input->post('caption'));
						$config['file_name'] 		= $nama_file."_".time();

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('nama_file')){
							print_r($this->upload->display_errors());

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							$this->load->view('include/template', $this->data);

						}else{

							$images = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/flyer/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/flyer/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/flyer/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 950,
				                'height' 			=> 633,
				                'new_image' 		=> './assets/images/flyer/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}

						$data = array(
				    		'nama_file' => $images['file_name']
				    	);

				        $this->db->where('id', $id);
				        $query = $this->db->update('flyer', $data);
					}
				}


				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_flyer($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$search = $this->models->cari_flyer($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

	public function delete($id = NULL){
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		} else {

			$hapus_gambar_flyer = $this->models->cari_gambar_flyer($id)->row();
			
			$temp_gambar_flyer 	= $hapus_gambar_flyer->nama_file;

			if ($this->models->hapus_flyer($id) === TRUE) {

				# Menghapus gambar flyer
				unlink('./assets/images/flyer/'.$temp_gambar_flyer);
				unlink('./assets/images/flyer/small_'.$temp_gambar_flyer);
				unlink('./assets/images/flyer/middle_'.$temp_gambar_flyer);
	
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

/* End of file Flyer.php */
/* Location: ./application/modules/backend/controllers/Flyer.php */