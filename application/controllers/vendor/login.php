<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        if (!$this->session->userdata('vendor_logged_in')) {
//            redirect(base_url()); // the user is not logged in, redirect them!
//        }
        $this->load->model('vendor/login_model');
        $this->load->model('vendor/profile_model');
        $this->load->model('vendor/manage_communication_model', 'communication_model');
        $this->load->model('vendor/manage_employee_model', 'employee_model');
        $this->load->model('vendor/manage_vendor_model', 'vendor_model');
    }

    public function index() {
        if ($this->session->userdata('vendor_logged_in')) {
            $sess_arr = $this->session->userdata('vendor_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "dashboard";
            $data['meta_title'] = "VENDOR DASHBOARD";
            $this->load->view('vendor/dashboard', $data);
        } else {
            $this->load->view('vendor/login');
        }
    }

    public function valid_login() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error_msg', 'Email and Password is required');
            redirect(base_url() . 'vendor');
        } else {
//
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            $result = $this->login_model->login($data);
            if ($result == TRUE) {               
                $this->after_login_next_steps($this->input->post('email'));
            } else {
                $check_is_delete = $this->login_model->checkIsDelete($data);
                //print_r($check_is_delete);die;
                if (!empty($check_is_delete)) {
                    if ($check_is_delete[0]['is_delete'] == '0') {

                        $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                        redirect(base_url() . 'vendor');
                    } elseif ($check_is_delete[0]['is_delete'] == '1') {

                        $this->session->set_flashdata('error_msg', 'Your account is temporarily deactivated. Please contact web administrator.');
                        redirect(base_url() . 'vendor');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                    redirect(base_url() . 'vendor');
                }
            }
        }
    }

    public function qr_code() {
        $email = strval($this->uri->segment(2));
        $this->after_login_next_steps($email);
    }

    public function after_login_next_steps($email) {
        $result = $this->login_model->get_vendor_details($email);
        if ($result != false) {
            $session_data = array(
                'email' => $result[0]->vendor_email,
            );
            $this->session->set_userdata('vendor_logged_in', $session_data);
            if ($this->input->post('remember_me') == 'on') {
                $this->load->helper('cookie');
                $cookie = $this->input->cookie('ci_session');
                $this->input->set_cookie('ci_session', $cookie, '3600');
            }
            $this->session->set_flashdata('succ_msg', 'Login Successfully...');

            if ($result[0]->change_password == '0') {
                redirect(base_url() . 'vendor_change_password');
            } else {
                $user_log_arr = array(
                    'user_id' => $result[0]->vendor_id,
                    'user_email_id' => $result[0]->vendor_email,
                    'user_type' => 'vendor',
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'user_login_date_time' => date("Y-m-d h:i:s")
                );
                $user_log_query = $this->login_model->add_user_log($user_log_arr);
                if (LATAM) {
                    redirect(base_url() . 'vendor_dashboard');
                }
                else {
                    go_to_correct_logged_in_url('vendor_dashboard');
                }
            }
        }
    }

    public function vendor_okta_login() {
        if (LATAM) {
            $OKTA_CLIENT_GROUP_ID = "00g1j75liwPOpyjRY4x7";
            $OKTA_VENDOR_GROUP_ID = "00g1ojg8yhXn2amoJ4x7";

            // Begin the PHP session so we have a place to store the username
            session_start();
            
            function http($url, $params=false) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if($params)
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            return json_decode(curl_exec($ch));
            } 
            
            $client_id = '0oa1j6n0qjMmnO7yN4x7';
            $client_secret = 'JDTCmC4kGibwJRkSBaNzCg2yNIVmAWMYU-GdAxjF';
            $redirect_uri = 'https://demo.porosiq.com/admin_okta_login';
            
            $metadata = http('https://cognatic.okta.com/oauth2/default/.well-known/oauth-authorization-server');
            
            if(isset($_GET['code'])) {
            
                if($_SESSION['state'] != $_GET['state']) {
                die('Authorization server returned an invalid state parameter');
            }
            
            $response = http($metadata->token_endpoint, [
                'grant_type' => 'authorization_code',
                'code' => $_GET['code'],
                'redirect_uri' => $redirect_uri,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ]);
            
            $token = http($metadata->introspection_endpoint, [
                'token' => $response->access_token,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ]);
            
            if($token->active == 1) {
                //fetching the user's primary email id
                    $headers = [
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: SSWS 00csMu_1y4LYS9zFG2PI5ArdDDr_laZgVkNwMvelj8'
                    ];
                    // curl for user email Id (primary Email)
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users/$token->username");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $res = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($res, true);

                    // curl for user group info
                    $gr = curl_init();
                    curl_setopt($gr, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($gr, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users/$token->username/groups");
                    curl_setopt($gr, CURLOPT_RETURNTRANSFER, 1);
                    $res_gr = curl_exec($gr);
                    curl_close($gr);
                    $gr_data = json_decode($res_gr, true);

                    // print_r($token);
                    // print_r($token->username);
                    // print_r($data);
                    // print_r($gr_data);

                    $session_data = array(
                        'email' => $data['profile']['email'],
                    );

                    if ($gr_data[1]['id'] == $OKTA_CLIENT_GROUP_ID) {

                        $this->session->set_userdata('admin_logged_in', $session_data);
                        redirect(base_url() . 'admin_dashboard');

                    } else if ($gr_data[1]['id'] == $OKTA_VENDOR_GROUP_ID) {

                        $this->session->set_userdata('vendor_logged_in', $session_data);
                        redirect(base_url() . 'vendor_dashboard');
                    }
                    // fetched the user primary email and stored into session
                
                // header('Location: https://demo.porosiq.com/admin_dashboard');
                die();
            }
            }
            
            // If there is a username, they are logged in, and we'll show the logged-in view
            if($this->session->userdata('admin_logged_in')) {
            
                redirect(base_url() . 'admin_dashboard');
            } 
            else if($this->session->userdata('vendor_logged_in')) {
            
                redirect(base_url() . 'vendor_dashboard');
            }
            
            // If there is no username, they are logged out, so show them the login link
            if(!$this->session->userdata('admin_logged_in')) {
            
            $_SESSION['state'] = rand(100000,9999999);
            
            $authorize_url = $metadata->authorization_endpoint . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => $client_id,
                'redirect_uri' => $redirect_uri,
                'state' => $_SESSION['state'],
                'scope' => 'openid',
            ]);
            redirect($authorize_url);
            // echo '<p>Not logged in</p>';
            // echo '<p><a href="'.$authorize_url.'">Log In</a></p>';
            }
            exit();
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $federal_tax_id = $data['get_details'][0]['federal_tax_id'];

        if ($federal_tax_id == '') {
            redirect(base_url() . 'vendor-update-details');
        }

        $data['get_employees'] = $this->profile_model->getEmployeeDetails($vendor_id);
        $data['get_invoice_details'] = $this->profile_model->getInvoiceDetails($vendor_id);
        $data['get_project_details'] = $this->profile_model->getProjectDetails($vendor_id);

        $data['page'] = "dashboard";
        $data['meta_title'] = "VENDOR DASHBOARD";

        $this->load->view('vendor/dashboard', $data);
    }

    public function change_password() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['page'] = "dashboard";
        $data['meta_title'] = "CHANGE PASSWORD";
        $this->load->view('vendor/initial_change_password', $data);
    }

    public function update_password() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //print_r($data);
