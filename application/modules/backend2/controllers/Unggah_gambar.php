<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unggah_gambar extends Backend_Controller {

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
		
		$this->load->model('unggah_gambar_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Gambar', 'Caption', '');

		$unggah_gambar = $this->models->get_data_unggah_gambar();

		$no = 1;
		foreach ($unggah_gambar->result() as $value) {
			$id = $value->id;
			$nama = $value->caption;
			$this->table->add_row(
				$no, 
				"<img src='".base_url()."assets/unggah/gambar/small_".$value->nama_file."' alt='$value->nama_file'>",
				$value->caption,
				anchor("#myModal",'<i class="fa fa-chain"></i> Link', array('title'=>'Salin link ke text editor' , 'class'=>'btn btn-warning btn-xs', 'id'=>'custId', 'data-toggle'=>'modal', 'data-id'=>"$id",))." ".
				anchor("backend/unggah_gambar/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/unggah_gambar/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'unggah_gambar/list_unggah_gambar', 
		);

		$this->load->view('include/box_template', $data);
	}

	public function check_file_gambar_unggah_gambar($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['nama_file']['name']);
        if(isset($_FILES['nama_file']['name']) && $_FILES['nama_file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_file_gambar_unggah_gambar', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_file_gambar_unggah_gambar', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'unggah_gambar/form_add_unggah_gambar',
			'form_action' 	=> 'backend/unggah_gambar/add',
		);

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_file', 'File gambar', 'trim|callback_check_file_gambar_unggah_gambar');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/box_template', $this->data);

			} else {

				# UPLOAD GAMBAR caption
				$gambar_unggah_gambar = $_FILES['nama_file']['name'];

				if ($gambar_unggah_gambar !="") {

					$config['upload_path']     	= './assets/unggah/gambar/';
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
						$this->load->view('include/box_template', $this->data);

					}else{

						$images = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/unggah/gambar/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 40,
			                'height' 			=> 40,
			                'new_image' 		=> './assets/unggah/gambar/small_'. $images['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/unggah/gambar/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 750,
			                'height' 			=> 390,
			                'new_image' 		=> './assets/unggah/gambar/middle_'. $images['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();							
					
					}
				}
				

				$input = $this->input->post(null, TRUE);

				$nama_file = $images['file_name'];

				$insert = $this->models->simpan_unggah_gambar($input, $nama_file);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/box_template', $this->data);
				}

			}

		}else{
			$this->load->view('include/box_template', $this->data);
		}
	}

	public function edit($id = NULL){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'unggah_gambar/form_edit_unggah_gambar',
			'form_action' 	=> "backend/unggah_gambar/edit/$id",
		);

		$this->data['unggah_gambar_id'] = $id;

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');

		if ($this->input->post('nama_file')) {
			$this->form_validation->set_rules('nama_file', 'Gambar caption', 'callback_check_file_gambar_unggah_gambar');
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/box_template', $this->data);

			} else {


				if ($_FILES['nama_file']['name'] != NULL) {

					$hapus_gambar_unggah_gambar = $this->models->cari_gambar_unggah_gambar($id)->row();
					$temp_gambar_unggah_gambar 	= $hapus_gambar_unggah_gambar->nama_file;

					# Menghapus gambar caption
					if ($temp_gambar_unggah_gambar) {
						unlink('./assets/unggah/gambar/'.$temp_gambar_unggah_gambar);
						unlink('./assets/unggah/gambar/small_'.$temp_gambar_unggah_gambar);
						unlink('./assets/unggah/gambar/middle_'.$temp_gambar_unggah_gambar);
					}
					

					# UPLOAD GAMBAR caption
					$gambar_unggah_gambar = $_FILES['nama_file']['name'];

					if ($gambar_unggah_gambar !="") {

						$config['upload_path']     	= './assets/unggah/gambar/';
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
							$this->load->view('include/box_template', $this->data);

						}else{

							$images = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/unggah/gambar/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/unggah/gambar/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/unggah/gambar/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 750,
				                'height' 			=> 390,
				                'new_image' 		=> './assets/unggah/gambar/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}

						$data = array(
				    		'nama_file' => $images['file_name']
				    	);

				        $this->db->where('id', $id);
				        $query = $this->db->update('unggah_gambar', $data);
					}
				}


				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_unggah_gambar($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/box_template', $this->data);
				}

			}

		}else{
			$search = $this->models->cari_unggah_gambar($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				$this->load->view('include/box_template', $this->data);
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

			$hapus_gambar_unggah_gambar = $this->models->cari_gambar_unggah_gambar($id)->row();
			
			$temp_gambar_unggah_gambar 	= $hapus_gambar_unggah_gambar->nama_file;

			if ($this->models->hapus_unggah_gambar($id) === TRUE) {

				# Menghapus gambar unggah_gambar
				unlink('./assets/unggah/gambar/'.$temp_gambar_unggah_gambar);
				unlink('./assets/unggah/gambar/small_'.$temp_gambar_unggah_gambar);
				unlink('./assets/unggah/gambar/middle_'.$temp_gambar_unggah_gambar);
	
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

	public function detail()
	{
		$id = $this->input->post('rowid');
		$data = array(
            'id' 			=> $_POST['rowid'],            
            'konten'		=> $this->models->cari_gambar_unggah_gambar($id)->row(),
        );
		
		$this->load->view('unggah_gambar/detail_unggah_gambar', $data);
	}

}

/* End of file Unggah_gambar.php */
/* Location: ./application/modules/backend/controllers/Unggah_gambar.php */