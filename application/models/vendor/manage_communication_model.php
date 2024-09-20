<?php

Class Manage_Communication_Model extends CI_Model {

    public function getRecipientEmails($recipient_email, $vendor_id, $admin_id) {
        $condition = "status = '1'";
        $this->db->select('distinct(sa_email)');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $this->db->like('sa_email', $recipient_email);
        $superadmin_query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $condition = "status = '1' and block_status = '1' and admin_id = '" . $admin_id . "'";
        $this->db->select('distinct(admin_email)');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $this->db->like('admin_email', $recipient_email);
        $admin_query = $this->db->get();

        $condition = "employee_email != '' and admin_id = '" . $admin_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('distinct(employee_email)');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->like('employee_email', $recipient_email);
        $employee_query = $this->db->get();
//echo $this->db->last_query();
//        die;
        $superadmin_email = array();
        $admin_email = array();
        $employee_email = array();

        if ($superadmin_query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();

            foreach ($superadmin_query->result() as $superadmin_row) {
                $superadmin_email[] = $superadmin_row->sa_email;
            }
        }
        if ($admin_query->num_rows() > 0) {

            foreach ($admin_query->result() as $admin_row) {
                $admin_email[] = $admin_row->admin_email;
            }
        }
        if ($employee_query->num_rows() > 0) {

            foreach ($employee_query->result() as $employee_row) {
                $employee_email[] = $employee_row->employee_email;
            }
        }

//        echo "<pre>";
//        print_r($admin_email);
//        die;

        if (!empty($superadmin_email) || !empty($admin_email) || !empty($employee_email)) {
            $mails_arr = array_unique(array_merge($superadmin_email, $admin_email, $employee_email));
//            echo "<pre>";
//            print_r($mails_arr);
//            die;
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($mails_arr as $row) {
                $data['message'][] = array(
                    //'label' => $row->employee_code,
                    'value' => $row
                );
            }
        } else {
            $data['response'] = 'false'; //Set false if user not valid
        }
//echo "<pre>";
//        print_r($data);
//        die;
        return $data;
    }

    public function getSuperAdminID($rval) {

        $condition = "sa_email = '" . trim($rval) . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('sa_id');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminID($rval) {

        $condition = "admin_email = '" . trim($rval) . "'";
        $this->db->select('admin_id');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeID($rval) {

        $condition = "employee_email = '" . trim($rval) . "'";
        $this->db->select('employee_id');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkMailID() {

        $this->db->select('*');
        $this->db->from('vms_mail_master');
//        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function add_mail($data) {
        $this->db->insert('vms_mail_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getSentMails($vendor_id) {
        $condition = "sender_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
//        $this->db->group_by('subject');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getSentMail($mail_id, $sender_id) {
        $condition = "sender_id = '" . $sender_id . "' and id='" . $mail_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminDetails($sa_id) {

        $condition = "sa_id = '" . $sa_id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminDetails($admin_id) {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeDetails($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInboxMails($vendor_id, $recipient_type) {
        $condition = "recipient_id = '" . $vendor_id . "' and recipient_type = '" . $recipient_type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
//        $this->db->group_by('subject');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getMailDetails($reply_id) {
        $condition = "id = '" . $reply_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getMailDetailsByReply($reply_id) {
        $condition = "reply_id = '" . $reply_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getInboxMailDetails($mail_id, $recipient_id, $type) {
        $condition = "id = '" . $mail_id . "' and recipient_id = '" . $recipient_id . "' and recipient_type = '" . $type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getReplyMailDetails($mail_id) {
        $condition = "reply_id = '" . $mail_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getInboxMailNotification($vendor_id, $recipient_type) {
//        $condition = "recipient_id = '" . $sa_id . "' and recipient_type = '".$recipient_type."' and reply_id='0' and is_view = '0'";
        $condition = "recipient_id = '" . $vendor_id . "' and recipient_type = '" . $recipient_type . "' and is_view = '0'";
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getRecipients($mail_id) {
        $condition = "mail_id = '" . $mail_id . "'";
        $this->db->select('recipient_id,recipient_type');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getRecipientValues($mail_id, $recipient_id) {
        $condition = "(reply_id = '" . $mail_id . "' OR id = '" . $mail_id . "')  and sender_id = '" . $recipient_id . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->group_by('reply_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getMailSubject($mail_id) {
        $condition = "id = '" . $mail_id . "'";
        $this->db->select('subject');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getMailNotification($vendor_id) {

        $condition = "recipient_id ='" . $vendor_id . "' and recipient_type = 'vendor' and is_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function getMails($vendor_id) {

        $condition = "recipient_id ='" . $vendor_id . "' and recipient_type = 'vendor' and is_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateViewStatus($update_arr, $mail_id, $vendor_id) {
        $condition = "id ='" . $mail_id . "' and recipient_id = '" . $vendor_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_mail_master', $update_arr);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getOthersNotification($admin_id, $vendor_id, $employee_ids) {

        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = '0';
        }

        if ($vendor_id != '') {
            $vendor_id = $vendor_id;
        } else {
            $vendor_id = '0';
        }

        $tot_count = "";
        $current_date = date("Y-m-d");

        /* -------------------------Consultant Added Timesheet--------------------- */

        $t_condition = "employee_id in (" . $employee_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($t_condition);
        $t_query = $this->db->get();
        if ($t_query->num_rows() > 0) {
            $t_num = $t_query->num_rows();
        } else {
            $t_num = 0;
        }

        /* -------------------------Consultant Added Timesheet--------------------- */

        /* -------------------------Admin assigned projects to vendor--------------------- */

        $p_condition = "admin_id = '" . $admin_id . "' and vendor_id = '" . $vendor_id . "' and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($p_condition);
        $p_query = $this->db->get();
//        echo $this->db->last_query();
        if ($p_query->num_rows() > 0) {
            $p_num = $p_query->num_rows();
        } else {
            $p_num = 0;
        }

        /* -------------------------Admin assigned projects to vendor--------------------- */

        /* -------------------------Admin Approved consultant for project--------------------- */

        $i_condition = "vendor_id = '" . $vendor_id . "' and DATE(updated_date) = '" . $current_date . "' and status = '1' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($i_condition);
        $i_query = $this->db->get();
//        echo $this->db->last_query();
        if ($i_query->num_rows() > 0) {
            $i_num = $i_query->num_rows();
        } else {
            $i_num = 0;
        }

        /* -------------------------Admin Approved consultant for project--------------------- */

        /* -------------------------Get Invoice Notification Mail--------------------- */

        $n_condition = "recipient_id = '" . $vendor_id . "' and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($n_condition);
        $n_query = $this->db->get();
//        echo $this->db->last_query();
        if ($n_query->num_rows() > 0) {
            $n_num = $n_query->num_rows();
        } else {
            $n_num = 0;
        }

        /* -------------------------Get Invoice Notification Mail--------------------- */

        $tot_count = $t_num + $p_num + $i_num + $n_num;
        return $tot_count;
    }

    public function getOthersNotificationDetails($admin_id, $vendor_id, $employee_ids) {

        $this->load->model('admin/manage_employee_model', 'employee_model');
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        $this->load->model('admin/profile_model');

        $result_arr = array();
        $current_date = date("Y-m-d");

        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = '0';
        }
        if ($vendor_id != '') {
            $vendor_id = $vendor_id;
        } else {
            $vendor_id = '0';
        }

        /* -------------------------Consultant Added Timesheet--------------------- */

        $t_condition = "employee_id in (" . $employee_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($t_condition);
        $this->db->order_by("entry_date", "desc");
        $t_query = $this->db->get();
        $t_data = $t_query->result_array();
//        echo $this->db->last_query();
        if ($t_query->num_rows() > 0) {
            foreach ($t_data as $tval) {
                $get_employee_details = $this->employee_model->getEmployeeData($tval['employee_id']);
                $get_project_details = $this->employee_model->getProjectData($tval['project_id']);

                if (!empty($get_employee_details) && !empty($get_project_details)) {

                    $result_arr[] = "[" . $get_employee_details[0]['employee_code'] . "] - " . ucwords($get_employee_details[0]['name_prefix']) . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " has added new timesheet for project [" . $get_project_details[0]['project_code'] . "] - " . ucwords($get_project_details[0]['project_name']);
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Consultant Added Timesheet--------------------- */

        /* -------------------------Admin assigned projects to vendor--------------------- */

        $p_condition = "admin_id = '" . $admin_id . "' and vendor_id = '" . $vendor_id . "' and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($p_condition);
        $this->db->order_by("entry_date", "desc");
        $p_query = $this->db->get();
        $p_data = $p_query->result_array();
        //echo $this->db->last_query();
        if ($p_query->num_rows() > 0) {
            foreach ($p_data as $pval) {

                $get_admin_details = $this->employee_model->getAdminDetails($pval['admin_id']);

                if (!empty($get_admin_details)) {

                    $result_arr[] = "Project " . ucwords($pval['project_code']) . " is assigned by " . ucwords($get_admin_details[0]['name_prefix']) . " " . ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']);
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Admin assigned projects to vendor--------------------- */

        /* -------------------------Admin Approved consultant for project--------------------- */

        $i_condition = "vendor_id = '" . $vendor_id . "' and DATE(updated_date) = '" . $current_date . "' and status = '1' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($i_condition);
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        if ($i_query->num_rows() > 0) {
            foreach ($i_data as $ival) {
                $get_employee_details = $this->employee_model->getEmployeeData($ival['employee_id']);
                $get_project_details = $this->employee_model->getProjectData($ival['project_id']);

                if (!empty($get_employee_details) && !empty($get_project_details)) {

                    $result_arr[] = "[" . strtoupper($get_employee_details[0]['employee_code']) . "] " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is hired for requirement [" . strtoupper($get_project_details[0]['project_code']) . "]";
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Admin Approved consultant for project--------------------- */

        /* -------------------------Get Invoice Notification Mail--------------------- */

        $n_condition = "recipient_id = '" . $vendor_id . "' and DATE(entry_date) = '" . $current_date . "' and is_vendor_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($n_condition);
        $n_query = $this->db->get();
        $n_data = $n_query->result_array();
        if ($n_query->num_rows() > 0) {
            foreach ($n_data as $nval) {
                $get_admin_details = $this->employee_model->getAdminDetails($nval['sender_id']);
                $get_vendor_details = $this->employee_model->getVendorDetails($nval['recipient_id']);
                $get_invoice_details = $this->employee_model->checkInvoiceStatusVendor($nval['invoice_id']);

                if (!empty($get_admin_details) && !empty($get_vendor_details) && !empty($get_invoice_details)) {

                    $result_arr[] = ucwords($get_admin_details[0]['name_prefix']) . " " . ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " is commented for invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Get Invoice Notification Mail--------------------- */

        return array_filter($result_arr);
    }

    public function getTimesheetDetails($employee_ids) {

        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = '0';
        }

        $t_condition = "employee_id in (" . $employee_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($t_condition);
        $this->db->order_by("entry_date", "desc");
        $t_query = $this->db->get();
        $t_data = $t_query->result_array();
        return $t_data;
    }

    public function getAssignedVendorProjectDetails($admin_id, $vendor_id) {

        $p_condition = "admin_id = '" . $admin_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($p_condition);
        $this->db->order_by("entry_date", "desc");
        $p_query = $this->db->get();
        $p_data = $p_query->result_array();
        return $p_data;
    }

    public function getApproveDetails($vendor_id) {
        $current_date = date("Y-m-d");
        $i_condition = "vendor_id = '" . $vendor_id . "' and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($i_condition);
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        return $i_data;
    }

    public function getInvoiceNotificationsDetails($vendor_id) {
        $current_date = date("Y-m-d");
        $i_condition = "recipient_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($i_condition);
//        $this->db->group_by('invoice_id');
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        return $i_data;
    }

    public function update_timesheet($update_arr) {
        $this->db->update('vms_project_timesheet_master', $update_arr);
    }

    public function update_vendor_project_details($update_arr) {
        $this->db->update('vms_project_master', $update_arr);
    }

    public function update_approve_details($update_arr) {
        $this->db->update('vms_assign_projects_to_employee', $update_arr);
    }

    public function update_inv_notification_details($update_arr) {
        $this->db->update('vms_payment_mail_master', $update_arr);
    }

}
