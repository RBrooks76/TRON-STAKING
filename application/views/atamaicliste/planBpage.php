    <div id="sideMenu">
    <?php

//if (juego_id()) {
?>
    <!-- Side Menu Start -->
    <div class="sideMenu">
      <div class="sideMenuClose">
        <button class="btn noBoxShadow">
          x
        </button>
      </div>
      <div class="profileContent">
        <span class="profTrigText">
           <?php echo lang('My Profile'); ?>
        </span>
        <span class="profTrigImage">
          <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/home/profileIcon.png" alt="profileIcon" />
        </span>
      </div>
      <div class="sideMenuInner">




        <div class="sideMenuPlan">
          <h2>- <?php echo lang('PLAN B'); ?> </h2>
          <ul class="noPadding font18 text-center">

            <?php
if ($planb) {
	foreach ($planb as $key => $result) {
		?>

            <li class="font20">
              <span> <?php echo lang('Deposit'); ?>  : <span id="plan_<?php echo $result->id; ?>"> 0 </span> TRX </span>
            </li>
            <li class="font20">
              <span>
               <?php echo lang('Plan'); ?>  : <span class="colorGold"> <?php echo $result->plan_name; ?> <span><a class="view_btn planb_view_history" data-name="<?php echo $result->plan_name; ?>" data-id="<?php echo $result->id; ?>" href="javascript:;"><?php echo lang('View') ?></a></span></span>
              </span>
            </li>

            <?php
}
}
?>

            <li>
              <span class="font20 w100"> <?php echo lang('Wallet'); ?>  : <span id="wallet_balance"> 0 </span> TRX</span>
              <span class="font15 w100">≈ <span id="wallet_usd_balance"> </span> USD</span>

            </li>
            <li>
              <span>
               <?php echo lang('Hold bonus'); ?>:  <span id="hold_bonus"> 0 </span> TRX
              </span>
            </li>
            <li>
              <span>
               <?php echo lang('Current fund bonus'); ?>:  <span id="fund_bonus"> 0 </span> TRX
              </span>
            </li>
            <li>
              <span>
               <?php echo lang('Referral bonus'); ?>: <span id="reff_bonus"> 0 </span> TRX
              </span>
            </li>

            <li>
              <span>
                 <?php echo lang('Withdrawn'); ?>: <span id="collected_balance"> 0 </span> TRX
              </span>
            </li>
            <li>
              <!-- <button class="btn noBoxShadow btnLightGreen btnBr30 withdraw_history" type="button">
                 <?php //echo lang('WITHDRAWHIS'); ?>
              </button> -->

              <button class="btn noBoxShadow btnLightGreen btnBr30 withdraw_modal" type="button">
                 <?php echo lang('WITHDRAW'); ?></button>

            </li>
          </ul>
        </div>



         <div class="MenuWalletAddress">
         <a href="javascript:;" class="show_wallet_address"> <span id="show_wallet_address"> <?php echo lang('Show wallet Address'); ?></span> </a>

        </div>



      </div>
    </div>
    <!-- Side Menu End -->

  <?php //}?>

  </div>

  <div id="singleWindow">

      <!-- Banner Start -->
      <div class="fullscreen banner">
        <div class="container containerTwo">
          <div class="bannerContent">
            <div class="row flex-column align-items-center justify-content-between">
              <div class="col-sm-12">

              </div>
              <div class="col-sm-12">
                <div class="bannerMiddleContent">
                  <h2> <?php echo lang('TOTAL INVESTED AMOUNT'); ?></h2>
                  <div class="bannerCalc">
                    <div class="input-group">
                      <input type="text" class="form-control" name="trx_value" id="trx_value" readonly="">
                      <div class="input-group-append">
                        <span class="input-group-text">.TRX</span>
                      </div>
                    </div>
                    <div class="bannerCalcValue">
                      <span class="bcvSign"> ≈ </span>
                      <span class="bcvValue" id="bcvValue"> 0 </span>
                      <span class="bcvCurrency"> USD </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">

                <div class="bannerBottomContent">
                  <div class="scrollDownContent">
                    <a href="#single2">
                      <span class="scrollDText">
                        <?php echo lang('Scroll down for more'); ?>
                      </span>
                      <span class="scrollDArrow">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34" height="34" viewBox="0 0 34 34">
                          <defs>
                            <pattern id="pattern" width="1" height="1" patternTransform="matrix(-1, 0, 0, 1, 68, 0)" viewBox="0 0 34 34">
                              <image preserveAspectRatio="xMidYMid slice" width="34" height="34" xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png"/>
                            </pattern>
                          </defs>
                          <path data-name="Drop down icon white" d="M0,0H34V34H0Z" fill="url(#pattern)"/>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Banner End -->

    </div>

     <!-- Plan Modal Start -->
      <!-- The Modal -->
      <div class="modal fade planModal" id="planB-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

              <input type="hidden" name="referrer_value" id="referrer_value" value="1">

              <h2> <?php echo lang('Invest in Plan B'); ?> </h2>
              <h4> <?php echo lang('Choose plan'); ?> </h4>
                <?php echo form_open(site_url('/'), array('class' => '', 'id' => 'planb_invest')); ?>
              <select name="plans" id="planb" class="custom-select">
                   <?php if ($planb) {
	foreach ($planb as $key => $result) {?>


                <option  value="<?php echo $result->id - 1; ?>" data-min="<?php echo $result->min_deposit; ?>"><?php echo $result->plan_name; ?></option>

                 <?php }}?>
              </select>

              <div class="input-group">
                <input type="text" class="form-control" name="plan_amt" id="plan_amt" placeholder="Enter amount">

                 <input type="hidden" class="form-control" name="set_min" id="set_min" value="<?php echo $planb[0]->min_deposit; ?>">

                <div class="input-group-append">
                  <span class="input-group-text">.TRX</span>
                </div>

              </div>
                <label for="plan_amt" class="error"></label>
              <p class="popupHints min_deposit"> <?php echo lang('Minimum amount required:'); ?>  <?php echo $planb[0]->min_deposit; ?></p>

              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck" name="customCheck" value="1">
                <label class="custom-control-label" for="customCheck"> <?php echo lang('By clicking this check box I confirm to invest the amount in TRX entered above'); ?> .</label>
              </div>
              <label for="customCheck" class="error"></label>

              <div class="popupSubmit">
                <button type="submit"  id="investplanb"  class="btn noBoxShadow"> <?php echo lang('invest'); ?> </button>
              </div>

             <?php echo form_close(); ?>

            </div>
          </div>
        </div>
      </div>
    <!-- Plan Modal End -->


    <div class="modal fade planModal" id="info-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

              <h2 class="text-center">  <?php echo lang('Information'); ?> </h2>

              <h4 class="clr_org">  <?php echo lang('We are in test network. Kindly change your tron node ( Shasta Testnet )'); ?> .</h4>

            </div>
          </div>
        </div>
      </div>


      <div class="modal fade planModal history-modal" id="planb-history-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h6>  <?php echo lang('PLAN B'); ?> - <span id="planName"> </span> <span> <?php echo lang('DEPOSIT HISTORY'); ?></span> </h6>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">



              <div class="table-responsive modalTableContainer">

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th> <?php echo lang('Sl.No') ?></th>
                        <th class="width_5"> <?php echo lang('Amount') ?></th>
                        <th> <?php echo lang('Date') ?></th>
                        <th> <?php echo lang('Days') ?></th>
                      </tr>
                    </thead>
                    <tbody id="view_history">
                    </tbody>
                  </table>

              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade join_popup" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">

      <!-- Modal -->
