<?php
/*
-- ---------------------------------------------------------------
-- MARKETPLACE MULTI BUYER MULTI SELLER + SUPPORT RESELLER SYSTEM
-- CREATED BY : ROBBY PRIHANDAYA
-- COPYRIGHT  : Copyright (c) 2018 - 2019, PHPMU.COM. (https://phpmu.com/)
-- LICENSE    : http://opensource.org/licenses/MIT  MIT License
-- CREATED ON : 2019-03-26
-- UPDATED ON : 2019-03-27
-- ---------------------------------------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller 
{
	function city()
	{
		$state_id = $this->input->post('stat_id');
		$data['kota'] = $this->db->select("*")->from('rb_kota')->where('provinsi_id',$state_id)->group_by("nama_kota")->get()->result_array();
		$this->load->view(template().'/reseller/view_city',$data);		
	}

	function CheckUsername()
	{
		$cek  = $this->model_app->view_where('rb_referral',array('username'=>$this->input->post('username')))->num_rows();
		$cekm  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('username')))->num_rows();
		if ($cek >= 1 OR $cekm >= 1) {
			echo "Username ".$this->input->post('username')." sudah dipakai";
		}
	}

	function CheckReff()
	{
		$cek  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('referral')))->num_rows();
		if ($cek <= 0) {
			$cek  = $this->model_app->view_where('rb_referral',array('username'=>$this->input->post('referral')))->num_rows();
			if ($cek <= 0) echo "Referral ".$this->input->post('referral')." tidak terdaftar";
		}
	}

	public function register()
	{
		if (isset($_POST['submit2']))
		{
			echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
                <script type="text/javascript" src="http://www.myshoving.com//asset/admin/plugins/jQuery/jquery-1.12.3.min.js"></script>';
			$cek  = $this->model_app->view_where('rb_referral',array('username'=>$this->input->post('a')))->num_rows();
			$cekm  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('a')))->num_rows();			
			if ($cek >= 1 OR $cekm >= 1) {
				echo "<script>
				$(document).ready(function(){
					swal({                
	                    text: 'Maaf, Username ".$this->input->post('a')." sudah dipakai oleh orang lain!',
	                    type: 'error',
	                }).then(()=>{
                      	window.location.href='".base_url()."auth/register?userid=".$this->input->post("userid")."';
                  	});
	            });
              	</script>";
			} else {
				$cekmitra = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('i')))->num_rows();
				if ($cekmitra < 1) {
					echo "<script>
	                $(document).ready(function(){
						swal({                
		                    text: 'Maaf, Referral Username ".$this->input->post('i')." tidak terdaftar!',
		                    type: 'error',
		                }).then(()=>{
	                      	window.location.href='".base_url()."auth/register?userid=".$this->input->post("userid")."';
	                  	});
		            });
		            </script>";
				}else{
					$data = array('username'=>$this->input->post('a'),
								'password'=>hash("sha512", md5($this->input->post('b'))),
								'no_telpon'=>$this->input->post('f'),
								'referral'=>$this->input->post('i'),
								'tanggal_daftar'=>date('Y-m-d H:i:s'));
					$this->model_app->insert('rb_referral',$data);					
					$cek = $this->db->query("SELECT * FROM rb_referral where id_reseller='".$this->db->insert_id()."'");
					if (isset($cek)){
						$row = $cek->row_array();
				    	$total = $cek->num_rows();
				    	if ($total > 0) {
				    		$this->session->set_userdata(array('id_reseller'=>$row['id_reseller'],
				    											'username'=>$row['username'],
				    											'reff'=>1,
				    											'pass_reff'=>$this->input->post('b')));
							echo "<script>window.location.href='".base_url()."reseller/home';</script>";
						}
					}
				}
			}
		}
		else
		{
			// $data['title'] = 'Formulir Pendaftaran';
			$this->template->load(template().'/template',template().'/reseller/view_register');
		}
		
	}

	function login()
	{
		if (isset($_POST['login']))
		{
			$nego = 0;
			if(isset($this->session->nego_temp)){
				$nego=1;
			}
			$username = strip_tags($this->input->post('a'));
			$password = hash("sha512", md5(strip_tags($this->input->post('b'))));
			$cek = $this->db->query("SELECT * FROM `rb_reseller` where `username`='".$this->db->escape_str($username)."' AND `password`='".$this->db->escape_str($password)."'");
		    $total = $cek->num_rows();
		    $cek1 = $this->db->query("SELECT * FROM `rb_referral` where `username`='".$this->db->escape_str($username)."' AND `password`='".$this->db->escape_str($password)."'");
		    $total1 = $cek1->num_rows();
		    if ($total >= 1) $row = $cek->row_array();
		    elseif ($total1 >= 1) $row = $cek1->row_array();
		    else{
		    	$data['title'] = 'User Login';
		    	echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password Salah</center></div>');
				$this->template->load(template().'/template',template().'/reseller/view_login',$data);
		    }
		    if($nego == 1){
		    	$this->load->helper('date');
		    	if ($total > 0 OR $total1 > 0) {
		    		$this->session->set_userdata(array('id_konsumen'=>$row['id_reseller'], 
											    	   'level'=>'konsumen',
											    	   'id_reseller'=>$row['id_reseller'],
													   'username'=>$row['username'],
													   'pass_reff'=>$this->input->post('b'),
													   'reff'=>$total > 0 ? 0 : 1));
			    	$data_nego = $this->model_reseller->get_nego_temp($this->session->nego_temp);
			    	$format = "%Y-%m-%d";
			    	$today = mdate($format);
			    	$data =[
				        'id_pembeli' => $row['id_reseller'],
				        'id_penjual' => $data_nego['id_penjual'],
				        'id_produk' => $data_nego['id_produk'],
				        'jumlah' => $data_nego['jumlah'],
				        'harga_jual' => $data_nego['harga_jual'],
				        'satuan' => $data_nego['satuan'],
	        			'tanggal_pengajuan' => $today
				    ]; 
					$this->model_reseller->insert_nego($data);
					$this->session->id_reseller=$this->session->id_konsumen;
					redirect('produk/detail');
		    	}
		    }
		    else{
			    if ($total > 0 OR $total1 > 0) {
			    	$this->session->set_userdata(array('id_konsumen'=>$row['id_reseller'], 
											    	   'level'=>'konsumen',
											    	   'id_reseller'=>$row['id_reseller'],
													   'username'=>$row['username'],
													   'pass_reff'=>$this->input->post('b'),
													   'reff'=>$total > 0 ? 0 : 1));
					if ($this->session->idp!=''){
						$data = array('kode_transaksi'=>$this->session->idp,
				        			  'id_pembeli'=>$row['id_reseller'],
				        			  'id_penjual'=>$this->session->reseller,
				        			  'status_pembeli'=>'konsumen',
				        			  'status_penjual'=>'reseller',
				        			  'waktu_transaksi'=>date('Y-m-d H:i:s'),
				        			  'proses'=>'0');
						$this->model_app->insert('rb_penjualan',$data);
						$id = $this->db->insert_id();
						$query_temp = $this->db->query("SELECT * FROM rb_penjualan_temp where session='".$this->session->idp."'");
						foreach ($query_temp->result_array() as $r) {
							$data = array('id_penjualan'=>$id,
					        			  'id_produk'=>$r['id_produk'],
					        			  'jumlah'=>$r['jumlah'],
					        			  'diskon'=>$r['diskon'],
					        			  'harga_jual'=>$r['harga_jual'],
					        			  'satuan'=>$r['satuan']);
							$this->model_app->insert('rb_penjualan_detail',$data);
						}
						// $this->db->query("DELETE FROM rb_penjualan_temp where session='".$this->session->idp."'");
						// $this->session->unset_userdata('reseller');
						// $this->session->unset_userdata('idp');
						$this->session->set_userdata(array('idpenjualan'=>$id));
						$this->session->id_reseller=$this->session->id_konsumen;
					}
					redirect('members/keranjang');
			    }
			}
		}
		else
		{
			$data['title'] = 'User Login';
			$this->template->load(template().'/template',template().'/reseller/view_login',$data);
		}
	}

	public function lupass()
	{
		if (isset($_POST['lupa'])){
			$email = strip_tags($this->input->post('a'));
			$cek = $this->db->query("SELECT * FROM rb_konsumen where email='".$this->db->escape_str($email)."'");
		    $row = $cek->row_array();
		    $total = $cek->num_rows();
			if ($total > 0){
				$identitas = $this->db->query("SELECT * FROM identitas where id_identitas='1'")->row_array();
				$randompass = generateRandomString(10);
				$passwordbaru = hash("sha512", md5($randompass));
				$this->db->query("UPDATE rb_konsumen SET password='$passwordbaru' where email='".$this->db->escape_str($email)."'");

				if ($row['jenis_kelamin']=='Laki-laki'){ $panggill = 'Bpk.'; }else{ $panggill = 'Ibuk.'; }
				$email_tujuan = $row['email'];
				$tglaktif = date("d-m-Y H:i:s");
				$subject      = 'Permintaan Reset Password ...';
				$message      = "<html><body>Halooo! <b>$panggill ".$row['nama_lengkap']."</b> ... <br> Hari ini pada tanggal <span style='color:red'>$tglaktif</span> Anda Mengirimkan Permintaan untuk Reset Password
					<table style='width:100%; margin-left:25px'>
		   				<tr><td style='background:#337ab7; color:#fff; pading:20px' cellpadding=6 colspan='2'><b>Berikut Data Informasi akun Anda : </b></td></tr>
						<tr><td><b>Nama Lengkap</b></td>			<td> : ".$row['nama_lengkap']."</td></tr>
						<tr><td><b>Alamat Email</b></td>			<td> : ".$row['email']."</td></tr>
						<tr><td><b>No Telpon</b></td>				<td> : ".$row['no_hp']."</td></tr>
						<tr><td><b>Jenis Kelamin</b></td>			<td> : ".$row['jenis_kelamin']." </td></tr>
						<tr><td><b>Tempat Lahir</b></td>				<td> : ".$row['tempat_lahir']." </td></tr>
						<tr><td><b>Tanggal Lahir</b></td>			<td> : ".$row['tanggal_lahir']." </td></tr>
						<tr><td><b>Alamat Lengkap</b></td>			<td> : ".$row['alamat_lengkap']." </td></tr>
						<tr><td><b>Waktu Daftar</b></td>			<td> : ".$row['tanggal_daftar']."</td></tr>
					</table>
					<br> Username Login : <b style='color:red'>$row[username]</b>
					<br> Password Login : <b style='color:red'>$randompass</b>
					<br> Silahkan Login di : <a href='$identitas[url]'>$identitas[url]</a> <br>
					Admin, $identitas[nama_website] </body></html> \n";
				
				$this->email->from($identitas['email'], $identitas['nama_website']);
				$this->email->to($email_tujuan);
				$this->email->cc('');
				$this->email->bcc('');

				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$this->email->send();
				
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$this->email->initialize($config);

				$data['email'] = $email;
				$data['title'] = 'Permintaan Reset Password Sudah Terkirim...';
				$this->template->load('phpmu-one/template','phpmu-one/view_lupass_success',$data);
			}else{
				$data['email'] = $email;
				$data['title'] = 'Email Tidak Ditemukan...';
				$this->template->load('phpmu-one/template','phpmu-one/view_lupass_error',$data);
			}
		}
	}

}