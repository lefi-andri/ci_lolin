<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function get_banner(){
		$query = $this->db->get_where('banner', array('perbolehkan_tampil'=>'1'));
		return $query;
	}

	public function get_flyer(){
		$query = $this->db->get_where('flyer', array('perbolehkan_tampil'=>'1'));
		return $query;
	}

	public function get_tag_line(){
		$query = $this->db->get_where('tag_line', array('perbolehkan_tampil' => '1'));
		return $query;
	}

	public function get_product(){
		$this->db->select('prodsName, prodsSlug, prodsBasePic, prodsNetto, catprodsName');
        $this->db->from('product');
        $this->db->join('product_cat', 'product_cat.catprodsId = product.catprodsId');
        $this->db->order_by('rand()');
        $this->db->limit(8, 0);
        $this->db->where('prodsShow', '1');
        $query = $this->db->get();

        return $query;
	}

	public function get_top_product(){
		$this->db->select('prodsId, prodsName, prodsSlug, prodsBasePic, prodsNetto, catprodsName, prodsDesc, prodsPrice');
        $this->db->from('product');
        $this->db->join('product_cat', 'product_cat.catprodsId = product.catprodsId');
        #$this->db->order_by('rand()');
        $this->db->limit(4, 0);
        $this->db->where('prodsShow', '1');
        $this->db->order_by('prodsAddedDate', 'DESC');
        $data = $this->db->get();

        return $data;
	}

	public function get_new_blog(){
		$this->db->select('*');
		$this->db->from('kategori_blog');
		$this->db->join('blog', 'blog.kategori_id = kategori_blog.id');
		$this->db->join('gambar_judul_blog', 'gambar_judul_blog.blog_id = blog.id');
		$this->db->where('blog.perbolehkan_tampil', '1');
		$this->db->limit(3, 0);
		$this->db->order_by('blog.tanggal_posting', 'DESC');
		$data = $this->db->get();

        return $data;
	}

	public function get_best_event(){
		$this->db->select('*');
		$this->db->from('events');
		$this->db->limit(3, 0);
		$this->db->where('eventsShow', 'y');
		$this->db->order_by('eventsDate', 'DESC');
		$data = $this->db->get();

        return $data;
	}

    public function get_instagram(){
        $this->db->select('*');
        $this->db->from('instagram');
        $this->db->limit(4, 0);
        $this->db->where('perbolehkan_tampil', 1);
        $this->db->order_by('tanggal', 'desc');
        $data = $this->db->get();

        return $data;
    }

	public function cari($key)
    {
        $query = $this->db->query("SELECT * FROM product WHERE prodsName LIKE '%$key%%' ");
        return $query;
    }

    public function get_introduction(){
    	$this->db->select('deskripsi');
    	$this->db->from('konten_halaman');
    	$this->db->where('slug', 'home-intro');
    	$this->db->where('perbolehkan_tampil', 1);
    	$query = $this->db->get();

    	return $query;
    }

    public function get_terdaftar(){
        $query = $this->db->get_where('introduction', array('id' => 1));
        return $query;
        /*$this->db->select('deskripsi');
        $this->db->from('konten_halaman');
        $this->db->where('slug', 'home-terdaftar');
        $this->db->where('perbolehkan_tampil', 1);
        $query = $this->db->get();

        return $query;*/
    }

    public function get_bersertifikat(){
        $query = $this->db->get_where('introduction', array('id' => 2));
        return $query;
        /*$this->db->select('deskripsi');
        $this->db->from('konten_halaman');
        $this->db->where('slug', 'home-bersertifikat');
        $this->db->where('perbolehkan_tampil', 1);
        $query = $this->db->get();

        return $query;*/
    }

    public function get_free_paraben(){
        $query = $this->db->get_where('introduction', array('id' => 3));
        return $query;
        /*$this->db->select('deskripsi');
        $this->db->from('konten_halaman');
        $this->db->where('slug', 'home-free-paraben');
        $this->db->where('perbolehkan_tampil', 1);
        $query = $this->db->get();

        return $query;*/
    }

    public function get_no_allergents(){
        $query = $this->db->get_where('introduction', array('id' => 4));
        return $query;
        /*$this->db->select('deskripsi');
        $this->db->from('konten_halaman');
        $this->db->where('slug', 'home-no-allergents');
        $this->db->where('perbolehkan_tampil', 1);
        $query = $this->db->get();

        return $query;*/
    }

}

/* End of file Home_model.php */
/* Location: ./application/modules/frontend/models/Home_model.php */