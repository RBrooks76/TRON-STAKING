<!DOCTYPE html>
<html lang="en">

<head>
    <?php $siteDetails = getSite();?>
    <title><?php echo $siteDetails->site_name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="<?php echo base_url() . 'ajqgzgmedscuoc/img/site/' . $siteDetails->fav_icon ?>" rel="icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/aos.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/toastr.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/custom.css?ver=<?php echo date('U') ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/DataTables/datatables.min.css">

    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/additional-methods.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/slick.min.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/aos.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/toastr.js"></script>
    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/custom.js?ver=<?php echo date('U') ?>"></script>

    <script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.growl.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/jquery.growl.css">

</head>

<body class="homepage">

    <!-- Header Start -->
    <header class="stickyHead">
        <div class="header">
            <div class="container containerTwo">
                <div class="row align-items-center">
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url() . 'ajqgzgmedscuoc/img/site/' . $siteDetails->site_logo ?>"
                                    alt="logo" />
                            </a>
                        </div>
                    </div>


                    <?php

$lang_code = FS::uri()->segment(1);

?>
                    <div
                        class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right d-flex justify-content-end align-items-center">

                        <div class="soc_icons">
                            <ul>
                                <li><a href="<?php echo site_url('faq'); ?>" target="_blank">FAQ</a></li>
                                <li><a href="<?php echo $siteDetails->facebooklink; ?>" target="_blank"><i
                                            class="fab fa-facebook"></i></a></li>
                                <li><a href="<?php echo $siteDetails->telegram_link; ?>" target="_blank"><i
                                            class="fab fa-telegram"></i></a></li>
                                <li><a href="<?php echo $siteDetails->twitterlink; ?>" target="_blank"><i
                                            class="fab fa-twitter-square"></i></a></li>
                                <li><a href="<?php echo $siteDetails->youtubelink; ?>" target="_blank"><i
                                            class="fab fa-youtube-square"></i></a></li>
                            </ul>
                        </div>

                        <div class="headerLanguage dropdown">
                            <button type="button" class="btn dropdown-toggle flagText" data-toggle="dropdown"
                                id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                                <img class="flagImage"
                                    src="<?php echo base_url() . 'ajqgzgmedscuoc/front/images/flags/' . getCurrentLang($lang_code)->lang_image ?>"
                                    alt="flag" /> <?php echo getCurrentLang($lang_code)->lang_name; ?>

                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php if ($lang) {
	foreach ($lang as $result) {

		if ($this->router->fetch_method() == 'referuser') {
			$chnge_url = base_url() . $result->lang_code . '/refer/' . FS::uri()->segment(3) . '/' . FS::uri()->segment(4);
		} else {
			$chnge_url = base_url() . $result->lang_code . '/' . FS::router()->fetch_class();
		}

		?>
                                <a class="dropdown-item" href="<?php echo $chnge_url; ?>">
                                    <img src="<?php echo base_url() . 'ajqgzgmedscuoc/front/images/flags/' . $result->lang_image ?>"
                                        alt="flag" />
                                    <span><?php echo $result->lang_short_name; ?></span>
                                </a>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="headerBottom">
            <div class="container containerTwo">
                <div class="d-flex align-items-center justify-content-between bannerTopContent">
                    <div class="actPants">
                        <?php echo lang('Active participants'); ?> : <?php echo $users_count; ?>
                    </div>
                    <div id="show_profile">
                        <?php

if (juego_id() || !empty(@$plansection)) {
	?>
                        <div class="profileTrig">
                            <button class="btn noBoxShadow">
                                <div class="profileContent">
                                    <span class="profTrigText">
                                        <?php echo lang('My Profile'); ?>
                                    </span>
                                    <span class="profTrigImage">
                                        <img src="<?php echo base_url() ?>ajqgzgmedscuoc/front/images/home/profileIcon.png"
                                            alt="profileIcon" />
                                    </span>
                                </div>
                            </button>
                        </div>
                        <?php
}
?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
    <?php

$lang_url = FS::uri()->segment(1);

?>

    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">

    <input type="hidden" id="base_url" value="<?php echo base_url() . $lang_url; ?>">

    <input type="hidden" id="curr_lang" value="<?php echo $lang_url; ?>">

    <div id="cover-spin" style="display: none">

        <div class="test">

            <center>
                <p class="show_text"> <?php echo lang('TIP'); ?> <br> <?php echo lang('PDRP'); ?> <br>
                    <?php echo lang('PCYTE'); ?> </p>
            </center>

        </div>

    </div>