<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		
	}

	public function get_data_blog(){
		
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
        $this->db->join('gambar_posting_blog', 'gambar_posting_blog.blog_id = blog.id');
        $this->db->order_by('blog.id', 'desc');
        $query = $this->db->get();

		return $query;
	}

	public function simpan_blog($input, $gambar_judul, $gambar_posting)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'kategori_id' => $this->input->post('kategori_id'),
    		'judul' => $this->input->post('judul'),
    		'slug' => slug($this->input->post('judul')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'perbolehkan_komentar' => $this->input->post('perbolehkan_komentar'),
    		'sub_judul' => $this->input->post('sub_judul'),
    		'penulis' => $this->input->post('penulis'),
    		'keyword' => $this->input->post('keyword'),
			'sumber_berita' => $this->input->post('sumber_berita'),
    		'tag_id' => serialize($this->input->post('nama_tag[]')),
    		'tanggal_posting' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id'),
    	);

        $this->db->insert('blog', $data);

        $post_last_id = $this->db->insert_id();

        $no = 1;					               
        foreach($this->input->post('konten') as $key => $value){
            $konten 	= $_POST['konten'][$key];                        
        	$data_kontent = array(
            	'blog_id'	=> $post_last_id,
            	'konten'	=> $_POST['konten'][$key],
            	'halaman'	=> $_POST['halaman'][$key],
            );                            
            $this->db->insert('konten_blog', $data_kontent);
            $no ++;
        }

        $data_gambar_judul = array(
    		'blog_id' => $post_last_id,
    		'nama_gambar_judul' => $gambar_judul,
    		'caption_gambar_judul' => $this->input->post('caption_gambar_judul'),
    	);

        $this->db->insert('gambar_judul_blog', $data_gambar_judul);
		
        $data_gambar_posting = array(
    		'blog_id' => $post_last_id,
    		'nama_gambar_posting' => $gambar_posting,
    		'caption_gambar_posting' => $this->input->post('caption_gambar_posting'),
    	);

        $this->db->insert('gambar_posting_blog', $data_gambar_posting);
		

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_blog($id)
    {
    	$this->db->select('*');
		$this->db->from('blog');
		$this->db->join('konten_blog', 'konten_blog.blog_id = blog.id');
		$this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
		$this->db->join('gambar_posting_blog', 'gambar_posting_blog.blog_id = blog.id');
		$this->db->where('blog.id', $id);
		$query = $this->db->get()->row();

    	return $query;
    }

    public function update_blog($id, $input)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'kategori_id' => $this->input->post('kategori_id'),
    		'judul' => $this->input->post('judul'),
    		'slug' => slug($this->input->post('judul')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'perbolehkan_komentar' => $this->input->post('perbolehkan_komentar'),
    		'sub_judul' => $this->input->post('sub_judul'),
    		'penulis' => $this->input->post('penulis'),
    		'keyword' => $this->input->post('keyword'),
			'sumber_berita' => $this->input->post('sumber_berita'),
    		'tag_id' => serialize($this->input->post('nama_tag[]')),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('blog', $data);

        $no = 1;					               
        foreach($this->input->post('konten') as $key => $value){
            $konten 	= $_POST['konten'][$key];                        
        	$data_kontent = array(
            	'konten'	=> $_POST['konten'][$key],
            );
            $this->db->where('blog_id', $id);
            $this->db->where('halaman', $_POST['halaman'][$key]);               
            $query = $this->db->update('konten_blog', $data_kontent);
            $no ++;
        }

		if ($gambar_posting != NULL) {
			
		}
        

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_judul($id)
    {
        $this->db->where('blog_id',$id);
        return $this->db->get('gambar_judul_blog');
    }

    public function cari_gambar_posting($id)
    {
        $this->db->where('blog_id',$id);
        return $this->db->get('gambar_posting_blog');
    }

    public function hapus_blog($id)
    {
    	$this->db->where('blog_id', $id);
        $this->db->delete('konten_blog');

        $this->db->where('blog_id', $id);
        $this->db->delete('gambar_judul_blog');

        $this->db->where('blog_id', $id);
        $this->db->delete('gambar_posting_blog');

        $this->db->where('id', $id);
        $this->db->delete('blog');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function dropdown_kategori_blog()
    {
        $this->db->order_by('nama_kategori', 'asc');
        $result = $this->db->get('kategori_blog');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_kategori;
            }
        }
        return $dropdown;
    }

    public function cari_kategori($id){
    	$query = $this->db->get_where('kategori_blog', array('id' => $id));
    	return $query->row();
    }

}

/* End of file Blog_model.php */
/* Location: ./application/modules/backend/models/Blog_model.php */