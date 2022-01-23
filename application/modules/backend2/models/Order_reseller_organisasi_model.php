<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_reseller_organisasi_model extends CI_Model {

	function remove_order($id){
        $this->db->where('order_code', $id);
        $this->db->delete('purchase_order');

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function search_order($id)
    {
        #return $this->db->get_where('purchase_order', array('md5(order_code)' => $id))->result();
        $this->db->select('*');
        $this->db->from('purchase_order');
        $this->db->join('product', 'product.prodsId = purchase_order.produk_id');
        $this->db->where('purchase_order.order_code', $id);
        return $this->db->get()->result();
    }


    public function hapus_order_pending($id){
        $this->db->where('kode_temporary', $id);
        $query = $this->db->delete('temporary_purchase_order');
        return $query;
    }

}

/* End of file Order_reseller_organisasi_model.php */
/* Location: ./application/modules/backend/models/Order_reseller_organisasi_model.php */