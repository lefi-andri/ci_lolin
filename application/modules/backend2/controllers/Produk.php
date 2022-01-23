<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends Backend_Controller {

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

        // load model
		$this->load->model('produk_model');
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
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Blog Kategori', 'blog');		

		# URLBACK
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$data = array(
			'main_view' => 'produk/list_produk', 
		);
		$this->load->view('include/template', $data);
	}

	public function grab_data_produk()
	{
		$draw						= $_REQUEST['draw'];		
		$length						= $_REQUEST['length'];
		$start						= $_REQUEST['start'];
		$search						= $_REQUEST['search']["value"];
		$total 						= $this->db->count_all_results('product');
		$output 					= array();
		$output['draw'] 			= $draw;
		$output['recordsTotal']		= $output['recordsFiltered'] = $total;
		$output['data']				= array();

		if($search!="")
		{
			$this->db->like('prodsName', $search);
		}
		
		$this->db->limit($length, $start);
		
		$this->db->select('*');
		$this->db->from('product_cat');
		$this->db->join('product', 'product.catprodsId = product_cat.catprodsId');
		$query = $this->db->get()->result_array();
		
		if($search!="")
		{
			$this->db->like('prodsName', $search);
			$jum = $this->db->get('product');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}

		$nomor_urut = $start+1;
		foreach ($query as $hasil) {
						
			$id 	= $hasil['prodsId'];
			$nama 	= $hasil['prodsName'];

			$output['data'][]=array(
				$nomor_urut,
				$hasil['prodsName']." [".$hasil['prodsNetto']."ml]",
				$hasil['catprodsName'],
				"<img src='".base_url()."assets/images/product/base_of_product/small_".$hasil['prodsBasePic']."' />",
				"<img src='".base_url()."assets/images/product/front_of_product/small_".$hasil['prodsFrontPic']."' />",
				"<img src='".base_url()."assets/images/product/back_of_product/small_".$hasil['prodsBackPic']."' />",
				$hasil['prodsSort'],
				($hasil['prodsShow'] == '1') ? 'Ya' : 'Tidak',
				$hasil['prodsPrice'],
				anchor("admin/product/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("admin/product/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
		$nomor_urut++;
		}

		echo json_encode($output);
	}


	/**
	* Controller Product
	*
	*/
	public function kategori_check()
    {
    	if ($this->input->post('catprodsId') === '') {
    		$this->form_validation->set_message('kategori_check', 'Tolong pilih kategori blog');
    		return FALSE;
    	}else{
    		return TRUE;
    	}
    }

    /*
     * file value and type check during validation
     */
    public function file_check_headline($str)
    {
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file_headline']['name']);
        if(isset($_FILES['file_headline']['name']) && $_FILES['file_headline']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_headline', 'Silahkan pilih hanya file pdf / gif / jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_headline', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

    public function file_check($str)
    {
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Silahkan pilih hanya file pdf / gif / jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

    public function file_check_base_of_product($str)
    {
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['prodsBasePic']['name']);
        if(isset($_FILES['prodsBasePic']['name']) && $_FILES['prodsBasePic']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_base_of_product', 'Silahkan pilih hanya file pdf / gif / jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_base_of_product', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }


	public function add_product()
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 			=> 'produk/form_add_produk',
			'form_action' 			=> 'admin/product/add',
			'dd_product_kategori' 	=> $this->produk_model->dd_product_kategori(),			
		);

		# URL BACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		
		$this->form_validation->set_rules('prodsKode', 'Kode Produk', 'trim|required|xss_clean');		
		$this->form_validation->set_rules('prodsDesc', 'Deskripsi Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsKeyword', 'Keyword Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsShow', 'Tampilkan Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsSort', 'Urutan Produk', 'trim|required|numeric|xss_clean');	
		$this->form_validation->set_rules('prodsName', 'Nama Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsNetto', 'Netto Produk', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('prodsWeight', 'Berat Produk', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('catprodsId', 'Kategori Product', 'trim|required|callback_kategori_check');
		$this->form_validation->set_rules('file', '', 'callback_file_check');
		$this->form_validation->set_rules('prodsFrontPicCaption', 'Caption Gambar Bangunan Klien', 'trim|required|xss_clean');
		$this->form_validation->set_rules('file_headline', '', 'callback_file_check_headline');
		$this->form_validation->set_rules('prodsBackPicCaption', 'Caption Gambar Logo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('poinNilai[]', 'Poin Produk', 'trim|required|numeric|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('News', 'adm_klien');
				$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				# UPLOAD GAMBAR DEPAN
				$filename = $_FILES['file']['name'];

				if ($filename !="") {

					$config['upload_path']     	= './assets/images/product/front_of_product/';
				    $config['allowed_types']   	= 'gif|jpg|png';	    
				    $config['detect_mime']		= TRUE;
				    $config['max_size']        	= 20000;
				    $nmfile 					= $this->input->post('prodsFrontPicCaption');
				    $time 						= time();		    
					$config['file_name'] 		= $nmfile."_".$time;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('file')){
						print_r($this->upload->display_errors());
						$this->breadcrumb->add('News', 'adm_klien');
						$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						$this->load->view('include/template', $this->data);

					}else{

						$images = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/front_of_product/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 100,
			                'height' 			=> 100,
			                'new_image' 		=> './assets/images/product/front_of_product/small_'. $images['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/front_of_product/'. $images['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 750,
			                'height' 			=> 390,
			                'new_image' 		=> './assets/images/product/front_of_product/middle_'. $images['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();							
					
					}
				}

				

				# UPLOAD GAMBAR BELAKANG
				$filename2 = $_FILES['file_headline']['name'];

				if ($filename2 !="") {
					$config_headline['upload_path']     	= './assets/images/product/back_of_product/';
				    $config_headline['allowed_types']   	= 'gif|jpg|png';	    
				    $config_headline['detect_mime']			= TRUE;
				    $config_headline['max_size']        	= 20000;
				    $nmfile 								= $this->input->post('prodsBackPicCaption');
				    $time 									= time();		    
					$config_headline['file_name'] 			= $nmfile."_".$time;

					$this->load->library('upload', $config_headline);
					$this->upload->initialize($config_headline);

					if (!$this->upload->do_upload('file_headline')){
						print_r($this->upload->display_errors());
						$this->breadcrumb->add('News', 'adm_klien');
						$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						$this->load->view('include/template', $this->data);

					}else{

						$images_headline = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/back_of_product/'. $images_headline['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 100,
			                'height' 			=> 100,
			                'new_image' 		=> './assets/images/product/back_of_product/small_'. $images_headline['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/back_of_product/'. $images_headline['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 375,
			                'height' 			=> 483,
			                'new_image' 		=> './assets/images/product/back_of_product/middle_'. $images_headline['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();	

					}

				}

				# BASE UPLOAD IMAGES
				$filename3 = $_FILES['prodsBasePic']['name'];

				if ($filename3 !="") {
					$config_headline['upload_path']     	= './assets/images/product/base_of_product/';
				    $config_headline['allowed_types']   	= 'gif|jpg|png';	    
				    $config_headline['detect_mime']			= TRUE;
				    $config_headline['max_size']        	= 20000;
				    $nmfile 								= $this->input->post('prodsBasePicCaption');
				    $time 									= time();		    
					$config_headline['file_name'] 			= $nmfile."_".$time;

					$this->load->library('upload', $config_headline);
					$this->upload->initialize($config_headline);

					if (!$this->upload->do_upload('prodsBasePic')){
						print_r($this->upload->display_errors());
						
						$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
						$this->load->view('include/template', $this->data);

					}else{

						$images_base_of_product = $this->upload->data();

						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/base_of_product/'. $images_base_of_product['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 100,
			                'height' 			=> 100,
			                'new_image' 		=> './assets/images/product/base_of_product/small_'. $images_base_of_product['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE
						$this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/product/base_of_product/'. $images_base_of_product['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 375,
			                'height' 			=> 483,
			                'new_image' 		=> './assets/images/product/base_of_product/middle_'. $images_base_of_product['file_name'],
			            ));
			            $this->load->library('image_lib', $config);
						$this->image_lib->resize();	

					}

				}

				# Membuat ID				
		        $this->db->select_max('prodsId');
				$query = $this->db->get('product');
				foreach ($query->result_array() as $nil) {
				  $createId = $nil['prodsId'];
				  $createId ++;				  
				}

				$this->load->helper('slug');
				$slug = slug($_POST['prodsName']);

				$info = array(
					'prodsId' 					=> $createId,
					'catprodsId' 				=> $this->input->post('catprodsId'),
					'prodsKode' 				=> $this->input->post('prodsKode'),
					'prodsName' 				=> $this->input->post('prodsName'),
					'prodsSlug' 				=> $slug,							
					'prodsFrontPic'				=> $images['file_name'],
					'prodsFrontPicCaption'		=> $this->input->post('prodsFrontPicCaption'),					
					'prodsBackPic'				=> $images_headline['file_name'],
					'prodsBackPicCaption'		=> $this->input->post('prodsBackPicCaption'),
					'prodsBasePic'				=> $images_base_of_product['file_name'],
					'prodsBasePicCaption'		=> $this->input->post('prodsBasePicCaption'),										
					'prodsNetto' 				=> $this->input->post('prodsNetto'),
					'prodsWeight' 				=> $this->input->post('prodsWeight'),
					'prodsDesc' 				=> $this->input->post('prodsDesc'),
					'prodsKeyword' 				=> $this->input->post('prodsKeyword'),
					'prodsAddedDate' 			=> date('Y-m-d H:i:s'),
					'prodsShow' 				=> $this->input->post('prodsShow'),
					'prodsSort' 				=> $this->input->post('prodsSort'),

					'prodsPrice'				=> $this->input->post('harga_satuan'),
					'prodsDirections' 			=> $this->input->post('prodsDirections'),
					'prodsIngredients' 			=> $this->input->post('prodsIngredients'),
					'nomor_bpom' 				=> $this->input->post('nomor_bpom'),
					'merchant'					=> serialize($this->input->post('merchant[]')),
					'admin_id'              	=> $this->session->userdata('user_id')
				);
				
				# Insert data Produk
				if ($this->produk_model->simpan_product($info) === TRUE) {

					
				# Insert data Nilai Poin Produk
				$name_attribut= $this->input->post('group_id[]');
				$result = array();
				foreach($name_attribut AS $key => $val){
				$result[] = array(
				 	'prodsId' 		=> $createId,
				  	"group_id"  	=> $_POST['group_id'][$key],
				 	"poinNilai"  	=> $_POST['poinNilai'][$key]
				);
				}
				$this->db->insert_batch('poin', $result);

				# DISKON
				$diskon_data = $this->input->post('satuan_diskon[]');
				$result_diskon = array();
				$no = 1;
				foreach($diskon_data AS $key => $val){
				 $result_diskon[] = array(
				 	'produk_id' => $createId,
				 	'diskon_urutan' => $no,
				  	"jumlah_unit" => $_POST['satuan_diskon'][$key],
				  	"berat" => $_POST['berat'][$key],
				 	"harga_jumlah_unit" => $_POST['harga_satuan_diskon'][$key]
				 );
				$no++;
				}
				$this->db->insert_batch('diskon_harga', $result_diskon);

				# Insert data Direction
				$info_directions = array(
					'prodsId' 		=> $createId,
				);
				$this->db->insert('product_directions', $info_directions);

				# Insert data Ingredients
				$info_ingredients = array(
					'prodsId' 		=> $createId,
				);
				$this->db->insert('product_ingredients', $info_ingredients);
				

					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{
					
					$this->breadcrumb->add('News', 'adm_klien');
					$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}

				// End Proses

			}

		}else{
			
			$this->breadcrumb->add('News', 'adm_klien');
			$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

			$this->load->view('include/template', $this->data);
		}
	}

	public function _set_rule_edit_product()
	{
		$this->form_validation->set_rules('prodsKode', 'Kode Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsDesc', 'Deskripsi Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsKeyword', 'Keyword Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsShow', 'Tampilkan Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsSort', 'Urutan Produk', 'trim|required|numeric|xss_clean');	
		$this->form_validation->set_rules('prodsName', 'Nama Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('prodsNetto', 'Netto Produk', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('prodsWeight', 'Berat Produk', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('catprodsId', 'Kategori Product', 'trim|required|callback_kategori_check');

		$this->form_validation->set_error_delimiters('<span class="peringatan">', '</span>');
	}

	public function edit_product($id = NULL)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 				=> 'produk/form_edit_produk',
			'form_action' 				=> 'admin/product/edit/'.$id,
			'dd_product_kategori' 		=> $this->produk_model->dd_product_kategori(),	
			'id'						=> $id,
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{
			
			if (isset($_POST['submit'])) {

				$this->_set_rule_edit_product();

				if ($this->form_validation->run() == FALSE) {
					$this->breadcrumb->add('News', 'adm_klien');
					$this->breadcrumb->add('Edit News', 'adm_klien/edit_klien');
					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					$this->load->view('include/template', $this->data);
				}

				$filename_gambar_depan		= $_FILES['file']['name'];
				$filename_gambar_belakang 	= $_FILES['file_headline']['name'];
				$filename_base_of_product 	= $_FILES['prodsBasePic']['name'];		

				if ($filename_gambar_depan !="") {

					$this->form_validation->set_rules('prodsFrontPicCaption', 'Caption Gambar Depan Produk', 'trim|required|xss_clean');
					
					if ($this->form_validation->run() == TRUE) {

						$removeImages = $this->produk_model->cariImage($id)->row();
						unlink('./assets/images/product/front_of_product/'.$removeImages->prodsFrontPic);
						unlink('./assets/images/product/front_of_product/small_'.$removeImages->prodsFrontPic);
						unlink('./assets/images/product/front_of_product/middle_'.$removeImages->prodsFrontPic);

						# GAMBAR DEPAN
						$filename = $_FILES['file']['name'];

						if ($filename !="") {

							$config['upload_path']     	= './assets/images/product/front_of_product/';
						    $config['allowed_types']   	= 'gif|jpg|png';	    
						    $config['detect_mime']		= TRUE;
						    $config['max_size']        	= 20000;
						    $nmfile 					= $this->input->post('prodsFrontPicCaption');
						    $time 						= time();		    
							$config['file_name'] 		= $nmfile."_".$time;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							if (!$this->upload->do_upload('file')){
								print_r($this->upload->display_errors());
								$this->breadcrumb->add('News', 'adm_klien');
								$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

								$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
								$this->load->view('include/template', $this->data);

							}else{

								$images = $this->upload->data();

								//MEMBUAT UKURAN SMALL				
					            $this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/front_of_product/'. $images['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 100,
					                'height' 			=> 100,
					                'new_image' 		=> './assets/images/product/front_of_product/small_'. $images['file_name'],
					            ));                
								$this->load->library('image_lib', $config);
								$this->image_lib->resize();

								//MEMBUAT UKURAN MIDDLE
								$this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/front_of_product/'. $images['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 750,
					                'height' 			=> 390,
					                'new_image' 		=> './assets/images/product/front_of_product/middle_'. $images['file_name'],
					            ));
					            $this->load->library('image_lib', $config);
								$this->image_lib->resize();							
							
							}

							$input_gambar = array(
								'prodsFrontPic'				=> $images['file_name'],
								'prodsFrontPicCaption'		=> $this->input->post('prodsFrontPicCaption'),
							);

							$this->produk_model->update_gambar_product($input_gambar, $id);
						}

					}
					
				}

				if ($filename_gambar_belakang !="") {
					
					$this->form_validation->set_rules('prodsBackPicCaption', 'Caption Gambar Logo', 'trim|required|xss_clean');

					if ($this->form_validation->run() == TRUE) {

						$removeImages = $this->produk_model->cariImage($id)->row();
						#print_r($removeImages);
						$temp_prodsBackPic 		= $removeImages->prodsBackPic;
						unlink('./assets/images/product/back_of_product/'.$temp_prodsBackPic);
						unlink('./assets/images/product/back_of_product/small_'.$temp_prodsBackPic);
						unlink('./assets/images/product/back_of_product/middle_'.$temp_prodsBackPic);

						$filename2 = $_FILES['file_headline']['name'];

						if ($filename2 !="") {
							$config_headline['upload_path']     	= './assets/images/product/back_of_product/';
						    $config_headline['allowed_types']   	= 'gif|jpg|png';	    
						    $config_headline['detect_mime']			= TRUE;
						    $config_headline['max_size']        	= 20000;
						    $nmfile 								= $this->input->post('prodsBackPicCaption');
						    $time 									= time();		    
							$config_headline['file_name'] 			= $nmfile."_".$time;

							$this->load->library('upload', $config_headline);
							$this->upload->initialize($config_headline);

							if (!$this->upload->do_upload('file_headline')){
								print_r($this->upload->display_errors());
								$this->breadcrumb->add('News', 'adm_klien');
								$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

								$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
								$this->load->view('include/template', $this->data);

							}else{

								$images_headline = $this->upload->data();

								//MEMBUAT UKURAN SMALL				
					            $this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/back_of_product/'. $images_headline['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 100,
					                'height' 			=> 100,
					                'new_image' 		=> './assets/images/product/back_of_product/small_'. $images_headline['file_name'],
					            ));                
								$this->load->library('image_lib', $config_headline);
								$this->image_lib->resize();

								//MEMBUAT UKURAN MIDDLE
								$this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/back_of_product/'. $images_headline['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 375,
					                'height' 			=> 483,
					                'new_image' 		=> './assets/images/product/back_of_product/middle_'. $images_headline['file_name'],
					            ));
					            $this->load->library('image_lib', $config_headline);
								$this->image_lib->resize();	

							}

							$input_gambar = array(					
								'prodsBackPic'				=> $images_headline['file_name'],
								'prodsBackPicCaption'		=> $this->input->post('prodsBackPicCaption'),
							);

							$this->produk_model->update_gambar_product($input_gambar, $id);
						}
						
					}

				}

				if ($filename_base_of_product !="") {
					
					$this->form_validation->set_rules('prodsBasePicCaption', 'Caption Gambar Logo', 'trim|required|xss_clean');
					if ($this->form_validation->run() == TRUE) {

						$removeImages = $this->produk_model->cariImage($id)->row();
						unlink('./assets/images/product/base_of_product/'.$removeImages->prodsBasePic);
						unlink('./assets/images/product/base_of_product/small_'.$removeImages->prodsBasePic);
						unlink('./assets/images/product/base_of_product/middle_'.$removeImages->prodsBasePic);

						# GAMBAR BASE
						$filename3 = $_FILES['prodsBasePic']['name'];

						if ($filename3 !="") {
							$config_base['upload_path']     	= './assets/images/product/base_of_product/';
						    $config_base['allowed_types']   	= 'gif|jpg|png';	    
						    $config_base['detect_mime']			= TRUE;
						    $config_base['max_size']        	= 20000;
						    $nmfile 							= $this->input->post('prodsBasePicCaption');
						    $time 								= time();		    
							$config_base['file_name'] 			= $nmfile."_".$time;

							$this->load->library('upload', $config_base);
							$this->upload->initialize($config_base);

							if (!$this->upload->do_upload('prodsBasePic')){
								print_r($this->upload->display_errors());
								
								$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
								$this->load->view('include/template', $this->data);

							}else{

								$images_base_of_product = $this->upload->data();

								//MEMBUAT UKURAN SMALL				
					            $this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/base_of_product/'. $images_base_of_product['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 100,
					                'height' 			=> 100,
					                'new_image' 		=> './assets/images/product/base_of_product/small_'. $images_base_of_product['file_name'],
					            ));                
								$this->load->library('image_lib', $config_base);
								$this->image_lib->resize();

								//MEMBUAT UKURAN MIDDLE
								$this->image_lib->initialize(array(
					                'image_library' 	=> 'gd2',
					                'source_image' 		=> './assets/images/product/base_of_product/'. $images_base_of_product['file_name'],
					                'maintain_ratio' 	=> FALSE,
					                'create_thumb' 		=> FALSE,
					                'width' 			=> 375,
					                'height' 			=> 483,
					                'new_image' 		=> './assets/images/product/base_of_product/middle_'. $images_base_of_product['file_name'],
					            ));
					            $this->load->library('image_lib', $config_base);
								$this->image_lib->resize();	

							}

							$input_gambar = array(
								'prodsBasePic'				=> $images_base_of_product['file_name'],
								'prodsBasePicCaption'		=> $this->input->post('prodsBasePicCaption'),
							);

							$this->produk_model->update_gambar_product($input_gambar, $id);

						}
						
					}

				}

				$id_produk = $this->session->userdata('id_sekarang');
						
				$input 	= $this->input->post(null, TRUE);						

				# UPDATE POIN
				$this->produk_model->update_poin($input);

				# UPDATE DISKON
				$this->produk_model->update_diskon($input);

				# UPDATE PRODUK
				$update_produk = $this->produk_model->update_product($input, $id_produk);

				if ($update_produk === TRUE) {           
					$this->session->unset_userdata('id_sekarang');

					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{

					$this->breadcrumb->add('News', 'adm_klien');
					$this->breadcrumb->add('Edit News', 'adm_klien/edit_klien');

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}


			}else{
				// Jika tidak disubmit
				$search = $this->produk_model->cari_product($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->prodsId);

					$this->breadcrumb->add('Product', 'adm_product');
					$this->breadcrumb->add('Edit Product', 'adm_product/edit_product');

					$this->data['dd_product_kategori'] = $this->produk_model->dd_product_kategori();										
					$this->data['dd_selected'] = $this->input->post('catprodsName')? $this->input->post('catprodsName') : $search->prodsId;

					$this->load->view('include/template', $this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}
			
		}
	}

	public function delete_product($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$removeImages 			= $this->produk_model->cariImage($id)->row();
			$temp_prodsFrontPic 	= $removeImages->prodsFrontPic;
			$temp_prodsBackPic 		= $removeImages->prodsBackPic;
			$temp_prodsBasePic 		= $removeImages->prodsBasePic;

			$this->db->delete('product_directions', array('prodsId' => $id));
			$this->db->delete('product_ingredients', array('prodsId' => $id));
			$this->db->delete('diskon_harga', array('produk_id' => $id));
			$this->db->delete('poin', array('prodsId' => $id));

			if ($this->produk_model->hapus_product($id) === TRUE) {

				# Menghapus gambar depan produk
				unlink('./assets/images/product/front_of_product/'.$temp_prodsFrontPic);
				unlink('./assets/images/product/front_of_product/small_'.$temp_prodsFrontPic);
				unlink('./assets/images/product/front_of_product/middle_'.$temp_prodsFrontPic);

				# Menghapus gambar belakang produk
				unlink('./assets/images/product/back_of_product/'.$temp_prodsBackPic);
				unlink('./assets/images/product/back_of_product/small_'.$temp_prodsBackPic);
				unlink('./assets/images/product/back_of_product/middle_'.$temp_prodsBackPic);

				# Menghapus gambar base produk
				unlink('./assets/images/product/base_of_product/'.$temp_prodsBasePic);
				unlink('./assets/images/product/base_of_product/small_'.$temp_prodsBasePic);
				unlink('./assets/images/product/base_of_product/middle_'.$temp_prodsBasePic);

				
				
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

	/*public function edit_directions($id)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'product/form_product_directions',
			'form_action' 		=> 'admin/product/directions/edit/'.$id,
		);

		# URL BACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		
		$this->form_validation->set_rules('directDirect', 'Deskripsi Aturan Penggunaan Produk', 'trim|required|xss_clean');
		
		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('Product', 'adm_product');
				$this->breadcrumb->add('Edit Directions', 'adm_product/edit_directions');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {

				$this->load->helper('slug');
				$slug = slug($_POST['catprodsName']);

				$info = array(					
					
					'directDirect' => $this->input->post('directDirect'),
				);

				if ($this->produk_model->update_directions($info, $id) === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{
					
					$this->breadcrumb->add('Product', 'adm_product');
					$this->breadcrumb->add('Edit Directions', 'adm_product/edit_directions');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}

			}
		}else{	

			$search = $this->produk_model->cari_directions($id);

			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->prodsId);

				$this->breadcrumb->add('Product', 'adm_product');
				$this->breadcrumb->add('Edit Directions', 'adm_product/edit_directions');

				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}

		}
	}*/

	/*public function edit_ingredients($id)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'product/form_product_ingredients',
			'form_action' 		=> 'admin/product/ingredients/edit/'.$id,
		);
		
		# Url untuk kembali		
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		
		$this->form_validation->set_rules('ingredValue', 'Deskripsi Bahan Produk', 'trim|required|xss_clean');
		

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('Product', 'adm_product');
				$this->breadcrumb->add('Edit Ingredients', 'adm_product/edit_ingredients');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {
				
				$info = array(					
					
					'ingredValue' => $this->input->post('ingredValue'),
				);

				if ($this->produk_model->update_ingredients($info, $id) === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{
					
					$this->breadcrumb->add('Product', 'adm_product');
					$this->breadcrumb->add('Edit Ingredients', 'adm_product/edit_ingredients');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}

			}
		}else{			

			$search = $this->produk_model->cari_ingredients($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->prodsId);

				$this->breadcrumb->add('Product', 'adm_product');
				$this->breadcrumb->add('Edit Ingredients', 'adm_product/edit_ingredients');

				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}*/

}

/* End of file Produk.php */
/* Location: ./application/modules/backend/controllers/Produk.php */