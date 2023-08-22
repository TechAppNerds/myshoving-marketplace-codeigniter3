<body onload="blinktext()">
	<form name="formwithdraw" id="formwithdraw" method="post" enctype="multipart/form-data">
		<div class='col-md-12'>
			<div class='box box-info'>
				<div class='box-header with-border'>
					<h3 class='box-title'><b>UPDATE STATUS PENARIKAN DANA (WITHDRAWAL)</b></h3>
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
						<p id="announcement" align="left"><font color="red" size="4"><b>Pastikan dana telah benar-benar ditransfer ke rekening reseller sebelum melakukan update menu ini!</b></font></p>
												
						<input type='hidden' id='tgl_system' name='tgl_system'>
											
						<div class="box-header">
							<i class="fa fa-th-list"></i>
							<h3 class="box-title"><b>Data Request Penarikan Mutasi Rekening </b></h3>								
						</div>
							
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th style='width:30px'>No</th>
									<th style='width:100px'>Tanggal</th>
									<th style='width:40px'>ID Reseller</th>
									<th style='width:100px'>Username</th>									
									<th style='width:170px'>Keterangan</th>
									<th style='width:80px' >&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Nominal</th>
									<th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Status</th>
									<th style='width:100px'>Bukti transfer</th>	
								</tr>
							</thead>
							<tbody>
								<?php 
									$no = 1;
									$mutasi = $this->db->query("SELECT * FROM penarikan_dana where status='N' ORDER BY tanggal ASC LIMIT 100");
									foreach ($mutasi->result_array() as $row2)
									{
									//if ($row['proses']=='0'){ $proses = '<i class="text-danger">Pending</i>'; $status = 'Proses'; $icon = 'star-empty'; $ubah = 1; }elseif($row['proses']=='1'){ $proses = '<i class="text-success">Proses</i>'; $status = 'Pending'; $icon = 'star text-yellow'; $ubah = 0; }else{ $proses = '<i class="text-info">Konfirmasi</i>'; $status = 'Proses'; $icon = 'star'; $ubah = 1; }
									//$total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='$row[id_penjualan]'")->row_array();
										echo "<tr><td>$no</td>
												  <td>$row2[tanggal]</td>
												  <td>$row2[id_reseller]</td>
												  <td>$row2[username]</td>
												  <td>$row2[keterangan]</td>
												  <td align='right'>".number_format($row2[nominal])."</td>
												  <td align='center'>$row2[status]</td>
												  <td>$row2[bukti_trf]</td>
											  </tr>";
										  $no++;
									}
									
					echo"</tbody>";
					echo"</table>";
									?>	  
									<br><br><p><b>Inputkan id user yang ingin diproses : &nbsp &nbsp </b><p><input type="text" id="id_user" name="id_user">&nbsp; &nbsp
									<br/><br/><label for="c_name">Upload bukti transfer<span class="required"></label> &nbsp; &nbsp; 
									
									<input type="file" name="filenya" id="filenya" placeholder="Upload bukti transfer" class="required" required />
									
									<br><br><button type="submit" name="submit" class="btn btn-info">Update status penarikan</button>				
									
									<?php												
									
									if(isset($_POST['submit'])) //jika submit ditekan maka akan dijalankan script dibawah ini
									{
										date_default_timezone_set('Asia/Jakarta');
										$date = new DateTime();
										$waktu=$date->getTimestamp();
										$id_waktu=date('dmY',$waktu);
										
										$iduser=$this->input->post('id_user');
										
										$tmp_file = $_FILES['filenya']['tmp_name'];
										$nama_file = $_FILES['filenya']['name'];
										
										
										$namafilenya=$iduser."-".$id_waktu."-".$nama_file;
										
										$path = "images/bukti_transfer/".$namafilenya;
										
																				
										if(move_uploaded_file($tmp_file, $path))
										{
										

											//update status tarik dan bukti transfer
											$this->db->query("update penarikan_dana set status='Y',bukti_trf='".$namafilenya."' where id_reseller=".$iduser);
											
											echo "<script type='text/javascript'>
												   alert('Update tarik dana untuk user yang diinput telah selesai, silakan proses untuk id reseller lainnya!');
												  </script>";												  
												
										}
										echo("<script>location.href = '".base_url()."reseller/update_tarik';</script>");
										
									}								
									
								?>						
					</div>
				</div>		
			</div>
		</div>
	</form>
</body>
    