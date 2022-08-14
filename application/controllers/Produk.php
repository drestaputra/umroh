<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

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
        $crud->set_table('produk');        
        $crud->set_subject('Data Produk');
        $crud->set_language('indonesian');
        
        $crud->columns('nama_produk','fasilitas','hak_calon_jamaah','syarat_ketentuan','deskripsi_produk','harga_produk','foto_produk');                 
        
        $crud->display_as('nama_produk','Nama')             
             ->display_as('deskripsi_produk','Deskripsi');             

        $crud->field_type('harga_produk','integer');
        // $crud->unset_texteditor(array('deskripsi_paket','full_text'));                
        $crud->set_field_upload('foto_produk','api/assets/foto_produk');        
        $crud->required_fields('nama_produk');                
        // $crud->callback_delete(array($this,'delete_data'));    
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('paket/index', $data, FALSE);

    }          
    function delete_data($primary_key){                
        $columnUpdate = array(
            'status_paket' => 'hapus'
        );
        $this->db->where('id_paket', $primary_key);
        return $this->db->update('paket', $columnUpdate);                
    } 
}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */