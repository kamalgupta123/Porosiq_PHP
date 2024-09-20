<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            if (US || INDIA) {
            set_referer_url();
            }
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $this->load->model('superadmin/manage_admin_model', 'admin_model');
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
    }

    public function index() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_lists";
        $data['meta_title'] = "ADD ADMIN USER";

        $this->load->view('superadmin/add_admin_user', $data);
    }

    public function add_admin() {
        $db = get_instance()->db->conn_id;

        $recipients = array();

        $sa_id = $this->input->post('sa_id');
        // $is_hiring_manager = $this->input->post('hiring_manager');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('fname');
        $last_name = $this->input->post('lname');
        $admin_designation = $this->input->post('admin_designation');
        $admin_company_name = $this->input->post('admin_company_name');
        $admin_employee_id = $this->input->post('admin_employee_id');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone');
        $fax_no = $this->input->post('fax');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));
        $send_credentials = $this->input->post('send_credentials');
        $status = '1';
        $block_status = '1';

        // $check_duplicate_email = $this->admin_model->checkDuplicate($email);
        // else if ($check_duplicate_email > 0) {
        //     $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
        //     redirect(base_url() . 'add-admin-user');
        // } 

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } else if (isset($admin_designation) && $admin_designation == '') {
            $this->session->set_flashdata('error_msg', 'Designation field cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } else if (isset($admin_company_name) && $admin_company_name == '') {
            $this->session->set_flashdata('error_msg', 'Company field cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } else if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } else if (isset($password) && $password == '' && isset($conf_password) && $conf_password == '') {

            $this->session->set_flashdata('error_msg', 'Password fields cannot be blank');
            redirect(base_url() . 'add-admin-user');
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'add-admin-user');
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                }
                $file_path = "./uploads/admin/profile_pic/" . strtolower($first_name) . "_" . strtolower($last_name) . "/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-user');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-admin-user');
                    }
                }
            } else {
                $new_file_name = "";
            }

            $insert_arr = array(
                'sa_id' => $sa_id,
                // 'is_hiring_manager' => $is_hiring_manager,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'admin_designation' => $admin_designation,
                'admin_company_name' => $admin_company_name,
                'admin_employee_id' => $admin_employee_id,
                'admin_email' => $email,
                'admin_password' => md5($password),
                'file' => $new_file_name,
                'phone_ext' => $phone_ext,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'entry_date' => date("Y-m-d"),
                'status' => $status,
                'block_status' => $block_status
            );

            $insert_query = $this->admin_model->add_admin_user($insert_arr);
//            $insert_query = '1';
//            if ($insert_query == '1') {
            if ( ($insert_query != '') && (!empty($send_credentials)) ) {
                
                if (US || INDIA) {
                    // Okta adding user into Okta group
                    $headers = [
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: SSWS 00csMu_1y4LYS9zFG2PI5ArdDDr_laZgVkNwMvelj8' //API token
                    ];
                    $data_raw = [
                        'profile' => [
                            'firstName' => $insert_arr['first_name'],
                            'lastName' => $insert_arr['last_name'],
                            'email' => $insert_arr['admin_email'],
                            'login' => $insert_arr['admin_email'],
                            'mobilePhone' => $insert_arr['phone_no'],
                        ],
                        'credentials' => [
                            'password' => [
                                'hash' => [
                                    'algorithm' => "MD5",
                                    'value' => base64_encode(hex2bin($insert_arr['admin_password'])),
                                ]
                            ]
                        ],
                        'groupIds' => [
                            "00g1j75liwPOpyjRY4x7", //Admin Group Id
                        ]
                    ];
                    $data_json = json_encode($data_raw);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_URL, "https://cognatic-admin.okta.com/api/v1/users?activate=true");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                    $res = curl_exec($ch);
                    curl_close($ch);
                    // close of Okta
                }
                $admin_name = $first_name . " " . $last_name;
                $admin_email = $email;
                $admin_password = $password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($admin_name) . ",</p>
                                                <p style='font-weight: 300;'>Your Login Details are as follows. Please Login with below details: </p>
                                                <p><strong>Email ID : </strong>" . $admin_email . "</p>
                                                <p><strong>Temporary Password : </strong>" . $admin_password . "</p>";
                $data['login_type'] = "admin";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                //$admin_email = $email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled as Admin in GRMS');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "SUPER ADMIN has been added new admin successfully.<br> "
                        . "<label><strong>Admin Name : </strong>" . $admin_name . "</label><br/>";
                $recipient_id = 1;
                $recipient_type = "superadmin";


