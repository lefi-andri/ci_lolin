<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk extends Backend_Controller {

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
		
		$this->load->library('form_validation');

		$this->load->library('image_lib');
		$this->load->helper('file');

		// setting ck editor
		$this->load->library(array('CKEditor', 'CKFinder'));		
		$width = '100%';
        $height = '500px';
        $this->editor($width,$height);

        //set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//set model
		$this->load->model('kategori_produk_model');
	}

	function editor($width,$height) {
	    $this->ckeditor->basePath = base_url().'assets/plugins/ckeditor/';
	    $this->ckeditor->config['toolbar'] = 'Full';
	    $this->ckeditor->config['language'] = 'en';
	    $this->ckeditor->config['width'] = $width;
	    $this->ckeditor->config['height'] = $height;
	 	    
	    $path = 'assets/plugins/ckfinder/';
	    $this->ckfinder->SetupCKEditor($this->ckeditor,$path);
	}

	public function index()
	{
		
	}

	public function list_kategori_product()
	{
		//set title
		$this->stencil->title('Kategori Blog');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$data = array(
			'label'	=> 'Kategori Produk',
		);

		//set view
		$this->stencil->paint('kategori_produk/list_kategori_produk',$data);

		/*$this->load->library('breadcrumb');
		$this->breadcrumb->add('Blog Kategori', 'blog');		

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$data = array(
			'main_view' => 'kategori_produk/list_kategori_produk', 
		);
		$this->load->view('include/template', $data);*/
	}

	public function grab_data_kategori_produk()
	{
		$draw						= $_REQUEST['draw'];		
		$length						= $_REQUEST['length'];
		$start						= $_REQUEST['start'];
		$search						= $_REQUEST['search']["value"];
		$total 						= $this->db->count_all_results('product_cat');
		$output 					= array();
		$output['draw'] 			= $draw;
		$output['recordsTotal']		= $output['recordsFiltered'] = $total;
		$output['data']				= array();

		if($search!="")
		{
			$this->db->like('catprodsName', $search)
					->or_like('catprodsSort', $search);
		}
		
		$this->db->limit($length, $start);		
		$this->db->order_by('catprodsSort', 'ASC');
		$query = $this->db->get('product_cat')->result_array();
		
		if($search!="")
		{
			$this->db->like('catprodsName', $search)
					->or_like('catprodsSort', $search);

			$jum = $this->db->get('product_cat');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}

		$nomor_urut = $start+1;
		foreach ($query as $hasil) {
						
			$id 	= md5($hasil['catprodsId']);
			$nama 	= $hasil['catprodsName'];

			$output['data'][]=array(
				$nomor_urut,
				"<img src='".base_url()."assets/images/product/product_category/small_".$hasil['catprodsNavbarPicture']."' />",
				$hasil['catprodsName'],
				$hasil['catprodsSort'],
				($hasil['catprodsShow'] == 'y') ? 'Ya' : 'Tidak',
				anchor("admin/product/kategori/remove/$id",'<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus Gambar', array('title'=>"Hapus gambar navbar $nama" , 'class'=>'btn btn-default btn-sm', 'onclick' => "return confirm('Anda yakin ingin menghapus gambar navbar $nama ?')"))." ".
				anchor("admin/product/kategori/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-default btn-sm'))." ".
				anchor("admin/product/kategori/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-default btn-sm', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
		$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function file_check_gambar_kategori($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['catprodsNavbarPicture']['name']);
        if(isset($_FILES['catprodsNavbarPicture']['name']) && $_FILES['catprodsNavbarPicture']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_gambar_kategori', 'Silahkan pilih hanya file pdf / gif / jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_gambar_kategori', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }
		
	public function add_kategori()
	{
		//set title
		$this->stencil->title('Tambah Kategori Produk');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		//set breadcrumb
		$this->load->library('breadcrumb');

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$this->data = array(
			'label'			=> 'Tambah Kategori produk',
			'form_action' 	=> 'backend/kategori_produk/add_kategori'
		);

		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'kategori_produk/form_add_kategori_produk',
			'form_action' 	=> 'admin/product/kategori/add'
		);

		# URLBACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;*/
		
		$this->form_validation->set_rules('catprodsName', 'Nama Kategori', 'trim|required|xss_clean');
		$this->form_validation->set_rules('catprodsSort', 'Pengurutan Kategori', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('catprodsShow', 'Kategori Ditampilkan', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			# Jika disubmit
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('Product Kategori', 'adm_product');
				$this->breadcrumb->add('Tambah Product Kategori', 'adm_product/add_kategori');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//$this->load->view('include/template', $this->data);
				//set view
				$this->stencil->paint('kategori_produk/form_add_kategori_produk',$this->data);
			} else {

				# UPLOAD FILE GAMBAR
				$filename = $_FILES['catprodsNavbarPicture']['name'];

				if ($filename !="") {

					$config['upload_path']     	= './assets/images/product/product_category/';
				    $config['allowed_types']   	= 'jpg|png';	    
				    $config['detect_mime']		= TRUE;
				    $config['max_size']        	= 20000;
				    $nmfile 					= $this->input->post('catprodsName');
				    $time 						= time();		    
					$config['file_name'] 		= $nmfile."_".$time;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('catprodsNavbarPicture')){
						print_r($this->upload->display_errors());
						$this->breadcrumb->add('News', 'adm_klien');
						$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						//$this->load->view('include/template', $this->data);
						//set view
						$this->stencil->paint('kategori_produk/form_add_kategori_produk',$this->data);

					}else{

						$images = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/product_category/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 40,
			                'height' 			=> 40,
			                'new_image' 		=> './assets/images/product/product_category/small_'. $images['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/product_category/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 750,
			                'height' 			=> 390,
			                'new_image' 		=> './assets/images/product/product_category/middle_'. $images['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();							
					
					}
				}

				$this->load->helper('slug');
				$slug = slug($_POST['catprodsName']);

				$info = array(					
					'catprodsName' 				=> $this->input->post('catprodsName'),
					'catprodsSlug' 				=> $slug,
					'catprodsNavbarPicture'		=> $images['file_name'],
					'catprodsSort' 				=> $this->input->post('catprodsSort'),
					'catprodsShow' 				=> $this->input->post('catprodsShow'),
				);

				if ($this->kategori_produk_model->simpan_kategori($info) === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{
					
					$this->breadcrumb->add('Product Kategori', 'adm_product');
					$this->breadcrumb->add('Tambah Product Kategori', 'adm_product/add_kategori');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					//$this->load->view('include/template', $this->data);
					//set view
					$this->stencil->paint('kategori_produk/form_add_kategori_produk',$this->data);
				}

			}
		}else{
			
			$this->breadcrumb->add('Product Kategori', 'adm_product');
			$this->breadcrumb->add('Tambah Product Kategori', 'adm_product/add_kategori');

			//$this->load->view('include/template', $this->data);
			//set view
			$this->stencil->paint('kategori_produk/form_add_kategori_produk',$this->data);
		}


	}

	public function edit_kategori($id)
	{
		//set title
		$this->stencil->title('Edit Kategori Produk');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$this->data = array(
			'label'			=> "Edit Kategori Blog",
			'form_action' 	=> "backend/kategori_produk/edit_kategori/$id"
		);
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'kategori_produk/form_edit_kategori_produk',
			'form_action' 		=> "admin/product/kategori/edit/$id"
		);*/

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('catprodsName', 'Nama Kategori', 'trim|required|xss_clean');
				$this->form_validation->set_rules('catprodsSort', 'Pengurutan Kategori', 'trim|required|numeric|xss_clean');
				$this->form_validation->set_rules('catprodsShow', 'Kategori Ditampilkan', 'trim|required|xss_clean');

				

				if ($this->form_validation->run() == FALSE) {

					$this->breadcrumb->add('Product Kategori', 'adm_product');
					$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					//$this->load->view('include/template', $this->data);
					//set view
					$this->stencil->paint('kategori_produk/form_edit_kategori_produk',$this->data);
				} else {

					
					# KATEGORI UPLOAD		
					$filename = $_FILES['catprodsNavbarPicture']['name'];

					$id = $this->session->userdata('id_sekarang');

					if ($filename !="") {

						if ($this->kategori_produk_model->cariImageKategori($id)->num_rows() > 0) {
							$removeImages = $this->kategori_produk_model->cariImageKategori($id)->row();
			
							# Menghapus gambar
							unlink('./assets/images/product/product_category/'.$removeImages->catprodsNavbarPicture);
							unlink('./assets/images/product/product_category/small_'.$removeImages->catprodsNavbarPicture);
							unlink('./assets/images/product/product_category/middle_'.$removeImages->catprodsNavbarPicture);
						}
						

						$config_headline['upload_path']     	= './assets/images/product/product_category/';
					    $config_headline['allowed_types']   	= 'gif|jpg|png';	    
					    $config_headline['detect_mime']			= TRUE;
					    $config_headline['max_size']        	= 20000;
					    $nmfile 								= $this->input->post('catprodsName');
					    $time 									= time();		    
						$config_headline['file_name'] 			= $nmfile."_".$time;

						$this->load->library('upload', $config_headline);
						$this->upload->initialize($config_headline);

						if (!$this->upload->do_upload('catprodsNavbarPicture')){
							print_r($this->upload->display_errors());
							$this->breadcrumb->add('News', 'adm_klien');
							$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							//$this->load->view('include/template', $this->data);
							//set view
							$this->stencil->paint('kategori_produk/form_edit_kategori_produk',$this->data);

						}else{

							$images = $this->upload->data();

							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/product/product_category/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/product/product_category/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/product/product_category/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 375,
				                'height' 			=> 483,
				                'new_image' 		=> './assets/images/product/product_category/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();	

						}

						$this->load->helper('slug');
						$slug = slug($_POST['catprodsName']);

						$info = array(					
							'catprodsName' 				=> $this->input->post('catprodsName'),
							'catprodsSlug' 				=> $slug,
							'catprodsNavbarPicture'		=> $images['file_name'],
							'catprodsSort' 				=> $this->input->post('catprodsSort'),
							'catprodsShow' 				=> $this->input->post('catprodsShow'),
						);

					} else {

						# JIKA TIDAK ADA GAMBAR UNTUK DIUPLOAD
						$this->load->helper('slug');
						$slug = slug($_POST['catprodsName']);

						$info = array(					
							'catprodsName' 				=> $this->input->post('catprodsName'),
							'catprodsSlug' 				=> $slug,
							'catprodsSort' 				=> $this->input->post('catprodsSort'),
							'catprodsShow' 				=> $this->input->post('catprodsShow'),
						);


					}
					
					if ($this->kategori_produk_model->update_kategori($info, $id) === TRUE) {
						$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);
					}else{

						$this->breadcrumb->add('Product Kategori', 'adm_product');
						$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

						$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
						//$this->load->view('include/template', $this->data);
						//set view
						$this->stencil->paint('kategori_produk/form_edit_kategori_produk',$this->data);
					}
					
				}
			}else{
				$search = $this->kategori_produk_model->cari_kategori($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->catprodsId);

					$this->breadcrumb->add('Product Kategori', 'adm_product');
					$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

					//$this->load->view('include/template', $this->data);
					//set view
					$this->stencil->paint('kategori_produk/form_edit_kategori_produk',$this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}

	public function delete_kategori($id = NULL)
	{
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$removeImages 	= $this->kategori_produk_model->cariImageNavbarKategori($id)->row();
			$tempImages 	= $removeImages->catprodsNavbarPicture;

			if (is_file("./assets/images/product/product_category/$tempImages")) {

				if ($this->kategori_produk_model->hapus_kategori($id) === TRUE) {
					
					unlink('./assets/images/product/product_category/'.$tempImages);
					unlink('./assets/images/product/product_category/small_'.$tempImages);
					unlink('./assets/images/product/product_category/middle_'.$tempImages);

					$this->session->set_flashdata('message_success', 'Proses hapus data berhasil.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{
					$this->session->set_flashdata('message_error', 'Gagal menghapus data!');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}else{
				if ($this->kategori_produk_model->hapus_kategori($id) === TRUE) {
	
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

	public function remove_image($id = NULL)
	{
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$removeImages 	= $this->kategori_produk_model->cariImageNavbarKategori($id)->row();
			$tempImages 	= $removeImages->catprodsNavbarPicture;

			if (!is_file("./assets/images/product/product_category/$tempImages")) {

				$this->session->set_flashdata('message_warning', 'Gambar Telah Kosong!');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			   		
			}else{

				$info = array(					
					'catprodsNavbarPicture' => "",
				);

				if ($this->kategori_produk_model->update_remove_product_category($info, $id) === TRUE) {

					unlink('./assets/images/product/product_category/'.$tempImages);
					unlink('./assets/images/product/product_category/small_'.$tempImages);
					unlink('./assets/images/product/product_category/middle_'.$tempImages);

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


}

/* End of file Kategori_produk.php */
/* Location: ./application/modules/backend/controllers/Kategori_produk.php */