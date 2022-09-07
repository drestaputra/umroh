<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mandroid extends CI_Model {

	function cek_login(){		
		$username=$this->input->post('username',TRUE);
		$password=$this->input->post('password',TRUE);
		$password = hash('sha512',$this->security->sanitize_filename($password) . config_item('encryption_key'));        
		
		$where="username=".$this->db->escape($username)." AND password=".$this->db->escape($password)." ";
		$this->db->where($where);
		$query_agen=$this->db->get('agen');		
		$query_jamaah=$this->db->get('jamaah');		
		$jumlah_cocok_agen = $query_agen->num_rows();
		$jumlah_cocok_jamaah = $query_jamaah->num_rows();
		$data_user=array();
		if ($jumlah_cocok_agen != 0) {
			$data_user_agen = $query_agen->row_array();
			$data_user = array(
				"id_agen" => $data_user_agen['id_agen'],
				"username" => $data_user_agen['username']
			);
			$status=200;
			$msg="Berhasil Login";
		}else if ($jumlah_cocok_jamaah != 0) {
			$data_user_jamaah = $query_jamaah->row_array();
			$data_user = array(
				"id_jamaah" => $data_user_jamaah['id_jamaah'],
				"username" => $data_user_jamaah['username']
			);
			$status=200;
			$msg="Berhasil Login";
		
		}else{
			$status=500;
			$msg="Username atau password salah";
		}
		return array("status"=>$status,"msg"=>$msg,"data"=> $data_user);
		
	}
	
	function get_akun($id){		
		$this->db->where('id_agen', $id);
		$query_agen=$this->db->get('agen');
		$this->db->where('id_jamaah', $id);
		$query_jamaah=$this->db->get('jamaah');
		$cocok_agen=$query_agen->num_rows();
		$cocok_jamaah=$query_jamaah->num_rows();
		if ($cocok_agen!=0) {
			$output=$query_agen->row_array();
			$output['nama_lengkap']=$output['nama_agen'];
			$output['id_user']=$output['id_agen'];
			$output['jenis_user']="agen";
			$output['foto']=$output['foto_agen'];
			$output['foto_ktp']=$output['foto_ktp_agen'];
		} elseif($cocok_jamaah!=0) {
			$output=$query_jamaah->row_array();
			$output['nama_lengkap']=$output['nama_jamaah'];
			$output['id_user']=$output['id_jamaah'];
			$output['foto']=$output['foto_jamaah'];
			$output['foto_ktp']=$output['foto_ktp_jamaah'];
			$output['jenis_user']="jamaah";
		}else{
			$output=null;
		}
		return $output;
	}
	function forget_password(){
		$this->load->library('form_validation');					
		$data['status']=500;									
		$data['msg']="Gagal silahkan coba lagi";
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		if ($this->form_validation->run() == TRUE) {				
			$email = $this->input->post('email', TRUE);
			$email = $this->security->sanitize_filename($email);
			$cek_email_agen = $this->function_lib->get_one('email','agen','email='.$this->db->escape($email).'');
			$cek_email_jamaah = $this->function_lib->get_one('email','jamaah','email='.$this->db->escape($email).'');
			if (!empty($cek_email_agen)) {
				$exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
				$jam_sekarang = date("Y-m-d H:i:s",strtotime($exp_datetime));
				$menit_lalu = date("Y-m-d H:i:s",strtotime('+590 minutes'));
				// BETWEEN '2016-01-23 00:00:00' AND '2016-01-24 00:00:00'
				// cek hitung batasan limit request forget password range 10 menit, limit 5 request
				$jumlah_request = $this->function_lib->get_one('count(id_forget_password)','forget_password','email='.$this->db->escape($email).' AND jenis_user="agen" AND exp_datetime BETWEEN '.$this->db->escape($menit_lalu).' AND '.$this->db->escape($jam_sekarang).'');					
				if (intval($jumlah_request)<5) {
					$this->insertKodeAgen($email);
					$data['status']=200;									
					$data['msg']="Email telah dikirim, silahkan cek email untuk mengubah password";	
				}else{					
					$data['status'] = 500;									
					$data['msg'] = "Anda terlalu banyak melakukan request perubahan password, silahkan tunggu 10 menit lagi.";	
				}
			}else if (!empty($cek_email_jamaah)) {
				$exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
				$jam_sekarang = date("Y-m-d H:i:s",strtotime($exp_datetime));
				$menit_lalu = date("Y-m-d H:i:s",strtotime('+590 minutes'));
				// BETWEEN '2016-01-23 00:00:00' AND '2016-01-24 00:00:00'
				// cek hitung batasan limit request forget password range 10 menit, limit 5 request
				$jumlah_request = $this->function_lib->get_one('count(id_forget_password)','forget_password','email='.$this->db->escape($email).' AND jenis_user="jamaah" AND exp_datetime BETWEEN '.$this->db->escape($menit_lalu).' AND '.$this->db->escape($jam_sekarang).'');					
				if (intval($jumlah_request)<5) {
					$this->insertKodeJamaah($email);
					$data['status']=200;									
					$data['msg']="Email telah dikirim, silahkan cek email untuk mengubah password";	
				}else{					
					$data['status'] = 500;									
					$data['msg'] = "Anda terlalu banyak melakukan request perubahan password, silahkan tunggu 10 menit lagi.";	
				}
			}else{
				$data['status']=500;									
				$data['msg']="Pengguna dengan email tersebut tidak ditemukan."	;
			}
		} else {
			$data['status']=500;									
			$data['msg']="Gagal silahkan coba lagi";
		}		
		return $data;					
	}
	function insertKodeAgen($email){
		$id_user = $this->function_lib->get_one('id_agen','agen','email='.$this->db->escape($email).'');
		$configKey = "3mai1f0rg3t";
		$exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
		$token = hash('sha512', $email . $configKey . $exp_datetime);
		$this->db->set('is_active','0');
		$this->db->where('email', $email);
		$this->db->where('jenis_user', "agen");
		$this->db->update('forget_password');
		$columnInsert = array(
			"email" => $email,
			"jenis_user" => "agen",
			"id_user" => $id_user,
			"token" => $token,
			"exp_datetime" => $exp_datetime
		);
		$insert = $this->db->insert('forget_password', $columnInsert);
		if ($insert) {
			$this->load->model('Mmail');
			$data_email['token']=$token;
			$data_email['base_url'] = "https://android.almakwatour.com/";
			$message = $this->load->view('template_email_forget_password', $data_email, TRUE);			
			$this->Mmail->kirim_email($email,"Almawa Tour And Travel","Permintaan Perubahaan Password",$message);
		}
		
	}
	function insertKodeJamaah($email){
		$id_user = $this->function_lib->get_one('id_jamaah','jamaah','email='.$this->db->escape($email).'');
		$configKey = "3mai1f0rg3t";
		$exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
		$token = hash('sha512', $email . $configKey . $exp_datetime);
		$this->db->set('is_active','0');
		$this->db->where('email', $email);
		$this->db->where('jenis_user', "jamaah");
		$this->db->update('forget_password');
		$columnInsert = array(
			"email" => $email,
			"jenis_user" => "jamaah",
			"id_user" => $id_user,
			"token" => $token,
			"exp_datetime" => $exp_datetime
		);
		$insert = $this->db->insert('forget_password', $columnInsert);
		if ($insert) {
			$this->load->model('Mmail');
			$data_email['token']=$token;
			$data_email['base_url'] = base_url();
			$message = $this->load->view('template_email_forget_password', $data_email, TRUE);			
			$this->Mmail->kirim_email($email,"Almawa Tour And Travel","Permintaan Perubahaan Password",$message);
		}
		
	}
	// function lupass($kode){
	// 	$password=$this->input->post('pwd',true);
	// 	$where="token='".$kode."' AND is_active='1'";
	// 	$this->db->where($where);
	// 	$query=$this->db->get('lupass');
	// 	$data_lupass=$query->row_array();

	// 	if ($data_lupass['jenis_user']=="jamaah") {
	// 		$data_update_jamaah=array(
	// 			"password"=>sha1($password)
	// 		);
	// 		$this->db->where('username', $data_lupass['username']);
	// 		$this->db->update('jamaah',$data_update_jamaah );
	// 	}
	// 	else if($data_lupass['jenis_user']=="agen") {
	// 		$data_update_agen=array(
	// 			"password"=>sha1($pwd)
	// 		);
	// 		$this->db->where('username', $data_lupass['username']);
	// 		$this->db->update('agen',$data_update_agen );
	// 	}		
	// 	$this->db->where($where);
	// 	$data_update_lupass=array(
	// 		"is_active"=>"0"
	// 	);
	// 	$this->db->update('lupass', $data_update_lupass);
	// 	return array("status"=>200,"msg"=>"Berhasil mengubah password, silahkan login");
	// }
	function validasi_daftar_agen(){
		$status=200;
		$msg="";
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_agen', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]',
			 array(
                'required'      => '%s masih kosong',
                'max_length'	=> '%s maksimal 100 karakter',
                'min_length'	=> '%s minimal 3 karakter'

        	)
		);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|min_length[1]|max_length[300]',
			 array(
                'required'      => '%s masih kosong',    
                'max_length'	=> '%s maksimal 300 karakter',
                'min_length'	=> '%s minimal 1 karakter'            
        	)
		);
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[agen.email]',
			array(
                'required'      => '%s masih kosong',
                'is_unique'     => '%s sudah terdaftar.'
        	)
		);
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|is_unique[agen.username]',
			array(
                'required'      => '%s masih kosong',        
                'max_length'	=> '%s maksimal 20 karakter',
                'min_length'	=> '%s minimal 3 karakter',
                'is_unique'     => '%s sudah terdaftar.'
        	)
		);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[40]',
			array(
                'required'      => '%s masih kosong',    
                'max_length'	=> '%s maksimal 40 karakter',
                'min_length'	=> '%s minimal 6 karakter'            
        	)
		);		
		// $this->form_validation->set_rules('foto_ktp_agen', 'Foto KTP Agen', 'required',
		// 	 array(
  //               'required'      => '%s masih kosong',
  //       	)
		// );		
		// $this->form_validation->set_rules('foto_agen', 'Foto Agen', 'required',
		// 	 array(
  //               'required'      => '%s masih kosong',
  //       	)
		// );		
		if ($this->form_validation->run() == TRUE) {
			$status=200;
			$msg="Berhasil";
		} else {
			$status=500;
			$msg=validation_errors(' ',' ');
		}
		return array("status"=>$status,"msg"=>$msg);
	}
	function daftar_agen(){
		$data_kolektor=null;
		 $validasi=$this->validasi_daftar_agen();
		 $status = isset($validasi['status']) ? $validasi['status'] : 500;
		 $msg = isset($validasi['msg']) ? $validasi['msg'] : 500;
		 if ($validasi['status']==200) {
			$post=$this->input->post();
			$post['password'] = isset($post['password']) ? $post['password'] : "";
			$post['password'] = hash('sha512',$this->security->sanitize_filename($post['password']) . config_item('encryption_key'));

		 	$UploadKtp = $this->upload_ktp_agen();
		 	$dataUploadKtp = isset($UploadKtp['data']) ? $UploadKtp['data'] : array();
		 	$UploadFoto = $this->upload_foto_agen();
		 	$dataUploadFoto = isset($UploadFoto['data']) ? $UploadFoto['data'] : array();
		 	$msgUploadKtp = isset($UploadKtp['error']) ? $UploadKtp['error'] : "";
		 	$fotoKtp = isset($dataUploadKtp['file_name']) ? $dataUploadKtp['file_name'] : " \n";
		 	$fotoName = isset($dataUploadFoto['file_name']) ? $dataUploadFoto['file_name'] : " \n";
		 	$msgUploadFoto = isset($UploadFoto['error']) ? $UploadFoto['error'] : "";

		 	$input_data = array(
		 		"nama_agen" => isset($post['nama_agen']) ? $post['nama_agen'] : "",
		 		"notif_app_id" => isset($post['notif_app_id']) ? $post['notif_app_id'] : "",
		 		"tempat_lahir" => isset($post['tempat_lahir']) ? $post['tempat_lahir'] : "",
		 		"tgl_lahir" => isset($post['tgl_lahir']) ? date("Y-m-d", strtotime($post['tgl_lahir'])) : "",
		 		"jenis_kelamin" => isset($post['jenis_kelamin']) ? $post['jenis_kelamin'] : "",
		 		"alamat" => isset($post['alamat']) ? $post['alamat'] : "",
		 		"no_hp" => isset($post['no_hp']) ? $post['no_hp'] : "",
		 		"pekerjaan" => isset($post['pekerjaan']) ? $post['pekerjaan'] : "",
		 		"email" => isset($post['email']) ? $post['email'] : "",
		 		"no_rekening" => isset($post['no_rekening']) ? $post['no_rekening'] : "",
		 		"bank_agen" => isset($post['bank_agen']) ? $post['bank_agen'] : "",
		 		"username" => isset($post['username']) ? $post['username'] : "",
		 		"password" => isset($post['password']) ? $post['password'] : "",
		 		"foto_agen" => isset($fotoName) ? $fotoName : "",
		 		"foto_ktp_agen" => isset($fotoKtp) ? $fotoKtp : "",
		 	);
		 
		 	$this->db->insert('agen', $input_data);
			$status = 200;
			$msg = "Berhasil daftar. ".$msgUploadFoto.$msgUploadKtp;
		
		 	
		 }
		 return array("status"=>$status,"msg"=>$msg);
	}

	function upload_ktp_agen(){
		$config['upload_path'] = './assets/foto_ktp_agen/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '7000';
		$config['file_name'] = time();
		$error = "";
		$upload_data = array();
		$this->load->library('upload', $config, 'fotoKtpAgen');
		$this->fotoKtpAgen->initialize($config);
		if (!$this->fotoKtpAgen->do_upload('foto_ktp_agen')){
            $error = $this->fotoKtpAgen->display_errors();
            $upload_data = array();
        }else{
            $upload_data = $this->fotoKtpAgen->data();
            $error = "";
        }
        return array("error"=>$error, "data" => $upload_data);
	}
	function upload_foto_agen(){
		$config = array();
		$config['upload_path'] = './assets/foto_agen/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '7000';
		$config['file_name'] = time();
		$error = "";
		$upload_data = array();
		$this->load->library('upload', $config, 'fotoAgen');
		$this->fotoAgen->initialize($config);
		if (!$this->fotoAgen->do_upload('foto_agen')){
            $error = $this->fotoAgen->display_errors();
            $upload_data = array();
        }else{
            $upload_data = $this->fotoAgen->data();
            $error = "";
        }
        return array("error"=>$error, "data" => $upload_data);
	}

	function validasi_daftar_jamaah(){
		$status=200;
		$msg="";
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_jamaah', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]',
			 array(
                'required'      => '%s masih kosong',
                'max_length'	=> '%s maksimal 100 karakter',
                'min_length'	=> '%s minimal 3 karakter'

        	)
		);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|min_length[1]|max_length[300]',
			 array(
                'required'      => '%s masih kosong',    
                'max_length'	=> '%s maksimal 300 karakter',
                'min_length'	=> '%s minimal 1 karakter'            
        	)
		);
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[jamaah.email]',
			array(
                'required'      => '%s masih kosong',
                'is_unique'     => '%s sudah terdaftar.'
        	)
		);
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|is_unique[jamaah.username]',
			array(
                'required'      => '%s masih kosong',        
                'max_length'	=> '%s maksimal 20 karakter',
                'min_length'	=> '%s minimal 3 karakter',
                'is_unique'     => '%s sudah terdaftar.'
        	)
		);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[40]',
			array(
                'required'      => '%s masih kosong',    
                'max_length'	=> '%s maksimal 40 karakter',
                'min_length'	=> '%s minimal 6 karakter'            
        	)
		);		
		// $this->form_validation->set_rules('foto_ktp_agen', 'Foto KTP Agen', 'required',
		// 	 array(
  //               'required'      => '%s masih kosong',
  //       	)
		// );		
		// $this->form_validation->set_rules('foto_agen', 'Foto Agen', 'required',
		// 	 array(
  //               'required'      => '%s masih kosong',
  //       	)
		// );		
		if ($this->form_validation->run() == TRUE) {
			$status=200;
			$msg="Berhasil";
		} else {
			$status=500;
			$msg=validation_errors(' ',' ');
		}
		return array("status"=>$status,"msg"=>$msg);
	}

	function daftar_jamaah(){
		$data_kolektor=null;
		 $validasi=$this->validasi_daftar_jamaah();
		 $status = isset($validasi['status']) ? $validasi['status'] : 500;
		 $msg = isset($validasi['msg']) ? $validasi['msg'] : 500;
		 if ($validasi['status']==200) {
			$post=$this->input->post();
			$post['password'] = isset($post['password']) ? $post['password'] : "";
			$post['password'] = hash('sha512',$this->security->sanitize_filename($post['password']) . config_item('encryption_key'));

		 	$UploadKtp = $this->upload_ktp_jamaah();
		 	$dataUploadKtp = isset($UploadKtp['data']) ? $UploadKtp['data'] : array();
		 	$UploadFoto = $this->upload_foto_jamaah();
		 	$dataUploadFoto = isset($UploadFoto['data']) ? $UploadFoto['data'] : array();
		 	$msgUploadKtp = isset($UploadKtp['error']) ? $UploadKtp['error'] : "";
		 	$fotoKtp = isset($dataUploadKtp['file_name']) ? $dataUploadKtp['file_name'] : " \n";
		 	$fotoName = isset($dataUploadFoto['file_name']) ? $dataUploadFoto['file_name'] : " \n";
		 	$msgUploadFoto = isset($UploadFoto['error']) ? $UploadFoto['error'] : "";

		 	$input_data = array(
		 		"nama_jamaah" => isset($post['nama_jamaah']) ? $post['nama_jamaah'] : "",
		 		"notif_app_id" => isset($post['notif_app_id']) ? $post['notif_app_id'] : "",
		 		"tempat_lahir" => isset($post['tempat_lahir']) ? $post['tempat_lahir'] : "",
		 		"tgl_lahir" => isset($post['tgl_lahir']) ? date("Y-m-d", strtotime($post['tgl_lahir'])) : "",
		 		"jenis_kelamin" => isset($post['jenis_kelamin']) ? $post['jenis_kelamin'] : "",
		 		"alamat" => isset($post['alamat']) ? $post['alamat'] : "",
		 		"no_hp" => isset($post['no_hp']) ? $post['no_hp'] : "",
		 		"pekerjaan" => isset($post['pekerjaan']) ? $post['pekerjaan'] : "",
		 		"email" => isset($post['email']) ? $post['email'] : "",
		 		"no_rekening" => isset($post['no_rekening']) ? $post['no_rekening'] : "",
		 		"bank_jamaah" => isset($post['bank_jamaah']) ? $post['bank_jamaah'] : "",
		 		"username" => isset($post['username']) ? $post['username'] : "",
		 		"password" => isset($post['password']) ? $post['password'] : "",
		 		"foto_jamaah" => isset($fotoName) ? $fotoName : "",
		 		"foto_ktp_jamaah" => isset($fotoKtp) ? $fotoKtp : "",
		 	);

		 
		 
		 	$this->db->insert('jamaah', $input_data);
			$status = 200;
			$msg = "Berhasil daftar. ".$msgUploadFoto.$msgUploadKtp;
		
		 	
		 }
		 return array("status"=>$status,"msg"=>$msg);
	}

	function upload_ktp_jamaah(){
		$config['upload_path'] = './assets/foto_ktp_jamaah/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '7000';
		$config['file_name'] = time();
		$error = "";
		$upload_data = array();
		$this->load->library('upload', $config, 'fotoKtpJamaah');
		$this->fotoKtpJamaah->initialize($config);
		if (!$this->fotoKtpJamaah->do_upload('foto_ktp_jamaah')){
            $error = $this->fotoKtpJamaah->display_errors();
            $upload_data = array();
        }else{
            $upload_data = $this->fotoKtpJamaah->data();
            $error = "";
        }
        return array("error"=>$error, "data" => $upload_data);
	}
	function upload_foto_jamaah(){
		$config = array();
		$config['upload_path'] = './assets/foto_jamaah/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = '7000';
		$config['file_name'] = time();
		$error = "";
		$upload_data = array();
		$this->load->library('upload', $config, 'fotoJamaah');
		$this->fotoJamaah->initialize($config);
		if (!$this->fotoJamaah->do_upload('foto_jamaah')){
            $error = $this->fotoJamaah->display_errors();
            $upload_data = array();
        }else{
            $upload_data = $this->fotoJamaah->data();
            $error = "";
        }
        return array("error"=>$error, "data" => $upload_data);
	}

}

/* End of file Mandroid.php */
/* Location: ./application/models/Mandroid.php */