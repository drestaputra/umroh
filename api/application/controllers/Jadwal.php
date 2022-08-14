<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Jadwal extends Rest_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();

    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_jadwal = $this->input->post('id_jadwal');
        $data = $this->function_lib->findAll('1', 'jadwal', 'id_jadwal desc');
    
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }

    public function detail_jadwal_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_jadwal = $this->input->post('id_jadwal');
        $data = $this->function_lib->get_row('jadwal','id_jadwal='.$this->db->escape($id_jadwal).'');
        if ($data != null) {
            $data['isi_jadwal'] = isset($data['isi_jadwal']) ?  html_entity_decode($data['isi_jadwal']) : "";
            $data['foto_jadwal'] = isset($data['foto_jadwal']) ?  base_url('assets/jadwal/').$data['foto_jadwal'] : "";
        }

        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Jadwal.php */
/* Location: ./application/controllers/android/Jadwal.php */