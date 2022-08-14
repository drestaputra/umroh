<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->function_lib->cek_auth(array("admin"));
		$this->load->library(array('grocery_CRUD','ajax_grocery_crud'));   
	}		
 
    public function index() {
        $crud = new Ajax_grocery_CRUD();

        $user_sess = $this->function_lib->get_user_level();
        $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";

        $crud->set_theme('adminlte');
        $crud->set_table('doa');
        $subject = "Data Doa";
        $crud->set_subject($subject);
        $crud->set_language('indonesian');
        
      
      	
              
        $operation = $crud->getState();
        
        $crud->required_fields('nama_doa');
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('general', $data, FALSE);

    }          
}

/* End of file Doa.php */
/* Location: ./application/controllers/Doa.php */