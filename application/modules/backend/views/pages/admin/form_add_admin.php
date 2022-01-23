<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah admin</h2>
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