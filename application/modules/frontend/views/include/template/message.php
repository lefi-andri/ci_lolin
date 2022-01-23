<?php  
/**
*
* @ Pesan Session
*
*/
?>
<?php $message_error = $this->session->flashdata('message_error'); ?>
<?php if (! empty($message_error)) : ?>
    <div id="notifications" class="alert alert-danger alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $message_error; ?></strong>
    </div>   
<?php endif ?>

<?php $message_success = $this->session->flashdata('message_success'); ?>
<?php if (! empty($message_success)) : ?>
    <div id="notifications" class="alert alert-success alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $message_success; ?></strong>
    </div>     
<?php endif ?>

<?php $message_info = $this->session->flashdata('message_info'); ?>
<?php if (! empty($message_info)) : ?>
    <div id="notifications" class="alert alert-info alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $message_info; ?></strong>
    </div>     
<?php endif ?>

<?php $message_warning = $this->session->flashdata('message_warning'); ?>
<?php if (! empty($message_warning)) : ?>
    <div id="notifications" class="alert alert-warning alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $message_warning; ?></strong>
    </div>     
<?php endif ?>

<?php  
/**
*
* @ Pesan String
*
*/
?>

<?php if (!empty($pesan_error)) : ?>
    <div id="notifications" class="alert alert-danger alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $pesan_error; ?></strong>
    </div>   
<?php endif ?>

<?php if (!empty($pesan_warning)) : ?>
    <div id="notifications" class="alert alert-warning alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $pesan_warning; ?></strong>
    </div>     
<?php endif ?>

<?php if (!empty($pesan_info)) : ?>
    <div id="notifications" class="alert alert-info alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $pesan_info; ?></strong>
    </div>    
<?php endif ?>

<?php if (!empty($pesan_success)) : ?>
    <div id="notifications" class="alert alert-success alert-dismissible fade show text-center" style="margin-bottom: 30px;"><span class="alert-close" data-dismiss="alert"></span>
        <strong><?php echo $pesan_success; ?></strong>
    </div>    
<?php endif ?>