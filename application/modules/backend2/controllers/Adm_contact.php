<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_contact extends Backend_Controller {

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
		
		// load model
		$this->load->model('contact_model');
	}

	public function index()
	{		
        $this->load->library('breadcrumb');
		$this->breadcrumb->add('Shop', 'adm_contact');		

		/**
		* @ Url untuk kembali		
		*/
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$data = array(
			'main_view' => 'contact/list_contact',
		);
		$this->load->view('include/template', $data);	
	}

	public function delete($id = NULL)
	{
		if (!empty($id)) {

			$this->db->where('conId', $id);
			$query = $this->db->delete('contact_me');

			redirect('adm_contact','refresh');
		}
		else {
			redirect('adm_contact','refresh');
		}
	}

	function grab_data_contact()
	{
		$draw						= $_REQUEST['draw'];		
		$length						= $_REQUEST['length'];
		$start						= $_REQUEST['start'];
		$search						= $_REQUEST['search']["value"];
		$total 						= $this->db->count_all_results('contact_me');
		$output 					= array();
		$output['draw'] 			= $draw;
		$output['recordsTotal']		= $output['recordsFiltered'] = $total;
		$output['data']				= array();

		if($search!="")
		{
			$this->db->like('conNama', $search)
					->or_like('conEmail', $search);
		}
		
		$this->db->limit($length, $start);		
		$this->db->order_by('conEmail', 'ASC');
		$query = $this->db->get('contact_me')->result_array();
		
		if($search!="")
		{
			$this->db->like('conNama', $search)
					->or_like('conEmail', $search);

			$jum = $this->db->get('contact_me');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}

		$nomor_urut = $start+1;
		foreach ($query as $hasil) {
						
			$id 	= md5($hasil['conId']);
			$nama 	= $hasil['conNama'];

			$output['data'][]=array(
				$nomor_urut,
				$hasil['conNama'],
				$hasil['conEmail'],
				anchor("#myModal",'<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Lihat Pesan', array('title'=>"Lihat Pesan $nama" , 'class'=>'btn btn-danger btn-sm', 'id'=>'custId', 'data-toggle'=>'modal', 'data-id'=>"$id",))." ".				
				anchor("admin/contact/delete/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Hapus data $nama" , 'class'=>'btn btn-dark btn-sm', 'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))				
			);
		$nomor_urut++;
		}

		echo json_encode($output);
	}

	public function delete_contact($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$this->db->delete('contact_me', array('conId' => $id));

			if ($this->contact_model->hapus_contact($id) === TRUE) {
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

	public function looks()
	{
		$data['myClass'] 	= $this;
		$data['id'] 		= $_POST['rowid'];
		$data['contact'] 	=  $this->db->get_where('contact_me', ['md5(conId)' => $_POST['rowid']])->row();
		$this->load->view('backend/contact/looks_contact', $data);
	}

}

/* End of file Adm_contact.php */
/* Location: ./application/modules/backend/controllers/Adm_contact.php */