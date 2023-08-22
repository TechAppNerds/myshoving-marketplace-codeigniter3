<body onload="blinktext()">
	<form name="formwithdraw" id="formwithdraw" method="post">
		<div class='col-md-12'>
			<div class='box box-info'>
				<div class='box-header with-border'>
					<h3 class='box-title'><b>PENARIKAN DANA (WITHDRAWAL)</b></h3>
					<script type="text/javascript">
					function blinktext() 
					{
						var f = document.getElementById('announcement');
						setInterval(function() 
						{
							f.style.visibility = (f.style.visibility == 'hidden' ? '' : 'hidden');
						}, 500);
						var today = new Date();
						var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
						var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
						var datetime = date+' '+time;
						document.getElementById("tgl_system").value = datetime;	
					}
					</script>
					
					<div class='box-body'>
						<p id="announcement" align="left"><font color="red" size="4"><b>Pastikan dana anda memenuhi jumlah minimum penarikan yakni Rp. 50.000,-</b></font></p>
						<p><font color="red" size="4">Penarikan dana efektif akan diproses dalam waktu 1x24 jam sejak dari permohonan penarikan dilakukan</font></p>
						
						<input type='hidden' id='tgl_system' name='tgl_system'>
											
						<div class="box-header">
							<i class="fa fa-th-list"></i>
						<?php 
							if ($this->session->userdata("reff")==0) {
							
							$status_blokir=$this->db->query("SELECT blokir FROM rb_reseller where id_reseller='".$this->session->id_reseller."'")->row_array();
							if($status_blokir['blokir']!="Y") 
							{	
						?> 	
								<h3 class="box-title"><b>25 Transaksi Mutasi Rekening terbaru</b></h3>
						<?php
							}
							else
							{
						?>
								<h3 class="box-title"><b>Transaksi Mutasi Rekening</b></h3>
						<?php						
							}	
						?>	
						</div>
						<?php
							if($status_blokir['blokir']!="Y") 
							{	
						?> 	
								<table class="table table-bordered table-condensed">
									<thead>
										<tr>
											<th style='width:30px'>No</th>
											<th style='width:40px'>Jenis</th>
											<th style='width:120px'>Tanggal transaksi</th>
											<th style='width:70px'>Type</th>
											<th style='width:190px'>Keterangan</th>
											<th style='width:80px' >&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Nilai</th>
											<th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Saldo</th>						
										</tr>
									</thead>
									<tbody>
										<?php 
											$no = 1;
											$mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$this->session->id_reseller." and status!='T' ORDER BY saldo ASC LIMIT 25");
											foreach ($mutasi->result_array() as $row2)
											{
											//if ($row['proses']=='0'){ $proses = '<i class="text-danger">Pending</i>'; $status = 'Proses'; $icon = 'star-empty'; $ubah = 1; }elseif($row['proses']=='1'){ $proses = '<i class="text-success">Proses</i>'; $status = 'Pending'; $icon = 'star text-yellow'; $ubah = 0; }else{ $proses = '<i class="text-info">Konfirmasi</i>'; $status = 'Proses'; $icon = 'star'; $ubah = 1; }
											//$total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='$row[id_penjualan]'")->row_array();
												echo "<tr><td>$no</td>
														  <td>$row2[type]</td>
														  <td>$row2[tanggal]</td>
														  <td>$row2[jenis_trn]</td>
														  <td>$row2[keterangan]</td>
														  <td align='right'>".number_format($row2[nilai])."</td>
														  <td align='right'>".number_format($row2[saldo])."</td>
													  </tr>";
												  $no++;
											}
											//cari nama user
											$cari_nama_user = $this->db->query("SELECT * FROM rb_reseller where id_reseller='".$this->session->id_reseller."'");
											foreach ($cari_nama_user->result_array() as $row_cari_nama)
											{
												
												$nama_user=$row_cari_nama[username];
												$id_user=$row_cari_nama[id_reseller];
											}
								echo"</tbody>";
								echo"</table>";
							}
							else
							{
							?>	
								<table class="table table-bordered table-condensed">
									<thead>
									  <tr>
										<th style='width:30px'>No</th>
										<th style='width:50px'>Jenis transaksi</th>
										<th style='width:30px'>Type</th>
										<th style='width:80px'>Saldo</th>						
									  </tr>
									</thead>									
								<tbody>							
							<?php 
													
									$mutasi = $this->db->query("SELECT sum(saldo) as saldo FROM mutasi_rek where id_reseller=".$this->session->id_reseller);
									foreach ($mutasi->result_array() as $row2)
									{
										echo "<tr><td>1</td>
												  <td>Transaksi internal member</td>
												  <td>GTU</td>
												  <td align='left'>".number_format($row2[saldo])."</td>
											  </tr>";						
									}	
								echo"</tbody>";
								echo"</table>";							
							}													  
									if ($row2[saldo]<50000)
									{
										echo "<p><br><b><font color='blue' size='4'>Jumlah saldo akhir adalah : ".number_format($row2[saldo])."</font><font color='red' size='4'> (belum memenuhi batas minimum penarikan)</font></b></p>";
										echo "<br><button type='submit' name='submit' class='btn btn-info' disabled>Request penarikan</button>";
									}elseif($row2[saldo]>=50000 && $status_blokir["blokir"]=="Y"){
										echo "<p><b><font color='blue' size='4'>Jumlah saldo akhir yang bisa diambil adalah (sebelum dikurangi biaya transfer antar Bank) : ".number_format($row2[saldo])." </font></b></p><br>";
										echo "<p><b><font color='blue' size='4'>Kalau ingin melakukan penarikan segera aktivasi member anda dengan melakukan transfer sebesar 50.000 ke rekening perusahaan BCA : 8621118811 atas nama Anthonius Effendy SE</font></b></p>";
										echo "<br><button type='submit' name='submit' class='btn btn-info' disabled>Request penarikan</button>";					
									}else{
										echo "<p><b><font color='blue' size='4'>Jumlah saldo akhir yang bisa diambil adalah (sebelum dikurangi biaya transfer antar Bank) : ".number_format($row2[saldo])." </font></b></p>";
										echo "<br><button type='submit' name='submit' class='btn btn-info'>Request penarikan</button>";
									}
								} else { // jika reff=1
									echo "Comming Soon";
								}
									
														
									if(isset($_POST['submit'])) //jika submit ditekan maka akan dijalankan script dibawah ini
									{
										//echo "<script type='text/javascript'>
										//		alert('Nama user : $nama_user');
										//	  </script>";
										$tanggal=$_POST['tgl_system'];
										if ($id_user=='')
										{
											$id_user=-1;	
										}
										$cari_reseller = $this->db->query("SELECT * FROM penarikan_dana where id_reseller=".$id_user." and status='N'");	
										if ($cari_reseller->num_rows()<=0)
										{
											//jika tidak ada maka insert data
											$status='N';
											$keterangan='Request penarikan dana';
											$data_withdraw = array('tanggal'=>$tanggal,
															'id_reseller'=>$id_user,
															'username'=>$nama_user,
															'keterangan'=>$keterangan,
															'nominal'=>$row2[saldo],
															'status'=>$status);
											$this->model_app->insert('penarikan_dana',$data_withdraw);
											
											//update status di tabel mutasi dengan status T yg artinya 'Tarik'
											$mutasi=$this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$this->session->id_reseller." and status!='T' ORDER BY saldo ASC LIMIT 25");
											foreach ($mutasi->result_array() as $row2)
											{
												$this->db->query("update mutasi_rek set status='T' where id_reseller=".$this->session->id_reseller);													
												
											}
											
											//dari mutasi rekening yang berstatus T diatas dipindah datanya ke tabel history tarik dana
											$this->db->query("insert into history_tarik_dana select * from mutasi_rek where id_reseller=".$this->session->id_reseller." and status='T'");
											
											//delete data di mutasi_rek yang berstatus T
											$this->db->query("delete from mutasi_rek where id_reseller=".$this->session->id_reseller." and status='T'");
											
											echo "<script type='text/javascript'>
													alert('Permohonan tarik dana telah berhasil disubmit, mohon tunggu dalam waktu 1x24 jam untuk diproses');
												  </script>";
										}						
										else
										{
											//jika ada record
											echo "<script type='text/javascript'>
													alert('Permohonan tarik dana belum bisa dilakukan untuk saat ini, sebab pada sistem masih tercatat permohonan yang masih diproses!');
												  </script>";
										}
									}
																
									
								?>						
					</div>
				</div>		
			</div>
		</div>
	</form>
</body>
    