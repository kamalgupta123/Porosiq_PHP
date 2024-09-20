<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Communication extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('vendor_logged_in')) {
            set_referer_url();
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }
        $this->load->model('vendor/manage_employee_model', 'employee_model');
        $this->load->model('vendor/manage_vendor_model', 'vendor_model');
        $this->load->model('vendor/profile_model');
        $this->load->model('vendor/manage_communication_model', 'communication_model');
    }

    public function index() {


        if (!$this->session->userdata('vendor_logged_in')) {
            set_referer_url();
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['page'] = "communication";
        $data['meta_title'] = "COMPOSE";

        $this->load->view('vendor/compose', $data);
    }

    public function get_recipient_emails() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];


        $recipient_email = trim($this->input->get('term', TRUE));
        $get_recipient_email = $this->communication_model->getRecipientEmails($recipient_email, $vendor_id, $admin_id);

        echo json_encode($get_recipient_email);
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
            redirect(base_url() . 'vendor_compose');
        } else {

            foreach ($recipient_arr as $rval) {

                $get_superadmin_id = $this->communication_model->getSuperAdminID($rval);
                if (!empty($get_superadmin_id)) {
                    $recipients [] = $get_superadmin_id[0]['sa_id'] . "_" . "superadmin";
                }

                $get_admin_id = $this->communication_model->getAdminID($rval);
                if (!empty($get_admin_id)) {
                    $recipients [] = $get_admin_id[0]['admin_id'] . "_" . "admin";
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
                    "sender_type" => "vendor",
                    "subject" => $subject,
                    "message" => $message,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );

                $insert_query = $this->communication_model->add_mail($insert_arr);
            }

            if ($insert_query != '') {

                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function sent_items() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_sent_mails'] = $this->communication_model->getSentMails($vendor_id);

        $data['page'] = "communication";
        $data['meta_title'] = "SENT ITEMS";

        $this->load->view('vendor/sent_items', $data);
    }

    public function sent_mail_details() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $mail_id = base64_decode($this->uri->segment(2));

        $data['get_sent_mail_details'] = $this->communication_model->getSentMail($mail_id, $vendor_id);

        $data['page'] = "communication";
        $data['meta_title'] = "SENT ITEMS";

        $this->load->view('vendor/sent_mail_details', $data);
    }

    public function inbox() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $recipient_type = "vendor";

        $data['get_inbox_mails'] = $this->communication_model->getInboxMails($vendor_id, $recipient_type);

        $data['page'] = "communication";
        $data['meta_title'] = "INBOX";

        $this->load->view('vendor/inbox', $data);
    }

    public function inbox_mail_details() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $type = "vendor";
        $mail_id = base64_decode($this->uri->segment(2));
        $data['vendor_id'] = $vendor_id;
        $update_arr = array(
            "is_view" => "1",
            "status" => "1"
        );
        $update_query = $this->communication_model->updateViewStatus($update_arr, $mail_id, $vendor_id);
        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $vendor_id, $type);

        $data['page'] = "communication";
        $data['meta_title'] = "INBOX";

        $this->load->view('vendor/inbox_mail_details', $data);
    }

    public function vendor_inbox_mail_reply() {

        if (!$this->session->userdata('vendor_logged_in')) {
            redirect(base_url() . 'vendor'); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['vendor_id'] = $data['get_details'][0]['vendor_id'];
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];
        $data['vendor_id'] = $vendor_id;

        $type = "vendor";
        $mail_id = base64_decode($this->uri->segment(2));
        $recipient_id = base64_decode($this->uri->segment(3));

        $data['get_inbox_mail_details'] = $this->communication_model->getInboxMailDetails($mail_id, $vendor_id, $type);
        $data['get_recipient_value'] = $this->communication_model->getRecipientValues($mail_id, $recipient_id);
        $data['get_mail_subject'] = $this->communication_model->getMailSubject($mail_id);
        $data['mail_id'] = $mail_id;

        $data['page'] = "communication";
        $data['meta_title'] = "REPLY";

        $this->load->view('vendor/inbox_mail_reply', $data);
    }

    public function vendor_send_reply() {

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
            redirect(base_url() . 'vendor_compose');
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
        if (!$this->session->userdata('vendor_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $get_mail_notification = $this->communication_model->getMailNotification($vendor_id);
        echo $get_mail_notification;
    }

    public function get_mail_notification() {
        if (!$this->session->userdata('vendor_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];

        $data['get_mails'] = $this->communication_model->getMails($vendor_id);
        $this->load->view('vendor/ajax/ajax_get_mails', $data);
    }

    public function get_others_notification_count() {
        if (!$this->session->userdata('vendor_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_ids = "";
        $e_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeListsByVendor($vendor_id);
        if (!empty($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $employee_ids .= $eval['employee_id'] . ",";
            }
        }
        $e_ids = rtrim($employee_ids, ",");

        $get_mail_notification = $this->communication_model->getOthersNotification($admin_id, $vendor_id, $e_ids);
//        echo $get_mail_notification;
//        die;
        echo $get_mail_notification;
    }

    public function get_vendor_others_notification_details() {
        if (!$this->session->userdata('vendor_logged_in')) {
            echo "na";
            exit();
        }

        $sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $vendor_id = $data['get_details'][0]['vendor_id'];
        $admin_id = $data['get_details'][0]['admin_id'];

        $employee_ids = "";
        $e_ids = "";
        $get_employee_details = $this->employee_model->getEmployeeListsByVendor($vendor_id);
        if (!empty($get_employee_details)) {
            foreach ($get_employee_details as $eval) {
                $employee_ids .= $eval['employee_id'] . ",";
            }
        }
        $e_ids = rtrim($employee_ids, ",");

        $data['get_details'] = $this->communication_model->getOthersNotificationDetails($admin_id, $vendor_id, $e_ids);
//        echo "<pre>";
//        print_r($get_details);
//        die;
        $this->load->view('vendor/ajax/ajax_get_notifications', $data);
    }

}
