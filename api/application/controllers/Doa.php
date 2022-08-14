<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Doa extends Rest_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();

    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_doa = $this->input->post('id_doa');
        $data = $this->function_lib->findAll('1', 'doa', 'id_doa desc');
    foreach ($data as $key => $value) {
            $data[$key]['bacaan_doa'] = isset($value['bacaan_doa']) ?  html_entity_decode($value['bacaan_doa']) : "";
            $data[$key]['arti_doa'] = isset($value['arti_doa']) ?  html_entity_decode($value['arti_doa']) : "";
        }
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }

    public function detail_doa_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_doa = $this->input->post('id_doa');
        $data = $this->function_lib->get_row('doa','id_doa='.$this->db->escape($id_doa).'');
        

        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Doa.php */
/* Location: ./application/controllers/android/Doa.php */