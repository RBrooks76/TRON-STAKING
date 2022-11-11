<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo getSite()->site_name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="<?php echo base_url() . 'ajqgzgmedscuoc/img/site/' . getSite()->fav_icon ?>" rel="icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/aos.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/custom.css?ver=<?php echo date('U') ?>">

    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/slick.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/aos.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.growl.js"></script>

    <?php global $myVAR;?>

    <script>
    var myVAR_language = <?php echo json_encode($myVAR); ?>;

    function getvalidationmsg(textmsg) {
        if (textmsg) {
            if (myVAR_language[textmsg]) {
                textmsg = textmsg.replace('.', '');
                return myVAR_language[textmsg];
            } else {
                return textmsg;
            }
        } else {
            return '';
        }
    }
    </script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/jquery.growl.css">
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/custom.js?ver=<?php echo date('U') ?>"></script>

</head>

<body>
    <div class="plansPage">
        <div class="planBackOthers">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <div class="planPageBack">
                        <a href="<?php echo base_url() . FS::uri()->segment(1); ?>"><button
                                class="btn noBoxShadow noPadding">
                                <?php echo lang('Back'); ?>
                            </button></a>
                    </div>

                    <div class="planPageOthers">
                        <h2><?php echo lang('OB'); ?> </h2>

                        <?php
						 	unset($plan_A[$planID - 1]);
							if (!empty($plan_A)) {
								foreach ($plan_A as $Akey => $Avalue) {
									if (isset($current_tree_id) && $current_tree_id >= 2) {
										$plan_link = site_url('plandetail/' . insep_encode($Avalue->id)) . '/' . insep_encode($current_tree_id); 
									} else $plan_link = site_url('plandetail/' . insep_encode($Avalue->id));
						?>
                        <div class="planotherLink">
                            <a href="<?php echo $plan_link ?>" class="btn">
                                <?php echo $Avalue->amount; ?> <?php echo lang('BOARD'); ?>
                            </a>
                        </div>
                        <?php
								}
							}
						?>

                        <div class="planotherLink m_clss">
                            <a href="javascript:;" class="btn"><?php echo lang('RLEAC7'); ?></a>
                        </div>
                        <?php
							if (juego_id() != ADMIN_ADDR) {
								// if (empty($ref_url_a) && empty($core_status)) {
								// 	$contract_id = @$main_user[0]['contract_id'];
								// 	if (isset($user_tree) && $user_tree != '' && count($user_tree) < 6) {
								// 		if (!empty(@$prv_main_user)) $contract_id = @$prv_main_user[0]['contract_id'];
								// 		else $contract_id = 0;
								// 	}
								// 	if (!empty($contract_id)) {
								// 		$current_tree_id = $contract_id == 1 ? 1 : $current_tree_id;
								// 		$get_upline_ref_link = @get_data(USERS, array('contract_id' => $contract_id, 'tree_id' => $current_tree_id), 'ref_code')->row()->ref_code;
								
								if (empty($ref_url_a) && empty($core_status)) {
									$contract_id = @$user_info->ref_id;
									
									if (!empty($contract_id)) {
										$current_tree_id = $contract_id == 1 ? 1 : $current_tree_id;
										$get_upline_ref_link = @get_data(USERS, array('contract_id' => $contract_id, 'tree_id' => $current_tree_id), 'ref_code')->row()->ref_code;
						?>

                        <h2><?php echo lang('SID'); ?> : <?php echo $contract_id; ?></h2>
                        <div class="planotherLink m_clss">
                            <a class="btn" href="javascript:;">
                                <span class="copyAdText up_referral_link"
                                    data-url="<?php echo base_url() . $lang_code__ . '/refer/plana/' . $get_upline_ref_link; ?>">
                                    <i class="fa fa-copy"></i>
                                    <?php echo lang('CPRL'); ?>
                                </span>
                            </a>
                        </div>
                        <?php 
									}
								}
							}
						?>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-inner">
            <div class="row">
                <?php 
					if (empty(@$prv_main_user)) {
				?>
                <div class="col-sm-7 mx-auto">
                    <div class="planDiagrams col-md-11">
                        <div class="planDiagram parent">
                            <?php
								$tree_data['main_user'] = $main_user;
								$tree_data['user_tree'] = $user_tree;

								if (!empty(@$Ouser_tree)) $tree_data['core_tree'] = array_slice(@$Ouser_tree, 2, 4);
								else $tree_data['core_tree'] = '';

								if (!empty(@$Tuser_tree)) $tree_data['tcore_tree'] = array_slice(@$Tuser_tree, 2, 4);
								else $tree_data['tcore_tree'] = '';

								if (!empty(@$Thuser_tree)) $tree_data['thcore_tree'] = array_slice(@$Thuser_tree, 2, 4);
								else $tree_data['thcore_tree'] = '';

								if (!empty(@$Fuser_tree)) $tree_data['fcore_tree'] = array_slice(@$Fuser_tree, 2, 4);
								else $tree_data['fcore_tree'] = '';

								if (!empty(@$Fiuser_tree)) $tree_data['ficore_tree'] = array_slice(@$Fiuser_tree, 2, 4);
								else $tree_data['ficore_tree'] = '';

								if (!empty(@$siuser_tree)) $tree_data['sicore_tree'] = array_slice(@$siuser_tree, 2, 4);
								else $tree_data['sicore_tree'] = '';

								if (!empty(@$seuser_tree)) $tree_data['secore_tree'] = array_slice(@$seuser_tree, 2, 4);
								else $tree_data['secore_tree'] = '';

								if (!empty(@$euser_tree)) $tree_data['ecore_tree'] = array_slice(@$euser_tree, 2, 4);
								else $tree_data['ecore_tree'] = '';
							?>

                            <?php 
								if(isset($main_user) && $main_user != '' && count($main_user)>0 && isset($tree_data['main_user']) && $tree_data['main_user'][0] && $tree_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($tree_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $tree_data);

								if(isset($main_user) && $main_user != '' && count($main_user)>0 && isset($tree_data['main_user']) && $tree_data['main_user'][0] && $tree_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>

                        </div>
                    </div>
                </div>
                <?php
					} else if (!empty(@$prv_main_user)) {
				?>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_prv_data['main_user'] = !empty(@$prv_main_user) ? $prv_main_user : '';
								$user_prv_data['user_tree'] = !empty(@$prev_user_tree) ? $prev_user_tree : '';
								
								if (!empty(@$POuser_tree)) $user_prv_data['core_tree'] = array_slice(@$POuser_tree, 2, 4);
								else $user_prv_data['core_tree'] = '';

								if (!empty(@$PTuser_tree)) $user_prv_data['tcore_tree'] = array_slice(@$PTuser_tree, 2, 4);
								else $user_prv_data['tcore_tree'] = '';
								
								if (!empty(@$PThuser_tree)) $user_prv_data['thcore_tree'] = array_slice(@$PThuser_tree, 2, 4);
								else $user_prv_data['thcore_tree'] = '';
								
								if (!empty(@$PFuser_tree)) $user_prv_data['fcore_tree'] = array_slice(@$PFuser_tree, 2, 4);
								else $user_prv_data['fcore_tree'] = '';
								
								if (!empty(@$PFiuser_tree)) $user_prv_data['ficore_tree'] = array_slice(@$PFiuser_tree, 2, 4);
								else $user_prv_data['ficore_tree'] = '';
								
								if (!empty(@$Psiuser_tree)) $user_prv_data['sicore_tree'] = array_slice(@$Psiuser_tree, 2, 4);
								else $user_prv_data['sicore_tree'] = '';
								
								if (!empty(@$Pseuser_tree)) $user_prv_data['secore_tree'] = array_slice(@$Pseuser_tree, 2, 4);
								else $user_prv_data['secore_tree'] = '';
								
								if (!empty(@$Peuser_tree)) $user_prv_data['ecore_tree'] = array_slice(@$Peuser_tree, 2, 4);
								else $user_prv_data['ecore_tree'] = '';
							?>

                            <?php 
								if(!empty(@$prv_main_user) && isset($user_prv_data['main_user']) && $user_prv_data['main_user'][0] && $user_prv_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_prv_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_prv_data);

								if(!empty(@$prv_main_user) && isset($user_prv_data['main_user']) && $user_prv_data['main_user'][0] && $user_prv_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$tree_data['main_user'] = $main_user;
								$tree_data['user_tree'] = $user_tree;

								if (!empty(@$Ouser_tree)) $tree_data['core_tree'] = array_slice(@$Ouser_tree, 2, 4);
								else $tree_data['core_tree'] = '';

								if (!empty(@$Tuser_tree)) $tree_data['tcore_tree'] = array_slice(@$Tuser_tree, 2, 4);
								else $tree_data['tcore_tree'] = '';

								if (!empty(@$Thuser_tree)) $tree_data['thcore_tree'] = array_slice(@$Thuser_tree, 2, 4);
								else $tree_data['thcore_tree'] = '';

								if (!empty(@$Fuser_tree)) $tree_data['fcore_tree'] = array_slice(@$Fuser_tree, 2, 4);
								else $tree_data['fcore_tree'] = '';

								if (!empty(@$Fiuser_tree)) $tree_data['ficore_tree'] = array_slice(@$Fiuser_tree, 2, 4);
								else $tree_data['ficore_tree'] = '';

								if (!empty(@$siuser_tree)) $tree_data['sicore_tree'] = array_slice(@$siuser_tree, 2, 4);
								else $tree_data['sicore_tree'] = '';

								if (!empty(@$seuser_tree)) $tree_data['secore_tree'] = array_slice(@$seuser_tree, 2, 4);
								else $tree_data['secore_tree'] = '';

								if (!empty(@$euser_tree)) $tree_data['ecore_tree'] = array_slice(@$euser_tree, 2, 4);
								else $tree_data['ecore_tree'] = '';
							?>

                            <?php 
								if(isset($main_user) && isset($tree_data['main_user']) && $tree_data['main_user'][0] && $tree_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($tree_data['main_user'][0]['children']) . '">';
								}

								$this->load->view(strtolower(CI_MODEL) . '/tree', $tree_data);

								if(isset($main_user) && isset($tree_data['main_user']) && $tree_data['main_user'][0] && $tree_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_one_data['main_user'] = !empty(@$Omain_user) ? $Omain_user : '';
								$user_one_data['user_tree'] = !empty(@$Ouser_tree) ? $Ouser_tree : '';
								
								if (!empty(@$OOuser_tree)) $user_one_data['core_tree'] = array_slice(@$OOuser_tree, 2, 4);
								else $user_one_data['core_tree'] = '';
								
								if (!empty(@$OTuser_tree)) $user_one_data['tcore_tree'] = array_slice(@$OTuser_tree, 2, 4);
								else $user_one_data['tcore_tree'] = '';
								
								if (!empty(@$OThuser_tree)) $user_one_data['thcore_tree'] = array_slice(@$OThuser_tree, 2, 4);
								else $user_one_data['thcore_tree'] = '';
								
								if (!empty(@$OFuser_tree)) $user_one_data['fcore_tree'] = array_slice(@$OFuser_tree, 2, 4);
								else $user_one_data['fcore_tree'] = '';
								
								if (!empty(@$OFiuser_tree)) $user_one_data['ficore_tree'] = array_slice(@$OFiuser_tree, 2, 4);
								else $user_one_data['ficore_tree'] = '';
								
								if (!empty(@$Osiuser_tree)) $user_one_data['sicore_tree'] = array_slice(@$Osiuser_tree, 2, 4);
								else $user_one_data['sicore_tree'] = '';
								
								if (!empty(@$Oseuser_tree)) $user_one_data['secore_tree'] = array_slice(@$Oseuser_tree, 2, 4);
								else $user_one_data['secore_tree'] = '';
								
								if (!empty(@$Oeuser_tree)) $user_one_data['ecore_tree'] = array_slice(@$Oeuser_tree, 2, 4);
								else $user_one_data['ecore_tree'] = '';
							?>
                            <?php 
								if(!empty(@$Omain_user) && isset($user_one_data['main_user']) && $user_one_data['main_user'][0] && $user_one_data['main_user'][0]['children']){
										echo '<a href="' . $child_url . insep_encode($user_one_data['main_user'][0]['children']) . '">';
								}
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_one_data);

								if(!empty(@$Omain_user) && isset($user_one_data['main_user']) && $user_one_data['main_user'][0] && $user_one_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_two_data['main_user'] = !empty(@$Tmain_user) ? $Tmain_user : '';
								$user_two_data['user_tree'] = !empty(@$Tuser_tree) ? $Tuser_tree : '';

								if (!empty(@$TOuser_tree)) $user_two_data['core_tree'] = array_slice(@$TOuser_tree, 2, 4);
								else $user_two_data['core_tree'] = '';

								if (!empty(@$TTuser_tree)) $user_two_data['tcore_tree'] = array_slice(@$TTuser_tree, 2, 4);
								else $user_two_data['tcore_tree'] = '';

								if (!empty(@$TThuser_tree)) $user_two_data['thcore_tree'] = array_slice(@$TThuser_tree, 2, 4);
								else $user_two_data['thcore_tree'] = '';

								if (!empty(@$TFuser_tree)) $user_two_data['fcore_tree'] = array_slice(@$TFuser_tree, 2, 4);
								else $user_two_data['fcore_tree'] = '';

								if (!empty(@$TFiuser_tree)) $user_two_data['ficore_tree'] = array_slice(@$TFiuser_tree, 2, 4);
								else $user_two_data['ficore_tree'] = '';

								if (!empty(@$Tsiuser_tree)) $user_two_data['sicore_tree'] = array_slice(@$Tsiuser_tree, 2, 4);
								else $user_two_data['sicore_tree'] = '';

								if (!empty(@$Tseuser_tree)) $user_two_data['secore_tree'] = array_slice(@$Tseuser_tree, 2, 4);
								else $user_two_data['secore_tree'] = '';

								if (!empty(@$Teuser_tree)) $user_two_data['ecore_tree'] = array_slice(@$Teuser_tree, 2, 4);
								else $user_two_data['ecore_tree'] = '';

							?>

                            <?php 
								if(!empty(@$Tmain_user) && isset($user_two_data['main_user']) && $user_two_data['main_user'][0] && $user_two_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_two_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_two_data);

								if(!empty(@$Tmain_user) && isset($user_two_data['main_user']) && $user_two_data['main_user'][0] && $user_two_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_three_data['main_user'] = !empty(@$Thmain_user) ? $Thmain_user : '';
								$user_three_data['user_tree'] = !empty(@$Thuser_tree) ? $Thuser_tree : '';

								if (!empty(@$ThOuser_tree)) $user_three_data['core_tree'] = array_slice(@$ThOuser_tree, 2, 4);
								else $user_three_data['core_tree'] = '';

								if (!empty(@$ThTuser_tree)) $user_three_data['tcore_tree'] = array_slice(@$ThTuser_tree, 2, 4);
								else $user_three_data['tcore_tree'] = '';

								if (!empty(@$ThThuser_tree)) $user_three_data['thcore_tree'] = array_slice(@$ThThuser_tree, 2, 4);
								else $user_three_data['thcore_tree'] = '';

								if (!empty(@$ThFuser_tree)) $user_three_data['fcore_tree'] = array_slice(@$ThFuser_tree, 2, 4);
								else $user_three_data['fcore_tree'] = '';

								if (!empty(@$ThFiuser_tree)) $user_three_data['ficore_tree'] = array_slice(@$ThFiuser_tree, 2, 4);
								else $user_three_data['ficore_tree'] = '';

								if (!empty(@$Thsiuser_tree)) $user_three_data['sicore_tree'] = array_slice(@$Thsiuser_tree, 2, 4);
								else $user_three_data['sicore_tree'] = '';

								if (!empty(@$Thseuser_tree)) $user_three_data['secore_tree'] = array_slice(@$Thseuser_tree, 2, 4);
								else $user_three_data['secore_tree'] = '';

								if (!empty(@$Theuser_tree)) $user_three_data['ecore_tree'] = array_slice(@$Theuser_tree, 2, 4);
								else $user_three_data['ecore_tree'] = '';

							?>

                            <?php 
								if(!empty(@$Thmain_user) && isset($user_three_data['main_user']) && $user_three_data['main_user'][0] && $user_three_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_three_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_three_data);

								if(!empty(@$Thmain_user) && isset($user_three_data['main_user']) && $user_three_data['main_user'][0] && $user_three_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_four_data['main_user'] = !empty(@$Fmain_user) ? $Fmain_user : '';
								$user_four_data['user_tree'] = !empty(@$Fuser_tree) ? $Fuser_tree : '';

								if (!empty(@$FOuser_tree)) $user_four_data['core_tree'] = array_slice(@$FOuser_tree, 2, 4);
								else $user_four_data['core_tree'] = '';

								if (!empty(@$FTuser_tree)) $user_four_data['tcore_tree'] = array_slice(@$FTuser_tree, 2, 4);
								else $user_four_data['tcore_tree'] = '';

								if (!empty(@$FThuser_tree)) $user_four_data['thcore_tree'] = array_slice(@$FThuser_tree, 2, 4);
								else $user_four_data['thcore_tree'] = '';

								if (!empty(@$FFuser_tree)) $user_four_data['fcore_tree'] = array_slice(@$FFuser_tree, 2, 4);
								else $user_four_data['fcore_tree'] = '';

								if (!empty(@$FFiuser_tree)) $user_four_data['ficore_tree'] = array_slice(@$FFiuser_tree, 2, 4);
								else $user_four_data['ficore_tree'] = '';

								if (!empty(@$Fsiuser_tree)) $user_four_data['sicore_tree'] = array_slice(@$Fsiuser_tree, 2, 4);
								else $user_four_data['sicore_tree'] = '';

								if (!empty(@$Fseuser_tree)) $user_four_data['secore_tree'] = array_slice(@$Fseuser_tree, 2, 4);
								else $user_four_data['secore_tree'] = '';

								if (!empty(@$Feuser_tree)) $user_four_data['ecore_tree'] = array_slice(@$Feuser_tree, 2, 4);
								else $user_four_data['ecore_tree'] = '';

							?>

                            <?php 
								if(!empty(@$Fmain_user) && isset($user_four_data['main_user']) && $user_four_data['main_user'][0] && $user_four_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_four_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_four_data);

								if(!empty(@$Fmain_user) && isset($user_four_data['main_user']) && $user_four_data['main_user'][0] && $user_four_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_five_data['main_user'] = !empty(@$Fimain_user) ? $Fimain_user : '';
								$user_five_data['user_tree'] = !empty(@$Fiuser_tree) ? $Fiuser_tree : '';

								if (!empty(@$FiOuser_tree)) $user_five_data['core_tree'] = array_slice(@$FiOuser_tree, 2, 4);
								else $user_five_data['core_tree'] = '';

								if (!empty(@$FiTuser_tree)) $user_five_data['tcore_tree'] = array_slice(@$FiTuser_tree, 2, 4);
								else $user_five_data['tcore_tree'] = '';

								if (!empty(@$FiThuser_tree)) $user_five_data['thcore_tree'] = array_slice(@$FiThuser_tree, 2, 4);
								else $user_five_data['thcore_tree'] = '';

								if (!empty(@$FiFuuser_tree)) $user_five_data['fcore_tree'] = array_slice(@$FiFuuser_tree, 2, 4);
								else $user_five_data['fcore_tree'] = '';

								if (!empty(@$FiFuser_tree)) $user_five_data['ficore_tree'] = array_slice(@$FiFuser_tree, 2, 4);
								else $user_five_data['ficore_tree'] = '';

								if (!empty(@$Fisiuser_tree)) $user_five_data['sicore_tree'] = array_slice(@$Fisiuser_tree, 2, 4);
								else $user_five_data['sicore_tree'] = '';

								if (!empty(@$Fiseuser_tree)) $user_five_data['secore_tree'] = array_slice(@$Fiseuser_tree, 2, 4);
								else $user_five_data['secore_tree'] = '';

								if (!empty(@$Fieuser_tree)) $user_five_data['ecore_tree'] = array_slice(@$Fieuser_tree, 2, 4);
								else $user_five_data['ecore_tree'] = '';

							?>

                            <?php 
								if(!empty(@$Fimain_user) && isset($user_five_data['main_user']) && $user_five_data['main_user'][0] && $user_five_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_five_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_five_data);

								if(!empty(@$Fimain_user) && isset($user_five_data['main_user']) && $user_five_data['main_user'][0] && $user_five_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_six_data['main_user'] = !empty(@$simain_user) ? $simain_user : '';
								$user_six_data['user_tree'] = !empty(@$siuser_tree) ? $siuser_tree : '';

								if (!empty(@$SiOuser_tree)) $user_six_data['core_tree'] = array_slice(@$SiOuser_tree, 2, 4);
								else $user_six_data['core_tree'] = '';

								if (!empty(@$SiTuser_tree)) $user_six_data['tcore_tree'] = array_slice(@$SiTuser_tree, 2, 4);
								else $user_six_data['tcore_tree'] = '';

								if (!empty(@$SiThuser_tree)) $user_six_data['thcore_tree'] = array_slice(@$SiThuser_tree, 2, 4);
								else $user_six_data['thcore_tree'] = '';

								if (!empty(@$SiFuuser_tree)) $user_six_data['fcore_tree'] = array_slice(@$SiFuuser_tree, 2, 4);
								else $user_six_data['fcore_tree'] = '';

								if (!empty(@$SiFuser_tree)) $user_six_data['ficore_tree'] = array_slice(@$SiFuser_tree, 2, 4);
								else $user_six_data['ficore_tree'] = '';

								if (!empty(@$Sisiuser_tree)) $user_six_data['sicore_tree'] = array_slice(@$Sisiuser_tree, 2, 4);
								else $user_six_data['sicore_tree'] = '';

								if (!empty(@$Siseuser_tree)) $user_six_data['secore_tree'] = array_slice(@$Siseuser_tree, 2, 4);
								else $user_six_data['secore_tree'] = '';

								if (!empty(@$Sieuser_tree)) $user_six_data['ecore_tree'] = array_slice(@$Sieuser_tree, 2, 4);
								else $user_six_data['ecore_tree'] = '';

							?>

                            <?php 
								if(!empty(@$simain_user) && isset($user_six_data['main_user']) && $user_six_data['main_user'][0] && $user_six_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_six_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_six_data);

								if(!empty(@$simain_user) && isset($user_six_data['main_user']) && $user_six_data['main_user'][0] && $user_six_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_seven_data['main_user'] = !empty(@$semain_user) ? $semain_user : '';
								$user_seven_data['user_tree'] = !empty(@$seuser_tree) ? $seuser_tree : '';

								if (!empty(@$SeOuser_tree)) $user_seven_data['core_tree'] = array_slice(@$SeOuser_tree, 2, 4);
								else $user_seven_data['core_tree'] = '';

								if (!empty(@$SeTuser_tree)) $user_seven_data['tcore_tree'] = array_slice(@$SeTuser_tree, 2, 4);
								else $user_seven_data['tcore_tree'] = '';

								if (!empty(@$SeThuser_tree)) $user_seven_data['thcore_tree'] = array_slice(@$SeThuser_tree, 2, 4);
								else $user_seven_data['thcore_tree'] = '';

								if (!empty(@$FeFuuser_tree)) $user_seven_data['fcore_tree'] = array_slice(@$FeFuuser_tree, 2, 4);
								else $user_seven_data['fcore_tree'] = '';

								if (!empty(@$SeFuser_tree)) $user_seven_data['ficore_tree'] = array_slice(@$SeFuser_tree, 2, 4);
								else $user_seven_data['ficore_tree'] = '';

								if (!empty(@$Sesiuser_tree)) $user_seven_data['sicore_tree'] = array_slice(@$Sesiuser_tree, 2, 4);
								else $user_seven_data['sicore_tree'] = '';

								if (!empty(@$Seseuser_tree)) $user_seven_data['secore_tree'] = array_slice(@$Seseuser_tree, 2, 4);
								else $user_seven_data['secore_tree'] = '';

								if (!empty(@$Seeuser_tree)) $user_seven_data['ecore_tree'] = array_slice(@$Seeuser_tree, 2, 4);
								else $user_seven_data['ecore_tree'] = '';
							?>

                            <?php 
								if(!empty(@$semain_user) && isset($user_seven_data['main_user']) && $user_seven_data['main_user'][0] && $user_seven_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_seven_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_seven_data);

								if(!empty(@$semain_user) && isset($user_seven_data['main_user']) && $user_seven_data['main_user'][0] && $user_seven_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="planDiagrams">
                        <div class="planDiagram child">
                            <?php
								$user_eight_data['main_user'] = !empty(@$emain_user) ? $emain_user : '';
								$user_eight_data['user_tree'] = !empty(@$euser_tree) ? $euser_tree : '';

								if (!empty(@$EiOuser_tree)) $user_eight_data['core_tree'] = array_slice(@$EiOuser_tree, 2, 4);
								else $user_eight_data['core_tree'] = '';

								if (!empty(@$EiTuser_tree)) $user_eight_data['tcore_tree'] = array_slice(@$EiTuser_tree, 2, 4);
								else $user_eight_data['tcore_tree'] = '';

								if (!empty(@$EiThuser_tree)) $user_eight_data['thcore_tree'] = array_slice(@$EiThuser_tree, 2, 4);
								else $user_eight_data['thcore_tree'] = '';

								if (!empty(@$EiFuuser_tree)) $user_eight_data['fcore_tree'] = array_slice(@$EiFuuser_tree, 2, 4);
								else $user_eight_data['fcore_tree'] = '';

								if (!empty(@$EiFuser_tree)) $user_eight_data['ficore_tree'] = array_slice(@$EiFuser_tree, 2, 4);
								else $user_eight_data['ficore_tree'] = '';

								if (!empty(@$Eisiuser_tree)) $user_eight_data['sicore_tree'] = array_slice(@$Eisiuser_tree, 2, 4);
								else $user_eight_data['sicore_tree'] = '';

								if (!empty(@$Eiseuser_tree)) $user_eight_data['secore_tree'] = array_slice(@$Eiseuser_tree, 2, 4);
								else $user_eight_data['secore_tree'] = '';

								if (!empty(@$Eieuser_tree)) $user_eight_data['ecore_tree'] = array_slice(@$Eieuser_tree, 2, 4);
								else $user_eight_data['ecore_tree'] = '';
							?>

                            <?php 
								if(!empty(@$emain_user) && isset($user_eight_data['main_user']) && $user_eight_data['main_user'][0] && $user_eight_data['main_user'][0]['children']){
									echo '<a href="' . $child_url . insep_encode($user_eight_data['main_user'][0]['children']) . '">';
								}
								
								$this->load->view(strtolower(CI_MODEL) . '/tree', $user_eight_data);

								if(!empty(@$emain_user) && isset($user_eight_data['main_user']) && $user_eight_data['main_user'][0] && $user_eight_data['main_user'][0]['children']){
									echo '</a>';
								}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>