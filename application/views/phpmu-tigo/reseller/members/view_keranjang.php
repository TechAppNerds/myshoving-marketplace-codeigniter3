<p class='sidebar-title text-danger produk-title'> Berikut Data Pesanan anda</p>
<?php 
// var_dump($this->session);
// echo "<br>";
// var_dump($rows);
  echo "<form action='".base_url()."members/selesai_belanja' method='POST'>";
  echo $error_reseller;
  if ($this->session->idpenjualan == ''){
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
  	
  	if (trim($rows['foto'])==''){ $foto_user = 'users1.gif'; }else{ $foto_user = $rows['foto']; } ?>
      <tr bgcolor='#e3e3e3'><td rowspan='12' width='110px'><center><?php echo "<img style='border:1px solid #cecece; height:85px; width:85px' src='".base_url()."asset/foto_user/$foto_user' class='img-circle img-thumbnail'>"; ?></center></td></tr>
      <tr><th scope='row' width='120px'>Nama Pelapak</th> <td><?php echo $rows['nama_reseller']!=""?$rows['nama_reseller']:"-"; ?></td></tr>
      <tr><th scope='row'>Alamat lengkap</th> <td><?php echo $rows['alamat_lengkap']!=""?$rows['alamat_lengkap']:"-"; ?></td></tr>
      <tr><th scope='row'>Kota</th> <td><?php echo $namakotapelapak!=""?$namakotapelapak:"-"; ?></td></tr>
  	  <!-- <tr><th scope='row'>Email</th> <td><?php echo $rows['email']!=""?$rows['email']:"-"; ?></td></tr> -->
      <tr><th scope='row'>Keterangan</th> <td><?php echo $rows['keterangan']!=""?$rows['keterangan']:"-"; ?></td></tr>
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
          foreach ($record->result_array() as $record_row) {
          $sub_total = ($record_row['harga_jual']*$record_row['jumlah'])-$record_row['diskon'];
          $total_bayar+=$sub_total;
          echo "<tr><td>$no</td>
                    <td><a style='color:#ab0534' href='".base_url()."produk/detail/$record_row[produk_seo]'>$record_row[nama_produk]</a></td>
                    <td>".rupiah($record_row['harga_jual']-$record_row['diskon'])."</td>
                    <td>$record_row[jumlah]</td>
                    <td>".($record_row['berat']*$record_row['jumlah'])." Gram</td>
                    <td>Rp ".rupiah($sub_total)."</td>
                    <td width='30px'><a class='btn btn-danger btn-xs' title='Delete' href='".base_url()."members/keranjang_delete/$record_row[id_penjualan_detail]'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>";
            $no++;
          }
          $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total, sum(b.berat*a.jumlah) as total_berat FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk where a.id_penjualan='".$this->session->idpenjualan."'")->row_array();
          $berat=$total[total_berat];
          echo "<tr class='success'>
                  <td colspan='5'><b>Total Berat</b></td>
                  <td><b>$berat Gram</b></td>
                  <td></td>
                </tr>

        </tbody>
      </table>

      <div class='col-md-4 pull-right'>
        <center>Total Bayar <br><h2 id='totalbayar'>Rp ".rupiah($total_bayar)."</h2>
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
			return $response["rajaongkir"]["results"][0]["costs"][0]["cost"][0]["value"];
		}
	}
	
  $cek1 = $this->db->query("SELECT * FROM `rb_reseller` where `id_reseller`='".$_SESSION['id_konsumen']."'");
  $total1 = $cek1->num_rows();
  $cek2 = $this->db->query("SELECT * FROM `rb_referral` where `id_reseller`='".$_SESSION['id_konsumen']."'");
  $total2 = $cek2->num_rows();
  if ($total1 >= 1) $row = $cek1->row_array();
  else $row = $cek2->row_array();
  
	// $input=$this->db->query("SELECT * FROM rb_konsumen where id_konsumen='".$_SESSION['id_konsumen']."'")->row_array();

  // $kota=$input["kota_id"];
	$kota=$row["kota_id"];
	
	//cari nama kota
	$input=$this->db->query("SELECT * FROM rb_kota where kota_id='".$kota."'")->row_array();
	$namakota=$input["nama_kota"];
	
	$kotapelapak=$rows['kota_id'];
	$input=$this->db->query("SELECT * FROM rb_kota where kota_id='".$kotapelapak."'")->row_array();
	$namakotapelapak=$input["nama_kota"];

?>

