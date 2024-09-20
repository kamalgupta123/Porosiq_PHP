<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('vendor_logged_in')) {
            set_referer_url();
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        $this->load->model('vendor/manage_employee_model', 'employee_model');
        $this->load->model('vendor/manage_vendor_model', 'vendor_model');
        $this->load->model('vendor/profile_model');
        $this->load->model('employee/manage_communication_model', 'communication_model');
    }

    public function index() {

        if (!$this->session->userdata('vendor_logged_in')) {
            if (empty($this->session->userdata('referer_url'))) {
                $this->session->set_userdata('referer_url', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            }
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $check_last_id = $this->employee_model->checkCount($vendor_id);
        $count = $check_last_id[0]['cnt'] + 1;

        $words = explode(" ", $data['get_details'][0]['vendor_company_name']);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        $employee_code = strtoupper($acronym . "C") . str_pad($count, 3, "0", STR_PAD_LEFT);
        $data['employee_code'] = $employee_code;


        $data['page'] = "employee_list";
        $data['meta_title'] = "CONSULTANT ADD";

        $this->load->view('vendor/add_employee_user', $data);
    }

    public function employee_lists() {

        if (!$this->session->userdata('vendor_logged_in')) {
            if (empty($this->session->userdata('referer_url'))) {
                $this->session->set_userdata('referer_url', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            }
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_employee_details'] = $this->employee_model->getEmployeeListsByVendor($vendor_id);


        $data['page'] = "employee_list";
        $data['meta_title'] = "CONSULTANT LISTS";

        $this->load->view('vendor/employee_lists', $data);
    }

    public function add_employee() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');
        $employee_code = $this->input->post('employee_code');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_type = $this->input->post('employee_type');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
//        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $v_employee_bill_rate = $this->input->post('v_employee_bill_rate');
        $date_of_joining = $this->input->post('date_of_joining');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant First Name cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Last Name cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Designation cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Classification cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Category cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'add_vendor_consultant');
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

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add_vendor_consultant');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add_vendor_consultant');
                    }
                }
            } else {
                $new_file_name = '';
            }


            /* ---------------Resume-------------- */

            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf", "doc", "docx");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add_vendor_consultant');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add_vendor_consultant');
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            /* ---------------Resume-------------- */

            $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }


            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'admin_id' => $admin_id,
                'employee_code' => $employee_code,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_type' => $employee_type,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'employee_designation' => $employee_designation,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'entry_date' => date("Y-m-d h:i:s"),
                'date_of_joining' => $date_of_joining,
                'v_employee_bill_rate' => $v_employee_bill_rate,
//                'employee_pay_rate' => $employee_pay_rate
            );
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_employee_user($insert_arr);

            if ($insert_query != '') {
                $employee_name = $first_name . " " . $last_name;

                if ($employee_category == '1') {
                    $employee_category = "W2";
                } else {
                    $employee_category = "Subcontractor";
                }

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = "<p style='font-weight: 800;'>" . ucwords($vendor_name) . " has added new consultant successfully. Consultant Details are as follows : </p>
                                                <p style='font-weight: 300;'>
                                                    <label><strong>Consultant Details : </strong></label><br/>
                                                    <label><strong>Consultant Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                                                    <label><strong>Consultant Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Consultant Designation : </strong>" . $employee_designation . "</label><br/>
                                                    <label><strong>Consultant Category : </strong>" . $employee_category . "</label><br/>
                                                </p>";
                $data['msg'] = $msg;
                $data['login_type'] = "employee";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('New Consultant Added Successfully');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => "New Consultant Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Consultant added Successfully..');
                redirect(base_url() . 'vendor_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Consultant not added Successfully..');
                redirect(base_url() . 'vendor_consultant_lists');
            }
        }
    }

    public function edit_employee() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $vendor_id = $data['get_details'][0]['vendor_id'];


        $data['page'] = "employee_list";
        $data['meta_title'] = "COSULTANT EDIT";

        $this->load->view('vendor/edit_employee_user', $data);
    }

    public function change_block_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));

        if ($bs_type == 'block') {
            $update_arr = array(
                'block_status' => '1',
                "updated_date" => date("Y-m-d h:i:s")
            );
        } else if ($bs_type == 'unblock') {
            $update_arr = array(
                'block_status' => '0',
                "updated_date" => date("Y-m-d h:i:s")
            );
        }

        $change_block_status = $this->employee_model->change_block_status($update_arr, $employee_id);
        if ($change_block_status > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function change_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));

        if ($bs_type == 'activate') {
            $update_arr = array(
                'status' => '0',
                "updated_date" => date("Y-m-d h:i:s")
            );
        } else if ($bs_type == 'deactivate') {
            $update_arr = array(
                'status' => '1',
                "updated_date" => date("Y-m-d h:i:s")
            );
        }

        $change_status = $this->employee_model->change_status($update_arr, $employee_id);
        if ($change_status > 0) {
            echo "1";
        } else {

            echo "0";
        }
    }

    public function update_employee() {

        $recipients = array();
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $employee_id = base64_decode($this->input->post('employee_id'));
        $vendor_name = $this->input->post('vendor_name');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
//        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $v_employee_bill_rate = $this->input->post('v_employee_bill_rate');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $employee_details = $this->employee_model->getEmployeeData($employee_id);

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Designation cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Category cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Category cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
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
                    $old_file = "./uploads/" . $employee_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_file_name = $employee_details[0]['file'];
            }

            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf", "doc", "docx");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

            $update_arr = array(
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_designation' => $employee_designation,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'date_of_joining' => $date_of_joining,
                'v_employee_bill_rate' => $v_employee_bill_rate,
//                'employee_pay_rate' => $employee_pay_rate,
                'updated_date' => date("Y-m-d h:i:s")
            );

            $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);

            if ($update_query > 0) {
                if ($employee_category == '1') {
                    $employee_category = "W2";
                } else {
                    $employee_category = "Subcontractor";
                }
                $get_vendor_details = $this->employee_model->getVendorDetails($employee_details[0]['vendor_id']);
                $vendor_id = $get_vendor_details[0]['vendor_id'];
                $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
                if (!empty($get_admin_details)) {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $employee_details[0]['employee_id'] . "_" . "employee";
                }

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $employee_name = $name_prefix . " " . $first_name . " " . $last_name;

                $msg = "<p style='font-weight: 800;'>" . ucwords($vendor_name) . " has updated consultant details successfully. Consultant Details are as follows : </p>
                                                <p style='font-weight: 300;'>
                                                    <label><strong>Consultant Details : </strong></label><br/>
                                                    <label><strong>Consultant Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Consultant Designation : </strong>" . $employee_designation . "</label><br/>
                                                    <label><strong>Consultant Category : </strong>" . $employee_category . "</label><br/>
                                                </p>";
                $data['msg'] = $msg;
                $data['login_type'] = "employee";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Consultant Data Updated Successfully');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => "Consultant Data Updated Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Consultant updated Successfully.');
                redirect(base_url() . 'vendor_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Consultant not updated Successfully.');
                redirect(base_url() . 'edit_vendor_consultant/' . base64_encode($employee_id));
            }
        }
    }

    public function employee_timesheet() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['get_employee_details'] = $this->employee_model->getEmployeeListsByVendor($vendor_id);

        $data['page'] = "employee_timesheet";
        $data['meta_title'] = "CONSULTANT TIMESHEETS";

        $this->load->view('vendor/employee_timesheet', $data);
    }

    public function view_employees_timesheet() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_project_details'] = $this->employee_model->getEmployeeProjects($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmp($employee_id);
        $data['get_timesheet_details_nt_approved'] = $this->employee_model->getTimesheetDetailsnotapprove($employee_id);
        $data['get_timesheet_details_pending'] = $this->employee_model->getTimesheetDetailspending($employee_id);

        $data['page'] = "employee_timesheet";
        $data['meta_title'] = "CONSULTANT TIMESHEETS";

