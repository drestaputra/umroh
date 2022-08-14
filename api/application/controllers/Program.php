<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Program extends Rest_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $data = $this->function_lib->findAll('1', 'program', 'id_program desc');
        // if ($data != null) {
	       //  foreach ($data as $key => $value) {
		      //   $data[$key]['harga_program'] = isset($value['harga_program']) ?   $this->function_lib->toRupiah($value['harga_program']) : "";
		      //   $data[$key]['harga_coret'] = isset($value['harga_coret']) ?  $this->function_lib->toRupiah($value['harga_coret']) : "";
	       //  }
        // }
        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    

    }

    public function detail_program_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_program = $this->input->post('id_program');
        
        
        $data = $this->function_lib->get_row('program','id_program='.$this->db->escape($id_program).'');
        if ($data != null) {
        	$id_program = isset($data['id_program']) ? $data['id_program'] : $id_program;
        	$data = $this->function_lib->get_row('program','id_program='.$this->db->escape($id_program).'');
		    $data['deskripsi_program'] = isset($data['deskripsi_program']) ?  html_entity_decode($data['deskripsi_program']) : "";
		    $data['cara_pendaftaran'] = isset($data['cara_pendaftaran']) ?  html_entity_decode($data['cara_pendaftaran']) : "";
		    $data['ketentuan'] = isset($data['ketentuan']) ?  html_entity_decode($data['ketentuan']) : "";
        }

        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Program.php */
/* Location: ./application/controllers/android/Program.php */