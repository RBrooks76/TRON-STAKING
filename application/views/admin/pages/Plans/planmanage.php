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
          <h4 class="card-title"><?php echo $section;?> Management</h4>
          
        </div>

    
        <div class="card-content">
          <div class="card-body card-dashboard table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>PLAN NAME</th>
                  <?php echo $section == 'Plan B' ? '<th>Language</th>' : ''?>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>

              <?php

              $lang_result =  get_data(LANG,'','lang_name')->result_array();

                if ($plan) {
                  $i = 1;
                  foreach($plan as $result) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $result->plan_name; ?></td>
                  <?php 
                    if($section == 'Plan B') { echo '<td>'.$lang_result[$result->language - 1]['lang_name'].'</td>'; }
                  ?>
                  <td><?php  if($result->status == 1) { echo 'Active'; } else { echo 'Deactive';} ?></td>
                  <?php if( $result->plan_type == 'A') { $var = 'TYPEA'; } else  { $var = 'TYPEB'; }?>
                  <td>
                    <a href="<?php echo base_url() . 'planedit/'. insep_encode($result->id).'/'.insep_encode($var)  ?>"title="Edit this plan"><i class="fa fa-edit"> </i> </a>
                   
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

  