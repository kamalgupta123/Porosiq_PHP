<?php

Class Profile_Model extends CI_Model {

    public function checkCurPassword($cur_password, $email) {

        $condition = "admin_password =" . "'" . md5($cur_password) . "' and admin_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getDetails($email) {

        $condition = "admin_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateProfile($data, $sa_id) {
        $this->db->where('admin_id', $sa_id);
        $this->db->update('vms_admin_master', $data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /* ------------------------------Documentation--------------------------- */

    public function getFiles() {

        $condition = "id = '1'";
        $this->db->select('*');
        $this->db->from('vms_verification_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_vendor_user_files($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_verification_files', $data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insert_vendor_user_files($data) {
        $this->db->insert('vms_verification_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function checkFiles() {

        $condition = "id = '1'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_verification_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    /* ------------------------------Documentation--------------------------- */

    public function getAdminDetails() {

        $condition = "status = '1' and block_status = '1'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetails($admin_id) {

        $condition = "status = '1' and block_status = '1' and admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetailsCount($admin_id) {

        $condition = "status = '1' and block_status = '1' and admin_id = '" . $admin_id . "' and is_delete='0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAllVendor() {

        $condition = "status = '1' and block_status ='1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeDetails($vendor_ids_str, $admin_id) {
        if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }

        $condition = "admin_id = '" . $admin_id . "' and vendor_id in (" . $vendor_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantDetails($vendor_ids_str, $admin_id) {
        if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }

        $condition = "admin_id = '" . $admin_id . "' and vendor_id in (" . $vendor_ids . ") and employee_type = 'C'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantDetailsCount() {

        #$vendor_ids_str,$admin_id
        /*if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }*/

        //$condition = "admin_id = '" . $admin_id . "' and vendor_id in (" . $vendor_ids . ") and employee_type = 'C' and is_delete = '0'";
        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpDetails($admin_id) {

        $condition = "admin_id = '" . $admin_id . "' and employee_type = 'E'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpDetailsCount() {

        #$admin_id
        //$condition = "admin_id = '" . $admin_id . "' and employee_type = 'E' and is_delete='0'";
        $condition = "employee_type = 'E' and is_delete='0' ";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpCompanyDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('vendor_company_name,company_id');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpAssignedProjects($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('project_id');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectsDetails($project_id) {

        $condition = "id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceDetails($vendor_ids_str) {

        if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }

        $condition = "vendor_id in (" . $vendor_ids . ")";
//        $condition = "status = '1' and vendor_id in (" . $vendor_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->order_by("updated_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getPendingInvoiceDetails($vendor_ids_str) {

        if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }

        $condition = "status = '0' and vendor_id in (" . $vendor_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeData($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorData($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminData($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getMenu($type) {
        $condition = "parent_id = '0' and view_portal = '" . $type . "'";
        $this->db->select('*');
        $this->db->from('vms_menu_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminPermissionDetails($admin_id) {
        $condition = "admin_id = '" . $admin_id . "' and is_view = '1'";
        $this->db->select('*');
        $this->db->from('vms_admin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminMenu($menu_str) {
        if ($menu_str != '') {
            $menu_str = $menu_str;
        } else {
            $menu_str = 0;
        }
        $condition = "id in (" . $menu_str . ") ";
        $this->db->select('*');
        $this->db->from('vms_menu_master');
        $this->db->where($condition);
        $this->db->order_by("view_order", "ASC");
        $query = $this->db->get();
        $data = $query->result_array();

        /**
         * Call to the dangerous Helper function
         */
        set_user_privileges($data);

        return $data;
    }

    public function getAdminChildMenu($parent_id) {
        $condition = "parent_id = '" . $parent_id . "'";
        $this->db->select('*');
        $this->db->from('vms_menu_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getFileDetails($doc_id, $employee_id) {

        $condition = "consultant_id = '" . $employee_id . "' and form_no = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateFile($doc_id, $employee_id, $file) {
        $data = [
            'file' => $file,
        ];
        $whereArray = ['form_no' => $doc_id, 'consultant_id' => $employee_id];
        $this->db->where($whereArray);
        $this->db->update('vms_consultant_files', $data);
        echo 'order has successfully been updated';
    }

    public function getMenuPermission($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('id');
        $this->db->from('vms_admin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getMenuStatus($menu_id, $admin_id) {

        $condition = "admin_id = '" . $admin_id . "' and menu_id = '" . $menu_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	/*code added to retrieve client details from client id*/
	
	 public function getClientData($client_id) {

        $condition = "status = '1' and id = '" . $client_id . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	public function getTen99UserDetailsCount() {

        #$admin_id
        //$condition = "admin_id = '" . $admin_id . "' and employee_type = '1099' and is_delete='0'";
        $condition = "employee_type = '1099' and is_delete='0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminConsInvoice($from_date, $to_date, $vendor_ids_str) {

        if ($vendor_ids_str != '') {
            $vendor_ids = $vendor_ids_str;
        } else {
            $vendor_ids = "0";
        }

        $condition = "status = '0' and vendor_id in (" . $vendor_ids . ") and (str_to_date(start_date, '%m/%d/%Y') >= str_to_date('$from_date', '%m/%d/%Y') and str_to_date(end_date, '%m/%d/%Y') <= str_to_date('$to_date', '%m/%d/%Y')) ";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("invoice_code", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
}
