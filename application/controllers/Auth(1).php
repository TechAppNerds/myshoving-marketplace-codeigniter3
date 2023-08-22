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

	public function register()
	{
		if (isset($_POST['submit1']))
		{
			//cari data existing member
			$cek  = $this->model_app->view_where('rb_konsumen',array('username'=>$this->input->post('a')))->num_rows();
			if ($cek >= 1)
			{
				$username = $this->input->post('a');
				echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
                                  window.location=('".base_url()."/auth/register')</script>";
			}
			else
			{
				$_SESSION['namalengkap']=$this->input->post('c');
				//$_SESSION['kotaid']=$this->input->post('kota');	
				$_SESSION['alamat']=$this->input->post('e');
				$_SESSION['tempatlahir']=$this->input->post('tempat_lahir');
				//$_SESSION['provinsi']=$this->input->post('state');
				$_SESSION['username']=$this->input->post('i');
				$_SESSION['kodepos']=$this->input->post('h');
				$_SESSION['ktp']=$this->input->post('k');
				$_SESSION['nohp']=$this->input->post('f');
				$_SESSION['email']=$this->input->post('g');
				$_SESSION['pass1']=$this->input->post('b');
				$_SESSION['pass2']=$this->input->post('b2');
    			$tanggal_lahir=$this->input->post('tanggal_lahir');
			
    			function ubahTanggal($tanggal)
    			{	
    				$pisah = explode('/',$tanggal);
    				$array = array($pisah[2],$pisah[1],$pisah[0]);
    				$satukan = implode('-',$array);
    				return $satukan;
    			}
    						
    			$tgl_lahir=ubahTanggal($tanggal_lahir);
    			
    			$data = array('username'=>$this->input->post('a'),
    	        			  'password'=>hash("sha512", md5($this->input->post('b'))),
    	        			  'nama_lengkap'=>$this->input->post('c'),
    	        			  'tempat_lahir'=>$this->input->post('kota_lahir'),
    	        			  'tanggal_lahir'=>$tgl_lahir,
    	        			  'email'=>$this->input->post('d'),
    	        			  'alamat_lengkap'=>$this->input->post('e'),
    	        			  'kota_id'=>$this->input->post('h'),
    	        			  'kecamatan'=>$this->input->post('i'),
    						  'no_hp'=>$this->input->post('j'),
    						  'tanggal_daftar'=>date('Y-m-d H:i:s'));
    			$this->model_app->insert('rb_konsumen',$data);
    			$id = $this->db->insert_id();
    			$this->session->set_userdata(array('id_konsumen'=>$id, 'level'=>'konsumen'));
    
    			if ($this->session->idp!=''){
    				$data = array('kode_transaksi'=>$this->session->idp,
    			        		  'id_pembeli'=>$id,
    			        		  'id_penjual'=>$this->session->reseller,
    			        		  'status_pembeli'=>'konsumen',
    			        		  'status_penjual'=>'reseller',
    			        		  'waktu_transaksi'=>date('Y-m-d H:i:s'),
    			        		  'proses'=>'0');
    				$this->model_app->insert('rb_penjualan',$data);
    				$idp = $this->db->insert_id();
    
    				$keranjang = $this->model_app->view_where('rb_penjualan_temp',array('session'=>$this->session->idp));
    				foreach ($keranjang->result_array() as $row) {
    					$dataa = array('id_penjualan'=>$idp,
    				        		   'id_produk'=>$row['id_produk'],
    				        		   'jumlah'=>$row['jumlah'],
    				        		   'harga_jual'=>$row['harga_jual'],
    				        		   'satuan'=>$row['satuan']);
    					$this->model_app->insert('rb_penjualan_detail',$dataa);
    				}
    
    				$this->db->query("DELETE FROM rb_penjualan_temp where session='".$this->session->idp."'");
    				$this->session->unset_userdata('reseller');
    				$this->session->unset_userdata('idp');
    				$this->session->set_userdata(array('idp'=>$idp));
    			}
    			redirect('members/profile');
			}
		}
		elseif (isset($_POST['submit2']))
		{ //pendaftaran pelapak
			
			//membuat post disimpan ke var session agar tidak hilang
			$_SESSION['namalengkap']=$this->input->post('c');
			//$_SESSION['kotaid']=$this->input->post('kota');	
			$_SESSION['alamat']=$this->input->post('e');
			$_SESSION['tempatlahir']=$this->input->post('tempat_lahir');
			//$_SESSION['provinsi']=$this->input->post('state');
			//$_SESSION['username']=$this->input->post('i');
			$_SESSION['kodepos']=$this->input->post('h');
			$_SESSION['ktp']=$this->input->post('k');
			$_SESSION['nohp']=$this->input->post('f');
			$_SESSION['email']=$this->input->post('g');
			$_SESSION['pass1']=$this->input->post('b');
			$_SESSION['pass2']=$this->input->post('b2');
			$_SESSION['tgl_lahir']=$this->input->post('tgl_lahir');
			
			$tanggal_lahir=$this->input->post('tgl_lahir');
					
			function ubahTanggal($tanggal)
			{	
				$pisah = explode('/',$tanggal);
				$array = array($pisah[2],$pisah[1],$pisah[0]);
				$satukan = implode('-',$array);
				return $satukan;
			}
						
			$tgl_lahir=ubahTanggal($tanggal_lahir);
						
			$cek  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('a')))->num_rows();
			if ($cek >= 1)
			{
				$username = $this->input->post('a');
				echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
                                  window.location=('".base_url()."/auth/register')</script>";
			}
			else
			{
				$route = array('administrator','agenda','auth','berita','contact','download','gallery','konfirmasi','main','members','page','produk','reseller','testimoni','video');
				if (in_array($this->input->post('a'), $route))
				{
					$username = $this->input->post('a');
					echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
	                                  window.location=('".base_url()."/".$this->input->post('i')."')</script>";
				}
				else
				{
					// Ambil Data yang Dikirim dari Form
					//$ukuran_file = $_FILES['m']['size'];
					//$tipe_file = $_FILES['m']['type'];
					$tmp_file = $_FILES['m']['tmp_name'];
					$nama_file = $_FILES['m']['name'];
					
					//Foto KTP					
					$tmp_file_ktp=$_FILES['foto_ktp']['tmp_name'];
					$nama_file_ktp=$_FILES['foto_ktp']['name'];
					
					//Set path folder tempat menyimpan gambarnya
					$path = "images/".$nama_file;
					$path2="images/ktp/".$nama_file_ktp;
					move_uploaded_file($tmp_file_ktp, $path2);
					
					if((move_uploaded_file($tmp_file, $path))||($nama_file==""))
					{			
						// mencari kode upline dari nama referral yg diinput saat pendaftaran       
						$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where username='".$this->input->post('i')."'");
						foreach ($cari_reseller->result_array() as $row)
						{
							//mencari kode upline dan level
							$reff_id_fix=$row[id_reseller]; //kode upline yang diinputkan saat pendaftaran reseller
							$parent=1;
						}
						$index_list_child=-1;
						$id_upline=$reff_id_fix;
						$list_child_id=array();
						$found=false;
						while (!$found) {												
							$cari_juml_downline=$this->db->query("SELECT * FROM rb_reseller where upline=".$id_upline);
							if ($cari_juml_downline->num_rows()==0){
								$pos_parent=$this->db->query("SELECT * FROM rb_reseller where id_reseller=".$id_upline);
								foreach ($pos_parent->result_array()  as $value) {
									$pos_upline_parent=$value["position"];
								}
								$pos_member_baru=$pos_upline_parent*2;
							}elseif ($cari_juml_downline->num_rows()==1) {
								foreach ($cari_juml_downline->result_array() as $row_juml_downline){
									$pos_member_exist=$row_juml_downline[position];
									if ($pos_member_exist%2==0) $pos_member_baru=$pos_member_exist+1;
									else $pos_member_baru=$pos_member_exist-1;
								}
							}else{
								foreach ($cari_juml_downline->result_array() as $row_juml_downline){
									$id_member_exist=$row_juml_downline[id_reseller];
									array_push($list_child_id,$id_member_exist);
								}
								$id_upline=$list_child_id[++$index_list_child];								
							}
							if (!empty($pos_member_baru)) {
								$jum_pos=$this->db->query("SELECT * FROM posisi where posisi.posisi=".$pos_member_baru);
								foreach ($jum_pos->result_array() as $value) {
									if($value["ket"]==0) $found=true;
								}
							}							
						}
						if ($found) {
							$kode_upline_fix=$id_upline;
							$refferal_fix=$this->input->post('i');
							$data = array('username'=>$this->input->post('a'),
										'password'=>hash("sha512", md5($this->input->post('b'))),
										'nama_reseller'=>$this->input->post('c'),
										'nama_ktp'=>$this->input->post('ktp'),
										'jenis_kelamin'=>$this->input->post('d'),
										'tempat_lahir'=>$this->input->post('tempat_lahir'),
										'tgl_lahir'=>$tgl_lahir,
										'kota_id'=>$this->input->post('kota'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'kode_pos'=>$this->input->post('h'),
										'no_ktp'=>$this->input->post('k'),
										'foto_ktp'=>$nama_file_ktp,
										'bank'=>$this->input->post('bank'),
										'norek_tabungan'=>$this->input->post('l'),
										'referral'=>$refferal_fix,
										'buku_tabungan'=>$nama_file,				  
										'parent_id'=>$parent,
										'upline'=>$kode_upline_fix,
										'reff_work'=>$reff_id_fix,
										'position'=>$pos_member_baru,
										'tanggal_daftar'=>date('Y-m-d H:i:s'));
							$this->model_app->insert('rb_reseller',$data);
									
							//update di tabel posisi untuk posisi member yg baru join bahwa sudah terisi
						
							$this->db->query("update posisi set ket=1 where posisi=".$pos_member_baru);
							
							//mencari nomor id reseller untuk ditampilkan
							$cari_member_barusan=$this->db->query("SELECT * FROM rb_reseller where username='".$this->input->post('a')."'");
							if ($cari_member_barusan->num_rows()==1)	//----> jika terdapat data
							{
								foreach ($cari_member_barusan->result_array() as $row_baru_daftar)
								{
									$id_baru_daftar=$row_baru_daftar[id_reseller];
								}							
							}
							
							echo "<script type='text/javascript'>
									alert('Member ".$this->input->post('a')." dengan ID Member : ".$id_baru_daftar." berhasil ditambahkan !');
									</script>";
							$id = $this->db->insert_id();
							$this->session->set_userdata(array('id_reseller'=>$id, 'level'=>'reseller'));
						}
						//$this->InsertMember($parent,$reff_id_fix,$id_upline,$index_list_child,$list_child_id);
					}					
					// //redirect('reseller/logout');
					echo "<script>window.location='".base_url()."auth/register';
						  </script>";
				}
			}
		}
		else
		{
			$data['title'] = 'Formulir Pendaftaran';
			$data['provinsi'] = $this->model_app->view_ordering('rb_provinsi','provinsi_id','ASC');
			$this->template->load(template().'/template',template().'/reseller/view_register',$data);
		}
		
	}

	public function login()
	{
		if (isset($_POST['login']))
		{
			$username = strip_tags($this->input->post('a'));
			$password = hash("sha512", md5(strip_tags($this->input->post('b'))));
			$cek = $this->db->query("SELECT * FROM rb_konsumen where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");			   
		    $total = $cek->num_rows();
		    $cek1 = $this->db->query("SELECT * FROM rb_reseller where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
			$total1 = $cek1->num_rows();
			$row = $cek->row_array();
			if ($total > 0 || $total1 > 0) //jika ada data, berarti berhasil login
			{
				$this->session->set_userdata(array('id_konsumen'=>$row['id_konsumen'], 'level'=>'konsumen'));
				if ($this->session->idp!=''){
					$data = array('kode_transaksi'=>$this->session->idp,
		        			  'id_pembeli'=>$row['id_konsumen'],
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
					$this->db->query("DELETE FROM rb_penjualan_temp where session='".$this->session->idp."'");

					$this->session->unset_userdata('reseller');
					$this->session->unset_userdata('idp');
					$this->session->set_userdata(array('idp'=>$id));
				}
				redirect('members/profile');
			}
			else //jika gagal login
			{
				$data['title'] = 'Username atau password salah';
				//$this->template->load('phpmu-one/template','phpmu-one/view_login_error',$data);
				$this->template->load(template().'/template',template().'/reseller/view_login_error',$data);
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