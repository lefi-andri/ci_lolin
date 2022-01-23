<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah kategori blog</h2>
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
          <label for="inputEmail3" class="col-sm-2 control-label">Pertanyaan</label>
          <div class="col-sm-10">
            <?php echo form_error('pertanyaan'); ?>
            <?php 
            $pertanyaan = set_value('pertanyaan', isset($form_value['pertanyaan']) ? $form_value['pertanyaan'] : '');
            ?>
            <textarea name="pertanyaan" class="form-control ckeditor" required="required"><?php echo $pertanyaan; ?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Jawaban</label>
          <div class="col-sm-10">
            <?php echo form_error('jawaban'); ?>
            <?php 
            $jawaban = set_value('jawaban', isset($form_value['jawaban']) ? $form_value['jawaban'] : '');
            ?>
            <textarea name="jawaban" class="form-control ckeditor" required="required"><?php echo $jawaban; ?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Label</label>
          <div class="col-sm-10">
            <?php echo form_error('label'); ?>
            <?php  
              $form = array(
                'label' => array(
                  'name' => 'label', 
                  'value'=>set_value('label', isset($form_value['label']) ? $form_value['label'] : ''),
                  'class'=>'form-control'
                ),
              );
            ?>
            <?php echo form_input($form['label']); ?>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Urutan</label>
          <div class="col-sm-2">
            <?php echo form_error('urutan'); ?>
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

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Tampilkan FAQ</label>
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
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>