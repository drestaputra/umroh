<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haji_plus extends CI_Controller {

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
        $crud->set_table('haji_plus');        
        $crud->set_subject('Data Haji Plus');
        $crud->set_language('indonesian');
        $crud->unset_delete();
        $crud->unset_add();
        
        $crud->columns('nama_haji_plus','biaya_sudah_termasuk','biaya_tidak_termasuk','syarat_ketentuan','deskripsi_haji_plus','harga_haji_plus','foto_haji_plus');                 
        
        $crud->display_as('nama_haji_plus','Judul')             
             ->display_as('deskripsi_haji_plus','Deskripsi');             

        $crud->field_type('harga_haji_plus','integer');
        // $crud->unset_texteditor(array('deskripsi_paket','full_text'));                
        $crud->set_field_upload('foto_haji_plus','api/assets/haji_plus');        
        $crud->required_fields('nama_haji_plus');                
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

/* End of file Haji_plus.php */
/* Location: ./application/controllers/Haji_plus.php */