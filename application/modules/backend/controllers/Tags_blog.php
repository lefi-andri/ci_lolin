<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags_blog extends Backend_Controller {

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
		
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//set model
		$this->load->model('tags_blog_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Tags Blog');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Tag', '');

		$tags = $this->models->get_data_tags_blog();

		$no = 1;
		foreach ($tags->result() as $value) {
			$id = $value->id;
			$nama = $value->nama_tag;
			$this->table->add_row(
				$no, 
				$value->nama_tag,
				anchor("backend/tags_blog/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/tags_blog/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}

		$template = array(
	        'table_open'            => '<table id="dt-opt" class="table table-lg table-hover">',
	        'thead_open'            => '<thead>',
	        'thead_close'           => '</thead>',
	        'heading_row_start'     => '<tr>',
	        'heading_row_end'       => '</tr>',
	        'heading_cell_start'    => '<th>',
	        'heading_cell_end'      => '</th>',
	        'tbody_open'            => '<tbody>',
	        'tbody_close'           => '</tbody>',
	        'row_start'             => '<tr>',
	        'row_end'               => '</tr>',
	        'cell_start'            => '<td>',
	        'cell_end'              => '</td>',
	        'row_alt_start'         => '<tr>',
	        'row_alt_end'           => '</tr>',
	        'cell_alt_start'        => '<td>',
	        'cell_alt_end'          => '</td>',
	        'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$data = array(
			'label'	=> 'Tags Blog',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('tags_blog/list_tags', $data);


		/*$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Tag', '');

		$tags = $this->models->get_data_tags_blog();

		$no = 1;
		foreach ($tags->result() as $value) {
			$id = $value->id;
			$nama = $value->nama_tag;
			$this->table->add_row(
				$no, 
				$value->nama_tag,
				anchor("backend/tags_blog/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/tags_blog/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'tags_blog/list_tags', 
		);

		$this->load->view('include/template', $data);*/
	}

	public function add(){
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
			'label'			=> 'Tambah Tags Blog',
			'form_action' 	=> 'backend/tags_blog/add'
		);

		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'tags_blog/form_add_tags',
			'form_action' 	=> 'backend/tags_blog/add'
		);*/

		$this->form_validation->set_rules('nama_tag', 'Nama Kategori', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//$this->load->view('include/template', $this->data);
				//set view
				$this->stencil->paint('tags_blog/form_add_tags',$this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_tags($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//$this->load->view('include/template', $this->data);
					//set view
					$this->stencil->paint('tags_blog/form_add_tags',$this->data);
				}

			}

		}else{
			//$this->load->view('include/template', $this->data);
			//set view
			$this->stencil->paint('tags_blog/form_add_tags',$this->data);
		}
	}

	public function edit($id = NULL){
		//set title
		$this->stencil->title('Edit Kategori Blog');
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
			'label'			=> "Edit Tags Blog",
			'form_action' 	=> "backend/tags_blog/edit/$id"
		);

		/*$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'tags_blog/form_add_tags',
			'form_action' 	=> "backend/tags_blog/edit/$id"
		);*/

		$this->form_validation->set_rules('nama_tag', 'Nama Kategori', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//$this->load->view('include/template', $this->data);
				//set view
				$this->stencil->paint('tags_blog/form_add_tags',$this->data);

			} else {

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_tags($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//$this->load->view('include/template', $this->data);
					//set view
					$this->stencil->paint('tags_blog/form_add_tags',$this->data);
				}

			}

		}else{
			$search = $this->models->cari_tags($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				//$this->load->view('include/template', $this->data);
				//set view
				$this->stencil->paint('tags_blog/form_add_tags',$this->data);
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
			if ($this->models->hapus_tags($id) === TRUE) {
	
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

/* End of file Tags_blog.php */
/* Location: ./application/modules/backend/controllers/Tags_blog.php */