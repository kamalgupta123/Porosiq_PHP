<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('vendor_logged_in')) {
            if (INDIA || US) {
                set_referer_url();
            }
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $this->load->model('vendor/manage_employee_model', 'employee_model');
        $this->load->model('vendor/profile_model');
        $this->load->model('vendor/manage_vendor_model', 'vendor_model');
        $this->load->model('employee/manage_communication_model', 'communication_model');
    }

    public function index() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_country'] = $this->profile_model->getCountry();
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['page'] = "vendor_profile";
        $data['meta_title'] = "PROFILE";

        $this->load->view('vendor/profile', $data);
    }

    public function update_profile() {

        $db = get_instance()->db->conn_id;

        $vendor_id = base64_decode($this->input->post('vendor_id'));
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $vendor_designation = $this->input->post('vendor_designation');
        $vendor_company_name = $this->input->post('vendor_company_name');
        $company_id = $this->input->post('company_id');
        $federal_tax_id = $this->input->post('federal_tax_id');
        $vendor_email = $this->input->post('vendor_email');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
//        $contract_from_date = $this->input->post('contract_from_date');
//        $contract_to_date = $this->input->post('contract_to_date');
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

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $vendor_details = $this->profile_model->getVendorData($vendor_id);
//        print_r($supadmin_details);
//        die;

        if (isset($vendor_name) && $vendor_name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($client_support_cal_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_cal_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($client_support_pen_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pen_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($client_support_pu_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $client_support_pu_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($nmsdc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nmsdc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($wbenc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $wbenc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($sba_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $sba_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($vetbiz_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $vetbiz_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
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
                        redirect(base_url() . 'vendor_profile');
                    }
                    if (in_array($nglcc_file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $nglcc_file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'vendor_profile');
                    }
                }
            } else {
                $new_nglcc_file_name = $vendor_details[0]['nglcc_file'];
            }

            /* ---------------------------------Files Uploads--------------------------- */

            $update_arr = array(
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'vendor_designation' => $vendor_designation,
                'vendor_company_name' => $vendor_company_name,
                'company_id' => $company_id,
                'federal_tax_id' => $federal_tax_id,
                'vendor_email' => $vendor_email,
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
                'address' => $address,
                'updated_date' => date("Y-m-d h:i:s")
            );
//echo "<pre>";
//print_r($update_arr);
//die;
            $update = $this->profile_model->updateProfile($update_arr, $vendor_id);

            if ($update > 0) {


                $this->session->set_flashdata('succ_msg', 'Profile Updated Successfully.');
                redirect(base_url() . 'vendor_profile');
            } else {
                $this->session->set_flashdata('succ_msg', 'Profile Updated Successfully.');
                redirect(base_url() . 'vendor_profile');
            }
        }
    }

    public function get_state_list() {
        $country_id = $this->input->post('country_id', TRUE);
        $data['get_state'] = $this->profile_model->getState($country_id);
        $this->load->view('vendor/ajax/ajax_get_state', $data);
    }

    public function get_city_list() {
        $state_id = $this->input->post('state_id', TRUE);
        $data['get_city'] = $this->profile_model->getCity($state_id);
        $this->load->view('vendor/ajax/ajax_get_city', $data);
    }

    /* ------------------------------Documentation--------------------------- */

    public function documents_lists() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $this->load->view('vendor/documents_lists', $data);
    }

    public function upload_vendor_documents() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $this->load->view('vendor/upload_documents', $data);
    }

    public function upload_verification_documents() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $this->load->view('vendor/fill_verify_documents', $data);
    }

    public function upload_documents() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor');  // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data_arr = $this->profile_model->getDetails($email);
        //print_r($data['get_details']);
        $vendor_id = $data_arr[0]['vendor_id'];
        $vendor_files_details = $this->profile_model->getVendorFiles($vendor_id);
//echo "<pre>";
//print_r($vendor_files_details);
//die;
        if ($_FILES['file_1']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file_1']['name'];
            $file_size = $_FILES['file_1']['size'];
            $file_tmp = $_FILES['file_1']['tmp_name'];
            $file_type = $_FILES['file_1']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
            //print_r($file_ext_arr);

            $new_file_name_1 = $file_name;
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
                if (!empty($vendor_files_details) && $vendor_files_details[0]['file_1'] != '') {
                    $old_file = "./uploads/" . $vendor_files_details[0]['file_1'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name_1);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_documents');
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_documents');
                }
            }
        } else {
            $new_file_name_1 = $vendor_files_details[0]['file_1'];
        }

        if ($_FILES['file_2']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file_2']['name'];
            $file_size = $_FILES['file_2']['size'];
            $file_tmp = $_FILES['file_2']['tmp_name'];
            $file_type = $_FILES['file_2']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
            //print_r($file_ext_arr);

            $new_file_name_2 = $file_name;
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
                if (!empty($vendor_files_details) && $vendor_files_details[0]['file_2'] != '') {
                    $old_file = "./uploads/" . $vendor_files_details[0]['file_2'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name_2);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_documents');
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_documents');
                }
            }
        } else {
            $new_file_name_2 = $vendor_files_details[0]['file_2'];
        }

        if ($_FILES['file_3']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file_3']['name'];
            $file_size = $_FILES['file_3']['size'];
            $file_tmp = $_FILES['file_3']['tmp_name'];
            $file_type = $_FILES['file_3']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
            //print_r($file_ext_arr);

            $new_file_name_3 = $file_name;
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
                if (!empty($vendor_files_details) && $vendor_files_details[0]['file_3'] != '') {
                    $old_file = "./uploads/" . $vendor_files_details[0]['file_3'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name_3);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_documents');
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_documents');
                }
            }
        } else {
            $new_file_name_3 = $vendor_files_details[0]['file_3'];
        }

        if ($_FILES['file_4']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file_4']['name'];
            $file_size = $_FILES['file_4']['size'];
            $file_tmp = $_FILES['file_4']['tmp_name'];
            $file_type = $_FILES['file_4']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
            //print_r($file_ext_arr);

            $new_file_name_4 = $file_name;
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
                if (!empty($vendor_files_details) && $vendor_files_details[0]['file_4'] != '') {
                    $old_file = "./uploads/" . $vendor_files_details[0]['file_4'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name_4);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_documents');
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_documents');
                }
            }
        } else {
            $new_file_name_4 = $vendor_files_details[0]['file_4'];
        }

        $check_vendor_files = $this->profile_model->checkFiles($vendor_id);

        if ($check_vendor_files[0]['cnt'] > '0') {

            $update_file_arr = array(
                "vendor_id" => $vendor_id,
                "file_1" => $new_file_name_1,
                "file_1_status" => '0',
                "file_2" => $new_file_name_2,
                "file_2_status" => '0',
                "file_3" => $new_file_name_3,
                "file_3_status" => '0',
                "file_4" => $new_file_name_4,
                "file_4_status" => '0',
                "updated_date" => date("Y-m-d h:i:s")
            );

            $update_files = $this->profile_model->update_vendor_user_files($update_file_arr, $vendor_id);
        } else {

            $insert_file_arr = array(
                "vendor_id" => $vendor_id,
                "file_1" => $new_file_name_1,
                "file_1_status" => '0',
                "file_2" => $new_file_name_2,
                "file_2_status" => '0',
                "file_3" => $new_file_name_3,
                "file_3_status" => '0',
                "file_4" => $new_file_name_4,
                "file_4_status" => '0',
                "entry_date" => date("Y-m-d h:i:s")
            );

            $insert_files = $this->profile_model->insert_vendor_user_files($insert_file_arr);
        }


        if ($update_files != '0' || $insert_files != '0') {
            $this->session->set_flashdata('succ_msg', 'Documents Uploaded Successfully.');
            redirect(base_url() . 'vendor_documentation');
        } else {
            $this->session->set_flashdata('err_msg', 'Documents Not Uploaded Successfully.');
            redirect(base_url() . 'upload_vendor_documents');
        }
    }

    public function all_documents_lists() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_vendor_documents'] = $this->profile_model->getVendorAllDocuments();

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['page'] = "documentation";
        $data['meta_title'] = "DOCUMENTATIONS";

        $this->load->view('vendor/all_documents_lists', $data);
    }

    public function invoice() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_vendor_documents'] = $this->profile_model->getVendorAllDocuments();

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['page'] = "payment";
        $data['meta_title'] = "INVOICE";

        $this->load->view('vendor/invoice', $data);
    }

    public function invoice_submit() {
        $invoice_id = $this->input->post('invoice');

        $store = $this->input->post('store');

        $PONumber = $this->input->post('purchase_order');

        $date = $this->input->post('date');

        $description = $this->input->post('description');

        $unit_price = $this->input->post('unit_price');

        $quantity = $this->input->post('quantity');

        $total = $this->input->post('total');

        // if ($_FILES['attachment']['name'] != '') {
        //     $file_name = $_FILES['attachment']['name'];
        //     $file_tmp = $_FILES['attachment']['tmp_name'];
        //     $file_ext_arr = explode('.', $file_name);
        //     $file_ext = strtolower($file_ext_arr[1]);
        //     $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
        //     $file_path = "./uploads/admin/invoice/";
            
        //     if (!is_dir($file_path)) {
        //         mkdir($file_path, 0777, true);
        //     }
        //     $path = $file_path . $new_file_name;
        //     move_uploaded_file($file_tmp, $path);
        // }

        $insert_arr = array(

            'InvoiceNumber' => $invoice_id,
 
            'Store' => $store,
 
            'PONumber' => $PONumber,
 
            'Date' => $date,
 
            'Description' => $description,
 
            'UnitPrice' => $unit_price,
 
            'Quantity' => $quantity,
 
            'Total' => $total,

            // 'invoiceFilePath' => $path,

            'VendorID' => 18
         );
 
         print_r($insert_arr);
 
         $insert_id = $this->profile_model->insert_invoice($insert_arr);
         

         if ($insert_id) {
        //     $purchase_order = [
        //         'invoice' => $invoice_id,
        //         'store' => $store,
        //         'PONumber' => $PONumber,
        //         'date' => $date,
        //         'description' => $description,
        //         'unit_price' => $unit_price,
        //         'quantity' => $quantity,
        //         'total' => $total,
        //         'total' => $total
        //     ];

        //     $data['purchase_order'] = $purchase_order;
        //     $this->load->view('vendor/invoice_pdf_latest', $data);
            
            $this->session->set_flashdata('succ_msg', 'Invoice Added Successfully');

            redirect(base_url() . 'vendor_consultant_invoice');

        }

        else {

            $this->session->set_flashdata('error_msg', 'Failed to add Invoice');

            redirect(base_url() . 'vendor_consultant_invoice');

        }

        
    }

    public function submit_documents() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $doc_id = base64_decode($this->uri->segment(2));
        $vendor_id = base64_decode($this->uri->segment(3));
        $data['vendor_id'] = $vendor_id;
        $data['vendor_ip'] = $_SERVER['REMOTE_ADDR'];

        if ($doc_id == '1') {

            /* --------------------Vendor and Admin Details--------------------------- */

            $get_vendor_details = $this->profile_model->getVendorData($vendor_id);
            $data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_designation'] = $get_vendor_details[0]['vendor_designation'];
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];


            $get_admin_details = $this->profile_model->getAdminDetails($get_vendor_details[0]['admin_id']);

            $data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];
            $data['admin_designation'] = $get_admin_details[0]['admin_designation'];
            $data['admin_company_name'] = $get_admin_details[0]['admin_company_name'];

            /* --------------------Vendor and Admin Details--------------------------- */

            $data['form_name'] = "ACH FORM";

            $this->load->view('vendor/form_templates/ach_form', $data);
        } else if ($doc_id == '2') {
            $data['form_name'] = "COMPANY SUBCONTRACTOR AGREEMENT";
            $this->load->view('vendor/form_templates/updated_subcon', $data);
        } else if ($doc_id == '3') {

            /* --------------------Vendor and Admin Details--------------------------- */

            $get_vendor_details = $this->profile_model->getVendorData($vendor_id);
            $data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_designation'] = $get_vendor_details[0]['vendor_designation'];
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

            $get_admin_details = $this->profile_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            $data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];
            $data['admin_designation'] = $get_admin_details[0]['admin_designation'];
            $data['admin_company_name'] = $get_admin_details[0]['admin_company_name'];

            /* --------------------Vendor and Admin Details--------------------------- */

            $data['form_name'] = "NDA FORM";

            $this->load->view('vendor/form_templates/nda', $data);
        } else if ($doc_id == '4') {
            $data['form_name'] = "SUBCONTRACTOR MANDATORY INSURANCE REQUIREMENTS";
            $this->load->view('vendor/form_templates/insurance_requirements', $data);
        }
    }

    public function add_ach_form() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $form_name = $this->input->post('form_name');
        $ach_data['vendor_ip'] = $this->input->post('vendor_ip');
        $ach_data['name_of_corporation'] = mysqli_real_escape_string($db, $this->input->post('name_of_corporation'));
        $ach_data['corporation_address'] = mysqli_real_escape_string($db, $this->input->post('corporation_address'));
        $ach_data['point_of_contact'] = $this->input->post('point_of_contact');
        $ach_data['telephone_number'] = $this->input->post('telephone_number');
        $ach_data['email'] = $this->input->post('email');
        $ach_data['fin_institution'] = mysqli_real_escape_string($db, $this->input->post('fin_institution'));
        $ach_data['account_no'] = $this->input->post('account_no');
        $ach_data['routing_no'] = $this->input->post('routing_no');
        $ach_data['vendor_signature'] = $this->input->post('vendor_signature');
        $ach_data['img_src'] = "./assets/images/pts.jpg";


        /* --------------------Vendor and Admin Details--------------------------- */

        $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
        $ach_data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
        $ach_data['vendor_designation'] = $get_vendor_details[0]['vendor_designation'];
        $ach_data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        $ach_data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];
        $ach_data['admin_designation'] = $get_admin_details[0]['admin_designation'];
        $ach_data['admin_company_name'] = $get_admin_details[0]['admin_company_name'];

        /* --------------------Vendor and Admin Details--------------------------- */

        $insert_arr = array(
            'vendor_id' => $vendor_id,
            'form_no' => '1',
            'form_name' => $form_name,
            'form_data' => json_encode($ach_data),
            'form_status' => '0',
            'entry_date' => date("Y-m-d h:i:s")
        );

        $insert_query = $this->profile_model->add_form($insert_arr);
