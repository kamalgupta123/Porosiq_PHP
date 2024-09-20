<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) {
            set_referer_url();
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $this->load->model('admin/manage_employee_model', 'employee_model');
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        $this->load->model('admin/profile_model');
        $this->load->model('admin/manage_communication_model', 'communication_model');
		// $this->load->model('admin/manage_ten99user_model', 'ten99user_model');
    }

    public function index() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_vendor'] = $this->vendor_model->getVendorLists($admin_id);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT ADD";

        $this->load->view('admin/add_employee_user', $data);
    }

    public function employee_lists() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        // $vendor_str = "";
        // $get_vendor_dtls_arr = $this->employee_model->getVendorLists();
        #$admin_id
        /*foreach ($get_vendor_dtls_arr as $v_val) {
            $vendor_str .= $v_val['vendor_id'] . ",";
        }
        $vendor_ids = rtrim($vendor_str, ",");
        if ($admin_id != '9' && $admin_id != '10') {
            $data['get_employee_details'] = $this->employee_model->getEmployeeListsByVendor($vendor_ids, $admin_id);
        } else {
            $data['get_employee_details'] = $this->employee_model->getAllEmployeeLists();
        }*/
        $data['get_employee_details'] = $this->employee_model->getConsultantLists();
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT LISTS";

        $this->load->view('admin/employee_lists', $data);
    }

    public function all_employee_current_status() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            
            if (INDIA) {
            $data['admin_type_id'] = $sess_arr['admin_type_id'];
            }

            $admin_id = $data['get_details'][0]['admin_id'];

            $employee_id = base64_decode($this->uri->segment(2));
            
            if (INDIA) {
                if ( $data['admin_type_id'] == 6 ) {
                    $data['get_all_employees_list'] = $this->employee_model->get_employees_list_all();
                }
                else {
                    $data['get_all_employees_list'] = $this->employee_model->get_all_employees_list($admin_id);
                }

            }
            if (US) {
                $data['get_all_employees_list'] = $this->employee_model->get_all_employees_list($admin_id);
            }
            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/all_employee_current_status', $data);
        }
    }

    public function employee_shift_list() {
        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['get_employee_shift_list'] = $this->employee_model->get_employee_shift_list();

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE SHIFT";

            $this->load->view('admin/employee_shift_list', $data);
        
       }
    }

    public function delete_current_shift() {
        if (INDIA) {
            $shift_id = $this->uri->segment(2);
            echo $shift_id."<br>";

            $employee_assigned_to_shift = $this->employee_model->get_employee_assigned_to_shift($shift_id);
            $employee_count = $employee_assigned_to_shift[0]->count;
            print_r($employee_count."<br>");

            $group_assigned_to_shift = $this->employee_model->get_group_assigned_to_shift($shift_id);
            $group_count = $group_assigned_to_shift[0]->count;
            print_r($group_count."<br>");

            if ($employee_count == 0 && $group_count == 0) {
                $this->employee_model->delete_master_shift($shift_id);
                $this->session->set_flashdata('succ_msg', 'Shift deleted successfully');
                redirect(base_url() . 'employee_shift_list');
            }
            else {
                $this->session->set_flashdata('error_msg', 'This shift is already assigned to a group or employee, so it cannot be deleted');
                redirect(base_url() . 'employee_shift_list');
            }
        }
    }

    public function assign_shift_to_employees() {
        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;
            $shift_id = $this->uri->segment(2);

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['shift_id'] = $shift_id;

            $data['current_shift_details'] = $this->employee_model->get_master_shift_data($shift_id);

            $data['shift_name'] = $data['current_shift_details'][0]->employee_shift_type;

            $data['all_employees']  = $this->employee_model->get_all_employees($shift_id);

            $data['all_groups'] = $this->employee_model->get_all_groups($shift_id);

            $data['get_all_employee_shift_list'] = $this->employee_model->get_all_employee_shift_list($shift_id);

            $data['get_group_list_of_shift'] = $this->employee_model->get_group_list_of_shift($shift_id);

            $this->load->view('admin/all_employee_shift_list', $data);
        }
    }
    
    public function assign_shift_to_employee() {
        if (INDIA) {    
            $employee_id = $this->input->post('employee_id');
            $shift_id = $this->input->post('shift_id');
    
            $current_shift_id = $this->employee_model->get_shift_id_of_current_employee($employee_id);
    
            $curr_shift_id = $current_shift_id[0]->shift_id;
            // exit;
    
            if (!$curr_shift_id) {
                $this->employee_model->assign_shift_to_employee($employee_id, $shift_id);
                $this->session->set_flashdata('succ_msg', 'Successfully assigned shift to employee');
            }
            else {
                $shift_data = $this->employee_model->get_master_shift_data($curr_shift_id);
                $this->session->set_flashdata('error_msg', 'This employee is already assigned to '.$shift_data[0]->employee_shift_type.' so it cannot be reassigned to a shift');
            }
    
            echo true;
        }
    }
        
    public function remove_employee_from_shift() {
        if (INDIA) {
            $employee_id = $this->input->post('employee_id');
            $shift_id = $this->input->post('shift_id');

            $this->employee_model->assign_shift_to_employee($employee_id, $shift_id);

            $this->session->set_flashdata('succ_msg', 'Successfully removed employee from shift');

            echo true;
        }
    }
    
    public function assign_shift_to_group() {
        if (INDIA) {
            $group_id = $this->input->post('group_id');
            $shift_id = $this->input->post('shift_id');
    
            $current_shift_id = $this->employee_model->get_shift_id_of_current_group($group_id);

            $curr_shift_id = $current_shift_id[0]->shift_id;

            if (!$curr_shift_id) {
                $this->employee_model->assign_shift_to_group($group_id, $shift_id);
                $this->employee_model->assign_same_shift_to_group_employees($group_id, $shift_id);
                $this->session->set_flashdata('succ_msg', 'Successfully assigned shift to group');
            }
            else {
                $shift_data = $this->employee_model->get_master_shift_data($curr_shift_id);
                $this->session->set_flashdata('error_msg', 'This group is already assigned to '.$shift_data[0]->employee_shift_type.' so it cannot be reassigned to a shift');
            }
    
            echo true;
        }
    }

    public function remove_group_from_shift() {
        if (INDIA) {
            $group_id = $this->input->post('group_id');
            $shift_id = $this->input->post('shift_id');

            $this->employee_model->assign_shift_to_group($group_id, $shift_id);
            $this->employee_model->assign_same_shift_to_group_employees($group_id, $shift_id);

            $this->session->set_flashdata('succ_msg', 'Successfully removed group from shift');

            echo true;
        }
    }

    public function submit_all_employee_shift() {
        if (INDIA) {
            $employee_ids = $this->input->post('employee_id');
            $shift_id = $this->input->post('shift_id');
    
            $this->employee_model->update_all_employee_shift_id($employee_ids, $shift_id);
    
            redirect(base_url() . 'employee_shift_list');
        }
    }

    public function create_new_group() {
        if (INDIA) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $group_name = $this->input->post('group_name');
            $group_desc = $this->input->post('group_desc');

            $insert_arr = [
                'group_name' => $group_name,
                'group_description' => $group_desc,
                'shift_id' => null,
                'created_by' => $admin_id,
                'created_time' => date("Y-m-d h:i:s"),
                'modified_by' => null,
                'modified_time' => null,
            ];

            $insert_id = $this->employee_model->insert_new_group($insert_arr);

            if ($insert_id) {
                $this->session->set_flashdata('succ_msg', 'group added successfully');
            }
            else {
                $this->session->set_flashdata('error_msg', 'failed to add group');
            }

            echo $insert_id;
        }
    }

    public function update_group_name() {
        if (INDIA) {
            $edited_group_name = $this->input->post('edited_group_name');
            $group_id = $this->input->post('group_id');

            $update_arr = [
                'group_name' => $edited_group_name,
            ];

            $this->employee_model->update_group_name($update_arr, $group_id);
        }
    }
    
    public function employee_group_list() {
        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['get_employee_group_list'] = $this->employee_model->get_employee_group_list();


            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE GROUP";

            $this->load->view('admin/employee_group_list', $data);

        }
    }

    public function assign_group_to_employees() {
        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;
            $group_id = $this->uri->segment(2);

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['group_id'] = $group_id;

            $data['current_group_name'] = $this->employee_model->get_current_group_name($group_id);

            $data['get_all_employee_group_list'] = $this->employee_model->get_current_group_employees($group_id);

            $this->load->view('admin/all_employee_group_list', $data);
        }
    }

    public function add_remove_employee_from_group() {
        if (INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }

            $group_id = $this->uri->segment(2);

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['group_id'] = $group_id;

            $data['current_group_name'] = $this->employee_model->get_current_group_name($group_id);

            $data['members'] = $this->employee_model->get_members($group_id);

            $data['not_members'] = $this->employee_model->get_not_members($group_id);

            $this->load->view('admin/add_remove_employee_from_group', $data);
        }
    }

    public function save_members_not_members() {
        if (INDIA) {
            $group_id = $this->input->post('group_id');
            $add_ids = $this->input->post('addIds');
            $remove_ids = $this->input->post('removeIds');

            $members_added = $this->employee_model->add_members_to_group($group_id, $add_ids);

            $members_removed = $this->employee_model->remove_members_from_group($remove_ids);

            if ($members_added || $members_removed) {
                echo json_encode(array('status' => true));
            }
            else {
                echo json_encode(array('status' => false));
            }
        }
    }





    public function all_shift_list() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $employee_id = base64_decode($this->uri->segment(2));
            $data['get_all_shift_list'] = $this->employee_model->get_master_shift_list();

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/all_employee_master_shift_list', $data);
        }
    }

    public function delete_employee_master_shift() {
        if (US || INDIA) {
            $shift_id = $this->input->post('shift_id');
            $data = $this->employee_model->delete_master_shift($shift_id);
            echo $data;
        }
    }

    public function edit_employee_master_shift() {
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }

            if (INDIA) { 
                $shift_id = $this->uri->segment(2); 
            }
            if (US) { 
                $shift_id = $this->input->get('shift_id'); 
            }
            $edit_data = $this->employee_model->get_master_shift_data($shift_id);

            $data = [
                'shift_id' => $shift_id,
                'employee_shift_type' => $edit_data[0]->employee_shift_type,
                'days' => explode(',',$edit_data[0]->days),
                'daily_shift_start_time' => $edit_data[0]->daily_shift_start_time,
                'daily_shift_end_time' => $edit_data[0]->daily_shift_end_time,
                'paid_break_hours' => $edit_data[0]->paid_break_hours,
                'unpaid_break_hours' => $edit_data[0]->unpaid_break_hours,
                'comment' => $edit_data[0]->comment,
            ];

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            // $employee_id = base64_decode($this->uri->segment(2));

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";
            $this->load->view('admin/edit_employee_shift_data', $data);
        }
    }

    public function update_employee_master_shift_data() {
        if (US || INDIA) {
            $shift_id = $this->input->post('shift_id');
            $employee_shift_type = $this->input->post('employee_shift_type');
            $days = $this->input->post('days');

            $days_str = '';
            foreach ( $days as $d ) {
                $days_str .= $d.',';
            }
            $days_str = substr($days_str, 0, strlen($days_str)-1);

            $daily_shift_start_time = $this->input->post('daily_shift_start_time');
            $daily_shift_end_time = $this->input->post('daily_shift_end_time');
            $paid_break_hours = $this->input->post('paid_break_hours');
            $unpaid_break_hours = $this->input->post('unpaid_break_hours');
            $comment = $this->input->post('comment');

            $update_arr = array(
                "employee_shift_type" => $employee_shift_type,
                "daily_shift_start_time" => $daily_shift_start_time,
                "daily_shift_end_time" => $daily_shift_end_time,
                "paid_break_hours" => $paid_break_hours,
                "unpaid_break_hours" => $unpaid_break_hours,
                "days" => $days_str,
                "comment" => $comment,
            );

            $update_query = $this->employee_model->update_employee_master_shift_data($update_arr, $shift_id);

            if ($update_query != '') {
                $this->session->set_flashdata('succ_msg', 'Employee master shift data updated successfully');
                if (INDIA) { 
                    redirect(base_url() . 'employee_shift_list'); 
                }
                if (US) { 
                    redirect(base_url() . 'all-shift-list'); 
                }
            }
            else {
                $this->session->set_flashdata('error_msg', 'Failed to update employee master shift data');
                if (INDIA) { 
                    redirect(base_url() . 'employee_shift_list'); 
                }
                if (US) { 
                    redirect(base_url() . 'all-shift-list'); 
                }
            }
        }
    }








    public function add_employee_shift_data() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            // $db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            // $employee_id = base64_decode("Mjg=");
            // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
            // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
            // $data['get_client'] = $this->employee_model->getClientLists();

            // $admin_id = $data['get_details'][0]['admin_id'];
            // $data['admin_id'] = $admin_id;

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/add_employee_shift_data', $data);
        }
    }

    public function add_employee_master_shift_data() {
        if (US || INDIA) {
            $employee_id = base64_decode($this->input->post('employee_id'));
            $employee_shift_type = $this->input->post('employee_shift_type');
            $days = $this->input->post('days');

            $days_str = '';
            foreach ( $days as $d ) {
                $days_str .= $d.',';
            }
            $days_str = substr($days_str, 0, strlen($days_str)-1);

            $daily_shift_start_time = $this->input->post('daily_shift_start_time');
            $daily_shift_end_time = $this->input->post('daily_shift_end_time');
            $paid_break_hours = $this->input->post('paid_break_hours');
            $unpaid_break_hours = $this->input->post('unpaid_break_hours');
            $comment = $this->input->post('comment');

            $all_shift_names = $this->employee_model->get_all_shift_names();

            $all_shifts = [];

            foreach($all_shift_names as $a) {
                $all_shifts[] = $a['employee_shift_type'];
            }

            if (in_array($employee_shift_type, $all_shifts)) {
                $this->session->set_flashdata('error_msg', 'Shift name cannot be same');
                redirect(base_url() . 'add-new-shift');
            }

            $insert_arr = array(
                "employee_shift_type" => $employee_shift_type,
                "daily_shift_start_time" => $daily_shift_start_time,
                "daily_shift_end_time" => $daily_shift_end_time,
                "paid_break_hours" => $paid_break_hours,
                "unpaid_break_hours" => $unpaid_break_hours,
                "days" => $days_str,
                "comment" => $comment,
            );

            $insert_query = $this->employee_model->add_employee_master_shift_data($insert_arr);

            if ($insert_query != '') {
                $this->session->set_flashdata('succ_msg', 'Employee master shift data added successfully');
                if (INDIA) { 
                    redirect(base_url() . 'employee_shift_list'); 
                }
                if (US) { 
                    redirect(base_url() . 'add-new-shift'); 
                }
            }
            else {
                $this->session->set_flashdata('error_msg', 'Failed to add employee master shift data');
                if (INDIA) { 
                    redirect(base_url() . 'employee_shift_list'); 
                }
                if (US) { 
                    redirect(base_url() . 'add-new-shift'); 
                }
            }
        }
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


    public function change_block_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));

        if ($bs_type == 'block') {
            $update_arr = array(
                'block_status' => '1'
            );
        } else if ($bs_type == 'unblock') {
            $update_arr = array(
                'block_status' => '0'
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
                'status' => '0'
            );
        } else if ($bs_type == 'deactivate') {
            $update_arr = array(
                'status' => '1'
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
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $employee_id = base64_decode($this->input->post('employee_id'));
        $name_prefix = $this->input->post('name_prefix');
        $employee_name = $this->input->post('employee_name');
        $employee_code = $this->input->post('employee_code');
        $employee_designation = $this->input->post('employee_designation');
        $employee_category = $this->input->post('employee_category');
        $employee_email = $this->input->post('employee_email');
        $password = $this->input->post('password');
        $conf_password = $this->input->post('conf_password');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $employee_details = $this->employee_model->getEmployeeData($employee_id);

        if (isset($employee_name) && $employee_name == '') {
            $this->session->set_flashdata('error_msg', 'Name field cannot be blank');
            redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
        } elseif ($conf_password != $password) {
            $this->session->set_flashdata('error_msg', 'Password and Confirm Password mismatch');
            redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
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
                        redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
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
                        redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

            if ($password != '') {
                $pwd = md5($password);
            } else {
                $pwd = $employee_details[0]['employee_password'];
            }

            $update_arr = array(
                'name_prefix' => $name_prefix,
                'employee_name' => $employee_name,
                'employee_designation' => $employee_designation,
                'employee_category' => $employee_category,
                'employee_code' => $employee_code,
                'employee_email' => $employee_email,
                'employee_password' => $pwd,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'date_of_joining' => $date_of_joining,
                'employee_bill_rate' => $employee_bill_rate,
                'updated_date' => date("Y-m-d h:i:s")
            );
            //echo "<pre>";
            //            print_r($update_arr);
            //            die;
            $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Employee updated Successfully..');
                redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Employee not updated Successfully..');
                redirect(base_url() . 'edit_admin_employee/' . base64_encode($employee_id));
            }
        }
    }

    public function view_employees_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
        //        echo $get_vendor_id->vendor_id;
        //        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_project_details'] = $this->employee_model->getEmployeeProjects($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmp($employee_id);
        $data['get_timesheet_details_nt_approved'] = $this->employee_model->getTimesheetDetailsnotapprove($employee_id);
        $data['get_timesheet_details_pending'] = $this->employee_model->getTimesheetDetailspending($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];


        if ($employee_type == 'C') {
            $data['page'] = "employee_lists";
            $data['meta_title'] = "CONSULTANT DOCUMENTS";
        } else {
            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE DOCUMENTS";
        }

        $this->load->view('admin/employees_project_timesheet', $data);
    }

    public function view_project_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $project_id = base64_decode($this->uri->segment(2));
        $employee_id = base64_decode($this->uri->segment(3));

        $data['get_timesheet_data'] = $this->employee_model->getTimesheetData($project_id, $employee_id);

        $data['project_id'] = $project_id;
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT TIMESHEET";

        $this->load->view('admin/view_project_timesheet', $data);
    }

    public function add_admin_employee_work_order() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $data['employee_id'] = base64_decode($this->uri->segment(2));
            $get_employee_details = $this->employee_model->getEmployeeData($data['employee_id']);
            $data['vendor_id']            = $get_employee_details[0]['vendor_id'];
            $data['employee_code']        = $get_employee_details[0]['employee_code'];
            $data['employee_name_prefix'] = $get_employee_details[0]['name_prefix'];
            $data['employee_name']        = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

            //$data['get_employee_details'] = $get_employee_details;

            $get_vendor_details = $this->employee_model->getVendorDtls($data['vendor_id'] );
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];
            $data['vendor_designation']  = $get_vendor_details[0]['vendor_designation'];
            $data['vendor_poc_name']     = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];

            $data['get_client_details'] = $this->employee_model->getClientDetails();

            $data['page'] = "employee_lists";
            $data['meta_title'] = "EMPLOYEE WORK ORDER";

            $this->load->view('admin/add_admin_employee_work_order', $data);
        }
        if (LATAM) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $employee_id = base64_decode($this->uri->segment(2));
            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $vendor_id = $get_employee_details[0]['vendor_id'];
            $admin_id = $data['get_details'][0]['admin_id'];
            $data['vendor_id'] = $vendor_id;
            $data['admin_id'] = $admin_id;
            $data['employee_id'] = $employee_id;
    
            $data['get_employee_details'] = $get_employee_details;
            $data['get_vendor_details'] = $this->employee_model->getVendorDtls($vendor_id);
            $data['get_client_details'] = $this->employee_model->getClientDetails();
            $data['page'] = "employee_lists";
            $data['meta_title'] = "EMPLOYEE WORK ORDER";
    
            $this->load->view('admin/add_admin_employee_work_order', $data);
        }
    }

    public function edit_admin_employee_work_order() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];
            $employee_id = base64_decode($this->uri->segment(2));
            $data['employee_id'] = $employee_id;

            $get_work_details = $this->employee_model->getWorkDetails($employee_id);
            $stage = $get_work_details[0]['stage'];

            $data['is_edit_allowed'] = true;
            if ($stage == 5) {
                $this->session->set_flashdata('error_msg', 'Work order PDF is already created.');
                redirect(base_url() . 'admin_consultant_lists');

            } else if ($stage == 4) {
                $data['is_edit_allowed'] = false;
            }

            $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
            $data['consultant_name'] = $get_work_details[0]['consultant'];
            $data['cons_start_date'] = $get_work_details[0]['start_date'];
            $data['readonly_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
            $data['project_duration'] = $get_work_details[0]['project_duration'];
            $data['bill_rate'] = $get_work_details[0]['bill_rate'];
            $data['ot_rate'] = $get_work_details[0]['ot_rate'];
            $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
            $data['payment_terms'] = $get_work_details[0]['payment_terms'];
            $data['client_name'] = $get_work_details[0]['client_name'];

            if ($get_work_details[0]['client_name'] != '') {
                $get_work_note = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
                $data['work_note'] = $get_work_note[0]['work_order_note'];

            } else {
                $data['work_note'] = " ";
            }
            $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
            $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
            $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
            $data['vendor_id'] = $get_work_details[0]['vendor_id'];

            if ($get_work_details[0]['vendor_signature_date'] == "0000-00-00") {
                $data['vendor_signature_date'] = "";
            } else {
                $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
            }

            $get_vendor_details = $this->employee_model->getVendorDtls($get_work_details[0]['vendor_id']);
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];


            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            if (!empty($get_employee_details)) {
                $employee_code = $get_employee_details[0]['employee_code'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_name_prefix = $get_employee_details[0]['name_prefix'];
            }
            $data['employee_details'] = $employee_name_prefix . " " . ucwords($employee_name) . " [ " . strtoupper($employee_code) . " ] ";

            $data['get_client_details'] = $this->employee_model->getClientDetails();

            $data['page'] = "employee_lists";
            $data['meta_title'] = "EMPLOYEE WORK ORDER";

            unset($get_work_details, $stage, $get_vendor_details, $get_employee_details, $employee_code, $employee_name, $employee_name_prefix);

            $this->load->view('admin/edit_admin_employee_work_order', $data);
        }
        if (LATAM) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
    
    
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];
            $employee_id = base64_decode($this->uri->segment(2));
            $data['employee_id'] = $employee_id;
    
            $data['get_work_details'] = $this->employee_model->getWorkDetails($employee_id);
            $data['get_vendor_details'] = $this->employee_model->getVendorDtls($data['get_work_details'][0]['vendor_id']);
            $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
            $data['get_client_details'] = $this->employee_model->getClientDetails();
    
            $data['page'] = "employee_lists";
            $data['meta_title'] = "EMPLOYEE WORK ORDER";
    
            $this->load->view('admin/edit_admin_employee_work_order', $data);
        }
    }

    public function insert_admin_employee_work_order() {
        $db = get_instance()->db->conn_id;

        $vendor_id = $this->input->post('vendor_id');
        $employee_id = $this->input->post('employee_id');
        $admin_id = $this->input->post('admin_id');
        $consultant = $this->input->post('consultant');
        if (US || INDIA) {
        $agreement_date = $this->input->post('agreement_date'); 
        }
        $start_date = $this->input->post('start_date');
        $client_name = $this->input->post('client_name');
        $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
        $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
        $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
        $bill_rate = $this->input->post('bill_rate');
        $ot_rate = $this->input->post('ot_rate');
        $vendor_poc_name = $this->input->post('vendor_poc_name');
        $vendor_poc_designation = $this->input->post('vendor_poc_designation');

        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add_admin_employee_work_order/' . base64_encode($employee_id)));
        } else {
            
            if (US || INDIA) {
                $insert_arr = array(
                    'vendor_id' => $vendor_id,
                    'employee_id' => $employee_id,
                    'admin_id' => $admin_id,
                    'consultant' => $consultant,
                    'agreement_date' => $agreement_date,
                    'start_date' => $start_date,
                    'client_name' => $client_name,
                    'project_duration' => $project_duration,
                    'invoicing_terms' => $invoicing_terms,
                    'payment_terms' => $payment_terms,
                    'bill_rate' => $bill_rate,
                    'ot_rate' => $ot_rate,
                    'vendor_poc_name' => $vendor_poc_name,
                    'vendor_poc_designation' => $vendor_poc_designation,
                    'stage' => '2',
                    'entry_date' => date("Y-m-d h:i:s")
                );
                $insert_query = $this->employee_model->add_work_order($insert_arr);
            }
            if (LATAM) {
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
                $insert_query = $this->employee_model->add_work_order($insert_arr);
                }
            
            if ($insert_query != '') {
                
                if (US || INDIA) {
                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                    $employee_code = $get_employee_details[0]['employee_code'];

                    $sess_arr = $this->session->userdata('admin_logged_in');
                    $admin_email = $sess_arr['email'];
                    $get_details = $this->profile_model->getDetails($admin_email);
                    $admin_id = $get_details[0]['admin_id'];
                    $admin_name = ucwords($get_details[0]['first_name'] . " " . $get_details[0]['last_name']);


                    send_emails_work_order(2, 'admin', [
                        'init_user_full_name' => $admin_name,
                        'con_full_name' => $employee_name,
                        'con_code' => $employee_code,
                        'access_link_part' => 'edit-sadmin-employee-work-order/' . base64_encode($employee_id),
                    ], [
                        SUPERADMIN_EMAIL,
                    ], [
                        $admin_email,
                    ]);
                }
                if (LATAM) {
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
                    $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                    $this->email->set_mailtype('html');
                    $this->email->send();
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br>" . ucwords($admin_name) . " has added work order for " . ucwords($employee_name). ".";

                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Work Order Added Successfully!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Work Order Added Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Work Order Not Added Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            }
        }
    }

    public function update_admin_employee_work_order() {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $get_details = $this->profile_model->getDetails($email);

            //details to send mail
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $db = get_instance()->db->conn_id;

            $vendor_id = $this->input->post('vendor_id');
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
            //$approved_by_admin = $this->input->post('approved_by_admin');
            
        if (LATAM) {
                $approved_by_admin = $this->input->post('approved_by_admin');
            }

        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
            redirect(base_url('edit_admin_employee_work_order/' . base64_encode($employee_id)));
        } else {
            
            if (US || INDIA) {
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
                    'approved_by_superadmin' => '0',
                    'updated_date' => date("Y-m-d h:i:s")
                );
            }
            if (LATAM) {
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
                    'approved_by_admin' => $approved_by_admin,
                    'updated_date' => date("Y-m-d h:i:s")
                );
            }

            $update_query = $this->employee_model->update_work_order($update_arr, $employee_id);

            if ($update_query != '') {
                
                if (US || INDIA) {
                    //$get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                    $superadmin_email = SUPERADMIN_EMAIL;

                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                    $employee_code = $get_employee_details[0]['employee_code'];

                    $sess_arr = $this->session->userdata('admin_logged_in');
                    $admin_email = $sess_arr['email'];
                    $data['get_details'] = $this->profile_model->getDetails($admin_email);
                    $admin_id = $data['get_details'][0]['admin_id'];
                    $admin_name = ucwords($data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name']);

                    send_emails_work_order(2, 'admin', [
                        'init_user_full_name' => $admin_name,
                        'con_full_name' => $employee_name,
                        'con_code' => $employee_code,
                        'access_link_part' => 'edit-sadmin-employee-work-order/' . base64_encode($employee_id),
                    ], [
                        $superadmin_email,
                    ], [
                        $admin_email,
                    ], [], true);
                }
                if (LATAM) {
                    $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                    $data['company_id'] = $get_vendor_details[0]['company_id'];

                    $get_admin_email = $this->vendor_model->getAdminEmail($get_vendor_details[0]['admin_id']);

                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;

                    $vendor_email = $get_vendor_details[0]['vendor_email'];
                    $admin_email = $get_admin_email[0]['admin_email'];
                    $admin_name = ucwords($get_admin_email[0]['first_name'] . " " . $get_admin_email[0]['last_name']);
                    $data['msg'] = ucwords($admin_name) . " has approved work order for " . ucwords($employee_name);
                    //Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($vendor_email);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Work Order Approved Successfully');
                    $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                    $this->email->set_mailtype('html');
                    $this->email->send();
                    
                    //to send mails
                
                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                }

            /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br>" . ucwords($admin_name) . " has updated work order for " . ucwords($employee_name). ".";

                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Work Order updated Successfully!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Work order updated Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Work order not updated Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            }
        }
    }

    public function view_admin_employees_work_order() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);

        // echo "<pre>";
        // print_r($data['get_work_order']);

        $this->load->view('admin/view_admin_employees_work_order', $data);
    }

    public function view_admin_employees_work_order_pdf() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        $get_vendor_details = $this->employee_model->getVendorDtls($get_employee_details[0]['vendor_id']);

        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->view('admin/view_employees_work_order_pdf', $data);

        /* $this->load->library('html2pdf');

          $directory_name = './uploads/work_order_pdf/' . date("Y-m-d") . "/" . $get_vendor_details[0]['first_name'] . '/' . $get_employee_details[0]['employee_code'] . '/';

          $file_name = time() . rand(00, 99) . ".pdf";

          if (!file_exists($directory_name)) {
          mkdir($directory_name, 0777, true);
          }
          $this->html2pdf->folder($directory_name);
          $this->html2pdf->filename($file_name);
          $this->html2pdf->paper('a4', 'portrait');

          $this->html2pdf->html($this->load->view('admin/view_employees_work_order_pdf', $data, true));
          if ($this->html2pdf->create('view_only')) {
          redirect(base_url() . 'admin_employee_lists');
          } */
    }

    public function admin_employee_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        // $vendor_str = "";
        // if ($admin_id != '10') {
        // $get_vendor_dtls_arr = $this->employee_model->getVendorLists($admin_id);
        // } else {
        //     $get_vendor_dtls_arr = $this->employee_model->getAllVendor();
        // }

        // //        echo "<pre>";
        // //        print_r($get_vendor_dtls);
        // foreach ($get_vendor_dtls_arr as $v_val) {
        //     $vendor_str .= $v_val['vendor_id'] . ",";
        // }
        // $vendor_ids = rtrim($vendor_str, ",");

        // $sa_emp_str = 0;
        // $emp_str = 0;
        // $get_emp_arr = $this->employee_model->getEmpIDs($admin_id);
        // if (!empty($get_emp_arr)) {
        //     foreach ($get_emp_arr as $empval) {
        //         $sa_emp_str .= $empval['employee_id'] . ",";
        //     }
        // }
        // $emp_str = rtrim($sa_emp_str, ",");

		// $ten99_str = 0;
		// $sa_ten99_str = 0;
		// $get_ten99_arr = $this->ten99user_model->getTen99UserIDs($admin_id);
		// if(!empty($get_ten99_arr)){
		// 	foreach($get_ten99_arr as $ten99val){
		// 		$sa_ten99_str .= $ten99val['employee_id'] . ",";
		// 	}
		// }
		// $ten99_str = rtrim($sa_ten99_str, ",");
		$data['get_ten99_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee("ten99");

        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants();
        // print_r($data['get_invoice_details']);
        // exit;
        //$vendor_ids, $emp_str

        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants();
        // $vendor_ids, $emp_str
        $data['get_not_apprv_admin_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants();
        //$vendor_ids, $emp_str
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee("emp");
        $data['admin_id'] = $admin_id;

        $data['page'] = "invoice";
        $data['meta_title'] = "INVOICE";

        //        $this->load->view('admin/admin_employee_invoice', $data);
        $this->load->view('admin/admin_employee_invoice_new', $data);
    }
      public function admin_consultant_invoice_summary() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $vendor_str = "";
        if ($admin_id != '10') {
        $get_vendor_dtls_arr = $this->employee_model->getVendorLists($admin_id);
        } else {
            $get_vendor_dtls_arr = $this->employee_model->getAllVendor();
        }

        //        echo "<pre>";
        //        print_r($get_vendor_dtls);
        foreach ($get_vendor_dtls_arr as $v_val) {
            $vendor_str .= $v_val['vendor_id'] . ",";
        }
        $vendor_ids = rtrim($vendor_str, ",");

        $sa_emp_str = 0;
        $emp_str = 0;
        $get_emp_arr = $this->employee_model->getEmpIDs($admin_id);
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($vendor_ids, $emp_str);

        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_not_apprv_admin_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);
        $data['admin_id'] = $admin_id;

        $data['page'] = "invoice";
        $data['meta_title'] = "INVOICE";

        //        $this->load->view('admin/admin_employee_invoice', $data);
        $this->load->view('admin/admin_consultant_invoice_summary', $data);
    }

    public function admin_vendor_invoice_summary() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $vendor_str = "";
        if ($admin_id != '10') {
        $get_vendor_dtls_arr = $this->employee_model->getVendorLists($admin_id);
        } else {
            $get_vendor_dtls_arr = $this->employee_model->getAllVendor();
        }

        //        echo "<pre>";
        //        print_r($get_vendor_dtls);
        foreach ($get_vendor_dtls_arr as $v_val) {
            $vendor_str .= $v_val['vendor_id'] . ",";
        }
        $vendor_ids = rtrim($vendor_str, ",");

        $sa_emp_str = 0;
        $emp_str = 0;
        $get_emp_arr = $this->employee_model->getEmpIDs($admin_id);
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($vendor_ids, $emp_str);

        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_not_apprv_admin_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);
        $data['admin_id'] = $admin_id;

        $data['page'] = "invoice";
        $data['meta_title'] = "INVOICE";

        //        $this->load->view('admin/admin_employee_invoice', $data);
        $this->load->view('admin/admin_vendor_invoice_summary', $data);
    }

    public function admin_employee_invoice_summary() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
       //echo'<pre>';print_r($get_details);exit;
         $admin_ids = $data['get_details'][0]['admin_id'];

        $vendor_str = "";
        if ($admin_id != '10') {
        $get_vendor_dtls_arr = $this->employee_model->getVendorLists($admin_id);
        } else {
            $get_vendor_dtls_arr = $this->employee_model->getAllVendor();
        }

        //        echo "<pre>";
        //        print_r($get_vendor_dtls);
        foreach ($get_vendor_dtls_arr as $v_val) {
            $vendor_str .= $v_val['vendor_id'] . ",";
        }
        $vendor_ids = rtrim($vendor_str, ",");

        $sa_emp_str = 0;
        $emp_str = 0;
         $get_emp_arr = $this->employee_model->getEmpIDs($admin_id);
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($vendor_ids, $emp_str);

        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_not_apprv_admin_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($vendor_ids, $emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);

        $data['admin_id'] = $admin_id;

        $data['page'] = "invoice";
        $data['meta_title'] = "INVOICE";

        //        $this->load->view('admin/admin_employee_invoice', $data);
        $this->load->view('admin/admin_employee_invoice_summary', $data);
    }

    public function edit_admin_employee_invoice_summary()
    {

         if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $sa_emp_str = 0;
        $emp_str = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);

       $get_emp_arr = $this->employee_model->getEmpIDs($admin_id);
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
         $emp_str = rtrim($sa_emp_str, ",");
         $invoice_code = base64_decode($this->uri->segment(2));

         $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyInvoiceCode($invoice_code);
         $data['page'] = "edit_admin_employee_invoice_summary";
         $data['meta_title'] = "EDIT EMPLOYEE INVOICE";
         $this->load->view('admin/edit_admin_employee_invoice_summary', $data);
    }

    public function update_admin_employee_invoice_summary()
    {
            $db = get_instance()->db->conn_id;
         if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
         $sess_arr = $this->session->userdata('logged_in');
         $email = $sess_arr['email'];
         $data['get_details'] = $this->profile_model->getDetails($email);
         $invoice_code = base64_decode($this->input->post('invoice_code'));

         $payment_receipt_no = $this->input->post('receipt_number');
         $status = $this->input->post('payment_status');
         $payment_date = $this->input->post('payment_date');

          $update_arr = array(
                'payment_receipt_number' => $payment_receipt_no,
                'payment_status' => $status,
                'payment_date' => $payment_date,

            );


            $update_query = $this->employee_model->update_admin_employee_invoice_summary($update_arr, $invoice_code);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Employee Invoice updated Successfully..');
                redirect(base_url() . 'admin_employee_invoice_summary');
            } else {
                $this->session->set_flashdata('succ_msg', 'Employee Invoice updated Successfully..');
                redirect(base_url() . 'admin_employee_invoice_summary');
            }


    }



    public function delete_consultant_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->input->post('invoice_id', TRUE));

        $del_query = $this->employee_model->deleteInvoicePermanently($invoice_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_vendor_invoice() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->input->post('invoice_id', TRUE));

        $del_query = $this->employee_model->deleteVendorInvoicePermanently($invoice_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function approve_invoice() {

        $recipients = array();

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $invoice_id = $this->input->post('invoice_id', TRUE);

        $get_invoice_details = $this->employee_model->checkInvoiceStatus($invoice_id);
        $get_employee_details = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);
        $get_vendor_details = $this->employee_model->getVendorDtls($get_invoice_details[0]['vendor_id']);
        $get_sadmin_details = $this->employee_model->getSuperAdminData($data['get_details'][0]['admin_id']);
        $sa_id = $get_sadmin_details[0]['sa_id'];
        $sa_email = $get_sadmin_details[0]['sa_email'];

        $update_arr = array(
            "status" => "1",
            "updated_date" => date("Y-m-d h:i:s")
        );
        $update_query = $this->employee_model->approveInvoice($update_arr, $invoice_id);

        if ($update_query > '0') {

            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;
            $to_email = $get_vendor_details[0]['vendor_email'];
            $admin_email = $data['get_details'][0]['admin_email'];
            $data['msg'] = "Invoice Approved Successfully";
            //Load email library
            $this->load->library('email');

            $this->email->from($from_email);
            $this->email->to($to_email);
            $this->email->bcc($sa_email);
            $this->email->bcc($superadmin_email);
            $this->email->subject('Invoice Approved Successfully');
            $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

            $this->email->set_mailtype('html');
            //Send mail
            $this->email->send();

            /* ----------------------------------Insert Mail------------------------------------ */


            $msg = ucwords($data['get_details'][0]['name_prefix'] . " " . $data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name']) . " has been approved invoice successfully.<br> "
                    . "<label><strong>Invoice Code : </strong>" . $get_invoice_details[0]['invoice_code'] . "</label><br/>" . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
            $recipients [] = 1 . "_" . "superadmin";
            $recipients [] = $sa_id . "_" . "superadmin";
            $recipients [] = $get_vendor_details[0]['vendor_id'] . "_" . "vendor";

            foreach ($recipients as $rtval) {
                $r_arr = explode("_", $rtval);
                $recipient_id = $r_arr[0];
                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => "Invoice Approved Successfully",
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

            echo "1";
        } else {
            echo "0";
        }
    }

    public function invoice_pdf() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $assign_projects = "";

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkInvoiceStatus($invoice_id);
        //echo $get_invoice_details[0]['employee_id'];
        if ($get_invoice_details[0]['vendor_id'] != '0') {
            $get_vendor_details = $this->employee_model->getVendorDtls($get_invoice_details[0]['vendor_id']);
            $data['get_vendor_details'] = $get_vendor_details;
            $get_assign_project_details = $this->employee_model->getAssignProjectDtls($get_invoice_details[0]['employee_id'], $get_invoice_details[0]['vendor_id']);
        } else {
            $get_assign_project_details = $this->employee_model->getAssignProjectDtlsbyEmp($get_invoice_details[0]['employee_id']);
        }

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

        $data['img_src'] = "../assets/images/pts.jpg";
        $data['dimension'] = "../assets/images/dimension.png";

        $data['get_invoice_details'] = $get_invoice_details;
        $data['get_work_order_details'] = $get_work_order_details;
        $get_employee_details = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);
        $data['get_employee_details'] = $get_employee_details;

        $this->load->library('html2pdf');

        $directory_name = './uploads/invoice_pdf/' . $get_employee_details[0]['first_name'] . "_" . $get_employee_details[0]['last_name'] . '/' . date("Y-m-d") . "/";

        $file_name = $get_invoice_details[0]['invoice_code'] . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        echo $this->load->view('admin/invoice_pdf', $data, true);
        exit();

        //        $this->html2pdf->html($this->load->view('admin/invoice_pdf', $data, true));
        //        if ($this->html2pdf->create('view_only')) {
        //            redirect(base_url() . 'admin_consultant_invoice');
        //        }
    }

    public function admin_invoice_pdf() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $assign_projects = "";

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkAdminInvoiceStatus($invoice_id);
        //echo $get_invoice_details[0]['employee_id'];
        if ($get_invoice_details[0]['vendor_id'] != '0') {
            $get_vendor_details = $this->employee_model->getVendorDtls($get_invoice_details[0]['vendor_id']);
            $data['get_vendor_details'] = $get_vendor_details;
            $get_assign_project_details = $this->employee_model->getAssignProjectDtls($get_invoice_details[0]['employee_id'], $get_invoice_details[0]['vendor_id']);
        } else {
            $get_assign_project_details = $this->employee_model->getAssignProjectDtlsbyEmp($get_invoice_details[0]['employee_id']);
        }

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

        $data['img_src'] = "../assets/images/pts.jpg";
        $data['dimension'] = "../assets/images/dimension.png";

        $data['get_invoice_details'] = $get_invoice_details;
        $data['get_work_order_details'] = $get_work_order_details;
        $get_employee_details = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);
        $data['get_employee_details'] = $get_employee_details;

        $this->load->library('html2pdf');

        $directory_name = './uploads/invoice_pdf/' . $get_employee_details[0]['first_name'] . "_" . $get_employee_details[0]['last_name'] . '/' . date("Y-m-d") . "/";

        $file_name = $get_invoice_details[0]['invoice_code'] . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        echo $this->load->view('admin/invoice_pdf', $data, true);
        exit();

        //        $this->html2pdf->html($this->load->view('admin/invoice_pdf', $data, true));
        //        if ($this->html2pdf->create('view_only')) {
        //            redirect(base_url() . 'admin_consultant_invoice');
        //        }
    }

    public function admin_project_lists() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $vendor_str = "";
        $data['get_vendor_dtls'] = $this->employee_model->getVendorLists($admin_id);
        $data['get_project_dtls'] = $this->employee_model->getProjectLists();

        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT LISTS";

        $this->load->view('admin/project_lists', $data);
    }

    public function add_admin_projects() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $vendor_str = "";
        $data['get_vendor_dtls'] = $this->employee_model->getVendorLists($admin_id);
        $data['get_project_type'] = $this->employee_model->getProjectType();
        $data['admin_id'] = $admin_id;
        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT ADD";

        $this->load->view('admin/add_project', $data);
    }

    public function insert_projects() {
        $db = get_instance()->db->conn_id;
        $recipients = array();

        $employee_type = $this->input->post('employee_type');
        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');
        $project_type = $this->input->post('project_type');
        $project_name = $this->input->post('project_name');
        $project_details = mysqli_real_escape_string($db, $this->input->post('project_details'));
        $client_name = $this->input->post('client_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $approx_total_time = $this->input->post('approx_total_time');
        $monthly_payment = $this->input->post('monthly_payment');

        if (isset($project_type) && $project_type == '') {
            $this->session->set_flashdata('error_msg', 'Project Type field cannot be blank');
            redirect(base_url() . 'add_admin_projects');
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add_admin_projects');
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url() . 'add_admin_projects');
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url() . 'add_admin_projects');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add_admin_projects');
        } else {

            $get_last_id = $this->employee_model->getLastID();
            if (!empty($get_last_id)) {
                $project_code = "REC00" . ($get_last_id[0]['id'] + 1);
            } else {
                $project_code = "REC001";
            }


            if ($employee_type == 'C') {
                $vendor_email = array();
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";
                foreach ($vendor_id as $vvalue) {
                    $get_vendor_details = $this->employee_model->getVendorDtls($vvalue);
                    if (!empty($get_vendor_details)) {
                        $admin_id = $get_vendor_details[0]['admin_id'];
                        $vendor_email [] = $get_vendor_details[0]['vendor_email'];
                        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

                        $admin_email = $get_admin_details[0]['admin_email'];
                        $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                        $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];

                        $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($vendor_name) . " successfully";


                        $recipients [] = $vvalue . "_" . "vendor";

                        $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
                        $sa_id = $get_sadmin_details[0]['sa_id'];
                        $sa_email = $get_sadmin_details[0]['sa_email'];
                    }
                }
            } else if ($employee_type == 'E') {
                $vendor_id = 0;
                $admin_id = $admin_id;
                $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($admin_name) . " successfully";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";

                $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
                $sa_id = $get_sadmin_details[0]['sa_id'];
                $sa_email = $get_sadmin_details[0]['sa_email'];
            }

            $insert_arr = array(
                'admin_id' => $admin_id,
                'vendor_id' => implode(",", $vendor_id),
                'project_code' => $project_code,
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
            //echo "<pre>";
            //            print_r($insert_arr);
            //            die;
            $insert_query = $this->employee_model->add_projects($insert_arr);
                //            $insert_query = '1';
                //            if ($insert_query == '1') {
            if ($insert_query != '') {

                $project_code = $project_code;
                $project_type = $project_type;
                $project_name = $project_name;
                $project_details = $project_details;
                $client_name = $client_name;
                $start_date = $start_date;
                $end_date = $end_date;

                if ($end_date != '0000-00-00') {
                    $end_date = date("d-m-Y", strtotime($end_date));
                } else {
                    $end_date = "";
                }

                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                                                <p style='font-weight: 300;'>New project " . ucwords($project_name) . " is assigned to you. Requirements details of the project are as follows :  </p>
                                                <p><strong>Req Code : </strong>" . strtoupper($project_code) . "</p>
                                                <p><strong>Project Type : </strong>" . ucwords($project_type) . "</p>
                                                <p><strong>Project Name : </strong>" . ucwords($project_name) . "</p>
                                                <p><strong>Project Details : </strong>" . stripslashes($project_details) . "</p>
                                                <p><strong>Client Name : </strong>" . ucwords($client_name) . "</p>
                                                <p><strong>Start Date : </strong>" . date("d-m-Y", strtotime($start_date)) . "</p>
                                                <p><strong>End Date : </strong>" . $end_date . "</p>";



                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    foreach ($vendor_email as $vmail) {
                        $this->email->to($vmail);
                    }
                } elseif ($employee_type == 'E') {
                    $this->email->to($sa_email);
                }
                $this->email->bcc($superadmin_email);
                $this->email->subject('Project Added Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "New project is assigned to you.<br> "
                        . "<label><strong>Project Type : </strong>" . ucwords($project_type) . "</label><br/>"
                        . "<label><strong>Project Name : </strong>" . ucwords($project_name) . "</label><br/>";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Project Added Successfully",
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

                $this->session->set_flashdata('succ_msg', 'Project added Successfully..');
                redirect(base_url() . 'admin_project_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Project not added Successfully..');
                redirect(base_url() . 'admin_project_lists');
            }
        }
    }

    public function edit_admin_projects() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $project_id = base64_decode($this->uri->segment(2));
        $data['get_project_dtls'] = $this->employee_model->getProjectData($project_id);
        $data['get_vendor_dtls'] = $this->employee_model->getVendorLists($admin_id);
        $data['get_project_type'] = $this->employee_model->getProjectType();

        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT EDIT";

        $this->load->view('admin/edit_project', $data);
    }

    public function update_admin_projects() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_id');
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
            $this->session->set_flashdata('error_msg', 'Project Type field cannot be blank');
            redirect(base_url() . 'edit_admin_projects/' . base64_encode($project_id));
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'edit_admin_projects/' . base64_encode($project_id));
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url() . 'edit_admin_projects/' . base64_encode($project_id));
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url() . 'edit_admin_projects/' . base64_encode($project_id));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'edit_admin_projects/' . base64_encode($project_id));
        } else {

            $update_arr = array(
                'vendor_id' => implode(",", $vendor_id),
                'project_type' => $project_type,
                'project_name' => $project_name,
                'project_details' => $project_details,
                'client_name' => $client_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'approx_total_time' => $approx_total_time,
                'monthly_payment' => $monthly_payment,
                'updated_date' => date("Y-m-d h:i:s")
            );

            $update_query = $this->employee_model->update_projects($update_arr, $project_id);

            if ($update_query > '0') {

                $this->session->set_flashdata('succ_msg', 'Project updated Successfully..');
                redirect(base_url() . 'admin_project_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Project not updated Successfully..');
                redirect(base_url() . 'admin_project_lists');
            }
        }
    }

    public function approve_disapprove_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $recipients = array();
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);

        $get_project_details = $this->employee_model->getProjectData($project_id);
        $get_vendor_details = $this->employee_model->getVendorDtls($get_project_details[0]['vendor_id']);
        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        $sadmin_id = $get_admin_details[0]['sa_id'];
        $get_superadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);

        $employee_type = $get_employee_details[0]['employee_type'];
        $employee_email = $get_employee_details[0]['employee_email'];

        if ($ad == 'Approved') {
            $approved_by_admin = '1';
        } else if ($ad == 'Disapproved') {
            $approved_by_admin = '0';
        }

        if (!empty($check)) {

            $update_arr = array(
                "approved_by_admin" => $approved_by_admin,
            );

            foreach ($check as $tid) {
                $change_status = $this->employee_model->changeTimesheetStatus($update_arr, $tid);
            }

            if ($change_status > 0) {

                if ($approved_by_admin == '0') {
                    $data['msg'] = "Your consultant timesheet has been disapproved for this month.";
                } else if ($approved_by_admin == '1') {
                    $data['msg'] = "Your consultant timesheet has been approved for this month.";
                }

                $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $vendor_id = $get_vendor_details[0]['vendor_id'];

                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $sa_admin_email = $get_superadmin_details[0]['sa_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $email;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($vendor_email);
                    $this->email->bcc($sa_admin_email);
                    $this->email->bcc($employee_email);
                    $this->email->bcc($superadmin_email);
                } else {
                    $this->email->to($employee_email);
                    $this->email->bcc($sa_admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Timesheet Status Changed Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been changed consultant timesheet status successfully.<br> "
                            . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $recipients [] = $employee_id . "_" . "consultant";
                } else {
                    $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been changed employee timesheet status successfully.<br> "
                            . "<label><strong>Vendor Name : </strong>" . $vendor_name . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $employee_id . "_" . "employee";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Timesheet Status Changed Successfully",
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

                $this->session->set_flashdata('succ_msg', 'Timesheet Status Changed Successfully');
                redirect(base_url() . 'view_admin_project_timesheet/' . base64_encode($project_id) . '/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('succ_msg', 'Timesheet Status Changed Successfully');
                redirect(base_url() . 'view_admin_project_timesheet/' . base64_encode($project_id) . '/' . base64_encode($employee_id));
            }
        }
                //        echo "<pre>";
                //        print_r($check);
                //        die;
    }

    public function admin_approve_disapprove_timesheet_period() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $recipients = array();
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $timesheet_period_id = $this->input->post('timesheet_period_id', TRUE);
        $admin_comment = $this->input->post('admin_comment', TRUE);

        if ($ad == 'Approved') {
            $approved_by_status = '1';
        } else if ($ad == 'Disapproved') {
            $approved_by_status = '0';
        }

        if (!empty($check)) {
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
                    $change_status_sv = $this->employee_model->changeEachTimesheetStatus($update_arr, $time_id);
                }
                // if ($change_status_sv > 0) {
                $this->session->set_flashdata('succ_msg', 'Total Time Has Been Saved !');
                redirect(base_url() . 'admin-view-period-timesheet/' . base64_encode($timesheet_period_id));
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

                if ($change_status > 0) {
                    $pstatus = array();

                    $get_period_details = $this->employee_model->getTimesheetPeriodDetails($timesheet_period_id);
                    foreach ($get_period_details as $pval) {
                        $pstatus[] = $pval['approved_by_status'];
                    }
                    if (in_array("0", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "0",
                            "approved_by_id" => $admin_id,
                            "approved_by" => "admin",
                            "admin_comment" => $admin_comment
                        );
                    } elseif (in_array("1", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "1",
                            "approved_by_id" => $admin_id,
                            "approved_by" => "admin",
                            "admin_comment" => $admin_comment
                        );
                    } elseif (in_array("2", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "2",
                            "approved_by_id" => $admin_id,
                            "approved_by" => "admin",
                            "admin_comment" => $admin_comment
                        );
                    }

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

                            $invoice_end_date = date("Y-m-d", strtotime($end_date));

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
                                }
                            }

                            $approved_by_id = $admin_id;
                            $approved_by = "admin";

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
                                "invoice_end_date" => $invoice_end_date,
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
                                redirect(base_url() . 'admin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                            } else {
                                if (US || INDIA) {
                                    $insert_period_query = $this->employee_model->generateTimesheetInvoice($insert_payment_arr);
                                }
                                if (LATAM) {
                                    if (GENERATE_INVOICE_AUTO) {
                                    $insert_period_query = $this->employee_model->generateTimesheetInvoice($insert_payment_arr);
                                    }
                                }
                            }
                        } else if ($get_timesheet_period_details[0]['status'] == '0') {
                            $update_i_arr = array(
                                "status" => "2"
                            );
                            $update_invoice_query = $this->employee_model->DeleteInvoice($update_i_arr, $timesheet_period_id);
                        }
                    }

                    /* ----------------------------------Insert Mail------------------------------------ */


                    $this->session->set_flashdata('succ_msg', 'Timesheet Status Changed Successfully');
                    redirect(base_url() . 'admin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong. !');
                    redirect(base_url() . 'admin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                }
            }
        }
                    //        echo "<pre>";
                    //        print_r($check);
                    //        die;
    }

    public function view_consultant_details() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_id = $data['get_details'][0]['admin_id'];

        $project_id = base64_decode($this->uri->segment(2));

        $data['get_employee_details'] = $this->employee_model->getAssignedEmpoyees($project_id);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);

        $data['project_id'] = $project_id;

        $data['page'] = "project_lists";
        $data['meta_title'] = "CONSULTANT LISTS PROJECT WISE";

        $this->load->view('admin/view_assigned_employees', $data);
    }

    public function admin_approve_disapprove_consultant() {

        $recipients = array();

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);

        $get_project_details = $this->employee_model->getProjectData($project_id);
        $get_vendor_details = $this->employee_model->getVendorDtls($get_project_details[0]['vendor_id']);
        $get_admin_details = $this->employee_model->getAdminDetails($get_vendor_details[0]['admin_id']);
        $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);

        $admin_email = $get_admin_details[0]['admin_email'];
        $admin_id = $get_admin_details[0]['admin_id'];
        $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
        $sa_email = $get_sadmin_details[0]['sa_email'];
        $sa_id = $get_sadmin_details[0]['sa_id'];

        if ($ad == 'Remove From Project') {

            if (!empty($check)) {

                $update_arr = array(
                    "is_assigned" => "1",
                    "updated_date" => date("Y-m-d h:i:s")
                );
            }

            foreach ($check as $employee_id) {
                    $change_status = $this->employee_model->remove_emp_from_project($update_arr, $project_id, $employee_id);
            }

            if ($change_status == 0) {

                $this->session->set_flashdata('succ_msg', 'Admin Changed Onboarding Status Successfully');
                    redirect(base_url() . 'view_consultant_details/' . base64_encode($project_id));

            } else if ($change_status == 1) {

                 $this->session->set_flashdata('succ_msg', 'Employee removed from project successfully');
                    redirect(base_url() . 'view_consultant_details/' . base64_encode($project_id));
            }

        } else {

            if ($ad == 'Approved') {
                $status = '1';
            } else if ($ad == 'Disapproved') {
                $status = '0';
            }

            if (!empty($check)) {

                $update_arr = array(
                    "status" => $status,
                    "updated_date" => date("Y-m-d h:i:s")
                );

                foreach ($check as $employee_id) {
                    $change_status = $this->employee_model->changeConsultantStatus($update_arr, $project_id, $employee_id);
                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                }

                if ($change_status > 0) {

                    if ($status == '0') {
                        $data['msg'] = "Your consultant has not approved for the project(" . $get_project_details[0]['project_code'] . " - " . $get_project_details[0]['project_name'] . ").";
                    } else if ($status == '1') {
                        $data['msg'] = "Your consultant has approved for the project(" . $get_project_details[0]['project_code'] . " - " . $get_project_details[0]['project_name'] . ").";
                    }

                    $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                    $vendor_email = $get_vendor_details[0]['vendor_email'];

                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;
                    $admin_email = $email;

                    //Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($vendor_email);
                    $this->email->bcc($sa_email);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Admin Changed Onboarding Status Successfully');
                    $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                    $this->email->set_mailtype('html');
                    $this->email->send();

                    /* ----------------------------------Insert Mail------------------------------------ */

                    if ($status == '0') {
                        $msg = ucwords($admin_name) . " has been deactivated onboarding status successfully.<br> "
                                . "<label><strong>Project Code : </strong>" . $get_project_details[0]['project_code'] . "</label><br/>" . "<label><strong>Project Name : </strong>" . $get_project_details[0]['project_name'] . "</label><br/>"
                                . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
                    } else if ($status == '1') {
                        $msg = ucwords($admin_name) . " has been activated onboarding status successfully.<br> "
                                . "<label><strong>Project Code : </strong>" . $get_project_details[0]['project_code'] . "</label><br/>" . "<label><strong>Project Name : </strong>" . $get_project_details[0]['project_name'] . "</label><br/>"
                                . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
                    }
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $sa_id . "_" . "superadmin";
                    $recipients [] = $get_vendor_details[0]['vendor_id'] . "_" . "vendor";

                    foreach ($recipients as $rtval) {
                        $r_arr = explode("_", $rtval);
                        $recipient_id = $r_arr[0];
                        $recipient_type = $r_arr[1];

                        $insert_arr = array(
                            "recipient_id" => $recipient_id,
                            "recipient_type" => $recipient_type,
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "Admin Changed Onboarding Status Successfully",
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

                    $this->session->set_flashdata('succ_msg', 'Admin Changed Onboarding Status Successfully');
                    redirect(base_url() . 'view_consultant_details/' . base64_encode($project_id));
                } else {
                    $this->session->set_flashdata('succ_msg', 'Admin Changed Onboarding Status Successfully');
                    redirect(base_url() . 'view_consultant_details/' . base64_encode($project_id));
                }
            }
                //        echo "<pre>";
                //        print_r($check);
                //        die;
        }
    }

    public function view_consultant_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

		$client_id = 0;
        $is_uhg = 0;
		$is_jci = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        if (LATAM) { 
            $is_temp_emp = $data['get_employee_details'][0]['is_temp_emp']; 
        }
            if (!empty($data['get_employee_details'])) {
                $employee_type = $data['get_employee_details'][0]['employee_type'];
            }

		$emp_enrollment_type = $data['get_employee_details'][0]['emp_pay_rate_type'];

        if ($employee_type == 'C') {
            $data['emp_type'] = "Consultant";
            $get_work_order_status = $this->employee_model->checkWorkOrderStatus($employee_id);
            if (!empty($get_work_order_status)) {
                $client_id = $get_work_order_status[0]['client_name'];
				$data['get_client_details'] = $this->profile_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
            } else {

                $client_id = 0;
            }
        } else {
            $data['emp_type'] = "Employee";
			//code to retrieve client name from client id
				$client_id = $data['get_employee_details'][0]['client_id'];
				$data['get_client_details'] = $this->profile_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];

            //            echo $client_name;
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


        if (LATAM) {
            if ($is_temp_emp) {
                $data['get_documents_details'] = $this->employee_model->get_temporary_employee_documents();
                // echo "<pre>";
                // print_r($data['get_documents_details']);
                // exit;
            } else {
                $data['get_documents_details'] = $this->employee_model->get_employee_documents_by_emp_type($employee_type);
            }
        }
        if (US || INDIA) {
        $data['get_documents_details'] = $this->employee_model->getAllFilesByClient($employee_type, $is_uhg, $is_jci, $emp_enrollment_type);
        }

        $data['get_admin_approve_status'] = $this->employee_model->get_ucsis_admin_approve_status($employee_id);
        $data['get_emp_uscis_files'] = $this->employee_model->getUscisFiles($employee_id);
        $data['get_work_order_status'] = $this->employee_model->checkWorkOrderStatus($employee_id);
        $data['get_vms_emp_id_list_a'] = $this->employee_model->getvmsEmpIdListA();
        $data['get_vms_emp_id_list_b'] = $this->employee_model->getvmsEmpIdListB();
        $data['get_vms_emp_id_list_c'] = $this->employee_model->getvmsEmpIdListC();

        if ($employee_type == 'C') {
            $data['page'] = "employee_lists";
            $data['meta_title'] = "CONSULTANT DOCUMENTS";
        } else {
            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE DOCUMENTS";
        }

        $this->load->view('admin/employees_documents', $data);
    }

    public function approve_disapprove_ucsic_docs() {

        $recipients = array();
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_approval = $this->input->post('admin_approval', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);

        $list_a_name = $this->input->post('list_a_name');
        $list_b_name = $this->input->post('list_b_name');
        $list_c_name = $this->input->post('list_c_name');

        $list_a_doc_name = $this->input->post('list_a_doc_name');
        $list_b_doc_name = $this->input->post('list_b_doc_name');
        $list_c_doc_name = $this->input->post('list_c_doc_name');

        if ($admin_approval != '') {
            $admin_approval = $admin_approval;
        } else {
            $admin_approval = "2";
        }

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        if (!empty($get_employee_details)) {

            $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_type = $get_employee_details[0]['employee_type'];
            $employee_email = $get_employee_details[0]['employee_email'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
            $get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $vendor_id = $get_vendor_details[0]['vendor_id'];

            if (!empty($get_admin_details)) {
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                if (!empty($get_sadmin_details)) {
                    $sadmin_email = $get_sadmin_details[0]['sa_email'];
                }
            }
        }

        $check_uscis_document = $this->employee_model->getUscisFiles($employee_id);

        if (!empty($check_uscis_document)) {

            $list_a_docs = explode(",", $check_uscis_document[0]['list_a_docs']);
            $list_b_docs = explode(",", $check_uscis_document[0]['list_b_docs']);
            $list_c_docs = explode(",", $check_uscis_document[0]['list_c_docs']);

            if (!empty($list_a_docs)) {
                foreach ($list_a_docs as $adocs) {
                    $path = "./uploads/lista_pdf/" . $adocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            if (!empty($list_b_docs)) {
                foreach ($list_b_docs as $bdocs) {
                    $path = "./uploads/listb_pdf/" . $bdocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            if (!empty($list_c_docs)) {
                foreach ($list_c_docs as $cdocs) {
                    $path = "./uploads/listc_pdf/" . $cdocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            $delete_prev_docs = $this->employee_model->deletePrevUscDocs($employee_id);
        }

        if ($list_a_name != '') {

            $a = 0;
            $docs_name = "";
            foreach ($_FILES['list_a_doc_name']['name'] as $list_a_val) {

                if ($list_a_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_a_doc_name']['name'][$a];
                    $file_size = $_FILES['list_a_doc_name']['size'][$a];
                    $file_tmp = $_FILES['list_a_doc_name']['tmp_name'][$a];
                    $file_type = $_FILES['list_a_doc_name']['type'][$a];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
                    //print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");

                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
                    //echo "<pre>";
                    //print_r($file_errors);
                    //die;
                    if (empty($file_errors)) {
                        $docs_name .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/lista_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $a++;
            }

            $insert_arr = array(
                'employee_id' => $employee_id,
                'list_a_docs_id' => $list_a_name,
                'list_a_docs' => rtrim($docs_name, ","),
                'admin_status' => $admin_approval,
                'entry_date' => date("Y-m-d h:i:s")
            );
        } elseif ($list_b_name != '' && $list_c_name != '') {
                //            echo"vgy";
                //            die;

            $c = 0;
            $b = 0;
            $docs_name_listb = "";
            $docs_name_listc = "";

            foreach ($_FILES['list_b_doc_name']['name'] as $list_b_val) {

                if ($list_b_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_b_doc_name']['name'][$c];
                    $file_size = $_FILES['list_b_doc_name']['size'][$c];
                    $file_tmp = $_FILES['list_b_doc_name']['tmp_name'][$c];
                    $file_type = $_FILES['list_b_doc_name']['type'][$c];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
                    //print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");

                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
                    ////echo "<pre>";
                    //print_r($file_errors);
                    //die;
                    if (empty($file_errors)) {
                        $docs_name_listb .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/listb_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $c++;
            }

            foreach ($_FILES['list_c_doc_name']['name'] as $list_c_val) {

                if ($list_c_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_c_doc_name']['name'][$b];
                    $file_size = $_FILES['list_c_doc_name']['size'][$b];
                    $file_tmp = $_FILES['list_c_doc_name']['tmp_name'][$b];
                    $file_type = $_FILES['list_c_doc_name']['type'][$b];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
                    //print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
                    ////echo "<pre>";
                    ////print_r($file_errors);
                    //die;
                    if (empty($file_errors)) {
                        $docs_name_listc .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/listc_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $b++;
            }
            $insert_arr = array(
                'employee_id' => $employee_id,
                'list_b_docs_id' => $list_b_name,
                'list_b_docs' => rtrim($docs_name_listb, ","),
                'list_c_docs_id' => $list_c_name,
                'list_c_docs' => rtrim($docs_name_listc, ","),
                'admin_status' => $admin_approval,
                'entry_date' => date("Y-m-d h:i:s")
            );
        }

        $insert_query = $this->employee_model->add_consultants_uscis_documents($insert_arr);

        if ($insert_query != '') {

            if (INDIA) {
                $this->session->set_flashdata('succ_msg', 'Employee USCIS Document Uploaded Successfully');
            }
            if (US || LATAM) {
                $this->session->set_flashdata('succ_msg', 'Consultant USCIS Document Uploaded Successfully');
            }
                redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
        } else {
            if (INDIA) {
                $this->session->set_flashdata('error_msg', 'Employee USCIS Document Not Uploaded Successfully');
            }
            if (US || LATAM) {
                $this->session->set_flashdata('error_msg', 'Consultant USCIS Document Not Uploaded Successfully');
            }
            redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
        }
    }

    public function ajax_change_uscis_status() {

        $uscis_id = $this->input->post('uscis_id', TRUE);
        $admin_approval = $this->input->post('admin_approval', TRUE);

        $update_arr = array(
            'admin_status' => $admin_approval,
            'updated_date' => date("Y-m-d")
        );
        $change_status = $this->employee_model->change_ucsis_status($update_arr, $uscis_id);
        if ($change_status > 0) {
            echo 1;
        } else {
            echo 0;
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
            redirect(base_url() . 'admin_consultant_invoice');
        } else {

            $get_invoice_details = $this->employee_model->checkInvoiceStatus($invoice_id);
            $get_vendor_details = $this->vendor_model->getVendorEmail($recipient_id);
            $get_admin_details = $this->vendor_model->getAdminEmail($sender_id);
            $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
            $sa_id = $get_sadmin_details[0]['sa_id'];
            $sa_email = $get_sadmin_details[0]['sa_email'];
            $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];

            $insert_arr = array(
                'invoice_id' => $invoice_id,
                'recipient_id' => $recipient_id,
                'reply_id' => $reply_id,
                'recipient_type' => $recipient_type,
                'sender_id' => $sender_id,
                'sender_type' => $sender_type,
                'subject' => $subject,
                'message' => $message,
                'entry_date' => date("Y-m-d h:i:s")
            );
            //echo "<pre>";
            //            print_r($insert_arr);
            //            die;
            $insert_query = $this->employee_model->add_payment_mail($insert_arr);

            if ($insert_query != '') {

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $data['msg'] = "Admin has been commented against " . $get_invoice_details[0]['invoice_code'] . "<br> " . "<label><strong>Admin Name : </strong>" . ucwords($admin_name) . "<br> <label><strong> comments : </strong>" . " " . stripslashes($message) . "<br> <label><strong> Vendor Name : </strong>" . " " . ucwords($get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']);


                //                $msg = ucwords($admin_name) . " has been deactivated onboarding status successfully.<br> "
                //                    . "<label><strong>Project Code : </strong>" . $get_project_details[0]['project_code'] . "</label><br/>" . "<label><strong>Project Name : </strong>" . $get_project_details[0]['project_name'] . "</label><br/>"
                //                    . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['employee_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($vendor_email);
                $this->email->bcc($sa_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject($subject);
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $msg = "Admin has been commented against " . $get_invoice_details[0]['invoice_code'] . "<br> " . "<label><strong>Admin Name : </strong>" . ucwords($admin_name) . "<br> <label><strong> comments : </strong>" . " " . stripslashes($message) . "<br> <label><strong> Vendor Name : </strong>" . " " . ucwords($get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']);
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sa_id . "_" . "superadmin";
                $recipients [] = $get_vendor_details[0]['vendor_id'] . "_" . "vendor";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['admin_id'],
                        "sender_type" => "admin",
                        "subject" => $subject,
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

                $this->session->set_flashdata('succ_msg', 'Comments sent Successfully..');
                redirect(base_url() . 'admin_payment_comments/' . base64_encode($invoice_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Comments not sent Successfully..');
                redirect(base_url() . 'admin_consultant_invoice/' . base64_encode($invoice_id));
            }
        }
    }

    public function admin_payment_comments() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];


        $invoice_id = base64_decode($this->uri->segment(2));
        $data['get_payment_details'] = $this->employee_model->getPaymentDetailsByInvoice($invoice_id);
        $data['get_payment_comments'] = $this->employee_model->getPaymentComments($invoice_id);
        $data['admin_id'] = $admin_id;
        $data['page'] = "payment";
        $data['meta_title'] = "COMMENTS";

        $this->load->view('admin/admin_payment_comments', $data);
    }

    public function admin_employee_list() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        
        if (US || INDIA) {
            $data['admin_type_id'] = $sess_arr['admin_type_id'];
        }

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        if (INDIA) {
            if ( $data['admin_type_id'] == 6 ) {
                $data['get_employee_details'] = $this->employee_model->getAllEmployeeListsbyAdmin();
            }
            else {
            //$data['get_employee_details'] = $this->employee_model->getEmployeeListsbyAdmin($admin_id);
                $data['get_employee_details'] = $this->employee_model->getEmployeeListsbyAdmin($admin_id);

            }
        }
        
        if (US || LATAM) {
            $data['get_employee_details'] = $this->employee_model->getAllEmployeeListsbyAdmin();
        }

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE LISTS";

        $this->load->view('admin/admin_employee_list', $data);
    }

    public function all_admin_employee_list() {
        
        if (INDIA) {
            //$data['get_employee_details'] = $this->employee_model->getEmployeeListsbyAdmin($admin_id);
            $data['get_employee_details'] = $this->employee_model->getAllEmployeeListsbyAdmin();

            $this->load->view('admin/all_admin_employee_list', $data);
        }
    }

    public function admin_direct_report_list() {
        if (INDIA) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];

            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['get_employee_details'] = $this->employee_model->getEmployeeListsbyAdmin($admin_id);

            $this->load->view('admin/all_admin_employee_list', $data);
        }
    }


    public function add_admin_employee_user() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        $data['get_client'] = $this->employee_model->getClientLists();

        $check_last_id = $this->employee_model->checkCount($admin_id);
        $count = $check_last_id[0]['cnt'] + 1;

        $words = explode(" ", $data['get_details'][0]['admin_company_name']);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $employee_code = strtoupper($acronym . "E") . str_pad($count, 3, "0", STR_PAD_LEFT);
        $data['employee_code'] = $employee_code;

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE ADD";

        if (US || INDIA) {
            $data['get_shift_data'] = $this->employee_model->getShiftDropDownData();

            $data['shift_managers'] = $this->employee_model->get_shift_manager();
        }

        $this->load->view('admin/add_admin_employee_user', $data);
    }

    public function insert_admin_employee_user() {
        $db = get_instance()->db->conn_id;
        $recipients = array();

        $admin_id = $this->input->post('admin_id');
        $client_id = $this->input->post('client_id');
        $employee_code = $this->input->post('employee_code');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_type = $this->input->post('employee_type');
        if (LATAM) {
            $is_temp_emp = $this->input->post('is_temp_emp');
        }
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $date_of_joining = $this->input->post('date_of_joining');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));
        if (US || INDIA) {
        $shift_type = !empty($this->input->post('shift_type')) ? $this->input->post('shift_type') : null;
        $shift_admin_manager_id = $this->input->post('shift_manager');

        $n_doj = explode("/", $date_of_joining);
        $new_doj = $n_doj[2] . "-" . $n_doj[0] . "-" . $n_doj[1];
        }

        // if (isset($employee_bill_rate_type) && isset($employee_pay_rate_type) && ($employee_bill_rate_type != $employee_pay_rate_type)) {
        //     $this->session->set_flashdata('error_msg', 'Employee bill rate type and pay rate type should be same');
        //     redirect(base_url() . 'add-admin-employee-user');
        // }
        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'Employee First Name cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
        } elseif (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Employee Last Name cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Employee Designation cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Employee Classification cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Employee Category cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'add-admin-employee-user');
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
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-admin-employee-user');
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
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            /* ---------------Resume-------------- */

            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
            $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
            $sa_id = $get_sadmin_details[0]['sa_id'];
            $sa_email = $get_sadmin_details[0]['sa_email'];

            if (US || INDIA) {
                $insert_arr = array(
                    'admin_id' => $admin_id,
                    'client_id' => $client_id,
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
                    'date_of_joining' => $new_doj,
                    'employee_bill_rate' => $employee_bill_rate,
                    'employee_pay_rate' => $employee_pay_rate,
                    'emp_bill_rate_type' => $employee_bill_rate_type,
                    'emp_pay_rate_type' => $employee_pay_rate_type,
                    'shift_id' => $shift_type,
                    'shift_admin_manager_id' => $shift_admin_manager_id
                );
            }
            if (LATAM) {
                $insert_arr = array(
                    'admin_id' => $admin_id,
                    'client_id' => $client_id,
                    'employee_code' => $employee_code,
                    'name_prefix' => $name_prefix,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'employee_type' => $employee_type,
                    'is_temp_emp' => $is_temp_emp,
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
                    'employee_bill_rate' => $employee_bill_rate,
                    'employee_pay_rate' => $employee_pay_rate,
                    'emp_bill_rate_type' => $employee_bill_rate_type,
                    'emp_pay_rate_type' => $employee_pay_rate_type
                );
            }
                    //echo "<pre>";
                    //print_r($insert_arr);
                    //die;
            $insert_query = $this->employee_model->add_employee_user($insert_arr);

            if ($insert_query != '') {

                $name_prefix = $name_prefix;
                $employee_name = $first_name . " " . $last_name;
                $employee_code = $employee_code;
                $employee_classification = $employee_classification;
                $employee_designation = $employee_designation;
                // if ($employee_category == '1') {
                //     $employee_category = "W2";
                // } else {
                //     $employee_category = "Subcontractor";
                // }

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
                $name_prefix = $get_admin_details[0]['name_prefix'];
                $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];

                $data['msg'] = "<p style='font-weight: 800;'> " . ucwords($name_prefix) . " " . ucwords($admin_name) . " has added new employee successfully. Employee Details are as follows : </p>
                                                <p style='font-weight: 300;'>
                                                    <label><strong>Employee Details : </strong></label><br/>
                                                    <label><strong>Employee Code : </strong> " . strtoupper($employee_code) . "</label><br/>
                                                    <label><strong>Employee Name : </strong> " . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Designation : </strong> " . $employee_designation . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Category : </strong> " . $employee_classification . "</label><br/>
                                                </p>";

                $data['login_type'] = "admin";

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($sa_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('New Employee Added Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been added new employee successfully.<br> "
                        . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $employee_code . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sa_id . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "New Employee Added Successfully",
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


                $this->session->set_flashdata('succ_msg', 'Emplyee added Successfully..');
                redirect(base_url() . 'admin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Employee not added Successfully..');
                redirect(base_url() . 'admin-employee-list');
            }
        }
    }

    public function edit_admin_employee_user() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        $data['get_client'] = $this->employee_model->getClientLists();
        if (US || INDIA) {
            $data['get_shift_data'] = $this->employee_model->getShiftDropDownData();
            $data['shift_managers'] = $this->employee_model->get_shift_manager();
        }

        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('admin/edit_employee_user', $data);
    }

    public function insert_shift_break_form_data(){
        if (US || INDIA) {
            // $this->session->unset_userdata('shift_break_modal_form_data');
            // $this->session->set_userdata('shift_break_modal_form_data', $_POST);
            print_r($this->session->userdata('session_clock_time_id'));



            $i=0;
            foreach($_POST['break_type'] as $break_type) {
                $this->employee_model->insert_shift_break_form_data($this->session->userdata('clock_break_data_employee_id'), $this->session->userdata('session_clock_time_id'), $break_type,$_POST['start_date'][$i], $_POST['start_time'][$i], $_POST['end_date'][$i], $_POST['end_time'][$i],$_POST['paid'][$i],$_POST['comment'][$i], $this->session->userdata('clock_break_data_admin_id'), date("Y-m-d H:i:s"));
                $i++;
            }

            $this->session->set_flashdata('succ_msg', 'Break added successfully');
            // $shift_break_data = $this->session->userdata('shift_break_modal_form_data');
            // print_r($shift_break_data); 
            // print_r($this->session->userdata('shift_break_modal_form_data'));
        }
    }

    public function add_admin_employee_shift() {
        
        if (US || INDIA) {
            
            // echo "test";
            // print_r($_SESSION);
            // print_r($this->session->userdata('shift_break_modal_form_data'));
            // exit;
            if ($_POST['clock_id']) {

                $c = 0;
                foreach($_POST['clock_id'] as $cid) {
                    if ($cid) {
                        $this->employee_model->update_clock_admin_data($_POST['clock_in_date'][$c],$_POST['clock_in_time'][$c], $_POST['clock_out_date'][$c], $_POST['clock_out_time'][$c], $_POST['comment'][$c], $cid);
                    }
                    $c++;
                }

                $t = 0;
                foreach($_POST['training_break'] as $tr) {
                    if ($tr) {
                        $this->employee_model->update_training_break_admin($_POST['training_break_start_date'][$t], $_POST['training_break_start_time'][$t], $_POST['training_break_end_date'][$t], $_POST['training_break_end_time'][$t], $_POST['comment_t'][$t], $tr);
                    }
                    $t++;
                }
                $p = 0;
                foreach($_POST['personal_break'] as $pr) {
                    if ($pr) {
                        $this->employee_model->update_personal_break_admin($_POST['personal_break_start_date'][$p], $_POST['personal_break_start_time'][$p], $_POST['personal_break_end_date'][$p], $_POST['personal_break_end_time'][$p], $_POST['comment_p'][$p], $pr);
                    }  
                    $p++;
                }
                $m = 0;
                foreach($_POST['meeting_break'] as $me) {
                    if ($me) {
                        $this->employee_model->update_meeting_break_admin($_POST['meeting_break_start_date'][$m], $_POST['meeting_break_start_time'][$m], $_POST['meeting_break_end_date'][$m], $_POST['meeting_break_end_time'][$m],$_POST['comment_m'][$m], $me);
                    }
                    $m++;
                }

                $l = 0;
                foreach($_POST['lunch_break'] as $lu) {
                    if ($lu) {
                        $this->employee_model->update_lunch_break_admin($_POST['lunch_break_start_date'][$l], $_POST['lunch_break_start_time'][$l], $_POST['lunch_break_end_date'][$l], $_POST['lunch_break_end_time'][$l], $_POST['comment_l'][$l], $lu);
                    }
                    $l++;
                }

                $this->session->unset_userdata('shift_break_modal_form_data');
                $this->session->set_flashdata('succ_msg', 'Shift Updated Successfully');
                redirect(base_url().'addEdit-employee-shifthours');
            }
            else {
                $clock_in_date = $_POST['clock_in_date'];
                $clock_in_time = $_POST['clock_in_time'];
                $clock_out_date = $_POST['clock_out_date'];
                $clock_out_time = $_POST['clock_out_time'];

                $insert_data = [
                    'employee_id' => $this->session->userdata('clock_break_data_employee_id'),
                    'shift_id' => $this->session->userdata('clock_break_data_shift_id'),
                    'clock_in' => date('Y-m-d H:i:s', strtotime("$clock_in_date $clock_in_time")),
                    'clock_out' => date('Y-m-d H:i:s', strtotime("$clock_out_date $clock_out_time")),
                    'comment' => $_POST['comment'],
                    'created_by' => $this->session->userdata('clock_break_data_admin_id'),
                    'created_time' => date("Y-m-d H:i:s"),
                    'clock_in_ipaddress' => getenv("REMOTE_ADDR"),
                ];

                $insert_id = $this->employee_model->insert_clock_data_admin($insert_data);

                // $shift_break_modal_form_data = $this->session->userdata('shift_break_modal_form_data');
                
                // // print_r($this->session->userdata('shift_break_modal_form_data'));
                // // exit;
                
                // $i=0;
                // foreach($shift_break_modal_form_data['break_type'] as $break_type) {
                //     $this->employee_model->insert_shift_break_form_data($this->session->userdata('clock_break_data_employee_id'), $insert_id, $break_type,$shift_break_modal_form_data['start_date'][$i], $shift_break_modal_form_data['start_time'][$i], $shift_break_modal_form_data['end_date'][$i], $shift_break_modal_form_data['end_time'][$i],$shift_break_modal_form_data['paid'][$i],$shift_break_modal_form_data['comment'][$i], $this->session->userdata('clock_break_data_employee_id'), date("Y-m-d H:i:s"));
                //     $i++;
                // }

                $this->session->unset_userdata('shift_break_modal_form_data');
                $this->session->set_flashdata('succ_msg', 'Shift Added Successfully');
                redirect(base_url().'addEdit-employee-shifthours');
            }
        }
    }

    public function get_employee_clock_data() {
        
        if (US || INDIA) {
            $date = $this->input->post('date');
            $employee_id = $this->input->post('employee_id');

            $this->session->unset_userdata('shift_break_modal_form_data');
            $this->session->set_userdata('clock_break_data_employee_id', $employee_id);
            $this->session->set_userdata('clock_break_data_date', date("Y-m-d H:i:s", strtotime($date)));

            $shift_id_data = $this->employee_model->get_employee_shift_id($employee_id);
            $shift_id_val = $shift_id_data[0]['shift_id'];

            $this->session->set_userdata('clock_break_data_shift_id', $shift_id_val);
            
            $clock_data = $this->employee_model->get_employee_clock_data($employee_id,$date);

            $clock_data_main = $this->employee_model->get_employee_clock_data_main($employee_id,$date);
            // echo "<pre>".print_r($clock_data_main,1)."</pre>";

            $show_add_break = false;

            $clock_str = "<tr>";
            if (!empty($clock_data_main)) {
                foreach ($clock_data_main as $c) {
                    if (!empty($c->clock_in)) {

                        $clock_in_date = date("Y-m-d", strtotime($c->clock_in));
                        $clock_in_time = date("H:i:s", strtotime($c->clock_in));
                        
                        $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' name='clock_in_date[]' class='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' id='clock_in_time' name='clock_in_time[]' class='clock_in_time validate[required]' value='".$clock_in_time."'></td>";
                    }
                    else {

                        $clock_in_date = date("Y-m-d", strtotime($date));

                        $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' name='clock_in_date[]' class='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' id='clock_in_time' name='clock_in_time[]' class='clock_in_time validate[required]'></td>";
                    }
                    if (!empty($c->clock_out)) {

                        $clock_out_date = date("Y-m-d", strtotime($c->clock_out));
                        $clock_out_time = date("H:i:s", strtotime($c->clock_out));
                        
                    $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' name='clock_out_date[]' class='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' id='clock_out_time' name='clock_out_time[]' max='".date("H:i:s")."' class='clock_out_time validate[required]' value='".$clock_out_time."'></td>";
                    }
                    else {

                        $clock_out_date = date("Y-m-d", strtotime($date));

                    $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' name='clock_out_date[]' class='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' id='clock_out_time' name='clock_out_time[]' max='".date("H:i:s")."' class='clock_out_time validate[required]'></td>";
                    }
                $clock_str.="<td width='15%'><label for='comment'>Comment<span style='color: red;'>*</span>&nbsp;&nbsp;&nbsp;</label></td><td width='15%'><input type='text' name='comment[]' value='".$c->comment."' id='comment' class='validate[required]'></td>";
                    $clock_str.="<input type='hidden' name='clock_id[]' value='".$c->clock_id."'></tr>";

                    if (!empty($c->clock_id)) {
                        $this->session->set_userdata('session_clock_time_id', $c->clock_id);
                        $show_add_break = true;
                    }
                    else {
                        $show_add_break = false;
                    }
                }
            }
            else {
                
                if (!empty($date)) {

                    $show_add_break = false;
                    
                    $this->session->set_userdata('show_add_break', false);

                    $clock_in_date = date("Y-m-d", strtotime($date));
                    $clock_out_date = date("Y-m-d", strtotime($date));

                    $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' class='clock_in_date' name='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' step='1' id='clock_in_time' name='clock_in_time' class='clock_in_time validate[required]'></td>";

                $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' class='clock_out_date' name='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' step='1' id='clock_out_time' name='clock_out_time' max='".date("H:i:s")."' class='clock_out_time validate[required]'></td>";

                $clock_str.="<td width='15%'><label for='comment'>Comment<span style='color: red;'>*</span>&nbsp;&nbsp;&nbsp;</label></td><td width='15%'><input type='text' name='comment' id='comment' class='validate[required]'></td></tr>";

                    $clock_str.="<tr><td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>Shift details are not there</b></span></div></td></tr>";

                }
                else {
                    
                    $show_add_break = false;

                    $clock_str.="<td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>Shift details are not there</b></span></div></td></tr>";
                }
            }
            

            $break_str = "";
            foreach ($clock_data as $c) {
                if ($c->break_type == "personal") {

                    $personal_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                    
                    $personal_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                    $personal_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                    $personal_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                    if (!empty($personal_break_start_time) && ($personal_break_end_time != "00:00:00")) {
                        $break_str.="<tr><td width='15%'><label for='personal_break_start_date'>Personal break start time</label>
                    </td><td><input type='date' id='personal_break_start_date' name='personal_break_start_date[]' class='break_start_date'  value='".$personal_break_start_date."' readonly></td><td><input type='time' step='1' id='personal_break_start_time' name='personal_break_start_time[]' class='break_start_time' value='".$personal_break_start_time."'></td><td><label for='personal_break_end_date'>Personal break end time</label></td><td><input type='date' id='personal_break_end_date' name='personal_break_end_date[]' class='break_end_date validate[required]' value='".$personal_break_end_date."' readonly></td><td><input type='time' step='1' id='personal_break_end_time' name='personal_break_end_time[]' class='break_end_time validate[required]' value='".$personal_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_p[]' value='".$c->comment."' id='comment_p' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='personal_break[]' value='".$c->break_id."'></tr>";
                    }
                    else if (!empty($personal_break_start_time) && ($personal_break_end_time == "00:00:00")) {

                        $personal_break_end_date = date("Y-m-d", strtotime($date));

                        $break_str.="<tr><td><label for='personal_break_start_date'>Personal break start time</label>
                    </td><td><input type='date' id='personal_break_start_date' name='personal_break_start_date[]' class='break_start_date'  value='".$personal_break_start_date."' readonly></td><td><input type='time' step='1' id='personal_break_start_time' name='personal_break_start_time[]' class='break_start_time' value='".$personal_break_start_time."'></td><td><label for='personal_break_end_date'>Personal break end time</label></td><td><input type='date' id='personal_break_end_date' name='personal_break_end_date[]' class='break_end_date validate[required]' value='".$personal_break_end_date."' readonly></td><td><input type='time' step='1' id='personal_break_end_time' name='personal_break_end_time[]' class='break_end_time validate[required]'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_p[]' value='".$c->comment."' id='comment_p' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='personal_break[]' value='".$c->break_id."'></tr>";
                    }
                }
                if ($c->break_type == "meeting") {
                    
                    $meeting_break_start_date = date("Y-m-d", strtotime($c->break_start_time));

                    $meeting_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                    $meeting_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                    $meeting_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                    if (!empty($meeting_break_start_time) && ($meeting_break_end_time!= "00:00:00")) {

                        $break_str.="<tr><td><label for='meeting_break_start_date'>Meeting break start time</label>
                    </td><td><input type='date' id='meeting_break_start_date' name='meeting_break_start_date[]' class='break_start_date'  value='".$meeting_break_start_date."' readonly></td><td><input type='time' step='1' id='meeting_break_start_time' name='meeting_break_start_time[]' class='break_start_time' value='".$meeting_break_start_time."'></td><td><label for='meeting_break_end_date'>Meeting break end time</label></td><td><input type='date' id='meeting_break_end_date' name='meeting_break_end_date[]' class='break_end_date validate[required]'  value='".$meeting_break_end_date."' readonly></td><td><input type='time' step='1' id='meeting_break_end_time' name='meeting_break_end_time[]' class='break_end_time validate[required]' value='".$meeting_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_m[]' class='validate[required]' value='".$c->comment."' id='comment_m' style='width: 66px !important;'></td><input type='hidden' name='meeting_break[]' value='".$c->break_id."'></tr>";
                    }
                    else if (!empty($meeting_break_start_time) && ($meeting_break_end_time== "00:00:00")) {

                        $meeting_break_end_date = date("Y-m-d", strtotime($date));

                        $break_str.="<tr><td><label for='meeting_break_start_date'>Meeting break start time</label>
                    </td><td><input type='date' id='meeting_break_start_date' class='break_start_date' name='meeting_break_start_date[]'  value='".$meeting_break_start_date."' readonly></td><td><input type='time' step='1' id='meeting_break_start_time' name='meeting_break_start_time[]' class='break_start_time' value='".$meeting_break_start_time."'></td><td><label for='meeting_break_end_date'>Meeting break end time</label></td><td><input type='date' id='meeting_break_end_date' class='break_end_date validate[required]' name='meeting_break_end_date[]' value='".$meeting_break_end_date."' readonly></td><td><input type='time' step='1' id='meeting_break_end_time' name='meeting_break_end_time[]' class='break_end_time validate[required]'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_m[]' value='".$c->comment."' id='comment_m' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='meeting_break[]' value='".$c->break_id."'></tr>";
                    }
                }
                if ($c->break_type == "training") {

                    $training_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                    
                    $training_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                    $training_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                    $training_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                    if (!empty($training_break_start_time) && ($training_break_end_time != "00:00:00")) {

                        $break_str.="<tr><td><label for='training_break_start_date'>Training break start time</label>
                    </td><td><input type='date' id='training_break_start_date' class='break_start_date' name='training_break_start_date[]'  value='".$training_break_start_date."' readonly></td><td><input type='time' step='1' id='training_break_start_time' name='training_break_start_time[]' class='break_start_time' value='".$training_break_start_time."'></td><td><label for='training_break_end_date'>Training break end time</label></td><td><input type='date' id='training_break_end_date' class='break_end_date validate[required]' name='training_break_end_date[]'  value='".$training_break_end_date."' readonly></td><td><input type='time' step='1' id='training_break_end_time' name='training_break_end_time[]' class='break_end_time validate[required]' value='".$training_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_t[]' value='".$c->comment."' id='comment_t' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='training_break[]' value='".$c->break_id."'></tr>";
                    }
                    else if (!empty($training_break_start_time) && ($training_break_end_time == "00:00:00")) {

                        $training_break_end_date = date("Y-m-d", strtotime($date));

                        $break_str.="<tr><td><label for='training_break_start_date'>Training break start time</label>
                    </td><td><input type='date' id='training_break_start_date' name='training_break_start_date[]' class='break_start_date'  value='".$training_break_start_date."' readonly></td><td><input type='time' step='1' id='training_break_start_time' name='training_break_start_time[]' class='break_start_time' value='".$training_break_start_time."'></td><td><label for='training_break_end_date'>Training break end time</label></td><td><input type='date' id='training_break_end_date' name='training_break_end_date[]' class='break_end_date validate[required]' value='".$training_break_end_date."' readonly></td><td><input type='time' step='1' id='training_break_end_time' name='training_break_end_time[]' class='break_end_time validate[required]'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_t[]' value='".$c->comment."' id='comment_t' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='training_break[]' value='".$c->break_id."'></tr>";
                    }
                }

                if ($c->break_type == "lunch") {

                    $lunch_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                    
                    $lunch_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                    $lunch_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                    $lunch_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                    if (!empty($lunch_break_start_time) && ($lunch_break_end_time != "00:00:00")) {
                        $break_str.="<tr><td><label for='lunch_break_start_date'>Lunch break start time</label>
                    </td><td><input type='date' id='lunch_break_start_date' name='lunch_break_start_date[]' class='break_start_date'  value='".$lunch_break_start_date."' readonly></td><td><input type='time' step='1' id='lunch_break_start_time' name='lunch_break_start_time[]' class='break_start_time' value='".$lunch_break_start_time."'></td><td><label for='lunch_break_end_date'>Lunch break end time</label></td><td><input type='date' id='lunch_break_end_date' name='lunch_break_end_date[]' class='break_end_date validate[required]' value='".$lunch_break_end_date."' readonly></td><td><input type='time' step='1' id='lunch_break_end_time' name='lunch_break_end_time[]' class='break_end_time validate[required]' value='".$lunch_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_l[]' class='validate[required]' value='".$c->comment."' id='comment_l' style='width: 66px !important;'></td><input type='hidden' name='lunch_break[]' value='".$c->break_id."'></tr>";
                    }
                    else if (!empty($lunch_break_start_time) && ($lunch_break_end_time == "00:00:00")) {

                        $lunch_break_end_date = date("Y-m-d", strtotime($date));

                        $break_str.="<tr><td><label for='lunch_break_start_date'>Lunch break start time</label>
                    </td><td><input type='date' id='lunch_break_start_date' name='lunch_break_start_date[]' class='break_start_date'  value='".$lunch_break_start_date."' readonly></td><td><input type='time' step='1' id='lunch_break_start_time' name='lunch_break_start_time[]' class='break_start_time' value='".$lunch_break_start_time."'></td><td><label for='lunch_break_end_date'>Lunch break end time</label></td><td><input type='date' id='lunch_break_end_date' name='lunch_break_end_date[]' class='break_end_date validate[required]' value='".$lunch_break_end_date."' readonly></td><td><input type='time' step='1' id='lunch_break_end_time' name='lunch_break_end_time[]' class='break_end_time validate[required]'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_l[]' value='".$c->comment."' id='comment_l' class='validate[required]' style='width: 66px !important;'></td><input type='hidden' name='lunch_break[]' value='".$c->break_id."'></tr>";
                    }
                }
            }

            if (empty($break_str)) {
                $break_str.="<tr><td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>No breaks available</b></span></div></td></tr>";
            }

            $result = [
                'clock_str' => $clock_str,
                'break_str' => $break_str,
                'show_add_break' => $show_add_break,
            ];

            echo json_encode($result);
        }
    }

    public function add_employee_shift_test() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            if (INDIA) {
                $data['admin_type_id'] = $sess_arr['admin_type_id'];
                // print_r($data['admin_type_id']);
                // exit;
            }

            $employee_id = base64_decode("Mjg=");
            
            $admin_id = $data['get_details'][0]['admin_id'];

            if (INDIA) {
                if ($data['admin_type_id'] == 6) {
                    $data['get_all_employees_shift'] = $this->employee_model->get_employees_shift_all();
                    // print_r($data['get_all_employees_shift']);
                }
                else {
                    $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
                }
            }

            if (US) {
                $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
            }
            // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
            // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
            // $data['get_client'] = $this->employee_model->getClientLists();

            $admin_id = $data['get_details'][0]['admin_id'];
            $data['admin_id'] = $admin_id;

            $this->session->set_userdata('clock_break_data_admin_id', $admin_id);

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/add_employee_shift_test', $data);
        }
    }

    public function get_all_employee_shift_details() {
        if (US || INDIA) {
            $from = $this->input->post('from');
            $from = date("Y-m-d H:i:s", strtotime($from));
            $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
            $to = $this->input->post('to');
            $to = date("Y-m-d 23:59:59", strtotime($to));
            $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
            $employee_id = $this->input->post('employee_id');
            $this->session->set_userdata('employee_datewise_shift_summary_employee_id', $employee_id);

            if (US) {
                $employee_data = $this->employee_model->getEmployeeData($employee_id);
                $employee_name = $employee_data[0]['first_name']." ".$employee_data[0]['last_name'];

                $get_current_employees_shift_total_hours = $this->employee_model->get_current_employees_shift_total_hours($from, $to, $employee_id);

                $get_current_employees_shift_total_paid_breaks = $this->employee_model->get_current_employees_shift_total_paid_breaks($from, $to, $employee_id);

                $get_current_employees_shift_total_unpaid_breaks = $this->employee_model->get_current_employees_shift_total_unpaid_breaks($from, $to, $employee_id);

                $total_breaks = (int)$get_current_employees_shift_total_paid_breaks[0]->total_paid_break + $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break;

                $result = [
                    'employee_name' => $employee_name,
                    'total_hours' => $get_current_employees_shift_total_hours[0]->total_hours,
                    'total_break' => $total_breaks,
                    'total_paid_break' => $get_current_employees_shift_total_paid_breaks[0]->total_paid_break,
                    'total_unpaid_break' => $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break,
                ];
                
                echo json_encode($result);
            }

            if (INDIA) {

                if (empty($employee_id)) {

                    $sess_arr = $this->session->userdata('admin_logged_in');
                    $email = $sess_arr['email'];
                    $data['get_details'] = $this->profile_model->getDetails($email);
        
                    $admin_id = $data['get_details'][0]['admin_id'];
        
                    $all_employees_under_manager = $this->employee_model->get_all_employees_shift($admin_id);
                    $result = [];
                    foreach ($all_employees_under_manager as $empshift) {
        
                        $employee_data = $this->employee_model->getEmployeeData($empshift['employee_id']);
                        $employee_name = $employee_data[0]['first_name']." ".$employee_data[0]['last_name'];
        
                        $get_current_employees_shift_total_hours = $this->employee_model->get_current_employees_shift_total_hours($from, $to, $empshift['employee_id']);
        
                        $get_current_employees_shift_total_paid_breaks = $this->employee_model->get_current_employees_shift_total_paid_breaks($from, $to, $empshift['employee_id']);
        
                        $get_current_employees_shift_total_unpaid_breaks = $this->employee_model->get_current_employees_shift_total_unpaid_breaks($from, $to, $empshift['employee_id']);
        
                        $total_breaks = (int)$get_current_employees_shift_total_paid_breaks[0]->total_paid_break + $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break;
        
                        $result[] = [
                            'employee_name' => $employee_name,
                            'total_hours' => $get_current_employees_shift_total_hours[0]->total_hours,
                            'total_break' => $total_breaks,
                            'total_paid_break' => $get_current_employees_shift_total_paid_breaks[0]->total_paid_break,
                            'total_unpaid_break' => $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break,
                        ];
        
                    }
        
                    echo json_encode($result);
                }
                else {
        
                    $employee_data = $this->employee_model->getEmployeeData($employee_id);
                    $employee_name = $employee_data[0]['first_name']." ".$employee_data[0]['last_name'];
        
                    $get_current_employees_shift_total_hours = $this->employee_model->get_current_employees_shift_total_hours($from, $to, $employee_id);
        
                    $get_current_employees_shift_total_paid_breaks = $this->employee_model->get_current_employees_shift_total_paid_breaks($from, $to, $employee_id);
        
                    $get_current_employees_shift_total_unpaid_breaks = $this->employee_model->get_current_employees_shift_total_unpaid_breaks($from, $to, $employee_id);
        
                    $total_breaks = (int)$get_current_employees_shift_total_paid_breaks[0]->total_paid_break + $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break;
        
                    $result = [
                        'employee_name' => $employee_name,
                        'total_hours' => $get_current_employees_shift_total_hours[0]->total_hours,
                        'total_break' => $total_breaks,
                        'total_paid_break' => $get_current_employees_shift_total_paid_breaks[0]->total_paid_break,
                        'total_unpaid_break' => $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break,
                    ];
        
                    echo json_encode($result);
                }
            }
        }
    }


    public function approve_deny_email_page() {
        if (INDIA) {
            $employee_id =  $this->uri->segment(2);
            $this->session->set_userdata('employee_datewise_shift_summary_employee_id', $employee_id);

            $date = $this->uri->segment(3);
            $from = date("Y-m-d", strtotime($date));
            $this->session->set_userdata('employee_datewise_shift_summary_from', $from);

            $to = date("Y-m-d", strtotime($date));
            $this->session->set_userdata('employee_datewise_shift_summary_to', $to);

            redirect(base_url()."view-employee-shifthours-detail");
        }
    }






    public function get_employee_datewise_shift_summary() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $admin_id = $data['get_details'][0]['admin_id'];

            $employee_id = base64_decode("Mjg=");
            
            if (INDIA) {
                $data['admin_type_id'] = $sess_arr['admin_type_id'];

                if ($data['admin_type_id'] == 6) {
                    $data['get_all_employees_shift'] = $this->employee_model->get_employees_shift_all();
                    // print_r($data['get_all_employees_shift']);
                }
                else {
                $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
                }
            }
            if (US) {
                $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
            }
            
            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/get_employee_datewise_shift_summary', $data);
        }
    }


    public function get_employee_shift_summary_data_all() {
        if (US || INDIA) {
            $from = $this->input->post('from');
            $from = date("Y-m-d H:i:s", strtotime($from));
            $to = $this->input->post('to');
            $to = date("Y-m-d 23:59:59", strtotime($to));
            $employee_id = $this->input->post('employee_id');

            if (US) {
                echo json_encode($this->employee_model->get_employee_shift_summary_data_all($from, $to, $employee_id, false));
            }

            if (INDIA) {
                if (empty($employee_id)) {

                    $sess_arr = $this->session->userdata('admin_logged_in');
                    $email = $sess_arr['email'];
                    $data['get_details'] = $this->profile_model->getDetails($email);

                    $admin_id = $data['get_details'][0]['admin_id'];

                    $all_employees_under_manager = $this->employee_model->get_all_employees_shift($admin_id);
                    $all_emp_under_mng = [];
                    foreach ($all_employees_under_manager as $empshift) {
                        $all_emp_under_mng[] = $empshift['employee_id'];
                    }

                    echo json_encode($this->employee_model->get_employee_shift_summary_data_all($from, $to, $all_emp_under_mng, true));
                }
                else {
                    echo json_encode($this->employee_model->get_employee_shift_summary_data_all($from, $to, $employee_id, false));
                }
            }
        }
    }

    public function change_employee_datewise_shift_summary_status() {
        if (US || INDIA) {
            $from = $this->input->post('from');
            $from = date("Y-m-d H:i:s", strtotime($from));
            $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
            $to = $this->input->post('to');
            $to = date("Y-m-d H:i:s", strtotime($to));
            $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
            $clock_time_id = $this->input->post('clock_time_id');
            $admin_id = $this->input->post('admin_id');
            $res = $this->employee_model->change_employee_datewise_shift_summary_status($clock_time_id, $admin_id);
            if ($res > 0) {
                echo "1";
            }
            else {
                echo "0";
            }
        }
    }

    public function change_employee_datewise_shift_summary_status_disapprove() {
        if (US || INDIA) {
            $from = $this->input->post('from');
            $from = date("Y-m-d H:i:s", strtotime($from));
            $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
            $to = $this->input->post('to');
            $to = date("Y-m-d H:i:s", strtotime($to));
            $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
            $clock_time_id = $this->input->post('clock_time_id');
            $admin_id = $this->input->post('admin_id');
            $res = $this->employee_model->change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id);
            if ($res > 0) {
                echo "1";
            }
            else {
                echo "0";
            }
        }
    }






    public function all_employee_shift_details() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            if (INDIA) {
                $data['admin_type_id'] = $sess_arr['admin_type_id'];
            }

            $admin_id = $data['get_details'][0]['admin_id'];
            $employee_id = base64_decode("Mjg=");

            if (INDIA) {
                if ($data['admin_type_id'] == 6) {
                    $data['get_all_employees_shift'] = $this->employee_model->get_employees_shift_all();
                    // print_r($data['get_all_employees_shift']);
                }
                else {
                $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
                }
            }
            if (US) {
                $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift($admin_id);
            }

            $data['page'] = "admin_employee_lists";
            $data['meta_title'] = "EMPLOYEE EDIT";

            $this->load->view('admin/all_employee_shift_details', $data);
        }
    }


    public function update_admin_employee_user() {
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $admin_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($admin_email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $recipients = array();

        $employee_id = base64_decode($this->input->post('employee_id'));
        $client_id = $this->input->post('client_id');
        $employee_email = $this->input->post('employee_email');
        if (LATAM) {
            $new_password = $this->input->post('new_password');
        }
        $employee_code = $this->input->post('employee_code');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_designation = $this->input->post('employee_designation');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));
        if (US || INDIA) {
            $shift_type = $this->input->post('shift_type');
            $shift_admin_manager_id = $this->input->post('shift_manager');
        }

        if (LATAM) {
            $is_temp_emp = $this->input->post('is_temp_emp');
            $check_duplicate_email = $this->employee_model->checkDuplicate($employee_email);
        }
        $employee_details = $this->employee_model->getEmployeeData($employee_id);
        $employee_name = $name_prefix . " " . $first_name . " " . $last_name;

        if (isset($first_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        } 
        // else if ( ($employee_email !== $employee_details[0]['employee_email']) && ($check_duplicate_email > 0) ) {
        // $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
        // redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        // }
        else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Employee Designation cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Employee Classification cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Employee Category cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
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
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
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
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
            $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
            $sa_id = $get_sadmin_details[0]['sa_id'];
            $sa_email = $get_sadmin_details[0]['sa_email'];
            //$admin_id = $get_admin_details[0]['admin_id'];

            if (US || INDIA) {
                $update_arr = array(
                    'employee_email' => $employee_email,
                    'client_id' => $client_id,
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
                    'employee_bill_rate' => $employee_bill_rate,
                    'employee_pay_rate' => $employee_pay_rate,
                    'emp_bill_rate_type' => $employee_bill_rate_type,
                    'emp_pay_rate_type' => $employee_pay_rate_type,
                    'updated_date' => date("Y-m-d h:i:s"),
                    'shift_id' => $shift_type,
                    'shift_admin_manager_id' => $shift_admin_manager_id
                );
                $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);
            }

            if (LATAM) {
                $update_arr = array(
                    'employee_email' => $employee_email,
                    'client_id' => $client_id,
                    'name_prefix' => $name_prefix,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'is_temp_emp' => $is_temp_emp,
                    'employee_designation' => $employee_designation,
                    'temp_classification' => $employee_classification,
                    'temp_category' => $employee_category,
                    'file' => $new_file_name,
                    'resume_file' => $new_resume_file_name,
                    'phone_no' => $phone_no,
                    'fax_no' => $fax_no,
                    'address' => $address,
                    'date_of_joining' => $date_of_joining,
                    'employee_bill_rate' => $employee_bill_rate,
                    'employee_pay_rate' => $employee_pay_rate,
                    'emp_bill_rate_type' => $employee_bill_rate_type,
                    'emp_pay_rate_type' => $employee_pay_rate_type,
                    'updated_date' => date("Y-m-d h:i:s")
                );

                if (empty($new_password)) {
                $update_login_arr = array(
                        'consultant_email' => $employee_email,
                );
                } else {
                    $update_login_arr = array(
                        'consultant_email' => $employee_email,
                        'password'=>md5($new_password),
                    );
                }

                $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);
                $update_login_query = $this->employee_model->update_employee_login_user($update_login_arr, $employee_id);
            }
            
            if ($update_query != '0') {

                if ($employee_email != '') {

                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;
                    //$admin_email = $get_admin_details[0]['admin_email'];
                    $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];

                    $data['msg'] = $admin_name . " has updated employee details. <br/> Employee Name : " . $employee_name . "<br/> Employee Code : " . $employee_code;

                    //Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($sa_email);
                    $this->email->bcc($superadmin_email);
                    $this->email->bcc($admin_email);
                    $this->email->subject('Employee Details Updated Successfully');
                    $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                    $this->email->set_mailtype('html');
                    //Send mail
                    $this->email->send();
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                $msg = ucwords($admin_name) . " has been updated employee details successfully.<br> "
                        . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $employee_code . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sa_id . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Employee Details Updated Successfully",
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


                $this->session->set_flashdata('succ_msg', 'Employee updated Successfully..');
                redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Employee not updated Successfully..');
                redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
            }
        }
    }

    public function assign_project_to_employee() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        $data['get_projects'] = $this->employee_model->getProjectLists($admin_id);
        $data['get_employees'] = $this->employee_model->getEmployeeListsByAdmin($admin_id);

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "ASSIGN PROJECTS TO EMPLOYEE ";

        $this->load->view('admin/assign_employee_to_project', $data);
    }

    public function add_assign_projects() {
        $db = get_instance()->db->conn_id;

        $recipients = array();
        $admin_id = $this->input->post('admin_id');
        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
        //echo "<pre>";
        //print_r($employee_ids);
        //die;

        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
        $sa_id = $get_sadmin_details[0]['sa_id'];
        $sa_email = $get_sadmin_details[0]['sa_email'];

        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign-projects-to-employee');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign-projects-to-employee');
        } else {
            $errors = array();
            $error = "";
            if (INDIA) {
            $succ = array();
            }
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                    //                        'admin_id' => $admin_id,
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'status' => '2'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);
                        $get_employee_details = $this->employee_model->getEmployeeData($eval);

                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                        $name_prefix = $get_admin_details[0]['name_prefix'];
                        $employee_email = $get_employee_details[0]['employee_email'];
                        $employee_code = $get_employee_details[0]['employee_code'];
                        $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

                        //if ($get_employee_details[0]['employee_category'] == '1') {
                        $employee_category = show_categories($get_employee_details[0]['temp_category'], false);
                            
                        // } else {
                        //     $employee_category = "Subcontractor";
                        // }

                        $data['msg'] = "<p style='font-weight: 800;'>" . ucwords($name_prefix) . " " . ucwords($admin_name) . " has assigned a new employee for the following project. Project details and Employee details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label>" . ucwords($get_project_details[0]['project_name']) . "<br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details['0']['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Employee Details </label><br/>
                                            <label style='font-weight: bold;'>Employee Code : </label>" . strtoupper($get_employee_details[0]['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Employee Category : </label>" . $employee_category . "<br/>
                                        </p>";

                        //Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($employee_email);
                        $this->email->bcc($sa_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
                        //Send mail
                        $this->email->send();
                        // print_r($this->email->print_debugger());
                        // exit;

                        /* ----------------------------------Insert Mail------------------------------------ */

                        $msg = ucwords($admin_name) . " has been assigned new project to employee successfully.<br> "
                                . "<label><strong>Project Name : </strong>" . $get_project_details[0]['project_name'] . "</label><br/>"
                                . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $employee_code . "</label><br/>";
                        //                        $recipients [] = 1 . "_" . "superadmin";
                        //                        $recipients [] = $sa_id . "_" . "superadmin";
                        //                        $recipients [] = $eval . "_" . "employee";
                                                //foreach($recipients as $rtval) {
                        //                            $r_arr = explode("_", $rtval);
                        //                            $recipient_id = $r_arr[0];
                        //                            $recipient_type = $r_arr[1];

                        $superadmin_insert_arr = array(
                            "recipient_id" => 1,
                            "recipient_type" => "superadmin",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $sadmin_insert_arr = array(
                            "recipient_id" => $sa_id,
                            "recipient_type" => "superadmin",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $employee_insert_arr = array(
                            "recipient_id" => $eval,
                            "recipient_type" => "employee",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );

                        $superadmin_insert_query = $this->communication_model->add_mail($superadmin_insert_arr);
                        $sadmin_insert_query = $this->communication_model->add_mail($sadmin_insert_arr);
                        $employee_insert_query = $this->communication_model->add_mail($employee_insert_arr);

                        /* ----------------------------------Insert Mail------------------------------------ */
                        $error = "1";
                        
                        if (INDIA) {
                            $get_employee_details = $this->employee_model->getEmployeeData($eval);
                            $succ[] =  " Project Assigned Successfully to ".ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']);
                        }
                    }
                } else {
                    $get_employee_details = $this->employee_model->getEmployeeData($eval);
                    $errors[] = ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is Already Assigned.";
                }
            }

            if (US || LATAM) {
                if (!empty($errors)) {
                    $this->session->set_flashdata('error_msg', $errors);
                    redirect(base_url() . 'assign-projects-to-employee');
                } else if ($error == '1') {

                    $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                    redirect(base_url() . 'admin-employee-list');
                }
            }

            if (INDIA) {
                if (!empty($errors)) {
                    // print_r($errors);
                    $this->session->set_flashdata('error_msg', $errors);
                }
                if (!empty($succ)) {
                    // print_r($succ);
                    $this->session->set_flashdata('succ_msg', $succ);
                    // exit;
                }

                redirect(base_url() . 'admin-employee-list');
            }
        }
    }

    public function assign_projects_to_admin_consultant() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        $data['get_projects'] = $this->employee_model->getProjectLists($admin_id);
        $data['get_employees'] = $this->employee_model->getConsultantListsByAdmin($admin_id);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "ASSIGN PROJECTS TO CONSULTANT ";

        $this->load->view('admin/assign_consultant_to_project', $data);
    }

    public function add_assign_projects_consultant() {
        $db = get_instance()->db->conn_id;

        $recipients = array();
        $admin_id = $this->input->post('admin_id');
        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
        //echo "<pre>";
        //print_r($employee_ids);
        //die;

        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
        $sa_id = $get_sadmin_details[0]['sa_id'];
        $sa_email = $get_sadmin_details[0]['sa_email'];

        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign-projects-to-admin-consultant');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign-projects-to-admin-consultant');
        } else {
            $errors = array();
            $error = "";
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                $get_employee_details = $this->employee_model->getEmployeeData($eval);

                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                        'vendor_id' => $get_employee_details[0]['vendor_id'],
                        'admin_id' => $admin_id,
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'updated_date' => date("Y-m-d h:i:s"),
                        'status' => '1'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);


                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                        $name_prefix = $get_admin_details[0]['name_prefix'];
                        $employee_email = $get_employee_details[0]['employee_email'];
                        $employee_code = $get_employee_details[0]['employee_code'];
                        $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

                        if ($get_employee_details[0]['employee_category'] == '1') {
                            $employee_category = "W2";
                        } else {
                            $employee_category = "Subcontractor";
                        }

                        $data['msg'] = "<p style='font-weight: 800;'>" . ucwords($name_prefix) . " " . ucwords($admin_name) . " has assigned a new employee for the following project. Project details and Employee details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label>" . ucwords($get_project_details[0]['project_name']) . "<br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details['0']['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Employee Details </label><br/>
                                            <label style='font-weight: bold;'>Employee Code : </label>" . strtoupper($get_employee_details[0]['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Employee Category : </label>" . $employee_category . "<br/>
                                        </p>";

                        //Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($employee_email);
                        $this->email->bcc($sa_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
                        //Send mail
                        $this->email->send();

                        /* ----------------------------------Insert Mail------------------------------------ */

                        $msg = ucwords($admin_name) . " has been assigned new project to employee successfully.<br> "
                            . "<label><strong>Project Name : </strong>" . $get_project_details[0]['project_name'] . "</label><br/>"
                            . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $employee_code . "</label><br/>";
                        //                        $recipients [] = 1 . "_" . "superadmin";
                        //                        $recipients [] = $sa_id . "_" . "superadmin";
                        //                        $recipients [] = $eval . "_" . "employee";
                                                //foreach($recipients as $rtval) {
                        //                            $r_arr = explode("_", $rtval);
                        //                            $recipient_id = $r_arr[0];
                        //                            $recipient_type = $r_arr[1];

                        $superadmin_insert_arr = array(
                            "recipient_id" => 1,
                            "recipient_type" => "superadmin",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $sadmin_insert_arr = array(
                            "recipient_id" => $sa_id,
                            "recipient_type" => "superadmin",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );
                        $employee_insert_arr = array(
                            "recipient_id" => $eval,
                            "recipient_type" => "employee",
                            "sender_id" => $admin_id,
                            "sender_type" => "admin",
                            "subject" => "New Project Assigned Successfully",
                            "message" => $msg,
                            "entry_date" => date("Y-m-d h:i:s"),
                            "is_deleted" => '0',
                            "status" => '0'
                        );

                        $superadmin_insert_query = $this->communication_model->add_mail($superadmin_insert_arr);
                        $sadmin_insert_query = $this->communication_model->add_mail($sadmin_insert_arr);
                        $employee_insert_query = $this->communication_model->add_mail($employee_insert_arr);

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
                redirect(base_url() . 'assign-projects-to-admin-consultant');
            } else if ($error == '1') {

                $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                redirect(base_url() . 'admin_consultant_lists');
            }
        }
    }

    public function generate_employee_login_details() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;
        $data['admin_id'] = $admin_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('admin/generate_employee_login_details', $data);
    }

    public function insert_employee_login_details() {
        $db = get_instance()->db->conn_id;
        $recipients = array();

        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        // $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);
        // else if ($check_duplicate_email > 0) {
        //     $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
        //     redirect(base_url() . 'generate-employee-login-details/' . base64_encode($employee_id));
        // }

        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate-employee-login-details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate-employee-login-details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
            $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
            $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
            $sa_id = $get_sadmin_details[0]['sa_id'];

            $insert_arr = array(
                'admin_id' => $admin_id,
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
                $employee_email = $consultant_email;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi, " . $name_prefix . " " . ucwords($employee_name) . ", You are successfully enrolled in Global Resource Management System. Your login details are as follows:<br/></p>
                                <p style='font-weight: 300;'>
                                    <label><b>Login Details </b></label><br/>
                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                    <label><b>Temporary Password : </b> " . $employee_password . "</label><br/>
                                </p>";
                $data['login_type'] = "employee";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System.');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($admin_name) . " has been enrolled employee successfully.<br> "
                        . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sa_id . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Employee successfully enrolled in Global Resource Management System.",
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


                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully..');
                redirect(base_url() . 'admin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Login Details Not Generated Successfully..');
                redirect(base_url() . 'admin-employee-list');
            }
        }
    }

    public function generate_admin_consultant_login_details() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;
        $data['admin_id'] = $admin_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('admin/generate_consultant_login_details', $data);
    }

    public function insert_admin_consultant_login_details() {
        $db = get_instance()->db->conn_id;
        $recipients = array();

        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);


        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate-admin-consultant-login-details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate-admin-consultant-login-details/' . base64_encode($employee_id));
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'generate-admin-consultant-login-details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
            $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
            $get_sadmin_details = $this->employee_model->getSuperAdminData($get_admin_details[0]['sa_id']);
            $sa_id = $get_sadmin_details[0]['sa_id'];

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'admin_id' => $admin_id,
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
                $employee_email = $consultant_email;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi, " . $name_prefix . " " . ucwords($employee_name) . ", You are successfully enrolled in Global Resource Management System. Your login details are as follows:<br/></p>
                                <p style='font-weight: 300;'>
                                    <label><b>Login Details </b></label><br/>
                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                    <label><b>Temporary Password : </b> " . $employee_password . "</label><br/>
                                </p>";
                $data['login_type'] = "employee";
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in Global Resource Management System.');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($admin_name) . " has been enrolled employee successfully.<br> "
                    . "<label><strong>Employee Name : </strong>" . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . "</label><br/>" . "<label><strong>Employee Code : </strong>" . $get_employee_details[0]['employee_code'] . "</label><br/>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $sa_id . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Employee successfully enrolled in Global Resource Management System.",
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


                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Login Details Not Generated Successfully..');
                redirect(base_url() . 'admin_consultant_lists');
            }
        }
    }

    public function add_employee_work_order() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $get_employee_details;
        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE WORK ORDER";

        $this->load->view('admin/add_employee_work_order', $data);
    }

    public function insert_employee_work_order() {
        $db = get_instance()->db->conn_id;

        $recipients = array();

        $admin_signature = $this->input->post('admin_signature');
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


        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add_employee_work_order/' . base64_encode($employee_id)));
        } else {

            $insert_arr = array(
                'employee_id' => $employee_id,
                'admin_id' => $admin_id,
                'consultant' => $consultant,
                'start_date' => $start_date,
                'client_name' => $client_name,
                'project_duration' => $project_duration,
                'invoicing_terms' => $invoicing_terms,
                'payment_terms' => $payment_terms,
                'admin_signature' => $admin_signature,
                'bill_rate' => $bill_rate,
                'ot_rate' => $ot_rate,
                'entry_date' => date("Y-m-d h:i:s"),
                'status' => '1',
                'approved_by_admin' => '1'
            );
            //echo "<pre>";
            //            print_r($insert_arr);
            //            die;
            $insert_query = $this->employee_model->add_work_order($insert_arr);

            if ($insert_query != '') {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                if (!empty($get_employee_details)) {
                    if ($get_employee_details[0]['employee_type'] == 'C') {
                        $get_vendor_details = $this->employee_model->getVendorDtls($get_employee_details[0]['vendor_id']);

                        $vendor_name = $get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                        $vendor_email = $get_vendor_details[0]['vendor_email'];
                        $vendor_id = $get_vendor_details[0]['vendor_id'];
                    }
                    $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $get_superadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);

                    $employee_type = $get_employee_details[0]['employee_type'];
                    $employee_email = $get_employee_details[0]['employee_email'];
                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                }
                $sa_admin_email = $get_superadmin_details[0]['sa_email'];

                $get_admin_email = $this->vendor_model->getAdminEmail($admin_id);

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_email = $get_admin_email[0]['admin_email'];
                $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                $data['msg'] = ucwords($admin_name) . " added work order for " . ucwords($employee_name);
                //Load email library
                $this->load->library('email');
                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($vendor_email);
                    $this->email->bcc($sa_admin_email);
                    $this->email->bcc($superadmin_email);
                } else {
                    $this->email->bcc($sa_admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Work Order Added Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been added consultant work order successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                } else {
                    $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has been added employee work order successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . $employee_name . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
                        "subject" => "Work Order Added Successfully",
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

                $this->session->set_flashdata('succ_msg', 'Work Order Added Successfully..');
                redirect(base_url() . 'admin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Work Order Not Added Successfully..');
                redirect(base_url() . 'admin-employee-list');
            }
        }
    }

    public function view_employees_work_order_pdf() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->view('admin/view_admin_employees_work_order_pdf', $data);

        /* $this->load->library('html2pdf');

          $directory_name = './uploads/work_order_pdf/' . date("Y-m-d") . "/" . $get_admin_details[0]['first_name'] . "_" . $get_admin_details[0]['last_name'] . '/' . $get_employee_details[0]['employee_code'] . '/';

          $file_name = time() . rand(00, 99) . ".pdf";

          if (!file_exists($directory_name)) {
          mkdir($directory_name, 0777, true);
          }
          $this->html2pdf->folder($directory_name);
          $this->html2pdf->filename($file_name);
          $this->html2pdf->paper('a4', 'portrait');

          $this->html2pdf->html($this->load->view('admin/view_admin_employees_work_order_pdf', $data, true));
          if ($this->html2pdf->create('show')) {
          redirect(base_url() . 'admin-employee-list');
          } */
    }

    public function approve_disapprove_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $recipients = array();

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_name = ucwords($data['get_details'][0]['first_name'] . " " . $data['get_details'][0]['last_name']);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            if (!empty($get_employee_details)) {
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_type = $get_employee_details[0]['employee_type'];
                $employee_email = $get_employee_details[0]['employee_email'];
                $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);

                $get_vendor_details = $this->employee_model->getVendorDetails($get_employee_details[0]['vendor_id']);
                //            echo "<pre>";
                //                print_r($get_vendor_details);
                ////            $vendor_email = $get_vendor_details[0]['vendor_email'];
                //            $vendor_id = $get_vendor_details[0]['vendor_id'];

                if (!empty($get_admin_details)) {
                    $admin_email = $get_admin_details[0]['admin_email'];
                    $admin_id = $get_admin_details[0]['admin_id'];
                    if (LATAM) {
                        $admin_first_name = $get_admin_details[0]['first_name'];
                    }
                    $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                    if (!empty($get_sadmin_details)) {
                        $sadmin_email = $get_sadmin_details[0]['sa_email'];
                    }
                }
            }


        if ($ad == 'Send BGV E-mail') {

            $msg ="Hello,<br>" . $employee_name . " employee/consultant of " . CLIENT_NAME . " has uploaded documents. Please start background verification on Vetzu.";
            $data['msg'] = $msg;
            $from_email = REPLY_EMAIL;
            $superadmin_email = SUPERADMIN_EMAIL;

            $this->load->library('email');
            $this->email->from($from_email);

            $this->email->to($admin_email);
            $this->email->bcc($superadmin_email);

            $this->email->subject('Start background verification on Vetzu');
            $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
            if(!empty($check)){

                foreach ($check as $tid) {

                $get_document_details[] = $this->employee_model->getUploadedDocs($tid, $employee_id);
                }

                $num = count($get_document_details);
                for($i=0; $i<$num; $i++) {

                    $filename = $get_document_details[$i][0]['file'];
                    $file_path = './uploads/' . $filename;
                    $this->email->attach($file_path);
                }
            }
            $this->email->set_mailtype('html');
            $this->email->send();

            $this->session->set_flashdata('succ_msg', 'Background Verification Requested');
                    redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));

        } else {

            if (LATAM) {
                if ($ad == "Approved" || trim($ad) == "Aprobado") {
                    $form_status = '1';
                } else if ($ad == 'Disapproved' || trim($ad) == "Rechazado") {
                    $form_status = '0';
                }
            }
            if (US || INDIA) {
                if ($ad == 'Approved') {
                    $form_status = '1';
                } else if ($ad == 'Disapproved') {
                    $form_status = '0';
                }
            }

            if (!empty($check)) {

                $update_arr = array(
                    "admin_form_status" => $form_status,
                    "updated_date" => date("Y-m-d h:i:s")
                );

                $msg = "";

                foreach ($check as $tid) {
                    $check_a_form_status = $this->employee_model->check_docs_status($employee_id, $tid);
                    //                echo "<pre>";
                    //                print_r($check_a_form_status);
                    if ($form_status == '0') {
                        if ($check_a_form_status[0]['admin_form_status'] == '1') {
                            $change_status = $this->employee_model->change_docs_status($update_arr, $employee_id, $tid);
                            $get_document_details = $this->employee_model->getUploadedDocs($tid, $employee_id);
                            $msg .= $admin_name . " " . "has been disapproved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                            $data['msg'] = $msg;
                        } else {
                            $change_status = 0;
                        }
                    } else if ($form_status == '1') {
                        if ($check_a_form_status[0]['admin_form_status'] == '0') {
                            $change_status = $this->employee_model->change_docs_status($update_arr, $employee_id, $tid);
                            $get_document_details = $this->employee_model->getUploadedDocs($tid, $employee_id);
                            $msg .= $admin_name . " " . "has been approved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                            $data['msg'] = $msg;
                        } else {
                            $change_status = 0;
                        }
                    }
                }
                    //            if ($form_status == '0') {
                    //                $data['msg'] = "Documents has been disapproved for " . $employee_name;
                    //            } else if ($form_status == '1') {
                    //                $data['msg'] = "Documents has been approved for " . $employee_name;
                    //            }     
                if ($change_status > 0) {

                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;
                    $admin_email = $email;

                    //Load email library
                    $this->load->library('email');
                    $this->email->from($from_email);
                    if (LATAM) {
                        if ($employee_type == 'C') {
                            $this->email->to($employee_email);
                            $this->email->bcc($vendor_email);
                            $this->email->bcc($superadmin_email);
                        } else {
                            $this->email->to($employee_email);
                            $this->email->bcc($superadmin_email);
                        }
                    }
                    if (US || INDIA) {
                        if ($employee_type == 'C') {
                            if (SEND_EMAIL_CANDIDATE_DOCUMENT) {
                                $this->email->to($employee_email);
                                $this->email->bcc($vendor_email);
                            }
        
                            $this->email->bcc($superadmin_email);
                        } else {
        
                            if (SEND_EMAIL_CANDIDATE_DOCUMENT) {
                                $this->email->to($employee_email);
                            }
        
                            $this->email->bcc($superadmin_email);
                        }
                    }
                    $this->email->subject('Documents Status Changed Successfully');
                    $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                    $this->email->set_mailtype('html');
                    $this->email->send();
                    /* ----------------------------------Insert Mail------------------------------------ */

                    if (LATAM) {
                        if ($employee_type == 'C') {
                            $recipients [] = 1 . "_" . "superadmin";
                            $recipients [] = $vendor_id . "_" . "vendor";
                            $recipients [] = $employee_id . "_" . "employee";
                        } else {
                            $recipients [] = 1 . "_" . "superadmin";
                            $recipients [] = $employee_id . "_" . "employee";
                        }
                    }
                    if (US || INDIA) {
                        if ($employee_type == 'C') {
                            $recipients [] = 1 . "_" . "superadmin";
        
                            if (SEND_EMAIL_CANDIDATE_DOCUMENT) {
                                $recipients [] = $vendor_id . "_" . "vendor";
                                $recipients [] = $employee_id . "_" . "employee";
                            }
        
                        } else {
                            $recipients [] = 1 . "_" . "superadmin";
        
                            if (SEND_EMAIL_CANDIDATE_DOCUMENT) {
                                $recipients [] = $employee_id . "_" . "employee";
                            }
                        }
                    }
                    foreach ($recipients as $rtval) {
                        $r_arr = explode("_", $rtval);
                        $recipient_id = $r_arr[0];
                        $recipient_type = $r_arr[1];

                        $insert_arr = array(
                            "recipient_id" => $recipient_id,
                            "recipient_type" => $recipient_type,
                            "sender_id" => $get_admin_details[0]['admin_id'],
                            "sender_type" => "admin",
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
                    redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong');
                    redirect(base_url() . 'view_admin_consultant_documents/' . base64_encode($employee_id));
                }
            }
                //        echo "<pre>";
                //        print_r($check);
                //        die;
        }
    }

    public function show_files() {

        if (!$this->session->userdata('emp_logged_in')) {
            redirect(base_url() . 'employee'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('emp_logged_in');
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
        $this->load->view('admin/form_templates/print_direct_deposit_form', $data);
    }

    public function consultant_onboarding() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];
        if (LATAM) {
            $is_temp_emp = $data['get_employee_details'][0]['is_temp_emp'];

            if ($is_temp_emp) {
                $data['get_documents_details'] = $this->employee_model->get_temporary_employee_documents();
            } else {
                $data['get_documents_details'] = $this->employee_model->getDocumentsListsbyEmpType($employee_type);
            }
        }
        $data['get_documents_details'] = $this->employee_model->getDocumentsListsbyEmpType($employee_type);
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE ONBOARDING";
        $this->load->view('admin/consultant_documentation', $data);
    }

    public function view_file() {

      // Code View File from S3 Bucket Start
      // $path = "demo/employee_onboarding/$id_first/$doc_id";
      $path = $this->input->post('path');
      require('assets/s3/autoload.php');
      $s3 = new Aws\S3\S3Client([
        'region'  => S3_REGION,
        'version' => 'latest',
        'credentials' => [
          'key'    => S3_KEY,
          'secret' => S3_SECRET,
        ]
      ]);
      $cmd = $s3->getCommand('GetObject', [
          'Bucket' => 'porosiq',
          'Key'    => "$path"
      ]);
      $request = $s3->createPresignedRequest($cmd, '+5 minutes');
      $presignedUrl = (string) $request->getUri();
      echo "$presignedUrl";
      // Code View File from S3 Bucket End
    }

    public function upload_consultant_documents() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . "admin"); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode($this->uri->segment(3));
        $data['employee_id'] = $employee_id;
        //S3 Bucket Upload Info Required START
        $data['employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $id_first = $employee_id."_".$data['employee_details'][0]['first_name'];
        $data['id_first'] = $id_first;
        //S3 S3 Bucket Upload Info Required END
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['page'] = "open_requirements";
        $data['doc_id'] = $doc_id;
        $data['get_document_details'] = $this->employee_model->getDocsDetails($doc_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "UPLOAD DOCUMENTS";
        $this->load->view('admin/upload_consultant_documents', $data);
    }

    public function upload_document() {

        $recipients = array();

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $employee_id = $this->input->post('employee_id');
        //S3 Bucket Upload Info Required START
        $id_first = $this->input->post('id_first');
        //S3 Bucket Upload Info Required END

        $check_prev_uploaded_document = $this->employee_model->checkPrevUploaded($doc_id, $employee_id);
        $check_approve_status = $this->employee_model->checkApproveStatus($doc_id, $employee_id);
        if ($check_prev_uploaded_document[0]['cnt'] > 0 && ($check_approve_status[0]['form_status'] == '1' || $check_approve_status[0]['admin_form_status'] == '1')) {
            $this->session->set_flashdata('error_msg', 'Document already approved.');
            redirect(base_url() . 'admin_employee_onboarding/' . base64_encode($employee_id));
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

            if ($file_size > 5242880) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 5 MB');
                $errors[] = "'File size must be excately 5 MB";
            }

            if (empty($errors) == true) {

                //Code For S3 Bucket Start
                if (INDIA) { $instance="india"; } if (US) { $instance="us"; } if (LATAM) { $instance="latam"; }
                $path = "$instance/employee_onboarding/$id_first/$doc_id";
                $new_path = "$instance/employee_onboarding/$id_first/$doc_id/$new_file_name";
                require('assets/s3/autoload.php');
                $s3 = new Aws\S3\S3Client([
                  'region'  => S3_REGION,
                  'version' => 'latest',
                  'credentials' => [
                    'key'    => S3_KEY,
                    'secret' => S3_SECRET,
                  ]
                ]);

                $result = $s3->putObject([
                  'Bucket' => 'porosiq',
                  'Key'    => "$path/$new_file_name",
                  'Content-type' => 'application/pdf',
                  'SourceFile' => $file_tmp
                ]);
                echo "File Uploaded to S3";
                //Code For S3 Bucket End

                // move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 5242880) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 5 MB');
                    $errors[] = "'File size must be excately 5 MB";
                    redirect(base_url() . 'upload_admin_employee_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_admin_employee_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->employee_model->getDocsDetails($doc_id);
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
        $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);

        $insert_arr = array(
            'consultant_id' => $employee_id,
            'form_no' => $doc_id,
            'form_name' => $get_document_details[0]['document_name'],
            'file' => $new_path,
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
                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " has uploaded " . ucwords($get_document_details[0]['document_name']) . " document for " . ucwords($employee_code) . "-" . ucwords($employee_name);
                $data['msg'] = $msg;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($get_sadmin_details[0]['sa_email']);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Pending Verification');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                //Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $get_sadmin_details[0]['sa_id'] . "_" . "superadmin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
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
                redirect(base_url() . 'admin_employee_onboarding/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'admin_employee_onboarding/' . base64_encode($employee_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'admin_employee_onboarding/' . base64_encode($employee_id));
        }
    }

    public function generate_admin_employee_payment() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "GENERATE INVOICE";

        $this->load->view('admin/generate_admin_employee_payment', $data);
    }

    public function ajax_monthly_timesheet() {
        $month = $this->input->post('month', TRUE);
        $year = $this->input->post('year', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
        //        print_r($get_emp_details);
        $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_details[0]['employee_bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_details[0]['employee_ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);

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

        $this->load->view('admin/ajax/ajax_get_monthly_details', $data);
    }

    public function ajax_weekly_timesheet() {
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
        //print_r($get_emp_work_order);
        $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_details[0]['employee_bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_details[0]['employee_ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);


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

        $this->load->view('admin/ajax/ajax_get_weekly_details', $data);
    }

    public function admin_generate_payment() {

        $recipients = array();
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $payment_type = $this->input->post('payment_type');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $daily_start_date = $this->input->post('daily_start_date');
        $daily_end_date = $this->input->post('daily_end_date');

        $month = $this->input->post('month');
        $year = date("Y");
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        if (isset($payment_type) && $payment_type == '') {
            $this->session->set_flashdata('error_msg', 'Payment Type field cannot be blank');
            redirect(base_url('admin-generate-invoice/' . base64_encode($employee_id)));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_code = $get_employee_details[0]['employee_code'];

            $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
            $code = ltrim($check_prev_generated_code[0]['invoice_code'], "INV");
            $invoice_code = "INV00" . ($code + 1);

            if ($payment_type == '1') {

                $check_date = $this->employee_model->getCheckDate($start_date, $end_date, $employee_id);
                //print_r($check_date);
                //                die;
                if ($check_date[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'admin-employee-list');
                }

                $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_employee_details[0]['employee_bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['weekly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
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
                    "updated_date" => date("Y-m-d h:i:s"),
                    "status" => "1"
                );
            } else if ($payment_type == '2') {

                $check_month = $this->employee_model->getCheckMonth($month, $year, $employee_id);
                if ($check_month[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'admin-employee-list');
                }

                $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);
                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_employee_details[0]['employee_bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['monthly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
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
                    "updated_date" => date("Y-m-d h:i:s"),
                    "status" => "1"
                );
            }
                //            echo "<pre>";
                //             print_r($insert_arr);
                //            die;

            $insert_query = $this->employee_model->generate_payment($insert_arr);

            if ($insert_query != '') {

                $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
                $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                if (!empty($get_admin_details)) {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = 'Successfully generated invoice for ' . ucwords($employee_name) . " [ " . $employee_code . " ]";
                $data['msg'] = $msg;

                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($get_sadmin_details[0]['sa_email']);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Invoice generated Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
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
                        "sender_id" => $admin_id,
                        "sender_type" => "admin",
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
                redirect(base_url() . 'admin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Invoice data not generated Successfully..');
                redirect(base_url() . 'admin-employee-list');
            }
        }
    }

    public function get_work_note() {

        $client_name = $this->input->post('client_name', TRUE);
        $data['get_work_note'] = $this->employee_model->getWorkNote($client_name);
        $this->load->view('admin/ajax/ajax_work_note', $data);
    }

    public function add_con_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url('admin')); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['get_consultant_lists'] = $this->employee_model->getConsultantLists();
        $data['page'] = "employee_lists";
        $data['meta_title'] = "ADD CONSULTANT TIMESHEET";
        $this->load->view('admin/add_con_timesheet', $data);
    }

    public function get_con_project_list() {
        $employee_id = $this->input->post('employee_id', TRUE);
        $data['get_project_list'] = $this->employee_model->getConProjectLists($employee_id);
        $this->load->view('admin/ajax/ajax_get_con_project_lists', $data);
    }

    public function ajax_con_timesheet_list() {

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

        $this->load->view('admin/ajax/ajax_get_con_timesheet_list', $data);
    }

    public function insert_new_con_timesheet() {
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
            redirect(base_url() . 'add-admin-con-timesheet');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-admin-con-timesheet');
        } else if (isset($end_date) && $end_date == '') {
            $this->session->set_flashdata('error_msg', 'End Date field cannot be blank');
            redirect(base_url() . 'add-admin-con-timesheet');
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
                redirect(base_url('admin_consultant_lists'));
            } else {
                $this->session->set_flashdata('error_msg', 'Timesheet not added Successfully.');
                redirect(base_url('admin_consultant_lists'));
            }
        }
    }

    public function add_emp_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url('admin')); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['get_employee_lists'] = $this->employee_model->getEmployeeListsbyType();
        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "ADD EMPLOYEE TIMESHEET";
        $this->load->view('admin/add_emp_timesheet', $data);
    }

    public function get_emp_project_list() {
        $employee_id = $this->input->post('employee_id', TRUE);
        $data['get_project_list'] = $this->employee_model->getEmpProjectLists($employee_id);
        $this->load->view('admin/ajax/ajax_get_emp_project_lists', $data);
    }

    public function ajax_emp_timesheet_list() {

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

        $this->load->view('admin/ajax/ajax_get_emp_timesheet_list', $data);
    }

    public function insert_new_emp_timesheet() {
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
            redirect(base_url() . 'add-admin-emp-timesheet');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-admin-emp-timesheet');
        } else if (isset($end_date) && $end_date == '') {
            $this->session->set_flashdata('error_msg', 'End Date field cannot be blank');
            redirect(base_url() . 'add-admin-emp-timesheet');
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
                redirect(base_url('admin-employee-list'));
            } else {
                $this->session->set_flashdata('error_msg', 'Timesheet not added Successfully.');
                redirect(base_url('admin-employee-list'));
            }
        }
    }

    public function con_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //$employee_type = "C";
        $get_employee_details = $this->employee_model->getConListForTimesheet();
        $ncon_str = "";
        $con_str = "";
        foreach ($get_employee_details as $cval) {
            $ncon_str .= $cval['employee_id'] . ",";
        }
        $con_str = rtrim($ncon_str, ",");
        //        echo "<pre>";
        //       echo $con_str;
        //       die; 

        if (US) {
            $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheetConsultant($con_str);
            $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheetConsultant($con_str);
            $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheetConsultant($con_str);
        }
        if (INDIA || LATAM) {
            $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet($con_str);
            $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet($con_str);
            $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet($con_str);
        }
        

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "CONSULTANT LISTS";
        $this->load->view('admin/admin_con_timesheet', $data);
    }

    public function emp_timesheet() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        //$employee_type = "E";
        
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "EMPLOYEE LISTS";
        $this->load->view('admin/admin_emp_timesheet', $data);
    }

    public function get_approved_timesheet_data_all() {

        $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet();

        echo json_encode($data['get_approved_timesheet_details']);
    }

    public function get_pending_timesheet_data_all() {

        $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet();

        echo json_encode($data['get_pending_timesheet_details']);
    }

    public function get_not_approved_timesheet_data_all() {

        $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet();

        echo json_encode($data['get_not_approved_timesheet_details']);
    }

    public function admin_historical_timesheet() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_historical_timesheet_data";
        $data['meta_title'] = "Admin Historical Timesheet";

        $this->load->view('admin/admin_historical_timesheet_data', $data);

    }

    public function admin_load_historical_timesheet() {

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

            $data['timesheet_status'] = $timesheet_status;
            if ($employee_type == "C") {

                $get_employee_details = $this->employee_model->getAllConsList();
                //$con_str = implode(",", $get_employee_details );
                $ncon_str = "";
                $con_str = "";
                foreach ($get_employee_details as $cval) {
                    $ncon_str .= $cval['employee_id'] . ",";
                }
                $con_str = rtrim($ncon_str, ",");

                $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $con_str, $timesheet_status);
                
                $this->load->view('admin/ajax/ajax_cons_historical_timesheet', $data);

            } else if ($employee_type == "E") {

                $get_employee_details = $this->employee_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ",");

                $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);

                $this->load->view('admin/ajax/ajax_emp_historical_timesheet', $data);
            } else if ($employee_type == "1099") {

                $get_employee_details = $this->ten99user_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ","); 
                
                $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);

                $this->load->view('admin/ajax/ajax_ten99_historical_timesheet', $data);
            }
        }
    }

    public function admin_view_period_manage_timesheet() {
        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }
            //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "TIMESHEET LISTS";

        $this->load->view('admin/admin_view_period_timesheet', $data);
    }

    public function manage_expense_request() {
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $tid = base64_decode("MTE=");
            $data['get_expense_employees'] = $this->employee_model->getExpenseEmployees();
            // echo "<pre>".print_r($data['get_expense_employees'],1)."</pre>";
            $data['page'] = "manage_expense_request";
            $data['meta_title'] = "TIMESHEET LISTS";

            $this->load->view('admin/manage_expense_request', $data);
        }
    }

    public function view_employee_all_expense() {
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            
            // $eid = base64_decode($this->uri->segment(2));
            // $getParticularEmployeeData = $this->employee_model->getParticularEmployeeData($eid);
            // $employee_name = $getParticularEmployeeData[0]['first_name']." ".$getParticularEmployeeData[0]['last_name'];
            // $employee_designation = $getParticularEmployeeData[0]['employee_designation'];

            // $this->session->set_userdata('expense_employee_name', $employee_name);
            // $this->session->set_userdata('expense_employee_designation', $employee_designation);
            // $this->session->set_userdata('expense_employee_id', $eid);

            // $data['get_employee_all_expense'] = $this->employee_model->get_employee_all_expense($eid);


            $data['get_employee_all_expense'] = $this->employee_model->get_all_expense();


            $data['page'] = "employee_all_expense";
            $data['meta_title'] = "EMPLOYEE ALL EXPENSE";

            $this->load->view('admin/all_employee_expense', $data);
        }
    }

    public function view_expense_form() {
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $expense_id = base64_decode($this->uri->segment(2));
            $data['expense_details'] = $this->employee_model->get_expense_details($expense_id);
            $data['expense_id'] = $expense_id;


            $eid = base64_decode($this->uri->segment(3));
            $getParticularEmployeeData = $this->employee_model->getParticularEmployeeData($eid);
            $employee_name = $getParticularEmployeeData[0]['first_name']." ".$getParticularEmployeeData[0]['last_name'];
            $employee_designation = $getParticularEmployeeData[0]['employee_designation'];

            $this->session->set_userdata('expense_employee_name', $employee_name);
            $this->session->set_userdata('expense_employee_designation', $employee_designation);
            $this->session->set_userdata('expense_employee_id', $eid);



            // echo "<pre>".print_r($data['get_employee_all_expense'],1)."</pre>";
            // exit;
            $data['page'] = "employee_all_expense";
            $data['meta_title'] = "EMPLOYEE ALL EXPENSE";

            $this->load->view('admin/view_expense_form', $data);
        }
    }

    public function view_expense_reciept() {

        // Code View File from S3 Bucket Start
        // $path = "demo/employee_onboarding/$id_first/$doc_id";
        $path = $this->input->post('path');
        require('assets/s3/autoload.php');
        $s3 = new Aws\S3\S3Client([
          'region'  => S3_REGION,
          'version' => 'latest',
          'credentials' => [
            'key'    => S3_KEY,
            'secret' => S3_SECRET,
          ]
        ]);
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'porosiq-demo',
            'Key'    => "$path"
        ]);
        $request = $s3->createPresignedRequest($cmd, '+5 minutes');
        $presignedUrl = (string) $request->getUri();
        echo "$presignedUrl";
        // Code View File from S3 Bucket End
      }

    public function update_admin_expense_approval_request() {
        if (US || INDIA) {
            $expense_id = $this->input->post('expense_id');
            // $directory_name = './tests/';
            // $file_name = "expense_pdf" . rand(00, 99) . ".pdf";

            // if (!file_exists($directory_name)) {
            //     mkdir($directory_name, 0777, true);
            // }

            // $sess_arr = $this->session->userdata('admin_logged_in');
            // $email = $sess_arr['email'];
            // $data['get_details'] = $this->profile_model->getDetails($email);
            // $data['expense_details'] = $this->employee_model->get_expense_details($expense_id);
            $data['is_approved'] = $this->input->post('approved_or_denied');
            $data['reason_for_approved_or_denied'] = $this->input->post('reason');
            $data['admin_signature'] = $this->input->post('signature');
            $data['approved_or_denied_date'] = $this->input->post('date');

            // $this->load->library('html2pdf');
            // $result = $this->load->view('admin/expense_pdf_template', $data, true);
            // $this->html2pdf->folder($directory_name);
            // $this->html2pdf->filename($file_name);
            // $this->html2pdf->paper('A4', 'portrait');
            // $this->html2pdf->html($result);

            // // $this->html2pdf->create('view_only');
            // $this->html2pdf->create('save');
            // if($path = $this->html2pdf->create('save')) {
            //     //PDF was successfully saved or downloaded
            //     echo 'PDF saved to: ' . $path;
            // }

            $update_arr = [
                'is_approved' => $this->input->post('approved_or_denied'),
                'reason_for_approved_or_denied' => $this->input->post('reason'),
                'admin_signature' => $this->input->post('signature'),
                'approved_or_denied_date' => $this->input->post('date'),
                // 'expense_pdf_name' => $file_name,
            ];

            $update_query = $this->employee_model->update_admin_expense($update_arr,$expense_id);

            $this->session->set_flashdata('succ_msg', 'Successfully Updated expense');

            // redirect(base_url('view_employee_all_expense/' . base64_encode($this->session->userdata('expense_employee_id'))));

            redirect(base_url('view_employee_all_expense'));
            // print_r($this->html2pdf->Output());
        }
    }

    public function get_expense_pdf() {
        $expense_id = base64_decode($this->input->post('expense_id'));

        $directory_name = './tests/';
        $file_name = "expense_pdf" . rand(00, 99) . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['expense_details'] = $this->employee_model->get_expense_details($expense_id);

        $eid = base64_decode($this->input->post('employee_id'));
        $getParticularEmployeeData = $this->employee_model->getParticularEmployeeData($eid);
        $employee_name = $getParticularEmployeeData[0]['first_name']." ".$getParticularEmployeeData[0]['last_name'];
        $employee_designation = $getParticularEmployeeData[0]['employee_designation'];

        $data['expense_employee_name'] = $employee_name;
        $data['expense_employee_designation'] = $employee_designation;

        $other_data = $this->employee_model->get_expense_by_id($expense_id);

        $data['is_approved'] = $other_data[0]['is_approved'];
        $data['reason_for_approved_or_denied'] = $other_data[0]['reason_for_approved_or_denied'];
        $data['admin_signature'] = $other_data[0]['admin_signature'];
        $data['approved_or_denied_date'] = $other_data[0]['approved_or_denied_date'];

        $this->load->library('html2pdf');
        $result = $this->load->view('admin/expense_pdf_template', $data, true);
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('A4', 'portrait');
        $this->html2pdf->html($result);

        // $this->html2pdf->create('view_only');
        $this->html2pdf->create('save');
        if($path = $this->html2pdf->create('save')) {
            //PDF was successfully saved or downloaded
            // echo 'PDF saved to: ' . $path;
            
            $update_arr = [
                'expense_pdf_name' => $file_name,
            ];

            $update_query = $this->employee_model->update_admin_expense($update_arr,$expense_id);


            echo base_url().$path;

        }
    }

    public function manage_payroll() {
        if (LATAM) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
            }
            //$db = get_instance()->db->conn_id;
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];
            // $data['payroll_data'] = $this->employee_model->get_payroll_data();
            // print_r($data['payroll_data']);
            // exit;
            $data['page'] = "manage_payroll";
            $data['meta_title'] = "MANAGE PAYROLL";

            $this->load->view('admin/manage_payroll', $data);
        }
    }

    public function get_payroll_data() {
        if (LATAM) {
            $payroll_data = $this->employee_model->get_payroll_data();
            $start_date = $this->input->post("start_date");
            $end_date = $this->input->post("end_date");
            $payroll_str = "";
            foreach ($payroll_data as $pd) {
                $employee_pay_rate = $pd['employee_pay_rate'];
                $daily_rate = number_format(intval($employee_pay_rate)/30, 2);
                $worked_days_except_holidays = 15-0;
                $gross_salary = number_format(($daily_rate*$worked_days_except_holidays)+((0*$daily_rate)*2)+((($daily_rate/8)*1.5)*(0)), 2);
                $ordinary_salary = $gross_salary;
                $cuota_patronal = number_format((26.50/100)*$ordinary_salary, 2);
                $labor_risk = number_format(0.01*$ordinary_salary, 2);
                $aguinaldo = number_format(0.0833*$ordinary_salary, 2);
                $vacations = number_format(0.0417*$ordinary_salary, 2);
                $social_cost = $cuota_patronal+$aguinaldo+$vacations+$labor_risk;
                $monthly_cost = $social_cost+$ordinary_salary;
                $vendor_fee = number_format(0.3*$monthly_cost, 2);
                $administ_fee = number_format(0.00*$monthly_cost, 2);
                $vat = number_format(0.00*$monthly_cost, 2);
                $cuota_obrera = number_format(0.105*$ordinary_salary, 2);
                $monthly_invoice = $ordinary_salary + $social_cost + $vendor_fee;
                $payroll_str .= "<tr><td>".$start_date."</td><td>".$end_date."</td><td>".$pd['first_name'].' '.$pd['last_name']."</td><td>".$pd['employee_designation']."</td><td>".$worked_days_except_holidays."</td><td><input type='number' class='holidays' value='0'></td><td><input type='number' class='ot_hours' value='0'></td><td><input type='number' value='0'></td><td><input type='number' value='0'></td><td><input type='number' value='0'></td><td>".$employee_pay_rate."</td><td>".$gross_salary."</td><td>".$monthly_invoice."</td><td>".$daily_rate."</td><td>".$ordinary_salary."</td><td>".$cuota_patronal."</td><td>".$aguinaldo."</td><td>".$vacations."</td><td>".$labor_risk."</td><td>".$social_cost."</td><td>".$monthly_cost."</td><td>".$vendor_fee."</td><td>".$administ_fee."</td><td>".$vat."</td><td>".$cuota_obrera."</td></tr>";
            }
            echo json_encode(['payroll_str' => $payroll_str]);
        }
    }

    public function store_payroll_table_data() {
        if (LATAM) {
            $Month = $this->input->post('Month');
            $Payroll = $this->input->post('Payroll');
            $Name = $this->input->post('Name');
            $Position = $this->input->post('Position');
            $Worked_days_except_holidays = $this->input->post('Worked_days_except_holidays');
            $Holidays = $this->input->post('Holidays');
            $OT_hours = $this->input->post('OT_hours');
            $Minus_hours = $this->input->post('Minus_hours');
            $Bonus = $this->input->post('Bonus');
            $Income_tax = $this->input->post('Income_tax');
            $Monthly_salary = $this->input->post('Monthly_salary');
            $Gross_salary = $this->input->post('Gross_salary');
            $Monthly_invoice = $this->input->post('Monthly_invoice');
            $Daily_rate = $this->input->post('Daily_rate');
            $Ordinary_salary = $this->input->post('Ordinary_salary');
            $Cuota_patronal = $this->input->post('Cuota_patronal');
            $Aguinaldo = $this->input->post('Aguinaldo');
            $Vacations = $this->input->post('Vacations');
            $Labor_risk = $this->input->post('Labor_risk');
            $Social_cost = $this->input->post('Social_cost');
            $Monthly_cost = $this->input->post('Monthly_cost');
            $Vendor_fee = $this->input->post('Vendor_fee');
            $Administ_fee = $this->input->post('Administ_fee');
            $Vat = $this->input->post('Vat');
            $Worker_quota = $this->input->post('Worker_quota');

            $insert_arr = [
                'month' => $Month,
                'payroll' => $Payroll,
                'name' => $Name,
                'position' => $Position,
                'worked_days_except_holidays' => $Worked_days_except_holidays,
                'holidays' => $Holidays,
                'ot_hours' => $OT_hours,
                'minus_hours' => $Minus_hours,
                'bonus' => $Bonus,
                'income_tax' => $Income_tax,
                'monthly_salary' => $Monthly_salary,
                'gross_salary' => $Gross_salary,
                'monthly_invoice' => $Monthly_invoice,
                'daily_rate' => $Daily_rate,
                'ordinary_salary' => $Ordinary_salary,
                'cuota_patronal' => $Cuota_patronal,
                'aguinaldo' => $Aguinaldo,
                'vacations' => $Vacations,
                'labor_risk' => $Labor_risk,
                'social_cost' => $Social_cost,
                'monthly_cost' => $Monthly_cost,
                'vendor_fee' => $Vendor_fee,
                'administ_fee' => $Administ_fee,
                'vat' => $Vat,
                'worker_quota' => $Worker_quota
            ];

            echo $this->employee_model->store_payroll_table_data($insert_arr);
        }
    }

    public function truncate_payroll_table_data() {
        if (LATAM) {
            $this->employee_model->truncate_payroll_table_data();
        }
    }

    public function manage_purchase_order() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin');
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_purchase_order_list'] = $this->employee_model->get_purchase_order_list();

        $data['page'] = "purchase_order_list";
        $data['meta_title'] = "PURCHASE ORDER";

        $this->load->view('admin/purchase_order_list', $data);
    }

    public function add_purchase_order_form() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin');
        }
        
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $get_vendors = $this->employee_model->getAllVendor();

        $data['vendors'] = $get_vendors;
        
        $data['page'] = "manage_purchase_order";
        $data['meta_title'] = "MANAGE PURCHASE ORDER";

        $this->load->view('admin/manage_purchase_order', $data);
    }

    public function insert_purchase_order() {

        $vendor_id = $this->input->post('vendor');
        $store = $this->input->post('store');
        $PONumber = $this->input->post('purchase_order_number');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $unit_price = $this->input->post('unit_price');
        $quantity = $this->input->post('quantity');
        $total = $this->input->post('total');
        $new_file_name = '';

        if ($_FILES['attachment']['name'] != '') {
            $file_name = $_FILES['attachment']['name'];
            $file_tmp = $_FILES['attachment']['tmp_name'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;

            $file_path = "./uploads/admin/supporting_doc/";
            
            if (!is_dir($file_path)) {
                mkdir($file_path, 0777, true);
            }

            move_uploaded_file($file_tmp, $file_path . $new_file_name);
        }

        // $directory_name = './purchase_orders/';
        // $file_name = "purchase_order" . rand(00, 99) . ".pdf";

        // if (!is_dir($directory_name)) {
        //     mkdir($directory_name, 0777, true);
        // }

        // $this->load->library('html2pdf');
        // $result = $this->load->view('admin/invoice_pdf_latest', $data, true);
        // $this->html2pdf->folder($directory_name);
        // $this->html2pdf->filename($file_name);
        // $this->html2pdf->paper('A4', 'portrait');
        // $this->html2pdf->html($result);

        // // $this->html2pdf->create('view_only');
        // $this->html2pdf->create('save');
        // if($path = $this->html2pdf->create('save')) {
        //     //PDF was successfully saved or downloaded
        //     echo 'PDF saved to: ' . $path;
        // }

        $insert_arr = array(
           'VendorID' => $vendor_id,
           'Store' => $store,
           'PONumber' => $PONumber,
           'Date' => $date,
           'Description' => $description,
           'UnitPrice' => $unit_price,
           'Quantity' => $quantity,
           'Total' => $total,
           'sdFilePath' => $new_file_name
        );

        $insert_id = $this->employee_model->insert_purchase_order($insert_arr);

        if ($insert_id) {
            $this->session->set_flashdata('succ_msg', 'Purchase Order Added Successfully');

            $purchase_order = [
                'vendor_id' => $vendor_id,
                'store' => $store,
                'PONumber' => $PONumber,
                'date' => $date,
                'description' => $description,
                'unit_price' => $unit_price,
                'quantity' => $quantity,
                'total' => $total
            ];

            $data['purchase_order'] = $purchase_order;

            $this->load->view('admin/invoice_pdf_latest', $data);
        }
        else {
            $this->session->set_flashdata('error_msg', 'Failed to add Purchase Order');
            redirect(base_url() . 'manage_purchase_order');
        }
    }

    public function show_purchase_order_pdf(){

        $vendor_id = 10;
        $store = 'agunalda';
        $PONumber = 12;
        $date = '10/03/1998';
        $description = 'test';
        $unit_price = 10;
        $quantity = 30;
        $total = 50;
        
        $purchase_order = [
            'vendor_id' => $vendor_id,
            'store' => $store,
            'PONumber' => $PONumber,
            'date' => $date,
            'description' => $description,
            'unit_price' => $unit_price,
            'quantity' => $quantity,
            'total' => $total
        ];

        $data['purchase_order'] = $purchase_order;

        $this->load->view('admin/invoice_pdf_latest', $data);
    }

    public function insert_invoice_payment_details() {

        $db = get_instance()->db->conn_id;



        $id = $this->input->post('id');
        $bank_name = $this->input->post('bank_name');
        $transaction_id = $this->input->post('transaction_id');
        $transaction_date = $this->input->post('transaction_date');

        $update_arr = array(

            'payment_status' => '1',
            'bank_name' => $bank_name,
            'transaction_id' => $transaction_id,
            'payment_date' => $transaction_date
        );

        $update_query = $this->employee_model->invoice_payment_details($update_arr,$id);

        if ($update_query = '1') {


                $this->session->set_flashdata('succ_msg', 'Payment Details Added Successfully..');
                redirect(site_url('admin_consultant_invoice'));
            } else {
                $this->session->set_flashdata('error_msg', 'Payment Details Not Added');
                redirect(site_url('admin_consultant_invoice') );
            }
    }

    public function show_admin_company_policy() {

        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['get_documents_details'] = $this->employee_model->show_company_policy_documents();

        $data['page'] = "admin_company_policy";
        $data['meta_title'] = "COMAPNY POLICY DOCUMENTS";
        $this->load->view('admin/admin_company_policy', $data);
    }

    public function load_add_company_policy_doc_page() {

        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "admin_add_company_policy";
        $data['meta_title'] = "ADD COMAPNY POLICY";
        $this->load->view('admin/add_company_policy_document', $data);
    }

    public function insert_company_policy_document() {
        $db = get_instance()->db->conn_id;

        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'add-admin-company-policy');
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
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
                //echo "<pre>";
                //print_r($file_errors);
                //die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-company-policy');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-admin-company-policy');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'document_name' => $document_name,
                'file' => $new_file_name,
                'entry_date' => date("Y-m-d"),
                'uploaded_by' => 'admin',
                'status' => '1'
            );

            $insert_query = $this->employee_model->insert_company_policy_document($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Company Policy Added Successfully');
                redirect(base_url() . 'admin-company-policy');
            } else {
                $this->session->set_flashdata('error_msg', 'Company Policy Not Added Successfully');
                redirect(base_url() . 'admin-company-policy');
            }
        }
    }
    
    public function show_requisition() {
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['requisition_list'] = $this->employee_model->get_requisition_list();
            $data['get_vendor'] = $this->employee_model->getVendorLists();
            if (US) {
                $data['is_hiring_manager'] = $data['get_details'][0]['is_hiring_manager'];
            }
            $data['page'] = "admin_requisition";
            $data['meta_title'] = "Requisition";
            $this->load->view('admin/admin_requisition', $data);
        }
    }

    public function view_specific_requisition() {
        
        if (US || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $req_id = base64_decode($this->uri->segment(2));

            $data['requistion_data'] = $this->employee_model->get_requisition_data($req_id);
            // echo "<pre>";
            // print_r($data['requistion_data']);
            $this->load->view('admin/view_specific_requisition_data', $data);
        }
    }

    public function add_requisition() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            if (US) {
                $data['get_client'] = $this->employee_model->getClientLists();
            }
            $data['page'] = "add_admin_requisition";
            $data['meta_title'] = "Add Requisition";
            $this->load->view('admin/add_admin_requisition', $data);
        }
    }   

    public function insert_requisition() {
        
        if (US || LATAM || INDIA) {
            $db = get_instance()->db->conn_id;

            $job_title = $this->input->post('job_title');
            $status = $this->input->post('status');
            if (US) {
                $candidate_type_arr = $this->input->post('candidate_type');
            }
            $job_category = $this->input->post('job_category');
            $department = $this->input->post('department');
            $number_of_openings = $this->input->post('number_of_openings');
            if (LATAM || INDIA) {
                $project_id = $this->input->post('project_id');
            }
            if (US) {
                $select_client = $this->input->post('select_client');
            }
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $employement_avilability = $this->input->post('employement_avilability');
            $employment_type = $this->input->post('employment_type');
            $pay_rate = $this->input->post('pay_rate');
            $pay_rate_type = $this->input->post('pay_rate_type');
            $bill_rate = $this->input->post('bill_rate');
            $bill_rate_type = $this->input->post('bill_rate_type');
            if (US) {
                $requirement_arr = $this->input->post('requirement');
                $visa_type_arr = $this->input->post('visa_type');

                $candidate_type = implode(",", $candidate_type_arr);
                $requirements = implode(", ", $requirement_arr);
                $visa_types = implode(", ", $visa_type_arr);
            }

            $job_description = mysqli_real_escape_string($db, $this->input->post('job_description'));
            $additional_information = mysqli_real_escape_string($db, $this->input->post('additional_information'));

            $admin_id = $this->input->post('admin_id');

            if (US) {
                $insert_arr = array(
                        'job_title' => $job_title,
                        'admin_id' => $admin_id,
                        'status' => $status,
                        'candidate_type' => $candidate_type,
                        'client_name' => $select_client,
                        'job_category' => $job_category,
                        'department' => $department,
                        'number_of_openings' => $number_of_openings,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'employement_avilability' => $employement_avilability,
                        'employment_type' => $employment_type,
                        'pay_rate' => $pay_rate,
                        'pay_rate_type' => $pay_rate_type,
                        'bill_rate' => $bill_rate,
                        'bill_rate_type' => $bill_rate_type,
                        'requirements' => $requirements,
                        'visa_types' => $visa_types,
                        'job_description' => $job_description,
                        'additional_information' => $additional_information,
                        'entry_date' => date("Y-m-d"),
                        
                    );
            }
            if (LATAM || INDIA) {
                $insert_arr = array(
                        'job_title' => $job_title,
                        'admin_id' => $admin_id,
                        'status' => $status,
                        'job_category' => $job_category,
                        'department' => $department,
                        'number_of_openings' => $number_of_openings,
                        'project_id' => $project_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'employement_avilability' => $employement_avilability,
                        'employment_type' => $employment_type,
                        'pay_rate' => $pay_rate,
                        'pay_rate_type' => $pay_rate_type,
                        'bill_rate' => $bill_rate,
                        'bill_rate_type' => $bill_rate_type,
                        'job_description' => $job_description,
                        'additional_information' => $additional_information,
                        'entry_date' => date("Y-m-d"),
                        
                    );
            }

            $insert_query = $this->employee_model->insert_requisition($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Requisition Added Successfully');
                redirect(base_url() . 'admin-requisition');
            } else {
                $this->session->set_flashdata('error_msg', 'Requisition Not Added Successfully');
                redirect(base_url() . 'admin-requisition');
            }
        }
    }

    public function assign_requisition_to_vendor() {
        if (LATAM) {
            $vendor_id = $this->input->post('vendor_id');
            $req_id = $this->input->post('req_id');

            $insert_arr = array(
                    'req_id' => $req_id,
                    'status' => "1",
                    'vendor_id' => $vendor_id,
                    'entry_date' => date("Y-m-d")
                    
                );
            
            $insert_query = $this->employee_model->assign_requisition_candidate($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Requisition Assigned To Vendor Successfully');
                redirect(base_url() . 'admin-requisition');
            } else {
                $this->session->set_flashdata('error_msg', 'Requisition Not Assigned To Vendor');
                redirect(base_url() . 'admin-requisition');
            }
        }
        if (US || INDIA) {
            $req_id = $this->input->post('req_id');
            $vendor_tier = $this->input->post('vendor_tier');

            $update_arr = array(
                    'vendor_tier' => $vendor_tier,
                );
            
            $update_query = $this->employee_model->assign_requisition_to_vendor($update_arr, $req_id);

            if ($update_query == 1) {

                $this->session->set_flashdata('succ_msg', 'Requisition Assigned To Vendors Successfully');
                redirect(base_url() . 'admin-requisition');
            } else {
                $this->session->set_flashdata('error_msg', 'Requisition Not Assigned To Vendors');
                redirect(base_url() . 'admin-requisition');
            }
        }
    }

    public function add_requisition_to_vendor() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $data['page'] = "add_requisition_to_vendor";
            $data['meta_title'] = "Add Requisition To Vendor";
            $this->load->view('admin/add_requisition_to_vendor', $data);
        }
    }

    public function requisition_vendor_list() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $data['page'] = "admin_requisition_vendor_list";
            $data['meta_title'] = "Requisition Vendor List";
            $this->load->view('admin/admin_requisition_vendor_list', $data);
        }
    }

    public function requisition_candidate_list() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            if (US) {
                $data['is_hiring_manager'] = $data['get_details'][0]['is_hiring_manager'];

                $data['req_id'] = base64_decode($this->uri->segment(2));
                //$data['req_data'] = $this->employee_model->get_requisition_data($req_id);
                
                $data['candidate_list'] = $this->employee_model->get_requisition_candidate_list($data['req_id']);
            }
            
            $data['page'] = "admin_requisition_candidate_list";
            $data['meta_title'] = "Requisition Candidate List";
            $this->load->view('admin/admin_requisition_candidate_list', $data);
        }
    }

    public function requisition_add_candidate() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            if (US) {
                $data['req_id'] = base64_decode($this->uri->segment(2));
                $req_data = $this->employee_model->get_requisition_data($data['req_id']);
                $data['required_candidate_type'] = $req_data[0]['candidate_type'];
            }

            $data['page'] = "admin_add_requisition_candidate";
            $data['meta_title'] = "Requisition Candidate List";
            $this->load->view('admin/admin_add_requisition_candidate', $data);
        }
    }

    public function requisition_insert_candidate() {
        
        if (US || LATAM || INDIA) {
            $db = get_instance()->db->conn_id;
            $req_id = $this->input->post('req_id');
            $source = $this->input->post('source');
            $prefix = $this->input->post('name_prefix');
            $candidate_type = $this->input->post('candidate_type');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $classification = $this->input->post('req_classification');
            $category = $this->input->post('req_category');
            $designation = $this->input->post('designation');
            $address = mysqli_real_escape_string($db, $this->input->post('address'));
            $phone_number = $this->input->post('phone_number');
            $email = $this->input->post('email');
            $notice_period = $this->input->post('notice_period');
            $interview_date = $this->input->post('interview_date');
            $pay_rate = $this->input->post('pay_rate');
            $pay_rate_type = $this->input->post('pay_rate_type');
            $bill_rate = $this->input->post('bill_rate');
            $bill_rate_type = $this->input->post('bill_rate_type');
            $comment = mysqli_real_escape_string($db, $this->input->post('comment'));
            $added_by_id = $this->input->post('admin_id');

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

                    move_uploaded_file($file_tmp, "./uploads/req_candidates_image/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'admin-add-requisition-candidate/' . base64_encode($requisition['req_id']));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'admin-add-requisition-candidate/' . base64_encode($req_id));
                    }
                }
            } else {
                $new_file_name = "";
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
                $resume_expensions = array("pdf");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/req_candidates_resume/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'admin-add-requisition-candidate/' . base64_encode($requisition['req_id']));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'admin-add-requisition-candidate/' . base64_encode($req_id));
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            $insert_arr = array(
                'req_id' => $req_id,
                'added_by_user_type' => 'admin',
                'added_by_id' => $added_by_id,
                'candidate_type' => $candidate_type,
                'prefix' => $prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'source' => $source,
                'phone_num' => $phone_number,
                'email' => $email,
                'address' => $address,
                'classification' => $classification,
                'category' => $category,
                'designation' => $designation,
                'candidate_image' => $new_file_name,
                'resume' => $new_resume_file_name,
                'notice_period' => $notice_period,
                'interview_date' => $interview_date,
                'pay_rate' => $pay_rate,
                'pay_rate_type' => $pay_rate_type,
                'bill_rate' => $bill_rate,
                'bill_rate_type' => $bill_rate_type,
                'comment' => $comment,
                'entry_date' => date("Y-m-d"),
                
            );

        $insert_query = $this->employee_model->insert_requisition_candidate($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Requisition Added Successfully');
                redirect(base_url() . 'admin-requisition-candidate-list/' . base64_encode($requisition['req_id']));
            } else {
                $this->session->set_flashdata('error_msg', 'Requisition Not Added Successfully');
                redirect(base_url() . 'admin-add-requisition-candidate/' . base64_encode($requisition['req_id']));
            }
        }

    }

    public function requisition_view_candidate() {
        
        if (US || LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);           
            
            if (US) {
                $data['candidate_id'] = base64_decode($this->uri->segment(2));

                $get_req_candidate_details = $this->employee_model->get_requisition_candidate_details($data['candidate_id']);
                $data['candidate_image'] = $get_req_candidate_details[0]['candidate_image'];
                $data['resume'] = $get_req_candidate_details[0]['resume'];
                $data['full_name'] = $get_req_candidate_details[0]['prefix'] . " " . $get_req_candidate_details[0]['first_name'] . " " . $get_req_candidate_details[0]['last_name'];
                $data['classification'] = $get_req_candidate_details[0]['classification'];
                $data['category'] = $get_req_candidate_details[0]['category'];
                $data['designation'] = $get_req_candidate_details[0]['designation'];

                if (!empty($get_req_candidate_details[0]['status'])) {
                $data['status'] = $get_req_candidate_details[0]['status'];
                } else {
                $data['status'] = "-";
                }

                $data['phone_num'] = $get_req_candidate_details[0]['phone_num'];

                if (!empty($get_req_candidate_details[0]['notice_period'])) {
                    $data['notice_period'] = $get_req_candidate_details[0]['notice_period'];
                } else {
                $data['notice_period'] =  "";
                }

                if (empty($get_req_candidate_details[0]['interview_date'])) {
                    $data['interview_date'] = "";

                } else {
                    $data['interview_date'] = date("m/d/Y", strtotime($get_req_candidate_details[0]['interview_date']));
                }

                if (empty($get_req_candidate_details[0]['address'])) {
                    $data['address'] = "";

                } else {
                    $data['address'] = $get_req_candidate_details[0]['address'];
                }

                $data['pay_rate'] = $get_req_candidate_details[0]['pay_rate'];
                $data['pay_rate_type'] = $get_req_candidate_details[0]['pay_rate_type'];
                $data['bill_rate'] = $get_req_candidate_details[0]['bill_rate'];
                $data['bill_rate_type'] = $get_req_candidate_details[0]['bill_rate_type'];
                
                if (empty($get_req_candidate_details[0]['comment'])) {
                    $data['comment'] = "";
                } else {
                    $data['comment'] = $get_req_candidate_details[0]['comment'];
                }

                unset($get_req_candidate_details);  //Unsetting Local variables for better memory managment
            
            }
            $data['page'] = "admin_view_requisition_candidate";
            $data['meta_title'] = "View Requisition Candidate";
            $this->load->view('admin/admin_view_requisition_candidate', $data);
        }
    }

    public function add_paid_stuff() {

        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_employee_lists'] = $this->employee_model->getEmployeeListsbyType();

        $data['page'] = "admin_add_paid_stuff";
        $data['meta_title'] = "Add Paid Stuff Document";
        $this->load->view('admin/admin_add_paid_stuff', $data);
    }

    public function insert_paid_stuff_document() {

        $db = get_instance()->db->conn_id;

        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        $employee_id = $this->input->post('employee_id');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'admin-add-paid-stuff');
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
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
                //echo "<pre>";
                //print_r($file_errors);
                //die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'admin-add-paid-stuff');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'admin-add-paid-stuff');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'employee_id' => $employee_id,
                'year' => $year,
                'month' => $month,
                'document_name' => $document_name,
                'file' => $new_file_name,
                'insert_date' => date("Y-m-d"),
                'uploaded_by' => 'admin',
                'status' => '1'
            );

            $insert_query = $this->employee_model->insert_paid_stuff_document($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Paid Stuff Added Successfully');
                redirect(base_url() . 'admin-add-paid-stuff');
            } else {
                $this->session->set_flashdata('succ_msg', 'Paid Stuff Added Successfully');
                redirect(base_url() . 'admin-add-paid-stuff');
            }
        }
    }

    public function add_w2() {

        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_employee_lists'] = $this->employee_model->getEmployeeListsbyType();

        $data['page'] = "admin_add_w2";
        $data['meta_title'] = "Add w2 Document";
        $this->load->view('admin/admin_add_w2', $data);
    }

    public function insert_w2_document() {

        $db = get_instance()->db->conn_id;

        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        $employee_id = $this->input->post('employee_id');
        $year = $this->input->post('year');

        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            if (INDIA) {
                redirect(base_url() . 'admin-add-tax');
            }
            if (US || LATAM) {
                redirect(base_url() . 'admin-add-w2');
            }
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
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
                //echo "<pre>";
                //print_r($file_errors);
                //die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        if (INDIA) {
                            redirect(base_url() . 'admin-add-tax');
                        }
                        if (US || LATAM) {
                            redirect(base_url() . 'admin-add-w2');
                        }
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        if (INDIA) {
                            redirect(base_url() . 'admin-add-tax');
                        }
                        if (US || LATAM) {
                            redirect(base_url() . 'admin-add-w2');
                        }
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'employee_id' => $employee_id,
                'year' => $year,
                'document_name' => $document_name,
                'file' => $new_file_name,
                'insert_date' => date("Y-m-d"),
                'uploaded_by' => 'admin',
                'status' => '1'
            );

            $insert_query = $this->employee_model->insert_w2_document($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'W2 Document Added Successfully');
                if (INDIA) {
                    redirect(base_url() . 'admin-add-tax');
                }
                if (US || LATAM) {
                    redirect(base_url() . 'admin-add-w2');
                }
            } else {
                $this->session->set_flashdata('succ_msg', 'W2 Document Added Successfully');
                if (INDIA) {
                    redirect(base_url() . 'admin-add-tax');
                }
                if (US || LATAM) {
                    redirect(base_url() . 'admin-add-w2');
                }
            }
        }
    }

    public function view_emp_paid_stuff_and_w2() {

        if (!$this->session->userdata('admin_logged_in')) {
            if (LATAM) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }
            if (US || INDIA) {
                redirect(base_url()); // the user is not logged in, redirect them!
            }
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_w2_details'] = $this->employee_model->load_w2($employee_id);
        $data['get_documents_details'] = $this->employee_model->load_paid_stuff($employee_id);
        $data['page'] = "admin_view_emp_paid_stuff_and_w2";
        $data['meta_title'] = "View Paid Stuff & W2";
        $this->load->view('admin/admin_view_emp_paid_stuff_and_w2', $data);         
    }

    public function admin_manage_documents() {
        if (LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $data['get_documents_details'] = $this->employee_model->getDocumentsLists();

            $data['page'] = "admin_manage_documents";
            $data['meta_title'] = "DOCUMENTS";
            $this->load->view('admin/admin_manage_documents', $data);
        }
    }

    public function admin_add_cons_document() {
        if (LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $data['page'] = "admin_add_consultant_document";
            $data['meta_title'] = "ADD DOCUMENT";
            $this->load->view('admin/admin_add_consultant_document', $data);
        }
    }

    public function insert_admin_documentation_form() {
        if (LATAM || INDIA) {
            $db = get_instance()->db->conn_id;

            $required_for_arr = $this->input->post('required_for');
            $required_for = implode(",", $required_for_arr);
            //$doc_type = $this->input->post('doc_type');
            // echo $required_for;
            // die;
            $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
            if (isset($document_name) && $document_name == '') {
                $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
                redirect(base_url() . 'admin-add-cons-emp-documents');
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
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
                    //echo "<pre>";
                    //print_r($file_errors);
                    //die;
                    if (empty($file_errors)) {

                        move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'admin-add-cons-emp-documents');
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'admin-add-cons-emp-documents');
                        }
                    }
                } else {
                    $new_file_name = "";
                }

                /* ---------------Resume-------------- */

                $insert_arr = array(
                    'document_name' => $document_name,
                    'required_for' => $required_for,
                    'file' => $new_file_name,
                    'entry_date' => date("Y-m-d"),
                );

                $insert_query = $this->employee_model->add_consultants_documents($insert_arr);

                if ($insert_query != '') {

                        $email_list = $this->employee_model->send_new_doc_email($required_for);

                        $msg = "Hi,<br> please submit the " . $document_name . " document by logging in into your dashboard.";
                        $data['msg'] = $msg;
                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;

                        $this->load->library('email');
                        


                        foreach ($email_list as $users_email) {

                            $this->email->from($from_email);
                            $this->email->to($users_email['employee_email']);
                            $this->email->bcc(SUPERADMIN_EMAIL);
                            $this->email->subject('Please Submit New Document');
                            $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));

                            $this->email->set_mailtype('html');

                            $this->email->send();
                        }
                        
                    $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                    redirect(base_url() . 'admin-manage-documents');
                } else {
                    $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                    redirect(base_url() . 'admin-manage-documents');
                }
            }
        }
    }

    public function admin_edit_cons_emp_document_page() {
        if (LATAM || INDIA) {
            if (!$this->session->userdata('admin_logged_in')) {
                redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
            }

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);

            $doc_id = base64_decode($this->uri->segment(2));
            $data['get_doc_details'] = $this->employee_model->getConsultantDocsDetails($doc_id);

            $data['page'] = "admin_edit_cons_emp_document";
            $data['meta_title'] = "EDIT DOCUMENT";
            $this->load->view('admin/admin_edit_cons_emp_document', $data);
        }
    }

    public function admin_update_cons_emp_document() {
        if (LATAM || INDIA) {
            $db = get_instance()->db->conn_id;

            $doc_id = base64_decode($this->input->post('doc_id'));

            $required_for_arr = $this->input->post('required_for');
            $required_for = implode(",", $required_for_arr);
            //        echo $required_for;
            //        die;
            $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));

            $get_doc_details = $this->employee_model->getConsultantDocsDetails($doc_id);

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
                    $file_path = "./uploads/";
                    $path = $file_path . $get_doc_details[0]['file'];
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $errors[] = "'File size must be exactly 2 MB";
                        redirect(base_url() . 'admin-edit-cons-emp-document/' . base64_encode($doc_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'admin-edit-cons-emp-document/' . base64_encode($doc_id));
                    }
                }
            } else {
                $new_file_name = $get_doc_details[0]['file'];
            }

            $update_arr = array(
                'document_name' => $document_name,
                'required_for' => $required_for,
                'file' => $new_file_name
            );

            $update_query = $this->employee_model->update_cons_emp_docs($update_arr, $doc_id);

            if ($update_query != '0') {
                $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
                redirect(base_url() . 'admin-manage-documents');
            } else {
                $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
                redirect(base_url() . 'admin-manage-documents');
            }
        }
    }

    public function upload_historical_approved_work_order() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "admin_upload_historical_wo";
        $data['meta_title'] = "Historical Approved Work Order";
        $this->load->view('admin/admin_upload_historical_wo', $data);
    }

    public function insert_historical_approved_work_order() {


        $employee_id = $this->input->post('employee_id');
        $final_approval_date = $this->input->post('final_approval_date');
        $check_duplicate_date = $this->employee_model->check_final_approval_date($employee_id, $final_approval_date);
        // echo "<pre>";
        // print_r($check_duplicate_date);
        // exit;
        if (isset($final_approval_date) && $final_approval_date == '') {

            $this->session->set_flashdata('error_msg', 'Final Approval Date cannot be blank');
            redirect(base_url() . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));

        } else if (!empty($check_duplicate_date)) {

            $this->session->set_flashdata('error_msg', 'You cannot upload another WO PDF for this approval date as there is already one WO PDF already uploaded for this date. Please either select a new approval date or delete the old historical WO PDF.');
            redirect(base_url() . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));

        }else {


            if ($_FILES['file']['name'] != '') {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
                //print_r($file_ext_arr);

                if (LATAM) {
                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                }
                if (US || INDIA) {
                    $new_file_name = $employee_id . '-' . time() . rand(00, 99) . '.' . $file_ext;
                }
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
                // echo "<pre>";
                // print_r($file_errors);
                // die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/historical_work_order/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url()  . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'employee_id' => $employee_id,
                'file' => $new_file_name,
                'final_approval_date' => $final_approval_date,
                'upload_date' => date("Y-m-d"),
                'uploaded_by' => 'admin',
            );

            $insert_query = $this->employee_model->insert_historical_approved_work_order($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Historical Work Order Added Successfully');
                if (LATAM) {
                    redirect(base_url() . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));
                }
                if (US || INDIA) {
                    redirect(base_url() . 'admin_consultant_lists');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Something went wrong. Please try again.');
                redirect(base_url() . 'admin-upload-historical-approved-work-order/' . base64_encode($employee_id));
            }
        }
    }

    public function historical_approved_work_order_list() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url(). 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['historical_wo_list'] = $this->employee_model->historical_approved_work_order_list($employee_id);
        
        $data['page'] = "historical_approved_wo_list";
        $data['meta_title'] = "Historical Approved Work Order List";
        $this->load->view('admin/historical_approved_wo_list', $data);
    }

}
