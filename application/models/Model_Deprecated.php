<?php

Class Manage_Employee_Model extends CI_Model
{
    public function getEmployeeListsbyAdmin($admin_id)
        {
                #$admin_id
                //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
                // $condition = "vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = ".$admin_id;

                // $this->db->select("vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type,vem.bg_check_status,vem.bg_order_id,vem.bg_report_file, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name", FALSE);

                // $this->db->from('vms_employee_master AS vem');
                // $this->db->join('vms_admin_master AS vam', 'vem.shift_admin_manager_id = vam.admin_id');
                // $this->db->where($condition);
                // $this->db->order_by("vem.employee_id", "desc");
                // $query = $this->db->get();

                $sql = "SELECT vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type,vem.bg_check_status,vem.bg_order_id,vem.bg_report_file, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name, veld.consultant_email, veld.status AS veld_status, veld.block_status, count(veld.id) as cnt, vcm.client_name FROM vms_employee_master vem INNER JOIN vms_admin_master vam ON vem.shift_admin_manager_id = vam.admin_id LEFT JOIN vms_employee_login_details veld ON vem.employee_id = veld.employee_id LEFT JOIN vms_client_master vcm ON vem.client_id=vcm.id and vcm.status = '1' WHERE vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = $admin_id GROUP BY vem.employee_id ORDER BY vem.employee_id DESC;";

                $query = $this->db->query($sql);

                
                $data = $query->result_array();
                return $data;
        }

    public function getEmployeeListsbyTypeNew($admin_id) {
                $condition = "employee_type = 'E' and is_delete = '0' and shift_admin_manager_id =".$admin_id;
                $this->db->select('*');
                $this->db->from('vms_employee_master');
                $this->db->where($condition);
                $this->db->order_by("employee_id", "desc");
                $query = $this->db->get();
                $data = $query->result_array();
                return $data;
        }

    public function getAllEmployeeListsbyAdmin() {
                #$admin_id
                //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
                $condition = "employee_type = 'E' and is_delete = '0'";

                $this->db->select('client_id,file,employee_code,name_prefix,first_name,last_name,employee_designation,temp_classification,employee_category,temp_category,address,phone_no,date_of_joining,resume_file,employee_bill_rate,employee_pay_rate,status,employee_id,fax_no,emp_bill_rate_type,emp_pay_rate_type');

                $this->db->from('vms_employee_master');
                $this->db->where($condition);
                $this->db->order_by("employee_id", "desc");
                $query = $this->db->get();
                $data = $query->result_array();
                return $data;
        }
}