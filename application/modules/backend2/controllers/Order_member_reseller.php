<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_member_reseller extends Backend_Controller {

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
		
		$this->load->model('order_member_reseller_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Nomor Pembelian', 'Nama & Id Reseller','Tanggal Order','Status Konfirmasi','Acc','Konfirmasi Email','');

		// query belum dikonfirmasi
		$this->db->select('purchase_order_reseller.order_code_reseller, purchase_order_reseller.order_date, purchase_order_reseller.status_konfirmasi,purchase_order_reseller.id as order_id,purchase_order_reseller.konfirmasi_email,meta.nama_lengkap, meta.reseller_id');
		$this->db->from('purchase_order_reseller');
		$this->db->join('users', 'users.id = purchase_order_reseller.reseller_id');
		$this->db->join('meta', 'meta.user_id = users.id');
		#$this->db->where('users.id', $id_reseller);
		#$this->db->where('purchase_order_reseller.status_konfirmasi', 0);
		#$this->db->where('purchase_order_reseller.is_temporary_order', 1);
		$this->db->group_by('purchase_order_reseller.order_code_reseller');
		$this->db->order_by('purchase_order_reseller.order_code_reseller', 'desc');
		$query = $this->db->get();

		$no = 1;
		foreach ($query->result() as $value) {
			$id 	= $value->order_code_reseller;
			$nama 	= $value->order_code_reseller;

			list($tanggal, $waktu) = explode(' ', $value->order_date);

			$options = array(
				''         => '-- Pilih --',
			    '1'         => 'Setujui',
			    '0'         => 'Tidak Setujui',
			);
			
			$this->table->add_row(
				$no,
				$value->order_code_reseller,
				$value->nama_lengkap.' --- '.$value->reseller_id,
				indonesian_date($tanggal).' --- '.$waktu,
				($value->status_konfirmasi == 1)? '<span class="label label-success">Sudah</span>' : '<span class="label label-default">Belum</span>',
				
				form_dropdown('status_konfirmasi', $options, $value->status_konfirmasi, array('onchange'=>'simpanbadanusaha('.$value->order_id.')', 'id' => 'acc_order'.$value->order_id, 'class'=>'form-control')),

				//($value->status_konfirmasi == 1) ? anchor("backend/order_reseller_pribadi/konfirmasi_email/$id", ($value->status_konfirmasi == 1)?'Kirim Ulang':'Konfirmasi Email', array('title'=>"Konfirmasi Email $nama" , 'class'=>'btn btn-dark btn-xs')) : ''.' '.
				
				($value->konfirmasi_email == 0) ? anchor("backend/order_member_reseller/konfirmasi_email/$id", ($value->konfirmasi_email == 1)?'Kirim Ulang':'Konfirmasi Email', array('title'=>"Konfirmasi Email $nama" , 'class'=>'btn btn-dark btn-xs')) : '',
				anchor("backend/order_member_reseller/edit_order/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Detail Order $nama" , 'class'=>'btn btn-dark btn-xs')).' '.
				anchor("backend/order_member_reseller/delete_order/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Detail Order $nama" , 'class'=>'btn btn-danger btn-xs','onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
		
		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'order_member_reseller/list_order',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function acc_order()
    {
        $id           =   $_GET['id'];
        $value_change =   $_GET['acc_order'];

        if ($value_change == 1) {
        	$info = array(
				'status_konfirmasi' => 1,
				'is_temporary_order' => 0,
			);
        }

        if ($value_change == 0) {
        	$info = array(
				'status_konfirmasi' => 0,
				'is_temporary_order' => 1,
			);
        }
        

        $this->db->where('id', $id)
        					->update('purchase_order_reseller', $info);


		
		echo "<script>window.alert('Berhasil mengubah persetujuan');window.location='".base_url()."backend/order_member_reseller'</script>";
    }

    public function konfirmasi_email($id){
		#echo $id;
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'order_reseller_pribadi/form_konfirmasi_email',
			'form_action' 	=> "backend/order_member_reseller/konfirmasi_email/$id"
		);

		$this->form_validation->set_rules('konfirmasi_email', 'Keterangan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('harga_pembelian_produk', 'Harga Pembelian Produk', 'trim|required|xss_clean');
		$this->form_validation->set_rules('biaya_pengiriman', 'Biaya Pengiriman', 'trim|required|xss_clean');
		$this->form_validation->set_rules('konfirmasi_total_harga', 'Konfirmasi Total Harga', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				$id = $this->session->userdata('id_sekarang');

				$input = $this->input->post(null, TRUE);

				$update = $this->models->update_konfirmasi_email($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil Mengirim Email Konfirmasi.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}

			}

		}else{
			$search = $this->models->cari_konfirmasi_email($id);
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

	public function delete_order($id = NULL)
	{
		//echo $id;
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			$this->db->where('order_code_reseller', $id);
			$remove = $this->db->delete('purchase_order_reseller');
			#if ($this->models->remove_order($id) === TRUE) {
			if ($remove) {
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

/* End of file Order_member_reseller.php */
/* Location: ./application/modules/backend/controllers/Order_member_reseller.php */