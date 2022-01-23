<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php echo $user_info_menu; ?>
    </div>
    <div class="col-lg-8">
      <div class="padding-top-2x mt-2 hidden-lg-up"></div>


      <div class="col-md-12">
          <h6 class="text-muted text-normal text-uppercase">Detail order id : <?php echo $order_id; ?></h6>
          <hr class="margin-bottom-1x">
          <div class="row">
          	<?php echo $table; ?>

            <table class="table">
              <tr>
                <td>Berat</td>
                <td><?php echo $berat_order; ?> gram</td>
              </tr>
              <tr>
                <td>Ongkos Kirim</td>
                <td>Rp. <?php echo number_format($ongkos_kirim, 0, ".", "."); ?></td>
              </tr>
              <tr>
                <td>Total Order</td>
                <td>Rp. <?php echo number_format($total_order, 0, ".", "."); ?></td>
              </tr>
              <tr>
                <td>Kurir</td>
                <td><?php echo strtoupper($kurir); ?></td>
              </tr>
              <tr>
                <td>Layanan</td>
                <td>
                  <?php 
                  $split = explode(',', $layanan);
                  echo $split[1];
                  ?>
                </td>
              </tr>
              <tr>
                <td>Tanggal Order</td>
                <td><?php echo $order_date; ?></td>
              </tr>
              <tr>
                <td>Payment Method</td>
                <td><?php echo $payment_method; ?></td>
              </tr>
              <tr>
                <td>Accepted</td>
                <td><?php echo ($status_konfirmasi == 1) ? "Ya" : "Tidak"; ?></td>
              </tr>
            </table>
          </div>
      </div>

    </div>
  </div>
</div>