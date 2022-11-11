<!-- BEGIN : Body-->
  <body data-col="1-column" class=" 1-column  blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!--Login Page Starts-->
<section id="login">
  <div class="container-fluid">
    <div class="row full-height-vh m-0">
      <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="card">
          <div class="card-content">
            <div class="card-body login-img">
              <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none py-2 text-center align-middle">
                  <img src="<?php echo base_url()?>ajqgzgmedscuoc/admin/img/gallery/login.png" alt="" class="img-fluid mt-5" width="400" height="230">
                </div>


                <div class="col-lg-6 col-md-12 bg-white px-4 pt-3">



                  <form id="login_form" class="login_form">

                    <?php 
                if(!empty(FS::session()->flashdata('success')))
                {
                ?>
                <div class="alert alert-success"> <?php echo FS::session()->flashdata('success')?> </div>
                <?php 
                }
                else if(!empty(FS::session()->flashdata('error')))
                {
                ?>
                <div class="alert alert-danger"> <?php echo FS::session()->flashdata('error')?> </div>
                <?php 
                }
                ?>
                <!-- <input type="hidden" name="pattern" id="pattern" value="123">
 -->
                  <h4 class="mb-2 card-title">Login</h4>
                  <p class="card-text mb-3">
                    Welcome back, please login to your account.
                  </p>
                  <p>
                    <div class="" id="show_msg"> </div>
                  </p>
                  <input type="text" class="form-control mb-3" placeholder="Email" name="email" id="email" />
                  <input type="password" class="form-control mb-1" placeholder="Password" name="password" id="password" />

                <div class="form-group">
                <div class="input-group">
                  <div class="maincontainer">
                    <div id="patterncontainer" class="patterncontainer">
                    </div>
                    <input type="hidden" name="pattern" id="pattern">
                  </div>
                </div>
                <label id="pattern-error" class="help-inline" for="pattern" style="display: none;">Pattern is required</label>
              </div>

                  <div class="d-flex justify-content-between mt-2">
                    <!-- <div class="remember-me">
                      <div class="custom-control custom-checkbox custom-control-inline mb-3">
                        <input type="checkbox" id="customCheckboxInline1" name="remember" class="custom-control-input" />
                        <label class="custom-control-label" for="customCheckboxInline1">
                          Remember Me
                        </label>
                      </div>
                    </div> -->
                    <div class="forgot-password-option">
                      <a href="<?php echo base_url()?>forgotpass" class="text-decoration-none text-primary">Forgot Password
                        ?</a>
                       </div>
                       <div class="forgot-password-option">
                      <a href="<?php echo base_url()?>forgotpattern" class="text-decoration-none text-primary">Forgot Pattern
                        ?</a>
                    </div>
                  </div>
                  <div class="fg-actions mt-4 justify-content-center mx-auto">
                    <div class="login-btn">
                       
                    </div>
                    <div class="recover-pass text-center">
                      <button class="btn btn-primary" type="submit">
                        Login
                      </button>
                    </div>
                  </div>
                </form>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Login Page Ends-->

          </div>
        </div>
        <!-- END : End Main Content-->
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

   
  </body>
 