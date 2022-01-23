<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
  <?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <!-- Blog Posts-->
    <div class="col-xl-9 col-lg-8">
      
      <!-- Post-->
      <?php  
      foreach ($rows as $post) {              
      ?>
      <article class="row">
        <div class="col-md-3">
          <ul class="post-meta">
            <?php list($year, $time) = explode(' ', $post->tanggal_posting); ?>
            <?php list($thn, $bln, $tgl) = explode('-', $year); ?>
            <li><i class="icon-clock"></i>&nbsp;<?php echo bulan($bln).' '.$tgl.', '.$thn; ?></li>
            <li><i class="icon-head"></i>&nbsp;<?php echo $post->penulis; ?></li>
            <li><i class="icon-tag"></i><a href="">&nbsp;<?php echo $post->nama_kategori; ?></a></li>
          </ul>
        </div>
        <div class="col-md-9 blog-post"><a class="post-thumb" href="<?php echo base_url(); ?>blog/<?php echo $post->slug; ?>"><img src="<?php echo base_url(); ?>assets/images/blog/gambar_judul/middle_<?php echo $post->nama_gambar_judul; ?>" alt="Post"></a>
          <h3 class="post-title">
            <a href="<?php echo base_url(); ?>blog/<?php echo $post->slug; ?>"><?php echo $post->judul; ?></a> </h3>
          <p>
            <?php
            $num_char = 250;

            $temp_post = strlen($post->konten);
            if ($temp_post >= $num_char) {
              $char     = $post->konten{$num_char - 1};
              while($char != ' ') {
                  $char = $post->konten{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
              }
              echo substr($post->konten, 0, $num_char) . '...';
            ?>
            <a href="<?php echo base_url(); ?>blog/<?php echo $post->slug; ?>" class='text-medium'>Read More</a>
            <?php
            }else{
              echo $post->konten;
            }
            ?>
          </p>
        </div>
      </article>
      <?php  
      }
      ?>
      
      <!-- Pagination-->
      <?php echo $pagination; ?>

    </div>


    <!-- Sidebar -->
    <div class="col-xl-3 col-lg-4">
      <aside class="sidebar sidebar-offcanvas">
        <!-- Widget Search-->
        <section class="widget">
          <?php echo form_open(base_url('blogs/search/pencarian'), array('method' => 'get', 'id'=> 'form', 'class'=>'input-group form-group')); ?>
          <span class="input-group-btn">
              <button type="submit"><i class="icon-search"></i></button></span>
            <input class="form-control" type="search" placeholder="Search blog" name="keyword">
          <?php echo form_close(); ?>

        </section>
        <!-- Widget Categories-->
        <section class="widget widget-categories">
          <h3 class="widget-title">Kategori</h3>
          <ul>
            <?php
            foreach ($kategori_blog->result() as $kategori) {
            ?>
            <?php  
            $jumlah_blog = $this->db->get_where('blog', array('kategori_id'=>$kategori->id))->num_rows();
            ?>
            <li><a href="<?php base_url(); ?>blog"><?php echo $kategori->nama_kategori; ?></a><span><?php echo $jumlah_blog; ?></span></li>
            <?php  
            }
            ?>
          </ul>
        </section>
        <!-- Widget Featured Posts-->
        <section class="widget widget-featured-posts">
          <h3 class="widget-title">Featured Posts</h3>
          <!-- Entry-->
          <?php
          foreach ($random_post->result() as $entry) {
          ?>
          <div class="entry">
            <div class="entry-thumb">
              <a href="<?php echo base_url(); ?>blog/<?php echo $entry->slug; ?>">
                <img src="<?php echo base_url(); ?>assets/images/blog/gambar_judul/small_<?php echo $entry->nama_gambar_judul; ?>" alt="Post">
              </a>
            </div>
            <div class="entry-content">
              <h4 class="entry-title">
                <a href="<?php echo base_url(); ?>blog/<?php echo $entry->slug; ?>"><?php echo $entry->judul; ?></a>
              </h4>
              <span class="entry-meta">by <?php echo $entry->penulis; ?></span>
            </div>
          </div>
          <?php  
          }
          ?>
        </section>

        <!-- Widget Tags-->
        <section class="widget widget-tags">
          <h3 class="widget-title">Popular Tags</h3>
          <?php  
          foreach ($tags->result() as $value_tags) {
          ?>
          <a class="tag" href="">#<?php echo $value_tags->nama_tag; ?></a>
          <?php
          }
          ?>
        </section>

        <!-- Promo Banner-->
        <section class="promo-box" style="background-image: url(<?php echo base_url(); ?>assets/images/iklan/middle_<?php echo $iklan->nama_file; ?>);">
          <span class="overlay-dark" style="opacity: .35;"></span>
          <div class="promo-box-content text-center padding-top-2x padding-bottom-2x">
            <h3 class="text-bold text-light text-shadow"><?php echo $iklan->caption; ?></h3>
            <h4 class="text-light text-thin text-shadow"><?php echo $iklan->deskripsi; ?></h4><a class="btn btn-sm btn-primary" href="<?php echo $iklan->link; ?>">Kunjungi</a>
          </div>
        </section>
      </aside>
    </div>
  </div>
</div>