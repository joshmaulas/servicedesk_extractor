<!DOCTYPE html>
<html class="no-js">

    <head>
        <title>Admin Home Page</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script src="assets/js/jquery-3.1.0.js"></script>

        <style type="text/css">

        .scroll-table{
            overflow: scroll;
        }
        .row-fluid {
                margin-left: 20px !important;
                width: 100% !important;
        }
        table thead,tbody th,td{
            min-width: 150% !important;
            overflow-x:scroll;

        }

        div.muted.pull-left-hub-dec{
            color: red;
        }

        th{
            font-size: 12px;
        }
        </style>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">ICT</a>
                    <div class="nav-collapse collapse">

                        <ul class="nav">
                            <li class="active">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reports <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li><a onclick="view_report_form(this)" data-report-name='daily'>Hourly Sales</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly'>Daily Sales</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='comp'>Daily Comps And Growth</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='weekly'>Hub Dec Summary</a><li>
                                    <li><a onclick="view_report_form(this)" data-report-name='hub_dec_reason'>Hub Dec Reason</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='calls_plot'>Calls Plot</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
                    </div>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div id="report_form"></div>
                        </div>
                                 <!-- /block -->
                    </div>
                </div>
                        <!-- Monthly table content -->
                <div class="span11" id="content">
                    <div class="row-fluid">
                    </div>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div id="table_form"></div>
                        </div>
                    </div>
                </div>
                         <!-- /Monthly table content -->
            </div>
        </div>
            </div>
            <hr>
            <footer>

            </footer>
        </div>
        <div id="preloader">
	           <div id="loader">&nbsp;</div>
        </div>
        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
        <!-- custom script -->