<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <?php if($mode == "Edit") {?>
    <div class="col-sm-6">
      <div class="content-header">Edit User</div>
    </div>
  <?php } else { ?>
     <div class="col-sm-6">
      <div class="content-header">Add User</div>
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

       

        <?php } else { ?>


        <div class="card-body">
          <div class="px-3">

            <form class="form" id="add_user" method="post">

              <div class="form-body">
                <h4 class="form-section"><i class="ft-info"></i>Add User</h4>


                <div class="row justify-content-md-center">
                  <fieldset class="form-group col-md-6 mb-2">
                      <label for="addanswer">ETH address</label>
                      <textarea class="form-control" name= "ethaddress" id="ethaddress" rows="3"
                        placeholder="ETH address"></textarea>
                    </fieldset>
                  </div>

                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Contract Id</label>
                    <input type="text" id="contactid" class="form-control border-primary" placeholder="Contract Id" name="contactid" value="">
                  </div>
                 
                </div>

                <div class="row justify-content-md-center">
                  <div class="form-group col-md-6 mb-2">
                    <label for="userinput1">Refferal Id</label>
                    <input type="text" id="refferalid" class="form-control border-primary" placeholder="Refferal Id" name="refferalid" value="">
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
             

              <div class="form-actions right">
                <button type="reset" class="btn btn-raised btn-warning mr-1">
                  <i class="ft-x"></i> Cancel
                </button>
                <button type="submit" class="btn btn-raised btn-primary" >
                  <i class="fa fa-check-square-o"></i> Save
                </button>

              </div>
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


          <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel1">Are You Sure to add this user</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <label>ETH address: <label id="modaladdress"></label></label><br>
                            <label>Contract Id: <label id="modalcontract"></label></label><br>
                            <label>Referral Id: <label id="modalrefferal"></label></label><br>
                            <label>Status: <label id="modalstatus"></label></label><br>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                          <button type="button" id="savedata" class="btn btn-outline-primary">Confirm</button>
                        </div>
                      </div>
                    </div>
                  </div>
         