//        $this->load->view('vendor/employees_project_timesheet', $data);
        $this->load->view('vendor/employees_project_timesheet', $data);
    }

    public function project_lists() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['get_project_details'] = $this->employee_model->getProjectListsByVendor($vendor_id);

        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $data['page'] = "project_list";
        $data['meta_title'] = "PROJECT LISTS";

        $this->load->view('vendor/projects_lists', $data);
    }

    public function open_requirements() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $vendor_tier = $data['get_details'][0]['vendor_tier'];
        $data['get_project_details'] = $this->employee_model->getProjectListsByVendor($vendor_id);
        if (!empty($vendor_tier)) {

            $data['requisition_list'] = $this->employee_model->getRequisitionList($vendor_tier);
        } else {
            $data['requisition_list'] = "";
        }
        // echo "<pre>";
        // print_r($data['requisition_list']);
        // exit;

        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $data['page'] = "open_requirements";
        $data['meta_title'] = "OPEN REQUIREMENTS";

        $this->load->view('vendor/open_requirements', $data);
    }

    public function add_projects() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['get_project_type'] = $this->employee_model->getProjectTypeLists();

        $data['page'] = "project_list";
        $data['meta_title'] = "PROJECT ADD";

        $this->load->view('vendor/add_projects.php', $data);
    }

    public function edit_projects() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $project_id = base64_decode($this->uri->segment(2));
        $data['get_project_data'] = $this->employee_model->getProjectData($project_id);
        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['get_project_type'] = $this->employee_model->getProjectTypeLists();

        $data['page'] = "project_list";
        $data['meta_title'] = "PROJECT EDIT";

        $this->load->view('vendor/edit_projects', $data);
    }

    public function update_projects() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_id');
        $project_type = $this->input->post('project_type');
        $project_name = $this->input->post('project_name');
        $project_details = mysqli_real_escape_string($db, $this->input->post('project_details'));
        $client_name = $this->input->post('client_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $approx_total_time = $this->input->post('approx_total_time');
        $monthly_payment = $this->input->post('monthly_payment');

        if (isset($project_type) && $project_type == '') {
            $this->session->set_flashdata('error_msg', 'Project Type ield cannot be blank');
            redirect(base_url('edit_projects/' . base64_encode($project_id)));
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url('edit_projects/' . base64_encode($project_id)));
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url('edit_projects/' . base64_encode($project_id)));
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url('edit_projects/' . base64_encode($project_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url('edit_projects/' . base64_encode($project_id)));
        } else {


            $update_arr = array(
                'project_type' => $project_type,
                'project_name' => $project_name,
                'project_details' => $project_details,
                'client_name' => $client_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'approx_total_time' => $approx_total_time,
                'monthly_payment' => $monthly_payment,
                'updated_date' => date("Y-m-d h:i:s"),
            );

            $update_query = $this->employee_model->update_projects($update_arr, $project_id);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Project updated Successfully..');
                redirect(base_url('edit_projects/' . base64_encode($project_id)));
            } else {
                $this->session->set_flashdata('error_msg', 'Project not updated Successfully..');
                redirect(base_url('edit_projects/' . base64_encode($project_id)));
            }
        }
    }

    public function assign_project_to_employee() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['get_projects'] = $this->employee_model->getProjectListsByVendor($vendor_id);
        $data['get_employees'] = $this->employee_model->getEmployeeListsByVendor($vendor_id);

        $data['page'] = "open_requirements";
        $data['meta_title'] = "ASSIGN PROJECTS TO CONSULTANTS ";

        $this->load->view('vendor/assign_employee_to_project', $data);
    }

    public function add_assign_projects() {

        $recipients = array();
        $db = get_instance()->db->conn_id;

        $vendor_id = $this->input->post('vendor_id');
        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
//echo "<pre>";
//print_r($employee_ids);
//die;
        $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        if (!empty($get_admin_details)) {
            $sa_id = $get_admin_details[0]['sa_id'];
            $admin_id = $get_admin_details[0]['admin_id'];
        }

        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign_project_to_consultant');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign_project_to_consultant');
        } else {
            $errors = array();
            $error = "";
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                        'vendor_id' => $vendor_id,
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'status' => '2'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);
                        $get_employee_details = $this->employee_model->getEmployeeData($eval);
                        $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                        $vendor_email = $get_vendor_details[0]['vendor_email'];

                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $employee_email = $get_employee_details[0]['employee_email'];

                        if ($get_employee_details[0]['employee_category'] == '1') {
                            $employee_category = "W2";
                        } else {
                            $employee_category = "Subcontractor";
                        }

                        $msg = "<p style='font-weight: 800;'>" . $vendor_name . " has assigned a new consultant for the following project. Project details and Consultant details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label>" . ucwords($get_project_details[0]['project_name']) . "<br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details[0]['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Consultant Details </label><br/>
                                            <label style='font-weight: bold;'>Consultant Code : </label>" . strtoupper($get_employee_details[0]['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Consultant Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Consultant Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Consultant Category : </label>" . $employee_category . "<br/>
                                        </p>";

                        $data['msg'] = $msg;

                        //Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($vendor_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
                        //Send mail
                        $this->email->send();

                        /* ----------------------------------Insert Mail------------------------------------ */

                        $sadmin_insert_arr = array(
                            "recipient_id" => "1",
                            "recipient_type" => "superadmin",
                            "sender_id" => $vendor_id,
                            "sender_type" => "vendor",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $sa_insert_arr = array(
                            "recipient_id" => $sa_id,
                            "recipient_type" => "superadmin",
                            "sender_id" => $vendor_id,
                            "sender_type" => "vendor",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $admin_insert_arr = array(
                            "recipient_id" => $admin_id,
                            "recipient_type" => "admin",
                            "sender_id" => $vendor_id,
                            "sender_type" => "vendor",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );

                        $sadmin_insert_query = $this->communication_model->add_mail($sadmin_insert_arr);
                        $sa_insert_query = $this->communication_model->add_mail($sa_insert_arr);
                        $admin_insert_query = $this->communication_model->add_mail($admin_insert_arr);


                        /* ----------------------------------Insert Mail------------------------------------ */

                        $error = "1";
                    }
                } else {
                    $get_employee_details = $this->employee_model->getEmployeeData($eval);
                    $errors[] = ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is Already Assigned.";
                }
            }
            if (!empty($errors)) {
                $this->session->set_flashdata('error_msg', $errors);
                redirect(base_url() . 'open_requirements');
            } else if ($error == '1') {

                $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                redirect(base_url() . 'open_requirements');
            }
        }
    }

    public function view_employee() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];


        $project_id = base64_decode($this->uri->segment(2));
