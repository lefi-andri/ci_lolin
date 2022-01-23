<!DOCTYPE html>
<html>



<head>
<?php echo $head; ?>
</head>

<body>
    <div class="app">
        <div class="authentication">
            <div class="sign-in-2">
                <div class="container-fluid no-pdd-horizon bg" style="background-image: url('<?php echo base_url(); ?>assets/themes/espire/dist/assets/images/others/img-30.jpg')">
                    <div class="row">
                        <div class="col-md-10 mr-auto ml-auto">
                            <div class="row">
                                <div class="mr-auto ml-auto full-height height-100">
                                    <div class="vertical-align full-height">
                                        <div class="table-cell">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="pdd-horizon-30 pdd-vertical-30">
                                                        <div class="mrg-btm-30">
                                                            <!--img class="img-responsive inline-block" src="assets/images/logo/logo.png" alt=""-->
                                                            <img class="img-responsive inline-block" src="<?php echo base_url(); ?>assets/images/template/lolin-logo.png" alt="" width="100px;">
                                                            <h2 class="inline-block pull-right no-mrg-vertical pdd-top-15">Login</h2>
                                                        </div>
                                                        <p class="mrg-btm-15 font-size-13">Please enter your user name and password to login</p>
                                                        
                                                        
                                                        <?php echo $content; ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</html>