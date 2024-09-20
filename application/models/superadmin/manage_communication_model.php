<?php

Class Manage_Communication_Model extends CI_Model {

    public function getRecipientEmails($recipient_email) {
        $email_arr = array();

        $condition = "status = '1' and block_status = '1'";
        $this->db->select('distinct(admin_email)');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $this->db->like('admin_email', $recipient_email);
        $admin_query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $condition = "status = '1' and block_status = '1'";
        $this->db->select('distinct(vendor_email)');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->like('vendor_email', $recipient_email);
        $vendor_query = $this->db->get();

        $condition = "employee_email != ''";
        $this->db->select('distinct(employee_email)');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->like('employee_email', $recipient_email);
        $employee_query = $this->db->get();
//echo $this->db->last_query();
//        die;
        $admin_email = array();
        $vendor_email = array();
        $employee_email = array();

        if ($admin_query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();

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

//        echo "<pre>";
//        print_r($admin_email);
//        die;

        if (!empty($admin_email) || !empty($vendor_email) || !empty($employee_email)) {
            $mails_arr = array_unique(array_merge($admin_email, $vendor_email, $employee_email));
//            echo "<pre>";
//            print_r(array_unique($mails_arr));
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

    public function getAdminID($rval) {

        $condition = "admin_email = '" . trim($rval) . "'";
        $this->db->select('admin_id');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorID($rval) {

        $condition = "vendor_email = '" . trim($rval) . "'";
        $this->db->select('vendor_id');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getemployeeID($rval) {

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

    public function getSentMails($sa_id, $sender_type) {
        $condition = "sender_type = '" . $sender_type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
//        $this->db->group_by('mail_id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getSentMailsAll($sender_type) {
        $condition = "sender_type = '" . $sender_type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getSentMail($mail_id, $sender_id) {
        $condition = "sender_id = '" . $sender_id . "' and id='" . $mail_id . "' ";
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

    public function getSentMailDetails($mail_id) {
        $condition = "id = '" . $mail_id . "' ";
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

    public function add_mail($data) {
        $this->db->insert('vms_mail_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getSuperAdminDetails($sa_id) {

        $condition = "sa_id = '" . $sa_id . "'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
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

    public function getVendorDetails($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
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

    public function getInboxMails($sa_id, $recipient_type) {
        $condition = "recipient_id = '" . $sa_id . "' and recipient_type = '" . $recipient_type . "'";
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

    public function getInboxMailsAll($recipient_type) {
        $condition = "recipient_type = '" . $recipient_type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
//        $this->db->group_by('reply_id');
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

    public function getInboxMailDetails($mail_id, $type) {
        $condition = "id = '" . $mail_id . "' and recipient_type = '" . $type . "'";
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

    public function getInboxMailNotification($sa_id, $recipient_type) {
//        $condition = "recipient_id = '" . $sa_id . "' and recipient_type = '".$recipient_type."' and reply_id='0' and is_view = '0'";
        $condition = "recipient_id = '" . $sa_id . "' and recipient_type = '" . $recipient_type . "' and is_view = '0'";
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

    public function updateViewStatus($update_arr, $mail_id, $type) {
        $condition = "id ='" . $mail_id . "' and recipient_type = '" . $type . "'";
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

    public function getRecipients($mail_id) {
        $condition = "id = '" . $mail_id . "'";
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

    public function getMailNotification($sa_id) {

        $condition = "recipient_type = 'superadmin' and is_view = '0'";
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

    public function getMails($sa_id) {

        if (US || INDIA) {
            $condition = "mm.recipient_type = 'superadmin' AND mm.is_view = '0'";
            $this->db->select(
                'mm.id, mm.subject, mm.message, mm.entry_date, mm.sender_type, mm.sender_id,
                sm.sa_id AS `sa_id`, sm.sa_name AS `sa_name`,
                sm.sa_email AS `sa_email`, sm.file AS `sa_file`,
                am.admin_id, am.admin_email, am.file AS `admin_file`,
                am.first_name AS `admin_first_name`, am.last_name AS `admin_last_name`,
                vm.vendor_id, vm.vendor_email, vm.photo AS `vendor_photo`,
                vm.first_name AS `vendor_first_name`, vm.last_name AS `vendor_last_name`,
                em.employee_id, em.employee_email, em.file AS `employee_file`,
                em.first_name AS `employee_first_name`, em.last_name AS `employee_last_name`'
            );
            $this->db->from('vms_mail_master mm');
            $this->db->join('vms_superadmin_master sm', 'sm.sa_id = mm.sender_id', 'left');
            $this->db->join('vms_admin_master am', 'am.admin_id = mm.sender_id', 'left');
            $this->db->join('vms_vendor_master vm', 'vm.vendor_id = mm.sender_id', 'left');
            $this->db->join('vms_employee_master em', 'em.employee_id = mm.sender_id', 'left');
            $this->db->where($condition);
            $this->db->order_by("mm.id", "desc");
            $this->db->limit(150);

            $query = $this->db->get();

            return $query->result_array();
        }
        if (LATAM) {
            $condition = "recipient_type = 'superadmin' and is_view = '0'";
            $this->db->select('*');
            $this->db->from('vms_mail_master');
            $this->db->where($condition);
            $this->db->order_by("id", "desc");
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function getOthersNotification($superadmin_id, $employee_ids = '0') {
 /* -------------------------Consultant Added Documents--------------------- */
        $t_condition = "consultant_id in (" . $employee_ids . ") and is_superadmin_view = '1'";
        $this->db->select('consultant_id');
        $this->db->from('vms_consultant_files');
        $this->db->where($t_condition);
        $t_query = $this->db->get();

        return $t_query->num_rows();
    }

    public function getOthersNotificationDetails($superadmin_id, $employee_ids = '0') {

        if (US || INDIA) {
            $result_arr = array();

            $t_condition = "cf.consultant_id in (" . $employee_ids . ") AND cf.is_superadmin_view = '1'";
            $this->db->select(
                'cf.form_name, em.employee_code, em.name_prefix, em.first_name, em.last_name'
            );
            $this->db->from('vms_consultant_files cf');
            $this->db->join('vms_employee_master em', 'cf.consultant_id = em.employee_id', 'inner');
            $this->db->where($t_condition);
            $this->db->order_by("cf.entry_date", "desc");
            $this->db->limit(150);

            $t_query = $this->db->get();
            $t_data = $t_query->result_array();

            if ($t_query->num_rows()) {
                foreach ($t_data as $tval) {
                    $result_arr[] = "[" . $tval['employee_code'] . "] - " . ucwords($tval['name_prefix'] . " " . $tval['first_name'] . " " . $tval['last_name']) . " added " . ucwords($tval['form_name']);
                }
            } else {
                $result_arr[] = "";
            }

            return array_filter($result_arr);
        }
        if (LATAM) {
            $result_arr = array();

            if ($employee_ids != '') {
                $employee_ids = $employee_ids;
            } else {
                $employee_ids = '0';
            }

            /* -------------------------Consultant Added Documents--------------------- */

            //$t_condition = "consultant_id in (" . $employee_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_superadmin_view = '1'";
            $t_condition = "consultant_id in (" . $employee_ids . ")  and is_superadmin_view = '1'";
            $this->db->select('*');
            $this->db->from('vms_consultant_files');
            $this->db->where($t_condition);
            $this->db->order_by("entry_date", "desc");
            $t_query = $this->db->get();
            $t_data = $t_query->result_array();

            if ($t_query->num_rows() > 0) {
                foreach ($t_data as $tval) {
                    $get_employee_details = $this->employee_model->getEmployeeData($tval['consultant_id']);
                    $get_form_details = $this->employee_model->getFormData($tval['form_no']);

                    if (!empty($get_employee_details) && !empty($get_form_details)) {

                        $result_arr[] = "[" . $get_employee_details[0]['employee_code'] . "] - " . ucwords($get_employee_details[0]['name_prefix']) . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " added " . ucwords($get_form_details[0]['document_name']);
                    } else {
                        $result_arr [] = "";
                    }
                }
            } else {
                $result_arr[] = "";
            }

        /* -------------------------Consultant Added Documents--------------------- */


            return array_filter($result_arr);
        }
    }

    public function getConsultantFileDetails($employee_ids) {

        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = '0';
        }

        $current_date = date("Y-m-d");
        $i_condition = "consultant_id in (" . $employee_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($i_condition);
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        return $i_data;
    }

   public function getVendorFileDetails($vendor_ids) {

        if ($vendor_ids != '') {
            $vendor_ids = $vendor_ids;
        } else {
            $vendor_ids = '0';
        }

        $current_date = date("Y-m-d");
        $i_condition = "vendor_id in (" . $vendor_ids . ")";
        $this->db->select('*');
        $this->db->from('vms_vendor_files');
        $this->db->where($i_condition);
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        return $i_data;
    }


    public function update_files($update_arr) {
        $this->db->update('vms_consultant_files', $update_arr);
    }

	public function update_vendorfiles($update_arr) {
        $this->db->update('vms_vendor_files', $update_arr);
    }
}
