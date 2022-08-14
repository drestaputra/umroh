<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

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
        $crud->set_table('artikel');        
        $crud->set_subject('Data Haji Plus');
        $crud->set_language('indonesian');
       
        
       
        
        $crud->display_as('nama_artikel','Judul')             
             ->display_as('deskripsi_artikel','Deskripsi');             

        $crud->field_type('harga_artikel','integer');
        $crud->unset_texteditor(array('judul_artikel','full_text'));                
        $crud->set_field_upload('gambar_artikel','api/assets/artikel');        
        $crud->required_fields('nama_artikel');                
        // $crud->callback_delete(array($this,'delete_data'));    
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('general', $data, FALSE);

    }          
    function delete_data($primary_key){                
        $columnUpdate = array(
            'status_paket' => 'hapus'
        );
        $this->db->where('id_paket', $primary_key);
        return $this->db->update('paket', $columnUpdate);                
    } 
}

/* End of file Artikel.php */
/* Location: ./application/controllers/Artikel.php */