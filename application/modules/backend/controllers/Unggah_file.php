<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unggah_file extends Backend_Controller {

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
		
		$this->load->model('unggah_file_model', 'models');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Caption', 'Ekstensi', 'Ukuran', 'Tanggal', '');

		$unggah_file = $this->models->get_data_unggah_file();

		$no = 1;
		foreach ($unggah_file->result() as $value) {
			$id = $value->id;
			$nama = $value->caption;
			$this->table->add_row(
				$no, 
				$value->caption,
				$value->ekstensi_file,
				$value->ukuran_file,
				$value->tanggal,
				anchor("#myModal",'<i class="fa fa-chain"></i> Link', array('title'=>'Salin link ke text editor' , 'class'=>'btn btn-warning btn-xs', 'id'=>'custId', 'data-toggle'=>'modal', 'data-id'=>"$id",))." ".
				anchor("backend/unggah_file/edit/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Edit $nama" , 'class'=>'btn btn-dark btn-xs'))." ".
				anchor("backend/unggah_file/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Delete $nama" , 'class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
	
		core::buat_tabel();

		$data = array(
			'table' => $this->table->generate(),
			'main_view' => 'unggah_file/list_unggah_file', 
		);

		$this->load->view('include/box_template', $data);
	}

	public function check_unggah_file($str)
    {
        $allowed_mime_type_arr = array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/x-zip', 'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword');
        $mime = get_mime_by_extension($_FILES['nama_file']['name']);
        if(isset($_FILES['nama_file']['name']) && $_FILES['nama_file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('check_unggah_file', 'Silahkan pilih hanya file pdf / doc/ docx / xls/ xlsx.');
                return false;
            }
        }else{
            $this->form_validation->set_message('check_unggah_file', 'Silakan pilih file yang akan diunggah.');
            return false;
        }
    }

	public function add(){
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'unggah_file/form_add_unggah_file',
			'form_action' 	=> 'backend/unggah_file/add',
		);

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_file', 'File dokumen', 'trim|callback_check_unggah_file');
		
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/box_template', $this->data);

			} else {

				# UPLOAD caption
				$unggah_file = $_FILES['nama_file']['name'];

				if ($unggah_file !="") {

					$config['upload_path']     	= './assets/unggah/file/';
				    $config['allowed_types']   	= 'pdf|xls|xlsx|doc|docx';
				    $config['detect_mime']		= TRUE;
				    $config['max_size']        	= 20000;
				    $nama_file 					= strtolower($this->input->post('caption'));
					$config['file_name'] 		= $nama_file."_".time();

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('nama_file')){
						print_r($this->upload->display_errors());

						$this->data['pesan_error'] = 'Terjadi kesalahan input file';
						$this->load->view('include/box_template', $this->data);

					}else{

						$file = $this->upload->data();						
					
					}
				}
				

				$input = $this->input->post(null, TRUE);

				$nama_file = $file['file_name'];
				$tipe_file = $file['file_type'];
				$ukuran_file = $file['file_size'];
				$ekstensi_file = $file['file_ext'];

				$insert = $this->models->simpan_unggah_file($input, $nama_file, $ekstensi_file, $tipe_file, $ukuran_file);
				
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
			'main_view' 	=> 'unggah_file/form_edit_unggah_file',
			'form_action' 	=> "backend/unggah_file/edit/$id",
		);

		$this->data['unggah_file_id'] = $id;

		$this->form_validation->set_rules('caption', 'Caption', 'trim|required|xss_clean');

		if ($this->input->post('nama_file')) {
			$this->form_validation->set_rules('nama_file', 'File caption', 'callback_check_unggah_file');
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/box_template', $this->data);

			} else {


				if ($_FILES['nama_file']['name'] != NULL) {

					$hapus_unggah_file = $this->models->cari_unggah_file($id);
					$temp_unggah_file 	= $hapus_unggah_file->nama_file;

					# Menghapus file
					if ($temp_unggah_file) {
						unlink('./assets/unggah/file/'.$temp_unggah_file);
					}
					

					# UPLOAD
					$unggah_file = $_FILES['nama_file']['name'];

					if ($unggah_file !="") {

						$config['upload_path']     	= './assets/unggah/file/';
					    $config['allowed_types']   	= 'pdf|xls|xlsx|doc|docx';
					    $config['detect_mime']		= TRUE;
					    $config['max_size']        	= 20000;
					    $nama_file 					= strtolower($this->input->post('caption'));
						$config['file_name'] 		= $nama_file."_".time();

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('nama_file')){
							print_r($this->upload->display_errors());

							$this->data['pesan_error'] = 'Terjadi kesalahan input file';
							$this->load->view('include/box_template', $this->data);

						}else{

							$file = $this->upload->data();						
						
						}

						$data = array(
				    		'nama_file' => $file['file_name'],
				    		'nama_file' => $file['file_name'],
							'tipe_file' => $file['file_type'],
							'ukuran_file' => $file['file_size'],
							'ekstensi_file' => $file['file_ext']
				    	);

				        $this->db->where('id', $id);
				        $query = $this->db->update('unggah_file', $data);
					}
				}

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_unggah_file($id, $input);
				
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
			$search = $this->models->cari_unggah_file($id);
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

			$hapus_unggah_file = $this->models->cari_unggah_file($id);
			
			$temp_unggah_file 	= $hapus_unggah_file->nama_file;

			if ($this->models->hapus_unggah_file($id) === TRUE) {

				# Menghapus gambar unggah_file
				unlink('./assets/unggah/file/'.$temp_unggah_file);
	
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
            'konten'		=> $this->models->cari_unggah_file($id),
        );
		
		$this->load->view('unggah_file/detail_unggah_file', $data);
	}

}

/* End of file Unggah_file.php */
/* Location: ./application/modules/backend/controllers/Unggah_file.php */