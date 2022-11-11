<div id="singleWindow" class="single_window">

    <!-- Banner Start -->
    <?php 
		$img 	=	$cms->cms_image;
			if(!empty($img))
			{
	?>
    <div class="col-md-4 pl-0 mt-3 mb-3 text-center mx-auto">
        <img src="<?php echo base_url().'ajqgzgmedscuoc/img/cms/'.$cms->cms_image;?>">
    </div>
    <?php
			}
		$buffer = 	$cms->content_description;
		echo html_entity_decode($buffer); 
	?>
    <!-- Banner End -->

</div>