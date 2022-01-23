<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Profile</h2>
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
        <p class="text-muted font-13 m-b-30">
          Halaman ini digunakan untuk mengelola akun admin website.
        </p>
        
<form>
	<div class="form-group">
		<label for="">Nama Depan</label>
		<input type="text" class="form-control" id="" value="<?php echo $user->nama_lengkap; ?>" disabled="disabled">
	</div>
	<div class="form-group">
		<label for="">Email</label>
		<input type="text" class="form-control" id="" value="<?php echo $user->email; ?>" disabled="disabled">
	</div>
	<div class="form-group">
		<?php echo anchor('url', 'Perbarui Akun', array('class' => 'btn btn-info btn-sm')); ?>
	</div>
</form>

      </div>
    </div>
  </div>
</div>