<script type="text/javascript">
	function cekongkir()
	{
		if(document.getElementById("kurir0").checked == true) {
			var padd = <?php echo add($kotapelapak,$kota,$berat,"jne");?>; // call function to insert value
			//var layanan=document.getElementById("service").value;
			//alert(layanan);
		}else if(document.getElementById("kurir1").checked == true) {
      var padd = <?php echo add($kotapelapak,$kota,$berat,"pos");?>;
    }else if(document.getElementById("kurir2").checked == true) {
      var padd = <?php echo add($kotapelapak,$kota,$berat,"tiki");?>;
    }
    document.getElementById("harga").innerHTML=padd;
    document.getElementById("ongkir").value=padd;
    $.ajax({
      type:"GET",
      url:"<?php echo site_url('members/totalcost'); ?>",
      data:"ongkir="+padd+"&subtotal="+<?php echo $total_bayar; ?>,
      success: function(response){
        $('#totalbayar').html(response);
      },
      error: function() {
          console.log('something went wrong');
      }
    });
	}
</script>
	
<!-- <input type="hidden" name="total" id="total" value="<?php echo $total['total']; ?>"/> -->
<input type="hidden" name="ongkir" id="ongkir" value="0"/>
<!-- <input type="hidden" name="berat" value="<?php echo $total['total_berat']; ?>"/> -->
<!-- <input type="hidden" name="diskonnilai" id="diskonnilai" value="<?php echo $diskon_total; ?>"/> -->
<div class="form-group">
    <label class="col-sm-1 control-label" for="">Pilih Kurir</label>&nbsp; &nbsp; &nbsp; &nbsp;
    <!-- <div class="col-md-10"> -->
		<label class="radio-inline" style="margin-left: -30px;">
		<input type="radio" name="kurir" class="kurir" id="kurir0" value="jne" onClick="cekongkir()" /><b>JNE</b>&nbsp; &nbsp; &nbsp; &nbsp; 
		<input type="radio" name="kurir" class="kurir" id="kurir1" value="pos" onClick="cekongkir()" /><b>POS</b>&nbsp; &nbsp; &nbsp; &nbsp; 
		<input type="radio" name="kurir" class="kurir" id="kurir2" value="tiki" onClick="cekongkir()" /><b>TIKI</b>&nbsp; &nbsp; &nbsp; &nbsp; 
		</label>        
    <!-- </div> -->
    <div class="col-md-10" style="margin-left: -15px;">
      <label class="col-sm-1 control-label" for="">Pilih Jenis Layanan</label>&nbsp; &nbsp; &nbsp; &nbsp;
      <select name="service" id="service" style="margin-left: -12px;"> 
        <option value="reg">REG</option>
        <option value="ons">ONS</option>
        <option value="yes">YES</option>
      </select>
    </div>
</div>


<div id="kuririnfo" >
    <div class="form-group">
        <div class="col-md-12">
            <br/><div class='alert alert-info' style='padding:5px; border-radius:0px; margin-bottom:0px'>Service detail<br/>
              <b>Asal :</b> &nbsp;<label id="asal"><?php echo $namakotapelapak; ?></label><br/>
        			<b>Tujuan :</b> &nbsp;<label id="tujuan"><?php echo $namakota; ?></label><br/>
        			<b>Berat :</b> &nbsp;<label id="berat"><?php echo $berat; ?></label><br/>
        			<b>Harga :</b> &nbsp;<label id="harga"></label><br/>
	           </div>
        </div>
    </div>
</div>


<?php

echo form_close();

?>
<!-- <script type="text/javascript">
$(document).ready(function(){

$(".kurir").each(function(o_index,o_val){
    $(this).on("change",function()
    {
        var did=$(this).val();
        var berat="";
        var kota="";
        $.ajax(
        {
          method: "get",
          dataType:"html",
          url: "produk/kurirdata",
          data: "kurir="+did+"&berat="+berat+"&kota="+kota,
          beforeSend:function()
          {
            $("#oksimpan").hide();
          }
        })
        .done(function( x ) 
        {           
            $("#kurirserviceinfo").html(x);
            $("#kuririnfo").show();         
        })
        .fail(function(  ) 
        {
            $("#kurirserviceinfo").html("");
            $("#kuririnfo").hide();
        });
    });
});

$("#diskon").html(toDuit(0));
hitung();
});

function hitung(){
    var diskon=$('#diskonnilai').val();
    var total=$('#total').val();
    var ongkir=$("#ongkir").val();
    var bayar=(parseFloat(total)+parseFloat(ongkir));
    if(parseFloat(ongkir) > 0){
        $("#oksimpan").show();
    }else{
        $("#oksimpan").hide();
    }
    $("#totalbayar").html(toDuit(bayar));
}
</script> -->

<?php 
echo "<div style='clear:both'></div><hr><br>$ket[keterangan]"; 
}

?>