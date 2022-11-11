<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Form actions layout section start -->
            <section id="form-action-layouts">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="content-header">Home Page Content</div>
                    </div>
                    <div class="col-sm-6">
                        <?php
                          if (!empty(FS::session()->flashdata('success'))) {
                        ?>
                        <div class="alert alert-success"> <?php echo FS::session()->flashdata('success') ?> </div>
                        <?php
                          } else if (!empty(FS::session()->flashdata('error'))) {
                        ?>
                        <div class="alert alert-danger"> <?php echo FS::session()->flashdata('error') ?> </div>
                        <?php
                          }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="px-3">

                                    <form class="form" id="homecontent" method="post" enctype="multipart/form-data">
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-6 mb-2">
                                                <fieldset class="form-group">
                                                    <label for="language">Language</label>
                                                    <select class="form-control" id="language_home" name="language">
                                                        <?php foreach ($lang as $key => $value) {?>
                                                        <option value="<?php echo $value->id; ?>"
                                                            <?php if ($home->language == $value->id) {echo 'selected';}?>>
                                                            <?php echo $value->lang_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i> Section 1 </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-6">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="smart_head_one"
                                                            id="smart_head_one" rows="3"
                                                            placeholder="Answer"><?php echo $home->smart_contact_1; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-6">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="smart_head_two"
                                                            id="smart_head_two" rows="3"
                                                            placeholder="Answer"><?php echo str_replace("\'", "'", $home->smart_contact_2); ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i> Section 2 </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="how_work_one"
                                                            id="how_work_one" rows="3"
                                                            placeholder="Answer"><?php echo $home->how_every_1; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="how_work_two"
                                                            id="how_work_two" rows="3"
                                                            placeholder="Answer"><?php echo $home->how_every_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 3 </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="market_plan_one"
                                                            id="market_plan_one" rows="3"
                                                            placeholder="Answer"><?php echo $home->market_plan_1; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="market_plan_two"
                                                            id="market_plan_two" rows="3"
                                                            placeholder="Answer"><?php echo $home->market_plan_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 4 </h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Join Link</label>
                                                        <textarea class="form-control" name="joinLink" id="joinLink"
                                                            placeholder="Join Link"
                                                            rows="1"> <?php echo $home->joinLink; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 5</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="reg_page_one"
                                                            id="reg_page_one" rows="3"
                                                            placeholder="Answer"><?php echo $home->reg_page_1; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="reg_page_two"
                                                            id="reg_page_two" rows="3"
                                                            placeholder="Answer"><?php echo $home->reg_page_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 6</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="adv_tech_1">Heading 1</label>
                                                        <textarea class="form-control" name="adv_tech_1" id="adv_tech_1"
                                                            rows="3"
                                                            placeholder="Heading 1"><?php echo $home->adv_tech_1; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="adv_tech_2">Heading 2</label>
                                                        <textarea class="form-control" name="adv_tech_2" id="adv_tech_2"
                                                            rows="3"
                                                            placeholder="Heading 2"><?php echo $home->adv_tech_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="adv_tech_2">Section 5 Logo</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='section-5-btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='section-5-logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->adv_tech_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section-5-input' name='adv_tech_logo'
                                                                    onchange="fileSelectChangeFunc('Section-5-input', 'section-5-logo', 'section-5-btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 7</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="footer_content_1">Heading 1</label>
                                                        <textarea class="form-control" name="footer_content_1"
                                                            id="footer_content_1" rows="3"
                                                            placeholder="Heading 1"><?php echo $home->footer_content_1; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="footer_content_2">Heading 2</label>
                                                        <textarea class="form-control" name="footer_content_2"
                                                            id="footer_content_2" rows="3"
                                                            placeholder="Heading 2"><?php echo $home->footer_content_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="adv_tech_2">Section 6 Logo</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='section-6-btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='section-6-logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->footer_content_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section-6-input' name='footer_content_logo'
                                                                    onchange="fileSelectChangeFunc('Section-6-input', 'section-6-logo', 'section-6-btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 8</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_1_head">Heading 1</label>
                                                        <textarea class="form-control" name="Section7_1_head"
                                                            id="Section7_1_head" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_1_head; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_1_content">Content 1</label>
                                                        <textarea class="form-control" name="Section7_1_content"
                                                            id="Section7_1_content" rows="3"
                                                            placeholder="Heading 2"><?php echo $home->Section7_1_content; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_1_link">More Link 1 </label>
                                                        <textarea class="form-control" name="Section7_1_link"
                                                            id="Section7_1_link" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_1_link; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="Section7_1_logo">Section 7 Logo 1</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='Section7_1_btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='Section7_1_logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->Section7_1_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section7_1_input' name='Section7_1_logo'
                                                                    onchange="fileSelectChangeFunc('Section7_1_input', 'Section7_1_logo', 'Section7_1_btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6 mb-3">
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_2_head">Heading 2</label>
                                                        <textarea class="form-control" name="Section7_2_head"
                                                            id="Section7_2_head" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_2_head; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_2_content">Content 2</label>
                                                        <textarea class="form-control" name="Section7_2_content"
                                                            id="Section7_2_content" rows="3"
                                                            placeholder="Heading 2"><?php echo $home->Section7_2_content; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_2_link">More Link 2 </label>
                                                        <textarea class="form-control" name="Section7_2_link"
                                                            id="Section7_2_link" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_2_link; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="Section7_2_logo">Section 7 Logo 2</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='Section7_2_btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='Section7_2_logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->Section7_2_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section7_2_input' name='Section7_2_logo'
                                                                    onchange="fileSelectChangeFunc('Section7_2_input', 'Section7_2_logo', 'Section7_2_btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6 mb-3">
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_3_head">Heading 3</label>
                                                        <textarea class="form-control" name="Section7_3_head"
                                                            id="Section7_3_head" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_3_head; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_3_content">Content 3</label>
                                                        <textarea class="form-control" name="Section7_3_content"
                                                            id="Section7_3_content" rows="3"
                                                            placeholder="Heading 2"><?php echo $home->Section7_3_content; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_3_link">More Link 3 </label>
                                                        <textarea class="form-control" name="Section7_3_link"
                                                            id="Section7_3_link" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_3_link; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="Section7_3_logo">Section 7 Logo 3</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='Section7_3_btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='Section7_3_logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->Section7_3_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section7_3_input' name='Section7_3_logo'
                                                                    onchange="fileSelectChangeFunc('Section7_3_input', 'Section7_3_logo', 'Section7_3_btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6 mb-3">
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_4_head">Heading 4</label>
                                                        <textarea class="form-control" name="Section7_4_head"
                                                            id="Section7_4_head" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_4_head; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_4_content">Content 4</label>
                                                        <textarea class="form-control" name="Section7_4_content"
                                                            id="Section7_4_content" rows="3"
                                                            placeholder="Heading 2"><?php echo $home->Section7_4_content; ?></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group col-md-12 mb-0">
                                                        <label for="Section7_4_link">More Link 4 </label>
                                                        <textarea class="form-control" name="Section7_4_link"
                                                            id="Section7_4_link" rows="1"
                                                            placeholder="Heading 1"><?php echo $home->Section7_4_link; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <div class='img-upload'>
                                                        <fieldset class="form-group mb-12">
                                                            <label for="Section7_4_logo">Section 7 Logo 4</label>
                                                            <div class='img-upload-containner'>
                                                                <div class='img-upload-btn-sec' id='Section7_4_btn'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/admin/img/upload-img.png' />
                                                                    Select Logo
                                                                </div>
                                                                <div class='img-upload-img-sec' id='Section7_4_logo'>
                                                                    <img class='img-upload-icon'
                                                                        src='<?php echo base_url() ?>ajqgzgmedscuoc/img/upload/<?php echo $home->Section7_4_logo; ?>' />
                                                                </div>
                                                                <input type='file' class='file-selector'
                                                                    id='Section7_4_input' name='Section7_4_logo'
                                                                    onchange="fileSelectChangeFunc('Section7_4_input', 'Section7_4_logo', 'Section7_4_btn')" />
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Section 9</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="footer_link_1">Footer Link 1</label>
                                                        <textarea class="form-control" name="footer_link_1"
                                                            id="footer_link_1" rows="3"
                                                            placeholder="Link 1"><?php echo $home->footer_link_1; ?></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="footer_link_2">Footer Link 2</label>
                                                        <textarea class="form-control" name="footer_link_2"
                                                            id="footer_link_2" rows="3"
                                                            placeholder="Link 2"><?php echo $home->footer_link_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="embeed_code">Changelly Embeed Code</label>
                                                        <textarea class="form-control" name="embeed_code"
                                                            id="embeed_code" rows="3"
                                                            placeholder=""><?php echo $home->embeed_code; ?></textarea>
                                                    </fieldset>
                                                </div>

                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="video_embeed_code">Video Embeed Code</label>
                                                        <textarea class="form-control" name="video_embeed_code"
                                                            id="video_embeed_code" rows="3"
                                                            placeholder=""><?php echo $home->video_embeed_code; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="reff_embeed_code">Referral Video Embeed Code</label>
                                                        <textarea class="form-control" name="reff_embeed_code"
                                                            id="reff_embeed_code" rows="3"
                                                            placeholder=""><?php echo $home->reff_embeed_code; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button type="reset" class="btn btn-raised btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-raised btn-primary">
                                                <i class="fa fa-check-square-o"></i> Save
                                            </button>
                                        </div>
                                    </form>

                                    <!-- <h4 class="card-title" id="from-actions-bottom-right">Spanish</h4>
                                    <form class="form" id="homecontent_sp" method="post" enctype="multipart/form-data">
                                        <input type="hidden" value="sp" name="lang">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-info"></i> SMART CONTRACT</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-6">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="smart_head_one_sp"
                                                            id="smart_head_one_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->smart_contact_1; ?></textarea>
                                                    </fieldset>

                                                </div>
                                                <div class="form-group col-md-6 mb-6">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="smart_head_two_sp"
                                                            id="smart_head_two_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->smart_contact_2; ?></textarea>
                                                    </fieldset>


                                                </div>
                                            </div>


                                            <h4 class="form-section"><i class="ft-info"></i> How Everything Works?</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="how_work_one_sp"
                                                            id="how_work_one_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->how_every_1; ?></textarea>
                                                    </fieldset>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="how_work_two_sp"
                                                            id="how_work_two_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->how_every_2; ?></textarea>
                                                    </fieldset>

                                                </div>
                                            </div>


                                            <h4 class="form-section"><i class="ft-info"></i> Advanced Technology</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="adv_tech_one_sp"
                                                            id="adv_tech_one_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->adv_tech_1; ?></textarea>
                                                    </fieldset>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="adv_tech_two_sp"
                                                            id="adv_tech_two_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->adv_tech_2; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <h4 class="form-section"><i class="ft-info"></i>Marketing Plan</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="market_plan_one_sp"
                                                            id="market_plan_one_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->market_plan_1; ?></textarea>
                                                    </fieldset>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="market_plan_two_sp"
                                                            id="market_plan_two_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->market_plan_2; ?></textarea>
                                                    </fieldset>

                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-info"></i>Registration in the Project
                                            </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">

                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 1</label>
                                                        <textarea class="form-control" name="reg_page_one_sp"
                                                            id="reg_page_one_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->reg_page_1; ?></textarea>
                                                    </fieldset>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <fieldset class="form-group col-md-12 mb-12">
                                                        <label for="answer">Heading 2</label>
                                                        <textarea class="form-control" name="reg_page_two_sp"
                                                            id="reg_page_two_sp" rows="3"
                                                            placeholder="Answer"><?php echo $home_sp->reg_page_2; ?></textarea>
                                                    </fieldset>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="form-actions right">
                                            <button type="reset" class="btn btn-raised btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-raised btn-primary">
                                                <i class="fa fa-check-square-o"></i> Save
                                            </button>
                                        </div>

                                    </form> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- // Form actions layout section end -->
        </div>
    </div>