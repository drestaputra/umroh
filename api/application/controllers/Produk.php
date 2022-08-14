<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Produk extends Rest_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('Mproduk');
    }

    public function index_get()
    {
        $status = 200;
        $msg = "OK";
        $id_produk = $this->input->post('id_produk');
        $data = $this->function_lib->findAll('1', 'produk', 'id_produk desc');
        // if ($data != null) {
	       //  foreach ($data as $key => $value) {
		      //   $data[$key]['harga_produk'] = isset($value['harga_produk']) ?   $this->function_lib->toRupiah($value['harga_produk']) : "";
		      //   $data[$key]['harga_coret'] = isset($value['harga_coret']) ?  $this->function_lib->toRupiah($value['harga_coret']) : "";
	       //  }
        // }
        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    

    }

    public function detail_produk_post()
    {    
        $status = 200;
        $msg = "OK";
        $id_produk = $this->input->post('id_produk');
        
        
        $data = $this->Mproduk->get_detail_produk($id_produk);
        if ($data != null) {
        	$id_produk = isset($data['id_produk']) ? $data['id_produk'] : $id_produk;
        	$data = $this->function_lib->get_row('produk','id_produk='.$this->db->escape($id_produk).'');
		    $data['isi_produk'] = isset($data['isi_produk']) ?  html_entity_decode($data['isi_produk']) : "";
		    $data['foto_produk'] = isset($data['foto_produk']) ?  base_url('assets/produk/').$data['foto_produk'] : "";
        }

        $json_data = array(
        	'status'=>$status,
        	'msg'=>$msg,
        	'data' => $data);

        $this->response($json_data);    
    }  

}

/* End of file Produk.php */
/* Location: ./application/controllers/android/Produk.php */