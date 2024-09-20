<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('superadmin/login_model');
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
        $this->load->model('superadmin/manage_admin_model', 'admin_model');
        $this->load->model('superadmin/manage_employee_model', 'employee_model');
		$this->load->model('superadmin/manage_ten99_model', 'ten99_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "dashboard";
            $data['meta_title'] = "SUPER ADMIN DASHBOARD";
            $this->load->view('superadmin/dashboard', $data);
        } else {
            $this->load->view('superadmin/login');
        }
    }

    public function forgot_password() {
        $this->load->view('superadmin/forgot_password');
    }

    public function reset_password() {

        $email_otp = $this->uri->segment(2);
        $get_details = $this->login_model->getDetailsbyOTP($email_otp);

        if (!empty($get_details)) {
            $data['email'] = $get_details[0]['sa_email'];
            $data['email_otp'] = $email_otp;
            $this->load->view('superadmin/reset_password', $data);
        } else {
            $this->session->set_flashdata('error_msg', 'You dont have permission to access reset password page.');
            redirect(base_url());
        }
    }

    public function otp_forgot_password() {
        $this->load->view('superadmin/otp_forgot_password');
    }

    public function valid_login() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error_msg', 'Email and Password is required');
            $this->load->view('superadmin/login');
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            $result = $this->login_model->login($data);
            if ($result == TRUE) {
                $this->after_login_next_steps($this->input->post('email'));
            } else {

                $check_is_delete = $this->login_model->checkIsDelete($data);
                if (!empty($check_is_delete)) {
                    if ($check_is_delete[0]['is_delete'] == '0') {

                        $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                        redirect(base_url());
                    } elseif ($check_is_delete[0]['is_delete'] == '1') {

                        $this->session->set_flashdata('error_msg', 'Your account is temporarily deactivated. Please contact web administrator.');
                        redirect(base_url());
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                    redirect(base_url() . 'index.php');
                }
            }
        }
    }

    public function qr_code() {
        $email = strval($this->uri->segment(2));
        $this->after_login_next_steps($email);
    }

    public function after_login_next_steps($email) {
        $result = $this->login_model->get_superadmin_details($email);
        if ($result != false) {
            $session_data = array(
                'email' => $result[0]->sa_email,
            );

            $this->session->set_userdata('logged_in', $session_data);
            if ($this->input->post('remember_me') == 'on') {
                $this->load->helper('cookie');
                $cookie = $this->input->cookie('ci_session');
                $this->input->set_cookie('ci_session', $cookie, '3600');
            }
            $this->session->set_flashdata('succ_msg', 'Login Successfully...');

            $user_log_arr = array(
                'user_id' => $result[0]->sa_id,
                'user_email_id' => $result[0]->sa_email,
                'user_type' => 'superadmin',
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'user_login_date_time' => date("Y-m-d h:i:s")
            );
            $user_log_query = $this->login_model->add_user_log($user_log_arr);
            if (US || INDIA) {
                go_to_correct_logged_in_url('dashboard');
            }
            if (LATAM) {
                redirect(base_url() . 'dashboard');
            }
        }
    }

    public function valid_forgot_password() {
        $email = $this->input->post('email');

        $check_email = $this->login_model->checkEmail($email);
        $get_details = $this->profile_model->getDetails($email);

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'forgot-password');
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'forgot-password');
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

                $superadmin_name = $get_details[0]['sa_name'];
                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['sa_name']) . ", you or someone else have requested for reset password option. Your Email OTP are as follows : " . $email_otp;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                //$this->email->bcc($superadmin_email);
                $this->email->subject('Forgot Password - Email OTP');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();
				
				
                $this->session->set_flashdata('succ_msg', 'OTP sent successfuly. Please check your email address.');
                redirect(base_url() . 'otp-forgot-password');
            } else {
                $this->session->set_flashdata('error_msg', 'Mail not sent successfuly. Please try again later.');
                redirect(base_url() . 'forgot-password');
            }
        }
    }

    public function valid_otp() {
        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'forgot-password');
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'forgot-password');
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . 'forgot-password');
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'forgot-password');
        } else {
            $reset_link = base_url() . "reset-password/" . $email_otp;
            if ($reset_link != '') {
                $this->session->set_flashdata('succ_msg', 'Enter New Password.');
                redirect(base_url() . "reset-password/" . $email_otp);
            } else {
                $this->session->set_flashdata('error_msg', 'Oops something errors. Please try again later.');
                redirect(base_url() . 'forgot-password');
            }
        }
    }

    public function sa_reset_password() {

        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');
        $n_pwd = $this->input->post('n_pwd');
        $cn_pwd = $this->input->post('cn_pwd');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);


        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'reset-password/' . $email_otp);
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'reset-password/' . $email_otp);
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . 'reset-password/' . $email_otp);
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'reset-password/' . $email_otp);
        } elseif ($n_pwd != $cn_pwd) {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'reset-password/' . $email_otp);
        } else {
            $update_arr = array(
                "sa_password" => md5($n_pwd),
                "forgot_password_otp" => ""
            );

            $update_query = $this->login_model->update_password($update_arr, $email);
            if ($update_query != '0') {
                $superadmin_name = $get_details[0]['sa_name'];
                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['sa_name']) . ", you have reset password successfuly. Please login with your new password.";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Password Reset Successfuly.');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'You have reset password successfuly. Please login with new password.');
                redirect(base_url());
            } else {
                $this->session->set_flashdata('error_msg', 'Password not reset Successfully. please try again later.');
                redirect(base_url() . "reset-password/" . $email_otp);
            }
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_admin_details'] = $this->profile_model->getAdminDetailsCount();
        $data['get_vendor_details'] = $this->profile_model->getVendorDetailsCount();
        $data['get_consultant_details'] = $this->profile_model->getConsultantDetailsCount();
        $data['get_employee_details'] = $this->profile_model->getEmpDetailsCount();
		$data['get_ten99user_details'] = $this->profile_model->getTen99UserDetailsCount();
		
        $data['get_menu_permission'] = $this->profile_model->getMenuPermission($sa_id);

        $data['get_invoice_details'] = $this->profile_model->getInvoiceDetails();
       
        if (US || INDIA) {
            $emp_category_record = $this->login_model->get_emp_category();
            
            foreach ($emp_category_record as $emp_category) {
                
                    $emp_nums[] = $emp_category['temp_category'];
            }

            $emp_nums_per_category = array_count_values($emp_nums);
            

            $emp_chart_data[0] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['it'] : 0;
            $emp_chart_data[1] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['admin_clerical'] : 0;
            $emp_chart_data[2] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['professional'] : 0;
            $emp_chart_data[3] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['light_industrial'] : 0;
            $emp_chart_data[4] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['engineering'] : 0;
            $emp_chart_data[5] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['scientific'] : 0;
            $emp_chart_data[6] =  (!empty($emp_nums_per_category))? $emp_nums_per_category['healthcare'] : 0;
            $data['emp_chart'] = $emp_chart_data;

            $invoice1 = $this->login_model->get_total_invoce_for_chart(0,30);
            $invoice2 = $this->login_model->get_total_invoce_for_chart(31,60);
            $invoice3 = $this->login_model->get_total_invoce_for_chart(61,90);
            $invoice4 = $this->login_model->get_total_invoce_for_chart(91,120);

            $account_receivable[0] = (!empty($invoice1))? $invoice1 : 0;
            $account_receivable[1] = (!empty($invoice2))? $invoice2 : 0;
            $account_receivable[2] = (!empty($invoice3))? $invoice3 : 0;
            $account_receivable[3] = (!empty($invoice4))? $invoice4 : 0;
            
            $data['account_receivable_chart'] = $account_receivable;

            $vendor_chart1 = $this->login_model->get_monthly_consultant_data(1);
            $vendor_chart2 = $this->login_model->get_monthly_consultant_data(2);
            $vendor_chart3 = $this->login_model->get_monthly_consultant_data(3);
            $vendor_chart4 = $this->login_model->get_monthly_consultant_data(4);
            $vendor_chart5 = $this->login_model->get_monthly_consultant_data(5);
            $vendor_chart6 = $this->login_model->get_monthly_consultant_data(6);
            $vendor_chart7 = $this->login_model->get_monthly_consultant_data(7);
            $vendor_chart8 = $this->login_model->get_monthly_consultant_data(8);
            $vendor_chart9 = $this->login_model->get_monthly_consultant_data(9);
            $vendor_chart10 = $this->login_model->get_monthly_consultant_data(10);
            $vendor_chart11 = $this->login_model->get_monthly_consultant_data(11);
            $vendor_chart12 = $this->login_model->get_monthly_consultant_data(12);

            $vendor_chart_data[0] = (!empty($vendor_chart1))? $vendor_chart1 : 0;
            $vendor_chart_data[1] = (!empty($vendor_chart2))? $vendor_chart2 : 0;
            $vendor_chart_data[2] = (!empty($vendor_chart3))? $vendor_chart3 : 0;
            $vendor_chart_data[3] = (!empty($vendor_chart4))? $vendor_chart4 : 0;
            $vendor_chart_data[4] = (!empty($vendor_chart5))? $vendor_chart5 : 0;
            $vendor_chart_data[5] = (!empty($vendor_chart6))? $vendor_chart6 : 0;
            $vendor_chart_data[6] = (!empty($vendor_chart7))? $vendor_chart7 : 0;
            $vendor_chart_data[7] = (!empty($vendor_chart8))? $vendor_chart8 : 0;
            $vendor_chart_data[8] = (!empty($vendor_chart9))? $vendor_chart9 : 0;
            $vendor_chart_data[9] = (!empty($vendor_chart10))? $vendor_chart10 : 0;
            $vendor_chart_data[10] = (!empty($vendor_chart11))? $vendor_chart11 : 0;
            $vendor_chart_data[11] = (!empty($vendor_chart12))? $vendor_chart12 : 0;
                            
            $data['vendor_chart'] = $vendor_chart_data;

            $finance1 = $this->login_model->get_monthly_finance_data(1);
            $finance2 = $this->login_model->get_monthly_finance_data(2);
            $finance3 = $this->login_model->get_monthly_finance_data(3);
            $finance4 = $this->login_model->get_monthly_finance_data(4);
            $finance5 = $this->login_model->get_monthly_finance_data(5);
            $finance6 = $this->login_model->get_monthly_finance_data(6);
            $finance7 = $this->login_model->get_monthly_finance_data(7);
            $finance8 = $this->login_model->get_monthly_finance_data(8);
            $finance9 = $this->login_model->get_monthly_finance_data(9);
            $finance10 = $this->login_model->get_monthly_finance_data(10);
            $finance11 = $this->login_model->get_monthly_finance_data(11);
            $finance12 = $this->login_model->get_monthly_finance_data(12);

            $finance_chart_data[0] = (!empty($finance1))? $finance1 : 0;
            $finance_chart_data[1] = (!empty($finance2))? $finance2 : 0;
            $finance_chart_data[2] = (!empty($finance3))? $finance3 : 0;
            $finance_chart_data[3] = (!empty($finance4))? $finance4 : 0;
            $finance_chart_data[4] = (!empty($finance5))? $finance5 : 0;
            $finance_chart_data[5] = (!empty($finance6))? $finance6 : 0;
            $finance_chart_data[6] = (!empty($finance7))? $finance7 : 0;
            $finance_chart_data[7] = (!empty($finance8))? $finance8 : 0;
            $finance_chart_data[8] = (!empty($finance9))? $finance9 : 0;
            $finance_chart_data[9] = (!empty($finance10))? $finance10 : 0;
            $finance_chart_data[10] = (!empty($finance11))? $finance11 : 0;
            $finance_chart_data[11] = (!empty($finance12))? $finance12 : 0;

            $data['finance_chart'] = $finance_chart_data;
        }

        $data['page'] = "dashboard";
        $data['meta_title'] = "SUPER ADMIN DASHBOARD";
        $data['super_admin_email']=$email;
        $this->load->view('superadmin/dashboard', $data);
    }

    public function load_periodic_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $employee_type = $this->input->post('user_type');
        $timesheet_status = $this->input->post('ts_Status');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        $db_from_date_range[] = get_db_date_range($db_from_date);
        $db_to_date_range[] = get_db_date_range($db_to_date, false);

         
        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            //$data['timesheet_status'] = $timesheet_status;
            if ($employee_type == "C") {

                $get_employee_details = $this->employee_model->getEmployeeLists();
                //$con_str = implode(",", $get_employee_details );
                $ncon_str = "";
                $con_str = "";
                foreach ($get_employee_details as $cval) {
                    $ncon_str .= $cval['employee_id'] . ",";
                }
                $con_str = rtrim($ncon_str, ",");

                $data['get_timesheet_details'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $con_str, $timesheet_status);
                
                // echo "<pre>";
                // print_r($data['get_timesheet_details']);
                $this->load->view('superadmin/ajax/ajax_timesheet_table', $data);

            } else if ($employee_type == "E") {

                $get_employee_details = $this->employee_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ",");

                $data['get_timesheet_details'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);
                // echo "<pre>";
                // print_r($data['get_timesheet_details']);
                $this->load->view('superadmin/ajax/ajax_timesheet_table', $data);
            } else if ($employee_type == "1099") {

                $get_employee_details = $this->ten99_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ","); 
                
                $data['get_timesheet_details'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);

                // echo "<pre>";
                // print_r($data['get_timesheet_details']);
                $this->load->view('superadmin/ajax/ajax_timesheet_table', $data);
            }
        }

    }

    public function load_cons_invoice() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            //if ($user_id == "") {

                $sa_emp_str = "0,";
                $emp_str = "0,";
                $get_emp_arr = $this->employee_model->getEmpIDs();
                if (!empty($get_emp_arr)) {
                    foreach ($get_emp_arr as $empval) {
                        $sa_emp_str .= $empval['employee_id'] . ",";
                    }
                }
                $emp_str = rtrim($sa_emp_str, ",");

            // } else {
            //     $emp_str = $user_id;
            // }


            $data['get_invoice_details'] = $this->employee_model->getConsPeriodicInvoice($db_from_date, $db_to_date, $emp_str); 
            // echo "<pre>" ; 
            // print_r($data['get_invoice_details']);
            $this->load->view('superadmin/ajax/ajax_cons_invoice', $data);
            
        }
        
    }

    public function load_emp_invoice() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            $sa_emp_str = "0,";
            $emp_str = "0,";
            $get_emp_arr = $this->employee_model->getEmpIDs();
            if (!empty($get_emp_arr)) {
                foreach ($get_emp_arr as $empval) {
                    $sa_emp_str .= $empval['employee_id'] . ",";
                }
            }
            $emp_str = rtrim($sa_emp_str, ",");

            $data['get_emp_invoice_details'] = $this->employee_model->getEmpPeriodicInvoice($db_from_date, $db_to_date, $emp_str); 
            $this->load->view('superadmin/ajax/ajax_emp_invoice', $data);
            // echo "<pre>";
            // print_r($data['get_emp_invoice_details']);
        }
    }

    public function load_1099_invoice() {

       if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            $sa_ten99_str = "0,";
            $ten99_str = "0,";
            $get_ten99_arr = $this->ten99_model->getTen99UserIDs();
            if(!empty($get_ten99_arr)){
                foreach($get_ten99_arr as $ten99val){
                    $sa_ten99_str .= $ten99val['employee_id'] . ",";
                }
            }
            $ten99_str = rtrim($sa_ten99_str, ",");
            
            $data['get_ten99_invoice_details'] = $this->employee_model->getEmpPeriodicInvoice($db_from_date, $db_to_date, $ten99_str);            
            $this->load->view('superadmin/ajax/ajax_1099_invoice', $data);
            // echo "<pre>";
            // print_r($data['get_emp_invoice_details']);
        }
    }

    public function logout() {
        $this->login_model->chat_logout();
        $sess_array = array(
            'email' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
//        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function admin_permission() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_admin_details'] = $this->admin_model->getAdminLists();

        $data['page'] = "permission";
        $data['meta_title'] = "ADMIN MENU PERMISSION";

        $this->load->view('superadmin/admin_permission', $data);
    }

    public function edit_admin_permission() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = base64_decode($this->uri->segment(2));

        $data['get_menu'] = $this->menu_model->getMenu('admin');
        $data['get_permission_details'] = $this->menu_model->getAdminPermissionDetails($admin_id);
        $data['get_admin_details'] = $this->admin_model->getAdminData($admin_id);

        $data['page'] = "permission";
        $data['meta_title'] = "EDIT ADMIN MENU PERMISSION";

        $this->load->view('superadmin/edit_admin_permission', $data);
    }

    public function insert_admin_menu() {

        $errors = array();
        $admin_name = $this->input->post('admin_name');
        $admin_id = $this->input->post('admin_id');
        $is_view = $this->input->post('is_view');

        if (!empty($is_view)) {
            $delete_prev_permission = $this->menu_model->deletePrevPermission($admin_id);
            foreach ($is_view as $vval) {
                $per_arr = explode("_", $vval);

                $menu_id = $per_arr[0];
                $is_view = $per_arr[1];

                $insert_arr = array(
                    "admin_id" => $admin_id,
                    "menu_id" => $menu_id,
                    "is_view" => $is_view,
                    "entry_date" => date("Y-m-d")
                );
                $insert_query = $this->menu_model->add_admin_menu_permission($insert_arr);
                if ($insert_query != '') {
                    $errors [] = "1";
                } else {
                    $errors [] = "";
                }
            }
            $msg = "Menu Permission for " . ucwords($admin_name) . " is Updated Successfully";
            if (!empty($errors)) {
                $this->session->set_flashdata('succ_msg', $msg);
                redirect(base_url() . 'admin-menu-permission');
            } else {
                $this->session->set_flashdata('err_msg', $msg);
                redirect(base_url() . 'admin-menu-permission');
            }
        }
    }

    public function superadmin_permission() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_superadmin_details'] = $this->profile_model->getSaLists($sa_id);

        $data['page'] = "permission";
        $data['meta_title'] = "SUPERADMIN MENU PERMISSION";

        $this->load->view('superadmin/superadmin_permission', $data);
    }

    public function edit_superadmin_permission() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = base64_decode($this->uri->segment(2));

        $data['get_menu'] = $this->menu_model->getMenu('superadmin');
        $data['get_permission_details'] = $this->menu_model->getSuperAdminPermissionDetails($sa_id);
        $data['get_superadmin_details'] = $this->profile_model->getDetailsByID($sa_id);

        $data['page'] = "permission";
        $data['meta_title'] = "EDIT SUPERADMIN MENU PERMISSION";

        $this->load->view('superadmin/edit_superadmin_permission', $data);
    }

    public function insert_superadmin_menu() {

        $errors = array();
        $sa_name = $this->input->post('sa_name');
        $sa_id = $this->input->post('sa_id');
        $is_view = $this->input->post('is_view');
        if (!empty($is_view)) {
            $delete_prev_permission = $this->menu_model->deleteSAPrevPermission($sa_id);
            foreach ($is_view as $vval) {
                $per_arr = explode("_", $vval);

                $menu_id = $per_arr[0];
                $is_view = $per_arr[1];

                $insert_arr = array(
                    "sa_id" => $sa_id,
                    "menu_id" => $menu_id,
                    "is_view" => $is_view,
                    "entry_date" => date("Y-m-d")
                );
                $insert_query = $this->menu_model->add_superadmin_menu_permission($insert_arr);
                if ($insert_query != '') {
                    $errors [] = "1";
                } else {
                    $errors [] = "";
                }
            }
            $msg = "Menu Permission for " . ucwords($sa_name) . " updated successfully";
            if (!empty($errors)) {
                $this->session->set_flashdata('succ_msg', $msg);
                redirect(base_url() . 'menu-permission');
            } else {
                $this->session->set_flashdata('succ_msg', $msg);
                redirect(base_url() . 'menu-permission');
            }
        }
    }

    public function notifications() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_ids = "";
		$vendor_ids = "";
        $e_ids = "";
		$v_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeLists(); //retrieves only the employees with type='C' i.e., the consultants
		$get_vendor_details = $this->employee_model->getVendorLists();
        if (!empty($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $employee_ids .= $eval['employee_id'] . ",";
            }
        }
        $e_ids = rtrim($employee_ids, ",");

		if (!empty($get_vendor_details)) {
            foreach ($get_vendor_details as $vval) {
                $vendor_ids .= $vval['vendor_id'] . ",";
            }
        }
        $v_ids = rtrim($vendor_ids, ",");
		
        $notifications_arr = array();

        $data['get_consultant_files_details'] = $this->communication_model->getConsultantFileDetails($e_ids);
		$data['get_vendor_files_details'] = $this->communication_model->getVendorFileDetails($v_ids);
		
        $update_arr = array(
            'is_superadmin_view' => '1'
        );

        $update_timesheet_query = $this->communication_model->update_files($update_arr);
		$update_sadminview_query = $this->communication_model->update_vendorfiles($update_arr);
		
        $data['page'] = "notification";
        $data['meta_title'] = "NOTIFICATIONS";

        $this->load->view('superadmin/notifications', $data);
    }

    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
