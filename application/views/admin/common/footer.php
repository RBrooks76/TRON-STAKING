<!-- BEGIN : Footer-->
<footer class="footer footer-static footer-light">
    <!--    <p class="clearfix text-muted text-sm-center px-2"><span>Copyright  &copy; 2019 <a href="" id="pixinventLink" target="_blank" class="text-bold-800 primary darken-2">MLM </a>, All rights reserved. </span></p> -->
</footer>
<!-- End : Footer-->

<div class="cz-bg-image row sb-bg-img">
    <!--  <div class="col-sm-2 mb-3"><img src="ajqgzgmedscuoc/admin/img/sidebar-bg/01.jpg" width="90" class="rounded sb-bg-01"></div> -->
</div>
</div>

<!--  <div class="ct-chart ct-perfect-fourth"></div> -->
<style type="text/css">
#cover-spin {
    position: fixed;
    width: 100%;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background-color: rgba(0, 11, 37, 0.7);
    z-index: 9999;
    display: none;
}

#cover-spin::after {
    content: '';
    display: block;
    position: absolute;
    left: 48%;
    top: 40%;
    width: 40px;
    height: 40px;
    border-style: solid;
    border-color: #9146a6;
    border-top-color: transparent;
    border-width: 4px;
    border-radius: 50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}

.show_text {
    display: none;
    font-size: 15px;
}

.test {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    font-size: 20px;
    width: 100%;
    color: #ffff;
    z-index: 100000000;
}
</style>

<div id="cover-spin" style="display: none">
    <div class="test">
        <center>
            <p class="show_text"> Transaction in Process... <br> Please don’t click or refresh the page. <br> Please
                check your transaction on Tron link. </p>
        </center>
    </div>
</div>

<script>
var base_url = "<?php echo base_url(); ?>";
</script>

<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/core/jquery-3.2.1.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/core/popper.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/core/bootstrap.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/perfect-scrollbar.jquery.min.js"
    type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/prism.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/jquery.matchHeight-min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/screenfull.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/pace/pace.min.js" type="text/javascript">
</script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!--  <script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/vendors/js/chartist.min.js" type="text/javascript"></script> -->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN APEX JS-->
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/js/app-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/js/notification-sidebar.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/js/customizer.js?ver=dfsdfsdfsdfsfdsdfsdfsd"
    type="text/javascript"></script>
<!-- END APEX JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!--   <script src="<?php echo base_url(); ?>ajqgzgmedscuoc/admin/js/dashboard1.js" type="text/javascript"></script> -->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/jquery.validate.min.js" type="text/javascript">
</script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/vendors/js/datatable/datatables.min.js"
    type="text/javascript"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/data-tables/datatable-basic.js" type="text/javascript">
</script>

<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/additional-methods.js?ver=<?php echo date('U'); ?>"
    type="text/javascript"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/pattern/script.js?ver=<?php echo date('U'); ?>"
    type="text/javascript"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/pattern/script1.js?ver=<?php echo date('U'); ?>"
    type="text/javascript"></script>
<script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/jquery.growl.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>ajqgzgmedscuoc/front/css/jquery.growl.css">

<script src="<?php echo base_url() ?>ajqgzgmedscuoc/admin/js/connect.js?ver=<?php echo date('U') ?>"></script>
<script src="<?php echo base_url() ?>ajqgzgmedscuoc/admin/js/commonFunc.js?ver=<?php echo date('U') ?>"></script>
<script src="<?php echo front_url(); ?>ajqgzgmedscuoc/admin/js/script.js?ver=<?php echo date("U"); ?>"
    type="text/javascript"></script>


<!-- END PAGE LEVEL JS-->
<script type="text/javascript">
setTimeout(function() {
    $(".cz-bg-image img").trigger('click');
}, 100)
</script>


