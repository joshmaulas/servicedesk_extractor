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
                                    <li><a onclick="view_report_form(this)" data-report-name='calls_plot'>Calls Plot</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly'>Monthly - Daily Sales</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly_per_store'>Monthly - Daily Sales Per Store</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly_per_store_day'>Monthly - Daily Sales Per Day</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly_breakfast'>Monthly - Breakfast Sales Per Store</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly_midnight'>Monthly - Midnight Sales Per Store</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='monthly_pmix'>Monthly - Product Mix</a></li>

                                    <!-- <li><a onclick="view_report_form(this)" data-report-name='comp'>Daily Comps And Growth</a></li>
                                    <li><a onclick="view_report_form(this)" data-report-name='weekly'>Hub Dec Summary</a><li>
                                    <li><a onclick="view_report_form(this)" data-report-name='hub_dec_reason'>Hub Dec Reason</a></li> -->
                                    
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
                    <div class="row-fluid"></div>
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
                    <div class="row-fluid"></div>
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
        <script>
        $("#preloader").hide();
        $("#loader").hide();
        $(function() {
            $("#table_form").hide();

        });

        function view_report_form(param){

            var report_name = param.getAttribute("data-report-name");


            $.ajax({

             url: "<?php echo base_url(); ?>pages/report_forms",
             method:"post",  
            data:{report_name:report_name},

             success: function(data){

                 $("#table_form").hide();
                 $("#report_form").html(data);
             },

             error: function(){


                 console.log("Error!");

             },
            });

        }


        function gen_table(param)
        {
            document.getElementById("gene").disabled = true;
            $("#preloader").fadeIn();
            $("#loader").fadeIn();
           var type_report = param.getAttribute('data-report-name');

           var directory = "";
            switch(type_report) {
                case "monthly_table_form":
                            directory = "monthly_report/";
                            var month =  $("#selectMonth").val();
                            var year =  $("#selectYear").val();
                            val1 = "";
                break;
                case "monthly_per_store_table_form":
                            directory = "monthly_per_store_report/";
                            var month_per_store =  $("#selectMonth").val();
                            var year_per_store =  $("#selectYear").val();
                break;
                case "monthly_per_store_day_table_form":
                            directory = "monthly_per_store_day_report/";
                            var month_per_store_day =  $("#selectMonth").val();
                            var year_per_store_day =  $("#selectYear").val();
                            // var csv_file = $("#csv_file").val();
                break;
                case "daily_table_form":
                            directory = "daily_report/";
                            var date_for_daily = $('#date_for_daily').val();
                            var month = "";
                            var year = "";
                break;
                case "weekly_table_form":
                            directory = "weekly_report/";
                            var weekly_date = $('#date_for_weekly').val();
                            var range = $('#range').val();
                break;
                case "hub_table_form":
                            directory = "hub_dec_report/";
                            var date_hub_from = $('#date_hub_from').val();
                            var date_hub_to = $('#date_hub_to').val();
                break;
                case "comp_table_form":
                            directory = "comp_growth_report/";
                            var prev_date = $('#previous_date').val();
                            var pre_date = $('#present_date').val();
                            var types = $("#selectType").val();
                break;
                case "calls_plot_table_form":
                            directory = "calls_plot_report/";
                            var store = $('#store').val();
                            var calls_plot_date_from = $('#calls_plot_date_from').val();
                            var calls_plot_date_to = $("#calls_plot_date_to").val();
                break;

                case "monthly_breakfast_table_form":
                            directory = "monthly_customized_report/";
                            var month_breakfast =  $("#selectMonth").val();
                            var year_breakfast =  $("#selectYear").val();
                break;

                case "monthly_midnight_table_form":
                            directory = "monthly_customized_report/";
                            var month_midnight =  $("#selectMonth").val();
                            var year_midnight =  $("#selectYear").val();
                break;

                case "pmix_table_form":
                            directory = "pmix_report/";
                            var month_pmix =  $("#selectMonth").val();
                            var year_pmix =  $("#selectYear").val();
                break;


                }
                //console.log("Month: "+month + "year: "+ year+ "val1: "+val1);
                $.ajax({

                        url:  "<?php echo base_url(); ?>pages/table_forms",
                        method: "POST",
                        data: {
                                month: month,
                                year: year,
                                month_per_store:month_per_store,
                                year_per_store:year_per_store,
                                date_for_daily: date_for_daily,
                                date_for_weekly: weekly_date,
                                d_range : range,
                                date_from : date_hub_from,
                                date_to : date_hub_to,
                                previous_date : prev_date,
                                present_date : pre_date,
                                type : types,
                                
                                store: store,
                                calls_plot_date_from: calls_plot_date_from,
                                calls_plot_date_to: calls_plot_date_to,

                                month_breakfast: month_breakfast,
                                year_breakfast: year_breakfast,

                                month_midnight: month_midnight,
                                year_midnight: year_midnight,

                                month_pmix: month_pmix,
                                year_pmix: year_pmix,

                                month_per_store_day:month_per_store_day,
                                year_per_store_day:year_per_store_day,
                                // csv_file:csv_file,
                                
                                type_report:type_report
                        },

                        success: function(data){

                             $("#table_form").show(function(){
                                 $("#preloader").hide();
                                 $("#loader").hide();
                                    $(this).html(data);

                                    document.getElementById("gene").disabled = false;

                             });


                        },

                        error: function(){
                            $("#preloader").hide();
                            $("#loader").hide();
                            console.log("Error!");

                          document.getElementById("gene").disabled = false;

                        },
                });

            }
        </script>
        <script src="vendors/jquery-1.9.1.js"></script>
        <link href="vendors/datepicker.css" rel="stylesheet" media="screen">
        <script src="vendors/bootstrap-datepicker.js"></script>
        <!-- datepickers -->
    </body>
    <style type="text/css">
   #loader {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #C0C0C0; /* Blue */
        border-radius: 50%;
        width:20px;
        height:20px;
        position:absolute;
        left:50%; /* centers the loading animation horizontally one the screen */
        top:50%;
        margin:-100px 0 0 -100px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    #preloader {
        position:fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: #000000; /* change if the mask should have another color then white */
        z-index:99; /* makes sure it stays on top */
        opacity: 0.5;
    }
    </style>

</html>
