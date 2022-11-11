<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <?php if($mode == "Edit") {?>
    <div class="col-sm-6">
      <div class="content-header">Edit Presentation</div>
    </div>
  <?php } else { ?>
     <div class="col-sm-6">
      <div class="content-header">Add Presentation</div>
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
          <h4 class="card-title" id="from-actions-bottom-right"><!-- User Profile --></h4>
          
        </div>
 <?php if($mode == "Edit") {?>

        <div class="card-body">
          <div class="px-3">

            <form class="form" id="edit_presen" method="post" enctype="multipart/form-data">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Edit Presentation</h4>


                 <div class="row justify-content-md-center">
                    <div class="col-md-6 mb-2">
                    <fieldset class="form-group">
                      <label for="language">Language</label>
                      <select class="form-control" id="language" name="language">
                        <option value="">Select Language</option>
                     <?php foreach($lang as $key => $value){ ?>
                      <option value="<?php echo $value->id;?>"  <?php if($presen->language == $value->id ) {echo 'selected';} ?> ><?php echo $value->lang_name;     ?></option> 
                      <?php } ?> 
                      </select>
                    </fieldset>
                  </div>
                </div>


                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Title</label>
                    <input type="text" id="title" class="form-control border-primary" placeholder="Banner Title" name="title" value="<?php echo $presen->title ; ?>">
                  </div>
                 
                </div>
              

                  <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="presen_img">Presentation Image</label>
                      <input type="file" class="form-control-file" id="presen_img" name="presen_img">
                    </fieldset>
                  </div>
                </div>

                   <?php if($presen->image){?>

                   <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                       <img width="200" height="100" src="<?php echo base_url().'ajqgzgmedscuoc/img/admin/Presentation/img/'.$presen->image;?>"/>
                   
                </div>
              </div>
                <?php } ?>



                   <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="presen_doc">Presentation Document</label>
                      <input type="file" class="form-control-file" id="presen_doc" name="presen_doc">
                    </fieldset>
                  </div>
                </div>


                  <?php if($presen->document){?>

                   <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                      <a href="<?php echo base_url().'ajqgzgmedscuoc/img/admin/Presentation/doc/'.$presen->document;?>"/ target="_blank">View Document </a>
                   
                </div>
              </div>
                <?php } ?>


                  <div class="row justify-content-md-center">
                    <fieldset class="form-group col-md-6 mb-2">
                      <label for="basicSelect">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option  value="">Select Option</option>
                        <option value="1"<?php if($presen->status == 1) { echo 'selected'; } ?>>Active</option>
                        <option value="0"<?php if($presen->status == 0) { echo 'selected'; } ?>>Deactive</option>
                      
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

            <form class="form" id="add_presen" method="post" enctype="multipart/form-data">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Add Presentation</h4>

      

                 <div class="row justify-content-md-center">
                 <div class="col-md-6 mb-2">
                    <fieldset class="form-group">
                      <label for="addlanguage">Language</label>
                      <select class="form-control" id="addlanguage" name="addlanguage">
                        <option value="">Select Language</option>
                     <?php foreach($lang as $key => $value){ ?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->lang_name;     ?></option> 
                      <?php } ?> 
                      </select>
                    </fieldset>
                  </div>
                </div>
                
                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Title</label>
                    <input type="text" id="addtitle" class="form-control border-primary" placeholder="Presentation Title" name="addtitle" value="">
                  </div>
                 
                </div>
               
                <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="addpresen_img">Presentation Image</label>
                      <input type="file" class="form-control-file" id="addpresen_img" name="addpresen_img">
                    </fieldset>
                  </div>
                </div>


                  <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12">
                    <fieldset class="form-group">
                      <label for="addpresen_doc">Presentation Document</label>
                      <input type="file" class="form-control-file" id="addpresen_doc" name="addpresen_doc">
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
         