<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	}
	public function index()
	{
		$this->function_lib->cek_auth(array('admin'));		
		$data = array();
		$this->load->view('admin/dashboard/index',$data,false);	
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */