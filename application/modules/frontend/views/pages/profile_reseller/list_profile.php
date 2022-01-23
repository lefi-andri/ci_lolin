<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
<div class="row">
  <div class="col-lg-4">
    <?php echo $user_info_menu; ?>
  </div>
  <div class="col-lg-8">
    <div class="padding-top-2x mt-2 hidden-lg-up"></div>

    <?php echo form_open($form_action, array('class'=>'row')); ?>
      
      <?php echo form_hidden('grup_reseller', $this->session->userdata('group')); ?>

      <?php
      if ($this->session->userdata('group') == 'reseller_pribadi') {
      ?>

      
      
      <div class="col-md-12">
        <h3>Data Reseller</h3>
        <p>Masukkan data sesuai data pada Kartu Tanda Penduduk (KTP) anda.</p>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="reseller_id">ID Reseller</label>
          <span class="peringatan"><?php echo form_error('reseller_id'); ?></span>
          <?php
          $form = array(
            'reseller_id' => array(
              'id' => 'reseller_id',
              'name' => 'reseller_id', 
              'value'=>set_value('reseller_id', isset($form_value['reseller_id']) ? $form_value['reseller_id'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required',
              #'disabled' => 'disabled'
            ),
          );
          ?>
          <?php echo form_input($form['reseller_id']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nama Lengkap</label>
          <span class="peringatan"><?php echo form_error('nama_lengkap'); ?></span>
          <?php
          $form = array(
            'nama_lengkap' => array(
              'name' => 'nama_lengkap', 
              'value'=>set_value('nama_lengkap', isset($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nama_lengkap']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-ln">Nomor KTP</label>
          <span class="peringatan"><?php echo form_error('nomor_ktp'); ?></span>
          <?php
          $form = array(
            'nomor_ktp' => array(
              'name' => 'nomor_ktp', 
              'value'=>set_value('nomor_ktp', isset($form_value['nomor_ktp']) ? $form_value['nomor_ktp'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_ktp']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-ln">Tempat Lahir</label>
          <span class="peringatan"><?php echo form_error('tempat_lahir'); ?></span>
          <?php
          $form = array(
            'tempat_lahir' => array(
              'name' => 'tempat_lahir', 
              'value'=>set_value('tempat_lahir', isset($form_value['tempat_lahir']) ? $form_value['tempat_lahir'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['tempat_lahir']); ?>
        </div>
      </div>

     
      <?php list($thn_selected, $bln_selected, $tgl_selected) = explode('-', $form_value['tanggal_lahir']); ?>

      <div class="col-md-2">
        <div class="form-group">
              <label for="account-fn">Tanggal Lahir</label>
              <p style="font-size: 10px;">Tanggal</p>
              <?php echo form_dropdown('tanggal', $dropdown_tanggal, set_value('tanggal', isset($tgl_selected) ? $tgl_selected : ''), array('class' => 'form-control' )); ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
              <label for="account-fn"></label>
              <p style="font-size: 10px;">Bulan</p>
              <?php echo form_dropdown('bulan', $dropdown_bulan, set_value('bulan', isset($bln_selected) ? $bln_selected : ''), array('class' => 'form-control' )); ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
              <label for="account-fn"></label>
              <p style="font-size: 10px;">Tahun</p>
              <?php echo form_dropdown('tahun', $dropdown_tahun, set_value('tahun', isset($thn_selected) ? $thn_selected : ''), array('class' => 'form-control' )); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-ln">Handphone</label>
          <span class="peringatan"><?php echo form_error('nomor_telepon_reseller'); ?></span>
          <?php
          $form = array(
            'nomor_telepon_reseller' => array(
              'name' => 'nomor_telepon_reseller', 
              'value'=>set_value('nomor_telepon_reseller', isset($form_value['nomor_telepon_reseller']) ? $form_value['nomor_telepon_reseller'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_telepon_reseller']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-ln">Alamat</label>
          <span class="peringatan"><?php echo form_error('alamat_reseller'); ?></span>
          <?php
          $form = array(
            'alamat_reseller' => array(
              'name' => 'alamat_reseller', 
              'value'=>set_value('alamat_reseller', isset($form_value['alamat_reseller']) ? $form_value['alamat_reseller'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['alamat_reseller']); ?>
        </div>
      </div>

      <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Email</label>
        <span class="peringatan"><?php echo form_error('email'); ?></span>
        <?php
        $form = array(
          'email' => array(
            'name' => 'email', 
            'value'=>set_value('email', isset($form_value['email']) ? $form_value['email'] : ''),
            'class'=>'form-control',
            'placeholder'=>'',
            'required' => 'required',
            #'disabled' => 'disabled'
          ),
        );
        ?>
        <?php echo form_input($form['email']); ?>
      </div>
    </div>

    <div class="col-md-12">
        <h3>Data Toko</h3>
        <p>Masukkan data sesuai informasi toko anda. Jika anda tidak memiliki informasi apapun, ini boleh dikosongkan.</p>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Nama Toko</label>
        <span class="peringatan"><?php echo form_error('nama_toko'); ?></span>
        <?php
        $form = array(
          'nama_toko' => array(
            'name' => 'nama_toko', 
            'value'=>set_value('nama_toko', isset($form_value['nama_toko']) ? $form_value['nama_toko'] : ''),
            'class'=>'form-control',
            'placeholder'=>'',
            'required' => 'required'
          ),
        );
        ?>
        <?php echo form_input($form['nama_toko']); ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Link Website Toko atau E-Commerce</label>
        <span class="peringatan"><?php echo form_error('link_toko'); ?></span>
        <?php
        $form = array(
          'link_toko' => array(
            'name' => 'link_toko', 
            'value'=>set_value('link_toko', isset($form_value['link_toko']) ? $form_value['link_toko'] : ''),
            'class'=>'form-control',
            'placeholder'=>'http://www.your-shop.com',
            'required' => 'required'
          ),
        );
        ?>
        <?php echo form_input($form['link_toko']); ?>
      </div>
    </div>

    <!--div class="col-md-12">
        <h3>Data Rekening</h3>
        <p>Masukkan data sesuai informasi rekening tabungan bank anda.</p>
    </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nama Bank</label>
          <span class="peringatan"><?php echo form_error('bank_id'); ?></span>
          <?php echo form_dropdown('bank_id', $dropdown_bank, set_value('bank_id', isset($form_value['bank_id']) ? $form_value['bank_id'] : ''), array('class' => 'form-control select2' )); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nomor Rekening</label>
          <span class="peringatan"><?php echo form_error('nomor_rekening'); ?></span>
          <?php
          $form = array(
            'nomor_rekening' => array(
              'name' => 'nomor_rekening', 
              'value'=>set_value('nomor_rekening', isset($form_value['nomor_rekening']) ? $form_value['nomor_rekening'] : ''),
              'class'=>'form-control',
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
          <label for="account-fn">Nama Pemilik Rekening</label>
          <span class="peringatan"><?php echo form_error('nama_pemilik_rekening'); ?></span>
          <?php
          $form = array(
            'nama_pemilik_rekening' => array(
              'name' => 'nama_pemilik_rekening', 
              'value'=>set_value('nama_pemilik_rekening', isset($form_value['nama_pemilik_rekening']) ? $form_value['nama_pemilik_rekening'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php #echo form_input($form['nama_pemilik_rekening']); ?>
        </div>
      </div-->

      <div class="col-md-12">
        <h3>Kata Sandi</h3>
        <p>Jika anda tidak ingi mengganti kata sandi, form dibawah tidak perlu diisi.</p>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Password</label>
          <span class="peringatan"><?php echo form_error('password'); ?></span>
          <?php
            $form = array(
                  'password' => array(
                    'type' => 'password',
                    'name' => 'password',
                    'class'=>'form-control',
                    'placeholder' => 'Password',
                  ),
              );
          ?>
          <?php echo form_input($form['password']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Konfirmasi Password</label>
          <span class="peringatan"><?php echo form_error('password_confirm'); ?></span>
          <?php
            $form = array(
                  'password_confirm' => array(
                    'type' => 'password',
                    'name' => 'password_confirm',
                    'class'=>'form-control',
                    'placeholder' => 'Konfirmasi Password',
                  ),
              );
          ?>
          <?php echo form_input($form['password_confirm']); ?>
        </div>
      </div>
      

<!-- -->

      <?php
      }
      if ($this->session->userdata('group') == 'reseller_organisasi') {
      ?>

      <div class="col-md-12">
        <h3>Data Reseller Organisasi</h3>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">ID Reseller</label>
          <span class="peringatan"><?php echo form_error('reseller_id'); ?></span>
          <?php
          $form = array(
            'reseller_id' => array(
              'name' => 'reseller_id', 
              'value'=>set_value('reseller_id', isset($form_value['reseller_id']) ? $form_value['reseller_id'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required',
              #'disabled' => 'disabled'
            ),
          );
          ?>
          <?php echo form_input($form['reseller_id']); ?>
        </div>
      </div>
            
      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nama Organisasi</label>
          <span class="peringatan"><?php echo form_error('nama_organisasi'); ?></span>
          <?php
          $form = array(
            'nama_organisasi' => array(
              'name' => 'nama_organisasi', 
              'value'=>set_value('nama_organisasi', isset($form_value['nama_organisasi']) ? $form_value['nama_organisasi'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nama_organisasi']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Alamat Organisasi</label>
          <span class="peringatan"><?php echo form_error('alamat_organisasi'); ?></span>
          <?php
          $form = array(
            'alamat_organisasi' => array(
              'name' => 'alamat_organisasi', 
              'value'=>set_value('alamat_organisasi', isset($form_value['alamat_organisasi']) ? $form_value['alamat_organisasi'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['alamat_organisasi']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nomor Telepon Organisasi</label>
          <span class="peringatan"><?php echo form_error('nomor_telepon_organisasi'); ?></span>
          <?php
          $form = array(
            'nomor_telepon_organisasi' => array(
              'name' => 'nomor_telepon_organisasi', 
              'value'=>set_value('nomor_telepon_organisasi', isset($form_value['nomor_telepon_organisasi']) ? $form_value['nomor_telepon_organisasi'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_telepon_organisasi']); ?>
        </div>
      </div>

      <div class="col-md-12">
        <h3>Data Perwakilan</h3>
        <p>Masukkan data sesuai data pada Kartu Tanda Penduduk (KTP) anda.</p>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nama Lengkap</label>
          <span class="peringatan"><?php echo form_error('nama_lengkap'); ?></span>
          <?php
          $form = array(
            'nama_lengkap' => array(
              'name' => 'nama_lengkap', 
              'value'=>set_value('nama_lengkap', isset($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nama_lengkap']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nomor KTP</label>
          <span class="peringatan"><?php echo form_error('nomor_ktp'); ?></span>
          <?php
          $form = array(
            'nomor_ktp' => array(
              'name' => 'nomor_ktp', 
              'value'=>set_value('nomor_ktp', isset($form_value['nomor_ktp']) ? $form_value['nomor_ktp'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_ktp']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-ln">Telepon</label>
          <span class="peringatan"><?php echo form_error('nomor_telepon_reseller'); ?></span>
          <?php
          $form = array(
            'nomor_telepon_reseller' => array(
              'name' => 'nomor_telepon_reseller', 
              'value'=>set_value('nomor_telepon_reseller', isset($form_value['nomor_telepon_reseller']) ? $form_value['nomor_telepon_reseller'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required'
            ),
          );
          ?>
          <?php echo form_input($form['nomor_telepon_reseller']); ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Email</label>
          <span class="peringatan"><?php echo form_error('email'); ?></span>
          <?php
          $form = array(
            'email' => array(
              'name' => 'email', 
              'value'=>set_value('email', isset($form_value['email']) ? $form_value['email'] : ''),
              'class'=>'form-control',
              'placeholder'=>'',
              'required' => 'required',
              #'disabled' => 'disabled'
            ),
          );
          ?>
          <?php echo form_input($form['email']); ?>
        </div>
      </div>

      <div class="col-md-12">
        <h3>Data Toko</h3>
        <p>Masukkan data sesuai informasi toko anda. Jika anda tidak memiliki informasi apapun, ini boleh dikosongkan.</p>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Nama Toko</label>
        <span class="peringatan"><?php echo form_error('nama_toko'); ?></span>
        <?php
        $form = array(
          'nama_toko' => array(
            'name' => 'nama_toko', 
            'value'=>set_value('nama_toko', isset($form_value['nama_toko']) ? $form_value['nama_toko'] : ''),
            'class'=>'form-control',
            'placeholder'=>'',
            'required' => 'required'
          ),
        );
        ?>
        <?php echo form_input($form['nama_toko']); ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Link Website Toko atau E-Commerce</label>
        <span class="peringatan"><?php echo form_error('link_toko'); ?></span>
        <?php
        $form = array(
          'link_toko' => array(
            'name' => 'link_toko', 
            'value'=>set_value('link_toko', isset($form_value['link_toko']) ? $form_value['link_toko'] : ''),
            'class'=>'form-control',
            'placeholder'=>'http://www.your-shop.com',
            'required' => 'required'
          ),
        );
        ?>
        <?php echo form_input($form['link_toko']); ?>
      </div>
    </div>

      <!--div class="col-md-12">
        <h3>Data Rekening</h3>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Nama Bank</label>
          <span class="peringatan"><?php echo form_error('bank_id'); ?></span>
          <?php echo form_dropdown('bank_id', $dropdown_bank, set_value('bank_id', isset($form_value['bank_id']) ? $form_value['bank_id'] : ''), array('class' => 'form-control select2' )); ?>
        </div>
      </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="account-fn">Nomor Rekening</label>
        <span class="peringatan"><?php echo form_error('nomor_rekening'); ?></span>
        <?php
        $form = array(
          'nomor_rekening' => array(
            'name' => 'nomor_rekening', 
            'value'=>set_value('nomor_rekening', isset($form_value['nomor_rekening']) ? $form_value['nomor_rekening'] : ''),
            'class'=>'form-control',
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
        <label for="account-fn">Nama Pemilik Rekening</label>
        <span class="peringatan"><?php echo form_error('nama_pemilik_rekening'); ?></span>
        <?php
        $form = array(
          'nama_pemilik_rekening' => array(
            'name' => 'nama_pemilik_rekening', 
            'value'=>set_value('nama_pemilik_rekening', isset($form_value['nama_pemilik_rekening']) ? $form_value['nama_pemilik_rekening'] : ''),
            'class'=>'form-control',
            'placeholder'=>'',
            'required' => 'required'
          ),
        );
        ?>
        <?php echo form_input($form['nama_pemilik_rekening']); ?>
      </div>
    </div-->

    <div class="col-md-12">
        <h3>Kata Sandi</h3>
        <p>Jika anda tidak ingi mengganti kata sandi, form dibawah tidak perlu diisi.</p>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Password</label>
          <span class="peringatan"><?php echo form_error('password'); ?></span>
          <?php
            $form = array(
                  'password' => array(
                    'type' => 'password',
                    'name' => 'password',
                    'class'=>'form-control',
                    'placeholder' => 'Password',
                  ),
              );
          ?>
          <?php echo form_input($form['password']); ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="account-fn">Konfirmasi Password</label>
          <span class="peringatan"><?php echo form_error('password_confirm'); ?></span>
          <?php
            $form = array(
                  'password_confirm' => array(
                    'type' => 'password',
                    'name' => 'password_confirm',
                    'class'=>'form-control',
                    'placeholder' => 'Konfirmasi Password',
                  ),
              );
          ?>
          <?php echo form_input($form['password_confirm']); ?>
        </div>
      </div>





      <?php
      }
      ?>

      


      

      

      <div class="col-12">
        <div align="right" style="font-size: 10px;">
        	*Dengan menekan tombol dibawah, berarti anda telah menyetujui aturan dan ketentuan yang berlaku dari Lolin Kids Care Product.
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div class="custom-control custom-checkbox d-block">
          </div>

          <?php echo form_submit('submit', 'Update Profile', array('class'=>'btn btn-primary margin-right-none btn-sm')); ?>
        
        </div>
      </div>
    <?php echo form_close(); ?>
  </div>
</div>
</div>