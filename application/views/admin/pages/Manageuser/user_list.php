<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="col-sm-6">
                                <?php
if (!empty(FS::session()->flashdata('success')) || !empty(FS::session()->flashdata('js'))) {
	?>
                                <div id="success" class="alert alert-success">
                                    <?php echo FS::session()->flashdata('success') ?> </div>
                                <?php
} else if (!empty(FS::session()->flashdata('error')) || !empty(FS::session()->flashdata('js'))) {
	?>
                                <div id="error" class="alert alert-danger">
                                    <?php echo FS::session()->flashdata('error') ?> </div>
                                <?php
}
?>
                            </div>

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $plan == 'plana' ? 'PLAN A ' : 'PLAN B '; ?>User
                                    Management</h4>
                            </div>

                            <!--  <div class="text-right d-none d-sm-none d-md-none d-lg-block">

               <a href="<?php //echo base_url() . 'useradd' ?>">  <button type="button" class="btn btn-success btn-raised mr-3"><i class="fa fa-plus"></i> Add User</button> </a>
         </div> -->

                            <div class="card-content">
                                <div class="card-body card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration"
                                        id="user-list_data">
                                        <thead>
                                            <tr>
                                                <th>S.No.<span class="fa fa-sort"></span></th>
                                                <th>Address<span class="fa fa-sort"></span></th>
                                                <?php if ($plan == 'plana') {?>
                                                <th>Core 7 Status<span class="fa fa-sort"></span></th>
                                                <th>Tree ID
                                                    <select id="dynamic_select">
                                                        <?php for ($i=1; $i <= $top_tree; $i++) { ?>
                                                        <option value='<?php echo $i; ?>'
                                                            <?php echo $tree_id == $i ? 'selected ' : ' '; ?>>
                                                            <?php echo $i;  ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="fa fa-sort"></span>
                                                </th>
                                                <th>Contract Id<span class="fa fa-sort"></span></th>
                                                <th>Placed Under Affiliate Id<span class="fa fa-sort"></span></th>
                                                <th>Refferal Link Status <span class="fa fa-sort"></span></th>
                                                <th>Refferal Link <span class="fa fa-sort"></span></th>
                                                <?php }?>
                                                <th>Referred by<span class="fa fa-sort"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Zero configuration table -->
            <!-- Default ordering table -->



            <script type="text/javascript">
            var current_plan = "<?php echo $plan; ?>";
            var tree_id = "<?php echo $tree_id; ?>";
            </script>

            <!--/ Language - Comma decimal place table -->

        </div>
    </div>
    <!-- END : End Main Content-->