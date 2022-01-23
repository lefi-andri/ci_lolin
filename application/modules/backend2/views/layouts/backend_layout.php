<!DOCTYPE html>
<html>
<head>
    <?php echo $head; ?>
</head>
<body class="<?php echo $body_class; ?>">
    <div class="app">
        <div class="layout">
            <!-- Side Nav START -->
            <?php echo $navbar; ?>
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">
                <!-- Header START -->
                <?php echo $header; ?>
                <!-- Header END -->

                <!-- Side Panel START -->
                <?php echo $side_panel; ?>
                <!-- Side Panel END -->

                <!-- theme configurator START -->
                <?php echo $theme_configurator; ?>
                <!-- theme configurator END -->

                <!-- Theme Toggle Button START -->
                <!--button class="theme-toggle btn btn-rounded btn-icon">
                    <i class="ti-palette"></i>
                </button-->
                <!-- Theme Toggle Button END -->

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="container-fluid">
                        <div class="page-title">
                            <h4><?php echo $label; ?></h4>
                        </div>
                        <?php echo $this->load->view('slices/message'); ?>
                        <?php echo $content; ?>
                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <?php echo $footer; ?>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->

        </div>
    </div>
    <?php echo $footer_javascript; ?>
    <?php echo $js; ?>
</html>