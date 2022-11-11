

    <div id="singleWindow" class="faq-block single_window">

        <!-- Banner Start -->
       <!--  <div class="fullscreen banner">
            <div class="container containerTwo">
                <div class="bannerContent">
                    <div class="row flex-column align-items-center justify-content-between">
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Banner End -->
        <!-- Home Plan Animation Start -->
       <!--  <div class="fullscreen homePlansAnimation" id="single3">
            <div class="container">
                <div class="planAniBack inactive">
                    <div class="container containerTwo w-100">
                        <button class="btn noBoxShadow noPadding hplanAniImgTrig">
                                Back
                            </button>
                    </div>
                </div>

            </div> -->
            <!-- Scroll Section button Start -->

       <!--  </div> -->
        <!-- Home Plan Animation End -->

        <!-- Home Plan QA Start -->
        <div class="fullscreen homePlansQA" id="single4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <h2 class="sectionTitle"><?php echo lang('FAQ'); ?></h2>
                       <!--  <p class="sectionPara">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
                        <div class="hplanQAblocks">
                            <div class="row justify-content-center">
                                <div class="col-md-10">


                                    <div id="main">
                                        <div class="container">
                                            <div class="accordion" id="faq">
                                                 <?php


    if (!empty($faq)) { $i = 0;
        foreach ($faq as $Fkey => $Fvalue) {  ?>

                                                <div class="card">
                                                    <div class="card-header" id="faqhead1">
                                                        <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq_<?php echo $i; ?>" aria-expanded="true" aria-controls="faq_<?php echo $i; ?>"><?php echo $Fvalue->question; ?></a>
                                                    </div>

                                                    <div id="faq_<?php echo $i; ?>" class="collapse <?php if($i == 0) { echo 'show'; } ?>" aria-labelledby="faqhead_<?php echo $i; ?>" data-parent="#faq">
                                                        <div class="card-body">
                                                         

                                                            <div class="row">

                                                            <?php if(isset($Fvalue->faq_img))
                                                            { ?> 

                                                            <div class="col-sm-6">
                                                                <img width="480" height="315" src="<?php echo base_url().'ajqgzgmedscuoc/img/admin/FAQ/'.$Fvalue->faq_img;?>"/>
                                                            </div>

                                                            <?php } ?>
                                                           
                                                            <?php if(isset($Fvalue->youtubeLink))
                                                            { ?> 
                                                            <div class="col-sm-6">

                                                                <?php echo $Fvalue->youtubeLink; ?>

                                                               
                                                            </div>
                                                             <?php } ?>
                                                           </div>
                                                              <?php echo $Fvalue->answer; ?>
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                               <?php $i++;
}
    }
    ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll Section button Start -->

        </div>
        <!-- Home Plan QA End -->

        <!-- Home Plan Slider Start -->



        <!-- Home Why Choose Start -->

    </div>


    <!-- homeSignShop content start -->


   

   

  