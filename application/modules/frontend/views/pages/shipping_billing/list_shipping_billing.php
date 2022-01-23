<?php #print_r($_SESSION); ?>

<?php #echo $this->session->userdata('provinsi'); ?>
<script type="text/javascript">
 

 $(document).ready(function() {
 <?php if($this->uri->segment(1) == 'ship_bill') { ?>

       $('#prov').change(function() {
          var prov = $('#prov').val();
          var province = prov.split(',');

          $.ajax({
             url: "<?php echo base_url();?>ship_bill/city",
             method: "POST",
             data: { prov : province[0] },
             success: function(obj) {
                $('#kota').html(obj);
             }
          });
       });

       $('#kota').change(function() {
          var kota = $('#kota').val();
          var dest = kota.split(',');
          var kurir = $('#kurir').val();
          var berat = $('#berat').val();

          $.ajax({
             url: "<?php echo base_url();?>ship_bill/getcost",
             method: "POST",
             data: { dest : dest[0], kurir : kurir, berat : berat },
             success: function(obj) {
                $('#layanan').html(obj);
             }
          });
       });







       $('#kurir').change(function() {
          var kota = $('#kota').val();
          var dest = kota.split(',');
          var kurir = $('#kurir').val();
          var berat = $('#berat').val();

          $.ajax({
             url: "<?php echo base_url();?>ship_bill/getcost",
             method: "POST",
             data: { dest : dest[0], kurir : kurir, berat : berat },
             success: function(obj) {
                $('#layanan').html(obj);
             }
          });
       });


       $('#layanan').change(function() {
          var layanan = $('#layanan').val();

          $.ajax({
             url: "<?php echo base_url();?>ship_bill/cost",
             method: "POST",
             data: { layanan : layanan },
             success: function(obj) {
                var hasil = obj.split(",");

                $('#ongkir').val(hasil[0]);
                $('#total').val(hasil[1]);
                $('#ongkir_order').val(hasil[0]);
                $('#total_order').val(hasil[1]);
             }
          });
       });

 <?php } ?>
    
 });
</script>

