<?php #print_r($_SESSION); ?>

<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<?php // PROSES CHECKOUT ?>
			<?php $this->load->view('include/template/extend/checkout_extend'); ?>
		</div>
		<div class="col-xs-6 col-sm-6">
			<?php echo form_open($form_action); ?>

			<div class="text-muted text-normal text-uppercase margin-top-2x"></div>

            <div class="card">
            	<div class="card-header">
			    	CUSTOMER INFORMATION
			  	</div>
			  	<div class="card-body">

          <?php  
            if (!$this->ion_auth->logged_in())
            {
            ?>
            
            <div class="form-group row">
              <label class="col-4 col-form-label" for="nama_lengkap">Nama Lengkap (Sesuai KTP)*</label>
              <div class="col-8">
                <?php echo ($this->session->userdata('nama_lengkap_order')) ? $this->session->userdata('nama_lengkap_order') : ''; ?>
                <?php  
	              /*$form = array(
	                'nama_lengkap' => array(
	                  'name' => 'nama_lengkap', 
	                  'value' => set_value('nama_lengkap', ($this->session->userdata('nama_lengkap_order')) ? $this->session->userdata('nama_lengkap_order') : ''),
	                  'class' => 'form-control',
	                  'type' => 'text',
	                  'id' => "nama_lengkap",
	                  'required' => "required",
                    'placeholder' => 'Nama Lengkap',
                    'disabled' => 'disabled',
	                ),
	              );*/
	            ?>
	            <?php #echo form_input($form['nama_lengkap']); ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-4 col-form-label" for="telepon">Handphone*</label>
              <div class="col-8">
                <?php echo ($this->session->userdata('telepon_order')) ? $this->session->userdata('telepon_order') : ''; ?>
                <?php  
	              /*$form = array(
	                'telepon' => array(
	                  'name' => 'telepon', 
	                  'value' => set_value('telepon', ($this->session->userdata('telepon_order')) ? $this->session->userdata('telepon_order') : ''),
	                  'class' => 'form-control',
	                  'type' => 'number',
	                  'id' => "telepon",
	                  'required' => "required",
                    'placeholder' => 'Handphone',
                    'disabled' => 'disabled',
	                ),
	              );*/
	            ?>
	            <?php #echo form_input($form['telepon']); ?>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-4 col-form-label" for="email">Email*</label>
              <div class="col-8">
                <?php echo ($this->session->userdata('email_order')) ? $this->session->userdata('email_order') : ''; ?>
                <?php  
	              /*$form = array(
	                'email' => array(
	                  'name' => 'email', 
	                  'value' => set_value('email', ($this->session->userdata('email_order')) ? $this->session->userdata('email_order') : ''),
	                  'class' => 'form-control',
	                  'type' => 'email',
	                  'id' => "email",
	                  'required' => "required",
                    'placeholder' => 'Email',
                    'disabled' => 'disabled',
	                ),
	              );*/
	            ?>
	            <?php #echo form_input($form['email']); ?>
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
			  		
			  	</div>
			</div>

			
			<div class="text-muted text-normal text-uppercase margin-top-2x"></div>
        

         <div class="card">
          <div class="card-header">
            PRODUCTS AND QUANTITY
          </div>
          <div class="card-body">
            <?php echo $table; ?>
          </div>
         </div>   



            

            
		</div>
		<div class="col-xs-6 col-sm-6">
			
			<div class="text-muted text-normal text-uppercase margin-top-2x"></div>
        
      <!--h4>SHIPPING ADDRESS</h4-->
        <div class="card">
          <div class="card-header">
            SHIPPING ADDRESS AND SHIPPING COSTS
          </div>
          <div class="card-body">
          
            <table class="table">
              <tr>
                <th>ALAMAT PENGIRIMAN</th>
                <td>
                  <?php 
                    $kota = $this->session->userdata('kota');
                    $provinsi = $this->session->userdata('provinsi');
                    $get_kota = explode(',', $kota); 
                    $get_provinsi = explode(',', $provinsi);
                  ?>
                  <?php echo ($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : ''; ?>, 
                  <?php echo ($this->session->userdata('kota')) ? $get_kota[1] : ''; ?>, 
                  <?php echo ($this->session->userdata('provinsi')) ? $get_provinsi[1] : ''; ?> - 
                  <?php echo ($this->session->userdata('kode_pos')) ? $this->session->userdata('kode_pos') : ''; ?>
                </td>
              </tr>
              <tr>
                <th>EKSPEDISI</th>
                <td>
                  <?php echo strtoupper($this->session->userdata('kurir')); ?> - 
                  <?php
                  $get_layanan = explode(',', $this->session->userdata('layanan'));
                  echo $get_layanan[1]; 
                  ?>
                </td>
              </tr>

              <tr>
                <th>SUBTOTAL</th>
                <td>Rp. <?php echo ($this->session->userdata('subtotal_order')) ? number_format($this->session->userdata('subtotal_order'), 0, ".", ".") : ''; ?></td>
              </tr>
              <tr>
                <th>BERAT (*GRAM)</th>
                <td><?php echo ($this->session->userdata('berat_order')) ? $this->session->userdata('berat_order') : ''; ?></td>
              </tr>
              <tr>
                <th>ONGKOS KIRIM</th>
                <td>Rp. <?php echo ($this->session->userdata('ongkir_order')) ? number_format($this->session->userdata('ongkir_order'), 0, ".", ".") : ''; ?></td>
              </tr>
              <tr>
                <th>ESTIMATED TOTAL</th>
                <td>Rp. <?php echo ($this->session->userdata('total_order')) ? number_format($this->session->userdata('total_order'), 0, ".", ".") : ''; ?></td>
              </tr>

            </table>
            </div>
        </div>

            <h6 class="text-muted text-normal text-uppercase margin-top-2x">PAYMENT METHOD</h6>
            <hr class="margin-bottom-1x">

            <p>Pilih salah satu metode pembayaran : </p>

            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h6>
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <label>
                      <?php  
                       $data = array(
                          'name'          => 'payment_method',
                          'value'         => 'transfer_bca',
                          #'checked'       => TRUE,
                          'style'         => '',
                          'required'    => 'required'
                       );

                       echo form_radio($data);
                      ?> Transfer BCA
                    </label>
                    </button>
                  </h6>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <img src="<?php echo base_url(); ?>assets/images/template/via_bca.jpg" alt=""><br>
                    <p>
                      Untuk pembayaran melalui rekening BCA.<br>
                      Kami kirimkan melalui Email yang telah anda daftarkan, mengenai informasi cara melakukan pembayaran menggunakan transfer BCA. Silahkan cek email anda setelah sukses melakukan order.
                    </p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h6 class="mb-0">

                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      
                    
                    <!--a href="#collapseTwo" data-toggle="collapse" ></a-->
                    <label>
                      <?php  
                       $data = array(
                          'name'          => 'payment_method',
                          'value'         => 'transfer_doku',
                          'style'         => '',
                          'required'      => 'required',
                          'disabled'      => 'disabled',
                       );

                       echo form_radio($data);
                      ?> DOKU
                    </label>
                    </button>

                  </h6>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                  <div class="card-body">
                    <img src="<?php echo base_url(); ?>assets/images/template/via_doku.jpg" alt="">
                    sAnim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h6 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <label>
                      <?php  
                       $data = array(
                          'name'          => 'payment_method',
                          'value'         => 'transfer_finpay',
                          'style'         => '',
                          'required'      => 'required',
                          'disabled'      => 'disabled',
                       );

                       echo form_radio($data);
                      ?> FINPAY
                    </label>
                    </button>
                    
                  </h6>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                  <div class="card-body">
                    <img src="<?php echo base_url(); ?>assets/images/template/via_finpay.jpg" alt="">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
            </div>

			<br>

			<!--div class="alert alert-default" role="alert">
			  Sebelum menyelesaikan order, silahkan cek kembali informasi pembelian Anda.
			</div-->

			<br>
			<div align="right">
				<?php echo anchor(base_url('ship_bill'), 'Back', array('class'=>'btn btn-secondary btn-sm')); ?>
            	<?php #echo anchor(base_url('payment'), 'Complete Order', array('class'=>'btn btn-primary btn-sm')); ?>
            	<?php echo form_submit('submit', 'Complete Order', array('class'=>'btn btn-primary btn-sm')); ?>
			</div>

		</div>
		<?php echo form_close(); ?>
	</div>
</div>