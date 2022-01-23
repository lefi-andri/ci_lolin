<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	public function showProduk()
	{
		$query = $this->db->get('produk');
		return $query;
	}

    public function get_judul($id){
        $query = $this->db->get_where('product', array('prodsSlug'=>$id));

        return $query;
    }

	// Method Simpan Review
    public function simpan_review($info)
    {
        $this->db->insert('product_reviews', $info);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function tampil_produk()
    {
    	$this->db->where('prodsShow', 'y');
    	return $this->db->get('product', 5, 0);
    }

    # hitung jumlah total data PAGING
    function total_record() {
        $this->db->from('product');
        return $this->db->count_all_results();
    }
    # tampilkan dengan limit PAGING
    function get_product_list($limit, $start = 0) {
        $this->db->select('*');
		$this->db->from('product');
		$this->db->limit($limit, $start);
		$this->db->order_by('product.prodsId', 'ASC');
        return $this->db->get();
    }

    # AMBIL DATA KATEGORI PRODUK
    function get_kategori_produk(){
        return $this->db->get('product_cat');
    }

    function modal_ambil_data_produk($id){
        $query = $this->db->get_where('product', array('prodsSlug'=>$id))->row();
        return $query;
    }

}

/* End of file Product_model.php */
/* Location: ./application/modules/frontend/models/Product_model.php */