<!-- <div class="modal fade align-items-center join_popup" id="basicExampleModal modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="show_modl_content">

      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



      <div class="modal fade planModal" id="withdraw-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

              <h6> <?php echo lang('WITHDRAW'); ?> </h6>
              <h4> Withdraw Amount </h4>
                <?php echo form_open(site_url('/'), array('class' => '', 'id' => 'withdraw_form')); ?>

                <input type="text" name="with_amt" id="with_amt" class="form-control">

                <label for="with_amt" class="error"></label>
                <!-- <p class="popupHints min_deposit"> <?php //echo lang('Minimum amount required:'); ?>  <?php //echo $planb[0]->min_deposit; ?></p> -->



              <div class="popupSubmit">
                <button type="submit"  id="investplanb"  class="btn noBoxShadow"> <?php echo lang('WITHDRAW'); ?> </button>
              </div>

             <?php echo form_close(); ?>

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade planModal history-modal" id="planb-withhistory-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h6>  <?php echo lang('WITHDRAW'); ?> - <span id="planName"> </span> <span> <?php echo lang('WITHDRAWHIS'); ?></span> </h6>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">



              <div class="table-responsive modalTableContainer">

                  <table class="table table-responsive" id="with_view_history"  data-page-length='5'>
                    <thead>
                      <tr>
                        <th> <?php echo lang('Sl.No') ?></th>
                        <th> <?php echo lang('TRANS') ?></th>
                        <th class="width_5"> <?php echo lang('Amount') ?></th>
                        <th> <?php echo lang('Date') ?></th>
                      </tr>
                    </thead>
                    <tbody id="withdraw_view_history">
                      <?php
