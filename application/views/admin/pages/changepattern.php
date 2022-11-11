<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <div class="col-sm-6">
      <div class="content-header">Change Pattern</div>
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

            <form class="form change_pattern" id="change_pattern" method="post">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Change Pattern</h4>
                <div class="form-group mt-1">
                    <label for="emailExample1">Old Pattern</label>
                 <div class="maincontainer">
                          <div id="patterncontainer" class="patterncontainer">
                          </div>
                          <input type="hidden" name="old_pattern" id="pattern">
                      </div>
                  </div>
                    <label id="pattern-error" class="help-inline" for="pattern" style="display: none;">Pattern is required</label>
                  <div class="form-group">
                    <label>New Pattern</label>
                 <div class="maincontainer">
                          <div id="patterncontainers" class="patterncontainer">
                          </div>
                          <input type="hidden" name="new_pattern" id="patterns">
                      </div>
                  </div>
                    <label id="pattern-error-n" class="help-inline" for="pattern" style="display: none;">Pattern is required</label>
                  <div class="form-group">
                    <label>Your password</label>
                 <input type="password" name="con_password" id="con_password" class="form-control" placeholder="Your Current Password" />
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
         