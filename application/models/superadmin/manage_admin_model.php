<?php

Class Manage_Admin_Model extends CI_Model {

    public function add_admin_user($data) {
        $this->db->insert('vms_admin_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_admin_user($data, $id) {
        $this->db->where('admin_id', $id);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_block_status($data, $id) {
        $this->db->where('admin_id', $id);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_status($data, $id) {
        $this->db->where('admin_id', $id);
        $this->db->update('vms_admin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getDetails($email) {

        $condition = "admin_email = '" . $email . "'";
        $this->db->select('admin_id,admin_name,file');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminData($id) {

        $condition = "sa_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
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

        $this->db->select('distinct(employee_email)');
        $this->db->from('vms_employee_master');
        $this->db->like('employee_email', $email);
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

    public function getAdminLists() {

        $condition = "is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $this->db->order_by("admin_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminData($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminType() {

        // $condition = "admin_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_type_master');
        //$this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkAdmin($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deleteAdminUser($data, $id) {

        $this->db->where('admin_id', $id);
        $this->db->update('vms_admin_master', $data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}