//echo $vendor_id;
        $data['get_employee_details'] = $this->employee_model->getAssignedEmpoyees($vendor_id, $project_id);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);

        $data['page'] = "open_requirements";
        $data['meta_title'] = "CONSULTANT LISTS PROJECT WISE";

        $this->load->view('vendor/view_assigned_employees', $data);
    }

    public function view_project_timesheet() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $project_id = base64_decode($this->uri->segment(2));
        $employee_id = base64_decode($this->uri->segment(3));

        $data['get_timesheet_data'] = $this->employee_model->getTimesheetData($project_id, $employee_id);

        $data['project_id'] = $project_id;
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);

        $data['page'] = "employee_timesheet";
        $data['meta_title'] = "CONSULTANT TIMESHEETS";

        $this->load->view('vendor/view_project_timesheet', $data);
    }

    public function get_timesheet_list() {
        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
//        echo $project_id;
//        exit;
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);

        $data['get_timesheet_data'] = $this->employee_model->getTimesheetData($project_id, $employee_id);

        $data['start'] = $start;
        $data['end'] = $end;

        $this->load->view('vendor/ajax/ajax_get_timesheet', $data);
    }

    public function change_timesheet_approve_status() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $timesheet_id = $this->input->post('timesheet_id', TRUE);
        $bs_type = $this->input->post('bs_type', TRUE);
        if ($bs_type == 'approved') {
            $approved_by_vendor = '0';
        } else if ($bs_type == 'disapproved') {
            $approved_by_vendor = '1';
        }

        $update_arr = array(
            "approved_by_vendor" => $approved_by_vendor,
        );

        $change_status = $this->employee_model->changeTimesheetStatus($update_arr, $timesheet_id);

        if ($change_status > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function approve_disapprove_timesheet() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);

        if ($ad == 'Approved') {
            $approved_by_vendor = '1';
        } else if ($ad == 'Disapproved') {
            $approved_by_vendor = '0';
        }
        if (!empty($check)) {

            $update_arr = array(
                "approved_by_vendor" => $approved_by_vendor,
            );

            foreach ($check as $tid) {
                $change_status = $this->employee_model->changeTimesheetStatus($update_arr, $tid);
            }

            if ($change_status > 0) {
                $this->session->set_flashdata('succ_msg', 'Timesheet status changed Successfully..');
                redirect(base_url() . 'view_vendor_project_timesheet/' . base64_encode($project_id) . '/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('succ_msg', 'Timesheet status changed Successfully..');
                redirect(base_url() . 'view_vendor_project_timesheet/' . base64_encode($project_id) . '/' . base64_encode($employee_id));
            }
        }
//        echo "<pre>";
//        print_r($check);
//        die;
    }

    public function add_vendor_employee_work_order() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['vendor_id'] = $vendor_id;
        $data['admin_id'] = $admin_id;
        $data['employee_id'] = $employee_id;


        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($vendor_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeListsByVendor($vendor_id);

        $this->load->view('vendor/add_vendor_employee_work_order', $data);
    }

    public function insert_vendor_employee_work_order() {
        $db = get_instance()->db->conn_id;

        $vendor_id = $this->input->post('vendor_id');
        $employee_id = $this->input->post('employee_id');
        $admin_id = $this->input->post('admin_id');
        $consultant = $this->input->post('consultant');
        $start_date = $this->input->post('start_date');
        $client_name = $this->input->post('client_name');
        $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
        $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
        $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
        $bill_rate = $this->input->post('bill_rate');
        $ot_rate = $this->input->post('ot_rate');
        $vendor_signature = $this->input->post('vendor_signature');
        $vendor_ip = $_SERVER['REMOTE_ADDR'];


        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add_vendor_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add_vendor_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add_vendor_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add_vendor_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add_vendor_employee_work_order/' . base64_encode($employee_id)));
        } else {

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'employee_id' => $employee_id,
                'admin_id' => $admin_id,
                'consultant' => $consultant,
                'start_date' => $start_date,
                'client_name' => $client_name,
                'project_duration' => $project_duration,
                'invoicing_terms' => $invoicing_terms,
                'payment_terms' => $payment_terms,
                'bill_rate' => $bill_rate,
                'ot_rate' => $ot_rate,
                'vendor_signature' => $vendor_signature,
                'vendor_ip' => $vendor_ip,
                'entry_date' => date("Y-m-d h:i:s")
            );

            $insert_query = $this->employee_model->add_work_order($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Work order added Successfully..');
                redirect(base_url() . 'vendor_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Work order not added Successfully..');
                redirect(base_url() . 'vendor_consultant_lists');
            }
        }
    }

    public function edit_vendor_employee_work_order() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $get_work_details = $this->employee_model->getWorkDetailsByEmp($employee_id);

        if ($get_work_details[0]['stage'] == 5) {
            $this->session->set_flashdata('error_msg', 'Work order PDF is already generated.');
            redirect(base_url() . 'vendor_consultant_lists');
        }

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];
        $data['employee_id'] = $employee_id;

        $data['get_admin_details'] = $this->employee_model->getAdminDetails($data['admin_id']);
        $data['get_employee_details'] = $this->employee_model->getEmployeeListsByVendor($data['vendor_id']);

        $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
        $data['consultant_name'] = $get_work_details[0]['consultant'];
        $data['start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
        $data['project_duration'] = $get_work_details[0]['project_duration'];
        $data['bill_rate'] = $get_work_details[0]['bill_rate'];
        $data['ot_rate'] = $get_work_details[0]['ot_rate'];
        $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
        $data['payment_terms'] = $get_work_details[0]['payment_terms'];
        $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
        $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
        $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];

        $get_work_note = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
        $data['client_name'] = $get_work_note[0]['client_name'];
        $data['work_note'] = empty($data['client_name']) ? '-' : $get_work_note[0]['work_order_note'];

        $get_vendor_details = $this->employee_model->getVendorDetails($data['vendor_id']);
        $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

        $data['page'] = "employee_list";
        $data['meta_title'] = "EMPLOYEE WORK ORDER";

        unset($get_vendor_details, $get_work_details, $get_work_note, $employee_id);

        $this->load->view('vendor/edit_vendor_employee_work_order', $data);
    }

    public function update_vendor_employee_work_order() {

        $vendor_signature = $this->input->post('vendor_signature');
        $vendor_poc_name = $this->input->post('vendor_poc_name');
        $vendor_poc_designation = $this->input->post('vendor_poc_designation');
        $vendor_ip = $_SERVER['REMOTE_ADDR'];

        $status_msg = '';
        $is_error = true;
        $redirect_url = 'edit_vendor_employee_work_order/' . base64_encode($employee_id);

        if (isset($vendor_signature) && empty($vendor_signature)) {

            $status_msg = 'Vendor Signature field cannot be blank.';
        } else if (isset($vendor_poc_name) && empty($vendor_poc_name)) {

            $status_msg = 'Vendor POC Name field cannot be blank.';
        } else if (isset($vendor_poc_designation) && empty($vendor_poc_designation)) {

            $status_msg = 'Vendor POC designation field cannot be blank.';
        } else {
        	$recipients = array();

	        $sess_arr = $this->session->userdata('vendor_logged_in');
	        $email = $sess_arr['email'];
	        $data['get_details'] = $this->profile_model->getDetails($email);

	        $employee_id = $this->input->post('employee_id');
	        $admin_id = $this->input->post('admin_id');
	        $vendor_id = $this->input->post('vendor_id');
	        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
	        $data['get_admin_details'] = $get_admin_details;

            $update_arr = array(
                'vendor_poc_name' => $vendor_poc_name,
                'vendor_poc_designation' => $vendor_poc_designation,
                'vendor_signature' => $vendor_signature,
                'vendor_ip' => $vendor_ip,
                'vendor_signature_date' => date("Y-m-d"),
                'stage' => '4',
                'status' => '1',
                'updated_date' => date("Y-m-d h:i:s")
            );

            $update_query = $this->employee_model->update_work_order($update_arr, $employee_id);

            if ($update_query != '') {
                if (!empty($get_admin_details)) {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }

                //$from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_name = $data['get_admin_details'][0]['first_name'] . " " . $data['get_admin_details'][0]['last_name'];
                $admin_email = $data['get_admin_details'][0]['admin_email'];
                $vendor_email = $data['get_details'][0]['vendor_email'];
                $vendor_company_name = $data['get_details'][0]['vendor_company_name'];
                $vendor_name = $data['get_details'][0]['name_prefix'] . " " . $data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name'];

                $asp_emails = $this->employee_model->get_asp_emails();

                $consultant_deatils = $this->employee_model->getEmployeeData($employee_id);
                $consultant_name = $consultant_deatils[0]['first_name'] . " " . $consultant_deatils[0]['last_name'];
                $consultant_code = $consultant_deatils[0]['employee_code'];

                send_emails_work_order(4, 'vendor', [
                    'init_user_full_name' => $vendor_name,
                    'con_full_name' => $consultant_name,
                    'con_code' => $consultant_code,
                    'access_link_part' => 'edit-sadmin-employee-work-order/' . base64_encode($employee_id),
                    ], $asp_emails , [
                        SUPERADMIN_EMAIL,
                        $admin_email,
                    ]);

                $data['msg'] = $vendor_name . ' successfully signed work order.';
                //Load email library
                /*$this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($vendor_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Work Order Signed Successfully');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();*/

                /* ----------------------------------Insert Mail------------------------------------ */


                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => "Work order is signed by vendor successfully",
                        "message" => $data['msg'],
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $status_msg = 'Work order has been signed successfully.';
                $is_error = false;
                $redirect_url = 'vendor_consultant_lists';
            } else {
                $status_msg = 'Work order was not signed proerly. Please try again.';
                $redirect_url = 'vendor_consultant_lists';
            }
        }

        if (!empty($status_msg)) {
        	$this->session->set_flashdata($is_error ? 'error_msg' : 'succ_msg', $status_msg);
        }
		redirect(base_url($redirect_url));
    }

    public function view_employees_work_order() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);

        // echo "<pre>";
        // print_r($data['get_work_order']);

        $this->load->view('vendor/view_employees_work_order', $data);
    }

    public function view_employees_work_order_pdf() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->view('vendor/view_employees_work_order_pdf', $data);
    }

    public function generate_vendor_employee_payment() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['check_work_order'] = $this->employee_model->checkWorkOrder($employee_id);

        $data['page'] = "employee_timesheet";
        $data['meta_title'] = "GENERATE INVOICE";

        $this->load->view('vendor/generate_vendor_employee_payment', $data);
    }

    public function generate_vendor_payment() {

        $recipients = array();
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $employee_id = $this->input->post('employee_id');
        $payment_type = $this->input->post('payment_type');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $daily_start_date = $this->input->post('daily_start_date');
        $daily_end_date = $this->input->post('daily_end_date');

        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        if (isset($payment_type) && $payment_type == '') {
            $this->session->set_flashdata('error_msg', 'Payment Type field cannot be blank');
            redirect(base_url('generate_vendor_consultant_invoice/' . base64_encode($employee_id)));
        } else {

            $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);

            $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
            $code = ltrim($check_prev_generated_code[0]['invoice_code'], "INV");
            $invoice_code = "INV00" . ($code + 1);

            if ($payment_type == '1') {

                $check_date = $this->employee_model->getCheckDate($start_date, $end_date, $employee_id);
//print_r($check_date);
//                die;
                if ($check_date[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'vendor_consultant_timesheet');
                }

                $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_emp_work_order[0]['bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_emp_work_order[0]['ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['weekly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
                    "vendor_id" => $vendor_id,
                    "employee_id" => $employee_id,
                    "payment_type" => $payment_type,
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "work_duration" => $work_duration,
                    "tot_time" => $tot_time,
                    "bill_rate" => $bill_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $over_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "comment" => $comment,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "status" => "0"
                );
            } else if ($payment_type == '2') {

                $check_month = $this->employee_model->getCheckMonth($month, $year, $employee_id);
                if ($check_month[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'vendor_consultant_timesheet');
                }

                $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);
                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_emp_work_order[0]['bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_emp_work_order[0]['ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['monthly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
                    "vendor_id" => $vendor_id,
                    "employee_id" => $employee_id,
                    "payment_type" => $payment_type,
                    "month" => $month,
                    "year" => $year,
                    "tot_time" => $tot_time,
                    "work_duration" => $work_duration,
                    "bill_rate" => $bill_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $over_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "comment" => $comment,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "status" => "0"
                );
            } else if ($payment_type == '3') {

                $check_date = $this->employee_model->getCheckDate($start_date, $end_date, $employee_id);
//print_r($check_date);
//                die;
                if ($check_date[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'vendor_consultant_timesheet');
                }

                $get_emp_timesheet = $this->employee_model->getDailyTimesheet($daily_end_date, $daily_end_date, $employee_id);

                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_emp_work_order[0]['bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_emp_work_order[0]['ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['daily_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
                    "vendor_id" => $vendor_id,
                    "employee_id" => $employee_id,
                    "payment_type" => $payment_type,
                    "start_date" => $daily_start_date,
                    "end_date" => $daily_end_date,
                    "work_duration" => $work_duration,
                    "tot_time" => $tot_time,
                    "bill_rate" => $bill_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $over_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "comment" => $comment,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "status" => "0"
                );
            }
//            echo "<pre>";
//             print_r($insert_arr);
//            die;

            $insert_query = $this->employee_model->generate_payment($insert_arr);

            if ($insert_query != '') {

                $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
                $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
                if (!empty($get_admin_details)) {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }


                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];

                $msg = ucwords($vendor_name) . ' successfully generated invoice.';
                $data['msg'] = $msg;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Invoice generated Successfully');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => "Pending Verification",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Invoice generated Successfully..');
                redirect(base_url() . 'vendor_consultant_timesheet');
            } else {
                $this->session->set_flashdata('error_msg', 'Invoice data not generated Successfully..');
                redirect(base_url() . 'vendor_consultant_timesheet');
            }
        }
    }

    public function vendor_employee_payment() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $data['get_payment_details'] = $this->employee_model->getPaymentDetails($vendor_id);

        $data['page'] = "payment";
        $data['meta_title'] = "INVOICE";

        $this->load->view('vendor/vendor_employee_payment', $data);
    }

    public function search_vendor_payment() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['vendor_id'] = $vendor_id;

        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($vendor_id);

        $data['search_by_emp_code'] = $this->input->post('search_by_emp_code');
        $data['search_by_payment_mode'] = $this->input->post('search_by_payment_mode');
        $data['search_by_start_date'] = date("Y-m-d", strtotime($this->input->post('search_by_start_date')));
        $data['search_by_end_date'] = date("Y-m-d", strtotime($this->input->post('search_by_end_date')));

        $data['search_by_month'] = $this->input->post('search_by_month');
        $data['search_by_year'] = $this->input->post('search_by_year');

        $data['get_payment_details'] = $this->employee_model->getSearchData($data);

        $this->load->view('vendor/vendor_employee_payment', $data);
    }

    public function search_by_emp_code() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $employee_code = trim($this->input->get('term', TRUE));
        $get_employee_code = $this->employee_model->getEmployeeCode($employee_code, $vendor_id);

        echo json_encode($get_employee_code);
    }

    public function ajax_monthly_timesheet() {
        $month = $this->input->post('month', TRUE);
        $year = $this->input->post('year', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
        //print_r($get_emp_work_order);
        $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_work_order[0]['bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_work_order[0]['ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);

        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
        $data = array(
            "employee_name" => $get_emp_details[0]['first_name'] . " " . $get_emp_details[0]['last_name'],
            "employee_code" => $get_emp_details[0]['employee_code'],
            "employee_designation" => $get_emp_details[0]['employee_designation'],
            "month" => $month,
            "year" => $year,
            "tot_time" => $tot_time,
            "bill_rate" => $bill_rate,
            "tot_time_pay" => $tot_time_pay,
            "over_time" => $over_time,
            "ot_rate" => $ot_rate,
            "over_time_pay" => $over_time_pay,
        );

        $this->load->view('vendor/ajax/ajax_get_monthly_details', $data);
    }

    public function ajax_weekly_timesheet() {
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
        //print_r($get_emp_work_order);
        $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_work_order[0]['bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_work_order[0]['ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);

        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
        $data = array(
            "employee_name" => $get_emp_details[0]['first_name'] . " " . $get_emp_details[0]['last_name'],
            "employee_code" => $get_emp_details[0]['employee_code'],
            "employee_designation" => $get_emp_details[0]['employee_designation'],
            "start_date" => $start_date,
            "end_date" => $end_date,
            "tot_time" => $tot_time,
            "bill_rate" => $bill_rate,
            "tot_time_pay" => $tot_time_pay,
            "over_time" => $over_time,
            "ot_rate" => $ot_rate,
            "over_time_pay" => $over_time_pay,
        );

        $this->load->view('vendor/ajax/ajax_get_weekly_details', $data);
    }

    public function ajax_daily_timesheet() {
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
        //print_r($get_emp_work_order);
        $get_emp_timesheet = $this->employee_model->getDailyTimesheet($start_date, $end_date, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_work_order[0]['bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_work_order[0]['ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);

        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
        $data = array(
            "employee_name" => $get_emp_details[0]['first_name'] . " " . $get_emp_details[0]['last_name'],
            "employee_code" => $get_emp_details[0]['employee_code'],
            "employee_designation" => $get_emp_details[0]['employee_designation'],
            "start_date" => $start_date,
            "end_date" => $end_date,
            "tot_time" => $tot_time,
            "bill_rate" => $bill_rate,
            "tot_time_pay" => $tot_time_pay,
            "over_time" => $over_time,
            "ot_rate" => $ot_rate,
            "over_time_pay" => $over_time_pay,
        );

        $this->load->view('vendor/ajax/ajax_get_daily_details', $data);
    }

    public function generate_invoice() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $payment_type = base64_decode($this->uri->segment(3));
        $get_payment_details = $this->employee_model->getPaymentDetailsbyEmp($employee_id, $payment_type);

        $insert_arr['invoice_id'] = "INV" . date("Ymd") . time();
        $insert_arr['vendor_id'] = $get_payment_details[0]['vendor_id'];
        $insert_arr['employee_id'] = $employee_id;
        $insert_arr['payment_type'] = $get_payment_details[0]['payment_type'];
        $insert_arr['start_date'] = $get_payment_details[0]['start_date'];
        $insert_arr['end_date'] = $get_payment_details[0]['end_date'];
        $insert_arr['month'] = $get_payment_details[0]['month'];
        $insert_arr['year'] = $get_payment_details[0]['year'];
        $insert_arr['work_duration'] = $get_payment_details[0]['work_duration'];
        $insert_arr['tot_time'] = $get_payment_details[0]['tot_time'];
        $insert_arr['bill_rate'] = $get_payment_details[0]['bill_rate'];
        $insert_arr['tot_time_pay'] = $get_payment_details[0]['tot_time_pay'];
        $insert_arr['over_time'] = $get_payment_details[0]['over_time'];
        $insert_arr['ot_rate'] = $get_payment_details[0]['ot_rate'];
        $insert_arr['over_time_pay'] = $get_payment_details[0]['over_time_pay'];
        $insert_arr['entry_date'] = $get_payment_details[0]['entry_date'];
        $insert_arr['status'] = $get_payment_details[0]['status'];

        $insert_id = $this->employee_model->generate_invoice($insert_arr);

        if ($insert_id != '') {

            $data['vendor_name'] = $data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name'];
            $data['vendor_email'] = $data['get_details'][0]['vendor_email'];

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;
            $to_email = $data['vendor_email'];
            $admin_email = $data['get_details'][0]['admin_email'];
            $data['msg'] = "Invoice generated successfully";
            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('Invoice generated successfully');
            $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

            $this->email->set_mailtype('html');
            //Send mail
            $this->email->send();
            $this->session->set_flashdata('succ_msg', 'Invoice Generated Successfully..');
            redirect(base_url() . 'vendor_employee_payment');
        } else {
            $this->session->set_flashdata('error_msg', 'Invoice not Generated Successfully..');
            redirect(base_url() . 'vendor_employee_payment');
        }
    }

    public function vendor_employee_invoice() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['get_vendor'] = $this->vendor_model->getVendorLists();

        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetails($vendor_id);

        $data['page'] = "invoice";
        $data['meta_title'] = "INVOICES";

        $this->load->view('vendor/vendor_employee_invoice', $data);
    }

    public function vendor_invoice_pdf() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkInvoiceStatusVendor($invoice_id);
