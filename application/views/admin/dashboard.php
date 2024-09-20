<?php
$this->load->view('admin/includes/header');
global $global_user_privileges;
?>
<?php if (DEMO) { ?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script>


<?php if (DEMO || LATAM) { ?>
<style type="text/css">

    #timesheet, #consultant_invoice, #employee_invoice, #user_invoice {
        display: none;
    }

    #expand-collapse, #expand-collapse-cons, #expand-collapse-emp, #expand-collapse-user {
        float: right;
        cursor:pointer;
        text-decoration:underline; 
        color:#09f;
    }

    .timesheet_container{
        display: flex;
        margin-bottom:1rem;
        align-items: center;
       
    }
    .start {
        display: block;
        margin-bottom: 10px;
        
    }
    .calender-container{
        margin: 1rem;
    }
    .calender{
        padding: 5px;
        border-radius: 5px;
        border: 1px solid;
    }
    .user{
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }
    .user-type{
        margin-bottom: 10px;
    }
    .user-select{
        padding: 8px;
        border-radius: 5px;
        padding-right: 100px;
    }

    .timesheet{
        display: flex;
        flex-direction: column;
        margin-left: 2rem;
    }
    .timesheet-select{
        padding: 8px;
        border-radius: 5px;
        padding-right: 100px;
    }
    .timesheet-status{
        margin-bottom: 10px;
    }
    .button-container{
        margin-left: 1rem;
      
    }
    .filter-button{
        margin-top: 30px;
        margin-left: 2rem;
        padding: 5px 16px;
        cursor: pointer;
        text-align: center;
        background-color: #4CAF50;
        border: none;
        text-align: center;
        text-decoration: none;
        border-radius: 2px;
        color: white;
        outline: none;
    }
    .loader-container{
        display:none;
    }
    .loader{
       width: 100px;
       height: auto;
    }
    .my-small-box{
        margin-right: 10px;
        margin-left: 10px;
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 90px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: white;
        width: 350px;
        height: 200px;
        min-height: 150px;
        min-width: 300px;
        padding: 0 10px;
        overflow:hidden;
    }
    .my-small-box-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
       
    }
    .my-img-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
    }
    .my-icon{
        transition: all .3s linear;
        position: absolute !important;
        top: -40px  !important;
        right: 13px  !important;
        z-index: 0;
        font-size: 160px  !important;
        color: rgba(0, 0, 0, 0.15);
    }
    .client-top{
        padding-top: 5px;
        padding-bottom: 5px;
        display: block;
        color: black;
        margin: 0;
        font-weight: bold;
        font-size: 12px;
        text-align: center;
        background-color: white;
    }
    .box-links-container{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}
.box-link{
    display: block;
    text-align: center;
    padding: 10px;
    color:#fff;
}
.box-link:hover{
    color:white;
    opacity:0.9;
}
.box-link:focus{
    color:white; 
}
.box-link:visited{
    color:white; 
}
</style>
<?php } ?>
<?php if (INDIA || US) { ?>
    <style type="text/css">

    #timesheet, #consultant_invoice, #employee_invoice, #user_invoice {
        display: none;
    }

    #expand-collapse, #expand-collapse-cons, #expand-collapse-emp, #expand-collapse-user {
        float: right;
        cursor:pointer;
        text-decoration:underline; 
        color:#09f;
    }

    .timesheet_container{
        display: flex;
        margin-bottom:1rem;
        align-items: center;
       
    }
    .start {
        display: block;
        margin-bottom: 10px;
        
    }
    .calender-container{
        margin: 1rem;
    }
    .calender{
        padding: 5px;
        border-radius: 5px;
        border: 1px solid;
    }
    .user{
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }
    .user-type{
        margin-bottom: 10px;
    }
    .user-select{
        padding: 8px;
        border-radius: 5px;
        padding-right: 100px;
    }

    .timesheet{
        display: flex;
        flex-direction: column;
        margin-left: 2rem;
    }
    .timesheet-select{
        padding: 8px;
        border-radius: 5px;
        padding-right: 100px;
    }
    .timesheet-status{
        margin-bottom: 10px;
    }
    .button-container{
        margin-left: 1rem;
      
    }
    .filter-button{
        margin-top: 30px;
        margin-left: 2rem;
        padding: 5px 16px;
        cursor: pointer;
        text-align: center;
        background-color: #4CAF50;
        border: none;
        text-align: center;
        text-decoration: none;
        border-radius: 2px;
        color: white;
        outline: none;
    }
    .loader-container{
        display:none;
    }
    .loader{
       width: 100px;
       height: auto;
    }
    .my-small-box{
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 90px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: white;
        width: 350px;
        height: 200px;
        padding: 0 10px;
        overflow:hidden;
    }
    .my-img-box{
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: white;
        width: 350px;
        height: 200px;
    }
    .my-small-box-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
       
    }
    .my-img-footer{
        display: block;
        position:absolute !important;
        width: 100%;
        left: 0px;
        bottom: 0px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px; 
    }
    .my-icon{
        transition: all .3s linear;
        position: absolute !important;
        top: -40px  !important;
        right: 13px  !important;
        z-index: 0;
        font-size: 160px  !important;
        color: rgba(0, 0, 0, 0.15);
    }
    .client-top{
        padding-top: 5px;
        padding-bottom: 5px;
        display: block;
        color: black;
        margin: 0;
        font-weight: bold;
        font-size: 12px;
        text-align: center;
        background-color: white;
    }
    .box-links-container{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    }
    .box-link{
        display: block;
        text-align: center;
        padding: 10px;
        color:#fff;
    }
    .box-link:hover{
        color:white;
        opacity:0.9;
    }
    .box-link:focus{
        color:white; 
    }
    .box-link:visited{
        color:white; 
    }
    </style>
