<?php
session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            set_referer_url();
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $this->load->model('superadmin/manage_employee_model', 'employee_model');
        $this->load->model('superadmin/manage_vendor_model', 'vendor_model');
        $this->load->model('superadmin/profile_model');
        $this->load->model('superadmin/manage_communication_model', 'communication_model');
        $this->load->model('superadmin/manage_menu_model', 'menu_model');
		$this->load->model('superadmin/manage_ten99_model', 'ten99_model');
    }

    public function index() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_vendor'] = $this->vendor_model->getVendorLists();
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT ADD";
        $this->load->view('superadmin/add_employee_user', $data);
    }

    public function employee_lists() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        
        if (DEMO) {
            $data['get_employee_details'] = $this->employee_model->getEmployeeLists();
        }

        if (INDIA) {
            $data['get_employee_details'] = $this->employee_model->getEmployeeListsIntegrated();
        }

        $data['employee_lists'] = "employee_lists";
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT LISTS";
        $data['super_admin_email']=$email;
        $this->load->view('superadmin/employee_lists', $data);
    }

    public function all_employee_current_status() {
        
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        // $admin_id = $data['get_details'][0]['admin_id'];

        // $employee_id = base64_decode($this->uri->segment(2));
        $data['get_all_employees_list'] = $this->employee_model->get_all_employees_list();

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/all_employee_current_status', $data);
    }

    public function insert_shift_break_form_data(){
        // $this->session->unset_userdata('shift_break_modal_form_data');
        // $this->session->set_userdata('shift_break_modal_form_data', $_POST);
        print_r($this->session->userdata('session_clock_time_id'));

        date_default_timezone_set('America/Chicago');

        $i=0;
        foreach($_POST['break_type'] as $break_type) {
            $this->employee_model->insert_shift_break_form_data($this->session->userdata('clock_break_data_employee_id'), $this->session->userdata('session_clock_time_id'), $break_type,$_POST['start_date'][$i], $_POST['start_time'][$i], $_POST['end_date'][$i], $_POST['end_time'][$i],$_POST['paid'][$i],$_POST['comment'][$i], $this->session->userdata('clock_break_data_admin_id'), date("Y-m-d H:i:s"));
            $i++;
        }
        // $shift_break_data = $this->session->userdata('shift_break_modal_form_data');
        // print_r($shift_break_data); 
        // print_r($this->session->userdata('shift_break_modal_form_data'));
    }

    public function add_admin_employee_shift() {

        date_default_timezone_set('America/Chicago');
        // echo "test";
        // print_r($_SESSION);
        // print_r($this->session->userdata('shift_break_modal_form_data'));
        // exit;
        if ($_POST['clock_id']) {

            $c = 0;
            foreach($_POST['clock_id'] as $cid) {
                if ($cid) {
                    $this->employee_model->update_clock_admin_data($_POST['clock_in_date'][$c],$_POST['clock_in_time'][$c], $_POST['clock_out_date'][$c], $_POST['clock_out_time'][$c], $_POST['comment'][$c], $cid);
                }
                $c++;
            }

            $t = 0;
            foreach($_POST['training_break'] as $tr) {
                if ($tr) {
                    $this->employee_model->update_training_break_admin($_POST['training_break_start_date'][$t], $_POST['training_break_start_time'][$t], $_POST['training_break_end_date'][$t], $_POST['training_break_end_time'][$t], $_POST['comment_t'][$t], $tr);
                }
                $t++;
            }
            $p = 0;
            foreach($_POST['personal_break'] as $pr) {
                if ($pr) {
                    $this->employee_model->update_personal_break_admin($_POST['personal_break_start_date'][$p], $_POST['personal_break_start_time'][$p], $_POST['personal_break_end_date'][$p], $_POST['personal_break_end_time'][$p], $_POST['comment_p'][$p], $pr);
                }  
                $p++;
            }
            $m = 0;
            foreach($_POST['meeting_break'] as $me) {
                if ($me) {
                    $this->employee_model->update_meeting_break_admin($_POST['meeting_break_start_date'][$m], $_POST['meeting_break_start_time'][$m], $_POST['meeting_break_end_date'][$m], $_POST['meeting_break_end_time'][$m],$_POST['comment_m'][$m], $me);
                }
                $m++;
            }

            $l = 0;
            foreach($_POST['lunch_break'] as $lu) {
                if ($lu) {
                    $this->employee_model->update_lunch_break_admin($_POST['lunch_break_start_date'][$l], $_POST['lunch_break_start_time'][$l], $_POST['lunch_break_end_date'][$l], $_POST['lunch_break_end_time'][$l], $_POST['comment_l'][$l], $lu);
                }
                $l++;
            }

            $this->session->unset_userdata('shift_break_modal_form_data');
            $this->session->set_flashdata('succ_msg', 'Shift Updated Successfully');
            redirect(base_url().'superadmin-addEdit-employee-shifthours');
        }
        else {
            $clock_in_date = $_POST['clock_in_date'];
            $clock_in_time = $_POST['clock_in_time'];
            $clock_out_date = $_POST['clock_out_date'];
            $clock_out_time = $_POST['clock_out_time'];

            $insert_data = [
                'employee_id' => $this->session->userdata('clock_break_data_employee_id'),
                'shift_id' => $this->session->userdata('clock_break_data_shift_id'),
                'clock_in' => date('Y-m-d H:i:s', strtotime("$clock_in_date $clock_in_time")),
                'clock_out' => date('Y-m-d H:i:s', strtotime("$clock_out_date $clock_out_time")),
                'comment' => $_POST['comment'],
                'created_by' => $this->session->userdata('clock_break_data_admin_id'),
                'created_time' => date("Y-m-d H:i:s"),
                'clock_in_ipaddress' => getenv("REMOTE_ADDR"),
            ];

            $insert_id = $this->employee_model->insert_clock_data_admin($insert_data);

            // $shift_break_modal_form_data = $this->session->userdata('shift_break_modal_form_data');
            
            // // print_r($this->session->userdata('shift_break_modal_form_data'));
            // // exit;
            
            // $i=0;
            // foreach($shift_break_modal_form_data['break_type'] as $break_type) {
            //     $this->employee_model->insert_shift_break_form_data($this->session->userdata('clock_break_data_employee_id'), $insert_id, $break_type,$shift_break_modal_form_data['start_date'][$i], $shift_break_modal_form_data['start_time'][$i], $shift_break_modal_form_data['end_date'][$i], $shift_break_modal_form_data['end_time'][$i],$shift_break_modal_form_data['paid'][$i],$shift_break_modal_form_data['comment'][$i], $this->session->userdata('clock_break_data_employee_id'), date("Y-m-d H:i:s"));
            //     $i++;
            // }

            $this->session->unset_userdata('shift_break_modal_form_data');
            $this->session->set_flashdata('succ_msg', 'Shift Added Successfully');
            redirect(base_url().'superadmin-addEdit-employee-shifthours');
        }
    }

    public function get_employee_clock_data() {
        $date = $this->input->post('date');
        $employee_id = $this->input->post('employee_id');

        $this->session->unset_userdata('shift_break_modal_form_data');
        $this->session->set_userdata('clock_break_data_employee_id', $employee_id);
        $this->session->set_userdata('clock_break_data_date', date("Y-m-d H:i:s", strtotime($date)));

        $shift_id_data = $this->employee_model->get_employee_shift_id($employee_id);
        $shift_id_val = $shift_id_data[0]['shift_id'];

        $this->session->set_userdata('clock_break_data_shift_id', $shift_id_val);
        
        $clock_data = $this->employee_model->get_employee_clock_data($employee_id,$date);

        $clock_data_main = $this->employee_model->get_employee_clock_data_main($employee_id,$date);
        // echo "<pre>".print_r($clock_data_main,1)."</pre>";

        $show_add_break = false;

        $clock_str = "<tr>";
        if (!empty($clock_data_main)) {
            foreach ($clock_data_main as $c) {
                if (!empty($c->clock_in)) {

                    $clock_in_date = date("Y-m-d", strtotime($c->clock_in));
                    $clock_in_time = date("H:i:s", strtotime($c->clock_in));
                    
                    $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' name='clock_in_date[]' class='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' id='clock_in_time' name='clock_in_time[]' class='clock_in_time validate[required]' value='".$clock_in_time."'></td>";
                }
                else {

                    $clock_in_date = date("Y-m-d", strtotime($date));

                    $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' name='clock_in_date[]' class='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' id='clock_in_time' name='clock_in_time[]' class='clock_in_time validate[required]'></td>";
                }
                if (!empty($c->clock_out)) {

                    $clock_out_date = date("Y-m-d", strtotime($c->clock_out));
                    $clock_out_time = date("H:i:s", strtotime($c->clock_out));
                    
                    $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' name='clock_out_date[]' class='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' id='clock_out_time' name='clock_out_time[]' class='clock_out_time validate[required]' value='".$clock_out_time."'></td>";
                }
                else {

                    $clock_out_date = date("Y-m-d", strtotime($date));

                    $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' name='clock_out_date[]' class='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' id='clock_out_time' name='clock_out_time[]' class='clock_out_time validate[required]'></td>";
                }
                $clock_str.="<td width='15%'><label for='comment'>Comment<span style='color: red;'>*</span>&nbsp;&nbsp;&nbsp;</label></td><td width='15%'><input type='text' name='comment[]' value='".$c->comment."' id='comment'></td>";
                $clock_str.="<input type='hidden' name='clock_id[]' value='".$c->clock_id."'></tr>";

                if (!empty($c->clock_id)) {
                    $this->session->set_userdata('session_clock_time_id', $c->clock_id);
                    $show_add_break = true;
                }
                else {
                    $show_add_break = false;
                }
            }
        }
        else {
            
            if (!empty($date)) {

                $show_add_break = false;
                
                $this->session->set_userdata('show_add_break', false);

                $clock_in_date = date("Y-m-d", strtotime($date));
                $clock_out_date = date("Y-m-d", strtotime($date));

                $clock_str.= "<td width='15%'><label for='clock_in_date'>Clock In Date</label></td><td width='15%'><input type='date' id='clock_in_date' class='clock_in_date' name='clock_in_date' value='".$clock_in_date."' readonly></td><td width='15%'><input type='time' step='1' id='clock_in_time' name='clock_in_time' class='clock_in_time validate[required]'></td>";

                $clock_str.= "<td width='15%'><label for='clock_out_date'>Clock Out Date</label></td><td width='15%'><input type='date' id='clock_out_date' class='clock_out_date' name='clock_out_date' value='".$clock_out_date."' readonly></td><td width='15%'><input type='time' step='1' id='clock_out_time' name='clock_out_time' class='clock_out_time validate[required]'></td>";

                $clock_str.="<td width='15%'><label for='comment'>Comment<span style='color: red;'>*</span>&nbsp;&nbsp;&nbsp;</label></td><td width='15%'><input type='text' name='comment' id='comment'></td></tr>";

                $clock_str.="<tr><td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>Shift details are not there</b></span></div></td></tr>";

            }
            else {
                
                $show_add_break = false;

                $clock_str.="<td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>Shift details are not there</b></span></div></td></tr>";
            }
        }
        

        $break_str = "";
        foreach ($clock_data as $c) {
            if ($c->break_type == "personal") {

                $personal_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                
                $personal_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                $personal_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                $personal_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                if (!empty($personal_break_start_time) && !empty($personal_break_end_time)) {
                    $break_str.="<tr><td width='15%'><label for='personal_break_start_date'>Personal break start time</label>
                    </td><td><input type='date' id='personal_break_start_date' name='personal_break_start_date[]' class='break_start_date'  value='".$personal_break_start_date."' readonly></td><td><input type='time' step='1' id='personal_break_start_time' name='personal_break_start_time[]' class='break_start_time' value='".$personal_break_start_time."'></td><td><label for='personal_break_end_date'>Personal break end time</label></td><td><input type='date' id='personal_break_end_date' name='personal_break_end_date[]' class='break_end_date' value='".$personal_break_end_date."' readonly></td><td><input type='time' step='1' id='personal_break_end_time' name='personal_break_end_time[]' class='break_end_time' value='".$personal_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_p[]' value='".$c->comment."' id='comment_p' style='width: 66px !important;'></td><input type='hidden' name='personal_break[]' value='".$c->break_id."'></tr>";
                }
                else if (!empty($personal_break_start_time) && empty($personal_break_end_time)) {

                    $personal_break_end_date = date("Y-m-d", strtotime($date));

                    $break_str.="<tr><td><label for='personal_break_start_date'>Personal break start time</label>
                    </td><td><input type='date' id='personal_break_start_date' name='personal_break_start_date[]' class='break_start_date'  value='".$personal_break_start_date."' readonly></td><td><input type='time' step='1' id='personal_break_start_time' name='personal_break_start_time[]' class='break_start_time' value='".$personal_break_start_time."'></td><td><label for='personal_break_end_date'>Personal break end time</label></td><td><input type='date' id='personal_break_end_date' name='personal_break_end_date[]' class='break_end_date' value='".$personal_break_end_date."' readonly></td><td><input type='time' step='1' id='personal_break_end_time' name='personal_break_end_time[]' class='break_end_time'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_p[]' value='".$c->comment."' id='comment_p' style='width: 66px !important;'></td><input type='hidden' name='personal_break[]' value='".$c->break_id."'></tr>";
                }
            }
            if ($c->break_type == "meeting") {
                
                $meeting_break_start_date = date("Y-m-d", strtotime($c->break_start_time));

                $meeting_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                $meeting_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                $meeting_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                if (!empty($meeting_break_start_time) && !empty($meeting_break_end_time)) {

                    $break_str.="<tr><td><label for='meeting_break_start_date'>Meeting break start time</label>
                    </td><td><input type='date' id='meeting_break_start_date' name='meeting_break_start_date[]' class='break_start_date'  value='".$meeting_break_start_date."' readonly></td><td><input type='time' step='1' id='meeting_break_start_time' name='meeting_break_start_time[]' class='break_start_time' value='".$meeting_break_start_time."'></td><td><label for='meeting_break_end_date'>Meeting break end time</label></td><td><input type='date' id='meeting_break_end_date' name='meeting_break_end_date[]' class='break_end_date'  value='".$meeting_break_end_date."' readonly></td><td><input type='time' step='1' id='meeting_break_end_time' name='meeting_break_end_time[]' class='break_end_time' value='".$meeting_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_m[]' value='".$c->comment."' id='comment_m' style='width: 66px !important;'></td><input type='hidden' name='meeting_break[]' value='".$c->break_id."'></tr>";
                }
                else if (!empty($meeting_break_start_time) && empty($meeting_break_end_time)) {

                    $meeting_break_end_date = date("Y-m-d", strtotime($date));

                    $break_str.="<tr><td><label for='meeting_break_start_date'>Meeting break start time</label>
                    </td><td><input type='date' id='meeting_break_start_date' class='break_start_date' name='meeting_break_start_date[]'  value='".$meeting_break_start_date."' readonly></td><td><input type='time' step='1' id='meeting_break_start_time' name='meeting_break_start_time[]' class='break_start_time' value='".$meeting_break_start_time."'></td><td><label for='meeting_break_end_date'>Meeting break end time</label></td><td><input type='date' id='meeting_break_end_date' class='break_end_date' name='meeting_break_end_date[]' value='".$meeting_break_end_date."' readonly></td><td><input type='time' step='1' id='meeting_break_end_time' name='meeting_break_end_time[]' class='break_end_time'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_m[]' value='".$c->comment."' id='comment_m' style='width: 66px !important;'></td><input type='hidden' name='meeting_break[]' value='".$c->break_id."'></tr>";
                }
            }
            if ($c->break_type == "training") {

                $training_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                
                $training_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                $training_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                $training_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                if (!empty($training_break_start_time) && !empty($training_break_end_time)) {

                    $break_str.="<tr><td><label for='training_break_start_date'>Training break start time</label>
                    </td><td><input type='date' id='training_break_start_date' class='break_start_date' name='training_break_start_date[]'  value='".$training_break_start_date."' readonly></td><td><input type='time' step='1' id='training_break_start_time' name='training_break_start_time[]' class='break_start_time' value='".$training_break_start_time."'></td><td><label for='training_break_end_date'>Training break end time</label></td><td><input type='date' id='training_break_end_date' class='break_end_date' name='training_break_end_date[]'  value='".$training_break_end_date."' readonly></td><td><input type='time' step='1' id='training_break_end_time' name='training_break_end_time[]' class='break_end_time' value='".$training_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_t[]' value='".$c->comment."' id='comment_t' style='width: 66px !important;'></td><input type='hidden' name='training_break[]' value='".$c->break_id."'></tr>";
                }
                else if (!empty($training_break_start_time) && empty($training_break_end_time)) {

                    $training_break_end_date = date("Y-m-d", strtotime($date));

                    $break_str.="<tr><td><label for='training_break_start_date'>Training break start time</label>
                    </td><td><input type='date' id='training_break_start_date' name='training_break_start_date[]' class='break_start_date'  value='".$training_break_start_date."' readonly></td><td><input type='time' step='1' id='training_break_start_time' name='training_break_start_time[]' class='break_start_time' value='".$training_break_start_time."'></td><td><label for='training_break_end_date'>Training break end time</label></td><td><input type='date' id='training_break_end_date' name='training_break_end_date[]' class='break_end_date' value='".$training_break_end_date."' readonly></td><td><input type='time' step='1' id='training_break_end_time' name='training_break_end_time[]' class='break_end_time'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_t[]' value='".$c->comment."' id='comment_t' style='width: 66px !important;'></td><input type='hidden' name='training_break[]' value='".$c->break_id."'></tr>";
                }
            }

            if ($c->break_type == "lunch") {

                $lunch_break_start_date = date("Y-m-d", strtotime($c->break_start_time));
                
                $lunch_break_start_time = date("H:i:s", strtotime($c->break_start_time));

                $lunch_break_end_date = date("Y-m-d", strtotime($c->break_end_time));

                $lunch_break_end_time = date("H:i:s", strtotime($c->break_end_time));

                if (!empty($lunch_break_start_time) && !empty($lunch_break_end_time)) {
                    $break_str.="<tr><td><label for='lunch_break_start_date'>Lunch break start time</label>
                    </td><td><input type='date' id='lunch_break_start_date' name='lunch_break_start_date[]' class='break_start_date'  value='".$lunch_break_start_date."' readonly></td><td><input type='time' step='1' id='lunch_break_start_time' name='lunch_break_start_time[]' class='break_start_time' value='".$lunch_break_start_time."'></td><td><label for='lunch_break_end_date'>Lunch break end time</label></td><td><input type='date' id='lunch_break_end_date' name='lunch_break_end_date[]' class='break_end_date' value='".$lunch_break_end_date."' readonly></td><td><input type='time' step='1' id='lunch_break_end_time' name='lunch_break_end_time[]' class='break_end_time' value='".$lunch_break_end_time."'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_l[]' value='".$c->comment."' id='comment_l' style='width: 66px !important;'></td><input type='hidden' name='lunch_break[]' value='".$c->break_id."'></tr>";
                }
                else if (!empty($lunch_break_start_time) && empty($lunch_break_end_time)) {

                    $lunch_break_end_date = date("Y-m-d", strtotime($date));

                    $break_str.="<tr><td><label for='lunch_break_start_date'>Lunch break start time</label>
                    </td><td><input type='date' id='lunch_break_start_date' name='lunch_break_start_date[]' class='break_start_date'  value='".$lunch_break_start_date."' readonly></td><td><input type='time' step='1' id='lunch_break_start_time' name='lunch_break_start_time[]' class='break_start_time' value='".$lunch_break_start_time."'></td><td><label for='lunch_break_end_date'>Lunch break end time</label></td><td><input type='date' id='lunch_break_end_date' name='lunch_break_end_date[]' class='break_end_date' value='".$lunch_break_end_date."' readonly></td><td><input type='time' step='1' id='lunch_break_end_time' name='lunch_break_end_time[]' class='break_end_time'></td><td><label for='comment'>Comment&nbsp;&nbsp;&nbsp;</label></td><td><input type='text' name='comment_l[]' value='".$c->comment."' id='comment_l' style='width: 66px !important;'></td><input type='hidden' name='lunch_break[]' value='".$c->break_id."'></tr>";
                }
            }
        }

        if (empty($break_str)) {
            $break_str.="<tr><td colspan='8'><br></td></tr><tr><td colspan='8'><br></td></tr><tr><td colspan='8'><div class='panel panel-info text-center'><span class='text text-danger'><b>No breaks available</b></span></div></td></tr>";
        }

        $result = [
            'clock_str' => $clock_str,
            'break_str' => $break_str,
            'show_add_break' => $show_add_break,
        ];

        echo json_encode($result);
    }

    public function add_employee_shift_test() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode("Mjg=");
        
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift();
        // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        // $data['get_client'] = $this->employee_model->getClientLists();

        $admin_id = $data['get_details'][0]['admin_id'];
        $data['admin_id'] = $admin_id;

        $this->session->set_userdata('clock_break_data_admin_id', $admin_id);

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/add_employee_shift_test', $data);
    }









    public function all_employee_shift_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_id = $data['get_details'][0]['admin_id'];
        $employee_id = base64_decode("Mjg=");
        $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift();
        // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        // $data['get_client'] = $this->employee_model->getClientLists();

        // $admin_id = $data['get_details'][0]['admin_id'];
        // $data['admin_id'] = $admin_id;

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/all_employee_shift_details', $data);
    }

    public function get_all_employee_shift_details() {
        $from = $this->input->post('from');
        $from = date("Y-m-d H:i:s", strtotime($from));
        $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
        $to = $this->input->post('to');
        $to = date("Y-m-d 23:59:59", strtotime($to));
        $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
        $employee_id = $this->input->post('employee_id');
        $this->session->set_userdata('employee_datewise_shift_summary_employee_id', $employee_id);

        if (empty($employee_id)) {

            $sess_arr = $this->session->userdata('admin_logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
        
            $admin_id = $data['get_details'][0]['admin_id'];

            $all_employees_under_manager = $this->employee_model->get_all_employees_shift();
            $result = [];
            foreach ($all_employees_under_manager as $empshift) {

                $employee_data = $this->employee_model->getEmployeeData($empshift['employee_id']);
                $employee_name = $employee_data[0]['first_name']." ".$employee_data[0]['last_name'];

                $get_current_employees_shift_total_hours = $this->employee_model->get_current_employees_shift_total_hours($from, $to, $empshift['employee_id']);

                $get_current_employees_shift_total_paid_breaks = $this->employee_model->get_current_employees_shift_total_paid_breaks($from, $to, $empshift['employee_id']);

                $get_current_employees_shift_total_unpaid_breaks = $this->employee_model->get_current_employees_shift_total_unpaid_breaks($from, $to, $empshift['employee_id']);

                $total_breaks = (int)$get_current_employees_shift_total_paid_breaks[0]->total_paid_break + $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break;

                $result[] = [
                    'employee_name' => $employee_name,
                    'total_hours' => $get_current_employees_shift_total_hours[0]->total_hours,
                    'total_break' => $total_breaks,
                    'total_paid_break' => $get_current_employees_shift_total_paid_breaks[0]->total_paid_break,
                    'total_unpaid_break' => $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break,
                ];

            }
            
            echo json_encode($result);
        }
        else {

            $employee_data = $this->employee_model->getEmployeeData($employee_id);
            $employee_name = $employee_data[0]['first_name']." ".$employee_data[0]['last_name'];

            $get_current_employees_shift_total_hours = $this->employee_model->get_current_employees_shift_total_hours($from, $to, $employee_id);

            $get_current_employees_shift_total_paid_breaks = $this->employee_model->get_current_employees_shift_total_paid_breaks($from, $to, $employee_id);

            $get_current_employees_shift_total_unpaid_breaks = $this->employee_model->get_current_employees_shift_total_unpaid_breaks($from, $to, $employee_id);

            $total_breaks = (int)$get_current_employees_shift_total_paid_breaks[0]->total_paid_break + $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break;

            $result = [
                'employee_name' => $employee_name,
                'total_hours' => $get_current_employees_shift_total_hours[0]->total_hours,
                'total_break' => $total_breaks,
                'total_paid_break' => $get_current_employees_shift_total_paid_breaks[0]->total_paid_break,
                'total_unpaid_break' => $get_current_employees_shift_total_unpaid_breaks[0]->total_unpaid_break,
            ];
            
            echo json_encode($result);
        }
    }




















    public function get_employee_datewise_shift_summary() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $admin_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode("Mjg=");
        $data['get_all_employees_shift'] = $this->employee_model->get_all_employees_shift();
        // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        // $data['get_client'] = $this->employee_model->getClientLists();

        // $admin_id = $data['get_details'][0]['admin_id'];
        // $data['admin_id'] = $admin_id;

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/get_employee_datewise_shift_summary', $data);
    }


    public function get_employee_shift_summary_data_all() {
        $from = $this->input->post('from');
        $from = date("Y-m-d H:i:s", strtotime($from));
        $to = $this->input->post('to');
        $to = date("Y-m-d 23:59:59", strtotime($to));
        $employee_id = $this->input->post('employee_id');

        if (empty($employee_id)) {

            $sess_arr = $this->session->userdata('logged_in');
            $email = $sess_arr['email'];
            $data['get_details'] = $this->profile_model->getDetails($email);
        
            $admin_id = $data['get_details'][0]['sa_id'];

            $all_employees_under_manager = $this->employee_model->get_all_employees_shift();
            $all_emp_under_mng = [];
            foreach ($all_employees_under_manager as $empshift) {
                $all_emp_under_mng[] = $empshift['employee_id'];
            }
            
            echo json_encode($this->employee_model->get_employee_shift_summary_data_all($from, $to, $all_emp_under_mng, true));
        }
        else {
            echo json_encode($this->employee_model->get_employee_shift_summary_data_all($from, $to, $employee_id, false));
        }
    }

    public function change_employee_datewise_shift_summary_status() {
        $from = $this->input->post('from');
        $from = date("Y-m-d H:i:s", strtotime($from));
        $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
        $to = $this->input->post('to');
        $to = date("Y-m-d H:i:s", strtotime($to));
        $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
        $clock_time_id = $this->input->post('clock_time_id');
        $admin_id = $this->input->post('admin_id');
        $res = $this->employee_model->change_employee_datewise_shift_summary_status($clock_time_id, $admin_id);
        if ($res > 0) {
            echo "1";
        }
        else {
            echo "0";
        }
    }

    public function change_employee_datewise_shift_summary_status_disapprove() {
        $from = $this->input->post('from');
        $from = date("Y-m-d H:i:s", strtotime($from));
        $this->session->set_userdata('employee_datewise_shift_summary_from', $from);
        $to = $this->input->post('to');
        $to = date("Y-m-d H:i:s", strtotime($to));
        $this->session->set_userdata('employee_datewise_shift_summary_to', $to);
        $clock_time_id = $this->input->post('clock_time_id');
        $admin_id = $this->input->post('admin_id');
        $res = $this->employee_model->change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id);
        if ($res > 0) {
            echo "1";
        }
        else {
            echo "0";
        }
    }






















    public function employee_shift_list() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url() . 'admin'); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];

        $data['get_employee_shift_list'] = $this->employee_model->get_employee_shift_list();

        $data['page'] = "employee_shift_lists";
        $data['meta_title'] = "EMPLOYEE SHIFT";

        $this->load->view('superadmin/employee_shift_list', $data);

    }

    public function delete_current_shift() {
        $shift_id = $this->uri->segment(2);
        echo $shift_id."<br>";

        $employee_assigned_to_shift = $this->employee_model->get_employee_assigned_to_shift($shift_id);
        $employee_count = $employee_assigned_to_shift[0]->count;
        print_r($employee_count."<br>");

        $group_assigned_to_shift = $this->employee_model->get_group_assigned_to_shift($shift_id);
        $group_count = $group_assigned_to_shift[0]->count;
        print_r($group_count."<br>");

        if ($employee_count == 0 && $group_count == 0) {
            $this->employee_model->delete_master_shift($shift_id);
            $this->session->set_flashdata('succ_msg', 'Shift deleted successfully');
            redirect(base_url() . 'superadmin-employee_shift_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'This shift is already assigned to a group or employee, so it cannot be deleted');
            redirect(base_url() . 'superadmin-employee_shift_list');
        }
    }

    public function assign_shift_to_employees() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $shift_id = $this->uri->segment(2);

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['sa_id'];

        $data['shift_id'] = $shift_id;

        $data['current_shift_details'] = $this->employee_model->get_master_shift_data($shift_id);

        $data['shift_name'] = $data['current_shift_details'][0]->employee_shift_type;

        $data['all_employees']  = $this->employee_model->get_all_employees($shift_id);

        $data['all_groups'] = $this->employee_model->get_all_groups($shift_id);
        
        $data['get_all_employee_shift_list'] = $this->employee_model->get_all_employee_shift_list($shift_id);

        $data['get_group_list_of_shift'] = $this->employee_model->get_group_list_of_shift($shift_id);

        $this->load->view('superadmin/all_employee_shift_list', $data);
    }

    public function assign_shift_to_employee() {
        $employee_id = $this->input->post('employee_id');
        $shift_id = $this->input->post('shift_id');

        $current_shift_id = $this->employee_model->get_shift_id_of_current_employee($employee_id);

        $curr_shift_id = $current_shift_id[0]->shift_id;
        // exit;

        if (!$curr_shift_id) {
            $this->employee_model->assign_shift_to_employee($employee_id, $shift_id);
            $this->session->set_flashdata('succ_msg', 'Successfully assigned shift to employee');
        }
        else {
            $shift_data = $this->employee_model->get_master_shift_data($curr_shift_id);
            $this->session->set_flashdata('error_msg', 'This employee is already assigned to '.$shift_data[0]->employee_shift_type.' so it cannot be reassigned to a shift');
        }

        echo true;
    }

    public function remove_employee_from_shift() {
        $employee_id = $this->input->post('employee_id');
        $shift_id = $this->input->post('shift_id');

        $this->employee_model->assign_shift_to_employee($employee_id, $shift_id);

        $this->session->set_flashdata('succ_msg', 'Successfully removed employee from shift');

        echo true;
    }

    public function assign_shift_to_group() {
        $group_id = $this->input->post('group_id');
        $shift_id = $this->input->post('shift_id');

        $current_shift_id = $this->employee_model->get_shift_id_of_current_group($group_id);

        $curr_shift_id = $current_shift_id[0]->shift_id;
        
        if (!$curr_shift_id) {
            $this->employee_model->assign_shift_to_group($group_id, $shift_id);
            $this->session->set_flashdata('succ_msg', 'Successfully assigned shift to group');
        }
        else {
            $shift_data = $this->employee_model->get_master_shift_data($curr_shift_id);
            $this->session->set_flashdata('error_msg', 'This group is already assigned to '.$shift_data[0]->employee_shift_type.' so it cannot be reassigned to a shift');
        }

        echo true;
    }

    public function remove_group_from_shift() {
        $group_id = $this->input->post('group_id');
        $shift_id = $this->input->post('shift_id');

        $this->employee_model->assign_shift_to_group($group_id, $shift_id);

        $this->session->set_flashdata('succ_msg', 'Successfully removed group from shift');

        echo true;
    }

    public function submit_all_employee_shift() {
        $employee_ids = $this->input->post('employee_id');
        $shift_id = $this->input->post('shift_id');

        $this->employee_model->update_all_employee_shift_id($employee_ids, $shift_id);
        
        redirect(base_url() . 'employee_shift_list');
    }

    public function add_employee_shift_data() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        // $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        // $employee_id = base64_decode("Mjg=");
        // $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        // $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        // $data['get_client'] = $this->employee_model->getClientLists();

        // $admin_id = $data['get_details'][0]['admin_id'];
        // $data['admin_id'] = $admin_id;

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/add_employee_shift_data', $data);
    }

    public function add_employee_master_shift_data() {
        $employee_id = base64_decode($this->input->post('employee_id'));
        $employee_shift_type = $this->input->post('employee_shift_type');
        $days = $this->input->post('days');
        
        $days_str = '';
        foreach ( $days as $d ) {
            $days_str .= $d.',';
        }
        $days_str = substr($days_str, 0, strlen($days_str)-1);

        $daily_shift_start_time = $this->input->post('daily_shift_start_time');
        $daily_shift_end_time = $this->input->post('daily_shift_end_time');
        $paid_break_hours = $this->input->post('paid_break_hours');
        $unpaid_break_hours = $this->input->post('unpaid_break_hours');
        $comment = $this->input->post('comment');

        $all_shift_names = $this->employee_model->get_all_shift_names();

        $all_shifts = [];

        foreach($all_shift_names as $a) {
            $all_shifts[] = $a['employee_shift_type'];
        }

        if (in_array($employee_shift_type, $all_shifts)) {
            $this->session->set_flashdata('error_msg', 'Shift name cannot be same');
            redirect(base_url() . 'add-new-shift');
        }

        $insert_arr = array(
            "employee_shift_type" => $employee_shift_type,
            "daily_shift_start_time" => $daily_shift_start_time,
            "daily_shift_end_time" => $daily_shift_end_time,
            "paid_break_hours" => $paid_break_hours,
            "unpaid_break_hours" => $unpaid_break_hours,
            "days" => $days_str,
            "comment" => $comment,
        );

        $insert_query = $this->employee_model->add_employee_master_shift_data($insert_arr);

        if ($insert_query != '') {
            $this->session->set_flashdata('succ_msg', 'Employee master shift data added successfully');
            redirect(base_url() . 'employee_shift_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Failed to add employee master shift data');
            redirect(base_url() . 'employee_shift_list');
        }       
    }


    public function edit_employee_master_shift() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $shift_id = $this->uri->segment(2);
        $edit_data = $this->employee_model->get_master_shift_data($shift_id);

        $data = [
            'shift_id' => $shift_id,
            'employee_shift_type' => $edit_data[0]->employee_shift_type,
            'days' => explode(',',$edit_data[0]->days),
            'daily_shift_start_time' => $edit_data[0]->daily_shift_start_time,
            'daily_shift_end_time' => $edit_data[0]->daily_shift_end_time,
            'paid_break_hours' => $edit_data[0]->paid_break_hours,
            'unpaid_break_hours' => $edit_data[0]->unpaid_break_hours,
            'comment' => $edit_data[0]->comment,
        ];

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        // $employee_id = base64_decode($this->uri->segment(2));

        $data['page'] = "admin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";
        $this->load->view('superadmin/edit_employee_shift_data', $data);
    }

    public function update_employee_master_shift_data() {
        $shift_id = $this->input->post('shift_id');
        $employee_shift_type = $this->input->post('employee_shift_type');
        $days = $this->input->post('days');
        
        $days_str = '';
        foreach ( $days as $d ) {
            $days_str .= $d.',';
        }
        $days_str = substr($days_str, 0, strlen($days_str)-1);

        $daily_shift_start_time = $this->input->post('daily_shift_start_time');
        $daily_shift_end_time = $this->input->post('daily_shift_end_time');
        $paid_break_hours = $this->input->post('paid_break_hours');
        $unpaid_break_hours = $this->input->post('unpaid_break_hours');
        $comment = $this->input->post('comment');

        $update_arr = array(
            "employee_shift_type" => $employee_shift_type,
            "daily_shift_start_time" => $daily_shift_start_time,
            "daily_shift_end_time" => $daily_shift_end_time,
            "paid_break_hours" => $paid_break_hours,
            "unpaid_break_hours" => $unpaid_break_hours,
            "days" => $days_str,
            "comment" => $comment,
        );

        $update_query = $this->employee_model->update_employee_master_shift_data($update_arr, $shift_id);

        if ($update_query != '') {
            $this->session->set_flashdata('succ_msg', 'Employee master shift data updated successfully');
            redirect(base_url() . 'superadmin-employee_shift_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Failed to update employee master shift data');
            redirect(base_url() . 'superadmin-employee_shift_list');
        } 
    }


    
    
    
    
    
    
    
    public function employee_group_list() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['sa_id'];

        $data['get_employee_group_list'] = $this->employee_model->get_employee_group_list();

        
        $data['page'] = "employee_group_lists";
        $data['meta_title'] = "EMPLOYEE GROUP";

        $this->load->view('superadmin/employee_group_list', $data);

    }

    public function activate_group() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $group_id = base64_decode($this->uri->segment(2));
        
        $update_res = $this->employee_model->activate_group($group_id);

        if ($update_res) {
            $this->session->set_flashdata('succ_msg', 'Group activated successfully');
            redirect(base_url() . 'superadmin-employee_group_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Group not activated successfully');
            redirect(base_url() . 'superadmin-employee_group_list');
        }
    }

    public function deactivate_group() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $group_id = base64_decode($this->uri->segment(2));
        
        $update_res = $this->employee_model->deactivate_group($group_id);

        if ($update_res) {
            $this->session->set_flashdata('succ_msg', 'Group deactivated successfully');
            redirect(base_url() . 'superadmin-employee_group_list');
        }
        else {
            $this->session->set_flashdata('error_msg', 'Group not deactivated successfully');
            redirect(base_url() . 'superadmin-employee_group_list');
        }
    }

    public function assign_group_to_employees() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;
        $group_id = $this->uri->segment(2);

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['sa_id'];

        $data['group_id'] = $group_id;

        $data['current_group_name'] = $this->employee_model->get_current_group_name($group_id);
        
        $data['get_all_employee_group_list'] = $this->employee_model->get_current_group_employees($group_id);

        $this->load->view('superadmin/all_employee_group_list', $data);
    }

    public function add_remove_employee_from_group() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $group_id = $this->uri->segment(2);

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['sa_id'];

        $data['group_id'] = $group_id;

        $data['current_group_name'] = $this->employee_model->get_current_group_name($group_id);

        $data['members'] = $this->employee_model->get_members($group_id);

        $data['not_members'] = $this->employee_model->get_not_members($group_id);

        $this->load->view('superadmin/add_remove_employee_from_group', $data);
    }

    public function save_members_not_members() {
        $group_id = $this->input->post('group_id');
        $add_ids = $this->input->post('addIds');
        $remove_ids = $this->input->post('removeIds');

        $this->employee_model->add_members_to_group($group_id, $add_ids);

        $this->employee_model->remove_members_from_group($remove_ids);
    }

    public function create_new_group() {
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['sa_id'];

        $group_name = $this->input->post('group_name');
        $group_desc = $this->input->post('group_desc');

        $insert_arr = [
            'group_name' => $group_name,
            'group_description' => $group_desc,
            'shift_id' => null,
            'created_by' => $admin_id,
            'created_time' => date("Y-m-d h:i:s"),
            'modified_by' => null,
            'modified_time' => null,
        ];

        $insert_id = $this->employee_model->insert_new_group($insert_arr);

        echo $insert_id;
    }

    public function update_group_name() {
        $edited_group_name = $this->input->post('edited_group_name');
        $group_id = $this->input->post('group_id');

        $update_arr = [
            'group_name' => $edited_group_name,
        ];

        $this->employee_model->update_group_name($update_arr, $group_id);
    }
























































    public function add_admin_employee_work_order() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['admin_id'] = $data['get_details'][0]['admin_id'];

        $data['employee_id'] = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($data['employee_id']);
        $data['vendor_id']            = $get_employee_details[0]['vendor_id'];
        $data['employee_code']        = $get_employee_details[0]['employee_code'];
        $data['employee_name_prefix'] = $get_employee_details[0]['name_prefix'];
        $data['employee_name']        = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

        $get_vendor_details = $this->employee_model->getVendorDtls($data['vendor_id']);
        $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];
        $data['vendor_designation']  = $get_vendor_details[0]['vendor_designation'];
        $data['vendor_poc_name']     = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];

        $data['get_client_details'] = $this->employee_model->getClientDetails();

        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT WORK ORDER";

        $this->load->view('superadmin/add_sadmin_employee_work_order', $data);
    }

    public function get_work_note() {

        $client_name = $this->input->post('client_name', TRUE);
        $data['get_work_note'] = $this->employee_model->getWorkNote($client_name);
        $this->load->view('superadmin/ajax/ajax_work_note', $data);
    }

    public function insert_sadmin_employee_work_order() {
        $db = get_instance()->db->conn_id;

        $vendor_id = $this->input->post('vendor_id');
        $employee_id = $this->input->post('employee_id');
        $admin_id = $this->input->post('admin_id');
        $consultant = $this->input->post('consultant');
        if (DEMO) {
            $agreement_date = $this->input->post('agreement_date');
        }
        $start_date = $this->input->post('start_date');
        $client_name = $this->input->post('client_name');
        $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
        $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
        $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
        $bill_rate = $this->input->post('bill_rate');
        $ot_rate = $this->input->post('ot_rate');
        $vendor_poc_name = $this->input->post('vendor_poc_name');
        $vendor_poc_designation = $this->input->post('vendor_poc_designation');

		//details to send mails.
		if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
		$get_sadmin_details = $this->employee_model->getSuperAdminData($sa_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }

        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
            $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add_sadmin_employee_work_order/' . base64_encode($employee_id)));
        } else {

            if (DEMO) {
                $insert_arr = array(
                    'vendor_id' => $vendor_id,
                    'employee_id' => $employee_id,
                    'admin_id' => $admin_id,
                    'consultant' => $consultant,
                    'agreement_date' => $agreement_date,
                    'start_date' => $start_date,
                    'client_name' => $client_name,
                    'project_duration' => $project_duration,
                    'invoicing_terms' => $invoicing_terms,
                    'payment_terms' => $payment_terms,
                    'bill_rate' => $bill_rate,
                    'ot_rate' => $ot_rate,
                    'vendor_poc_name' => $vendor_poc_name,
                    'vendor_poc_designation' => $vendor_poc_designation,
                    'stage' => '2',
                    'entry_date' => date("Y-m-d h:i:s")
                );
            }

            if (INDIA) {
                $insert_arr = array(
                    'vendor_id' => $vendor_id,
                    'employee_id' => $employee_id,
                    'admin_id' => $admin_id,
                    'consultant' => $consultant,
                    'start_date' => $start_date,
                    'client_name' => $client_name,
                    'project_duration' => $project_duration,
                    'invoicing_terms' => $invoicing_terms,
                    'payment_terms' => $payment_terms,
                    'bill_rate' => $bill_rate,
                    'ot_rate' => $ot_rate,
                    'vendor_poc_name' => $vendor_poc_name,
                    'vendor_poc_designation' => $vendor_poc_designation,
                    'entry_date' => date("Y-m-d h:i:s")
                );
            }
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_work_order($insert_arr);

            if ($insert_query != '') {

                $get_vendor_details = $this->vendor_model->getVendorData($vendor_id);
                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                
                if (DEMO) {
                    $employee_code = $get_employee_details[0]['employee_code'];
                }

                if (INDIA) {
                    $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                    $data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
                    $data['company_id'] = $get_vendor_details[0]['company_id'];
                }

                //$vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                //$data['vendor_email'] = $get_vendor_details[0]['vendor_email'];
                //$data['company_id'] = $get_vendor_details[0]['company_id'];

                $get_admin_email = $this->vendor_model->getAdminEmail($get_vendor_details[0]['admin_id']);

                if (INDIA) {
                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;
                }
                //$from_email = REPLY_EMAIL;
                //$superadmin_email = SUPERADMIN_EMAIL;

                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_email[0]['admin_email'];
                $admin_name = ucwords($get_admin_email[0]['first_name'] . " " . $get_admin_email[0]['last_name']);

                if (DEMO) {
                    send_emails_work_order(2, 'sadmin', [
                        'init_user_full_name' => $sa_name,
                        'con_full_name' => $employee_name,
                        'con_code' => $employee_code,
                        'access_link_part' => 'edit-sadmin-employee-work-order/' . base64_encode($employee_id),
                    ], [
                        SUPERADMIN_EMAIL,
                    ], [
                        $admin_email,
                        $sa_email,
                    ]);
                }

                if (INDIA) {

                    $data['msg'] = ucwords($admin_name) . " added work order for " . ucwords($employee_name);
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($superadmin_email);
                    $this->email->subject('Work Order Added Successfully');
                    $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                    $this->email->set_mailtype('html');
                    $this->email->send();
                    
                }

                /*$data['msg'] = ucwords($admin_name) . " added work order for " . ucwords($employee_name);
                //Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($superadmin_email);
                $this->email->subject('Work Order Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();*/

				
				/* ----------------------------------Insert Mail------------------------------------ */

                $msg = "Hi,<br>" . ucwords($sa_name) . " has added work order for " . ucwords($employee_name). "."; 
                        
                $recipient_id = 1;
                $recipient_type = "superadmin";
                $insert_arr = array(
                    "recipient_id" => $recipient_id,
                    "recipient_type" => $recipient_type,
                    "sender_id" => $sa_id,
                    "sender_type" => "superadmin",
                    "subject" => "Work Order Added Successfully!",
                    "message" => $msg,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "is_deleted" => '0',
                    "status" => '0'
                );
                $insert_query = $this->communication_model->add_mail($insert_arr);


                /* ----------------------------------Insert Mail------------------------------------ */
				
                $this->session->set_flashdata('succ_msg', 'Work Order Added Successfully..');
                redirect(base_url() . 'consultant-user');
            } else {
                $this->session->set_flashdata('error_msg', 'Work Order Not Added Successfully..');
                redirect(base_url() . 'consultant-user');
            }
        }
    }

    public function con_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_type = "C";

        if (DEMO) {
            $get_employee_details = $this->employee_model->getEmployeeLists($employee_type);
        }

        if (INDIA) {
            $get_employee_details = $this->employee_model->getEmployeeLists();
        }
        
        $ncon_str = "";
        $con_str = "";
        foreach ($get_employee_details as $cval) {
            $ncon_str .= $cval['employee_id'] . ",";
        }
        $con_str = rtrim($ncon_str, ",");
