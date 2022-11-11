<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
   
     <div class="col-sm-6">
      <div class="content-header">Edit Subadmin</div>
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

            <form class="form" id="edit_subadmin" method="post">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Edit Subadmin</h4>
                     
              <?php 
              $val = $this->uri->segment(2);
              $name =  getsubadminDetails($res->user_id,'admin_name');
               $code =  getsubadminDetails($res->user_id,'code');
               $status =  getsubadminDetails($res->user_id,'status');
              // $password = getsubadminDetails($res->user_id,'password');
              $password = encrypt_decrypt('decrypt',getsubadminDetails($res->user_id,'password')); 
              $email = encrypt_decrypt('decrypt',getsubadminDetails($res->user_id,'email_id')); 

              $assign_array     =   json_decode($res->access,true);

              $assign_array     =   array_column($assign_array, 'view');

              ?>

                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Name</label>
                    <input type="text" id="name" class="form-control border-primary" placeholder="Name" name="name" value="<?php echo $name; ?>">
                  </div>
                 
                </div>

                 <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Email ID</label>
                    <input type="text" id="email" class="form-control border-primary" placeholder="Email ID" name="email" value="<?php echo $email; ?>">
                  </div>
                 
                </div>

                   <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Password</label>
                    <input type="password" id="password" class="form-control border-primary" placeholder="Password" name="password" value="<?php echo $password; ?>">
                  </div>
                 
                </div>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $res->user_id; ?>">
                <input type="hidden" name="val" id="val" value="<?php echo $val; ?>">
                
                      <div class="row justify-content-md-center">
                    <fieldset class="form-group col-md-6 mb-2">
                      <label for="basicSelect">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option  value="">Select Option</option>
                        <option value="1"<?php if($status == 1) { echo 'selected'; } ?>>Active</option>
                        <option value="0"<?php if($status == 0) { echo 'selected'; } ?>>Deactive</option>
                      
                      </select>
                    </fieldset>
                  </div>

                  <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="access_options">User access</label>
                  <?php  foreach ($access_user as $mkey => $mvalue) {
                   ?>
                    <div class="remember-me">
                      <div class="custom-control custom-checkbox custom-control-inline mb-3">
                        <input type="checkbox" id="customCheckboxInline_<?php echo $mkey; ?>" name="access_options[<?php echo $mvalue->acc_id;?>][view]" class="custom-control-input"  <?php if(in_array($mvalue->acc_id,$assign_array)){?> checked="checked" <?php } ?> value="<?php echo $mvalue->acc_id;?>" />
                        <label class="custom-control-label" for="customCheckboxInline_<?php echo $mkey; ?>">
                        <?php echo $mvalue->acc_name;?>
                        </label>
                      </div>
                    </div>
                  <?php } ?>

                  <label id="access_options[]-error" class="error" for="access_options[]"></label>

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
  </div>
 
</section>
<!-- // Form actions layout section end -->

          </div>
        </div>
         