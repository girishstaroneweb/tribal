<!DOCTYPE html>
<html>

    <!-- Mirrored from coderthemes.com/ubold_1.1/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Nov 2015 02:13:52 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="content">
        <meta name="author" content="Star One Web">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon_1.ico">

        <title>Project name</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>

        <style type="text/css">
            .nav.nav-tabs + .tab-content{
                padding: 0px;
            }
            .wrapper-page{
                margin: 3% auto;
            }
            .m-t-40{
                margin-top: 0px!important;
            }
        </style>        
    </head>
    <body>

        <div class="animationload">
            <div class="loader"></div>
        </div>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading"> 
                    <?php
                    if ($this->session->flashdata('msg')) {
                        echo $this->session->flashdata('msg');
                    }
                    ?>
                    <h3 class="text-center"> Sign In to <strong class="text-custom">Name</strong> </h3>
                </div> 



                <div class="row">

                    <div class="col-lg-12"> 
                        <ul class="nav nav-tabs tabs">
                            <li class="active tab">
                                <a href="#admin" data-toggle="tab" aria-expanded="false"> 
                                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                                    <span class="hidden-xs">Admin</span> 
                                </a>
                            </li> 
                            <li class="tab"> 
                                <a href="#user" data-toggle="tab" aria-expanded="false"> 
                                    <span class="visible-xs"><i class="fa fa-user"></i></span> 
                                    <span class="hidden-xs">user</span> 
                                </a>
                            </li>
                        </ul> 

                        <div class="tab-content"> 

                            <?php
                            $attr = array("role" => "form", "class" => "form-horizontal m-t-20");
                            echo form_open('login/chkLogin', $attr);
                            ?>

                            <div class="tab-pane" id="user">


                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <select name="dist" class="form-control" id="dist" onchange="dist_fun()" name="dist">
                                            <option value="">--SELECT DIST.--</option>
                                            <?php foreach ($dist as $st) { ?>
                                                <option value="<?php echo $st['id']; ?>"><?php echo $st['dist_name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <select name="city" class="form-control" id="city" onchange="city_fun()">
                                            <option value="">--SELECT CITY--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <select name="vil" class="form-control" id="vil">
                                            <option value="">--SELECT VILLAGE--</option>
                                        </select>
                                    </div>
                                </div>


                            </div> 


                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input name="uname" class="form-control" type="text"  placeholder="Username">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input name="pass" class="form-control" type="password"  placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group text-center m-t-40">
                                <div class="col-xs-12">
                                    <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <a href="page-recoverpw.html" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                            </div>

                            <?php echo form_close(); ?>    
                        </div> 
                    </div>

                    <!-- end row -->
                </div>  




            </div>



            <script>
                var resizefunc = [];
            </script>

            <!-- jQuery  -->
            <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>


            <script src="<?php echo base_url(); ?>assets/js/jquery.core.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>

    </body>

    <!-- Mirrored from coderthemes.com/ubold_1.1/light/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Nov 2015 02:13:52 GMT -->
</html>



<script>
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