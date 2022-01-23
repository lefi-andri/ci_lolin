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
          <label for="inputEmail3" class="col-sm-2 control-label">Nama Kategori Produk <b class="peringatan">*</b></label>
          <div class="col-sm-10">
            <span class="peringatan"><?php echo form_error('nama_kategori'); ?></span>
            <?php  
              $form = array(
                'nama_kategori' => array(
                  'name' => 'nama_kategori', 
                  'value'=>set_value('nama_kategori', isset($form_value['nama_kategori']) ? $form_value['nama_kategori'] : ''),
                  'class'=>'form-control'
                ),
              );
            ?>
            <?php echo form_input($form['nama_kategori']); ?>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Tampilkan Kategori Produk <b class="peringatan">*</b></label>
          <div class="col-sm-10">
          <span class="peringatan"><?php echo form_error('perbolehkan_tampil'); ?></span>
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