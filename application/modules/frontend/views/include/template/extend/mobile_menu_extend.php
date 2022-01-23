    <div class="offcanvas-container" id="mobile-menu">
<?php
if ($this->ion_auth->logged_in()) {
?>
    <a class="account-link" href="<?php echo base_url(); ?>reseller">
        <div class="user-ava">
          <img src="<?php echo base_url(); ?>assets/themes/unishop/img/account/user.png" alt="Users">
        </div>

        <!--div class="user-info">
          <h6 class="user-name"><?php #if($data_reseller->nama_lengkap_reseller){echo $data_reseller->nama_lengkap_reseller;} ?></h6><span class="text-sm text-white opacity-60"><?php #echo $poin_saat_ini; ?> Reward points</span>
        </div-->
    </a>
<?php
}else{
?>
    <a class="account-link" href="<?php echo base_url(); ?>reseller">
        <div class="user-ava">
          <img src="<?php echo base_url(); ?>assets/themes/unishop/img/account/user.png" alt="Users">
        </div>

        <div class="user-info">
          <h6 class="user-name">Users</h6>
        </div>
    </a>
<?php
}
?>

      <nav class="offcanvas-menu">
        <ul class="menu">
          
          <li class="has-children"><span><a href="<?php echo base_url(); ?>"><span>HOME</span></a></span></li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>profile"><span>PROFIL</span></a></span></li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>product"><span>PRODUK</span></a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
                <?php  
                $data_kategori_produk = $this->db->get_where('product_cat', array('catprodsShow' => 'y'));
                if ($data_kategori_produk->num_rows() > 0) {
                  foreach ($data_kategori_produk->result() as $value) {
                ?>
                <li class="has-children"><span><a href="<?php echo base_url().'product/category/'.$value->catprodsSlug; ?>"><?php echo $value->catprodsName; ?></a><span class="sub-menu-toggle"></span></span>
                  <ul class="offcanvas-submenu">
                      <?php  
                      $data_produk = $this->db->get_where('product', array('prodsShow' => 'y', 'catprodsId' => $value->catprodsId));
                      if ($data_produk->num_rows() > 0) {
                        foreach ($data_produk->result() as $values) {
                      ?>
                        <li><a href="<?php echo base_url().'product/'.$values->prodsSlug; ?>"><?php echo $values->prodsName; ?></a></li>
                      <?php
                        }
                      }
                      ?>
                  </ul>
                </li>
                <?php
                  }
                }
                ?>
                <!--li><a href="../home-featured-categories.html">Featured Categories</a></li>
                <li><a href="../home-collection-showcase.html">Products Collection Showcase</a></li-->
            </ul>
          </li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>blog"><span>blog</span></a></span></li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>faq"><span>FAQ</span></a></span></li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>reseller"><span>RESELLER</span></a><span class="sub-menu-toggle"></span></span>
            <ul class="offcanvas-submenu">
                <li><a href="<?php echo base_url(); ?>reseller">Reseller Area</a></li>
                <li><a href="<?php echo base_url(); ?>event">Event</a></li>
                <li><a href="<?php echo base_url(); ?>testimonials">Testimoni</a></li>
            </ul>
          </li>
          <li class="has-children"><span><a href="<?php echo base_url(); ?>contact"><span>KONTAK</span></a></span></li>

        </ul>
      </nav>
    </div>