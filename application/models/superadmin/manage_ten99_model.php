<?php

Class Manage_ten99_Model extends CI_Model {

    
    public function getDocumentsLists() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_1099_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

	public function add_ten99_documents($data) {
        $this->db->insert('vms_1099_documents', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
	public function getten99DocsDetails($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	public function getTen99UserIDs()
    {

        $condition = "employee_type = '1099'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
       //echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }
	
	
	public function update_docs($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_1099_documents', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
	
	public function getten99Lists() {

        //$condition = "employee_type = 'C' and is_delete = '0'";
		$condition = "employee_type = '1099' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
       // echo $this->db->last_query();
       // die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	public function getAllFilesByClient($employee_type, $is_uhg, $is_jci) {

        //for consultants
		if ($employee_type == '1099') {
            if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "UPPER(document_name) not like 'JCI%'";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "UPPER(document_name) not like ('CWA%')";
            }
			else{
				$condition = "UPPER(document_name) not like ('CWA%') and UPPER(document_name) not like ('JCI%')";
			}
			
        }
		
		//For hourly employees
		/*else if (($employee_type == 'E') && ($emp_enrollment_type == 'yearly')){
			if (($is_uhg == 0) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
            } 
			else if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'PTS Employee Agreement - Hourly')";
            }
			else{
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
			}
        }
		
		//For yearly employees
		else if (($employee_type == 'E') && ($emp_enrollment_type == 'hourly')){
			if (($is_uhg == 0) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
            } 
			else if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'PTS Employee Agreement - Yearly')";
            }
			else{
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
			}
        }*/
		
        
		 $this->db->select('*');
        $this->db->from('vms_1099_documents');
        $this->db->where($condition);
        $query = $this->db->get();
       //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

	public function getUploadedDocs($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	public function check_docs_status($employee_id, $doc_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	public function change_docs_status($data, $employee_id, $doc_id) {
        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_1099_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
	
	public function get_ucsis_sadmin_approve_status($employee_id) {
        $condition = "consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
//        echo $this->db->last_query();
//        die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	public function getFiles($consultant_id) {

        $condition = "consultant_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	public function getDocsDetails($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	 public function checkPrevUploaded($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

	
	 public function checkApproveStatus($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	public function getPrevUploaded($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_1099_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
	
	
	function deletePreviousDocsbyID($doc_id, $employee_id) {
        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_1099_files');
        return 1;
    }
	
	  public function add_employee_documents($data) {
        $this->db->insert('vms_1099_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

	
	 public function getEmployeeListsbyType() {

        $condition = "employee_type = '1099' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
	
	
    public function getten99IDs() {

        $condition = "employee_type = '1099'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
//       echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }
	
}
