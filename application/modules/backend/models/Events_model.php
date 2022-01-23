<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {

	// Method Simpan Events
    public function simpan_events($info)
    {
        $this->db->insert('events', $info);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // Method Update Events
    public function update_events($info, $id)
    {
    	
        $this->db->where('eventsId', $id)
        					->update('events', $info);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
		
        
    }

    // Method Hapus Events
    public function hapus_events($id)
    {
        $query = $this->db->where('md5(eventsId)', $id)
                        ->delete('events');

            if ($query) {

                if($this->db->affected_rows() > 0){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }        
    }

    function cariImage($id)
    {        
        return $this->db->get_where('events',array('md5(eventsId)'=>$id));
    }

    // Method Cari Events
    public function cari_events($id)
    {    	
        return $this->db->get_where('events',array('md5(eventsId)'=>$id))->row();
    }











    function cariImageEvent($id)
    {
        $this->db->where('md5(eventsPicId)',$id);
        return $this->db->get('eventspic')->row();
    }

    // Method Hapus Picture
    public function hapus_event_picture($id)
    {
        $query = $this->db->where('md5(eventsPicId)', $id)
                        ->delete('eventspic');

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

    public function insertEventPicture($data)
    {
        return $this->db->insert('eventspic',$data);
    }

    public function update_events_picture($info, $id)
    {
        $this->db->where('eventsPicId', $id);
        $this->db->update('eventspic', $info);

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

/* End of file Events_model.php */
/* Location: ./application/modules/backend/models/Events_model.php */