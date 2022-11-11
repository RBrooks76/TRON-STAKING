<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Form actions layout section start -->
            <section id="form-action-layouts">
                <div class="row">
                    <?php if($mode == "Edit") {?>
                    <div class="col-sm-6">
                        <div class="content-header">
                            Edit Plan
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-sm-6">
                        <div class="content-header">
                            Edit Plan
                        </div>
                    </div>

                    <?php  } ?>
                    <div class="col-sm-6">
                        <?php 
                          if(!empty(FS::session()->flashdata('success'))) {
                        ?>
                        <div class="alert alert-success"> <?php echo FS::session()->flashdata('success')?> </div>
                        <?php 
                          } else if(!empty(FS::session()->flashdata('error'))){
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
                            <?php if($mode == "B") {?>

                            <div class="card-body">
                                <div class="px-3">
                                    <form class="form" id="edit_plan" method="post" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i>Edit Plan B</h4>
                                            <div class="row justify-content-md-center">
                                                <div class="col-md-6 mb-2">
                                                    <fieldset class="form-group">
                                                        <label for="language">Language</label>
                                                        <select class="form-control" id="language" name="language">
                                                            <option value="">Select Language</option>
                                                            <?php foreach($lang as $key => $value){ ?>
                                                            <option value="<?php echo $value->id;?>"
                                                                <?php if($plan_data->language == $value->id ) {echo 'selected';} ?>>
                                                                <?php echo $value->lang_name;     ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput1">Plan Name</label>
                                                    <input type="text" id="plan_name"
                                                        class="form-control border-primary" placeholder="Plan Name"
                                                        name="plan_name" value="<?php echo $plan_data->plan_name ; ?>">
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="plan_type">Plan Type</label>
                                                    <input class="form-control" name="plan_type" id="plan_type"
                                                        placeholder="Plan Type"
                                                        value="<?php echo $plan_data->plan_type ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="receive">Receive</label>
                                                    <input class="form-control" name="receive" id="receive"
                                                        placeholder="Receive"
                                                        value="<?php echo $plan_data->receive ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="return_amt">Return Amount</label>
                                                    <input class="form-control" name="return_amt" id="return_amt"
                                                        value="<?php echo $plan_data->return_amt ; ?>"
                                                        placeholder="Return Amount">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="days">Days</label>
                                                    <input class="form-control" name="days" id="days" rows="3"
                                                        placeholder="Days" value="<?php echo $plan_data->days ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="min_deposit">Minimum Deposit</label>
                                                    <input class="form-control" name="min_deposit" id="min_deposit"
                                                        placeholder="Minimum Deposit"
                                                        value="<?php echo $plan_data->min_deposit ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="max_withdraw">Maximum Withdraw</label>
                                                    <input class="form-control" name="max_withdraw" id="max_withdraw"
                                                        value="<?php echo $plan_data->max_withdraw ; ?>"
                                                        placeholder="Maximum Withdraw">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="withdraw_happen">Withdraw Happend</label>
                                                    <input class="form-control" name="withdraw_happen"
                                                        id="withdraw_happen"
                                                        value="<?php echo $plan_data->withdraw_happens ; ?>"
                                                        placeholder="Withdraw Happend">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="hold_bonus">Hold Bonus</label>
                                                    <textarea class="form-control" name="hold_bonus" id="hold_bonus"
                                                        rows="3"
                                                        placeholder="Hold Bonus"><?php echo $plan_data->hold_bonus ; ?></textarea>
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="fund_bonus">Fund Bonus</label>
                                                    <textarea class="form-control" name="fund_bonus" id="fund_bonus"
                                                        rows="3"
                                                        placeholder="Fund Bonus"><?php echo $plan_data->fund_bonus ; ?></textarea>
                                                </fieldset>
                                            </div>
                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="referral_bonus">Referral Bonus</label>
                                                    <textarea class="form-control" name="referral_bonus"
                                                        id="referral_bonus" rows="3"
                                                        placeholder="Referral Bonus"><?php echo $plan_data->referral_bonus ; ?></textarea>
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="referral_rewards">Referral Rewards</label>
                                                    <textarea class="form-control" name="referral_rewards"
                                                        id="referral_rewards" rows="3"
                                                        placeholder="Referral Rewards"><?php echo $plan_data->referral_rewards ; ?></textarea>
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="basicSelect">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">Select Option</option>
                                                        <option value="1"
                                                            <?php if($plan_data->status == 1) { echo 'selected'; } ?>>
                                                            Active
                                                        </option>
                                                        <option value="0"
                                                            <?php if($plan_data->status == 0) { echo 'selected'; } ?>>
                                                            Deactive</option>

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

                            <?php }  else {?>

                            <div class="card-body">
                                <div class="px-3">
                                    <form class="form" id="edit_plana" method="post" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i>Edit Plan A</h4>
                                            <input type="hidden" name="language_a" id="language_a" value="1">
                                            <div class="row justify-content-md-center">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="plan_name_a">Plan Name</label>
                                                    <input type="text" id="plan_name_a"
                                                        class="form-control border-primary" placeholder="Plan Name"
                                                        name="plan_name_a"
                                                        value="<?php echo $plan_data->plan_name ; ?>">
                                                </div>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="plan_type_a">Plan Type</label>
                                                    <input class="form-control" name="plan_type_a" id="plan_type_a"
                                                        placeholder="Plan Type"
                                                        value="<?php echo $plan_data->plan_type ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="receive">Amount</label>
                                                    <input class="form-control" name="amount" id="amount"
                                                        placeholder="Amount" value="<?php echo $plan_data->amount ; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="row justify-content-md-center">
                                                <fieldset class="form-group col-md-6 mb-2">
                                                    <label for="basicSelect">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">Select Option</option>
                                                        <option value="1"
                                                            <?php if($plan_data->status == 1) { echo 'selected'; } ?>>
                                                            Active
                                                        </option>
                                                        <option value="0"
                                                            <?php if($plan_data->status == 0) { echo 'selected'; } ?>>
                                                            Deactive</option>

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
                            <?php }  ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- // Form actions layout section end -->
    </div>
</div>