//        echo "<pre>";
//       echo $con_str;
//       die; 

        $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet($con_str);
        $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet($con_str);
        $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet($con_str);
//       echo "<pre>";
//       print_r( $data['get_approved_timesheet_details'] );
//       die;


        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "CONSULTANT LISTS";
        $this->load->view('superadmin/sadmin_new_con_timesheet', $data);
    }

    public function emp_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_type = "E";

        if (DEMO) {
            $get_employee_details = $this->employee_model->getEmployeeListsbyType($employee_type);
        }
        
        if (INDIA) {
            $get_employee_details = $this->employee_model->getEmployeeListsbyType();
        }

        $ncon_str = "";
        $emp_str = "";
        foreach ($get_employee_details as $eval) {
            $ncon_str .= $eval['employee_id'] . ",";
        }
        $emp_str = rtrim($ncon_str, ",");
//        echo "<pre>";
//       echo $con_str;
//       die; 
//       
        $data['get_approved_timesheet_details'] = $this->employee_model->getApprovedTimesheet($emp_str);
        $data['get_not_approved_timesheet_details'] = $this->employee_model->getNotApprovedTimesheet($emp_str);
        $data['get_pending_timesheet_details'] = $this->employee_model->getPendingTimesheet($emp_str);
//       echo "<pre>";
//       print_r( $data['get_approved_timesheet_details'] );
//       die;

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "EMPLOYEE LISTS";
        $this->load->view('superadmin/sadmin_new_emp_timesheet', $data);
    }

    public function historical_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "sadmin_historical_timesheet_data";
        $data['meta_title'] = "Historical Timesheet";

        $this->load->view('superadmin/sadmin_historical_timesheet_data', $data);
    }

    public function load_historical_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $db = get_instance()->db->conn_id;

        $sa_id = $this->input->post('sa_id');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $employee_type = $this->input->post('user_type');
        $timesheet_status = $this->input->post('ts_Status');
        
        $db_from_date = get_date_db_value($from_date);
        $db_to_date = get_date_db_value($to_date);

        if (DEMO) {
            $db_from_date_range[] = get_db_date_range($db_from_date);
            $db_to_date_range[] = get_db_date_range($db_to_date, false);
        }
        
        if (INDIA) {
            $period = new DatePeriod(
                new DateTime($from_date),
                new DateInterval('P1D'),
                new DateTime($to_date)
            );
    
            $db_dates[] = $db_from_date;
            foreach ($period as $key => $value) {
                $db_dates[] = $value->format('m/d/Y');       
            }
            $db_dates[] = $db_to_date;
        }
        // print_r($db_dates);
        // exit;
        
        // $db_from_date_range[] = get_db_date_range($db_from_date);
        // $db_to_date_range[] = get_db_date_range($db_to_date, false);
        // exit;     
        if (isset($from_date) && $from_date == '') {

            echo '<div class="alert alert-danger">From Date field cannot be blank</div>';

        } else if (isset($to_date) && $to_date == '') {

            echo '<div class="alert alert-danger">To Date field cannot be blank</div>';

        } else {

            $data['timesheet_status'] = $timesheet_status;
            if ($employee_type == "C") {

                $get_employee_details = $this->employee_model->getEmployeeLists();
                //$con_str = implode(",", $get_employee_details );
                $ncon_str = "";
                $con_str = "";
                foreach ($get_employee_details as $cval) {
                    $ncon_str .= $cval['employee_id'] . ",";
                }
                $con_str = rtrim($ncon_str, ",");

                if (DEMO) {
                    $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $con_str, $timesheet_status);
                }

                if (INDIA) {
                    $data['historical_timesheet'] = $this->employee_model->getAllHistoricalTimesheetNew($db_dates, $con_str, $timesheet_status);
                }
                // $data['historical_timesheet'] = $this->employee_model->getAllHistoricalTimesheetNew($db_from_date, $db_to_date, $db_dates, $con_str, $timesheet_status);
                
                $this->load->view('superadmin/ajax/ajax_cons_historical_timesheet', $data);

            } else if ($employee_type == "E") {

                $get_employee_details = $this->employee_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ",");

                if (DEMO) {
                    $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);
                }

                if (INDIA) {
                    $data['historical_timesheet'] = $this->employee_model->getAllHistoricalTimesheetNew($db_dates, $emp_str, $timesheet_status);
                }

                //$data['historical_timesheet'] = $this->employee_model->getAllHistoricalTimesheetNew($db_from_date, $db_to_date, $db_dates, $emp_str, $timesheet_status);

                $this->load->view('superadmin/ajax/ajax_emp_historical_timesheet', $data);
            } else if ($employee_type == "1099") {

                $get_employee_details = $this->ten99_model->getEmployeeListsbyType();
                $ncon_str = "";
                $emp_str = "";
                foreach ($get_employee_details as $eval) {
                    $ncon_str .= $eval['employee_id'] . ",";
                }
                $emp_str = rtrim($ncon_str, ",");
                
                if (DEMO) {
                    $data['historical_timesheet'] = $this->employee_model->getHistoricalTimesheet($db_from_date_range, $db_to_date_range, $emp_str, $timesheet_status);
                }

                if (INDIA) {
                    $data['historical_timesheet'] = $this->employee_model->getAllHistoricalTimesheetNew($db_dates, $emp_str, $timesheet_status);
                }
                
                // $data['historical_timesheet'] = getAllHistoricalTimesheetNew($db_from_date, $db_to_date, $db_dates, $emp_str, $timesheet_status);

                $this->load->view('superadmin/ajax/ajax_ten99_historical_timesheet', $data);
            }
        }

    }

    public function add_employee() {
        $db = get_instance()->db->conn_id;
        $recipients = array();

        $sa_id = $this->input->post('sa_id');
        $vendor_id = $this->input->post('vendor_id');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_type = $this->input->post('employee_type');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
//        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
//        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $date_of_joining = $this->input->post('date_of_joining');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $get_vendor_details = $this->employee_model->getVendorDtls($vendor_id);
//        print_r($get_vendor_details);
//        die;

        $check_last_id = $this->employee_model->checkCount($vendor_id);
        $count = $check_last_id[0]['cnt'] + 1;

        $words = explode(" ", $get_vendor_details[0]['vendor_company_name']);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        $employee_code = strtoupper($acronym . "C") . str_pad($count, 3, "0", STR_PAD_LEFT);
//        $employee_code = strtoupper($get_vendor_details[0]['vendor_company_name']) . str_pad($count, 3, "0", STR_PAD_LEFT);

        $admin_id = $get_vendor_details[0]['admin_id'];


        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'add-consultant');
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'add-consultant');
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Designation cannot be blank');
            redirect(base_url() . 'add-consultant');
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Classification cannot be blank');
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Category cannot be blank');
            redirect(base_url() . 'add-consultant');
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'add-consultant');
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                }

                if (empty($errors) == true) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-consultant');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-consultant');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-consultant');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-consultant');
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            /* ---------------Resume-------------- */

            $get_admin_details = $this->vendor_model->getAdminEmail($admin_id);

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'admin_id' => $admin_id,
                'employee_code' => $employee_code,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_type' => $employee_type,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'employee_designation' => $employee_designation,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'phone_ext' => $phone_ext,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'entry_date' => date("Y-m-d h:i:s"),
                'date_of_joining' => $date_of_joining,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate
            );
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_employee_user($insert_arr);

            if ($insert_query != '') {

                $employee_name = $first_name . " " . $last_name;

                if ($employee_category == '1') {
                    $employee_category = "W2";
                } else {
                    $employee_category = "Subcontractor";
                }
                $data['msg'] = "<p style='font-weight: 800;'>New consultant is added successfully. Consultant Details are as follows :</p>
                                                    <p style='font-weight: 300;'>
                                                        <label><strong>Consultant Details : </strong></label><br/>
                                                        <label><strong>Consultant Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                                                        <label><strong>Consultant Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                        <label><strong>Consultant Designation : </strong>" . $employee_designation . " " . ucwords($employee_name) . "</label><br/>
                                                        <label><strong>Consultant Category : </strong>" . $employee_category . "</label><br/>
                                                    </p>";

                $data['login_type'] = "employee";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $vendor_email = $get_vendor_details[0]['vendor_email'];
                $admin_email = $get_admin_details[0]['admin_email'];

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($vendor_email);
                $this->email->bcc($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('New Consultant Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "<p style='font-weight: 800;'>New consultant is added successfully. Consultant Details are as follows :</p>
                            <p style='font-weight: 300;'>
                                <label><strong>Consultant Details : </strong></label><br/>
                                <label><strong>Consultant Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                                <label><strong>Consultant Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                <label><strong>Consultant Designation : </strong>" . $employee_designation . " " . ucwords($employee_name) . "</label><br/>
                                <label><strong>Consultant Category : </strong>" . $employee_category . "</label><br/>
                            </p>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";
                $recipients [] = $vendor_id . "_" . "vendor";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "New Vendor Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Employee added Successfully..');
                redirect(base_url() . 'consultant-user');
            } else {
                $this->session->set_flashdata('error_msg', 'Employee not added Successfully..');
                redirect(base_url() . 'consultant-user');
            }
        }
    }

    public function edit_employee() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);
        $data['get_vendor'] = $this->vendor_model->getVendorLists();
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT EDIT";
        $this->load->view('superadmin/edit_employee_user', $data);
    }

    public function change_block_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));

        $recipients = array();

        if ($bs_type == 'block') {
            $update_arr = array(
                'block_status' => '0',
                'updated_date' => date("Y-m-d")
            );
        } else if ($bs_type == 'unblock') {
            $update_arr = array(
                'block_status' => '1',
                'updated_date' => date("Y-m-d")
            );
        }

        $change_block_status = $this->employee_model->change_block_status($update_arr, $employee_id);

        if ($change_block_status > 0) {

            $check_status = $this->employee_model->checkStatus($employee_id);
            $check_block_status = $this->employee_model->checkBlockStatus($employee_id);
//            $get_files = $this->vendor_model->getFiles();

            if ($check_block_status[0]['block_status'] == '1') {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                $employee_type = $get_employee_details[0]['employee_type'];
                $admin_id = $get_employee_details[0]['admin_id'];
                $vendor_id = $get_employee_details[0]['vendor_id'];
                $get_admin_details = $this->employee_model->getAdminData($admin_id);
                $get_vendor_details = $this->employee_model->getVendorData($vendor_id);

                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }
                if ($employee_type == 'C') {
                    $data['msg'] = ucwords($sa_name) . " has been unblocked your " . SITE_NAME . " Account successfully. Please login to your portal.<br>"
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                } else if ($employee_type == 'E') {
                    $data['msg'] = ucwords($sa_name) . " has been unblocked your " . SITE_NAME . " Account successfully. Please login to your portal.<br>"
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                }
                $data['employee_name'] = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $data['employee_email'] = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_employee_details[0]['employee_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($to_email);
                    $this->email->bcc($vendor_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                } else if ($employee_type == 'E') {
                    $this->email->to($to_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                }
//            }
                $this->email->subject('Your Account Unblocked Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($sa_name) . " has been unblocked consultant account successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $subject = "Consultant account unblocked successfully in GRMS";
                } else if ($employee_type == 'E') {
                    $msg = ucwords($sa_name) . " has been unblocked employee account successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $subject = "Employee account unblocked successfully in GRMS";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sadmin_id,
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */
            } else {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                $employee_type = $get_employee_details[0]['employee_type'];
                $admin_id = $get_employee_details[0]['admin_id'];
                $vendor_id = $get_employee_details[0]['vendor_id'];
                $get_admin_details = $this->employee_model->getAdminData($admin_id);
                $get_vendor_details = $this->employee_model->getVendorData($vendor_id);

                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }
                if ($employee_type == 'C') {
                    $data['msg'] = ucwords($sa_name) . " has been blocked your " . SITE_NAME . " Account successfully.<br>"
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                } else if ($employee_type == 'E') {
                    $data['msg'] = ucwords($sa_name) . " has been blocked your " . SITE_NAME . " Account successfully.<br>"
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                }
                $data['employee_name'] = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $data['employee_email'] = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_employee_details[0]['employee_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    //$this->email->to($to_email);
                    //$this->email->to($vendor_email);
                    $this->email->to($admin_email);
                    $this->email->bcc($superadmin_email);
                } else if ($employee_type == 'E') {
                    //$this->email->to($to_email);
                    $this->email->to($admin_email);
                    $this->email->bcc($superadmin_email);
                }
//            }
                $this->email->subject('Your Account Blocked Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($sa_name) . " has been blocked consultant account successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $subject = "Consultant account blocked successfully in GRMS";
                } else if ($employee_type == 'E') {
                    $msg = ucwords($sa_name) . " has been blocked employee account successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $subject = "Employee account blocked successfully in GRMS";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sadmin_id,
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */
            }

            echo "1";
        } else {
            echo "0";
        }
    }

    public function change_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));

        $recipients = array();

        if ($bs_type == 'activate') {
            $update_arr = array(
                'status' => '1',
                'updated_date' => date("Y-m-d")
            );
        } else if ($bs_type == 'deactivate') {
            $update_arr = array(
                'status' => '0',
                'updated_date' => date("Y-m-d")
            );
        }

        $change_status = $this->employee_model->change_status($update_arr, $employee_id);
        if ($change_status > 0) {
            $check_status = $this->employee_model->checkStatus($employee_id);
            $check_block_status = $this->employee_model->checkBlockStatus($employee_id);
//            $get_files = $this->vendor_model->getFiles();

            if ($check_status[0]['status'] == '1') {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                $employee_type = $get_employee_details[0]['employee_type'];
                $admin_id = $get_employee_details[0]['admin_id'];
                $vendor_id = $get_employee_details[0]['vendor_id'];
                $get_admin_details = $this->employee_model->getAdminData($admin_id);
                $get_vendor_details = $this->employee_model->getVendorData($vendor_id);

                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }
                if ($employee_type == 'C') {
                    $data['msg'] = ucwords($sa_name) . " has been activated your Account successfully. Please login to your portal.<br>"
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                } else if ($employee_type == 'E') {
                    $data['msg'] = ucwords($sa_name) . " has been activated your Account successfully. Please login to your portal.<br>"
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                }
                $data['employee_name'] = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $data['employee_email'] = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_employee_details[0]['employee_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($to_email);
                    $this->email->bcc($vendor_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                } else if ($employee_type == 'E') {
                    $this->email->to($to_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Your Account Activate Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($sa_name) . " has been activated consultant account successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $subject = "Consultant account activate successfully in GRMS";
                } else if ($employee_type == 'E') {
                    $msg = ucwords($sa_name) . " has been activated employee account successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $subject = "Employee account activate successfully in GRMS";
                }

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sadmin_id,
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */
            } else {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                $employee_type = $get_employee_details[0]['employee_type'];
                $admin_id = $get_employee_details[0]['admin_id'];
                $vendor_id = $get_employee_details[0]['vendor_id'];
                $get_admin_details = $this->employee_model->getAdminData($admin_id);
                $get_vendor_details = $this->employee_model->getVendorData($vendor_id);

                if (!empty($get_admin_details)) {
                    $sadmin_id = $get_admin_details[0]['sa_id'];
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                }
//                print_r($recipients);
//                die;
                $get_sadmin_details = $this->employee_model->getSuperAdminData($sadmin_id);
                if (!empty($get_sadmin_details)) {
                    $sa_email = $get_sadmin_details[0]['sa_email'];
                    $sa_name = $get_sadmin_details[0]['sa_name'];
                }
                if ($employee_type == 'C') {
                    $data['msg'] = ucwords($sa_name) . " has been deactivated your Account successfully. <br>"
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                } else if ($employee_type == 'E') {
                    $data['msg'] = ucwords($sa_name) . " has been deactivated your Account successfully. <br>"
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                }
                $data['employee_name'] = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $data['employee_email'] = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $to_email = $get_employee_details[0]['employee_email'];
                $admin_email = $get_admin_details[0]['admin_email'];
                $vendor_email = $get_vendor_details[0]['vendor_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    //$this->email->to($to_email);
                    //$this->email->bcc($vendor_email);
                    $this->email->to($admin_email);
                    $this->email->bcc($superadmin_email);
                } else if ($employee_type == 'E') {
                    //$this->email->to($to_email);
                    $this->email->to($admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Your Account Deactivate Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $msg = ucwords($sa_name) . " has been deactivated consultant account successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $subject = "Consultant account deactivate successfully";
                } else if ($employee_type == 'E') {
                    $msg = ucwords($sa_name) . " has been deactivated employee account successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $subject = "Employee account deactivate successfully";
                }

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sadmin_id,
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */
            }

            echo "1";
        } else {
            echo "0";
        }
    }

    public function update_employee() {
        $db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $sa_email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($sa_email);

        $employee_id = base64_decode($this->input->post('employee_id'));
        $vendor_id = $this->input->post('vendor_id');
        $employee_email = $this->input->post('employee_email');
        $new_password = $this->input->post('new_password');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
//        echo $date_of_joining;
//        die;
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $employee_details = $this->employee_model->getEmployeeData($employee_id);
        $check_duplicate_email = $this->employee_model->checkDuplicate($employee_email);

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } elseif (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Designation cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Classification cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Category cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else if ( ($employee_email !== $employee_details[0]['employee_email']) && ($check_duplicate_email > 0) ) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                }

                if (empty($errors) == true) {
                    $old_file = "./uploads/" . $employee_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_file_name = $employee_details[0]['file'];
            }


            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add_employee');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit-consultant/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

            $update_arr = array(
                'employee_email' => $employee_email,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_designation' => $employee_designation,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'date_of_joining' => $date_of_joining,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate,
                'updated_date' => date("Y-m-d h:i:s")
            );
            $update_login_arr = array(
                'consultant_email' => $employee_email,
                'password' => md5($new_password)
            );
//echo "<pre>";
//            print_r($update_arr);
//            die;
            $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);
            $update_login_query = $this->employee_model->update_employee_login_user($update_login_arr, $employee_id);

            if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Consultant updated Successfully..');
                redirect(base_url() . 'consultant-user');
            } else {
                $this->session->set_flashdata('succ_msg', 'Consultant updated Successfully..');
                redirect(base_url() . 'consultant-user');
            }
        }
    }

    public function view_employees_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
