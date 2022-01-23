<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah paket reseller</h2>
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

      <?php echo form_open($form_action, array('class'=>'form-horizontal')); ?>

      <div class="row">

          <div class="col-md-12">
            <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Group Reseller</label>
                  <div class="col-sm-10">
                  <?php echo form_error('group_id'); ?>
                  <?php echo form_dropdown('group_id', $dropdown_group, set_value('group_id', isset($form_value['group_id']) ? $form_value['group_id'] : ''), array('class' => 'form-control select2' )); ?>
                  </div>
            </div>
          </div>

          <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Nama Paket</label>
              <div class="col-sm-10">
                <?php echo form_error('nama_paket'); ?>
                <?php  
                  $form = array(
                    'nama_paket' => array(
                      'name' => 'nama_paket', 
                      'value'=>set_value('nama_paket', isset($form_value['nama_paket']) ? $form_value['nama_paket'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['nama_paket']); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Berat</label>
              <div class="col-sm-10">
                <?php echo form_error('berat'); ?>
                <?php  
                  $form = array(
                    'berat' => array(
                      'name' => 'berat', 
                      'value'=>set_value('berat', isset($form_value['berat']) ? $form_value['berat'] : ''),
                      'class'=>'form-control',
                      'type' => 'number'
                    ),
                  );
                ?>
                <?php echo form_input($form['berat']); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Harga Paket</label>
              <div class="col-sm-10">
                <?php echo form_error('harga_paket'); ?>
                <?php  
                  $form = array(
                    'harga_paket' => array(
                      'name' => 'harga_paket', 
                      'value'=>set_value('harga_paket', isset($form_value['harga_paket']) ? $form_value['harga_paket'] : ''),
                      'class'=>'form-control',
                      'type' => 'number'
                    ),
                  );
                ?>
                <?php echo form_input($form['harga_paket']); ?>
              </div>
            </div>

            


          
            <div class="form-group">
            <label>Produk</label>
            <br>
                <?php echo form_error('prodsId[]'); ?>
                  <?php  
                  $data_tags = $this->db->get('product');
                  foreach ($data_tags->result() as $key => $value) {
                  ?>
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                  
                  <div class="checkbox">
                    <label>
                      <input name="prodsId[]" type="checkbox" class='flat' value="<?php echo $value->prodsId; ?>"> <?php echo $value->prodsName; ?>
                    </label>
                  </div>
                  
                </div>

                <div class="col-sm-4">

                <?php echo form_error('jumlah_list'); ?>
                <?php  
                  $form = array(
                    'jumlah_list' => array(
                      'name' => 'jumlah_list[]', 
                      'value' => set_value('jumlah_list', isset($form_value['jumlah_list']) ? $form_value['jumlah_list'] : ''),
                      'class'=>'form-control',
                      'type' => 'number',
                      'placeholder' => 'jumlah',
                    ),
                  );
                ?>
                <?php echo form_input($form['jumlah_list']); ?>

                </div>
                <?php
                  }
                  ?>

              </div>
          
              
                
              
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>
        <div class="col-sm-10">
          <?php echo form_error('keterangan_paket'); ?>
          <?php  
            $form = array(
              'keterangan_paket' => array(
                'name' => 'keterangan_paket', 
                'value' => set_value('keterangan_paket', isset($form_value['keterangan_paket']) ? $form_value['keterangan_paket'] : ''),
                'class'=>'form-control',
                'type' => 'text',
                'placeholder' => 'Keterangan',
              ),
            );
          ?>
          <?php echo form_input($form['keterangan_paket']); ?>
        </div>
      </div>

      <hr>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>
        <?php echo form_close(); ?>



      </div>
    </div>
  </div>
</div>