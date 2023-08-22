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
class Reseller extends CI_Controller {
	function __construct() {
		parent::__construct();
		// if (!$this->session->id_reseller) {
		// 	echo "<script>window.alert('Maaf, Waktu Anda Sudah Habis. Silahkan Login Kembali');</script>";
		// 	$this->logout();
		// }
	}
	function index()  //jika tombol login ditekan
	{
		if (isset($_POST['submit']))
		{
			$username = $this->input->post('a');
			$password = hash("sha512", md5($this->input->post('b')));
			$table="rb_reseller";
			$cek = $this->db->query("SELECT * FROM ".$table." where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
			if ($cek->num_rows() == 0) {
				$table="rb_referral";
				$cek = $this->db->query("SELECT * FROM ".$table." where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
			}
			if (isset($cek)){
				$row = $cek->row_array();
		    	$total = $cek->num_rows();
		    	if ($total > 0) {
		    		$this->session->set_userdata(array('id_reseller'=>$row['id_reseller'],
													   'username'=>$row['username'],
													   // 'level'=>'reseller',
													   'pass_reff'=>$this->input->post('b'),
													   'reff'=>$table == "rb_reseller" ? 0 : 1));
					redirect('reseller/home');
				}
				else
				{
					//$data['title'] = 'Pelapak &rsaquo; Log In';
					$data['titlelogin'] = "<div class='alert alert-danger'>User name atau password salah atau status user masih belum aktif. Jika memang belum aktif silakan selesaikan pembayaran dahulu</div>";
					$this->load->view('reseller/view_login',$data);
				}
			}else{
				// echo "
				// <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css'>
				// <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js'></script>
				// <script>Swal.fire({
				//                 title: 'Mohon memilih jenis member terlebih dahulu',
				//                 type: 'warning',
				//             });</script>";
	            $data['titlelogin'] = "<div class='alert alert-danger'>Mohon memilih jenis member terlebih dahulu</div>";
				$this->load->view('reseller/view_login',$data);
			}
			/*$cek = $this->db->query("SELECT * FROM rb_reseller where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."' AND blokir='Y'");
			$total = $cek->num_rows();
			if ($total > 0) //jika ada data berarti blokir 'Y' dan login ditolak
			{
				//$data['title'] = 'Pelapak &rsaquo; Log In';
				$data['title'] = 'Tidak berhasil login dikarenakan status user masih terblokir, silakan selesaikan pembayaran dahulu; Log In';				
				$this->load->view('reseller/view_login',$data);
			}*/		
		}
		else
		{
			$data['titlelogin'] = 'Login';
			$this->load->view('reseller/view_login',$data);           
		}
	}
    function akuntoko()
    {
         $session = $this->session->userdata('reff');
        if($session==0||$session==1)
        {
           $data['record'] = $this->model_app->view_where_ordering('history_produk',array('id_reseller'=>$this->session->id_reseller),'id_produk','DESC');
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_produk/view_history_produk',$data);
        }
    }
    function historypembelian()
    {
         $session = $this->session->userdata('reff');
        if($session==0||$session==1)
        {
            cek_session_reseller_timeout();
            $this->session->unset_userdata('idp');
            $id = $this->session->id_reseller;
            $data['record'] = $this->model_reseller->history_penjualan_list_konsumen($id,'reseller');
           // $data['record'] = $this->model_reseller->penjualan_list_konsumen($id,'reseller');
            $this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/mod_penjualan/view_history_penjualan_produk',$data);
        }
    }
     function testi()
    {
        $session = $this->session->userdata('reff');
        if($session==0||$session==1)
        {
           
           $data['record'] = $this->model_reseller->testimonial();
            $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_produk/view_testimoni',$data);
        }
    }
    function insert_testimoni()
    {
        $session = $this->session->userdata('reff');
        if($session==0||$session==1)
        {   
            $id_transaksi=$this->uri->segment(3);
            $id_pelanggan="";
            $tanggal=date('Y-m-d H:i:s');
             $query = $this->db->query("SELECT id_pembeli FROM history_penjualan where id_penjualan ='$id_transaksi'");
                        foreach ($query->result_array() as $row){
                            $id_pelanggan=$row['id_pembeli'];
                        }
            $rating = $this->input->post('rating');
            $star = $this->input->post('star');
            if($rating=='3')
            {
              $isi_testimoni = $this->input->post('testimoni');  
            }else if($rating=='2')
            {
                $isi_testimoni = $this->input->post('testimoni2'); 
            }else if($rating=='1')
            {
                $isi_testimoni = $this->input->post('testimoni3'); 
            }
            
            $id_barang="";
            $query2 = $this->db->query("SELECT id_produk FROM history_penjualan_detail where id_penjualan ='$id_transaksi'");
                        foreach ($query2->result_array() as $row2){
                            $id_barang=$row2['id_produk'];
                            $this->model_reseller->insert_testimonial($id_pelanggan, $id_barang,$isi_testimoni,$rating,$tanggal,$star,$id_transaksi); 
                        }
            
            header('Location: '."http://www.myshoving.com/reseller/historypembelian");
        }
    }
    function detail_history_pembelian(){
		cek_session_reseller_timeout();
		$data['rows'] = $this->model_reseller->penjualan_konsumen_detail_reseller($this->uri->segment(3))->row_array();
		$data['record'] = $this->model_app->view_join_where('history_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','DESC');
		$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/mod_penjualan/view_history_penjualan_detail',$data);
	}
    function detail_history_penjualan(){
		cek_session_reseller_timeout();
		$data['rows'] = $this->model_reseller->penjualan_konsumen_detail_reseller($this->uri->segment(3))->row_array();
		$data['record'] = $this->model_app->view_join_where('history_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','DESC');
		$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/mod_penjualan/view_history_penjualan_detail',$data);
	}
    function akunpembeli()
    {
        cek_session_reseller_timeout();
		if (isset($this->session->id_reseller)) {
			$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/view_consumer');
		}	
//         $session = $this->session->userdata('reff');
//        if($session==0||$session==1)
//        {
//            cek_session_reseller_timeout();
//            $this->session->unset_userdata('idp');
//            $id = $this->session->id_reseller;
//            $data['record'] = $this->model_reseller->history_penjualan_list_konsumen($id,'reseller');
//            $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_penjualan/view_history_penjualan_produk',$data);
//        }
        
    }
    function edit_consumer(){
		cek_session_reseller_timeout();
		if (isset($this->session->id_reseller)) {
			$id = $this->session->id_reseller;
			//jika tombol update ditekan
			if (isset($_POST['submit']))
			{
				$config['upload_path'] = 'asset/foto_user/';
	            $config['allowed_types'] = 'gif|jpg|png|jpeg';
	            $config['max_size'] = '5000'; // kb
	            $this->load->library('upload', $config);
	            $this->upload->do_upload('gg');
	            $hasil=$this->upload->data();
	            
				$tmp_file = $_FILES['s']['tmp_name'];
				$nama_file = $_FILES['s']['name'];
				//Set path folder tempat menyimpan gambarnya
				$path = "images/".$nama_file;
				
				if(move_uploaded_file($tmp_file, $path) || $hasil['file_name']=="")
				{
					//---------- jika file foto kosong -----------
					if ($hasil['file_name']=='')
					{
						//jika password tidak kosong
						if (trim($this->input->post('b')) != '')
						{
							
								$data = array('password'=>hash("sha512", md5($this->input->post('b'))),
										'nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										//'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
						//jika password kosong
						else
						{
						   $data = array('nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										//'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
					}
					//------- jika file foto tidak kosong -----------
					else
					{
						//jika password tidak kosong
						if (trim($this->input->post('b')) != ''){
							$data = array('password'=>hash("sha512", md5($this->input->post('b'))),
										'nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										'foto'=>$hasil['file_name'],
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
						//jika password kosong
						else
						{
						   $data = array('nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										'foto'=>$hasil['file_name'],
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
					}
					$where = array('id_reseller' => $this->input->post('id'));
					if ($this->session->userdata("reff")==0) {
						$this->model_app->update('rb_reseller', $data, $where);
					}else{
						$this->model_app->update('rb_referral', $data, $where);
					}				
					redirect($this->uri->segment(1).'/detail_reseller');
				}
			}
			else
			{
				if ($this->session->userdata("reff")==0) {
					$edit = $this->model_app->edit('rb_reseller',array('id_reseller'=>$id))->row_array();
				}else{
					$edit = $this->model_app->edit('rb_referral',array('id_reseller'=>$id))->row_array();
				}
				
				$data = array('rows' => $edit);
				$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/mod_reseller/view_reseller_edit',$data);
			}
		}
	}
	function ref(){
		if (isset($_POST['submit2'])){
			$cek  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('a')))->num_rows();	
			if ($cek >= 1){
				$username = $this->input->post('a');
				echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
                                  window.location=('".base_url()."/".$this->input->post('i')."')</script>";
			}else{
				$route = array('administrator','agenda','auth','berita','contact','download','gallery','konfirmasi','main','members','page','produk','reseller','testimoni','video');
				if (in_array($this->input->post('a'), $route)){
					$username = $this->input->post('a');
					echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
	                                  window.location=('".base_url()."/".$this->input->post('i')."')</script>";
				}else{
				$data = array('username'=>$this->input->post('a'),
		        			  'password'=>hash("sha512", md5($this->input->post('b'))),
		        			  'nama_reseller'=>$this->input->post('c'),
		        			  'jenis_kelamin'=>$this->input->post('d'),
		        			  'alamat_lengkap'=>$this->input->post('e'),
		        			  'no_telpon'=>$this->input->post('f'),
							  'email'=>$this->input->post('g'),
							  'kode_pos'=>$this->input->post('h'),
							  'referral'=>$this->input->post('i'),
							  'tanggal_daftar'=>date('Y-m-d H:i:s'));
				$this->model_app->insert('rb_reseller',$data);
				$id = $this->db->insert_id();
				$this->session->set_userdata(array('id_reseller'=>$id, 'level'=>'reseller'));
				$identitas = $this->model_app->view_where('identitas',array('id_identitas'=>'1'))->row_array();

				$ref = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('i')))->row_array();
				$email_tujuan = $ref['email'];
				$tglaktif = date("d-m-Y H:i:s");
				$subject      = 'Pendaftaran Sebagai Reseller Berhasil...';

				$message      = "<html><body>Selamat, Pada Hari ini tanggal $tglaktif<br> Bpk/Ibk <b>".$this->input->post('c')."</b> Sukses Mendafatar Sebagai reseller dengan referral <b>".$ref['nama_reseller']."</b>...";
				$message      .= "<table style='width:100%; margin-left:25px'>
		   				<tr><td style='background:#337ab7; color:#fff; pading:20px' cellpadding=6 colspan='2'><b>Berikut Informasi akun : </b></td></tr>
						<tr><td><b>Nama Reseller</b></td>			<td> : ".$this->input->post('c')."</td></tr>
						<tr><td><b>Alamat Email</b></td>			<td> : ".$this->input->post('g')."</td></tr>
						<tr><td><b>No Telpon</b></td>				<td> : ".$this->input->post('f')."</td></tr>
						<tr><td><b>Jenis Kelamin</b></td>			<td> : ".$this->input->post('d')." </td></tr>
						<tr><td><b>Alamat Lengkap</b></td>			<td> : ".$this->input->post('e')." </td></tr>
						<tr><td><b>Kode Pos</b></td>				<td> : ".$this->input->post('h')." </td></tr>
						<tr><td><b>Waktu Daftar</b></td>			<td> : ".date('Y-m-d H:i:s')."</td></tr>
					</table><br>

					Admin, $identitas[nama_website] </body></html> \n";
				
				$this->email->from($identitas['email'], $identitas['nama_website']);
				$this->email->to($email_tujuan,$this->input->post('g'));
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

				redirect($this->uri->segment(1).'/home');
				}
			}
		}
	}

	function home(){
		// $_SESSION["reff"]=$_GET["reff"];
		// $this->session->set_userdata('reff', $_GET["reff"]);
		cek_session_reseller_timeout();
		if (isset($this->session->id_reseller)) {
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/view_home');
		}		
	}


	function edit_reseller(){
		cek_session_reseller_timeout();
		if (isset($this->session->id_reseller)) {
			$id = $this->session->id_reseller;
			//jika tombol update ditekan
			if (isset($_POST['submit']))
			{
				$config['upload_path'] = 'asset/foto_user/';
	            $config['allowed_types'] = 'gif|jpg|png|jpeg';
	            $config['max_size'] = '5000'; // kb
	            $this->load->library('upload', $config);
	            $this->upload->do_upload('gg');
	            $hasil=$this->upload->data();
	            
				$tmp_file = $_FILES['s']['tmp_name'];
				$nama_file = $_FILES['s']['name'];
				//Set path folder tempat menyimpan gambarnya
				$path = "images/".$nama_file;
				
				if(move_uploaded_file($tmp_file, $path) || $hasil['file_name']=="")
				{
					//---------- jika file foto kosong -----------
					if ($hasil['file_name']=='')
					{
						//jika password tidak kosong
						if (trim($this->input->post('b')) != '')
						{
							
								$data = array('password'=>hash("sha512", md5($this->input->post('b'))),
										'nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										//'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
						//jika password kosong
						else
						{
						   $data = array('nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										//'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
					}
					//------- jika file foto tidak kosong -----------
					else
					{
						//jika password tidak kosong
						if (trim($this->input->post('b')) != ''){
							$data = array('password'=>hash("sha512", md5($this->input->post('b'))),
										'nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										'foto'=>$hasil['file_name'],
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
						//jika password kosong
						else
						{
						   $data = array('nama_reseller'=>$this->input->post('c'),
										'jenis_kelamin'=>$this->input->post('d'),
										'alamat_lengkap'=>$this->input->post('e'),
										'no_telpon'=>$this->input->post('f'),
										'email'=>$this->input->post('g'),
										'no_ktp'=>$this->input->post('o'),
										'norek_tabungan'=>$this->input->post('r'),
										'buku_tabungan'=>$nama_file,
										'kode_pos'=>$this->input->post('h'),
										'keterangan'=>$this->input->post('i'),
										'foto'=>$hasil['file_name'],
										//'referral'=>$this->input->post('k'),
										'kota_id'=>$this->input->post('kota'));
						}
					}
					$where = array('id_reseller' => $this->input->post('id'));
					if ($this->session->userdata("reff")==0) {
						$this->model_app->update('rb_reseller', $data, $where);
					}else{
						$this->model_app->update('rb_referral', $data, $where);
					}				
					redirect($this->uri->segment(1).'/detail_reseller');
				}
			}
			else
			{
				if ($this->session->userdata("reff")==0) {
					$edit = $this->model_app->edit('rb_reseller',array('id_reseller'=>$id))->row_array();
				}else{
					$edit = $this->model_app->edit('rb_referral',array('id_reseller'=>$id))->row_array();
				}
				
				$data = array('rows' => $edit);
				$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_edit',$data);
			}
		}
	}
	function detail_reseller(){
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		if ($this->session->userdata("reff")==0) {
			$edit = $this->model_app->edit('rb_reseller',array('id_reseller'=>$id))->row_array();
		}else{
			$edit = $this->model_app->edit('rb_referral',array('id_reseller'=>$id))->row_array();
		}		
		$data = array('rows' => $edit);
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_detail',$data);
	}

	//untuk menampilkan network list by parent id
	function network_list()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_network_list',$data);
	}
	
	//untuk menampilkan network list by downline langsung
	function network_list2()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		$lihat = $this->model_app->view_where('rb_reseller',array('upline'=>$id))->row_array();
		$data = array('rows' => $lihat);
        // $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_network_list2',$data);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_network_list_tree',$data);
	}
	
	function network_list3()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		$lihat = $this->model_app->view_where('rb_reseller',array('upline'=>$id))->row_array();
		$data = array('rows' => $lihat);
        // $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_network_list2',$data);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_referral_tree',$data);
	}

	function penarikan_dana()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/penarikan_dana',$data);
	}
	
	function mutasi_perusahaan()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_mutasi_perusahaan',$data);
	}
	
	function alokasi_member()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_alokasi_perjoin',$data);
	}
	
	function alokasi_penampungan()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_mutasi_penampungan',$data);
	}
	
	function update_tarik()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/update_tarik',$data);
	}
	
	function cek_transfer()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/cek_transfer',$data);
	}
	
	function create_voucher()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/create_voucher',$data);
	}

	function register_mitra()
	{
		cek_session_reseller_timeout();
		if (isset($this->session->id_reseller)) {
			if(isset($_POST['registermitra'])) 
		    {
		        //membuat post disimpan ke var session agar tidak hilang
				$_SESSION['namalengkap']=$this->input->post('namalengkap');
				$_SESSION['alamat']=$this->input->post('alamat');
				$_SESSION['tempatlahir']=$this->input->post('tempat_lahir');
				$_SESSION['field_username']=$this->input->post('username');
				$_SESSION['kodepos']=$this->input->post('kodepos');
				// $_SESSION['ktp']=$this->input->post('noktp');
				$_SESSION['nohp']=$this->input->post('nohp');
				$_SESSION['email']=$this->input->post('email');
				$_SESSION['pass1']=$this->input->post('pass');
				$_SESSION['pass2']=$this->input->post('cpass');
				$_SESSION['tgl_lahir']=$this->input->post('tgl_lahir');
				if($this->input->post('qty')) $this->session->jumlah=$this->input->post('qty');
				// $jumlah=$this->input->post($_SESSION['jumlah']==""?'qty':'counter');
				$jumlah=$this->input->post($this->input->post('qty')?'qty':'counter');
				// if (isset($this->input->post('qty'))) {
				// 	$this->session->jumlah=$this->input->post('qty');
				// }

				//jika $_SESSION['jumlah'] kosong maka $jumlah diisi dengan qty daftar
				// echo "<script>alert('".$this->session->jumlah."')</script>";
				if($this->session->jumlah=="") 
				{
					//$this->session->jumlah=$this->input->post('qty');
					// if(($jumlah==3)||($jumlah==7))
					// {
					// 	//$counter=1;
					// 	$_SESSION['reff_name']=$this->input->post('username');
					// }
				}
				// else
				// {
				// 	$jumlah=$_SESSION['jumlah'];
				// }


				$tanggal_lahir=$this->input->post('tgl_lahir');
						
				function ubahTanggal($tanggal)
				{	
					$pisah = explode('/',$tanggal);
					$array = array($pisah[2],$pisah[1],$pisah[0]);
					$satukan = implode('-',$array);
					return $satukan;
				}
							
				$tgl_lahir=ubahTanggal($tanggal_lahir);

				echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
                <script type="text/javascript" src="http://www.myshoving.com//asset/admin/plugins/jQuery/jquery-1.12.3.min.js"></script>';	
				$cek  = $this->model_app->view_where('rb_reseller',array('username'=>$this->input->post('username')))->num_rows();
				if ($cek >= 1)
				{
					$username = $this->input->post('username');
					// echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
	    //                               window.location=('".base_url()."/Reseller/register_mitra')</script>";
					$this->session->ctrreg=$jumlah;
					echo "<script>
                    $(document).ready(function(){
						swal({                
		                    text: 'Maaf, Username $username sudah dipakai oleh orang lain!',
		                    type: 'error',
		                }).then(()=>{
	                      	window.location.href='".base_url()."reseller/register_mitra".($jumlah!=""?"?no=".$jumlah:"")."';
	                  	});
		            });
                  	</script>";                  	
                      // echo "<script>window.location='".base_url()."reseller/register_mitra?no=".$jumlah."';</script>";
				}
				else
				{
					$route = array('administrator','agenda','auth','berita','contact','download','gallery','konfirmasi','main','members','page','produk','reseller','testimoni','video');
					if (in_array($this->input->post('username'), $route))
					{
						$username = $this->input->post('username');
						// echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
		    //                               window.location=('".base_url()."/".$this->input->post('reffus')."')</script>";
						// echo "<script>window.alert('Maaf, Username $username sudah dipakai oleh orang lain!');
		    //                               window.location=('http://www.myshoving.com/reseller/register_mitra')</script>";
                    	$this->session->ctrreg=$jumlah;
                    	echo "<script>
                        $(document).ready(function(){
							swal({                
			                    text: 'Maaf, Username $username sudah dipakai oleh orang lain!',
			                    type: 'error',
			                }).then(()=>{
		                      	window.location.href='".base_url()."reseller/register_mitra".($jumlah!=""?"?no=".$jumlah:"")."';
		                  	});
			            });
						</script>";						
					}
					else
					{
						// Ambil Data yang Dikirim dari Form
						//$ukuran_file = $_FILES['m']['size'];
						//$tipe_file = $_FILES['m']['type'];
						
						//cek data posisi di tabel referral
						$cari_last_pos = $this->db->query("SELECT * FROM rb_referral where referral='".$this->input->post('reffus')."' order by position desc limit 1")->row_array();
						$last_posisi=$cari_last_pos['position']+1;
						
						//foto buku tabungan
						$tmp_file = $_FILES['bukutab']['tmp_name'];
						$nama_file = $_FILES['bukutab']['name'];
						
						//Set path folder tempat menyimpan foto butab
						$path = "images/".$nama_file;
						move_uploaded_file($tmp_file, $path);
						
						//Foto KTP					
						$tmp_file_ktp=$_FILES['foto_ktp']['tmp_name'];
						$nama_file_ktp=$_FILES['foto_ktp']['name'];
						
						//Set path folder tempat menyimpan foto ktp
						$path2="images/ktp/".$nama_file_ktp;
						
						if((move_uploaded_file($tmp_file_ktp, $path2))||($nama_file==""))
						{
							// if($this->input->post('v')==''){
							// 	$cari_reseller = $this->db->query("SELECT * FROM rb_referral where username='".$this->input->post('username')."'");
							// 	if ($cari_reseller->num_rows() < 1) {
							// 		$data = array('username'=>$this->input->post('username'),
							// 					'password'=>hash("sha512", md5($this->input->post('pass'))),
							// 					'nama_reseller'=>$this->input->post('namalengkap'),
							// 					'nama_ktp'=>$this->input->post('namaktp'),
							// 					'jenis_kelamin'=>$this->input->post('jk'),
							// 					'tempat_lahir'=>$this->input->post('tempat_lahir'),
							// 					'tgl_lahir'=>$tgl_lahir,
							// 					'kota_id'=>$this->input->post('kota'),
							// 					'alamat_lengkap'=>$this->input->post('alamat'),
							// 					'no_telpon'=>$this->input->post('nohp'),
							// 					'email'=>$this->input->post('email'),
							// 					'kode_pos'=>$this->input->post('kodepos'),
							// 					'no_ktp'=>$this->input->post('noktp'),
							// 					'foto_ktp'=>$nama_file_ktp,
							// 					'bank'=>$this->input->post('namabank'),
							// 					'norek_tabungan'=>$this->input->post('norek'),
							// 					'referral'=>$this->input->post('reffus'),
							// 					'buku_tabungan'=>$nama_file,
							// 					'position'=>$last_posisi,
							// 					'tanggal_daftar'=>date('Y-m-d H:i:s'));
							// 		$this->model_app->insert('rb_referral',$data);
							// 	}
							// }
							// else {
								//get tanggal sekarang
								date_default_timezone_set('Asia/Jakarta');
	                            $tanggal_hari_ini=date("Y-m-d");
								
								$cari_voucher = $this->db->query("SELECT * FROM voucher WHERE active=1 AND kode='".$this->input->post('kode')."'");
								$cari_selisih_hari = $this->db->query("SELECT TIMESTAMPDIFF(DAY,tanggal,'".$tanggal_hari_ini."') AS selisih_hari FROM voucher where kode='".$this->input->post('kode')."'")->row_array();
								
								if (($cari_voucher->num_rows() > 0) && ($cari_selisih_hari['selisih_hari']<30))
								{
									// mencari kode upline dari nama referral yg diinput saat pendaftaran       
									$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where username='".$this->input->post('reffus')."'");
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
										$refferal_fix=$this->input->post('reffus');
										$data = array('username'=>$this->input->post('username'),
													'password'=>hash("sha512", md5($this->input->post('pass'))),
													'nama_reseller'=>$this->input->post('namalengkap'),
													'nama_ktp'=>$this->input->post('namaktp'),
													'jenis_kelamin'=>$this->input->post('jk'),
													'tempat_lahir'=>$this->input->post('tempat_lahir'),
													'tgl_lahir'=>$tgl_lahir,
													'kota_id'=>$this->input->post('kota'),
													'alamat_lengkap'=>$this->input->post('alamat'),
													'no_telpon'=>$this->input->post('nohp'),
													'email'=>$this->input->post('email'),
													'kode_pos'=>$this->input->post('kodepos'),
													'no_ktp'=>$this->input->post('noktp'),
													'foto_ktp'=>$nama_file_ktp,
													'bank'=>$this->input->post('namabank'),
													'norek_tabungan'=>$this->input->post('norek'),
													'referral'=>$refferal_fix,
													'buku_tabungan'=>$nama_file,
													'parent_id'=>$parent,
													'upline'=>$kode_upline_fix,
													'reff_work'=>$reff_id_fix,
													'position'=>$pos_member_baru,
													'tanggal_daftar'=>date('Y-m-d H:i:s'),
													'blokir'=>'N'
												);
										$this->model_app->insert('rb_reseller',$data);

										$data=array('username'=>$this->input->post('username'),
													'password'=>hash("sha512", md5($this->input->post('pass'))),
													'nama_reseller'=>$this->input->post('namalengkap'),
													'nama_ktp'=>$this->input->post('namaktp'),
													'jenis_kelamin'=>$this->input->post('jk'),
													'tempat_lahir'=>$this->input->post('tempat_lahir'),
													'tgl_lahir'=>$tgl_lahir,
													'kota_id'=>$this->input->post('kota'),
													'alamat_lengkap'=>$this->input->post('alamat'),
													'no_ktp'=>$this->input->post('noktp'),
													'foto_ktp'=>$nama_file_ktp,
													'bank'=>$this->input->post('namabank'),
													'norek_tabungan'=>$this->input->post('norek'),
													'buku_tabungan'=>$nama_file,
													'no_telpon'=>$this->input->post('nohp'),
													'email'=>$this->input->post('email'),
													'kode_pos'=>$this->input->post('kodepos'),
													'foto_ktp'=>$nama_file_ktp,
													'referral'=>$refferal_fix,
													'tanggal_daftar'=>date('Y-m-d H:i:s'),
													'blokir'=>'N',
													'position'=>$pos_member_baru,
										);
										$this->model_app->insert('rb_referral',$data);
										
										//update di tabel posisi untuk posisi member yg baru join bahwa sudah terisi
										$this->db->query("update posisi set ket=1 where posisi=".$pos_member_baru);
										
										//mencari nomor id reseller untuk ditampilkan
										$cari_member_barusan=$this->db->query("SELECT * FROM rb_reseller where username='".$this->input->post('username')."'");
										if ($cari_member_barusan->num_rows()==1)	//----> jika terdapat data
										{
											foreach ($cari_member_barusan->result_array() as $row_baru_daftar)
											{
												$id_baru_daftar=$row_baru_daftar[id_reseller];
											}
										}

									}
									// , segera transfer Rp. 10.000 ke rek BCA 8621118811 a/n. anthonius efendy dan konfirmasi ke WA 089529784689
									// $id = $this->db->insert_id();
									// $this->session->set_userdata(array('id_reseller'=>$id, 'level'=>'reseller'));
									$this->db->query("update voucher set used=10000, active=0 where kode='".$this->input->post('kode')."'");
									if($jumlah==1)
									{
										$_SESSION['namalengkap']="";
										$_SESSION['alamat']="";
										$_SESSION['tempatlahir']="";
										$_SESSION['field_username']="";
										$_SESSION['kodepos']="";
										// $_SESSION['ktp']="";
										$_SESSION['nohp']="";
										$_SESSION['email']="";
										$_SESSION['pass1']="";
										$_SESSION['pass2']="";
										$_SESSION['tgl_lahir']="";
										$_SESSION['jumlah']="";
										// $_SESSION['ctrreg']="";
										// echo "<script>alert('sebelum=".$this->session->ctrreg."')</script>";
										$this->session->ctrreg="";
										unset($_SESSION["jumlah"]);
										unset($_SESSION["ctrreg"]);
										// echo "<script>alert('sesudah=".$this->session->ctrreg."')</script>";
										echo "<script>
										$(document).ready(function(){
											swal({                
							                    text: 'Member ".$this->input->post('username')." No.ID : ".$id_baru_daftar." sukses ditambahkan!',
							                    type: 'success',
							                }).then(()=>{
						                      	window.location.href='".base_url()."reseller/home';
						                  	});
							            });</script>";
										// redirect("reseller/home");
										// $_SESSION['reff_name']=$reffname->referral;
									}
									else
									{
										$jumlah--;
										// echo "<script>alert('".$jumlah."')</script>";
										// echo "<script>window.location.href='".base_url()."reseller/register_mitra?no=".$jumlah."';</script>";
										$this->session->ctrreg=$jumlah;
										echo "<script>
										$(document).ready(function(){
											swal({                
							                    text: 'Member ".$this->input->post('username')." No.ID : ".$id_baru_daftar." sukses ditambahkan!',
							                    type: 'success',
							                }).then(()=>{
						                      	window.location.href='".base_url()."reseller/register_mitra".($jumlah!=""?"?no=".$jumlah:"")."';
						                  	});
					                  	});
										</script>";
										// $_SESSION['jumlah']=$jumlah;
									}
								} else {
									// echo "<script type='text/javascript'>
									// 		alert('Voucher kode ".$this->input->post('kode')." sudah expired atau sudah dipakai');</script>";
									$this->session->ctrreg=$jumlah;
									echo "<script>
				                  	$(document).ready(function(){
										swal({                
						                    text: 'Voucher kode ".$this->input->post('kode')." sudah expired atau sudah dipakai',
						                    type: 'error',
						                }).then(()=>{
					                      	window.location.href='".base_url()."reseller/register_mitra".($jumlah!=""?"?no=".$jumlah:"")."';
					                  	});
						            });
          							</script>";
          							// $_SESSION['jumlah']=$jumlah;
								}
								

							// }
							
						}
						// //redirect('reseller/logout');
						
					}
				}
		    }else{
				// $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/view_home');
				// $data["provinsi"]=$this->model_app->view("rb_provinsi")->result_array();
				$data['provinsi'] = $this->model_app->view_ordering('rb_provinsi','provinsi_id','ASC');
		        // $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/register_mitra?no=1',$data);
	        	$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/register_mitra',$data);
		    }
		}
	}

	function reset_idle()
	{
		// $this->config->set_item('sess_expiration', 300);
		$this->session->sess_expiration=3600; // 900
	}

	// function city()
	// {
	// 	$state_id = $this->input->post('stat_id');
	// 	$data['kota'] = $this->db->select("*")->from('rb_kota')->where('provinsi_id',$state_id)->group_by("nama_kota")->get()->result_array();
	// 	$this->load->view(template().'/reseller/view_city',$data);
	// }

	// function register_as_mitra()
	// {

	// }
	
	function release_user()
	{
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		//$lihat = $this->model_app->view_where('rb_reseller',array('parent_id'=>$id))->row_array();
		//$data = array('rows' => $lihat);
        $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/release_user',$data);
	}
	
	// Controller Modul Produk

	function produk(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit'])){
			$jml = $this->model_app->view('rb_produk')->num_rows();
			for ($i=1; $i<=$jml; $i++){
				$a  = $_POST['a'][$i];
				$b  = $_POST['b'][$i];
				$cek = $this->model_app->edit('rb_produk_diskon',array('id_produk'=>$a,'id_reseller'=>$this->session->id_reseller))->num_rows();
				if ($cek >= 1){
					if ($b > 0){
						$data = array('diskon'=>$b);
						$where = array('id_produk' => $a,'id_reseller' => $this->session->id_reseller);
						$this->model_app->update('rb_produk_diskon', $data, $where);
					}else{
						$this->model_app->delete('rb_produk_diskon',array('id_produk'=>$a,'id_reseller'=>$this->session->id_reseller));
					}
				}else{
					if ($b > 0){
						$data = array('id_produk'=>$a,
			                          'id_reseller'=>$this->session->id_reseller,
			                          'diskon'=>$b);
						$this->model_app->insert('rb_produk_diskon',$data);
					}
				}
			}
			redirect($this->uri->segment(1).'/produk');
		}else{
			$data['record'] = $this->model_app->view_where_ordering('rb_produk',array('id_reseller'=>$this->session->id_reseller),'id_produk','DESC');
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_produk/view_produk',$data);
		}
	}

