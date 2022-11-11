<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <section id="news-latter">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="newsletter-header">SMTP server manage</div>
                            </div>

                            <div class="card-body">

                                <form class="form" id="SMTPserver" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="adv_tech_1">smtp_host</label>
                                                <input type="text" class="form-control" name="host"
                                                    placeholder="please enter smtp host"
                                                    value='<?php if(isset($smtpinfo) && $smtpinfo->host) echo $smtpinfo->host; ?>' />
                                            </fieldset>
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="adv_tech_2">smtp_user</label>
                                                <input type="email" class="form-control" name="user"
                                                    placeholder="please enter user address"
                                                    value='<?php if(isset($smtpinfo) && $smtpinfo->user) echo $smtpinfo->user; ?>' />
                                            </fieldset>
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="adv_tech_1">smtp_pass</label>
                                                <input type="text" class="form-control" name="pass"
                                                    placeholder="please enter pass"
                                                    value='<?php if(isset($smtpinfo) && $smtpinfo->pass) echo $smtpinfo->pass; ?>' />
                                            </fieldset>
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="adv_tech_2">smtp_port</label>
                                                <input text="text" class="form-control" name="port"
                                                    placeholder="please enter port"
                                                    value='<?php if(isset($smtpinfo) && $smtpinfo->port) echo $smtpinfo->port; ?>' />
                                            </fieldset>
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="adv_tech_1">email sender</label>
                                                <input text="email" class="form-control" name="sender"
                                                    placeholder="please enter sender address"
                                                    value='<?php if(isset($smtpinfo) && $smtpinfo->sender) echo $smtpinfo->sender; ?>' />
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <fieldset class="form-group col-md-12 mt-4"
                                                style='display:flex; flex-direction: column;'>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- END : End Main Content-->
</div>

<script>
CKEDITOR.replace('news_content');
</script>