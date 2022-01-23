<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_order_model extends CI_Model {

	public function ambil_data_produk(){
		$query = $this->db->get_where('product', array('prodsShow'=>'1'));
		return $query;
	}

	public function get_data_reseller_on_mail($id){
		$query = $this->db->get_where('users', array('id'=>$id))->row();
		return $query;
	}

	public function modal_ambil_data_produk($id){
        $query = $this->db->get_where('product', array('prodsId'=>$id))->row();
        return $query;
    }

    public function dropdown_diskonan($id)
    {
    	$data_diskon = $this->db->get_where('diskon_harga', array('produk_id'=>$id, 'jumlah_unit !=' => 0));

        $dropdown[''] = '-- Pilih --';
			foreach ($data_diskon->result() as $diskonan) {
				$dropdown[$diskonan->diskon_id] = $diskonan->jumlah_unit;
			}
        return $dropdown;
    }



    // RAJA ONGKIR --------------------------------------------

    public function dropdown_provinsi(){
    	$curl = curl_init();

			curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "key:ff115172b7a842920e60a6eb2d6fe34a"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  $data = json_decode($response, TRUE);

		  #for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		  #echo '<option value="'.$data['rajaongkir']['results'][$i]['province_id'].','.$data['rajaongkir']['results'][$i]['province'].'">'.$data['rajaongkir']['results'][$i]['province'].'</option>';
		  
		  	$dropdown[''] = '-- Pilih --';
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				$dropdown[$data['rajaongkir']['results'][$i]['province_id'].','.$data['rajaongkir']['results'][$i]['province']] = $data['rajaongkir']['results'][$i]['province_id'].','.$data['rajaongkir']['results'][$i]['province'];
			}
        	return $dropdown;



		  
		}
    }

}

/* End of file Reseller_order_model.php */
/* Location: ./application/modules/frontend/models/Reseller_order_model.php */