if (!empty($with_history)) {
	$i = 1;
	foreach ($with_history as $wi_key => $wi_value) {

		extract($wi_value);
		?>
                          <tr>
                            <td> <?php echo $i; ?></td>
                            <td> <?php echo substr($txhash, 0, 4) . '...' . substr($txhash, -4); ?> </td>
                            <td> <?php echo $amount; ?></td>
                            <td> <?php echo date('Y-m-d h:i:s', $timestamp / 1000); ?></td>
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


      <div class="modal fade planModal" id="joinModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
              <h6><?php echo lang('PLANAJM'); ?>.</h6>

              <h6> <?php echo lang('GRLV'); ?> : </h6>

              <ul class="list-unstyled d-flex justify-content-center social-icons nav nav-tabs border-bottom-0" id="myTab" role="tablist">
                <li>
                  <a href="#" data-toggle="tab" data-target="#google" role="tab" aria-controls="google" aria-selected="false">
                    <i class="fab fa-google"></i>
                  </a>
                </li>
                <li>
                  <a href="#" data-toggle="tab" data-target="#whatsapp" role="tab" aria-controls="whatsapp" aria-selected="false">
                    <i class="fab fa-whatsapp"></i>
                  </a>
                </li>
                <li>
                  <a href="#" data-toggle="tab" data-target="#telegram" role="tab" aria-controls="telegram" aria-selected="false">
                    <i class="fab fa-telegram-plane"></i>
                  </a>
                </li>
              </ul>
                <div class="tab-content mt-4" id="myTabContent">
                  <div class="tab-pane" id="google" role="tabpanel" aria-labelledby="google-tab">
                    <form class="common_form" id="form_gmail" method="post">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email_field" placeholder="<?php echo lang('EGI') ?>" id="email_field" />
                      </div>
                      <div class="form-group text-center">
                        <input type="submit" class="btnBr30 btnPrimay-small py-2" value="Submit" />
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="whatsapp" role="tabpanel" aria-labelledby="whatsapp-tab">
                    <form class="common_form" id="form_whatsapp" method="post">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email_field" placeholder="<?php echo lang('EGI') ?>" id="wemail_field" />
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?php echo lang('EYWN') ?>" name="number_field" id="Wnumber_field" />
                      </div>
                      <div class="form-group text-center">
                        <input type="submit" class="btnBr30 btnPrimay-small py-2" value="Submit" />
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="telegram" role="tabpanel" aria-labelledby="telegram-tab">
                    <form class="common_form" id="form_telegram" method="post">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email_field" placeholder="<?php echo lang('EGI') ?>" id="temail_field" />
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?php echo lang('EYTN') ?>" name="number_field" id="Tnumber_field"/>
                      </div>
                      <div class="form-group text-center">
                        <input type="submit" class="btnBr30 btnPrimay-small py-2" value="Submit" />
                      </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade planModal video_pop" id="video-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal">
                <svg  width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                  <g id="close_button" data-name="close button" transform="translate(14.142 -356.382) rotate(45)">
                    <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20" transform="translate(252 252)" fill="#fff"/>
                    <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20" transform="translate(264 260) rotate(90)" fill="#fff"/>
                  </g>
                </svg>
              </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

              <div class="col-md-12 text-center">

              <?php
echo html_entity_decode($home_content->video_embeed_code);
?>

              </div>

            </div>
          </div>
        </div>
      </div>

      <?php
if (!empty(FS::session()->userdata('InvalidRef'))) {
	?>

        <script type="text/javascript"> let InvalidRef = 1; let InvalidRefMsg = "<?php echo FS::session()->userdata('InvalidRef'); ?>"; </script>

        <?php

	FS::session()->unset_userdata('InvalidRef');
}
?>

      <script type="text/javascript">
        let referrer_id = "<?php echo @$referrer_id; ?>";
        let referrer    = "<?php echo @$referrer; ?>";
        let Areferrer_id = "<?php echo @$Areferrer_id; ?>";
        let Areferrer    = "<?php echo @$Areferrer; ?>";
        let tree_id    = "<?php echo @$tree_id; ?>";
      </script>

      <?php
if (!empty($ref_url_a)) {
	?>
        <script type="text/javascript">
          let is_reff_user_a = 1;
        </script>
        <?php
} else if (FS::router()->fetch_method() == 'referuser') {
	?>
        <script type="text/javascript">
          let is_reff_user_a = 1;
        </script>
        <?php
} else {
	?>
        <script type="text/javascript">
          let is_reff_user_a = 0;
        </script>
        <?php
}
?>