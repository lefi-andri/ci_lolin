<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah tags blog</h2>
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
          <label for="inputEmail3" class="col-sm-2 control-label">Nama Tag <b class="peringatan">*</b></label>
          <div class="col-sm-6">
            <span class="peringatan"><?php echo form_error('nama_tag'); ?></span>
            <?php  
              $form = array(
                'nama_tag' => array(
                  'name' => 'nama_tag', 
                  'value'=>set_value('nama_tag', isset($form_value['nama_tag']) ? $form_value['nama_tag'] : ''),
                  'class'=>'form-control'
                ),
              );
            ?>
            <?php echo form_input($form['nama_tag']); ?>
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