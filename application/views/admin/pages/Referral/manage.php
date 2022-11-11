<div class="main-panel">
    <div class="main-content">
        <div class="content-wrapper">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="col-sm-6">
                                <?php 
                if(!empty(FS::session()->flashdata('success')))
                {
                ?>
                                <div class="alert alert-success"> <?php echo FS::session()->flashdata('success')?>
                                </div>
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

                            <div class="card-header">
                                <h4 class="card-title">Referral Link Management
                                    <button class="btn btn-success pull-right add_new" type="button">
                                        Add New Tree <i class="fa fa-plus"></i>
                                    </button>
                                </h4>



                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Tree ID</th>
                                                <th>Referral Link</th>
                                                <th>Date Time</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                        if(!empty($result))
                        {

                          $i=1;

                          foreach ($result as $key => $value) {

                            extract($value);

                          ?>

                                            <tr>

                                                <td><?php echo $i;?> </td>
                                                <td> <?php echo $tree_id;?></td>
                                                <td><?php echo base_url().'en/refer/'.$tree_id.'/'.$referral_link;?>
                                                </td>
                                                <td> <?php echo $created_at;?></td>
                                                <td> <a href="javascript:;"
                                                        data-url="<?php echo base_url().'en/refer/'.$tree_id.'/'.$referral_link;?>"
                                                        class="copy_link" title="Copy Link"> <i class="fa fa-copy"
                                                            title="Copy Link"></i> </a></td>

                                            </tr>

                                            <?php  

                          $i++;

                          }
                        }
                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>