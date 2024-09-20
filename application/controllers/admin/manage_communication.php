<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Communication extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('admin/manage_employee_model', 'employee_model');
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        $this->load->model('admin/profile_model');
        $this->load->model('admin/manage_communication_model', 'communication_model');
    }

    public function index() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_id = $data['get_details'][0]['admin_id'];

        $data['page'] = "communication";
        $data['meta_title'] = "COMPOSE";

        $this->load->view('admin/compose', $data);
    }

    public function get_recipient_emails() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $recipient_email = trim($this->input->get('term', TRUE));
        $get_recipient_email = $this->communication_model->getRecipientEmails($recipient_email, $admin_id);

        echo json_encode($get_recipient_email);
    }

    public function approve_shift_notification() {
        if (INDIA) {
            $clock_time_id = $this->input->post('clock_time_id');
            $admin_id = $this->input->post('admin_id');
            $notification_id = $this->input->post('notification_id');

            $this->communication_model->approve_notification($notification_id);

            $this->communication_model->change_employee_datewise_shift_summary_status($clock_time_id, $admin_id);
        }
    }

    public function disapprove_shift_notification() {
        if (INDIA) {
            $clock_time_id = $this->input->post('clock_time_id');
            $admin_id = $this->input->post('admin_id');
            $notification_id = $this->input->post('notification_id');

            $this->communication_model->disapprove_notification($notification_id);

            $this->communication_model->change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id);
        }
    }

    public function send_mail() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('sender_id');
        $recipient_arr = $this->input->post('recipient_arr');
        $subject = mysqli_real_escape_string($db, $this->input->post('subject'));

        $msg = str_replace("\n", "", $this->input->post('message'));
        $message = mysqli_real_escape_string($db, $msg);

        if ($message == "") {
            $this->session->set_flashdata('error_msg', 'Message field cannot be blank');
            redirect(base_url() . 'admin_compose');
        } else {

            foreach ($recipient_arr as $rval) {

                $get_superadmin_id = $this->communication_model->getSuperAdminID($rval);
                if (!empty($get_superadmin_id)) {
                    $recipients [] = $get_superadmin_id[0]['sa_id'] . "_" . "superadmin";
                }
                $get_vendor_id = $this->communication_model->getVendorID($rval);
                if (!empty($get_vendor_id)) {
                    $recipients [] = $get_vendor_id[0]['vendor_id'] . "_" . "vendor";
                }

                $get_employee_id = $this->communication_model->getEmployeeID($rval);
                if (!empty($get_employee_id)) {
                    $recipients [] = $get_employee_id[0]['employee_id'] . "_" . "employee";
                }
            }

            foreach ($recipients as $rtval) {
                $r_arr = explode("_", $rtval);
                $recipient_id = $r_arr[0];
                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $admin_id,
                    "sender_type" => "admin",
                    "subject" => $subject,
                    "message" => $message,
                    "entry_date" => date("Y-m-d H:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );

                $insert_query = $this->communication_model->add_mail($insert_arr);
            }
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            if ($insert_query != '') {

                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function sent_items() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['get_sent_mails'] = $this->communication_model->getSentMails($admin_id);

        $data['page'] = "communication";
        $data['meta_title'] = "SENT ITEMS";

        $this->load->view('admin/sent_items', $data);
    }

    public function sent_mail_details() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $mail_id = base64_decode($this->uri->segment(2));

        $data['get_sent_mail_details'] = $this->communication_model->getSentMail($mail_id, $admin_id);
        $data['admin_id'] = $admin_id;

        $data['page'] = "communication";
        $data['meta_title'] = "SENT ITEMS";

        $this->load->view('admin/sent_mail_details', $data);
    }

    public function inbox() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_id = $data['get_details'][0]['admin_id'];
        $recipient_type = "admin";

        $data['get_inbox_mails'] = $this->communication_model->getInboxMails($admin_id, $recipient_type);

        $data['page'] = "communication";
        $data['meta_title'] = "INBOX";

        $this->load->view('admin/inbox', $data);
    }

    public function inbox_mail_details() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $type = "admin";
        $mail_id = base64_decode($this->uri->segment(2));
        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $admin_id, $type);
        $data['admin_id'] = $admin_id;
        $update_arr = array(
            "is_view" => "1",
            "status" => "1"
        );
        $update_query = $this->communication_model->updateViewStatus($update_arr, $mail_id, $admin_id);

        $data['page'] = "communication";
        $data['meta_title'] = "INBOX";

        $this->load->view('admin/inbox_mail_details', $data);
    }

    public function admin_inbox_mail_reply() {

        if (!$this->session->userdata('admin_logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $mail_id = base64_decode($this->uri->segment(2));
        $recipient_id = base64_decode($this->uri->segment(3));

        $type = "admin";
        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $admin_id, $type);
        //print_r($data['get_inbox_mail_details']);
        $data['get_recipient_value'] = $this->communication_model->getRecipientValues($mail_id, $recipient_id);
        $data['get_mail_subject'] = $this->communication_model->getMailSubject($mail_id);
        $data['mail_id'] = $mail_id;
        $data['admin_id'] = $admin_id;

        $data['page'] = "communication";
        $data['meta_title'] = "REPLY";

        $this->load->view('admin/inbox_mail_reply', $data);
    }

    public function admin_send_reply() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $recipient_id = $this->input->post('recipient_id');
        $recipient_type = $this->input->post('recipient_type');
        $sender_id = $this->input->post('sender_id');
        $sender_type = $this->input->post('sender_type');
        $reply_id = $this->input->post('reply_id');
        $subject = mysqli_real_escape_string($db, $this->input->post('subject'));

        $msg = str_replace("\n", "", $this->input->post('message'));
        $message = mysqli_real_escape_string($db, $msg);


        if ($message == "") {
            $this->session->set_flashdata('error_msg', 'Message field cannot be blank');
            redirect(base_url() . 'admin_compose');
        } else {

            $insert_arr = array(
                "recipient_id" => $recipient_id,
                "recipient_type" => $recipient_type,
                "sender_id" => $sender_id,
                "sender_type" => $sender_type,
                "reply_id" => $reply_id,
                "subject" => $subject,
                "message" => $message,
                "entry_date" => date("Y-m-d h:i:s"),
                "is_deleted" => '0',
                "status" => '0'
            );

            $insert_query = $this->communication_model->add_mail($insert_arr);

//echo "<pre>";
//            print_r($insert_arr);
//            die;
            if ($insert_query != '') {

                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function get_notification_count() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $get_mail_notification = $this->communication_model->getMailNotification($admin_id);
        echo $get_mail_notification;
    }

    public function get_mail_notification() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_mails'] = $this->communication_model->getMails($admin_id);
        $this->load->view('admin/ajax/ajax_get_mails', $data);
    }

    public function get_others_notification_count() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo "na";
            exit();
        }

        if (US || LATAM) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $vendor_ids = "";
            $v_ids = "";
            $get_vendor_details = $this->vendor_model->getVendorLists($admin_id);
            if (!empty($get_vendor_details)) {
                foreach ($get_vendor_details as $vval) {
                    $vendor_ids .= $vval['vendor_id'] . ",";
                }
            }
            $v_ids = rtrim($vendor_ids, ",");

            $employee_ids = "";
            $e_ids = "";
            $get_employee_details = $this->employee_model->getEmployeeLists($admin_id);
            if (!empty($get_employee_details)) {
                foreach ($get_employee_details as $eval) {
                    $employee_ids .= $eval['employee_id'] . ",";
                }
            }
            $e_ids = rtrim($employee_ids, ",");

            $get_mail_notification = $this->communication_model->getOthersNotification($admin_id, $v_ids, $e_ids);
            //        echo $get_mail_notification;
            //        die;
            echo $get_mail_notification;
        }
        if (INDIA) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $get_mail_notification = $this->communication_model->getOthersNotification($admin_id);
        
            echo $get_mail_notification;
        }
    }

    public function get_admin_others_notification_details() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo "na";
            exit();
        }
            
        if (US || LATAM) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];
            $vendor_ids = "";
            $v_ids = "";
            $get_vendor_details = $this->vendor_model->getVendorLists($admin_id);
            if (!empty($get_vendor_details)) {
                foreach ($get_vendor_details as $vval) {
                    $vendor_ids .= $vval['vendor_id'] . ",";
                }
            }
            $v_ids = rtrim($vendor_ids, ",");
            $employee_ids = "";
            $e_ids = "";
            $get_employee_details = $this->employee_model->getEmployeeLists($admin_id);
            if (!empty($get_employee_details)) {
                foreach ($get_employee_details as $eval) {
                    $employee_ids .= $eval['employee_id'] . ",";
                }
            }
            $e_ids = rtrim($employee_ids, ",");
            $data['get_details'] = $this->communication_model->getOthersNotificationDetails($admin_id, $v_ids, $e_ids);
            $this->load->view('admin/ajax/ajax_get_notifications', $data);
        }
        if (INDIA) {
            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
            $admin_id = $data['get_details'][0]['admin_id'];

            $data['get_details'] = $this->communication_model->getAdminOthersNotificationDetails($admin_id);

            $this->load->view('admin/ajax/ajax_get_notifications', $data);
        }
    }

}
