<!-- chat Admin-->
<?php 
$_SESSION["user-email-id"] = $this->session->userdata('admin_logged_in')['email'];
    // echo $_SESSION["user-email-id"];
 

    include('chat/chat.php');
?>
<!-- jQuery 2.2.3 -->
<!--<script src="<?php //echo base_url();  ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.print.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="--><?php //echo base_url();   ?><!--assets/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>





<script>
    $(function () {

        $('.alert').delay(5000).fadeOut('slow');
    })
    $(document).ready(function () {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
        var profileImage = $('#profileImage').text(intials);
        var profileImage1 = $('#profileImage1').text(intials);
        var profileImage2 = $('#profileImage2').text(intials);
        var profileImage3 = $('#profileImage3').text(intials);
        var profileImage4 = $('#profileImage4').text(intials);
        var profileImage5 = $('#profileImage5').text(intials);
        var profileImage6 = $('#profileImage6').text(intials);
    });

    /*-------------------------Mail Notifications-------------------------*/

    function addcount(type, msg) {
//        alert(msg);
        $('#notification-count').text(msg);
    }

    function addmail(type, msg) {
        //alert(msg);
        $('#notification-latest').html(msg);
    }

    function get_notification() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_admin_notification_count'); ?>",
            async: true,
            cache: false,
            success: function (data) {
                if (data != 'na') {
                    addcount("new", data);
                    setTimeout(get_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('admin-logout'); ?>";
                }
            }
        });
    }

    function get_mail_notification() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_admin_mail_notification'); ?>",
            async: true,
            cache: false,
            success: function (data) {
                if (data != 'na') {
                    addmail("new", data);
                    setTimeout(get_mail_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('admin-logout'); ?>";
                }
            }
        });
    }

    /*-------------------------Mail Notifications-------------------------*/
    /*-------------------------All Others Notifications-------------------------*/

    function addotherscount(type, msg) {
        //alert(msg);
        $('#others-notification-count').text(msg);
    }

    function addothersdetails(type, msg) {
        //alert(msg);
        $('#others-notification-latest').html(msg);
    }

    function get_others_notification() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_admin_others_notification_count'); ?>",
            async: true,
            cache: false,
            success: function (data) {
//                alert(data);
//                return false;
                if (data != 'na') {
                    addotherscount("new", data);
                    setTimeout(get_others_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('admin-logout'); ?>";
                }
            }
        });
    }

    function get_others_notification_details() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_admin_others_notification_details'); ?>",
            async: true,
            cache: false,
            success: function (data) {
//                alert(data);
//                return false;
                if (data != 'na') {
                    addothersdetails("new", data);
                    setTimeout(get_others_notification_details, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('admin-logout'); ?>";
                }
            }
        });
    }

    /*-------------------------All Others Notifications-------------------------*/

    $(document).ready(function () {
        // get_notification();
        // get_mail_notification();
        // get_others_notification();
        // get_others_notification_details();


        $(document).on('click','.approve_notification', function() {

            var clock_time_id = $(this).attr("data-clock-time-id");
            var admin_id = $(this).attr("data-admin-id");
            var notification_id = $(this).attr("data-notification-id");

            $(this).parent().parent().html("<span class='glyphicon glyphicon-refresh glyphicon-loader-animate'></span>");

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('approve_shift_notification'); ?>", 
                    data: {clock_time_id: clock_time_id, admin_id : admin_id, notification_id:notification_id },
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        get_others_notification();
                        get_others_notification_details();
                    }
            });

        });

        $(document).on('click','.disapprove_notification', function() {

            var clock_time_id = $(this).attr("data-clock-time-id");
            var admin_id = $(this).attr("data-admin-id");
            var notification_id = $(this).attr("data-notification-id");

            $(this).parent().parent().html("<span class='glyphicon glyphicon-refresh glyphicon-loader-animate'></span>");

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('disapprove_shift_notification'); ?>", 
                    data: {clock_time_id: clock_time_id, admin_id : admin_id, notification_id:notification_id},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        get_others_notification();
                        get_others_notification_details();
                    }
            });

        });
    });
</script>
<script type="text/javascript">
    $('select').select2();
</script>

<script src="<?php echo base_url(); ?>assets/js/fancybox/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
<script src="<?php echo base_url(); ?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox({
            autoSize : false,
            width: '80%',
            height: 1024,
            type: 'iframe'
        });
    });
</script>
<!--script type="text/javascript">
    var $zoho = $zoho || {};
    $zoho.salesiq = $zoho.salesiq || {widgetcode: "e5e3ac71d9190edc2b394dac001fcd1c4773b26b48f429e035732afd8b3deb1b44bad168f7c211b73a19ecb1c8e813ec", values: {}, ready: function () {}};
    var d = document;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.id = "zsiqscript";
    s.defer = true;
    s.src = "https://salesiq.zoho.com/widget";
    t = d.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(s, t);
    d.write("<div id='zsiqwidget'></div>");
</script-->
<!-- <?php

    if ($this->session->userdata('admin_logged_in')) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $chat_link = ($email == "swaraj.r@ptscservices.com")? "http://projecttrial.procuretech.net/chat-dev/admin/chat.php" : "http://projecttrial.procuretech.net/chat-dev/user.php";
        } 
     ?>
    <a target="_blank" href="<?php echo $chat_link; ?>">
    <img style="position: fixed; right: 15px; bottom: 15px;" src="<?php echo base_url(); ?>assets/images/chat.png"/>
    </a> -->
</body>
</html>