<?php

Class Manage_Communication_Model extends CI_Model {

    public function getRecipientEmails($recipient_email, $admin_id) {
        $condition = "status = '1'";
        $this->db->select('distinct(sa_email)');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $this->db->like('sa_email', $recipient_email);
        $superadmin_query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $condition = "status = '1' and block_status = '1' and admin_id = '" . $admin_id . "'";
        $this->db->select('distinct(vendor_email)');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->like('vendor_email', $recipient_email);
        $vendor_query = $this->db->get();

        $condition = "employee_email != '' and admin_id = '" . $admin_id . "'";
        $this->db->select('distinct(employee_email)');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->like('employee_email', $recipient_email);
        $employee_query = $this->db->get();
//echo $this->db->last_query();
//        die;
        $superadmin_email = array();
        $vendor_email = array();
        $employee_email = array();

        if ($superadmin_query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();

            foreach ($superadmin_query->result() as $superadmin_row) {
                $superadmin_email[] = $superadmin_row->sa_email;
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

        if (!empty($superadmin_email) || !empty($vendor_email) || !empty($employee_email)) {
            $mails_arr = array_unique(array_merge($superadmin_email, $vendor_email, $employee_email));
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

        $condition = "sa_email = '" . trim($rval) . "'";
        $this->db->select('sa_id');
        $this->db->from('vms_superadmin_master');
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

    public function getSentMails($admin_id) {
        $condition = "sender_id = '" . $admin_id . "'";
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
        $condition = "(reply_id = '" . $mail_id . "' || id = '" . $mail_id . "') and sender_id = '" . $sender_id . "'";
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
//        die;
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

    public function getInboxMails($admin_id, $recipient_type) {
        $condition = "recipient_id = '" . $admin_id . "' and recipient_type = '" . $recipient_type . "'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $this->db->group_by('subject');
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
        $condition = "(reply_id = '" . $mail_id . "' || id = '" . $mail_id . "') and recipient_id = '" . $recipient_id . "' and recipient_type = '" . $type . "'";
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

    public function getInboxMailNotification($admin_id, $recipient_type) {
        $condition = "recipient_id = '" . $admin_id . "' and recipient_type = '" . $recipient_type . "' and reply_id='0' and is_view = '0'";
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

    public function getMailNotification($admin_id) {

        $condition = "recipient_id ='" . $admin_id . "' and recipient_type = 'admin' and is_view = '0'";
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

    public function getMails($admin_id) {

        $condition = "recipient_id ='" . $admin_id . "' and recipient_type = 'admin' and is_view = '0'";
        $this->db->select('*');
        $this->db->from('vms_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateViewStatus($update_arr, $mail_id, $admin_id) {
        $condition = "(id = '" . $mail_id . "' or reply_id = '" . $mail_id . "') and recipient_id = '" . $admin_id . "'";
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

    public function getOthersNotification($admin_id) {
        if (INDIA) {
            $sql="Select count(*) as count from notification WHERE sent_to = $admin_id AND is_sent_to_admin = 1 AND status=1 and is_approved IS NULL";    
            $query = $this->db->query($sql);
            $res = $query->result_array();
            $count = $res[0]['count'];

            return $count;
        }
    }

    // if INDIA up code, LATAM US Down commented code
    /*
    public function getOthersNotification($admin_id, $vendor_ids, $employee_ids) {

        if (US || LATAM) {
            if ($employee_ids != '') {
                $employee_ids = $employee_ids;
            } else {
                $employee_ids = '0';
            }

            if ($vendor_ids != '') {
                $vendor_ids = $vendor_ids;
            } else {
                $vendor_ids = '0';
            }

            $tot_count = "";
            $current_date = date("Y-m-d");

            // -------------------------Consultant Added Timesheet---------------------


            //$t_condition = "employee_id in (" . $employee_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
            $t_condition = "employee_id in (" . $employee_ids . ") and is_view = '1'";
            $this->db->select('*');
            $this->db->from('vms_project_timesheet_master');
            $this->db->where($t_condition);
            $t_query = $this->db->get();
            if ($t_query->num_rows() > 0) {
                $t_num = $t_query->num_rows();
            } else {
                $t_num = 0;
            }

            // -------------------------Consultant Added Timesheet---------------------

            // -------------------------Vendor Assigned Counsultant On Project---------------------

            //$p_condition = "employee_id in (" . $employee_ids . ") and vendor_id in (" . $vendor_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
            $p_condition = "employee_id in (" . $employee_ids . ") and vendor_id in (" . $vendor_ids . ")  and is_view = '1'";
            $this->db->select('*');
            $this->db->from('vms_assign_projects_to_employee');
            $this->db->where($p_condition);
            $p_query = $this->db->get();
            //        echo $this->db->last_query();
            if ($p_query->num_rows() > 0) {
                $p_num = $p_query->num_rows();
            } else {
                $p_num = 0;
            }

            // -------------------------Vendor Assigned Counsultant On Project---------------------

            // -------------------------Vendor Generated Invoice---------------------

            //$i_condition = "vendor_id in (" . $vendor_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
            $i_condition = "vendor_id in (" . $vendor_ids . ") and is_view = '1'";
            $this->db->select('*');
            $this->db->from('vms_payment_master');
            $this->db->where($i_condition);
            $i_query = $this->db->get();
            //        echo $this->db->last_query();
            if ($i_query->num_rows() > 0) {
                $i_num = $i_query->num_rows();
            } else {
                $i_num = 0;
            }

            // -------------------------Vendor Generated Invoice---------------------

            // -------------------------Get Invoice Notification Mail---------------------

            //$n_condition = "recipient_id = '" . $admin_id . "' and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
            $n_condition = "recipient_id = '" . $admin_id . "' and is_view = '1'";
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

            // -------------------------Get Invoice Notification Mail---------------------

            $tot_count = $t_num + $p_num + $i_num + $n_num;
            return $tot_count;
        }
    }
    */

    public function getOthersNotificationDetails($admin_id, $vendor_ids, $employee_ids) {

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

        if ($vendor_ids != '') {
            $vendor_ids = $vendor_ids;
        } else {
            $vendor_ids = '0';
        }

        /* -------------------------Consultant Added Timesheet--------------------- */

        //$t_condition = "employee_id in (" . $employee_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
        $t_condition = "employee_id in (" . $employee_ids . ") and is_view = '1'";
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

        /* -------------------------Vendor Assigned Counsultant On Project--------------------- */

        //$p_condition = "employee_id in (" . $employee_ids . ") and vendor_id in (" . $vendor_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
        $p_condition = "employee_id in (" . $employee_ids . ") and vendor_id in (" . $vendor_ids . ") and is_view = '1'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($p_condition);
        $this->db->order_by("entry_date", "desc");
        $p_query = $this->db->get();
        $p_data = $p_query->result_array();
        //echo $this->db->last_query();
        if ($p_query->num_rows() > 0) {
            foreach ($p_data as $pval) {
                $get_employee_details = $this->employee_model->getEmployeeData($pval['employee_id']);
                $get_vendor_details = $this->employee_model->getVendorDtls($pval['vendor_id']);
                $get_project_details = $this->employee_model->getProjectData($pval['project_id']);


                if (!empty($get_employee_details) && !empty($get_project_details) && !empty($get_vendor_details)) {

                    $result_arr[] = "[" . $get_employee_details[0]['employee_code'] . "] - " . ucwords($get_employee_details[0]['name_prefix']) . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is assigned by " . ucwords($get_vendor_details[0]['name_prefix']) . " " . ucwords($get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']) . " for project [" . $get_project_details[0]['project_code'] . "] - " . ucwords($get_project_details[0]['project_name']);
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Vendor Assigned Counsultant On Project--------------------- */

        /* -------------------------Vendor Generated Invoice--------------------- */

        //$i_condition = "vendor_id in (" . $vendor_ids . ") and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
        $i_condition = "vendor_id in (" . $vendor_ids . ") and is_view = '1'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($i_condition);
        $this->db->order_by("entry_date", "desc");
        $i_query = $this->db->get();
        $i_data = $i_query->result_array();
        if ($i_query->num_rows() > 0) {
            foreach ($i_data as $ival) {
                $get_employee_details = $this->employee_model->getEmployeeData($ival['employee_id']);
                $get_vendor_details = $this->employee_model->getVendorDtls($ival['vendor_id']);

                if (!empty($get_employee_details) && !empty($get_vendor_details)) {

                    $result_arr[] = "New invoice is generated by " . ucwords($get_vendor_details[0]['name_prefix']) . " " . ucwords($get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']);
                } else {
                    $result_arr [] = "";
                }
            }
        } else {
            $result_arr [] = "";
        }

        /* -------------------------Vendor Generated Invoice--------------------- */

        /* -------------------------Get Invoice Notification Mail--------------------- */

        //$n_condition = "recipient_id = '" . $admin_id . "' and DATE(entry_date) = '" . $current_date . "' and is_view = '0'";
        $n_condition = "recipient_id = '" . $admin_id . "' and is_view = '1'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($n_condition);
        $n_query = $this->db->get();
        $n_data = $n_query->result_array();
        if ($n_query->num_rows() > 0) {
            foreach ($n_data as $nval) {
                $get_admin_details = $this->employee_model->getAdminDetails($nval['recipient_id']);
                $get_vendor_details = $this->employee_model->getVendorDtls($nval['sender_id']);
                $get_invoice_details = $this->employee_model->checkInvoiceStatus($nval['invoice_id']);

                if (!empty($get_admin_details) && !empty($get_vendor_details) && !empty($get_invoice_details)) {

                    $result_arr[] = ucwords($get_vendor_details[0]['vendor_company_name']) . " is commented for invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
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

    public function getAdminOthersNotificationDetails($admin_id) {
        if (INDIA) {
            $i_condition = "sent_to = " . $admin_id . " and is_sent_to_admin = 1 and status=1 and is_approved IS NULL";
            $this->db->select('id,description,clock_time_id');
            $this->db->from('notification');
            $this->db->where($i_condition);
            $this->db->order_by("created_time", "desc");
            $this->db->limit(5);
            $i_query = $this->db->get();
            $i_data = $i_query->result_array();
            if ($i_query->num_rows() > 0) {

                foreach ($i_data as $ival) {

                    $array = str_split($ival['description'], 44); 

                    $desc = implode("<br>",$array);

                    // <a href='".site_url('admin_notifications/'.$ival['id'])."'
                    
                    $result_arr[] = "<a href='#' class='tooltip-demo'>".$ival['description']."<div class='tooltiptext'>".$desc."<br><br><button class='btn btn-primary approve_notification' data-admin-id='".$admin_id."' data-notification-id='".$ival['id']."' data-clock-time-id='".$ival['clock_time_id']."'>Approve</button><button class='btn btn-danger disapprove_notification' data-admin-id='".$admin_id."' data-notification-id='".$ival['id']."' data-clock-time-id='".$ival['clock_time_id']."'>Deny</button></div></a>";

                }
            } else {
                $result_arr [] = "";
            }

            // print_r($result_arr);
            // exit;

            return array_filter($result_arr);
        }
    }

    public function getBellNotification($notification_id) {
        if (INDIA) {
            $this->db->select('*');
            $this->db->from('notification');
            $this->db->where('id', $notification_id);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    



    public function getAllNotification($admin_id) {
        if (INDIA) {
            $i_condition = "sent_to = " . $admin_id . " and is_sent_to_admin = 1";
            $this->db->select('id,description,clock_time_id');
            $this->db->from('notification');
            $this->db->where($i_condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;  
        }
    }

    public function change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id) {
        if (INDIA) { 
            $data = [
                'is_approved_by_admin' => 0,
                'admin_approver' => $admin_id,
            ];

            $this->db->where('id', $clock_time_id);
            $this->db->update('vms_employee_clock_time', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function change_employee_datewise_shift_summary_status($clock_time_id, $admin_id) {
        if (INDIA) {
            $data = [
                'is_approved_by_admin' => 1,
                'admin_approver' => $admin_id,
            ];

            $this->db->where('id', $clock_time_id);
            $this->db->update('vms_employee_clock_time', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function approve_notification($notification_id) {
        if (INDIA) {
            $data = [
                'is_approved' => 1
            ];

            $this->db->where('id', $notification_id);
            $this->db->update('notification', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function disapprove_notification($notification_id) {
        if (INDIA) {
            $data = [
                'is_approved' => 0
            ];

            $this->db->where('id', $notification_id);
            $this->db->update('notification', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }




    public function update_notification_status($notification_id) {
        if (INDIA) {
            $update_arr = [
                'status' => 0
            ];
            $this->db->where('id', $notification_id);
            $this->db->update(DBASE.'.notification', $update_arr);
            return true;
        }
    }


    public function getTimesheetDetails($admin_id) {
        // $employee_ids

        $sql = "SELECT vptm.start_time, vptm.end_time, vptm.comment, vptm.project_date, vptm.tot_time, vptm.over_time, vem.employee_code, vem.name_prefix, vem.first_name, vem.last_name, vpm.project_code, vpm.project_name FROM vms_project_timesheet_master vptm LEFT JOIN vms_employee_master vem ON vptm.employee_id = vem.employee_id LEFT JOIN vms_project_master vpm ON vptm.project_id = vpm.id WHERE vptm.employee_id IN (SELECT employee_id FROM vms_employee_master WHERE admin_id = '$admin_id' ORDER BY employee_id DESC) ORDER BY vptm.entry_date DESC";

        // if ($employee_ids != '') {
        //     $employee_ids = $employee_ids;
        // } else {
        //     $employee_ids = '0';
        // }

        // $t_condition = "employee_id in (" . $employee_ids . ")";
        // $this->db->select('*');
        // $this->db->from('vms_project_timesheet_master');
        // $this->db->where($t_condition);
        // $this->db->order_by("entry_date", "desc");
        // $t_query = $this->db->get();
        $t_query = $this->db->query($sql);
        $t_data = $t_query->result_array();
        return $t_data;
    }

    public function getAssignedDetails($admin_id) {

        // if ($employee_ids != '') {
        //     $employee_ids = $employee_ids;
        // } else {
        //     $employee_ids = '0';
        // }

        // if ($vendor_ids != '') {
        //     $vendor_ids = $vendor_ids;
        // } else {
        //     $vendor_ids = '0';
        // }

        // $p_condition = "employee_id in (" . $employee_ids . ") and vendor_id in (" . $vendor_ids . ")";
        // $this->db->select('*');
        // $this->db->from('vms_assign_projects_to_employee');
        // $this->db->where($p_condition);
        // $this->db->order_by("entry_date", "desc");
        // $p_query = $this->db->get();

        $sql = "SELECT vem.employee_code, vem.name_prefix, vem.first_name, vem.last_name, vem.file, vem.employee_designation, vem.employee_category, vem.address, vem.phone_no, vem.fax_no, vem.date_of_joining, vem.resume_file, vem.employee_bill_rate, vem.employee_pay_rate, vvm.name_prefix AS vendor_name_prefix, vvm.first_name AS vendor_first_name, vvm.last_name AS vendor_last_name, vpm.project_code, vpm.project_name, vaptm.entry_date FROM vms_assign_projects_to_employee vaptm LEFT JOIN vms_employee_master vem ON vaptm.employee_id = vem.employee_id LEFT JOIN vms_project_master vpm ON vaptm.project_id = vpm.id LEFT JOIN vms_vendor_master vvm ON vaptm.vendor_id = vvm.vendor_id WHERE vaptm.employee_id IN (SELECT employee_id FROM vms_employee_master WHERE admin_id = '$admin_id' ORDER BY employee_id DESC) AND vaptm.vendor_id IN (SELECT vendor_id FROM vms_vendor_master WHERE is_delete = '0' ORDER BY vendor_id DESC) ORDER BY entry_date DESC";

        $p_query = $this->db->query($sql);

        $p_data = $p_query->result_array();
        return $p_data;
    }

    public function getInvoiceDetails() {

        // if ($vendor_ids != '') {
        //     $vendor_ids = $vendor_ids;
        // } else {
        //     $vendor_ids = '0';
        // }

        // $i_condition = "vendor_id in (" . $vendor_ids . ")";
        // $this->db->select('*');
        // $this->db->from('vms_payment_master');
        // $this->db->where($i_condition);
        // $this->db->order_by("entry_date", "desc");

        $sql = "SELECT vem.employee_code, vem.first_name, vem.last_name, vem.employee_designation, vvm.name_prefix AS vendor_name_prefix, vvm.first_name AS vendor_first_name, vvm.last_name AS vendor_last_name, vvm.vendor_company_name, vpm.entry_date, vpm.invoice_code, vpm.start_date, vpm.end_date, vpm.month, vpm.year, vpm.work_duration, vpm.tot_time, vpm.bill_rate, vpm.tot_time_pay, vpm.over_time, vpm.ot_rate, vpm.over_time_pay, vpm.status, vpm.payment_type FROM vms_payment_master vpm LEFT JOIN vms_employee_master vem ON vpm.employee_id = vem.employee_id LEFT JOIN vms_vendor_master vvm ON vpm.vendor_id = vvm.vendor_id WHERE vpm.vendor_id IN (SELECT vendor_id FROM vms_vendor_master WHERE is_delete = '0' ORDER BY vendor_id DESC) ORDER BY entry_date DESC";

        $i_query = $this->db->query($sql);
        $i_data = $i_query->result_array();
        return $i_data;
    }

    public function getInvoiceNotificationsDetails($admin_id) {
        // $current_date = date("Y-m-d");
        // $i_condition = "recipient_id = '" . $admin_id . "'";
        // $this->db->select('*');
        // $this->db->from('vms_payment_mail_master');
        // $this->db->where($i_condition);
        // $this->db->order_by("entry_date", "desc");
        $sql = "SELECT vpmm.invoice_id, vpmm.sender_id, vpmm.recipient_id, vpmm.entry_date, vpmm.invoice_id, vpmm.subject, vpmm.message, vpmm.recipient_type, vpmm.sender_type, vpmm.id, vpm.invoice_code FROM vms_payment_mail_master vpmm  LEFT JOIN vms_payment_master vpm ON vpmm.invoice_id = vpm.id WHERE vpmm.recipient_id = '$admin_id' ORDER BY vpmm.entry_date DESC";

        $i_query = $this->db->query($sql);
        $i_data = $i_query->result_array();
        return $i_data;
    }

    public function update_timesheet($update_arr) {
        $this->db->update('vms_project_timesheet_master', $update_arr);
    }

    public function update_assign_details($update_arr) {
        $this->db->update('vms_assign_projects_to_employee', $update_arr);
    }

    public function update_invoice_details($update_arr) {
        $this->db->update('vms_payment_master', $update_arr);
    }

    public function update_inv_notification_details($update_arr) {
        $this->db->update('vms_payment_mail_master', $update_arr);
    }

}
