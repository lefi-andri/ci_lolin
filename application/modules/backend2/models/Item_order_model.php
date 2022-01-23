<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_order_model extends CI_Model {

	function remove_item_order($id){
        $this->db->where('order_id', $id);
        $this->db->delete('purchase_order');

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function search_item_order($id){
    	#return $this->db->get_where('purchase_order', array('order_id' => $id))->row();
    	$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('product', 'product.prodsId = purchase_order.produk_id');
		$this->db->where('purchase_order.order_id', $id);
		return $this->db->get()->row();
    }

    function update_item_order($input, $id){
    	/*$object = array(
    		'order_quantity' => $this->input->post('jumlah'),
    	);*/
    	$this->db->where('order_id', $id);
    	return $this->db->update('purchase_order', $input);
    }

    function update_item_order_ubah($input, $id){
        
        $this->db->where('order_id', $id);
        return $this->db->update('purchase_order', $input);
    }



}

/* End of file Item_order_model.php */
/* Location: ./application/modules/backend/models/Item_order_model.php */