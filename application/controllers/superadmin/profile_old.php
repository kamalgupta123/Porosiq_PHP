<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            set_referer_url();
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
        $this->load->model('superadmin/manage_employee_model', 'employee_model');
        $this->load->model('superadmin/manage_vendor_model', 'vendor_model');
    }

    public function index() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['page'] = "profile";
        $data['meta_title'] = "PROFILE";
        $this->load->view('superadmin/profile', $data);
    }

    public function update_profile() {
        $name = $this->input->post('name');
        $sa_id = $this->input->post('sa_id');
        $email = $this->input->post('email');

        $check_duplicate_email = $this->profile_model->checkDuplicate($email);
        $superadmin_details = $this->profile_model->getSuperAdminData($sa_id);
        // echo "$email";
        // echo "<br>";
        // print_r($superadmin_details[0]['sa_email']);
        // exit;
        if (isset($name) && $name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url('profile'));

        } else if (isset($email) && $email == '') {
                $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
                redirect(base_url('profile'));

        } else if ( ($email !== $superadmin_details[0]['sa_email']) && ($check_duplicate_email > 0) ) {

                $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
                redirect(base_url('profile'));
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

                if (empty($errors) == true) {
                    $old_file = "./uploads/" . $superadmin_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'profile');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'profile');
                    }
                }
            } else {
                $new_file_name = $superadmin_details[0]['file'];
            }

            $x = 1;
            if($email !== $superadmin_details[0]['sa_email']) {
                $x++ ;
            }

            $update_arr = array(
                'sa_name' => $name,
                'sa_email' => $email,
                'updated_date' => date("Y-m-d h:i:s"),
                'file' => $new_file_name
            );

            $update = $this->profile_model->updateProfile($update_arr, $sa_id);

            if ( ($update > 0) && ($x == 1) ) {
                $this->session->set_flashdata('succ_msg', 'Profile Updated Successfully');
                redirect(base_url() . 'profile');

            } else if ( ($update > 0) && ($x == 2) ) {

               $this->session->set_flashdata('succ_msg', 'Profile Updated Successfully. Login again with updated email ID ');
                redirect(site_url('logout'));

            } else {
                $this->session->set_flashdata('succ_msg', 'Profile Updated Successfully');
                redirect(base_url() . 'profile');
            }
        }
    }

    public function about_us() {

        $data['meta_title'] = "ABOUT US";
        $this->load->view('superadmin/about_us', $data);
    }

    public function contact_us() {

        $data['meta_title'] = "CONTACT US";
        $this->load->view('superadmin/contact_us', $data);
    }

    public function superadmin_lists() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_sa_lists'] = $this->profile_model->getSaLists($sa_id);
        $data['page'] = "superadmin_lists";
        $data['meta_title'] = "SUPER ADMIN USER";
        $this->load->view('superadmin/superadmin_lists', $data);
    }

    public function add_superadmin() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "superadmin_lists";
        $data['meta_title'] = "ADD SUPER ADMIN USER";

        $this->load->view('superadmin/add_superadmin_user', $data);
    }

    public function insert_superadmin() {
        $db = get_instance()->db->conn_id;
        $superadmin_name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $is_asp = $this->input->post('is_asp');

        $check_duplicate_email = $this->profile_model->checkDuplicate($email);

        if (isset($superadmin_name) && $superadmin_name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'add-super-admin-user');
        } else if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
            redirect(base_url() . 'add-super-admin-user');
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'add-super-admin-user');
        } else if (isset($password) && $password == '' && isset($conf_password) && $conf_password == '') {

            $this->session->set_flashdata('error_msg', 'Password fields cannot be blank');
            redirect(base_url() . 'add-super-admin-user');
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'add-super-admin-user');
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
                $file_path = "./uploads/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-super-admin-user');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-super-admin-user');
                    }
                }
            } else {
                $new_file_name = "";
            }

            $insert_arr = array(
                'is_asp' => $is_asp,
                'sa_name' => $superadmin_name,
                'sa_email' => $email,
                'file' => $new_file_name,
                'sa_password' => md5($password),
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->profile_model->add_superadmin_user($insert_arr);

            if ($insert_query != '') {


                $data['msg'] = " <p style='font-weight: 800;'>  Hi " . ucwords($superadmin_name) . ",</p>
                                                <p style='font-weight: 300;'>Congratulation ,you have successfully enrolled as a SuperAdmin in Global Resource Management System.</p>
                                                <p style='font-weight: 300;'>Your Login Details are as follows. Please Login with below details: </p>
                                                <p><strong>Email ID : </strong>" . $email . "</p>
                                                <p><strong>Temporary Password : </strong>" . $password . "</p>";
                $data['login_type'] = "";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $sa_email = $email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($sa_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();

//                echo $this->load->view('superadmin/email_template/admin_reg_template', $data, true);
//                die;
                $this->session->set_flashdata('succ_msg', 'Super Admin Added Successfully');
                redirect(base_url() . 'super-admin-user');
            } else {
                $this->session->set_flashdata('error_msg', 'Super Admin Not Added Successfully');
                redirect(base_url() . 'add-super-admin-user');
            }
        }
    }

    public function edit_super_admin_user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = base64_decode($this->uri->segment(2));
        $data['get_superadmin_data'] = $this->profile_model->getSuperAdminData($sa_id);

        $data['page'] = "superadmin_lists";
        $data['meta_title'] = "EDIT SUPER ADMIN USER";

        $this->load->view('superadmin/edit_super_admin_user', $data);
    }

    public function update_superadmin() {
        $db = get_instance()->db->conn_id;

        $sa_id = $this->input->post('sa_id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $is_asp = $this->input->post('is_asp');

        $check_duplicate_email = $this->profile_model->checkDuplicate($email);
        $superadmin_details = $this->profile_model->getSuperAdminData($sa_id);

        if (isset($name) && $name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'edit-super-admin-user/' . base64_encode($sa_id));
        } else if (isset($email) && $email == '') {
            $this->session->set_flashdata('error_msg', 'Email ID field cannot be blank');
            redirect(base_url() . 'edit-super-admin-user/' . base64_encode($sa_id));
        } else if ( ($email !== $superadmin_details[0]['sa_email']) && ($check_duplicate_email > 0) ) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'edit-super-admin-user/' . base64_encode($sa_id));

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
                $file_path = "./uploads/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }

                if (empty($errors) == true) {
                    $old_file = $file_path . $superadmin_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit-super-admin-user/' . base64_encode($sa_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-super-admin-user/' . base64_encode($sa_id));
                    }
                }
            } else {
                $new_file_name = $superadmin_details[0]['file'];
            }

            $update_arr = array(
                'is_asp' => $is_asp,
                'sa_name' => $name,
                'sa_email' => $email,
                'file' => $new_file_name,
                'updated_date' => date("Y-m-d")
            );

            $update_query = $this->profile_model->updateProfile($update_arr, $sa_id);

            if ($update_query != '0') {

                $this->session->set_flashdata('succ_msg', 'Super Admin Detail has been updated Successfully');
                redirect(base_url() . 'super-admin-user');
            } else {
                $this->session->set_flashdata('succ_msg', 'Super Admin Detail has been updated Successfully');
                redirect(base_url() . 'super-admin-user');
            }
        }
    }

    public function show_files() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $doc_id = base64_decode($this->uri->segment(2));
        $employee_id = base64_decode($this->uri->segment(3));

        $get_file_details = $this->profile_model->getFileDetails($doc_id, $employee_id);
