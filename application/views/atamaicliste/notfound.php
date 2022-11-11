<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo getSite()->site_name;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
    <!-- Favicons -->
    <link href="<?php echo base_url().'ajqgzgmedscuoc/img/site/' .getSite()->fav_icon?>" rel="icon">
  
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
      
         
    <link rel="stylesheet" href="<?php echo base_url()?>ajqgzgmedscuoc/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>ajqgzgmedscuoc/front/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>ajqgzgmedscuoc/front/css/slick.css">      
    <link rel="stylesheet" href="<?php echo base_url()?>ajqgzgmedscuoc/front/css/aos.css">      
    <link rel="stylesheet" href="<?php echo base_url()?>ajqgzgmedscuoc/front/css/custom.css?ver=<?php echo date('U')?>">  
      

       <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/jquery.min.js"></script>    
  
     <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/jquery-ui.js"></script>
    <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/popper.min.js"></script>
    <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/slick.min.js"></script>
    <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/aos.js"></script>   
    <script src="<?php echo base_url()?>ajqgzgmedscuoc/front/js/custom.js?ver=<?php echo date('U')?>"></script>
      
  </head> 
  <body>
    <div class="not_found_page text-center pb-5 pt-5">
    <div class="container">
      <div class="no_page_ryt mb-3">
        <img src="<?php echo base_url().'ajqgzgmedscuoc/img/site/' .getSite()->site_logo?>">
      </div>
      <h1>404</h1>
      <h2><?php echo lang('Page Not Found'); ?></h2>
      <p><?php echo lang("NOTTEXT"); ?></p>
      <a href="<?php echo base_url() ?>"><?php echo lang("Back to home"); ?></a>
    </div>
  </div>  
  </body>
</html>