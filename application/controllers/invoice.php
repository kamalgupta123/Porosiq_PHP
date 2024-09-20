<?php 
/**
 * 
 */
class Invoice extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/manage_employee_model', 'employee_model');
        $this->load->model('admin/manage_vendor_model', 'vendor_model');
        $this->load->model('admin/profile_model');
        $this->load->model('admin/manage_communication_model', 'communication_model');
		$this->load->model('admin/manage_ten99user_model', 'ten99user_model');
	}

	public function admin_invoice_pdf() {
       
        $sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];

        $assign_projects = "";

        $data['get_details'] = $this->profile_model->getDetails($email);
        $admin_id = $data['get_details'][0]['admin_id'];
        $invoice_id = base64_decode($this->uri->segment(2));
        $get_invoice_details = $this->employee_model->checkAdminInvoiceStatus($invoice_id);
//echo $get_invoice_details[0]['employee_id'];
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

        echo $this->load->view('admin/invoice_pdf', $data, true);
        
        exit();

//        $this->html2pdf->html($this->load->view('admin/invoice_pdf', $data, true));
//        if ($this->html2pdf->create('view_only')) {
//            redirect(base_url() . 'admin_consultant_invoice');
//        }
    }

}