<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <section id="news-latter">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="newsletter-header">Send NewsLetter</div>
                                <div class="sender-section">
                                    <div class="sender-hader">Sender Email : </div>
                                    <div class="sender-mail"><?php echo $contact_email; ?></div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="member-users-section row">
                                    <div class="form-group select-plan-contain col-md-6">
                                        <label class="form-control-label">Select Plan</label>
                                        <select class="form-control" name="select_plan" id="select_plan"
                                            onchange='PlanChangeFunc()'>
                                            <option value="all" selected>All Plan</option>
                                            <option value="1">Plan A</option>
                                            <option value="2">Plan B</option>
                                            <option value="requestJoinLink">Request Referral Joining Link</option>
                                        </select>
                                    </div>
                                    <div class="form-group select-plan-contain col-md-6"
                                        style='display:<?php echo $treeState ? 'block' : 'none'; ?>'>
                                        <label class="form-control-label">Select Tree ID</label>
                                        <select class="form-control" name="select_tree" id="select_tree"
                                            onchange='TreeChangeFunc()'>
                                            <option value="all" selected>All Tree</option>
                                            <?php
                                                for ($i=0; $i < $treeCount ; $i++) { 
                                            ?>
                                            <option value="<?php echo $i+1; ?>"><?php echo $i+1; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 member-table-contain">
                                        <label class="form-control-label">Users :</label>
                                        <div class="member-table-header">
                                            <div class="all-user-select" style="padding-left:  20px;">
                                                <label>
                                                    <input type="checkbox" name="all_plans"
                                                        class="permission all_plans newsAllUserSelect"
                                                        onchange='NewsUserAllSelFunc(this)'>
                                                    All Users
                                                </label>
                                            </div>

                                            <div class="news-user-serch-contain">
                                                <input type="text" placeholder="" class="p-1" id='searchContent'
                                                    onkeydown='SearchChangeFunc(event)'>
                                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                                    class="news-user-search-icon bi bi-search"
                                                    onclick='SearchEnterFunc()'>
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="members-table-body rowheaders">
                                            <?php
                                                if($referralStatus){
                                            ?>
                                            <table class="table-contain_">
                                                <caption style='
                                                    display:<?php echo count($usersData)?'none':'table-caption'; ?>'>
                                                    data not exist
                                                </caption>
                                                <thead>
                                                    <tr class="table-contain_tr">
                                                        <th></th>
                                                        <th>Email Address</th>
                                                        <th>Request Type</th>
                                                        <th>Another Address</th>
                                                        <th>Request date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($usersData as  $value) {
                                                    ?>
                                                    <tr class="table-contain_tr">
                                                        <td>
                                                            <div class="table-contain-first-td">
                                                                <input type="checkbox"
                                                                    class="permission all_user NewsUsersSelect"
                                                                    name="all_user_<?php echo $value->link_id; ?>"
                                                                    data-id='<?php echo $value->link_id; ?>'
                                                                    onchange='NewsUsersSelFunc(this)'>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($value->request_type == 2 || $value->request_type == 3) echo $value->request_e;
                                                                else echo $value->request_value;
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php 
                                                                if($value->request_type == 2) echo 'WhatsApp';
                                                                else if($value->request_type == 3) echo 'Telegram';
                                                                else echo 'Gmail';
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($value->request_type == 2 || $value->request_type == 3) echo $value->request_value ;
                                                                else echo $value->request_e; 
                                                            ?>
                                                        </td>

                                                        <td><?php echo $value->created_at; ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                                } else {
                                            ?>
                                            <table class="table-contain_">
                                                <caption style='
                                                    display:<?php echo count($usersData)?'none':'table-caption'; ?>'>
                                                    data not exist
                                                </caption>
                                                <thead>
                                                    <tr class="table-contain_tr">
                                                        <th></th>
                                                        <th>Email</th>
                                                        <th>Wallet Address</th>
                                                        <th>profile ID</th>
                                                        <th>plan</th>
                                                        <th>tree ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($usersData as  $value) {
                                                    ?>
                                                    <tr class="table-contain_tr">
                                                        <td>
                                                            <div class="table-contain-first-td">
                                                                <input type="checkbox"
                                                                    class="permission all_user NewsUsersSelect"
                                                                    name="all_user_<?php echo $value->id; ?>"
                                                                    data-id='<?php echo $value->id; ?>'
                                                                    onchange='NewsUsersSelFunc(this)'>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $value->email; ?></td>
                                                        <td><?php echo $value->address; ?></td>
                                                        <td><?php echo $value->contract_id; ?></td>
                                                        <td><?php echo $value->plan_id; ?></td>
                                                        <td><?php echo $value->tree_id; ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <form class='row col-md-12 form' id="newsLetterForm" method="post"
                                        enctype="multipart/form-data">
                                        <div class="col-md-12 form-group news-subtitle mt-5">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="answer">Subtitle</label>
                                                <input class="form-control" name="subtitle" id="news_subtitle"
                                                    placeholder="please enter subtitle" />
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12 news-content">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="answer">attach file</label>
                                                <input class="form-control" name="attachfile" id="news_attachfile"
                                                    type='file' />
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12 news-content">
                                            <fieldset class="form-group col-md-12 mb-12">
                                                <label for="answer">Content</label>
                                                <textarea class="form-control" name="news_content" id="news_content"
                                                    placeholder="please enter content"></textarea>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12 newsletter-send-btn-contain">
                                            <input type="submit" class="newsletter-send-btn"
                                                style='background-color: #a3a3a3;' id='newsLetterSubmitBtn'
                                                value="Submit">
                                        </div>
                                    </form>
                                </div>
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