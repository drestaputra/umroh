<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Artikel extends Rest_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_artikel = $this->input->post('id_artikel');
        $data = $this->function_lib->findAll('1', 'artikel', 'id_artikel desc');
        foreach ($data as $key => $value) {
	        $data[$key]['isi_artikel'] = isset($value['isi_artikel']) ?  html_entity_decode($value['isi_artikel']) : "";
	        $data[$key]['gambar_artikel'] = isset($value['gambar_artikel']) ?  base_url('assets/artikel/').$value['gambar_artikel'] : "";
        }
        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    

    }

    public function detail_artikel_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_artikel = $this->input->post('id_artikel');
        $data = $this->function_lib->get_row('artikel','id_artikel='.$this->db->escape($id_artikel).'');
        if ($data != null) {
		    $data['isi_artikel'] = isset($data['isi_artikel']) ?  html_entity_decode($data['isi_artikel']) : "";
		    $data['gambar_artikel'] = isset($data['gambar_artikel']) ?  base_url('assets/artikel/').$data['gambar_artikel'] : "";
        }

        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Artikel.php */
/* Location: ./application/controllers/android/Artikel.php */