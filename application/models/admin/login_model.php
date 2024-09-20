<?php

Class Login_Model extends CI_Model {

    public function login($data) {

        $condition = "admin_email =" . "'" . $data['email'] . "' AND " . "admin_password =" . "'" . md5($data['password']) . "' and status = '1' and block_status='1' and is_delete = '0'";
        $this->db->select('admin_id');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIsDelete($data) {

        $condition = "admin_email =" . "'" . $data['email'] . "' AND " . "admin_password =" . "'" . md5($data['password']) . "' and status = '1' and block_status='1'";
        $this->db->select('is_delete');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function get_admin_details($email) {

        $condition = "admin_email =" . "'" . $email . "'";
        $this->db->select('admin_email,admin_type_id,admin_id,change_password');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function checkOldPassword($email, $password) {

        $condition = "admin_email =" . "'" . $email . "' and admin_password = '" . md5($password) . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function update_admin_password($data, $email) {
        $this->db->where('admin_email', $email);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkEmail($email) {

        $condition = "admin_email =" . "'" . $email . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function checkValidOTP($email, $email_otp) {

        $condition = "admin_email =" . "'" . $email . "' and forgot_password_otp = '" . $email_otp . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getDetailsbyOTP($email_otp) {

        $condition = "forgot_password_otp = '" . $email_otp . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function update_email_otp($data, $email) {
        $this->db->where('admin_email', $email);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_password($data, $email) {
        $this->db->where('admin_email', $email);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add_user_log($data) {
        $this->db->insert('vms_user_log', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function chat_logout(){
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data =array(
            'status' => '0',
            );
        $this->db->where('user_name', $email);
        $this->db->update('chat_user', $data);

        // if ($this->db->affected_rows() > 0) {
        //     echo "done";
        // } else {
        //     echo "error";
        // }
    }

    public function get_emp_category() {

        $condition = "vms_employee_login_details.status = '1' and vms_employee_login_details.block_status = '1' and vms_employee_login_details.is_delete = '0'";
        $this->db->_protect_identifiers = FALSE;
        $this->db->select('vms_employee_master.employee_email, vms_employee_master.temp_category, vms_employee_login_details.status, vms_employee_login_details.block_status, vms_employee_login_details.is_delete'); 
        $this->db->from('vms_employee_master');
        $this->db->join('vms_employee_login_details', 'vms_employee_master.employee_id = vms_employee_login_details.employee_id', 'inner');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function get_total_invoce_for_chart($from_date, $to_date) {

        $condition = "datediff(current_date,date(entry_date)) BETWEEN " . $from_date . " AND " . $to_date . " and payment_status = '0'";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
      //   echo $this->db->last_query();
      // die;
        $data = $query->result_array();

        $total_amount = "0";
        foreach($data as $in) {
           // echo $in['tot_time_pay'] . "<br>";
            $total_amount += $in['tot_time_pay'];
        }

        return $total_amount;
    } 

    public function get_monthly_consultant_data($month) {

        $condition = "employee_type = 'C' and month(date_of_joining)='" . $month . "' and year(date_of_joining)= YEAR(CURDATE())";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_monthly_finance_data($month) {

        $condition = "month(invoice_end_date)='" . $month . "' and year(invoice_end_date)= YEAR(CURDATE())";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        $total_amount = "0";
        foreach($data as $in) {

            $total_amount += $in['tot_time_pay'];
        }

        return $total_amount;
    }

}
