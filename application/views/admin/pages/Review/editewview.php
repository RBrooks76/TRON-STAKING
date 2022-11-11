<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <?php if($mode == "Edit") {?>
    <div class="col-sm-6">
      <div class="content-header">Edit Review</div>
    </div>
  <?php } else { ?>
     <div class="col-sm-6">
      <div class="content-header">Add Review</div>
    </div>

  <?php  } ?>
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
          <h4 class="card-title" id="from-actions-bottom-right">
        
            </h4>
          
        </div>
      <?php if($mode == "Edit") {?>

        <div class="card-body">
          <div class="px-3">

            <form class="form" id="edit_review" method="post" enctype="multipart/form-data">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Edit Review</h4>
    

                <input type="hidden" name="language" value="1">
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Title</label>
                    <input type="text" id="title" class="form-control border-primary" placeholder=" Title" name="title" value="<?php echo $review->title ; ?>">
                  </div>
                 
                </div>
               
              

                   <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="review_img"> Image</label>
                      <input type="file" class="form-control-file" id="review_img" name="review_img">
                    </fieldset>
                  </div>
                </div>


                  <?php if($review->image){?>

                   <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                       <img width="200" height="100" src="<?php echo base_url().'ajqgzgmedscuoc/img/admin/Review/'.$review->image;?>"/>
                   
                </div>
              </div>
                <?php } ?>


                  <div class="row justify-content-md-center">
                    <fieldset class="form-group col-md-6 mb-2">
                      <label for="basicSelect">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option  value="">Select Option</option>
                        <option value="1"<?php if($review->status == 1) { echo 'selected'; } ?>>Active</option>
                        <option value="0"<?php if($review->status == 0) { echo 'selected'; } ?>>Deactive</option>
                      
                      </select>
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

        <?php } else { ?>


        <div class="card-body">
          <div class="px-3">

            <form class="form" id="add_review" method="post" enctype="multipart/form-data">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Add Review</h4>

                <input type="hidden" name="addlanguage" value="1">
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Title</label>
                    <input type="text" id="addtitle" class="form-control border-primary" placeholder=" Title" name="addtitle" value="">
                  </div>
                 
                </div>
               
             
                  <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="addreview_img"> Image</label>
                      <input type="file" class="form-control-file" id="addreview_img" name="addreview_img">
                    </fieldset>
                  </div>
                </div>

                 
                  <div class="row justify-content-md-center">
                    <fieldset class="form-group col-md-6 mb-2">
                      <label for="basicSelect">Status</label>
                      <select class="form-control" id="addstatus" name="addstatus">
                        <option value="">Select Option</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                      
                      </select>
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

        <?php  } ?>

        </div>
      </div>
    </div>
  </div>
 
</section>
<!-- // Form actions layout section end -->

          </div>
        </div>
         