<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agen extends CI_Controller {

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
        $crud->set_table('agen');
        $subject = "Data Agen";
        $crud->set_subject($subject);
        $crud->set_language('indonesian');
        $crud->columns('id_produk','judul_agen','isi_agen');                
        
      
        $crud->display_as('id_produk','Produk')
             ->display_as('judul_agen','Agen')
             ->display_as('isi_agen','Isi');
              
        $operation = $crud->getState();
        $crud->callback_column('Laporan',array($this,'link_laporan'));        
        
        $crud->required_fields('nama_agen','foto_ktp_agen','foto_agen','username','password');
        $crud->unset_texteditor(array('alamat','alamat'));
        $crud->unset_fields("notif_app_id","password");
        $crud->set_field_upload('foto_agen','api/assets/foto_agen');
        $crud->set_field_upload('foto_ktp_agen','api/assets/foto_ktp_agen');
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('agen/index', $data, FALSE);

    }          
}

/* End of file Agen.php */
/* Location: ./application/controllers/Agen.php */