//        die;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $conf_new_password = $this->input->post('conf_new_password');

        if (isset($old_password) && $old_password == '') {
            $this->session->set_flashdata('error_msg', 'Old Password field cannot be blank');
            redirect(base_url() . 'vendor_change_password');
        } else if (isset($new_password) && $new_password == '') {
            $this->session->set_flashdata('error_msg', 'New Password field cannot be blank');
            redirect(base_url() . 'vendor_change_password');
        } else if (isset($conf_new_password) && $conf_new_password == '') {
            $this->session->set_flashdata('error_msg', 'Confirm Password field cannot be blank');
            redirect(base_url() . 'vendor_change_password');
        } else if ($conf_new_password != $new_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm New Password field mismatched');
            redirect(base_url() . 'vendor_change_password');
        }

        $check_old_password = $this->login_model->checkOldPassword($email, $old_password);
        if ($check_old_password == '') {
            $this->session->set_flashdata('error_msg', 'Wrong Old Password. Please Try Again');
            redirect(base_url() . 'vendor_change_password');
        } else {
            $update_arr = array(
                "vendor_password" => md5($new_password),
                "change_password" => "1"
            );
            $update_query = $this->login_model->update_vendor_password($update_arr, $email);

            if ($update_query != '0') {
                $this->session->set_flashdata('succ_msg', 'New Password Generated Successfully..');
                redirect(base_url() . 'vendor-update-details');
            } else {
                $this->session->set_flashdata('error_msg', 'New Password Not Generated Successfully..');
                redirect(base_url() . 'vendor_change_password');
            }
        }

