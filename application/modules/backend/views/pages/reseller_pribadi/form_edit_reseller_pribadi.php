<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update data reseller pribadi</h2>
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
        
<?php echo form_open($form_action, array('class'=>'form-horizontal')); ?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">Pilih Paket Reseller</label>
  <div class="col-sm-10">
    <?php echo form_error('paket_id'); ?>
    <?php echo form_dropdown('paket_id', $dropdown_paket_reseller, set_value('paket_reseller_id', isset($form_value['paket_reseller_id']) ? $form_value['paket_reseller_id'] : ''), array('class' => 'form-control')); ?>
  </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nama Lengkap:</label>
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

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Tempat Lahir:</label>
      <div class="col-sm-10">
      <?php echo form_error('tempat_lahir'); ?>
      <?php  
      $form = array(
            'tempat_lahir' => array(
                  'name' => 'tempat_lahir', 
                  'value'=>set_value('tempat_lahir', isset($form_value['tempat_lahir']) ? $form_value['tempat_lahir'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['tempat_lahir']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Tanggal Lahir:</label>

      <?php list($thn_selected, $bln_selected, $tgl_selected) = explode('-', $form_value['tanggal_lahir']); ?>

      <div class="col-sm-1">
            <?php echo form_dropdown('tanggal', $dropdown_tanggal, set_value('tanggal', isset($tgl_selected) ? $tgl_selected : ''), array('class' => 'form-control' )); ?>
      </div>
      <div class="col-sm-1">
            <?php echo form_dropdown('bulan', $dropdown_bulan, set_value('bulan', isset($bln_selected) ? $bln_selected : ''), array('class' => 'form-control' )); ?>
      </div>
      <div class="col-sm-2">
            <?php echo form_dropdown('tahun', $dropdown_tahun, set_value('tahun', isset($thn_selected) ? $thn_selected : ''), array('class' => 'form-control' )); ?>
      </div>

</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Nomor Telepon:</label>
      <div class="col-sm-10">
      <?php echo form_error('nomor_telepon_reseller'); ?>
      <?php  
      $form = array(
            'nomor_telepon_reseller' => array(
                  'name' => 'nomor_telepon_reseller', 
                  'value'=>set_value('nomor_telepon_reseller', isset($form_value['nomor_telepon_reseller']) ? $form_value['nomor_telepon_reseller'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['nomor_telepon_reseller']); ?>
      </div>
</div>

<div class="form-group">
      <label for="" class="col-sm-2 control-label">Alamat:</label>
      <div class="col-sm-10">
      <?php echo form_error('alamat_reseller'); ?>
      <?php  
      $form = array(
            'alamat_reseller' => array(
                  'name' => 'alamat_reseller', 
                  'value'=>set_value('alamat_reseller', isset($form_value['alamat_reseller']) ? $form_value['alamat_reseller'] : ''),
                  'class'=>'form-control'
            ),
      );
      ?>
      <?php echo form_input($form['alamat_reseller']); ?>
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
      <label for="" class="col-sm-2 control-label">Email: <i>email anda <?php echo set_value('email', isset($form_value['email']) ? $form_value['email'] : ''); ?></i></label>
      <div class="col-sm-10">
      <?php echo form_error('email'); ?>
      <?php 
      $form = array(
            'email' => array(
                  'name' => 'email',
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
            <?php echo form_submit('submit', 'Update', array('class'=>'btn btn-dark btn-sm')); ?>
      </div>
</div>

      
<?php echo form_close(); ?>




      </div>
    </div>
  </div>
</div>