//                $r_arr = explode("_", $recipients);
//                $recipient_id = $r_arr[0];
//                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "New Admin enrolled in Global Resource Management System",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
// print_r($insert_arr);
// die;
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Admin Added Successfully');
                redirect(base_url() . 'admin-user');

            } else if ( ($insert_query != '') && (empty($send_credentials)) ) {

                $admin_name = $first_name . " " . $last_name;
                $admin_email = $email;
                //$admin_password = $password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($admin_name) . ",</p>
                                                <p style='font-weight: 300;'>You are successfully enrolled as Admin in Global Resource Management System </p>
                                                <p><strong>Email ID : </strong>" . $admin_email . "</p>";
                $data['login_type'] = "admin";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                //$admin_email = $email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled as Admin in GRMS');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "SUPER ADMIN has been added new admin successfully.<br> "
                        . "<label><strong>Admin Name : </strong>" . $admin_name . "</label><br/>";
                $recipient_id = 1;
                $recipient_type = "superadmin";


//                $r_arr = explode("_", $recipients);
//                $recipient_id = $r_arr[0];
//                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "New Admin enrolled in Global Resource Management System",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
// print_r($insert_arr);
// die;
                $insert_query = $this->communication_model->add_mail($insert_arr);

                
                $this->session->set_flashdata('succ_msg', 'Admin Added Successfully');
                redirect(base_url() . 'admin-user');

            } else {
                $this->session->set_flashdata('error_msg', 'Admin Not Added Successfully');
                redirect(base_url() . 'add-admin-user');
            }
        }
    }

    public function admin_lists() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_admin_details'] = $this->admin_model->getAdminLists();

        $data['page'] = "admin_lists";
        $data['meta_title'] = "ADMIN USER";

        $this->load->view('superadmin/admin_lists', $data);
    }

    public function edit_admin() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = base64_decode($this->uri->segment(2));
        $data['get_admin_data'] = $this->admin_model->getAdminData($admin_id);

        $data['page'] = "admin_lists";
        $data['meta_title'] = "EDIT ADMIN USER";

        $this->load->view('superadmin/edit_admin_user', $data);
    }

    public function update_admin() {
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $admin_id = base64_decode($this->input->post('admin_id'));
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('fname');
        $last_name = $this->input->post('lname');
        $admin_email = $this->input->post('email');
        $admin_designation = $this->input->post('admin_designation');
        $admin_company_name = $this->input->post('admin_company_name');
        $admin_employee_id = $this->input->post('admin_employee_id');

        $phone_no = $this->input->post('phone');
        $fax_no = $this->input->post('fax');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $admin_details = $this->admin_model->getAdminData($admin_id);
        $sa_details = $this->admin_model->getSuperAdminData($admin_details[0]['sa_id']);
        $check_duplicate_email = $this->admin_model->checkDuplicate($admin_email);

        $sa_id = $sa_details[0]['sa_id'];
        $sa_email = $sa_details[0]['sa_email'];
        //$admin_email = $admin_details[0]['admin_email'];

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
        } elseif (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
        } elseif (isset($admin_designation) && $admin_designation == '') {
            $this->session->set_flashdata('error_msg', 'Designation field cannot be blank');
            redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
        } elseif (isset($admin_company_name) && $admin_company_name == '') {
            $this->session->set_flashdata('error_msg', 'Company Name field cannot be blank');
            redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
        } else if ( ($admin_email !== $admin_details[0]['admin_email']) && ($check_duplicate_email > 0) ) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                }
                if (!is_dir('path/to/directory')) {
                    mkdir('path/to/directory', 0777, true);
                }
                $file_path = "./uploads/admin/profile_pic/" . strtolower($first_name) . "_" . strtolower($last_name) . "/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }

                if (empty($errors) == true) {
                    $old_file = $file_path . $admin_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-admin-user/' . base64_encode($admin_id));
                    }
                }
            } else {
                $new_file_name = $admin_details[0]['file'];
            }

            $update_arr = array(
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'admin_email' => $admin_email,
                'admin_designation' => $admin_designation,
                'admin_company_name' => $admin_company_name,
                'admin_employee_id' => $admin_employee_id,
                'file' => $new_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'updated_date' => date("Y-m-d")
            );

            $update_query = $this->admin_model->update_admin_user($update_arr, $admin_id);

            if ($update_query != '0') {

                $admin_name = $first_name . " " . $last_name;
                //$admin_email = $email;
                //$admin_password = $password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($admin_name) . ",</p>
                            <p style='font-weight: 300;'>Your information has been updated on GRMS. Please login in your application and check the updates. </p>
                            <p><strong>Email ID : </strong>" . $admin_email . "</p>";

                $data['login_type'] = "admin";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $admin_details[0]['admin_email'];

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                //$this->email->bcc($superadmin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Your information has been updated on GRMS');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $msg = "SUPER ADMIN has been updated admin details successfully.<br> "
                        . "<label><strong>Admin Name : </strong>" . $admin_name . "</label><br/>";
                $recipient_id = 1;
                $recipient_type = "superadmin";


//                $r_arr = explode("_", $recipients);
//                $recipient_id = $r_arr[0];
//                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "Admin details update in Global Resource Management System",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
// print_r($insert_arr);
// die;
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Admin Detail has been updated Successfully');
                redirect(base_url() . 'admin-user');
            } else {
                $this->session->set_flashdata('succ_msg', 'Admin Detail has been updated Successfully');
                redirect(base_url() . 'admin-user');
            }
        }
    }

    public function change_block_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $admin_id = base64_decode($this->input->post('admin_id', TRUE));

        if ($bs_type == 'block') {
            $update_arr = array(
                'block_status' => '1'
            );
        } else if ($bs_type == 'unblock') {
            $update_arr = array(
                'block_status' => '0'
            );
        }

        if (LATAM) {
            $admin_data = $this->admin_model->getAdminData($admin_id);
            $admin_email = $admin_data[0]['admin_email'];

            
            // Suspend/unsuspend okta user
            
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: SSWS 00csMu_1y4LYS9zFG2PI5ArdDDr_laZgVkNwMvelj8' //API token
                ];

            $ch = curl_init(); //API call to get admin okta user id
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users?q=$admin_email&limit=1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($res, true);
            $okta_user_id = $data[0]['id'];

            if ($bs_type == 'block') {

                $ch = curl_init(); //API call to suspend admin in okta
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users/$okta_user_id/lifecycle/unsuspend");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                $res = curl_exec($ch);
                curl_close($ch);
                $okta_response = json_decode($res, true);

                $change_block_status = $this->admin_model->change_block_status($update_arr, $admin_id);

            } else if ($bs_type == 'unblock') {

                $ch = curl_init(); //API call to unsuspend admin in okta
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, "https://cognatic.okta.com/api/v1/users/$okta_user_id/lifecycle/suspend");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                $res = curl_exec($ch);
                curl_close($ch);
                $okta_response = json_decode($res, true);

                $change_block_status = $this->admin_model->change_block_status($update_arr, $admin_id);
            }
        }
       

        $change_block_status = $this->admin_model->change_block_status($update_arr, $admin_id);

        if ($change_block_status > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function change_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $admin_id = base64_decode($this->input->post('admin_id', TRUE));

        if ($bs_type == 'activate') {
            $update_arr = array(
                'status' => '0'
            );
        } else if ($bs_type == 'deactivate') {
            $update_arr = array(
                'status' => '1'
            );
        }

        $change_status = $this->admin_model->change_status($update_arr, $admin_id);
        if ($change_status > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_admin_user() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $recipients = array();
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_sa_dtls = $this->profile_model->getDetails($email);
        $sa_id = $get_sa_dtls[0]['sa_id'];
        $admin_id = base64_decode($this->input->post('admin_id'));
        $check_admin_dtls = $this->admin_model->checkAdmin($admin_id);
        $get_admin_dtls = $this->admin_model->getAdminData($admin_id);
        $get_sadmin_dtls = $this->admin_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

        if ($check_admin_dtls) {
            //echo "OOPS !! Admin has vendor under him.";
            echo "2";
            //redirect(base_url() . 'admin-user');
        } else {
            $update_arr = array(
                "is_delete" => "1"
            );
            $update_query = $this->admin_model->deleteAdminUser($update_arr, $admin_id);

            if ($update_query > 0) {
                $name_prefix = $get_admin_dtls[0]['name_prefix'];
                $admin_name = $get_admin_dtls[0]['first_name'] . " " . $get_admin_dtls[0]['last_name'];
                $a_email = $get_admin_dtls[0]['admin_email'];

                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                                <p style='font-weight: 300;'> " . ucwords($get_sa_dtls[0]['sa_name']) . " has deleted " . $name_prefix . " " . ucwords($admin_name) . " from GRMS .</p>
                                <p><strong>Email ID : </strong>" . $a_email . "</p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $a_email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                //$this->email->to($admin_email);
                $this->email->to($get_sadmin_dtls[0]['sa_email']);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Admin has been deleted from GRMS');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $msg = "SUPER ADMIN has been deleted admin successfully.<br> "
                        . "<label><strong>Admin Name : </strong>" . ucwords($admin_name) . "</label><br/>
                        <label><strong>Admin Email : </strong>" . $a_email . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "Admin deleted from Global Resource Management System",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//     print_r($insert_arr);
//     die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

//            }
//            if ($update_query > 0) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

}
