<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Form actions layout section start -->
            <section id="form-action-layouts">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="content-header flex-center">
                            <a class='point-cursor' href="<?php echo base_url() . 'document' ?>">
                                <i class='ft-arrow-left'></i>
                            </a>
                            Add Document
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <?php 
                            if(!empty(FS::session()->flashdata('success'))) {
                        ?>

                        <div class="alert alert-success"> <?php echo FS::session()->flashdata('success')?> </div>

                        <?php 
                            } else if(!empty(FS::session()->flashdata('error'))) {
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
                                <!-- <h4 class="card-title" id="from-actions-bottom-right"></h4> -->
                            </div>

                            <div class="card-body">
                                <div class="px-3">
                                    <form class="form" id="add_doc" method="post" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i>Add Document</h4>

                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control border-primary"
                                                        placeholder="Title" name="title" value="">
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <div class="col-md-6 mb-2">
                                                    <fieldset class="form-group">
                                                        <label for="language">Language</label>
                                                        <select class="form-control" name="language">
                                                            <option value="">Select Language</option>
                                                            <?php foreach($lang as $key => $value){ ?>
                                                            <option value="<?php echo $value->id;?>"
                                                                <?php if($value->id == 1) {echo 'selected';} ?>>
                                                                <?php echo $value->lang_name;     ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <div class="col-lg-6 col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="doc">File Type (PDF,RTF,WORD,PNG,TXt,JPEG)</label>
                                                        <input type="file" class="form-control-file" name="doc">
                                                    </fieldset>
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