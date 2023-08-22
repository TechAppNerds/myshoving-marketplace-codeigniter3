<head>
<script language="javascript" type="text/javascript">
function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 20;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	document.randform.kode.value = randomstring;
}
</script>
</head>
<body>
	<form name="randform" method="post">
		<div class='col-md-12'>
			<div class='box box-info'>
				<div class='box-header with-border'>
					<h3 class='box-title'><b>CREATE CODE VOUCHER</b></h3>
										
					<div class='box-body'>
																		
						<input type='hidden' id='tgl_system' name='tgl_system'>
											
						<!--div class="box-header">
							<i class="fa fa-th-list"></i>
							<h3 class="box-title"><b>Data bukti transfer yang telah diupload </b></h3>								
						</div-->
						<?php
							date_default_timezone_set('Asia/Jakarta');
							$tanggal=date("Y-m-d");
							$used=0;
						?>
						
						<p>Kode voucher</p>
						<input type="password" name="kode" value=""><br/><br/>
						
						<p>Tanggal</p>
						<input type="text" name="tanggal" id="tanggal" value="<?php echo $tanggal;?>" readonly /><br/><br/>
						
						<p>Nominal</p>
						<input type="text" name="nilai" id="nilai" value="10000" readony /><br/><br/>
						
						<button type="button" name="generate" class="btn btn-info" onClick="randomString()">Create code voucher</button> &nbsp; &nbsp; <button type="submit" name="submit" class="btn btn-info" >Simpan</button>				
									
						<?php							
							if(isset($_POST['submit'])) 
							{
											
								$kode=$_POST['kode'];
								$nilai=$_POST['nilai'];
								$tanggal=$_POST['tanggal'];
								
								//echo"<script>alert('".$nilai."');</script>";
								//echo"<script>alert('".$tanggal."');</script>";
								
								//cari existing voucher apakah ada
								$cek  = $this->model_app->view_where('voucher',array('kode'=>$this->input->post('randomfield')))->num_rows();
								if ($cek>=1)
								{
									echo "<script>alert('Maaf, kode voucher tersebut sudah ada di database!')";
									//window.location=('".base_url()."/auth/register')</script>";
								
								}
								else
								{
									$data = array('kode'=>$kode,
											'nilai'=>$nilai,
											'tanggal'=>$tanggal,
											'used'=>$used);										
											//'tanggal_daftar'=>date('Y-m-d H:i:s'));
									$this->model_app->insert('voucher',$data);
									
									echo"<script>alert('Data voucher berhasil disimpan di database');</script>";
								}
							}
						?>						
					</div>
				</div>		
			</div>
		</div>
	</form>
</body>
    