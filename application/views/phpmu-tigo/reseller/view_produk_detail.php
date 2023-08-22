<html>
<style>
body{
    margin-top:20px;
    background:#FDFDFD;
}

@media (min-width: 0) {
    .g-mr-15 {
        margin-right: 1.07143rem !important;
    }
}

@media (min-width: 0){
    .g-mt-3 {
        margin-top: 0.21429rem !important;
    }
}

.g-height-50 {
    height: 50px;
}

.g-width-50 {
    width: 50px !important;
}

@media (min-width: 0){
    .g-pa-30 {
        padding: 2.14286rem !important;
    }
}

.g-bg-secondary {
    background-color: #fafafa !important;
}

.u-shadow-v18 {
    box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.15);
}

.g-color-gray-dark-v4 {
    color: #777 !important;
}

.g-font-size-12 {
    font-size: 0.85714rem !important;
}

.media-comment {
    margin-top:20px
}    
</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</html>
<?php
// var_dump($this->session);
echo $this->session->flashdata('message');
$cek = $this->db->query("SELECT * FROM `rb_reseller` where `id_reseller`='".$record["id_reseller"]."'");
if ($cek->num_rows() > 0) 
    $table="rb_reseller";
else{
    $cek1 = $this->db->query("SELECT * FROM `rb_referral` where `id_reseller`='".$record["id_reseller"]."'");
    if ($cek1->num_rows() > 0) 
        $table="rb_referral";    
}
$rows = $this->db->query("SELECT a.*, b.nama_kota, c.nama_provinsi FROM `".$table."` a JOIN rb_kota b ON a.kota_id=b.kota_id
JOIN rb_provinsi c ON b.provinsi_id=c.provinsi_id where a.id_reseller='$record[id_reseller]'")->row_array();
echo "<div class='col-md-12'>
    <div class='col-md-9' style='padding:0px'>
        <div class='col-md-3' style='padding:0px'>";
        if ($record['gambar'] != ''){ 
            $ex = explode(';',$record['gambar']);
            $hitungex = count($ex);
            for($i=0; $i<1; $i++){
                if (file_exists("asset/foto_produk/".$ex[$i])) { 
                    if ($ex[$i]==''){
                        echo "<img style='height:120px; width:100%;  border:1px solid #cecece' src='".base_url()."asset/foto_produk/no-image.jpg'>";
                    }else{
                        echo "<a target='_BLANK'  href='".base_url()."asset/foto_produk/".$ex[$i]."'><img class='' style='width:100%; border:1px solid #cecece' src='".base_url()."asset/foto_produk/".$ex[$i]."'></a>";
                    }
                }else{
                    echo "<img style='height:120px; width:100%;  border:1px solid #cecece' src='".base_url()."asset/foto_produk/no-image.jpg'>";
                }
            }

            echo "<center style='margin-top:5px'>";
            for($i=1; $i<$hitungex; $i++){
                if (file_exists("asset/foto_produk/".$ex[$i])) { 
                    if ($ex[$i]==''){
                        echo "<img style='width:24%; border:1px solid #fff' src='".base_url()."asset/foto_produk/no-image.jpg'>";
                    }else{
                        echo "<a target='_BLANK'  href='".base_url()."asset/foto_produk/".$ex[$i]."'><img class='' style='width:24%; border:1px solid #fff' src='".base_url()."asset/foto_produk/".$ex[$i]."'></a>";
                    }
                }else{
                    echo "<img style='width:24%;  border:2px solid #fff' src='".base_url()."asset/foto_produk/no-image.jpg'>";
                }
            }
            echo "</center>";
        }else{
            echo "<i style='color:red'>Gambar / Foto untuk Produk ini tidak tersedia!</i>";
        }
        $kat = $this->model_app->view_where('rb_kategori_produk',array('id_kategori_produk'=>$record['id_kategori_produk']))->row_array();
        // $jual = $this->model_reseller->jual_reseller($record['id_reseller'],$record['id_produk'])->row_array();
        // $beli = $this->model_reseller->beli_reseller($record['id_reseller'],$record['id_produk'])->row_array();
        $jumlah_produk = $this->model_app->view_where("rb_produk",array("id_produk"=>$record['id_produk']))->row()->jumlah;
        $disk = $this->db->query("SELECT * FROM rb_produk_diskon where id_produk='$record[id_produk]'")->row_array();
        $diskon = rupiah(($disk['diskon']/$record['harga_konsumen'])*100,0)."%";
        if ($disk['diskon']>=1){ 
            $diskon_persen = "<div class='top-right'>$diskon</div>";
            $harga_konsumen =  "Rp ".rupiah($record['harga_konsumen']-$disk['diskon']);
            $harga_asli = "Rp ".rupiah($record['harga_konsumen']);
        }else{
            $diskon_persen = '';
            $harga_konsumen =  "Rp ".rupiah($record['harga_konsumen']);
            $harga_asli = "";
        }

        echo "<div style='clear:both'></div><center style='color:green;'><i>Klik untuk lihat ukuran besar.</i></center>";
        
        echo '
        <style>
            .progress {
                height: 31px;
                margin-bottom: 10px
            }

            .progress .skill {
                font: normal 12px "Open Sans Web";
                line-height: 32px;
                padding: 0;
                margin: 0 0 0 20px;
                text-transform: uppercase
            }

            .progress .skill .val {
                float: right;
                font-style: normal;
                margin: 0 20px 0 0
            }

            .progress-bar {
                text-align: left;
                transition-duration: 3s
            }

            .bsp_big-image {
                box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0);
                border-radius: 5px;
                margin-top: 0px
            }
        </style>
        <script>$(document).ready(function() {
            $(\'.progress .progress-bar\').css("width",
            function() {
            return $(this).attr("aria-valuenow") + "%";
            }
            )
        });</script>';
        $rate_star_1 = $this->db->query("SELECT `star` FROM `testimoni` WHERE `id_barang` = ".$record['id_produk']." AND `star` = 1")->result_array();
        $rate_star_2 = $this->db->query("SELECT `star` FROM `testimoni` WHERE `id_barang` = ".$record['id_produk']." AND `star` = 2")->result_array();
        $rate_star_3 = $this->db->query("SELECT `star` FROM `testimoni` WHERE `id_barang` = ".$record['id_produk']." AND `star` = 3")->result_array();
        $rate_star_4 = $this->db->query("SELECT `star` FROM `testimoni` WHERE `id_barang` = ".$record['id_produk']." AND `star` = 4")->result_array();
        $rate_star_5 = $this->db->query("SELECT `star` FROM `testimoni` WHERE `id_barang` = ".$record['id_produk']." AND `star` = 5")->result_array();
        $jumlah_star_1 = 0.0;
        $jumlah_star_2 = 0.0;
        $jumlah_star_3 = 0.0;
        $jumlah_star_4 = 0.0;
        $jumlah_star_5 = 0.0;
        $total_star = 0.0;
        $con = 0.0;
        foreach ($rate_star_1 as $star1) {
            $con=$con+1.0;
            $jumlah_star_1 = $jumlah_star_1 + 1.0;
        }
        foreach ($rate_star_2 as $star2) {
            $con=$con+1.0;
            $jumlah_star_2 = $jumlah_star_2 + 1.0;
        }
        foreach ($rate_star_3 as $star3) {
            $con=$con+1.0;
            $jumlah_star_3 = $jumlah_star_3 + 1.0;
        }
        foreach ($rate_star_4 as $star4) {
            $con=$con+1.0;
            $jumlah_star_4 = $jumlah_star_4 + 1.0;
        }
        foreach ($rate_star_5 as $star5) {
            $con=$con+1.0;
            $jumlah_star_5 = $jumlah_star_5 + 1.0;
        }
        $total_star = $jumlah_star_1+$jumlah_star_2+$jumlah_star_3+$jumlah_star_4+$jumlah_star_5;
        $rata_star = 0.0;
        $rata_star = (($jumlah_star_1*1.0)+($jumlah_star_2*2.0)+($jumlah_star_3*3.0)+($jumlah_star_4*4.0)+($jumlah_star_5*5.0))/$con;
        if($con ==0.0){
            $rata_star = 0;
        }
        echo '<h1 style="font-size:50px; display: inline-block;">'.round($rata_star,1).'<span style="font-size:20px;">/5</span></h1> 
        <div class="progress skill-bar" style="background-color:rgb(255, 196, 0);">
                 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="'.$total_star.'" style="width:'.($jumlah_star_5/$total_star * 100).'%"> <span class="skill" style="font-weight:bold;color:yellow;"> ★5<span style="font-size:45px;color:white;font-weight:lighter;">|</span><i class="val" style="font-weight:bold;color:white;">'.$jumlah_star_5.'</i></span> </div>
             </div>
             <div class="progress skill-bar" style="background-color:rgb(255, 196, 0);">
                 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="'.$total_star.'" style="width:'.($jumlah_star_4/$total_star * 100).'%"> <span class="skill" style="font-weight:bold;color:yellow;"> ★4<span style="font-size:45px;color:white;font-weight:lighter;">|</span><i class="val" style="font-weight:bold;color:white;">'.$jumlah_star_4.'</i></span> </div>
             </div>
             <div class="progress skill-bar" style="background-color:rgb(255, 196, 0);">
                 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="'.$total_star.'" style="width:'.($jumlah_star_3/$total_star * 100).'%"> <span class="skill" style="font-weight:bold;color:yellow;"> ★3<span style="font-size:45px;color:white;font-weight:lighter;">|</span><i class="val" style="font-weight:bold;color:white;">'.$jumlah_star_3.'</i></span> </div>
             </div>
             <div class="progress skill-bar" style="background-color:rgb(255, 196, 0);">
                 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="'.$total_star.'" style="width:'.($jumlah_star_2/$total_star * 100).'%"> <span class="skill" style="font-weight:bold;color:yellow;"> ★2<span style="font-size:45px;color:white;font-weight:lighter;">|</span><i class="val" style="font-weight:bold;color:white;">'.$jumlah_star_2.'</i></span> </div>
             </div>
             <div class="progress skill-bar" style="background-color:rgb(255, 196, 0);">
                 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="'.$total_star.'" style="width:'.($jumlah_star_1/$total_star * 100).'%"> <span class="skill" style="font-weight:bold;color:yellow;"> ★1<span style="font-size:45px;color:white;font-weight:lighter;">|</span><i class="val" style="font-weight:bold;color:white;">'.$jumlah_star_1.'</i></span> </div>
             </div>';
        echo "</div>

        <div class='col-md-9' style='padding:0px'>
            <div style='margin-left:10px'>
            <h1>$record[nama_produk]</h1>"; ?>
            
            <div class='addthis_toolbox addthis_default_style'>
              <a class='addthis_button_preferred_1'></a>
              <a class='addthis_button_preferred_2'></a>
              <a class='addthis_button_preferred_3'></a>
              <a class='addthis_button_preferred_4'></a>
              <a class='addthis_button_compact'></a>
              <a class='addthis_counter addthis_bubble_style'></a>
            </div>
              <script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f8aab4674f1896a'></script>
          
            <?php 
                echo "<form action='".base_url()."produk/keranjang' method='POST'>
                        <table class='table table-condensed' style='margin-bottom:0px'>
                            <tr><td colspan='2' style='color:red;'><del style='color:#8a8a8a'>$harga_asli</del><br>
                            <h1 style='display:inline-block'>$harga_konsumen</h1> / $record[satuan] ";
                            // <a target='_BLANK' style='border-radius:15px 0px 0px 15px' class='btn btn-danger btn-sm pull-right' href='https://api.whatsapp.com/send?phone=$rows[no_telpon]&amp;text=$record[nama_produk],... Apakah%20produk%20Ini%20bisa%20Nego?...'>Coba Nego Pelapak</a>
                            echo "<button type='button' style='border-radius:15px 0px 0px 15px' class='btn btn-danger btn-sm pull-right' data-toggle='modal' data-target='#myModal'>Coba Nego Pelapak</button>";
                            // echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                            //       Launch demo modal
                            //     </button>';
                            


                            echo "</td></tr>
                            <tr><td style='font-weight:bold; width:90px'>Berat</td> <td>$record[berat] Gram</td></tr>
                            <tr><td style='font-weight:bold'>Kategori</td> <td><a href='".base_url()."produk/kategori/$kat[kategori_seo]'>$kat[nama_kategori]</a></td></tr>";
                if ($jumlah_produk >= 1){
                    $stok="ada";
					echo "<tr><td style='font-weight:bold'>Tersedia</td> <td class='text-success'>".$jumlah_produk." stok barang</td></tr>";
                }else{
                    $stok="tidak ada";
					echo "<tr><td style='font-weight:bold'>Stok</td> <td>Tidak Tersedia</td></tr>";
                }
                if ($stok=="ada") {?>
                    <input type='hidden' name='id_reseller' value='<?php echo $record[id_reseller];?>'>
                    <input type='hidden' name='id_produk' value='<?php echo $record[id_produk];?>'>
                    <tr>
                        <td><span style='font-weight:bold'>Jumlah Beli</span></td>
                        <td><div class="form-group" style="width:125px;">
                                <input id="colorful1" class="form-control" name="jumlah" type="number" value="1" min="1" max="<?php echo $jumlah_produk;?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                            </div></td>
                    </tr>
                    </table>
                    <div class='alert alert-warning' style='border-radius:0px'>
                      <span style='color:orange' class='glyphicon glyphicon-ok'></span>
                      <b>Jaminan 100% Aman</b><br>
                      Uang pasti kembali. Sistem pembayaran bebas penipuan.<br>
                      Barang tidak sesuai pesanan? Ikuti langkah retur barang di sini.
                    </div>
                    <?php
                        
                        if(isset($this->session->id_konsumen)){
                            if($wish[0]['status_wish']==0){
                                echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    $("#wish_div").click(function(){
                                        $.ajax({
                                            url     : "'.site_url("produk/wish").'",
                                            type    : "POST",
                                            data    : {
                                                wish   : ';echo $record['id_produk']; echo '
                                            },
                                            success : function(result){
                                                $("#wish_div").html(result);
                                            }
                                        });
                                    });
                                });
                            </script>
                            <div id="wish_div" style="display: contents;">
                                <button class="btn btn-secondary btn-lg" id="wish" type="button"><i class="fa fa-heart"></i> Wishlist</button>
                            </div>';
                            }
                            elseif($wish[0]['status_wish']==1){
                                echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    $("#wish_div").click(function(){
                                        $.ajax({
                                            url     : "'.site_url("produk/wish").'",
                                            type    : "POST",
                                            data    : {
                                                wish   : ';echo $record['id_produk']; echo '
                                            },
                                            success : function(result){
                                                $("#wish_div").html(result);
                                            }
                                        });
                                    });
                                });
                            </script>
                            <div id="wish_div" style="display: contents;">
                                <button class="btn btn-danger btn-lg" id="wish" type="button"><i class="fa fa-heart"></i> Wishlist</button>
                            </div>';
                            }
                        }
                    ?>
                    
                    <button class='btn btn-success btn-lg' type='submit'>Beli Sekarang</button>
                    </form>

                    <?php
                    echo '<!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color:black;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Nego</h4>
                                            </div>
                                            <div class="modal-body row">
                                                <form action="'.base_url().'produk/proses_nego/1" method="POST">
                                                <div class="form-group" style="margin-bottom:0px;">
                                                    <label class="col-sm-2 control-label">Jumlah</label>
                                                    <div style="width:125px; padding:15px;">
                                                        <input id="colorful3" class="form-control" name="jumlah_nego" type="number" value="1" min="1" max="'.$jumlah_produk.'" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="update_total()"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Harga Satuan</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" id="harga_tawar" class="form-control" name="harga_nego" value="1" min="1"  placeholder="Harga Satuan" max="'.$record['harga_konsumen'].'" onchange="update_total()">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" style="padding-top:15px;">Harga Total</label>
                                                    <div class="col-sm-10">
                                                        <h2 id="harga_total_modal" style="color:green">Rp 1.00</h2>
                                                    </div>
                                                </div>';
                                            echo "<script>

                                                function update_total(){
                                                  const formatter = new Intl.NumberFormat('en-US', {
                                                      minimumFractionDigits: 2
                                                    })
                                                    var jumlah = document.getElementById('colorful3').value;
                                                    var harga = document.getElementById('harga_tawar').value;
                                                    var total = (jumlah * harga);
                                                    document.getElementById('harga_total_modal').innerHTML = 'Rp '+formatter.format(total);
                                                }
                                            </script>
                                            <div class='form-group'>
                                            <div class='col-sm-12'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary'>Send Negotiation</button>
                                            </div>
                                            </div>
                                            <input type='hidden' name='id_reseller' value='".$record['id_reseller']."'>
                                            <input type='hidden' name='id_produk' value='".$record['id_produk']."'>
                                            <input type='hidden' name='satuan' value='".$record['satuan']."'>
                                            </form>
                                            ";
                                            echo '</div>
                                        </div>
                                    </div>
                                </div>';
                    ?>
                <?php }else{ ?>
                    </table>
                    <center><a class='btn btn-success btn-block btn-lg' href='#' disabled>Tidak bisa dibeli, karena stok kosong</a></center>
                <?php }?>
            <?php /*if ($this->session->level=='konsumen'){
                if ($stok=="ada")
				{
                    echo "<input type='hidden' name='id_reseller' value='$record[id_reseller]'>";
                    echo "<input type='hidden' name='id_produk' value='$record[id_produk]'>";
                    //jumlah beli
                    echo "<tr><td><span style='font-weight:bold'>Jumlah Beli</span></td><td>";
                    echo '<div class="form-group" style="width:125px;>
                        <input id="colorful1" class="form-control" name="jumlah" type="number" value="1" min="1" max="'.($beli['beli']-$jual['jual']).'""/>
                    </div></td></tr>';
                            
                            echo "</table>";
                    echo "<div class='alert alert-warning' style='border-radius:0px'>
                      <span style='color:orange' class='glyphicon glyphicon-ok'></span>
                      <b>Jaminan 100% Aman</b><br>
                      Uang pasti kembali. Sistem pembayaran bebas penipuan.<br>
                      Barang tidak sesuai pesanan? Ikuti langkah retur barang di sini.
                    </div>";
                    echo "<center><button class='btn btn-success btn-block btn-lg' type='submit'>Beli Sekarang</button></center>";

                    echo "</form>";
				}
				else
				{
                    echo "</table>";
					echo "<center><a class='btn btn-success btn-block btn-lg' href='#' disabled>Tidak bisa dibeli, karena stok kosong</a></center>";
				}
			}
			else
			{
                if ($stok=="ada")
				{
                    echo "<input type='hidden' name='id_reseller' value='$record[id_reseller]'>";
                    echo "<input type='hidden' name='id_produk' value='$record[id_produk]'>";
                    //jumlah beli
                    echo "<tr><td><span style='font-weight:bold'>Jumlah Beli</span></td>
                            <td>";
                    echo '<div class="form-group" style="width:125px;">
                        <input id="colorful2" class="form-control" name="jumlah" type="number" value="1" min="1" max="'.($beli['beli']-$jual['jual']).'"/>
                    </div></td></tr>';
                    echo "</table>";
                    echo "<div class='alert alert-warning' style='border-radius:0px'>
                      <span style='color:orange' class='glyphicon glyphicon-ok'></span>
                      <b>Jaminan 100% Aman</b><br>
                      Uang pasti kembali. Sistem pembayaran bebas penipuan.<br>
                      Barang tidak sesuai pesanan? Ikuti langkah retur barang di sini.
                    </div>";
					echo "<center><button class='btn btn-success btn-block btn-lg' type='submit'>Beli Sekarang</button></center>";
				    echo "</form>";
                }
				else
				{
                    echo "</table>";
					echo "<center><a class='btn btn-success btn-block btn-lg' href='#' disabled>Tidak bisa dibeli sekarang, karena stok kosong</a></center>";	
				}
			}*/
            $id_produksekarang=$record[id_produk]; ?>
       <br><a target='_BLANK' class='btn btn-default btn-sm' href='https://api.whatsapp.com/send?phone=$rows[no_telpon]&amp;text=$record[nama_produk],... Apakah%20Stok%20Masih%20ada?...'><span class='glyphicon glyphicon-comment'></span>  Apakah Stok Masih ada?</a> 
                <a target='_BLANK' class='btn btn-default btn-sm' href='https://api.whatsapp.com/send?phone=$rows[no_telpon]&amp;text=$record[nama_produk],... Saya%20Pesan%20Sekarang%20ya!'><span class='glyphicon glyphicon-comment'></span> Saya Pesan Sekarang ya!</a>
                <a target='_BLANK' class='btn btn-default btn-sm' href='https://api.whatsapp.com/send?phone=$rows[no_telpon]&amp;text=Haloo!%20Saya%20dapat%20info%20dari%20myshoving.com,%20$rows[nama_reseller],%20Saya%20Mau%20Order%20Produknya...'><span style='color:green' class='glyphicon glyphicon-certificate'></span> Chat dengan Pelapak.</a>
        </div>
        </div>
        <div class='col-md-12' style='padding:0px'>
            <div class='panel-body'>
                <ul class='myTabs nav nav-tabs' role='tablist'>
                  <li role='presentation' class='active'><a href='#deskripsi' id='deskripsi-tab' role='tab' data-toggle='tab' aria-controls='deskripsi' aria-expanded='true'>DESKRIPSI </a></li>
                  <li role='presentation' class=''><a href='#diskusi' role='tab' id='diskusi-tab' data-toggle='tab' aria-controls='diskusi' aria-expanded='false'>DISKUSI BARANG</a></li>
                  <li role='presentation' class=''><a href='#testimoni' role='tab' id='testimoni-tab' data-toggle='tab' aria-controls='diskusi' aria-expanded='false'>TESTIMONI BARANG</a></li>
                </ul><br>
                <div id='myTabContent' class='tab-content'>
                    <div role='tabpanel' class='tab-pane fade active in' id='deskripsi' aria-labelledby='deskripsi-tab'>
                        <?php echo $record[keterangan];  ?>
                    </div>
                    <div role='tabpanel' class='tab-pane fade' id='diskusi' aria-labelledby='diskusi-tab'>
                        <div class='block-content'>
                            <div class='comment-block'>
                                <div class='fb-comments' data-href= '<?php echo base_url()?>produk/detail/$record[produk_seo]' data-width='830' data-numposts='5' data-colorscheme='light'></div> 
                            </div>
                        </div>
                    </div>
                    <div role='tabpanel' class='tab-pane fade' id='testimoni' aria-labelledby='testimoni-tab'>
                        <div id="" style="overflow:scroll; height:300px;margin-top:20px;">
                    <?php foreach($testimoni as $value) {
                        if($value->id_barang==$id_produksekarang) {?>
                        <div class='block-content'>
                            <div class='comment-block'>
                                <div class='row' style='width:150%'>
                                    <div class='col-md-8'>
                                        <div class='media g-mb-30 media-comment'>
                                            <div class='media-body u-shadow-v18 g-bg-secondary g-pa-30'>
                                                <div class='g-mb-15'>
                                                    <h5 class='h5 g-color-gray-dark-v1 mb-0'>
                                                    
                                                        <?php $nama_konsumen="";
                                                            $query = $this->db->query("SELECT nama_lengkap FROM rb_konsumen where id_konsumen ='$value->id_konsumen'");
                                                            foreach ($query->result_array() as $row){
                                                                $nama_konsumen=$row['nama_lengkap'];
                                                            }

                                                            if($nama_konsumen=="")
                                                            {
                                                                $query2 = $this->db->query("SELECT nama_reseller FROM rb_reseller where id_reseller ='$value->id_konsumen'");
                                                                foreach ($query2->result_array() as $row2){
                                                                     $nama_konsumen=$row2['nama_reseller'];
                                                                    }
                                                            }
                                                            if($nama_konsumen=="")
                                                            {

                                                                $query3 = $this->db->query("SELECT nama_reseller FROM rb_referral where id_reseller ='$value->id_konsumen'");
                                                                foreach ($query3->result_array() as $row3){
                                                                        $nama_konsumen=$row3['nama_reseller'];
                                                                    }
                                                            }
                                                            echo $nama_konsumen."</br>";
                                                        
                                                            for ($i=0; $i < $value->star; $i++) { 
                                                                echo "<span style='color:yellow;font-size:15px; -webkit-text-stroke: 0.5px #000;'>★</span>";
                                                            }
                                    
                                                        ?></h5>
                                                    <span class='g-color-gray-dark-v4 g-font-size-12'><?php echo $value->waktu_testimoni ?></span>
                                                </div>

                                              <p><?php echo $value->isi_testimoni ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    }?>
                        </div>   
                    </div>
                </div>
            </div>        
        </div>

    </div>

    <div class='col-md-3' style='padding:0px'>
    <?php include "sidebar_pelapak.php"; ?>
    </div>

</div>
<div style='clear:both'><br></div>

<script type="text/javascript">
    
/* ========================================================================
 * bootstrap-spin - v1.0
 * https://github.com/wpic/bootstrap-spin
 * ========================================================================
 * Copyright 2014 WPIC, Hamed Abdollahpour
 *
 * ========================================================================
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

(function ( $ ) {

    $.fn.bootstrapNumber = function( options ) {

        var settings = $.extend({
            upClass: 'default',
            downClass: 'default',
            upText: '+',
            downText: '-',
            center: true
            }, options );

        return this.each(function(e) {
            var self = $(this);
            var clone = self.clone(true, true);

            var min = self.attr('min');
            var max = self.attr('max');
            var step = parseInt(self.attr('step')) || 1;

            function setText(n) {
                if (isNaN(n) || (min && n < min) || (max && n > max)) {
                    return false;
                }

                clone.focus().val(n);
                clone.trigger('change');
                return true;
            }

            var group = $("<div class='input-group'></div>");
            var down = $("<button type='button'>" + settings.downText + "</button>").attr('class', 'btn btn-' + settings.downClass).click(function() {
                setText(parseInt(clone.val() || clone.attr('value')) - step);
            });
            var up = $("<button type='button'>" + settings.upText + "</button>").attr('class', 'btn btn-' + settings.upClass).click(function() {
                setText(parseInt(clone.val() || clone.attr('value')) + step);
            });
            $("<span class='input-group-btn'></span>").append(down).appendTo(group);
            clone.appendTo(group);
            if(clone && settings.center) {
                clone.css('text-align', 'center');
            }
            $("<span class='input-group-btn'></span>").append(up).appendTo(group);

            // remove spins from original
            clone.prop('type', 'text').keydown(function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }

                var c = String.fromCharCode(e.which);
                var n = parseInt(clone.val() + c);

                if ((min && n < min) || (max && n > max)) {
                    e.preventDefault();
                }
            });

            self.replaceWith(group);
        });
    };
} ( jQuery ));

</script>
<script>
// Remember set you events before call bootstrapSwitch or they will fire after bootstrapSwitch's events
$("[name='checkbox2']").change(function() {
    if(!confirm('Do you wanna cancel me!')) {
        this.checked = true;
    }
});
$('#after').bootstrapNumber();
$('#colorful1').bootstrapNumber({
    upClass: 'success',
    downClass: 'danger'
});
$('#colorful2').bootstrapNumber({
    upClass: 'success',
    downClass: 'danger'
});
$('#colorful3').bootstrapNumber({
    upClass: 'success',
    downClass: 'danger'
});
$("#colorful1").on("blur", function(){
    if ($(this).val().length < 1) $(this).val($(this).attr("min"));
});
$("#colorful2").on("blur", function(){
    if ($(this).val().length < 1) $(this).val($(this).attr("min"));
});
$("#colorful3").on("blur", function(){
    if ($(this).val().length < 1) $(this).val($(this).attr("min"));
});
// $("#colorful1").on("input", function(e){
//     // console.log(e.key);
//     if ($(this).val().length > 0) {
//         // if ($(this).val() > $(this).attr("max")) $(this).attr("max");
//     }
// });
// $("#colorful1").on("keyup", function(e){
//     if (e.key >= '0' && e.key <= '9') {
//         // console.log(e.key);
        
//     }
// });
</script>
