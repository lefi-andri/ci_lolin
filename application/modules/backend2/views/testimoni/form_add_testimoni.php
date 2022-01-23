<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah Testimoni</h2>
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
          <div class="col-md-8">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">File Gambar</label>
              <div class="col-sm-10">
                <span><?php echo form_error('nama_file'); ?></span>
                <?php
                $form = array(
                  'nama_file' => array(
                    'name'      => 'nama_file', 
                    'value'     => set_value('nama_file', isset($form_value['nama_file']) ? $form_value['nama_file'] : ''),    
                  ),
                );
                ?>
                <?php echo form_upload($form['nama_file']); ?>
              </div>      
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Caption</label>
              <div class="col-sm-8">
                <?php echo form_error('caption'); ?>
                <?php  
                  $form = array(
                    'caption' => array(
                      'name' => 'caption', 
                      'value'=>set_value('caption', isset($form_value['caption']) ? $form_value['caption'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['caption']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
              <div class="col-sm-10">
                <?php echo form_error('deskripsi'); ?>
                <?php 
                $deskripsi = set_value('deskripsi', isset($form_value['deskripsi']) ? $form_value['deskripsi'] : '');
                ?>
                <textarea name="deskripsi" class="form-control"><?php echo $deskripsi; ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Urutan</label>
              <div class="col-sm-2">
                <span class="peringatan"><?php echo form_error('urutan'); ?></span>
                <?php  
                  $form = array(
                    'urutan' => array(
                      'name' => 'urutan', 
                      'value'=> set_value('urutan', isset($form_value['urutan']) ? $form_value['urutan'] : ''),
                      'class'=> 'form-control',
                      'type' => 'number'
                    ),
                  );
                ?>
                <?php echo form_input($form['urutan']); ?>
              </div>
            </div>

          </div>
          <div class="col-md-4">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Perbolehkan Tampil</label>
              <div class="col-sm-8">
              <?php echo form_error('perbolehkan_tampil'); ?>
                <label class="radio-inline">
                        <?php echo form_radio('perbolehkan_tampil', '1', set_radio('perbolehkan_tampil', '1', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Ya</label>
                    <label class="radio-inline">
                        <?php echo form_radio('perbolehkan_tampil', '0', set_radio('perbolehkan_tampil', '0', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Tidak</label>
                </div>
            </div>
            
          </div>
        </div>

        

        

        <hr>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label"></label>
          <div class="col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>

        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>