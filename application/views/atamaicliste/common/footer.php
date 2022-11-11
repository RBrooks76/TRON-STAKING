<?php $siteDetails = getSite();?>
<!-- footer content start -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="footerContent footerContent-links">
                    <h2 class='pb-0'><?php echo $siteDetails->site_name_2; ?></h2>

                    <?php if(isset($siteDetails->how_site) && !empty($siteDetails->how_site)){ ?>
                    <h2><?php echo $siteDetails->how_site; ?></h2>
                    <?php } ?>

                    <ul>
                        <?php
                            $get_address = FS::Common()->getTableData(ADDRESS)->result_array();

                            if ($siteDetails->site_mode == 2) { $add_url = $siteDetails->api_demo_url; }
                            else { $add_url = $siteDetails->api_live_url; }
                            if (empty(@$plansection)) {
	                    ?>

                        <li>
                            <a href="#"><?php echo lang('SMART CONTRACT'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo site_url('faq'); ?>" target="_blank"><?php echo lang('FAQ'); ?></a>
                        </li>

                        <?php
                            if ($tree_id == 1) {
                        ?>

                        <li>
                            <a href="<?php echo $add_url ?>#/contract/<?php echo insep_decode($get_address[0]['address_name']) ?>/code"
                                target="_blank"><?php echo lang('PLAN A'); ?></a>
                        </li>

                        <?php
                            } else {
                        ?>

                        <li>
                            <a href="<?php echo $add_url ?>#/contract/TEEXnjyMN34Nzap3okpwpinreefEQ1XxfK/code"
                                target="_blank"><?php echo lang('PLAN A'); ?></a>
                        </li>

                        <?php 
                            }
                        ?>

                        <!--  <li>
                            <a href="< ?php //echo $add_url?>#/contract/< ?php //echo insep_decode($get_address[1]['address_name'])?>/code" target="_blank">< ?php //echo lang('PLAN B'); ?></a>
                        </li> -->

                        <li>
                            <a href="javascript;" data-toggle="modal"
                                data-target="#video-modal"><?php echo lang('VVP'); ?></a>
                        </li>

                        <li>
                            <a href="javascript;" data-toggle="modal"
                                data-target="#video-modal-new"><?php echo lang('RVL'); ?></a>
                        </li>

                        <?php 
                            }

                            $lang_code = FS::uri()->segment(1);
                            $lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
                            $cms_pages = @get_data(CMS, array('status' => 1, 'language' => $lang), 'heading,link')->result_array();

                            if (!empty($cms_pages)) {
                                foreach ($cms_pages as $cmskey => $cmsvalue) {
                        ?>

                        <li>
                            <a href="<?php echo site_url('cms/' . $cmsvalue['link']); ?>">
                                <?php echo $cmsvalue['heading']; ?></a>
                        </li>

                        <?php
                                }
                            }
                        ?>
                    </ul>

                    <br />
                    <?php if (isset($doc) && !empty($doc)) { ?>
                    <h2 class='pb-0'><?php echo lang('Download Brochure'); ?></h2>
                    <ul>
                        <?php foreach ($doc as $value) { ?>
                        <li>
                            <a href="<?php echo base_url() . 'ajqgzgmedscuoc/img/admin/document/' . $value->document; ?>"
                                target="_blank"><?php echo $value->title; ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 pl-0">
                <div class="footerContent">
                    <h2 class="pb-0"><?php echo lang('CONTACTS'); ?></h2>

                    <ul>
                        <li>
                            <a href="mailto:support@trongoogol.com"> <?php echo $siteDetails->site_email; ?></a>
                        </li>
                    </ul>

                    <div class="col-md-12 pl-0 mt-3 mb-3">
                        <a href="<?php echo $siteDetails->contact_us_link ?>" target="_blank"><img
                                src="<?php echo base_url() . 'ajqgzgmedscuoc/img/site/' . $siteDetails->contact_us_img; ?>"></a>
                    </div>
                    <ul>
                        <li> <a href="javascript:;"> <?php echo $siteDetails->contact_us_title ?> </a> </li>
                    </ul>

                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-6">
                <div class="footerContent">
                    <h2><?php echo lang('REVIEWS'); ?></h2>
                    <div class="row align-items-center">
                        <?php if ($review) {
	                        foreach ($review as $result) {?>
                        <div class="col-6 col-sm-4 col-md-6 col-lg-4 text-center">
                            <div class="reviewsImage">
                                <a href="<?php echo $result->url_value ?>" target="_blank">
                                    <img src="<?php echo base_url() . 'ajqgzgmedscuoc/img/admin/Review/' . $result->image ?>"
                                        alt="Dapp-stats-logo-white" />
                                </a>
                            </div>
                        </div>
                        <?php }}?>
                    </div>

                    <div class='join_request'>
                        <h2 class='join_request-header'>Request Referral Joining Link & For Newsletter</h2>
                        <form id="Join_request_form" method="post" enctype="multipart/form-data">
                            <div class='join_request-contain row'>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email address : </label>
                                        <input type="email" class="form-control" name='email'>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="type" class="form-label">Another request Type : </label>
                                        <select class="form-control" name="type" onchange='JoinRequestTypeChange(this)'>
                                            <option value='1' selected>default</option>
                                            <option value='2'>Whatsapp Link</option>
                                            <option value='3'>Telegram Link</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="Whatsapp" class="form-label">Whatsapp Link : </label>
                                        <input type="text" class="form-control" name='Whatsapp' id='join-request-watapp'
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="Telegram" class="form-label">Telegram Link : </label>
                                        <input type="text" class="form-control" name='Telegram'
                                            id='join-request-telegram' disabled>
                                    </div>
                                </div>

                                <div class='form_footer_contain col-sm-12 col-md-12 col-lg-6'></div>
                                <div class='form_footer_contain col-sm-12 col-md-12 col-lg-6'>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer content End -->

<div class="copyRight">
    <div class="container-fluid d-flex justify-content-between">
        <p><?php echo getcopyrightext(); ?></p>

        <div class="soc_icons">
            <ul>
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

    </div>
</div>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
(function() {
    var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/62788615b0d10b6f3e7137b3/1g2jcnha5';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>

</html>


<?php global $myVAR;?>

<script>
var myVAR_language = <?php echo json_encode($myVAR); ?>;

function getvalidationmsg(textmsg) {
    if (textmsg) {
        if (myVAR_language[textmsg]) {
            textmsg = textmsg.replace('.', '');
            return myVAR_language[textmsg];
        } else return textmsg;
    } else return '';
}
</script>


<script type="text/javascript">
var usd_value = '<?php echo $coin_usd_value; ?>';

$("#trx_value").on('change keyup paste', function() {
    var trx_value = $('input:text[name=trx_value]').val();
    var usd = parseFloat(usd_value) * parseFloat(trx_value);
    $('#bcvValue').html(usd);
});

var value = $('#planb option:selected').attr('data-min');
$('#planb').change(function() {
    value = $(this).find(':selected').attr('data-min');
    $('.min_deposit').html('Minimum amount required:' + value);
    $('#set_min').val(value);
});

$("#plan_amt").on('change keyup paste', function() {
    var plan_amt = $('input:text[name=plan_amt]').val();
});


function start_loader() {
    $('#cover-spin').show(0);
}

function stop_loader() {
    $('#cover-spin').hide(0);
}
</script>

<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/socket.io.js"></script>

<script type="text/javascript">
var host = window.location.hostname;
var hosts = window.location.origin;
var res = hosts.substring(0, 5);
if (host == 'www.trongoogol.io' && res == 'http:') {
    var socket = io.connect('http://trongoogol.io:2052', {
        transports: ['websocket'],
        upgrade: false
    }, {
        'force new connection': true
    });
} else if (host == 'www.trongoogol.io' && res == 'https') {
    var socket = io.connect('https://trongoogol.io:2053', {
        transports: ['websocket'],
        upgrade: false
    }, {
        'force new connection': true
    });
} else if (host == '127.0.0.1' && res == 'http:') {
    console.log('http://' + window.location.hostname + ':2053')
    var socket = io.connect('https://' + window.location.hostname + ':2053', {
        transports: ['websocket'],
        upgrade: false
    }, {
        'force new connection': true
    });
}
</script>

<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/bignumber.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/moment-with-locales.min.js">
</script>
<script src="<?php echo base_url() ?>ajqgzgmedscuoc/TronConfig.js" type="text/javascript">
</script>
<script type="text/javascript"
    src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/WTCRWORN.js?ver=<?php echo date('U') ?>"></script>
<?php
    if (!empty($tree_id)) {
	    if ($tree_id == 1 && @$section != 'Manual') {
?>
<script src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/WTRRWOCN.js?ver=<?php echo date('U') ?>"
    type="text/javascript"></script>

<?php
    } else if ($tree_id == 1 && @$section == 'Manual') {?>

<script type="text/javascript"
    src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/nmwERwKc.js?ver=<?php echo date('U') ?>"></script>

<?php } else if ($tree_id > 1 && @$section == 'Manual') {?>
<script type="text/javascript"
    src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/nTmwECwKr.js?ver=<?php echo date('U') ?>"></script>
<?php } else { ?>

<script type="text/javascript"
    src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/TWTCRWORT.js?ver=<?php echo date('U') ?>"></script>
<?php
        }
    }
    if (!empty(@$plansection)) {
?>
<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/B.js?ver=<?php echo date('U') ?>">
</script>
<?php
    }
?>
<script type="text/javascript"
    src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/prefixfree.min.js?ver=<?php echo date('U') ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>ajqgzgmedscuoc/front/js/CommonFunc.js"></script>

<script>
// forEach method
var forEach = function(array, callback, scope) {
    for (var i = 0; i < array.length; i++) {
        callback.call(scope, i, array[i]);
    }
};

var spinner = document.querySelector("#spinner"),
    angle = 0,
    images = document.querySelectorAll("#spinner figure"),
    numpics = images.length,
    degInt = 360 / numpics,
    start = 0,
    current = 1;

forEach(images, function(index, value) {
    images[index].style.webkitTransform = "rotateY(-" + start + "deg)";
    images[index].style.transform = "rotateY(-" + start + "deg)";
    images[index].addEventListener("click", function() {
        if (this.classList.contains('current')) {
            this.classList.toggle("focus");
        }
    })
    start = start + degInt;
});

function setCurrent(current) {
    document.querySelector('figure#spinner figure:nth-child(' + current + ')').classList.add('current');
}

function galleryspin(sign) {
    forEach(images, function(index, value) {
        images[index].classList.remove('current');
        images[index].classList.remove('focus');
        images[index].classList.remove('caption');
    })

    if (!sign) {
        angle = angle + degInt;
        current = (current + 1);
        if (current > numpics) {
            current = 1;
        }
    } else {
        angle = angle - degInt;
        current = current - 1;
        if (current == 0) {
            current = numpics;
        }
    }

    spinner.setAttribute("style", "-webkit-transform: rotateY(" + angle + "deg); transform: rotateY(" + angle + "deg)");
    setCurrent(current);
}

document.body.onkeydown = function(e) {
    if (e.target.id != 'user-mail-info') {
        switch (e.which) {
            case 37: // left cursor
                galleryspin('-');
                break;

            case 39: // right cursor
                galleryspin('');
                break;
                2087
            case 90: // Z - zoom image in forefront image
                document.querySelector('figure#spinner figure.current').classList.toggle('focus');
                break;

            case 67: // C - show caption for forefront image
                document.querySelector('figure#spinner figure.current').classList.toggle('caption');
                break;

            default:
                return; // exit this handler for other keys
        }
        e.preventDefault();
    }
}

setCurrent(1);

if (typeof InvalidRef !== 'undefined') {
    if (InvalidRef == 1) {
        $.growl.error({
            message: (InvalidRefMsg)
        }, {

        })
    }
}

$(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
});

$(document).ready(function() {
    document.onkeydown = function(e) {
        if (e.target.id != 'user-mail-info') {
            if (e.ctrlKey &&
                (e.keyCode === 67 ||
                    e.keyCode === 86 ||
                    e.keyCode === 85 ||
                    e.keyCode === 117)) {
                return false;
            } else {
                return true;
            }
        }
    };
});

$(document).ready(function() {
    //$('#with_view_history').DataTable();
    $('#with_view_history').DataTable({
        "lengthMenu": [
            [5, 10, 15, -1],
            [5, 10, 15, "All"]
        ]
    });
});
</script>