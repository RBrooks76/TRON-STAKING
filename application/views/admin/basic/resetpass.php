

  <!-- BEGIN : Body-->
  <body data-col="1-column" class=" 1-column  blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!--Forgot Password Starts-->
<section id="forgot-password">

    

  <div class="container-fluid forgot-password-bg">

    

    <div class="row full-height-vh m-0 d-flex align-items-center justify-content-center">
      <div class="col-md-7 col-sm-12">

        <div class="col-sm-6">
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
    </div>
      
        <div class="card">
          <div class="card-content">
            <div class="card-body fg-image">

               <?php $attributes=array('class'=>'form-horizontal','id'=>'reset-password');
                echo form_open($action,$attributes); ?>
              <div class="row m-0">


                <div class="col-lg-6 d-none d-lg-block text-center py-2">
                 
                  <img src="<?php echo base_url()?>ajqgzgmedscuoc/admin/img/gallery/forgot.png" alt="" class="img-fluid" width="300" height="230">
                </div>
       
                <div class="col-lg-6 col-md-12 bg-white px-4 pt-3">
                  <h4 class="mb-2 card-title">Reset Password</h4>
                  <p class="card-text mb-3">
                    Here you can reset your Password.
                  </p>
                  <input type="Password" class="form-control mb-3" placeholder="New Password " name="newpass" id="newpass" />
                  <input type="Password" class="form-control mb-3" placeholder="Confirm New Password " name="confirmpass" id="confirmpass" />
                  <div class="fg-actions d-flex justify-content-between">
                    <div class="login-btn">
                     
                        <a href="<?php echo base_url()?>authenticate" class="text-decoration-none">Back To Login</a>
                     
                    </div>
                    <div class="recover-pass">
                      <button class="btn btn-primary" type="submit">
                        Reset
                      </button>
                    </div>
                  </div>
             
           

              </div>
            </div>   </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Forgot Password Ends-->

          </div>
        </div>
        <!-- END : End Main Content-->
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

   
  </body>
 