//        $this->load->view('admin/initial_change_password', $data);
    }

    public function logout() {
        $this->login_model->chat_logout();
        $sess_array = array(
            'email' => ''
        );
        $this->session->unset_userdata('vendor_logged_in', $sess_array);
        redirect(base_url() . 'vendor');
    }

    public function registration() {
        $this->load->view('vendor/registration');
    }

    public function vendor_valid_registration() {
        $vendor_name = $this->input->post('name');
        $company_id = $this->input->post('company_id');
        $vendor_email = $this->input->post('email');
        $vendor_password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');

        $check_duplicate_email = $this->login_model->checkDuplicate($vendor_email);

        if (isset($vendor_name) && $vendor_name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'registration');
        } else if (isset($vendor_email) && $vendor_email == '') {
            $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
            redirect(base_url() . 'registration');
        } else if (isset($company_id) && $company_id == '') {
            $this->session->set_flashdata('error_msg', 'company ID field cannot be blank');
            redirect(base_url() . 'registration');
        } else if ($check_duplicate_email[0]['cnt'] > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'registration');
        } else if (isset($vendor_password) && $vendor_password == '' && isset($conf_password) && $conf_password == '') {

            $this->session->set_flashdata('error_msg', 'Password fields cannot be blank');
            redirect(base_url() . 'registration');
        } elseif ($conf_password != $vendor_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'registration');
        } else {
            $str = '';
            for ($i = 7; $i > 0; $i--) {
                $str = $str . chr(rand(97, 122));

                /*  The above line concatenates one character at a time for
                  seven iterations within the ASCII range mentioned.
                  So, we get a seven characters random OTP comprising of
                  all small alphabets.
                 */
            }
            $reg_code = strtoupper($str);
            $insert_arr = array(
                'vendor_name' => $vendor_name,
                'company_id' => $company_id,
                'vendor_email' => $vendor_email,
                'vendor_password' => md5($vendor_password),
                'entry_date' => date("Y-m-d h:i:s"),
                'status' => '0',
                'block_status' => '0',
                'reg_code' => $reg_code,
            );

            $insert_query = $this->login_model->addVendor($insert_arr);

            if ($insert_query != '') {

                $from_email = REPLY_EMAIL;
                $to_email = $vendor_email;

                $data['msg'] = " <h3>Hi, " . $vendor_name . " ( " . $company_id . " ) </h3>
                                    <p>Welcome to " . SITE_NAME . ". Your One Time Verification Code are as Follows : </p>
                                    <p><strong>Email OTP :</strong>" . $reg_code . "</p>
                                    <p>
                                        Please Verify Your Registration with One Time Email Verification OTP.
                                    </p>";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Verify Your Registration');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'Registration Successful. Please check your email for verification link.');
                redirect(base_url() . 'vendor_reg_verification');
            } else {
                $this->session->set_flashdata('error_msg', 'Registration not Successful.');
                redirect(base_url() . 'registration');
            }
        }
    }

    public function vendor_reg_verification() {

        $this->load->view('vendor/registration_verification');
    }

    public function vendor_verify() {

        $email_otp = $this->input->post('email_otp');

        if (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'OTP field cannot be blank');
            redirect(base_url() . 'vendor_reg_verification');
        } else {

            $check_otp = $this->login_model->checkOTP($email_otp);

            if ($check_otp[0]['cnt'] == '0') {
                $this->session->set_flashdata('error_msg', 'Wrong OTP. Please check your email for OTP');
                redirect(base_url() . 'vendor_reg_verification');
            } else {
                $update_arr = array(
                    'reg_verification' => '1'
                );
                $change_status = $this->login_model->changeStatus($update_arr, $email_otp);
                if ($change_status > 0) {

                    $get_vendor_details = $this->login_model->getVendorDetails($email_otp);

                    $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                    $vendor_email = $get_vendor_details[0]['vendor_email'];
                    $company_id = $get_vendor_details[0]['company_id'];

                    $from_email = REPLY_EMAIL;
                    $to_email = $get_vendor_details[0]['vendor_email'];

                    $data['msg'] = "<h3>New Vendor Registration</h3>
                            <p>New vendor registration successfully done. New vendor details are as Follows : </p>
                            <p><strong>Vendor Name :</strong>" . $vendor_name . "</p>
                            <p><strong>Vendor Company ID :</strong>" . $company_id . "</p>
                            <p><strong>Vendor Email :</strong> " . $vendor_email . "</p>
                            <p>
                                Please Verify and Activate New Vendor.
                            </p>";

                    //Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($to_email);
                    $this->email->subject('New Vendor Registration');
                    $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                    $this->email->set_mailtype('html');
                    //Send mail
                    $this->email->send();


                    $this->session->set_flashdata('succ_msg', 'Registration Verification Successful. Please Login To Generate New Password.');
                    redirect(base_url() . 'vendor');
                } else {

                    $this->session->set_flashdata('error_msg', 'Registration Verification Not Done Successfully. Please Check Your Email For Right OTP.');
                    redirect(base_url() . 'vendor_reg_verification');
                }
            }
        }
    }

    public function vendor_change_old_password() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $this->load->view('vendor/change_old_password', $data);
    }

    public function vendor_update_old_password() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //print_r($data);
