<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk_model extends CI_Model {

	public function tampil_produk()
    {
    	$this->db->where('prodsShow', 'y');
    	return $this->db->get('product', 5, 0);
    }

    # AMBIL DATA KATEGORI PRODUK
    function get_kategori_produk(){
        return $this->db->get('product_cat');
    }

	# hitung jumlah total data PAGING
    function total_record() {
        $this->db->from('product');
        return $this->db->count_all_results();
    }
    # tampilkan dengan limit PAGING
    function get_product_list($limit, $start = 0, $id) {
        $this->db->select('*');
		$this->db->from('product');
		$this->db->join('product_cat', 'product_cat.catprodsId = product.catprodsId');
		$this->db->limit($limit, $start);
		$this->db->where('product_cat.catprodsSlug', $id);
		$this->db->order_by('product.prodsId', 'desc');
        return $this->db->get();
    }

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/modules/frontend/models/Kategori_produk_model.php */