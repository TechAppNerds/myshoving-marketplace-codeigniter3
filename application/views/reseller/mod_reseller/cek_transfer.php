<body onload="blinktext()">
	<form name="formwithdraw" id="formwithdraw" method="post" enctype="multipart/form-data">
		<div class='col-md-12'>
			<div class='box box-info'>
				<div class='box-header with-border'>
					<h3 class='box-title'><b>CEK BUKTI TRANSFER YANG DI UPLOAD</b></h3>
										
					<div class='box-body'>
																		
						<input type='hidden' id='tgl_system' name='tgl_system'>
											
						<div class="box-header">
							<i class="fa fa-th-list"></i>
							<h3 class="box-title"><b>Data bukti transfer yang telah diupload </b></h3>								
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
									$mutasi = $this->db->query("SELECT * FROM penarikan_dana where status='Y' ORDER BY tanggal ASC LIMIT 100");
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
									<br><br><p><b>Inputkan id user yang bukti transfernya ingin dicek : &nbsp &nbsp </b><p><input type="text" id="id_user" name="id_user">&nbsp; &nbsp
																		
									<br><br><button type="submit" name="submit" class="btn btn-info">Cek bukti transfer</button>				
									
									<?php												
									
									if(isset($_POST['submit'])) //jika submit ditekan maka akan dijalankan script dibawah ini
									{
										/*date_default_timezone_set('Asia/Jakarta');
										$date = new DateTime();
										$waktu=$date->getTimestamp();
										$id_waktu=date('dmY',$waktu);*/
										
										$iduser=$this->input->post('id_user');
								echo"<table class='table table-condensed table-bordered'>";
										$mutasi = $this->db->query("SELECT * FROM penarikan_dana where id_reseller=".$iduser);
										foreach ($mutasi->result_array() as $row2)
										{ 
											echo"<tr><th scope='row'>Tanggal</th>        <td><input class='form-control' type='text' name='tanggal' value='$row2[tanggal]' readonly></td></tr>";
											echo"<tr><th scope='row'>Id Reseller</th>    <td><input class='form-control' type='text' name='id_reseller' value='$row2[id_reseller]' readonly></td></tr>";
											echo"<tr><th scope='row'>Username</th>       <td><input class='form-control' type='text' name='username' value='$row2[username]' readonly></td></tr>";
											echo"<tr><th scope='row'>Keterangan</th>     <td><input class='form-control' type='text' name='keterangan' value='$row2[keterangan]' readonly></td></tr>";
											echo"<tr><th scope='row'>Nominal</th>        <td><input class='form-control' type='text' name='nominal' value='$row2[nominal]' readonly></td></tr>";
											echo"<tr><th scope='row'>Status</th>         <td><input class='form-control' type='text' name='status' value='$row2[status]' readonly></td></tr>";
											echo"<tr><th scope='row'>Bukti transfer</th>  <td><img src='".base_url()."/images/bukti_transfer/".$row2[bukti_trf]."' width='250' height='150'/></td></tr>";
										}
								echo"</table>";
											echo"<a href='".base_url()."reseller/cek_transfer'><button type='button' name='batal' class='btn btn-info'>Cancel</button>";	
									}								
									
								?>						
					</div>
				</div>		
			</div>
		</div>
	</form>
</body>
    