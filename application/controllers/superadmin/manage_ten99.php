<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_ten99 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            if (US || INDIA) {
                set_referer_url();
            }
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $this->load->model('superadmin/manage_employee_model', 'employee_model');
		$this->load->model('superadmin/manage_ten99_model', 'ten99_model');
        $this->load->model('superadmin/manage_vendor_model', 'vendor_model');
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
    }


public function ten99_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
		
		//echo $email;
		
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_documents_details'] = $this->ten99_model->getDocumentsLists();

        $data['page'] = "ten99_documents";
        $data['meta_title'] = "ten99 DOCUMENTS";
        $this->load->view('superadmin/ten99_documents', $data);
    }
	
	public function add_ten99_documentations() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "ten99_documents";
        $data['meta_title'] = "ten99 DOCUMENTATIONS";

        $this->load->view('superadmin/add_ten99_documentations', $data);
    }
	
	public function insert_ten99_documentation_form() {
        $db = get_instance()->db->conn_id;
        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'add-vendor-doc');
        } else {


            if ($_FILES['file']['name'] != '') {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }
                $file_path = "./uploads/ten99/documents/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                if (empty($file_errors) == true) {

                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-doc');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-doc');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'document_name' => $document_name,
                'file' => $new_file_name,
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->ten99_model->add_ten99_documents($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Vendor Documents added Successfully.');
                redirect(base_url() . 'ten99-docs');
            } else {
                $this->session->set_flashdata('error_msg', 'Vendor Documents not added Successfully.');
                redirect(base_url() . 'ten99-docs');
            }
        }
    }

	 public function edit_ten99_documents() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['get_doc_details'] = $this->ten99_model->getten99DocsDetails($doc_id);

        $data['page'] = "ten99_documents";
        $data['meta_title'] = "ten99 DOCUMENTS";
        $this->load->view('superadmin/edit_ten99_documents', $data);
    }
	
	public function update_ten99_documentation_form() {
        $db = get_instance()->db->conn_id;

        $doc_id = base64_decode($this->input->post('doc_id'));
        $get_doc_details = $this->ten99_model->getten99DocsDetails($doc_id);

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
                $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                $errors[] = "'File size must be exactly 2 MB";
            }

            if (empty($errors) == true) {
                $file_path = "./uploads/ten99/documents/";
                $path = $file_path . $get_doc_details[0]['file'];
                if (file_exists($path)) {
                    unlink($path);
                }
                move_uploaded_file($file_tmp, "./uploads/ten99/documents/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "'File size must be exactly 2 MB";
                    redirect(base_url() . 'edit-ten99-documents/' . base64_encode($doc_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'edit-ten99-documents/' . base64_encode($doc_id));
                }
            }
        } else {
            $new_file_name = $get_doc_details[0]['file'];
        }

        $update_arr = array(
            'file' => $new_file_name
        );

        $update_query = $this->ten99_model->update_docs($update_arr, $doc_id);

        if ($update_query != '0') {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully.');
            redirect(base_url() . 'ten99-docs');
        } else {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully.');
            redirect(base_url() . 'ten99-docs');
        }
    }

	public function superadmin_ten99users_list() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_employee_details'] = $this->ten99_model->getten99Lists();

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USERS LISTS";
        $data['super_admin_email']=$email;
        $this->load->view('superadmin/superadmin_ten99users_list', $data);
    }

	public function add_superadmin_ten99_user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_admin'] = $this->employee_model->getAdminLists($email);
        $data['get_client'] = $this->employee_model->getClientLists();

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USER ADD";

        $this->load->view('superadmin/add_superadmin_ten99_user', $data);
    }
	
	public function insert_superadmin_ten99_user() {
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $client_id = $this->input->post('client_id');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_type = $this->input->post('employee_type');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $employee_ot_rate = $this->input->post('employee_ot_rate');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $date_of_joining = $this->input->post('date_of_joining');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

		echo $admin_id;
		
        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
        $check_last_id = $this->employee_model->checkAdminCount($admin_id);
        $count = $check_last_id[0]['cnt'] + 1;

        $words = explode(" ", $get_admin_details[0]['admin_company_name']);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $employee_code = strtoupper($acronym . "E") . str_pad($count, 3, "0", STR_PAD_LEFT);

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', '1099 User First Name cannot be blank');
            redirect(base_url() . 'add-superadmin-ten99-user');
        } elseif (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', '1099 User Last Name cannot be blank');
            redirect(base_url() . 'add-superadmin-ten99-user');
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', '1099 User Designation cannot be blank');
            redirect(base_url() . 'add-superadmin-ten99-user');
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', '1099 User Category cannot be blank');
            redirect(base_url() . 'add-superadmin-ten99-user');
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'add-superadmin-ten99-user');
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
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "File size must be exactly 2 MB";
                }

                if (empty($errors) == true) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-superadmin-ten99-user');
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
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $resume_errors[] = "File size must be exactly 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $resume_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            /* ---------------Resume-------------- */

