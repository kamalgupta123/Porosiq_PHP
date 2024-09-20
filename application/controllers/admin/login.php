<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('admin/login_model');
        $this->load->model('admin/profile_model');
        $this->load->model('admin/manage_communication_model', 'communication_model');
        $this->load->model('admin/manage_employee_model', 'employee_model');
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        // $this->load->model('admin/manage_ten99user_model', 'ten99user_model');
    }

    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['page'] = "dashboard";
            $data['meta_title'] = "ADMIN DASHBOARD";
            $this->load->view('admin/dashboard', $data);
        } else {
            $this->load->view('admin/login');
        }
    }

    public function valid_login() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error_msg', 'Email and Password is required');
            redirect(base_url() . 'admin');
        } else {
//
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
           // print_r($data);
           // die;

            $result = $this->login_model->login($data);
            if ($result == TRUE) {
                $this->after_login_next_steps($this->input->post('email'));
            } else {
                $check_is_delete = $this->login_model->checkIsDelete($data);
                //print_r($check_is_delete);
                if (!empty($check_is_delete)) {
                    if ($check_is_delete[0]['is_delete'] == '0') {

                        $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                        redirect(base_url() . 'admin');
                    } elseif ($check_is_delete[0]['is_delete'] == '1') {

                        $this->session->set_flashdata('error_msg', 'Your account is temporarily deactivated. Please contact with web administrator.');
                        redirect(base_url() . 'admin');
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong Email or Password');
                    redirect(base_url() . 'admin');
                }
            }
        }
    }

    public function qr_code() {
        $email = strval($this->uri->segment(2));
        $this->after_login_next_steps($email);
    }

    public function after_login_next_steps($email) {
        $result = $this->login_model->get_admin_details($email);
        if ($result != false) {
            if (LATAM) {
                $session_data = array(
                    'email' => $result[0]->admin_email,
                );
            }
            if (US || INDIA) {
                $session_data = array(
                    'email' => $result[0]->admin_email,
                    'admin_type_id' => $result[0]->admin_type_id,
                );
            }

            // Add user data in session
            $this->session->set_userdata('admin_logged_in', $session_data);
            if ($this->input->post('remember_me') == 'on') {
                $this->load->helper('cookie');
                $cookie = $this->input->cookie('ci_session');
                $this->input->set_cookie('ci_session', $cookie, '3600');
            }
            $this->session->set_flashdata('succ_msg', 'Login Successfully...');

            // redirect(base_url() . 'dashboard');
            if ($result[0]->change_password == '0') {
                redirect(base_url() . 'change_password');
            } else {

                $user_log_arr = array(
                    'user_id' => $result[0]->admin_id,
                    'user_email_id' => $result[0]->admin_email,
                    'user_type' => 'admin',
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'user_login_date_time' => date("Y-m-d h:i:s")
                );
                $user_log_query = $this->login_model->add_user_log($user_log_arr);
                go_to_correct_logged_in_url('admin_dashboard');
            }
        }
    }

    public function admin_okta_login(){
        
        if (DEMO) {
            if (USE_SSO_OKTA) {
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
                
                $_SESSION['state'] = rand(100000, 9999999);
                
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
    
            } else {
                echo "Okta Login has been disabled. Try manual login from login page.";
            }
        }
        if (US || INDIA) {
            // Begin the PHP session so we have a place to store the username
            session_start();
                    
            function http($url, $params=false) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if($params)
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            return json_decode(curl_exec($ch));
            } 

            $client_id = '0oa1jy8p3x5zDItYy4x7';
            $client_secret = 'BngFOpy5l0ahAu5SEUxhh6ceeSpZc1hbNlNFpYqX';
            $redirect_uri = 'https://porosiq.com/admin_okta_login';

            $metadata = http('https://ptscservices.okta.com/oauth2/default/.well-known/oauth-authorization-server');

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
                $headers = [
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: SSWS 00FBPm-L6EooE4dl3TRYNWL3NhMpTctL16cywmOUWm'
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                curl_setopt($ch, CURLOPT_URL,"https://ptscservices.okta.com/api/v1/users/$token->username");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $res=curl_exec($ch);
                
                curl_close($ch);
                $data=json_decode($res,true);
                // echo "<pre>";
                // print_r($token);
                // print_r($token->username);
                // print_r($data);
                $session_data = array(
                    'email' => $data['profile']['email'],
                );
                // print_r($session_data);
                // exit();
            
                $this->session->set_userdata('admin_logged_in', $session_data);

                header('Location: https://porosiq.com/admin_dashboard');
                die();
            }
            }

            // If there is a username, they are logged in, and we'll show the logged-in view
            if($this->session->userdata('admin_logged_in')) {

                redirect(base_url() . 'admin_dashboard');
            }

            // If there is no username, they are logged out, so show them the login link
            if(!$this->session->userdata('admin_logged_in')) {

            $_SESSION['state'] = rand(100000,9999999);

            $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
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
        if (LATAM) {
            // Begin the PHP session so we have a place to store the username
            session_start();
            
            function http($url, $params=false) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if($params)
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            return json_decode(curl_exec($ch));
            } 
            
            $client_id = SSO_OKTA_CLIENT_ID;
            $client_secret = SSO_OKTA_CLIENT_SECRET;
            $redirect_uri =  '' . base_url() . 'admin_okta_login';

            $metadata = http('https://ptscservices.okta.com/oauth2/default/.well-known/oauth-authorization-server');

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
                        'Authorization: SSWS '.SSO_OKTA_TOKEN
                    ]; 

                    // curl for user email Id (primary Email)
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_URL, "https://ptscservices.okta.com/api/v1/users/$token->username");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $res = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($res, true);

                    // curl for user group info
                    /*$gr = curl_init();
                    curl_setopt($gr, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($gr, CURLOPT_URL, "https://ptscservices.okta.com/api/v1/users/$token->username/groups");
                    curl_setopt($gr, CURLOPT_RETURNTRANSFER, 1);
                    $res_gr = curl_exec($gr);
                    curl_close($gr);
                    $gr_data = json_decode($res_gr, true);*/
                    
                    
                    $session_data = array(
                        'email' => $data['profile']['email'],
                    );

                    $this->session->set_userdata('admin_logged_in', $session_data);
                    redirect(base_url() . 'admin_dashboard');

                    /*if (($gr_data[3]['id'] == $OKTA_CLIENT_GROUP_ID) || ($gr_data[7]['id'] == $OKTA_CLIENT_GROUP_ID)) {

                        $this->session->set_userdata('admin_logged_in', $session_data);
                        redirect(base_url() . 'admin_dashboard');

                    } else if ($gr_data[1]['id'] == $OKTA_VENDOR_GROUP_ID) {

                        $this->session->set_userdata('vendor_logged_in', $session_data);
                        redirect(base_url() . 'vendor_dashboard');
                    }*/
                    // fetched the user primary email and stored into session
                
                // header('Location: https://demo.porosiq.com/admin_dashboard');
                die();
            }
            }
            
            // If there is a username, they are logged in, and we'll show the logged-in view
            if($this->session->userdata('admin_logged_in')) {
            
                redirect(base_url() . 'admin_dashboard');
            } 
            /*else if($this->session->userdata('vendor_logged_in')) {
            
                redirect(base_url() . 'vendor_dashboard');
            }*/
            
            // If there is no username, they are logged out, so show them the login link
            if(!$this->session->userdata('admin_logged_in')) {
            
            $_SESSION['state'] = rand(100000, 9999999);
            
            $authorize_url = $metadata->authorization_endpoint . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => $client_id,
                'redirect_uri' => $redirect_uri,
                'state' => $_SESSION['state'],
                'scope' => 'openid',
            ]);
            redirect($authorize_url);
            }
            exit();
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        
        // $get_vendor_details = $this->vendor_model->getAllVendor();
        
        // $data['get_vendor_details'] = $get_vendor_details;

        // $data['get_consulatnt_details'] = $this->profile_model->getConsultantDetailsCount();
        // $data['get_employee_details'] = $this->profile_model->getEmpDetailsCount();
		// $data['get_ten99user_details'] = $this->profile_model->getTen99UserDetailsCount();
        $data['get_menu_permission'] = $this->profile_model->getMenuPermission($admin_id);

        
        $emp_category_record = $this->login_model->get_emp_category();
       
        foreach ($emp_category_record as $emp_category) {
            
            $emp_nums[] .= $emp_category['temp_category'];
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

        $data['page'] = "dashboard";
        $data['meta_title'] = "ADMIN DASHBOARD";

        $this->load->view('admin/dashboard', $data);
    }

    public function load_admin_periodic_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $admin_id = $this->input->post('admin_id');
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

                $get_employee_details = $this->employee_model->getAllConsList();
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
                $this->load->view('admin/ajax/ajax_admin_timesheet', $data);

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
                $this->load->view('admin/ajax/ajax_admin_timesheet', $data);

            } else if ($employee_type == "1099") {

                $get_employee_details = $this->ten99user_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ","); 
                
                $data['get_timesheet_details'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);

               $this->load->view('admin/ajax/ajax_admin_timesheet', $data);

            }
        }
    }

    public function load_admin_cons_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
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

            $vendor_ids = "";
            $vendor_ids_str = "";

            $get_vendor_details = $this->vendor_model->getAllVendor();
        
            if (!empty($get_vendor_details)) {
                foreach ($get_vendor_details as $v_val) {
                    $vendor_ids .= $v_val['vendor_id'] . ",";
                }
            }
            $vendor_ids_str = rtrim($vendor_ids, ",");

            $data['get_invoice_details'] = $this->profile_model->getAdminConsInvoice($db_from_date, $db_to_date, $vendor_ids_str);
            // echo "<pre>";
            // print_r($data['get_invoice_details']);
            $this->load->view('admin/ajax/ajax_admin_cons_invoice', $data);
        }
    }

    public function load_admin_emp_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $payment_status = $this->input->post('payment_status');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            $admin_emp_str = "0,";
            $emp_str = "0,";
            $get_emp_arr = $this->employee_model->getEmpIDs();
            
            if (!empty($get_emp_arr)) {
                foreach ($get_emp_arr as $empval) {
                    $admin_emp_str .= $empval['employee_id'] . ",";
                }
            }
            $emp_str = rtrim($admin_emp_str, ",");

            $data['get_emp_invoice_details'] = $this->employee_model->getAdminConsInvoice($db_from_date, $db_to_date, $emp_str, $payment_status);
            // echo "<pre>";
            // print_r($data['get_emp_invoice_details']);
            $this->load->view('admin/ajax/ajax_admin_emp_invoice', $data);
        }
    }

    public function load_admin_1099_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
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

            $admin_ten99_str = "0,";
            $ten99_str = "0,";
            $get_ten99_arr = $this->ten99user_model->getTen99UserIDs();
            #$admin_id
            if(!empty($get_ten99_arr)){
                foreach($get_ten99_arr as $ten99val){
                    $admin_ten99_str .= $ten99val['employee_id'] . ",";
                }
            }
            $ten99_str = rtrim($admin_ten99_str, ",");

            $data['get_ten99_invoice_details'] = $this->employee_model->getAdminConsInvoice($db_from_date, $db_to_date, $ten99_str);

            $this->load->view('admin/ajax/ajax_admin_1099_invoice', $data);

        }
    }

    public function change_password() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['page'] = "dashboard";
        $data['meta_title'] = "CHANGE PASSWORD";
        $this->load->view('admin/initial_change_password', $data);
    }

    public function update_password() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //print_r($data);
//        die;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $conf_new_password = $this->input->post('conf_new_password');

        if (isset($old_password) && $old_password == '') {
            $this->session->set_flashdata('error_msg', 'Old Password field cannot be blank');
            redirect(base_url() . 'change_password');
        } else if (isset($new_password) && $new_password == '') {
            $this->session->set_flashdata('error_msg', 'New Password field cannot be blank');
            redirect(base_url() . 'change_password');
        } else if (isset($conf_new_password) && $conf_new_password == '') {
            $this->session->set_flashdata('error_msg', 'Confirm Password field cannot be blank');
            redirect(base_url() . 'change_password');
        } else if ($conf_new_password != $new_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm New Password field mismatched');
            redirect(base_url() . 'change_password');
        }

        $check_old_password = $this->login_model->checkOldPassword($email, $old_password);
        if ($check_old_password == '') {
            $this->session->set_flashdata('error_msg', 'Wrong Old Password. Please Try Again');
            redirect(base_url() . 'change_password');
        } else {
            $update_arr = array(
                "admin_password" => md5($new_password),
                "change_password" => "1"
            );
            $update_query = $this->login_model->update_admin_password($update_arr, $email);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'New Password Generated Successfully..');
                redirect(base_url() . 'admin_dashboard');
            } else {
                $this->session->set_flashdata('error_msg', 'New Password Not Generated Successfully..');
                redirect(base_url() . 'change_password');
            }
        }

//        $this->load->view('admin/initial_change_password', $data);
    }

    public function admin_change_password() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url('admin')); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
//        $data['page'] = "dashboard";
        $data['meta_title'] = "CHANGE PASSWORD";
        $this->load->view('admin/change_password', $data);
    }

    public function admin_update_password() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url('admin')); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //print_r($data);
//        die;

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $conf_new_password = $this->input->post('conf_password');

        if (isset($old_password) && $old_password == '') {
            $this->session->set_flashdata('error_msg', 'Current Password field cannot be blank');
            redirect(base_url() . 'admin-change-password');
        } else if (isset($new_password) && $new_password == '') {
            $this->session->set_flashdata('error_msg', 'New Password field cannot be blank');
            redirect(base_url() . 'admin-change-password');
        } else if (isset($conf_new_password) && $conf_new_password == '') {
            $this->session->set_flashdata('error_msg', 'Confirm Password field cannot be blank');
            redirect(base_url() . 'admin-change-password');
        } else if ($conf_new_password != $new_password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm New Password field mismatched');
            redirect(base_url() . 'admin-change-password');
        }

        $check_old_password = $this->login_model->checkOldPassword($email, $old_password);
        if ($check_old_password == '') {
            $this->session->set_flashdata('error_msg', 'Wrong Old Password. Please Try Again');
            redirect(base_url() . 'admin-change-password');
        } else {
            
            if (LATAM) {
                $headers = [
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: SSWS '.SSO_OKTA_TOKEN
                  ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users?q=$email&limit=1");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $res = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($res, true);
                $okta_user_id = $data[0]['id'];

            }
            $update_arr = array(
                "admin_password" => md5($new_password)
            );
            $update_query = $this->login_model->update_password($update_arr, $email);

            if ($update_query != '0') {
                
                if (LATAM) {
                    /*$headers = [
                  'Accept: application/json',
                  'Content-Type: application/json',
                  'Authorization: SSWS 00csMu_1y4LYS9zFG2PI5ArdDDr_laZgVkNwMvelj8' //API token
                ];*/
                $data_raw = [
                    
                    'oldPassword' => [
                        
                        'value' => $old_password
                    ],

                    'newPassword' => [
                        
                        'value' => $new_password
                    ]
                
            ];
            $data_json = json_encode($data_raw);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, "https://cognatic-admin.okta.com/api/v1/users/$okta_user_id/credentials/change_password");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            curl_close($ch);
            
                }
                $this->session->set_flashdata('succ_msg', 'Password Updated Successfully');
                redirect(base_url() . 'admin-change-password');
            } else {
                $this->session->set_flashdata('succ_msg', 'Password Updated Successfully');
                redirect(base_url() . 'admin-change-password');
            }
        }
    }

    public function logout() {
        $this->login_model->chat_logout();
        $sess_array = array(
            'email' => ''
        );
        $this->session->unset_userdata('admin_logged_in', $sess_array);
        redirect(base_url() . 'admin');
    }

    public function admin_notifications() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        if (INDIA) {
            $notification_id = $this->uri->segment(2);
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $vendor_ids = "";
        $v_ids = "";
        $get_vendor_details = $this->vendor_model->getVendorLists($admin_id);
        if (!empty($get_vendor_details)) {
            foreach ($get_vendor_details as $vval) {
                $vendor_ids .= $vval['vendor_id'] . ",";
            }
        }
        $v_ids = rtrim($vendor_ids, ",");

        $employee_ids = "";
        $e_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeLists($admin_id);
        if (!empty($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $employee_ids .= $eval['employee_id'] . ",";
            }
        }
        $e_ids = rtrim($employee_ids, ",");
        
        $notifications_arr = array();

        $data['get_timesheet_details'] = $this->communication_model->getTimesheetDetails($e_ids);

        $data['get_assigned_details'] = $this->communication_model->getAssignedDetails($e_ids, $v_ids);
        $data['get_invoice_details'] = $this->communication_model->getInvoiceDetails($v_ids);
        $data['get_invoice_notifications_details'] = $this->communication_model->getInvoiceNotificationsDetails($admin_id);
//        echo "<pre>";
//        print_r($data['get_invoice_details']);

        $update_arr = array(
            'is_view' => '1'
        );

        $update_timesheet_query = $this->communication_model->update_timesheet($update_arr);
        $update_assign_query = $this->communication_model->update_assign_details($update_arr);
        $update_invoice_query = $this->communication_model->update_invoice_details($update_arr);
        $update_inv_notifications_query = $this->communication_model->update_inv_notification_details($update_arr);

        if (INDIA) {
            $this->communication_model->update_notification_status($notification_id);
            // exit;
            $data['notification'] = $this->communication_model->getBellNotification($notification_id);

            $data['admin_id'] = $admin_id;

            $data['clock_time_id'] = $data['notification'][0]['clock_time_id'];
        }

        $data['page'] = "notification";
        $data['meta_title'] = "NOTIFICATIONS";

        $this->load->view('admin/admin_notifications', $data);
    }


    public function admin_notifications_new() {

        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }


            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $vendor_ids = "";
            $v_ids = "";
            $get_vendor_details = $this->vendor_model->getVendorLists($admin_id);
            if (!empty($get_vendor_details)) {
                foreach ($get_vendor_details as $vval) {
                    $vendor_ids .= $vval['vendor_id'] . ",";
                }
            }
            $v_ids = rtrim($vendor_ids, ",");

            $employee_ids = "";
            $e_ids = "";
            $get_employee_details = $this->employee_model->getEmployeeLists($admin_id);
            if (!empty($get_employee_details)) {
                foreach ($get_employee_details as $eval) {
                    $employee_ids .= $eval['employee_id'] . ",";
                }
            }
            $e_ids = rtrim($employee_ids, ",");
            
            $notifications_arr = array();

            $data['get_timesheet_details'] = $this->communication_model->getTimesheetDetails($admin_id);

            // $data['get_timesheet_details'] = $this->communication_model->getTimesheetDetails($e_ids);
            $data['get_assigned_details'] = $this->communication_model->getAssignedDetails($admin_id);
            // $data['get_assigned_details'] = $this->communication_model->getAssignedDetails($e_ids, $v_ids);
            $data['get_invoice_details'] = $this->communication_model->getInvoiceDetails();
            $data['get_invoice_notifications_details'] = $this->communication_model->getInvoiceNotificationsDetails($admin_id);
            //        echo "<pre>";
            //        print_r($data['get_invoice_details']);

            $update_arr = array(
                'is_view' => '1'
            );

            $update_timesheet_query = $this->communication_model->update_timesheet($update_arr);
            $update_assign_query = $this->communication_model->update_assign_details($update_arr);
            $update_invoice_query = $this->communication_model->update_invoice_details($update_arr);
            $update_inv_notifications_query = $this->communication_model->update_inv_notification_details($update_arr);

            $data['page'] = "notification";
            $data['meta_title'] = "NOTIFICATIONS";

            $this->load->view('admin/admin_notifications_new', $data);
        }
    }


    
    public function see_all_notifications() {

        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }


            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['all_notification'] = $this->communication_model->getAllNotification($admin_id);

            $data['admin_id'] = $admin_id;

            // print_r($data['all_notification']);
            // exit;
            
            $data['page'] = "all notification";
            $data['meta_title'] = "ALL NOTIFICATIONS";

            $this->load->view('admin/see_all_notifications', $data);
        }
    }




    public function forgot_password() {
        $this->load->view('admin/forgot_password');
    }

    public function valid_forgot_password() {
        $email = $this->input->post('email');

        $check_email = $this->login_model->checkEmail($email);
        $get_details = $this->profile_model->getDetails($email);
		$data['get_details'] = $this->profile_model->getDetails($email);
        // echo "<pre>";
        // print_r($data);
        // // exit;
        // echo "</pre>";
        $admin_id = $data['get_details'][0]['admin_id'];
		

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'admin-forgot-password');
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'admin-forgot-password');
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

                $from_email = SENDER_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']) . ", you or someone else have requested for reset password option. Your Email OTP are as follows : " . $email_otp;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                //echo "$from_email";
                $this->email->to($to_email);
				$this->email->bcc($superadmin_email);
                $this->email->subject('Forgot Password - Email OTP');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();
				
				/* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br> " . ucwords($get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']) . " has initiated request for reset password option .<br> OTP to reset the account is as follows : " . $email_otp; 
                        
                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Reset Password initiated for Admin!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */
                // echo "<pre>";
                // print_r($insert_arr);
                // echo "<br>";
                // print_r($insert_query);
                // exit;
                $this->session->set_flashdata('succ_msg', 'OTP sent successfuly. Please check your email address.');
                redirect(base_url() . 'admin-otp-forgot-password');
            } else {
                $this->session->set_flashdata('error_msg', 'Mail not sent successfuly. Please try again later.');
                redirect(base_url() . 'admin-forgot-password');
            }
        }
    }

    public function otp_forgot_password() {
        $this->load->view('admin/otp_forgot_password');
    }

    public function valid_otp() {
        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);
       // echo "<pre>";
       // print_r($check_email);
       // print_r($check_valid_otp);
       // print_r()
       // die;

        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . "admin-otp-forgot-password");
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . "admin-otp-forgot-password");
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . "admin-otp-forgot-password");
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . "admin-otp-forgot-password");
        } else {
            $reset_link = base_url() . "admin-reset-password/" . $email_otp;
            if ($reset_link != '') {
                $this->session->set_flashdata('succ_msg', 'Enter New Password.');
                redirect(base_url() . "admin-reset-password/" . $email_otp);
            } else {
                $this->session->set_flashdata('error_msg', 'Oops something errors. Please try again later.');
                redirect(base_url() . "admin-otp-forgot-password");
            }
        }
    }

    public function reset_password() {

        $email_otp = $this->uri->segment(2);
        $get_details = $this->login_model->getDetailsbyOTP($email_otp);

        if (!empty($get_details)) {
            $data['email'] = $get_details[0]['admin_email'];
            $data['email_otp'] = $email_otp;
            $this->load->view('admin/reset_password', $data);
        } else {
            $this->session->set_flashdata('error_msg', 'You dont have permission to access reset password page.');
            redirect(base_url('admin'));
        }
    }

    public function admin_reset_password() {

        $email = $this->input->post('email');
        $email_otp = $this->input->post('email_otp');
        $n_pwd = $this->input->post('n_pwd');
        $cn_pwd = $this->input->post('cn_pwd');

        $check_email = $this->login_model->checkEmail($email);
        $check_valid_otp = $this->login_model->checkValidOTP($email, $email_otp);
        $get_details = $this->profile_model->getDetails($email);


        if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'admin-reset-password/' . $email_otp);
        } elseif ($check_email[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find your account details please try another email address.');
            redirect(base_url() . 'admin-reset-password/' . $email_otp);
        } elseif (isset($email_otp) && $email_otp == '') {
            $this->session->set_flashdata('error_msg', 'Email OTP field cannot be blank');
            redirect(base_url() . 'admin-reset-password/' . $email_otp);
        } elseif ($check_valid_otp[0]['cnt'] == '0') {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'admin-reset-password/' . $email_otp);
        } elseif ($n_pwd != $cn_pwd) {
            $this->session->set_flashdata('error_msg', 'Sorry, we cannot find otp details assosiated with your email address, please try another email address.');
            redirect(base_url() . 'admin-reset-password/' . $email_otp);
        } else {
            $update_arr = array(
                "admin_password" => md5($n_pwd),
                "forgot_password_otp" => ""
            );

            $update_query = $this->login_model->update_password($update_arr, $email);
            if ($update_query != '0') {
                $from_email = REPLY_EMAIL;
                $to_email = $email;

                $data['msg'] = "Hi " . ucwords($get_details[0]['name_prefix'] . " " . $get_details[0]['first_name'] . " " . $get_details[0]['last_name']) . ", you have reset password successfuly. Please login with your new password.";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->subject('Password Reset Successfuly.');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'You have reset password successfuly. Please login with new password.');
                redirect(base_url('admin'));
            } else {
                $this->session->set_flashdata('error_msg', 'Password not reset Successfully. Please try again later.');
                redirect(base_url() . "admin-reset-password/" . $email_otp);
            }
        }
    }

    public function admin_view_period_timesheet() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "TIMESHEET LISTS";

        $this->load->view('admin/admin_view_period_timesheet', $data);
    }

    public function admin_view_period_timesheet_view() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "TIMESHEET LISTS";

        $this->load->view('admin/admin_view_period_timesheet_view', $data);
    }

    public function load_admin_timesheet_page() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_timesheet_page";
        $data['meta_title'] = "TIMESHEET";
        $this->load->view('admin/admin_timesheet_page', $data);
    }

    public function load_admin_cons_invoice_summery_page() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_cons_invoice_summery_page";
        $data['meta_title'] = "Consultant Invoice Summery";
        $this->load->view('admin/admin_cons_invoice_summery_page', $data);
    }

    public function load_admin_emp_invoice_summery_page() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_emp_invoice_summery_page";
        $data['meta_title'] = "Employee Invoice Summery";
        $this->load->view('admin/admin_emp_invoice_summery_page', $data);
    }

    public function load_admin_ten99_invoice_summery_page() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_ten99_invoice_summery_page";
        $data['meta_title'] = "Employee Invoice Summery";
        $this->load->view('admin/admin_ten99_invoice_summery_page', $data);
    }
}