//        echo $get_vendor_id->vendor_id;
//        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_project_details'] = $this->employee_model->getEmployeeProjects($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT TIMESHEET";
        $this->load->view('superadmin/employees_project_timesheet', $data);
    }

    public function view_superadmin_con_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
//        echo $get_vendor_id->vendor_id;
//        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmp($employee_id);
        $data['get_timesheet_details_nt_approved'] = $this->employee_model->getTimesheetDetailsnotapprove($employee_id);
        $data['get_timesheet_details_pending'] = $this->employee_model->getTimesheetDetailspending($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT TIMESHEET";
//        $this->load->view('superadmin/con_project_timesheet', $data);
        $this->load->view('superadmin/ncon_project_timesheet', $data);
    }

    public function view_superadmin_employee_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
//        echo $get_vendor_id->vendor_id;
//        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmp($employee_id);
        $data['get_timesheet_details_nt_approved'] = $this->employee_model->getTimesheetDetailsnotapprove($employee_id);
        $data['get_timesheet_details_pending'] = $this->employee_model->getTimesheetDetailspending($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE TIMESHEET";
//        $this->load->view('superadmin/con_project_timesheet', $data);
        $this->load->view('superadmin/ncon_project_timesheet', $data);
    }

    public function view_superadmin_emp_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_project_timesheet_details'] = $this->employee_model->getEmployeeProjectDetails($employee_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "EMPLOYEE TIMESHEET";
        $this->load->view('superadmin/emp_project_timesheet', $data);
    }

    public function view_project_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $project_id = base64_decode($this->uri->segment(2));
        $employee_id = base64_decode($this->uri->segment(3));

        $data['get_timesheet_data'] = $this->employee_model->getTimesheetData($project_id, $employee_id);

        $data['project_id'] = $project_id;
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);
        $data['page'] = "employee_lists";
        $data['meta_title'] = "CONSULTANT TIMESHEET";
        $this->load->view('superadmin/view_project_timesheet', $data);
    }

    public function superadmin_employee_invoice() {


        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $sa_emp_str = 0;
        $emp_str = 0;

        $sa_ten99_str = 0;
        $ten99_str = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);
		
        $get_emp_arr = $this->employee_model->getEmpIDs();
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");

		$get_ten99_arr = $this->ten99_model->getten99IDs();
		if(!empty($get_ten99_arr)){
			foreach($get_ten99_arr as $ten99val){
				$sa_ten99_str .= $ten99val['employee_id'] . ",";
			}
		}
		$ten99_str = rtrim($sa_ten99_str, ",");
		
		if(!empty($ten99_str)){
			$data['get_ten99_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($ten99_str);
		}else {
			$data['get_ten99_invoice_details'] = "";
		}
		
		//echo "<pre>";
		//print_r($ten99_str);
		
		
		
        //------------------------Vendor Generated Invoice------------------
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($emp_str);
        //------------------------Vendor Generated Invoice------------------
        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($emp_str);
        $data['get_admin_not_apprv_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);

        $data['page'] = "superadmin_employee_invoice";
        $data['meta_title'] = "INVOICE";
        $this->load->view('superadmin/superadmin_employee_invoice', $data);
    }
    public function sadmin_consultant_invoice() {


        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $sa_emp_str = 0;
        $emp_str = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);

        $get_emp_arr = $this->employee_model->getEmpIDs();
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");

        //------------------------Vendor Generated Invoice------------------
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($emp_str);
        //------------------------Vendor Generated Invoice------------------
        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($emp_str);
        $data['get_admin_not_apprv_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);

        $data['page'] = "superadmin_employee_invoice";
        $data['meta_title'] = "INVOICE";
        $this->load->view('superadmin/sadmin_consultant_invoice', $data);
    }


    public function sadmin_vendor_invoice()
    {
       
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $sa_emp_str = 0;
        $emp_str = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);

        $get_emp_arr = $this->employee_model->getEmpIDs();
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");

        //------------------------Vendor Generated Invoice------------------
        $data['get_invoice_details'] = $this->employee_model->getInvoiceDetailsbyConsultants($emp_str);
        //------------------------Vendor Generated Invoice------------------
        $data['get_admin_invoice_details'] = $this->employee_model->getAdminInvoiceDetailsbyConsultants($emp_str);
        $data['get_admin_not_apprv_invoice_details'] = $this->employee_model->getAdminNotApprvInvoiceDetailsbyConsultants($emp_str);
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);

        $data['page'] = "sadmin_consultant_invoice";
        $data['meta_title'] = "INVOICE";
        $this->load->view('superadmin/sadmin_vendor_invoice', $data);
    }

    public function sadmin_employee_invoice()
    {
       
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $sa_emp_str = 0;
        $emp_str = 0;

        $data['get_details'] = $this->profile_model->getDetails($email);

        $get_emp_arr = $this->employee_model->getEmpIDs();
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");
          
         // echo'<pre>';print_r($emp_str);exit;
        
        $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailsbyEmployee($emp_str);

        $data['page'] = "sadmin_employee_invoice";
        $data['meta_title'] = "INVOICE";
        $this->load->view('superadmin/sadmin_employee_invoice', $data);
    }

    public function edit_sadmin_employee_invoice()
    {

         if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
         $sess_arr = $this->session->userdata('logged_in');
         $email = $sess_arr['email'];
         $data['get_details'] = $this->profile_model->getDetails($email);
          $sa_emp_str = 0;
        $emp_str = 0;
		
		$data['get_details'] = $this->profile_model->getDetails($email);

        $get_emp_arr = $this->employee_model->getEmpIDs();
        if (!empty($get_emp_arr)) {
            foreach ($get_emp_arr as $empval) {
                $sa_emp_str .= $empval['employee_id'] . ",";
            }
        }
        $emp_str = rtrim($sa_emp_str, ",");
         $invoice_code = base64_decode($this->uri->segment(2));
        // echo $invoice_code;exit; 
         $data['get_emp_invoice_details'] = $this->employee_model->getInvoiceDetailbyInvoiceCode($invoice_code);
         $data['page'] = "edit_sadmin_employee_invoice";
         $data['meta_title'] = "EDIT EMPLOYEE INVOICE";
         $this->load->view('superadmin/edit_sadmin_employee_invoice', $data);
    }

    public function update_sadmin_employee_invoice()
    {
            $db = get_instance()->db->conn_id;
         if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
         $sess_arr = $this->session->userdata('logged_in');
         $email = $sess_arr['email'];
         $data['get_details'] = $this->profile_model->getDetails($email);
			 
		 
         $invoice_code = base64_decode($this->input->post('invoice_code'));
         
         $payment_receipt_no = $this->input->post('receipt_number');
         $status = $this->input->post('payment_status');
         $payment_date = $this->input->post('payment_date');

          $update_arr = array(
                'payment_receipt_number' => $payment_receipt_no,
                'payment_status' => $status,
                'payment_date' => $payment_date,
                
            );
           

            $update_query = $this->employee_model->update_sadmin_employee_invoice($update_arr, $invoice_code);

			if ($update_query != '0') {


                $this->session->set_flashdata('succ_msg', 'Employee Invoice updated Successfully..');
                redirect(base_url() . 'sadmin_employee_invoice');
            } else {
                $this->session->set_flashdata('succ_msg', 'Employee Invoice updated Successfully..');
                redirect(base_url() . 'sadmin_employee_invoice');
            }


    }

    public function delete_consultant_invoice() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->input->post('invoice_id', TRUE));

		echo $invoice_id;
        $del_query = $this->employee_model->deleteInvoicePermanently($invoice_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_vendor_invoice() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->input->post('invoice_id', TRUE));

        $del_query = $this->employee_model->deleteVendorInvoicePermanently($invoice_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_employee_invoice() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $invoice_id = base64_decode($this->input->post('invoice_id', TRUE));
		
        $del_query = $this->employee_model->deleteEmployeeInvoicePermanently($invoice_id);

        if ($del_query > '0') {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function invoice_pdf() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $assign_projects = "";
        $data['get_details'] = $this->profile_model->getDetails($email);
        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkInvoiceStatus($invoice_id);

        if ($get_invoice_details[0]['vendor_id'] != '0') {
            $get_vendor_details = $this->employee_model->getVendorDtls($get_invoice_details[0]['vendor_id']);
            $data['get_vendor_details'] = $get_vendor_details;
            $get_assign_project_details = $this->employee_model->getAssignProjectDtls($get_invoice_details[0]['employee_id'], $get_invoice_details[0]['vendor_id']);
        } else {
            $get_assign_project_details = $this->employee_model->getAssignProjectDtlsbyEmp($get_invoice_details[0]['employee_id']);
        }

        if (!empty($get_assign_project_details)) {
            foreach ($get_assign_project_details as $pval) {
                $get_project_details = $this->employee_model->getProjectData($pval['project_id']);
                $assign_projects .= $get_project_details[0]['project_code'] . ",";
                $data['assign_prject'] = $assign_projects;
            }
        } else {
            $data['assign_prject'] = $assign_projects;
        }
        $get_work_order_details = $this->employee_model->getWorkDetails($get_invoice_details[0]['employee_id']);

        $data['img_src'] = "../assets/images/pts.jpg";
        $data['dimension'] = "../assets/images/dimension.png";

        $data['get_invoice_details'] = $get_invoice_details;
        $data['get_work_order_details'] = $get_work_order_details;
        $get_employee_details = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);
        $data['get_employee_details'] = $get_employee_details;

        $this->load->library('html2pdf');

        $directory_name = './uploads/invoice_pdf/' . $get_employee_details[0]['first_name'] . "_" . $get_employee_details[0]['last_name'] . '/' . date("Y-m-d") . "/";

        $file_name = $get_invoice_details[0]['invoice_code'] . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        echo $this->load->view('superadmin/invoice_pdf', $data, true);
        exit();
    }

    public function sa_invoice_pdf() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $assign_projects = "";
        $data['get_details'] = $this->profile_model->getDetails($email);
        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkAdminInvoiceStatus($invoice_id);

        if ($get_invoice_details[0]['vendor_id'] != '0') {
            $get_vendor_details = $this->employee_model->getVendorDtls($get_invoice_details[0]['vendor_id']);
            $data['get_vendor_details'] = $get_vendor_details;
            $get_assign_project_details = $this->employee_model->getAssignProjectDtls($get_invoice_details[0]['employee_id'], $get_invoice_details[0]['vendor_id']);
        } else {
            $get_assign_project_details = $this->employee_model->getAssignProjectDtlsbyEmp($get_invoice_details[0]['employee_id']);
        }

        if (!empty($get_assign_project_details)) {
            foreach ($get_assign_project_details as $pval) {
                $get_project_details = $this->employee_model->getProjectData($pval['project_id']);
                $assign_projects .= $get_project_details[0]['project_code'] . ",";
                $data['assign_prject'] = $assign_projects;
            }
        } else {
            $data['assign_prject'] = $assign_projects;
        }
        $get_work_order_details = $this->employee_model->getWorkDetails($get_invoice_details[0]['employee_id']);

        $data['img_src'] = "../assets/images/pts.jpg";
        $data['dimension'] = "../assets/images/dimension.png";

        $data['get_invoice_details'] = $get_invoice_details;
        $data['get_work_order_details'] = $get_work_order_details;
        $get_employee_details = $this->employee_model->getEmployeeData($get_invoice_details[0]['employee_id']);
        $data['get_employee_details'] = $get_employee_details;

        $this->load->library('html2pdf');

        $directory_name = './uploads/invoice_pdf/' . $get_employee_details[0]['first_name'] . "_" . $get_employee_details[0]['last_name'] . '/' . date("Y-m-d") . "/";

        $file_name = $get_invoice_details[0]['invoice_code'] . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        echo $this->load->view('superadmin/invoice_pdf', $data, true);
        exit();
    }

    public function consultant_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_documents_details'] = $this->employee_model->getDocumentsLists();

        $data['page'] = "consultant_documents";
        $data['meta_title'] = "DOCUMENTS";
        $this->load->view('superadmin/consultant_documents', $data);
    }

    public function update_consultant_documentation_form() {
        $db = get_instance()->db->conn_id;

        $doc_id = base64_decode($this->input->post('doc_id'));

        $required_for_arr = $this->input->post('required_for');
        $required_for = implode(",", $required_for_arr);
//        echo $required_for;
//        die;
        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));

        $get_doc_details = $this->vendor_model->getConsultantDocsDetails($doc_id);

        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                $errors[] = "'File size must be exactly 2 MB";
            }

            if (empty($errors) == true) {
                $file_path = "./uploads/";
                $path = $file_path . $get_doc_details[0]['file'];
                if (file_exists($path)) {
                    unlink($path);
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "'File size must be exactly 2 MB";
                    redirect(base_url() . 'edit-consultant-documents/' . base64_encode($doc_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'edit-consultant-documents/' . base64_encode($doc_id));
                }
            }
        } else {
            $new_file_name = $get_doc_details[0]['file'];
        }

        $update_arr = array(
            'document_name' => $document_name,
            'required_for' => $required_for,
            'file' => $new_file_name
        );

        $update_query = $this->employee_model->update_consultant_docs($update_arr, $doc_id);

        if ($update_query != '0') {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'manage-documents');
        } else {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'manage-documents');
        }
    }

    public function add_consultant_documentations() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "consultant_documents";
        $data['meta_title'] = "CONSULTANT DOCUMENTATIONS";

        $this->load->view('superadmin/add_consultant_documentations', $data);
    }

    public function insert_documentation_form() {
        $db = get_instance()->db->conn_id;

        $required_for_arr = $this->input->post('required_for');
        $required_for = implode(",", $required_for_arr);
        $doc_type = $this->input->post('doc_type');
       // echo $required_for;
       // die;
        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'add_consultant_documentations');
        } else {


            if ($_FILES['file']['name'] != '') {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
//echo "<pre>";
//print_r($file_errors);
//die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add_consultant_documentations');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add_consultant_documentations');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'document_name' => $document_name,
                'required_for' => $required_for,
                'file' => $new_file_name,
                'entry_date' => date("Y-m-d"),
                'document_timing' => $doc_type
            );

            $insert_query = $this->employee_model->add_consultants_documents($insert_arr);

            if ($insert_query != '') {

                    $email_list = $this->employee_model->send_new_doc_email($required_for, $doc_type);
                    $msg = "Hi,<br> please submit the " . $document_name . " document by logging in into your dashboard.";
                    $data['msg'] = $msg;
                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;

                    $this->load->library('email');
                    


                    foreach ($email_list as $users_email) {

                        $this->email->from($from_email);
                        $this->email->to($users_email['employee_email']);
                        $this->email->bcc(SUPERADMIN_EMAIL);
                        $this->email->subject('Please Submit New Document');
                        $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                        $this->email->set_mailtype('html');

                        $this->email->send();
                    }
                    
                $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                redirect(base_url() . 'manage-documents');
            } else {
                $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                redirect(base_url() . 'manage-documents');
            }
        }
    }

    public function edit_consultant_documents() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['get_doc_details'] = $this->vendor_model->getConsultantDocsDetails($doc_id);

        $data['page'] = "consultant_documents";
        $data['meta_title'] = "CONSULTANT DOCUMENTS";
        $this->load->view('superadmin/edit_consultant_documents', $data);
    }

    public function delete_consultant_documents() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $doc_id = base64_decode($this->uri->segment(2));

        $get_doc_details = $this->employee_model->getDocsDetails($doc_id);
        $path = "./uploads/" . $get_doc_details[0]['file'];
        if (file_exists($path)) {
            unlink($path);
            $delete_query = $this->employee_model->deleteDocuments($doc_id);
        }

        if ($delete_query > '0') {

            $this->session->set_flashdata('succ_msg', 'Consultant Documents deleted Successfully..');
            redirect(base_url() . 'consultant_documents');
        } else {
            $this->session->set_flashdata('error_msg', 'Consultant Documents not deleted Successfully..');
            redirect(base_url() . 'consultant_documents');
        }
    }

    public function view_consultant_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $client_id = 0;
        $is_uhg = 0;
		$is_jci = 0;
		
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
		$emp_enrollment_type = $data['get_employee_details'][0]['emp_pay_rate_type'];
		
		
        if (!empty($data['get_employee_details'])) {
            $employee_type = $data['get_employee_details'][0]['employee_type'];
        }

        if ($employee_type == 'C') {
            $data['emp_type'] = "Consultant";
            $get_work_order_status = $this->employee_model->checkWorkOrderStatus($employee_id);
            if (!empty($get_work_order_status)) {
                $client_id = $get_work_order_status[0]['client_name'];
				
				//code to retrieve client name from client id
				$data['get_client_details'] = $this->employee_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
				//echo $client_name;
            } else {
                $client_id = 0;
				$client_name = "";
            }
        } else if ($employee_type == 'E') {
            $data['emp_type'] = "Employee";
            $client_id = $data['get_employee_details'][0]['client_id'];
			
			//code to retrieve client name from client id
				$data['get_client_details'] = $this->employee_model->getClientData($client_id);
				$client_name = $data['get_client_details'][0]['client_name'];
                //echo $client_name;
        }

        if ($client_name == 'United Health Group') {
            $is_uhg = 1;
        } else {
            $is_uhg = 0;
        }
		
		if($client_name == 'JCI'){
			$is_jci = 1;
		}else{
			$is_jci = 0;
		}
		
        $data['get_documents_details'] = $this->employee_model->getAllFilesByClient($employee_type, $is_uhg, $is_jci, $emp_enrollment_type);
        if ($employee_type == 'C') {
            $data['emp_type'] = "Consultant";
        } else {
            $data['emp_type'] = "Employee";
        }
        $data['get_sadmin_approve_status'] = $this->employee_model->get_ucsis_sadmin_approve_status($employee_id);
        $data['get_emp_uscis_files'] = $this->employee_model->getUscisFiles($employee_id);
        $data['get_work_order_status'] = $this->employee_model->checkWorkOrderStatus($employee_id);
        $data['get_vms_emp_id_list_a'] = $this->employee_model->getvmsEmpIdListA();
        $data['get_vms_emp_id_list_b'] = $this->employee_model->getvmsEmpIdListB();
        $data['get_vms_emp_id_list_c'] = $this->employee_model->getvmsEmpIdListC();

        if ($employee_type == 'C') {
            $data['page'] = "employee_lists";
        } else {
            $data['page'] = "superadmin_employee_lists";
        }

        $data['meta_title'] = strtoupper($data['emp_type']) . " DOCUMENTS";
        $this->load->view('superadmin/employees_documents', $data);
    }

    public function approve_disapprove_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $recipients = array();

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
		
		
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        if (!empty($get_employee_details)) {

            $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_type = $get_employee_details[0]['employee_type'];
            $employee_email = $get_employee_details[0]['employee_email'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
            $get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $vendor_id = $get_vendor_details[0]['vendor_id'];

            if (!empty($get_admin_details)) {
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                if (!empty($get_sadmin_details)) {
                    $sadmin_email = $get_sadmin_details[0]['sa_email'];
                }
            }
        }


        if ($ad == 'Approved') {
            $form_status = '1';
        } else if ($ad == 'Disapproved') {
            $form_status = '0';
        }

        if (!empty($check)) {

            $update_arr = array(
                "form_status" => $form_status,
                "updated_date" => date("Y-m-d h:i:s")
            );
            $msg = "";
            foreach ($check as $tid) {
                $check_sa_form_status = $this->employee_model->check_docs_status($employee_id, $tid);
//                echo "<pre>";
//                print_r($check_sa_form_status);
//                
                if ($form_status == '0') {
                    if ($check_sa_form_status[0]['form_status'] == '1' || $check_sa_form_status[0]['form_status'] == '2') {
                        $change_status = $this->employee_model->change_docs_status($update_arr, $employee_id, $tid);
                        $get_document_details = $this->employee_model->getUploadedDocs($tid, $employee_id);
                        $msg .= ucwords($get_sadmin_details[0]['sa_name']) . " " . "has been disapproved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                        $data['msg'] = $msg;
                    } else {
                        $change_status = 0;
                    }
                } else if ($form_status == '1') {
                    if ($check_sa_form_status[0]['form_status'] == '0' || $check_sa_form_status[0]['form_status'] == '2') {
                        $change_status = $this->employee_model->change_docs_status($update_arr, $employee_id, $tid);
                        $get_document_details = $this->employee_model->getUploadedDocs($tid, $employee_id);
                        $msg .= ucwords($get_sadmin_details[0]['sa_name']) . " " . "has been approved" . " " . $get_document_details[0]['form_name'] . " for " . $employee_name . "<br/>";
                        $data['msg'] = $msg;
                    } else {
                        $change_status = 0;
                    }
                }
//                } 
            }
//echo $data['msg'];
//die;
            if ($change_status > 0) {


                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
//$admin_email = $email;
//Load email library
                $this->load->library('email');
                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    $this->email->to($employee_email);
                    $this->email->bcc($vendor_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                } else {
                    $this->email->to($employee_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($superadmin_email);
                }
                $this->email->subject('Documents Status Changed Successfully');
                $this->email->message($this->load->view('admin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if ($employee_type == 'C') {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $vendor_id . "_" . "vendor";
                    $recipients [] = $employee_id . "_" . "employee";
                } else {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                    $recipients [] = $employee_id . "_" . "employee";
                }
                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => "Document Status Changed Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                $this->session->set_flashdata('succ_msg', 'Documents Status Changed Successfully');
                redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Something went wrong !');
                redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
            }
        }
//        echo "<pre>";
//        print_r($check);
//        die;
    }

    public function approve_disapprove_ucsic_docs() {

        $recipients = array();
        $sadmin_approval = $this->input->post('sadmin_approval', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);

        $list_a_name = $this->input->post('list_a_name');
        $list_b_name = $this->input->post('list_b_name');
        $list_c_name = $this->input->post('list_c_name');

        $list_a_doc_name = $this->input->post('list_a_doc_name');
        $list_b_doc_name = $this->input->post('list_b_doc_name');
        $list_c_doc_name = $this->input->post('list_c_doc_name');

        if ($sadmin_approval != '') {
            $sadmin_approval = $sadmin_approval;
        } else {
            $sadmin_approval = "2";
        }

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        if (!empty($get_employee_details)) {

            $employee_name = $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_type = $get_employee_details[0]['employee_type'];
            $employee_email = $get_employee_details[0]['employee_email'];

            $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
            $get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
            $vendor_email = $get_vendor_details[0]['vendor_email'];
            $vendor_id = $get_vendor_details[0]['vendor_id'];

            if (!empty($get_admin_details)) {
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_id = $get_admin_details[0]['admin_id'];
                $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
                if (!empty($get_sadmin_details)) {
                    $sadmin_email = $get_sadmin_details[0]['sa_email'];
                }
            }
        }

        $check_uscis_document = $this->employee_model->getUscisFiles($employee_id);

        if (!empty($check_uscis_document)) {

            $list_a_docs = explode(",", $check_uscis_document[0]['list_a_docs']);
            $list_b_docs = explode(",", $check_uscis_document[0]['list_b_docs']);
            $list_c_docs = explode(",", $check_uscis_document[0]['list_c_docs']);

            if (!empty($list_a_docs)) {
                foreach ($list_a_docs as $adocs) {
                    $path = "./uploads/lista_pdf/" . $adocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            if (!empty($list_b_docs)) {
                foreach ($list_b_docs as $bdocs) {
                    $path = "./uploads/listb_pdf/" . $bdocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            if (!empty($list_c_docs)) {
                foreach ($list_c_docs as $cdocs) {
                    $path = "./uploads/listc_pdf/" . $cdocs;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            $delete_prev_docs = $this->employee_model->deletePrevUscDocs($employee_id);
        }

        if ($list_a_name != '') {

            $a = 0;
            $docs_name = "";
            foreach ($_FILES['list_a_doc_name']['name'] as $list_a_val) {

                if ($list_a_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_a_doc_name']['name'][$a];
                    $file_size = $_FILES['list_a_doc_name']['size'][$a];
                    $file_tmp = $_FILES['list_a_doc_name']['tmp_name'][$a];
                    $file_type = $_FILES['list_a_doc_name']['type'][$a];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");

                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
//echo "<pre>";
//print_r($file_errors);
//die;
                    if (empty($file_errors)) {
                        $docs_name .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/lista_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $a++;
            }

            $insert_arr = array(
                'employee_id' => $employee_id,
                'list_a_docs_id' => $list_a_name,
                'list_a_docs' => rtrim($docs_name, ","),
                'sadmin_status' => $sadmin_approval,
                'entry_date' => date("Y-m-d h:i:s")
            );
        } elseif ($list_b_name != '' && $list_c_name != '') {
//            echo"vgy";
//            die;

            $c = 0;
            $b = 0;
            $docs_name_listb = "";
            $docs_name_listc = "";

            foreach ($_FILES['list_b_doc_name']['name'] as $list_b_val) {

                if ($list_b_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_b_doc_name']['name'][$c];
                    $file_size = $_FILES['list_b_doc_name']['size'][$c];
                    $file_tmp = $_FILES['list_b_doc_name']['tmp_name'][$c];
                    $file_type = $_FILES['list_b_doc_name']['type'][$c];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");

                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
////echo "<pre>";
//print_r($file_errors);
//die;
                    if (empty($file_errors)) {
                        $docs_name_listb .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/listb_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $c++;
            }

            foreach ($_FILES['list_c_doc_name']['name'] as $list_c_val) {

                if ($list_c_val != '') {

                    $file_errors = array();
                    $file_name = $_FILES['list_c_doc_name']['name'][$b];
                    $file_size = $_FILES['list_c_doc_name']['size'][$b];
                    $file_tmp = $_FILES['list_c_doc_name']['tmp_name'][$b];
                    $file_type = $_FILES['list_c_doc_name']['type'][$b];
                    $file_ext_arr = explode('.', $file_name);
                    $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                    $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                    $file_extensions = array("pdf");
//
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                    }
////echo "<pre>";
////print_r($file_errors);
//die;
                    if (empty($file_errors)) {
                        $docs_name_listc .= $new_file_name . ",";
                        move_uploaded_file($file_tmp, "./uploads/listc_pdf/" . $new_file_name);
                    } else {
                        if ($file_size > 2097152) {
                            $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                            $file_errors[] = "'File size must be excately 2 MB";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                        if (in_array($file_ext, $file_extensions) === false) {
                            $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                            $file_errors[] = "extension not allowed, please choose a PDF file.";
                            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
                        }
                    }
                } else {
                    $new_file_name = "";
                }
                $b++;
            }
            $insert_arr = array(
                'employee_id' => $employee_id,
                'list_b_docs_id' => $list_b_name,
                'list_b_docs' => rtrim($docs_name_listb, ","),
                'list_c_docs_id' => $list_c_name,
                'list_c_docs' => rtrim($docs_name_listc, ","),
                'sadmin_status' => $sadmin_approval,
                'entry_date' => date("Y-m-d h:i:s")
            );
        }

        $insert_query = $this->employee_model->add_consultants_uscis_documents($insert_arr);

        if ($insert_query != '') {

            $this->session->set_flashdata('succ_msg', 'Conusltant USCIS Document Upload Successfully');
            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
        } else {
            $this->session->set_flashdata('succ_msg', 'Conusltant USCIS Document Not Upload Successfully');
            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
        }
    }

    public function ajax_change_uscis_status() {

        $uscis_id = $this->input->post('uscis_id', TRUE);
        $sadmin_approval = $this->input->post('sadmin_approval', TRUE);

        $update_arr = array(
            'sadmin_status' => $sadmin_approval,
            'updated_date' => date("Y-m-d")
        );
        $change_status = $this->employee_model->change_ucsis_status($update_arr, $uscis_id);
        if ($change_status > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function change_document_status() {

        $bs_type = $this->input->post('bs_type', TRUE);
        $employee_id = base64_decode($this->input->post('employee_id', TRUE));
        $doc_id = base64_decode($this->input->post('doc_id', TRUE));

        if ($bs_type == 'activate') {
            $update_arr = array(
                'form_status' => '1',
                'updated_date' => date("Y-m-d h:i:s")
            );
        } else if ($bs_type == 'deactivate') {
            $update_arr = array(
                'form_status' => '0',
                'updated_date' => date("Y-m-d h:i:s")
            );
        }

        $change_status = $this->employee_model->change_docs_status($update_arr, $employee_id, $doc_id);
        if ($change_status > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function project_lists() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_project_dtls'] = $this->employee_model->getProjectLists();
//echo print_r($data['get_project_dtls']);
//die;
        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT LISTS";

        $this->load->view('superadmin/project_lists', $data);
    }

    public function delete_project() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//        $sess_arr = $this->session->userdata('logged_in');
//        $email = $sess_arr['email'];
//        $data['get_details'] = $this->profile_model->getDetails($email);
        $project_id = base64_decode($this->input->post('id'));
        $check_project_dtls = $this->employee_model->checkProject($project_id);

        if (!empty($check_project_dtls)) {
            echo "3";
//redirect(base_url() . 'admin-user');
        } else {
            $update_arr = array(
                "is_deleted" => "0"
            );
            $update_query = $this->employee_model->deleteProject($update_arr, $project_id);
//            echo $update_query;
//            die;
            if ($update_query > 0) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function add_projects() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $vendor_str = "";
        $data['get_vendor_dtls'] = $this->employee_model->getVendorLists();
        $data['get_admin_dtls'] = $this->employee_model->getAdminLists();
        $data['get_project_type'] = $this->employee_model->getProjectType();
        $data['sa_id'] = $sa_id;
        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT ADD";

        $this->load->view('superadmin/add_project', $data);
    }

    public function get_vendor_list() {

        $admin_id = $this->input->post('admin_id');
        $data['get_vendor_dtls'] = $this->employee_model->selectVendorList($admin_id);
        $this->load->view('superadmin/ajax/ajax_get_vendor', $data);
    }

    public function insert_projects() {
        $db = get_instance()->db->conn_id;

        $recipients = array();

        $employee_type = $this->input->post('employee_type');
        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');
        $project_type = $this->input->post('project_type');
        $project_name = $this->input->post('project_name');
        $project_details = mysqli_real_escape_string($db, $this->input->post('project_details'));
        $client_name = $this->input->post('client_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $approx_total_time = $this->input->post('approx_total_time');
        $monthly_payment = $this->input->post('monthly_payment');

        if (isset($project_type) && $project_type == '') {
            $this->session->set_flashdata('error_msg', 'Project Type field cannot be blank');
            redirect(base_url() . 'add-projects');
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add-projects');
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url() . 'add-projects');
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url() . 'add-projects');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-projects');
        } else {

            $get_last_id = $this->employee_model->getLastID();
            if (!empty($get_last_id)) {
                $project_code = "REC00" . ($get_last_id[0]['id'] + 1);
            } else {
                $project_code = "REC001";
            }

            if ($employee_type == 'C') {
//$vendor_id = $vendor_id;
                $vendor_email = array();
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";
                foreach ($vendor_id as $vvalue) {
                    $get_vendor_details = $this->employee_model->getVendorDtls($vvalue);
                    if (!empty($get_vendor_details)) {
                        $admin_id = $get_vendor_details[0]['admin_id'];
                        $vendor_email [] = $get_vendor_details[0]['vendor_email'];
                        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

                        $admin_email = $get_admin_details[0]['admin_email'];
                        $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                        $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                        $vendor_company_name = $get_vendor_details[0]['vendor_company_name'];

                        $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($vendor_company_name) . " successfully";

                        $recipients [] = $vvalue . "_" . "vendor";
                    }
                }
            } else if ($employee_type == 'E') {
                $vendor_id = 0;
                $admin_id = $admin_id;
                $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
                $admin_email = $get_admin_details[0]['admin_email'];
                $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($admin_name) . " successfully";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";
            }

            $insert_arr = array(
                'admin_id' => $admin_id,
                'vendor_id' => implode(",", $vendor_id),
                'project_code' => $project_code,
                'project_type' => $project_type,
                'project_name' => $project_name,
                'project_details' => $project_details,
                'client_name' => $client_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'approx_total_time' => $approx_total_time,
                'monthly_payment' => $monthly_payment,
                'entry_date' => date("Y-m-d h:i:s"),
                'status' => '1'
            );

            $insert_query = $this->employee_model->add_projects($insert_arr);
//            $insert_query = '1';
//            if ($insert_query == '1') {
            if ($insert_query != '') {
                if ($end_date != '0000-00-00') {
                    $end_date = date("d-m-Y", strtotime($end_date));
                } else {
                    $end_date = "";
                }

                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                                                <p style='font-weight: 300;'>New project " . ucwords($project_name) . " is assigned to you. Requirements details of the project are as follows :  </p>
                                                <p><strong>Req Code : </strong>" . strtoupper($project_code) . "</p>
                                                <p><strong>Project Type : </strong>" . ucwords($project_type) . "</p>
                                                <p><strong>Project Name : </strong>" . ucwords($project_name) . "</p>
                                                <p><strong>Project Details : </strong>" . stripslashes($project_details) . "</p>
                                                <p><strong>Client Name : </strong>" . ucwords($client_name) . "</p>
                                                <p><strong>Start Date : </strong>" . date("d-m-Y", strtotime($start_date)) . "</p>
                                                <p><strong>End Date : </strong>" . $end_date . "</p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;


//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($employee_type == 'C') {
                    foreach ($vendor_email as $vmail) {
                        $this->email->to($vmail);
                    }
                    $this->email->bcc($admin_email);
                } elseif ($employee_type == 'E') {
                    $this->email->to($admin_email);
                }
                $this->email->bcc($superadmin_email);
                $this->email->subject('Project Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "<p style='font-weight: 800;'>  Hi,</p>
                            <p style='font-weight: 300;'>New project " . ucwords($project_name) . " is assigned to you. Requirements details of the project are as follows :  </p>
                            <p><strong>Req Code : </strong>" . strtoupper($project_code) . "</p>
                            <p><strong>Project Type : </strong>" . ucwords($project_type) . "</p>
                            <p><strong>Project Name : </strong>" . ucwords($project_name) . "</p>
                            <p><strong>Project Details : </strong>" . stripslashes($project_details) . "</p>
                            <p><strong>Client Name : </strong>" . ucwords($client_name) . "</p>
                            <p><strong>Start Date : </strong>" . date("d-m-Y", strtotime($start_date)) . "</p>
                            <p><strong>End Date : </strong>" . $end_date . "</p>";


                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Project added Successfully..');
                redirect(base_url() . 'project_lists');
            } else {
                $this->session->set_flashdata('error_msg', 'Project not added Successfully..');
                redirect(base_url() . 'project_lists');
            }
        }
    }

    public function edit_superadmin_projects() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $project_id = base64_decode($this->uri->segment(2));
        $data['get_project_dtls'] = $this->employee_model->getProjectData($project_id);
        $data['get_admin_dtls'] = $this->employee_model->getAdminDetails($data['get_project_dtls'][0]['admin_id']);
        $data['get_vendor_dtls'] = $this->employee_model->selectVendorList($data['get_project_dtls'][0]['admin_id']);
        $data['get_project_type'] = $this->employee_model->getProjectType();

        $data['page'] = "project_lists";
        $data['meta_title'] = "PROJECT EDIT";

        $this->load->view('superadmin/edit_project', $data);
    }

    public function update_superadmin_projects() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_id');
        $admin_id = $this->input->post('admin_id');
        $vendor_id = $this->input->post('vendor_id');
//        print_r($vendor_id);
//        die;
        $project_type = $this->input->post('project_type');
        $project_name = $this->input->post('project_name');
        $project_details = mysqli_real_escape_string($db, $this->input->post('project_details'));
        $client_name = $this->input->post('client_name');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $approx_total_time = $this->input->post('approx_total_time');
        $monthly_payment = $this->input->post('monthly_payment');

        if (isset($project_type) && $project_type == '') {
            $this->session->set_flashdata('error_msg', 'Project Type field cannot be blank');
            redirect(base_url() . 'edit-superamdin-projects/' . base64_encode($project_id));
        } else if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'edit-superamdin-projects/' . base64_encode($project_id));
        } else if (isset($project_details) && $project_details == '') {
            $this->session->set_flashdata('error_msg', 'Project Details field cannot be blank');
            redirect(base_url() . 'edit-superamdin-projects/' . base64_encode($project_id));
        } else if (isset($client_name) && $client_name == '') {
            $this->session->set_flashdata('error_msg', 'Client Name field cannot be blank');
            redirect(base_url() . 'edit-superamdin-projects/' . base64_encode($project_id));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'edit-superamdin-projects/' . base64_encode($project_id));
        } else {

            $update_arr = array(
                'vendor_id' => implode(",", $vendor_id),
                'project_type' => $project_type,
                'project_name' => $project_name,
                'project_details' => $project_details,
                'client_name' => $client_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'approx_total_time' => $approx_total_time,
                'monthly_payment' => $monthly_payment,
                'updated_date' => date("Y-m-d h:i:s")
            );

            $update_query = $this->employee_model->update_projects($update_arr, $project_id);

            if ($update_query > '0') {
                $get_project_details = $this->employee_model->getProjectData($project_id);

                if ($get_project_details[0]['vendor_id'] != '0') {
                    $vendor_email = array();
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";

//                    $vendor_id = $get_project_details[0]['vendor_id'];
                    foreach ($vendor_id as $vvalue) {
                        $get_vendor_details = $this->employee_model->getVendorDtls($vvalue);
                        if (!empty($get_vendor_details)) {
                            $admin_id = $get_vendor_details[0]['admin_id'];
                            $vendor_email [] = $get_vendor_details[0]['vendor_email'];
                            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

                            $admin_email = $get_admin_details[0]['admin_email'];
                            $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                            $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                            $vendor_company_name = $get_vendor_details[0]['vendor_company_name'];

                            $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($vendor_company_name) . " successfully";

                            $recipients [] = $vvalue . "_" . "vendor";
                        }
                    }
                } else if ($get_project_details[0]['vendor_id'] == '0') {
                    $vendor_id = 0;
                    $admin_id = $get_project_details[0]['admin_id'];
                    $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
                    $admin_email = $get_admin_details[0]['admin_email'];
                    $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                    $subject = "New Project " . ucwords($project_name) . " is assigned to " . ucwords($admin_name) . " successfully";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $admin_id . "_" . "admin";
                }

                if ($end_date != '0000-00-00') {
                    $end_date = date("d-m-Y", strtotime($end_date));
                } else {
                    $end_date = "";
                }


                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                            <p style='font-weight: 300;'>New project " . ucwords($project_name) . " has been updated. Requirements details of the project are as follows :  </p>
                            <p><strong>Project Type : </strong>" . ucwords($project_type) . "</p>
                            <p><strong>Project Name : </strong>" . ucwords($project_name) . "</p>
                            <p><strong>Project Details : </strong>" . stripslashes($project_details) . "</p>
                            <p><strong>Client Name : </strong>" . ucwords($client_name) . "</p>
                            <p><strong>Start Date : </strong>" . date("d-m-Y", strtotime($start_date)) . "</p>
                            <p><strong>End Date : </strong>" . $end_date . "</p>";

                $get_admin_email = $this->employee_model->getAdminDetails($admin_id);

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;


//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                if ($get_project_details[0]['vendor_id'] != '0') {
                    foreach ($vendor_email as $vmail) {
                        $this->email->to($vmail);
                    }
                    $this->email->bcc($admin_email);
                } elseif ($get_project_details[0]['vendor_id'] == '0') {
                    $this->email->to($admin_email);
                }
                $this->email->bcc($superadmin_email);
                $this->email->subject('Project Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
                $this->email->send();
//                echo $this->load->view('admin/email_template/project_assign_template', $data, true);
//                die;

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "<p style='font-weight: 800;'>  Hi,</p>
                            <p style='font-weight: 300;'>New project " . ucwords($project_name) . " has been updated. Requirements details of the project are as follows :  </p>
                            <p><strong>Req Code : </strong>" . strtoupper($get_project_details[0]['project_code']) . "</p>
                            <p><strong>Project Type : </strong>" . ucwords($project_type) . "</p>
                            <p><strong>Project Name : </strong>" . ucwords($project_name) . "</p>
                            <p><strong>Project Details : </strong>" . stripslashes($project_details) . "</p>
                            <p><strong>Client Name : </strong>" . ucwords($client_name) . "</p>
                            <p><strong>Start Date : </strong>" . date("d-m-Y", strtotime($start_date)) . "</p>
                            <p><strong>End Date : </strong>" . $end_date . "</p>";


                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_email[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Project updated Successfully..');
                redirect(base_url() . 'project_lists');
            } else {
                $this->session->set_flashdata('succ_msg', 'Project updated Successfully..');
                redirect(base_url() . 'project_lists');
            }
        }
    }

    public function view_consultant_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $sa = $data['get_details'][0]['sa_id'];

        $project_id = base64_decode($this->uri->segment(2));

        $data['get_employee_details'] = $this->employee_model->getAssignedEmpoyees($project_id);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);

        $data['project_id'] = $project_id;

        $data['page'] = "project_lists";
        $data['meta_title'] = "CONSULTANT LISTS PROJECT WISE";

        $this->load->view('superadmin/view_assigned_employees', $data);
    }

    public function vendor_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $data['get_documents_details'] = $this->vendor_model->getDocumentsLists();

        $data['page'] = "vendor_documents";
        $data['meta_title'] = "VENDOR DOCUMENTS";
        $this->load->view('superadmin/vendor_documents', $data);
    }

    public function add_vendor_documentations() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $data['page'] = "vendor_documents";
        $data['meta_title'] = "VENDOR DOCUMENTATIONS";

        $this->load->view('superadmin/add_vendor_documentations', $data);
    }

    public function insert_vendor_documentation_form() {
        $db = get_instance()->db->conn_id;
        $document_name = mysqli_real_escape_string($db, $this->input->post('document_name'));
        if (isset($document_name) && $document_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'add-vendor-doc');
        } else {


            if ($_FILES['file']['name'] != '') {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }
                $file_path = "./uploads/vendor/documents/";
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                if (empty($file_errors) == true) {

                    move_uploaded_file($file_tmp, $file_path . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-vendor-doc');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-vendor-doc');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'document_name' => $document_name,
                'file' => $new_file_name,
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->vendor_model->add_vendor_documents($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Vendor Documents added Successfully.');
                redirect(base_url() . 'vendor-docs');
            } else {
                $this->session->set_flashdata('error_msg', 'Vendor Documents not added Successfully.');
                redirect(base_url() . 'vendor-docs');
            }
        }
    }

    public function edit_vendor_documents() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['get_doc_details'] = $this->vendor_model->getVendorDocsDetails($doc_id);

        $data['page'] = "vendor_documents";
        $data['meta_title'] = "VENDOR DOCUMENTS";
        $this->load->view('superadmin/edit_vendor_documents', $data);
    }

    public function update_vendor_documentation_form() {
        $db = get_instance()->db->conn_id;

        $doc_id = base64_decode($this->input->post('doc_id'));
        $get_doc_details = $this->vendor_model->getVendorDocsDetails($doc_id);

        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                $errors[] = "'File size must be exactly 2 MB";
            }

            if (empty($errors) == true) {
                $file_path = "./uploads/vendor/documents/";
                $path = $file_path . $get_doc_details[0]['file'];
                if (file_exists($path)) {
                    unlink($path);
                }
                move_uploaded_file($file_tmp, "./uploads/vendor/documents/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "'File size must be exactly 2 MB";
                    redirect(base_url() . 'edit-vendor-documents/' . base64_encode($doc_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'edit-vendor-documents/' . base64_encode($doc_id));
                }
            }
        } else {
            $new_file_name = $get_doc_details[0]['file'];
        }

        $update_arr = array(
            'file' => $new_file_name
        );

        $update_query = $this->employee_model->update_docs($update_arr, $doc_id);

        if ($update_query != '0') {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully.');
            redirect(base_url() . 'vendor-docs');
        } else {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully.');
            redirect(base_url() . 'vendor-docs');
        }
    }

    public function superadmin_employee_list() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_employee_details'] = $this->employee_model->getEmployeeListsbyType();

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE LISTS";
        $data['super_admin_email']=$email;
        $this->load->view('superadmin/superadmin_employee_list', $data);
    }

    public function sadmin_emp_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['get_employee_details'] = $this->employee_model->getEmployeeListsbyType();

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "EMPLOYEE TIMESHEET";

        $this->load->view('superadmin/sadmin_emp_timesheet', $data);
    }

    public function add_superadmin_employee_user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_admin'] = $this->employee_model->getAdminLists($email);
        $data['get_client'] = $this->employee_model->getClientLists();

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE ADD";

        $this->load->view('superadmin/add_superadmin_employee_user', $data);
    }

    public function insert_superadmin_employee_user() {
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $client_id = $this->input->post('client_id');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_type = $this->input->post('employee_type');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_ext = $this->input->post('phone_ext');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $employee_ot_rate = $this->input->post('employee_ot_rate');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $date_of_joining = $this->input->post('date_of_joining');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

//        $n_doj = explode("/", $date_of_joining);
//        $new_doj = $n_doj[2] . "-" . $n_doj[0] . "-" . $n_doj[1];

        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $get_sadmin_details = $this->employee_model->getSuperAdminDetails($get_admin_details[0]['sa_id']);
        $check_last_id = $this->employee_model->checkAdminCount($admin_id);
        $count = $check_last_id[0]['cnt'] + 1;

        $words = explode(" ", $get_admin_details[0]['admin_company_name']);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $employee_code = strtoupper($acronym . "E") . str_pad($count, 3, "0", STR_PAD_LEFT);

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'Employee First Name cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        } elseif (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Employee Last Name cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Employee Designation cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Employee Classification cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        }else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Employee Category cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'add-superadmin-employee-user');
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                    $errors[] = "'File size must be exactly 2 MB";
                }

                if (empty($errors) == true) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be exactly 2 MB');
                        $errors[] = "'File size must be exactly 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_file_name = '';
            }


            /* ---------------Resume-------------- */

            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf", "doc", "docx");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_resume_file_name = "";
            }

            /* ---------------Resume-------------- */