// ---------------Pay Staff File--------------

            if ($_FILES['pay_staff_file']['name'] != '') {

                $pay_staff_file_errors = array();
                $pay_staff_file_name = $_FILES['pay_staff_file']['name'];
                $pay_staff_file_size = $_FILES['pay_staff_file']['size'];
                $pay_staff_file_tmp = $_FILES['pay_staff_file']['tmp_name'];
                $pay_staff_file_type = $_FILES['pay_staff_file']['type'];
                $pay_staff_file_ext_arr = explode('.', $pay_staff_file_name);
                $pay_staff_file_ext = strtolower($pay_staff_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_pay_staff_file_name = time() . rand(00, 99) . '.' . $pay_staff_file_ext;
                $pay_staff_file_expensions = array("pdf", "doc", "docx");

                if (in_array($pay_staff_file_ext, $pay_staff_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($pay_staff_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $pay_staff_file_errors[] = "File size must be exactly 2 MB";
                }

                if (empty($pay_staff_file_errors) == true) {

                    move_uploaded_file($pay_staff_file_tmp, "./uploads/" . $new_pay_staff_file_name);
                } else {
                    if ($pay_staff_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $pay_staff_file_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                    if (in_array($pay_staff_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                }
            } else {
                $new_pay_staff_file_name = "";
            }

// ---------------Pay Staff File--------------
// ---------------W2 File--------------

            if ($_FILES['w2_file']['name'] != '') {

                $w2_file_errors = array();
                $w2_file_name = $_FILES['w2_file']['name'];
                $w2_file_size = $_FILES['w2_file']['size'];
                $w2_file_tmp = $_FILES['w2_file']['tmp_name'];
                $w2_file_type = $_FILES['w2_file']['type'];
                $w2_file_ext_arr = explode('.', $w2_file_name);
                $w2_file_ext = strtolower($w2_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_w2_file_name = time() . rand(00, 99) . '.' . $w2_file_ext;
                $w2_file_expensions = array("pdf", "doc", "docx");

                if (in_array($w2_file_ext, $w2_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($w2_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $w2_file_errors[] = "File size must be exactly 2 MB";
                }

                if (empty($w2_file_errors) == true) {

                    move_uploaded_file($w2_file_tmp, "./uploads/" . $new_w2_file_name);
                } else {
                    if ($w2_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $w2_file_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                    if (in_array($w2_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-superadmin-ten99-user');
                    }
                }
            } else {
                $new_w2_file_name = "";
            }

// ---------------W2 File--------------

            $insert_arr = array(
                'admin_id' => $admin_id,
                'client_id' => $client_id,
                'employee_code' => $employee_code,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_type' => $employee_type,
                'employee_category' => $employee_category,
                'employee_designation' => $employee_designation,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'pay_staff_file' => $new_pay_staff_file_name,
                'w2_file' => $new_w2_file_name,
                'phone_ext' => $phone_ext,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'entry_date' => date("Y-m-d h:i:s"),
                'date_of_joining' => $date_of_joining,
                'employee_ot_rate' => $employee_ot_rate,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate,
                'emp_bill_rate_type' => $employee_bill_rate_type,
                'emp_pay_rate_type' => $employee_pay_rate_type,
            );
//echo "<pre>";
//print_r($insert_arr);
//die;
            $insert_query = $this->employee_model->add_employee_user($insert_arr);

            if ($insert_query != '') {

                $employee_name = $first_name . " " . $last_name;

                if ($employee_category == '1') {
                    $employee_category = "W2";
                } else if($employee_category == '2') {
                    $employee_category = "Subcontractor";
                }else if ($employee_category == '3')
				{$employee_category = "1099";}

                $name_prefix = $name_prefix;
                $employee_name = $first_name . " " . $last_name;
                $employee_code = $employee_code;
                $employee_category = $employee_category;
                $employee_designation = $employee_designation;

                $data['msg'] = "<p style='font-weight: 800;'>New 1099 user is added successfully. Employee Details are as follows : </p>
                                                <p style='font-weight: 300;'>
                                                    <label><strong>Employee Details : </strong></label><br/>
                                                    <label><strong>Employee Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                                                    <label><strong>Employee Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Designation : </strong>" . $employee_designation . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Category : </strong>" . $employee_category . "</label><br/>
                                                </p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('New 1099 user Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "<label><strong>" . ucwords($get_sadmin_details[0]['sa_name']) . "</strong></label>" . " " . " " . "<p style='font-weight: 800;'>has added new 1099 user successfully. Employee Details are as follows : </p>
                        <p style='font-weight: 300;'>
                            <label><strong>Employee Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                            <label><strong>Employee Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                            <label><strong>Employee Designation : </strong>" . $employee_designation . "</label><br/>
                            <label><strong>Employee Category : </strong>" . $employee_category . "</label><br/>
                        </p>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => "New 1099 User Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                $this->session->set_flashdata('succ_msg', '1099 User added Successfully..');
                redirect(base_url() . '1099-user');
            } else {
                $this->session->set_flashdata('error_msg', '1099 User not added Successfully..');
                redirect(base_url() . '1099-user');
            }
        }
    }
	
	public function edit_superadmin_ten99_user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);

        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_admin'] = $this->employee_model->getAdminLists($email);
        $data['get_client'] = $this->employee_model->getClientLists();

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USER EDIT";

        $this->load->view('superadmin/edit_superadmin_ten99_user', $data);
    }
	
	public function update_superadmin_ten99_user() {
        $db = get_instance()->db->conn_id;

        $employee_id = base64_decode($this->input->post('employee_id'));
        $client_id = $this->input->post('client_id');
        $employee_email = $this->input->post('employee_email');
        $new_password = $this->input->post('new_password');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
        $employee_ot_rate = $this->input->post('employee_ot_rate');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $employee_details = $this->employee_model->getEmployeeData($employee_id);
        $check_duplicate_email = $this->employee_model->checkDuplicate($employee_email);

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Employee Designation cannot be blank');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));

        } else if ( ($employee_email !== $employee_details[0]['employee_email']) && ($check_duplicate_email > 0) ) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Employee Category cannot be blank');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
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
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "File size must be exactly 2 MB";
                }

                if (empty($errors) == true) {
                    $old_file = "./uploads/" . $employee_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
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
                $resume_expensions = array("pdf");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $resume_errors[] = "File size must be exactly 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $resume_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit-superadmin-ten99-user/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

// ---------------Pay Staff File-------------- 

            if ($_FILES['pay_staff_file']['name'] != '') {

                $pay_staff_file_errors = array();
                $pay_staff_file_name = $_FILES['pay_staff_file']['name'];
                $pay_staff_file_size = $_FILES['pay_staff_file']['size'];
                $pay_staff_file_tmp = $_FILES['pay_staff_file']['tmp_name'];
                $pay_staff_file_type = $_FILES['pay_staff_file']['type'];
                $pay_staff_file_ext_arr = explode('.', $pay_staff_file_name);
                $pay_staff_file_ext = strtolower($pay_staff_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_pay_staff_file_name = time() . rand(00, 99) . '.' . $pay_staff_file_ext;
                $pay_staff_file_expensions = array("pdf", "doc", "docx");

                if (in_array($pay_staff_file_ext, $pay_staff_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($pay_staff_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $pay_staff_file_errors[] = "File size must be exactly 2 MB";
                }

                if (empty($pay_staff_file_errors) == true) {

                    move_uploaded_file($pay_staff_file_tmp, "./uploads/" . $new_pay_staff_file_name);
                } else {
                    if ($pay_staff_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $pay_staff_file_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'edit-superadmin-ten99-user');
                    }
                    if (in_array($pay_staff_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'edit-superadmin-ten99-user');
                    }
                }
            } else {
                $new_pay_staff_file_name = "";
            }

// ---------------Pay Staff File-------------- 
// ---------------W2 File-------------- 

            if ($_FILES['w2_file']['name'] != '') {

                $w2_file_errors = array();
                $w2_file_name = $_FILES['w2_file']['name'];
                $w2_file_size = $_FILES['w2_file']['size'];
                $w2_file_tmp = $_FILES['w2_file']['tmp_name'];
                $w2_file_type = $_FILES['w2_file']['type'];
                $w2_file_ext_arr = explode('.', $w2_file_name);
                $w2_file_ext = strtolower($w2_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_w2_file_name = time() . rand(00, 99) . '.' . $w2_file_ext;
                $w2_file_expensions = array("pdf", "doc", "docx");

                if (in_array($w2_file_ext, $w2_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
					//redirect(base_url() . 'edit-superadmin-ten99-user');
                }

                if ($w2_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $w2_file_errors[] = "File size must be exactly 2 MB";
				//	redirect(base_url() . 'edit-superadmin-ten99-user');
                }

                if (empty($w2_file_errors) == true) {

                    move_uploaded_file($w2_file_tmp, "./uploads/" . $new_w2_file_name);
                } else {
                    if ($w2_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $w2_file_errors[] = "File size must be exactly 2 MB";
                        redirect(base_url() . 'edit-superadmin-ten99-user');
                    }
                    if (in_array($w2_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'edit-superadmin-ten99-user');
                    }
                }
            } else {
                $new_w2_file_name = "";
            }

// ---------------W2 File-------------- 

            $update_arr = array(
                'client_id' => $client_id,
                'employee_email' => $employee_email,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_designation' => $employee_designation,
                'employee_category' => $employee_category,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'pay_staff_file' => $new_pay_staff_file_name,
                'w2_file' => $new_w2_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'date_of_joining' => $date_of_joining,
                'employee_ot_rate' => $employee_ot_rate,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate,
                'emp_bill_rate_type' => $employee_bill_rate_type,
                'emp_pay_rate_type' => $employee_pay_rate_type,
                'updated_date' => date("Y-m-d h:i:s")
            );
            $update_login_arr = array(
                'consultant_email' => $employee_email,
                'password'=>md5($new_password)
            );
            $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);
            $update_login_query = $this->employee_model->update_employee_login_user($update_login_arr, $employee_id);

            if ($update_query != '0') {

                $this->session->set_flashdata('succ_msg', '1099 User updated Successfully.');
                redirect(base_url() . '1099-user');
            } else {
                $this->session->set_flashdata('succ_msg', '1099 User updated Successfully.');
                redirect(base_url() . '1099-user');
            }
        }
    }
	
	 public function assign_project_to_ten99user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_projects'] = $this->employee_model->getProjectLists();
        $data['get_employees'] = $this->ten99_model->getten99Lists();

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "ASSIGN PROJECTS TO 1099 USER ";

        $this->load->view('superadmin/assign_ten99user_to_project', $data);
    }

	public function add_assign_ten99user_projects() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
//echo "<pre>";
//print_r($employee_ids);
//die;
        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-ten99user');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-ten99user');
        } else {
            $errors = array();
            $error = "";
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                $get_employee_details = $this->employee_model->getEmployeeData($eval);
                $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'status' => '2'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);

						
                        if ($get_employee_details[0]['employee_category'] == '1') {
                            $employee_category = "W2";
                        } else if($get_employee_details[0]['employee_category'] == '2'){
                            $employee_category = "Subcontractor";
                        }else {
                            $employee_category = "1099";
                        }


                        $data['msg'] = "<p style='font-weight: 800;'>Superadmin has assigned a new 1099 user to the following project. Project details and Employee details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label><?php echo ucwords($get_project_details[0]['project_name']); ?><br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details[0]['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Employee Details </label><br/>
                                            <label style='font-weight: bold;'>Employee Code : </label>" . strtoupper($get_employee_details['0']['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Employee Category : </label>" . $employee_category . "
                                        <br/>
                                        </p>";

                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $employee_email = $get_employee_details[0]['employee_email'];

//Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($admin_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
//Send mail
                        $this->email->send();

                        $error = "1";
                    }
                } else {
                    $get_employee_details = $this->employee_model->getEmployeeData($eval);
                    $errors[] = ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is Already Assigned.";
                }
            }
            if (!empty($errors)) {
                $this->session->set_flashdata('error_msg', $errors);
                redirect(base_url() . 'assign-projects-to-superadmin-ten99user');
            } else if ($error == '1') {

                $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                redirect(base_url() . '1099-user');
            }
        }
    }
	
	public function generate_ten99user_login_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;
        $data['sa_id'] = $sa_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('superadmin/generate_ten99user_login_details', $data);
	}
	
	public function insert_ten99user_login_details() {
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);


        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate-superadmin-ten99user-login-details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate-superadmin-ten99user-login-details/' . base64_encode($employee_id));
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'generate-superadmin-ten99user-login-details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

            $insert_arr = array(
                'admin_id' => $admin_id,
                'employee_id' => $employee_id,
                'consultant_email' => $consultant_email,
                'password' => md5($consultant_password),
                'entry_date' => date("Y-m-d")
            );

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

                $data['msg'] = "<p style='font-weight: 800;'>  Hi," . $name_prefix . " " . ucwords($employee_name) . ", You are successfully enrolled in Global Resource Management System. Your login details are as follows: <br/></p>
                                                <p style='font-weight: 300;'>
                                                    <label><b>Login Details </b></label><br/>
                                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                                    <label><b>Temporary Password : </b> " . $employee_password . "</label><br/>
                                                </p>";
                $data['login_type'] = "employee";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
                $employee_email = $consultant_email;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System.');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();


                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully.');
                redirect(base_url() . '1099-user');
            } else {
                $this->session->set_flashdata('succ_msg', 'Login Details Not Generated Successfully.');
                redirect(base_url() . '1099-user');
            }
        }
    }

	public function view_ten99user_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $client_id = 0;
        $is_uhg = 0;
		$is_jci = 0;
		
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
		//$emp_enrollment_type = $data['get_employee_details'][0]['emp_pay_rate_type'];
		
		
        if (!empty($data['get_employee_details'])) {
            $employee_type = $data['get_employee_details'][0]['employee_type'];
        }

        if ($employee_type == 'C') {
            $data['emp_type'] = "Consultant";
            $get_work_order_status = $this->employee_model->checkWorkOrderStatus($employee_id);
            if (!empty($get_work_order_status)) {
                $client_id = $get_work_order_status[0]['client_name'];
				
				//code to retrieve client name from client id
				$data['get_client_details'] = $this->employee_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
				echo $client_name;
            } else {
                $client_id = 0;
				$client_name = "";
            }
        } else if ($employee_type == 'E') {
            $data['emp_type'] = "Employee";
            $client_id = $data['get_employee_details'][0]['client_id'];
			
			//code to retrieve client name from client id
				$data['get_client_details'] = $this->employee_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
                //echo $client_name;
        }
		else if ($employee_type == '1099') {
            $data['emp_type'] = "1099";
            $client_id = $data['get_employee_details'][0]['client_id'];
			
			//code to retrieve client name from client id
				$data['get_client_details'] = $this->employee_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
                //echo $client_name;
        }

        if ($client_name == 'United Health Group') {
            $is_uhg = 1;
        } else {
            $is_uhg = 0;
        }
		
		if($client_name == 'JCI'){
			$is_jci = 1;
		}else{
			$is_jci = 0;
		}
		
        //$data['get_documents_details'] = $this->ten99_model->getAllFilesByClient($employee_type, $is_uhg, $is_jci, $emp_enrollment_type);
		
		$data['get_documents_details'] = $this->ten99_model->getAllFilesByClient($employee_type, $is_uhg, $is_jci);
        if ($employee_type == 'C') {
            $data['emp_type'] = "Consultant";
        } else if ($employee_type == 'E'){
            $data['emp_type'] = "Employee";
        }else{
			$data['emp_type'] = "1099";
		} 
		
		
        $data['get_sadmin_approve_status'] = $this->ten99_model->get_ucsis_sadmin_approve_status($employee_id);
        $data['get_emp_uscis_files'] = $this->employee_model->getUscisFiles($employee_id);
        $data['get_work_order_status'] = $this->employee_model->checkWorkOrderStatus($employee_id);
        $data['get_vms_emp_id_list_a'] = $this->employee_model->getvmsEmpIdListA();
        $data['get_vms_emp_id_list_b'] = $this->employee_model->getvmsEmpIdListB();
        $data['get_vms_emp_id_list_c'] = $this->employee_model->getvmsEmpIdListC();

        if ($employee_type == 'C') {
            $data['page'] = "employee_lists";
        } else if ($employee_type == 'E'){
            $data['page'] = "superadmin_employee_lists";
        }else{
			$data['page'] = "superadmin_ten99users_list";
		}

		
        $data['meta_title'] = strtoupper($data['emp_type']) . " DOCUMENTS";
		
		$emp_type = $data['emp_type'];
		//echo $emp_type;
		//echo "<pre>";
		//print_r($data);
        $this->load->view('superadmin/ten99users_documents', $data);
    }

	public function approve_disapprove_ten99user_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $recipients = array();

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
		
		
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        if (!empty($get_employee_details)) {

            $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_type = $get_employee_details[0]['employee_type'];
            $employee_email = $get_employee_details[0]['employee_email'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
            //$get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
            //$vendor_email = $get_vendor_details[0]['vendor_email'];
            //$vendor_id = $get_vendor_details[0]['vendor_id'];

            if (!empty($get_admin_details)) {
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                if (!empty($get_sadmin_details)) {
                    $sadmin_email = $get_sadmin_details[0]['sa_email'];
                }
            }
        }


        if ($ad == 'Approved') {
            $form_status = '1';
        } else if ($ad == 'Disapproved') {
            $form_status = '0';
        }

        if (!empty($check)) {

            $update_arr = array(
                "form_status" => $form_status,
                "updated_date" => date("Y-m-d h:i:s")
            );
            $msg = "";
            foreach ($check as $tid) {
                $check_sa_form_status = $this->ten99_model->check_docs_status($employee_id, $tid);
//                echo "<pre>";
                //print_r($check_sa_form_status);
                
                if ($form_status == '0') {
                    if ($check_sa_form_status[0]['form_status'] == '1') {
                        $change_status = $this->ten99_model->change_docs_status($update_arr, $employee_id, $tid);
                        $get_document_details = $this->ten99_model->getUploadedDocs($tid, $employee_id);
                        $msg .= ucwords($get_sadmin_details[0]['sa_name']) . " " . "is disapproved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                        $data['msg'] = $msg;
                    } else {
                        $change_status = 0;
                    }
                } else if ($form_status == '1') {
                    if ($check_sa_form_status[0]['form_status'] == '0') {
                        $change_status = $this->ten99_model->change_docs_status($update_arr, $employee_id, $tid);
                        $get_document_details = $this->ten99_model->getUploadedDocs($tid, $employee_id);
                        $msg .= ucwords($get_sadmin_details[0]['sa_name']) . " " . "is approved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                        $data['msg'] = $msg;
                    } else {
                        $change_status = 0;
                    }
                }
//                } 
            }
//echo $data['msg'];
//die;
            if ($change_status > 0) {


                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
//$admin_email = $email;
//Load email library
                $this->load->library('email');
                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($employee_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                } else {
                    $this->email->to($employee_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Documents Status Changed Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $employee_id . "_" . "employee";
                } else {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $employee_id . "_" . "employee";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => "Document Status Changed Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                $this->session->set_flashdata('succ_msg', 'Documents Status Changed Successfully');
                redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Something went wrong !');
                redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
            }
        }
        echo "<pre>";
        print_r($check);
        die;
    }
	
	public function upload_sa_ten99user_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
       
		$data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        
		$employee_id = base64_decode($this->uri->segment(3));
        $data['employee_id'] = $employee_id;
        $data['get_files'] = $this->ten99_model->getFiles($employee_id);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['page'] = "open_requirements";
        $data['doc_id'] = $doc_id;
        $data['get_document_details'] = $this->ten99_model->getDocsDetails($doc_id);
        $data['get_employee_details'] = $this->employee_model->getConsultantData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];

        $data['page'] = "ten99user_lists";
        $data['meta_title'] = "UPLOAD DOCUMENTS";
        $this->load->view('superadmin/upload_sa_ten99user_docs', $data);
    }
	
	
	public function upload_sa_ten99user_doc() {

        $recipients = array();

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $employee_id = $this->input->post('employee_id');

        $check_prev_uploaded_document = $this->ten99_model->checkPrevUploaded($doc_id, $employee_id);
        $check_approve_status = $this->ten99_model->checkApproveStatus($doc_id, $employee_id);
        if ($check_prev_uploaded_document[0]['cnt'] > 0 && ($check_approve_status[0]['form_status'] == '1' || $check_approve_status[0]['admin_form_status'] == '1')) {
            $this->session->set_flashdata('error_msg', 'Document already approved.');
            redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
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
                $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                $errors[] = "File size must be exactly 2 MB";
            }

            if (empty($errors) == true) {

                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "File size must be exactly 2 MB";
                    redirect(base_url() . 'upload_sa_ten99user_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_sa_ten99user_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->ten99_model->getDocsDetails($doc_id);
        $get_employee_details = $this->employee_model->getConsultantData($employee_id);
//        $get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
        $get_prev_uploaded_document = $this->ten99_model->getPrevUploaded($doc_id, $employee_id);


        if (!empty($get_prev_uploaded_document)) {

            $prev_doc = $get_prev_uploaded_document[0]['file'];
            $path = "./uploads/" . $prev_doc;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $del_query = $this->ten99_model->deletePreviousDocsbyID($doc_id, $employee_id);
        $insert_arr = array(
            'consultant_id' => $employee_id,
            'form_no' => $doc_id,
            'form_name' => $get_document_details[0]['document_name'],
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s")
        );
//        $del_query = $this->employee_model->deletePreviousDocs($doc_id, $employee_id);

        if ($del_query > 0) {
            $insert_query = $this->ten99_model->add_employee_documents($insert_arr);

            if ($insert_query != '') {

                $employee_code = $get_employee_details[0]['employee_code'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];
//                $vendor_id = $get_admin_details[0]['vendor_id'];
//                $vendor_email = $get_admin_details[0]['vendor_email'];

                $msg = ucwords($employee_code) . "-" . ucwords($employee_name) . " has uploaded " . ucwords($get_document_details[0]['document_name']) . " document. Please view and approve the documents.";
                $data['msg'] = $msg;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Pending Verification');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "Pending Verification",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
                redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'view_superadmin_ten99user_documents/' . base64_encode($employee_id));
        }
    }

	public function view_superadmin_ten99user_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
//        echo $get_vendor_id->vendor_id;
//        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmp($employee_id);
        $data['get_timesheet_details_nt_approved'] = $this->employee_model->getTimesheetDetailsnotapprove($employee_id);
        $data['get_timesheet_details_pending'] = $this->employee_model->getTimesheetDetailspending($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USER TIMESHEET";
//        $this->load->view('superadmin/con_project_timesheet', $data);
        $this->load->view('superadmin/ten99user_ncon_project_timesheet', $data);
    }
	
	
	 public function ten99user_con_view_period_timesheet() {
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
		
		//print_r($data);
		
        $this->load->view('superadmin/ten99user_con_view_period_timesheet', $data);
    }
	
	public function ten99user_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_type = "E";
        $get_employee_details = $this->ten99_model->getEmployeeListsbyType();
        $ncon_str = "";
        $emp_str = "";
        foreach ($get_employee_details as $eval) {
            $ncon_str .= $eval['employee_id'] . ",";
        }
        $emp_str = rtrim($ncon_str, ",");
//        echo "<pre>";
//       echo $con_str;
//       die; 

        $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet($emp_str);
        $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet($emp_str);
        $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet($emp_str);
//       echo "<pre>";
//       print_r( $data['get_approved_timesheet_details'] );
//       die;


        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "1099 USERS LISTS";
        $this->load->view('superadmin/sadmin_new_ten99user_timesheet', $data);
    }

	public function add_ten99user_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_employee_lists'] = $this->ten99_model->getEmployeeListsbyType();
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "ADD 1099 USER TIMESHEET";
        $this->load->view('superadmin/add_ten99user_timesheet', $data);
    }
	
	public function get_ten99user_project_list() {
        $employee_id = $this->input->post('employee_id', TRUE);
        $data['get_project_list'] = $this->employee_model->getEmpProjectLists($employee_id);
        $this->load->view('superadmin/ajax/ajax_get_ten99user_project_lists', $data);
    }

    public function ajax_ten99user_timesheet_list() {

        $project_id = $this->input->post('project_id', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);
        $project_code = $data['get_project_details'][0]['project_code'];
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        //--------------------------------Generate Timesheet ID------------------

        $timesheet_id = "";
        $tcount = 0;
        $check_timesheet = $this->employee_model->checkTimesheetPeriod($project_id);
        //echo $check_timesheet[0]['cnt'];
        if (!empty($check_timesheet)) {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        } else {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        }
        //echo $timesheet_id;
        $data['timesheet_id'] = $timesheet_id;
        //--------------------------------Generate Timesheet ID------------------

        $this->load->view('superadmin/ajax/ajax_get_ten99user_timesheet_list', $data);
    }

    public function insert_new_ten99user_timesheet() {
        $db = get_instance()->db->conn_id;

        $employee_id = $this->input->post('employee_id');
        $project_id = $this->input->post('project_id');
        $timesheet_id = $this->input->post('timesheet_id');
        $period = $this->input->post('period');
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $project_date = $this->input->post('project_date');
        $st = $this->input->post('st');
        $ot = $this->input->post('ot');
//        $start_time_mm = $this->input->post('start_time_mm');
//        $start_time_type = $this->input->post('start_time_type');
//
//        $end_time_mm = $this->input->post('end_time_mm');
//        $end_time_type = $this->input->post('end_time_type');
//
//
//        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));
//        $billable = $this->input->post('billable');

        if (isset($project_id) && $project_id == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add-ten99user-timesheet');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-ten99user-timesheet');
        } else if (isset($end_date) && $end_date == '') {
            $this->session->set_flashdata('error_msg', 'End Date field cannot be blank');
            redirect(base_url() . 'add-ten99user-timesheet');
        } else {


            $insert_arr = array(
                'project_id' => $project_id,
                'employee_id' => $employee_id,
                'timesheet_id' => $timesheet_id,
                'period' => $period,
                'comment' => $comment,
                'entry_date' => date("Y-m-d h:i:s")
            );
//            echo "<pre>";
//            print_r($insert_arr);
//            die;
//            $n_start_time = date("g:i a", strtotime($start_time));
//            $n_end_time = date("g:i a", strtotime($end_time));

            $insert_query = $this->employee_model->add_timesheet_period($insert_arr);

            if ($insert_query != '') {
                $i = 0;
                foreach ($project_date as $date) {

                    $c_start_time = $start_time[$i];
                    $c_end_time = $end_time[$i];

                    $working_time = "08:00";
                    $t1 = new DateTime("" . $date . " " . $c_start_time . "");
                    $t2 = new DateTime("" . $date . " " . $c_end_time . "");
                    $interval = $t1->diff($t2);
                    $approx_tot_time = $interval->format('%H:%I');

                    if ($approx_tot_time > "08:00") {
                        $w_time = new DateTime("" . $date . " 08:00");
                    } else {
                        $w_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    }

                    $at_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    $ot_interval = $w_time->diff($at_time);
                    $ot_time = $ot_interval->format('%H:%I');

                    if ($ot_interval->format('%I') > 30) {
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
                        $m_ot_time = $fecha->modify('+ 1 hour');
                        $over_time = $m_ot_time->format('g');
                        $tot_time = $w_time->format('g');
                    } else {
//                $ot_time = "01:00";
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
//                echo $fecha->format('g');
                        if ($fecha->format('g') != '12') {
                            $over_time = $fecha->format('g');
                        } else {
                            $over_time = "0";
                        }
                        $tot_time = $w_time->format('g');
                    }

                    if($start_time[$i] == '00:00' && $end_time[$i]== '00:00'){
                        $c_start_time = '0.00';
                        $c_end_time = '0.00';
                        $tot_time = '0.00';
                        $over_time = '0.00';
                    }
                    $insert_timesheet_arr = array(
                        'timesheet_period_id' => $insert_query,
                        'project_id' => $project_id,
                        'employee_id' => $employee_id,
                        'project_date' => $date,
                        'start_time' => $c_start_time,
                        'end_time' => $c_end_time,
                        'tot_time' => $tot_time,
                        'over_time' => $over_time,
                        'entry_date' => date("Y-m-d h:i:s"),
                    );
                    $insert_timesheet_query = $this->employee_model->add_timesheet($insert_timesheet_arr);

                    $i++;
                }
//                die();
//                $get_employee_dtls = $this->timesheet_model->getEmployeeData($employee_id);
//                $get_vendor_id = $this->timesheet_model->getVendorID($employee_id, $project_id);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $get_vendor_dtls = $this->timesheet_model->getVendorData($get_vendor_id[0]['vendor_id']);
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_vendor_dtls[0]['admin_id']);
//                        $vendor_email = $get_vendor_dtls[0]['vendor_email'];
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                        $data['vendor_name'] = $get_vendor_dtls[0]['first_name'] . " " . $get_vendor_dtls[0]['last_name'];
//                    } else {
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_employee_dtls[0]['admin_id']);
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                    }
//                }
//
//
//                $data['get_project_details'] = $this->timesheet_model->getProjectData($project_id);
//                $data['project_date'] = $tasks_date;
//                $data['start_time'] = $n_start_time;
//                $data['end_time'] = $n_end_time;
//                $data['tot_time'] = $tot_time;
//                $data['over_time'] = $over_time;
//                $data['comment'] = $comment;
//
//                $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
//
//
//                $subject = ucwords($employee_name) . " Added New Timesheet.";
//                $data['subject'] = $subject;
//
//
//                $from_email = REPLY_EMAIL;
//                $superadmin_email = SUPERADMIN_EMAIL;
//
//                //Load email library
//                $this->load->library('email');
//
//                $this->email->from($from_email);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $this->email->to($admin_email);
//                        $this->email->cc($vendor_email);
//                        $this->email->bcc($superadmin_email);
//                    } else {
//                        $this->email->to($admin_email);
//                        $this->email->bcc($superadmin_email);
//                    }
//                }
//
//                $this->email->subject($subject);
//                $this->email->message($this->load->view('employee/email_template/timesheet_add_email_template', $data, true));
//                $this->email->set_mailtype('html');
//                //Send mail
//                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'Timesheet added Successfully.');
                redirect(base_url('ten99user-timesheet'));
            } else {
                $this->session->set_flashdata('error_msg', 'Timesheet not added Successfully.');
                redirect(base_url('ten99user-timesheet'));
            }
        }
    }

	 public function sadmin_view_ten99user_period_timesheet() {
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

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "TIMESHEET LISTS";

        $this->load->view('superadmin/sadmin_view_ten99user_period_timesheet', $data);
    }

	
	public function ten99user_onboarding() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];
        $data['get_documents_details'] = $this->ten99_model->getDocumentsLists();
        $data['get_files'] = $this->ten99_model->getFiles($employee_id);
        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USER ONBOARDING";
		
		//echo "<pre>";
		//print_r($data);
		
        $this->load->view('superadmin/ten99user_documentation', $data);
    }

	
	public function delete_ten99_user() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $recipients = array();
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_sa_dtls = $this->profile_model->getDetails($email);
        $sa_id = $get_sa_dtls[0]['sa_id'];

        $employee_id = base64_decode($this->input->post('employee_id'));
        $check_employee_dtls = $this->employee_model->checkEmployee($employee_id);

        if (!empty($check_employee_dtls)) {
            echo "3";
//redirect(base_url() . 'admin-user');
        } else {
            $update_arr = array(
                "is_delete" => "1"
            );
            $update_query = $this->employee_model->deleteEmployeeUser($update_arr, $employee_id);
//            echo $update_query;
//            die;

            $get_employee_dtls = $this->employee_model->getEmployeeData($employee_id);
//            echo "<pre>";
//            print_r($get_employee_dtls);
//            die;
            if (!empty($get_employee_dtls)) {
                if (($get_employee_dtls[0]['employee_type']) == 'C') {
                    $get_vendor_dtls = $this->employee_model->getVendorData($get_employee_dtls[0]['vendor_id']);
                    $get_admin_dtls = $this->employee_model->getAdminData($get_employee_dtls[0]['admin_id']);
                    $get_sadmin_dtls = $this->employee_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

                    $name_prefix = $get_employee_dtls[0]['name_prefix'];
                    $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
                    $e_email = $get_employee_dtls[0]['employee_email'];
                } else if(($get_employee_dtls[0]['employee_type']) == 'E') {
                    $get_admin_dtls = $this->employee_model->getAdminData($get_employee_dtls[0]['admin_id']);
                    $get_sadmin_dtls = $this->employee_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

                    $name_prefix = $get_employee_dtls[0]['name_prefix'];
                    $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
                    $e_email = $get_employee_dtls[0]['employee_email'];
                }
				else {
                    $get_admin_dtls = $this->employee_model->getAdminData($get_employee_dtls[0]['admin_id']);
                    $get_sadmin_dtls = $this->employee_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

                    $name_prefix = $get_employee_dtls[0]['name_prefix'];
                    $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
                    $e_email = $get_employee_dtls[0]['employee_email'];
                }
            }

            if ($update_query > 0) {

                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                                <p style='font-weight: 300;'> " . ucwords($get_sa_dtls[0]['sa_name']) . " has deleted " . $name_prefix . " " . ucwords($employee_name) . " from GRMS .</p>
                                <p><strong>Email ID : </strong>" . $e_email . "</p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                if (($get_employee_dtls[0]['employee_type']) == 'C') {

                    $admin_email = $get_admin_dtls[0]['admin_email'];
                    $vendor_email = $get_vendor_dtls[0]['vendor_email'];
                    $consultant_email = $e_email;

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($consultant_email);
                    $this->email->bcc($vendor_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($get_sadmin_dtls[0]['sa_email']);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Consultant is deleted from Global Resource Management System');
                } else if (($get_employee_dtls[0]['employee_type']) == 'E') {
                    $admin_email = $get_admin_dtls[0]['admin_email'];
                    $consultant_email = $e_email;

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($consultant_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($get_sadmin_dtls[0]['sa_email']);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Employee is deleted from Global Resource Management System');
                }else {
                    $admin_email = $get_admin_dtls[0]['admin_email'];
                    $consultant_email = $e_email;

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($consultant_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($get_sadmin_dtls[0]['sa_email']);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('1099 User is deleted from Global Resource Management System');
                }
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if (($get_employee_dtls[0]['employee_type']) == 'C') {
                    $msg = "SUPER ADMIN has deleted consultant successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($employee_name) . "</label><br/>
                            <label><strong>Consultant Email : </strong>" . $e_email . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_vendor_dtls[0]['vendor_id'] . "_" . "vendor";
                    $sub = "Consultant deleted from Global Resource Management System";
                } else if  (($get_employee_dtls[0]['employee_type']) == 'E') {
                    $msg = "SUPER ADMIN has deleted employee successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($employee_name) . "</label><br/>
                            <label><strong>Employee Email : </strong>" . $e_email . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['admin_id'] . "_" . "admin";
                    $sub = "Employee deleted from Global Resource Management System";
                } else{
                    $msg = "SUPER ADMIN has deleted 1099 User successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($employee_name) . "</label><br/>
                            <label><strong>Employee Email : </strong>" . $e_email . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['admin_id'] . "_" . "admin";
                    $sub = "Employee deleted from Global Resource Management System";
                }

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => $sub,
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


                echo "1";
            } else {
                echo "0";
            }
        }
    }

	public function add_admin_ten99user_work_order() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
		
        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $vendor_id = $get_employee_details[0]['vendor_id'];
         $data['get_employee_details'] = $get_employee_details;
		
		//echo "<pre>";
		//print_r($get_employee_details);
		
		$admin_id = $data['get_employee_details'][0]['admin_id'];
		$data['get_admin_details'] = $this->profile_model->getAdminData($admin_id);

        $data['vendor_id'] = $vendor_id;
        $data['admin_id'] = $admin_id;
        $data['employee_id'] = $employee_id;

       
       // $data['get_vendor_details'] = $this->employee_model->getVendorDtls($vendor_id);
        //$data['get_vendor_details'] = $vendor_id;
		$data['get_client_details'] = $this->employee_model->getClientDetails();
        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "EMPLOYEE WORK ORDER";

        $this->load->view('superadmin/add_sadmin_ten99user_work_order', $data);
    }
	
	public function insert_sadmin_ten99user_work_order() {
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
        $vendor_poc_name = $this->input->post('vendor_poc_name');
        $vendor_poc_designation = $this->input->post('vendor_poc_designation');

		//details to send mails.
		if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
		$get_sadmin_details = $this->employee_model->getSuperAdminData($sa_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }

        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add_sadmin_ten99user_work_order/' . base64_encode($employee_id)));
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
                'vendor_poc_name' => $vendor_poc_name,
                'vendor_poc_designation' => $vendor_poc_designation,
                'entry_date' => date("Y-m-d h:i:s")
            );
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_work_order($insert_arr);

            if ($insert_query != '') {

                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
                $data['company_id'] = $get_vendor_details[0]['company_id'];

                $get_admin_email = $this->vendor_model->getAdminEmail($get_vendor_details[0]['admin_id']);

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_email[0]['admin_email'];
                $admin_name = ucwords($get_admin_email[0]['first_name'] . " " . $get_admin_email[0]['last_name']);
                $data['msg'] = ucwords($admin_name) . " added work order for " . ucwords($employee_name);
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($superadmin_email);
                $this->email->subject('Work Order Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

				
				/* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br>" . ucwords($sa_name) . " has added work order for " . ucwords($employee_name). "."; 
                        
                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "Work Order Added Successfully!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */
				
                $this->session->set_flashdata('succ_msg', 'Work Order Added Successfully..');
                redirect(base_url() . '1099-user');
            } else {
                $this->session->set_flashdata('error_msg', 'Work Order Not Added Successfully..');
                redirect(base_url() . '1099-user');
            }
        }
    }

	public function edit_sadmin_ten99user_work_order() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;

        $data['get_work_details'] = $this->employee_model->getWorkDetails($employee_id);
        $data['get_vendor_details'] = $this->employee_model->getVendorDtls($data['get_work_details'][0]['vendor_id']);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_admin_details'] = $this->employee_model->getAdminData($data['get_employee_details'][0]['admin_id']);
        $data['get_client_details'] = $this->employee_model->getClientDetails();

        $data['page'] = "superadmin_ten99users_list";
        $data['meta_title'] = "1099 USER WORK ORDER";

        $this->load->view('superadmin/edit_sadmin_ten99user_work_order', $data);
    }

    public function update_sadmin_ten99user_work_order() {
		
		$sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_details = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

		
		//details to send mail
		$data['get_details'] = $this->profile_model->getDetails($email);
		 $sa_id = $data['get_details'][0]['sa_id'];
		$get_sadmin_details = $this->employee_model->getSuperAdminData($sa_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }
				
//$admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant = $this->input->post('consultant');
        $start_date = $this->input->post('start_date');
        $client_name = $this->input->post('client_name');
        $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
        $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
        $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
        $bill_rate = $this->input->post('bill_rate');
        $ot_rate = $this->input->post('ot_rate');
        $vendor_poc_name = $this->input->post('vendor_poc_name');
        $vendor_poc_designation = $this->input->post('vendor_poc_designation');
        $approved_by_superadmin = $this->input->post('approved_by_superadmin');

        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
            redirect(base_url('edit-sadmin-ten99user-work-order/' . base64_encode($employee_id)));
        } else {

            $update_arr = array(
                'consultant' => $consultant,
                'start_date' => $start_date,
                'client_name' => $client_name,
                'project_duration' => $project_duration,
                'invoicing_terms' => $invoicing_terms,
                'payment_terms' => $payment_terms,
                'bill_rate' => $bill_rate,
                'ot_rate' => $ot_rate,
                'vendor_poc_name' => $vendor_poc_name,
                'vendor_poc_designation' => $vendor_poc_designation,
                'approved_by_superadmin' => $approved_by_superadmin,
                'updated_date' => date("Y-m-d h:i:s")
            );

            $update_query = $this->employee_model->update_work_order($update_arr, $employee_id);
			
			//to send mails
			
			$get_employee_details = $this->employee_model->getEmployeeData($employee_id);
			$employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

			/* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br>" . ucwords($sa_name) . " has updated work order for " . ucwords($employee_name). "."; 
                        
                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "Work Order updated Successfully!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */
			
			
            if ($update_query != '') {

                $this->session->set_flashdata('succ_msg', 'Work order updated Successfully..');
                redirect(base_url() . '1099-user');
            } else {
                $this->session->set_flashdata('error_msg', 'Work order not updated Successfully..');
                redirect(base_url() . '1099-user');
            }
        }
    }

	 public function view_sadmin_ten99user_work_order_pdf() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        $get_vendor_details = $this->employee_model->getVendorDtls($get_employee_details[0]['vendor_id']);

        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->view('superadmin/view_ten99user_work_order_pdf', $data);
    }

	public function sadmin_approve_disapprove_ten99user_timesheet_period() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $recipients = array();
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $timesheet_period_id = $this->input->post('timesheet_period_id', TRUE);
        $sadmin_comment = $this->input->post('sadmin_comment', TRUE);

        if ($ad == 'Approved') {
            $approved_by_status = '1';
        } else if ($ad == 'Disapproved') {
            $approved_by_status = '0';
        }

        if (!empty($check)) {
            //echo $ad;
            //die;
            if ($ad == 'Save') {


                foreach ($check as $time_id) {
                    $tot_time = $this->input->post('tot_time_' . $time_id);
                    $over_time = $this->input->post('over_time_' . $time_id);

                    if ($tot_time != '') {
                        $tot_time = $tot_time;
                    } else {
                        $tot_time = 0;
                    }

                    if ($over_time != '') {
                        $over_time = $over_time;
                    } else {
                        $over_time = 0;
                    }

                    $update_arr = array(
                        "tot_time" => $tot_time,
                        "over_time" => $over_time
                    );

                    //echo "<pre>";
                    //print_r($update_arr);
                    $change_status_sv = $this->employee_model->changeEachTimesheetStatus($update_arr, $time_id);
                }

                // if ($change_status_sv > 0) {
                $this->session->set_flashdata('succ_msg', 'Total Time Has Been Saved !');
                redirect(base_url() . 'sadmin-view-ten99user-period-timesheet/' . base64_encode($timesheet_period_id));
//                } else {
//                    $this->session->set_flashdata('error_msg', 'Something went wrong. !');
//                    redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
//                }
            } else {
                $update_arr = array(
                    "approved_by_status" => $approved_by_status,
                );

                foreach ($check as $tid) {
                    $change_status = $this->employee_model->changeEachTimesheetStatus($update_arr, $tid);
                }
                //echo $change_status;
//                die;

                if ($change_status > 0) {
                    $pstatus = array();

                    $get_period_details = $this->employee_model->getTimesheetPeriodDetails($timesheet_period_id);
//                    echo "<pre>";
//                    print_r($get_period_details);
//                    die();
//                    
                    foreach ($get_period_details as $pval) {
                        $pstatus[] = $pval['approved_by_status'];
                    }
                    if (in_array("0", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "0",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    } elseif (in_array("1", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "1",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    } elseif (in_array("2", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "2",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    }
//                    echo "<pre>";
//                    print_r($update_p_arr);
//                    die;

                    $change_period_status = $this->employee_model->changePeriodTimesheetStatus($update_p_arr, $timesheet_period_id);

                    $get_timesheet_period_details = $this->employee_model->getPeriodDetails($timesheet_period_id);

                    if (!empty($get_timesheet_period_details)) {
                        if ($get_timesheet_period_details[0]['status'] == '1') {


                            $tot_time = 0;
                            $ot_time = 0;

                            $cal_st = $this->employee_model->getTotalST($timesheet_period_id);
                            $cal_ot = $this->employee_model->getTotalOT($timesheet_period_id);

                            $tot_time = $cal_st[0]['tot_time'];
                            $ot_time = $cal_ot[0]['over_time'];

                            $period_arr = explode("~", $get_timesheet_period_details[0]['period']);
                            $start_date = $period_arr[0];
                            $end_date = $period_arr[1];


                            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                            if (!empty($get_employee_details)) {

                                $pay_rate = 0;
                                $ot_rate = 0;
                                $pay_rate_type = '';

                                if ($get_employee_details[0]['employee_type'] == 'C') {

                                    $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
                                    if (!empty($get_emp_work_order)) {
                                        $pay_rate = $get_emp_work_order[0]['bill_rate'];
                                        $ot_rate = $get_emp_work_order[0]['ot_rate'];
                                        $tot_time_pay = ($tot_time * $pay_rate);
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    }
                                    $vendor_id = $get_employee_details[0]['vendor_id'];
                                } elseif ($get_employee_details[0]['employee_type'] == 'E') {
                                    $pay_rate_type = $get_employee_details[0]['emp_pay_rate_type'];
                                    $pay_rate = $get_employee_details[0]['employee_pay_rate'];
                                    $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                                    if ($pay_rate_type == 'hourly') {
                                        $tot_time_pay = ($tot_time * $pay_rate);
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    } elseif ($pay_rate_type == 'yearly') {
                                        $tot_time_pay = ($tot_time * ($pay_rate / 2080));
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    }
                                    $vendor_id = 0;
                                }elseif ($get_employee_details[0]['employee_type'] == '1099') {
                                     $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
                                    if (!empty($get_emp_work_order)) {
										
										$pay_rate_type = $get_employee_details[0]['emp_pay_rate_type'];
										$pay_rate = $get_employee_details[0]['employee_pay_rate'];
										$ot_rate = $get_employee_details[0]['employee_ot_rate'];
										
										if ($pay_rate_type == 'hourly') {
											$tot_time_pay = ($tot_time * $pay_rate);
											$over_time_pay = ($ot_time * $ot_rate);
										} elseif ($pay_rate_type == 'yearly') {
											$tot_time_pay = ($tot_time * ($pay_rate / 2080));
											$over_time_pay = ($ot_time * $ot_rate);
										}
										$vendor_id = 0;
									}
                                }
								
                            }


                            $approved_by_id = $sa_id;
                            $approved_by = "superadmin";

                            $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
                            $code = ltrim($check_prev_generated_code[0]['invoice_code'], "INV");
                            $invoice_code = "INV00" . ($code + 1);

                            $insert_payment_arr = array(
                                "invoice_code" => $invoice_code,
                                "timesheet_period_id" => $timesheet_period_id,
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
                                "updated_date" => date("Y-m-d h:i:s"),
                                "status" => "1"
                            );

                            $check_prev_invoice = $this->employee_model->getPrevInvoice($timesheet_period_id, $employee_id, $vendor_id, $start_date, $end_date);

                            if ($check_prev_invoice[0]['cnt'] > 0) {
                                $update_i_arr = array(
                                    "status" => "1"
                                );
                                $update_invoice_query = $this->employee_model->DeleteInvoice($update_i_arr, $timesheet_period_id);
                                $this->session->set_flashdata('succ_msg', 'Invoice has already generated');
                                redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                            } else {
                                $insert_period_query = $this->employee_model->generateTimesheetInvoice($insert_payment_arr);
                            }
                        } else if ($get_timesheet_period_details[0]['status'] == '0') {
                            $update_i_arr = array(
                                "status" => "2"
                            );
                            $update_invoice_query = $this->employee_model->DeleteInvoice($update_i_arr, $timesheet_period_id);
                        }
                    }

//                    echo "<pre>";
//                    print_r($insert_payment_arr);
//                    die;




                    /* ----------------------------------Insert Mail------------------------------------ */

                    $this->session->set_flashdata('succ_msg', 'Timesheet Status Changed Successfully');
                    redirect(base_url() . 'sadmin-view-ten99user-period-timesheet/' . base64_encode($timesheet_period_id));
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong !!');
                    redirect(base_url() . 'sadmin-view-ten99user-period-timesheet/' . base64_encode($timesheet_period_id));
                }
            }
        }
    }

}