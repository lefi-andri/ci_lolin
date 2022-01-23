<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2></h2>
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
    <?php echo form_open($form_action); ?>
    <h4>Apakah ingin menonaktifkan akun admin ?</h4>
      <p>
        <label for="confirm">Yes:</label>
    <input type="radio" name="confirm" value="yes" checked="checked" />
        <label for="confirm">No:</label>
    <input type="radio" name="confirm" value="no" />
      </p>

      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('id'=>$user['id'])); ?>

      <p>
        <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
        <?php echo form_submit('submit', 'Ok', array('class'=>'btn btn-dark btn-sm')); ?>   
      </p>

    <?php echo form_close(); ?>
        
      </div>
    </div>
  </div>
</div>
