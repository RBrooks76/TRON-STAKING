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
            <?php echo form_open(base_url().'t_f_a',array('class'=>'login','id'=>'twofactorform')); ?>
            <input type="hidden" name="usmal" value="<?php echo $email;?>">
                <div class="form-group row">
                  <div class="col-md-6">
                    <input type="text" name="tfacode" class="form-control" placeholder="000000" required=>
                  </div>
                </div>  
                <?php
                echo '<p>Enter the Six-digit number from your mobile app here.</p>';

                ?>
                <div class="form-group">
                    
                    
                    <button type="submit" class="btn btn-raised btn-primary">Verify</button>
                    
                   

                </div>  
                <?php echo form_close(); ?>

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