  <!-- BEGIN : Body-->

  <body data-col="2-columns" class=" 2-columns ">
      <!-- ////////////////////////////////////////////////////////////////////////////-->
      <div class='total_containner'>
          <div class="wrapper">

              <!-- main menu-->
              <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
              <div data-active-color="black" data-background-color="black" data-image="" class="app-sidebar">
                  <!-- main menu header-->
                  <!-- Sidebar Header starts-->
                  <div class="sidebar-header">
                      <div class="logo clearfix"><a href="<?php echo base_url('admindashboard') ?>"
                              class="logo-text float-left">
                              <!-- <div class="logo-img"></div> --><span class="text align-middle">Trongoogol</span>
                          </a>
                          <!-- <a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-left"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a> -->
                      </div>
                  </div>
                  <!-- Sidebar Header Ends-->
                  <!-- / main menu header-->
                  <!-- main menu content-->
                  <div class="sidebar-content">
                      <div class="nav-container">
                          <ul id="main-menu-navigation" data-menu="menu-navigation" data-scroll-to-active="true"
                              class="navigation navigation-main">
                              <?php
                            $isValid = FS::Common()->getTableData(ASSIGN, array('priviledge_id' => admin_id()))->row()->access;
                            $var = json_decode($isValid);
                            $items = array();
                            foreach ($var as $key => $value) {$items[] = $key;}
                          ?>

                              <?php if (in_array(5, $items)) {?>
                              <li class="nav-item <?php echo FS::router()->fetch_class() == 'FAQ' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'faq'; ?>"><i class="icon-question"></i><span
                                          data-i18n="" class="menu-title">FAQ Management</span></a>
                              </li>
                              <?php }if (in_array(7, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Emailtemplate' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'emailtemplate'; ?>"><i
                                          class="icon-envelope-open"></i><span data-i18n="" class="menu-title">Email
                                          Template</span></a>
                              </li>

                              <?php }if (in_array(8, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'basic' && FS::router()->fetch_method() == 'homecontent' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'homecontent'; ?>">
                                      <i class="icon-size-fullscreen"></i>
                                      <span data-i18n="" class="menu-title">Home Page Content</span></a>
                              </li>
                              <?php }if (in_array(9, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'howitworks' || FS::router()->fetch_method() == 'edithowitwork' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'howitwork'; ?>"><i
                                          class="fa fa-search-plus"></i><span data-i18n="" class="menu-title">How it
                                          works?</span></a>
                              </li>
                              <?php }if (in_array(21, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'whychoose' || FS::router()->fetch_method() == 'editWhychoose' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'whychoose'; ?>"><i class="icon-question"></i><span
                                          data-i18n="" class="menu-title">Why Choose?</span></a>
                              </li>
                              <?php }if (in_array(22, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Review' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'review'; ?>"><i class="ft-message-square"></i><span
                                          data-i18n="" class="menu-title">Review</span></a>
                              </li>
                              <?php }if (in_array(15, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'addressmanage' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'address'; ?>"><i class="fa-envelope-o"></i><span
                                          data-i18n="" class="menu-title">Address Management</span></a>
                              </li>

                              <?php }if (in_array(16, $items)) {?>

                              <li
                                  class="has-sub nav-item <?php echo FS::router()->fetch_class() == 'Manageuser' ? 'active' : ''; ?>">

                                  <a href="javascript:;"><i class="fa fa-user"></i><span data-i18n=""
                                          class="menu-title">User Management</span></a>
                                  <ul class="menu-content">
                                      <li>
                                          <a href="<?php echo base_url() . 'user/plana/1'; ?>" class="menu-item">PLAN A
                                              Users</a>
                                      </li>
                                      <li>
                                          <a href="<?php echo base_url() . 'user/planb'; ?>" class="menu-item">PLAN B
                                              Users</a>
                                      </li>
                                  </ul>
                              </li>

                              <?php }if (in_array(24, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Subadmin' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'subadmin'; ?>"><i class="ft-users"></i><span
                                          data-i18n="" class="menu-title">Subadmin Management</span></a>
                              </li>

                              <?php }if (in_array(14, $items)) {?>
                              <!-- <li class="nav-item"><a href="<?php //echo base_url().'document';?>"><i class="icon-doc"></i><span data-i18n="" class="menu-title">Document Section</span></a>
              </li> -->
                              <?php }if (in_array(19, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'Userip' || FS::router()->fetch_method() == 'editUserip' || FS::router()->fetch_method() == 'addUserip' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'userip'; ?>"><i class="fa fa-qrcode"></i><span
                                          data-i18n="" class="menu-title">IP Block Management</span></a>
                              </li>
                              <?php }if (in_array(20, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'Adminip' || FS::router()->fetch_method() == 'editAdminip' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'adminip'; ?>"><i class="fa fa-qrcode"></i><span
                                          data-i18n="" class="menu-title">Admin IP</span></a>
                              </li>
                              <?php }if (in_array(23, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'planmanage' || @$mode == 'A' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'plan'; ?>"><i class="icon-paper-plane"></i><span
                                          data-i18n="" class="menu-title">Plan A Management</span></a>
                              </li>
                              <?php }if (in_array(23, $items)) {?>
                              <li
                                  class="nav-item <?php echo FS::router()->fetch_method() == 'planbmanage' || @$mode == 'B' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'planb'; ?>"><i class="icon-paper-plane"></i><span
                                          data-i18n="" class="menu-title">Plan B Management</span></a>
                              </li>
                              <?php }if (in_array(6, $items)) {?>

                              <li class="nav-item <?php echo FS::router()->fetch_class() == 'CMS' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'cms'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">CMS Management</span></a>
                              </li>

                              <?php }if (in_array(25, $items)) {?>

                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Referral' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'referral'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">Referral Link </span></a>
                              </li>

                              <?php }if (in_array(26, $items)) {?>

                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Linkrequest' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'linkrequest'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">Link Request</span></a>
                              </li>

                              <?php }?>

                              <?php if (in_array(14, $items)) {?>

                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'Document' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'document'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">Brochure Management</span></a>
                              </li>

                              <?php }?>

                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'NewsLetter' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'newsletter'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">News Letter</span></a>
                              </li>

                              <li
                                  class="nav-item <?php echo FS::router()->fetch_class() == 'SMTPserver' ? 'active' : ''; ?>">
                                  <a href="<?php echo base_url() . 'smtpmanage'; ?>"><i class="icon-grid"></i><span
                                          data-i18n="" class="menu-title">SMTP server Manage</span></a>
                              </li>

                              <!-- <li class="has-sub nav-item"><a href="javascript:;"><i class="icon-target"></i><span
                                      data-i18n="" class="menu-title">Promo Management</span></a>
                              <ul class="menu-content">
                                  <li><a href="<?php //echo base_url().'presentation';?>"
                                          class="menu-item">Presentation</a>
                                  </li>
                                  <li><a href="<?php //echo base_url().'text';?>" class="menu-item">Text</a>
                                  </li>
                                  <li><a href="<?php //echo base_url().'banner';?>" class="menu-item">Banner</a>
                                  </li>
                                  <li><a href="<?php //echo base_url().'video';?>" class="menu-item">Video</a>
                                  </li>
                              </ul>
                          </li> -->

                          </ul>
                      </div>
                  </div>
                  <!-- main menu content-->
                  <div class="sidebar-background"></div>
                  <!-- main menu footer-->
                  <!-- include includes/menu-footer-->
                  <!-- main menu footer-->
              </div>
              <!-- / main menu-->