//        $insert_query = '1';
        if ($insert_query != '') {

            $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
            $data['company_id'] = $get_vendor_details[0]['company_id'];


            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;

            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $admin_email = $get_admin_details[0]['admin_email'];

            $data['msg'] = ucwords($vendor_name) . " has uploaded the ACH Form successfully. Please login and approve the ACH Form.";
            $msg = ucwords($vendor_name) . " has uploaded the ACH Form successfully. Please login and approve the ACH Form.";

            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('ACH Form uploaded successfully');
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

            $this->session->set_flashdata('succ_msg', 'ACH form updated Successfully');
            redirect(base_url() . 'all_documents_lists');
        } else {
            $this->session->set_flashdata('error_msg', 'ACH form not updated Successfully..');
            redirect(base_url() . 'all_documents_lists');
        }
    }

    public function add_subcontractor_form() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $form_name = $this->input->post('form_name');
        $sub_data['vendor_ip'] = $this->input->post('vendor_ip');
        $sub_data['con_day'] = $this->input->post('con_day');
        $sub_data['con_month'] = $this->input->post('con_month');
        $sub_data['con_year'] = $this->input->post('con_year');
        $sub_data['con_comp'] = $this->input->post('con_comp');
        $sub_data['con_location'] = $this->input->post('con_location');
        $sub_data['con_tin_no'] = $this->input->post('con_tin_no');
        $sub_data['emp_name'] = $this->input->post('emp_name');
        $sub_data['emp_designation'] = $this->input->post('emp_designation');
        $sub_data['emp_signature'] = $this->input->post('emp_signature');
        $sub_data['emp_witnessth'] = $this->input->post('emp_witnessth');

        $sub_data['img_src'] = "./assets/images/pts.jpg";

        $insert_arr = array(
            'vendor_id' => $vendor_id,
            'form_no' => '2',
            'form_name' => $form_name,
            'form_data' => json_encode($sub_data),
            'form_status' => '0',
            'entry_date' => date("Y-m-d h:i:s")
        );

        $insert_query = $this->profile_model->add_form($insert_arr);

        if ($insert_query != '') {

            $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);

            $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
            $data['company_id'] = $get_vendor_details[0]['company_id'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;

            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $admin_email = $get_admin_details[0]['admin_email'];

            $data['msg'] = ucwords($vendor_name) . " has uploaded the Subcontractor Form successfully. Please login and approve the Subcontractor Form.";
            $msg = ucwords($vendor_name) . " has uploaded the Subcontractor Form successfully. Please login and approve the Subcontractor Form.";

            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('Subcontractor Form updated Successfully');
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

            $this->session->set_flashdata('succ_msg', 'Subcontractor Form uploaded Successfully');
            redirect(base_url() . 'all_documents_lists');
        } else {
            $this->session->set_flashdata('error_msg', 'Subcontractor form not uploaded Successfully..');
            redirect(base_url() . 'all_documents_lists');
        }
    }

    public function add_insurance_form() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $form_name = $this->input->post('form_name');
        $inc_data['vendor_ip'] = $this->input->post('vendor_ip');
        $inc_data['img_src'] = "./assets/images/pts.jpg";

        $insert_arr = array(
            'vendor_id' => $vendor_id,
            'form_no' => '4',
            'form_name' => $form_name,
            'form_data' => json_encode($inc_data),
            'form_status' => '0',
            'entry_date' => date("Y-m-d h:i:s")
        );

        $insert_query = $this->profile_model->add_form($insert_arr);

        if ($insert_query != '') {

            $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);

            $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
            $data['company_id'] = $get_vendor_details[0]['company_id'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            if (!empty($get_admin_details)) {
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
            }

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;

            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $admin_email = $get_admin_details[0]['admin_email'];

            $data['msg'] = ucwords($vendor_name) . " has uploaded the Subcontractor Insurance Requirements Form successfully. Please login and approve the Subcontractor Insurance Requirements Form.";
            $msg = ucwords($vendor_name) . " has uploaded the Subcontractor Insurance Requirements Form successfully. Please login and approve the Subcontractor Insurance Requirements Form.";

            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('Subcontractor Insurance Requirements form updated Successfully');
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

            $this->session->set_flashdata('succ_msg', 'Subcontractor Insurance Requirements form updated Successfully');
            redirect(base_url() . 'all_documents_lists');
        } else {
            $this->session->set_flashdata('error_msg', 'Subcontractor Insurance Requirements form not updated Successfully..');
            redirect(base_url() . 'all_documents_lists');
        }
    }

    public function add_nda_form() {
        $recipients = array();
        $vendor_id = $this->input->post('vendor_id');
        $form_name = $this->input->post('form_name');
        $nda_data['vendor_ip'] = $this->input->post('vendor_ip');
        $nda_data['nda_day'] = $this->input->post('nda_day');
        $nda_data['nda_month'] = $this->input->post('nda_month');
        $nda_data['nda_year'] = $this->input->post('nda_year');
        $nda_data['recipient'] = $this->input->post('recipient');
        $nda_data['location'] = $this->input->post('location');
        $nda_data['owner'] = $this->input->post('owner');
        $nda_data['vendor_signature'] = $this->input->post('vendor_signature');
        $nda_data['img_src'] = "./assets/images/pts.jpg";


        /* --------------------Vendor and Admin Details--------------------------- */

        $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
        $nda_data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        $nda_data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];

        if (!empty($get_admin_details)) {
            $recipients [] = 1 . "_" . "superadmin";
            $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
            $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
        }
        /* --------------------Vendor and Admin Details--------------------------- */

        $insert_arr = array(
            'vendor_id' => $vendor_id,
            'form_no' => '3',
            'form_name' => $form_name,
            'form_data' => json_encode($nda_data),
            'form_status' => '0',
            'entry_date' => date("Y-m-d h:i:s")
        );

        $insert_query = $this->profile_model->add_form($insert_arr);

        if ($insert_query != '') {

            $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
            $data['company_id'] = $get_vendor_details[0]['company_id'];

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;

            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $admin_email = $get_admin_details[0]['admin_email'];

            $data['msg'] = ucwords($vendor_name) . " has uploaded the NDA form successfully. Please login and approve the NDA form.";
            $msg = ucwords($vendor_name) . " has uploaded the NDA form successfully. Please login and approve the NDA form.";

            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('NDA form updated Successfully');
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

            $this->session->set_flashdata('succ_msg', 'NDA form updated Successfully');
            redirect(base_url() . 'all_documents_lists');
        } else {
            $this->session->set_flashdata('error_msg', 'NDA form not updated Successfully..');
            redirect(base_url() . 'all_documents_lists');
        }
    }

    public function upload_vendor_files() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $data['vendor_id'] = $vendor_id;
        $data['doc_id'] = base64_decode($this->uri->segment(2));
        $data['doc_name'] = base64_decode($this->uri->segment(3));

        $data['page'] = "documentation";
        $data['meta_title'] = "UPLOAD DOCUMENTS";

        $this->load->view('vendor/upload_files', $data);
    }

    public function upload_file() {
        $recipients = array();
        $db = get_instance()->db->conn_id;

        $doc_id = $this->input->post('doc_id');
        $vendor_id = $this->input->post('vendor_id');
        $doc_name = $this->input->post('doc_name');



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

                move_uploaded_file($file_tmp, "./uploads/vendor_pdfs/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_vendor_files/' . base64_encode($doc_id) . '/' . base64_encode($doc_name));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_vendor_files/' . base64_encode($doc_id) . '/' . base64_encode($doc_name));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_vendor_details = $this->employee_model->getVendorDetails($vendor_id);
        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        if (!empty($get_admin_details)) {
            $recipients [] = 1 . "_" . "superadmin";
            $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
            $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
        }

        $delete_prev = $this->profile_model->deletePrevDocs($vendor_id,$doc_id,$doc_name);

        $insert_arr = array(
            'vendor_id' => $vendor_id,
            'form_no' => $doc_id,
            'form_name' => $doc_name,
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s")
        );
//        echo "<pre>";
//        print_r($insert_arr);
//        die;
        $insert_query = $this->profile_model->add_vendor_files($insert_arr);

        if ($insert_query != '') {

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;
            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $name_prefix = $get_vendor_details[0]['name_prefix'];
            $vendor_company_name = $get_vendor_details[0]['vendor_company_name'];
            $admin_email = $get_admin_details[0]['admin_email'];

            $data['msg'] = ucwords($name_prefix) . " " . ucwords($vendor_name) . " has uploaded " . ucwords($doc_name) . " for " . ucwords($vendor_company_name) . ". Please view and approve the documents.";
            $msg = ucwords($name_prefix) . " " . ucwords($vendor_name) . " has uploaded " . ucwords($doc_name) . " for " . ucwords($vendor_company_name) . ". Please view and approve the documents.";

            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('Pending Verification');
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
                    "subject" => "Pending Verification",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );

                $insert_query = $this->communication_model->add_mail($insert_arr);
            }

            /* ----------------------------------Insert Mail------------------------------------ */

            $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
            redirect(base_url() . 'all_documents_lists');
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'all_documents_lists');
        }
    }

    public function show_files() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $doc_id = base64_decode($this->uri->segment(2));
        $vendor_id = base64_decode($this->uri->segment(3));

        $get_file_details = $this->profile_model->getFileDetails($doc_id, $vendor_id);
