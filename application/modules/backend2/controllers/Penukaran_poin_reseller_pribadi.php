<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penukaran_poin_reseller_pribadi extends Backend_Controller {

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
		
		$this->load->model('penukaran_poin_reseller_pribadi_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Nomor Penukaran','Nama Id Reseller', 'Bonus', 'Penukaran', 'Tanggal Tukar', 'Acc','Acc At','Email Confirmation','',''));

		$data_tukar_poin = $this->models->get_data_tukar_poin();

		$no = 1;
		foreach ($data_tukar_poin->result() as $value) {

			$id = $value->tukar_poin_id;

			list($tanggal, $waktu) = explode(' ', $value->tanggal_tukar_poin);

			$options = array(
				''         => '-- Pilih --',
			    '1'         => 'Setujui Penukaran',
			    '0'         => 'Tidak Setujui',
			);

			$this->table->add_row(array(
				$no, 
				$value->kode_tukar_poin,
				$value->nama_lengkap.' --- '.$value->reseller_id,
				$value->poin_bonus." poin",
				$value->nama_jenis_bonus,
				indonesian_date($tanggal).' --- '.$waktu,

				form_dropdown('acc_tukar_poin', $options, $value->acc_tukar_poin, array('onchange'=>'simpanbadanusaha('.$value->tukar_poin_id.')', 'id' => 'acc_tukar_poin'.$value->tukar_poin_id, 'class'=>'form-control', 'style'=>'width:100px;')),
				$value->tanggal_acc,
				($value->konfirmasi_email_status == 1) ? "Sudah" : "Belum",
				($value->konfirmasi_email_status == 1) ? anchor(base_url()."backend/penukaran_poin_reseller_pribadi/konfirmasi_email/$id", 'Kirim Ulang', array('class' => '')) : anchor(base_url()."backend/penukaran_poin_reseller_pribadi/konfirmasi_email/$id", 'Konfirmasi Email', array("class" => "")),
				anchor(base_url().'backend/penukaran_poin_reseller_pribadi/edit_tukar_poin/'.$value->tukar_poin_id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('class'=>'btn btn-dark btn-xs')).' '.
				anchor(base_url().'backend/penukaran_poin_reseller_pribadi/delete_tukar_poin/'.$value->tukar_poin_id, '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('class'=>'btn btn-danger btn-xs', 'onclick' => "return confirm('Anda yakin ingin menghapus data $value->reseller_id ?')")),
			));
			$no++;
		}

		core:: buat_tabel();


		$this->data = array(
			'main_view' 		=> 'penukaran_poin_reseller_pribadi/list_penukaran_poin',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function acc_penukaran_poin()
    {
        $id           =   $_GET['id'];
        $value_change =   $_GET['acc_tukar_poin'];

        if ($value_change == 1) {
        	$info = array(
				'acc_tukar_poin' => $value_change,
				'tanggal_acc' => date("Y-m-d h:i:s"),
			);
        }

        if ($value_change == 0) {
        	$info = array(
				'acc_tukar_poin' => $value_change,
				'tanggal_acc' => '',
			);
        }

        $this->db->where('tukar_poin_id', $id)
        					->update('tukar_poin', $info);

		echo "<script>window.alert('Data berhasil diubah');window.location='".base_url()."backend/penukaran_poin_reseller_pribadi/index';</script>";
    }

    public function konfirmasi_email($id){
		//echo $id;

		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'penukaran_poin_reseller_pribadi/form_konfirmasi_email',
			'form_action' 	=> "backend/penukaran_poin_reseller_pribadi/konfirmasi_email/$id"
		);

		$this->form_validation->set_rules('konfirmasi_email', 'Keterangan', 'trim|xss_clean');
		//$this->form_validation->set_rules('harga_pembelian_produk', 'Harga Pembelian Produk', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('biaya_pengiriman', 'Biaya Pengiriman', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('konfirmasi_total_harga', 'Konfirmasi Total Harga', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);

			} else {

				$id 				= $this->session->userdata('id_sekarang');
				$nama_lengkap 		= $this->input->post('nama_lengkap');
				$nama_jenis_bonus 	= $this->input->post('nama_jenis_bonus');
				$poin_bonus 		= $this->input->post('poin_bonus');
				$nilai_bonus 		= $this->input->post('nilai_bonus');
				$kode_tukar_poin 	= $this->input->post('kode_tukar_poin');
				$tanggal_tukar_poin = $this->input->post('tanggal_tukar_poin');
				$email 				= $this->input->post('email');
				$nama_bank 			= $this->input->post('nama_bank');
				$pemilik_rek 		= $this->input->post('pemilik_rek');
				$norek 				= $this->input->post('norek');
				$konfirmasi_email 	= $this->input->post('konfirmasi_email');

				$reseller_id 				= $this->input->post('reseller_id');
				$nomor_telepon_reseller 	= $this->input->post('nomor_telepon_reseller');
				$alamat_reseller 			= $this->input->post('alamat_reseller');
				$nama_organisasi 			= $this->input->post('nama_organisasi');
				$nomor_telepon_organisasi 	= $this->input->post('nomor_telepon_organisasi');
				$alamat_organisasi 			= $this->input->post('alamat_organisasi');

				$object = array(
							'konfirmasi_email_status' 	=> 1,
							'konfirmasi_email_pesan' 	=> $konfirmasi_email,
						  );

				$this->db->where('tukar_poin_id', $id);
				$konfirmasi_update = $this->db->update('tukar_poin', $object);

				if ($konfirmasi_update) {
					
					// INI JIKA MEMBER
					$pengaturan_email = core::get_pengaturan_email();
					if ($pengaturan_email == 1) {

						$email_to = $email;
						$email_template = "template_email_order"; // Samakan dengan nama method template
						$subjek = "Acc Penukaran Poin Reseller";

						$email_konten = "";

						$user = $this->ion_auth->get_user();
						$group_member = $user->group;

						if ($group_member == "reseller_pribadi") {
							$email_konten .= "
							Dear, ".$nama_lengkap."<br>
							Request penukaran poin anda telah kami setujui. Kini kami akan mentransfer bonus, sejumlah poin yang ditukarkan ke rekening bank anda dengan detail:
							<table width='100%' border='1'>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Bonus</div></td>
							  </tr>
							  <tr>
							    <td>Nama Bonus </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nama_jenis_bonus ."
							    </td>
							  </tr>
							  <tr>
							    <td>Poin</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$poin_bonus."
							    </td>
							  </tr>
							  <tr>
							    <td>Nilai Bonus </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nilai_bonus."
							    </td>
							  </tr>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Penukaran</div></td>
							  </tr>
							  <tr>
							    <td>Kode Penukaran </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$kode_tukar_poin."
							    </td>
							  </tr>
							  <tr>
							    <td>Tanggal Permintaan Penukaran </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$tanggal_tukar_poin."
							     </td>
							  </tr>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Rekening Anda</div></td>
							  </tr>
							  <tr>
							    <td>Nama Bank</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nama_bank."
							    </td>
							  </tr>
							  <tr>
							    <td>Atas Nama</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$pemilik_rek."
							    </td>
							  </tr>
							  <tr>
							    <td>Nomor Rekening</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$norek."
							    </td>
							  </tr>
							</table>
							<br>
							<table width='100%' border='1'>
							  <tr>
							    <td colspan='3'><div align='left'>
							      <br>
							      ".$konfirmasi_email."
							      <br> 
							    </div></td>
							  </tr>
							</table>
							";
						}

						if ($group_member == "reseller_organisasi") {
							$email_konten .= "
							Dear, ".$nama_organisasi."<br>
							Request penukaran poin anda telah kami setujui. Kini kami akan mentransfer bonus, sejumlah poin yang ditukarkan ke rekening bank anda dengan detail:
							<table width='100%' border='1'>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Bonus</div></td>
							  </tr>
							  <tr>
							    <td>Nama Bonus </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nama_jenis_bonus ."
							    </td>
							  </tr>
							  <tr>
							    <td>Poin</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$poin_bonus."
							    </td>
							  </tr>
							  <tr>
							    <td>Nilai Bonus </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nilai_bonus."
							    </td>
							  </tr>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Penukaran</div></td>
							  </tr>
							  <tr>
							    <td>Kode Penukaran </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$kode_tukar_poin."
							    </td>
							  </tr>
							  <tr>
							    <td>Tanggal Permintaan Penukaran </td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$tanggal_tukar_poin."
							     </td>
							  </tr>
							  <tr>
							    <td colspan='3'><div align='left'>Rincian Rekening Anda</div></td>
							  </tr>
							  <tr>
							    <td>Nama Bank</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$nama_bank."
							    </td>
							  </tr>
							  <tr>
							    <td>Atas Nama</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$pemilik_rek."
							    </td>
							  </tr>
							  <tr>
							    <td>Nomor Rekening</td>
							    <td><div align='center'>:</div></td>
							    <td>
							    ".$norek."
							    </td>
							  </tr>
							</table>
							<br>
							<table width='100%' border='1'>
							  <tr>
							    <td colspan='3'><div align='left'>
							      <br>
							      ".$konfirmasi_email."
							      <br> 
							    </div></td>
							  </tr>
							</table>
							";
						}

						
						$kirim = core::buat_email($email_to, $subjek, $email_konten, $email_template);

						if ($kirim) {
							#INFO
							$email_to = email_fordward(); //email_fordward lihat di config lolin
							$email_template = "template_email_order_info"; // Samakan dengan nama method template
							$subjek = "Acc Penukaran Poin Member";
							$email_konten = "Anda baru saja mensetujui penukaran poin member detang detail sebagai berikut :";
							$email_konten .= "
								 <table width='100%' border='1'>
								  <tr>
								    <td colspan='3'><div align='left'>Rincian Customer</div></td>
								  </tr>
								  <tr>
								    <td>Id Member </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$reseller_id."
								    </td>
								  </tr>
								  <tr>
								    <td>Nama Lengkap </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$nama_lengkap."
								    </td>
								  </tr>
								  <tr>
								    <td>Alamat </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$alamat_reseller."
								    </td>
								  </tr>
								  <tr>
								    <td>Handphone </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$nomor_telepon_reseller."
								    </td>
								  </tr>
								  <tr>
								    <td>Email</td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$email."
								    </td>
								  </tr>
								  <tr>
								    <td colspan='3'><div align='left'>Rincian Bonus</div></td>
								  </tr>
								  <tr>
								    <td>Nama Bonus </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$nama_jenis_bonus."
								    </td>
								  </tr>
								  <tr>
								    <td>Poin</td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$poin_bonus."
								    </td>
								  </tr>
								  <tr>
								    <td>Nilai Bonus </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$nilai_bonus."
								    </td>
								  </tr>
								  <tr>
								    <td colspan='3'><div align='left'>Rincian Penukaran</div></td>
								  </tr>
								  <tr>
								    <td>Kode Penukaran </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$kode_tukar_poin."
								    </td>
								  </tr>
								  <tr>
								    <td>Tanggal Permintaan Penukaran </td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$tanggal_tukar_poin."
								     </td>
								  </tr>
								  <tr>
								    <td colspan='3'><div align='left'>Rincian Rekening Anda</div></td>
								  </tr>
								  <tr>
								    <td>Nama Bank</td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$nama_bank."
								    </td>
								  </tr>
								  <tr>
								    <td>Atas Nama</td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$pemilik_rek."
								    </td>
								  </tr>
								  <tr>
								    <td>Nomor Rekening</td>
								    <td><div align='center'>:</div></td>
								    <td>
								    ".$norek."
								    </td>
								  </tr>
								</table>
							";

							core::buat_email($email_to, $subjek, $email_konten, $email_template);
						}

					}
					

					redirect(base_url()."backend/penukaran_poin_reseller_pribadi/sukses_acc",'refresh');

				}

				/*$input = $this->input->post(null, TRUE);

				$update = $this->models->update_konfirmasi_email($id, $input);
				
				if ($update === TRUE) {
					$this->session->set_flashdata('message_success', 'Berhasil Mengirim Email Konfirmasi.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}*/

			}

		}else{
			$search = $this->models->cari_konfirmasi_email($id);
			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->tukar_poin_id);

				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

	public function add_tukar_poin()
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'penukaran_poin_reseller_pribadi/form_add_penukaran_poin',
			'form_action' 	=> 'backend/penukaran_poin_reseller_pribadi/add_tukar_poin',
			'data_reseller_pribadi' => $this->models->get_data_reseller_pribadi(),
			'data_bonus_poin' => $this->models->get_data_bonus_poin(),
		);

		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;

		$this->form_validation->set_rules('user_id', 'Reseller', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bonus_poin_id', 'Bonus', 'trim|required|xss_clean');
		

		if (isset($_POST['submit'])) {

			if ($this->form_validation->run() == FALSE) {

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {

				$input = $this->input->post(null, TRUE);

				$tipe = 'reseller_pribadi';
				$kode_tukar_poin = core::buat_kode_tukar_poin($tipe);

				$saved_tukar_poin = $this->models->simpan_tukar_poin($input, $kode_tukar_poin);

				if ($saved_tukar_poin === TRUE) {					

					$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);

				}else{
					
					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}
			}
		}else{
			
			$this->load->view('include/template', $this->data);
		}
	}

	public function edit_tukar_poin($id)
	{
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 	=> 'penukaran_poin_reseller_pribadi/form_edit_penukaran_poin',
			'form_action' 	=> "backend/penukaran_poin_reseller_pribadi/edit_tukar_poin/$id",
			'data_reseller_pribadi' => $this->models->get_data_reseller_pribadi(),
			'data_bonus_poin' => $this->models->get_data_bonus_poin(),
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('user_id', 'Reseller', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bonus_poin_id', 'Bonus', 'trim|required|xss_clean');

				

				if ($this->form_validation->run() == FALSE) {

					$this->data['pesan_error'] = 'Terjadi kesalahan input ';
					$this->load->view('include/template', $this->data);
				} else {

					$id = $this->session->userdata('id_sekarang');

					$input = $this->input->post(null, TRUE);

					$saved_tukar_poin = $this->models->update_tukar_poin($input,$id);

					if ($saved_tukar_poin === TRUE) {					

						$this->session->set_flashdata('message_success', 'Berhasil mengubah data.');
						$url = $this->session->userdata('lolin_urlback_backend');
						redirect($url);

					}else{
						
						$this->data['pesan_error'] = "Terjadi Kesalahan ";
						$this->load->view('include/template', $this->data);
					}
					
				}
			}else{
				$search = $this->models->cari_tukar_poin($id);
				if ($search) {
					foreach ($search as $key => $value) {
						$this->data['form_value'][$key] = $value;
					}
					$this->session->set_userdata('id_sekarang', $search->tukar_poin_id);

					$this->load->view('include/template', $this->data);
				}else{
					$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}
			}

			
		}
	}

	public function delete_tukar_poin($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{
			if ($this->models->hapus_tukar_poin($id) === TRUE) {
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

	public function sukses_acc(){
		//echo "berhasil acc";

		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'penukaran_poin_reseller_pribadi/penukaran_sukses',
		);

		$this->load->view('include/template', $this->data);
	}

}

/* End of file Penukaran_poin_reseller_pribadi.php */
/* Location: ./application/modules/backend/controllers/Penukaran_poin_reseller_pribadi.php */