<!-- chat VENDOR-->
<?php 
$_SESSION["user-email-id"] = $this->session->userdata('vendor_logged_in')['email'];
 
    include('chat/chat.php');
?>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<!--<script src="<?php //echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slicknav.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/modernizr.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>


<!-- datepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/datetimepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#menu').slicknav();
    });
</script>
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
            url: "<?php echo site_url('get_vendor_notification_count'); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
                if (data != 'na') {
                    addcount("new", data);
                    setTimeout(get_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('vendor-logout'); ?>";
                }
            }
        });
    }
    ;

    function get_mail_notification() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_vendor_mail_notification'); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
                if (data != 'na') {
                    addmail("new", data);
                    setTimeout(get_mail_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('vendor-logout'); ?>";
                }
            }
        });
    }
    ;



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
            url: "<?php echo site_url('get_vendor_others_notification_count'); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
//                alert(data);
//                return false;
                if (data != 'na') {
                    addotherscount("new", data);
                    setTimeout(get_others_notification, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('vendor-logout'); ?>";
                }
            }
        });
    }

    function get_others_notification_details() {
        $.ajax({

            type: "GET",
            url: "<?php echo site_url('get_vendor_others_notification_details'); ?>",
            async: true,
            cache: false,
            timeout: 50000,
            success: function (data) {
//                alert(data);
//                return false;
                if (data != 'na') {
                    addothersdetails("new", data);
                    setTimeout(get_others_notification_details, 10000);
                } else
                {
                    window.location.href = "<?php echo base_url('vendor-logout'); ?>";
                }
            }
        });
    }

    /*-------------------------All Others Notifications-------------------------*/

    $(document).ready(function () {
        get_notification();
        get_mail_notification();
        get_others_notification();
        get_others_notification_details();
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
<script type="text/javascript">
    $(document).ready(function () {
        var notification_sh = $("#notification_sh").val();
//        alert(notification_sh);
        if(notification_sh == 'show') {
            $('#myModal').modal('show');
        }
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
</body>
</html>