//        echo "<pre>";
//        print_r($get_file_details);
        if (!empty($get_file_details)) {
            $form_data = json_decode($get_file_details[0]['form_data']);
        }

        $data['img_src'] = "./assets/images/pts.jpg";
        //print_r($data['form_data']);
        if ($doc_id == '1') {

            $data['vendor_ip'] = $form_data->vendor_ip;
            $data['name_of_corporation'] = $form_data->name_of_corporation;
            $data['corporation_address'] = $form_data->corporation_address;
            $data['point_of_contact'] = $form_data->point_of_contact;
            $data['telephone_number'] = $form_data->telephone_number;
            $data['email'] = $form_data->email;
            $data['fin_institution'] = $form_data->fin_institution;
            $data['account_no'] = $form_data->account_no;
            $data['routing_no'] = $form_data->routing_no;
            $data['name_of_corporation'] = $form_data->name_of_corporation;
            $data['vendor_signature'] = $form_data->vendor_signature;

            $get_vendor_details = $this->profile_model->getVendorData($vendor_id);
            $data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $data['vendor_designation'] = $get_vendor_details[0]['vendor_designation'];
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

            $get_admin_details = $this->profile_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            $data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];
            $data['admin_designation'] = $get_admin_details[0]['admin_designation'];
            $data['admin_company_name'] = $get_admin_details[0]['admin_company_name'];

            $this->load->view('vendor/form_templates/print_ach_form', $data);
        } elseif ($doc_id == '2') {

            $data['vendor_ip'] = $form_data->vendor_ip;
            $data['con_day'] = $form_data->con_day;
            $data['con_month'] = $form_data->con_month;
            $data['con_year'] = $form_data->con_year;
            $data['con_comp'] = $form_data->con_comp;
            $data['con_location'] = $form_data->con_location;
            $data['con_tin_no'] = $form_data->con_tin_no;
            $data['emp_name'] = $form_data->emp_name;
            $data['emp_designation'] = $form_data->emp_designation;
            $data['emp_signature'] = $form_data->emp_signature;
            $data['emp_witnessth'] = $form_data->emp_witnessth;

            $this->load->view('vendor/form_templates/print_subcontractor_form', $data);
        } elseif ($doc_id == '3') {

            $data['vendor_ip'] = $form_data->vendor_ip;
            $data['nda_day'] = $form_data->nda_day;
            $data['nda_month'] = $form_data->nda_month;
            $data['nda_year'] = $form_data->nda_year;
            $data['recipient'] = $form_data->recipient;
            $data['location'] = $form_data->location;
            $data['owner'] = $form_data->owner;
            $data['vendor_signature'] = $form_data->vendor_signature;
            $data['img_src'] = "./assets/images/pts.jpg";

            $get_vendor_details = $this->profile_model->getVendorData($vendor_id);
            $data['vendor_name'] = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
            $get_admin_details = $this->profile_model->getAdminDetails($get_vendor_details[0]['admin_id']);
            $data['admin_name'] = $get_admin_details[0]['name_prefix'] . "" . $get_admin_details[0]['first_name'] . "" . $get_admin_details[0]['last_name'];

            $this->load->view('vendor/form_templates/print_nda_form', $data);
        } elseif ($doc_id == '4') {
            $data['vendor_ip'] = $form_data->vendor_ip;
            $data['img_src'] = "./assets/images/pts.jpg";
            $this->load->view('vendor/form_templates/print_insurance_requirements', $data);
        }
    }

    /* ------------------------------Documentation--------------------------- */
}
