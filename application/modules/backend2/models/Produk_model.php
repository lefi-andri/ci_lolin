<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

    /**
    * @ Method Product
    *
    */

    // Method Simpan Product
    public function simpan_product($info)
    {
        $this->db->insert('product', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }




    // UPDATE PRODUCT
    function update_product($input, $id_produk)
    {
        $this->load->helper('slug');
        $slug = slug($_POST['prodsName']);

        $info = array(
            'catprodsId'            => $this->input->post('catprodsId'),
            'prodsKode'             => $this->input->post('prodsKode'),
            'prodsName'             => $this->input->post('prodsName'),
            'prodsSlug'             => $slug,
            'prodsNetto'            => $this->input->post('prodsNetto'),
            'prodsWeight'           => $this->input->post('prodsWeight'),
            'prodsDesc'             => $this->input->post('prodsDesc'),
            'prodsKeyword'          => $this->input->post('prodsKeyword'),
            'prodsUpdateDate'       => date('Y-m-d H:i:s'),
            'prodsShow'             => $this->input->post('prodsShow'),
            'prodsSort'             => $this->input->post('prodsSort'),
            'prodsPrice'            => $this->input->post('harga_satuan'),
            'prodsDirections'       => $this->input->post('prodsDirections'),
            'prodsIngredients'      => $this->input->post('prodsIngredients'),
            'nomor_bpom'            => $this->input->post('nomor_bpom'),
            'merchant'              => serialize($this->input->post('merchant[]')),
            'admin_id'              => $this->session->userdata('user_id'),
        );

        $this->db->where('prodsId', $id_produk)->update('product', $info);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    // UPDATE GAMBAR PRODUK
    function update_gambar_product($input_gambar, $id)
    {
        return $this->db->where('prodsId', $id)->update('product', $input_gambar);
    }

    // UPDATE POIN
    function update_poin($input)
    {
        $ID_att = $this->input->post('poinId[]');
        $result = array();
        foreach($ID_att AS $key => $val){
            $result[] = array(
                "poinId" => $ID_att[$key],
                "poinNilai"  => $_POST['poinNilai'][$key]
            );
        }
        return $this->db->update_batch('poin', $result, 'poinId');
    }

    // UPDATE DISKON
    function update_diskon($input)
    {
        $diskon_data = $this->input->post('satuan_diskon[]');
        $result_diskon = array();
        foreach($diskon_data AS $key => $val){
            $result_diskon[] = array(
                "diskon_id"         => $_POST['diskon_id'][$key],
                "jumlah_unit"       => $_POST['satuan_diskon'][$key],
                "berat"             => $_POST['berat'][$key],
                "harga_jumlah_unit" => $_POST['harga_satuan_diskon'][$key]
            );
        }
        return $this->db->update_batch('diskon_harga', $result_diskon, 'diskon_id');
    }

    // Method Cari Product
    public function cari_product($id)
    {
    	$this->db->select('*');
    	$this->db->from('product');
		#$this->db->join('product_directions', 'product.prodsId = product_directions.prodsId');
        $this->db->join('poin', 'product.prodsId = poin.prodsId');
        $this->db->where('product.prodsId', $id);
		return $this->db->get()->row();        
    }

    // Method Hapus Product
    public function hapus_product($id)
    {
        $query = $this->db->where('prodsId', $id)
        				->delete('product');

        	if ($query) {

        		if($this->db->affected_rows() > 0)
		        {
		            return TRUE;
		        }
		        else
		        {
		            return FALSE;
		        }
        	}        
    }

    



    function cariImage($id)
    {
        $this->db->where('prodsId',$id);
        return $this->db->get('product');
    }

    function dd_product_kategori()
    {
    	$this->db->order_by('catprodsSort', 'asc');
		$result = $this->db->get('product_cat');
		$dd[''] = 'Please Select';
		if ($result->num_rows()>0) {
			foreach ($result->result() as $row) {
				$dd[$row->catprodsId] = $row->catprodsName;
			}
		}
		return $dd;
    }

    // Method Update Directions
    public function update_directions($info, $id)
    {
        
        $this->db->where('prodsId', $id)
                            ->update('product_directions', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }                
    }

    // Method Update Ingredients
    public function update_ingredients($info, $id)
    {
        
        $this->db->where('prodsId', $id)
                            ->update('product_ingredients', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }                
    }


    // Method Cari Directions
    public function cari_directions($id)
    {
        $this->db->where('prodsId', $id);
        return $this->db->get('product_directions')->row();
        
    }

    // Method Cari Ingredients
    public function cari_ingredients($id)
    {
        $this->db->where('prodsId', $id);
        return $this->db->get('product_ingredients')->row();
        
    }

	

}

/* End of file Produk_model.php */
/* Location: ./application/modules/backend/models/Produk_model.php */