<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
<?php echo form_open($form_action); ?>
	<div class="row">

		<div class="col-xs-12 col-sm-12">
			<?php // PROSES CHECKOUT ?>
      <?php $this->load->view('include/template/extend/checkout_extend'); ?>
		</div>

		<div class="col-xs-6 col-sm-6">

			<h6 class="text-muted text-normal text-uppercase margin-top-2x">CUSTOMER INFORMATION</h6>
            <hr class="margin-bottom-1x">

            <?php  
            if (!$this->ion_auth->logged_in())
            {
            ?>
            <div align="right">
              <p>
                Already have an account? <?php echo anchor(base_url().'reseller', 'Sign In', array('class'=>'', 'style' => 'text-decoration:none;')); ?>
              </p>
            </div>

            <div class="form-group row">
              <label class="col-4 col-form-label" for="nama_lengkap">Nama Lengkap (Sesuai KTP)*</label>
              <div class="col-8">
                <?php  
	              $form = array(
	                'nama_lengkap' => array(
	                  'name' => 'nama_lengkap', 
	                  'value' => set_value('nama_lengkap', ($this->session->userdata('nama_lengkap_order')) ? $this->session->userdata('nama_lengkap_order') : ''),
	                  'class' => 'form-control form-control-rounded form-control-sm',
	                  'type' => 'text',
	                  'id' => "nama_lengkap",
	                  'required' => "required",
                    'placeholder' => 'Nama Lengkap',
	                ),
	              );
	            ?>
	            <?php echo form_input($form['nama_lengkap']); ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-4 col-form-label" for="telepon">Handphone*</label>
              <div class="col-8">
                <?php  
	              $form = array(
	                'telepon' => array(
	                  'name' => 'telepon', 
	                  'value' => set_value('telepon', ($this->session->userdata('telepon_order')) ? $this->session->userdata('telepon_order') : ''),
	                  'class' => 'form-control form-control-rounded form-control-sm',
	                  'type' => 'number',
	                  'id' => "telepon",
	                  'required' => "required",
                    'placeholder' => 'Handphone',
	                ),
	              );
	            ?>
	            <?php echo form_input($form['telepon']); ?>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-4 col-form-label" for="email">Email*</label>
              <div class="col-8">
                <?php  
	              $form = array(
	                'email' => array(
	                  'name' => 'email', 
	                  'value' => set_value('email', ($this->session->userdata('email_order')) ? $this->session->userdata('email_order') : ''),
	                  'class' => 'form-control form-control-rounded form-control-sm',
	                  'type' => 'email',
	                  'id' => "email",
	                  'required' => "required",
                    'placeholder' => 'Email',
	                ),
	              );
	            ?>
	            <?php echo form_input($form['email']); ?>
              </div>
            </div>



            <?php
            //jika belum login
            }else{
              //jika sudah login
              $user = $this->ion_auth->get_user();
              
              if ($user->group == "reseller_pribadi") {
            ?>
            <table class="table">
                <tr>
                  <td>Nama Lengkap*</td>
                  <td>:</td>
                  <td><?php echo $user->nama_lengkap; ?></td>
                </tr>
                <tr>
                  <td>Alamat*</td>
                  <td>:</td>
                  <td>
                    <?php
                    echo $user->alamat_reseller;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Handphone*</td>
                  <td>:</td>
                  <td><?php echo $user->nomor_telepon_reseller; ?></td>
                </tr>
                <tr>
                  <td>Email*</td>
                  <td>:</td>
                  <td><?php echo $user->email; ?></td>
                </tr>
                <tr>
                  <td>Status Member*</td>
                  <td>:</td>
                  <td>
                    <?php 
                    echo ($user->group == "reseller_pribadi") ? "Reseller" : "Distributor";
                    ?>
                  </td>
                </tr>
            </table>
            <?php
              }
            ?>
            <?php
              if ($user->group == "reseller_organisasi") {
            ?>
            <table class="table">
                <tr>
                  <td>Distributor*</td>
                  <td>:</td>
                  <td><?php echo $user->nama_organisasi; ?></td>
                </tr>
                <tr>
                  <td>Alamat*</td>
                  <td>:</td>
                  <td>
                    <?php
                    echo $user->alamat_organisasi;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Handphone*</td>
                  <td>:</td>
                  <td><?php echo $user->nomor_telepon_organisasi; ?></td>
                </tr>
                <tr>
                  <td>Email*</td>
                  <td>:</td>
                  <td><?php echo $user->email; ?></td>
                </tr>
                <tr>
                  <td>Nama Perwakilan*</td>
                  <td>:</td>
                  <td><?php echo $user->nama_lengkap; ?></td>
                </tr>
                <tr>
                  <td>Status Member*</td>
                  <td>:</td>
                  <td>
                    <?php 
                    echo ($user->group == "reseller_pribadi") ? "Reseller" : "Distributor";
                    ?>
                  </td>
                </tr>
            </table>
            <?php   
              }
            ?>
            

            <?php
            }
            ?>

            <h6 class="text-muted text-normal text-uppercase margin-top-2x">SHIPPNG INFORMATION</h6>
            <hr class="margin-bottom-1x">

            <!-- PROVINSI -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="prov">Provinsi*</label>
              <div class="col-10">
                <?php $this->load->view('pages/shipping_billing/prov'); ?>
              </div>
            </div>

            <!-- KOTA KABUPATEN -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="kota">Kota / Kabupaten*</label>
              <div class="col-10">
              	<select name="kota" class="form-control" id="kota" required="required">
                     <option value="" disabled selected>Kota / Kabupaten</option>
                  </select>
              </div>
            </div>

            <!-- ALAMAT -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="alamat">Alamat*</label>
              <div class="col-10">
                <?php  
	              $form = array(
	                'alamat' => array(
	                  'name' => 'alamat', 
	                  'value' => set_value('alamat', ($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : ''),
	                  'class' => 'form-control form-control-rounded form-control-sm',
	                  'type' => 'text',
	                  'id' => "alamat",
                    'required' => "required",
                    'placeholder' => 'Alamat',
	                ),
	              );
	            ?>
	            <?php echo form_input($form['alamat']); ?>
              </div>
            </div>

            <!-- KODE POS -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="kode_pos">Kode Pos*</label>
              <div class="col-4">
                <?php  
	              $form = array(
	                'kode_pos' => array(
	                  'name' => 'kode_pos', 
	                  'value' => set_value('kode_pos', ($this->session->userdata('kode_pos')) ? $this->session->userdata('kode_pos') : ''),
	                  'class' => 'form-control form-control-rounded form-control-sm',
	                  'type' => 'number',
	                  'id' => "kode_pos",
                    'required' => "required",
                    'placeholder' => 'Kode Pos',
	                ),
	              );
	            ?>
	            <?php echo form_input($form['kode_pos']); ?>
              </div>
            </div>

            <!-- EKSPEDISI -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="kurir">Pilih Ekspedisi*</label>
              <div class="col-10">
              	<select class="form-control" name="kurir" id="kurir" required="required">
                      <option value="" disabled selected>Layanan</option>
                     <option value="pos">POS</option>
                     <option value="jne">JNE</option>
                  </select>
              </div>
            </div>

            <!-- PILIH LAYANAN -->
            <div class="form-group row">
              <label class="col-2 col-form-label" for="layanan">Layanan*</label>
              <div class="col-10">
              	<select class="form-control" name="layanan" id="layanan" required="required">
                     <option value="" disabled selected>Layanan</option>
                  </select>
              </div>
            </div>






            
            

        </div>

        <div class="col-xs-6 col-sm-6">

        	<h6 class="text-muted text-normal text-uppercase margin-top-2x">PRODUCT AND QUANTITY</h6>
            <hr class="margin-bottom-1x">

<div class="card">
  <div class="card-header">
    Prices and shipping costs
  </div>
  <div class="card-body">
    <?php echo $table; ?>
  </div>
    <div class="card-footer text-muted bg-dark text-white">

    	<!-- ONGKOS KIRIM -->
            <div class="form-group row">
              <label class="col-4 col-form-label" for="subtotal">SUBTOTAL</label>


              <div class="col-8">
              	<div class="input-group">
        				  <input class="form-control form-control-rounded form-control-md" type="text" value="<?php echo number_format($this->cart->total(), 0, ".", "."); ?>" name="subtotal" id="subtotal" disabled="disabled">
                  <?php echo form_hidden('subtotal_order', $this->cart->total()); ?>
        				  <span class="input-group-addon"><b>Rp.</b></span>
        				</div> 
              </div>
            </div>

            <!-- BERAT -->
            <div class="form-group row">
              <label class="col-4 col-form-label" for="berat">BERAT (*GRAM)</label>
              <div class="col-8">
                <?php  
                $form = array(
                  'berat' => array(
                    'name' => 'berat',
                    'value' => $berat_pembelian,
                    'class' => 'form-control form-control-rounded',
                    'type' => 'number',
                    'id' => 'berat',
                    'disabled' => "disabled",
                  ),
                );
              ?>
              <?php echo form_input($form['berat']); ?>
              <?php echo form_hidden('berat_order', $berat_pembelian); ?>
              </div>
            </div>
    
    	<!-- ONGKOS KIRIM -->
            <div class="form-group row">
              <label class="col-4 col-form-label" for="ongkir">ONGKOS KIRIM</label>
              <div class="col-8">
              	<?php  
	              $form = array(
	                'ongkir' => array(
	                  'name' => 'ongkir', 
	                  'value' => set_value('ongkir', isset($form_value['ongkir']) ? $form_value['ongkir'] : ''),
	                  'class' => 'form-control form-control-rounded form-control-md',
	                  'type' => 'number',
	                  'id' => "ongkir",
	                  'disabled' => "disabled",
	                ),
	              );
	            ?>
	            
	            <div class="input-group">
      				  <?php echo form_input($form['ongkir']); ?>
                <input type="hidden" name="ongkir_order" id="ongkir_order">
      				  <span class="input-group-addon"><b>Rp.</b></span>
      				</div> 

              </div>
            </div>

            <!-- TOTAL BIAYA -->
            <div class="form-group row">
              <label class="col-4 col-form-label" for="total">ESTIMATED TOTAL</label>
              <div class="col-8">
              	<?php  
	              $form = array(
	                'total' => array(
	                  'name' => 'total', 
	                  'value' => number_format($this->cart->total(), 0, ".", "."),
	                  #'value' => 5000,
	                  'class' => 'form-control form-control-rounded form-control-md',
	                  'type' => 'number',
	                  'id' => "total",
	                  'disabled' => "disabled",
	                ),
	              );
	            ?>
	            <div class="input-group">
				  
				  <?php echo form_input($form['total']); ?>
          <input type="hidden" name="total_order" id="total_order">
				  <span class="input-group-addon"><b>Rp.</b></span>
				</div>
              </div>
            </div>


  </div>
</div>
    
<div align="right">
  <?php echo anchor(base_url('shop'), '<i class="icon-arrow-left"></i>&nbsp;Back to Shopping', array('class'=>'btn btn-outline-secondary btn-sm')); ?>
  <?php echo anchor(base_url('cart'), '<i class="icon-bag"></i>&nbsp;Your Cart', array('class'=>'btn btn-primary btn-sm')); ?>
  <?php echo form_submit('submit', 'Continue', array('class'=>'btn btn-success btn-sm')); ?>
</div>
    
        	
        </div>

    </div>
<?php echo form_close(); ?>









		</div>
	</div>
</div>