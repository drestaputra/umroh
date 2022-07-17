<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manasik extends CI_Controller {

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
        $crud->set_table('manasik');
        $subject = "Data Manasik";
        $crud->set_subject($subject);
        $crud->set_language('indonesian');
        $crud->set_relation('id_produk','produk','nama_produk');

        $crud->columns('id_produk','judul_manasik','isi_manasik');                
        
      
        $crud->display_as('id_produk','Produk')
             ->display_as('judul_manasik','Manasik')
             ->display_as('isi_manasik','Isi');
              
        $operation = $crud->getState();
        $crud->callback_column('Laporan',array($this,'link_laporan'));        
        
        $crud->required_fields('id_produk','judul_manasik','isi_manasik');
        $crud->unset_texteditor(array('isi_manasik','full_text'));
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('manasik/index', $data, FALSE);

    }          
}

/* End of file Manasik.php */
/* Location: ./application/controllers/Manasik.php */