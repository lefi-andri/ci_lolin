<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
    <head>
        <title>Recaptcha - harviacode.com</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <style>
            .login-box{
                width: 300px;
                margin-top: 100px;
            }
        </style>
        <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <div class="login-box">
                    <h3>Please Sign In</h3>
                    <?php
                    echo form_open($action);
                    ?>
                    <div class="form-group">
                        <label>Username</label>
                        <?php echo form_input('username', $username, 'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <?php echo form_password('password', $password, 'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <div id="captcha1"></div>
                    </div>
                    <div class="form-group">
                        <?php echo form_submit('login', 'login', 'class="btn btn-primary"'); ?>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="login-box">
                    <h3>Register</h3>
                    <?php
                    echo form_open($action2);
                    ?>
                    <div class="form-group">
                        <label>Username</label>
                        <?php echo form_input('username2', $username2, 'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <?php echo form_password('password2', $password2, 'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
                        <div id="captcha2"></div>
                    </div>
                    <div class="form-group">
                        <?php echo form_submit('register', 'register', 'class="btn btn-primary"'); ?>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
 
        <script>
            var CaptchaCallback = function () {
                grecaptcha.render('captcha1', {'sitekey': '6LdN2w0TAAAAAGlQcnEYzBFn3Mc03TlTjE2p5Zfj'});
                grecaptcha.render('captcha2', {'sitekey': '6LdN2w0TAAAAAGlQcnEYzBFn3Mc03TlTjE2p5Zfj'});
            };
        </script>
 
    </body>
</html>

<!--html>
    <head>
        <title>Recaptcha - harviacode.com</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <style>
            .login-box{
                width: 300px;
                margin: auto;
                margin-top: 100px;
            }
        </style>
        <?php //echo $script_captcha; // javascript recaptcha ?>
    </head>
    <body>
        <div class="login-box">
            <h3>Please Sign In</h3>
            <?php
            //echo form_open($action);
            ?>
            <div class="form-group">
                <label>Username</label>
                <?php //echo form_input('username', $username, 'class="form-control"'); ?>
            </div>
            <div class="form-group">
                <label>Password</label>
                <?php //echo form_password('password', $password, 'class="form-control"'); ?>
            </div>
            <div class="form-group">
                <?php //echo $captcha // tampilkan recaptcha ?>
            </div>
            <div class="form-group">
                <?php //echo form_submit('login', 'login', 'class="btn btn-primary"'); ?>
            </div>
        </div>
    </body>
</html-->