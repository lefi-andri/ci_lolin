<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_socialmedia extends Backend_Controller {

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
		
		$this->load->library('image_lib');
		$this->load->helper('file');

		// setting ck editor
		$this->load->library(array('CKEditor', 'CKFinder'));		
		$width = '100%';
        $height = '500px';
        $this->editor($width,$height);

        //set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//load model
		$this->load->model('socialmedia_model');

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
		//set title
		$this->stencil->title('Social Media');
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
			'label'	=> 'Social Media',
		);

		//set view
		$this->stencil->paint('socialmedia/list_socialmedia',$data);
	}

	function grab_data_socialmedia()
	{
		$draw						= $_REQUEST['draw'];		
		$length						= $_REQUEST['length'];
		$start						= $_REQUEST['start'];
		$search						= $_REQUEST['search']["value"];
		$total 						= $this->db->count_all_results('socialmedia');
		$output 					= array();
		$output['draw'] 			= $draw;
		$output['recordsTotal']		= $output['recordsFiltered'] = $total;
		$output['data']				= array();

		if($search!="")
		{
			$this->db->like('socialName', $search)
					->or_like('socialRemark', $search);
		}
		
		$this->db->limit($length, $start);		
		$this->db->order_by('socialId', 'ASC');
		$query = $this->db->get('socialmedia')->result_array();
		
		if($search!="")
		{
			$this->db->like('socialName', $search)
					->or_like('socialRemark', $search);

			$jum = $this->db->get('socialmedia');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}

		$nomor_urut = $start+1;
		foreach ($query as $hasil) {
						
			$id 	= md5($hasil['socialId']);
			$name 	= $hasil['socialName'];

			$output['data'][]=array(
				$nomor_urut,
				$hasil['socialName'],
				$hasil['socialValue'],
				($hasil['socialStatus'] == 'y') ? 'Ya' : 'Tidak',
				anchor("admin/socialmedia/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $name" , 'class'=>'btn btn-dark btn-xs')),				
			);
		$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function edit_socialmedia($id)
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'socialmedia/form_socialmedia',
			'form_action' 	=> 'admin/socialmedia/edit/'.$id
		);*/

		//set title
		$this->stencil->title('Tambah Kategori Blog');
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
			'label'			=> 'Tambah Kategori Blog',
			'form_action' 	=> "admin/socialmedia/edit/$id",
		);

		//set validation
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('socialType', 'Type Sosial Media', 'trim|required|xss_clean');
				$this->form_validation->set_rules('socialName', 'Sosial Media Nama', 'trim|required|xss_clean');
				$this->form_validation->set_rules('socialRemark', 'Sosial Media Remark', 'trim|required|xss_clean');
				$this->form_validation->set_rules('socialValue', 'Sosial Media Value', 'trim|required|xss_clean');
				$this->form_validation->set_rules('socialStatus', 'Sosial Media Status', 'trim|required|xss_clean');

				if ($this->form_validation->run() == FALSE) {

					$this->breadcrumb->add('Social Media', 'adm_socialmedia');
					$this->breadcrumb->add('Edit Social Media', 'adm_socialmedia/edit_socialmedia');

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					//set view
					$this->stencil->paint('socialmedia/form_socialmedia',$this->data);
				} else {					

					$info = array(					
						'socialType' 		=> $this->input->post('socialType'),						
						'socialName' 		=> $this->input->post('socialName'),
						'socialRemark' 		=> $this->input->post('socialRemark'),
						'socialValue' 		=> $this->input->post('socialValue'),
						'socialStatus' 		=> $this->input->post('socialStatus'),
					);

					$id = $this->session->userdata('id_sekarang');

					if ($this->socialmedia_model->update_socialmedia($info, $id) === TRUE) {
						$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);
					}else{

						$this->breadcrumb->add('Social Media', 'adm_socialmedia');
						$this->breadcrumb->add('Edit Social Media', 'adm_socialmedia/edit_socialmedia');

						$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
						//set view
						$this->stencil->paint('socialmedia/form_socialmedia',$this->data);
					}
				}
			}else{
				$search = $this->socialmedia_model->cari_socialmedia($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->socialId);

					$this->breadcrumb->add('Social Media', 'adm_socialmedia');
					$this->breadcrumb->add('Edit Social Media', 'adm_socialmedia/edit_socialmedia');

					//set view
					$this->stencil->paint('socialmedia/form_socialmedia',$this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}


}

/* End of file Adm_socialmedia.php */
/* Location: ./application/modules/backend/controllers/Adm_socialmedia.php */