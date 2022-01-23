<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update paket reseller</h2>
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
              <label for="inputEmail3" class="col-sm-2 control-label">Produk</label>
              <div class="col-sm-10">
                <?php echo form_error('prodsId[]'); ?>
                <?php

                $produk_list =isset($form_value['produk_list']) ? $form_value['produk_list'] : '';
                $jumlah_list =isset($form_value['jumlah_list']) ? $form_value['jumlah_list'] : '';

                $data_tags = $this->db->get('product');

                if (!empty($form_value['produk_list'])) {
                  $selected_tags = unserialize($produk_list);
                  $jumlah_list = unserialize($jumlah_list);
                  foreach ($data_tags->result() as $key => $value) {
                    if (in_array($value->prodsId, $selected_tags)) { 
                    ?>
                    <div class="checkbox">
                      <label>
                        <input name="prodsId[]" type="checkbox" class='flat' value="<?php echo $value->prodsId; ?>" checked> <?php echo $value->prodsName; ?>
                      </label>
                    </div>

                    <input type="number" name="jumlah_list[]" placeholder="Jumlah" class="form-control" value="<?php echo $jumlah_list[$key]; ?>">


                    <?php
                    }else{
                    ?>
                    <div class="checkbox">
                      <label>
                        <input name="prodsId[]" type="checkbox" class='flat' value="<?php echo $value->prodsId; ?>"> <?php echo $value->prodsName; ?>
                      </label>
                    </div>
                    <input type="number" name="jumlah_list[]" placeholder="Jumlah" class="form-control" value="">
                


                    <?php
                    }
                  }
                }else{
                  foreach ($data_tags->result() as $key_null => $value_null) {
                ?>
                <div class="checkbox">
                  <label>
                    <input name="prodsId[]" type="checkbox" class='flat' value="<?php echo $value_null->prodsId; ?>"> <?php echo $value_null->prodsName; ?>
                  </label>
                </div>
                <?php
                  }
                }
                ?>
              </div>
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
            <?php echo form_submit('submit', 'Update', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>
        <?php echo form_close(); ?>



      </div>
    </div>
  </div>
</div>