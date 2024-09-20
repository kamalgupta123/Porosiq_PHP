<?php

Class Manage_Menu_Model extends CI_Model {

    public function getMenu($type) {
        $condition = "parent_id = '0' and view_portal = '" . $type . "'";
        $this->db->select('*');
        $this->db->from('vms_menu_master');
        $this->db->where($condition);
        $this->db->order_by("view_order", "ASC");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminPermissionDetails($admin_id) {
        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPermission($admin_id) {
        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_admin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deletePrevPermission($admin_id) {
        $this->db->where('admin_id', $admin_id);
        $this->db->delete('vms_admin_permission');
    }

    public function add_admin_menu_permission($data) {
        $this->db->insert('vms_admin_permission', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function checkSAPermission($sa_id) {
        $condition = "sa_id = '" . $sa_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_superadmin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminPermissionDetails($sa_id) {
        $condition = "sa_id = '" . $sa_id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deleteSAPrevPermission($sa_id) {
        $this->db->where('sa_id', $sa_id);
        $this->db->delete('vms_superadmin_permission');
    }

    public function add_superadmin_menu_permission($data) {
        $this->db->insert('vms_superadmin_permission', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

}
