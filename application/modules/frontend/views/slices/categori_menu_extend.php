<div class="offcanvas-container" id="product-categories">
      <div class="offcanvas-header">
        <h3 class="offcanvas-title">Produk Kategori</h3>
      </div>
      <nav class="offcanvas-menu">
        <ul class="menu">

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
        </ul>
      </nav>
    </div>