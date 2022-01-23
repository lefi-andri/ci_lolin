<?php
$user = $this->ion_auth->get_user();
$nama_pengguna="";
$split = explode(" ", $user->nama_lengkap);

foreach ($split as $key => $value) {
  if ($key < 2) {
    $nama_pengguna .= substr($value,0,1);
  }            
}        
?>
<!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img data-name="<?php echo $nama_pengguna; ?>" class="profile"/><?php echo $user->nama_lengkap; ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="<?php echo base_url('backend/profile/index'); ?>"><i class="fa fa-user pull-right"></i>  Akun Saya</a>
                  </li>                  
                  <li><a href="#" data-toggle="modal" data-target="#modal_logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->