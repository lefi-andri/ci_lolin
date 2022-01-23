<?php  
/**
*
* @ Pesan Session
*
*/
?>


<?php $message_error = $this->session->flashdata('message_error'); ?>
<?php if (! empty($message_error)) : ?>
    <div id="notifications" class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $message_error; ?></strong>
    </div>   
<?php endif ?>

<?php $message_success = $this->session->flashdata('message_success'); ?>
<?php if (! empty($message_success)) : ?>
    <div id="notifications" class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $message_success; ?></strong>
    </div>     
<?php endif ?>

<?php $message_warning = $this->session->flashdata('message_warning'); ?>
<?php if (! empty($message_warning)) : ?>
    <div id="notifications" class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
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
    <div id="notifications" class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $pesan_error; ?></strong>
    </div>   
<?php endif ?>

<?php if (!empty($pesan_warning)) : ?>
    <div id="notifications" class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $pesan_warning; ?></strong>
    </div>     
<?php endif ?>

<?php if (!empty($pesan_info)) : ?>
    <div id="notifications" class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong><?php echo $pesan_info; ?></strong>
    </div>    
<?php endif ?>
