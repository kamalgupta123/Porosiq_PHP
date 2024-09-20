<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ACH FORM</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            img {
                text-align: center;
                width: 24%;
            }

            span {
                display: block;
            }

            .form-control {
                background-color: #fff;
                box-shadow: none;
                border-radius: 0px;
                background-image: none;
                border-color: currentcolor currentcolor #000;
                border-image: none;
                border-style: none none solid;
                border-width: medium medium 1px;
                color: #555;
                display: block;
                font-size: 14px;
                height: 34px;
                line-height: 1.42857;
                padding: 6px 12px;
                width: 100%;
            }

            .image {
                text-align: center;
            }

            .image h4 {
                margin: 65px 0 0;
            }

            .area {
                background-color: #fff;
                background-image: none;
                color: #555;
                display: block;
                font-size: 14px;
                height: 34px;
                line-height: 1.42857;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }

            td {
                border: 1px solid #000;
                width: 50%;
            }

            .text {
                border: medium none;
                outline: medium none;
                padding: 10px;
                width: 100%;
            }

            .container {
                width: 800px;
            }

            .space {
                margin: 30px 0;
            }

            .form-control:focus {
                box-shadow: none;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="image">
                <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

                <h2>ACH Form </h2>
            </div>

            <form id="ach_form"
                  action="<?php echo site_url('add_ach_form'); ?>"
                  method="post" enctype="multipart/form-data">

                <table width="100%" style="border:1px solid black; text-align:center; ">
                    <tr>
                        <td>Name Of The Corporation</td>
                        <td><input type="text" name="name_of_corporation" id="name_of_corporation"
                                   class="text validate[required]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><textarea class="form-control text validate[required]" cols="50" rows="2" name="corporation_address"
                                      id="corporation_address"></textarea></td>
                    </tr>
                    <tr>
                        <td>A/R Point of Contact</td>
                        <td><input type="text" name="point_of_contact" id="point_of_contact" class="text validate[required]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>A/R Telephone Number</td>
                        <td><input type="text" name="telephone_number" id="telephone_number" class="text validate[required]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>A/R Email</td>
                        <td><input type="text" name="email" id="email" class="text validate[required,custom[email]]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>Financial Institution</td>
                        <td><input type="text" name="fin_institution" id="fin_institution" class="text validate[required]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>Account Number</td>
                        <td><input type="text" name="account_no" id="account_no" class="text validate[required]"
                                   /></td>
                    </tr>
                    <tr>
                        <td>Routing Number</td>
                        <td><input type="text" name="routing_no" id="routing_no" class="text validate[required]"
                                   /></td>
                    </tr>
                </table>


                <div class="image">
                    <h4>Accepted by: </h4>
                </div>
                <div class="row space">
                    <div class="col-sm-3">
                        <label class="control-label">Procuretechstaff</label>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"><input type="hidden" class="form-control"></div>
                </div>
                <div class="row space">
                    <div class="col-sm-3">
                        <label class="control-label">Name</label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $admin_name; ?></div>
                    <div class="col-sm-3">
                        <label class="control-label">Name</label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $vendor_name; ?></div>
                </div>
                <div class="row space">
                    <div class="col-sm-3">
                        <label class="control-label"> Designation: </label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $admin_designation; ?></div>
                    <div class="col-sm-3">
                        <label class="control-label">Designation:</label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $vendor_designation; ?></div>
                </div>
                <div class="row space">
                    <div class="col-sm-3">
                        <label class="control-label"> Company Name: </label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $admin_company_name; ?></div>
                    <div class="col-sm-3">
                        <label class="control-label">Company Name</label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;"><?php echo $vendor_company_name; ?></div>
                </div>
                <div class="row space">
                    <div class="col-sm-3">
                        <label class="control-label"> Signature </label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-family: 'Dancing Script', cursive; font-size: 1.7em;">&nbsp;</div>
                    <div class="col-sm-3">
                        <label class="control-label">Signature</label>
                    </div>
                    <div class="col-sm-3"
                         style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;">
                             <?php //echo $vendor_name; ?>
                        <input type="text" name="vendor_signature" id="vendor_signature" class="text validate[required]"
                               style="font-family: 'Dancing Script', cursive; font-size: 1.7em;"/>
                    </div>
                </div>
                <div class="image">
                    <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
                    <span>Tel: 773-304-3630</span>
                    <span>Fax: 773-747-4056</span>
                    <span><a href="#"> www.procuretechstaff.com</a></span>
                </div>
                <br/>

                <div class="col-xs-12 col-sm-12 col-md-12" align="center">
                    <input class="btn btn-success" type="submit" name="submit" value="Submit Form">
                    <a class="btn btn-default" href="<?php echo site_url('all_documents_lists'); ?>" style="text-decoration: none;">Back</a>
                    <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                    <input type="hidden" name="vendor_ip" value="<?php echo $vendor_ip; ?>">
                    <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
                </div>
            </form>

        </div>

        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
              type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
                type="text/javascript" charset="utf-8">
        </script>
        <script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
                type="text/javascript" charset="utf-8">
        </script>
        <script>
            $(document).ready(function () {
                // binds form submission and fields to the validation engine
                $("#ach_form").validationEngine({promptPosition: 'inline'});
            });

        </script>

    </body>
</html>
