<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class Akun extends REST_Controller {
	
	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }
    
	public function profil_post(){	
		$status = 500;
		$msg = "Akun tidak ditemukan";
		$data = array();
		$id_user = $this->input->post('id_user');
		$jenis_user = $this->input->post('jenis_user');
		$data = array();
		if (trim($id_user)!="") {
			$cekIdUser = "";
			if (!empty($jenis_user) && $jenis_user == "agen") {
				$id_user = $this->function_lib->get_one('id_agen','agen','id_agen='.$this->db->escape($id_user).'');
				$dataTemp  = $this->function_lib->get_row('agen','id_agen='.$id_user.'');
				$data = array(
					'id_user' => $id_user,
					'nama_lengkap' => isset($dataTemp['nama_agen']) ? $dataTemp['nama_agen'] : "",
					'jenis_user' => "agen",
					'username' => isset($dataTemp['username']) ? $dataTemp['username'] : "",
					'email' => isset($dataTemp['email']) ? $dataTemp['email'] : "",
					'no_hp' => isset($dataTemp['no_hp']) ? $dataTemp['no_hp'] : "",
					'alamat' => isset($dataTemp['alamat']) ? $dataTemp['alamat'] : "",
					'tgl_lahir' => isset($dataTemp['tgl_lahir']) ? $dataTemp['tgl_lahir'] : "",
					'tempat_lahir' => isset($dataTemp['tempat_lahir']) ? $dataTemp['tempat_lahir'] : "",
					'pekerjaan' => isset($dataTemp['pekerjaan']) ? $dataTemp['pekerjaan'] : "",
					'foto_ktp' => isset($dataTemp['foto_ktp_agen']) ? $dataTemp['foto_ktp_agen'] : "",
					'foto' => isset($dataTemp['foto_agen']) ? $dataTemp['foto_agen'] : ""
				);
			}else if(!empty($jenis_user) && $jenis_user == "agen") {

				$id_user = $this->function_lib->get_one('id_jamaah','jamaah','id_jamaah='.$this->db->escape($id_user));
				$dataTemp  = $this->function_lib->get_row('jamaah','id_jamaah='.$id_user.'');
				$data = array(
					'id_user' => $id_user,
					'nama_lengkap' => isset($dataTemp['nama_jamaah']) ? $dataTemp['nama_jamaah'] : "",
					'jenis_user' => "jamaah",
					'username' => isset($dataTemp['username']) ? $dataTemp['username'] : "",
					'email' => isset($dataTemp['email']) ? $dataTemp['email'] : "",
					'no_hp' => isset($dataTemp['no_hp']) ? $dataTemp['no_hp'] : "",
					'alamat' => isset($dataTemp['alamat']) ? $dataTemp['alamat'] : "",
					'tgl_lahir' => isset($dataTemp['tgl_lahir']) ? $dataTemp['tgl_lahir'] : "",
					'tempat_lahir' => isset($dataTemp['tempat_lahir']) ? $dataTemp['tempat_lahir'] : "",
					'pekerjaan' => isset($dataTemp['pekerjaan']) ? $dataTemp['pekerjaan'] : "",
					'foto_ktp' => isset($dataTemp['foto_ktp_jamaah']) ? $dataTemp['foto_ktp_jamaah'] : "",
					'foto' => isset($dataTemp['foto_jamaah']) ? $dataTemp['foto_jamaah'] : ""
				);
			}
			
			$status = 200;
			$msg = "Sukses";
		}
		$response = array("status"=>$status,"msg"=>$msg,"data"=>$data);
		$this->response($response);
	}
}

/* End of file Akun.php */
/* Location: ./application/controllers/android/Akun.php */