<div class="main-panel">
        <!-- BEGIN : Main Content-->
  <div class="main-content">
      <div class="content-wrapper"><!-- Zero configuration table -->
<section id="configuration">
  <div class="row">
    <div class="col-12">
      <div class="card">

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

        <div class="card-header">
          <h4 class="card-title">Subadmin Management</h4>
          
        </div>

      <div class="text-right d-none d-sm-none d-md-none d-lg-block">
               
               <a href="<?php echo base_url() . 'subadminadd' ?>">  <button type="button" class="btn btn-success btn-raised mr-3"><i class="fa fa-plus"></i> Add Subadmin</button> </a>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                   <th>S.No</th>
                   <th>Username</th> 
                   <th>Email id</th>                    
                   <th>Status</th>
                   <th>Action&nbsp;&nbsp;&nbsp;</th>
                </tr>
              </thead>
              <tbody>

              <?php
                if ($subadmin) {
                  $i = 1;
                  foreach($subadmin as $result) { 
                     $Type = getsubadminDetails($result->user_id,'type');
                 if(($result->user_id != 1) && ($Type != '1')){ ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo getsubadminDetails($result->user_id,'admin_name'); ?></td>
                  <td><?php echo encrypt_decrypt('decrypt',getsubadminDetails($result->user_id,'email_id')); ?></td>
                  <?php  $status = getsubadminDetails($result->user_id,'status'); ?>
                  <td><?php  if($status == 1) { echo 'Active'; } else { echo 'Deactive';} ?></td>
                  <td>
                    <a href="<?php echo base_url() . 'subadminedit/'. insep_encode($result->user_id)  ?>" title="Edit this Admin"><i class="fa fa-edit"> </i> </a>
                    <a href="<?php echo base_url() . 'subadmindelete/'. insep_encode($result->user_id)  ?>"title="Delete this Admin"><i class="fa fa-trash"> </i> </a>
                  </td>
                 
                </tr>
                <?php  $i++;
                  }  }       
                } else{?>
                <?php }?>
              </tbody>
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Zero configuration table -->
<!-- Default ordering table -->







<!--/ Language - Comma decimal place table -->

          </div>
        </div>
        <!-- END : End Main Content-->

  