//echo $get_invoice_details[0]['employee_id'];
        $get_vendor_details = $this->employee_model->getVendorDetails($get_invoice_details[0]['vendor_id']);

        $assign_projects = "";
        $get_assign_project_details = $this->employee_model->getAssignProjectDtls($get_invoice_details[0]['employee_id'], $get_invoice_details[0]['vendor_id']);
        if (!empty($get_assign_project_details)) {
            foreach ($get_assign_project_details as $pval) {
                $get_project_details = $this->employee_model->getProjectData($pval['project_id']);
                $assign_projects .= $get_project_details[0]['project_code'] . ",";
                $data['assign_prject'] = $assign_projects;
            }
        } else {
            $data['assign_prject'] = $assign_projects;
        }

        $get_work_order_details = $this->employee_model->getWorkDetails($get_invoice_details[0]['employee_id']);

        $data['img_src'] = "./assets/images/pts.jpg";
        $data['dimension'] = "./assets/images/dimension.png";
        $data['get_vendor_details'] = $get_vendor_details;
        $data['get_invoice_details'] = $get_invoice_details;
        $data['get_work_order_details'] = $get_work_order_details;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);

        $this->load->library('html2pdf');

        $directory_name = './uploads/invoice_pdf/' . $get_vendor_details[0]['first_name'] . "_" . $get_vendor_details[0]['last_name'] . '/' . date("Y-m-d") . "/";

        $file_name = $get_invoice_details[0]['invoice_code'] . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        echo $this->load->view('admin/invoice_pdf', $data, true);
        exit();
    }

    public function insert_projects() {
        $db = get_instance()->db->conn_id;

        $vendor_id = $this->input->post('vendor_id');
        $project_type = $this->input->post('project_type');
        $project_name = $this->input->post('project_name');
        $project_details = mysqli_real_escape_string($db, $this->input->post('project_details'));
        $client_name = $this->input->post('client_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $approx_total_time = $this->input->post('approx_total_time');
        $monthly_payment = $this->input->post('monthly_payment');

        if (isset($project_type) && $project_type == '') {
            $this->session->set_flashdata('error_msg', 'Project Type ield cannot be blank');
            redirect(base_url() . 'add_projects');
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add_projects');
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url() . 'add_projects');
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url() . 'add_projects');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add_projects');
        } else {

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'project_type' => $project_type,
                'project_name' => $project_name,
                'project_details' => $project_details,
                'client_name' => $client_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'approx_total_time' => $approx_total_time,
                'monthly_payment' => $monthly_payment,
                'entry_date' => date("Y-m-d h:i:s"),
                'status' => '1'
            );

            $insert_query = $this->employee_model->add_projects($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Project added Successfully..');
                redirect(base_url() . 'add_projects');
            } else {
                $this->session->set_flashdata('error_msg', 'Project not added Successfully..');
                redirect(base_url() . 'add_projects');
            }
        }
    }

    public function generate_consultant_login_details() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['vendor_id'] = $vendor_id;
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "open_requirements";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('vendor/generate_consultant_login_details', $data);
    }

    public function generate_login_details() {
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);


        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate_consultant_login_details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate_consultant_login_details/' . base64_encode($employee_id));
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'generate_consultant_login_details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
            $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'employee_id' => $employee_id,
                'consultant_email' => $consultant_email,
                'password' => md5($consultant_password),
                'entry_date' => date("Y-m-d")
            );