//        die;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $conf_new_password = $this->input->post('conf_new_password');

        if (isset($old_password) && $old_password == '') {
            $this->session->set_flashdata('error_msg', 'Old Password field cannot be blank');
            redirect(base_url() . 'vendor_change_old_password');
        } else if (isset($new_password) && $new_password == '') {
            $this->session->set_flashdata('error_msg', 'New Password field cannot be blank');
            redirect(base_url() . 'vendor_change_old_password');
        } else if (isset($conf_new_password) && $conf_new_password == '') {
            $this->session->set_flashdata('error_msg', 'Confirm Password field cannot be blank');
            redirect(base_url() . 'vendor_change_old_password');
        } else if ($conf_new_password != $new_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm New Password field mismatched');
            redirect(base_url() . 'vendor_change_old_password');
        }

        $check_old_password = $this->login_model->checkOldPassword($email, $old_password);
        if ($check_old_password == '') {
            $this->session->set_flashdata('error_msg', 'Wrong Old Password. Please Try Again');
            redirect(base_url() . 'vendor_change_old_password');
        } else {
            $update_arr = array(
                "vendor_password" => md5($new_password),
                "updated_date" => date("Y-m-d h:i:s")
            );
            $update_query = $this->login_model->update_vendor_password($update_arr, $email);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Password Changed Successfully..');
                redirect(base_url() . 'vendor_change_old_password');
            } else {
                $this->session->set_flashdata('error_msg', 'Password Not Changed Successfully..');
                redirect(base_url() . 'vendor_change_old_password');
            }
        }

