<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use \setasign\Fpdi\Fpdi;
// use setasign\Fpdi\PdfReader;

class Welcome extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
			parent::__construct();
			// $config=array('orientation'=>'P','size'=>'A4');
			// $this->load->library('mypdf',$config);
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function combineImagePdf(){
		combineImagePdf(["expense_pdf7.pdf","expense_pdf14.pdf"]);
    }   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */