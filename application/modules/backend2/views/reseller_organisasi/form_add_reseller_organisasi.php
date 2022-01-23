<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah reseller organisasi</h2>
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

        
<?php echo form_open($form_action, array('class' => 'form-horizontal')); ?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">Pilih Paket Distributor</label>
  <div class="col-sm-10">
    <?php echo form_error('paket_id'); ?>
    <?php echo form_dropdown('paket_id', $dropdown_paket_distributor, set_value('paket_id', isset($form_value['paket_id']) ? $form_value['paket_id'] : ''), array('class' => 'form-control')); ?>
  </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nama Organisasi:</label>
      <div class="col-sm-10">
      <?php echo form_error('nama_organisasi'); ?>
      <?php  
      $form = array(
            'nama_organisasi' => array(
                  'name' => 'nama_organisasi', 
                  'value'=>set_value('nama_organisasi', isset($form_value['nama_organisasi']) ? $form_value['nama_organisasi'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nama_organisasi']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Alamat Organisasi:</label>
      <div class="col-sm-10">
      <?php echo form_error('alamat_organisasi'); ?>
      <?php  
      $form = array(
            'alamat_organisasi' => array(
                  'name' => 'alamat_organisasi', 
                  'value'=>set_value('alamat_organisasi', isset($form_value['alamat_organisasi']) ? $form_value['alamat_organisasi'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['alamat_organisasi']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nomor Telepon Organisasi:</label>
      <div class="col-sm-10">
      <?php echo form_error('nomor_telepon_organisasi'); ?>
      <?php  
      $form = array(
            'nomor_telepon_organisasi' => array(
                  'name' => 'nomor_telepon_organisasi', 
                  'value'=>set_value('nomor_telepon_organisasi', isset($form_value['nomor_telepon_organisasi']) ? $form_value['nomor_telepon_organisasi'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nomor_telepon_organisasi']); ?>
      </div>
</div>

<hr>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nama Lengkap Perwakilan:</label>
      <div class="col-sm-10">
      <?php echo form_error('nama_lengkap'); ?>
      <?php  
      $form = array(
            'nama_lengkap' => array(
                  'name' => 'nama_lengkap', 
                  'value'=>set_value('nama_lengkap', isset($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nama_lengkap']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nomor KTP:</label>
      <div class="col-sm-10">
      <?php echo form_error('nomor_ktp'); ?>
      <?php  
      $form = array(
            'nomor_ktp' => array(
                  'name' => 'nomor_ktp', 
                  'value'=>set_value('nomor_ktp', isset($form_value['nomor_ktp']) ? $form_value['nomor_ktp'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nomor_ktp']); ?>
      </div>
</div>

<hr>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nama Bank:</label>
      <div class="col-sm-4">
      <?php echo form_error('bank_id'); ?>
      <?php echo form_dropdown('bank_id', $dropdown_bank, set_value('bank_id', isset($form_value['bank_id']) ? $form_value['bank_id'] : ''), array('class' => 'form-control select2' )); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nomor Rekening:</label>
      <div class="col-sm-8">
      <?php echo form_error('nomor_rekening'); ?>
      <?php  
      $form = array(
            'nomor_rekening' => array(
                  'name' => 'nomor_rekening', 
                  'value'=>set_value('nomor_rekening', isset($form_value['nomor_rekening']) ? $form_value['nomor_rekening'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nomor_rekening']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nama Pemilik Rekening:</label>
      <div class="col-sm-10">
      <?php echo form_error('nama_pemilik_rekening'); ?>
      <?php  
      $form = array(
            'nama_pemilik_rekening' => array(
                  'name' => 'nama_pemilik_rekening', 
                  'value'=>set_value('nama_pemilik_rekening', isset($form_value['nama_pemilik_rekening']) ? $form_value['nama_pemilik_rekening'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nama_pemilik_rekening']); ?>
      </div>
</div>

<hr>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Email:</label>
      <div class="col-sm-10">
      <?php echo form_error('email'); ?>
      <?php 
      $form = array(
            'email' => array(
                  'name' => 'email',
                  'value'=>set_value('email', isset($form_value['email']) ? $form_value['email'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['email']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Password:</label>
      <div class="col-sm-10">
      <?php echo form_error('password'); ?>
      <?php 
      $form = array(
            'password' => array(
                  'name' => 'password',
                  'type' => 'password',
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['password']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Confirm Password:</label>
      <div class="col-sm-10">
      <?php echo form_error('password_confirm'); ?>
      <?php 
      $form = array(
            'password_confirm' => array(
                  'name' => 'password_confirm',
                  'type' => 'password',
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['password_confirm']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
      </div>
</div>

      
<?php echo form_close();?>




      </div>
    </div>
  </div>
</div>