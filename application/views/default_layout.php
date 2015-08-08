<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo version();?> </title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!--<link href="<?php /*echo base_url()*/?>assets/css/sb-admin.css" rel="stylesheet">-->
    <link href="<?php echo base_url()?>assets/css/freeow/freeow.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/apps/css/app.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url()?>assets/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!-- jQuery Version 1.11.0 -->

    <script src="<?php echo base_url()?>assets/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url()?>assets/js/underscore.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/underscore.string.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.maskedinput.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.numeric.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.blockUI.js"></script>
    <script src="<?php echo base_url()?>assets/js/numeral.min.js"></script>
    <script src="<?php echo base_url()?>assets/heighcharts/js/highcharts.js"></script>

    <script src="<?php echo base_url()?>assets/apps/js/apps.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.freeow.min.js"></script>


    <script type="text/javascript" charset="utf-8">
        var site_url = '<?php echo site_url()?>';
        var base_url = '<?php echo base_url()?>';
        var url_44 = '<?php echo prov_server(44)?>';
        var url_40 = '<?php echo prov_server(40)?>';
        var url_45 = '<?php echo prov_server(45)?>';
        var url_46 = '<?php echo prov_server(46)?>';
        var provname = '<?php echo provname()?>';
        var year = '<?php echo year()?>';
        var off_id = '<?php echo $this->session->userdata('hospcode')?>';
        var user_level = '<?php echo $this->session->userdata('user_level')?>';
        var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>


</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url()?>">Env Occ</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">


                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-keyboard-o"></i> รายงานโรคจากการประกอบอาชีพ (Y96)<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('reports/y96')?>"><i class="fa fa-reddit-square"> </i> จำนวนผู้ป่วยที่วนิฉัยด้วย Y96</a></li>
                            <li><a href="<?php echo site_url('reports/principle_y96')?>"><i class="fa fa-search-plus"> </i>20 อันดับโรคหลักทีวนิจฉัย Y96</a></li>
                            <li><a href="<?php echo site_url('reports/y96_sex')?>"><i class="fa fa-list"> </i> จำนวนผู้ป่วย  Y96 แยกรายเพศ</a></li>
                            <li><a href="<?php echo site_url('reports/y96_age')?>"><i class="fa fa-anchor"> </i> จำนวนผู้ป่วยตามกลุ่มอายุ</a></li>
                            <li ><a href="<?php echo site_url('reports/y96_sex')?>" disabled><i class="fa fa-bars"> </i> จำนวนผู้ป่วยตามอาชีพ </a></li>


                        </ul>

                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> รายงานโรคจากสิ่งแวดล้อม (Y97)<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('reports/y97')?>"><i class="fa fa-search-plus"> </i> จำนวนผู้ป่วยที่วนิฉัยด้วย Y97</a></li>
                            <li><a href="<?php echo site_url('reports/principle_y97')?>"><i class="fa fa-camera-retro"> </i> 20 อันดับโรคหลักทีวนิจฉัย Y97</a></li>
                            <li><a href="<?php echo site_url('reports/y97_sex')?>"><i class="fa fa-database"> </i> จำนวนผู้ป่วย  Y97 แยกรายเพศ</a></li>
                            <li><a href="<?php echo site_url('reports/y96_sex')?>"><i class="fa fa-envelope"> </i> จำนวนผู้ป่วยตามกลุ่มอายุ</a></li>
                            <li><a href="<?php echo site_url('reports/y96_sex')?>"><i class="fa fa-file"> </i> จำนวนผู้ป่วยตามอาชีพ </a></li>
                        </ul>

                    </li>
<!--                    <li class="dropdown">
                        <a href="<?php /*echo site_url('reports/individual')*/?>"><i class="fa fa-reddit-square"> </i> ข้อมูลการป่วยรายบุคคล (Individual Data)</a>
                    </li>-->
                </ul>
                </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<br>
    <br>    <br>    <br>
<div style="" class="container" id="page-wrapper">
        <?php echo $content_for_layout?>
    </div>
</div>
<div id="freeow" class="freeow freeow-bottom-right"></div>
</body>
</html>
