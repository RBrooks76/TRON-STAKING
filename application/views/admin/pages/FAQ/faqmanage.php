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
          <h4 class="card-title">FAQ Management</h4>
          
        </div>

      <div class="text-right d-none d-sm-none d-md-none d-lg-block">
               
               <a href="<?php echo base_url() . 'faqadd' ?>">  <button type="button" class="btn btn-success btn-raised mr-3"><i class="fa fa-plus"></i> Add FAQ</button> </a>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>QUESTION</th>
                  <th>LANGUAGE</th>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>


              <?php
                if ($faq) {
                  $i = 1;
                  foreach($faq as $result) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $result->question; ?></td>
                  <td><?php echo get_data(LANG,array('id'=>$result->language))->row()->lang_name; ?></td>
                  <td><?php  if($result->status == 1) { echo 'Active'; } else { echo 'Deactive';} ?></td>
                  <td>
                    <a href="<?php echo base_url() . 'faqedit/'. insep_encode($result->id)  ?>"title="Edit this faq"><i class="fa fa-edit"> </i> </a>
                    <a href="<?php echo base_url() . 'faqdelete/'. insep_encode($result->id)  ?>"title="Delete this faq"><i class="fa fa-trash"> </i> </a>
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

  