<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

	public function dropdown_diskonan($id)
    {
    	$data_diskon = $this->db->get_where('diskon_harga', array('produk_id'=>$id, 'jumlah_unit !=' => 0));

        $dropdown[''] = '-- Pilih --';
			foreach ($data_diskon->result() as $diskonan) {
				$dropdown[$diskonan->jumlah_unit] = $diskonan->jumlah_unit;
			}
        return $dropdown;
    }

}

/* End of file Cart_model.php */
/* Location: ./application/modules/frontend/models/Cart_model.php */