<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_order extends Member_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller atau distributor.');
            redirect('reseller','refresh');
        }
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer','user_info_menu'));
		//load model
		$this->load->model('member_order_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');
		//set title
		$this->stencil->title('My Order');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('my order', 'member/member_order');

		$id_reseller = $this->session->userdata('user_id');

		$this->load->library('table');

		// query belum dikonfirmasi
		$this->db->select('*');
		$this->db->from('purchase_order_reseller');
		$this->db->join('users', 'users.id = purchase_order_reseller.reseller_id');
		$this->db->where('users.id', $id_reseller);
		$this->db->where('purchase_order_reseller.status_konfirmasi', 0);
		$this->db->where('purchase_order_reseller.is_temporary_order', 1);
		$this->db->group_by('purchase_order_reseller.order_code_reseller');
		$this->db->order_by('purchase_order_reseller.order_code_reseller', 'desc');
		$data_purchase_order = $this->db->get();

		$data_order =  $data_purchase_order;

		$this->table->set_heading('No', 'Nomor Invoice', 'Tanggal');

		$no = 1;
		foreach ($data_order->result() as $key => $value) {

			$id = $value->order_code_reseller;

			list($tanggal, $waktu) = explode(' ', $value->order_date);

			$this->table->add_row(
				$no, 
				anchor(base_url().'member/temp_order/detail/'.$id, $value->order_code_reseller, array('data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Klik untuk detail', 'style'=>'text-decoration:none;')), 
				indonesian_date($tanggal).' --- '.$waktu
			);
			$no++;
		}
		$template = array(
	        'table_open'            => '<table class="table table-sm">',
	        'thead_open'            => '<thead>',
	        'thead_close'           => '</thead>',
	        'table_close'           => '</table>'
		);
		$this->table->set_template($template);

		$belum_dikonfirmasi = $this->table->generate();


		// query sudah dikonfirmasi
		$this->db->select('*');
		$this->db->from('purchase_order_reseller');
		$this->db->join('users', 'users.id = purchase_order_reseller.reseller_id');
		$this->db->where('users.id', $id_reseller);
		$this->db->where('purchase_order_reseller.status_konfirmasi', 1);
		$this->db->where('purchase_order_reseller.is_temporary_order', 0);
		$this->db->group_by('purchase_order_reseller.order_code_reseller');
		$this->db->order_by('purchase_order_reseller.order_code_reseller', 'desc');
		$data_purchase_order = $this->db->get();

		$data_order_dikonfirmasi =  $data_purchase_order;

		$this->table->set_heading('No', 'Nomor Invoice', 'Tanggal');

		$no = 1;
		foreach ($data_order_dikonfirmasi->result() as $key => $value) {

			$id = $value->order_code_reseller;

			list($tanggal, $waktu) = explode(' ', $value->order_date);

			$this->table->add_row(
				$no, 
				anchor(base_url().'member/order/detail/'.$id, $value->order_code_reseller, array('data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Klik untuk detail', 'style'=>'text-decoration:none;')),
				indonesian_date($tanggal).' --- '.$waktu
			);
			$no++;
		}

		$template = array(
	        'table_open'            => '<table class="table table-sm">',
	        'thead_open'            => '<thead>',
	        'thead_close'           => '</thead>',
	        'table_close'           => '</table>'
		);
		$this->table->set_template($template);

		$sudah_dikonfirmasi = $this->table->generate();

		//get meta data
		$meta = member_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'My Order',
            'data_reseller'			=> $this->ion_auth->get_user(),
			'poin_saat_ini'			=> member_controller::poin_member(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
            'table_sudah_dikonfirmasi'	=> $sudah_dikonfirmasi,
			'table_belum_dikonfirmasi'	=> $belum_dikonfirmasi,
        );

		//set view
		$this->stencil->paint('member_order/list_member_order',$data);

	}

	public function detail_per_order($id){
		#echo $id;
		//set title
		$this->stencil->title('Poin Member');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('member', 'member');
		$this->breadcrumb->add('detail order', 'reseller/detail');

		//set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		//set id member
		$id_reseller = $this->session->userdata('user_id');
		
		$this->db->select('produk_id, quantity, kurir,layanan,berat_order,total_order,ongkos_kirim,total_order,payment_method,order_date,status_konfirmasi');
		$this->db->from('purchase_order_reseller');
		$this->db->where('purchase_order_reseller.order_code_reseller', $id);
		$this->db->where('purchase_order_reseller.status_konfirmasi', 1);
		$this->db->where('purchase_order_reseller.is_temporary_order', 0);
		$get_data = $this->db->get();



		//print_r($query->result());

		if ($get_data->num_rows() > 0) {
			$rw_data = $get_data->row();
			$banyak_produk = count(unserialize($rw_data->produk_id));

			$id_produk_order = unserialize($rw_data->produk_id);
			$qty_produk_order = unserialize($rw_data->quantity);

			$this->load->library('table');
			$this->table->set_heading('No.', '','Nama Produk', 'Quantity');

			$no = 1;
			for ($i = 0; $i < $banyak_produk; $i++) {

				$this->db->select('prodsName, prodsSlug, prodsFrontPic, prodsNetto, prodsWeight, prodsPrice,');
				$this->db->from('product');
				$this->db->where('prodsId', $id_produk_order[$i]);
				$data_produk = $this->db->get()->row();

				$this->table->add_row(
					$no,
					"<img class='d-block mx-auto mb-3' src='".base_url()."assets/images/product/front_of_product/small_".$data_produk->prodsFrontPic."' alt='Image'>",
					$data_produk->prodsName,
					$qty_produk_order[$i]
				);
				$no++;
			}

			$template = array(
			        'table_open'            => '<table class="table">',

			        'thead_open'            => '<thead class="thead-dark">',
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

			//get meta data
			$meta = member_controller::get_meta(2);
			//set metadata
			$this->stencil->meta(array(
	            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
	            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
	            'author' 		=> 'Lolin Kids Care Product',
	        ));


	        //set data
			$data = array(
	            'label'					=> 'Detail Order',
	            'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
				'poin_saat_ini'			=> member_controller::poin_member(),
				'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
				'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

				'table'					=> $this->table->generate(),

				'kurir'	=> $rw_data->kurir,
				'layanan' => $rw_data->layanan,
				'berat_order' => $rw_data->berat_order,
				'total_order' => $rw_data->total_order,
				'ongkos_kirim' => $rw_data->ongkos_kirim,
				'payment_method' => $rw_data->payment_method,
				'order_date' => $rw_data->order_date,
				'status_konfirmasi' => $rw_data->status_konfirmasi,
				'order_id'				=> $id,
	        );

			//set view
			$this->stencil->paint('member_order/detail_order_acc',$data);
			
		}else{
			

			//get meta data
			$meta = member_controller::get_meta(2);
			//set metadata
			$this->stencil->meta(array(
	            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
	            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
	            'author' 		=> 'Lolin Kids Care Product',
	        ));


	        //set data
			$data = array(
	            'label'					=> 'Detail Order',
	            'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
				'poin_saat_ini'			=> member_controller::poin_member(),
				'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
				'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
				'order_id'				=> $id,
	        );

			//set view
			$this->stencil->paint('member_order/detail_order_non_acc',$data);
		}
	}

	public function detail_per_order_non_acc($id){

		//echo $id;
		//set title
		$this->stencil->title('Detail Order Pending');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('member', 'member');
		$this->breadcrumb->add('detail order pending', 'reseller/detail');

		//set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		//set id member
		$id_reseller = $this->session->userdata('user_id');
		
		$this->db->select('produk_id, quantity, kurir,layanan,berat_order,total_order,ongkos_kirim,total_order,payment_method,order_date,status_konfirmasi');
		$this->db->from('purchase_order_reseller');
		$this->db->where('purchase_order_reseller.order_code_reseller', $id);
		$this->db->where('purchase_order_reseller.status_konfirmasi', 0);
		$this->db->where('purchase_order_reseller.is_temporary_order', 1);
		$get_data = $this->db->get();



		//print_r($query->result());

		if ($get_data->num_rows() > 0) {
			$rw_data = $get_data->row();
			$banyak_produk = count(unserialize($rw_data->produk_id));

			$id_produk_order = unserialize($rw_data->produk_id);
			$qty_produk_order = unserialize($rw_data->quantity);

			$this->load->library('table');
			$this->table->set_heading('No.', '','Nama Produk', 'Quantity');

			$no = 1;
			for ($i = 0; $i < $banyak_produk; $i++) {

				$this->db->select('prodsName, prodsSlug, prodsFrontPic, prodsNetto, prodsWeight, prodsPrice,');
				$this->db->from('product');
				$this->db->where('prodsId', $id_produk_order[$i]);
				$data_produk = $this->db->get()->row();

				$this->table->add_row(
					$no,
					"<img class='d-block mx-auto mb-3' src='".base_url()."assets/images/product/front_of_product/small_".$data_produk->prodsFrontPic."' alt='Image'>",
					$data_produk->prodsName,
					$qty_produk_order[$i]
				);
				$no++;
			}

			$template = array(
			        'table_open'            => '<table class="table">',

			        'thead_open'            => '<thead class="thead-light">',
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

			//get meta data
			$meta = member_controller::get_meta(2);
			//set metadata
			$this->stencil->meta(array(
	            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
	            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
	            'author' 		=> 'Lolin Kids Care Product',
	        ));


	        //set data
			$data = array(
	            'label'					=> 'Detail Order Pending',
	            'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
				'poin_saat_ini'			=> member_controller::poin_member(),
				'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
				'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

				'table'					=> $this->table->generate(),

				'kurir'	=> $rw_data->kurir,
				'layanan' => $rw_data->layanan,
				'berat_order' => $rw_data->berat_order,
				'total_order' => $rw_data->total_order,
				'ongkos_kirim' => $rw_data->ongkos_kirim,
				'payment_method' => $rw_data->payment_method,
				'order_date' => $rw_data->order_date,
				'status_konfirmasi' => $rw_data->status_konfirmasi,
				'order_id'				=> $id,
	        );

			//set view
			$this->stencil->paint('member_order/detail_order_acc',$data);
			
		}else{
			

			//get meta data
			$meta = member_controller::get_meta(2);
			//set metadata
			$this->stencil->meta(array(
	            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
	            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
	            'author' 		=> 'Lolin Kids Care Product',
	        ));


	        //set data
			$data = array(
	            'label'					=> 'Detail Order',
	            'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
				'poin_saat_ini'			=> member_controller::poin_member(),
				'banyak_order_reseller'	=> member_controller::banyak_order_reseller($id_reseller),
				'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
				'order_id'				=> $id,
	        );

			//set view
			$this->stencil->paint('member_order/detail_order_non_acc',$data);
		}
	}

}

/* End of file Member_order.php */
/* Location: ./application/modules/frontend/controllers/Member_order.php */