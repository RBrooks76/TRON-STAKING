<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <div class="col-sm-6">
      <div class="content-header">Admin Profile Settings</div>
    </div>
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
  </div>
  <div class="row ">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="from-actions-bottom-right"><!-- User Profile --></h4>
          
        </div>
        <div class="card-body">
          <div class="px-3">

            <form class="form" id="profile_form" method="post" enctype="multipart/form-data"  >

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Admin Profile</h4>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Email Address</label>
                    <input type="text" id="email" class="form-control border-primary" placeholder="Email address" name="email" value="<?php echo encrypt_decrypt('decrypt', $profile->email_id);?>" readonly>
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Phone Number</label>
                    <input type="text" id="phone_no" class="form-control border-primary" placeholder="Phone Number" name="phone_no" value="<?php echo $profile->phone ;?>">
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1"> FirstName</label>
                    <input type="text" id="fname" class="form-control border-primary" placeholder="FirstName" name="fname" value="<?php echo $profile->first_name ;?>">
                  </div>
                 
                </div>  
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1"> LastName</label>
                    <input type="text" id="lname" class="form-control border-primary" placeholder="LastName" name="lname" value="<?php echo $profile->last_name ;?>">
                  </div>
                 
                </div>             
              
                <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="admin_img">Profile Image</label>
                      <input type="file" class="form-control-file" id="admin_img" name="admin_img">
                    </fieldset>
                  </div>
                </div>
                <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                  <?php if($profile->profile_picture){?>
                  <div class="form-group col-md-6 mb-2">
                      <img height="100" weight="100" src="<?php echo base_url().'ajqgzgmedscuoc/img/admin/img_admin/'.$profile->profile_picture;?>"/>
                  </div>
                   <?php }
                     ?>
                    </div>
                  </div>


              </div>

              <div class="form-actions right">
                <button type="reset" class="btn btn-raised btn-warning mr-1">
                  <i class="ft-x"></i> Cancel
                </button>
                <button type="submit" class="btn btn-raised btn-primary">
                  <i class="fa fa-check-square-o"></i> Save
                </button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
 
</section>
<!-- // Form actions layout section end -->

          </div>
        </div>
         