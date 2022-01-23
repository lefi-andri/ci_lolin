<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_history_tukar_poin extends Backend_Controller {

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
		
		$this->load->model('history_tukar_poin_model');
	}

	public function index()
	{
		$get_years = $this->db->get('pengaturan')->row()->pengaturanTahun;

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Tag Line', 'adm_tukar_poin');		
		
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$template = array(
		        'table_open'            => '<table class="table table-striped">',

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

		$this->table->set_heading('No.', 'Id Member', 'Instansi','Nama', 'Item Penukaran', 'Tanggal Penukaran Bonus', 'Admin', '');

		$this->db->select('tukar_poin.tukarId, member.memberId, member.memberInstance, user_information.userInfoName, poin_bonus.bonusJenis, tukar_poin.tukarDate, tukar_poin.userId');
		$this->db->from('tukar_poin');
		$this->db->join('member', 'member.memberId = tukar_poin.memberId');
		$this->db->join('poin_bonus', 'poin_bonus.bonusId = tukar_poin.bonusId');
		$this->db->join('user', 'user.userId = member.userId');
		$this->db->join('user_information', 'user_information.userInfoId = user.userInfoId');
		$this->db->like('tukar_poin.tukarDate', $get_years);
		$query = $this->db->get();

        $nomor_urut = 1;
        foreach ($query->result() as $value) {

        	$id 		= md5($value->tukarId);
        	$nama 		= $value->userInfoName;

        	$this->db->select('*');
			$this->db->from('user');
			$this->db->join('user_information', 'user_information.userInfoId = user.userInfoId');
			$this->db->where('user.userId', $value->userId);
			$nama_admin = $this->db->get()->row()->userInfoName;

        	$this->table->add_row(
        		$nomor_urut,
        		$value->memberId,
        		$value->memberInstance,
        		$value->userInfoName,
        		$value->bonusJenis,
        		$value->tukarDate,
        		$nama_admin,
				anchor("admin/member/poin/history/delete/$id", "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete History Penukaran", ['title' => "Delete history penukaran $nama" , 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Anda yakin ingin menghapus history penukaran member : $nama ?')"])
			);	
			$nomor_urut++;
        }

		

		$data = array(
			'table'		=> $this->table->generate(),
			'main_view' => 'history_tukar_poin/list_history_tukar_poin', 
		);
		$this->load->view('include/template', $data);
	}

	public function delete_history_tukar_poin($id = NULL)
    {
    	if (empty($id)) {
    		$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			if ($this->history_tukar_poin_model->hapus_tukar_poin_model($id) === TRUE) {
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

/* End of file Member_history_tukar_poin.php */
/* Location: ./application/modules/backend/controllers/Member_history_tukar_poin.php */