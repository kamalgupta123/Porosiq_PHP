	<?php

Class Profile_Model extends CI_Model {

    public function checkCurPassword($cur_password, $email) {

        $condition = "sa_password =" . "'" . md5($cur_password) . "' and sa_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
//echo $query->num_rows(); die;

        if ($query->num_rows() > 0) {
//echo $this->db->last_query();
//            die;
            return 1;
        } else {
            return 0;
        }
    }

    public function getDetails($email) {

        if (LATAM) {
            $condition = "sa_email = '" . $email . "' and lower(sa_email) not like 'aurica%' ";
        }
        if (US || INDIA) {
            $condition = "sa_email = '" . $email . "'";
        }
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateProfile($data, $sa_id) {
        $this->db->where('sa_id', $sa_id);
        $this->db->update('vms_superadmin_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

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

    public function getAdminDetailsCount() {

        $condition = "status = '1' and block_status = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetails() {

        $condition = "status = '1' and block_status = '1'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetailsCount() {

        $condition = "status = '1' and block_status = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeDetails() {

//        $condition = "status = '1' and block_status = '1'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantDetails() {

        $condition = "employee_type = 'C'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantDetailsCount() {

        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpDetails() {

        $condition = "employee_type = 'E'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpDetailsCount() {

        $condition = "employee_type = 'E' and is_delete = '0'";
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

    public function getInvoiceDetails() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->limit(10);
        $this->db->from('vms_payment_master');
        $this->db->order_by("updated_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
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

    public function getSuperAdminData($sa_id) {

        if (LATAM) {
            $condition = "sa_id = '" . $sa_id . "' and is_delete = '0' and lower(sa_email) not like 'aurica%'";
        }
        if (US || INDIA) {
            $condition = "sa_id = '" . $sa_id . "' and is_delete = '0'";
        }
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSaLists($sa_id) {

//        $condition = "sa_id <> '" . $sa_id . "' and is_delete = '0'";
        $condition = "is_delete = '0'";
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

    public function add_superadmin_user($data) {
        $this->db->insert('vms_superadmin_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getDetailsByID($id) {

        $condition = "sa_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminPermissionDetails($sa_id) {
        $condition = "sa_id = '" . $sa_id . "' and is_view = '1'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminMenu($menu_str) {
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
	//	echo $this->db->last_query();
//die;
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminChildMenu($parent_id) {
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

    public function getInactiveSuperadminDetails() {

        $condition = "is_delete = '1'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInactiveAdminDetails() {

        $condition = "is_delete = '1'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deleteSadminUser($data, $id) {
        $this->db->where('sa_id', $id);
        $this->db->update('vms_superadmin_master', $data);
//echo $this->db->last_query();
//die;
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getInactiveVendorDetails() {

        $condition = "is_delete = '1'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInactiveConDetails() {

        $condition = "is_delete = '1' and employee_type = 'C'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getInactiveEmpDetails() {

        $condition = "is_delete = '1' and employee_type = 'E'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function updateIsDeleteStatus($data, $user_type, $user_id) {

        if ($user_type == 'superadmin') {
            $where_condition = array('sa_id' => $user_id);
            $table = 'vms_superadmin_master';
        } else if ($user_type == 'admin') {
            $where_condition = array('admin_id' => $user_id);
            $table = 'vms_admin_master';
        } else if ($user_type == 'vendor') {
            $where_condition = array('vendor_id' => $user_id);
            $table = 'vms_vendor_master';
        } else if ($user_type == 'consultant') {
            $where_condition = array('employee_id' => $user_id);
            $table = 'vms_employee_master';
            $where_condition1 = array('employee_id' => $user_id);
            $table1 = 'vms_employee_login_details';
        } else if ($user_type == 'employee') {
            $where_condition = array('employee_id' => $user_id);
            $table = 'vms_employee_master';
            $where_condition1 = array('employee_id' => $user_id);
            $table1 = 'vms_employee_login_details';
        }

        $this->db->where($where_condition);
        $this->db->update($table, $data);

        if ($user_type == 'consultant' || $user_type == 'employee') {
            $this->db->where($where_condition1);
            $this->db->update($table1, $data);
        }

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteUserPermanently($user_type, $user_id) {

        if ($user_type == 'superadmin') {
            $where_condition = array('sa_id' => $user_id);
            $table = 'vms_superadmin_master';
        } else if ($user_type == 'admin') {
            $where_condition = array('admin_id' => $user_id);
            $table = 'vms_admin_master';
        } else if ($user_type == 'vendor') {
            $where_condition = array('vendor_id' => $user_id);
            $table = 'vms_vendor_master';
        } else if ($user_type == 'consultant') {
            $where_condition = array('employee_id' => $user_id);
            $table = 'vms_employee_master';
            $where_condition1 = array('employee_id' => $user_id);
            $table1 = 'vms_employee_login_details';
        } else if ($user_type == 'employee') {
            $where_condition = array('employee_id' => $user_id);
            $table = 'vms_employee_master';
            $where_condition1 = array('employee_id' => $user_id);
            $table1 = 'vms_employee_login_details';
        }

        $this->db->where($where_condition);
        $this->db->delete($table);

        if ($user_type == 'consultant' || $user_type == 'employee') {
            $this->db->where($where_condition1);
            $this->db->delete($table1);
        }

        if (!$this->db->affected_rows()) {
            return 0;
        } else {
            return 1;
        }
    }

    public function checkSadmin($id) {

        $condition = "sa_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getMenuPermission($sa_id) {

        $condition = "sa_id = '" . $sa_id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getMenuStatus($menu_id, $sa_id) {

        $condition = "sa_id = '" . $sa_id . "' and menu_id = '" . $menu_id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAccssLogDetails() {

//        $condition = "sa_id = '" . $sa_id . "' and menu_id = '".$menu_id."'";
        $this->db->select('*');
        $this->db->from('vms_user_log');
        $this->db->order_by("user_login_date_time", "desc");
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    //---------------------------------------------------------------------

    public function getAdminDetailsBySA($sa_id) {

        $condition = "status = '1' and block_status = '1' and sa_id = '" . $sa_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetailsBySA($admin_arr_str) {

        $condition = "status = '1' and block_status = '1' and admin_id in (" . $admin_arr_str . ")";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantDetailsBySA($admin_arr_str) {

        $condition = "employee_type = 'C' and admin_id in (" . $admin_arr_str . ")";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpDetailsBySA($admin_arr_str) {

        $condition = "employee_type = 'E' and admin_id in (" . $admin_arr_str . ")";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

	
	/**Adding new modules for super admin to retrieve all the vendor files from DB**/
	 public function getVendorAllDocuments() {

//        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	 public function getFileStatus($dkey, $vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and form_no = '" . $dkey . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }
	
	public function getTen99UserDetailsCount() {

        $condition = "employee_type = '1099' and is_delete = '0'";
		$this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->order_by("entry_date", "desc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	
    //---------------------------------------------------------------------
}
