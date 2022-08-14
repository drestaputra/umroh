<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->function_lib->cek_auth(array("super_admin","admin"));
		$this->load->library(array('grocery_CRUD','ajax_grocery_crud'));   
	}		
 
    public function index() {
        $this->load->config('grocery_crud');
        $this->config->set_item('grocery_crud_xss_clean', false);
        $crud = new Ajax_grocery_CRUD();

        $user_sess = $this->function_lib->get_user_level();
        $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";

        $crud->set_theme('adminlte');
        $crud->set_table('program');        
        $crud->set_subject('Data Program');
        $crud->set_language('indonesian');
        
        
       
       
               
        $crud->required_fields('nama_program','deskripsi_program','cara_pendaftaran','ketentuan');                
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('general', $data, FALSE);

    }          
    function delete_data($primary_key){                
        $columnUpdate = array(
            'is_active' => '0'
        );
        $this->db->where('id_program', $primary_key);
        return $this->db->update('program', $columnUpdate);                
    } 
}

/* End of file Program.php */
/* Location: ./application/controllers/Program.php */