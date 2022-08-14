<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Haji_plus extends Rest_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $data = $this->function_lib->get_row('haji_plus', '1');
        // if ($data != null) {
	       //  foreach ($data as $key => $value) {
		      //   $data[$key]['harga_haji_plus'] = isset($value['harga_haji_plus']) ?   $this->function_lib->toRupiah($value['harga_haji_plus']) : "";
		      //   $data[$key]['harga_coret'] = isset($value['harga_coret']) ?  $this->function_lib->toRupiah($value['harga_coret']) : "";
	       //  }
        // }
        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    

    }

    public function manasik_get()
    {
        $status = 200;
        $msg = "OK";
        $id_haji_plus = $this->input->post('id_haji_plus');
        $data = $this->function_lib->findAll('id_haji_plus in (SELECT id_haji_plus from manasik)', 'haji_plus', 'id_haji_plus desc');
        // if ($data != null) {
           //  foreach ($data as $key => $value) {
              //   $data[$key]['harga_haji_plus'] = isset($value['harga_haji_plus']) ?   $this->function_lib->toRupiah($value['harga_haji_plus']) : "";
              //   $data[$key]['harga_coret'] = isset($value['harga_coret']) ?  $this->function_lib->toRupiah($value['harga_coret']) : "";
           //  }
        // }
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }

    public function detail_haji_plus_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_haji_plus = $this->input->post('id_haji_plus');
        
        
        $data = $this->function_lib->get_row('haji_plus','id_haji_plus='.$this->db->escape($id_haji_plus).'');
        if ($data != null) {
        	$id_haji_plus = isset($data['id_haji_plus']) ? $data['id_haji_plus'] : $id_haji_plus;
        	$data = $this->function_lib->get_row('haji_plus','id_haji_plus='.$this->db->escape($id_haji_plus).'');
		    $data['isi_haji_plus'] = isset($data['isi_haji_plus']) ?  html_entity_decode($data['isi_haji_plus']) : "";
		    $data['foto_haji_plus'] = isset($data['foto_haji_plus']) ?  base_url('assets/haji_plus/').$data['foto_haji_plus'] : "";
        }

        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Haji_plus.php */
/* Location: ./application/controllers/android/Haji_plus.php */