//echo "<pre>";
//print_r($insert_arr);
//die;
            $insert_query = $this->employee_model->generate_login_details($insert_arr);

            if ($insert_query != '') {

                $update_arr = array(
                    'employee_email' => $consultant_email
                );
                $update_query = $this->employee_model->update_login_details($update_arr, $employee_id);

                $name_prefix = $get_employee_details[0]['name_prefix'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $consultant_email;
                $employee_password = $consultant_password;

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];

                $data['msg'] = "<p style='font-weight: 800;'>  Hi, " . $name_prefix . " " . ucwords($employee_name) . ", You have been hired for new project. Your login details are as follows:<br/></p>
                                                <p style='font-weight: 300;'>
                                                    <label><b>Login Details </b></label><br/>
                                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                                    <label><b>Temporary Password : </b>" . $employee_password . "</label><br/>
                                                </p>";
                $data['login_type'] = "employee";
                $msg = ucwords($vendor_name) . " is generated login details for " . ucwords($employee_name) . " successfully.";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System.');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();


                /* ----------------------------------Insert Mail------------------------------------ */

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => "Successfully Generated Login Details",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully..');
                redirect(base_url() . 'open_requirements');
            } else {
                $this->session->set_flashdata('error_msg', 'Login Details Not Generated Successfully..');
                redirect(base_url() . 'open_requirements');
            }
        }
    }

    public function consultant_onboarding() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['get_documents_details'] = $this->employee_model->getAllFiles();

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $data['page'] = "open_requirements";
        $data['meta_title'] = "CONSULTANT ONBOARDING";
        $this->load->view('vendor/consultant_documentation', $data);
    }

    public function upload_consultant_documents() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $employee_id = base64_decode($this->uri->segment(3));
        $data['employee_id'] = $employee_id;
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['page'] = "open_requirements";
        $data['doc_id'] = $doc_id;
        $data['get_document_details'] = $this->employee_model->getDocsDetails($doc_id);

        $data['meta_title'] = "UPLOAD DOCUMENTS";
        $this->load->view('vendor/upload_consultant_documents', $data);
    }

    public function upload_document() {
        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $employee_id = $this->input->post('employee_id');

        $check_prev_uploaded_document = $this->employee_model->checkPrevUploaded($doc_id, $employee_id);
        $check_approve_status = $this->employee_model->checkApproveStatus($doc_id, $employee_id);
        if ($check_prev_uploaded_document[0]['cnt'] > 0 && ($check_approve_status[0]['form_status'] == '1' || $check_approve_status[0]['admin_form_status'] == '1')) {
            $this->session->set_flashdata('error_msg', 'Document already approved.');
            redirect(base_url() . 'consultant_onboarding/' . base64_encode($employee_id));
        }

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
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                $errors[] = "'File size must be excately 2 MB";
            }

            if (empty($errors) == true) {

                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_consultant_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_consultant_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->employee_model->getDocsDetails($doc_id);
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $get_vendor_details = $this->employee_model->getVendorDetails($get_employee_details[0]['vendor_id']);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);

        $insert_arr = array(
            'consultant_id' => $employee_id,
            'form_no' => $doc_id,
            'form_name' => $get_document_details[0]['document_name'],
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s")
        );

        $del_query = $this->employee_model->deletePreviousDocs($doc_id, $employee_id);

        if ($del_query > 0) {
            $insert_query = $this->employee_model->add_employee_documents($insert_arr);

            if ($insert_query != '') {

                $employee_code = $get_employee_details[0]['employee_code'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_details[0]['admin_email'];

                $data['msg'] = ucwords($employee_code) . "-" . ucwords($employee_name) . " has uploaded " . ucwords($get_document_details[0]['document_name']) . " document. Please view and approve the documents.";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($superadmin_email);
                $this->email->cc($vendor_email);
                $this->email->subject('Pending Verification');
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
                redirect(base_url() . 'consultant_onboarding/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'consultant_onboarding/' . base64_encode($employee_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'consultant_onboarding/' . base64_encode($employee_id));
        }
    }

    public function insert_payment_comment() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $invoice_id = $this->input->post('invoice_id');
        $reply_id = $this->input->post('reply_id');
        $recipient_id = $this->input->post('recipient_id');
        $recipient_type = $this->input->post('recipient_type');
        $sender_id = $this->input->post('sender_id');
        $sender_type = $this->input->post('sender_type');
        $subject = $this->input->post('subject');
        $message = mysqli_real_escape_string($db, $this->input->post('message'));

        if (isset($message) && $message == '') {
            $this->session->set_flashdata('error_msg', 'Comments field cannot be blank');
            redirect(base_url() . 'vendor_notifications');
        } else {
            $get_invoice_details = $this->employee_model->checkInvoiceStatusVendor($invoice_id);
            $get_vendor_details = $this->employee_model->getVendorDetails($sender_id);
            $get_admin_details = $this->employee_model->getAdminDetails($recipient_id);
            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }

            $insert_arr = array(
                'invoice_id' => $invoice_id,
                'reply_id' => $reply_id,
                'recipient_id' => $recipient_id,
                'recipient_type' => $recipient_type,
                'sender_id' => $sender_id,
                'sender_type' => $sender_type,
                'subject' => $subject,
                'message' => $message,
                'is_vendor_view' => '1',
                'entry_date' => date("Y-m-d h:i:s")
            );
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_payment_mail($insert_arr);

            if ($insert_query != '') {

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $vendor_id = $sender_id;
                $vendor_name = ucwords($get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']);
                $vendor_email = $get_vendor_details[0]['vendor_email'];

                $admin_name = ucwords($get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']);
                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = $vendor_name . " has been commented against " . $get_invoice_details[0]['invoice_code'] . "<br> " . "<label><strong>Admin Name : </strong>" . $admin_name . "";
                $data['msg'] = $msg;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->subject($subject);
                $this->email->message($this->load->view('vendor/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $vendor_id,
                        "sender_type" => "vendor",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Comments sent Successfully.');
                redirect(base_url() . 'vendor_payment_comments/' . base64_encode($invoice_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Comments not sent Successfully..');
                redirect(base_url() . 'vendor_payment_comments/' . base64_encode($invoice_id));
            }
        }
    }

    public function vendor_payment_comments() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $invoice_id = base64_decode($this->uri->segment(2));
        $data['get_payment_details'] = $this->employee_model->getPaymentDetailsByInvoice($invoice_id);
        $data['get_payment_comments'] = $this->employee_model->getPaymentComments($invoice_id);
        $data['get_admin_details'] = $this->employee_model->getAdminDetails($data['get_details'][0]['admin_id']);
        $data['vendor_id'] = $vendor_id;
        $data['page'] = "payment";
        $data['meta_title'] = "COMMENTS";

        $this->load->view('vendor/vendor_payment_comments', $data);
    }

    public function con_view_period_timesheet() {
        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $this->load->view('vendor/con_view_period_timesheet', $data);
    }

    public function generate_con_invoice_by_vendor() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $timesheet_id = $this->input->post('t_id', TRUE);

        $get_timesheet_period_details = $this->employee_model->getPeriodDetails($timesheet_id);

        if (!empty($get_timesheet_period_details)) {
            $employee_id = $get_timesheet_period_details[0]['employee_id'];

            if ($get_timesheet_period_details[0]['status'] == '1') {

                $tot_time = 0;
                $ot_time = 0;

                $cal_st = $this->employee_model->getTotalST($timesheet_id);
                $cal_ot = $this->employee_model->getTotalOT($timesheet_id);

                $tot_time = $cal_st[0]['tot_time'];
                $ot_time = $cal_ot[0]['over_time'];

                $period_arr = explode("~", $get_timesheet_period_details[0]['period']);
                $start_date = $period_arr[0];
                $end_date = $period_arr[1];


                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                if (!empty($get_employee_details)) {

                    $pay_rate = 0;
                    $ot_rate = 0;
                    $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
                    if (!empty($get_emp_work_order)) {
                        $pay_rate = $get_emp_work_order[0]['bill_rate'];
                        $ot_rate = $get_emp_work_order[0]['ot_rate'];
                    }
                    $vendor_id = $get_employee_details[0]['vendor_id'];
                }

                $tot_time_pay = ($tot_time * $pay_rate);
                $over_time_pay = ($ot_time * $ot_rate);
                $approved_by_id = $vendor_id;
                $approved_by = "vendor";

                $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
//                echo "<pre>";
//                print_r($check_prev_generated_code);
//                die;
                if (!empty($check_prev_generated_code)) {
                    $inv_code = $check_prev_generated_code[0]['invoice_code'];
                } else {
                    $inv_code = "INV001";
                }
                $code = ltrim($inv_code, "INV");
                $invoice_code = "INV00" . ($code + 1);

                $insert_payment_arr = array(
                    "invoice_code" => $invoice_code,
                    "timesheet_period_id" => $timesheet_id,
                    "vendor_id" => $vendor_id,
                    "employee_id" => $employee_id,
                    "payment_type" => "1",
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "tot_time" => $tot_time,
                    "bill_rate" => $pay_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $ot_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "approved_by_id" => $approved_by_id,
                    "approved_by" => $approved_by,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "status" => "0"
                );
            }
        }
//                    echo "<pre>";
//                    print_r($insert_payment_arr);
//                    die;
        $insert_period_query = $this->employee_model->generateTimesheetInvoice($insert_payment_arr);

        if ($insert_period_query > 0) {
            echo "1";
        } else {
            echo "0";
        }
        /* ----------------------------------Insert Mail------------------------------------ */
//
//        $data['page'] = "employee_timesheet";
//        $data['meta_title'] = "CONSULTANT TIMESHEETS";
//
////        $this->load->view('vendor/employees_project_timesheet', $data);
//        $this->load->view('vendor/employees_project_timesheet', $data);
    }

    public function show_asp_emails() {

        $asp_emails = $this->employee_model->get_asp_emails();
        echo "<pre>";
        print_r($asp_emails);
        // $asp_email_arr = array();
        // foreach ($asp_emails as $asp_mail) {
        //     //$asp_email_arr[] .= $asp_mail;
        //     $asp_email_arr[] .= $asp_mail['sa_email'];
        // }
        // echo "------<br>";
        // print_r($asp_email_arr);
        exit;
    }

}
