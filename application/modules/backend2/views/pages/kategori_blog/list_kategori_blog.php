<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title">Halaman ini digunakan untuk mengelola kategori blog. </h4>
                        <div align="right">
                          <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-default' )); ?>
                          <?php echo anchor('backend/kategori_blog/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Kategori Blog', array('class' => 'btn btn-primary')); ?>
                        </div>
                        <?php echo $table; ?>
                <select class="form-control" name="kurir[]" id="kurir" required="required" multiple="multiple">
                    <option value="pos">POS</option>
                    <option value="jne">JNE</option>
                </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>