<?php

Class Manage_Vendor_Model extends CI_Model {

    public function add_vendor_user($data) {
        $this->db->insert('vms_vendor_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_vendor_user_files($data) {
        $this->db->insert('vms_vendor_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_vendor_user($data, $id) {
        $this->db->where('vendor_id', $id);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_vendor_user_files($data, $id) {
        $this->db->where('vendor_id', $id);
        $this->db->update('vms_vendor_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_block_status($data, $id) {
        $this->db->where('vendor_id', $id);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_status($data, $id) {
        $this->db->where('vendor_id', $id);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getDetails($email) {

        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
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

    public function getVendorLists() {

        //$condition = "1=1";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        //$this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorData($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorFiles($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCountry() {

        // $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('countries');
        // $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getState($country_id) {

        $condition = "country_id = '" . $country_id . "'";
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCity($state_id) {

        $condition = "state_id = '" . $state_id . "'";
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCountryName($country_id) {

        $condition = "id = '" . $country_id . "'";
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getStateName($state_id) {

        $condition = "id = '" . $state_id . "'";
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCityName($city_id) {

        $condition = "id = '" . $city_id . "'";
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getNoEmployees($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeesDetails($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

}
