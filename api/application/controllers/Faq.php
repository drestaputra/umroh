<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Faq extends Rest_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();

    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_faq = $this->input->post('id_faq');
        $data = $this->function_lib->findAll('status="aktif"', 'faq', 'id_faq desc');
   
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }

    public function detail_faq_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_faq = $this->input->post('id_faq');
        $data = $this->function_lib->get_row('faq','id_faq='.$this->db->escape($id_faq).'');
        

        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Faq.php */
/* Location: ./application/controllers/android/Faq.php */