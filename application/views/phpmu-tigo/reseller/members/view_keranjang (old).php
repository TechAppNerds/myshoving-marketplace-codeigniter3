<p class='sidebar-title text-danger produk-title'> Berikut Data Pesanan anda</p>
<?php 
  // var_dump($this->session);
  // var_dump($rows);
  echo "<form action='".base_url()."members/selesai_belanja' method='POST'>";
  echo $error_reseller; 
  if ($this->session->idp == ''){
    echo "<center style='padding:10%'><i class='text-danger'>Maaf, Keranjang belanja anda saat ini masih kosong,...</i><br>
            <a class='btn btn-warning btn-sm' href='".base_url()."members/reseller'>Klik Disini Untuk mulai Belanja!</a></center>";
  }else{
?>
  <table class='table table-condensed'>
  <tbody>
    <?php 
	$kotapelapak=$rows['kota_id'];
	$input=$this->db->query("SELECT * FROM rb_kota where kota_id='".$kotapelapak."'")->row_array();
	$namakotapelapak=$input["nama_kota"];
	
	if (trim($rows['foto'])==''){ $foto_user = 'users.gif'; }else{ $foto_user = $rows['foto']; } ?>
    <tr bgcolor='#e3e3e3'><td rowspan='12' width='110px'><center><?php echo "<img style='border:1px solid #cecece; height:85px; width:85px' src='".base_url()."asset/foto_user/$foto_user' class='img-circle img-thumbnail'>"; ?></center></td></tr>
    <tr><th scope='row' width='120px'>Nama Pelapak</th> <td><?php echo $rows['nama_reseller']?></td></tr>
    <tr><th scope='row'>Alamat lengkap</th> <td><?php echo $rows['alamat_lengkap']?></td></tr>
    <tr><th scope='row'>Kota</th> <td><?php echo $namakotapelapak?></td></tr>
	<tr><th scope='row'>Email</th> <td><?php echo $rows['email']?></td></tr>
    <tr><th scope='row'>Keterangan</th> <td><?php echo $rows['keterangan']?></td></tr>
  </tbody>
  </table>
  <hr>
      <?php 
        echo "<a class='btn btn-success btn-sm' href='".base_url()."members/produk_reseller/$rows[id_reseller]'>Lanjut Belanja</a>
              <a class='btn btn-danger btn-sm' href='".base_url()."members/batalkan_transaksi' onclick=\"return confirm('Apa anda yakin untuk Batalkan Transaksi ini?')\">Batalkan Transaksi</a>"; 
      ?>
      <table class="table table-striped table-condensed">
          <thead>
            <tr bgcolor='#e3e3e3'>
              <th style='width:40px'>No</th>
              <th width='47%'>Nama Produk</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Berat</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
        <?php 
          $no = 1;
          foreach ($record as $row){
          $sub_total = ($row['harga_jual']*$row['jumlah'])-$row['diskon'];
          echo "<tr><td>$no</td>
                    <td><a style='color:#ab0534' href='".base_url()."produk/detail/$row[produk_seo]'>$row[nama_produk]</a></td>
                    <td>".rupiah($row['harga_jual']-$row['diskon'])."</td>
                    <td>$row[jumlah]</td>
                    <td>".($row['berat']*$row['jumlah'])." Gram</td>
                    <td>Rp ".rupiah($sub_total)."</td>
                    <td width='30px'><a class='btn btn-danger btn-xs' title='Delete' href='".base_url()."members/keranjang_delete/$row[id_penjualan_detail]'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>";
            $no++;
          }
          $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total, sum(b.berat*a.jumlah) as total_berat FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk where a.id_penjualan='".$this->session->idp."'")->row_array();
          echo "<tr class='success'>
                  <td colspan='5'><b>Total Berat</b></td>
                  <td><b>$total[total_berat] Gram</b></td>
                  <td></td>
                </tr>
        </tbody>
      </table>

      <div class='col-md-4 pull-right'>
        <center>Total Bayar <h2 id='totalbayar' style='margin-left: 15px;display: inline-block;'></h2>
        <button type='submit' name='submit' id='oksimpan' class='btn btn-success btn-flat btn-sm' style='display: block'>Lakukan Pembayaran</button>
        </center>
      </div>";

      $ket = $this->db->query("SELECT * FROM rb_keterangan where id_reseller='".$rows['id_reseller']."'")->row_array();
      $diskon_total = '0';
	
			
	function add($a,$b,$c,$d)
	{
		//header("Content-Type: text/plain");
		$curl = curl_init();
		curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=$a&destination=$b&weight=$c&courier=$d",
      CURLOPT_HTTPHEADER => array(
        "key: b13ed15e93c7ffd2e598c1d9494ecd10",
        "content-type: application/x-www-form-urlencoded"
      ),
		));

		$response = curl_exec($curl);
		//$response = json_decode($response, TRUE);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) 
		{
		  echo "cURL Error #:" . $err;
		} 
		else 
		{			
			$response=json_decode($response,true);        
      return $response["rajaongkir"]["results"][0]["costs"];
    }
  }	
	
	$input=$this->db->query("SELECT * FROM rb_konsumen where id_konsumen='".$_SESSION['id_konsumen']."'")->row_array();
	$kota=$input["kota_id"];
	
	//cari nama kota
	$input=$this->db->query("SELECT * FROM rb_kota where kota_id='".$kota."'")->row_array();
	$namakota=$input["nama_kota"];
	
	$kotapelapak=$rows['kota_id'];
	$input=$this->db->query("SELECT * FROM rb_kota where kota_id='".$kotapelapak."'")->row_array();
	$namakotapelapak=$input["nama_kota"];
	
	$berat=$total[total_berat];
