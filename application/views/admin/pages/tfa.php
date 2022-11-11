

<div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- Form actions layout section start -->
<section id="form-action-layouts">
  <div class="row">
    <div class="col-sm-6">
      <div class="content-header">Change TFA</div>
    </div>
    <div class="col-sm-6">
      <?php 
      if(!empty(FS::session()->flashdata('success')))
      {
      ?>
      <div class="alert alert-success"> <?php echo FS::session()->flashdata('success')?> </div>
      <?php 
      }
      else if(!empty(FS::session()->flashdata('error')))
      {
      ?>
      <div class="alert alert-danger"> <?php echo FS::session()->flashdata('error')?> </div>
      <?php 
      }
      ?>
    </div>
  </div>
  <div class="row ">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="from-actions-bottom-right"><!-- User Profile --></h4>
          
        </div>
        <div class="card-body">
          <div class="px-3">

           <div id="dash_pil5" class="tab-pane fade  show active">
     
        <div class="row">
            <div class="col-md-7">

                <a name="two-factor"></a>
                <span id="toc0"></span><h3>Two-Factor Authentication</h3>
         
            </div>
        </div>
     
        <div class="row mt-3">
      <?php if($tfastatus=='enable') { ?>    
          <div class="col-md-7 two-factor-hd">
        <dl>
          <dt><p>Two-factor authentication is <span class="text-success">enabled</span>.</p></dt>
           
        <?php echo form_open(base_url().'tfa', array('class' => 'mt-3', 'id' => 'mobile-two-factor-form')); ?>
        <input class="form-control" id="secret" name="secret" type="hidden" value="<?php echo $secret_code; ?>">
        <?php 
        if($papercode==0) {
          echo '<p>Your authentication key: '.$secret_code.'(will be shown only 24 hours after enabling)</p>';
        }
        ?>
        <h4>Disable two-factor authentication</h4>     
        <div id="div_id_token" class="form-group">
         <label for="id_token" class="control-label">Two-factor authentication code <span class="invalid">*</span> </label> 
        <div class="controls "> <input autocomplete="off" class="col-md-5 form-control" id="id_token" maxlength="6" name="token" type="text"> </div> </div>
        <?php 
        if($papercode==0) {
          echo '<p>Please confirm disabling two-factor authentication by providing the authentication code</p>';
        } else {
          echo '<p>Please confirm disabling two-factor authentication by providing the six-digit code number '.$pcount.' from your printed two-factor card</p>';
        }
        ?>

        <button type="submit" class="btn btn-raised btn-primary">Disable two-factor authentication</button>
        <?php echo form_close(); ?>    
        </dl>
    </div>
<?php } else { ?>
    <div class="col-md-7 two-factor-hd">
        <dl>
            <dt><span id="toc2"></span><h3>Enable two-factor authentication</h3></dt>
           
 
           <?php echo form_open(base_url().'tfa', array('class' => 'mt-3 display_none', 'id' => 'mobile-two-factor-form')); ?>

                <div id="" title=""><img src="<?php echo $url; ?>"></div>

                <input type="hidden">

                <div>
                    

        <div id="div_id_secret_key_b32" class="form-group mt-3"> <label for="id_secret_key_b32" class="control-label  requiredField">
        Authentication key<span class="invalid">*</span> </label> <div class="controls "> <input class="form-control" id="secret" name="secret" type="text" value="<?php echo $secret_code; ?>" readonly="" required> </div> </div>

        <div id="div_id_token" class="form-group"> <label for="id_token" class="control-label requiredField">
        Authentication code<span class="invalid">*</span> </label> <div class="controls "> <input autocomplete="off" class="input-small textinput textInput form-control" id="id_token" maxlength="6" name="token" type="text" required> </div> </div>

                </div>

                <p>
                    <input required type="checkbox"> I have written down my backup code <strong class="auth-key"><?php echo $secret_code; ?></strong> on paper
                </p>

                <button type="submit" class="btn btn-raised btn-primary">Enable two-factor authentication</button>
        <?php echo form_close(); ?>

    
            <div class="twofactor-need mt-3" id="twofactor-need-phone" style="display: none;">
                <h3>Mobile app based two-factor authentication</h3>

                <ol>
                    <li>
                        Download the Google Authenticator app for your mobile phone or tablet: <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a>, <a target="_blank" href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8">iPhone, iPad and iPod</a> or <a href="http://www.windowsphone.com/en-us/store/app/authenticator/e7994dbc-2336-4950-91ba-ca22d653759b">Windows Phone</a>.
                    </li>
                    <li>
                        Your backup code is: <strong class="auth-key"><?php echo $secret_code; ?></strong><br><strong>Important!</strong> Write this code down on a piece of paper and store it safe. You will need it if you lose your phone, or you will be locked out of your account.
                    </li>
                    <li>
                        Press the <i>Proceed to activation</i> button (above).
                    </li>
                    <li>
                        Launch the authenticator app on your mobile device. Find the <i>scan a barcode</i> function in the app and scan the barcode at the top of this page.
                    </li>
                    <li>
                        Enter the code given by your mobile app in the box above.
                    </li>
                </ol>
            </div>
            
        </dl>
    </div>
<?php } ?>    
</div>


      <?php echo form_close(); ?>
    </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
</section>
<!-- // Form actions layout section end -->

          </div>
        </div>
<script type="text/javascript">
  $(document).ready(function() {

    $("#show-active-key").click(function() {
        var method = $("input[name='two-factor-method']:checked").val();
        if(method == "mobile") {
            $("#mobile-two-factor-form").slideDown();
        } else {
            $("#paper-two-factor-form").slideDown();
        }

        $("#active-method").hide();
    });

    $("input[name='two-factor-method']").change(function() {
        $("#show-active-key").removeAttr("disabled");

        $(".twofactor-need").hide()

        var method = $("input[name='two-factor-method']:checked").val();
        if(method == "mobile") {
            $("#twofactor-need-phone").slideDown();
        } else {
            $("#twofactor-need-paper").slideDown();
        }

    });

    if($("#two-factor-form").find(".errorlist").size() > 0) {
        $("#two-factor-form").show();
        $("#show-active-key").hide();
    };

    $("#paper-codes").click(function(e) {
        e.preventDefault();
        var href = $(this).attr("href");
        window.open(href, "Paer codes",'height=500,width=640');
        return false;
    });

    var code = $("#id_secret_key_b32").val();
    $(".auth-key").text(code);
  });