<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk_model extends CI_Model {

	/**
    * @ Method Product Kategori
    *
    */

	// Method Simpan Kategori
    public function simpan_kategori($info)
    {
        $this->db->insert('product_cat', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // Method Update Kategori
    public function update_kategori($info, $id)
    {
        $this->db->where('catprodsId', $id);
        $this->db->update('product_cat', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // Method Cari Kategori
    public function cari_kategori($id)
    {
        return $this->db->where('md5(catprodsId)', $id)
                        ->get('product_cat')->row();
    }

    // Method Hapus Kategori
    public function hapus_kategori($id)
    {
        $this->db->where('md5(catprodsId)', $id);
        $this->db->delete('product_cat');

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {           
            return FALSE;
        }
    }

    // Method Remove Navbar Picture Kategori
    public function update_remove_image($info, $id)
    {
        $this->db->where('md5(catprodsId)', $id);
        $this->db->update('product_cat', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

        function cariImageNavbarKategori($id)
    {
        $this->db->where('md5(catprodsId)',$id);
        return $this->db->get('product_cat');
    }

    // Method Update Remove Image Navbar
    public function update_remove_product_category($info, $id)
    {
        $this->db->where('md5(catprodsId)', $id)
                            ->update('product_cat', $info);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function cariImageKategori($id)
    {
        $this->db->where('catprodsId',$id);
        return $this->db->get('product_cat');
    }

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/modules/backend/models/Kategori_produk_model.php */