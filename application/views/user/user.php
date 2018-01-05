<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">User Management</h4>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>welcome">Dash Board</a></li>
                        <li class="active">User Management</li>
                    </ol>
                </div>
            </div>

            <?php
            if ($this->session->flashdata('msg')) {
                echo $this->session->flashdata('msg');
            }
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="pull-right">
                            <?php echo form_open('user/user_search') ?>
                            <input type="text" name="search" class="form-control" value="<?php if (isset($search_data)) {
                                echo $search_data;
                            } ?>" placeholder="Search User">
                        <?php echo form_close(); ?>
                        </div>

<?php echo form_open('user/deleteuser'); ?>
                        <div class="row">
                            <a href="<?php echo base_url(); ?>user/add" class="btn btn-default waves-effect waves-light">Add <i class="fa fa-plus"></i></a>

                            <button id="demo-delete-row" class="btn btn-danger" onclick="deleteConfirm()"><i class="fa fa-times m-r-5"></i>Delete</button>
                        </div>  
                        <br>
                        <div class="row">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="select_all" id="checkALL" value=""/></th> 
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Email</th>
                                        <th>District</th>
                                        <th>City</th>
                                        <th>Village</th>
                                        <th>Last Access</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
<?php foreach ($users as $key) {
    ?>
                                        <tr>
                                            <th><input type="checkbox" name="ck[]" class="checkbox" value="<?php echo $key['uid']; ?>"/></th>      
                                            <th><?php echo $key['username']; ?></th>
                                            <td><?php echo $key['type']; ?></td>
                                            <td><?php echo $key['email']; ?></td>
                                            <td><?php echo $key['dist_name']; ?></td>
                                            <th><?php echo $key['city_name']; ?></th>
                                            <td><?php echo $key['vil_name']; ?></td>
                                            <td><?php echo $key['last_login']; ?></td>
                                            <td><?php echo $key['status']; ?></td>
                                            <td> 
                                                <?php
                                                $this->load->model('alldata', 'model');
                                                $encrypted_id = $this->model->encryptdata($key['uid']);
                                                ?>
                                                <a href="<?php echo base_url(); ?>user/edit/<?php echo $encrypted_id; ?>" class="btn-warning btn-xs" title="update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <?php if ($key['status'] == "active") { ?>
                                                    <a class="btn-primary btn-xs" href="<?php echo base_url(); ?>user/deactiveUser/<?php echo $encrypted_id; ?>"  title="Deactive"><i class="fa fa-minus-circle text-center"></i></a>
                                                    <?php } else { ?>
                                                    <a class="btn-danger btn-xs" href="<?php echo base_url(); ?>user/activeUser/<?php echo $encrypted_id; ?>"  title="Active"><i class="fa fa-plus-circle text-center"></i></a>
                                        <?php } ?>
                                            </td>
                                        </tr>
<?php } ?>
                                </tbody>
                            </table>
                        </div>
<?php echo form_close();
echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div>