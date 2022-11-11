<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <div class="col-sm-6">
      <div class="content-header">Level Password Management</div>
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

            <form class="form" id="level_password_one" method="post">

              <input type="hidden" name="levelid" id="levelid" value="1">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i> <strong> Level 1 - 15 Password </strong></h4>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Current Password</label>
                    <input type="Password" id="levelPasswrd" class="form-control border-primary" placeholder="Current Password" name="levelPasswrd" value="">
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">New Password</label>
                    <input type="Password" id="npass" class="form-control border-primary" placeholder="New Password" name="npass" value="">
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Confirm New Password</label>
                    <input type="Password" id="cnpass" class="form-control border-primary" placeholder="Confirm New Password" name="cnpass" value="">
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


        <div class="card-body">
          <div class="px-3">

            <form class="form" id="level_password_two" method="post">

              <input type="hidden" name="levelid" id="levelid" value="16">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i><strong> Level 16 - 31 Password </strong></h4>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Current Password</label>
                    <input type="Password" id="levelPasswrd" class="form-control border-primary" placeholder="Current Password" name="levelPasswrd" value="">
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">New Password</label>
                    <input type="Password" id="tnpass" class="form-control border-primary" placeholder="New Password" name="npass" value="">
                  </div>
                 
                </div>
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Confirm New Password</label>
                    <input type="Password" id="tcnpass" class="form-control border-primary" placeholder="Confirm New Password" name="cnpass" value="">
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
         