// ---------------Pay Staff File--------------

            if ($_FILES['pay_staff_file']['name'] != '') {

                $pay_staff_file_errors = array();
                $pay_staff_file_name = $_FILES['pay_staff_file']['name'];
                $pay_staff_file_size = $_FILES['pay_staff_file']['size'];
                $pay_staff_file_tmp = $_FILES['pay_staff_file']['tmp_name'];
                $pay_staff_file_type = $_FILES['pay_staff_file']['type'];
                $pay_staff_file_ext_arr = explode('.', $pay_staff_file_name);
                $pay_staff_file_ext = strtolower($pay_staff_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_pay_staff_file_name = time() . rand(00, 99) . '.' . $pay_staff_file_ext;
                $pay_staff_file_expensions = array("pdf", "doc", "docx");

                if (in_array($pay_staff_file_ext, $pay_staff_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($pay_staff_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $pay_staff_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($pay_staff_file_errors) == true) {

                    move_uploaded_file($pay_staff_file_tmp, "./uploads/" . $new_pay_staff_file_name);
                } else {
                    if ($pay_staff_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $pay_staff_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($pay_staff_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_pay_staff_file_name = "";
            }

// ---------------Pay Staff File--------------
// ---------------W2 File--------------

            if ($_FILES['w2_file']['name'] != '') {

                $w2_file_errors = array();
                $w2_file_name = $_FILES['w2_file']['name'];
                $w2_file_size = $_FILES['w2_file']['size'];
                $w2_file_tmp = $_FILES['w2_file']['tmp_name'];
                $w2_file_type = $_FILES['w2_file']['type'];
                $w2_file_ext_arr = explode('.', $w2_file_name);
                $w2_file_ext = strtolower($w2_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_w2_file_name = time() . rand(00, 99) . '.' . $w2_file_ext;
                $w2_file_expensions = array("pdf", "doc", "docx");

                if (in_array($w2_file_ext, $w2_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($w2_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $w2_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($w2_file_errors) == true) {

                    move_uploaded_file($w2_file_tmp, "./uploads/" . $new_w2_file_name);
                } else {
                    if ($w2_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $w2_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($w2_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_w2_file_name = "";
            }

// ---------------W2 File--------------

            $insert_arr = array(
                'admin_id' => $admin_id,
                'client_id' => $client_id,
                'employee_code' => $employee_code,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_type' => $employee_type,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'employee_designation' => $employee_designation,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'pay_staff_file' => $new_pay_staff_file_name,
                'w2_file' => $new_w2_file_name,
                'phone_ext' => $phone_ext,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'entry_date' => date("Y-m-d h:i:s"),
                'date_of_joining' => $date_of_joining,
                'employee_ot_rate' => $employee_ot_rate,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate,
                'emp_bill_rate_type' => $employee_bill_rate_type,
                'emp_pay_rate_type' => $employee_pay_rate_type,
            );
//echo "<pre>";
//print_r($insert_arr);
//die;
            $insert_query = $this->employee_model->add_employee_user($insert_arr);

            if ($insert_query != '') {

                $employee_name = $first_name . " " . $last_name;

                // if ($employee_category == '1') {
                //     $employee_category = "W2";
                // } else {
                //     $employee_category = "Subcontractor";
                // }

                $name_prefix = $name_prefix;
                $employee_name = $first_name . " " . $last_name;
                $employee_code = $employee_code;
                $employee_category = $employee_category;
                $employee_designation = $employee_designation;

                $data['msg'] = "<p style='font-weight: 800;'>New employee is added successfully. Employee Details are as follows : </p>
                                                <p style='font-weight: 300;'>
                                                    <label><strong>Employee Details : </strong></label><br/>
                                                    <label><strong>Employee Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                                                    <label><strong>Employee Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Designation : </strong>" . $employee_designation . " " . ucwords($employee_name) . "</label><br/>
                                                    <label><strong>Employee Category : </strong>" . $employee_category . "</label><br/>
                                                </p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('New Employee Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = "<label><strong>" . ucwords($get_sadmin_details[0]['sa_name']) . "</strong></label>" . " " . " " . "<p style='font-weight: 800;'>has been added new employee successfully. Employee Details are as follows : </p>
                        <p style='font-weight: 300;'>
                            <label><strong>Employee Code : </strong>" . strtoupper($employee_code) . "</label><br/>
                            <label><strong>Employee Name : </strong>" . $name_prefix . " " . ucwords($employee_name) . "</label><br/>
                            <label><strong>Employee Designation : </strong>" . $employee_designation . "</label><br/>
                            <label><strong>Employee Category : </strong>" . $employee_category . "</label><br/>
                        </p>";
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_details[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => "New Employee Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
// print_r($insert_arr);
// die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                $this->session->set_flashdata('succ_msg', 'Emplyee added Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Employee not added Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function edit_superadmin_employee_user() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
//$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $data['get_employee_data'] = $this->employee_model->getEmployeeData($employee_id);
        $data['check_generate_status'] = $this->employee_model->getGenerateStatus($employee_id);

        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_admin'] = $this->employee_model->getAdminLists($email);
        $data['get_client'] = $this->employee_model->getClientLists();

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE EDIT";

        $this->load->view('superadmin/edit_superadmin_employee_user', $data);
    }

    public function update_superadmin_employee_user() {
        $db = get_instance()->db->conn_id;

        $employee_id = base64_decode($this->input->post('employee_id'));
        $client_id = $this->input->post('client_id');
        $employee_email = $this->input->post('employee_email');
        $new_password = $this->input->post('new_password');
        $name_prefix = $this->input->post('name_prefix');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $employee_classification = $this->input->post('employee_classification');
        $employee_category = $this->input->post('employee_category');
        $employee_designation = $this->input->post('employee_designation');
        $phone_no = $this->input->post('phone_no');
        $fax_no = $this->input->post('fax_no');
        $date_of_joining = $this->input->post('date_of_joining');
        $employee_ot_rate = $this->input->post('employee_ot_rate');
        $employee_bill_rate = $this->input->post('employee_bill_rate');
        $employee_pay_rate = $this->input->post('employee_pay_rate');
        $employee_bill_rate_type = $this->input->post('emp_bill_rate_type');
        $employee_pay_rate_type = $this->input->post('emp_pay_rate_type');
        $address = mysqli_real_escape_string($db, $this->input->post('address'));

        $employee_details = $this->employee_model->getEmployeeData($employee_id);
        $check_duplicate_email = $this->employee_model->checkDuplicate($employee_email);
//        $n_doj = explode("/", $date_of_joining);
//        $new_doj = $n_doj[2] . "-" . $n_doj[0] . "-" . $n_doj[1];

        if (isset($first_name) && $first_name == '') {
            $this->session->set_flashdata('error_msg', 'First Name field cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else if (isset($last_name) && $last_name == '') {
            $this->session->set_flashdata('error_msg', 'Last Name field cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else if (isset($employee_designation) && $employee_designation == '') {
            $this->session->set_flashdata('error_msg', 'Employee Designation cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else if (isset($employee_classification) && $employee_classification == '') {
            $this->session->set_flashdata('error_msg', 'Employee Classification cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        }else if (isset($employee_category) && $employee_category == '') {
            $this->session->set_flashdata('error_msg', 'Employee Category cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else if (isset($phone_no) && $phone_no == '') {
            $this->session->set_flashdata('error_msg', 'Phone No. cannot be blank');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else if ( ($employee_email !== $employee_details[0]['employee_email']) && ($check_duplicate_email > 0) ) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
        } else {

            if ($_FILES['file']['name'] != '') {
                $errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $expensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                }

                if (empty($errors) == true) {
                    $old_file = "./uploads/" . $employee_details[0]['file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
                    }
                    if (in_array($file_ext, $expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a JPEG or PNG file.');
                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                        redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_file_name = $employee_details[0]['file'];
            }

            if ($_FILES['resume_file']['name'] != '') {

                $resume_errors = array();
                $resume_file_name = $_FILES['resume_file']['name'];
                $resume_file_size = $_FILES['resume_file']['size'];
                $resume_file_tmp = $_FILES['resume_file']['tmp_name'];
                $resume_file_type = $_FILES['resume_file']['type'];
                $resume_file_ext_arr = explode('.', $resume_file_name);
                $resume_file_ext = strtolower($resume_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_resume_file_name = time() . rand(00, 99) . '.' . $resume_file_ext;
                $resume_expensions = array("pdf");

                if (in_array($resume_file_ext, $resume_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $resume_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($resume_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $resume_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($resume_errors) == true) {

                    move_uploaded_file($resume_file_tmp, "./uploads/" . $new_resume_file_name);
                } else {
                    if ($resume_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $resume_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'edit-admin-employee-user/' . base64_encode($employee_id));
                    }
                    if (in_array($resume_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $resume_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'edit-superadmin-employee-user/' . base64_encode($employee_id));
                    }
                }
            } else {
                $new_resume_file_name = $employee_details[0]['resume_file'];
            }

// ---------------Pay Staff File-------------- 

            if ($_FILES['pay_staff_file']['name'] != '') {

                $pay_staff_file_errors = array();
                $pay_staff_file_name = $_FILES['pay_staff_file']['name'];
                $pay_staff_file_size = $_FILES['pay_staff_file']['size'];
                $pay_staff_file_tmp = $_FILES['pay_staff_file']['tmp_name'];
                $pay_staff_file_type = $_FILES['pay_staff_file']['type'];
                $pay_staff_file_ext_arr = explode('.', $pay_staff_file_name);
                $pay_staff_file_ext = strtolower($pay_staff_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_pay_staff_file_name = time() . rand(00, 99) . '.' . $pay_staff_file_ext;
                $pay_staff_file_expensions = array("pdf", "doc", "docx");

                if (in_array($pay_staff_file_ext, $pay_staff_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($pay_staff_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $pay_staff_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($pay_staff_file_errors) == true) {

                    move_uploaded_file($pay_staff_file_tmp, "./uploads/" . $new_pay_staff_file_name);
                } else {
                    if ($pay_staff_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $pay_staff_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($pay_staff_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $pay_staff_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_pay_staff_file_name = "";
            }

// ---------------Pay Staff File-------------- 
// ---------------W2 File-------------- 

            if ($_FILES['w2_file']['name'] != '') {

                $w2_file_errors = array();
                $w2_file_name = $_FILES['w2_file']['name'];
                $w2_file_size = $_FILES['w2_file']['size'];
                $w2_file_tmp = $_FILES['w2_file']['tmp_name'];
                $w2_file_type = $_FILES['w2_file']['type'];
                $w2_file_ext_arr = explode('.', $w2_file_name);
                $w2_file_ext = strtolower($w2_file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_w2_file_name = time() . rand(00, 99) . '.' . $w2_file_ext;
                $w2_file_expensions = array("pdf", "doc", "docx");

                if (in_array($w2_file_ext, $w2_file_expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                    $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                }

                if ($w2_file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $w2_file_errors[] = "'File size must be excately 2 MB";
                }

                if (empty($w2_file_errors) == true) {

                    move_uploaded_file($w2_file_tmp, "./uploads/" . $new_w2_file_name);
                } else {
                    if ($w2_file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $w2_file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                    if (in_array($w2_file_ext, $resume_expensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF/DOC/DOCX file.');
                        $w2_file_errors[] = "extension not allowed, please choose a PDF/DOC/DOCX file.";
                        redirect(base_url() . 'add-admin-employee-user');
                    }
                }
            } else {
                $new_w2_file_name = "";
            }

// ---------------W2 File-------------- 

            $update_arr = array(
                'client_id' => $client_id,
                'employee_email' => $employee_email,
                'name_prefix' => $name_prefix,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_designation' => $employee_designation,
                'temp_classification' => $employee_classification,
                'temp_category' => $employee_category,
                'file' => $new_file_name,
                'resume_file' => $new_resume_file_name,
                'pay_staff_file' => $new_pay_staff_file_name,
                'w2_file' => $new_w2_file_name,
                'phone_no' => $phone_no,
                'fax_no' => $fax_no,
                'address' => $address,
                'date_of_joining' => $date_of_joining,
                'employee_ot_rate' => $employee_ot_rate,
                'employee_bill_rate' => $employee_bill_rate,
                'employee_pay_rate' => $employee_pay_rate,
                'emp_bill_rate_type' => $employee_bill_rate_type,
                'emp_pay_rate_type' => $employee_pay_rate_type,
                'updated_date' => date("Y-m-d h:i:s")
            );
            $update_login_arr = array(
                'consultant_email' => $employee_email,
                'password'=>md5($new_password)
            );
            $update_query = $this->employee_model->update_employee_user($update_arr, $employee_id);
            $update_login_query = $this->employee_model->update_employee_login_user($update_login_arr, $employee_id);

            if ($update_query != '0') {

                $this->session->set_flashdata('succ_msg', 'Employee updated Successfully.');
                redirect(base_url() . 'superadmin-employee-list');
            } else {
                $this->session->set_flashdata('succ_msg', 'Employee not updated Successfully.');
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function generate_employee_login_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;
        $data['sa_id'] = $sa_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('superadmin/generate_employee_login_details', $data);
    }

    public function insert_employee_login_details() {
        $db = get_instance()->db->conn_id;
        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);


        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate-superadmin-employee-login-details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate-superadmin-employee-login-details/' . base64_encode($employee_id));
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'generate-superadmin-employee-login-details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

            $insert_arr = array(
                'admin_id' => $admin_id,
                'employee_id' => $employee_id,
                'consultant_email' => $consultant_email,
                'password' => md5($consultant_password),
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->employee_model->generate_login_details($insert_arr);

            if ($insert_query != '') {

                $update_arr = array(
                    'employee_email' => $consultant_email
                );
                $update_query = $this->employee_model->update_login_details($update_arr, $employee_id);

                $name_prefix = $get_employee_details[0]['name_prefix'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $consultant_email;
                $employee_password = $consultant_password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi," . $name_prefix . " " . ucwords($employee_name) . ", You are successfully enrolled in Global Resource Management System. Your login details are as follows: <br/></p>
                                                <p style='font-weight: 300;'>
                                                    <label><b>Login Details </b></label><br/>
                                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                                    <label><b>Temporary Password : </b> " . $employee_password . "</label><br/>
                                                </p>";
                $data['login_type'] = "employee";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
                $employee_email = $consultant_email;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in GRMS.');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();


                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully.');
                redirect(base_url() . 'superadmin-employee-list');
            } else {
                $this->session->set_flashdata('succ_msg', 'Login Details Not Generated Successfully.');
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function generate_consultant_login_details() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;
        $data['sa_id'] = $sa_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "employee_lists";
        $data['meta_title'] = "GENERATE LOGIN DETAILS";

        $this->load->view('superadmin/generate_consultant_login_details', $data);
    }

    public function insert_consultant_login_details() {
        $db = get_instance()->db->conn_id;
        $vendor_id = $this->input->post('vendor_id');
        $admin_id = $this->input->post('admin_id');
        $employee_id = $this->input->post('employee_id');
        $consultant_email = $this->input->post('consultant_email');
        $consultant_password = $this->input->post('consultant_password');

        $check_duplicate_email = $this->employee_model->checkDuplicate($consultant_email);


        if (isset($consultant_email) && $consultant_email == '') {
            $this->session->set_flashdata('error_msg', 'Cosultant Email cannot be blank');
            redirect(base_url() . 'generate-superadmin-consultant-login-details/' . base64_encode($employee_id));
        } else if (isset($consultant_password) && $consultant_password == '') {
            $this->session->set_flashdata('error_msg', 'Consultant Password cannot be blank');
            redirect(base_url() . 'generate-superadmin-consultant-login-details/' . base64_encode($employee_id));
        } else if ($check_duplicate_email > 0) {
            $this->session->set_flashdata('error_msg', 'Duplicate Email ID. Please Enter another Email ID');
            redirect(base_url() . 'generate-superadmin-consultant-login-details/' . base64_encode($employee_id));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $get_admin_details = $this->employee_model->getAdminDetails($admin_id);

            $insert_arr = array(
                'vendor_id' => $vendor_id,
                'admin_id' => $admin_id,
                'employee_id' => $employee_id,
                'consultant_email' => $consultant_email,
                'password' => md5($consultant_password),
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->employee_model->generate_login_details($insert_arr);

            if ($insert_query != '') {

                $update_arr = array(
                    'employee_email' => $consultant_email
                );
                $update_query = $this->employee_model->update_login_details($update_arr, $employee_id);

                $name_prefix = $get_employee_details[0]['name_prefix'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $consultant_email;
                $employee_password = $consultant_password;

                $data['msg'] = "<p style='font-weight: 800;'>  Hi," . $name_prefix . " " . ucwords($employee_name) . ", You are successfully enrolled in Global Resource Management System. Your login details are as follows: <br/></p>
                                                <p style='font-weight: 300;'>
                                                    <label><b>Login Details </b></label><br/>
                                                    <label><b>Email ID : </b> " . $employee_email . "</label><br/>
                                                    <label><b>Temporary Password : </b> " . $employee_password . "</label><br/>
                                                </p>";
                $data['login_type'] = "employee";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_email = $get_admin_details[0]['admin_email'];
                $employee_email = $consultant_email;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($employee_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('You are successfully enrolled in GRMS.');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();


                $this->session->set_flashdata('succ_msg', 'Login Details Generated Successfully.');
                redirect(base_url() . 'consultant-user');
            } else {
                $this->session->set_flashdata('succ_msg', 'Login Details Not Generated Successfully.');
                redirect(base_url() . 'consultant-user');
            }
        }
    }

    public function add_employee_work_order() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $admin_id = $get_employee_details[0]['admin_id'];
        $get_admin_details = $this->employee_model->getAdminDetails($admin_id);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $get_employee_details;
        $data['get_admin_details'] = $get_admin_details;
        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE WORK ORDER";

        $this->load->view('superadmin/add_employee_work_order', $data);
    }

    public function insert_employee_work_order() {
        $db = get_instance()->db->conn_id;

        $recipients = array();

        $admin_signature = $this->input->post('admin_signature');
        $employee_id = $this->input->post('employee_id');
        $admin_id = $this->input->post('admin_id');
        $consultant = $this->input->post('consultant');
        $start_date = $this->input->post('start_date');
        $client_name = $this->input->post('client_name');
        $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
        $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
        $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
        $bill_rate = $this->input->post('bill_rate');
        $ot_rate = $this->input->post('ot_rate');


        if (isset($consultant) && $consultant == '') {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url('add-superadmin-employee-work_order/' . base64_encode($employee_id)));
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
            redirect(base_url('add-superadmin-employee-work_order/' . base64_encode($employee_id)));
        } else if (isset($bill_rate) && $bill_rate == '') {
            $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
            redirect(base_url('add-superadmin-employee-work_order/' . base64_encode($employee_id)));
        } else if (isset($ot_rate) && $ot_rate == '') {
            $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
            redirect(base_url('add-superadmin-employee-work_order/' . base64_encode($employee_id)));
        } else if (isset($vendor_signature) && $vendor_signature == '') {
            $this->session->set_flashdata('error_msg', 'Vendor signature field cannot be blank');
            redirect(base_url('add-superadmin-employee-work_order/' . base64_encode($employee_id)));
        } else {

            $insert_arr = array(
                'employee_id' => $employee_id,
                'admin_id' => $admin_id,
                'consultant' => $consultant,
                'start_date' => $start_date,
                'client_name' => $client_name,
                'project_duration' => $project_duration,
                'invoicing_terms' => $invoicing_terms,
                'payment_terms' => $payment_terms,
                'admin_signature' => $admin_signature,
                'bill_rate' => $bill_rate,
                'ot_rate' => $ot_rate,
                'entry_date' => date("Y-m-d h:i:s"),
                'status' => '1',
                'approved_by_admin' => '1'
            );
//echo "<pre>";
//            print_r($insert_arr);
//            die;
            $insert_query = $this->employee_model->add_work_order($insert_arr);

            if ($insert_query != '') {

                $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];

                $get_admin_email = $this->vendor_model->getAdminEmail($admin_id);
                $get_sadmin_details = $this->vendor_model->getSuperAdminData($get_admin_email[0]['sa_id']);
                $sadmin_email = $get_sadmin_details[0]['sa_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_email = $get_admin_email[0]['admin_email'];
                $data['msg'] = ucwords($get_sadmin_details[0]['sa_name']) . " " . "has been added Work order for " . ucwords($employee_name);
//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Work Order Added Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                $msg = ucwords($get_sadmin_details[0]['sa_name']) . " " . "has been added Work order for " . ucwords($employee_name);
                $recipients [] = 1 . "_" . "superadmin";
                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $get_admin_email[0]['sa_id'],
                        "sender_type" => "superadmin",
                        "subject" => "Work Order Added Successfully",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Work Order Added Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Work Order Not Added Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function view_employees_work_order_pdf() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->library('html2pdf');

        $directory_name = './uploads/work_order_pdf/' . date("Y-m-d") . "/" . $get_admin_details[0]['first_name'] . "_" . $get_admin_details[0]['last_name'] . '/' . $get_employee_details[0]['employee_code'] . '/';

        $file_name = time() . rand(00, 99) . ".pdf";

        if (!file_exists($directory_name)) {
            mkdir($directory_name, 0777, true);
        }
        $this->html2pdf->folder($directory_name);
        $this->html2pdf->filename($file_name);
        $this->html2pdf->paper('a4', 'portrait');

        $this->html2pdf->html($this->load->view('superadmin/view_superadmin_employees_work_order_pdf', $data, true));
        if ($this->html2pdf->create('view_only')) {
            redirect(base_url() . 'superadmin-employee-list');
        }
    }

    public function assign_project_to_employee() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_projects'] = $this->employee_model->getProjectLists();
        $data['get_employees'] = $this->employee_model->getEmployeeListsbyType();

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "ASSIGN PROJECTS TO EMPLOYEE ";

        $this->load->view('superadmin/assign_employee_to_project', $data);
    }

    public function add_assign_projects() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
//echo "<pre>";
//print_r($employee_ids);
//die;
        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-employee');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-employee');
        } else {
            $errors = array();
            $error = "";
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                $get_employee_details = $this->employee_model->getEmployeeData($eval);
                $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'status' => '2'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);

                        if ($get_employee_details[0]['employee_category'] == '1') {
                            $employee_category = "W2";
                        } else {
                            $employee_category = "Subcontractor";
                        }


                        $data['msg'] = "<p style='font-weight: 800;'>Superadmin has assigned a new employee for the following project. Project details and Employee details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label><?php echo ucwords($get_project_details[0]['project_name']); ?><br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details[0]['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Employee Details </label><br/>
                                            <label style='font-weight: bold;'>Employee Code : </label>" . strtoupper($get_employee_details['0']['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Employee Category : </label>" . $employee_category . "
                                        <br/>
                                        </p>";

                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $employee_email = $get_employee_details[0]['employee_email'];

//Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($admin_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
//Send mail
                        $this->email->send();

                        $error = "1";
                    }
                } else {
                    $get_employee_details = $this->employee_model->getEmployeeData($eval);
                    $errors[] = ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is Already Assigned.";
                }
            }
            if (!empty($errors)) {
                $this->session->set_flashdata('error_msg', $errors);
                redirect(base_url() . 'assign-projects-to-superadmin-employee');
            } else if ($error == '1') {

                $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function assign_project_to_consultant() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;

        $data['get_projects'] = $this->employee_model->getProjectLists();
        $data['get_employees'] = $this->employee_model->getEmployeeLists();

        $data['page'] = "employee_lists";
        $data['meta_title'] = "ASSIGN PROJECTS TO CONSULTANT ";

        $this->load->view('superadmin/assign_consultant_to_project', $data);
    }

    public function add_assign_projects_consultant() {
        $db = get_instance()->db->conn_id;

        $project_id = $this->input->post('project_name');
        $employee_ids = $this->input->post('employee_id');
//echo "<pre>";
//print_r($employee_ids);
//die;
        if (isset($project_name) && $project_name == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-consultant');
        } else if (empty($employee_ids)) {
            $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
            redirect(base_url() . 'assign-projects-to-superadmin-consultant');
        } else {
            $errors = array();
            $error = "";
            foreach ($employee_ids as $eval) {

                $check_prev_assign = $this->employee_model->check_prev_assign($project_id, $eval);
                $get_employee_details = $this->employee_model->getEmployeeData($eval);
                $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
                if ($check_prev_assign[0]['cnt'] == 0) {
                    $insert_arr = array(
                        'vendor_id' => $get_employee_details[0]['vendor_id'],
                        'project_id' => $project_id,
                        'employee_id' => $eval,
                        'entry_date' => date("Y-m-d h:i:s"),
                        'updated_date' => date("Y-m-d h:i:s"),
                        'status' => '1'
                    );

                    $insert_query = $this->employee_model->add_assign_projects($insert_arr);

                    if ($insert_query != '') {
                        $get_project_details = $this->employee_model->getProjectData($project_id);

                        if ($get_employee_details[0]['employee_category'] == '1') {
                            $employee_category = "W2";
                        } else {
                            $employee_category = "Subcontractor";
                        }


                        $data['msg'] = "<p style='font-weight: 800;'>Superadmin has assigned a new employee for the following project. Project details and Employee details are as follows:</p>
                                        <p style='font-weight: 300;width: 45%;float: left;font-size: 12px;'>
                                        <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Project Details </label><br/>
                                        <label style='font-weight: bold;'>Project Code : </label>" . strtoupper($get_project_details[0]['project_code']) . "<br/>
                                        <label style='font-weight: bold;'>Project Name :  </label><?php echo ucwords($get_project_details[0]['project_name']); ?><br/>
                                        <label style='font-weight: bold;'>Project Start Date : </label>" . date("d-m-Y", strtotime($get_project_details[0]['start_date'])) . "<br/>
                                        </p>
                                        <p style='font-weight: 300;width: 55%;float: left;font-size: 12px;'>
                                            <label style='font-weight: bold;border-bottom: 1px solid #a1a1a1;'>Employee Details </label><br/>
                                            <label style='font-weight: bold;'>Employee Code : </label>" . strtoupper($get_employee_details['0']['employee_code']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Name : </label>" . $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . "<br/>
                                            <label style='font-weight: bold;'>Employee Designation : </label>" . $get_employee_details[0]['employee_designation'] . "<br/>
                                            <label style='font-weight: bold;'>Employee Category : </label>" . $employee_category . "
                                        <br/>
                                        </p>";

                        $from_email = REPLY_EMAIL;
                        $superadmin_email = SUPERADMIN_EMAIL;
                        $admin_email = $get_admin_details[0]['admin_email'];
                        $employee_email = $get_employee_details[0]['employee_email'];

//Load email library
                        $this->load->library('email');

                        $this->email->from($from_email);
                        $this->email->to($admin_email);
                        $this->email->bcc($superadmin_email);
                        $this->email->subject('New Project Assigned Successfully');
                        $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                        $this->email->set_mailtype('html');
//Send mail
                        //$this->email->send();

                        $error = "1";
                    }
                } else {
                    $get_employee_details = $this->employee_model->getEmployeeData($eval);
                    $errors[] = ucwords($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']) . " is Already Assigned.";
                }
            }
            if (!empty($errors)) {
                $this->session->set_flashdata('error_msg', $errors);
                redirect(base_url() . 'add_assign_projects_consultant');
            } else if ($error == '1') {

                $this->session->set_flashdata('succ_msg', "Project Assigned Successfully");
                redirect(base_url() . 'consultant-user');
            }
        }
    }

    public function show_files() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $doc_id = base64_decode($this->uri->segment(2));
        $employee_id = base64_decode($this->uri->segment(3));

        $get_file_details = $this->profile_model->getFileDetails($doc_id, $employee_id);
//        echo "<pre>";
//        print_r($get_file_details);
        if (!empty($get_file_details)) {
            $data['form_name'] = $get_file_details[0]['form_name'];
            $data['form_data'] = json_decode($get_file_details[0]['form_data']);
        }
        $data['img_src'] = "./assets/images/pts.jpg";
//print_r($data['form_data']);
        $this->load->view('superadmin/form_templates/print_direct_deposit_form', $data);
    }

    public function consultant_onboarding() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];
        $data['get_documents_details'] = $this->employee_model->getDocumentsListsbyEmpType($employee_type);
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "EMPLOYEE ONBOARDING";
        $this->load->view('superadmin/consultant_documentation', $data);
    }

    public function upload_consultant_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $employee_id = base64_decode($this->uri->segment(3));
        $data['employee_id'] = $employee_id;
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['page'] = "open_requirements";
        $data['doc_id'] = $doc_id;
        $data['get_document_details'] = $this->employee_model->getDocsDetails($doc_id);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "UPLOAD DOCUMENTS";
        $this->load->view('superadmin/upload_consultant_documents', $data);
    }

    public function upload_document() {

        $recipients = array();

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $employee_id = $this->input->post('employee_id');

        $check_prev_uploaded_document = $this->employee_model->checkPrevUploaded($doc_id, $employee_id);
        $check_approve_status = $this->employee_model->checkApproveStatus($doc_id, $employee_id);
        if ($check_prev_uploaded_document[0]['cnt'] > 0 && ($check_approve_status[0]['form_status'] == '1' || $check_approve_status[0]['admin_form_status'] == '1')) {
            $this->session->set_flashdata('error_msg', 'Document already approved.');
            redirect(base_url() . 'superadmin_employee_onboarding/' . base64_encode($employee_id));
        }
        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 5242880) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 5 MB');
                $errors[] = "'File size must be excately 5 MB";
            }

            if (empty($errors) == true) {

                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 5242880) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 5 MB');
                    $errors[] = "'File size must be excately 5 MB";
                    redirect(base_url() . 'upload_superadmin_employee_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_superadmin_employee_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->employee_model->getDocsDetails($doc_id);
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);

        $insert_arr = array(
            'consultant_id' => $employee_id,
            'form_no' => $doc_id,
            'form_name' => $get_document_details[0]['document_name'],
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s")
        );
        $del_query = $this->employee_model->deletePreviousDocs($doc_id, $employee_id);

        if ($del_query > 0) {
            $insert_query = $this->employee_model->add_employee_documents($insert_arr);

            if ($insert_query != '') {

                $employee_code = $get_employee_details[0]['employee_code'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = ucwords($employee_code) . "-" . ucwords($employee_name) . " has uploaded " . ucwords($get_document_details[0]['document_name']) . " document. Please view and approve the documents.";
                $data['msg'] = $msg;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Pending Verification');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "Pending Verification",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
                redirect(base_url() . 'superadmin_employee_onboarding/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'superadmin_employee_onboarding/' . base64_encode($employee_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'superadmin_employee_onboarding/' . base64_encode($employee_id));
        }
    }

    public function upload_sa_doc() {

        $recipients = array();

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $db = get_instance()->db->conn_id;
        $doc_id = $this->input->post('doc_id');
        $employee_id = $this->input->post('employee_id');

        $check_prev_uploaded_document = $this->employee_model->checkPrevUploaded($doc_id, $employee_id);
        $check_approve_status = $this->employee_model->checkApproveStatus($doc_id, $employee_id);
        if ($check_prev_uploaded_document[0]['cnt'] > 0 && ($check_approve_status[0]['form_status'] == '1' || $check_approve_status[0]['admin_form_status'] == '1')) {
            $this->session->set_flashdata('error_msg', 'Document already approved.');
            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
        }
        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                $errors[] = "'File size must be excately 2 MB";
            }

            if (empty($errors) == true) {

                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'upload_sa_consultant_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'upload_sa_consultant_documents/' . base64_encode($doc_id) . '/' . base64_encode($employee_id));
                }
            }
        } else {

            $new_file_name = '';
        }

        $get_document_details = $this->employee_model->getDocsDetails($doc_id);
        $get_employee_details = $this->employee_model->getConsultantData($employee_id);
//        $get_vendor_details = $this->employee_model->getVendorData($get_employee_details[0]['vendor_id']);
        $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
        $get_prev_uploaded_document = $this->employee_model->getPrevUploaded($doc_id, $employee_id);


        if (!empty($get_prev_uploaded_document)) {

            $prev_doc = $get_prev_uploaded_document[0]['file'];
            $path = "./uploads/" . $prev_doc;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $del_query = $this->employee_model->deletePreviousDocsbyID($doc_id, $employee_id);
        $insert_arr = array(
            'consultant_id' => $employee_id,
            'form_no' => $doc_id,
            'form_name' => $get_document_details[0]['document_name'],
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d h:i:s"),
            'form_status' => '2'
        );
//        $del_query = $this->employee_model->deletePreviousDocs($doc_id, $employee_id);

        if ($del_query > 0) {
            $insert_query = $this->employee_model->add_employee_documents($insert_arr);

            if ($insert_query != '') {

                $employee_code = $get_employee_details[0]['employee_code'];
                $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_email = $get_employee_details[0]['employee_email'];

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;
                $admin_id = $get_admin_details[0]['admin_id'];
                $admin_email = $get_admin_details[0]['admin_email'];
//                $vendor_id = $get_admin_details[0]['vendor_id'];
//                $vendor_email = $get_admin_details[0]['vendor_email'];

                $msg = ucwords($employee_code) . "-" . ucwords($employee_name) . " has uploaded " . ucwords($get_document_details[0]['document_name']) . " document. Please view and approve the documents.";
                $data['msg'] = $msg;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Pending Verification');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                $this->email->set_mailtype('html');
//Send mail
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */


                $recipients [] = $admin_id . "_" . "admin";

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "Pending Verification",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//                    print_r($insert_arr);
//                    die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Document uploaded Successfully..');
                redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
            } else {
                $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
                redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Document not uploaded Successfully..');
            redirect(base_url() . 'view_superadmin_consultant_documents/' . base64_encode($employee_id));
        }
    }

    public function upload_sa_consultant_documents() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
       
		$data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        
		$employee_id = base64_decode($this->uri->segment(3));
        $data['employee_id'] = $employee_id;
        $data['get_files'] = $this->employee_model->getFiles($employee_id);
        $doc_id = base64_decode($this->uri->segment(2));

        $data['page'] = "open_requirements";
        $data['doc_id'] = $doc_id;
        $data['get_document_details'] = $this->employee_model->getDocsDetails($doc_id);
        $data['get_employee_details'] = $this->employee_model->getConsultantData($employee_id);
        $employee_type = $data['get_employee_details'][0]['employee_type'];

        $data['page'] = "employee_lists";
        $data['meta_title'] = "UPLOAD DOCUMENTS";
        $this->load->view('superadmin/upload_sa_consultant_docs', $data);
    }

    public function generate_sa_employee_payment() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $employee_id = base64_decode($this->uri->segment(2));

        $data['employee_id'] = $employee_id;

        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);

        $data['page'] = "superadmin_employee_lists";
        $data['meta_title'] = "GENERATE INVOICE";

        $this->load->view('superadmin/generate_sa_employee_payment', $data);
    }

    public function ajax_monthly_timesheet() {
        $month = $this->input->post('month', TRUE);
        $year = $this->input->post('year', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
//        print_r($get_emp_details);
        $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_details[0]['employee_bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_details[0]['employee_ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);

        $data = array(
            "employee_name" => $get_emp_details[0]['first_name'] . " " . $get_emp_details[0]['last_name'],
            "employee_code" => $get_emp_details[0]['employee_code'],
            "employee_designation" => $get_emp_details[0]['employee_designation'],
            "month" => $month,
            "year" => $year,
            "tot_time" => $tot_time,
            "bill_rate" => $bill_rate,
            "tot_time_pay" => $tot_time_pay,
            "over_time" => $over_time,
            "ot_rate" => $ot_rate,
            "over_time_pay" => $over_time_pay,
        );

        $this->load->view('superadmin/ajax/ajax_get_monthly_details', $data);
    }

    public function ajax_weekly_timesheet() {
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $get_emp_details = $this->employee_model->getEmployeeData($employee_id);
//print_r($get_emp_work_order);
        $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

        $tot_time = $get_emp_timesheet['st'];
        $bill_rate = $get_emp_details[0]['employee_bill_rate'];
        $tot_time_pay = round(($tot_time * $bill_rate), 2);

        $over_time = $get_emp_timesheet['ot'];
        $ot_rate = $get_emp_details[0]['employee_ot_rate'];
        $over_time_pay = round(($over_time * $ot_rate), 2);


        $data = array(
            "employee_name" => $get_emp_details[0]['first_name'] . " " . $get_emp_details[0]['last_name'],
            "employee_code" => $get_emp_details[0]['employee_code'],
            "employee_designation" => $get_emp_details[0]['employee_designation'],
            "start_date" => $start_date,
            "end_date" => $end_date,
            "tot_time" => $tot_time,
            "bill_rate" => $bill_rate,
            "tot_time_pay" => $tot_time_pay,
            "over_time" => $over_time,
            "ot_rate" => $ot_rate,
            "over_time_pay" => $over_time_pay,
        );

        $this->load->view('superadmin/ajax/ajax_get_weekly_details', $data);
    }

    public function sa_generate_payment() {

        $recipients = array();
        $db = get_instance()->db->conn_id;
        $sa_id = $this->input->post('sa_id');
        $employee_id = $this->input->post('employee_id');
        $payment_type = $this->input->post('payment_type');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $daily_start_date = $this->input->post('daily_start_date');
        $daily_end_date = $this->input->post('daily_end_date');

        $month = $this->input->post('month');
        $year = date("Y");
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        if (isset($payment_type) && $payment_type == '') {
            $this->session->set_flashdata('error_msg', 'Payment Type field cannot be blank');
            redirect(base_url('sa-generate-invoice/' . base64_encode($employee_id)));
        } else {

            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
            $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_code = $get_employee_details[0]['employee_code'];

            $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
            $code = ltrim($check_prev_generated_code[0]['invoice_code'], "INV");
            $invoice_code = "INV00" . ($code + 1);

            if ($payment_type == '1') {

                $check_date = $this->employee_model->getCheckDate($start_date, $end_date, $employee_id);
//print_r($check_date);
//                die;
                if ($check_date[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'superadmin-employee-list');
                }

                $get_emp_timesheet = $this->employee_model->getWeeklyTimesheet($start_date, $end_date, $employee_id);

                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_employee_details[0]['employee_bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['weekly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
                    "employee_id" => $employee_id,
                    "payment_type" => $payment_type,
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "work_duration" => $work_duration,
                    "tot_time" => $tot_time,
                    "bill_rate" => $bill_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $over_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "comment" => $comment,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "updated_date" => date("Y-m-d h:i:s"),
                    "status" => "1"
                );
            } else if ($payment_type == '2') {

                $check_month = $this->employee_model->getCheckMonth($month, $year, $employee_id);
                if ($check_month[0]['cnt'] > '0') {
                    $this->session->set_flashdata('error_msg', 'Payment data already generated');
                    redirect(base_url() . 'superadmin-employee-list');
                }

                $get_emp_timesheet = $this->employee_model->getMonthlyTimesheet($month, $year, $employee_id);
                $tot_time = $get_emp_timesheet['st'];
                $bill_rate = $get_employee_details[0]['employee_bill_rate'];
                $tot_time_pay = round(($tot_time * $bill_rate), 2);

                $over_time = $get_emp_timesheet['ot'];
                $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                $over_time_pay = round(($over_time * $ot_rate), 2);

                $work_duration = $get_emp_timesheet['monthly_work_duration'];

                $insert_arr = array(
                    "invoice_code" => $invoice_code,
                    "employee_id" => $employee_id,
                    "payment_type" => $payment_type,
                    "month" => $month,
                    "year" => $year,
                    "tot_time" => $tot_time,
                    "work_duration" => $work_duration,
                    "bill_rate" => $bill_rate,
                    "tot_time_pay" => $tot_time_pay,
                    "over_time" => $over_time,
                    "ot_rate" => $ot_rate,
                    "over_time_pay" => $over_time_pay,
                    "comment" => $comment,
                    "entry_date" => date("Y-m-d h:i:s"),
                    "updated_date" => date("Y-m-d h:i:s"),
                    "status" => "1"
                );
            }
//            echo "<pre>";
//             print_r($insert_arr);
//            die;

            $insert_query = $this->employee_model->generate_payment($insert_arr);

            if ($insert_query != '') {

                $get_admin_details = $this->employee_model->getAdminDetails($get_employee_details[0]['admin_id']);
                if (!empty($get_admin_details)) {
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_details[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_admin_details[0]['sa_id'] . "_" . "superadmin";
                }

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                $admin_email = $get_admin_details[0]['admin_email'];

                $msg = 'Successfully generated invoice for ' . ucwords($employee_name) . " [ " . $employee_code . " ]";
                $data['msg'] = $msg;

//Load email library
                $this->load->library('email');

                $this->email->from($from_email);
                $this->email->to($admin_email);
                $this->email->bcc($superadmin_email);
                $this->email->subject('Invoice generated Successfully');
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
                $this->email->set_mailtype('html');
                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "Pending Verification",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */

                $this->session->set_flashdata('succ_msg', 'Invoice generated Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Invoice data not generated Successfully..');
                redirect(base_url() . 'superadmin-employee-list');
            }
        }
    }

    public function delete_employee_user() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $recipients = array();
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $get_sa_dtls = $this->profile_model->getDetails($email);
        $sa_id = $get_sa_dtls[0]['sa_id'];

        $employee_id = base64_decode($this->input->post('employee_id'));
        $check_employee_dtls = $this->employee_model->checkEmployee($employee_id);

        if (!empty($check_employee_dtls)) {
            echo "3";
//redirect(base_url() . 'admin-user');
        } else {
            $update_arr = array(
                "is_delete" => "1"
            );
            $update_query = $this->employee_model->deleteEmployeeUser($update_arr, $employee_id);
//            echo $update_query;
//            die;

            $get_employee_dtls = $this->employee_model->getEmployeeData($employee_id);
//            echo "<pre>";
//            print_r($get_employee_dtls);
//            die;
            if (!empty($get_employee_dtls)) {
                if (($get_employee_dtls[0]['employee_type']) == 'C') {
                    $get_vendor_dtls = $this->employee_model->getVendorData($get_employee_dtls[0]['vendor_id']);
                    $get_admin_dtls = $this->employee_model->getAdminData($get_employee_dtls[0]['admin_id']);
                    $get_sadmin_dtls = $this->employee_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

                    $name_prefix = $get_employee_dtls[0]['name_prefix'];
                    $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
                    $e_email = $get_employee_dtls[0]['employee_email'];
                } else {
                    $get_admin_dtls = $this->employee_model->getAdminData($get_employee_dtls[0]['admin_id']);
                    $get_sadmin_dtls = $this->employee_model->getSuperAdminData($get_admin_dtls[0]['sa_id']);

                    $name_prefix = $get_employee_dtls[0]['name_prefix'];
                    $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
                    $e_email = $get_employee_dtls[0]['employee_email'];
                }
            }

            if ($update_query > 0) {

                $data['msg'] = "<p style='font-weight: 800;'>  Hi,</p>
                                <p style='font-weight: 300;'> " . ucwords($get_sa_dtls[0]['sa_name']) . " has deleted " . $name_prefix . " " . ucwords($employee_name) . " from GRMS .</p>
                                <p><strong>Email ID : </strong>" . $e_email . "</p>";

                $from_email = REPLY_EMAIL;
                $superadmin_email = SUPERADMIN_EMAIL;

                if (($get_employee_dtls[0]['employee_type']) == 'C') {

                    $admin_email = $get_admin_dtls[0]['admin_email'];
                    $vendor_email = $get_vendor_dtls[0]['vendor_email'];
                    $consultant_email = $e_email;

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($consultant_email);
                    $this->email->bcc($vendor_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($get_sadmin_dtls[0]['sa_email']);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Consultant has been deleted from Global Resource Management System');
                } else {
                    $admin_email = $get_admin_dtls[0]['admin_email'];
                    $consultant_email = $e_email;

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($consultant_email);
                    $this->email->bcc($admin_email);
                    $this->email->bcc($get_sadmin_dtls[0]['sa_email']);
                    $this->email->bcc($superadmin_email);
                    $this->email->subject('Employee has been deleted from Global Resource Management System');
                }
                $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));
//                echo $this->load->view('superadmin/email_template/form_submitted_template', $data, true);
//                die;
                $this->email->set_mailtype('html');

                $this->email->send();

                /* ----------------------------------Insert Mail------------------------------------ */

                if (($get_employee_dtls[0]['employee_type']) == 'C') {
                    $msg = "SUPER ADMIN has been deleted consultant successfully.<br> "
                            . "<label><strong>Consultant Name : </strong>" . ucwords($employee_name) . "</label><br/>
                            <label><strong>Consultant Email : </strong>" . $e_email . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['admin_id'] . "_" . "admin";
                    $recipients [] = $get_vendor_dtls[0]['vendor_id'] . "_" . "vendor";
                    $sub = "Consultant deleted from Global Resource Management System";
                } else {
                    $msg = "SUPER ADMIN has been deleted employee successfully.<br> "
                            . "<label><strong>Employee Name : </strong>" . ucwords($employee_name) . "</label><br/>
                            <label><strong>Employee Email : </strong>" . $e_email . "</label><br/>";
                    $recipients [] = 1 . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['sa_id'] . "_" . "superadmin";
                    $recipients [] = $get_admin_dtls[0]['admin_id'] . "_" . "admin";
                    $sub = "Employee deleted from Global Resource Management System";
                }

                foreach ($recipients as $rtval) {
                    $r_arr = explode("_", $rtval);
                    $recipient_id = $r_arr[0];
                    $recipient_type = $r_arr[1];

                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => $sub,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
//     print_r($insert_arr);
//     die;
                    $insert_query = $this->communication_model->add_mail($insert_arr);
                }

                /* ----------------------------------Insert Mail------------------------------------ */


                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function view_sadmin_employees_work_order_pdf() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $employee_id = base64_decode($this->uri->segment(2));
        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        $get_vendor_details = $this->employee_model->getVendorDtls($get_employee_details[0]['vendor_id']);

        $data['get_work_order'] = $this->employee_model->getWorkOrder($employee_id);
        $data['img_src'] = "./assets/images/pts.jpg";

        $this->load->view('superadmin/view_employees_work_order_pdf', $data);
    }

    public function edit_sadmin_employee_work_order() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['sa_id'] = $sa_id;
        $is_asp = $data['get_details'][0]['is_asp'];
        $data['sa_name'] = $data['get_details'][0]['sa_name'];
        $data['sa_designation'] = 'Legal Counsel';

        $employee_id = base64_decode($this->uri->segment(2));
        $data['employee_id'] = $employee_id;

        $get_work_details = $this->employee_model->getWorkDetails($employee_id);

        $data['show_sign_form'] = false;
        $data['stage']          = $get_work_details[0]['stage'];

        if ($get_work_details[0]['stage'] == 5) {
            $this->session->set_flashdata('error_msg', 'Work order PDF is already created.');
            redirect(base_url() . 'consultant-user');
        }
        
        if ($is_asp && 4 == $data['stage']) { // Only the ASP signature is pending
            $data['show_sign_form'] = true;
        }

        if ($data['show_sign_form']) {
            $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
            $data['cons_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
        } else {
            $data['agreement_date'] = $get_work_details[0]['agreement_date'];
            $data['cons_start_date'] = $get_work_details[0]['start_date'];
        }

        $data['consultant_name'] = $get_work_details[0]['consultant'];
        $data['project_duration'] = $get_work_details[0]['project_duration'];
        $data['bill_rate'] = $get_work_details[0]['bill_rate'];
        $data['ot_rate'] = $get_work_details[0]['ot_rate'];
        $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
        $data['payment_terms'] = $get_work_details[0]['payment_terms'];

        $data['client_name'] = $get_work_details[0]['client_name'];
        $data['client_name_str'] = '';
        if (empty($get_work_details[0]['client_name'])) {
            $data['work_note'] = " ";
        } else {
            $get_work_note = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
            $data['work_note'] = $get_work_note[0]['work_order_note'];
            $data['client_name_str'] = $get_work_note[0]['client_name'];
        }

        $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
        $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
        if (empty($get_work_details[0]['vendor_signature'])) {
            $data['vendor_signature'] = " ";
        } else {
            $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
        }

        if (empty($get_work_details[0]['vendor_signature_date'])) {
            $data['vendor_signature_date'] = " ";
        } else {
            $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
        }

        $data['approved_by_superadmin'] = $get_work_details[0]['approved_by_superadmin'];
        $data['vendor_id'] = $get_work_details[0]['vendor_id'];

        $get_vendor_details = $this->employee_model->getVendorDtls($get_work_details[0]['vendor_id']);
        $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);

        if (!empty($get_employee_details)) {
            $employee_code = $get_employee_details[0]['employee_code'];
            $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
            $employee_name_prefix = $get_employee_details[0]['name_prefix'];
        }

        $data['employee_details'] = $employee_name_prefix . " " . ucwords($employee_name) . " [ " . strtoupper($employee_code) . " ] ";

        $data['get_admin_details'] = $this->employee_model->getAdminData($get_employee_details[0]['admin_id']);
        $data['get_client_details'] = $this->employee_model->getClientDetails();

        $data['page'] = "employee_lists";
        $data['meta_title'] = "EMPLOYEE WORK ORDER";

        $this->load->view('superadmin/edit_sadmin_employee_work_order', $data);
    }

    public function update_sadmin_employee_work_order() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
		
		$sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
		$sa_id = $data['get_details'][0]['sa_id'];

		$get_sadmin_details = $this->employee_model->getSuperAdminData($sa_id);
        if (!empty($get_sadmin_details)) {
            $sa_email = $get_sadmin_details[0]['sa_email'];
            $sa_name = $get_sadmin_details[0]['sa_name'];
        }
				
        $employee_id = $this->input->post('employee_id');
        $stage = $this->input->post('stage');

        if ($stage == 4) { // To save the final PDF ultimately
            $asp_name = $this->input->post('asp_name');
            $asp_designation = $this->input->post('asp_designation'); 
            $asp_signature = $this->input->post('asp_signature');

            $update_arr = array(
                'asp_name'           => $asp_name,
                'asp_designation'    => $asp_designation,
                'asp_signature'      => $asp_signature,
                'asp_signature_date' => date("Y-m-d"),
                'stage'              => '5',        
            );

            $update_query = $this->employee_model->asp_sign_work_order($update_arr, $employee_id);

            $directory_name = './uploads/historical_work_order/';
            $file_name = $employee_id . "-" . time() . rand(00, 99) . ".pdf";

            if (!file_exists($directory_name)) {
                mkdir($directory_name, 0777, true);
            }
            
            //$attachment_path = 'uploads/historical_work_order/' . $file_name;
            $attachment_path = 'view-work-order/' . base64_encode($file_name);

            $get_work_details = $this->employee_model->getWorkDetails($employee_id);
            $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
            $data['cons_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
            $data['consultant_name'] = $get_work_details[0]['consultant'];
            $data['project_duration'] = $get_work_details[0]['project_duration'];
            $data['bill_rate'] = $get_work_details[0]['bill_rate'];
            $data['ot_rate'] = $get_work_details[0]['ot_rate'];
            $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
            $data['payment_terms'] = $get_work_details[0]['payment_terms'];

            $data['client_name'] = $get_work_details[0]['client_name'];
            $data['client_name_str'] = '';
            if (empty($get_work_details[0]['client_name'])) {
                $data['work_note'] = " ";
            } else {
                $get_work_note = $this->employee_model->getWorkNote($get_work_details[0]['client_name']);
                $data['work_note'] = $get_work_note[0]['work_order_note'];
                $data['client_name_str'] = $get_work_note[0]['client_name'];
            }

            $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
            $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
            if (!empty($get_work_details[0]['vendor_signature'])) {
                $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
            } else {
                $data['vendor_signature'] = " ";
            }

            if (!empty($get_work_details[0]['vendor_signature_date'])) {
                $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
            } else {
                $data['vendor_signature_date'] = " ";
            }

            $data['asp_name'] = $get_work_details[0]['asp_name'];
            $data['asp_designation'] = $get_work_details[0]['asp_designation'];
            $data['asp_signature'] = $get_work_details[0]['asp_signature'];
            $data['asp_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['asp_signature_date']));

            $data['vendor_ip'] = $get_work_details[0]['vendor_ip'];
            $data['vendor_id'] = $get_work_details[0]['vendor_id'];
            $get_vendor_details = $this->employee_model->getVendorDtls($get_work_details[0]['vendor_id']);
            $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

            $this->load->library('html2pdf');
            $result = $this->load->view('superadmin/wo_pdf_template', $data, true);

            $this->html2pdf->html($result);
            $this->html2pdf->folder($directory_name);
            $this->html2pdf->filename($file_name);
            $this->html2pdf->paper('A4', 'portrait');

            if ($this->html2pdf->create('save')) {
                
                $insert_arr = array(
                    'employee_id'         => $employee_id,
                    'file'                => $file_name,
                    'final_approval_date' => date("Y-m-d"),
                    'upload_date'         => date("Y-m-d"),
                    'uploaded_by'         => 'sadmin',
                );

                $insert_query = $this->employee_model->insert_historical_approved_work_order($insert_arr);

                if (!empty($update_query) && !empty($insert_query)) {

                    $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                    $employee_code = $get_employee_details[0]['employee_code'];

                    $vendor_id = $get_employee_details[0]['vendor_id'];
                    $get_vendor_data = $this->employee_model->getVendorData($vendor_id);
                    $vendor_email = $get_vendor_data[0]['vendor_email'];

                    $get_admin_email = $this->vendor_model->getAdminEmail($get_vendor_data[0]['admin_id']);
                    $admin_email = $get_admin_email[0]['admin_email'];

                    send_emails_work_order(5, 'asp', [
                        'init_user_full_name' => $sa_name,
                        'con_full_name' => $employee_name,
                        'con_code' => $employee_code,
                        'access_link_part'  => $attachment_path,
                    ], [
                        $vendor_email,
                        $admin_email,
                    ], [
                        SUPERADMIN_EMAIL,
                        $sa_email,
                    ]);

                    $msg = "Hi,<br>" . ucwords($sa_name) . " has signed work order for " . ucwords($employee_name) . "[" . $employee_code . "] .";

                    $recipient_id = 1;
                    $recipient_type = "superadmin";
                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => "ASP signed Work Order Successfully!",
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );

                    $insert_query = $this->communication_model->add_mail($insert_arr);

                    $this->session->set_flashdata('succ_msg', 'Work Order signed successfully.');
                    redirect(base_url() . 'consultant-user');
                } else {
                    $this->session->set_flashdata('error_msg', 'Work Order not signed successfully.');
                    redirect(base_url() . 'consultant-user');
                }
            }

        } else {
            $db = get_instance()->db->conn_id;
            $consultant = $this->input->post('consultant');
            $agreement_date = $this->input->post('agreement_date');
            $start_date = $this->input->post('start_date');
            $client_name = $this->input->post('client_name');
            $project_duration = mysqli_real_escape_string($db, $this->input->post('project_duration'));
            $invoicing_terms = mysqli_real_escape_string($db, $this->input->post('invoicing_terms'));
            $payment_terms = mysqli_real_escape_string($db, $this->input->post('payment_terms'));
            $bill_rate = $this->input->post('bill_rate');
            $ot_rate = $this->input->post('ot_rate');
            $vendor_poc_name = $this->input->post('vendor_poc_name');
            $vendor_poc_designation = $this->input->post('vendor_poc_designation');
            $approved_by_superadmin = $this->input->post('approved_by_superadmin');

            $wo_stage = "";
            if ($approved_by_superadmin) {
                $wo_stage = 3;
            } else {
                $wo_stage = 2;
            }

            if (isset($consultant) && $consultant == '') {
                $this->session->set_flashdata('error_msg', 'Consultant field cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($agreement_date) && $agreement_date == '') {
                $this->session->set_flashdata('error_msg', 'Agreement Date cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($start_date) && $start_date == '') {
                $this->session->set_flashdata('error_msg', 'Start Date cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($bill_rate) && $bill_rate == '') {
                $this->session->set_flashdata('error_msg', 'Bill rate field cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($ot_rate) && $ot_rate == '') {
                $this->session->set_flashdata('error_msg', 'Overtime field cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($vendor_poc_name) && $vendor_poc_name == '') {
                $this->session->set_flashdata('error_msg', 'Vendor POC Name field cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else if (isset($vendor_poc_designation) && $vendor_poc_designation == '') {
                $this->session->set_flashdata('error_msg', 'Vendor POC designation field cannot be blank');
                redirect(base_url('edit-sadmin-employee-work-order/' . base64_encode($employee_id)));
            } else {

                $update_arr = array(
                    'consultant' => $consultant,
                    'agreement_date' => $agreement_date,
                    'start_date' => $start_date,
                    'client_name' => $client_name,
                    'project_duration' => $project_duration,
                    'invoicing_terms' => $invoicing_terms,
                    'payment_terms' => $payment_terms,
                    'bill_rate' => $bill_rate,
                    'ot_rate' => $ot_rate,
                    'vendor_poc_name' => $vendor_poc_name,
                    'stage' => $wo_stage,
                    'vendor_poc_designation' => $vendor_poc_designation,
                    'approved_by_superadmin' => $approved_by_superadmin,
                    'updated_date' => date("Y-m-d h:i:s")
                );

                $update_query = $this->employee_model->update_work_order($update_arr, $employee_id);
    			
                if ($update_query != '') {
    			//to send mails
    			
    			$get_employee_details = $this->employee_model->getEmployeeData($employee_id);
    			$employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                $employee_code = $get_employee_details[0]['employee_code'];

                $vendor_id = $get_employee_details[0]['vendor_id'];
                $get_vendor_data = $this->employee_model->getVendorData($vendor_id);
                $vendor_email = $get_vendor_data[0]['vendor_email'];

                $get_admin_email = $this->vendor_model->getAdminEmail($get_vendor_data[0]['admin_id']);
                $admin_email = $get_admin_email[0]['admin_email'];


                if ($approved_by_superadmin) {

                    send_emails_work_order(3, 'sadmin', [
                    'init_user_full_name' => $sa_name,
                    'con_full_name' => $employee_name,
                    'con_code' => $employee_code,
                    'access_link_part' => 'edit_vendor_consultant_work_order/' . base64_encode($employee_id),
                    ], [
                        $vendor_email,
                    ], [
                        $sa_email,
                        $admin_email,
                        SUPERADMIN_EMAIL,
                    ]);

                    $msg = "Hi,<br>" . ucwords($sa_name) . " has approved the work order for " . ucwords($employee_name) . "[" . $employee_code . "] ."; 
                    $subject = "Super Admin Approved The Work Order";

                } else {
                    
                    send_emails_work_order(2, 'sadmin', [
                    'init_user_full_name' => $sa_name,
                    'con_full_name' => $employee_name,
                    'con_code' => $employee_code,
                    'access_link_part' => 'edit-sadmin-employee-work-order/' . base64_encode($employee_id),
                    ], [
                        $sa_email,
                    ], [
                        SUPERADMIN_EMAIL,
                    ], [], true);

                    $msg = "Hi,<br>" . ucwords($sa_name) . " has updated work order for " . ucwords($employee_name) . "[" . $employee_code . "] ."; 
                    $subject = "Work Order updated successfully";
                }
                

    			/* ----------------------------------Insert Mail------------------------------------ */

                    
                            
                    $recipient_id = 1;
                    $recipient_type = "superadmin";
                    $insert_arr = array(
                        "recipient_id" => $recipient_id,
                        "recipient_type" => $recipient_type,
                        "sender_id" => $sa_id,
                        "sender_type" => "superadmin",
                        "subject" => $subject,
                        "message" => $msg,
                        "entry_date" => date("Y-m-d h:i:s"),
                        "is_deleted" => '0',
                        "status" => '0'
                    );
                    $insert_query = $this->communication_model->add_mail($insert_arr);


                    /* ----------------------------------Insert Mail------------------------------------ */
    			

                    $this->session->set_flashdata('succ_msg', 'Work order updated Successfully..');
                    redirect(base_url() . 'consultant-user');
                } else {
                    $this->session->set_flashdata('error_msg', 'Work order not updated Successfully..');
                    redirect(base_url() . 'consultant-user');
                }
            }
        }
    }

    public function consultants_internal_files() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
//        $data['get_emp_internal_files_details'] = $this->employee_model->getEmployeeInternalFilesDetails();
        $data['get_emp_internal_file_details'] = $this->employee_model->getEmployeeInternalFileDetails();

        $data['page'] = "internal_files";
        $data['meta_title'] = "INTERNAL FILES FOR CONSULTANTS/EMPLOYEES";
        $this->load->view('superadmin/new_consultants_internal_files', $data);
    }

    public function all_internal_files() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }


        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = base64_decode($this->uri->segment(2));
//        $data['get_emp_internal_files_details'] = $this->employee_model->getEmployeeInternalFilesDetails();
        $data['get_emp_tot_internal_file_details'] = $this->employee_model->getEmployeeTotalInternalFilesDetails($employee_id);

        $data['page'] = "internal_files";
        $data['meta_title'] = "INTERNAL FILES FOR CONSULTANTS/EMPLOYEES";
        $this->load->view('superadmin/consultants_total_internal_files', $data);
    }

    public function add_consultant_internal_files() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_employee'] = $this->employee_model->getAllEmployeeLists();
		// print_r($data['get_employee']);
		// die;
        $data['page'] = "internal_files";
        $data['meta_title'] = "INTERNAL FILES ADD";
        $this->load->view('superadmin/add_consultant_internal_files', $data);
    }

    public function insert_consultant_internal_files() {
        $db = get_instance()->db->conn_id;

        $employee_id = $this->input->post('employee_id');
        $docs_name = mysqli_real_escape_string($db, $this->input->post('docs_name'));
        if (isset($docs_name) && $docs_name == '') {
            $this->session->set_flashdata('error_msg', 'Document Name field cannot be blank');
            redirect(base_url() . 'add-consultant-internal-files');
        } else {


            if ($_FILES['file']['name'] != '') {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

                $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $file_errors[] = "'File size must be excately 2 MB";
                }
//echo "<pre>";
//print_r($file_errors);
//die;
                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
                } else {
                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                        $file_errors[] = "'File size must be excately 2 MB";
                        redirect(base_url() . 'add-consultant-internal-files');
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect(base_url() . 'add-consultant-internal-files');
                    }
                }
            } else {
                $new_file_name = "";
            }

            /* ---------------Resume-------------- */

            $insert_arr = array(
                'employee_id' => $employee_id,
                'docs_name' => $docs_name,
                'file' => $new_file_name,
                'entry_date' => date("Y-m-d")
            );

            $insert_query = $this->employee_model->add_consultants_internal_files($insert_arr);

            if ($insert_query != '') {

                $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                redirect(base_url() . 'consultants-internal-files');
            } else {
                $this->session->set_flashdata('succ_msg', 'Conusltant Document Added Successfully');
                redirect(base_url() . 'consultants-internal-files');
            }
        }
    }

    public function edit_consultant_internal_files() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $file_id = base64_decode($this->uri->segment(2));

        $data['get_internal_file_details'] = $this->employee_model->getInternalFileDetails($file_id);
        $data['get_employee'] = $this->employee_model->getEmployeeLists();

        $data['page'] = "internal_files";
        $data['meta_title'] = "INTERNAL FILES UPDATE";
        $this->load->view('superadmin/edit_consultant_internal_files', $data);
    }

    public function update_consultant_internal_files() {
        $db = get_instance()->db->conn_id;

        $doc_id = base64_decode($this->input->post('doc_id'));
        $docs_name = mysqli_real_escape_string($db, $this->input->post('docs_name'));

        $get_doc_details = $this->employee_model->getInternalFileDetails($doc_id);

        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                $errors[] = "'File size must be excately 2 MB";
            }

            if (empty($errors) == true) {
                $file_path = "./uploads/";
                $path = $file_path . $get_doc_details[0]['file'];
                if (file_exists($path)) {
                    unlink($path);
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'edit-consultant-internal-files/' . base64_encode($doc_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'edit-consultant-internal-files/' . base64_encode($doc_id));
                }
            }
        } else {
            $new_file_name = $get_doc_details[0]['file'];
        }

        $update_arr = array(
            'docs_name' => $docs_name,
            'file' => $new_file_name,
            'entry_date' => date("Y-m-d")
        );

        $update_query = $this->employee_model->update_consultants_internal_files($update_arr, $doc_id);

        if ($update_query != '0') {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'consultants-internal-files');
        } else {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'consultants-internal-files');
        }
    }

    public function send_internal_files_mail() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);

        $employee_id = $this->input->post('employee_id', TRUE);
        $file_id = $this->input->post('file_id', TRUE);

        $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
        $get_internal_files_details = $this->employee_model->getInternalFileDetails($file_id);

        if (!empty($get_employee_details) && !empty($get_internal_files_details)) {
            if ($get_internal_files_details[0]['status'] == 0) {
                $update_arr = array(
                    'status' => '1'
                );
                $update_query = $this->employee_model->updateInternalFileStatus($update_arr, $file_id);
                if ($update_query > 0) {

                    $docs_name = $get_internal_files_details[0]['docs_name'];
                    $employee_name = $get_employee_details[0]['employee_name'];

                    $data['msg'] = "<p style='font-weight: 300;'>Hi " . ucwords($employee_name) . ", has uplaoded the Internal file for you,Please go through the Internal Link and uploded the " . ucwords($docs_name) . " file .</p>";


                    $from_email = REPLY_EMAIL;
                    $superadmin_email = SUPERADMIN_EMAIL;
                    $employee_email = $get_employee_details[0]['employee_email'];

//Load email library
                    $this->load->library('email');

                    $this->email->from($from_email);
                    $this->email->to($employee_email);
                    $this->email->subject('File Upload Request');
                    $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

                    $this->email->set_mailtype('html');

//Send mail
                    $this->email->send();

                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
        }
    }

    public function upload_consultant_signed_internal_files() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $file_id = base64_decode($this->uri->segment(2));

        $data['get_internal_file_details'] = $this->employee_model->getInternalFileDetails($file_id);
        $data['get_employee'] = $this->employee_model->getEmployeeLists();

        $data['page'] = "internal_files";
        $data['meta_title'] = "INTERNAL FILES UPDATE";
        $this->load->view('superadmin/upload_consultant_signed_internal_files', $data);
    }

    public function update_consultant_signed_internal_files() {
        $db = get_instance()->db->conn_id;

        $doc_id = base64_decode($this->input->post('doc_id'));

        $get_doc_details = $this->employee_model->getInternalFileDetails($doc_id);

        if ($_FILES['file']['name'] != '') {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_ext_arr = explode('.', $file_name);
            $file_ext = strtolower($file_ext_arr[1]);
//print_r($file_ext_arr);

            $new_file_name = time() . rand(00, 99) . '.' . $file_ext;
            $expensions = array("pdf");

            if (in_array($file_ext, $expensions) === false) {
                $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                $errors[] = "extension not allowed, please choose a PDF file.";
            }

            if ($file_size > 2097152) {
                $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                $errors[] = "'File size must be excately 2 MB";
            }

            if (empty($errors) == true) {
                $file_path = "./uploads/";
                $path = $file_path . $get_doc_details[0]['employee_internal_files'];
                if (file_exists($path)) {
                    unlink($path);
                }
                move_uploaded_file($file_tmp, "./uploads/" . $new_file_name);
            } else {
                if ($file_size > 2097152) {
                    $this->session->set_flashdata('error_msg', 'File size must be excately 2 MB');
                    $errors[] = "'File size must be excately 2 MB";
                    redirect(base_url() . 'edit-consultant-internal-files/' . base64_encode($doc_id));
                }
                if (in_array($file_ext, $expensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $errors[] = "extension not allowed, please choose a PDF file.";
                    redirect(base_url() . 'edit-consultant-internal-files/' . base64_encode($doc_id));
                }
            }
        } else {
            $new_file_name = $get_doc_details[0]['employee_internal_files'];
        }

        $update_arr = array(
            'employee_internal_files' => $new_file_name,
            'status' => '1',
            'entry_date' => date("Y-m-d")
        );

        $update_query = $this->employee_model->update_consultants_internal_files($update_arr, $doc_id);

        if ($update_query != '0') {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'consultants-internal-files');
        } else {
            $this->session->set_flashdata('succ_msg', 'Document updated Successfully..');
            redirect(base_url() . 'consultants-internal-files');
        }
    }

    public function con_view_period_timesheet() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $this->load->view('superadmin/con_view_period_timesheet', $data);
    }

    public function search_sa_con_timesheet() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $employee_id = $this->input->post('employee_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $data['employee_id'] = $employee_id;
        $get_vendor_id = $this->employee_model->getVendorID($employee_id);
//        echo $get_vendor_id->vendor_id;
//        die;
        $data['get_vendor_details'] = $this->employee_model->getVendorDetails($get_vendor_id->vendor_id);
        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByEmpSearch($employee_id, $start_date, $end_date);
        $data['get_employee_details'] = $this->employee_model->getEmployeeData($employee_id);
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "CONSULTANT TIMESHEET";

        $this->load->view('superadmin/ncon_project_timesheet', $data);
    }

    public function sadmin_view_period_timesheet() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        //$db = get_instance()->db->conn_id;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $tid = base64_decode($this->uri->segment(2));

        $data['get_timesheet_details'] = $this->employee_model->getTimesheetDetailsByID($tid);
        $data['get_timesheet_period_details'] = $this->employee_model->getTimesheetPeriodDetails($tid);

        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "TIMESHEET LISTS";

        $this->load->view('superadmin/sadmin_view_period_timesheet', $data);
    }

    public function sadmin_approve_disapprove_timesheet_period() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $recipients = array();
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $check = $this->input->post('check', TRUE);
        $ad = $this->input->post('ad', TRUE);
        $project_id = $this->input->post('project_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $timesheet_period_id = $this->input->post('timesheet_period_id', TRUE);
        $sadmin_comment = $this->input->post('sadmin_comment', TRUE);

        if ($ad == 'Approved') {
            $approved_by_status = '1';
        } else if ($ad == 'Disapproved') {
            $approved_by_status = '0';
        }

        if (!empty($check)) {
//            echo $ad;
//            die;
            if ($ad == 'Save') {


                foreach ($check as $time_id) {
                    $tot_time = $this->input->post('tot_time_' . $time_id);
                    $over_time = $this->input->post('over_time_' . $time_id);

                    if ($tot_time != '') {
                        $tot_time = $tot_time;
                    } else {
                        $tot_time = 0;
                    }

                    if ($over_time != '') {
                        $over_time = $over_time;
                    } else {
                        $over_time = 0;
                    }

                    $update_arr = array(
                        "tot_time" => $tot_time,
                        "over_time" => $over_time
                    );

//                    echo "<pre>";
//                    print_r($update_arr);
                    $change_status_sv = $this->employee_model->changeEachTimesheetStatus($update_arr, $time_id);
                }

                // if ($change_status_sv > 0) {
                $this->session->set_flashdata('succ_msg', 'Total Time Has Been Saved !');
                redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
//                } else {
//                    $this->session->set_flashdata('error_msg', 'Something went wrong. !');
//                    redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
//                }
            } else {
                $update_arr = array(
                    "approved_by_status" => $approved_by_status,
                );

                foreach ($check as $tid) {
                    $change_status = $this->employee_model->changeEachTimesheetStatus($update_arr, $tid);
                }
//                echo $change_status;
//                die;

                if ($change_status > 0) {
                    $pstatus = array();

                    $get_period_details = $this->employee_model->getTimesheetPeriodDetails($timesheet_period_id);
//                    echo "<pre>";
//                    print_r($get_period_details);
//                    die();
//                    
                    foreach ($get_period_details as $pval) {
                        $pstatus[] = $pval['approved_by_status'];
                    }
                    if (in_array("0", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "0",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    } elseif (in_array("1", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "1",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    } elseif (in_array("2", $pstatus)) {
                        $update_p_arr = array(
                            "status" => "2",
                            "approved_by_id" => $sa_id,
                            "approved_by" => "superadmin",
                            "sadmin_comment" => $sadmin_comment,
                        );
                    }
//                    echo "<pre>";
//                    print_r($update_p_arr);
//                    die;

                    $change_period_status = $this->employee_model->changePeriodTimesheetStatus($update_p_arr, $timesheet_period_id);

                    $get_timesheet_period_details = $this->employee_model->getPeriodDetails($timesheet_period_id);

                    if (!empty($get_timesheet_period_details)) {
                        if ($get_timesheet_period_details[0]['status'] == '1') {


                            $tot_time = 0;
                            $ot_time = 0;

                            $cal_st = $this->employee_model->getTotalST($timesheet_period_id);
                            $cal_ot = $this->employee_model->getTotalOT($timesheet_period_id);

                            $tot_time = $cal_st[0]['tot_time'];
                            $ot_time = $cal_ot[0]['over_time'];

                            $period_arr = explode("~", $get_timesheet_period_details[0]['period']);
                            $start_date = $period_arr[0];
                            $end_date = $period_arr[1];


                            $get_employee_details = $this->employee_model->getEmployeeData($employee_id);
                            if (!empty($get_employee_details)) {

                                $pay_rate = 0;
                                $ot_rate = 0;
                                $pay_rate_type = '';

                                if ($get_employee_details[0]['employee_type'] == 'C') {

                                    $get_emp_work_order = $this->employee_model->getWorkOrder($employee_id);
                                    if (!empty($get_emp_work_order)) {
                                        $pay_rate = $get_emp_work_order[0]['bill_rate'];
                                        $ot_rate = $get_emp_work_order[0]['ot_rate'];
                                        $tot_time_pay = ($tot_time * $pay_rate);
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    }
                                    $vendor_id = $get_employee_details[0]['vendor_id'];
                                } elseif ($get_employee_details[0]['employee_type'] == 'E') {
                                    $pay_rate_type = $get_employee_details[0]['emp_pay_rate_type'];
                                    $pay_rate = $get_employee_details[0]['employee_pay_rate'];
                                    $ot_rate = $get_employee_details[0]['employee_ot_rate'];
                                    if ($pay_rate_type == 'hourly') {
                                        $tot_time_pay = ($tot_time * $pay_rate);
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    } elseif ($pay_rate_type == 'yearly') {
                                        $tot_time_pay = ($tot_time * ($pay_rate / 2080));
                                        $over_time_pay = ($ot_time * $ot_rate);
                                    }
                                    $vendor_id = 0;
                                }
                            }


                            $approved_by_id = $sa_id;
                            $approved_by = "superadmin";

                            $check_prev_generated_code = $this->employee_model->getPrevGeneratedCode();
                            $code = ltrim($check_prev_generated_code[0]['invoice_code'], "INV");
                            $invoice_code = "INV00" . ($code + 1);

                            $insert_payment_arr = array(
                                "invoice_code" => $invoice_code,
                                "timesheet_period_id" => $timesheet_period_id,
                                "vendor_id" => $vendor_id,
                                "employee_id" => $employee_id,
                                "payment_type" => "1",
                                "start_date" => $start_date,
                                "end_date" => $end_date,
                                "tot_time" => $tot_time,
                                "bill_rate" => $pay_rate,
                                "tot_time_pay" => $tot_time_pay,
                                "over_time" => $ot_time,
                                "ot_rate" => $ot_rate,
                                "over_time_pay" => $over_time_pay,
                                "approved_by_id" => $approved_by_id,
                                "approved_by" => $approved_by,
                                "entry_date" => date("Y-m-d h:i:s"),
                                "updated_date" => date("Y-m-d h:i:s"),
                                "status" => "1"
                            );

                            $check_prev_invoice = $this->employee_model->getPrevInvoice($timesheet_period_id, $employee_id, $vendor_id, $start_date, $end_date);

                            if ($check_prev_invoice[0]['cnt'] > 0) {
                                $update_i_arr = array(
                                    "status" => "1"
                                );
                                $update_invoice_query = $this->employee_model->DeleteInvoice($update_i_arr, $timesheet_period_id);
                                $this->session->set_flashdata('succ_msg', 'Invoice has already generated');
                                redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                            } else {
                                $insert_period_query = $this->employee_model->generateTimesheetInvoice($insert_payment_arr);
                            }
                        } else if ($get_timesheet_period_details[0]['status'] == '0') {
                            $update_i_arr = array(
                                "status" => "2"
                            );
                            $update_invoice_query = $this->employee_model->DeleteInvoice($update_i_arr, $timesheet_period_id);
                        }
                    }

//                    echo "<pre>";
//                    print_r($insert_payment_arr);
//                    die;




                    /* ----------------------------------Insert Mail------------------------------------ */

                    $this->session->set_flashdata('succ_msg', 'Timesheet Status Changed Successfully');
                    redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong !!');
                    redirect(base_url() . 'sadmin-view-period-timesheet/' . base64_encode($timesheet_period_id));
                }
            }
        }
    }

    public function add_con_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_consultant_lists'] = $this->employee_model->getEmployeeLists();
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "ADD CONSULTANT TIMESHEET";
        $this->load->view('superadmin/add_con_timesheet', $data);
    }

    public function get_con_project_list() {
        $employee_id = $this->input->post('employee_id', TRUE);
        $data['get_project_list'] = $this->employee_model->getConProjectLists($employee_id);
        $this->load->view('superadmin/ajax/ajax_get_con_project_lists', $data);
    }

    public function ajax_con_timesheet_list() {

        $project_id = $this->input->post('project_id', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);
        $project_code = $data['get_project_details'][0]['project_code'];
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        //--------------------------------Generate Timesheet ID------------------

        $timesheet_id = "";
        $tcount = 0;
        $check_timesheet = $this->employee_model->checkTimesheetPeriod($project_id);
        //echo $check_timesheet[0]['cnt'];
        if (!empty($check_timesheet)) {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        } else {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        }
        //echo $timesheet_id;
        $data['timesheet_id'] = $timesheet_id;
        //--------------------------------Generate Timesheet ID------------------

        $this->load->view('superadmin/ajax/ajax_get_con_timesheet_list', $data);
    }

    public function insert_new_con_timesheet() {
        $db = get_instance()->db->conn_id;

        $employee_id = $this->input->post('employee_id');
        $project_id = $this->input->post('project_id');
        $timesheet_id = $this->input->post('timesheet_id');
        $period = $this->input->post('period');
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $project_date = $this->input->post('project_date');
        $st = $this->input->post('st');
        $ot = $this->input->post('ot');
//        $start_time_mm = $this->input->post('start_time_mm');
//        $start_time_type = $this->input->post('start_time_type');
//
//        $end_time_mm = $this->input->post('end_time_mm');
//        $end_time_type = $this->input->post('end_time_type');
//
//
//        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));
//        $billable = $this->input->post('billable');

        if (isset($project_id) && $project_id == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add-con-timesheet');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-con-timesheet');
        } else if (isset($end_date) && $end_date == '') {
            $this->session->set_flashdata('error_msg', 'End Date field cannot be blank');
            redirect(base_url() . 'add-con-timesheet');
        } else {


            $insert_arr = array(
                'project_id' => $project_id,
                'employee_id' => $employee_id,
                'timesheet_id' => $timesheet_id,
                'period' => $period,
                'comment' => $comment,
                'entry_date' => date("Y-m-d h:i:s")
            );
//            echo "<pre>";
//            print_r($insert_arr);
//            die;
//            $n_start_time = date("g:i a", strtotime($start_time));
//            $n_end_time = date("g:i a", strtotime($end_time));

            $insert_query = $this->employee_model->add_timesheet_period($insert_arr);

            if ($insert_query != '') {
                $i = 0;
                foreach ($project_date as $date) {

                    $c_start_time = $start_time[$i];
                    $c_end_time = $end_time[$i];

                    $working_time = "08:00";
                    $t1 = new DateTime("" . $date . " " . $c_start_time . "");
                    $t2 = new DateTime("" . $date . " " . $c_end_time . "");
                    $interval = $t1->diff($t2);
                    $approx_tot_time = $interval->format('%H:%I');

                    if ($approx_tot_time > "08:00") {
                        $w_time = new DateTime("" . $date . " 08:00");
                    } else {
                        $w_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    }

                    $at_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    $ot_interval = $w_time->diff($at_time);
                    $ot_time = $ot_interval->format('%H:%I');

                    if ($ot_interval->format('%I') > 30) {
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
                        $m_ot_time = $fecha->modify('+ 1 hour');
                        $over_time = $m_ot_time->format('g');
                        $tot_time = $w_time->format('g');
                    } else {
//                $ot_time = "01:00";
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
//                echo $fecha->format('g');
                        if ($fecha->format('g') != '12') {
                            $over_time = $fecha->format('g');
                        } else {
                            $over_time = "0";
                        }
                        $tot_time = $w_time->format('g');
                    }

                    if($start_time[$i] == '00:00' && $end_time[$i]== '00:00'){
                        $c_start_time = '0.00';
                        $c_end_time = '0.00';
                        $tot_time = '0.00';
                        $over_time = '0.00';
                    }

                    $insert_timesheet_arr = array(
                        'timesheet_period_id' => $insert_query,
                        'project_id' => $project_id,
                        'employee_id' => $employee_id,
                        'project_date' => $date,
                        'start_time' => $c_start_time,
                        'end_time' => $c_end_time,
                        'tot_time' => $tot_time,
                        'over_time' => $over_time,
                        'entry_date' => date("Y-m-d h:i:s"),
                    );
                    $insert_timesheet_query = $this->employee_model->add_timesheet($insert_timesheet_arr);

                    $i++;
                }
//                die();
//                $get_employee_dtls = $this->timesheet_model->getEmployeeData($employee_id);
//                $get_vendor_id = $this->timesheet_model->getVendorID($employee_id, $project_id);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $get_vendor_dtls = $this->timesheet_model->getVendorData($get_vendor_id[0]['vendor_id']);
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_vendor_dtls[0]['admin_id']);
//                        $vendor_email = $get_vendor_dtls[0]['vendor_email'];
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                        $data['vendor_name'] = $get_vendor_dtls[0]['first_name'] . " " . $get_vendor_dtls[0]['last_name'];
//                    } else {
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_employee_dtls[0]['admin_id']);
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                    }
//                }
//
//
//                $data['get_project_details'] = $this->timesheet_model->getProjectData($project_id);
//                $data['project_date'] = $tasks_date;
//                $data['start_time'] = $n_start_time;
//                $data['end_time'] = $n_end_time;
//                $data['tot_time'] = $tot_time;
//                $data['over_time'] = $over_time;
//                $data['comment'] = $comment;
//
//                $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
//
//
//                $subject = ucwords($employee_name) . " Added New Timesheet.";
//                $data['subject'] = $subject;
//
//
//                $from_email = REPLY_EMAIL;
//                $superadmin_email = SUPERADMIN_EMAIL;
//
//                //Load email library
//                $this->load->library('email');
//
//                $this->email->from($from_email);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $this->email->to($admin_email);
//                        $this->email->cc($vendor_email);
//                        $this->email->bcc($superadmin_email);
//                    } else {
//                        $this->email->to($admin_email);
//                        $this->email->bcc($superadmin_email);
//                    }
//                }
//
//                $this->email->subject($subject);
//                $this->email->message($this->load->view('employee/email_template/timesheet_add_email_template', $data, true));
//                $this->email->set_mailtype('html');
//                //Send mail
//                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'Timesheet added Successfully.');
                redirect(base_url('con-timesheet'));
            } else {
                $this->session->set_flashdata('error_msg', 'Timesheet not added Successfully.');
                redirect(base_url('con-timesheet'));
            }
        }
    }

    public function add_emp_timesheet() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['get_employee_lists'] = $this->employee_model->getEmployeeListsbyType();
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "ADD EMPLOYEE TIMESHEET";
        $this->load->view('superadmin/add_emp_timesheet', $data);
    }

    public function get_emp_project_list() {
        $employee_id = $this->input->post('employee_id', TRUE);
        $data['get_project_list'] = $this->employee_model->getEmpProjectLists($employee_id);
        $this->load->view('superadmin/ajax/ajax_get_emp_project_lists', $data);
    }

    public function ajax_emp_timesheet_list() {

        $project_id = $this->input->post('project_id', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);

        $data['get_project_details'] = $this->employee_model->getProjectData($project_id);
        $project_code = $data['get_project_details'][0]['project_code'];
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        //--------------------------------Generate Timesheet ID------------------

        $timesheet_id = "";
        $tcount = 0;
        $check_timesheet = $this->employee_model->checkTimesheetPeriod($project_id);
        //echo $check_timesheet[0]['cnt'];
        if (!empty($check_timesheet)) {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        } else {
            $tcount = $check_timesheet[0]['cnt'] + 1;
            $timesheet_id = strtoupper($project_code) . str_pad($tcount, 3, "0", STR_PAD_LEFT);
        }
        //echo $timesheet_id;
        $data['timesheet_id'] = $timesheet_id;
        //--------------------------------Generate Timesheet ID------------------

        $this->load->view('superadmin/ajax/ajax_get_emp_timesheet_list', $data);
    }

    public function insert_new_emp_timesheet() {
        $db = get_instance()->db->conn_id;

        $employee_id = $this->input->post('employee_id');
        $project_id = $this->input->post('project_id');
        $timesheet_id = $this->input->post('timesheet_id');
        $period = $this->input->post('period');
        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $project_date = $this->input->post('project_date');
        $st = $this->input->post('st');
        $ot = $this->input->post('ot');
//        $start_time_mm = $this->input->post('start_time_mm');
//        $start_time_type = $this->input->post('start_time_type');
//
//        $end_time_mm = $this->input->post('end_time_mm');
//        $end_time_type = $this->input->post('end_time_type');
//
//
//        $comment = mysqli_real_escape_string($db, $this->input->post('comment'));
//        $billable = $this->input->post('billable');

        if (isset($project_id) && $project_id == '') {
            $this->session->set_flashdata('error_msg', 'Project Name field cannot be blank');
            redirect(base_url() . 'add-emp-timesheet');
        } else if (isset($start_date) && $start_date == '') {
            $this->session->set_flashdata('error_msg', 'Start Date field cannot be blank');
            redirect(base_url() . 'add-emp-timesheet');
        } else if (isset($end_date) && $end_date == '') {
            $this->session->set_flashdata('error_msg', 'End Date field cannot be blank');
            redirect(base_url() . 'add-emp-timesheet');
        } else {


            $insert_arr = array(
                'project_id' => $project_id,
                'employee_id' => $employee_id,
                'timesheet_id' => $timesheet_id,
                'period' => $period,
                'comment' => $comment,
                'entry_date' => date("Y-m-d h:i:s")
            );
//            echo "<pre>";
//            print_r($insert_arr);
//            die;
//            $n_start_time = date("g:i a", strtotime($start_time));
//            $n_end_time = date("g:i a", strtotime($end_time));

            $insert_query = $this->employee_model->add_timesheet_period($insert_arr);

            if ($insert_query != '') {
                $i = 0;
                foreach ($project_date as $date) {

                    $c_start_time = $start_time[$i];
                    $c_end_time = $end_time[$i];

                    $working_time = "08:00";
                    $t1 = new DateTime("" . $date . " " . $c_start_time . "");
                    $t2 = new DateTime("" . $date . " " . $c_end_time . "");
                    $interval = $t1->diff($t2);
                    $approx_tot_time = $interval->format('%H:%I');

                    if ($approx_tot_time > "08:00") {
                        $w_time = new DateTime("" . $date . " 08:00");
                    } else {
                        $w_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    }

                    $at_time = new DateTime("" . $date . " " . $approx_tot_time . "");
                    $ot_interval = $w_time->diff($at_time);
                    $ot_time = $ot_interval->format('%H:%I');

                    if ($ot_interval->format('%I') > 30) {
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
                        $m_ot_time = $fecha->modify('+ 1 hour');
                        $over_time = $m_ot_time->format('g');
                        $tot_time = $w_time->format('g');
                    } else {
//                $ot_time = "01:00";
                        $fecha = new DateTime("" . $date . " " . $ot_time . "");
//                echo $fecha->format('g');
                        if ($fecha->format('g') != '12') {
                            $over_time = $fecha->format('g');
                        } else {
                            $over_time = "0";
                        }
                        $tot_time = $w_time->format('g');
                    }

                    if($start_time[$i] == '00:00' && $end_time[$i]== '00:00'){
                        $c_start_time = '0.00';
                        $c_end_time = '0.00';
                        $tot_time = '0.00';
                        $over_time = '0.00';
                    }
                    $insert_timesheet_arr = array(
                        'timesheet_period_id' => $insert_query,
                        'project_id' => $project_id,
                        'employee_id' => $employee_id,
                        'project_date' => $date,
                        'start_time' => $c_start_time,
                        'end_time' => $c_end_time,
                        'tot_time' => $tot_time,
                        'over_time' => $over_time,
                        'entry_date' => date("Y-m-d h:i:s"),
                    );
                    $insert_timesheet_query = $this->employee_model->add_timesheet($insert_timesheet_arr);

                    $i++;
                }
//                die();
//                $get_employee_dtls = $this->timesheet_model->getEmployeeData($employee_id);
//                $get_vendor_id = $this->timesheet_model->getVendorID($employee_id, $project_id);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $get_vendor_dtls = $this->timesheet_model->getVendorData($get_vendor_id[0]['vendor_id']);
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_vendor_dtls[0]['admin_id']);
//                        $vendor_email = $get_vendor_dtls[0]['vendor_email'];
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                        $data['vendor_name'] = $get_vendor_dtls[0]['first_name'] . " " . $get_vendor_dtls[0]['last_name'];
//                    } else {
//                        $get_admin_dtls = $this->timesheet_model->getAdminData($get_employee_dtls[0]['admin_id']);
//                        $admin_email = $get_admin_dtls[0]['admin_email'];
//                    }
//                }
//
//
//                $data['get_project_details'] = $this->timesheet_model->getProjectData($project_id);
//                $data['project_date'] = $tasks_date;
//                $data['start_time'] = $n_start_time;
//                $data['end_time'] = $n_end_time;
//                $data['tot_time'] = $tot_time;
//                $data['over_time'] = $over_time;
//                $data['comment'] = $comment;
//
//                $employee_name = $get_employee_dtls[0]['first_name'] . " " . $get_employee_dtls[0]['last_name'];
//
//
//                $subject = ucwords($employee_name) . " Added New Timesheet.";
//                $data['subject'] = $subject;
//
//
//                $from_email = REPLY_EMAIL;
//                $superadmin_email = SUPERADMIN_EMAIL;
//
//                //Load email library
//                $this->load->library('email');
//
//                $this->email->from($from_email);
//                if (!empty($get_vendor_id)) {
//                    if ($get_vendor_id[0]['vendor_id'] != '') {
//                        $this->email->to($admin_email);
//                        $this->email->cc($vendor_email);
//                        $this->email->bcc($superadmin_email);
//                    } else {
//                        $this->email->to($admin_email);
//                        $this->email->bcc($superadmin_email);
//                    }
//                }
//
//                $this->email->subject($subject);
//                $this->email->message($this->load->view('employee/email_template/timesheet_add_email_template', $data, true));
//                $this->email->set_mailtype('html');
//                //Send mail
//                $this->email->send();

                $this->session->set_flashdata('succ_msg', 'Timesheet added Successfully.');
                redirect(base_url('emp-timesheet'));
            } else {
                $this->session->set_flashdata('error_msg', 'Timesheet not added Successfully.');
                redirect(base_url('emp-timesheet'));
            }
        }
    }

    public function load_send_migration_email_page() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        echo "This will not work anymore now because it's only for emergency purposes!";
        exit;

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['page'] = "manage_timesheet";
        $data['meta_title'] = "send email";
        $this->load->view('superadmin/send_migration_email', $data);
    }

    public function send_migration_email() {
        echo "This will not work anymore now because it's only for emergency purposes!";
        exit;

        $email_ids = $this->input->post('email_ids');
        $email_ids_arr = explode(",", $email_ids);

        $msg = "Hello,<br><br/>" .
        "Greetings for the Day!<br><br>" . 
        "We are excited to announce that Procureline application has been migrated to PorosIQ with enhanced features. Please find the new link below <a href='https://www.porosiq.com/employee'>www.porosiq.com/employee</a>. Please reach out to <a href='mailto:helpdesk@porosiq.com'>helpdesk@porosiq.com</a> if you need any technical assistance.<br><br>" . 
        "Thank You!";

        $data['msg'] = $msg;
        $from_email = REPLY_EMAIL;
        $cc_email = "Reshma.Multani@ptscservices.com";
        $send_bcc_once = false;

        $this->load->library('email');

        foreach ($email_ids_arr as $email_id) {
            echo $email_id . '--<br/>';
            
            $this->email->from($from_email);
            $this->email->to(trim($email_id));

            if (!$send_bcc_once) {

               $this->email->bcc('swaraj@porosiq.com, anutosh@porosiq.com');
               $send_bcc_once = true;
            }

            if (!empty($cc_email)) {

                $this->email->cc($cc_email);
            }

            $this->email->subject('Procureline is now PorosIQ | Login details');
            $this->email->message($this->load->view('superadmin/email_template/form_submitted_template', $data, true));

            $this->email->set_mailtype('html');

            $this->email->send();
        }
    }

    public function document_template_list() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['doc_template_list'] = $this->employee_model->get_doc_template_list();

        $data['page'] = "document_template_list";
        $data['meta_title'] = "Doc Template List";
        $this->load->view('superadmin/document_template_list', $data);
    }

    public function add_document_template() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];

        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['page'] = "add_document_template";
        $data['meta_title'] = "Add Doc Template";
        $this->load->view('superadmin/add_document_template', $data);
    }

    public function insert_document_template() {

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $doc_template_name = $this->input->post('doc_template_name');
        $required_for_arr = $this->input->post('required_for');
        $required_for = implode(",", $required_for_arr);
        $pay_rate_type = $this->input->post('pay_rate_type');
        $classification = $this->input->post('classification');
        $category = $this->input->post('category');
        $applicable_date = $this->input->post('applicable_date');
        $status = $this->input->post('status');

        $insert_arr = [

            'doc_template_name'     => $doc_template_name,
            'required_for'          => $required_for,
            'pay_rate_type'         => $pay_rate_type,
            'classification'        => $classification,
            'category'              => $category,
            'applicable_date'       => $applicable_date,
            'status'                => $status,
            'inserted_by_sadmin_id' => $sa_id,
            'inserted_date'         => date("Y-m-d"),
        ];

        $insert_query = $this->employee_model->insert_doc_template($insert_arr);

        if (!empty($insert_query)) {
            $this->session->set_flashdata('succ_msg', 'Document Template Uploaded Successfully.');
            redirect(base_url() . 'document-template-list');
        } else {
            $this->session->set_flashdata('error_msg', 'Document Template Not Uploaded.');
            redirect(base_url() . 'add-document-template');
        }

    }
    
    public function edit_document_template() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['doc_template_id'] = base64_decode($this->uri->segment(2));
        $doc_template_data = $this->employee_model->get_individual_doc_template_data($data['doc_template_id']);
        $data['doc_template_name'] = $doc_template_data[0]['doc_template_name'];
        if (empty($doc_template_data[0]['applicable_date'])) {
            $data['applicable_date'] = "";
        } else {
            $data['applicable_date'] = $doc_template_data[0]['applicable_date'];
        }

        $user_types_arr = explode(",", $doc_template_data[0]['required_for']);
        $data['is_consultant'] = (in_array('C', $user_types_arr))? 'checked' : '';
        $data['is_employee'] = (in_array('E', $user_types_arr))? 'checked' : '';
        $data['is_temp_emp'] = (in_array('TE', $user_types_arr))? 'checked' : '';
        $data['is_1099'] = (in_array('1099', $user_types_arr))? 'checked' : '';

        $data['is_yearly'] = '';
        $data['is_monthly'] = '';
        if ($doc_template_data[0]['pay_rate_type'] == 'yearly') {
            $data['is_yearly'] = 'selected';
        } else if ($doc_template_data[0]['pay_rate_type'] == 'monthly') {
            $data['is_monthly'] = 'selected';
        }
        
        if (empty($doc_template_data[0]['classification'])) {
            $data['classification'] = "";
        } else {
            $data['classification'] = $doc_template_data[0]['classification'];
        }

        if (empty($doc_template_data[0]['category'])) {
            $data['category'] = "";
        } else {
            $data['category'] = $doc_template_data[0]['category'];
        }
        
        $data['is_active'] = "";
        $data['is_archive'] = "";
        if ($doc_template_data[0]['status'] == 1) {
            $data['is_active'] = 'selected';
        } else if ($doc_template_data[0]['status'] == 2) {
            $data['is_archive'] = 'selected';
        }
        
        $data['page'] = "edit_document_template";
        $data['meta_title'] = "Edit Doc Template"; 
        $this->load->view('superadmin/edit_document_template', $data);       
    }

    public function update_document_template() {
        
        $doc_template_id = $this->input->post('doc_template_id');
        $doc_template_name = $this->input->post('doc_template_name');
        $required_for_arr = $this->input->post('required_for');
        $required_for = implode(",", $required_for_arr);
        $pay_rate_type = $this->input->post('pay_rate_type');
        $classification = $this->input->post('classification');
        $category = $this->input->post('category');
        $applicable_date = $this->input->post('applicable_date');
        $status = $this->input->post('status');

        $edit_doc_template_page_url = base_url() . 'edit-document-template/' . base64_encode($doc_template_id);

        if (isset($doc_template_name) && empty($doc_template_name)) {
            $this->session->set_flashdata('error_msg', 'Document template name field cannot be blank');
            redirect($edit_doc_template_page_url);

        } else if (isset($required_for_arr) && empty($required_for_arr)) {
            $this->session->set_flashdata('error_msg', 'Required for field cannot be blank');
            redirect($edit_doc_template_page_url);

        } else if (isset($status) && empty($status)) {
            $this->session->set_flashdata('error_msg', 'Status field cannot be blank');
            redirect($edit_doc_template_page_url);

        } else {
            
            $update_arr = [

                'doc_template_name'     => $doc_template_name,
                'required_for'          => $required_for,
                'pay_rate_type'         => $pay_rate_type,
                'classification'        => $classification,
                'category'              => $category,
                'applicable_date'       => $applicable_date,
                'status'                => $status,
                'updated_date'          => date("Y-m-d"),
            ];

            $update_query = $this->employee_model->update_document_template($update_arr, $doc_template_id);

            if (!empty($update_query)) {
                $this->session->set_flashdata('succ_msg', 'Document Template Updated Successfully.');
                redirect(base_url() . 'document-template-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Document Template Not Updated.');
                redirect($edit_doc_template_page_url);
            }
        }
        
    }

    public function add_doc_in_specific_doc_template() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['doc_template_id'] = base64_decode($this->uri->segment(2));
        $doc_template_data = $this->employee_model->get_individual_doc_template_data($data['doc_template_id']);
        $data['doc_template_name'] = $doc_template_data[0]['doc_template_name'];
        
        $data['page'] = "add_doc_in_specific_template";
        $data['meta_title'] = "Add Document";
        $this->load->view('superadmin/add_doc_in_specific_template', $data);
    }

    public function upload_doc_in_specific_doc_template() {

        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $document_name = $this->input->post('document_name');
        $applicable_date = $this->input->post('applicable_date');
        $status = $this->input->post('status');
        $doc_template_id = $this->input->post('doc_template_id');

        $add_document_for_template_url = base_url() . 'add-doc-in-specific-doc-template/' . base64_encode($doc_template_id);

        if (isset($document_name) && empty($document_name)) {
            $this->session->set_flashdata('error_msg', 'Document name field cannot be blank');
            redirect($add_document_for_template_url);
        } else if (isset($status) && empty($status)) {
            $this->session->set_flashdata('error_msg', 'Document status field cannot be blank');
            redirect($add_document_for_template_url);
        } else if (empty($_FILES)) {
            $this->session->set_flashdata('error_msg', 'Please Select The Document');
            redirect($add_document_for_template_url);
        } else {

            if (!empty($_FILES['file']['name'])) {

                $file_errors = array();
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext_arr = explode('.', $file_name);
                $file_ext = strtolower($file_ext_arr[1]);

                $new_file_name = $doc_template_id . '-' . time() . rand(00, 99) . '.' . $file_ext;
                $file_extensions = array("pdf");

                if (in_array($file_ext, $file_extensions) === false) {
                    $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                    $file_errors[] = "extension not allowed, please choose a PDF file.";
                }

                if ($file_size > 5*1024*1024) { // 5*1024*1024 = 5MB 
                    $this->session->set_flashdata('error_msg', 'File size must be less than 5 MB');
                    $file_errors[] = "'File size must be less than 5 MB";
                }

                if (empty($file_errors)) {

                    move_uploaded_file($file_tmp, "./uploads/template_documents/" . $new_file_name);
                } else {
                    if ($file_size > 5*1024*1024) { // 5*1024*1024 = 5MB 
                        $this->session->set_flashdata('error_msg', 'File size must be less than 5 MB');
                        $file_errors[] = "'File size must be less than 5 MB";
                        redirect($add_document_for_template_url);
                    }
                    if (in_array($file_ext, $file_extensions) === false) {
                        $this->session->set_flashdata('error_msg', 'Extension not allowed, please choose a PDF file.');
                        $file_errors[] = "extension not allowed, please choose a PDF file.";
                        redirect($add_document_for_template_url);
                    }
                }
            } else {
                $new_file_name = "";
            }

            $insert_arr = [

                'document_name'      => $document_name,
                'applicable_date'    => $applicable_date,
                'status'             => $status,
                'doc_template_id'    => $doc_template_id,
                'file'               => $new_file_name,
                'added_by_sadmin_id' => $sa_id,
                'inserted_date'      => date("Y-m-d"),
            ];

            $insert_query = $this->employee_model->insert_doc_in_specific_doc_template($insert_arr);

            if (!empty($insert_query)) {
                $this->session->set_flashdata('succ_msg', 'Document Uploaded Successfully.');
                redirect(base_url() . 'document-template-list');
            } else {
                $this->session->set_flashdata('error_msg', 'Document Not Uploaded.');
                redirect($add_document_for_template_url);
            }
        }

    }

    public function show_doc_list_for_specific_doc_template() {

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];

        $data['doc_template_id'] = base64_decode($this->uri->segment(2));
        $doc_template_data = $this->employee_model->get_individual_doc_template_data($data['doc_template_id']);
        $data['doc_template_name'] = $doc_template_data[0]['doc_template_name'];

        $data['document_list'] = $this->employee_model->get_doc_list_of_specific_doc_template($data['doc_template_id']);
        // echo "<pre>";
        // print_r($data['document_list']);
        // exit;
        $data['page'] = "doc_list_of_specific_doc_template";
        $data['meta_title'] = "Document List";
        $this->load->view('superadmin/doc_list_of_specific_doc_template', $data);
    }

    public function mockup_add_template_page() {
        
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url()); // the user is not logged in, redirect them!
        }
        
        $sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        
        $data['get_details'] = $this->profile_model->getDetails($email);
        $sa_id = $data['get_details'][0]['sa_id'];
        $data['page'] = "mockup_add_template_page";
        $data['meta_title'] = "Add Template";
        $this->load->view('superadmin/mockup_add_template_page', $data);
    }
}
