<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Konfirmasi Email</h2>
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



<?php echo form_open($form_action, array('class' => 'form-horizontal', 'name'=>'')); ?>

<h3><i>" Draft</i></h3>
<hr style="border: dotted;">
Dear, <?php echo ($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : ''; ?><br>
Request penukaran poin anda telah kami setujui. Kini kami akan mentransfer bonus, sejumlah poin yang ditukarkan ke rekening bank anda dengan detail:

<table width="100%" border="1">
  <tr>
    <td colspan="3"><div align="left">Rincian Bonus</div></td>
  </tr>
  <tr>
    <td>Nama Bonus </td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
        echo ($form_value['nama_jenis_bonus']) ? $form_value['nama_jenis_bonus'] : '';
        echo form_hidden('nama_jenis_bonus', ($form_value['nama_jenis_bonus']) ? $form_value['nama_jenis_bonus'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td>Poin</td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['poin_bonus']) ? $form_value['poin_bonus'] : '';
      echo form_hidden('poin_bonus', ($form_value['poin_bonus']) ? $form_value['poin_bonus'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td>Nilai Bonus </td>
    <td><div align="center">:</div></td>
    <td>
      Rp. 
      <?php 
      echo ($form_value['nilai_bonus']) ? number_format($form_value['nilai_bonus'], 0, ".", ".") : '';
      echo form_hidden('nilai_bonus', ($form_value['nilai_bonus']) ? number_format($form_value['nilai_bonus'], 0, ".", ".") : '');
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><div align="left">Rincian Penukaran</div></td>
  </tr>
  <tr>
    <td>Kode Penukaran </td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['kode_tukar_poin']) ? $form_value['kode_tukar_poin'] : '';
      echo form_hidden('kode_tukar_poin', ($form_value['kode_tukar_poin']) ? $form_value['kode_tukar_poin'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td>Tanggal Permintaan Penukaran </td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['tanggal_tukar_poin']) ? $form_value['tanggal_tukar_poin'] : '';
      echo form_hidden('tanggal_tukar_poin', ($form_value['tanggal_tukar_poin']) ? $form_value['tanggal_tukar_poin'] : '');
      echo form_hidden('email', ($form_value['email']) ? $form_value['email'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><div align="left">Rincian Rekening Anda</div></td>
  </tr>
  <tr>
    <td>Nama Bank</td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['nama_bank']) ? $form_value['nama_bank'] : '';
      echo form_hidden('nama_bank', ($form_value['nama_bank']) ? $form_value['nama_bank'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td>Atas Nama</td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['pemilik_rek']) ? $form_value['pemilik_rek'] : '';
      echo form_hidden('pemilik_rek', ($form_value['pemilik_rek']) ? $form_value['pemilik_rek'] : '');
      ?>
    </td>
  </tr>
  <tr>
    <td>Nomor Rekening</td>
    <td><div align="center">:</div></td>
    <td>
      <?php 
      echo ($form_value['norek']) ? $form_value['norek'] : '';
      echo form_hidden('norek', ($form_value['norek']) ? $form_value['norek'] : '');
      echo form_hidden('nama_lengkap', ($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : '');
      echo form_hidden('reseller_id', ($form_value['reseller_id']) ? $form_value['reseller_id'] : '');
      echo form_hidden('nomor_telepon_reseller', ($form_value['nomor_telepon_reseller']) ? $form_value['nomor_telepon_reseller'] : '');
      echo form_hidden('alamat_reseller', ($form_value['alamat_reseller']) ? $form_value['alamat_reseller'] : '');
      echo form_hidden('nama_organisasi', ($form_value['nama_organisasi']) ? $form_value['nama_organisasi'] : '');
      echo form_hidden('nomor_telepon_organisasi', ($form_value['nomor_telepon_organisasi']) ? $form_value['nomor_telepon_organisasi'] : '');
      echo form_hidden('alamat_organisasi', ($form_value['alamat_organisasi']) ? $form_value['alamat_organisasi'] : '');
      ?>
    </td>
  </tr>
</table>
<br>
<table width="100%" border="1">
  <tr>
    <td colspan="3"><div align="left">
      <br>
      ... keterangan ...
      <br> 
    </div></td>
  </tr>
</table>
<br>
<hr style="border: dotted;">
<br>
<br>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan <b class="peringatan">*</b></label>
    <div class="col-sm-10">
      <span class="peringatan"><?php echo form_error('konfirmasi_email'); ?></span>
      <?php 
      $konten = set_value('konfirmasi_email', isset($form_value['konfirmasi_email_pesan']) ? $form_value['konfirmasi_email_pesan'] : '');
      ?>
      <textarea name="konfirmasi_email" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
      <?php echo form_submit('submit', 'Kirim', array('class'=>'btn btn-dark btn-sm')); ?>
    </div>
  </div>
<?php echo form_close(); ?>



      </div>
    </div>
  </div>
</div>