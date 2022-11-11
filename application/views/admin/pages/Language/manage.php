

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
          <h4 class="card-title">Language Management</h4>
          
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>LANGUAGE</th>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>

               
              <?php
                if ($result) {
                  $i = 1;
                  foreach($result as $value) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                   <td><?php echo $value->lang_name;?></td>
                   <td><?php echo $value->status == 1 ? 'Active' : 'De-Active';?></td>
                  <td>
                    
                   <a href="<?php echo base_url() . 'languageupdate/'. $value->id ?>" title="<?php echo $value->status == 1 ? 'De-Active' : 'Active';?> the language"> <i class="fa <?php echo $value->status == 1 ? 'fa-lock' : 'fa-unlock';?>"></i></a>

                   <a href="<?php echo base_url() . 'updatelanguage/'. insep_encode($value->id)  ?>"title="Edit this "><i class="fa fa-edit"> </i> </a>

                  </td>
                 
                </tr>
                <?php  $i++;
                  }         
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

  