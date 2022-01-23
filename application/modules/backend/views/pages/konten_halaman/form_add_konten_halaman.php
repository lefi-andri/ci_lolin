<script>
function showDetails(bookURL){
       window.open(bookURL,"bookDetails","width=600,height=430,scrollbars=yes");              
    }
</script>

<?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
          <div class="form-group">
            <label for="judul">Judul</label>
                <?php echo form_error('judul'); ?>
                <?php  
                  $form = array(
                    'judul' => array(
                      'id' => 'judul',
                      'name' => 'judul', 
                      'value'=>set_value('judul', isset($form_value['judul']) ? $form_value['judul'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['judul']); ?>
          </div>
      </div>
      <div class="col-md-6">
            
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
                <?php echo form_error('deskripsi'); ?>
                <?php 
                $deskripsi = set_value('deskripsi', isset($form_value['deskripsi']) ? $form_value['deskripsi'] : '');
                ?>
                <textarea name="deskripsi" id="deskripsi" class="form-control ckeditor"><?php echo $deskripsi; ?></textarea>
                <br>
                <p onclick="return showDetails('<?php echo base_url("backend/unggah_gambar/index"); ?>');" title="Upload Gambar" class="btn btn-warning btn-xs"><i class="fa fa-file-photo-o"></i> Upload Gambar</p>
            </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
            <div class="form-group">
              <label for="deskripsi_seo">Deskripsi Seo</label>
                <?php echo form_error('deskripsi_seo'); ?>
                <?php 
                $deskripsi_seo = set_value('deskripsi_seo', isset($form_value['deskripsi_seo']) ? $form_value['deskripsi_seo'] : '');
                ?>
                <textarea name="deskripsi_seo" id="deskripsi_seo" class="form-control"><?php echo $deskripsi_seo; ?></textarea>
                <small id="emailHelp" class="form-text text-muted">Dibutuhkan agar website kita dapat di indeks oleh mesin pencari (Search engine)</small>
            </div>

            <div class="form-group">
              <label for="keyword_seo">Keyword Seo</label>
                <?php echo form_error('keyword_seo'); ?>
                <?php 
                $keyword_seo = set_value('keyword_seo', isset($form_value['keyword_seo']) ? $form_value['keyword_seo'] : '');
                ?>
                <textarea name="keyword_seo" id="keyword_seo" class="form-control"><?php echo $keyword_seo; ?></textarea>
                <small id="emailHelp" class="form-text text-muted">Dibutuhkan agar website kita dapat di indeks oleh mesin pencari (Search engine), pisahkan dengan koma</small>
            </div>

      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="">Status Halaman</label>
              <?php echo form_error('status_id'); ?>
              <?php echo form_dropdown('status_id', $dropdown_status, set_value('status_id', isset($form_value['status_id']) ? $form_value['status_id'] : ''), array('class' => 'form-control' )); ?>
            </div>

            <div class="form-group">
              <label for="inputEmail3">Tampilkan Sebagai Peta Situs</label>
              <?php echo form_error('peta_situs'); ?>
              <br>
              <label class="radio-inline">
                      <?php echo form_radio('peta_situs', '1', set_radio('peta_situs', '1', isset($form_value['peta_situs']) && $form_value['peta_situs'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                  Ya</label>
                  <label class="radio-inline">
                      <?php echo form_radio('peta_situs', '0', set_radio('peta_situs', '0', isset($form_value['peta_situs']) && $form_value['peta_situs'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                  Tidak</label>
            </div>

            <div class="form-group">
              <label for="inputEmail3">Perbolehkan Tampil</label>
              <br>
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
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label"></label>
          <div class="col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>