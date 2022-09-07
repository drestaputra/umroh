<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Daftar extends REST_Controller {
	
	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('Mandroid');
    }

	public function kolektor_post()
	{
		$post=$this->input->post();
		if ($post) {
			$this->load->model('Mandroid');
			$daftar=$this->Mandroid->daftar();
			$this->response($daftar);
		}
	}	
	public function agen_post(){
		$post = $this->input->post();
		if ($post) {
			$this->load->model('Mandroid');
			$daftar=$this->Mandroid->daftar_agen();
			$status = isset($daftar['status']) ? $daftar['status'] : 500;
			$msg = isset($daftar['msg']) ? $daftar['msg'] : 500;

			$json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => array()
        );

        $this->response($json_data);    
		}
	}
	public function jamaah_post(){
		$post = $this->input->post();
		if ($post) {
			$this->load->model('Mandroid');
			$daftar=$this->Mandroid->daftar_jamaah();
			$status = isset($daftar['status']) ? $daftar['status'] : 500;
			$msg = isset($daftar['msg']) ? $daftar['msg'] : 500;

			$json_data = array(
            'status'=>$status,
            'msg'=>$msg,
            'data' => array()
        );

        $this->response($json_data);    
		}
	}
	// public function tesmail(){
	// 	// $this->load->model('Mmail');
	// 	// $hasil=$this->Mmail->kirim_email("drestaputra@gmail.com","Biro Umroh Cilacap","Notifikasi Pendaftaran Agen","tes");
	// 	// echo "<pre>";
	// 	// print_r ($hasil);
	// 	// echo "</pre>";
	// 	// $post=$this->input->post();				
	// 	// $this->load->model('Mmail');
	// 	// if ($post) {
	// 	// // public function kirim_email($to,$to_name,$subjek,$pesan){		
	// 	// 	$hasil=$this->Mmail->kirim_email($post['email'],$post['nama'],$post['subjek'],$post['pesan']);
	// 	// 	// redirect('daftar/sukses');
	// 	// 	echo "<pre>";
	// 	// 	print_r ($hasil);
	// 	// 	echo "</pre>";
	// 	// }
	// 	// $this->load->view('tesmail', null, FALSE);
	// 	// 			$data2['id_jamaah']="2";

	// 	// 			// mengirim email ke calon jamaah					
	// 	// 			$data2['nama_jamaah']="a";
	// 	// 			$data2['email']="d@g.com";
	// 	// 			$data2['username']="d";

	// 	// $message=$this->load->view('templatemail', null, FALSE);
	// }	
}

/* End of file Daftar.php */
/* Location: ./application/controllers/android/daftar/Daftar.php */