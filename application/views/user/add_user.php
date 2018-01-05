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
                        <li><a href="<?php echo base_url(); ?>user">User Management</a></li>
                        <?php if (!isset($view)) { ?>
                            <li class="active">Add User</li>
                        <?php } else { ?>
                            <li class="active">Edit User</li>
                        <?php } ?>

                    </ol>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="card-box">
                        <?php
                        if (!isset($view)) {
                            echo form_open('user/add', "data-parsley-validate", "novalidate");
                        } else {
                            $this->load->model('alldata', 'model');
                            $encrypted_id = $this->model->encryptdata($view[0]['uid']);
                            echo form_open("user/edit/{$encrypted_id}", "data-parsley-validate", "novalidate");
                        }
                        ?>
                        <div class="form-group">
                            <?php
                            if (isset($view)) {
                                $t = $view[0]['type'];
                            }
                            ?>  
                            <select name="u_type"    class="form-control" id="type" onchange="type_fun()" parsley-trigger="change" required placeholder="Select type">
                                <option value="">--SELECT TYPE--</option>
                                <option value="user" <?php
                                if (isset($view)) {
                                    if ($t == "user") {
                                        echo "selected";
                                    }
                                }
                                ?> >user</option>

                                <option value="admin" <?php
                                if (isset($view)) {
                                    if ($t == "admin") {
                                        echo "selected";
                                    }
                                }
                                ?> >admin</option>
                            </select>
                        </div>

                        <span id="user">
                            <div class="form-group">
                                <?php
                                if (isset($view)) {
                                    $d = $view[0]['dist'];
                                    $c = $view[0]['city'];
                                    $v = $view[0]['vil'];
                                }
                                ?>    
                                <select name="dist" class="form-control" id="dist" onchange="dist_fun()" name="dist" parsley-trigger="change" required placeholder="Select dist.">
                                    <option value="">--SELECT DIST.--</option>
                                    <?php foreach ($dist as $st) { ?>
                                        <option value="<?php echo $st['id']; ?>" <?php
                                        if (isset($view)) {
                                            if ($d == $st['id']) {
                                                echo "selected";
                                            }
                                        }
                                        ?>><?php echo $st['dist_name']; ?></option>
                                            <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="city" class="form-control" id="city" onchange="city_fun()">
                                    <option value="">--SELECT CITY--</option>
                                    <?php foreach ($city as $ct) { ?>
                                        <option value="<?php echo $ct['id']; ?>" <?php
                                        if (isset($view)) {
                                            if ($c == $ct['id']) {
                                                echo "selected";
                                            }
                                        }
                                        ?>><?php echo $ct['city_name']; ?></option>
                                            <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="vil" class="form-control" id="vil">
                                    <option value="">--SELECT VILLAGE--</option>
                                    <?php foreach ($village as $vl) { ?>
                                        <option value="<?php echo $vl['id']; ?>" <?php
                                        if (isset($view)) {
                                            if ($v == $vl['id']) {
                                                echo "selected";
                                            }
                                        }
                                        ?>><?php echo $vl['vil_name']; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </span>

                        <div class="form-group">
                            <input type="text" name="u_name" parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="userName" value="<?php
                            if (isset($view)) {
                                echo $view[0]['username'];
                            }
                            ?>">

                        </div>

                        <div class="form-group">
                            <input type="email" name="u_email" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress" value="<?php
                            if (isset($view)) {
                                echo $view[0]['email'];
                            }
                            ?>">
                        </div>
                        <?php if (!isset($view)) { ?>
                            <label>Password is auto generated</label>
                        <?php } ?>
                        <div class="form-group text-right m-b-0">

                            <input type="submit" name="save" value="save" class="btn btn-primary">

                            <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
</div>


<script>

    $('#city').load('/dfasdf');


    function dist_fun() {
        var dist = $('#dist').val();
        $.ajax({
            url: '<?php echo base_url(); ?>login/getcity/' + dist,
            type: 'PUT',
            //data : {dist:dist},
            success: function (data) {
                $('#city').html(data);

            }
        });

    }


    function city_fun() {
        var city = $('#city').val();
        $.ajax({
            url: '<?php echo base_url(); ?>login/get_village/' + city,
            type: 'PUT',
            //data : {dist:dist},
            success: function (data) {
                $('#vil').html(data);
            }
        });

    }
</script> 

<script type="text/javascript">


    $(document).ready(function () {
        var type = $('#type').val();
        if (type == 'admin') {
            $("#user").hide();
            $("#dist").removeAttr("required");
        }

        if (type == 'user') {
            $("#user").show();
        }
    });



    function type_fun() {

        var type = $('#type').val();
        if (type == 'admin') {
            $("#user").hide();
            $("#dist").removeAttr("required");
        }

        if (type == 'user') {
            $("#user").show();
        }
    }
</script>