<?php
class Manage_Employee extends CI_Controller {

    public function edit_current_shift() {
        $shift_id = $this->uri->segment(2);   
    }

    public function activate_group() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $group_id = base64_decode($this->uri->segment(2));

        $update_res = $this->employee_model->activate_group($group_id);

        if ($update_res) {
            $this->session->set_flashdata('succ_msg', 'Group activated successfully');
            redirect(base_url() . 'employee_group_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Group not activated successfully');
            redirect(base_url() . 'employee_group_list');
        }
    }

    public function deactivate_group() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $group_id = base64_decode($this->uri->segment(2));

        $update_res = $this->employee_model->deactivate_group($group_id);

        if ($update_res) {
            $this->session->set_flashdata('succ_msg', 'Group deactivated successfully');
            redirect(base_url() . 'employee_group_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Group not deactivated successfully');
            redirect(base_url() . 'employee_group_list');
        }
    }

    public function blank_test_page() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $this->load->view('admin/blank_test_page', $data);
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
        $bg_order_id = $this->employee_model->get_order_id_by_phone_and_email($phone, $email);
        $bg_order_id = $bg_order_id[0]['bg_order_id'];

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
            "email":"admin@ptscservices.com",
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

        $this->employee_model->update_order_report($phone, $filename, $email);
        // exit;



        if ($status == 1) {
            $this->employee_model->update_order_status($phone, $email);
        }
        if ($status == 2) {
            $this->employee_model->update_order_status_needs_attention($phone, $email);
        }
        if ($status == 3) {
            $this->employee_model->update_order_status_canceled($phone, $email);
        }
        if ($status == 4) {
            $this->employee_model->update_order_status_archived($phone, $email);
        }
        redirect(site_url('admin-employee-list'));
    }

    public function submit_consultant_form() {
        $bg_check_id = $this->input->post('bg_check');
        $data['multiple_employee_details'] = $this->employee_model->get_multiple_employee_details($bg_check_id);
        // echo "<pre>".print_r($data['multiple_employee_details'],1)."</pre>";
        // exit;

        $employee_ids = '';
        foreach ($data['multiple_employee_details'] as $key => $value) {
            $first_name = '';
            $last_name = '';
            $address = '';
            $phone = '';
            $email = '';
            $emp_id = '';
            foreach ($value as $k => $v) {
                if ($k == 'employee_id') {
                    $emp_id = $v;
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
                if ($k == 'employee_email') {
                    $email = $v;
                    // echo $k.' : '.$v.'<br>';
                }
            }
            if (!empty($first_name) && !empty($last_name) && !empty($address) && !empty($email) & !empty($phone) && !empty($emp_id)) {


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
                    "email":"bapu@raj.com",
                    "password":"Admin@123"
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

                $employee_ids .= $emp_id.',';

                $this->employee_model->update_employee_bg_order_id($bg_order_id, $emp_id);
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
        $emp_ids = explode(',',$employee_ids);
        $this->employee_model->update_employee_bg_status($emp_ids);
        $this->session->set_flashdata('succ_msg', 'background check has been ordered for the selected consultants');
        redirect(site_url('admin-employee-list'));
    }

    public function approve_disapprove_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $recipients = array();

        $data['get_details'] = $this->profile_model->getDetails($email);
        $pdfData['get_details'] = $this->profile_model->getDetails($email);   // This line is deprecated
        $admin_name = ucwords($data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name']);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $form_no = $this->input->post('id');                                                    // This line is deprecated
        $get_file_details_pdf = $this->profile_model->getFileDetails($form_no, $employee_id);   // This line is deprecated
        //        echo "<pre>";
        //        print_r($get_file_details);
        if (!empty($get_file_details_pdf)) {                                                    // This line is deprecated
            $pdfData['form_name'] = $get_file_details_pdf[0]['form_name'];                      // This line is deprecated
            $pdfData['form_data'] = json_decode($get_file_details_pdf[0]['form_data']);         // This line is deprecated
        }
        $pdfData['img_src'] = "./assets/images/pts.jpg";                                        // This line is deprecated

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
    }

    public function emp_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //$employee_type = "E";
        // $get_employee_details = $this->employee_model->getEmployeeListsbyTypeNew();
        // $ncon_str = "";
        // $emp_str = "";
        // foreach ($get_employee_details as $eval) {
        //     $ncon_str .= $eval['employee_id'] . ",";
        // }
        // $emp_str = rtrim($ncon_str, ",");
        //        echo "<pre>";
        //       echo $con_str;
        //       die;

        // $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet($emp_str);
        // $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet($emp_str);
        // $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet($emp_str);
        //       echo "<pre>";
        //       print_r( $data['get_approved_timesheet_details'] );
        //       die;


        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "EMPLOYEE LISTS";
        $this->load->view('admin/admin_emp_timesheet', $data);
    }








    public function get_approved_timesheet_data_all() {
        // $sess_arr = $this->session->userdata('admin_logged_in');
        // $email = $sess_arr['email'];
        // $data['get_details'] = $this->profile_model->getDetails($email);
        // //$employee_type = "E";
        // $get_employee_details = $this->employee_model->getEmployeeListsbyTypeNew();
        // $ncon_str = "";
        // $emp_str = "";
        // foreach ($get_employee_details as $eval) {
        //     $ncon_str .= $eval['employee_id'] . ",";
        // }
        // $emp_str = rtrim($ncon_str, ",");
        //        echo "<pre>";
        //       echo $con_str;
        //       die;

        $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet();

        echo json_encode($data['get_approved_timesheet_details']);
    }

    public function get_pending_timesheet_data_all() {
        // $sess_arr = $this->session->userdata('admin_logged_in');
        // $email = $sess_arr['email'];
        // $data['get_details'] = $this->profile_model->getDetails($email);
        // //$employee_type = "E";
        // $get_employee_details = $this->employee_model->getEmployeeListsbyTypeNew();
        // $ncon_str = "";
        // $emp_str = "";
        // foreach ($get_employee_details as $eval) {
        //     $ncon_str .= $eval['employee_id'] . ",";
        // }
        // $emp_str = rtrim($ncon_str, ",");
        //        echo "<pre>";
        //       echo $con_str;
        //       die;

        $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet();

        echo json_encode($data['get_pending_timesheet_details']);
    }

    public function get_not_approved_timesheet_data_all() {
        // $sess_arr = $this->session->userdata('admin_logged_in');
        // $email = $sess_arr['email'];
        // $data['get_details'] = $this->profile_model->getDetails($email);
        // //$employee_type = "E";
        // $get_employee_details = $this->employee_model->getEmployeeListsbyTypeNew();
        // $ncon_str = "";
        // $emp_str = "";
        // foreach ($get_employee_details as $eval) {
        //     $ncon_str .= $eval['employee_id'] . ",";
        // }
        // $emp_str = rtrim($ncon_str, ",");

        $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet();

        echo json_encode($data['get_not_approved_timesheet_details']);
    }
}
