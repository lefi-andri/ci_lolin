<script>
function showDetails(bookURL){
       window.open(bookURL,"bookDetails","width=600,height=430,scrollbars=yes");              
    }
</script>
            <div class="side-nav" style="background-color: #313644;">
                <div class="side-nav-inner">
                    <div class="side-nav-logo" style="background-color: #313644; border-color: #313644; border:0px;">
                        <a href="index.html">
                            <div class="logo logo-dark" style="background-image: url('assets/images/logo/logo.png')"></div>
                            <div class="logo logo-white" style="background-image: url('assets/images/logo/logo-white.png')"></div>
                        </a>
                        <div class="mobile-toggle side-nav-toggle">
                            <a href="#">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                    <ul class="side-nav-menu scrollable">
                        <li class="nav-item dropdown">
                            <a class="mrg-top-30" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-home"></i>
                                    </span>
                                <span class="title">Website</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
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
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-open-book"></i>
                                    </span>
                                <span class="title">Blog</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('backend/kategori_blog/index'); ?>">Kategori Blog</a></li>
                                <li><a href="<?php echo base_url('backend/blog/index'); ?>">Blog</a></li>
                                <li><a href="<?php echo base_url('backend/tags_blog/index'); ?>">Tags</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-office-cart"></i>
                                    </span>
                                <span class="title">Produk</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('admin/product/kategori'); ?>">Kategori Produk</a></li>      
                                <li><a href="<?php echo base_url('admin/product'); ?>">Produk</a></li>
                                <li><a href="<?php echo base_url('backend/merchant'); ?>">Merchant</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-meeting"></i>
                                    </span>
                                <span class="title">Member Reseller</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
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
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-tie"></i>
                                    </span>
                                <span class="title">Member Distributor</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
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
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-users"></i>
                                    </span>
                                <span class="title">Admin</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('backend/admin/index'); ?>">Data Admin</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-cloud-add"></i>
                                    </span>
                                <span class="title">Unggah</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="return showDetails('<?php echo base_url("backend/unggah_gambar/index"); ?>');">Unggah Gambar</a></li>
                                <li><a href="javascript:;" onclick="return showDetails('<?php echo base_url("backend/unggah_file/index"); ?>');">Unggah File</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                        <i class="ei-tools"></i>
                                    </span>
                                <span class="title">Pengaturan</span>
                                <span class="arrow">
                                        <i class="ti-angle-right"></i>
                                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('admin/pengaturan'); ?>"> Pengaturan</a></li>
                            </ul>
                        </li>
                       
                    </ul>
                </div>
            </div>