    <?php echo form_open($form_action); ?>
    <h4>Akun reseller akan dinonaktifkan ?</h4>
      <p>
        <label for="confirm">Yes:</label>
    <input type="radio" name="confirm" value="yes" checked="checked" />
        <label for="confirm">No:</label>
    <input type="radio" name="confirm" value="no" />
      </p>

      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('id'=>$user['id'])); ?>

      <p>
        <?php echo anchor($this->session->userdata('lolin_urlback_backend'), 'Batal', array('class' => 'btn btn-default btn-xs')); ?>
        <?php echo form_submit('submit', 'Ok', array('class' => 'btn btn-dark btn-xs')); ?>    
      </p>

    <?php echo form_close(); ?>