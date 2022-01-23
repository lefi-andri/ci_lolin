<footer class="site-footer">
        <div class="container">
          
          
          <div class="row">
            <div class="col-md-2 padding-bottom-1x">

              <section class="widget widget-links widget-light-skin">
                <h3 class="widget-title">About</h3>
                
                <ul>
                  <li><a href="<?php echo base_url('about_us'); ?>">About Lolin</a></li>
                  <li><a href="<?php echo base_url('career'); ?>">Career Opportunities</a></li>
                  <li><a href="<?php echo base_url('contact'); ?>">Contact Us</a></li>
                </ul>
              </section>

            </div>
            <div class="col-md-2 padding-bottom-1x">
              
              <section class="widget widget-links widget-light-skin">
                <h3 class="widget-title">Peges</h3>
                <ul>
                  <li><a href="<?php echo base_url('blog'); ?>"><span>Article</span></a></li>
                  <li><a href="<?php echo base_url('event'); ?>">Event</a></li>
                  <li><a href="<?php echo base_url('testimonials'); ?>">Testimonials</a></li>
                  <li><a href="<?php echo base_url('registered_member'); ?>">Registered Member</a></li>
                </ul>
              </section>

            </div>

            <div class="col-md-2 padding-bottom-1x">
              
              <section class="widget widget-links widget-light-skin">
                <h3 class="widget-title">My Account</h3>
                <ul>
                  <li><a href="<?php echo base_url('reseller/profile'); ?>"><span>Profile</span></a></li>
                  <li><a href="<?php echo base_url('reseller/penukaran_poin'); ?>">Return & Exchanges</a></li>
                  <li><a href="<?php echo base_url('reseller/profile'); ?>">Manage Address</a></li>
                  <li><a href="<?php echo base_url('member/order'); ?>">My Orders</a></li>
                </ul>
                
              </section>

            </div>

            <div class="col-md-6 padding-bottom-1x">

              <section class="widget widget-light-skin">
                <h3 class="widget-title">Stay Connected</h3>
                <!--p class="text-white">Phone: 00 33 169 7720</p-->

                <div class="margin-top-1x hidden-md-up"></div>
              <!--Subscription-->
              <!--form class="subscribe-form" action="http://rokaux.us12.list-manage.com/subscribe/post?u=c7103e2c981361a6639545bd5&amp;amp;id=1194bb7544" method="post" target="_blank" novalidate-->
              <?php echo form_open(base_url('subscribe'), array('class' => 'subscribe-form', "target"=>"_blank")); ?>
                <div class="clearfix">
                  <div class="input-group input-light">
                    <input class="form-control" type="email" name="your_email" placeholder="Your e-mail" required="required"><span class="input-group-addon"><i class="icon-mail"></i></span>
                  </div>
                  <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                  <div style="position: absolute; left: -5000px;" aria-hidden="true">
                    <input type="text" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                  </div>
                  <button class="btn btn-primary" name="submit" type="submit"><i class="icon-check"></i></button>
                </div><span class="form-text text-sm text-white opacity-50">Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.</span>
              <?php echo form_close(); ?>
              <!--/form-->
            </div>
                
              </section>

              
          </div>

          <!-- Copyright-->
          <p class="footer-copyright">Copyright © 2015 - <?php echo date('Y'); ?> Lolin Kids Care Product. All rights reserved.</p>
        </div>



      </footer>