?>

<script>
	function cekongkir(type_kurir) {
    var arr_ongkir=[];
    if (type_kurir==="jne") arr_ongkir=<?php echo json_encode(add($kotapelapak,$kota,$berat,"jne")); ?>;
    else if (type_kurir==="pos") arr_ongkir=<?php echo json_encode(add($kotapelapak,$kota,$berat,"pos")); ?>;
    else arr_ongkir=<?php echo json_encode(add($kotapelapak,$kota,$berat,"tiki")); ?>;
    console.log(arr_ongkir);
    // console.log(arr_ongkir);
    $("select#jenis_ongkir").css("display","block");
    $("select#jenis_ongkir").empty();
    $.each(arr_ongkir,function (array_key,array_value) {
      if (array_value["service"]!="Paket Kilat Khusus") {
        $("select#jenis_ongkir").append($('<option>', { 'value' : array_value["cost"][0]["value"]+","+array_value["cost"][0]["etd"]+" HARI" }).text(array_value["service"]));
      }else {
        $("select#jenis_ongkir").append($('<option>', { 'value' : array_value["cost"][0]["value"]+","+array_value["cost"][0]["etd"] }).text(array_value["service"]));
      }
    });
	}

  function toRupiah(angka){
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(',').split('').reverse().join('');
    return "Rp. "+ribuan;
  }

  function select_price(price) {
    var ex=price.split(",");
    document.getElementById("harga").innerHTML=ex[0];
    document.getElementById("estimasi").innerHTML=ex[1];
    var subt=<?php echo $sub_total; ?>;
    jum=parseInt(ex[0])+parseInt(subt);
    $("h2#totalbayar").text(toRupiah(jum));
    $('input[name="ongkir"]:hidden').val(ex[0]);
    $('input[name="total_pemb"]:hidden').val(jum);
  }
</script>
	
<input type="hidden" name="total" id="total" value="<?php echo $total['total']; ?>"/>
<input type="hidden" name="ongkir" id="ongkir" value=""/>
<input type="hidden" name="berat" value="<?php echo $total['total_berat']; ?>"/>
<input type="hidden" name="diskonnilai" id="diskonnilai" value="<?php echo $diskon_total; ?>"/>
<input type="hidden" name="total_pemb" id="total_pemb" value=""/>

<div class="form-group">
  <label class="col-sm-2 control-label" for="">Pilih Kurir</label>
  <div class="col-md-10" style="margin-bottom: 50px;">
    <label class="radio-inline">
      <input type="radio" name="kurir" class="kurir" value="jne" onclick="cekongkir(this.value);" /><b>JNE</b>&nbsp; &nbsp; &nbsp; &nbsp; 
      <input type="radio" name="kurir" class="kurir" value="pos" onclick="cekongkir(this.value);" /><b>POS</b>&nbsp; &nbsp; &nbsp; &nbsp; 
      <input type="radio" name="kurir" class="kurir" value="tiki" onclick="cekongkir(this.value);" /><b>TIKI</b>&nbsp; &nbsp; &nbsp; &nbsp; 
    </label>      
  </div>
  <label class="col-sm-2 control-label" for="">Pilih Jenis Layanan</label>
  <div class="col-md-10">    
    <select name="jenis_ongkir" id="jenis_ongkir" onclick="select_price(this.value);" style="display: none;"></select>
  </div>
</div>

<div id="kuririnfo" >
    <div class="form-group">
        <div class="col-md-12">
            <br/><div class='alert alert-info' style='padding:5px; border-radius:0px; margin-bottom:0px'>Service detail<br/>
            <b>Asal :</b> &nbsp;<label id="asal"><?php echo $namakotapelapak; ?></label><br/>
            <b>Tujuan :</b> &nbsp;<label id="tujuan"><?php echo $namakota; ?></label><br/>
            <b>Berat :</b> &nbsp;<label id="berat"><?php echo $berat; ?></label><br/>
            <b>Harga :</b> &nbsp;<label id="harga" name="labelharga"></label><br/>
            <b>Estimasi :</b> &nbsp;<label id="estimasi"></label><br/>
			</div>
        </div>
    </div>
</div>

<?php
  echo form_close();
  echo "<div style='clear:both'></div><hr><br>$ket[keterangan]"; 
}
?>