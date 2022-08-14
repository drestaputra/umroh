<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jamaah extends CI_Controller {

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
        $crud->set_table('jamaah');
        $subject = "Data Jamaah";
        $crud->set_subject($subject);
        $crud->set_language('indonesian');
        
              
        $operation = $crud->getState();
        $crud->callback_column('Laporan',array($this,'link_laporan'));        
        
        $crud->required_fields('nama_jamaah','foto_ktp_jamaah','foto_jamaah','username','password');
        $crud->unset_texteditor(array('alamat','alamat'));
        $crud->unset_fields("notif_app_id","password");
        $crud->unset_columns('notif_app_id','password');
        $crud->set_field_upload('foto_jamaah','api/assets/foto_jamaah');
        $crud->set_field_upload('foto_ktp_jamaah','api/assets/foto_ktp_jamaah');
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('general', $data, FALSE);

    }          
}

/* End of file Jamaah.php */
/* Location: ./application/controllers/Jamaah.php */