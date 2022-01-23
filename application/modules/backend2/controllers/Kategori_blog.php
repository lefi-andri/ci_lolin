<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_blog extends Backend_Controller {

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
		$this->load->model('kategori_blog_model', 'models');
	}

	public function index()
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

		$this->load->library('table');

		$this->table->set_heading('No', 'Kategori', 'Perbolehkan Tampil', '');

		$kategori = $this->models->get_data_kategori_blog();

		$no = 1;
		foreach ($kategori->result() as $value) {
			$id = $value->id;
			$nama = $value->nama_kategori;
			$this->table->add_row(
				$no, 
				$value->nama_kategori,
				($value->perbolehkan_tampil == '1') ? 'Ya' : 'Tidak',
				anchor("backend/kategori_blog/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-default'))." ".
				anchor("backend/kategori_blog/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-default', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::create_table();

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$data = array(
			'label'	=> 'Kategori Blog',
			'table' => $this->table->generate(),
		);

		//set view
		$this->stencil->paint('kategori_blog/list_kategori_blog',$data);
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
			'label'			=> 'Tambah Kategori Blog',
			'form_action' 	=> 'backend/kategori_blog/add'
		);

		//set validation
		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Kategori Ditampilkan', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);

			} else {

				$input = $this->input->post(null, TRUE);

				$insert = $this->models->simpan_kategori($input);
				
				if ($insert === TRUE) {
					$this->session->set_flashdata('message_success', 'Update Success.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);
				}

			}

		}else{
			//set view
			$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);
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
			'label'			=> "Edit Kategori Blog",
			'form_action' 	=> "backend/kategori_blog/edit/$id"
		);

		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|xss_clean');
		$this->form_validation->set_rules('perbolehkan_tampil', 'Kategori Ditampilkan', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				//set view
				$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);

			} else {

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_kategori($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil update data user.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					//set view
					$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);
				}
			}
		}else{
			$search = $this->models->cari_kategori($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->id);

				//set view
				$this->stencil->paint('kategori_blog/form_add_kategori',$this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Data tidak ditemukan.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

	public function delete($id = NULL){
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Data tidak ditemukan.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		} else {
			if ($this->models->hapus_kategori($id) === TRUE) {
	
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

/* End of file Kategori_blog.php */
/* Location: ./application/modules/backend/controllers/Kategori_blog.php */