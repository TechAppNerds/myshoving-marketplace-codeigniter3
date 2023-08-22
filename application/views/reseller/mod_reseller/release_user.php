<head>
<script type="text/javascript">
	function getDate() 
	{
		var f = document.getElementById('announcement');
		setInterval(function() 
		{
			f.style.visibility = (f.style.visibility == 'hidden' ? '' : 'hidden');
		}, 500);
	}
</script>
</head>
<body onload="getDate()">
	<form name="formrelease" id="formrelease" method="post">
		<div class='col-md-12'>
			<div class='box box-info'>
				<div class='box-header with-border'>
					<h3 class='box-title'><b>Release User</b></h3>
					<div class='box-body'>
					<p id="announcement" align="left"><font color="red" size="4"><b>Pastikan user yang akan di-release telah melakukan transfer dan dana efektif telah masuk di rekening perusahaan</b></font></p>

					<table class="table table-condensed table-bordered">
						<tbody>
							<?php echo"<tr bgcolor='#e3e3e3'><th rowspan='35' width='110px'><center><img style='border:1px solid #cecece; height:85px; width:85px' src='".base_url()."asset/foto_user/blank.png' class='img-circle img-thumbnail'></center></th></tr>";?>
							<tr><th width="100px" scope=row">ID reseller</th>       
								<td><input type="text" size="16" id="input_id" name="input_id">&nbsp <input type="submit" name="submit1" value="Cek ID"></td></tr>
							<?php
							    date_default_timezone_set('Asia/Jakarta');
                                $tanggal=date("Y-m-d");
                                $jam=date('H:i:s',strtotime('now'));
                                $gabung=$tanggal." ".$jam;
							?>
							
							<input type='hidden' id='tgl_system' name='tgl_system' value="<?php echo $gabung; ?>" />
					
					<?php
						if(isset($_POST['submit1'])) //jika submit ditekan maka akan dijalankan script dibawah ini
						{
							//echo "<script type='text/javascript'>
							//		alert('Test');
							//	  </script>";
							$id=$_POST['input_id'];
							$tanggal2=$_POST['tgl_system'];
							$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$id);	
							foreach ($cari_reseller->result_array() as $row) 
							{
								$nama=$row[username];
								$status=$row[blokir];								
							}							
							echo"<tr><th scope='row'>Nama reseller</th>
								     <td><input type='text' size='50' name='nama_reseller'  value='$nama' disabled>&nbsp";
							/*if ($status=='N')
							{
							   echo "<script type='text/javascript'>
									alert('User reseller dengan ID $id sudah aktif sebelumnya!');
								  </script>";
							   echo"<input type='submit' value='Release user' name='submit2' disabled></td></tr>";	
							}
							if ($status=='Y')
							{
							   echo"<input type='submit' value='Release user' name='submit2'></td></tr>";	
							}*/
							
							echo"<input type='submit' value='Release user' name='submit2'></td></tr>";
							echo"<input type='hidden'  value='$id' name='idnya'>";
							echo"<input type='hidden'  value='$tanggal2' id='tgl_system2' name='tgl_system2'>";						
					
						}
						
						//jika submit ke-2 ditekan maka akan dijalankan script dibawah ini
						if(isset($_POST['submit2'])) 
						{
							$idnya=$_POST['idnya'];
							//$namanya=$_POST['nama_reseller'];
							$cari_data_reff_work = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$idnya);
							foreach ($cari_data_reff_work->result_array() as $row_reff_work)
							{
								//get id refferal yg mengajak
								$reff_work=$row_reff_work[reff_work];
								$nm_user=$row_reff_work[username];
								$upline1=$row_reff_work[upline];//tampung data upline1
							}
							
							//$this->db->query("update rb_reseller set blokir='N' where id_reseller=".$idnya);	
														
							//---------------- input fee new member di tabel mutasi rekening upline dari reseller yang didaftarkan ----------------------------
							//id perlu dicari karena tabel mutasi_rek campur jadi satu semua reseller
							$keterangan_mutasi='Jasa promosi website new reseller atas nama ';
							$keterangan_komplit=$keterangan_mutasi.$nm_user;
							$type_trx='K';
							$nilai_trx=5000;							
							$jenis_trx='FN';
										
							//cari saldo terakhir upline dari id_reseller yang mendaftar
							$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$reff_work." ORDER BY tanggal DESC LIMIT 1"); 
							//jika data ditemukan maka saldo existing ditambah 5000
							if ($cari_data_mutasi->num_rows()<=0)
							{
								$saldo=5000;
							}
							else
							{
								foreach ($cari_data_mutasi->result_array() as $row_mutasi)
								{
										$saldo=$row_mutasi[saldo]+$nilai_trx;						
								}					
							}
							$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$reff_work." and keterangan='".$keterangan_komplit."'");
							//jika tidak ada data di mutasi rekening berdasar id_refferal dan keterangan identik maka insert data baru
							if ($cari_data_mutasi->num_rows()<=0)
							{
								$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
											   'id_reseller'=>$reff_work,
											   'keterangan'=>$keterangan_komplit,
											   'type'=>$type_trx,
											   'nilai'=>$nilai_trx,
											   'saldo'=>$saldo,
											   'jenis_trn'=>$jenis_trx);
								$this->model_app->insert('mutasi_rek',$data_mutasi);
							}
							//--------------- EOF Fee 5000 ------------------------------
							
							//--------------- mulai start 20 level ke atas ------------------------
							if ($upline1!=9) //id perusahaan
							{
								$keterangan_mutasi='Bonus level new member user ';
								$keterangan_komplit=$keterangan_mutasi.$nm_user;
								$type_trx='K';
								$nilai_trx=100;							
								$jenis_trx='BL';
								
								//------------------ tambah mutasi rek untuk upline #1 ------------------	
								$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline1." ORDER BY saldo DESC LIMIT 1"); 
								//jika data ditemukan maka saldo existing ditambah 100
								if ($cari_data_mutasi->num_rows()<=0)
								{
									$saldo=100;
								}
								else
								{
									foreach ($cari_data_mutasi->result_array() as $row_mutasi)
									{
											$saldo=$row_mutasi[saldo]+$nilai_trx;						
									}					
								}
								$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline1." and keterangan='".$keterangan_komplit."'");
								if ($cari_data_mutasi->num_rows()<=0)
								{
									$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
												   'id_reseller'=>$upline1,
												   'keterangan'=>$keterangan_komplit,
												   'type'=>$type_trx,
												   'nilai'=>$nilai_trx,
												   'saldo'=>$saldo,
												   'jenis_trn'=>$jenis_trx);
									$this->model_app->insert('mutasi_rek',$data_mutasi);
									//$db_tampung=$nilai_trx;
								}
								
								//cari upline 2 (upline dari upline ke-1) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline1);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline2=$row_cari_upline[upline];//tampung data upline2
									
									//------------------ tambah mutasi rek untuk upline #2 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline2." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100;
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline2." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline2,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}									
								}
								
								if ($upline2=='')
								{
									$upline2=-1;	
								}
								//cari upline 3 (upline dari upline ke-2) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline2);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline3=$row_cari_upline[upline];//tampung data upline3
									
									//------------------ tambah mutasi rek untuk upline #3 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline3." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline3." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline3,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}									
								}
								
								if ($upline3=='')
								{
									$upline3=-1;	
								}
								//cari upline 4 (upline dari upline ke-3) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline3);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline4=$row_cari_upline[upline];//tampung data upline4
									
									//------------------ tambah mutasi rek untuk upline #4 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline4." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline4." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline4,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline4=='')
								{
									$upline4=-1;	
								}
								//cari upline 5 (upline dari upline ke-4) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline4);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline5=$row_cari_upline[upline];//tampung data upline5
									
									//------------------ tambah mutasi rek untuk upline #5 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline5." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline5." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline5,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline5=='')
								{
									$upline5=-1;	
								}
								//cari upline 6 (upline dari upline ke-5) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline5);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline6=$row_cari_upline[upline];//tampung data upline6
									
									//------------------ tambah mutasi rek untuk upline #6 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline6." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline6." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline6,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline6=='')
								{
									$upline6=-1;	
								}
								//cari upline 7 (upline dari upline ke-6) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline6);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline7=$row_cari_upline[upline];//tampung data upline7
									
									//------------------ tambah mutasi rek untuk upline #7 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline7." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline7." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline7,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								//cari upline 8 (upline dari upline ke-7) :
								if ($upline7=='')
								{
									$upline7=-1;	
								}
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline7);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline8=$row_cari_upline[upline];//tampung data upline8
									
									//------------------ tambah mutasi rek untuk upline #8 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline8." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline8." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline8,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline8=='')
								{
									$upline8=-1;	
								}
								//cari upline 9 (upline dari upline ke-8) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline8);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline9=$row_cari_upline[upline];//tampung data upline9
									
									//------------------ tambah mutasi rek untuk upline #9 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline9." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline9." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline9,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline9=='')
								{
									$upline9=-1;	
								}
								//cari upline 10 (upline dari upline ke-9) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline9);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline10=$row_cari_upline[upline];//tampung data upline10
									
									//------------------ tambah mutasi rek untuk upline #10 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline10." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline10." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline10,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline10=='')
								{
									$upline10=-1;	
								}
								//cari upline 11 (upline dari upline ke-9) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline10);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline11=$row_cari_upline[upline];//tampung data upline11
									
									//------------------ tambah mutasi rek untuk upline #11 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline11." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline11." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline11,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline11=='')
								{
									$upline11=-1;	
								}
								//cari upline 12 (upline dari upline ke-11) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline11);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline12=$row_cari_upline[upline];//tampung data upline12
									
									//------------------ tambah mutasi rek untuk upline #12 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline12." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline12." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline12,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline12=='')
								{
									$upline12=-1;	
								}
								//cari upline 13 (upline dari upline ke-12) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline12);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline13=$row_cari_upline[upline];//tampung data upline13
									
									//------------------ tambah mutasi rek untuk upline #13 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline13." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline13." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline13,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline13=='')
								{
									$upline13=-1;	
								}
								//cari upline 14 (upline dari upline ke-13) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline13);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline14=$row_cari_upline[upline];//tampung data upline14
									
									//------------------ tambah mutasi rek untuk upline #14 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline14." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline14." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline14,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline14=='')
								{
									$upline14=-1;	
								}
								//cari upline 15 (upline dari upline ke-14) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline14);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline15=$row_cari_upline[upline];//tampung data upline15
									
									//------------------ tambah mutasi rek untuk upline #15 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline15." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline15." and  keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline15,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline15=='')
								{
									$upline15=-1;	
								}
								//cari upline 16 (upline dari upline ke-15) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline15);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline16=$row_cari_upline[upline];//tampung data upline16
									
									//------------------ tambah mutasi rek untuk upline #16 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline16." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline16." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline16,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline16=='')
								{
									$upline16=-1;	
								}
								//cari upline 17 (upline dari upline ke-16) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline16);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline17=$row_cari_upline[upline];//tampung data upline17
									
									//------------------ tambah mutasi rek untuk upline #17 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline17." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline17." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline17,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline17=='')
								{
									$upline17=-1;	
								}
								//cari upline 18 (upline dari upline ke-17) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline17);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline18=$row_cari_upline[upline];//tampung data upline18
									
									//------------------ tambah mutasi rek untuk upline #18 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline18." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline18." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline18,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline18=='')
								{
									$upline18=-1;	
								}
								//cari upline 19 (upline dari upline ke-18) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline18);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline19=$row_cari_upline[upline];//tampung data upline19
									
									//------------------ tambah mutasi rek untuk upline #19 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline19." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline19." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline19,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}
								
								if ($upline19=='')
								{
									$upline19=-1;	
								}
								//cari upline 20 (upline dari upline ke-19) :
								$cari_upline = $this->db->query("SELECT * FROM rb_reseller where id_reseller=".$upline19);	
								foreach ($cari_upline->result_array() as $row_cari_upline) 
								{
									$upline20=$row_cari_upline[upline];//tampung data upline20
									
									//------------------ tambah mutasi rek untuk upline #20 ------------------	
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline20." ORDER BY saldo DESC LIMIT 1"); 
									//jika data ditemukan maka saldo existing ditambah 100
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$saldo=100; //tidak ada data maka nilai $saldo dikembalikan ke default yakni 100
									}
									else
									{
										foreach ($cari_data_mutasi->result_array() as $row_mutasi)
										{
												$saldo=$row_mutasi[saldo]+$nilai_trx;						
										}					
									}
									$cari_data_mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$upline20." and keterangan='".$keterangan_komplit."'");
									if ($cari_data_mutasi->num_rows()<=0)
									{
										$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
													   'id_reseller'=>$upline20,
													   'keterangan'=>$keterangan_komplit,
													   'type'=>$type_trx,
													   'nilai'=>$nilai_trx,
													   'saldo'=>$saldo,
													   'jenis_trn'=>$jenis_trx);
										$this->model_app->insert('mutasi_rek',$data_mutasi);
										//$db_tampung=$db_tampung+$nilai_trx;
									}
								}								
							}
							
							//---------------- EOF Bonus 20 level -----------------------------
							
							//---------------- Pengurangan alokasi nilai penampungan ------------------
							
							$cari_data_db_tampung = $this->db->query("SELECT sum(nilai) as jumlah FROM mutasi_rek where keterangan='".$keterangan_komplit."' and jenis_trn='BL'");
							foreach ($cari_data_db_tampung->result_array() as $row_db_tampung)
							{
								$db_tampung=$row_db_tampung[jumlah];
							}
							
							//---------------- insert mutasi baru ke rekening penampungan (bonus 20 level up @100 = 2000) perusahaan ----------------------
							//untuk rekening penampungan id tidak diperlukan karena yang perlu hanya last saldo ditambah 2000
							$keterangan_mutasi_tampung='Insentif perusahaan terhadap reseller baru atas nama ';
							$keterangan_komplit_tampung=$keterangan_mutasi_tampung.$nm_user;
							$type_trx_tampung='K';							
							$nilai_tampung=2000;//untuk alokasi 20 level keatas @100 masuk ke rek penampungan
							$jenis_trx_tampung='AB'; //alokasi bonus
											
							//cari saldo terakhir
							$cari_data_mutasi_tampung = $this->db->query("SELECT * FROM mutasi_penampungan ORDER BY saldo DESC LIMIT 1"); 
							//jika data ditemukan maka saldo existing ditambah 2000, jika tidak maka insert row baru dengan saldo 2000
							if ($cari_data_mutasi_tampung->num_rows()<=0)
							{
								//jika tidak ada data, maka set saldo awal 2000
								$saldo_tampung=2000;
							}
							else
							{
								foreach ($cari_data_mutasi_tampung->result_array() as $row_mutasi_tampung)
								{
									//jika ada data, maka last data saldo ditambah 2000 untuk menjadi new saldo pada insert data berikutnya
									$saldo_tampung=$row_mutasi_tampung[saldo]+$nilai_tampung;						
								}					
							}
							$nilai_tampung_akhir=$nilai_tampung-$db_tampung;
							$saldo_tampung_akhir=$saldo_tampung-$db_tampung;
							//cek record data tidak boleh ada yg sama dari id new member yang daftar/di release dikarenakan alokasi 2000 (20 level) hanya untuk id_reseller benar-benar baru yang join (unique id)
							$cari_data_mutasi_tampung = $this->db->query("SELECT * FROM mutasi_penampungan where id_reseller=".$idnya);
							if ($cari_data_mutasi_tampung->num_rows()<=0)
							{
								$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
											   'id_reseller'=>$idnya,
											   'keterangan'=>$keterangan_komplit_tampung,
											   'type'=>$type_trx_tampung,
											   'nilai'=>$nilai_tampung_akhir,
											   'saldo'=>$saldo_tampung_akhir,
											   'jenis_trn'=>$jenis_trx_tampung);
								$this->model_app->insert('mutasi_penampungan',$data_mutasi);
							}
							//---------------- EOF Penampungan -----------------------

														
							//------------- cari saldo akhir dari last row 
							/*$cari_data_db_tampung = $this->db->query("SELECT * FROM mutasi_penampungan ORDER BY tanggal DESC LIMIT 1"); 
							if ($cari_data_mutasi_tampung->num_rows()>0)
							{
								foreach ($cari_data_db_tampung->result_array() as $row_db_tampung)
								{
									$saldo_akhir=$row_db_tampung[saldo];
									$saldo_akhir=$row_db_tampung[saldo]-$db_tampung;
									
									$id_lastrow=$row_db_tampung[id_reseller];
									$this->db->query("update mutasi_penampungan set saldo=".$saldo_akhir." where id_reseller=".$id_lastrow);
								}	
							}			
													
							pengurangan penampungan dengan id_yg_ada
							$cari_data_db_tampung = $this->db->query("SELECT * FROM mutasi_penampungan where id_reseller=".$idnya." and keterangan='".$keterangan_komplit_tampung."'");
							foreach ($cari_data_db_tampung->result_array() as $row_db_tampung)
							{
								$saldo_akhir=$row_db_tampung[saldo];
								$nilai_db_tampung=$row_db_tampung[nilai]-$db_tampung;
								$saldo_akhir=$saldo_akhir-$db_tampung;
								
								$this->db->query("update mutasi_penampungan set nilai=".$nilai_db_tampung." where id_reseller=".$idnya);
								$this->db->query("update mutasi_penampungan set saldo=".$saldo_akhir." where id_reseller=".$idnya);								
							}*/					
							
													
							//---------------- EOF pengurangan alokasi penampungan -----------------							
							
							//----------------insert 3000 ke rekening perusahaan----------------
							//untuk perusahaan hanya melihat last saldo ditambah dengan 3000
							$keterangan_mutasi_company='Alokasi perusahaan new member atas nama ';
							$keterangan_komplit_company=$keterangan_mutasi_company.$nm_user;
							$type_trx_company='K';
							$nilai_company=3000;//untuk rekening perusahaan							
							$jenis_trx_company='AP'; //alokasi perusahaan
											
							//cari saldo terakhir
							$cari_data_mutasi_company = $this->db->query("SELECT * FROM mutasi_perusahaan ORDER BY saldo DESC LIMIT 1"); 
							//jika data ditemukan maka saldo existing ditambah 2000, jika tidak maka insert row baru dengan saldo 2000
							if ($cari_data_mutasi_company->num_rows()<=0)
							{
								//jika tidak ada data maka set saldo awal 3000
								$saldo_company=3000;
							}
							else
							{
								foreach ($cari_data_mutasi_company->result_array() as $row_mutasi_company)
								{
									//jika ada data, maka last data saldo ditambah 3000 untuk menjadi new saldo pada insert data berikutnya
									$saldo_company=$row_mutasi_company[saldo]+$nilai_company;						
								}					
							}
							//cek record data tidak boleh ada yg sama dari id new member yang daftar/di release dikarenakan alokasi perusahaan hanya untuk id_reseller benar-benar baru yang join (unique id)
							$cari_data_mutasi_company = $this->db->query("SELECT * FROM mutasi_perusahaan where id_reseller=".$idnya);
							if ($cari_data_mutasi_company->num_rows()<=0)
							{
								//jika tidak ada data maka insert data
								$data_mutasi = array('tanggal'=>$this->input->post('tgl_system'),
											   'id_reseller'=>$idnya,
											   'keterangan'=>$keterangan_komplit_company,
											   'type'=>$type_trx_company,
											   'nilai'=>$nilai_company,
											   'saldo'=>$saldo_company,
											   'jenis_trn'=>$jenis_trx_company);
								$this->model_app->insert('mutasi_perusahaan',$data_mutasi);
							}
							//-------------- EOF Rek perusahaan -------------------
							
							echo "<script type='text/javascript'>
									alert('User reseller dengan ID $idnya telah berhasil diaktifkan');
								  </script>";
							
						}
					?>														
					<tbody>						
					</table>
					</div>
				</div>		
			</div>
		</div>
	</form>
</body>
    