	function tambah_produk(){
        cek_session_reseller_timeout();
        if (isset($_POST['submit'])){
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for($i=0; $i<$cpt; $i++){
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileName = str_replace(' ','_',$fileName);
            if (trim($fileName)!=''){
                $data = array('id_kategori_produk'=>$this->input->post('a'),
                			  'id_kategori_produk_sub'=>$this->input->post('aa'),
                			  'id_reseller'=>$this->session->id_reseller,
                              'nama_produk'=>$this->input->post('b'),
                              'produk_seo'=>seo_title($this->input->post('b')),
                              'satuan'=>$this->input->post('c'),
                              'harga_beli'=>$this->input->post('d'),
                              'harga_reseller'=>$this->input->post('e'),
                              'harga_konsumen'=>$this->input->post('f'),
                              'berat'=>$this->input->post('berat'),
                              'gambar'=>$fileName,
                              'keterangan'=>$this->input->post('ff'),
                              'username'=>$this->session->username,
                              'waktu_input'=>date('Y-m-d H:i:s'));
            }else{
                $data = array('id_kategori_produk'=>$this->input->post('a'),
                			  'id_kategori_produk_sub'=>$this->input->post('aa'),
                			  'id_reseller'=>$this->session->id_reseller,
                              'nama_produk'=>$this->input->post('b'),
                              'produk_seo'=>seo_title($this->input->post('b')),
                              'satuan'=>$this->input->post('c'),
                              'harga_beli'=>$this->input->post('d'),
                              'harga_reseller'=>$this->input->post('e'),
                              'harga_konsumen'=>$this->input->post('f'),
                              'berat'=>$this->input->post('berat'),
                              'keterangan'=>$this->input->post('ff'),
                              'username'=>$this->session->username,
                              'waktu_input'=>date('Y-m-d H:i:s'));
            }
            $this->model_app->insert('rb_produk',$data);
            $this->model_app->insert('history_produk',$data);
            $id_produk = $this->db->insert_id();
            if ($this->input->post('diskon') > 0){
            	$cek = $this->db->query("SELECT * FROM rb_produk_diskon where id_produk='".$id_produk."' AND id_reseller='".$this->session->id_reseller."'");
				if ($cek->num_rows()>=1){
					$data = array('diskon'=>$this->input->post('diskon'));
					$where = array('id_produk' => $id_produk,'id_reseller' => $this->session->id_reseller);
					$this->model_app->update('rb_produk_diskon', $data, $where);
				}else{
					$data = array('id_produk'=>$id_produk,
			                      'id_reseller'=>$this->session->id_reseller,
			                      'diskon'=>$this->input->post('diskon'));
					$this->model_app->insert('rb_produk_diskon',$data);
				}
			}


			if ($this->input->post('stok') != ''){
				$kode_transaksi = "TRX-".date('YmdHis');
				$data = array('kode_transaksi'=>$kode_transaksi,
			        		  'id_pembeli'=>$this->session->id_reseller,
			        		  'id_penjual'=>'1',
			        		  'status_pembeli'=>'reseller',
			        		  'status_penjual'=>'admin',
			        		  'service'=>'Stok Otomatis (Pribadi)',
			        		  'waktu_transaksi'=>date('Y-m-d H:i:s'),
			        		  'proses'=>'1');
				$this->model_app->insert('rb_penjualan',$data);
				$idp = $this->db->insert_id();

				$data = array('id_penjualan'=>$idp,
		        			  'id_produk'=>$id_produk,
		        			  'jumlah'=>$this->input->post('stok'),
		        			  'harga_jual'=>$this->input->post('e'),
		        			  'satuan'=>$this->input->post('c'));
				$this->model_app->insert('rb_penjualan_detail',$data);
			}

            redirect('reseller/produk');
        }else{
            $data['record'] = $this->model_app->view_ordering('rb_kategori_produk','id_kategori_produk','DESC');
            $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_produk/view_produk_tambah',$data);
        }
    }

    function edit_produk(){
        cek_session_reseller_timeout();
        $id = $this->uri->segment(3);
        if (!empty($_POST)){
        	$no_telp = false;
        	//cek 5 digit
        	$deskripsi = $this->input->post('ff');
        	$length = strlen($deskripsi);
        	for ($i=0; $i < $length; $i++) { 
        		if(is_numeric($deskripsi[$i])){
        			$count = 0;
        			$j = 1;
        			while(true){
        				if(is_numeric($deskripsi[($i+$j)])){
        					$count++;
        				}
        				elseif(preg_match('/\s/',$deskripsi[($i+$j)])){

        				}
        				else{
        					break;
        				}
        				$j++;
        				
        			}
        			if($count == 4){
    					echo "<script>alert('Tolong jangan mencantumkan nomor telepon!')</script>";
        				$no_telp = true;
        				break;
    				}
        		}
        	}
        	if($no_telp==true){

        		echo "<script>window.location.href = '".base_url()."reseller/produk'</script>";
        		exit();
        	}
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for($i=0; $i<$cpt; $i++){
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileName = str_replace(' ','_',$fileName);
            if (trim($fileName)!=''){
                $data = array('id_kategori_produk'=>$this->input->post('a'),
                			  'id_kategori_produk_sub'=>$this->input->post('aa'),
                              'nama_produk'=>$this->input->post('b'),
                              'produk_seo'=>seo_title($this->input->post('b')),
                              'satuan'=>$this->input->post('c'),
                              'harga_beli'=>$this->input->post('d'),
                              'harga_reseller'=>$this->input->post('e'),
                              'harga_konsumen'=>$this->input->post('f'),
                              'berat'=>$this->input->post('berat'),
                              'gambar'=>$fileName,
                              'keterangan'=>$this->input->post('ff'),
                              'username'=>$this->session->username);
            }else{
                $data = array('id_kategori_produk'=>$this->input->post('a'),
                			  'id_kategori_produk_sub'=>$this->input->post('aa'),
                              'nama_produk'=>$this->input->post('b'),
                              'produk_seo'=>seo_title($this->input->post('b')),
                              'satuan'=>$this->input->post('c'),
                              'harga_beli'=>$this->input->post('d'),
                              'harga_reseller'=>$this->input->post('e'),
                              'harga_konsumen'=>$this->input->post('f'),
                              'berat'=>$this->input->post('berat'),
                              'keterangan'=>$this->input->post('ff'),
                              'username'=>$this->session->username);
            }

            $where = array('id_produk' => $this->input->post('id'),'id_reseller'=>$this->session->id_reseller);
            $this->model_app->update('rb_produk', $data, $where);

            if ($this->input->post('diskon') >= 0){
            	$cek = $this->db->query("SELECT * FROM rb_produk_diskon where id_produk='".$this->input->post('id')."' AND id_reseller='".$this->session->id_reseller."'");
				if ($cek->num_rows()>=1){
					$data = array('diskon'=>$this->input->post('diskon'));
					$where = array('id_produk' => $this->input->post('id'),'id_reseller' => $this->session->id_reseller);
					$this->model_app->update('rb_produk_diskon', $data, $where);
				}else{
					$data = array('id_produk'=>$this->input->post('id'),
			                      'id_reseller'=>$this->session->id_reseller,
			                      'diskon'=>$this->input->post('diskon'));
					$this->model_app->insert('rb_produk_diskon',$data);
				}
			}

			if ($this->input->post('stok') != ''){
				$kode_transaksi = "TRX-".date('YmdHis');
				$data = array('kode_transaksi'=>$kode_transaksi,
			        		  'id_pembeli'=>$this->session->id_reseller,
			        		  'id_penjual'=>'1',
			        		  'status_pembeli'=>'reseller',
			        		  'status_penjual'=>'admin',
			        		  'service'=>'Stok Otomatis (Pribadi)',
			        		  'waktu_transaksi'=>date('Y-m-d H:i:s'),
			        		  'proses'=>'1');
				$this->model_app->insert('rb_penjualan',$data);
				$idp = $this->db->insert_id();

				$data = array('id_penjualan'=>$idp,
		        			  'id_produk'=>$this->input->post('id'),
		        			  'jumlah'=>$this->input->post('stok'),
		        			  'harga_jual'=>$this->input->post('e'),
		        			  'satuan'=>$this->input->post('c'));
				$this->model_app->insert('rb_penjualan_detail',$data);
			}

        	echo "<script>window.location.href = '".base_url()."reseller/produk'</script>";
        }else{
            $data['record'] = $this->model_app->view_ordering('rb_kategori_produk','id_kategori_produk','DESC');
            $data['rows'] = $this->model_app->edit('rb_produk',array('id_produk'=>$id,'id_reseller'=>$this->session->id_reseller))->row_array();
            $this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_produk/view_produk_edit',$data);
        }
    }

    private function set_upload_options(){
        $config = array();
        $config['upload_path'] = 'asset/foto_produk/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '5000'; // kb
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
      return $config;
    }

    function delete_produk(){
        cek_session_reseller_timeout();
        $id = array('id_produk' => $this->uri->segment(3));
        $this->model_app->delete('rb_produk',$id);
        redirect('reseller/produk');
    }
     function delete_history_produk(){
        cek_session_reseller_timeout();
        $id = array('id_produk' => $this->uri->segment(3));
        $this->model_app->delete('history_produk',$id);
        redirect('reseller/produk');
    }

	// Controller Modul Rekening

	function rekening(){
		cek_session_reseller_timeout();
		$data['record'] = $this->model_app->view_where('rb_rekening_reseller',array('id_reseller'=>$this->session->id_reseller));
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_rekening/view_rekening',$data);
	}

	function tambah_rekening(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit'])){
			$data = array('id_reseller'=>$this->session->id_reseller,
			              'nama_bank'=>$this->input->post('a'),
			              'no_rekening'=>$this->input->post('b'),
			              'pemilik_rekening'=>$this->input->post('c'));
						$this->model_app->insert('rb_rekening_reseller',$data);
			redirect($this->uri->segment(1).'/rekening');
		}else{
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_rekening/view_rekening_tambah');
		}
	}

	function edit_rekening(){
		cek_session_reseller_timeout();
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$data = array('id_reseller'=>$this->session->id_reseller,
			              'nama_bank'=>$this->input->post('a'),
			              'no_rekening'=>$this->input->post('b'),
			              'pemilik_rekening'=>$this->input->post('c'));
			$where = array('id_rekening_reseller' => $this->input->post('id'),'id_reseller' => $this->session->id_reseller);
			$this->model_app->update('rb_rekening_reseller', $data, $where);
			redirect($this->uri->segment(1).'/rekening');
		}else{
			$data['rows'] = $this->model_app->edit('rb_rekening_reseller',array('id_rekening_reseller'=>$id))->row_array();
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_rekening/view_rekening_edit',$data);
		}
	}

