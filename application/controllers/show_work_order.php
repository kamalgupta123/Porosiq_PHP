<?php 
session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Show_Work_Order extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
	}

	public function index() {
		$sadmin_logged_in = $this->session->userdata('logged_in');
		$admin_logged_in = $this->session->userdata('admin_logged_in');
		$vendor_logged_in = $this->session->userdata('vendor_logged_in');

		if ($sadmin_logged_in || $admin_logged_in || $vendor_logged_in) {
			$file_name = base64_decode($this->uri->segment(2));

			if ($sadmin_logged_in) {
				$data['dashboard_link'] = site_url('dashboard');
			} else if ($admin_logged_in) {
				$data['dashboard_link'] = site_url('admin_dashboard');
			} else if ($vendor_logged_in) {
				$data['dashboard_link'] = site_url('vendor_dashboard');
			}

			$data['wo_pdf_link'] = base_url() . 'uploads/historical_work_order/' . $file_name;
			$this->load->view('view_work_order', $data);
		} else {
			set_referer_url();
            redirect(base_url()); 
		}
	}
}