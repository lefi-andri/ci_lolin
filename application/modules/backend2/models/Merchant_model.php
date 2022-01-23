<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant_model extends CI_Model {

	public function ambil_data_merchant(){
		$query = $this->db->get('merchant');
		return $query;
	}

	function simpan_merchant($input,$gambar_logo_merchant){

        $data_merchant = array(
            'nama_merchant'         => $this->input->post('nama_merchant'),
            'deskripsi_merchant'    => $this->input->post('deskripsi_merchant'),
            'gambar_logo_merchant'  => $gambar_logo_merchant,
            'link_merchant'    		=> $this->input->post('link_merchant'),
            'urutan_merchant'    	=> $this->input->post('urutan_merchant'),
            'tampilkan_merchant'    => $this->input->post('tampilkan_merchant'),
        );

        $this->db->insert('merchant', $data_merchant);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function update_merchant($id,$input,$gambar_logo_merchant){
        
        $data_merchant = array(
            'nama_merchant'         => $this->input->post('nama_merchant'),
            'deskripsi_merchant'    => $this->input->post('deskripsi_merchant'),
            #'gambar_logo_merchant'  => $gambar_logo_merchant,
            'link_merchant'    		=> $this->input->post('link_merchant'),
            'urutan_merchant'    	=> $this->input->post('urutan_merchant'),
            'tampilkan_merchant'    => $this->input->post('tampilkan_merchant'),
        );

        if ($gambar_logo_merchant) {
        	$data_merchant['gambar_logo_merchant'] = $gambar_logo_merchant;
        }

        $this->db->where('id_merchant', $id);
        $this->db->update('merchant', $data_merchant);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function cari_gambar($id)
    {
        $this->db->where('id_merchant',$id);
        return $this->db->get('merchant');
    }

    function hapus_merchant($id)
    {
        $this->db->delete('merchant', array('id_merchant' => $id));

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function search_merchant($id){
        $query = $this->db->get_where('merchant', array('id_merchant'=>$id))->row();
        return $query;
    }

}

/* End of file Merchant_model.php */
/* Location: ./application/modules/backend/models/Merchant_model.php */