	function delete_rekening(){
		cek_session_reseller_timeout();
		$id = array('id_rekening_reseller' => $this->uri->segment(3));
		$this->model_app->delete('rb_rekening_reseller',$id);
		redirect($this->uri->segment(1).'/rekening');
	}



	// Controller Modul Pembelian

	function pembelian(){
		cek_session_reseller_timeout();
		$this->session->unset_userdata('idp');
		$data['record'] = $this->model_reseller->reseller_pembelian($this->session->id_reseller,'admin');
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_pembelian/view_pembelian',$data);
	}

	function detail_pembelian(){
		cek_session_reseller_timeout();
		$data['rows'] = $this->model_reseller->penjualan_detail($this->uri->segment(3))->row_array();
		$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','DESC');
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_pembelian/view_pembelian_detail',$data);
	}

	function tambah_pembelian(){
		cek_session_reseller_timeout();
		if(isset($_POST['submit'])){
			if ($this->session->idp == ''){
				$kode_transaksi = "TRX-".date('YmdHis');
				$data = array('kode_transaksi'=>$kode_transaksi,
			        		  'id_pembeli'=>$this->session->id_reseller,
			        		  'id_penjual'=>'1',
			        		  'status_pembeli'=>'reseller',
			        		  'status_penjual'=>'admin',
			        		  'waktu_transaksi'=>date('Y-m-d H:i:s'),
			        		  'proses'=>'0');
				$this->model_app->insert('rb_penjualan',$data);
				$idp = $this->db->insert_id();
				$this->session->set_userdata(array('idp'=>$idp));
			}

	        if ($this->input->post('idpd')==''){
				$data = array('id_penjualan'=>$this->session->idp,
		        			  'id_produk'=>$this->input->post('aa'),
		        			  'jumlah'=>$this->input->post('dd'),
		        			  'harga_jual'=>$this->input->post('bb'),
		        			  'satuan'=>$this->input->post('ee'));
				$this->model_app->insert('rb_penjualan_detail',$data);
			}else{
		        $data = array('id_produk'=>$this->input->post('aa'),
		        			  'jumlah'=>$this->input->post('dd'),
		        			  'harga_jual'=>$this->input->post('bb'),
		        			  'satuan'=>$this->input->post('ee'));
				$where = array('id_penjualan_detail' => $this->input->post('idpd'));
				$this->model_app->update('rb_penjualan_detail', $data, $where);
			}
			redirect($this->uri->segment(1).'/tambah_pembelian');
		}else{
			$data['rows'] = $this->model_reseller->penjualan_detail($this->session->idp)->row_array();
			$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->session->idp),'id_penjualan_detail','DESC');
			$data['barang'] = $this->model_app->view_where_ordering('rb_produk',array('id_reseller'=>'0'),'id_produk','ASC');
			$data['reseller'] = $this->model_app->view_ordering('rb_reseller','id_reseller','ASC');
			if ($this->uri->segment(3)!=''){
				$data['row'] = $this->model_app->view_where('rb_penjualan_detail',array('id_penjualan_detail'=>$this->uri->segment(3)))->row_array();
			}
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_pembelian/view_pembelian_tambah',$data);
		}
	}

	function delete_pembelian(){
        cek_session_reseller_timeout();
		$id = array('id_penjualan' => $this->uri->segment(3));
		$this->model_app->delete('rb_penjualan',$id);
		$this->model_app->delete('rb_penjualan_detail',$id);
		redirect($this->uri->segment(1).'/pembelian');
	}

	function delete_pembelian_tambah_detail(){
        cek_session_reseller_timeout();
		$id = array('id_penjualan_detail' => $this->uri->segment(3));
		$this->model_app->delete('rb_penjualan_detail',$id);
		redirect($this->uri->segment(1).'/tambah_pembelian');
	}

	function konfirmasi_pembayaran(){
		cek_session_reseller_timeout();
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
				$data = array('id_penjualan'=>$this->input->post('id'),
			        		  'total_transfer'=>$this->input->post('b'),
			        		  'id_rekening'=>$this->input->post('c'),
			        		  'nama_pengirim'=>$this->input->post('d'),
			        		  'tanggal_transfer'=>$this->input->post('e'),
			        		  'waktu_konfirmasi'=>date('Y-m-d H:i:s'));
				$this->model_app->insert('rb_konfirmasi_pembayaran',$data);
			}else{
				$data = array('id_penjualan'=>$this->input->post('id'),
			        		  'total_transfer'=>$this->input->post('b'),
			        		  'id_rekening'=>$this->input->post('c'),
			        		  'nama_pengirim'=>$this->input->post('d'),
			        		  'tanggal_transfer'=>$this->input->post('e'),
			        		  'bukti_transfer'=>$hasil['file_name'],
			        		  'waktu_konfirmasi'=>date('Y-m-d H:i:s'));
				$this->model_app->insert('rb_konfirmasi_pembayaran',$data);
			}
				$data1 = array('proses'=>'2');
				$where = array('id_penjualan' => $this->input->post('id'));
				$this->model_app->update('rb_penjualan', $data1, $where);
			redirect($this->uri->segment(1).'/pembelian');
		}else{
			$data['record'] = $this->model_app->view('rb_rekening');
			$data['total'] = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='".$this->uri->segment(3)."'")->row_array();
			$data['rows'] = $this->model_app->view_where('rb_penjualan',array('id_penjualan'=>$this->uri->segment(3)))->row_array();
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_pembelian/view_konfirmasi_pembayaran',$data);
		}
	}

	function keterangan(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit'])){
			$cek = $this->model_app->view_where('rb_keterangan',array('id_reseller'=>$this->session->id_reseller))->num_rows();
			if ($cek>=1){
				$data1 = array('keterangan'=>$this->input->post('a'));
				$where = array('id_keterangan' => $this->input->post('id'),'id_reseller'=>$this->session->id_reseller);
				$this->model_app->update('rb_keterangan', $data1, $where);
			}else{
				$data1 = array('id_reseller'=>$this->session->id_reseller,
							   'keterangan'=>$this->input->post('a'),
							   'tanggal_posting'=>date('Y-m-d H:i:s'));
				$this->model_app->insert('rb_keterangan',$data);
			}
			redirect($this->uri->segment(1).'/keterangan');
		}else{
			$data['record'] = $this->model_app->edit('rb_keterangan',array('id_reseller'=>$this->session->id_reseller))->row_array();
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_keterangan/view_keterangan',$data);
		}
	}

	function penjualan(){
		cek_session_reseller_timeout();
		$this->session->unset_userdata('idp');
		$id = $this->session->id_reseller;
		$data['record'] = $this->model_reseller->penjualan_list_konsumen($id,'reseller');
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_penjualan/view_penjualan',$data);
	}
	function nego(){
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		$data['penjual_a'] = $this->model_reseller->find_nego_penjual_a($id);
		$data['penjual_b'] = $this->model_reseller->find_nego_penjual_b($id);
		$data['penjual_a_diterima'] = $this->model_reseller->find_nego_penjual_a_diterima($id);
		$data['penjual_b_diterima'] = $this->model_reseller->find_nego_penjual_b_diterima($id);
		$data['penjual_a_ditolak'] = $this->model_reseller->find_nego_penjual_a_ditolak($id);
		$data['penjual_b_ditolak'] = $this->model_reseller->find_nego_penjual_b_ditolak($id);

		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_nego/view_nego', $data);
	}
	function negokonsumen(){
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		$data['pembeli_a'] = $this->model_reseller->find_nego_pembeli_a($id);
		$data['pembeli_b'] = $this->model_reseller->find_nego_pembeli_b($id);

		$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/mod_nego/view_nego_konsumen', $data);
	}
	function hapus_nego($id){
		cek_session_reseller_timeout();
		$id_user = $this->session->id_reseller;
		$where = array('id_nego'=>$id, 'id_pembeli'=>$id_user);
		$this->model_reseller->hapus_nego($where,'rb_nego');
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
		  Data Berhasil Dihapus!
		</div>');
		redirect('reseller/nego');
	}
	function tolak_nego($id){
		cek_session_reseller_timeout();
		$id_user = $this->session->id_reseller;
		$where = array('id_nego'=>$id, 'id_penjual'=>$id_user);
		$this->model_reseller->tolak_nego($where,'rb_nego');
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
		  Penawaran Berhasil Ditolak!
		</div>');
		redirect('reseller/nego');
	}
	function setuju_nego($id,$jumlah){
		cek_session_reseller_timeout();
		$id_user = $this->session->id_reseller;
		$this->model_reseller->setuju_nego($jumlah,$id,$id_user);
		redirect('reseller/nego');
	}
	function detail_penjualan(){
		cek_session_reseller_timeout();
		$data['rows'] = $this->model_reseller->penjualan_konsumen_detail_reseller($this->uri->segment(3))->row_array();
		$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','DESC');
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_penjualan/view_penjualan_detail',$data);
	}

	function tambah_penjualan(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit1'])){
			if ($this->session->idp == ''){
				$data = array('kode_transaksi'=>$this->input->post('a'),
			        		  'id_pembeli'=>$this->input->post('b'),
			        		  'id_penjual'=>$this->session->id_reseller,
			        		  'status_pembeli'=>'konsumen',
			        		  'status_penjual'=>'reseller',
			        		  'waktu_transaksi'=>date('Y-m-d H:i:s'),
			        		  'proses'=>'0');
				$this->model_app->insert('rb_penjualan',$data);
                $this->model_app->insert('history_penjualan',$data);
				$idp = $this->db->insert_id();
				$this->session->set_userdata(array('idp'=>$idp));
			}else{
				$data = array('kode_transaksi'=>$this->input->post('a'),
			        		  'id_pembeli'=>$this->input->post('b'));
				$where = array('id_penjualan' => $this->session->idp);
				$this->model_app->update('rb_penjualan', $data, $where);
			}
				redirect($this->uri->segment(1).'/tambah_penjualan');

		}elseif(isset($_POST['submit'])){
			$jual = $this->model_reseller->jual_reseller($this->session->id_reseller, $this->input->post('aa'))->row_array();
            $beli = $this->model_reseller->beli_reseller($this->session->id_reseller, $this->input->post('aa'))->row_array();
            $stok = $beli['beli']-$jual['jual'];
            if ($this->input->post('dd') > $stok){
            	echo "<script>window.alert('Maaf, Stok Tidak Mencukupi!');
                                  window.location=('".base_url().$this->uri->segment(1)."/tambah_penjualan')</script>";
            }else{
		        if ($this->input->post('idpd')==''){
					$data = array('id_penjualan'=>$this->session->idp,
			        			  'id_produk'=>$this->input->post('aa'),
			        			  'jumlah'=>$this->input->post('dd'),
			        			  'harga_jual'=>$this->input->post('bb'),
			        			  'satuan'=>$this->input->post('ee'));
					$this->model_app->insert('rb_penjualan_detail',$data);
				}else{
			        $data = array('id_produk'=>$this->input->post('aa'),
			        			  'jumlah'=>$this->input->post('dd'),
			        			  'harga_jual'=>$this->input->post('bb'),
			        			  'satuan'=>$this->input->post('ee'));
					$where = array('id_penjualan_detail' => $this->input->post('idpd'));
					$this->model_app->update('rb_penjualan_detail', $data, $where);
				}
				redirect($this->uri->segment(1).'/tambah_penjualan');
			}
			
		}else{
			$data['rows'] = $this->model_reseller->penjualan_konsumen_detail_reseller($this->session->idp)->row_array();
			$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->session->idp),'id_penjualan_detail','DESC');
			$data['barang'] = $this->model_app->view_ordering('rb_produk','id_produk','ASC');
			$data['konsumen'] = $this->model_app->view_ordering('rb_konsumen','id_konsumen','ASC');
			if ($this->uri->segment(3)!=''){
				$data['row'] = $this->model_app->view_where('rb_penjualan_detail',array('id_penjualan_detail'=>$this->uri->segment(3)))->row_array();
			}
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_penjualan/view_penjualan_tambah',$data);
		}
	}

	function edit_penjualan(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit1'])){
			$data = array('kode_transaksi'=>$this->input->post('a'),
			        	  'id_pembeli'=>$this->input->post('b'),
			        	  'waktu_transaksi'=>$this->input->post('c'));
			$where = array('id_penjualan' => $this->input->post('idp'));
			$this->model_app->update('rb_penjualan', $data, $where);
			redirect($this->uri->segment(1).'/edit_penjualan/'.$this->input->post('idp'));

		}elseif(isset($_POST['submit'])){
			$cekk = $this->db->query("SELECT * FROM rb_penjualan_detail where id_penjualan='".$this->input->post('idp')."' AND id_produk='".$this->input->post('aa')."'")->row_array();
			$jual = $this->model_reseller->jual_reseller($this->session->id_reseller, $this->input->post('aa'))->row_array();
            $beli = $this->model_reseller->beli_reseller($this->session->id_reseller, $this->input->post('aa'))->row_array();
            $stok = $beli['beli']-$jual['jual']+$cekk['jumlah'];
            if ($this->input->post('dd') > $stok){
            	echo "<script>window.alert('Maaf, Stok $stok Tidak Mencukupi!');
                                  window.location=('".base_url().$this->uri->segment(1)."/edit_penjualan/".$this->input->post('idp')."')</script>";
            }else{
				if ($this->input->post('idpd')==''){
					$data = array('id_penjualan'=>$this->input->post('idp'),
			        			  'id_produk'=>$this->input->post('aa'),
			        			  'jumlah'=>$this->input->post('dd'),
			        			  'harga_jual'=>$this->input->post('bb'),
			        			  'satuan'=>$this->input->post('ee'));
					$this->model_app->insert('rb_penjualan_detail',$data);
				}else{
			        $data = array('id_produk'=>$this->input->post('aa'),
			        			  'jumlah'=>$this->input->post('dd'),
			        			  'harga_jual'=>$this->input->post('bb'),
			        			  'satuan'=>$this->input->post('ee'));
					$where = array('id_penjualan_detail' => $this->input->post('idpd'));
					$this->model_app->update('rb_penjualan_detail', $data, $where);
				}
				redirect($this->uri->segment(1).'/edit_penjualan/'.$this->input->post('idp'));
			}
			
		}else{
			$data['rows'] = $this->model_reseller->penjualan_konsumen_detail_reseller($this->uri->segment(3))->row_array();
			$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','DESC');
			$data['barang'] = $this->model_app->view_ordering('rb_produk','id_produk','ASC');
			$data['konsumen'] = $this->model_app->view_ordering('rb_konsumen','id_konsumen','ASC');
			if ($this->uri->segment(4)!=''){
				$data['row'] = $this->model_app->view_where('rb_penjualan_detail',array('id_penjualan_detail'=>$this->uri->segment(4)))->row_array();
			}
			$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_penjualan/view_penjualan_edit',$data);
		}
	}

	function proses_penjualan(){
		cek_session_reseller_timeout();
	        $data = array('proses'=>$this->uri->segment(4));
			$where = array('id_penjualan' => $this->uri->segment(3));
			$this->model_app->update('rb_penjualan', $data, $where);
			redirect($this->uri->segment(1).'/penjualan');
	}

	function proses_penjualan_detail(){
		cek_session_reseller_timeout();
        $data = array('proses'=>$this->uri->segment(4));
		$where = array('id_penjualan' => $this->uri->segment(3));
		$this->model_app->update('rb_penjualan', $data, $where);
		redirect($this->uri->segment(1).'/detail_penjualan/'.$this->uri->segment(3));
	}

	function delete_penjualan(){
        cek_session_reseller_timeout();
		$id = array('id_penjualan' => $this->uri->segment(3));
		$this->model_app->delete('rb_penjualan',$id);
		$this->model_app->delete('rb_penjualan_detail',$id);
		redirect($this->uri->segment(1).'/penjualan');
	}

	function delete_penjualan_detail(){
        cek_session_reseller_timeout();
		$id = array('id_penjualan_detail' => $this->uri->segment(4));
		$this->model_app->delete('rb_penjualan_detail',$id);
		redirect($this->uri->segment(1).'/edit_penjualan/'.$this->uri->segment(3));
	}

	function delete_penjualan_tambah_detail(){
        cek_session_reseller_timeout();
		$id = array('id_penjualan_detail' => $this->uri->segment(3));
		$this->model_app->delete('rb_penjualan_detail',$id);
		redirect($this->uri->segment(1).'/tambah_penjualan');
	}

	function detail_konsumen(){
		cek_session_reseller_timeout();
		$id = $this->uri->segment(3);
		$edit = $this->model_app->edit('rb_konsumen',array('id_konsumen'=>$id))->row_array();
		$data = array('rows' => $edit);
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_konsumen/view_konsumen_detail',$data);
	}

	function pembayaran_konsumen(){
		cek_session_reseller_timeout();
		$data['record'] = $this->db->query("SELECT a.*, b.*, c.kode_transaksi, c.proses FROM `rb_konfirmasi_pembayaran_konsumen` a JOIN rb_rekening_reseller b ON a.id_rekening=b.id_rekening_reseller JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where b.id_reseller='".$this->session->id_reseller."'");
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_konsumen/view_konsumen_pembayaran',$data);
	}

	function download(){
		$name = $this->uri->segment(3);
		$data = file_get_contents("asset/files/".$name);
		force_download($name, $data);
	}

	function keuangan(){
		cek_session_reseller_timeout();
		$id = $this->session->id_reseller;
		
		$record = $this->model_reseller->reseller_pembelian($id,'admin');
		$penjualan = $this->model_reseller->penjualan_list_konsumen($id,'reseller');
		$edit = $this->model_app->edit('rb_reseller',array('id_reseller'=>$id))->row_array();
		$reward = $this->model_app->view_ordering('rb_reward','id_reward','ASC');

		$data = array('rows' => $edit,'record'=>$record,'penjualan'=>$penjualan,'reward'=>$reward);
		$this->template->load($this->uri->segment(1).'/template',$this->uri->segment(1).'/mod_reseller/view_reseller_keuangan',$data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('main');
	}
	function wishlist(){
		cek_session_reseller_timeout();
		$data['wish'] = $this->model_reseller->lihat_wishlist($this->session->id_reseller);
		if (isset($this->session->id_reseller)) {
			$this->template->load($this->uri->segment(1).'/template_consumer',$this->uri->segment(1).'/view_wishlist',$data);
		}
	}
	function hapus_wish($id){
		cek_session_reseller_timeout();
		$id_user = $this->session->id_reseller;
		$where = array('id_wishlist'=>$id, 'id_user'=>$id_user);
		$this->model_reseller->hapus_wish($where,'wishlist');
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
		  Wish Berhasil Dihapus!
		</div>');
		redirect('reseller/wishlist');
	}
}
?>