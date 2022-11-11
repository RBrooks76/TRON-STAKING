    <div id="sideMenu">
        <?php
          if (juego_id()) {
        ?>
        <!-- Side Menu Start -->
        <div class="sideMenu">
            <div class="sideMenuClose">
                <button class="btn noBoxShadow">x</button>
            </div>
            <div class="profileContent">
                <span class="profTrigText">
                    <?php echo lang('My Profile'); ?>
                </span>
                <span class="profTrigImage">
                    <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/home/profileIcon.png"
                        alt="profileIcon" />
                </span>
            </div>
            <div class="sideMenuInner">
                <div class="sideMenuPlan">

                    <?php $getProfileID = getProfileID();

                      if (juego_id() != 'TEEXnjyMN34Nzap3okpwpinreefEQ1XxfK') {

                    ?>

                    <h2>- <?php echo lang('PLAN A'); ?> <span class="full-right">
                            <?php echo !empty($getProfileID) ? lang('PID') . ' : ' . $getProfileID : ''; ?></span> </h2>

                    <?php 
                      } else {
		                ?>

                    <div class="d-flex justify-content-between sin_cls">- <h2><?php echo lang('PLAN A'); ?> </h2><span>
                            <?php echo !empty($getProfileID) ? lang('PID') . ' : ' . $getProfileID : ''; ?></span>
                        <div class="d-flex">
                            <span class="col-md-6 p-0">Tree ID : </span>
                            <select class="form-control col-md-6 sin_select">
                                <?php if (!empty($tree_data)) {
                                  foreach ($tree_data as $tr_key => $tr_value) {
                                ?>

                                <option value="<?php echo insep_encode($tr_value['tree_id']) ?>"
                                    <?php echo @$tree_id == $tr_value['tree_id'] ? 'selected' : ''; ?>>
                                    <?php echo $tr_value['tree_id'] ?> </option>
                                <?php
			                            }}
                                ?>

                            </select>
                        </div>
                    </div>

                    <?php }?>

                    <ul class="font17">

                        <?php
                          $tree_id = !empty(@$tree_id) ? $tree_id : '';
                          if (!empty($plan_A)) {
                            foreach ($plan_A as $Akey => $Avalue) {

                              if ($tree_id >= 2) {
                                $plan_link = site_url('plandetail/' . insep_encode($Avalue->id)) . '/' . insep_encode($tree_id);
                              } else {
                                $plan_link = site_url('plandetail/' . insep_encode($Avalue->id));
                              }
                        ?>

                        <li class="fontBold">
                            <span> <?php echo lang('BOARD') . ' ' . $Avalue->amount; ?> <span> <a
                                        class="view_btn view_<?php echo $Avalue->amount; ?>"
                                        href="<?php echo $plan_link; ?>"><?php echo lang('View') ?></a></span> </span>
                        </li>
                        <li>
                            <span class="w100"> <?php echo lang('RECIEVED'); ?> : <span
                                    id="total_<?php echo $Avalue->id; ?>"> </span> TRX</span>
                            <span class="w100"> <?php echo lang('GIVEN'); ?> : <span
                                    id="give_<?php echo $Avalue->id; ?>"> </span> TRX</span>
                            <span class="w100"> <?php echo lang('KEEP'); ?> : <span
                                    id="Earns_<?php echo $Avalue->id; ?>"> </span> TRX</span>
                        </li>

                        <?php
                          }
                            }
                        ?>

                        <li class="">
                            <span class="fontBold"> <?php echo lang('C7A'); ?> : </span> <span>
                                <?php echo !empty($core_status) ? 'YES' : 'No'; ?></span>
                        </li>

                        <li class="">
                            <span class="fontBold"> <?php echo lang('YRL'); ?></span> <span>
                                <?php echo lang('PUYRL'); ?></span>
                        </li>

                        <?php
                          if (empty($ref_url_a) && empty($core_status)) {
                        ?>

                        <li class="">
                            <span class="fontBold"> <?php echo lang('SBRL'); ?> : </span> <span>
                                <?php echo lang('UYURL'); ?></span>
                        </li>

                        <?php }?>

                        <!-- <li class="fontBold">
                          <span> <?php //echo lang('BOARD'); ?> 50 <span> <a class="view_btn planb_view_history" href="javascript:;"><?php //echo lang('View')?></a></span> </span>
                        </li>
                        <li>
                          <span class="w100"> <?php //echo lang('RECIEVED'); ?> :  -:-</span>
                          <span class="w100"> <?php //echo lang('GIVEN'); ?>   :  -:-</span>
                          <span class="w100"> <?php //echo lang('KEEP'); ?>   :  -:-</span>
                        </li>

                        <li class="fontBold">
                          <span> <?php //echo lang('BOARD'); ?> 100 <span> <a class="view_btn planb_view_history" href="javascript:;"><?php //echo lang('View')?></a></span> </span>
                        </li>
                        <li>
                          <span class="w100"> <?php //echo lang('RECIEVED'); ?> :  -:-</span>
                          <span class="w100"> <?php //echo lang('GIVEN'); ?>   :  -:-</span>
                          <span class="w100"> <?php //echo lang('KEEP'); ?>   :  -:-</span>
                        </li> -->

                    </ul>
                </div>

                <?php
                  /*echo 'ref_url_a'.$ref_url_a;
                          echo 'core_status'.$core_status;*/
                  if (juego_id() != 'TEEXnjyMN34Nzap3okpwpinreefEQ1XxfK') {
                    if (!empty($ref_url_a) && !empty($core_status)) {
                ?>
                <div class="MenuWalletAddress">
                    <a class="btn noBoxShadow">
                        <span class="copyAdText referral_link" data-url="<?php echo $ref_url_a; ?>"> <i
                                class="fa fa-copy"></i>
                            <?php echo lang('Copy referral A link'); ?>
                        </span>
                    </a>
                </div>
                <?php
                  } else if (empty($ref_url_a) && empty($core_status)) {
                ?>

                <div class="MenuWalletAddress">
                    <a class="btn noBoxShadow">
                        <span class="copyAdText referrallink"> <i class="fa fa-copy"></i>
                            <?php echo lang('Copy referral A link'); ?>
                        </span>
                    </a>
                </div>

                <div class="MenuWalletAddress">
                    <a class="btn noBoxShadow">
                        <span class="copyAdText partnerreferrallink"> <i class="fa fa-copy"></i>
                            <?php echo lang('CPRL'); ?>
                        </span>
                    </a>
                </div>

                <?php
                  }
                    }
                ?>
                <div class="MenuWalletAddress">
                    <a href="javascript:;" class="show_wallet_address"> <span id="show_wallet_address">
                            <?php echo lang('Show wallet Address'); ?></span> </a>


                </div>



            </div>
        </div>
        <!-- Side Menu End -->

        <?php }?>

    </div>

    <div id="singleWindow">
        <!-- Banner Start -->
        <div class="fullscreen banner">
            <div class="container containerTwo">
                <div class="bannerContent">
                    <div class="row flex-column align-items-center justify-content-between">
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12">
                            <div class="bannerMiddleContent">
                                <h2> <?php echo lang('TOTAL INVESTED AMOUNT'); ?></h2>
                                <div class="bannerCalc">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="trx_value" id="trx_value"
                                            readonly="">
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
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="34" height="34"
                                                viewBox="0 0 34 34">
                                                <defs>
                                                    <pattern id="pattern" width="1" height="1"
                                                        patternTransform="matrix(-1, 0, 0, 1, 68, 0)"
                                                        viewBox="0 0 34 34">
                                                        <image preserveAspectRatio="xMidYMid slice" width="34"
                                                            height="34"
                                                            xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png" />
                                                    </pattern>
                                                </defs>
                                                <path data-name="Drop down icon white" d="M0,0H34V34H0Z"
                                                    fill="url(#pattern)" />
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

        <!-- Home About Start -->
        <div class="fullscreen homeAbout" id="single2">
            <div class="container containerTwo">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="homeAboutContent">
                            <h2><?php echo @$home_content->smart_contact_1; ?></h2>
                            <p><?php echo str_replace("\'", "'", $home_content->smart_contact_2); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll Section button Start TD4aZNsWJW3seMdxnUJojcaVxwo7K4fQHi-->
            <div class="bannerBottomContent">
                <div class="scrollDownContent">
                    <a href="#single3">
                        <span class="scrollDText">
                            <?php echo lang('Scroll down for more'); ?>
                        </span>
                        <span class="scrollDArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="34" height="34" viewBox="0 0 34 34">
                                <defs>
                                    <pattern id="pattern" width="1" height="1"
                                        patternTransform="matrix(-1, 0, 0, 1, 68, 0)" viewBox="0 0 34 34">
                                        <image preserveAspectRatio="xMidYMid slice" width="34" height="34"
                                            xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png" />
                                    </pattern>
                                </defs>
                                <path data-name="Drop down icon white" d="M0,0H34V34H0Z" fill="url(#pattern)" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            <!-- Scroll Section button End -->
        </div>
        <!-- Home About End -->


        <!-- Home Plan Animation Start -->
        <div class="fullscreen homePlansAnimation" id="single3">
            <div class="container">
                <div class="planAniBack inactive">
                    <div class="container containerTwo w-100">
                        <button class="btn noBoxShadow noPadding hplanAniImgTrig-back">
                            <?php echo lang('Back'); ?>
                        </button>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="row align-items-center flex-md-nowrap homePaniRow">
                            <div class="col-sm-12 col-md-12 col-lg-6 homePaniCol show">
                                <div class="hplanAniContent">
                                    <h2><?php echo @$home_content->how_every_1; ?></h2>
                                    <h3> <?php echo lang('CORE 7 ABUNDANCE'); ?></h3>
                                    <p><?php echo @$home_content->how_every_2; ?></p>
                                    <div class="hplanAniLink">
                                        <a href="javascript:;"
                                            class="btn noBoxShadow btnBr30 btnPrimay hplanAniImgTrig-join">
                                            <?php echo lang('JOIN'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6 homePaniCol show noMobile">
                                <div class="hplanAniImage">
                                    <button class="btn noBoxShadow noPadding hplanAniImgTrig-join">
                                        <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/plans/plan-path1.png"
                                            alt="plan-a-matrix-diagram" class="img-fluid" />
                                    </button>
                                </div>
                            </div>

                            <span class="scrollDText new_scrollDText">
                                <strong><?php echo lang('YNE'); ?></strong>
                            </span>

                            <?php if ($plan_A) {
                              $i = 0;
                              foreach ($plan_A as $result) {
                            ?>

                            <div class="col-sm-12 col-md-12 col-lg-6 homePaniCol">

                                <div class="hplanAniImage hplanAniImageBuy" data-id="<?php echo $result->id; ?>"
                                    data-amount="<?php echo $result->amount; ?>">

                                    <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/plans/plan-a-matrix-diagram.png"
                                        alt="plan-a-matrix-diagram" class="img-fluid" />
                                    <div class="hplanAniPrice">
                                        <span class="hpAniPriceText"> <?php echo lang('Entry with'); ?></span>
                                        <span class="hpAniPriceAmt">$<?php echo $result->amount; ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php $i++;}}?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll Section button Start -->
            <div class="bannerBottomContent">
                <div class="scrollDownContent">
                    <a href="#single4">
                        <span class="scrollDText">
                            <?php echo lang('Scroll down for more'); ?>
                        </span>
                        <span class="scrollDArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="34" height="34" viewBox="0 0 34 34">
                                <defs>
                                    <pattern id="pattern" width="1" height="1"
                                        patternTransform="matrix(-1, 0, 0, 1, 68, 0)" viewBox="0 0 34 34">
                                        <image preserveAspectRatio="xMidYMid slice" width="34" height="34"
                                            xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png" />
                                    </pattern>
                                </defs>
                                <path data-name="Drop down icon white" d="M0,0H34V34H0Z" fill="url(#pattern)" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            <!-- Scroll Section button End -->
        </div>
        <!-- Home Plan Animation End -->

        <!-- Home Plan QA Start -->
        <div class="fullscreen homePlansQA" id="single4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <h2 class="sectionTitle"><?php echo @$home_content->market_plan_1; ?></h2>
                        <p class="sectionPara"><?php echo @$home_content->market_plan_2; ?></p>
                        <div class="hplanQAblocks">
                            <div class="row">
                                <?php if ($work) {
                                	foreach ($work as $result) {
                                ?>
                                <!-- QA content Start -->
                                <div class="col-sm-12 col-md-6">
                                    <a href="javascript:;" class="popover__wrapper__"
                                        data-id="<?php echo $result->id; ?>">
                                        <div class="hplanQAcontent popover__wrapper">
                                            <div class="d-flex align-items-center popover__title">
                                                <div class="hplanQAicon">
                                                    <div class="hplanQAiconText">?</div>
                                                </div>
                                                <div class="hplanQAtext">
                                                    <h4 id="head_<?php echo $result->id; ?>">
                                                        <?php echo $result->heading ?></h4>
                                                    <p id="content_<?php echo $result->id; ?>">
                                                        <?php echo $result->content ?></p>
                                                    <input type="hidden" name="l_content"
                                                        id="l_content_<?php echo $result->id; ?>"
                                                        value="<?php echo $result->long_content ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- QA content End -->
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll Section button Start -->
            <div class="bannerBottomContent">
                <div class="scrollDownContent">
                    <a href="#single5">
                        <span class="scrollDText">
                            <?php echo lang('Scroll down for more'); ?>
                        </span>
                        <span class="scrollDArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="34" height="34" viewBox="0 0 34 34">
                                <defs>
                                    <pattern id="pattern" width="1" height="1"
                                        patternTransform="matrix(-1, 0, 0, 1, 68, 0)" viewBox="0 0 34 34">
                                        <image preserveAspectRatio="xMidYMid slice" width="34" height="34"
                                            xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png" />
                                    </pattern>
                                </defs>
                                <path data-name="Drop down icon white" d="M0,0H34V34H0Z" fill="url(#pattern)" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            <!-- Scroll Section button End -->
        </div>
        <!-- Home Plan QA End -->

        <!-- Home Plan Slider Start -->
        <div class="fullscreen homePlansSlider pad_7" id="single5">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="carousel">
                            <figure id="spinner">
                                <?php if ($plan) {
	                                foreach ($plan as $result) {
                                ?>
                                <figure>
                                    <div class="plan_sec">
                                        <h4><?php echo $result->plan_name ?></h4>
                                        <h3> <?php echo lang('a return of'); ?></h3>
                                        <h2><?php echo $result->receive ?>+%</h2>
                                        <ul>
                                            <li><?php echo $result->return_amt ?>% <?php echo lang('return for'); ?>
                                                <?php echo $result->days ?> <?php echo lang('days'); ?></li>
                                            <li> <?php echo lang('withdrawal'); ?>
                                                <?php echo $result->withdraw_happens ?></li>
                                            <li><?php echo $result->min_deposit ?>k
                                                <?php echo lang('Minimum Deposit'); ?> </li>
                                            <li> <?php echo lang('Max withdrawal of'); ?>
                                                <?php echo $result->max_withdraw ?>K <?php echo lang('per day'); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </figure>
                                <?php
                                    }
                                }
                                ?>
                            </figure>
                        </div>
                        <span style=float:left class=ss-icon onclick="galleryspin('-')">&lt;</span>
                        <span style=float:right class=ss-icon onclick="galleryspin('')">&gt;</span>

                    </div>

                    <div class="col-sm-6">
                        <?php if(isset($cms) && $cms){ ?>
                        <div class="plan_details homepSliderTBcontent ">
                            <?php 
                                $buffer = 	$cms->content_description;
                                echo html_entity_decode($buffer);
                            ?>
                            <?php $lang_url = FS::uri()->segment(1);?>
                            <div class="hplanSliderLink pl-3">
                                <a href="<?php echo $home_content->joinLink; ?>" target="_blank"><button
                                        href="javascript:;" class="btn noBoxShadow btnBr30 btnPrimay">
                                        <?php echo lang('JOIN'); ?></button></a>
                                <a href="<?php echo base_url() . $lang_url . '/cms/plan'; ?>">
                                    <button
                                        class="btn noBoxShadow btnBr30 btnPrimay"><?php echo lang('Readmore'); ?></button>
                                </a>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>

                    <!-- <div class="col-sm-6">
                        <div class="plan_details homepSliderTBcontent ">
                            < ?php if ($plan) {
                              $i = 0;
                              foreach ($plan as $result) {
                              if ($i == 1) {break;}
                            ?>

                            <h2>
                                < ?php echo lang('LWT'); ?>
                            </h2>
                            <h4>< ?php echo lang('ASP'); ?></h4>
                            <div class="homepSliderTBscroll">
                                <h3> < ?php echo lang('Hold bonus'); ?></h3>
                                <p>< ?php echo $result->hold_bonus ?></p>
                                <h3> < ?php echo lang('Fund bonus'); ?></h3>
                                <p>< ?php echo $result->fund_bonus ?></p>
                                <h3> < ?php echo lang('Referral bonus'); ?></h3>
                                <p>< ?php echo $result->referral_bonus ?></p>
                                <h3> < ?php echo lang('Referral rewards'); ?></h3>
                                <ul>
                                    < ?php echo $result->referral_rewards ?>
                                </ul>
                            </div>
                            < ?php $lang_url = FS::uri()->segment(1);?>
                            <div class="hplanSliderLink">
                                <a href="https://livewithtron.io" target="_blank"><button href="javascript:;"
                                        class="btn noBoxShadow btnBr30 btnPrimay">
                                        < ?php echo lang('JOIN'); //juego_id() == '' || empty($ref_url_b) ? lang('JOIN') : lang('Deposit');              ?></button></a>

                                <a href="< ?php echo base_url() . $lang_url . '/cms/plan'; ?>"> <button
                                        class="btn noBoxShadow btnBr30 btnPrimay">< ?php echo lang('Readmore'); ?></button> </a>
                            </div>
                            < ?php $i++;}}?>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Scroll Section button Start -->
            <div class="bannerBottomContent">
                <div class="scrollDownContent">
                    <a href="#single6">
                        <span class="scrollDText">
                            <?php echo lang('Scroll down for more'); ?>
                        </span>
                        <span class="scrollDArrow">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="34" height="34" viewBox="0 0 34 34">
                                <defs>
                                    <pattern id="pattern" width="1" height="1"
                                        patternTransform="matrix(-1, 0, 0, 1, 68, 0)" viewBox="0 0 34 34">
                                        <image preserveAspectRatio="xMidYMid slice" width="34" height="34"
                                            xlink:href="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/arrow.png" />
                                    </pattern>
                                </defs>
                                <path data-name="Drop down icon white" d="M0,0H34V34H0Z" fill="url(#pattern)" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            <!-- Scroll Section button End -->
        </div>
        <!-- Home Plan Slider End -->


        <!-- Home Why Choose Start -->
        <div class="fullscreen whyChoose" id="single6">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12 text-center">
                        <h2><?php echo @$home_content->reg_page_1; ?></h2>
                        <p><?php echo @$home_content->reg_page_2; ?></p>
                        <div class="whyChoosePoints">
                            <div class="row align-items-center">
                                <?php if ($why) {
	                                foreach ($why as $result) {
                                ?>

                                <div class="col-sm-12 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="whyChoosePointsIcons">
                                            <img src="<?php echo base_url() . 'ajqgzgmedscuoc/img/admin/whychoose/' . $result->icon ?>"
                                                alt="tick" />
                                        </div>
                                        <div class="whyChoosePointsText">
                                            <?php echo $result->heading; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home Why Choose End -->
    </div>


    <!-- homeSignShop content start -->
    <div class="homeSignShopSwap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-12 col-lg-6 mb-4">
                    <div class="homeSignShop">
                        <div class="homeSign">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="homeSignImage">
                                        <img src="<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo @$home_content->adv_tech_logo?@$home_content->adv_tech_logo:'adv_tech_logo.png' ?>"
                                            alt="homeSignup" />
                                        <?php echo @$home_content->adv_tech_logo; ?>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="homeSignContent">
                                        <h3><?php echo @$home_content->adv_tech_1; ?></h3>
                                        <p><?php echo @$home_content->adv_tech_2; ?></p>
                                        <div class="homeSignLink">
                                            <a href="<?php echo @$home_content->footer_link_1; ?>" class="btn"
                                                target="_blank"> <?php echo lang('SIGN UP'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="homeSign homeShop">
                            <div class="row">
                                <div class="col-12">
                                    <div class="homeShopImage">
                                        <img src="<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo @$home_content->footer_content_logo?@$home_content->footer_content_logo:'footer_content_logo.png' ?>"
                                            alt="crypto-mytrip" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="homeSignContent">
                                        <h3><?php echo @$home_content->footer_content_1; ?></h3>
                                        <p><?php echo @$home_content->footer_content_2; ?></p>
                                        <div class="homeSignLink">
                                            <a href="<?php echo @$home_content->footer_link_2; ?>" class="btn"
                                                target="_blank"> <?php echo lang('SHOP NOW'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="homeSection7-contain">
                        <div class="section7-item mb-3">
                            <div class="section7-img">
                                <img
                                    src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home_content->Section7_1_logo; ?>' />
                            </div>
                            <div class="section7-content">
                                <div class="content-header"><?php echo $home_content->Section7_1_head; ?></div>
                                <div class="content-content">
                                    <?php echo $home_content->Section7_1_content; ?>
                                </div>
                                <div class="content-more-btn">
                                    <a href="<?php echo $home_content->Section7_1_link; ?>"
                                        target='_blank'><?php echo lang('Readmore'); ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="section7-item mb-3">
                            <div class="section7-img">
                                <img
                                    src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home_content->Section7_2_logo; ?>' />
                            </div>
                            <div class="section7-content">
                                <div class="content-header"><?php echo $home_content->Section7_2_head; ?></div>
                                <div class="content-content">
                                    <?php echo $home_content->Section7_2_content; ?>
                                </div>
                                <div class="content-more-btn">
                                    <a href="<?php echo $home_content->Section7_2_link; ?>"
                                        target='_blank'><?php echo lang('Readmore'); ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="section7-item mb-3">
                            <div class="section7-img">
                                <img
                                    src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home_content->Section7_3_logo; ?>' />
                            </div>
                            <div class="section7-content">
                                <div class="content-header"><?php echo $home_content->Section7_3_head; ?></div>
                                <div class="content-content">
                                    <?php echo $home_content->Section7_3_content; ?>
                                </div>
                                <div class="content-more-btn">
                                    <a href="<?php echo $home_content->Section7_3_link; ?>"
                                        target='_blank'><?php echo lang('Readmore'); ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="section7-item">
                            <div class="section7-img">
                                <img
                                    src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home_content->Section7_4_logo; ?>' />
                            </div>
                            <div class="section7-content">
                                <div class="content-header"><?php echo $home_content->Section7_4_head; ?></div>
                                <div class="content-content">
                                    <?php echo $home_content->Section7_4_content; ?>
                                </div>
                                <div class="content-more-btn">
                                    <a href="<?php echo $home_content->Section7_4_link; ?>"
                                        target='_blank'><?php echo lang('Readmore'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- todo -->
            <!-- <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="homeSwap">
                        <?php
                          echo html_entity_decode($home_content->embeed_code);
                        ?>
                    </div>
                </div> -->
        </div>
    </div>
    </div>
    <!-- homeSignShop content End -->

    <!-- Plan Modal Start -->
    <!-- The Modal -->
    <div class="modal fade planModal" id="planB-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
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


                        <option value="<?php echo $result->id - 1; ?>" data-min="<?php echo $result->min_deposit; ?>">
                            <?php echo $result->plan_name; ?></option>

                        <?php }}?>
                    </select>

                    <div class="input-group">
                        <input type="text" class="form-control" name="plan_amt" id="plan_amt"
                            placeholder="Enter amount">

                        <input type="hidden" class="form-control" name="set_min" id="set_min"
                            value="<?php echo $planb[0]->min_deposit; ?>">

                        <div class="input-group-append">
                            <span class="input-group-text">.TRX</span>
                        </div>

                    </div>
                    <label for="plan_amt" class="error"></label>
                    <p class="popupHints min_deposit"> <?php echo lang('Minimum amount required:'); ?>
                        <?php echo $planb[0]->min_deposit; ?></p>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="customCheck"
                            value="1">
                        <label class="custom-control-label" for="customCheck">
                            <?php echo lang('By clicking this check box I confirm to invest the amount in TRX entered above'); ?>
                            .</label>
                    </div>
                    <label for="customCheck" class="error"></label>

                    <div class="popupSubmit">
                        <button type="submit" id="investplanb" class="btn noBoxShadow"> <?php echo lang('invest'); ?>
                        </button>
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
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                    <h2 class="text-center"> <?php echo lang('Information'); ?> </h2>

                    <h4 class="clr_org">
                        <?php echo lang('We are in test network. Kindly change your tron node ( Shasta Testnet )'); ?> .
                    </h4>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade planModal history-modal" id="planb-history-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h6> <?php echo lang('PLAN B'); ?> - <span id="planName"> </span> <span>
                            <?php echo lang('DEPOSIT HISTORY'); ?></span> </h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
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

    <div class="modal fade join_popup" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label"
        aria-hidden="true">

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
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
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
                        <button type="submit" id="investplanb" class="btn noBoxShadow"> <?php echo lang('WITHDRAW'); ?>
                        </button>
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
                    <h6> <?php echo lang('WITHDRAW'); ?> - <span id="planName"> </span> <span>
                            <?php echo lang('WITHDRAWHIS'); ?></span> </h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">



                    <div class="table-responsive modalTableContainer">

                        <table class="table table-responsive" id="with_view_history" data-page-length='5'>
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
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h6><?php echo lang('PLANAJM'); ?>.</h6>

                    <h6> <?php echo lang('GRLV'); ?> : </h6>

                    <ul class="list-unstyled d-flex justify-content-center social-icons nav nav-tabs border-bottom-0"
                        id="myTab" role="tablist">
                        <li>
                            <a href="#" data-toggle="tab" data-target="#google" role="tab" aria-controls="google"
                                aria-selected="false">
                                <i class="fab fa-google"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tab" data-target="#whatsapp" role="tab" aria-controls="whatsapp"
                                aria-selected="false">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tab" data-target="#telegram" role="tab" aria-controls="telegram"
                                aria-selected="false">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-4" id="myTabContent">
                        <div class="tab-pane" id="google" role="tabpanel" aria-labelledby="google-tab">
                            <form class="common_form" id="form_gmail" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email_field"
                                        placeholder="<?php echo lang('EGI') ?>" id="email_field" />
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btnBr30 btnPrimay-small py-2" value="Submit" />
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="whatsapp" role="tabpanel" aria-labelledby="whatsapp-tab">
                            <form class="common_form" id="form_whatsapp" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email_field"
                                        placeholder="<?php echo lang('EGI') ?>" id="wemail_field" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="<?php echo lang('EYWN') ?>"
                                        name="number_field" id="Wnumber_field" />
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btnBr30 btnPrimay-small py-2" value="Submit" />
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="telegram" role="tabpanel" aria-labelledby="telegram-tab">
                            <form class="common_form" id="form_telegram" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email_field"
                                        placeholder="<?php echo lang('EGI') ?>" id="temail_field" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="<?php echo lang('EYTN') ?>"
                                        name="number_field" id="Tnumber_field" />
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
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
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

    <div class="modal fade planModal video_pop" id="video-modal-new">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <?php
                          echo html_entity_decode($home_content->reff_embeed_code);
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade planModal new_pop" id="video-modal-news">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <a href="https://bit.ly/3eSf2US" target="_blank">
                            <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/pop_img.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade planModal" id="Reg_Modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <svg width="16.971" height="16.971" viewBox="0 0 16.971 16.971">
                            <g id="close_button" data-name="close button"
                                transform="translate(14.142 -356.382) rotate(45)">
                                <rect id="Rectangle_16" data-name="Rectangle 16" width="4" height="20"
                                    transform="translate(252 252)" fill="#fff" />
                                <rect id="Rectangle_17" data-name="Rectangle 17" width="4" height="20"
                                    transform="translate(264 260) rotate(90)" fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h6>Please insert your Gmail email ID.
                        <br>We need this information to keep you updated on Tron Googol
                        project
                    </h6>

                    <div class="mt-4 reg-gmail-input-containner">
                        <input type='gmail' class='reg-input' id='user-mail-info' />
                    </div>
                    <div class='reg-btn-containner mt-3'>
                        <button class='reg-btn' id='reg-btn'>submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
      if (!empty(FS::session()->userdata('InvalidRef'))) {
    ?>

    <script type="text/javascript">
let InvalidRef = 1;
let InvalidRefMsg = "<?php echo FS::session()->userdata('InvalidRef'); ?>";
    </script>

    <?php
        FS::session()->unset_userdata('InvalidRef');
      }
    ?>

    <script type="text/javascript">
let referrer_id = "<?php echo @$referrer_id; ?>";
let referrer = "<?php echo @$referrer; ?>";
let Areferrer_id = "<?php echo @$Areferrer_id; ?>";
let Areferrer = "<?php echo @$Areferrer; ?>";
let tree_id = "<?php echo @$tree_id; ?>";
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

      if (@$section == 'Manual') {
	  ?>

    <script type="text/javascript">
var curr_user_address = ' <?php echo @$curr_address; ?>';
    </script>

    <?php
      }
    ?>