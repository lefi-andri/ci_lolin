<aside class="user-info-wrapper">
  <div class="user-cover" style="background-image: url(<?php echo base_url(); ?>assets/themes/unishop/img/account/user-cover-img.jpg);">
    <div class="info-label" data-toggle="tooltip" title="You currently have <?php echo $poin_saat_ini; ?> Reward Points to spend"><i class="icon-medal"></i><?php echo $poin_saat_ini; ?> points</div>
  </div>
  <div class="user-info">
    <div class="user-avatar"><a class="edit-avatar" href="<?php echo base_url('reseller/photo_profile'); ?>"></a><img src="<?php echo base_url(); ?>assets/images/foto_profile/<?php echo ($foto)? 'middle_'.$foto : 'user.png'; ?>" alt="Foto Profil"></div>
    <div class="user-data">
      <h4><?php echo $data_reseller->nama_lengkap; ?></h4>
      <span>Joined 
      <?php 
      $this->load->helper('indonesiandate');
      list($tanggal, $waktu) = explode(' ', $data_reseller->tanggal_daftar_reseller);
      echo indonesian_date($tanggal); 
      ?>
      </span>
    </div>
  </div>
</aside>

<nav class="list-group">
  <a class="list-group-item <?php if ($this->uri->segment(2) == 'dashboard'){ echo 'active';} ?>" href="<?php echo base_url('reseller/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
  <a class="list-group-item <?php if ($this->uri->segment(2) == 'profile'){ echo 'active';} ?>" href="<?php echo base_url('reseller/profile'); ?>"><i class="fa fa-user"></i> Profile</a>

  <a class="list-group-item with-badge" href="<?php echo base_url('member/order'); ?>"><i class="fa fa-cart-plus"></i> My Order</a>

  <a class="list-group-item with-badge <?php if (($this->uri->segment(2) == 'order')and($this->uri->segment(3) == '')){ echo 'active';} ?>" href="<?php echo base_url('reseller/order'); ?>"><i class="fa fa-cart-plus"></i> Order</a>
  <a class="list-group-item with-badge <?php if (($this->uri->segment(2) == 'order')and($this->uri->segment(3) == 'rekaman')){ echo 'active';} ?>" href="<?php echo base_url('reseller/order/rekaman'); ?>"><i class="fa fa-history"></i> History Order <span class="badge badge-primary badge-pill"><?php echo $banyak_order_reseller; ?></span></a>
  <a class="list-group-item <?php if (($this->uri->segment(2) == 'penukaran_poin')and($this->uri->segment(3) == '')){ echo 'active';} ?>" href="<?php echo base_url('reseller/penukaran_poin'); ?>"><i class="icon-head"></i>Penukaran Poin</a>
  <a class="list-group-item <?php if (($this->uri->segment(2) == 'penukaran_poin')and($this->uri->segment(3) == 'rekaman')){ echo 'active';} ?>" href="<?php echo base_url('reseller/penukaran_poin/rekaman'); ?>"><i class="fa fa-history"></i></i>History Penukaran Poin</a>
  <a class="list-group-item <?php if (($this->uri->segment(2) == '')and($this->uri->segment(3) == '')){ echo 'active';} ?>" href="<?php echo base_url('reseller/rekapitulasi_poin'); ?>"><i class="fa fa-history"></i></i>Rekapitulasi Poin</a>
  <?php echo anchor('#', '<i class="fa fa-sign-out"></i> Logout', array('class'=>'list-group-item', 'data-toggle'=>'modal', 'data-target'=>'#modalDefault')); ?>
</nav>