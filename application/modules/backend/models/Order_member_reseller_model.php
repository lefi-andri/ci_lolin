<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_member_reseller_model extends CI_Model {

	public function cari_konfirmasi_email($id)
    {
        $query = $this->db->get_where('purchase_order_reseller', array('order_code_reseller' => $id))->row();
        return $query;
    }

}

/* End of file Order_member_reseller_model.php */
/* Location: ./application/modules/backend/models/Order_member_reseller_model.php */