//        echo "<pre>";
//        print_r($get_file_details);
        if (!empty($get_file_details)) {
            $data['form_name'] = $get_file_details[0]['form_name'];
            $data['form_data'] = json_decode($get_file_details[0]['form_data']);
        }
        $data['img_src'] = "./assets/images/pts.jpg";
        //print_r($data['form_data']);
        $this->load->view('superadmin/form_templates/print_direct_deposit_form', $data);
    }

    public function user_recovery() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['get_inactive_sadmin_details'] = $this->profile_model->getInactiveSuperadminDetails();
        $data['get_inactive_admin_details'] = $this->profile_model->getInactiveAdminDetails();
        $data['get_inactive_vendor_details'] = $this->profile_model->getInactiveVendorDetails();
        $data['get_inactive_con_details'] = $this->profile_model->getInactiveConDetails();
        $data['get_inactive_emp_details'] = $this->profile_model->getInactiveEmpDetails();

        $data['page'] = "user_recovery";
        $data['meta_title'] = "USER RECOVERY";
        $this->load->view('superadmin/user_recovery', $data);
    }

    public function recover_user_account() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $del_val = $this->input->post('del_val');
        $user_type = $this->input->post('user_type');
        $user_id = base64_decode($this->input->post('user_id'));

        $update_arr = array(
            'is_delete' => $del_val
        );


        $update_query = $this->profile_model->updateIsDeleteStatus($update_arr, $user_type, $user_id);

        if ($update_query != '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function per_delete_user_account() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);


        $user_type = $this->input->post('user_type');
        $user_id = base64_decode($this->input->post('user_id'));

        $del_query = $this->profile_model->deleteUserPermanently($user_type, $user_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_superadmin_user() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//        $sess_arr = $this->session->userdata('logged_in');
//        $email = $sess_arr['email'];
//        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = base64_decode($this->input->post('sa_id'));
        $check_sa_dtls = $this->profile_model->checkSadmin($sa_id);

        if (!empty($check_sa_dtls)) {
            echo "3";
            //redirect(base_url() . 'admin-user');
        } else {
            $update_arr = array(
                "is_delete" => "1"
            );
            $update_query = $this->profile_model->deleteSadminUser($update_arr, $sa_id);
//            echo $update_query;
//            die;
            if ($update_query > 0) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function access_log() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['get_access_log_details'] = $this->profile_model->getAccssLogDetails();

        $data['page'] = "user_recovery";
        $data['meta_title'] = "USER ACCESS LOG";
        $this->load->view('superadmin/access_log', $data);
    }

    public function add_timesheet_tbl() {

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $this->load->view('superadmin/ajax/timesheet_table', $data);
    }
	
	/**Adding modules for Superadmin to upload files for vendor**/
	/*public function all_documents_lists() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        
		//$data['get_details'] = $this->profile_model->getDetails($email);
        //$data['get_vendor_documents'] = $this->profile_model->getVendorAllDocuments();
        //$vendor_id = $data['get_details'][0]['vendor_id'];
		
        $vendor_id = base64_decode($this->uri->segment(2));
		$data['get_details'] = $this->profile_model->getVendorData($vendor_id);
		$data['get_vendor_documents'] = $this->profile_model->getVendorAllDocuments();

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "UPLOAD VENDOR DOCUMENTS";

        $this->load->view('superadmin/all_documents_lists', $data);
    }*/

    public function sso_settings() {

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "sso_settings";
        $data['meta_title'] = "SSO SETTINGS";
        $this->load->view('superadmin/sso_settings', $data);
    }
}
