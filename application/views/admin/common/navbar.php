<nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span
                    class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                    class="icon-bar"></span><span class="icon-bar"></span></button><span
                class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent"
                    href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>

        </div>
        <div class="navbar-container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item mr-2 d-none d-lg-block"><a id="navbar-fullscreen" href="javascript:;"
                            class="nav-link apptogglefullscreen"><i
                                class="ft-maximize font-medium-3 blue-grey darken-4"></i>
                            <p class="d-none">fullscreen</p>
                        </a></li>


                    <li class="dropdown nav-item"><a id="dropdownBasic3" href="#" data-toggle="dropdown"
                            class="nav-link position-relative dropdown-toggle"><i
                                class="ft-user font-medium-3 blue-grey darken-4"></i>
                            <p class="d-none">User Settings</p>
                        </a>

                        <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3"
                            class="dropdown-menu text-left dropdown-menu-right">
                            <?php 
          
           $isValid = FS::Common()->getTableData(ASSIGN, array('priviledge_id' => admin_id()))->row()->access;

           $var  = json_decode($isValid);
           $items = array();
           foreach ($var as $key => $value) {
        
             $items[] = $key;
           }
          //  echo "<pre>";
          // print_r( $items); die;
           ?>

                            <?php  if(in_array(4, $items))
                { ?>
                            <a href="<?php echo base_url().'profile';?>" class="dropdown-item py-1"><i
                                    class="ft-edit mr-2"></i><span>Edit Profile</span></a>
                            <?php } if(in_array(2, $items)){ ?>
                            <a href="<?php echo base_url().'sitesettings';?>" class="dropdown-item py-1"><i
                                    class="fa fa-cog mr-2"></i><span>Site Settings</span></a>
                            <?php } if(in_array(3, $items)){ ?>
                            <a href="<?php echo base_url().'changepass';?>" class="dropdown-item py-1"><i
                                    class="fa fa-unlock-alt mr-2"></i><span>Change Password</span></a>
                            <?php } if(in_array(17, $items)){ ?>
                            <a href="<?php echo base_url().'changepattern';?>" class="dropdown-item py-1"><i
                                    class="fa fa-dot-circle-o mr-2"></i><span>Change Pattern</span></a>
                            <?php } if(in_array(13, $items)){ ?>
                            <a href="<?php echo base_url().'tfa';?>" class="dropdown-item py-1"><i
                                    class="fa fa-lock mr-2"></i><span>TFA</span></a>
                            <?php }  ?>
                            <div class="dropdown-divider"></div><a href="<?php echo base_url()?>logout"
                                class="dropdown-item"><i class="ft-power mr-2"></i><span>Logout</span></a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>