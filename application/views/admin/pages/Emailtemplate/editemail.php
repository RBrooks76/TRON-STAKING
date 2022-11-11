<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Form actions layout section start -->
            <section id="form-action-layouts">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="content-header">Edit Email Template</div>
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
                                <h4 class="card-title" id="from-actions-bottom-right">
                                    <!-- User Profile -->
                                </h4>

                            </div>
                            <div class="card-body">
                                <div class="px-3">

                                    <form class="form" id="edit_email" method="post">

                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i>Edit Email Template</h4>

                                            <div class="row justify-content-md-center">
                                                <div class="col-md-6 mb-2">
                                                    <fieldset class="form-group">
                                                        <label for="language">Language</label>
                                                        <select class="form-control" id="language" name="language">
                                                            <option value="">Select Language</option>
                                                            <?php foreach($lang as $key => $value){ ?>
                                                            <option value="<?php echo $value->id;?>"
                                                                <?php if($email->language == $value->id ) {echo 'selected';} ?>>
                                                                <?php echo $value->lang_name;     ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput1">Name</label>
                                                    <input type="text" id="name" class="form-control border-primary"
                                                        placeholder="Name" name="name"
                                                        value="<?php echo $email->name ; ?>">
                                                </div>

                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput1">Subject</label>
                                                    <input type="text" id="subject" class="form-control border-primary"
                                                        placeholder="Subject" name="subject"
                                                        value="<?php echo $email->subject ; ?>">
                                                </div>

                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput1">Content</label>

                                                    <textarea class="form-control" id="content_description"
                                                        name="content_description"
                                                        rows="20"><?php echo $email->template; ?></textarea>

                                                </div>

                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label id="content_description-error" class="error"
                                                        for="content_description"></label>
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