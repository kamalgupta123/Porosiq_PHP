<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Communication extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('superadmin/manage_vendor_model', 'vendor_model');
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
        $this->load->model('superadmin/manage_employee_model', 'employee_model');
    }

    public function index() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data["page"] = "communication";
        $data['meta_title'] = "COMPOSE";
        $this->load->view('superadmin/compose', $data);
    }

    public function get_recipient_emails() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $recipient_email = trim($this->input->get('term', TRUE));
        $get_recipient_email = $this->communication_model->getRecipientEmails($recipient_email);

        echo json_encode($get_recipient_email);
    }

    public function send_mail() {
        $recipients = array();
        $db = get_instance()->db->conn_id;
        $sa_id = $this->input->post('sender_id');
        $recipient_arr = $this->input->post('recipient_arr');
        $subject = mysqli_real_escape_string($db, $this->input->post('subject'));

        $msg = str_replace("\n", "", $this->input->post('message'));
        $message = mysqli_real_escape_string($db, $msg);

//        echo $message;
//        die;



        if ($message == "") {
            $this->session->set_flashdata('error_msg', 'Message field cannot be blank');
            redirect(base_url() . 'compose');
        } else {

            foreach ($recipient_arr as $rval) {

                $get_admin_id = $this->communication_model->getAdminID($rval);
                if (!empty($get_admin_id)) {
                    $recipients [] = $get_admin_id[0]['admin_id'] . "_" . "admin";
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
//echo "<pre>";
//            print_r($recipients);
//            die;
            foreach ($recipients as $rtval) {
                $r_arr = explode("_", $rtval);
                $recipient_id = $r_arr[0];
                $recipient_type = $r_arr[1];

                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => $subject,
                    "message" => $message,
                    "entry_date" => date("Y-m-d h:i:s"),
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

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $sender_type = "superadmin";

        $data['get_sent_mails'] = $this->communication_model->getSentMailsAll($sender_type);

        $data["page"] = "communication";
        $data['meta_title'] = "SENT ITEMS";
        $this->load->view('superadmin/sent_items', $data);
    }

    public function sent_mail_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;
        $sender_type = "superadmin";
        $mail_id = base64_decode($this->uri->segment(2));

        $data['get_sent_mail_details'] = $this->communication_model->getSentMail($mail_id, $sa_id);
        $data["page"] = "communication";
        $data['meta_title'] = "SENT ITEMS";
        $this->load->view('superadmin/sent_mail_details', $data);
    }

    public function inbox() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $recipient_type = "superadmin";

//        $data['get_inbox_mails'] = $this->communication_model->getInboxMails($sa_id, $recipient_type);
        $data['get_inbox_mails'] = $this->communication_model->getInboxMailsAll($recipient_type);

        $data["page"] = "communication";
        $data['meta_title'] = "INBOX";
        $this->load->view('superadmin/inbox', $data);
    }

    public function inbox_mail_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $type = "superadmin";
        $mail_id = base64_decode($this->uri->segment(2));

        $data['sa_id'] = $sa_id;

        $update_arr = array(
            "is_view" => "1",
            "status" => "1"
        );
        $update_query = $this->communication_model->updateViewStatus($update_arr, $mail_id, $type);
        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $type);
        $data["page"] = "communication";
        $data['meta_title'] = "INBOX";
        $this->load->view('superadmin/inbox_mail_details', $data);
    }

    public function inbox_mail_reply() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;
        $type = "superadmin";
        $mail_id = base64_decode($this->uri->segment(2));
        $recipient_id = base64_decode($this->uri->segment(3));

        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $type);
        $data['get_recipient_value'] = $this->communication_model->getRecipientValues($mail_id, $recipient_id);
        $data['get_mail_subject'] = $this->communication_model->getMailSubject($mail_id);
        $data['mail_id'] = $mail_id;
        $data['sa_id'] = $sa_id;
        $data["page"] = "communication";
        $data['meta_title'] = "REPLY";
        $this->load->view('superadmin/inbox_mail_reply', $data);
    }

    public function send_reply() {
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
            redirect(base_url() . 'compose');
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
        if (!$this->session->userdata('logged_in')) {
            echo "na"; // This string is required by the jQuery response.
            exit();
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        echo $this->communication_model->getMailNotification($sa_id);
    }

    public function get_mail_notification() {
        if (!$this->session->userdata('logged_in')) {
            echo "na"; // This string is required by the jQuery response.
            exit();
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_details = $this->profile_model->getDetails($email);
        $sa_id = $get_details[0]['sa_id'];

        $data['get_mails'] = $this->communication_model->getMails($sa_id);
        $this->load->view('superadmin/ajax/ajax_get_mails', $data);
    }

    public function get_others_notification_count() {
        if (!$this->session->userdata('logged_in')) {
            echo "na"; // This string is required by the jQuery response.
            exit();
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_details = $this->profile_model->getDetails($email);
        $sa_id = $get_details[0]['sa_id'];

        $emp_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeLists('employee_id');
        if (!empty($get_employee_details) && count($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $emp_ids .= $eval['employee_id'] . ",";
            }
        }
        $emp_ids = rtrim($emp_ids, ",");

        echo $this->communication_model->getOthersNotification($sa_id, $emp_ids);
    }

    public function get_superadmin_others_notification_details() {
        if (!$this->session->userdata('logged_in')) {
            echo "na"; // This string is required by the jQuery response.
            exit();
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_details = $this->profile_model->getDetails($email);
        $sa_id = $get_details[0]['sa_id'];

        $emp_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeLists('employee_id');
        if (!empty($get_employee_details) && count($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $emp_ids .= $eval['employee_id'] . ",";
            }
        }
        $emp_ids = rtrim($emp_ids, ",");

        $data['result_values'] = $this->communication_model->getOthersNotificationDetails($sa_id, $emp_ids);
        
        $this->load->view('superadmin/ajax/ajax_get_notifications', $data);
    }

}
