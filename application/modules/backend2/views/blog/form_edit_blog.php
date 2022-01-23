<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update blog</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
        
        <div class="row">
          <div class="col-md-6">
            
            <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Kategori Blog</label>
                  <div class="col-sm-10">
                  <?php echo form_error('kategori_id'); ?>
                  <?php echo form_dropdown('kategori_id', $dropdown_kategori_blog, set_value('kategori_id', isset($form_value['kategori_id']) ? $form_value['kategori_id'] : ''), array('class' => 'form-control select2' )); ?>
                  </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-10">
                <span class="peringatan"><?php echo form_error('judul'); ?></span>
                <?php  
                  $form = array(
                    'judul' => array(
                      'name' => 'judul', 
                      'value'=>set_value('judul', isset($form_value['judul']) ? $form_value['judul'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['judul']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Sub Judul</label>
              <div class="col-sm-10">
                <?php echo form_error('sub_judul'); ?>
                <?php  
                  $form = array(
                    'sub_judul' => array(
                      'name' => 'sub_judul', 
                      'value'=>set_value('sub_judul', isset($form_value['sub_judul']) ? $form_value['sub_judul'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['sub_judul']); ?>
              </div>
            </div>

          </div>
          <div class="col-md-6">
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Penulis</label>
              <div class="col-sm-10">
                <?php echo form_error('penulis'); ?>
                <?php  
                  $form = array(
                    'penulis' => array(
                      'name' => 'penulis', 
                      'value'=>set_value('penulis', isset($form_value['penulis']) ? $form_value['penulis'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['penulis']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Keyword</label>
              <div class="col-sm-10">
                <?php echo form_error('keyword'); ?>
                <?php  
                  $form = array(
                    'keyword' => array(
                      'name' => 'keyword', 
                      'value'=>set_value('keyword', isset($form_value['keyword']) ? $form_value['keyword'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['keyword']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Sumber Berita</label>
              <div class="col-sm-10">
                <?php echo form_error('sumber_berita'); ?>
                <?php  
                  $form = array(
                    'sumber_berita' => array(
                      'name' => 'sumber_berita', 
                      'value'=>set_value('sumber_berita', isset($form_value['sumber_berita']) ? $form_value['sumber_berita'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['sumber_berita']); ?>
              </div>
            </div>

          </div>
        </div>

        

        

        

        <hr>

        <?php 
        $data = $this->db->get_where('konten_blog', array('blog_id' => $blog_id, 'halaman' => '1'))->row();
        ?>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label">Konten</label>
          <div class="col-sm-11">
            <?php echo form_error('konten[]'); ?>
            <?php 
            $konten = set_value('konten[]', isset($data->konten) ? $data->konten : '');
            ?>
            <textarea name="konten[]" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
            <?php echo form_hidden('halaman[]', '1'); ?>
          </div>
        </div>

        <?php 
        $data = $this->db->get_where('konten_blog', array('blog_id' => $blog_id, 'halaman' => '2'))->row();
        ?>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label">Konten</label>
          <div class="col-sm-11">
            <?php echo form_error('konten[]'); ?>
            <?php 
            $konten = set_value('konten[]', isset($data->konten) ? $data->konten : '');
            ?>
            <textarea name="konten[]" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
            <?php echo form_hidden('halaman[]', '2'); ?>
          </div>
        </div>

        <?php 
        $data = $this->db->get_where('konten_blog', array('blog_id' => $blog_id, 'halaman' => '3'))->row();
        ?>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label">Konten</label>
          <div class="col-sm-11">
            <?php echo form_error('konten[]'); ?>
            <?php 
            $konten = set_value('konten[]', isset($data->konten) ? $data->konten : '');
            ?>
            <textarea name="konten[]" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
            <?php echo form_hidden('halaman[]', '3'); ?>
          </div>
        </div>

        <?php 
        $data = $this->db->get_where('konten_blog', array('blog_id' => $blog_id, 'halaman' => '4'))->row();
        ?>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label">Konten</label>
          <div class="col-sm-11">
            <?php echo form_error('konten[]'); ?>
            <?php 
            $konten = set_value('konten[]', isset($data->konten) ? $data->konten : '');
            ?>
            <textarea name="konten[]" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
            <?php echo form_hidden('halaman[]', '4'); ?>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Gambar Judul</label>
              <div class="col-sm-8">
                <span><?php echo form_error('nama_gambar_judul'); ?></span>
                <?php
                $form = array(
                  'nama_gambar_judul' => array(
                    'name'      => 'nama_gambar_judul', 
                    'value'     => set_value('nama_gambar_judul', isset($form_value['nama_gambar_judul']) ? $form_value['nama_gambar_judul'] : ''),    
                  ),
                );
                ?>
                <?php echo form_upload($form['nama_gambar_judul']); ?>
              </div>      
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Caption Gambar Judul</label>
              <div class="col-sm-8">
                <?php echo form_error('caption_gambar_judul'); ?>
                <?php  
                  $form = array(
                    'caption_gambar_judul' => array(
                      'name' => 'caption_gambar_judul', 
                      'value'=>set_value('caption_gambar_judul', isset($form_value['caption_gambar_judul']) ? $form_value['caption_gambar_judul'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['caption_gambar_judul']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Gambar Posting</label>
              <div class="col-sm-8">
                <span><?php echo form_error('nama_gambar_posting'); ?></span>
                <?php
                $form = array(
                  'nama_gambar_posting' => array(
                    'name'      => 'nama_gambar_posting', 
                    'value'     => set_value('nama_gambar_posting', isset($form_value['nama_gambar_posting']) ? $form_value['nama_gambar_posting'] : ''),    
                  ),
                );
                ?>
                <?php echo form_upload($form['nama_gambar_posting']); ?>
              </div>      
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Caption Gambar Posting</label>
              <div class="col-sm-8">
                <?php echo form_error('caption_gambar_posting'); ?>
                <?php  
                  $form = array(
                    'caption_gambar_posting' => array(
                      'name' => 'caption_gambar_posting', 
                      'value'=>set_value('caption_gambar_posting', isset($form_value['caption_gambar_posting']) ? $form_value['caption_gambar_posting'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['caption_gambar_posting']); ?>
              </div>
            </div>
            
          </div>
          <div class="col-md-6">
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Tags</label>
              <div class="col-sm-10">
                <?php echo form_error('nama_tag[]'); ?>
                <?php

                $tag_id =isset($form_value['tag_id']) ? $form_value['tag_id'] : '';

                $data_tags = $this->db->get('tags_blog');

                if (!empty($form_value['tag_id'])) {
                  $selected_tags = unserialize($tag_id);
                  foreach ($data_tags->result() as $key => $value) {
                    if (in_array($value->id, $selected_tags)) { 
                    ?>
                    <div class="checkbox">
                      <label>
                        <input name="nama_tag[]" type="checkbox" class='flat' value="<?php echo $value->id; ?>" checked> <?php echo $value->nama_tag; ?>
                      </label>
                    </div>
                    <?php
                    }else{
                    ?>
                    <div class="checkbox">
                      <label>
                        <input name="nama_tag[]" type="checkbox" class='flat' value="<?php echo $value->id; ?>"> <?php echo $value->nama_tag; ?>
                      </label>
                    </div>
                    <?php
                    }
                  }
                }else{
                  foreach ($data_tags->result() as $key_null => $value_null) {
                ?>
                <div class="checkbox">
                  <label>
                    <input name="nama_tag[]" type="checkbox" class='flat' value="<?php echo $value_null->id; ?>"> <?php echo $value_null->nama_tag; ?>
                  </label>
                </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>

          </div>
        </div>

        <hr>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Perbolehkan Komentar</label>
          <div class="col-sm-10">
          <?php echo form_error('perbolehkan_komentar'); ?>
            <label class="radio-inline">
                    <?php echo form_radio('perbolehkan_komentar', '1', set_radio('perbolehkan_komentar', '1', isset($form_value['perbolehkan_komentar']) && $form_value['perbolehkan_komentar'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                Ya</label>
                <label class="radio-inline">
                    <?php echo form_radio('perbolehkan_komentar', '0', set_radio('perbolehkan_komentar', '0', isset($form_value['perbolehkan_komentar']) && $form_value['perbolehkan_komentar'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                Tidak</label>
            </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Perbolehkan Tampil</label>
          <div class="col-sm-10">
          <?php echo form_error('perbolehkan_tampil'); ?>
            <label class="radio-inline">
                    <?php echo form_radio('perbolehkan_tampil', '1', set_radio('perbolehkan_tampil', '1', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                Ya</label>
                <label class="radio-inline">
                    <?php echo form_radio('perbolehkan_tampil', '0', set_radio('perbolehkan_tampil', '0', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                Tidak</label>
            </div>
        </div>

        <hr>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Update', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>
        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>