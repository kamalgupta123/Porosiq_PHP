<?php

Class Profile_Model extends CI_Model {

    public function checkCurPassword($cur_password, $email) {

        $condition = "vendor_password =" . "'" . md5($cur_password) . "' and vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
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

        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminEmail($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('admin_email');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
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

    public function updateProfile($data, $sa_id) {
        $this->db->where('vendor_id', $sa_id);
        $this->db->update('vms_vendor_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkCounterForm($doc_id, $vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and form_no = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_vendor_files');
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

    /* ------------------------------Documentation--------------------------- */

    public function add_form($data) {
        $this->db->insert('vms_vendor_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
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

    public function insert_vendor_user_files($data) {
        $this->db->insert('vms_vendor_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function checkFiles($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
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

    public function update_form($data, $id) {
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
	
	/* ------------------------------Newly inserted part to send mails--------------------------- */
		
	public function getSuperAdminDetails($sa_id) {

        $condition = "UPPER(sa_name) like 'aurica%' or sa_id = '" . $sa_id . "' ";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	
	/* ------------------------------Newly inserted part to send mails--------------------------- */
	
    /* ------------------------------Documentation--------------------------- */

    public function getEmployeeDetails($vendor_id) {

        $condition = "status = '1' and block_status = '1' and vendor_id = '" . $vendor_id . "'";
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

    public function getProjectDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->limit(10);
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceDetails($vendor_id) {

        $condition = "status = '1' and vendor_id = '" . $vendor_id . "'";
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

    public function getAdminData($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getUnapprovedTimesheetCount($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '1' and approved_by_admin = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
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

    public function getVendorAllDocuments() {

//        $condition = "vendor_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
//        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceList() {

        $this->db->select('InvoiceNumber,Date,PONumber,Store,Total,invoiceFilePath');
        $this->db->from('invoices');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function insert_invoice($data) {
        $this->db->insert('invoices',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }


    public function checkUploadedForm($form_name, $vendor_id) {

        $condition = "form_name = '" . trim($form_name) . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_vendor_files($data) {
        $this->db->insert('vms_vendor_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getAllFiles() {

//        $condition = "FIND_IN_SET('".$employee_type."',required_for) > 0";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
//        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getFileDetails($doc_id, $vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "' and form_no = '" . $doc_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deletePrevDocs($vendor_id, $doc_id,$doc_name) {
        $condition = "form_name = '" . trim($doc_name) . "' and vendor_id = '" . $vendor_id . "' and form_no = '".$doc_id."'";
        $this->db->where($condition);
        $this->db->delete('vms_vendor_files');
        return 1;
    }
}
