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
        $this->load->model('Martikel');       
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_artikel = $this->input->post('id_artikel');
        $data = $this->function_lib->findAll('1', 'artikel', 'id_artikel desc');
        foreach ($data as $key => $value) {
	        $data[$key]['isi_artikel'] = isset($value['isi_artikel']) ?  html_entity_decode($value['isi_artikel']) : "";
	        $data[$key]['foto_artikel'] = isset($value['foto_artikel']) ?  base_url('assets/artikel/').$value['foto_artikel'] : "";
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
		    $data['foto_artikel'] = isset($data['foto_artikel']) ?  base_url('assets/artikel/').$data['foto_artikel'] : "";
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