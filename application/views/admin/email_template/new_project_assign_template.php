<!DOCTYPE html>
<html>
    <head>
        <title>New Project Assign Successfuly</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <style type="text/css">
            /* CLIENT-SPECIFIC STYLES */
            body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
            img { -ms-interpolation-mode: bicubic; }

            /* RESET STYLES */
            img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
            table { border-collapse: collapse !important; }
            body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

            /* iOS BLUE LINKS */
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            /* MEDIA QUERIES */
            @media screen and (max-width: 480px) {
                .mobile-hide {
                    display: none !important;
                }
                .mobile-center {
                    text-align: center !important;
                }
            }

            /* ANDROID CENTER FIX */
            div[style*="margin: 16px 0;"] { margin: 0 !important; }

            a.link2 {
                font-size: 16px;
                text-decoration: none;
                color: #ffffff;
            }
        </style>

    </head>
    <body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">

        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" style="background-color: #0D47A1;" bgcolor="#0D47A1">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                        <tr>
                            <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#0D47A1">
                                <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                        <tr>
                                            <td align="center" valign="top" class="mobile-center">
                                                <a href="#" target="_blank">
                                                    <img alt="Logo" src="<?php echo base_url(); ?>assets/images/vms_logo2.png" width="250" height="60"  border="0">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>

                </td>
            </tr>
            <tr>
                <td align="center" height="100%" valign="top" width="100%" style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">

                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                        <tr>
                            <td align="center" valign="top" style="font-size:0;">

                                <div style="display:inline-block; max-width:100%; min-width:240px; vertical-align:top; width:100%;">

                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                        <tr>
                                            <td align="left" valign="top" style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                                <p style="font-weight: 800;"><?php echo ucwords($name_prefix) . " " . ucwords($admin_name) . " has assigned a new employee for the following project. Project details and Employee details are as follows:" ; ?></p>
                                                <p style="font-weight: 300;width: 45%;float: left;font-size: 12px;">
                                                    <label style="font-weight: bold;border-bottom: 1px solid #a1a1a1;">Project Details </label><br/>
                                                    <label style="font-weight: bold;">Project Code : </label><?php echo strtoupper($get_project_details['0']['project_code']); ?><br/>
                                                    <label style="font-weight: bold;">Project Name :  </label><?php echo ucwords($get_project_details['0']['project_name']); ?><br/>
                                                    <label style="font-weight: bold;">Project Start Date : </label><?php echo date("m-d-Y", strtotime($get_project_details['0']['start_date'])); ?><br/>
                                                </p>
                                                <p style="font-weight: 300;width: 55%;float: left;font-size: 12px;">
                                                    <label style="font-weight: bold;border-bottom: 1px solid #a1a1a1;">Employee Details </label><br/>
                                                    <label style="font-weight: bold;">Employee Code : </label><?php echo strtoupper($get_employee_details['0']['employee_code']); ?><br/>
                                                    <label style="font-weight: bold;">Employee Name : </label><?php echo $get_employee_details[0]['name_prefix']. " " .ucwords($get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']); ?><br/>
                                                    <label style="font-weight: bold;">Employee Designation : </label><?php echo $get_employee_details[0]['employee_designation']; ?><br/>
                                                    <label style="font-weight: bold;">Employee Category : </label><?php echo ($get_employee_details[0]['employee_category'] == '1')?"W2":"Subcontractor"; ?><br/>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td align="center" style="padding: 35px; background-color: #1E88E5;" bgcolor="#1E88E5">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                        <tr>
                            <td align="center">
                                <img src="<?php echo base_url(); ?>assets/images/vms_logo2.png" width="124" height="37" style="display: block; border: 0px;"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                                <p style="font-size: 14px; font-weight: 300; line-height: 24px; color: #fff;">
                                    <?php echo OFFICE_ADDRESS; ?><br>
                                    Email : <a href="mailto:<?php echo HELPDESK_EMAIL; ?>"> <?php echo HELPDESK_EMAIL; ?></a><br>
                                    Tel: <a href="tel:<?php echo TELEPHONE; ?>"> <?php echo TELEPHONE; ?></a> Fax: <?php echo FAX; ?> 
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="specbundle">
                                <table width="100%" border="0"
                                       cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td valign='top' width='10' align="right">
                                                <div
                                                    class="contentEditableContainer contentFacebookEditable">
                                                    <div
                                                        class="contentEditable">
                                                        <a target='_blank'
                                                           href="<?php echo FACEBOOK_LINK; ?>"><img
                                                                src="<?php echo base_url(); ?>assets/images/facebook.png"
                                                                width='25'
                                                                height='25'
                                                                alt='facebook icon'
                                                                data-default="placeholder"
                                                                data-max-width="25"
                                                                data-customIcon="true"></a>
                                                    </div>
                                                </div>
                                            </td>

                                            <td valign='top' width='10'>
                                                <div class="contentEditableContainer contentTwitterEditable" style="margin: 0px 0px 0px 2px;">
                                                    <div
                                                        class="contentEditable">
                                                        <a target='_blank'
                                                           href="<?php echo TWITTER_LINK; ?>"><img
                                                                src="<?php echo base_url(); ?>assets/images/twitter.png"
                                                                width='25'
                                                                height='25'
                                                                alt='twitter icon'
                                                                data-default="placeholder"
                                                                data-max-width="25"
                                                                data-customIcon="true"></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>
</html>
