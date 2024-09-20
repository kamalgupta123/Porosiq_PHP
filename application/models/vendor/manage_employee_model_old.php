<?php

Class Manage_Employee_Model extends CI_Model {

    public function add_employee_user($data) {
        $this->db->insert('vms_employee_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_work_order($data) {
        $this->db->insert('vms_employee_work_order', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function generate_invoice($data) {
        $this->db->insert('vms_payment_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_projects($data) {
        $this->db->insert('vms_project_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_assign_projects($data) {
        $this->db->insert('vms_assign_projects_to_employee', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function generate_login_details($data) {
        $this->db->insert('vms_employee_login_details', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_employee_user($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_login_details($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_work_order($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_work_order', $data);
//        echo $this->db->last_query();
//        die;

        return $this->db->affected_rows();
    }

    public function checkWorkOrderStatus($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_projects($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_project_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_tasks($data, $tasks_id) {
        $this->db->where('tasks_id', $tasks_id);
        $this->db->update('vms_tasks_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_block_status($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_status($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkDuplicate($email) {
        $mails_arr = array();
        $this->db->select('distinct(sa_email)');
        $this->db->from('vms_superadmin_master');
        $this->db->like('sa_email', $email);
        $superadmin_query = $this->db->get();

        $this->db->select('distinct(admin_email)');
        $this->db->from('vms_admin_master');
        $this->db->like('admin_email', $email);
        $admin_query = $this->db->get();

        $this->db->select('distinct(vendor_email)');
        $this->db->from('vms_vendor_master');
        $this->db->like('vendor_email', $email);
        $vendor_query = $this->db->get();

        $this->db->select('distinct(consultant_email)');
        $this->db->from('vms_employee_login_details');
        $this->db->like('consultant_email', $email);
        $employee_query = $this->db->get();

        $superadmin_email = array();
        $admin_email = array();
        $vendor_email = array();
        $employee_email = array();

        if ($superadmin_query->num_rows() > 0) {

            foreach ($superadmin_query->result() as $superadmin_row) {
                $superadmin_email[] = $superadmin_row->sa_email;
            }
        }

        if ($admin_query->num_rows() > 0) {
            foreach ($admin_query->result() as $admin_row) {
                $admin_email[] = $admin_row->admin_email;
            }
        }

        if ($vendor_query->num_rows() > 0) {

            foreach ($vendor_query->result() as $vendor_row) {
                $vendor_email[] = $vendor_row->vendor_email;
            }
        }

        if ($employee_query->num_rows() > 0) {

            foreach ($employee_query->result() as $employee_row) {
                $employee_email[] = $employee_row->employee_email;
            }
        }


        if (!empty($superadmin_email) || !empty($admin_email) || !empty($vendor_email) || !empty($employee_email)) {
            $mails_arr = array_unique(array_merge($superadmin_email, $admin_email, $vendor_email, $employee_email));
        }

        if (in_array($email, $mails_arr)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getWorkOrder($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function check_prev_assign($project_name, $employee_name) {

        $condition = "project_id = '" . $project_name . "' and employee_id = '" . $employee_name . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkWorkOrder($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeLists() {

        //$condition = "1=1";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        //$this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkDetails($employee_id) {

        //$condition = "1=1";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        //$this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkDetailsByEmp($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectTypeLists() {

        //$condition = "1=1";
        $this->db->select('*');
        $this->db->from('vms_project_type_master');
        //$this->db->where($condition);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignedEmpoyees($vendor_id, $project_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and project_id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeProjects($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeData($id) {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeIDbyName($employee_name) {

        $condition = "employee_name = '" . trim($employee_name) . "'";
        $this->db->select('employee_id');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeIDbyCode($employee_code) {

        $condition = "employee_code = '" . trim($employee_code) . "'";
        $this->db->select('employee_id');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectData($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorName($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetails($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminDetails($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectLists() {

        //$condition = "1=1";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        //$this->db->where($condition);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeListsByVendor($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectListsByVendor($vendor_id) {

        $condition = "FIND_IN_SET('" . $vendor_id . "', vendor_id)";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getTasksListsByProject($project_id) {

        $condition = "project_id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_tasks_master');
        $this->db->where($condition);
//        $this->db->order_by("id","desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_tasks($data) {
        $this->db->insert('vms_tasks_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getTaskData($tasks_id) {

        $condition = "tasks_id = '" . $tasks_id . "'";
        $this->db->select('*');
        $this->db->from('vms_tasks_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCountEmployeesByProjects($project_id) {

        $condition = "project_id = '" . $project_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        // $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetData($project_id, $employee_id) {

        $condition = "project_id = '" . $project_id . "' and employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->order_by("entry_date", "asc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function changeTimesheetStatus($data, $timesheet_id) {
        $this->db->where('id', $timesheet_id);
        $this->db->update('vms_project_timesheet_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkGenerateStatus($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCheckDate($start_date, $end_date, $employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and start_date = '" . $start_date . "' and end_date = '" . $end_date . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//       echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getCheckMonth($month, $year, $employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and month = '" . $month . "' and year = '" . $year . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getWeeklyTimesheet($start_date, $end_date, $employee_id) {
        $times = array();
        $otimes = array();
        $times_arr = array();
        $condition = "employee_id = '" . $employee_id . "' and (project_date between '" . $start_date . "' and '" . $end_date . "' ) and approved_by_admin = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();

        foreach ($data as $tval) {
            $times[] = $tval['tot_time'];
            $otimes[] = $tval['over_time'];
        }
        $hours = "";
        $minutes = "";
        foreach ($times as $time) {
            $t_arr = explode(' ', $time);
            $minutes += $t_arr[0] * 60;
        }

        $hours = floor($minutes / 60);

        $ohours = "";
        $ominutes = "";
        foreach ($otimes as $otime) {
            $o_arr = explode(' ', $otime);
            $ominutes += $o_arr[0] * 60;
        }

        $ohours = floor($ominutes / 60);

        $times_arr['st'] = $hours;
        $times_arr['ot'] = $ohours;
        $times_arr['weekly_work_duration'] = count($data);
//        echo "<pre>";
//        print_r($times_arr);
//        die;
        return $times_arr;
    }

    public function getDailyTimesheet($start_date, $end_date, $employee_id) {
        $times = array();
        $otimes = array();
        $times_arr = array();
        $condition = "employee_id = '" . $employee_id . "' and (project_date between '" . $start_date . "' and '" . $end_date . "' ) and approved_by_admin = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();

        $data = $query->result_array();

        foreach ($data as $tval) {
            $times[] = $tval['tot_time'];
            $otimes[] = $tval['over_time'];
        }
        $hours = "";
        $minutes = "";
        foreach ($times as $time) {
            $t_arr = explode(' ', $time);
            $minutes += $t_arr[0] * 60;
        }

        $hours = floor($minutes / 60);

        $ohours = "";
        $ominutes = "";
        foreach ($otimes as $otime) {
            $o_arr = explode(' ', $otime);
            $ominutes += $o_arr[0] * 60;
        }

        $ohours = floor($ominutes / 60);

        $times_arr['st'] = $hours;
        $times_arr['ot'] = $ohours;
        $times_arr['daily_work_duration'] = count($data);
//        echo "<pre>";
//        print_r($times_arr);
//        die;
        return $times_arr;
    }

    public function getMonthlyTimesheet($month, $year, $employee_id) {
        $times = array();
        $otimes = array();
        $times_arr = array();

        $tot_time = 0;
        $over_time = 0;
        $condition = "employee_id = '" . $employee_id . "' and YEAR(project_date) = '" . $year . "' and MONTH(project_date) = '" . $month . "' and approved_by_admin = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();

        foreach ($data as $tval) {
//            $times[] = $tval['tot_time'];
//            $otimes[] = $tval['over_time'];
            $tot_time = $tot_time + $tval['tot_time'];
            $over_time = $over_time + $tval['over_time'];
        }
//        $hours = "";
//        $minutes = "";
//        foreach ($times as $time) {
//            $t_arr = explode(' ', $time);
//            $minutes += $t_arr[0] * 60;
//        }
//
//        $hours = floor($minutes / 60);
//
//        $ohours = "";
//        $ominutes = "";
//        foreach ($otimes as $otime) {
//            $o_arr = explode(' ', $otime);
//            $ominutes += $o_arr[0] * 60;
//        }
//
//        $ohours = floor($ominutes / 60);

        $times_arr['st'] = $tot_time;
        $times_arr['ot'] = $over_time;
        $times_arr['monthly_work_duration'] = count($data);
//        echo "<pre>";
//        print_r($times_arr);
//        die;
        return $times_arr;
    }

    public function generate_payment($data) {
        $this->db->insert('vms_payment_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getPaymentDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getSearchData($search_data) {
        $condition = "1 = 1";

        if ($search_data['search_by_emp_code'] != "") {
            $get_employee_id = $this->getEmployeeIDbyCode($search_data['search_by_emp_code']);
            $condition .= " AND employee_id = '" . $get_employee_id[0]['employee_id'] . "'";
        }
        if ($search_data['search_by_payment_mode'] != "") {
            $condition .= " AND payment_type = '" . $search_data['search_by_payment_mode'] . "'";
        }
        if ($search_data['search_by_start_date'] != "") {
            $condition .= " AND start_date >= '" . $search_data['search_by_start_date'] . "'";
        }
        if ($search_data['search_by_end_date'] != "") {
            $condition .= " AND end_date <= '" . $search_data['search_by_end_date'] . "'";
        }
        if ($search_data['search_by_month'] != "") {
            $condition .= " AND month = '" . $search_data['search_by_month'] . "'";
        }
        if ($search_data['search_by_year'] != "") {
            $condition .= " AND year = '" . $search_data['search_by_year'] . "'";
        }

        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeCode($employee_code, $vendor_id) {
        $this->db->select('distinct(employee_code)');
        $this->db->from('vms_employee_master');
        $this->db->where('vendor_id', $vendor_id);
        $this->db->like('employee_code', $employee_code);
        $query = $this->db->get();
//echo $this->db->last_query();
//        die;
        if ($query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();

            foreach ($query->result() as $row) {
                $data['message'][] = array(
                    //'label' => $row->employee_code,
                    'value' => $row->employee_code
                );
            }
        } else {
            $data['response'] = 'false'; //Set false if user not valid
        }
        return $data;
    }

    public function checkTimesheet($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getPaymentDetailsbyEmp($employee_id, $payment_type) {

        $condition = "employee_id = '" . $employee_id . "' and payment_type = '" . $payment_type . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getPaymentDetailsByInvoice($invoice_id) {

        $condition = "id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getPaymentComments($invoice_id) {

        $condition = "invoice_id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkInvoice($employee_id, $payment_type) {

        $condition = "employee_id = '" . $employee_id . "' and payment_type = '" . $payment_type . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getPrevGeneratedCode() {

        $this->db->select('invoice_code');
        $this->db->from('vms_payment_master');
        $this->db->limit(1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkInvoiceStatus($employee_id, $payment_type) {

        $condition = "employee_id = '" . $employee_id . "' and payment_type = '" . $payment_type . "'";
        $this->db->select('status');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkInvoiceStatusVendor($invoice_id) {

        $condition = "id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getWorkingDays($payment_type, $start_date, $end_date, $employee_id) {
        $condition = "1 = 1 AND approved_by_admin = '1' ";

        if ($payment_type == '1' || $payment_type == '3') {
            if ($start_date != "") {
                $condition .= " AND project_date >= '" . $start_date . "'";
            }
            if ($end_date != "") {
                $condition .= " AND project_date <= '" . $end_date . "'";
            }
        }

        $condition .= " AND employee_id = '" . $employee_id . "'";

        $this->db->select('project_date,tot_time,over_time');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getWorkingDaysMonthly($payment_type, $month, $year, $employee_id) {
        $condition = "1 = 1";

        if ($payment_type == '2') {
            if ($month != "" && $year != "") {
                $condition .= " AND YEAR(project_date) = '" . $year . "' and MONTH(project_date) = '" . $month . "' AND approved_by_admin = '1'";
            }
        }

        $condition .= " AND employee_id = '" . $employee_id . "'";

        $this->db->select('project_date,tot_time,over_time');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkCount($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getLoginDetails($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploadedDetails($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAllFiles() {

//        $condition = "consultant_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getFiles($consultant_id) {

        $condition = "consultant_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getDocsDetails($doc_id) {

        $condition = "id = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploaded($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function add_employee_documents($data) {
        $this->db->insert('vms_consultant_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function deletePreviousDocs($form_name, $employee_id) {
        $condition = "form_name = '" . trim($form_name) . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_consultant_files');
        return 1;
    }

    public function checkApproveStatus($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignProjectDtls($employee_id, $vendor_id) {

        $condition = "employee_id = '" . $employee_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_payment_mail($data) {
        $this->db->insert('vms_payment_mail_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getWorkNote($client_name) {

        $condition = "id = '" . $client_name . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsByEmp($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsnotapprove($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailspending($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '2'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTotalST($timesheet_id) {

        $condition = "timesheet_period_id = '" . $timesheet_id . "'";
        $this->db->select('sum(tot_time) as tot_time');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTotalOT($timesheet_id) {

        $condition = "timesheet_period_id = '" . $timesheet_id . "'";
        $this->db->select('sum(over_time) as over_time');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsByID($tid) {

        $condition = "id = '" . $tid . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetPeriodDetails($tid) {

        $condition = "timesheet_period_id = '" . $tid . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPeriodDetails($timesheet_period_id) {

        $condition = "id = '" . $timesheet_period_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function generateTimesheetInvoice($data) {
        $this->db->insert('vms_payment_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function checkGenInvoice($timesheet_period_id) {

        $condition = "timesheet_period_id = '" . $timesheet_period_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceCodeByID($timesheet_id, $vendor_id) {

        $condition = "timesheet_period_id = " . $timesheet_id . " and vendor_id = " . $vendor_id . "";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
//        echo $this->db->last_query();
//        die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getRequisitionList($vendor_tier) {

        /*$condition = "vms_requisition_vendors.vendor_id = '" . $vendor_id . "'";
        $this->db->_protect_identifiers = FALSE;
        $this->db->select('*');
        $this->db->from('vms_requisition_master');
        $this->db->join('vms_requisition_vendors', 'vms_requisition_master.req_id = vms_requisition_vendors.req_id', 'inner');
        $this->db->where($condition);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        $data = $query->result_array();
        return $data;*/
        $condition = "";

        if ($vendor_tier == "1") {
            $condition = "vendor_tier IN (1, 2, 3) AND candidate_type LIKE '%Consultant%'";

        } else if ($vendor_tier == "2") {
            $condition = "vendor_tier IN (2, 3) AND candidate_type LIKE '%Consultant%'";

        } else if ($vendor_tier == "3") {
            $condition = "vendor_tier = '3' AND candidate_type LIKE '%Consultant%'";
        }

        $this->db->select('*');
        $this->db->from('vms_requisition_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function final_approved_work_order($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_historical_approved_work_order');
        $this->db->where($condition);
        $this->db->order_by('final_approval_date', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_asp_emails() {

        $condition = "is_asp = '1'";
        $this->db->select('sa_email');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $asp_emails = $query->result_array(); 

        $asp_email_arr = array();
        foreach ($asp_emails as $asp_mail) {
            $asp_email_arr[] .= $asp_mail['sa_email'];
        } 

        return $asp_email_arr;
    }

}
