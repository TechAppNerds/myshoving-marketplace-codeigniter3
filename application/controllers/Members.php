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
class Members extends CI_Controller {
	function foto(){
		cek_session_reseller_timeout();
		if (isset($_POST['submit'])){
			$this->model_reseller->modupdatefoto();
			redirect('members/profile');
		}else{
			redirect('members/profile');
		}
	}

	function profile(){
		cek_session_reseller_timeout();
		
		$data['title'] = 'Profile Anda';
		$data['row'] = $this->model_reseller->profile_konsumen($this->session->id_reseller)->row_array();
		$this->template->load(template().'/template',template().'/reseller/view_profile',$data);
	}

	function edit_profile(){
		cek_session_reseller_timeout();
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$this->model_reseller->profile_update($this->session->id_konsumen);
			redirect('members/profile');
		}else{
			$data['title'] = 'Edit Profile Anda';
			$data['row'] = $this->model_reseller->profile_konsumen($this->session->id_konsumen)->row_array();
			$row = $this->model_reseller->profile_konsumen($this->session->id_konsumen)->row_array();
			$data['provinsi'] = $this->model_app->view_ordering('rb_provinsi','provinsi_id','ASC');
			$data['rowse'] = $this->db->query("SELECT provinsi_id FROM rb_kota where kota_id='$row[kota_id]'")->row_array();
			$this->template->load(template().'/template',template().'/reseller/view_profile_edit',$data);
		}
	}


	function reseller(){
		cek_session_reseller_timeout();
		$jumlah= $this->model_app->view('rb_reseller')->num_rows();
		$config['base_url'] = base_url().'members/reseller';
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 12; 	
		if ($this->uri->segment('3')==''){
			$dari = 0;
		}else{
			$dari = $this->uri->segment('3');
		}

		if (is_numeric($dari)) {
			$data['title'] = 'Semua Daftar Reseller';
			$this->pagination->initialize($config);
			if (isset($_POST['submit'])){
				$data['record'] = $this->model_reseller->cari_reseller(filter($this->input->post('cari_reseller')));
			}elseif (isset($_GET['cari_reseller'])){
				$data['record'] = $this->model_reseller->cari_reseller(filter($this->input->get('cari_reseller')));
				$total = $this->model_reseller->cari_reseller(filter($this->input->get('cari_reseller')));
				if ($total->num_rows()==1){
					$row = $total->row_array();
					redirect('produk/keranjang/'.$row['id_reseller'].'/'.$this->session->produk);
				}
			}else{
				$data['record'] = $this->db->query("SELECT * FROM rb_reseller a LEFT JOIN rb_kota b ON a.kota_id=b.kota_id ORDER BY id_reseller DESC LIMIT $dari,$config[per_page]");
			}
			$this->template->load(template().'/template',template().'/reseller/view_reseller',$data);
		}else{
			redirect('main');
		}
	}

	function detail_reseller(){
		cek_session_reseller_timeout();
		$data['title'] = 'Detail Profile Reseller';
		$id = $this->uri->segment(3);
		$data['rows'] = $this->model_app->edit('rb_reseller',array('id_reseller'=>$id))->row_array();
		$data['record'] = $this->model_reseller->penjualan_list_konsumen($id,'reseller');
		$data['rekening'] = $this->model_app->view_where('rb_rekening_reseller',array('id_reseller'=>$id));
		$this->template->load(template().'/template',template().'/reseller/view_reseller_detail',$data);

	}

	function orders_report(){
		// if ($this->session->id_konsumen=='') redirect('auth/login');
		// else{
			if ($this->session->id_reseller) {
				cek_session_reseller_timeout();
			}		
			$data['title'] = 'Laporan Pesanan Anda';
			$data['record'] = $this->model_reseller->orders_report($this->session->id_konsumen,'reseller');
			$this->template->load(template().'/template',template().'/reseller/members/view_orders_report',$data);
		// }
	}

	function produk_reseller(){
		cek_session_reseller_timeout();
		$jumlah= $this->model_app->view('rb_produk')->num_rows();
		$config['base_url'] = base_url().'members/produk_reseller/'.$this->uri->segment('3');
		$config['total_rows'] = $jumlah;
		$config['per_page'] = 12; 	
		if ($this->uri->segment('4')==''){
			$dari = 0;
		}else{
			$dari = $this->uri->segment('4');
		}

		if (is_numeric($dari)) {
			$data['title'] = 'Data Produk Reseller';
			$id = $this->uri->segment(3);
			$data['rows'] = $this->db->query("SELECT * FROM rb_reseller a JOIN rb_kota b ON a.kota_id=b.kota_id where a.id_reseller='$id'")->row_array();
			$data['record'] = $this->model_app->view_where_ordering_limit('rb_produk',array('id_reseller!='=>'0'),'id_produk','DESC',$dari,$config['per_page']);
			$this->pagination->initialize($config);
			$this->template->load(template().'/template',template().'/reseller/view_reseller_produk',$data);
		}else{
			redirect('main');
		}
	}

	function keranjang(){
		if ($this->session->id_reseller) {
			cek_session_reseller_timeout();
		}
		if ($this->session->idpenjualan) {
            $id_penjualan=$this->session->idpenjualan;
            $query = $this->db->query("SELECT id_penjual FROM rb_penjualan where id_penjualan ='$id_penjualan'");
            $id_penjual="";
            foreach ($query->result_array() as $row){
                $id_penjual=$row['id_penjual'];
            }
            $query2 = $this->db->query("SELECT username FROM rb_referral where id_reseller ='$id_penjual'");
            $status="";
            foreach ($query2->result_array() as $row2){
                $status=$row2['username'];
            }
	        if($status==""){
	            $table_user="rb_reseller";
	        }else{
	            $table_user="rb_referral";
	        }
            
			// $data['rows'] = $this->model_reseller->penjualan_konsumen_detail($this->session->idpenjualan)->row_array();
			$data['rows'] = $this->db->query("SELECT * FROM `rb_penjualan` a JOIN ".$table_user." b ON a.id_penjual=b.id_reseller JOIN rb_kota c ON b.kota_id=c.kota_id where a.id_penjualan='".$this->session->idpenjualan."'")->row_array();
//			// $data['rows'] = $this->db->query("SELECT * FROM `rb_penjualan` a JOIN ".$table_user." b ON a.id_penjual=b.id_reseller JOIN rb_kota c ON b.kota_id=c.kota_id where a.id_penjualan='".$this->session->idpenjualan."'")->row_array();
			$data['rowsk'] = $this->model_reseller->view_join_where_one($table_user,'rb_kota','kota_id',array('id_reseller'=>$this->session->id_konsumen))->row_array();
			// $data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->session->idpenjualan),'id_penjualan_detail','ASC');
			$data['record']=$this->db->query("SELECT a.*,b.nama_produk,b.produk_seo,b.berat FROM `rb_penjualan_detail` a,`rb_produk` b WHERE a.id_produk=b.id_produk AND a.id_penjualan='".$this->session->idpenjualan."'");

		}
		$data['title'] = 'Keranjang Belanja';
		$this->template->load(template().'/template',template().'/reseller/members/view_keranjang',$data);
//        
	}

	function totalcost(){
		echo "Rp ".rupiah($this->input->get("subtotal")+$this->input->get("ongkir"));
	}

	function lihatsession(){
		echo "<pre>";
		print_r($this->session->all_userdata());
		echo "</pre>";
	}

	function keranjang_detail(){
		cek_session_reseller_timeout();
		$data['rows'] = $this->model_reseller->penjualan_konsumen_detail($this->uri->segment(3))->row_array();
		$data['record'] = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->uri->segment(3)),'id_penjualan_detail','ASC');
		$data['title'] = 'Detail Belanja';
		$this->template->load(template().'/template',template().'/reseller/members/view_keranjang_detail',$data);
	}

	function keranjang_delete(){
		$id = array('id_penjualan_detail' => $this->uri->segment(3));
		$this->model_app->delete('rb_penjualan_detail',$id);
		$isi_keranjang = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_penjualan_detail where id_penjualan='".$this->session->idp."'")->row_array();
		if ($isi_keranjang['jumlah']==''){
			$idp = array('id_penjualan' => $this->session->idp);
			$this->model_app->delete('rb_penjualan',$idp);
			$this->session->unset_userdata('idp');
		}
		redirect('members/keranjang');
	}

	function selesai_belanja(){
		if (isset($_POST['submit'])){
			$iden = $this->model_app->view_where('identitas',array('id_identitas'=>'1'))->row_array();
			$cekres = $this->model_app->view_where('rb_penjualan',array('id_penjualan'=>$this->session->idpenjualan))->row_array();

			$cek = $this->db->query("SELECT * FROM `rb_reseller` where `id_reseller`='".$this->session->id_konsumen."'");
		    $total = $cek->num_rows();
		    $cek1 = $this->db->query("SELECT * FROM `rb_referral` where `id_reseller`='".$this->session->id_konsumen."'");
		    $total1 = $cek1->num_rows();
		    if ($total >= 1) {
		    	$row = $cek->row_array();
		    	$kons = $this->db->query("SELECT a.id_reseller, a.username, a.nama_reseller, a.email, a.jenis_kelamin, a.tgl_lahir, a.tempat_lahir, a.alamat_lengkap, a.kecamatan, a.no_telpon, a.tanggal_daftar, b.kota_id, b.nama_kota as kota, c.provinsi_id, c.nama_provinsi as propinsi FROM `rb_reseller` a LEFT JOIN rb_kota b ON a.kota_id=b.kota_id LEFT JOIN rb_provinsi c ON b.provinsi_id=c.provinsi_id where a.id_reseller='".$this->session->id_konsumen."'")->row_array();
		    }
		    elseif ($total1 >= 1) {
		    	$row = $cek1->row_array();
		    	$kons = $this->db->query("SELECT a.id_reseller, a.username, a.nama_reseller, a.email, a.jenis_kelamin, a.tgl_lahir, a.tempat_lahir, a.alamat_lengkap, a.kecamatan, a.no_telpon, a.tanggal_daftar, b.kota_id, b.nama_kota as kota, c.provinsi_id, c.nama_provinsi as propinsi FROM `rb_referral` a LEFT JOIN rb_kota b ON a.kota_id=b.kota_id LEFT JOIN rb_provinsi c ON b.provinsi_id=c.provinsi_id where a.id_reseller='".$this->session->id_konsumen."'")->row_array();
		    }
			// $kons = $this->model_reseller->profile_konsumen($this->session->id_konsumen)->row_array();
		    $data=$this->model_app->view_where("rb_penjualan",array('kode_transaksi'=>$this->session->idp))->row_array();
			$data_insert = array('id_penjualan'=>$data["id_penjualan"],
			        			 'kode_transaksi'=>$data["kode_transaksi"],
			        			 'id_pembeli'=>$data["id_pembeli"],
			        			 'id_penjual'=>$data["id_penjual"],
			        			 'status_pembeli'=>$data["status_pembeli"],
			        			 'status_penjual'=>$data["status_penjual"],
			        			 'kurir'=>$this->input->post('kurir'),
			        			 'service'=>$this->input->post('service'),
			        			 'ongkir'=>$this->input->post('ongkir'),
			        			 'waktu_transaksi'=>$data["waktu_transaksi"],
			        			 'proses'=>$data["proses"]);
			$this->model_app->insert('history_penjualan',$data_insert);

			$data=$this->model_app->view_where("rb_penjualan_detail",array('id_penjualan'=>$this->session->idpenjualan))->row_array();
			$data_insert = array('id_penjualan_detail'=>$data["id_penjualan_detail"],
			        			 'id_penjualan'=>$data["id_penjualan"],
			        			 'id_produk'=>$data["id_produk"],
			        			 'jumlah'=>$data["jumlah"],
			        			 'diskon'=>$data["diskon"],
			        			 'harga_jual'=>$data["harga_jual"],
			        			 'satuan'=>$data["satuan"]);
			$this->model_app->insert('history_penjualan_detail',$data_insert);

			$res = $this->model_app->view_where('rb_reseller',array('id_reseller'=>$cekres['id_penjual']))->row_array();
			$data['rekening_reseller'] = $this->model_app->view_where('rb_rekening_reseller',array('id_reseller'=>$cekres['id_penjual']));

			$data1 = array('kurir'=>$this->input->post('kurir'),
						   'service'=>$this->input->post('service'),
						   'ongkir'=>$this->input->post('ongkir'));
			$where1 = array('id_penjualan'=>$this->session->idpenjualan);
			$this->model_app->update('rb_penjualan', $data1, $where1);

			// $email_tujuan = $kons['email'];
			$email_tujuan = $row['email'];
			$tglaktif = date("d-m-Y H:i:s");

			$subject      = "$iden[nama_website] - Detail Orderan anda";
			$message      = "<html><body>Halooo! <b>".$kons['nama_lengkap']."</b> ... <br> Hari ini pada tanggal <span style='color:red'>$tglaktif</span> Anda telah order produk di $iden[nama_website].
				<br><table style='width:100%;'>
	   				<tr><td style='background:#337ab7; color:#fff; pading:20px' cellpadding=6 colspan='2'><b>Berikut Data Anda : </b></td></tr>
					<tr><td width='140px'><b>Nama Lengkap</b></td>  <td> : ".$kons['nama_lengkap']."</td></tr>
					<tr><td><b>Alamat Email</b></td>			<td> : ".$kons['email']."</td></tr>
					<tr><td><b>No Telpon</b></td>				<td> : ".$kons['no_hp']."</td></tr>
					<tr><td><b>Alamat</b></td>					<td> : ".$kons['alamat_lengkap']." </td></tr>
					<tr><td><b>Negara</b></td>					<td> : ".$kons['negara']." </td></tr>
					<tr><td><b>Provinsi</b></td>				<td> : ".$kons['propinsi']." </td></tr>
					<tr><td><b>Kabupaten/Kota</b></td>			<td> : ".$kons['kota']." </td></tr>
					<tr><td><b>Kecamatan</b></td>				<td> : ".$kons['kecamatan']." </td></tr>
				</table><br>

				<table style='width:100%;'>
	   				<tr><td style='background:#337ab7; color:#fff; pading:20px' cellpadding=6 colspan='2'><b>Berikut Data Reseller : </b></td></tr>
					<tr><td width='140px'><b>Nama Reseller</b></td>	<td> : ".$res['nama_reseller']."</td></tr>
					<tr><td><b>Alamat</b></td>					<td> : ".$res['alamat_lengkap']."</td></tr>
					<tr><td><b>No Telpon</b></td>				<td> : ".$res['no_telpon']."</td></tr>
					<tr><td><b>Email</b></td>					<td> : ".$res['email']." </td></tr>
					<tr><td><b>Keterangan</b></td>				<td> : ".$res['keterangan']." </td></tr>
				</table><br>

				No Orderan anda : <b>".$cekres['kode_transaksi']."</b><br>
				Berikut Detail Data Orderan Anda :
				<table style='width:100%;' class='table table-striped'>
			          <thead>
			            <tr bgcolor='#337ab7'>
			              <th style='width:40px'>No</th>
			              <th width='47%'>Nama Produk</th>
			              <th>Harga</th>
			              <th>Qty</th>
			              <th>Berat</th>
			              <th>Subtotal</th>
			            </tr>
			          </thead>
			          <tbody>";

			          $no = 1;
			          $belanjaan = $this->model_app->view_join_where('rb_penjualan_detail','rb_produk','id_produk',array('id_penjualan'=>$this->session->idpenjualan),'id_penjualan_detail','ASC');
			          foreach ($belanjaan as $row){
			          $sub_total = ($row['harga_jual']*$row['jumlah']);
			$message .= "<tr bgcolor='#e3e3e3'><td>$no</td>
			                    <td>$row[nama_produk]</td>
			                    <td>".rupiah($row['harga_jual'])."</td>
			                    <td>$row[jumlah]</td>
			                    <td>".($row['berat']*$row['jumlah'])." Kg</td>
			                    <td>Rp ".rupiah($sub_total)."</td>
			                </tr>";
			            $no++;
			          }
			          $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total, sum(b.berat*a.jumlah) as total_berat FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk where a.id_penjualan='".$this->session->idpenjualan."'")->row_array();
			$message .= "<tr bgcolor='lightgreen'>
			                  <td colspan='5'><b>Total Harga</b></td>
			                  <td><b>Rp ".rupiah($total['total']+$this->input->post("ongkir"))."</b></td>
			                </tr>

			                <tr bgcolor='lightblue'>
			                  <td colspan='5'><b>Total Berat</b></td>
			                  <td><b>$total[total_berat] Kg</b></td>
			                </tr>

			        </tbody>
			      </table><br>

			      Silahkan melakukan pembayaran ke rekening reseller :
			      <table style='width:100%;' class='table table-hover table-condensed'>
					<thead>
					  <tr bgcolor='#337ab7'>
					    <th width='20px'>No</th>
					    <th>Nama Bank</th>
					    <th>No Rekening</th>
					    <th>Atas Nama</th>
					  </tr>
					</thead>
					<tbody>";
					    $noo = 1;
					    $rekening = $this->model_app->view_where('rb_rekening_reseller',array('id_reseller'=>$cekres['id_penjual']));
					    foreach ($rekening->result_array() as $row){
			$message .= "<tr bgcolor='#e3e3e3'><td>$noo</td>
					              <td>$row[nama_bank]</td>
					              <td>$row[no_rekening]</td>
					              <td>$row[pemilik_rekening]</td>
					          </tr>";
					      $noo++;
					    }
			$message .= "</tbody>
				  </table><br><br>

			      Jika sudah melakukan transfer, jangan lupa konfirmasi transferan anda <a href='".base_url()."konfirmasi'>disini</a><br>
			      Admin, $iden[nama_website] </body></html> \n";
			
			$this->email->from($iden['email'], $iden['nama_website']);
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
			$this->session->unset_userdata('idp');
			$this->session->unset_userdata('idpenjualan');
			$this->session->unset_userdata('reseller');
			$this->session->unset_userdata('level');
		}
		redirect('members/orders_report/orders');
	}

	function batalkan_transaksi(){
		echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Anda Telah mebatalkan Transaksi!</center></div>');
		$idp = array('id_penjualan' => $this->session->idp);
		$this->model_app->delete('rb_penjualan',$idp);
		$idp_detail = array('id_penjualan' => $this->session->idp);
		$this->model_app->delete('rb_penjualan_detail',$idp_detail);

		$this->session->unset_userdata('idp');
		redirect('members/profile');
	}

	function order(){
		cek_session_reseller_timeout();
		$this->session->set_userdata(array('produk'=>$this->uri->segment(3)));
		$cek = $this->db->query("SELECT b.nama_kota FROM rb_konsumen a JOIN rb_kota b ON a.kota_id=b.kota_id where a.id_konsumen='".$this->session->id_konsumen."'")->row_array();
		redirect('members/reseller?cari_reseller='.$cek['nama_kota']);
	}

	public function username_check(){
        // allow only Ajax request    
        if($this->input->is_ajax_request()) {
	        // grab the email value from the post variable.
	        $username = $this->input->post('a');

            if(!$this->form_validation->is_unique($username, 'rb_konsumen.username')) {          
	         	$this->output->set_content_type('application/json')->set_output(json_encode(array('messageusername' => 'Maaf, Username ini sudah terdaftar,..')));
            }

        }
    }

    public function email_check(){
        // allow only Ajax request    
        if($this->input->is_ajax_request()) {
	        // grab the email value from the post variable.
	        $email = $this->input->post('d');

	        if(!$this->form_validation->is_unique($email, 'rb_konsumen.email')) {          
	         	$this->output->set_content_type('application/json')->set_output(json_encode(array('message' => 'Maaf, Email ini sudah terdaftar,..')));
            }
        }
    }

	function logout(){
		// cek_session_reseller_timeout();
		$this->session->sess_destroy();
		redirect('main');
	}
}
