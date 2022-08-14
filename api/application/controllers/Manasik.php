<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Manasik extends Rest_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();

    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_manasik = $this->input->post('id_manasik');
        $data = $this->function_lib->findAll('1', 'manasik', 'id_manasik desc');
    
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    


    }
    public function get_by_produk_post()
    {
        $status = 200;
        $msg = "OK";
        $id_produk = $this->input->post('id_produk');
        
        $data = $this->function_lib->findAll('id_produk='.$this->db->escape($id_produk).'', 'manasik', 'id_manasik desc');
    
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }

    public function detail_manasik_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_manasik = $this->input->post('id_manasik');
        $data = $this->function_lib->get_row('manasik','id_manasik='.$this->db->escape($id_manasik).'');
       

        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Manasik.php */
/* Location: ./application/controllers/android/Manasik.php */