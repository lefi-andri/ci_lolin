<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Backend_Controller {

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
		
		$this->load->model('blog_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');

	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Judul', 'Kategori', 'Gambar Judul', 'Gambar Posting', 'Perbolehkan Tampil', '');

		$blog = $this->models->get_data_blog();

		$no = 1;
		foreach ($blog->result() as $value) {
			$id = $value->id;
			$nama = $value->judul;
			$nama_kategori = $this->models->cari_kategori($value->kategori_id)->nama_kategori;
			$this->table->add_row(
				$no, 
				$value->judul,
				$nama_kategori,
				"<img src='".base_url()."assets/images/blog/gambar_judul/small_".$value->nama_gambar_judul."' alt='$value->nama_gambar_judul'>",
				"<img src='".base_url()."assets/images/blog/gambar_posting/small_".$value->nama_gambar_posting."' alt='$value->nama_gambar_posting'>",
				($value->perbolehkan_tampil == '1') ? 'Ya' : 'Tidak',
				anchor("backend/blog/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/blog/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'blog/list_blog', 
		);

		$this->load->view('include/template', $data);
	}

	public function check_file_gambar_judul($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['nama_gambar_judul']['name']);
        if(isset($_FILES['nama_gambar_judul']['name']) && $_FILES['nama_gambar_judul']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_file_gambar_judul', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_file_gambar_judul', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

    public function check_file_gambar_posting($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['nama_gambar_posting']['name']);
        if(isset($_FILES['nama_gambar_posting']['name']) && $_FILES['nama_gambar_posting']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_file_gambar_posting', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_file_gambar_posting', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'blog/form_add_blog',
			'form_action' 	=> 'backend/blog/add',
			'dropdown_kategori_blog' => $this->models->dropdown_kategori_blog(),
		);

		$this->form_validation->set_rules('judul', 'Nama Kategori', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kategori_id', 'Kategori Blog', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_komentar', 'Komentar Ditampilkan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Kategori Ditampilkan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('penulis', 'Penulis', 'trim|required|xss_clean');
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sumber_berita', 'Sumber Berita', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_gambar_judul', 'Gambar Judul', 'trim|callback_check_file_gambar_judul');
		$this->form_validation->set_rules('nama_gambar_posting', 'Gambar Posting', 'trim|callback_check_file_gambar_posting');
		$this->form_validation->set_rules('caption_gambar_judul', 'Caption Gambar Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('caption_gambar_posting', 'Caption Gambar Posting', 'trim|required|xss_clean');
		$this->form_validation->set_rules('konten[]', 'Konten', 'trim|xss_clean');
		$this->form_validation->set_rules('nama_tag[]', 'Tags Blog', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

		# UPLOAD GAMBAR Judul
		$gambar_judul = $_FILES['nama_gambar_judul']['name'];

		if ($gambar_judul !="") {

			$config['upload_path']     	= './assets/images/blog/gambar_judul/';
		    $config['allowed_types']   	= 'jpg|png';	    
		    $config['detect_mime']		= TRUE;
		    $config['max_size']        	= 20000;
		    $nama_file 					= strtolower($this->input->post('caption_gambar_judul'));
			$config['file_name'] 		= $nama_file."_".time();

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('nama_gambar_judul')){
				print_r($this->upload->display_errors());

				$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
				$this->load->view('include/template', $this->data);

			}else{

				$images_gambar_judul = $this->upload->data();

				//MEMBUAT UKURAN SMALL				
	            $this->image_lib->initialize(array(
	                'image_library' 	=> 'gd2',
	                'source_image' 		=> './assets/images/blog/gambar_judul/'. $images_gambar_judul['file_name'],
	                'maintain_ratio' 	=> FALSE,
	                'create_thumb' 		=> FALSE,
	                'width' 			=> 40,
	                'height' 			=> 40,
	                'new_image' 		=> './assets/images/blog/gambar_judul/small_'. $images_gambar_judul['file_name'],
	            ));                
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				//MEMBUAT UKURAN MIDDLE
				$this->image_lib->initialize(array(
	                'image_library' 	=> 'gd2',
	                'source_image' 		=> './assets/images/blog/gambar_judul/'. $images_gambar_judul['file_name'],
	                'maintain_ratio' 	=> FALSE,
	                'create_thumb' 		=> FALSE,
	                'width' 			=> 750,
	                'height' 			=> 390,
	                'new_image' 		=> './assets/images/blog/gambar_judul/middle_'. $images_gambar_judul['file_name'],
	            ));
	            $this->load->library('image_lib', $config);
				$this->image_lib->resize();							
			
			}
		}

		# UPLOAD GAMBAR Posting
		$gambar_posting = $_FILES['nama_gambar_posting']['name'];

		if ($gambar_posting !="") {

			$config['upload_path']     	= './assets/images/blog/gambar_posting/';
		    $config['allowed_types']   	= 'jpg|png';	    
		    $config['detect_mime']		= TRUE;
		    $config['max_size']        	= 20000;
		    $nama_file 					= strtolower($this->input->post('caption_gambar_posting'));
			$config['file_name'] 		= $nama_file."_".time();

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('nama_gambar_posting')){
				print_r($this->upload->display_errors());

				$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
				$this->load->view('include/template', $this->data);

			}else{

				$images_gambar_posting = $this->upload->data();

				//MEMBUAT UKURAN SMALL				
	            $this->image_lib->initialize(array(
	                'image_library' 	=> 'gd2',
	                'source_image' 		=> './assets/images/blog/gambar_posting/'. $images_gambar_posting['file_name'],
	                'maintain_ratio' 	=> FALSE,
	                'create_thumb' 		=> FALSE,
	                'width' 			=> 40,
	                'height' 			=> 40,
	                'new_image' 		=> './assets/images/blog/gambar_posting/small_'. $images_gambar_posting['file_name'],
	            ));                
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				//MEMBUAT UKURAN MIDDLE
				$this->image_lib->initialize(array(
	                'image_library' 	=> 'gd2',
	                'source_image' 		=> './assets/images/blog/gambar_posting/'. $images_gambar_posting['file_name'],
	                'maintain_ratio' 	=> FALSE,
	                'create_thumb' 		=> FALSE,
	                'width' 			=> 750,
	                'height' 			=> 390,
	                'new_image' 		=> './assets/images/blog/gambar_posting/middle_'. $images_gambar_posting['file_name'],
	            ));
	            $this->load->library('image_lib', $config);
				$this->image_lib->resize();							
			
			}
		}
				

				$input = $this->input->post(null, TRUE);

				$gambar_judul = $images_gambar_judul['file_name'];
				$gambar_posting = $images_gambar_posting['file_name'];

				$insert = $this->models->simpan_blog($input, $gambar_judul, $gambar_posting);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
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
			'main_view' 	=> 'blog/form_edit_blog',
			'form_action' 	=> "backend/blog/edit/$id",
			'dropdown_kategori_blog' => $this->models->dropdown_kategori_blog(),
		);

		$this->data['blog_id'] = $id;

		$this->form_validation->set_rules('judul', 'Nama Kategori', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kategori_id', 'Kategori Blog', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_komentar', 'Komentar Ditampilkan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Kategori Ditampilkan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('penulis', 'Penulis', 'trim|required|xss_clean');
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sumber_berita', 'Sumber Berita', 'trim|required|xss_clean');

		if ($this->input->post('nama_gambar_judul')) {
			$this->form_validation->set_rules('nama_gambar_judul', 'Gambar Judul', 'callback_check_file_gambar_judul');
		}

		if ($this->input->post('nama_gambar_posting')) {
			$this->form_validation->set_rules('nama_gambar_posting', 'Gambar Posting', 'callback_check_file_gambar_posting');
		}

		$this->form_validation->set_rules('caption_gambar_judul', 'Caption Gambar Judul', 'trim|required|xss_clean');
		$this->form_validation->set_rules('caption_gambar_posting', 'Caption Gambar Posting', 'trim|required|xss_clean');
		$this->form_validation->set_rules('konten[]', 'Konten', 'trim|xss_clean');
		

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {


				if ($_FILES['nama_gambar_judul']['name'] != NULL) {

					$hapus_gambar_judul_blog = $this->models->cari_gambar_judul($id)->row();
					$temp_gambar_judul_blog 	= $hapus_gambar_judul_blog->nama_gambar_judul;

					# Menghapus gambar judul
					if ($temp_gambar_judul_blog) {
						unlink('./assets/images/blog/gambar_judul/'.$temp_gambar_judul_blog);
						unlink('./assets/images/blog/gambar_judul/small_'.$temp_gambar_judul_blog);
						unlink('./assets/images/blog/gambar_judul/middle_'.$temp_gambar_judul_blog);
					}
					

					# UPLOAD GAMBAR Judul
					$gambar_judul = $_FILES['nama_gambar_judul']['name'];

					if ($gambar_judul !="") {

						$config['upload_path']     	= './assets/images/blog/gambar_judul/';
					    $config['allowed_types']   	= 'jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nama_file 					= strtolower($this->input->post('caption_gambar_judul'));
						$config['file_name'] 		= $nama_file."_".time();

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('nama_gambar_judul')){
							print_r($this->upload->display_errors());

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							$this->load->view('include/template', $this->data);

						}else{

							$images_gambar_judul = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/blog/gambar_judul/'. $images_gambar_judul['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/blog/gambar_judul/small_'. $images_gambar_judul['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/blog/gambar_judul/'. $images_gambar_judul['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 750,
				                'height' 			=> 390,
				                'new_image' 		=> './assets/images/blog/gambar_judul/middle_'. $images_gambar_judul['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}

						$data_gambar_judul = array(
				    		'nama_gambar_judul' => $images_gambar_judul['file_name'],
				    		'caption_gambar_judul' => $this->input->post('caption_gambar_judul'),
				    	);

				        $this->db->where('blog_id', $id);
				        $query = $this->db->update('gambar_judul_blog', $data_gambar_judul);
					}
				}

				if ($_FILES['nama_gambar_posting']['name'] != NULL) {

					$hapus_gambar_posting_blog = $this->models->cari_gambar_posting($id)->row();
					$temp_gambar_posting_blog 	= $hapus_gambar_posting_blog->nama_gambar_posting;

					# Menghapus gambar posting
					if ($temp_gambar_posting_blog) {
						unlink('./assets/images/blog/gambar_posting/'.$temp_gambar_posting_blog);
						unlink('./assets/images/blog/gambar_posting/small_'.$temp_gambar_posting_blog);
						unlink('./assets/images/blog/gambar_posting/middle_'.$temp_gambar_posting_blog);
					}
					

					# UPLOAD GAMBAR Posting
					$gambar_posting = $_FILES['nama_gambar_posting']['name'];

					if ($gambar_posting !="") {

						$config['upload_path']     	= './assets/images/blog/gambar_posting/';
					    $config['allowed_types']   	= 'jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nama_file 					= strtolower($this->input->post('caption_gambar_posting'));
						$config['file_name'] 		= $nama_file."_".time();

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('nama_gambar_posting')){
							print_r($this->upload->display_errors());

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							$this->load->view('include/template', $this->data);

						}else{

							$images_gambar_posting = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/blog/gambar_posting/'. $images_gambar_posting['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/blog/gambar_posting/small_'. $images_gambar_posting['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/blog/gambar_posting/'. $images_gambar_posting['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 750,
				                'height' 			=> 390,
				                'new_image' 		=> './assets/images/blog/gambar_posting/middle_'. $images_gambar_posting['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();							
						
						}

						$data_gambar_posting = array(
				    		'nama_gambar_posting' => $images_gambar_posting['file_name'],
				    		'caption_gambar_posting' => $this->input->post('caption_gambar_posting'),
				    	);

				        $this->db->where('blog_id', $id);
				        $query = $this->db->update('gambar_posting_blog', $data_gambar_posting);
					}
				}



				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_blog($id, $input);
				
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
			$search = $this->models->cari_blog($id);
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

			$hapus_gambar_judul_blog = $this->models->cari_gambar_judul($id)->row();
			$hapus_gambar_posting_blog = $this->models->cari_gambar_posting($id)->row();

			$temp_gambar_judul_blog 	= $hapus_gambar_judul_blog->nama_gambar_judul;
			$temp_gambar_posting_blog 	= $hapus_gambar_posting_blog->nama_gambar_posting;

			if ($this->models->hapus_blog($id) === TRUE) {

				# Menghapus gambar judul
				unlink('./assets/images/blog/gambar_judul/'.$temp_gambar_judul_blog);
				unlink('./assets/images/blog/gambar_judul/small_'.$temp_gambar_judul_blog);
				unlink('./assets/images/blog/gambar_judul/middle_'.$temp_gambar_judul_blog);

				# Menghapus gambar posting
				unlink('./assets/images/blog/gambar_posting/'.$temp_gambar_posting_blog);
				unlink('./assets/images/blog/gambar_posting/small_'.$temp_gambar_posting_blog);
				unlink('./assets/images/blog/gambar_posting/middle_'.$temp_gambar_posting_blog);
	
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

/* End of file Blog.php */
/* Location: ./application/modules/backend/controllers/Blog.php */