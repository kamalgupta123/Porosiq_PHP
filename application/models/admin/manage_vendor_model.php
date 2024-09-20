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
		
		//echo $email;

        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
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

    public function getVendorLists($admin_id) {

        //$condition = "admin_id = '" . $admin_id . "' and is_delete = '0'";
        $condition = "is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query();
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

    public function getAdminData($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminLists() {

        $condition = "status = '1' and block_status = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminData($id) {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
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
        $this->db->order_by("form_name", "ASC");
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

        $condition = "vendor_id = '" . $id . "' and is_delete = '0'";
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

    public function getEmpDetails($id) {

        $condition = "vendor_id = '" . $id . "' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkStatus($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('status');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkBlockStatus($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('block_status');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getFiles() {

        $condition = "id = '1'";
        $this->db->select('*');
        $this->db->from('vms_verification_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_vendor_docs($data, $id) {
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

    public function getVendorEmail($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminEmail($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDocument($form_no, $vendor_id) {

        $condition = "form_no = '" . $form_no . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function update_form($data, $vendor_id, $form_no) {
        $condition = "form_no = '" . $form_no . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_vendor_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkFormStatus($form_no, $vendor_id) {
        $condition = "form_no = '" . $form_no . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAllVendor() {

        //$condition = "status = '1' and block_status ='1' and is_delete = '0'";
        $condition = "is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function get_multiple_vendor_details($data) {
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where_in('vendor_id', $data);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_vendor_bg_order_id($bg_order_id, $vendor_id) {
        $data = array('bg_order_id' => $bg_order_id);
        $this->db->where('vendor_id', $vendor_id);
        $this->db->update('vms_vendor_master', $data);
    }

    public function update_vendor_bg_status($vendor_id) {
        $data = array('bg_check_status' => 1);
        $this->db->where_in('vendor_id', $vendor_id);
        $this->db->update('vms_vendor_master', $data);
    }

    public function get_order_id_by_phone_and_email($phone, $email) {
        $this->db->select('bg_order_id');
        $this->db->from('vms_vendor_master');
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_order_report($phone, $file, $email) {
        $data = array('bg_report_file' => $file);
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_vendor_master', $data);
    }

    public function update_order_status($phone, $email) {
        $data = array('bg_check_status' => 2);
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_vendor_master', $data);
    }

    public function update_order_status_needs_attention($phone, $email) {
        $data = array('bg_check_status' => 3);
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_vendor_master', $data);
    }

    public function update_order_status_canceled($phone, $email) {
        $data = array('bg_check_status' => 4);
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_vendor_master', $data);
    }

    public function update_order_status_archived($phone, $email) {
        $data = array('bg_check_status' => 5);
        $multipleWhere = array('phone_no' => $phone, 'vendor_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_vendor_master', $data);
    }
    
    public function getVendorDocuments() {

//        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkAdminForm($doc_id, $vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and form_no = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getDocDetails($doc_id) {

        $condition = "id = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deletePreviousDocs($form_no, $vendor_id, $admin_id) {
        $condition = "form_no = '" . $form_no . "' and vendor_id = '" . $vendor_id . "' and admin_id = '" . $admin_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_admin_vendor_files');
        return 1;
    }

    public function add_vendor_documents($data) {
        $this->db->insert('vms_admin_vendor_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getAdminDetails($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	
	/**code added to include vendor documents in superadmin**/
	 public function getGenerateStatus($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
		//echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	public function getDocumentsLists() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

	public function getUploadedDocs($doc_id, $vendor_id) {

        $condition = "form_no = '" . $doc_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
      //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	public function getSuperAdminDetails($id) {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	 public function check_docs_status($vendor_id, $doc_id) {

        $condition = "form_no = '" . $doc_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	 public function change_docs_status($data, $vendor_id, $doc_id) {
        $condition = "form_no = '" . $doc_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_vendor_files', $data);
     // echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}
