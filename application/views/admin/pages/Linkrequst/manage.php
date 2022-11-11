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
                  <h4 class="card-title">Link Request Management </h4>

                  

                </div>
                <div class="card-content">
                  <div class="card-body card-dashboard table-responsive">
                    <table class="table table-striped table-bordered zero-configuration">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Request Type</th>
                          <th>Request Value</th>
                          <!-- <th>Status</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(!empty($result))
                        {

                          $i=1;

                          foreach ($result as $key => $value) {

                            extract($value);

                            if($request_type == 1)
                            {
                              $type   = 'Email';
                            }
                            else if($request_type == 2)
                            {
                              $type   = 'Whatsapp';
                            }
                            else if($request_type == 3)
                            {
                              $type   = 'Telegram';
                            }

                          ?>

                          <tr>

                            <td><?php echo $i;?> </td> <td> <?php echo $type;?></td> <td><?php echo $request_type == 1 ? $request_value : $request_value.' - '.$request_e;?> </td> <!-- <td> <?php //echo $request_status;?></td> -->

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