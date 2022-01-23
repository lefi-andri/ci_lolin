<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_reseller_pribadi_model extends CI_Model {

	function remove_order($id){
        $this->db->where('order_code', $id);
        $this->db->delete('purchase_order');

        $this->db->where('related_id', $id);
        $this->db->delete('log_transaksi');

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

    public function cari_konfirmasi_email($id)
    {
        $query = $this->db->get_where('purchase_order', array('order_code' => $id))->row();
        return $query;
    }

    public function update_konfirmasi_email($id, $input)
    {
            
        $data = array(
            'status_konfirmasi' => 1,
            'konfirmasi_email' => $this->input->post('konfirmasi_email'),
            'harga_pembelian_produk' => $this->input->post('harga_pembelian_produk'),
            'biaya_pengiriman' => $this->input->post('biaya_pengiriman'),
            'konfirmasi_total_harga' => $this->input->post('konfirmasi_total_harga')
        );

        $this->db->where('order_id', $id);
        $this->db->update('purchase_order', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Order_reseller_pribadi_model.php */
/* Location: ./application/modules/backend/models/Order_reseller_pribadi_model.php */