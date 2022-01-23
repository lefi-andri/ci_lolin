<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php echo $user_info_menu; ?>
    </div>
    <div class="col-lg-8">
      <div class="padding-top-2x mt-2 hidden-lg-up"></div>

        <div class="card bg-secondary text-left mb-3">
          <div class="card-header text-lg">Foto Anda</div>
          <div class="card-body">

            <div class="row">
              <div class="col-sm-4">
                <img class="d-block mx-auto img-thumbnail rounded-circle mb-3" src="<?php echo base_url(); ?>assets/images/foto_profile/<?php echo ($foto)? 'middle_'.$foto : 'user.png'; ?>" alt="Foto Profil">
              </div>
              <div class="col-sm-8">
                <?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
                <div class="form-group row">
                  <label class="col-2 col-form-label" for="file-input">Foto</label>
                  <div class="col-10">
                    <?php echo form_error('nama_file'); ?>
                    <div class="custom-file">
                      <input class="custom-file-input" name="nama_file" type="file" id="file-input" required="required">
                      <label class="custom-file-label" for="file-input">Choose file...</label>
                    </div>
                  </div>
                </div>
                <p>Pilih foto dengan bentuk kotak, ukuran file maksimal 2 Mb</p>

                  <?php echo form_submit('submit', 'Update', array('class' => 'btn btn-outline-primary')); ?>
                  <?php echo anchor('member/photo_profile/delete', 'Hapus Foto', array('title'=>"Hapus foto profil", 'class' => 'btn btn-outline-secondary', 'onclick' => "return confirm('Anda ingin menghapus foto profil ?')")); ?>
                <?php echo form_close(); ?>
              </div>
            </div>

            

          </div>
        </div>
        
        
    </div>
  </div>
</div>