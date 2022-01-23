<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_events extends Backend_Controller {

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
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//load model
		$this->load->model('events_model');

	}

	public function index()
	{
		//set title
		$this->stencil->title('Event');
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
			'label'	=> 'Event',
		);

		//set view
		$this->stencil->paint('events/list_events',$data);
	}

	public function grab_data_events()
	{
		$draw						= $_REQUEST['draw'];		
		$length						= $_REQUEST['length'];
		$start						= $_REQUEST['start'];
		$search						= $_REQUEST['search']["value"];
		$total 						= $this->db->count_all_results('events');
		$output 					= array();
		$output['draw'] 			= $draw;
		$output['recordsTotal']		= $output['recordsFiltered'] = $total;
		$output['data']				= array();

		if($search!="")
		{
			$this->db->like('eventsName', $search);
		}
		
		$this->db->limit($length, $start);		
		$this->db->order_by('eventsId', 'ASC');
		$query = $this->db->get('events')->result_array();
		
		if($search!="")
		{
			$this->db->like('eventsName', $search);

			$jum = $this->db->get('events');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}

		$nomor_urut = $start+1;
		foreach ($query as $hasil) {
						
			$id 	= md5($hasil['eventsId']);
			$nama 	= $hasil['eventsName'];

			$output['data'][]=array(
				$nomor_urut,
				"<img src='".base_url()."assets/images/events/small_".$hasil['eventsPic']."' />",
				$hasil['eventsName'],
				$hasil['eventsDate'],
				$hasil['eventsVenue'],
				($hasil['eventsShow'] == 'y') ? 'Ya' : 'Tidak',
				$hasil['eventsSort'],
				anchor("admin/event/picture/add/$id",'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambahkan Gambar', array('title'=>'judul' , 'class'=>'btn btn-warning btn-xs'))." ".		
				anchor("admin/event/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=> "Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("admin/event/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))				
			);
		$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function add_events()
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'events/form_add_events',
			'form_action' 		=> 'admin/event/add',			
		);

		# URLBACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;*/
		
		//set title
		$this->stencil->title('Tambah Event');
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
			'label'			=> 'Tambah Event',
			'form_action' 		=> 'admin/event/add',
		);

		//set validation
		$this->form_validation->set_rules('eventsName', 'Nama Event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('eventsDesc', 'Deskripsi Event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('eventsDate', 'Tanggal Event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('eventsVenue', 'Tempat Event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('file', '', 'callback_file_check');
		$this->form_validation->set_rules('eventsSort', 'Urutan Event', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('eventsShow', 'Tampilkan Event', 'trim|required|xss_clean');	
		
		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('client', 'adm_client');
				$this->breadcrumb->add('add client', 'adm_client/add_client');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('events/form_add_events',$this->data);
			} else {

				# UPLOAD
				$config['upload_path']     	= './assets/images/events/';
			    $config['allowed_types']   	= 'gif|jpg|png';	    
			    $config['detect_mime']		= TRUE;
			    $config['max_size']        	= 20000;
			    $nmfile 					= $this->input->post('eventsName');
			    $time 						= time();		    
				$config['file_name'] 		= $nmfile."_".$time;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')){
					print_r($this->upload->display_errors());
					$this->breadcrumb->add('client', 'adm_client');
					$this->breadcrumb->add('add client', 'adm_client/add_client');

					$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
					//set view
					$this->stencil->paint('events/form_add_events',$this->data);

				}else{

					$images = $this->upload->data();
					//MEMBUAT UKURAN SMALL				
		            $this->image_lib->initialize(array(
		                'image_library' 	=> 'gd2',
		                'source_image' 		=> './assets/images/events/'. $images['file_name'],
		                'maintain_ratio' 	=> FALSE,
		                'create_thumb' 		=> FALSE,
		                'width' 			=> 40,
		                'height' 			=> 40,
		                'new_image' 		=> './assets/images/events/small_'. $images['file_name'],
		            ));                
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					//MEMBUAT UKURAN MIDDLE
					$this->image_lib->initialize(array(
		                'image_library' 	=> 'gd2',
		                'source_image' 		=> './assets/images/events/'. $images['file_name'],
		                'maintain_ratio' 	=> FALSE,
		                'create_thumb' 		=> FALSE,
		                'width' 			=> 420,
		                'height' 			=> 280,
		                'new_image' 		=> './assets/images/events/middle_'. $images['file_name'],
		            ));
		            $this->load->library('image_lib', $config);
					$this->image_lib->resize();

					//MEMBUAT UKURAN LARGE
					$this->image_lib->initialize(array(
		                'image_library' 	=> 'gd2',
		                'source_image' 		=> './assets/images/events/'. $images['file_name'],
		                'maintain_ratio' 	=> FALSE,
		                'create_thumb' 		=> FALSE,
		                'width' 			=> 1000,
		                'height' 			=> 667,
		                'new_image' 		=> './assets/images/events/large_'. $images['file_name'],
		            ));
		            $this->load->library('image_lib', $config);
					$this->image_lib->resize();

				$this->load->helper('slug');
				$slug = slug($_POST['eventsName']);
							
				$info = array(
					'eventsName' 		=> $this->input->post('eventsName'),
					'eventsDesc' 		=> $this->input->post('eventsDesc'),
					'eventsSlug' 		=> $slug,
					'eventsDate' 		=> $this->input->post('eventsDate'),												
					'eventsVenue' 		=> $this->input->post('eventsVenue'),
					'eventsPic' 		=> $images['file_name'],					
					'eventsSort' 		=> $this->input->post('eventsSort'),
					'eventsShow' 		=> $this->input->post('eventsShow'),
				);				

				if ($this->events_model->simpan_events($info) === TRUE) {					

					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{
					
					$this->breadcrumb->add('client', 'adm_client');
					$this->breadcrumb->add('add client', 'adm_client/add_client');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					//set view
					$this->stencil->paint('events/form_add_events',$this->data);
				}}

			}
		}else{
			
			$this->breadcrumb->add('Event', 'adm_events');
			$this->breadcrumb->add('Tambah Event', 'adm_events/add_events');

			//set view
			$this->stencil->paint('events/form_add_events',$this->data);
		}
	}

	public function looks()
	{
		$data['id'] = $_POST['rowid'];
		$this->db->where('eventsId', $_POST['rowid']);
		$data['client'] =  $this->db->get('client');
		$this->load->view('backend/events/events_looks', $data);		
	}
	
	/*
     * file value and type check during validation
     */
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

	public function edit_events($id)
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'events/form_edit_events',
			'form_action' 		=> "admin/event/edit/$id",
			
		);*/

		//set title
		$this->stencil->title('Edit Event');
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
			'label'			=> "Edit Event",
			'form_action' 		=> "admin/event/edit/$id",
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{
			/* Merubah Sampek Sini */
			if (isset($_POST['submit'])) {

				$filename = $_FILES['file']['name'];
				if ($filename !="") {
					//JIKA ADA GAMBAR UNTUK DI UPLOAD
				
					$this->form_validation->set_rules('eventsName', 'Nama Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsDesc', 'Deskripsi Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsDate', 'Tanggal Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsVenue', 'Tempat Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsSort', 'Urutan Event', 'trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('eventsShow', 'Tampilkan Event', 'trim|required|xss_clean');				

					if ($this->form_validation->run() == FALSE) {

					$this->breadcrumb->add('events', 'adm_events');
					$this->breadcrumb->add('edit events', 'adm_events/edit_events');

					$this->data['pesan_error'] = 'Terjadi kesalahan pengisian ';
					//set view
					$this->stencil->paint('events/form_edit_events',$this->data);

					} else {

						$removeImages = $this->events_model->cariImage($id)->row();
						unlink('./assets/images/events/'.$removeImages->eventsPic);
						unlink('./assets/images/events/small_'.$removeImages->eventsPic);
						unlink('./assets/images/events/middle_'.$removeImages->eventsPic);
						unlink('./assets/images/events/large_'.$removeImages->eventsPic);
						
						
						$config['upload_path']     	= './assets/images/events';
					    $config['allowed_types']   	= 'gif|jpg|png';	    
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nmfile 					= $_POST['eventsName'];
					    $time 						= time();		    
						$config['file_name'] 		= $nmfile."_".$time;

						$this->load->library('upload', $config);

						if (!$this->upload->do_upload('file')){

						$this->breadcrumb->add('events', 'adm_events');
						$this->breadcrumb->add('edit events', 'adm_events/edit_events');

						$this->data['pesan_error'] = 'Terjadi kesalahan input ';
						//set view
						$this->stencil->paint('events/form_edit_events',$this->data);

						}else{

							$images = $this->upload->data();
							//MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/events/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN MIDDLE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 420,
				                'height' 			=> 280,
				                'new_image' 		=> './assets/images/events/middle_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();

							//MEMBUAT UKURAN LARGE
							$this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 1000,
				                'height' 			=> 667,
				                'new_image' 		=> './assets/images/events/large_'. $images['file_name'],
				            ));
				            $this->load->library('image_lib', $config);
							$this->image_lib->resize();

						$this->load->helper('slug');
						$slug = slug($_POST['eventsName']);

						$info = array(							
							'eventsName' 	=> $this->input->post('eventsName'),
							'eventsDesc' 	=> $this->input->post('eventsDesc'),
							'eventsSlug' 	=> $slug,
							'eventsDate' 	=> $this->input->post('eventsDate'),												
							'eventsVenue' 	=> $this->input->post('eventsVenue'),
							'eventsPic' 	=> $images['file_name'],					
							'eventsSort' 	=> $this->input->post('eventsSort'),
							'eventsShow' 	=> $this->input->post('eventsShow'),
						);
				
						$id = $this->session->userdata('id_sekarang');

						if ($this->events_model->update_events($info, $id) === TRUE) {
							                                                	                 
							$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
							$url = $this->session->userdata('lolin_urlback_backend');
							redirect($url);
						}else{

							$this->breadcrumb->add('events', 'adm_events');
							$this->breadcrumb->add('edit events', 'adm_events/edit_events');

							$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
							//set view
							$this->stencil->paint('events/form_edit_events',$this->data);
						}
					}

				}


				}else{
					//JIKA TIDAK ADA GAMBAR UNTUK DI UPLOAD

					$this->form_validation->set_rules('eventsName', 'Nama Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsDesc', 'Deskripsi Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsDate', 'Tanggal Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsVenue', 'Tempat Event', 'trim|required|xss_clean');
					$this->form_validation->set_rules('eventsSort', 'Urutan Event', 'trim|required|numeric|xss_clean');
					$this->form_validation->set_rules('eventsShow', 'Tampilkan Event', 'trim|required|xss_clean');
					

					if ($this->form_validation->run() == FALSE) {

					$this->breadcrumb->add('events', 'adm_events');
					$this->breadcrumb->add('edit events', 'adm_events/edit_events');

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					//set view
					$this->stencil->paint('events/form_edit_events',$this->data);
					} else {												

						$this->load->helper('slug');
						$slug = slug($_POST['eventsName']);

						$info = array(						
							'eventsName' 	=> $this->input->post('eventsName'),
							'eventsDesc' 	=> $this->input->post('eventsDesc'),
							'eventsSlug' 	=> $slug,
							'eventsDate' 	=> $this->input->post('eventsDate'),												
							'eventsVenue' 	=> $this->input->post('eventsVenue'),					
							'eventsSort' 	=> $this->input->post('eventsSort'),
							'eventsShow' 	=> $this->input->post('eventsShow'),
						);
						

						$id = $this->session->userdata('id_sekarang');

						if ($this->events_model->update_events($info, $id) === TRUE) {
							                                                	                 
							$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
							$url = $this->session->userdata('lolin_urlback_backend');
							redirect($url);
						}else{

							$this->breadcrumb->add('events', 'adm_events');
							$this->breadcrumb->add('edit events', 'adm_events/edit_events');

							$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
							//set view
							$this->stencil->paint('events/form_edit_events',$this->data);
						}
					}

				}


			}else{
				$search = $this->events_model->cari_events($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->eventsId);

					$this->breadcrumb->add('events', 'adm_events');
					$this->breadcrumb->add('edit events', 'adm_events/edit_events');
					
					//set view
					$this->stencil->paint('events/form_edit_events',$this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}
			/* Merubah Sampek Sini */
			
		}
	}

	public function delete_events($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$removeImages = $this->events_model->cariImage($id)->row();
			$tempImages 	= $removeImages->eventsPic;
			

			if ($this->events_model->hapus_events($id) === TRUE) {
				unlink('./assets/images/events/'.$tempImages);
				unlink('./assets/images/events/small_'.$tempImages);
				unlink('./assets/images/events/middle_'.$tempImages);
				unlink('./assets/images/events/large_'.$tempImages);

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


	# ========================================= UPLOAD EVENT PICTURE ========================================

	# TAMPIL LIST FOTO
	public function add_picture($id)
	{
		$search = $this->events_model->cari_events($id);

		if ($search) {
			$this->load->library('breadcrumb');

			$this->breadcrumb->add('Event', 'adm_event');
			$this->breadcrumb->add('Event Pictures', 'adm_event/add_picture');

			$this->load->library('table');

			$template = array(
	        	'table_open' => '<table class="table table-hover">'
			);

			$this->table->set_template($template);

			$this->table->set_heading('No', 'Foto', 'Caption', 'Foto Ditampilkan','Urutan','','');

			$collection = $this->db->get_where('eventspic',['md5(eventsId)'=>$id]);

			$no = 1;
			foreach ($collection->result() as $value) {

				$eventsPicId 	= md5($value->eventsPicId);
				$eventsPicName 	= $value->eventsPicName;

				$this->table->add_row(
					$no,
					"<img src='".base_url()."assets/images/events_picture/small_$value->eventsPicImage' />",
					$eventsPicName,
					($value->eventsPicShow == '1') ? 'Ya' : 'Tidak',
					$value->eventsPicSort,
					anchor("admin/event/picture/edit/files/$eventsPicId", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $eventsPicName" , 'class'=>'btn btn-dark btn-xs'))." ".
					anchor("admin/event/picture/delete/files/$eventsPicId", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $eventsPicName" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $eventsPicName ?')"))
				);
			$no++;
			}						

			
			# URL BACK
			$url = $this->uri->uri_string();
			$this->session->set_userdata('lolin_urlback_backend', $url);

			//set title
			$this->stencil->title('Tambah Gambar Event');
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
				'label'			=> "Tambah Gambar Event",
				'eventsId' 		=> $id,
				'table' 		=> $this->table->generate(),
			);

			//set view
			$this->stencil->paint('events/list_events_picture',$this->data);

		}else{
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}
	}

	# MENAMBAHKAN FOTO KE ALBUM
	public function add_event_picture($id)
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'events/form_events_picture_add',
			'form_action' 	=> 'admin/event/picture/add/files/'.$id,
		);

		# URLBACK
		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;
		*/

		//set title
		$this->stencil->title('Tambah Gambar Event');
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
			'label'			=> 'Tambah Gambar Event',
			'form_action' 	=> "admin/event/picture/add/files/$id",
		);

		//set validation
		$this->form_validation->set_rules('userfiles[]', 'File Gambar', 'trim|xss_clean');
		$this->form_validation->set_rules('caption_userfiles[]', 'Caption Gambar', 'trim|xss_clean');
		$this->form_validation->set_rules('event_pic_sort[]', 'Pengurutan Gambar', 'trim|xss_clean');
		
		if (isset($_POST['submit'])) {
			
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('Product Kategori', 'adm_product');
				$this->breadcrumb->add('Tambah Product Kategori', 'adm_product/add_kategori');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('events/form_events_picture_add',$this->data);
			} else {	

				# UPLOAD FILES
				$number_of_files 	= sizeof($_FILES['userfiles']['tmp_name']);  
				$files 				= $_FILES['userfiles'];

				$config=array(  
					'upload_path' 		=> './assets/images/events_picture/', //direktori untuk menyimpan gambar  
					'allowed_types' 	=> 'jpg|jpeg|png|gif',  
					'max_size' 			=> '2000',  
					'max_width' 		=> '2000',  
					'max_height' 		=> '2000' 
				); 
				$sort = 0;
				for ($i = 0;$i < $number_of_files; $i++){  

					$sort++;

					$_FILES['userfile']['name'] 		= time()."_".str_replace(" ", "_", $files['name'][$i]);  
					$_FILES['userfile']['type'] 		= $files['type'][$i];  
					$_FILES['userfile']['tmp_name'] 	= $files['tmp_name'][$i];  
					$_FILES['userfile']['error'] 		= $files['error'][$i];  
					$_FILES['userfile']['size'] 		= $files['size'][$i];

					$caption_userfiles 					= $_POST['caption_userfiles'][$i];
					$event_pic_sort 					= $_POST['event_pic_sort'][$i];

					$this->load->library('upload', $config); 

					$images = $this->upload->data();

					$id = $this->session->userdata('id_sekarang');

					$data = array( 
						'eventsId'				=> $id,    
						'eventsPicName'			=> $caption_userfiles,  		
						'eventsPicImage'		=> $_FILES['userfile']['name'],
						'eventsPicSort'			=> $event_pic_sort,
						'eventsPicShow'			=> "1",
					);

					$this->events_model->insertEventPicture($data);

	                if ($this->upload->do_upload('userfile')){

	                	$imagesgallery = $this->upload->data();
						//MEMBUAT UKURAN SMALL				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/events_picture/'. $imagesgallery['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 40,
			                'height' 			=> 40,
			                'new_image' 		=> './assets/images/events_picture/small_'. $imagesgallery['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN MIDDLE				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/events_picture/'. $imagesgallery['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 420,
			                'height' 			=> 280,
			                'new_image' 		=> './assets/images/events_picture/middle_'. $imagesgallery['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						//MEMBUAT UKURAN LARGE				
			            $this->image_lib->initialize(array(
			                'image_library' 	=> 'gd2',
			                'source_image' 		=> './assets/images/events_picture/'. $imagesgallery['file_name'],
			                'maintain_ratio' 	=> FALSE,
			                'create_thumb' 		=> FALSE,
			                'width' 			=> 1000,
			                'height' 			=> 667,
			                'new_image' 		=> './assets/images/events_picture/large_'. $imagesgallery['file_name'],
			            ));                
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

	                }
				}

					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
			}

		}else{
		
			$search = $this->events_model->cari_events($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->eventsId);

					$this->breadcrumb->add('testimonial', 'adm_testimonial');
					$this->breadcrumb->add('edit events', 'adm_testimonial/edit_testimonial');
					
					//set view
					$this->stencil->paint('events/form_events_picture_add',$this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}


		}

	}

	public function file_check_events_pic($str)
    {
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['eventsPicImage']['name']);
        if(isset($_FILES['eventsPicImage']['name']) && $_FILES['eventsPicImage']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_events_pic', 'Silahkan pilih hanya file jpg / png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_events_pic', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function edit_picture($id)
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'events/form_events_picture_edit',
			'form_action' 		=> 'admin/event/picture/edit/files/'.$id
		);
	*/
		//set title
		$this->stencil->title('Edit Gambar Event');
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
			'label'			=> "Edit Gambar Event",
			'form_action' 		=> "admin/event/picture/edit/files/$id"
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('eventsPicName', 'Caption', 'trim|required|xss_clean');
				$this->form_validation->set_rules('eventsPicSort', 'Pengurutan Gambar', 'trim|required|numeric|xss_clean');
				$this->form_validation->set_rules('eventsPicShow', 'Tampilkan Gambar', 'trim|required|xss_clean');			

				if ($this->form_validation->run() == FALSE) {

					$this->breadcrumb->add('Product Kategori', 'adm_product');
					$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					//set view
					$this->stencil->paint('events/form_events_picture_edit',$this->data);
				} else {

					# KATEGORI UPLOAD		
					$filename = $_FILES['eventsPicImage']['name'];//time()."_".str_replace(" ", "_", $_FILES['eventsPicImage']['name']);//

					if ($filename !="") {

						$removeImages = $this->events_model->cariImageEvent($id);
			
						# Menghapus gambar
						unlink('./assets/images/events_picture/'.$removeImages->eventsPicImage);
						unlink('./assets/images/events_picture/small_'.$removeImages->eventsPicImage);
						unlink('./assets/images/events_picture/middle_'.$removeImages->eventsPicImage);
						unlink('./assets/images/events_picture/large_'.$removeImages->eventsPicImage);

						$config_headline['upload_path']     	= './assets/images/events_picture/';
					    $config_headline['allowed_types']   	= 'gif|jpg|png';	    
					    $config_headline['detect_mime']			= TRUE;
					    $config_headline['max_size']        	= 20000;	    
						$config_headline['file_name'] 			= time()."_".str_replace(" ", "_", $_FILES['eventsPicImage']['name']);

						$this->load->library('upload', $config_headline);
						$this->upload->initialize($config_headline);

						if (!$this->upload->do_upload('eventsPicImage')){
							print_r($this->upload->display_errors());
							$this->breadcrumb->add('News', 'adm_klien');
							$this->breadcrumb->add('Tambah News', 'adm_klien/add_klien');

							$this->data['pesan_error'] = 'Terjadi kesalahan input gambar';
							//set view
							$this->stencil->paint('events/form_events_picture_edit',$this->data);

						}else{

							$images = $this->upload->data();

							#MEMBUAT UKURAN SMALL				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events_picture/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/events_picture/small_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							#MEMBUAT UKURAN MIDDLE				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events_picture/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/events_picture/middle_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

							#MEMBUAT UKURAN LARGE				
				            $this->image_lib->initialize(array(
				                'image_library' 	=> 'gd2',
				                'source_image' 		=> './assets/images/events_picture/'. $images['file_name'],
				                'maintain_ratio' 	=> FALSE,
				                'create_thumb' 		=> FALSE,
				                'width' 			=> 40,
				                'height' 			=> 40,
				                'new_image' 		=> './assets/images/events_picture/large_'. $images['file_name'],
				            ));                
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();

						}

						$info = array(					
							'eventsPicName' 				=> $this->input->post('eventsPicName'),
							'eventsPicImage'				=> $images['file_name'],
							'eventsPicSort' 				=> $this->input->post('eventsPicSort'),
							'eventsPicShow' 				=> $this->input->post('eventsPicShow'),
						);

					}else{

						# JIKA TIDAK ADA GAMBAR UNTUK DIUPLOAD

						$info = array(					
							'eventsPicName' 				=> $this->input->post('eventsPicName'),
							'eventsPicSort' 				=> $this->input->post('eventsPicSort'),
							'eventsPicShow' 				=> $this->input->post('eventsPicShow'),
						);

					}
					
					$id = $this->session->userdata('id_sekarang');

					if ($this->events_model->update_events_picture($info, $id) === TRUE) {
						$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);
					}else{

						$this->breadcrumb->add('Product Kategori', 'adm_product');
						$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

						$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
						//set view
						$this->stencil->paint('events/form_events_picture_edit',$this->data);
					}
					
				}
			}else{
				$search = $this->events_model->cariImageEvent($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->eventsPicId);

					$this->breadcrumb->add('Product Kategori', 'adm_product');
					$this->breadcrumb->add('Edit Product Kategori', 'adm_product/edit_kategori');

					//set view
					$this->stencil->paint('events/form_events_picture_edit',$this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}	
		}
	}

	public function delete_picture($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$removeImages = $this->events_model->cariImageEvent($id);
			unlink('./assets/images/events_picture/'.$removeImages->eventsPicImage);
			unlink('./assets/images/events_picture/small_'.$removeImages->eventsPicImage);
			unlink('./assets/images/events_picture/middle_'.$removeImages->eventsPicImage);
			unlink('./assets/images/events_picture/large_'.$removeImages->eventsPicImage);

			if ($this->events_model->hapus_event_picture($id) === TRUE) {
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

/* End of file Adm_events.php */
/* Location: ./application/modules/backend/controllers/Adm_events.php */