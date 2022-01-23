<script>
function showDetails(bookURL){
       window.open(bookURL,"bookDetails","width=600,height=430,scrollbars=yes");              
    }
</script>
<div class="menu_section">
  <h3>General</h3>
  <ul class="nav side-menu">
    <li><a><i class="fa fa-home"></i> Site <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('backend/dashboard/index'); ?>">Dashboard</a></li>
        <li><a href="<?php echo base_url('backend/konten_halaman/index'); ?>">Konten Halaman</a></li>
        <li><a href="<?php echo base_url('backend/introduction/index'); ?>">Introduction</a></li>
        <li><a href="<?php echo base_url('backend/banner/index'); ?>">Banner</a></li>
        <li><a href="<?php echo base_url('backend/flyer/index'); ?>">Flyer</a></li>
        <li><a href="<?php echo base_url('backend/faq/index'); ?>">FAQ</a></li>
        <li><a href="<?php echo base_url('backend/pertanyaan/index'); ?>">Pertanyaan</a></li>
        <li><a href="<?php echo base_url('admin/socialmedia'); ?>">Sosmed & Konten</a></li>        
        <li><a href="<?php echo base_url('admin/contact'); ?>">Pesan Contact</a></li>
        <li><a href="<?php echo base_url('backend/testimoni/index'); ?>">Testimoni</a></li>        
        <li><a href="<?php echo base_url('admin/event'); ?>">Event</a></li>
        <li><a href="<?php echo base_url('backend/tag_line/index'); ?>">Tag Line</a></li>
        <li><a href="<?php echo base_url('backend/iklan/index'); ?>">Iklan</a></li>
        <li><a href="<?php echo base_url('backend/instagram/index'); ?>">Instagram</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-book"></i> Blog <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('backend/kategori_blog/index'); ?>">Kategori Blog</a></li>
        <li><a href="<?php echo base_url('backend/blog/index'); ?>">Blog</a></li>
        <li><a href="<?php echo base_url('backend/tags_blog/index'); ?>">Tags</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-shopping-cart"></i> Produk <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('admin/product/kategori'); ?>">Kategori Produk</a></li>      
        <li><a href="<?php echo base_url('admin/product'); ?>">Produk</a></li>
        <li><a href="<?php echo base_url('backend/merchant'); ?>">Merchant</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-group"></i> Reseller Pribadi <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('backend/paket_reseller/index'); ?>">Paket Reseller</a></li>
        <li><a href="<?php echo base_url('backend/reseller_pribadi/index'); ?>">Reseller Pribadi</a></li>

        <li><a href="<?php echo base_url('backend/order_member_reseller/index'); ?>">Order Reseller</a></li>

        <li><a href="<?php echo base_url('backend/order_reseller_pribadi/index'); ?>">Order</a></li>
        <li><a href="<?php echo base_url('backend/order_pending_reseller_pribadi/index'); ?>">Order Pending</a></li>
        <li><a href="<?php echo base_url('backend/poin_reseller_pribadi/index'); ?>">Poin</a></li>
        <li><a href="<?php echo base_url('backend/rekaman_order_reseller_pribadi/index'); ?>">Rekaman Order</a></li>
        <li><a href="<?php echo base_url('backend/penukaran_poin_reseller_pribadi/index'); ?>">Penukaran Poin</a></li>
        <li><a href="<?php echo base_url('backend/rekaman_penukaran_poin_reseller_pribadi/index'); ?>">Rekaman Penukaran</a></li>
        <li><a href="<?php echo base_url('backend/bonus_poin_reseller_pribadi/index'); ?>">Bonus Poin</a></li>
        <li><a href="<?php echo base_url('backend/kedaluwarsa_reseller_pribadi/index'); ?>">Reseller Pribadi Experied</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-group"></i> Reseller Organisasi <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('backend/reseller_organisasi/index'); ?>">Reseller Organisasi</a></li>
        <li><a href="<?php echo base_url('backend/order_reseller_organisasi/index'); ?>">Order</a></li>
        <li><a href="<?php echo base_url('backend/order_pending_reseller_organisasi/index'); ?>">Order Pending</a></li>
        <li><a href="<?php echo base_url('backend/poin_reseller_organisasi/index'); ?>">Poin</a></li>
        <li><a href="<?php echo base_url('backend/rekaman_order_reseller_organisasi/index'); ?>">Rekaman Order</a></li>
        <li><a href="<?php echo base_url('backend/penukaran_poin_reseller_organisasi/index'); ?>">Penukaran Poin</a></li>
        <li><a href="<?php echo base_url('backend/rekaman_penukaran_poin_reseller_organisasi/index'); ?>">Rekaman Penukaran Poin</a></li>
        <li><a href="<?php echo base_url('backend/bonus_poin_reseller_organisasi/index'); ?>">Bonus Poin</a></li>
        <li><a href="<?php echo base_url('backend/kedaluwarsa_reseller_organisasi/index'); ?>">Reseller Organisasi Experied</a></li>
      </ul>
    </li>

    <li><a><i class="fa fa-user"></i> Admin <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="<?php echo base_url('backend/admin/index'); ?>">Data Admin</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-photo"></i> Unggah Gambar & File <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">
        <li><a href="javascript:;" onclick="return showDetails('<?php echo base_url("backend/unggah_gambar/index"); ?>');">Unggah Gambar</a></li>
        <li><a href="javascript:;" onclick="return showDetails('<?php echo base_url("backend/unggah_file/index"); ?>');">Unggah File</a></li>
      </ul>
    </li>
    <li><a><i class="fa fa-cogs"></i> Pengaturan <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">        
        <li><a href="<?php echo base_url('admin/pengaturan'); ?>"> Pengaturan</a></li>
      </ul>
    </li> 
  </ul>
</div>

<!--div class="menu_section">
  <ul class="nav side-menu">
    <li><a><i class="fa fa-home"></i> Member <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu" style="display: none">        
        <li><a href="<?php echo base_url('admin/member_area'); ?>">Data Member</a></li>
        <li><a href="<?php echo base_url('admin/member_orders'); ?>">Member Orders</a></li>  
        <li><a href="<?php echo base_url('admin/member_history'); ?>">History Member Orders</a></li>
        <li><a href="<?php echo base_url('admin/master_bonus'); ?>">Master Poin Bonus</a></li>
        <li><a href="<?php echo base_url('admin/member/poin'); ?>">Data Poin Member</a></li>
        <li><a href="<?php echo base_url('admin/member/poin/history'); ?>">History Penukaran Poin</a>
        </li>
      </ul>
    </li>           
  </ul>
</div-->

<?php  
#if ($this->session->userdata('account_level') == 'admin') {
?>

<?php
#}elseif ($this->session->userdata('acc_level') == 'superadministrator') {
?>

<?php
#}elseif ($this->session->userdata('acc_level') == 'webdeveloper') {
?>

<?php
#}
?>