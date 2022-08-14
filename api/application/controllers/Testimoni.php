<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Testimoni extends Rest_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $data = $this->function_lib->findAll('1', 'testimoni', 'id_testimoni desc');
        if ($data != null) {
            foreach ($data as $key => $value) {
                $data[$key]['foto_tester'] = base_url('assets/tester/').$value['foto_tester'];
            }
        }
        $json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => $data);

        $this->response($json_data);    

    }
}

/* End of file Testimoni.php */
/* Location: ./application/controllers/android/Testimoni.php */