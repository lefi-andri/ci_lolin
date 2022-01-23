<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

	public function cari($key)
    {
        $query = $this->db->query("SELECT * FROM blog WHERE judul LIKE '%$key%%' ");
        return $query;
    }

    public function get_judul($id){
    	$query = $this->db->get_where('blog', array('slug'=>$id));

    	return $query;
    }

	# hitung jumlah total data PAGING
    function total_record() {
        $this->db->from('blog');
        return $this->db->count_all_results();
    }

    # tampilkan dengan limit PAGING
    function user_limit($limit, $start = 0) {

        $this->db->select('*');
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('konten_blog', 'konten_blog.blog_id = blog.id');
		$this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
		$this->db->join('gambar_posting_blog', 'gambar_posting_blog.blog_id = blog.id');
		$this->db->where('konten_blog.halaman', 1);
		$this->db->limit($limit, $start);
		$this->db->order_by('blog.tanggal_posting', 'desc');
		$query = $this->db->get();

		return $query;
    }

    public function check_artikel($id)
	{
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('konten_blog', 'konten_blog.blog_id = blog.id');
		$this->db->join('gambar_posting_blog', 'gambar_posting_blog.blog_id = blog.id');
		$this->db->where('konten_blog.halaman', 1);
		$this->db->where('blog.perbolehkan_tampil', 1);
		$this->db->where('blog.slug', $id);
		$query = $this->db->get();

		return $query;
	}

	public function check_artikel_halaman($id1, $id2)
	{
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('konten_blog', 'konten_blog.blog_id = blog.id');
		$this->db->join('gambar_posting_blog', 'gambar_posting_blog.blog_id = blog.id');
		$this->db->where('konten_blog.halaman', $id2);
		$this->db->where('blog.perbolehkan_tampil', 1);
		$this->db->where('blog.slug', $id1);
		$query = $this->db->get();

		return $query;
	}

    public function link_previous($id)
	{
		#$check = $this->db->get_where('newsinfo', array('newsSlug'=>$id));
		$check = $this->db->get_where('blog', array('slug'=>$id));
		if ($check->num_rows() > 0) {
			# NEXT
			$data_sekarang = $check->row()->id;
			#$sql = "SELECT * FROM newsinfo WHERE newsId = (SELECT MAX(newsId) FROM newsinfo WHERE newsId < $data_sekarang)";
			$sql = "SELECT * FROM blog WHERE id = (SELECT MAX(id) FROM blog WHERE id < $data_sekarang)";
			$check_link = $this->db->query($sql);
			if ($check_link->num_rows() > 0) {
				return $check_link;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function link_next($id)
	{
		$check = $this->db->get_where('blog', array('slug'=>$id));
		if ($check->num_rows() > 0) {
			# NEXT
			$data_sekarang = $check->row()->id;
			$sql = "SELECT * FROM blog WHERE id = (SELECT MIN(id) FROM blog WHERE id > $data_sekarang)";
			$check_link = $this->db->query($sql);
			if ($check_link->num_rows() > 0) {
				return $check_link;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function get_tags(){
		$query = $this->db->get('tags_blog');
		return $query;
	}

	public function get_random_post(){
		$this->db->select('kategori_blog.nama_kategori, blog.judul, gambar_judul_blog.nama_gambar_judul, blog.slug, blog.penulis');
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
		$this->db->where('blog.perbolehkan_tampil', 1);
		$this->db->order_by('rand()');
        $this->db->limit(4, 0);
		$query = $this->db->get();

		return $query;
	}

	public function get_kategori_blog(){
		$query = $this->db->get_where('kategori_blog', array('perbolehkan_tampil' => 1));
		return $query;
	}

	public function get_random_post_read_blog(){
		$this->db->select('kategori_blog.nama_kategori, blog.judul, gambar_judul_blog.nama_gambar_judul, blog.slug, blog.penulis');
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
		$this->db->where('blog.perbolehkan_tampil', 1);
		$this->db->order_by('rand()');
        $this->db->limit(8, 0);
		$query = $this->db->get();

		return $query;
	}

	

}

/* End of file Blog_model.php */
/* Location: ./application/modules/frontend/models/Blog_model.php */