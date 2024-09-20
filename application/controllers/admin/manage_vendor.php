<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) {
            if (US || INDIA) {
                set_referer_url();
            }
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        $this->load->model('admin/profile_model');
        $this->load->model('admin/manage_communication_model', 'communication_model');
    }

    public function index() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_country'] = $this->vendor_model->getCountry();

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR ADD";

        $this->load->view('admin/add_vendor_user', $data);
    }

    public function add_vendor() {

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $name_prefix = $this->input->post('name_prefix');
        if (LATAM) {
            $vendor_tier = $this->input->post('vendor_tier');
        }
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $vendor_designation = $this->input->post('vendor_designation');
        $vendor_company_name = $this->input->post('vendor_company_name');
        $company_id = $this->input->post('company_id');
        $federal_tax_id = $this->input->post('federal_tax_id');
        $vendor_email = $this->input->post('vendor_email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $contract_from_date = $this->input->post('contract_from_date');
        $contract_to_date = date('Y-m-d', strtotime('+1 year', strtotime($contract_from_date)));
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $remittance_address = mysqli_real_escape_string($db, $this->input->post('remittance_address'));
        $main_contact_person = $this->input->post('main_contact_person');
        $main_email_address = $this->input->post('main_email_address');
        $main_phone_no = $this->input->post('main_phone_no');
        $billing_contact_person = $this->input->post('billing_contact_person');
        $billing_email_address = $this->input->post('billing_email_address');
        $billing_phone_no = $this->input->post('billing_phone_no');
        $additional_contact_person = $this->input->post('additional_contact_person');
        $additional_email_address = $this->input->post('additional_email_address');
        $additional_phone_no = $this->input->post('additional_phone_no');
        $client_support_cal = $this->input->post('client_support_cal');
        $client_support_pen = $this->input->post('client_support_pen');
        $client_support_pu = $this->input->post('client_support_pu');
        $nmsdc = $this->input->post('nmsdc');
        $wbenc = $this->input->post('wbenc');
        $sba = $this->input->post('sba');
        $vetbiz = $this->input->post('vetbiz');
        $nglcc = $this->input->post('nglcc');

        $status = '0';
        $block_status = '0';
        $reg_verification = '1';

        $vendor_details = $this->vendor_model->getDetails($vendor_email);

//        print_r($vendor_details);
//die;
        $check_duplicate_email = $this->vendor_model->checkDuplicate($vendor_email);

//        print_r($check_duplicate_email);
//        die;

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'add-vendor-user');
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'add-vendor-user');
        } else if (isset($vendor_email) && $vendor_email == '') {
            $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'add_admin_vendor');
        } else if (isset($password) && $password == '' && isset($conf_password) && $conf_password == '') {

            $this->session->set_flashdata('error_msg', 'Password fields cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'add_admin_vendor');
        } else {


            /* ---------------------------Photo Upload-------------------------------- */

            if ($_FILES['photo']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['photo']['name'];
                $file_size = $_FILES['photo']['size'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $file_type = $_FILES['photo']['type'];
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
                        redirect(base_url() . 'add_admin_vendor');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add_admin_vendor');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------------------Photo Upload-------------------------------- */

            /* ---------------------------------Files Uploads--------------------------- */
            $expensions = array("pdf");

            if ($_FILES['client_support_cal_file']['name'] != '') {

                $client_support_cal_file_errors = array();
                $client_support_cal_file_name = $_FILES['client_support_cal_file']['name'];
                $client_support_cal_file_size = $_FILES['client_support_cal_file']['size'];
                $client_support_cal_file_tmp = $_FILES['client_support_cal_file']['tmp_name'];
                $client_support_cal_file_type = $_FILES['client_support_cal_file']['type'];
                $client_support_cal_file_ext_arr = explode('.', $client_support_cal_file_name);
                $client_support_cal_file_ext = strtolower($client_support_cal_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_cal_file_name = time() . rand(00, 99) . '.' . $client_support_cal_file_ext;


                if (in_array($client_support_cal_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_cal_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_cal_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_cal_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_cal_file_errors) == true) {

                    move_uploaded_file($client_support_cal_file_tmp, "./uploads/" . $new_client_support_cal_file_name);
                } else {
                    if ($client_support_cal_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_cal_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($client_support_cal_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_cal_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_client_support_cal_file_name = "";
            }

            if ($_FILES['client_support_pen_file']['name'] != '') {

                $client_support_pen_file_errors = array();
                $client_support_pen_file_name = $_FILES['client_support_pen_file']['name'];
                $client_support_pen_file_size = $_FILES['client_support_pen_file']['size'];
                $client_support_pen_file_tmp = $_FILES['client_support_pen_file']['tmp_name'];
                $client_support_pen_file_type = $_FILES['client_support_pen_file']['type'];
                $client_support_pen_file_ext_arr = explode('.', $client_support_pen_file_name);
                $client_support_pen_file_ext = strtolower($client_support_pen_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_pen_file_name = time() . rand(00, 99) . '.' . $client_support_pen_file_ext;


                if (in_array($client_support_pen_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_pen_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_pen_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_pen_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_pen_file_errors) == true) {

                    move_uploaded_file($client_support_pen_file_tmp, "./uploads/" . $new_client_support_pen_file_name);
                } else {
                    if ($client_support_pen_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_pen_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($client_support_pen_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pen_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_client_support_pen_file_name = "";
            }

            if ($_FILES['client_support_pu_file']['name'] != '') {

                $client_support_pu_file_errors = array();
                $client_support_pu_file_name = $_FILES['client_support_pu_file']['name'];
                $client_support_pu_file_size = $_FILES['client_support_pu_file']['size'];
                $client_support_pu_file_tmp = $_FILES['client_support_pu_file']['tmp_name'];
                $client_support_pu_file_type = $_FILES['client_support_pu_file']['type'];
                $client_support_pu_file_ext_arr = explode('.', $client_support_pu_file_name);
                $client_support_pu_file_ext = strtolower($client_support_pu_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_pu_file_name = time() . rand(00, 99) . '.' . $client_support_pu_file_ext;


                if (in_array($client_support_pu_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_pu_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_pu_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_pu_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_pu_file_errors) == true) {

                    move_uploaded_file($client_support_pu_file_tmp, "./uploads/" . $new_client_support_pu_file_name);
                } else {
                    if ($client_support_pu_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_pu_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($client_support_pu_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pu_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_client_support_pu_file_name = "";
            }

            if ($_FILES['nmsdc_file']['name'] != '') {

                $nmsdc_file_errors = array();
                $nmsdc_file_name = $_FILES['nmsdc_file']['name'];
                $nmsdc_file_size = $_FILES['nmsdc_file']['size'];
                $nmsdc_file_tmp = $_FILES['nmsdc_file']['tmp_name'];
                $nmsdc_file_type = $_FILES['nmsdc_file']['type'];
                $nmsdc_file_ext_arr = explode('.', $nmsdc_file_name);
                $nmsdc_file_ext = strtolower($nmsdc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_nmsdc_file_name = time() . rand(00, 99) . '.' . $nmsdc_file_ext;


                if (in_array($nmsdc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $nmsdc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($nmsdc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $nmsdc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($nmsdc_file_errors) == true) {

                    move_uploaded_file($nmsdc_file_tmp, "./uploads/" . $new_nmsdc_file_name);
                } else {
                    if ($nmsdc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $nmsdc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($nmsdc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nmsdc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_nmsdc_file_name = "";
            }

            if ($_FILES['wbenc_file']['name'] != '') {

                $wbenc_file_errors = array();
                $wbenc_file_name = $_FILES['wbenc_file']['name'];
                $wbenc_file_size = $_FILES['wbenc_file']['size'];
                $wbenc_file_tmp = $_FILES['wbenc_file']['tmp_name'];
                $wbenc_file_type = $_FILES['wbenc_file']['type'];
                $wbenc_file_ext_arr = explode('.', $wbenc_file_name);
                $wbenc_file_ext = strtolower($wbenc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_wbenc_file_name = time() . rand(00, 99) . '.' . $wbenc_file_ext;


                if (in_array($wbenc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $wbenc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($wbenc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $wbenc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($wbenc_file_errors) == true) {

                    move_uploaded_file($wbenc_file_tmp, "./uploads/" . $new_wbenc_file_name);
                } else {
                    if ($wbenc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $wbenc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($wbenc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $wbenc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_wbenc_file_name = "";
            }

            if ($_FILES['sba_file']['name'] != '') {

                $sba_file_errors = array();
                $sba_file_name = $_FILES['sba_file']['name'];
                $sba_file_size = $_FILES['sba_file']['size'];
                $sba_file_tmp = $_FILES['sba_file']['tmp_name'];
                $sba_file_type = $_FILES['sba_file']['type'];
                $sba_file_ext_arr = explode('.', $sba_file_name);
                $sba_file_ext = strtolower($sba_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_sba_file_name = time() . rand(00, 99) . '.' . $sba_file_ext;


                if (in_array($sba_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $sba_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($sba_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $sba_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($sba_file_errors) == true) {

                    move_uploaded_file($sba_file_tmp, "./uploads/" . $new_sba_file_name);
                } else {
                    if ($sba_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $sba_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($sba_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $sba_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_sba_file_name = "";
            }

            if ($_FILES['vetbiz_file']['name'] != '') {

                $vetbiz_file_errors = array();
                $vetbiz_file_name = $_FILES['vetbiz_file']['name'];
                $vetbiz_file_size = $_FILES['vetbiz_file']['size'];
                $vetbiz_file_tmp = $_FILES['vetbiz_file']['tmp_name'];
                $vetbiz_file_type = $_FILES['vetbiz_file']['type'];
                $vetbiz_file_ext_arr = explode('.', $vetbiz_file_name);
                $vetbiz_file_ext = strtolower($vetbiz_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_vetbiz_file_name = time() . rand(00, 99) . '.' . $vetbiz_file_ext;


                if (in_array($vetbiz_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $vetbiz_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($vetbiz_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $vetbiz_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($vetbiz_file_errors) == true) {

                    move_uploaded_file($vetbiz_file_tmp, "./uploads/" . $new_vetbiz_file_name);
                } else {
                    if ($vetbiz_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $vetbiz_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($vetbiz_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $vetbiz_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_vetbiz_file_name = "";
            }

            if ($_FILES['nglcc_file']['name'] != '') {

                $nglcc_file_errors = array();
                $nglcc_file_name = $_FILES['nglcc_file']['name'];
                $nglcc_file_size = $_FILES['nglcc_file']['size'];
                $nglcc_file_tmp = $_FILES['nglcc_file']['tmp_name'];
                $nglcc_file_type = $_FILES['nglcc_file']['type'];
                $nglcc_file_ext_arr = explode('.', $nglcc_file_name);
                $nglcc_file_ext = strtolower($nglcc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_nglcc_file_name = time() . rand(00, 99) . '.' . $nglcc_file_ext;


                if (in_array($nglcc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $nglcc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($nglcc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $nglcc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($nglcc_file_errors) == true) {

                    move_uploaded_file($nglcc_file_tmp, "./uploads/" . $new_nglcc_file_name);
                } else {
                    if ($nglcc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $nglcc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-user');
                    }
                    if (in_array($nglcc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nglcc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-user');
                    }
                }
            } else {
                $new_nglcc_file_name = "";
            }

            /* ---------------------------------Files Uploads--------------------------- */



            $get_admin_details = $this->vendor_model->getAdminData($admin_id);
            if (!empty($get_admin_details)) {
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }
            if (LATAM) {
                $insert_arr = array(
                    'admin_id' => $admin_id,
                    'name_prefix' => $name_prefix,
                    'vendor_tier' => $vendor_tier,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'company_id' => $company_id,
                    'federal_tax_id' => $federal_tax_id,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => md5($password),
                    'photo' => $new_file_name,
                    'phone_ext' => $phone_ext,
                    'phone_no' => $phone_no,
                    'fax_no' => $fax_no,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'remittance_address' => $remittance_address,
                    'main_contact_person' => $main_contact_person,
                    'main_email_address' => $main_email_address,
                    'main_phone_no' => $main_phone_no,
                    'billing_contact_person' => $billing_contact_person,
                    'billing_email_address' => $billing_email_address,
                    'billing_phone_no' => $billing_phone_no,
                    'additional_contact_person' => $additional_contact_person,
                    'additional_email_address' => $additional_email_address,
                    'additional_phone_no' => $additional_phone_no,
                    'client_support_cal' => $client_support_cal,
                    'client_support_cal_file' => $new_client_support_cal_file_name,
                    'client_support_pen' => $client_support_pen,
                    'client_support_pen_file' => $new_client_support_pen_file_name,
                    'client_support_pu' => $client_support_pu,
                    'client_support_pu_file' => $new_client_support_pu_file_name,
                    'nmsdc' => $nmsdc,
                    'nmsdc_file' => $new_nmsdc_file_name,
                    'wbenc' => $wbenc,
                    'wbenc_file' => $new_wbenc_file_name,
                    'sba' => $sba,
                    'sba_file' => $new_sba_file_name,
                    'vetbiz' => $vetbiz,
                    'vetbiz_file' => $new_vetbiz_file_name,
                    'nglcc' => $nglcc,
                    'nglcc_file' => $new_nglcc_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'address' => $address,
                    'entry_date' => date("Y-m-d h:i:s"),
                    'status' => $status,
                    'block_status' => $block_status,
                    'reg_verification' => $reg_verification,
                );
            }
            if (US || INDIA) {
                $insert_arr = array(
                    'admin_id' => $admin_id,
                    'name_prefix' => $name_prefix,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'company_id' => $company_id,
                    'federal_tax_id' => $federal_tax_id,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => md5($password),
                    'photo' => $new_file_name,
                    'phone_ext' => $phone_ext,
                    'phone_no' => $phone_no,
                    'fax_no' => $fax_no,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'remittance_address' => $remittance_address,
                    'main_contact_person' => $main_contact_person,
                    'main_email_address' => $main_email_address,
                    'main_phone_no' => $main_phone_no,
                    'billing_contact_person' => $billing_contact_person,
                    'billing_email_address' => $billing_email_address,
                    'billing_phone_no' => $billing_phone_no,
                    'additional_contact_person' => $additional_contact_person,
                    'additional_email_address' => $additional_email_address,
                    'additional_phone_no' => $additional_phone_no,
                    'client_support_cal' => $client_support_cal,
                    'client_support_cal_file' => $new_client_support_cal_file_name,
                    'client_support_pen' => $client_support_pen,
                    'client_support_pen_file' => $new_client_support_pen_file_name,
                    'client_support_pu' => $client_support_pu,
                    'client_support_pu_file' => $new_client_support_pu_file_name,
                    'nmsdc' => $nmsdc,
                    'nmsdc_file' => $new_nmsdc_file_name,
                    'wbenc' => $wbenc,
                    'wbenc_file' => $new_wbenc_file_name,
                    'sba' => $sba,
                    'sba_file' => $new_sba_file_name,
                    'vetbiz' => $vetbiz,
                    'vetbiz_file' => $new_vetbiz_file_name,
                    'nglcc' => $nglcc,
                    'nglcc_file' => $new_nglcc_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'address' => $address,
                    'entry_date' => date("Y-m-d h:i:s"),
                    'status' => $status,
                    'block_status' => $block_status,
                    'reg_verification' => $reg_verification,
                );
            }
                //            echo "<pre>";
                //            print_r($insert_arr);
                //            die;
            $insert_id = $this->vendor_model->add_vendor_user($insert_arr);

            if ($insert_id != '') {

                $name_prefix = $name_prefix;
                $vendor_name = $name_prefix . " " . $first_name . " " . $last_name;
                $vendor_email = $vendor_email;
                $vendor_password = $password;

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $email;
                $vendor_email = $vendor_email;

                $data['msg'] = " <p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($vendor_name) . ",</p>
                                                <p style='font-weight: 300;'>Your Login Details are as follows. Please Login with your Email ID and Temporary Password to " . SITE_NAME . ". </p>
                                                <p><strong>Email ID : </strong>" . $vendor_email . "</p>
                                                <p><strong>Temporary Password : </strong>" . $vendor_password . "</p>";
                $data['login_type'] = "vendor";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($vendor_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has added new vendor successfully. Vendor details are as follows : <br> "
                        . "<label><strong>Vendor Name : </strong>" . $name_prefix . " " . ucwords($first_name) . " " . ucwords($last_name) . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "New Vendor Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
                    //print_r($insert_arr);
                    //die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Vendor added Successfully..');
                redirect(base_url() . 'admin_vendor_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Vendor not added Successfully..');
                redirect(base_url() . 'add_admin_vendor');
            }
        }
    }

    public function vendor_lists() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
       // if ($admin_id != '9' && $admin_id != '10') {
      //      $data['get_vendor_details'] = $this->vendor_model->getVendorLists($admin_id);
       // } else {
            $data['get_vendor_details'] = $this->vendor_model->getAllVendor();
       // }

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR LISTS";

        $this->load->view('admin/vendor_lists', $data);
    }

    public function update_bg_status() {
        $phone = $this->uri->segment(2);
        $email = $this->uri->segment(3);
        // $url = 'https://vetzu-dev.azurewebsites.net/public/GetUpdatedStatusPorosiq.php';
        // $ch = curl_init($url);
        // $payload = json_encode($phone);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);
        $bg_order_id = $this->vendor_model->get_order_id_by_phone_and_email($phone, $email);
        $bg_order_id = $bg_order_id[0]['bg_order_id'];
        // print_r($bg_order_id);
        // exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vetzu-java-dev.azurewebsites.net/authenticate',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email":"admin@vetzu.com",
            "password":"1234567Aa!"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: ARRAffinity=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647; ARRAffinitySameSite=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response);
        $access_token = $res->responseObject->access_token;


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vetzu-java-dev.azurewebsites.net/order/findOrderById?orderId='.$bg_order_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token,
            'Cookie: ARRAffinity=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647; ARRAffinitySameSite=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
        // echo "<pre>".print_r($res,1)."</pre>";

        $orderDetailId = $res->responseObject->serviceMasterData[0]->orderDetailId;
        // echo $orderDetailId;
        $status = $res->responseObject->status;
        // echo $bg_order_id;
        // echo $status;
        // exit;
        // exit;

        // print_r($orderDetailId);
        // exit;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vetzu-java-dev.azurewebsites.net/document/downloadOrderReportDocument?orderDetailId='.$orderDetailId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token,
            'Cookie: ARRAffinity=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647; ARRAffinitySameSite=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647'
        ),
        ));

        $pdf_response = curl_exec($curl);

        curl_close($curl);
        // echo $pdf_response;

        $filename = uniqid(rand(), true) . '.pdf';

        $path = './uploads/'.$filename;
        file_put_contents($path, $pdf_response);

        $this->vendor_model->update_order_report($phone, $filename, $email);
        // exit;



        if ($status == 1) {
            $this->vendor_model->update_order_status($phone, $email);
        }
        if ($status == 2) {
            $this->vendor_model->update_order_status_needs_attention($phone, $email);
        }
        if ($status == 3) {
            $this->vendor_model->update_order_status_canceled($phone, $email);
        }
        if ($status == 4) {
            $this->vendor_model->update_order_status_archived($phone, $email);
        }
        redirect(site_url('admin_vendor_lists'));
    }

    public function submit_consultant_form() {
        $bg_check_id = $this->input->post('bg_check');
        $data['multiple_vendor_details'] = $this->vendor_model->get_multiple_vendor_details($bg_check_id);
        // echo "<pre>".print_r($data['multiple_vendor_details'],1)."</pre>";
        // exit;

        $vendor_ids = '';
        foreach ($data['multiple_vendor_details'] as $key => $value) {
            $first_name = '';
            $last_name = '';
            $address = '';
            $phone = '';
            $email = '';
            $vendor_id = '';
            foreach ($value as $k => $v) {
                if ($k == 'vendor_id') {
                    $vendor_id = $v;
                    // echo $k.' : '.$v.'<br>';
                }
                if ($k == 'first_name') {
                    $first_name = $v;
                    // echo $k.' : '.$v.'<br>';
                }
                if ($k == 'last_name') {
                    $last_name = $v;
                    // echo $k.' : '.$v.'<br>';
                }
                if ($k == 'address') {
                    $address = $v;
                    // echo $k.' : '.$v.'<br>';
                }
                if ($k == 'phone_no') {
                    $phone = $v;
                    // echo $k.' : '.$v.'<br>';
                }
                if ($k == 'vendor_email') {
                    $email = $v;
                    // echo $k.' : '.$v.'<br>';
                }
            }
            if (!empty($first_name) && !empty($last_name) && !empty($address) && !empty($email) & !empty($phone) && !empty($vendor_id)) {


                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://vetzu-java-dev.azurewebsites.net/authenticate',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "email":"admin@vetzu.com",
                    "password":"1234567Aa!"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: ARRAffinity=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647; ARRAffinitySameSite=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $res = json_decode($response);
                $access_token = $res->responseObject->access_token;
                // echo $access_token;


                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://vetzu-java-dev.azurewebsites.net/order/createorder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "city": 12937,
                    "country": "641",
                    "dateOfBirth": "1995-11-19",
                    "email": "'.$email.'",
                    "firstName": "'.$first_name.'",
                    "houseApt": "9765",
                    "lastName": "'.$last_name.'",
                    "middleName": "",
                    "packageIds": [1143],
                    "phoneNumber": "'.$phone.'",
                    "sendDocumentToEsign": false,
                    "socialSecurityNumber": "945658239",
                    "state": 443,
                    "streetAddress": "'.$address.'",
                    "zipcode": "95643"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$access_token,
                    'Content-Type: application/json',
                    'Cookie: ARRAffinity=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647; ARRAffinitySameSite=15641592cc602e8061f47d04d8a22d723a264e9c85c100e71c618dd5a9fbe647'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $res1 = json_decode($response);
                $bg_order_id = $res1->responseObject->orderId;
                // echo $response;
                // print_r($bg_order_id."tt");

                $vendor_ids .= $vendor_id.',';

                $this->vendor_model->update_vendor_bg_order_id($bg_order_id, $vendor_id);
                // $order_query = "INSERT into client_order_report (client_id, client_name, check_options, first_name, middle_name, last_name, street_address, dob, city, state, zip_code, social_security_no,  house_number, email, phone) VALUES (34, 0, '$check_options', '$first_name', '', '$last_name', '$address', '', '', '', '', '', '', '$email', '$phone')";

                // if (mysqli_query($conn, $order_query)) {
                //     $employee_ids .= $emp_id.',';
                //     echo $employee_ids;
                // }
                // else {
                //     echo "failed to insert the record<br>";
                // }
            }
            // echo '<br><br>';
        }
        
        
        // exit;
        // $data['check_options'] = 'crim,social';
        // $url = 'https://quintrx-dev.azurewebsites.net/public/DetailsFromPorosiq.php';
        // $ch = curl_init($url);
        // $payload = json_encode($data);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // echo "<pre>".print_r($response,1)."</pre>";
        $ven_ids = explode(',',$vendor_ids);
        // print_r($ven_ids);
        // exit;
        $this->vendor_model->update_vendor_bg_status($ven_ids);
        $this->session->set_flashdata('succ_msg', 'background check has been ordered for the selected vendors');
        redirect(site_url('admin_vendor_lists'));
    }

    public function edit_vendor() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        /* ------------------------------Mail Notification---------------------------------- */
        $admin_id = $data['get_details'][0]['admin_id'];

        /* ------------------------------Mail Notification---------------------------------- */
        $vendor_id = base64_decode($this->uri->segment(2));
        $data['get_vendor_data'] = $this->vendor_model->getVendorData($vendor_id);
        $data['get_vendor_files'] = $this->vendor_model->getVendorFiles($vendor_id);
        $data['get_country'] = $this->vendor_model->getCountry();

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR EDIT";

        $this->load->view('admin/edit_vendor_user', $data);
    }

    public function verify_vendor_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = base64_decode($this->uri->segment(2));
        $data['vendor_id'] = $vendor_id;
        $data['get_vendor_data'] = $this->vendor_model->getVendorData($vendor_id);
        $data['get_vendor_documents'] = $this->vendor_model->getVendorDocuments();

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VERIFY VENDOR DOCUMENTS";

        $this->load->view('admin/verify_vendor_documents', $data);
    }

    public function update_vendor() {
        $recipients = array();
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $vendor_id = base64_decode($this->input->post('vendor_id'));
        $name_prefix = $this->input->post('name_prefix');
        if (LATAM) {
            $vendor_tier = $this->input->post('vendor_tier');
        }
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $vendor_designation = $this->input->post('vendor_designation');
        $vendor_company_name = $this->input->post('vendor_company_name');
        $company_id = $this->input->post('company_id');
        $federal_tax_id = $this->input->post('federal_tax_id');
        $vendor_email = $this->input->post('vendor_email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $contract_from_date = $this->input->post('contract_from_date');
        $contract_to_date = $this->input->post('contract_to_date');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $remittance_address = mysqli_real_escape_string($db, $this->input->post('remittance_address'));
        $main_contact_person = $this->input->post('main_contact_person');
        $main_email_address = $this->input->post('main_email_address');
        $main_phone_no = $this->input->post('main_phone_no');
        $billing_contact_person = $this->input->post('billing_contact_person');
        $billing_email_address = $this->input->post('billing_email_address');
        $billing_phone_no = $this->input->post('billing_phone_no');
        $additional_contact_person = $this->input->post('additional_contact_person');
        $additional_email_address = $this->input->post('additional_email_address');
        $additional_phone_no = $this->input->post('additional_phone_no');
        $client_support_cal = $this->input->post('client_support_cal');
        $client_support_pen = $this->input->post('client_support_pen');
        $client_support_pu = $this->input->post('client_support_pu');
        $nmsdc = $this->input->post('nmsdc');
        $wbenc = $this->input->post('wbenc');
        $sba = $this->input->post('sba');
        $vetbiz = $this->input->post('vetbiz');
        $nglcc = $this->input->post('nglcc');

        $vendor_details = $this->vendor_model->getVendorData($vendor_id);
        $vendor_files_details = $this->vendor_model->getVendorFiles($vendor_id);

        if (isset($vendor_name) && $vendor_name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
        } else {

            if ($_FILES['photo']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['photo']['name'];
                $file_size = $_FILES['photo']['size'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $file_type = $_FILES['photo']['type'];
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
                    $old_file = "./uploads/" . $vendor_details[0]['photo'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_file_name = $vendor_details[0]['photo'];
            }

            /* ---------------------------------Files Uploads--------------------------- */
            $expensions = array("pdf");

            if ($_FILES['client_support_cal_file']['name'] != '') {

                $client_support_cal_file_errors = array();
                $client_support_cal_file_name = $_FILES['client_support_cal_file']['name'];
                $client_support_cal_file_size = $_FILES['client_support_cal_file']['size'];
                $client_support_cal_file_tmp = $_FILES['client_support_cal_file']['tmp_name'];
                $client_support_cal_file_type = $_FILES['client_support_cal_file']['type'];
                $client_support_cal_file_ext_arr = explode('.', $client_support_cal_file_name);
                $client_support_cal_file_ext = strtolower($client_support_cal_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_cal_file_name = time() . rand(00, 99) . '.' . $client_support_cal_file_ext;


                if (in_array($client_support_cal_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_cal_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_cal_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_cal_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_cal_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['client_support_cal_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($client_support_cal_file_tmp, "./uploads/" . $new_client_support_cal_file_name);
                } else {
                    if ($client_support_cal_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_cal_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($client_support_cal_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_cal_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_client_support_cal_file_name = $vendor_details[0]['client_support_cal_file'];
            }

            if ($_FILES['client_support_pen_file']['name'] != '') {

                $client_support_pen_file_errors = array();
                $client_support_pen_file_name = $_FILES['client_support_pen_file']['name'];
                $client_support_pen_file_size = $_FILES['client_support_pen_file']['size'];
                $client_support_pen_file_tmp = $_FILES['client_support_pen_file']['tmp_name'];
                $client_support_pen_file_type = $_FILES['client_support_pen_file']['type'];
                $client_support_pen_file_ext_arr = explode('.', $client_support_pen_file_name);
                $client_support_pen_file_ext = strtolower($client_support_pen_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_pen_file_name = time() . rand(00, 99) . '.' . $client_support_pen_file_ext;


                if (in_array($client_support_pen_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_pen_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_pen_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_pen_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_pen_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['client_support_pen_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($client_support_pen_file_tmp, "./uploads/" . $new_client_support_pen_file_name);
                } else {
                    if ($client_support_pen_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_pen_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($client_support_pen_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pen_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_client_support_pen_file_name = $vendor_details[0]['client_support_pen_file'];
            }

            if ($_FILES['client_support_pu_file']['name'] != '') {

                $client_support_pu_file_errors = array();
                $client_support_pu_file_name = $_FILES['client_support_pu_file']['name'];
                $client_support_pu_file_size = $_FILES['client_support_pu_file']['size'];
                $client_support_pu_file_tmp = $_FILES['client_support_pu_file']['tmp_name'];
                $client_support_pu_file_type = $_FILES['client_support_pu_file']['type'];
                $client_support_pu_file_ext_arr = explode('.', $client_support_pu_file_name);
                $client_support_pu_file_ext = strtolower($client_support_pu_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_client_support_pu_file_name = time() . rand(00, 99) . '.' . $client_support_pu_file_ext;


                if (in_array($client_support_pu_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $client_support_pu_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($client_support_pu_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $client_support_pu_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($client_support_pu_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['client_support_pu_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($client_support_pu_file_tmp, "./uploads/" . $new_client_support_pu_file_name);
                } else {
                    if ($client_support_pu_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $client_support_pu_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($client_support_pu_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pu_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_client_support_pu_file_name = $vendor_details[0]['client_support_pu_file'];
            }

            if ($_FILES['nmsdc_file']['name'] != '') {

                $nmsdc_file_errors = array();
                $nmsdc_file_name = $_FILES['nmsdc_file']['name'];
                $nmsdc_file_size = $_FILES['nmsdc_file']['size'];
                $nmsdc_file_tmp = $_FILES['nmsdc_file']['tmp_name'];
                $nmsdc_file_type = $_FILES['nmsdc_file']['type'];
                $nmsdc_file_ext_arr = explode('.', $nmsdc_file_name);
                $nmsdc_file_ext = strtolower($nmsdc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_nmsdc_file_name = time() . rand(00, 99) . '.' . $nmsdc_file_ext;


                if (in_array($nmsdc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $nmsdc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($nmsdc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $nmsdc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($nmsdc_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['nmsdc_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($nmsdc_file_tmp, "./uploads/" . $new_nmsdc_file_name);
                } else {
                    if ($nmsdc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $nmsdc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($nmsdc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nmsdc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_nmsdc_file_name = $vendor_details[0]['nmsdc_file'];
            }

            if ($_FILES['wbenc_file']['name'] != '') {

                $wbenc_file_errors = array();
                $wbenc_file_name = $_FILES['wbenc_file']['name'];
                $wbenc_file_size = $_FILES['wbenc_file']['size'];
                $wbenc_file_tmp = $_FILES['wbenc_file']['tmp_name'];
                $wbenc_file_type = $_FILES['wbenc_file']['type'];
                $wbenc_file_ext_arr = explode('.', $wbenc_file_name);
                $wbenc_file_ext = strtolower($wbenc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_wbenc_file_name = time() . rand(00, 99) . '.' . $wbenc_file_ext;


                if (in_array($wbenc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $wbenc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($wbenc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $wbenc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($wbenc_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['wbenc_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($wbenc_file_tmp, "./uploads/" . $new_wbenc_file_name);
                } else {
                    if ($wbenc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $wbenc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($wbenc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $wbenc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_wbenc_file_name = $vendor_details[0]['wbenc_file'];
            }

            if ($_FILES['sba_file']['name'] != '') {

                $sba_file_errors = array();
                $sba_file_name = $_FILES['sba_file']['name'];
                $sba_file_size = $_FILES['sba_file']['size'];
                $sba_file_tmp = $_FILES['sba_file']['tmp_name'];
                $sba_file_type = $_FILES['sba_file']['type'];
                $sba_file_ext_arr = explode('.', $sba_file_name);
                $sba_file_ext = strtolower($sba_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_sba_file_name = time() . rand(00, 99) . '.' . $sba_file_ext;


                if (in_array($sba_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $sba_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($sba_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $sba_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($sba_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['sba_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($sba_file_tmp, "./uploads/" . $new_sba_file_name);
                } else {
                    if ($sba_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $sba_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($sba_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $sba_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_sba_file_name = $vendor_details[0]['sba_file'];
            }

            if ($_FILES['vetbiz_file']['name'] != '') {

                $vetbiz_file_errors = array();
                $vetbiz_file_name = $_FILES['vetbiz_file']['name'];
                $vetbiz_file_size = $_FILES['vetbiz_file']['size'];
                $vetbiz_file_tmp = $_FILES['vetbiz_file']['tmp_name'];
                $vetbiz_file_type = $_FILES['vetbiz_file']['type'];
                $vetbiz_file_ext_arr = explode('.', $vetbiz_file_name);
                $vetbiz_file_ext = strtolower($vetbiz_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_vetbiz_file_name = time() . rand(00, 99) . '.' . $vetbiz_file_ext;


                if (in_array($vetbiz_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $vetbiz_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($vetbiz_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $vetbiz_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($vetbiz_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['vetbiz_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($vetbiz_file_tmp, "./uploads/" . $new_vetbiz_file_name);
                } else {
                    if ($vetbiz_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $vetbiz_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($vetbiz_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $vetbiz_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_vetbiz_file_name = $vendor_details[0]['vetbiz_file'];
            }

            if ($_FILES['nglcc_file']['name'] != '') {

                $nglcc_file_errors = array();
                $nglcc_file_name = $_FILES['nglcc_file']['name'];
                $nglcc_file_size = $_FILES['nglcc_file']['size'];
                $nglcc_file_tmp = $_FILES['nglcc_file']['tmp_name'];
                $nglcc_file_type = $_FILES['nglcc_file']['type'];
                $nglcc_file_ext_arr = explode('.', $nglcc_file_name);
                $nglcc_file_ext = strtolower($nglcc_file_ext_arr[1]);
                //print_r($file_ext_arr);

                $new_nglcc_file_name = time() . rand(00, 99) . '.' . $nglcc_file_ext;


                if (in_array($nglcc_file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $nglcc_file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($nglcc_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $nglcc_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($nglcc_file_errors) == true) {
                    $old_file = "./uploads/" . $vendor_details[0]['nglcc_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($nglcc_file_tmp, "./uploads/" . $new_nglcc_file_name);
                } else {
                    if ($nglcc_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $nglcc_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                    if (in_array($nglcc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nglcc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit_admin_vendor/' . base64_encode($vendor_id));
                    }
                }
            } else {
                $new_nglcc_file_name = $vendor_details[0]['nglcc_file'];
            }

            /* ---------------------------------Files Uploads--------------------------- */

            if ($password != '') {
                $pwd = md5($password);
            } else {
                $pwd = $vendor_details[0]['vendor_password'];
            }
            $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
            if (!empty($get_vendor_details)) {
                $admin_id = $get_vendor_details[0]['admin_id'];
            }
            $get_admin_details = $this->vendor_model->getAdminData($admin_id);
            if (!empty($get_admin_details)) {
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                $recipients [] = $vendor_id . "_" . "vendor";
                $admin_email = $get_admin_details[0]['admin_email'];
            }
                //            print_r($recipients);
                //            die;
            if (LATAM) {
                $update_arr = array(
                    'admin_id' => $admin_id,
                    'name_prefix' => $name_prefix,
                    'vendor_tier' => $vendor_tier,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'company_id' => $company_id,
                    'federal_tax_id' => $federal_tax_id,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => $pwd,
                    'photo' => $new_file_name,
                    'phone_ext' => $phone_ext,
                    'phone_no' => $phone_no,
                    'fax_no' => $fax_no,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'remittance_address' => $remittance_address,
                    'main_contact_person' => $main_contact_person,
                    'main_email_address' => $main_email_address,
                    'main_phone_no' => $main_phone_no,
                    'billing_contact_person' => $billing_contact_person,
                    'billing_email_address' => $billing_email_address,
                    'billing_phone_no' => $billing_phone_no,
                    'additional_contact_person' => $additional_contact_person,
                    'additional_email_address' => $additional_email_address,
                    'additional_phone_no' => $additional_phone_no,
                    'client_support_cal' => $client_support_cal,
                    'client_support_cal_file' => $new_client_support_cal_file_name,
                    'client_support_pen' => $client_support_pen,
                    'client_support_pen_file' => $new_client_support_pen_file_name,
                    'client_support_pu' => $client_support_pu,
                    'client_support_pu_file' => $new_client_support_pu_file_name,
                    'nmsdc' => $nmsdc,
                    'nmsdc_file' => $new_nmsdc_file_name,
                    'wbenc' => $wbenc,
                    'wbenc_file' => $new_wbenc_file_name,
                    'sba' => $sba,
                    'sba_file' => $new_sba_file_name,
                    'vetbiz' => $vetbiz,
                    'vetbiz_file' => $new_vetbiz_file_name,
                    'nglcc' => $nglcc,
                    'nglcc_file' => $new_nglcc_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'address' => $address,
                    'updated_date' => date("Y-m-d h:i:s")
                );
            }
            if (US || INDIA) {
                $update_arr = array(
                    'admin_id' => $admin_id,
                    'name_prefix' => $name_prefix,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'company_id' => $company_id,
                    'federal_tax_id' => $federal_tax_id,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => $pwd,
                    'photo' => $new_file_name,
                    'phone_ext' => $phone_ext,
                    'phone_no' => $phone_no,
                    'fax_no' => $fax_no,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'remittance_address' => $remittance_address,
                    'main_contact_person' => $main_contact_person,
                    'main_email_address' => $main_email_address,
                    'main_phone_no' => $main_phone_no,
                    'billing_contact_person' => $billing_contact_person,
                    'billing_email_address' => $billing_email_address,
                    'billing_phone_no' => $billing_phone_no,
                    'additional_contact_person' => $additional_contact_person,
                    'additional_email_address' => $additional_email_address,
                    'additional_phone_no' => $additional_phone_no,
                    'client_support_cal' => $client_support_cal,
                    'client_support_cal_file' => $new_client_support_cal_file_name,
                    'client_support_pen' => $client_support_pen,
                    'client_support_pen_file' => $new_client_support_pen_file_name,
                    'client_support_pu' => $client_support_pu,
                    'client_support_pu_file' => $new_client_support_pu_file_name,
                    'nmsdc' => $nmsdc,
                    'nmsdc_file' => $new_nmsdc_file_name,
                    'wbenc' => $wbenc,
                    'wbenc_file' => $new_wbenc_file_name,
                    'sba' => $sba,
                    'sba_file' => $new_sba_file_name,
                    'vetbiz' => $vetbiz,
                    'vetbiz_file' => $new_vetbiz_file_name,
                    'nglcc' => $nglcc,
                    'nglcc_file' => $new_nglcc_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'address' => $address,
                    'updated_date' => date("Y-m-d h:i:s")
                );
            }
                //echo "<pre>";
                //print_r($update_arr);
                //die;
            $update_query = $this->vendor_model->update_vendor_user($update_arr, $vendor_id);

            if ($update_query != '0') {
                $vendor_name = $name_prefix . " " . $first_name . " " . $last_name;
                $vendor_email = $vendor_email;
                $vendor_password = $password;

                $data['msg'] = " <p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($vendor_name) . ",</p>
                                                <p style='font-weight: 300;'>Your Details are updated successfully by " . ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . ". </p>";

                $data['login_type'] = "vendor";
                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $vendor_email = $vendor_email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);

                if (PROFILE_UPDATE_SEND_EMAIL_VENDOR) {

                    $this->email->to($vendor_email);
                    $this->email->bcc($superadmin_email);

                } else {

                    $this->email->to($superadmin_email);

                }

                $this->email->subject('Vendor details update successfully in Global Resource Management System');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has updated the vendor details successfully.<br> "
                        . "<label><strong>Vendor Name : </strong>" . $name_prefix . " " . ucwords($first_name) . " " . ucwords($last_name) . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor details has been update successfully",
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
                $this->session->set_flashdata('succ_msg', 'Vendor updated Successfully..');
                redirect(base_url() . 'admin_vendor_lists');
            } else {
                $this->session->set_flashdata('succ_msg', 'Vendor updated Successfully..');
                redirect(base_url() . 'admin_vendor_lists');
            }
        }
    }

    public function admin_view_vendor_profile() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = base64_decode($this->uri->segment(2));
        $data['get_vendor_data'] = $this->vendor_model->getVendorData($vendor_id);
        $data['get_vendor_files'] = $this->vendor_model->getVendorFiles($vendor_id);
        $data['get_country'] = $this->vendor_model->getCountry();
        $this->load->view('admin/view_vendor_profile', $data);
    }

    public function add_admin_vendor_user_sd() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
//        echo "<pre>";
//        print_r($data['get_details']);
//        echo $data['get_details'][0]['sa_id'];
//        die;
        $data['get_country'] = $this->vendor_model->getCountry();
        $data['get_super_admin'] = $this->vendor_model->getSuperAdminData($data['get_details'][0]['sa_id']);

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR ADD";

        $this->load->view('admin/add_admin_vendor_user_sd', $data);
    }

    public function add_admin_vendor_sd() {

        $db = get_instance()->db->conn_id;

        $recipients = array();

        $admin_id = $this->input->post('admin_id');
        $name_prefix = $this->input->post('name_prefix');
        if (LATAM) {
            $vendor_tier = $this->input->post('vendor_tier');
        }
        $sa_id = $this->input->post('sa_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $vendor_designation = $this->input->post('vendor_designation');
        $vendor_company_name = $this->input->post('vendor_company_name');
        $vendor_email = $this->input->post('vendor_email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $contract_from_date = $this->input->post('contract_from_date');
        $contract_to_date = date('Y-m-d', strtotime('+1 year', strtotime($contract_from_date)));

        $status = '0';
        $block_status = '0';
        $reg_verification = '1';

        $vendor_details = $this->vendor_model->getDetails($vendor_email);

//        print_r($vendor_details);
//die;
        $check_duplicate_email = $this->vendor_model->checkDuplicate($vendor_email);

//        print_r($check_duplicate_email);
//        die;

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } else if (isset($admin_id) && $admin_id == '') {
            $this->session->set_flashdata('error_msg', 'Admin Name field cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } else if (isset($vendor_email) && $vendor_email == '') {
            $this->session->set_flashdata('error_msg', 'Email field cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'add_admin_vendor');
        } else if (isset($password) && $password == '' && isset($conf_password) && $conf_password == '') {

            $this->session->set_flashdata('error_msg', 'Password fields cannot be blank');
            redirect(base_url() . 'add_admin_vendor');
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'add_admin_vendor');
        } else {


            /* ---------------------------Photo Upload-------------------------------- */

            if ($_FILES['photo']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['photo']['name'];
                $file_size = $_FILES['photo']['size'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $file_type = $_FILES['photo']['type'];
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
                        redirect(base_url() . 'add_admin_vendor');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add_admin_vendor');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------------------Photo Upload-------------------------------- */


            //$contract_to_date = date('d-m-Y', strtotime('+1 year', strtotime($contract_from_date)));

            if (LATAM) {
                $insert_arr = array(
                    'sa_id' => $sa_id,
                    'name_prefix' => $name_prefix,
                    'vendor_tier' => $vendor_tier,
                    'admin_id' => $admin_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => md5($password),
                    'photo' => $new_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'entry_date' => date("Y-m-d h:i:s"),
                    'status' => $status,
                    'block_status' => $block_status,
                    'reg_verification' => $reg_verification
                );
            }
            if (US || INDIA) {
                $insert_arr = array(
                    'sa_id' => $sa_id,
                    'name_prefix' => $name_prefix,
                    'admin_id' => $admin_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'vendor_designation' => $vendor_designation,
                    'vendor_company_name' => $vendor_company_name,
                    'vendor_email' => $vendor_email,
                    'vendor_password' => md5($password),
                    'photo' => $new_file_name,
                    'contract_from_date' => $contract_from_date,
                    'contract_to_date' => $contract_to_date,
                    'entry_date' => date("Y-m-d h:i:s"),
                    'status' => $status,
                    'block_status' => $block_status,
                    'reg_verification' => $reg_verification
                );
            }

//echo "<pre>";
//print_r($insert_arr);
//die;
            $insert_id = $this->vendor_model->add_vendor_user($insert_arr);

            if ($insert_id != '') {
                $admin_details = $this->vendor_model->getAdminData($admin_id);
                $sadmin_details = $this->vendor_model->getSuperAdminData($admin_details[0]['sa_id']);
                $vendor_name = $first_name . " " . $last_name;
                $ven_email = $vendor_email;
                $vendor_password = $password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi " . $name_prefix . " " . ucwords($vendor_name) . ",</p>
                                <p style='font-weight: 300;'>Your Login Details are as follows. Please Login with below details: </p>
                                <p><strong>Email ID : </strong>" . $ven_email . "</p>
                                <p><strong>Temporary Password : </strong>" . $vendor_password . "</p>";

                $data['login_type'] = "vendor";
                
                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_email = $vendor_email;
                //$admin_email = $admin_details[0]['admin_email'];
                //Load email library
                $this->load->library('email');
                
                $config['protocol'] = 'smtp';
                $config['mailtype'] = 'html';
                $config['crlf'] = "\n";
                $config['charset'] = "utf-8";
                $config['newline'] = "\r\n";

                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->set_crlf( "\r\n" );
                // $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
                // $this->email->set_header('Content-type', 'text/html');

                $this->email->from($from_email);
                $this->email->to($vendor_email);
                $this->email->bcc($sadmin_details[0]['sa_email']);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Admin has added new vendor successfully. Vendor details are as follows : <br> "
                        . "<label><strong>Vendor Name : </strong>" . ucwords($first_name) . " " . ucwords($last_name) . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sadmin_details[0]['sa_id'] . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "New Vendor Added Successfully",
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

                $this->session->set_flashdata('succ_msg', 'Vendor Added Successfully');
                redirect(base_url() . 'admin_vendor_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Vendor Not Added Successfully');
                redirect(base_url() . 'admin_vendor_lists');
            }
        }
    }

    public function change_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $vendor_id = base64_decode($this->input->post('vendor_id', TRUE));

        if ($bs_type == 'activate') {
            $msg_type = "Activated";
            $update_arr = array(
                'status' => '0'
            );
        } else if ($bs_type == 'deactivate') {
            $msg_type = "Deactivated";
            $update_arr = array(
                'status' => '1'
            );
        }

        $change_status = $this->vendor_model->change_status($update_arr, $vendor_id);
        if ($change_status > 0) {

            $check_status = $this->vendor_model->checkStatus($vendor_id);
            $check_block_status = $this->vendor_model->checkBlockStatus($vendor_id);


//            echo $check_status[0]['status'] . " " . $check_block_status[0]['block_status'];
//            die;

            if ($check_status[0]['status'] == '1') {

                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $admin_id = $get_vendor_details[0]['admin_id'];
                $get_admin_details = $this->vendor_model->getAdminData($admin_id);
                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->vendor_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sadmin_mail = $get_sadmin_details[0]['sa_email'];
                }

                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $company_name = $get_vendor_details[0]['company_name'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_vendor_details[0]['vendor_email'];

                $data['msg'] = " <p style='font-weight: 300;'>Hi, " . $vendor_name . " ( " . ucwords($company_name) . " )" . "</p>
                                                <p style='font-weight: 200;'>
                                                    Your Account Activated Successfully. Please login and go through the <b>Documentation</b> menu and upload the required documents.
                                                </p>";

                //Load email library
                $data['msg'] = "Your Account Activated Successfully. Please login to your portal.";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->bcc($sadmin_mail);
                $this->email->bcc($superadmin_email);
                $this->email->subject("Vendor Account Activated Successfully");
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been activated vendor account successfully.<br> "
                        . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor account has been " . strtolower($msg_type) . " successfully",
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
            } else {
                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $admin_id = $get_vendor_details[0]['admin_id'];
                $get_admin_details = $this->vendor_model->getAdminData($admin_id);
                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->vendor_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sadmin_mail = $get_sadmin_details[0]['sa_email'];
                }

                $data['vendor_name'] = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
                $data['company_id'] = $get_vendor_details[0]['company_id'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                //$to_email = $get_vendor_details[0]['vendor_email'];
                $data['msg'] = "Your Account Deactivated Successfully";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
               // $this->email->to($to_email);
                $this->email->to($sadmin_mail);
                $this->email->bcc($superadmin_email);
                $this->email->subject("Vendor Account Deactivated");
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been deactivated vendor account successfully.<br> "
                        . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor account has been " . strtolower($msg_type) . " successfully",
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
            }
            echo "1";
        } else {

            echo "0";
        }
    }

    public function change_block_status() {
        $recipients = array();
        $bs_type = $this->input->post('bs_type', TRUE);
        $vendor_id = base64_decode($this->input->post('vendor_id', TRUE));

        if ($bs_type == 'block') {
            $msg_type = "Blocked";
            $update_arr = array(
                'block_status' => '1'
            );
        } else if ($bs_type == 'unblock') {
            $msg_type = "Unblocked";
            $update_arr = array(
                'block_status' => '0'
            );
        }

        $change_block_status = $this->vendor_model->change_block_status($update_arr, $vendor_id);
        if ($change_block_status > 0) {

            $check_status = $this->vendor_model->checkStatus($vendor_id);
            $check_block_status = $this->vendor_model->checkBlockStatus($vendor_id);


//            echo $check_status[0]['status'] . " " . $check_block_status[0]['block_status'];
//            die;

            if ($check_block_status[0]['block_status'] == '1') {

                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $admin_id = $get_vendor_details[0]['admin_id'];
                $get_admin_details = $this->vendor_model->getAdminData($admin_id);
                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->vendor_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sadmin_mail = $get_sadmin_details[0]['sa_email'];
                }

                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $company_id = $get_vendor_details[0]['company_id'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_vendor_details[0]['vendor_email'];

                $data['msg'] = " <p style='font-weight: 300;'>Hi, " . $vendor_name . " ( " . $company_id . " )" . "</p>
                                                <p style='font-weight: 200;'>
                                                    Your Account Unblocked Successfully. Please login and go through the <b>Documentation</b> menu and upload the required documents.
                                                </p>";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($to_email);
                $this->email->bcc($sadmin_mail);
                $this->email->bcc($superadmin_email);
                $this->email->subject("Vendor Account Unblocked Successfully");
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                //Send mail
                $this->email->send();
                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been unblocked vendor account successfully.<br> "
                        . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor account has been unblocked successfully",
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
            } else {
                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $admin_id = $get_vendor_details[0]['admin_id'];
                $get_admin_details = $this->vendor_model->getAdminData($admin_id);
                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->vendor_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sadmin_mail = $get_sadmin_details[0]['sa_email'];
                }

                $data['vendor_name'] = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
                $data['company_id'] = $get_vendor_details[0]['company_id'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_vendor_details[0]['vendor_email'];
                $data['msg'] = "Your Account Has Been Blocked";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                //$this->email->to($to_email);
                $this->email->to($sadmin_mail);
                $this->email->bcc($superadmin_email);
                $this->email->subject("Vendor Account Blocked");
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been blocked vendor account successfully.<br> "
                        . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor account has been " . $msg_type . " successfully",
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
            }
            echo "1";
        } else {

            echo "0";
        }
    }

    public function get_state_list() {
        $country_id = $this->input->post('country_id', TRUE);
        $data['get_state'] = $this->vendor_model->getState($country_id);
        $this->load->view('admin/ajax/ajax_get_state', $data);
    }

    public function get_city_list() {
        $state_id = $this->input->post('state_id', TRUE);
        $data['get_city'] = $this->vendor_model->getCity($state_id);
        $this->load->view('admin/ajax/ajax_get_city', $data);
    }

    public function view_vendor_document() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $form_no = base64_decode($this->uri->segment(2));
        $vendor_id = base64_decode($this->uri->segment(3));

        $data['get_vendor_data'] = $this->vendor_model->getVendorData($vendor_id);

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR DOCUMENTS";

        if ($form_no == '1') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
//            echo "<pre>";
//            print_r($data['get_form_details']);
            $this->load->view('admin/form_templates/print_ach_form', $data);
        } elseif ($form_no == '2') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
//            echo "<pre>";
//            print_r($data['get_form_details']);
            $this->load->view('admin/form_templates/print_subcontractor_form', $data);
        } elseif ($form_no == '3') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
//            echo "<pre>";
//            print_r($data['get_form_details']);
            $this->load->view('admin/form_templates/print_nda_form', $data);
        } elseif ($form_no == '4') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
//            echo "<pre>";
//            print_r($data['get_form_details']);
            $this->load->view('admin/form_templates/print_insurance_requirements', $data);
        }
    }

    public function verify_documents() {
        $recipients = array();
        $errors = "";
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $vendor_id = base64_decode($this->input->post('vendor_id'));
        $file_status = $this->input->post('file_status');
        $doc_id = $this->input->post('doc_id');

        if (!empty($doc_id)) {
            foreach ($doc_id as $dkey => $dval) {

                $get_doc_details = $this->vendor_model->getDocDetails($dval);
                if (!empty($get_doc_details)) {
                    $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                    $get_admin_details = $this->vendor_model->getAdminData($get_vendor_details[0]['admin_id']);
                    if (!empty($get_admin_details)) {
                        $sadmin_id = $get_admin_details[0]['sa_id'];
                        $recipients [] = 1 . "_" . "superadmin";
                        $recipients [] = $sadmin_id . "_" . "superadmin";
                        $recipients [] = $vendor_id . "_" . "vendor";
                    }
                    $get_superadmin_details = $this->vendor_model->getSuperAdminData($sadmin_id);
                }

                $update_arr = array(
                    "form_status" => $file_status[$dkey]
                );
                $update_status = $this->vendor_model->update_form($update_arr, $vendor_id, $dval);


                $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                $vendor_name = $get_vendor_details[0]['vendor_company_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $sa_admin_email = $get_superadmin_details[0]['sa_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $data["msg"] = ucwords($admin_name) . " has changed the " . ucwords($get_doc_details[0]['document_name']) . " status for " . ucwords($vendor_name) . ".";

//                if($file_status[$dkey] == '1') {
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($sa_admin_email);
                
                if (LATAM) {
                    $this->email->bcc($vendor_email);
                }
                if (US || INDIA) {
                    if (SEND_EMAIL_VENDOR_DOCUMENT) {
                        $this->email->bcc($vendor_email);
                    }
                }
                $this->email->bcc($superadmin_email);
                $this->email->subject('Vendor Document Status Verified Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();
//                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been verified vendor documents successfully.<br> "
                        . "<label><strong>Company Name : </strong>" . $vendor_name . "</label><br/>";

//                foreach($recipients as $rtval) {
//                    $r_arr = explode("_", $rtval);
//                    $recipient_id = $r_arr[0];
//                    $recipient_type = $r_arr[1];

                $sa_insert_arr = array(
                    "recipient_id" => 1,
                    "recipient_type" => "superadmin",
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Vendor Document Status Verified Successfully",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $sadmin_insert_arr = array(
                    "recipient_id" => $sadmin_id,
                    "recipient_type" => "superadmin",
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Vendor Document Status Verified Successfully",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );

                if (LATAM || SEND_EMAIL_VENDOR_DOCUMENT) {
                    $vendor_insert_arr = array(
                        "recipient_id" => $vendor_id,
                        "recipient_type" => "vendor",
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Vendor Document Status Verified Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
                }
                // print_r($insert_arr);
                // die;
                $sa_insert_query = $this->communication_model->add_mail($sa_insert_arr);
                $sadmin_insert_query = $this->communication_model->add_mail($sadmin_insert_arr);

                if (LATAM || SEND_EMAIL_VENDOR_DOCUMENT) {
                $vendor_insert_query = $this->communication_model->add_mail($vendor_insert_arr);
                }
                //                }

                /* ----------------------------------Insert Mail------------------------------------ */
            }
        }
        if ($update_status > '0') {
            $errors = "Documents Status Changed Successfully";
        } else {
            $errors = "Documents Status Changed Successfully";
        }
        if (!empty($errors)) {

            $this->session->set_flashdata('error_msgs', $errors);
            redirect(base_url() . 'verify_vendor_documents/' . base64_encode($vendor_id));
        }
    }

    public function uploads_admin_vendor_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $doc_id = base64_decode($this->uri->segment(2));
        $vendor_id = base64_decode($this->uri->segment(3));

        $data['get_document_details'] = $this->vendor_model->getDocDetails($doc_id);
        $data['get_vendor_details'] = $this->vendor_model->getVendorData($vendor_id);
        $data['admin_id'] = $data['get_details'][0]['admin_id'];
        $data['vendor_id'] = $vendor_id;
        $data['doc_id'] = $doc_id;

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "UPLOAD DOCUMENTS";

        $this->load->view('admin/uploads_admin_vendor_documents', $data);
    }

    public function upload_document() {

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');

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
                    redirect(base_url() . 'uploads-admin-vendor-documents/' . base64_encode($doc_id) . '/' . base64_encode($vendor_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'uploads-admin-vendor-documents/' . base64_encode($doc_id) . '/' . base64_encode($vendor_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->vendor_model->getDocDetails($doc_id);
        $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
        $insert_arr = array(
            'admin_id' => $admin_id,
            'vendor_id' => $vendor_id,
            'form_no' => $doc_id,
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s")
        );
        $del_query = $this->vendor_model->deletePreviousDocs($doc_id, $vendor_id, $admin_id);

        if ($del_query > 0) {
            $insert_query = $this->vendor_model->add_vendor_documents($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
                redirect(base_url() . 'verify_vendor_documents/' . base64_encode($vendor_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'verify_vendor_documents/' . base64_encode($vendor_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'verify_vendor_documents/' . base64_encode($vendor_id));
        }
    }

	/**Code added to include vendor documents in admin section**/
	public function view_admin_vendor_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
		
		//echo $email;
        
		$data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = base64_decode($this->uri->segment(2));
        $data['vendor_id'] = $vendor_id;

        $data['get_vendor_details'] = $this->vendor_model->getVendorData($vendor_id);
		$data['get_documents_details'] = $this->vendor_model->getDocumentsLists();
        
        $data['meta_title'] = "DOCUMENTS";
        $this->load->view('admin/view_admin_vendor_documents', $data);
    }
	
	public function approve_disapprove_vendor_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $recipients = array();

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
		$admin_name = ucwords($data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name']);
        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $vendor_id = $this->input->post('vendor_id', TRUE);

		$get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
        if (!empty($get_vendor_details)) {

            $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $get_admin_details = $this->vendor_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            $vendor_id = $get_vendor_details[0]['vendor_id'];
			

            if (!empty($get_admin_details)) {
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $get_sadmin_details = $this->vendor_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
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
                $check_form_status = $this->vendor_model->check_docs_status($vendor_id, $tid);
//                echo "<pre>";
//                print_r($check_sa_form_status);
//                
                if ($form_status == '0') {
                    if ($check_form_status[0]['form_status'] == '1') {
                        $change_status = $this->vendor_model->change_docs_status($update_arr, $vendor_id, $tid);
                        $get_document_details = $this->vendor_model->getUploadedDocs($tid, $vendor_id);
                        $msg .= $admin_name . " " . "has disapproved" . " " . $get_document_details[0]['form_name'] . " for " . $vendor_name . "<br/>";
						$data['msg'] = $msg;
                    } else {
                        $change_status = 0;
                    }
                } else if ($form_status == '1') {
                    if ($check_form_status[0]['form_status'] == '0') {
                        $change_status = $this->vendor_model->change_docs_status($update_arr, $vendor_id, $tid);
                        $get_document_details = $this->vendor_model->getUploadedDocs($tid, $vendor_id);
                        $msg .= $admin_name . " " . "has disapproved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
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
                
                if (LATAM){
                    $this->email->to($vendor_email);
                    $this->email->bcc($admin_email);
                }
                if (US || INDIA){
                    if (SEND_EMAIL_VENDOR_DOCUMENT) {
                        $this->email->to($vendor_email);
                        $this->email->bcc($admin_email);
                    } else {
                        $this->email->to($admin_email);
                    }
                }
                
                $this->email->bcc($superadmin_email);
                
                $this->email->subject('Documents Status Changed Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                
                   $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    
                
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
                redirect(base_url() . 'view_admin_vendor_documents/' . base64_encode($vendor_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Oops! Something went wrong!');
                redirect(base_url() . 'view_admin_vendor_documents/' . base64_encode($vendor_id));
            }
        }
//        echo "<pre>";
//        print_r($check);
//        die;
    }
	

	public function view_vendor_submiited_document() {
	 if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $form_no = base64_decode($this->uri->segment(2));
        $vendor_id = base64_decode($this->uri->segment(3));

        $data['get_vendor_data'] = $this->vendor_model->getVendorData($vendor_id);

        $data['page'] = "vendor_lists";
        $data['meta_title'] = "VENDOR DOCUMENTS";

        if ($form_no == '1') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
            $this->load->view('admin/form_templates/print_ach_form', $data);
        } elseif ($form_no == '2') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
            $this->load->view('admin/form_templates/print_subcontractor_form', $data);
        } elseif ($form_no == '3') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
            $this->load->view('admin/form_templates/print_nda_form', $data);
        } elseif ($form_no == '4') {

            $data['get_form_details'] = $this->vendor_model->getVendorDocument($form_no, $vendor_id);
            $this->load->view('admin/form_templates/print_insurance_requirements', $data);
        }
    }
	
	
}