<script>
$(function() {
    $('#dynamic_select').on('change', function() {
        var tree_id = $(this).val();
        if (tree_id) {
            window.location = base_url + 'user/plana/' + tree_id;
        }
        return false;
    });
});
$(document).ready(function() {
    if (current_plan) {
        let _plan_ = "<?php echo isset($plan)?$plan:''; ?>";
        if (_plan_ && current_plan == 'plana') {
            $('#user-list_data').DataTable({
                'processing': true,
                'destroy': true,
                'serverSide': true,
                'serverMethod': 'post',
                "lengthMenu": [500, 1000],
                'ajax': {
                    'url': '<?php echo base_url(); ?>get_users/' + current_plan + '/' + tree_id,
                    'dataType': 'json',
                },
                'columns': [{
                    data: 'id'
                }, {
                    data: 'address'
                }, {
                    data: 'c_status'
                }, {
                    data: 'tree_id'
                }, {
                    data: 'contract_id'
                }, {
                    data: 'affiliate_id'
                }, {
                    data: 'ref_link'
                }, {
                    data: 'r_link'
                }, {
                    data: 'ref_id'
                }, ],
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            })
        }

        if (_plan_ && current_plan == 'planb') {
            $('#user-list_data').DataTable({
                'processing': true,
                'destroy': true,
                'serverSide': true,
                'serverMethod': 'post',
                "lengthMenu": [500, 1000],
                'ajax': {
                    'url': '<?php echo base_url(); ?>get_users/' + current_plan
                },
                'columns': [{
                        data: 'id'
                    }, {
                        data: 'address'
                    }, {
                        data: 'contract_id'
                    },

                ],
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });

        }
    }

    $(document).on('click', '.copyToClipboard', function() {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('data-id')).select();
        document.execCommand("copy");
        $temp.remove();

        $.growl.notice({
            message: ("Copied the URL: " + $(this).attr('data-id'))
        });
    })
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#language_home").on('change', function() {
        var level = $(this).val();
        if (level) {

            $.ajax({
                url: base_url + 'getHomecontentdata',
                type: 'POST',
                data: {
                    lang: level
                },
                dataType: "JSON",

                success: function(data) {
                    if (data.status == 'SUCCESS') {
                        if (data.datas) {

                            $('#smart_head_one').val(data.datas.smart_contact_1);
                            $('#smart_head_two').val(data.datas.smart_contact_2);
                            $('#how_work_one').val(data.datas.how_every_1);
                            $('#how_work_two').val(data.datas.how_every_2);
                            $('#market_plan_one').val(data.datas.market_plan_1);
                            $('#market_plan_two').val(data.datas.market_plan_2);
                            $('#reg_page_one').val(data.datas.reg_page_1);
                            $('#reg_page_two').val(data.datas.reg_page_2);
                            $('#adv_tech_1').val(data.datas.adv_tech_1);
                            $('#adv_tech_2').val(data.datas.adv_tech_2);
                            $('#footer_content_1').val(data.datas.footer_content_1);
                            $('#footer_content_2').val(data.datas.footer_content_2);
                            $('#footer_link_1').val(data.datas.footer_link_1);
                            $('#footer_link_2').val(data.datas.footer_link_2);
                            $('#embeed_code').val(data.datas.embeed_code);


                        }


                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
});

$(document).on('click', '.copy_link', function() {
    let value = $(this).attr('data-url')
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    $.growl.notice({
        message: ("Copied the URL: " + value)
    });
})
</script>

<script>
$('document').ready(() => {
    let ImgContain1 = $('#section-5-logo')[0];
    let BtnContain1 = $('#section-5-btn')[0];

    let ImgContain2 = $('#section-6-logo')[0];
    let BtnContain2 = $('#section-6-btn')[0];

    let ImgSection7_1 = $('#Section7_1_logo')[0];
    let BtnSection7_1 = $('#Section7_1_btn')[0];

    let ImgSection7_2 = $('#Section7_2_logo')[0];
    let BtnSection7_2 = $('#Section7_2_btn')[0];

    let ImgSection7_3 = $('#Section7_3_logo')[0];
    let BtnSection7_3 = $('#Section7_3_btn')[0];

    let ImgSection7_4 = $('#Section7_4_logo')[0];
    let BtnSection7_4 = $('#Section7_4_btn')[0];

    let adv_tech_logo = "<?php echo  isset($home->adv_tech_logo)?$home->adv_tech_logo:''; ?>";
    let footer_content_logo = "<?php echo isset($home->footer_content_logo)?$home->footer_content_logo:''; ?>";

    let ImgSec7_logo1 = "<?php echo isset($home->Section7_1_logo)?$home->Section7_1_logo:''; ?>";
    let ImgSec7_logo2 = "<?php echo isset($home->Section7_2_logo)?$home->Section7_2_logo:''; ?>";
    let ImgSec7_logo3 = "<?php echo isset($home->Section7_3_logo)?$home->Section7_3_logo:''; ?>";
    let ImgSec7_logo4 = "<?php echo isset($home->Section7_4_logo)?$home->Section7_4_logo:''; ?>";

    if (adv_tech_logo && ImgContain1 && BtnContain1) {
        ImgContain1.style.display = 'flex';
        BtnContain1.style.display = 'none';
    }
    if (footer_content_logo && ImgContain2 && BtnContain2) {
        ImgContain2.style.display = 'flex';
        BtnContain2.style.display = 'none';
    }

    if (ImgSec7_logo1 && ImgSection7_1 && BtnSection7_1) {
        ImgSection7_1.style.display = 'flex';
        BtnSection7_1.style.display = 'none';
    }
    if (ImgSec7_logo2 && ImgSection7_2 && BtnSection7_2) {
        ImgSection7_2.style.display = 'flex';
        BtnSection7_2.style.display = 'none';
    }
    if (ImgSec7_logo3 && ImgSection7_3 && BtnSection7_3) {
        ImgSection7_3.style.display = 'flex';
        BtnSection7_3.style.display = 'none';
    }
    if (ImgSec7_logo4 && ImgSection7_4 && BtnSection7_4) {
        ImgSection7_4.style.display = 'flex';
        BtnSection7_4.style.display = 'none';
    }
})
</script>

<script>
$(document).ready(() => {
    let _page_name_ = "<?php echo isset($page)? $page : ''; ?>";
    if (_page_name_ == 'NewsLetter') {
        let selectedPlan = "<?php echo $selectedPlan; ?>";
        let selectedTree = "<?php echo $selectedTree; ?>";
        $('#select_plan')[0].value = selectedPlan;
        if (selectedPlan == 1) {
            $('#select_tree')[0].value = selectedTree;
        }

        let searchContent = "<?php echo $searchContent; ?>";
        $('#searchContent').val(searchContent);
    }
})
</script>

</body>
<!-- END : Body-->

</html>