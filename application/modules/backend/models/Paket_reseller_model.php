<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_reseller_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		
	}

	public function dropdown_group()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('id >', 2);
        $result = $this->db->get('groups');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->description;
            }
        }
        return $dropdown;
    }

	public function get_data_paket_reseller(){
		
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->join('paket_reseller', 'groups.id = paket_reseller.group_id');
        $this->db->order_by('paket_reseller.id', 'desc');
        $query = $this->db->get();

		return $query;
	}

	public function simpan_paket_reseller($input)
    {
    	$data = array(
    		'group_id' => $this->input->post('group_id'),
    		'nama_paket' => $this->input->post('nama_paket'),
            'produk_list' => serialize($this->input->post('prodsId[]')),
            'jumlah_list' => serialize($this->input->post('jumlah_list[]')),
    		'berat' => $this->input->post('berat'),
    		'harga_paket' => $this->input->post('harga_paket'),
            'keterangan_paket' => $this->input->post('keterangan_paket')
    	);

        $this->db->insert('paket_reseller', $data);
		
        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_paket_reseller($id)
    {
        $query = $this->db->get_where('paket_reseller', array('id' => $id))->row();
        return $query;
    }

    public function update_paket_reseller($id, $input)
    {
        $data = array(
            'group_id' => $this->input->post('group_id'),
            'nama_paket' => $this->input->post('nama_paket'),
            'produk_list' => serialize($this->input->post('prodsId[]')),
            'jumlah_list' => serialize($this->input->post('jumlah_list[]')),
            'berat' => $this->input->post('berat'),
            'harga_paket' => $this->input->post('harga_paket'),
            'keterangan_paket' => $this->input->post('keterangan_paket')
        );

        $this->db->where('id', $id);
        $this->db->update('paket_reseller', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_paket_reseller($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('paket_reseller');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Paket_reseller_model.php */
/* Location: ./application/modules/backend/models/Paket_reseller_model.php */