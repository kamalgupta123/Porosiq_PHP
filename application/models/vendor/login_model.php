<?php

Class Login_Model extends CI_Model {

    public function login($data) {

        $condition = "vendor_email =" . "'" . $data['email'] . "' AND " . "vendor_password =" . "'" . md5($data['password']) . "' and reg_verification = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
//echo $query->num_rows(); die;

        if ($query->num_rows() == 1) {
//echo $this->db->last_query();
//            die;
            return true;
        } else {
            return false;
        }
    }

    public function checkIsDelete($data) {

        $condition = "vendor_email =" . "'" . $data['email'] . "' AND " . "vendor_password =" . "'" . md5($data['password']) . "' and reg_verification = '1'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function get_vendor_details($email) {

        $condition = "vendor_email =" . "'" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function checkOldPassword($email, $password) {

        $condition = "vendor_email =" . "'" . $email . "' and vendor_password = '" . md5($password) . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function update_vendor_password($data, $email) {
        $this->db->where('vendor_email', $email);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function changeStatus($data, $email_otp) {
        $this->db->where('reg_code', $email_otp);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkDuplicate($email) {

        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkOTP($email_otp) {

        $condition = "reg_code = '" . $email_otp . "' and status = '0' and block_status = '0'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function addVendor($data) {
        $this->db->insert('vms_vendor_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getEmployeeLists($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorName($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('vendor_name,company_id');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetails($otp) {

        $condition = "reg_code = '" . $otp . "'";
        $this->db->select('vendor_name,company_id,vendor_email');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorFiles($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkEmail($email) {

        $condition = "vendor_email =" . "'" . $email . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function checkValidOTP($email, $email_otp) {

        $condition = "vendor_email =" . "'" . $email . "' and forgot_password_otp = '" . $email_otp . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getDetailsbyOTP($email_otp) {

        $condition = "forgot_password_otp = '" . $email_otp . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function update_email_otp($data, $email) {
        $this->db->where('vendor_email', $email);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_password($data, $email) {
        $this->db->where('vendor_email', $email);
        $this->db->update('vms_vendor_master', $data);
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
        $sess_arr = $this->session->userdata('vendor_logged_in');
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

}
