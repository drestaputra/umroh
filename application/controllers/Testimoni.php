<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends CI_Controller {

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
        // $crud->or_where("status","non_aktif");
        $crud->set_theme('adminlte');
        $crud->judul = "Testimoni";
        $crud->deskripsi = "Data Testimoni";
        $crud->set_table('testimoni');        
        $crud->set_subject('Data Testimoni');
        $crud->set_language('indonesian');
       
        $crud->columns('nama_tester','isi_testimoni');                 
        
        $crud->display_as('nama_tester','Nama Tester')
             ->display_as('isi_testimoni','Isi Testimoni');
        
        
        $crud->required_fields('no_testimoni','nama_pemilik_testimoni','nama_bank');                
        $crud->set_field_upload('foto_tester','api/assets/tester');       
        // $crud->callback_delete(array($this,'delete_data'));        
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('testimoni/index', $data, FALSE);

    }   
    
    function delete_data($primary_key){        
        $user_sess = $this->function_lib->get_user_level();
        $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";
      
        $columnUpdate = array(
            'status' => 'non_aktif'
        );
        $this->db->where('id_testimoni', $primary_key);
        return $this->db->update('testimoni', $columnUpdate);                
    } 
}

/* End of file Testimoni.php */
/* Location: ./application/controllers/Testimoni.php */