<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php echo $user_info_menu; ?>
    </div>
    <div class="col-lg-8">
      <div class="padding-top-2x mt-2 hidden-lg-up"></div>

        <div align="center">
          <h3>Penukaran Poin</h3>
        </div>

        <?php echo form_open($form_action); ?>
        <hr class="margin-bottom-1x">
        <div class="form-group row">
          <label class="col-2 col-form-label" for="text-input">Jumlah Poin</label>
          <div class="col-10">
            <?php echo $poin_saat_ini; ?> Poin Aktif
          </div>
        </div>
        <div class="form-group row">
          <label class="col-2 col-form-label" for="bonus_poin_id">Penukaran Poin</label>
          <div class="col-10">
            <span><?php echo form_error('bonus_poin_id'); ?></span> 
            <?php echo form_dropdown('bonus_poin_id', $dd_tukar_poin, set_value('bonus_poin_id', isset($form_value['bonus_poin_id']) ? $form_value['bonus_poin_id'] : ''), array('class' => 'form-control form-control-rounded form-control-sm', 'required' => 'required', 'id' => 'bonus_poin_id')); ?>
          </div>
        </div>



<!-- -->

    <div class="col-md-12">
        <h3>Data Rekening</h3>
        <p>Masukkan data sesuai informasi rekening tabungan bank anda.</p>
    </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="bank">Nama Bank</label>
          <span class="peringatan"><?php echo form_error('bank_id'); ?></span>
          <?php echo form_dropdown('bank_id', $dropdown_bank, set_value('bank_id', isset($form_value['bank_id']) ? $form_value['bank_id'] : ''), array('class' => 'form-control', 'id' => 'bank', 'required' => 'required')); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="nomor_rekening">Nomor Rekening</label>
          <span class="peringatan"><?php echo form_error('nomor_rekening'); ?></span>
          <?php
          $form = array(
            'nomor_rekening' => array(
              'id' => 'nomor_rekening',
              'name' => 'nomor_rekening',
              'value'=>set_value('nomor_rekening', isset($form_value['nomor_rekening']) ? $form_value['nomor_rekening'] : ''),
              'class'=>'form-control form-control-rounded form-control-sm',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_rekening']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="nama_pemilik_rekening">Nama Pemilik Rekening</label>
          <span class="peringatan"><?php echo form_error('nama_pemilik_rekening'); ?></span>
          <?php
          $form = array(
            'nama_pemilik_rekening' => array(
              'id' => 'nama_pemilik_rekening',
              'name' => 'nama_pemilik_rekening',
              'value'=>set_value('nama_pemilik_rekening', isset($form_value['nama_pemilik_rekening']) ? $form_value['nama_pemilik_rekening'] : ''),
              'class'=>'form-control form-control-rounded form-control-sm',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nama_pemilik_rekening']); ?>
        </div>
      </div>


      <div class="col-md-12">
        <p>Masukkan ulang kata sandi akun Lolin anda.</p>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="password">Password</label>
          <span class="peringatan"><?php echo form_error('password'); ?></span>
          <?php
            $form = array(
                  'password' => array(
                    'id' => 'password',
                    'type' => 'password',
                    'name' => 'password',
                    'value'=>set_value('password', isset($form_value['password']) ? $form_value['password'] : ''),
                    'class'=>'form-control form-control-rounded form-control-sm',
                    'placeholder' => 'Password',
                    'required' => 'required'
                  ),
              );
          ?>
          <?php echo form_input($form['password']); ?>
        </div>
      </div>

<!-- -->






        <?php echo form_submit('submit', 'Ya', array('class' => 'btn btn-primary btn-sm')); ?>
        <?php echo anchor($this->session->userdata('lolin_urlback_frontend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Tidak', array('class' => 'btn btn-secondary btn-sm' )); ?>

        <?php echo form_close(); ?>
        
        <?php echo $table; ?>
        <!--a href="#kotak" class="btn btn-primary btn-sm" data-toggle="collapse">Klik Disini</a>
        <div id="kotak" class="collapse">
          
        </div-->

        <!--hr>
        <p>Anda bisa menukarkan poin yang anda miliki sesuai tabel ponukaran poin berikut :</p>

        <div class="card bg-secondary text-center mb-3">
          <div class="card-header text-lg">Bonus</div>
          <div class="card-body">
            <?php #echo $table; ?>
          </div>
        </div-->

    </div>
  </div>
</div>