//        $this->load->view('admin/initial_change_password', $data);
    }

    public function vendor_notifications() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_ids = "";
        $e_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeListsByVendor($vendor_id);
        if (!empty($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $employee_ids .= $eval['employee_id'] . ",";
            }
        }
        $e_ids = rtrim($employee_ids, ",");

        $notifications_arr = array();

        $data['get_timesheet_details'] = $this->communication_model->getTimesheetDetails($e_ids);
        $data['get_approve_details'] = $this->communication_model->getApproveDetails($vendor_id);
        $data['get_vendor_project_details'] = $this->communication_model->getAssignedVendorProjectDetails($admin_id, $vendor_id);
        $data['get_invoice_notifications_details'] = $this->communication_model->getInvoiceNotificationsDetails($vendor_id);


        $update_arr = array(
            'is_vendor_view' => '1'
        );

        $update_timesheet_query = $this->communication_model->update_timesheet($update_arr);
        $update_approve_query = $this->communication_model->update_approve_details($update_arr);
        $update_vendor_project_query = $this->communication_model->update_vendor_project_details($update_arr);
        $update_inv_notifications_query = $this->communication_model->update_inv_notification_details($update_arr);

        $data['page'] = "notification";
        $data['meta_title'] = "NOTIFICATIONS";

        $this->load->view('vendor/vendor_notifications', $data);
    }

    public function forgot_password() {
        $this->load->view('vendor/forgot_password');
    }

    public function valid_forgot_password() {
        $email = $this->input->post('email');

        $check_email = $this->login_model->checkEmail($email);
        $get_details = $this->profile_model->getDetails($email);
//        echo "<pre>";
//        print_r($check_email);
//        die;

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'vendor-forgot-password');
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'vendor-forgot-password');
        } else {
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet .= "0123456789";
            $max = strlen($codeAlphabet); // edited

            for ($i = 0; $i < 10; $i++) {
                $token .= $codeAlphabet[rand(0, $max - 1)];
            }

            $email_otp = strtoupper($token);

            $update_arr = array(
                "forgot_password_otp" => $email_otp
            );
            $update_query = $this->login_model->update_email_otp($update_arr, $email);
            if ($update_query > 0) {

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']) . ", you or someone else have requested for reset password option. Your Email OTP are as follows : " . $email_otp;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Forgot Password - Email OTP');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'OTP sent successfuly. Please check your email address.');
                redirect(base_url() . 'vendor-otp-forgot-password');
            } else {
                $this->session->set_flashdata('error_msg', 'Mail not sent successfuly. Please try again later.');
                redirect(base_url() . 'vendor-forgot-password');
            }
        }
    }

    public function otp_forgot_password() {
        $this->load->view('vendor/otp_forgot_password');
    }

    public function valid_otp() {
        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);
//        echo "<pre>";
//        print_r($check_email);
//        die;

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'vendor-otp-forgot-password');
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'vendor-otp-forgot-password');
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . 'vendor-otp-forgot-password');
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'vendor-otp-forgot-password');
        } else {
            $reset_link = base_url() . "vendor-reset-password/" . $email_otp;
            if ($reset_link != '') {
                $this->session->set_flashdata('succ_msg', 'Enter New Password.');
                redirect(base_url() . "vendor-reset-password/" . $email_otp);
            } else {
                $this->session->set_flashdata('error_msg', 'Oops something errors. Please try again later.');
                redirect(base_url() . 'vendor-otp-forgot-password');
            }
        }
    }

    public function reset_password() {

        $email_otp = $this->uri->segment(2);
        $get_details = $this->login_model->getDetailsbyOTP($email_otp);

        if (!empty($get_details)) {
            $data['email'] = $get_details[0]['vendor_email'];
            $data['email_otp'] = $email_otp;
            $this->load->view('vendor/reset_password', $data);
        } else {
            $this->session->set_flashdata('error_msg', 'You dont have permission to access reset password page.');
            redirect(base_url('vendor'));
        }
    }

    public function vendor_reset_password() {

        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');
        $n_pwd = $this->input->post('n_pwd');
        $cn_pwd = $this->input->post('cn_pwd');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);


        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'vendor-reset-password/' . $email_otp);
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'vendor-reset-password/' . $email_otp);
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . 'vendor-reset-password/' . $email_otp);
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'vendor-reset-password/' . $email_otp);
        } elseif ($n_pwd != $cn_pwd) {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'vendor-reset-password/' . $email_otp);
        } else {
            $update_arr = array(
                "vendor_password" => md5($n_pwd),
                "forgot_password_otp" => ""
            );

            $update_query = $this->login_model->update_password($update_arr, $email);
            if ($update_query != '0') {
                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']) . ", you have reset password successfuly. Please login with your new password.";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Password Reset Successfuly.');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'You have reset password successfuly. Please login with new password.');
                redirect(base_url('vendor'));
            } else {
                $this->session->set_flashdata('error_msg', 'Password not reset Successfully.please try again later.');
                redirect(base_url() . "vendor-reset-password/" . $email_otp);
            }
        }
    }

    public function vendor_update_details() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_country'] = $this->vendor_model->getCountry();
        $data['page'] = "dashboard";
        $data['meta_title'] = "UPDATE DETAILS";
        $this->load->view('vendor/initial_update_details', $data);
    }

}