//        $data['page'] = "dashboard";
        $data['meta_title'] = "CHANGE PASSWORD";
        $this->load->view('superadmin/change_password', $data);
    }

    public function update_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //print_r($data);
//        die;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $conf_new_password = $this->input->post('conf_password');

        if (isset($old_password) && $old_password == '') {
            $this->session->set_flashdata('error_msg', 'Current Password field cannot be blank');
            redirect(base_url() . 'change-password');
        } else if (isset($new_password) && $new_password == '') {
            $this->session->set_flashdata('error_msg', 'New Password field cannot be blank');
            redirect(base_url() . 'change-password');
        } else if (isset($conf_new_password) && $conf_new_password == '') {
            $this->session->set_flashdata('error_msg', 'Confirm Password field cannot be blank');
            redirect(base_url() . 'change-password');
        } else if ($conf_new_password != $new_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm New Password field mismatched');
            redirect(base_url() . 'change-password');
        }

        $check_old_password = $this->login_model->checkOldPassword($email, $old_password);
        if ($check_old_password == '') {
            $this->session->set_flashdata('error_msg', 'Wrong Old Password. Please Try Again');
            redirect(base_url() . 'change-password');
        } else {
            $update_arr = array(
                "sa_password" => md5($new_password)
            );
            $update_query = $this->login_model->update_password($update_arr, $email);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Password Updated Successfully');
                redirect(base_url() . 'dashboard');
            } else {
                $this->session->set_flashdata('succ_msg', 'Password Updated Successfully');
                redirect(base_url() . 'dashboard');
            }
        }
    }

    public function view_period_timesheet() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $this->load->view('superadmin/view_period_timesheet', $data);
    }

    public function load_sadmin_timesheet_page() {

        if (US || INDIA) {
            if (!$this->session->userdata('logged_in')) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "sadmin_timesheet_page";
            $data['meta_title'] = "Timesheet";
            $this->load->view('superadmin/sadmin_timesheet_page', $data);
        }
    }

    public function load_sadmin_cons_invoice_summery_page() {

        if (US || INDIA) {
            if (!$this->session->userdata('logged_in')) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "sadmin_cons_invoice_summery_page";
            $data['meta_title'] = "Consultant Invoice Summery";
            $this->load->view('superadmin/sadmin_cons_invoice_summery_page', $data);
        }
    }

    public function load_sadmin_emp_invoice_summery_page() {

        if (US || INDIA) {
            if (!$this->session->userdata('logged_in')) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "sadmin_emp_invoice_summery_page";
            $data['meta_title'] = "Employee Invoice Summery";
            $this->load->view('superadmin/sadmin_emp_invoice_summery_page', $data);
        }
    }

    public function load_sadmin_ten99_invoice_summery_page() {

        if (US || INDIA) {
            if (!$this->session->userdata('logged_in')) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "sadmin_ten99_invoice_summery_page";
            $data['meta_title'] = "Ten99 Invoice Summery";
            $this->load->view('superadmin/sadmin_ten99_invoice_summery_page', $data);
        }
    }
}
