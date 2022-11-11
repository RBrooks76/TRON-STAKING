<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
     
     <div class="col-sm-6">
      <div class="content-header">Update Language Content</div>
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

            <form class="form" id="edit_language" method="post" enctype="multipart/form-data">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Edit Language</h4>
              <div class="row ">
                    <div class="form-group col-md-6 mb-2">
                    <fieldset class="form-group">
                      <label for="language">Language</label>
                      <select class="form-control" id="language" name="language">
                        <option value="<?php echo $lang_name;?>"><?php echo $lang_name;?></option>
                      </select>
                    </fieldset>
                  </div>

              

                  <div class="col-md-2 mb-2">
                    <a href="<?php echo base_url(); ?>download/<?php echo strtolower($lang_name);?>">Download File</a>
                  </div>

                  </div>

                  <div class="row">

                  <div class="form-group col-md-6 mb-2">
                      <fieldset class="form-group">
                      <label for="new_lang">Upload Language file</label>
                      <input type="file" class="form-control-file" id="new_lang" name="new_lang" required="" accept=".php">
                      </fieldset>
                   
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
         