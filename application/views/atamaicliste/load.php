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


            <?php $getProfileID = getProfileID();

if (juego_id() != ADMIN_ADDR) {

	?>

            <h2>- <?php echo lang('PLAN A'); ?> <span class="full-right">
                    <?php echo !empty($getProfileID) ? lang('PID') . ' : ' . $getProfileID : ''; ?></span> </h2>

            <?php } else {
	?>

            <div class="d-flex justify-content-between sin_cls">- <h2><?php echo lang('PLAN A'); ?> </h2><span>
                    <?php echo !empty($getProfileID) ? lang('PID') . ' : ' . $getProfileID : ''; ?></span>
                <div class="d-flex">
                    <span class="col-md-6 p-0">Tree ID :</span>
                    <select class="form-control col-md-6 sin_select">
                        <?php if (!empty($tree_data)) {
		foreach ($tree_data as $tr_key => $tr_value) {
			?>

                        <option value="<?php echo insep_encode($tr_value['tree_id']) ?>"
                            <?php echo @$tree_id == $tr_value['tree_id'] ? 'selected' : ''; ?>>
                            <?php echo $tr_value['tree_id'] ?> </option>
                        <?php

		}}?>

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
                    <span>
                        <?php echo lang('BOARD') . ' ' . $Avalue->amount; ?>
                        <span>
                            <a class="view_btn view_<?php echo $Avalue->amount; ?>" href="<?php echo $plan_link; ?>">
                                <?php echo lang('View') ?>
                            </a>
                        </span>
                    </span>
                </li>
                <li>
                    <span class="w100">
                        <?php echo lang('RECIEVED'); ?> : <span id="total_<?php echo $Avalue->id; ?>"></span> TRX
                    </span>
                    <span class="w100">
                        <?php echo lang('GIVEN'); ?> : <span id="give_<?php echo $Avalue->id; ?>"></span> TRX
                    </span>
                    <span class="w100">
                        <?php echo lang('KEEP'); ?> : <span id="Earns_<?php echo $Avalue->id; ?>"></span> TRX
                    </span>
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
                    <span class="fontBold"> <?php echo lang('YRL'); ?></span> <span> <?php echo lang('PUYRL'); ?></span>
                </li>

                <?php
                    if (empty($ref_url_a) && empty($core_status)) {
                ?>

                <li class="">
                    <span class="fontBold"> <?php echo lang('SBRL'); ?> : </span> <span>
                        <?php echo lang('UYURL'); ?></span>
                </li>
                <?php }?>

            </ul>
        </div>
        <?php
            if (juego_id() != ADMIN_ADDR) {
                if (!empty($ref_url_a) && !empty($core_status)) {
		?>
        <div class="MenuWalletAddress">
            <a class="btn noBoxShadow">
                <span class="copyAdText referral_link" data-url="<?php echo $ref_url_a; ?>"> <i class="fa fa-copy"></i>
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