<?php } ?>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/expand-collapse.js"></script>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin_dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('admin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('admin/includes/user_panel');
            $this->load->view('admin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo CLIENT_NAME; ?>
                <?php if (DEMO || LATAM) { ?>
                <small>Overview</small>
                <?php } ?>
                <?php if (INDIA || US) { ?>
                <small>Control panel <?php echo SMTP_EMAIL; ?></small>
                <?php } ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Overview</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <?php if (DEMO) { ?>
            <div class="row gx-5">
            <?php if (!$is_hiring_manager) { ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/accountsRecieveable.js"></script-->
                        <canvas id="accountsChart"></canvas>
                        <script type="text/javascript">
                          let varAccountsChart = document
                                .getElementById("accountsChart")
                                .getContext("2d");

                            var accountsChart = new Chart(varAccountsChart, {
                                type: "doughnut",
                                data: {
                                    labels: [
                                        "1-30 days",
                                        "31-60 days",
                                        "61-90 days",
                                        "91-120 days",
                                    ],
                                    fontColor: "black",
                                    datasets: [
                                        {
                                            label: "Accounts Receivable",
                                            data: <?php echo json_encode($account_receivable_chart); ?>, //[120, 50, 30, 110, 30]
                                            backgroundColor: [
                                                "#92ccfc",
                                                "#e08cec",
                                                "#f5a5c8",
                                                "#ffcc5c",
                                            ],
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    legend: {
                                        display: true,
                                        position: "right",
                                        align: "center",
                                        labels: {
                                            fontColor: "black",
                                            boxWidth: 10,
                                        },
                                    },
                                    title: {
                                        display: true,
                                        text: "Accounts Receivable",
                                        fontColor: "black",
                                        fontFamily: "tahoma",
                                        fontWeight: "bold"
                                    },
                                },
                            });
          
                        </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_invoice'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php // Section - Finance Chart ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/financeChart.js"></script-->
                        <canvas id="elFinanceChart"></canvas>
                        <script type="text/javascript">
                            let varFinanceChart = document
                                .getElementById("elFinanceChart")
                                .getContext("2d");

                            var financeChart = new Chart(varFinanceChart, {
                                type: "line",
                                data: {
                                    labels: [
                                        "Jan",
                                        "Feb",
                                        "Mar",
                                        "Apr",
                                        "May",
                                        "Jun",
                                        "Jul",
                                        "Aug",
                                        "Sep",
                                        "Oct",
                                        "Nov",
                                        "Dec",
                                    ],
                                    datasets: [
                                        {
                                            data: <?php echo json_encode($finance_chart); ?> , //[20, 40, 70, 80, 120, 140, 50, 65, 30, 55, 100, 70]
                                            fill: false,
                                            backgroundColor: "green",
                                            borderColor: "orange",
                                            pointBackgroundColor: "orange",
                                            pointBorderColor: "orange",
                                            pointHoverBackgroundColor: "orange",
                                            pointHoverBorderColor: "orange",
                                        },
                                    ],
                                },
                                options: {
                                    tooltips: {
                                        callbacks: {
                                            label: function (tooltipItem) {
                                                return Number(tooltipItem.yLabel) + "$";
                                            },
                                        },
                                    },
                                    legend: {
                                        display: false,
                                    },
                                    title: {
                                        display: true,
                                        text: "Finance Chart",
                                        fontSize: 12,
                                        fontColor: "black",
                                        fontFamily: "tahoma",
                                        fontWeight: "bold"
                                    },
                                    scales: {
                                        yAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    fontColor: "black",
                                                    labelString: "Amount (in $)",
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    fontColor: "black",
                                                    stepSize: 50,
                                                    maxTicksLimit: 5,
                                                    callback: function (value, index, values) {
                                                        return value;
                                                    },
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                        xAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: "Months",
                                                    fontColor: "black",
                                                },
                                                ticks: {
                                                    fontColor: "black",
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                    },
                                },
                            });

                        </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_invoice'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                   
                <?php if (!empty($get_menu_permission)) { ?>
                    <?php
                    if ($global_user_privileges['employee']) {
                        // Section - Employee Category
                    ?>  
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div style="background-color:#565d64" class="small-box my-small-box">
                                <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/employeeCategory.js"></script-->
                                <canvas id="elEmployeeChart"></canvas>
                                <script type="text/javascript">
                                    let varEmployeeChart = document
                                    .getElementById("elEmployeeChart")
                                    .getContext("2d");

                                    Chart.defaults.global.defaultFontColor = "white";
                                    Chart.defaults.global.defaultFontSize = 10;
                                    var employeeChart = new Chart(varEmployeeChart, {
                                        type: "pie",
                                        data: {
                                            labels: [
                                                "IT",
                                                "Admin Clerical",
                                                "Professional",
                                                "Light Industrial",
                                                "Engineering",
                                                "Scientific",
                                                "Healthcare",
                                            ],
                                            datasets: [
                                                {
                                                    label: "Employee Category",
                                                    data: <?php echo json_encode($emp_chart); ?>,
                                                    backgroundColor: [
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(54, 162, 235, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                        "rgba(255, 159, 64, 1)",
                                                        "rgb(187,187,187)",
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                    ],
                                                },
                                            ],
                                        },
                                        options: {
                                            legend: {
                                                display: true,
                                                position: "right",
                                                align: "center",
                                                labels: {
                                                    boxWidth: 10,
                                                },
                                            },
                                            title: {
                                                display: true,
                                                text: "Employee Category",
                                                fontFamily: "tahoma",
                                                fontWeight: "bold"
                                            },
                                        },
                                    });

                                </script>
                                
                                <a href="<?php echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if ($global_user_privileges['vendor']) {
                        // Section - Vendor Chart
                        
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div class="small-box my-small-box">
                                <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/vendorChart.js"></script-->
                                <canvas id="VendorChart"></canvas>
                                <script type="text/javascript">
                                    let varVendorChart = document.getElementById("VendorChart").getContext("2d");

                                    var vendorChart = new Chart(varVendorChart, {
                                        type: "bar",
                                        data: {
                                            labels: [
                                                "Jan",
                                                "Feb",
                                                "Mar",
                                                "Apr",
                                                "May",
                                                "Jun",
                                                "Jul",
                                                "Aug",
                                                "Sep",
                                                "Oct",
                                                "Nov",
                                                "Dec",
                                            ],
                                            datasets: [
                                                {
                                                    data: <?php echo json_encode($vendor_chart); ?>, //[4, 30, 20, 35, 23, 12, 22, 43, 34, 33, 29, 30]
                                                    backgroundColor: "blue",
                                                },
                                            ],
                                        },
                                        options: {
                                            legend: {
                                                display: false,
                                            },
                                            title: {
                                                display: true,
                                                text: "Vendor Chart",
                                                fontSize: 12,
                                                fontFamily: "tahoma",
                                                fontWeight: "bold",
                                                fontColor: "black"
                                            },
                                            scales: {
                                                yAxes: [
                                                    {
                                                        scaleLabel: {
                                                            display: false,
                                                            fontColor: "black",
                                                            labelString: "Vendor",
                                                        },
                                                        ticks: {
                                                            beginAtZero: true,
                                                            fontColor: "black",
                                                            stepSize: 10,
                                                            maxTicksLimit: 5,
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, 0)",
                                                        },
                                                    },
                                                ],
                                                xAxes: [
                                                    {
                                                        scaleLabel: {
                                                            display: true,
                                                            labelString: "Months",
                                                            fontColor: "black",
                                                        },
                                                        ticks: {
                                                            fontColor: "black",
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, 0)",
                                                        },
                                                    },
                                                ],
                                            },
                                        },
                                    });

                                </script>
                                <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

                <?php // Section - Hiring Status ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <div id="hiringStatus" style="height: 330px; width: 100%;"></div>

                        <script type="text/javascript">
                        $(document).ready(function() {

                            var chart = new CanvasJS.Chart("hiringStatus", {
                                animationEnabled: true,
                                height: 200,
                                backgroundColor: "transparent",
                                title: {
                                    display: true,
                                    text: "Hiring, <?php echo date('Y'); ?>",
                                    fontFamily: "tahoma",
                                    fontWeight: "bold",
                                    fontSize: 12,
                                },  
                                axisY: {
                                    title: "Number of Open Requisition",
                                    titleFontColor: "#000000",
                                    lineColor: "#E08CEC",
                                    labelFontColor: "#E08CEC",
                                    tickColor: "#E08CEC",
                                    titleFontSize: 10,
                                    margin: 15
                                },
                                axisY2: {
                                    title: "Number of Candidates Applied",
                                    titleFontColor: "#000000",
                                    lineColor: "#92CDFC",
                                    labelFontColor: "#92CDFC",
                                    tickColor: "#92CDFC",
                                    titleFontSize: 10,
                                    margin: 15
                                },
                                toolTip: {
                                    shared: true
                                },
                                legend: {
                                    cursor: "pointer",
                                    itemclick: toggleDataSeries
                                },
                                data: [{
                                    type: "column",
                                    name: "Number of Open Positions",
                                    legendText: "Open Positions",
                                    labelFontSize: 8,
                                    showInLegend: true, 
                                    dataPoints: [
                                        { label: "REQ1", y: 8 },
                                        { label: "REQ2", y: 2 },
                                        { label: "REQ3", y: 1 },
                                        { label: "REQ4", y: 1 },
                                        { label: "REQ5", y: 2 },
                                        { label: "REQ6", y: 1 }
                                    ]
                                },
                                {
                                    type: "column", 
                                    name: "Number of Candidates",
                                    legendText: "Candidates",
                                    labelFontSize: 8,
                                    axisYType: "secondary",
                                    showInLegend: true,
                                    dataPoints: [
                                        { label: "REQ1", y: 20 },
                                        { label: "REQ2", y: 6 },
                                        { label: "REQ3", y: 8 },
                                        { label: "REQ4", y: 9 },
                                        { label: "REQ5", y: 10 },
                                        { label: "REQ6", y: 15 }
                                    ]
                                }]
                            });

                            chart.render();
                        });

                        </script>
                        <a style="background-color:#565d64" href="" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php // Section - Requisition Budget ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <div id="chartContainer"></div>

                        <script type="text/javascript">
                        $(document).ready(function() {

                            var chart2 = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                height: 200,
                                backgroundColor: "transparent",

                                title: {
                                    text: "Requisition Budget",
                                    fontFamily: "tahoma",
                                    fontWeight: "bold",
                                    fontSize: 12
                                },

                                axisY: {
                                    title: "Budget",
                                    valueFormatString: "#,##0.##",
                                    titleFontSize: 10
                                },

                                toolTip: {
                                    shared: true
                                },

                                legend: {
                                    cursor: "pointer",
                                    itemclick: toggleDataSeries
                                },

                                data: [
                                    {
                                        type: "stackedColumn",
                                        name: "Amount used",
                                        legendText: "Amount used",
                                        labelFontSize: 8,
                                        showInLegend: "true",
                                        dataPoints: [
                                            {  y: 30000, label: "REQ1"},
                                            {  y: 40000, label: "REQ2"},
                                            {  y: 20000, label: "REQ3"},
                                            {  y: 8000, label: "REQ4"},
                                            {  y: 5000, label: "REQ5"},
                                            {  y: 15000, label: "REQ6"}
                                        ]
                                    }, {
                                        type: "stackedColumn",
                                        name: "Amount left",
                                        legendText: "Amount left",
                                        showInLegend: "true",
                                        labelFontSize: 8,
                                        indexLabel: "#total",
                                        yValueFormatString: "#,##0.##",
                                        indexLabelPlacement: "outside",
                                        dataPoints: [
                                            {  y: 70000, label: "REQ1"},
                                            {  y: 60000, label: "REQ2"},
                                            {  y: 120000, label: "REQ3"},
                                            {  y: 72000, label: "REQ4"},
                                            {  y: 50000, label: "REQ5"},
                                            {  y: 90000, label: "REQ6"}
                                        ]
                                    }
                                ]
                            });

                            chart2.render();
                        });

                        </script>
                        <a style="background-color:#565d64" href="" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            <?php if (!$is_hiring_manager) { ?>

                <?php // Section - Client Performance ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div  class="small-box my-small-box">
                        <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/charts/clientPerformance.js"></script>
                        <canvas id="clientChart"></canvas>
                        <a style="background-color:#565d64" href="#" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div style="background-color:#565d64; padding:0px;" class="small-box my-small-box">
                        <div class="box-links-container">
                            <?php if ($global_user_privileges['timesheet']) { ?>
                                <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-timesheet'); ?>">TimeSheet</a> 
                            <?php } ?>
                            <?php if ($global_user_privileges['invoice']) { ?>
                                <?php if ($global_user_privileges['consultant']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-consultant-invoice-summery'); ?>">Consultant's Invoice Summary</a> 
                                <?php } ?>
                                <?php if ($global_user_privileges['employee']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-employee-invoice-summery'); ?>">Employee's Invoice Summary</a> 
                                <?php } ?>
                                <?php if ($global_user_privileges['1099 user']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-ten99-invoice-summery'); ?>">1099 User's Invoice Summary</a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            
            <?php } ?>
            <?php if (INDIA || US) { ?>
                <div class="row">
                <?php // Section - Accounts Receivable ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                    <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/accountsRecieveable.js"></script-->
                    <canvas id="accountsChart"></canvas>
                    <script type="text/javascript">
                      let varAccountsChart = document
                            .getElementById("accountsChart")
                            .getContext("2d");

                        var accountsChart = new Chart(varAccountsChart, {
                            type: "doughnut",
                            data: {
                                labels: [
                                    "1-30 days",
                                    "31-60 days",
                                    "61-90 days",
                                    "91-120 days",
                                ],
                                fontColor: "black",
                                datasets: [
                                    {
                                        label: "Accounts Receivable",
                                        data: <?php echo json_encode($account_receivable_chart); ?>, //[120, 50, 30, 110, 30]
                                        backgroundColor: [
                                            "#92ccfc",
                                            "#e08cec",
                                            "#f5a5c8",
                                            "#ffcc5c",
                                        ],
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                legend: {
                                    display: true,
                                    position: "right",
                                    align: "center",
                                    labels: {
                                        fontColor: "black",
                                        boxWidth: 10,
                                    },
                                },
                                title: {
                                    display: true,
                                    text: "Accounts Receivable",
                                    fontColor: "black",
                                },
                            },
                        });
      
                    </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_vendor_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php // Section - Finance Chart ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/financeChart.js"></script-->
                        <canvas id="elFinanceChart"></canvas>
                        <script type="text/javascript">
                            let varFinanceChart = document
                                .getElementById("elFinanceChart")
                                .getContext("2d");

                            var financeChart = new Chart(varFinanceChart, {
                                type: "line",
                                data: {
                                    labels: [
                                        "Jan",
                                        "Feb",
                                        "Mar",
                                        "Apr",
                                        "May",
                                        "Jun",
                                        "Jul",
                                        "Aug",
                                        "Sep",
                                        "Oct",
                                        "Nov",
                                        "Dec",
                                    ],
                                    datasets: [
                                        {
                                            data: <?php echo json_encode($finance_chart); ?> , //[20, 40, 70, 80, 120, 140, 50, 65, 30, 55, 100, 70]
                                            fill: false,
                                            backgroundColor: "green",
                                            borderColor: "orange",
                                            pointBackgroundColor: "orange",
                                            pointBorderColor: "orange",
                                            pointHoverBackgroundColor: "orange",
                                            pointHoverBorderColor: "orange",
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    tooltips: {
                                        callbacks: {
                                            label: function (tooltipItem) {
                                                return Number(tooltipItem.yLabel) + "$";
                                            },
                                        },
                                    },
                                    legend: {
                                        display: false,
                                    },
                                    title: {
                                        display: true,
                                        text: "PO utilisation",
                                        fontSize: 12,
                                        fontColor: "black",
                                    },
                                    scales: {
                                        yAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    fontColor: "black",
                                                    labelString: "Amount (in $)",
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    fontColor: "black",
                                                    stepSize: 50,
                                                    maxTicksLimit: 5,
                                                    callback: function (value, index, values) {
                                                        return value;
                                                    },
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                        xAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: "Months",
                                                    fontColor: "black",
                                                },
                                                ticks: {
                                                    fontColor: "black",
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                    },
                                },
                            });

                        </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                   
                <?php if (!empty($get_menu_permission)) { ?>
                    <?php
                    if ($global_user_privileges['employee']) {
                        // Section - Employee Category
                    ?>  
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div style="background-color:#565d64" class="small-box my-small-box">
                            <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/employeeCategory.js"></script-->
                            <canvas id="elEmployeeChart"></canvas>
                                <script type="text/javascript">
                                    let varEmployeeChart = document
                                    .getElementById("elEmployeeChart")
                                    .getContext("2d");

                                    Chart.defaults.global.defaultFontColor = "white";
                                    Chart.defaults.global.defaultFontSize = 10;
                                    var employeeChart = new Chart(varEmployeeChart, {
                                        type: "pie",
                                        data: {
                                            labels: [
                                                "IT",
                                                "Admin Clerical",
                                                "Professional",
                                                "Light Industrial",
                                                "Engineering",
                                                "Scientific",
                                                "Healthcare",
                                            ],
                                            datasets: [
                                                {
                                                    label: "Employee category",
                                                    data: <?php echo json_encode($emp_chart); ?>,
                                                    backgroundColor: [
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(54, 162, 235, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                        "rgba(255, 159, 64, 1)",
                                                        "rgb(187,187,187)",
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                    ],
                                                },
                                            ],
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,  
                                            legend: {
                                                display: true,
                                                position: "right",
                                                align: "center",
                                                labels: {
                                                    boxWidth: 10,
                                                },
                                            },
                                            title: {
                                                display: true,
                                                text: "Employee Category",
                                            },
                                        },
                                    });

                                </script>
                                
                                <a href="<?php echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if ($global_user_privileges['vendor']) {
                        // Section - Vendor Chart
                        
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                           <div class="small-box my-small-box">
                           <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/vendorChart.js"></script-->
                           <canvas id="VendorChart"></canvas>
                           <script type="text/javascript">
                                let varVenderChart = document.getElementById("VendorChart").getContext("2d");

                                var vendorChart = new Chart(varVenderChart, {
                                    type: "bar",
                                    data: {
                                        labels: [
                                            "Jan",
                                            "Feb",
                                            "Mar",
                                            "Apr",
                                            "May",
                                            "Jun",
                                            "Jul",
                                            "Aug",
                                            "Sep",
                                            "Oct",
                                            "Nov",
                                            "Dec",
                                        ],
                                        datasets: [
                                            {
                                                data: <?php echo json_encode($vendor_chart); ?>, //[4, 30, 20, 35, 23, 12, 22, 43, 34, 33, 29, 30]
                                                backgroundColor: "blue",
                                            },
                                        ],
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false, 
                                        legend: {
                                            display: false,
                                        },
                                        title: {
                                            display: true,
                                            text: "Vendor Chart",
                                            fontSize: 12,
                                            fontColor: "black",
                                        },
                                        scales: {
                                            yAxes: [
                                                {
                                                    scaleLabel: {
                                                        display: false,
                                                        fontColor: "black",
                                                        labelString: "Vendor",
                                                    },
                                                    ticks: {
                                                        beginAtZero: true,
                                                        fontColor: "black",
                                                        stepSize: 10,
                                                        maxTicksLimit: 5,
                                                    },
                                                    gridLines: {
                                                        color: "rgba(0, 0, 0, 0)",
                                                    },
                                                },
                                            ],
                                            xAxes: [
                                                {
                                                    scaleLabel: {
                                                        display: true,
                                                        labelString: "Months",
                                                        fontColor: "black",
                                                    },
                                                    ticks: {
                                                        fontColor: "black",
                                                    },
                                                    gridLines: {
                                                        color: "rgba(0, 0, 0, 0)",
                                                    },
                                                },
                                            ],
                                        },
                                    },
                                });

                            </script>
                               <a style="background-color:#565d64" href="<?php echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                           </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php // Section - Client Performance ?>
                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-8">
                    <div  class="small-box my-small-box">
                        <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/charts/clientPerformance.js"></script>
                        <canvas id="clientChart"></canvas>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                        <div style="background-color:#565d64; padding:0px;" class="small-box my-small-box">
                                <div class="box-links-container">
                                    <?php if ($global_user_privileges['timesheet']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-timesheet'); ?>">TimeSheet</a>
                                    <?php } ?>
                                    <?php if ($global_user_privileges['invoice']) { ?>
                                        <?php if ($global_user_privileges['consultant']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-consultant-invoice-summery'); ?>">Consultant's Invoice Summary</a> 
                                        <?php } ?>
                                        <?php if ($global_user_privileges['employee']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-employee-invoice-summery'); ?>">Employee's Invoice Summary</a> 
                                        <?php } ?>
                                        <?php if ($global_user_privileges['1099 user']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-ten99-invoice-summery'); ?>">1099 User's Invoice Summary</a> 
                                         <?php }} ?>
                                </div>   
                            </div>
                    </div>
            </div>
            <?php } ?>
            <?php if (LATAM) { ?>
                <div class="row gx-5">
                <?php // Section - Accounts Receivable ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                    <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/accountsRecieveable.js"></script-->
                    <canvas id="accountsChart"></canvas>
                    <script type="text/javascript">
                      let varAccountsChart = document
                            .getElementById("accountsChart")
                            .getContext("2d");

                        var accountsChart = new Chart(varAccountsChart, {
                            type: "doughnut",
                            data: {
                                labels: [
                                    "1-30 days",
                                    "31-60 days",
                                    "61-90 days",
                                    "91-120 days",
                                ],
                                fontColor: "black",
                                datasets: [
                                    {
                                        label: "Accounts Receivable",
                                        data: <?php echo json_encode($account_receivable_chart); ?>, //[120, 50, 30, 110, 30]
                                        backgroundColor: [
                                            "#92ccfc",
                                            "#e08cec",
                                            "#f5a5c8",
                                            "#ffcc5c",
                                        ],
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    display: true,
                                    position: "right",
                                    align: "center",
                                    labels: {
                                        fontColor: "black",
                                        boxWidth: 10,
                                    },
                                },
                                title: {
                                    display: true,
                                    text: "Accounts Receivable",
                                    fontColor: "black",
                                },
                            },
                        });
      
                    </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_invoice'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php // Section - Finance Chart ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div class="small-box my-small-box">
                        <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/financeChart.js"></script-->
                        <canvas id="elFinanceChart"></canvas>
                        <script type="text/javascript">
                            let varFinanceChart = document
                                .getElementById("elFinanceChart")
                                .getContext("2d");

                            var financeChart = new Chart(varFinanceChart, {
                                type: "line",
                                data: {
                                    labels: [
                                        "Jan",
                                        "Feb",
                                        "Mar",
                                        "Apr",
                                        "May",
                                        "Jun",
                                        "Jul",
                                        "Aug",
                                        "Sep",
                                        "Oct",
                                        "Nov",
                                        "Dec",
                                    ],
                                    datasets: [
                                        {
                                            data: <?php echo json_encode($finance_chart); ?> , //[20, 40, 70, 80, 120, 140, 50, 65, 30, 55, 100, 70]
                                            fill: false,
                                            backgroundColor: "green",
                                            borderColor: "orange",
                                            pointBackgroundColor: "orange",
                                            pointBorderColor: "orange",
                                            pointHoverBackgroundColor: "orange",
                                            pointHoverBorderColor: "orange",
                                        },
                                    ],
                                },
                                options: {
                                    tooltips: {
                                        callbacks: {
                                            label: function (tooltipItem) {
                                                return Number(tooltipItem.yLabel) + "$";
                                            },
                                        },
                                    },
                                    legend: {
                                        display: false,
                                    },
                                    title: {
                                        display: true,
                                        text: "Finance Chart",
                                        fontSize: 12,
                                        fontColor: "black",
                                    },
                                    scales: {
                                        yAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    fontColor: "black",
                                                    labelString: "Amount (in $)",
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    fontColor: "black",
                                                    stepSize: 50,
                                                    maxTicksLimit: 5,
                                                    callback: function (value, index, values) {
                                                        return value;
                                                    },
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                        xAxes: [
                                            {
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: "Months",
                                                    fontColor: "black",
                                                },
                                                ticks: {
                                                    fontColor: "black",
                                                },
                                                gridLines: {
                                                    color: "rgba(0, 0, 0, 0)",
                                                },
                                            },
                                        ],
                                    },
                                },
                            });

                        </script>
                        <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_invoice'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                   
                <?php if (!empty($get_menu_permission)) { ?>
                    <?php
                    if ($global_user_privileges['employee']) {
                        // Section - Employee Category
                    ?>  
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                            <div style="background-color:#565d64" class="small-box my-small-box">
                            <!--script type="text/javascript" defer src="<?php //echo base_url(); ?>assets/js/charts/employeeCategory.js"></script-->
                            <canvas id="elEmployeeChart"></canvas>
                                <script type="text/javascript">
                                    let varEmployeeChart = document
                                    .getElementById("elEmployeeChart")
                                    .getContext("2d");

                                    Chart.defaults.global.defaultFontColor = "white";
                                    Chart.defaults.global.defaultFontSize = 10;
                                    var employeeChart = new Chart(varEmployeeChart, {
                                        type: "pie",
                                        data: {
                                            labels: [
                                                "IT",
                                                "Admin Clerical",
                                                "Professional",
                                                "Light Industrial",
                                                "Engineering",
                                                "Scientific",
                                                "Healthcare",
                                            ],
                                            datasets: [
                                                {
                                                    label: "Employee category",
                                                    data: <?php echo json_encode($emp_chart); ?>,
                                                    backgroundColor: [
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(54, 162, 235, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                        "rgba(255, 159, 64, 1)",
                                                        "rgb(187,187,187)",
                                                        "rgba(255, 99, 132, 1)",
                                                        "rgba(255, 206, 86, 1)",
                                                        "rgba(75, 192, 192, 1)",
                                                        "rgba(153, 102, 255, 1)",
                                                    ],
                                                },
                                            ],
                                        },
                                        options: {
                                            legend: {
                                                display: true,
                                                position: "right",
                                                align: "center",
                                                labels: {
                                                    boxWidth: 10,
                                                },
                                            },
                                            title: {
                                                display: true,
                                                text: "Employee Category",
                                            },
                                        },
                                    });

                                </script>
                                
                                <a href="<?php echo site_url('admin-employee-list'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    if ($global_user_privileges['vendor']) {
                        // Section - Vendor Chart
                        
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                           <div class="small-box my-small-box">
                           <!--script defer type="text/javascript" src="<?php //echo base_url(); ?>assets/js/charts/vendorChart.js"></script-->
                           <canvas id="VendorChart"></canvas>
                           <script type="text/javascript">
                                let varVenderChart = document.getElementById("VendorChart").getContext("2d");

                                var vendorChart = new Chart(varVenderChart, {
                                    type: "bar",
                                    data: {
                                        labels: [
                                            "Jan",
                                            "Feb",
                                            "Mar",
                                            "Apr",
                                            "May",
                                            "Jun",
                                            "Jul",
                                            "Aug",
                                            "Sep",
                                            "Oct",
                                            "Nov",
                                            "Dec",
                                        ],
                                        datasets: [
                                            {
                                                data: <?php echo json_encode($vendor_chart); ?>, //[4, 30, 20, 35, 23, 12, 22, 43, 34, 33, 29, 30]
                                                backgroundColor: "blue",
                                            },
                                        ],
                                    },
                                    options: {
                                        legend: {
                                            display: false,
                                        },
                                        title: {
                                            display: true,
                                            text: "Vendor Chart",
                                            fontSize: 12,
                                            fontColor: "black",
                                        },
                                        scales: {
                                            yAxes: [
                                                {
                                                    scaleLabel: {
                                                        display: false,
                                                        fontColor: "black",
                                                        labelString: "Vendor",
                                                    },
                                                    ticks: {
                                                        beginAtZero: true,
                                                        fontColor: "black",
                                                        stepSize: 10,
                                                        maxTicksLimit: 5,
                                                    },
                                                    gridLines: {
                                                        color: "rgba(0, 0, 0, 0)",
                                                    },
                                                },
                                            ],
                                            xAxes: [
                                                {
                                                    scaleLabel: {
                                                        display: true,
                                                        labelString: "Months",
                                                        fontColor: "black",
                                                    },
                                                    ticks: {
                                                        fontColor: "black",
                                                    },
                                                    gridLines: {
                                                        color: "rgba(0, 0, 0, 0)",
                                                    },
                                                },
                                            ],
                                        },
                                    },
                                });

                            </script>
                               <a style="background-color:#565d64" href="<?php echo site_url('admin_consultant_lists'); ?>" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                           </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php // Section - Client Performance ?>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                    <div  class="small-box my-small-box">
                        <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/charts/clientPerformance.js"></script>
                        <canvas id="clientChart"></canvas>
                        <a style="background-color:#565d64" href="#" class="small-box-footer my-small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-8">
                        <div style="background-color:#565d64; padding:0px;" class="small-box my-small-box">
                                <div class="box-links-container">
                                    <?php if ($global_user_privileges['timesheet']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-timesheet'); ?>">TimeSheet</a> 
                                    <?php } ?>
                                    <?php if ($global_user_privileges['invoice']) { ?>
                                        <?php if ($global_user_privileges['consultant']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-consultant-invoice-summery'); ?>">Consultant's Invoice Summary</a> 
                                        <?php } ?>
                                        <?php if ($global_user_privileges['employee']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-employee-invoice-summery'); ?>">Employee's Invoice Summary</a> 
                                        <?php } ?>
                                        <?php if ($global_user_privileges['1099 user']) { ?>
                                    <a style="background-color:#09274b;" class="box-link" href="<?php echo site_url('admin-ten99-invoice-summery'); ?>">1099 User's Invoice Summary</a>
                                         <?php }} ?>
                                </div>   
                            </div>
                    </div>
            </div>
            <?php } ?>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('admin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('admin/includes/footer');
?>
<!--script>
    $(function() {

        $("#timesheet_form_submit").click(function(e){  // passing down the event 

            var spinner = $('#loader');
            spinner.show();
            $('#ajax_admin_timesheet').hide();

            $.ajax({
               url:'admin/login/load_admin_periodic_timesheet', 
               type: 'POST',
               data: $("#timesheet_form").serialize(),
               success: function(response){
                   $("#ajax_admin_timesheet").html(response);
                   spinner.hide();
                   $('#ajax_admin_timesheet').show();
               },
               error: function(){
               }
            });
        e.preventDefault(); 
        });


        $("#form_submit").click(function(e){  // passing down the event 

            $('#cons_loader').show();
            $('#cons_ajax_data').hide();

            $.ajax({
               url:'admin/login/load_admin_cons_invoice', // 
               type: 'POST',
               data: $("#cons_invoice_form").serialize(),
               success: function(response){
                   $("#cons_ajax_data").html(response);
                   $('#cons_loader').hide();
                   $('#cons_ajax_data').show();
               },
               error: function(){
               }
           });
           e.preventDefault(); 
           });


        $("#emp_form_submit").click(function(e){  // passing down the event 

            $('#emp_loader').show();
            $('#emp_ajax_data').hide();

            $.ajax({
               url:'admin/login/load_admin_emp_invoice', 
               type: 'POST',
               data: $("#emp_invoice_form").serialize(),
               success: function(response){
                   $("#emp_ajax_data").html(response);
                   $('#emp_loader').hide();
                   $('#emp_ajax_data').show();
               },
               error: function(){
               }
           });
           e.preventDefault(); // could also use: return false;
         });

    $("#1099_form_submit").click(function(e){  // passing down the event 

        $('#1099_loader').show();
        $('#1099_ajax_data').hide();

        $.ajax({
           url:'admin/login/load_admin_1099_invoice', 
           type: 'POST',
           data: $("#1099_invoice_form").serialize(),
           success: function(response){
               $("#1099_ajax_data").html(response);
               $('#1099_loader').hide();
               $('#1099_ajax_data').show();
           },
           error: function(){
           }
       });
       e.preventDefault(); // could also use: return false;
     });

    });
</script>
<script>
    $(function () {
        $('#timesheet_tbl').DataTable({
            //scrollY: "300px",
            // scrollX: true,
            // scrollCollapse: true,
//            paging: false,
            "order": [[ 6, "desc" ]]

        });


        $('#van_tbl').DataTable();
        $('#emp_tbl').DataTable();
		$('#ten99_tbl').DataTable();
    });

</script-->
<script>
    function getApprove(val) {
        var invoice_id = val;

        $.post("<?php echo site_url('approve_invoice'); ?>", {invoice_id: invoice_id}, function (data) {
            //alert(data);
            if (data == 1) {
                location.reload();
                $(".err").hide();
                $(".succ").show();
            } else {
                location.reload();
                $(".err").show();
                $(".succ").hide();
            }

        });
    }

    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else {
            e.dataSeries.visible = true;
        }
        e.chart.render();
    }
</script>






