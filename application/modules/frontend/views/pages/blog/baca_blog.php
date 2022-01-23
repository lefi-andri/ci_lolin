      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-2">
        <?php $this->load->view('include/template/message'); ?>
        <div class="row justify-content-center">
          <!-- Content-->
          <div class="col-lg-10">
            <!-- Post-->
            <?php  
      			foreach ($content as $val) {
      			?>
            <div class="single-post-meta">
              <div class="column">
                <div class="meta-link"><span>by</span><?php echo $val->penulis; ?></div>
                <div class="meta-link"><span>in</span><a href="#"><?php echo $val->nama_kategori; ?></a></div>
              </div>
              <div class="column">
                <?php list($year, $time) = explode(' ', $val->tanggal_posting); ?>
                <?php list($thn, $bln, $tgl) = explode('-', $year); ?>
                <div class="meta-link"><a href="#"><i class="icon-clock"></i><?php echo bulan($bln).' '.$tgl.', '.$thn; ?></a></div>
                <!--div class="meta-link"><a class="scroll-to" href="#comments"><i class="icon-speech-bubble"></i>3</a></div-->
              </div>
            </div>

            <div align="center">
            	<img src="<?php echo base_url("assets/images/blog/gambar_posting/middle_$val->nama_gambar_posting") ?>" class="img-responsive" alt="Article Images">
            </div>
            
            <h2 class="padding-top-2x"><?php echo $val->judul; ?></h2>
            <p><?php echo $val->konten; ?></p>
            <div align="right">
              <b><i>Sumber : <?php echo $val->sumber_berita; ?></i></b>
            </div>
            <div class="single-post-footer">
              <div class="column">
                <?php  
                $tag = unserialize($val->tag_id);
                foreach ($tag as $value_tag) {
                  $tagname = $this->db->get_where('tags_blog', array('id' => $value_tag))->row();
                  echo '<a class="sp-tag" href="">&nbsp;#'.$tagname->nama_tag.'</a> ';
                }
                ?>
              </div>
              <div class="column">
                <div class="entry-share"><span class="text-muted">Bagikan post:</span>

                <div class="share-links">
                <?php $share = 'http://www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
                <?php echo anchor("http://www.facebook.com/share.php?u=$share", '<i class="socicon-facebook"></i>', array('class'=>'social-button shape-circle sb-facebook', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Facebook')); ?>
                <?php echo anchor("http://twitter.com/share?url=$share&text=$val->judul", '<i class="socicon-twitter"></i>', array('class'=>'social-button shape-circle sb-twitter', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Twitter')); ?>
                <?php echo anchor("https://plus.google.com/share?url=$share", '<i class="socicon-googleplus"></i>', array('class'=>'social-button shape-circle sb-google-plus', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Google +')); ?>
                <?php echo anchor("http://www.linkedin.com/shareArticle?mini=true&url='.$share.'&title=$val->judul", '<i class="socicon-linkedin"></i>', array('class'=>'social-button shape-circle sb-linkedin', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Linked In')); ?>
                </div>
                
                </div>
              </div>
            </div>
            <?php

            $this->db->from('konten_blog');
            $this->db->where('blog_id', $val->id);
            $this->db->where('konten !=', '');
            $query = $this->db->count_all_results();

            if ($query == '1') {
              echo "";
            }else{
              $this->db->select('konten_blog.halaman');
              $this->db->from('blog');
              $this->db->join('konten_blog', 'konten_blog.blog_id = blog.id');
              $this->db->where('konten_blog.blog_id', $val->id);
              $this->db->where('konten_blog.konten !=', '');
              $query = $this->db->get();

              echo '<p>Halaman :</p>';
              foreach ($query->result() as $value) {
                $class_button = ($this->uri->segment(3) == $value->halaman) ? 'btn btn-primary' : 'btn btn-secondary';
                echo anchor(base_url().'blog/'.$val->slug.'/'.$value->halaman, $value->halaman, array('class' => $class_button));
              }
            }
    			}
    			?>
            <!-- Post Navigation-->
            <div class="entry-navigation">
              <div class="column text-left">
              	<?php echo $link_prev; ?>
              </div>
              <div class="column">
              	<a class="btn btn-outline-secondary view-all" href="<?php echo $link_home; ?>" data-toggle="tooltip" data-placement="top" title="All posts"><i class="icon-menu"></i></a>
              </div>
              
              <div class="column text-right">
                <?php echo $link_next; ?>
              </div>
            </div>
            <!-- Relevant Posts-->
            <h3 class="padding-top-3x padding-bottom-1x">Baca juga</h3>
            <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: false, &quot;autoHeight&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}} }">
            <?php
      			foreach ($random_post->result() as $entry) {
      			?>
              <div class="widget widget-featured-posts">
                <div class="entry">
                  <div class="entry-thumb"><a href="<?php echo base_url(); ?>blog/<?php echo $entry->slug; ?>"><img src="<?php echo base_url(); ?>assets/images/blog/gambar_judul/small_<?php echo $entry->nama_gambar_judul; ?>" alt="Post"></a></div>
                  <div class="entry-content">
                    <h4 class="entry-title"><a href="<?php echo base_url(); ?>blog/<?php echo $entry->slug; ?>"><?php echo $entry->judul; ?></a></h4><span class="entry-meta">by <?php echo $entry->penulis; ?></span>
                  </div>
                </div>
              </div>
    				<?php  
    				}
    				?>
            </div>
          </div>
        </div>
      </div>