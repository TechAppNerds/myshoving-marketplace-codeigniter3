<p class='sidebar-title text-danger produk-title'> &nbsp; <?php echo $judul; ?></p>
<style type="text/css">
  div.produk{
    box-shadow: 5px 5px 5px lightgrey;
      border-radius: 5%;
      padding: 0px;
        margin-right: 15px;
      margin-left: 15px;
      height: 260px;
  }
  div.box {
    border: 1px solid #CCC;
      padding: 40px 25px;
      background: #FFF;
      max-width: 400px;
      position: relative;
      border-radius: 3px;
      margin: 0 auto;
  }
  
  div.box div.top-cross-ribbon {
      background: #EA4335;
      padding: 2px 50px;
      color: #FFF;
      position: absolute;
      /*top: -160px;*/
      top: -140px;
      right: -50px;
      transform: rotate(45deg);
      border: 1px dashed #FFF;
      box-shadow: 0 0 0 3px #EA4335;
      margin: 5px;
  }
  h4.produk-title{
    text-align: left;
    margin-bottom: 5px;
  }
  h4.produk-title a{
    color: black;
  }
  span.harga{
      text-align: left;
      display: block;
  }  
</style>
<?php 
if ($this->uri->segment(2)=='kategori'){
  $cek = $this->model_app->edit('rb_kategori_produk',array('kategori_seo'=>$this->uri->segment(3)))->row_array();
  $jumlah= $this->model_app->view_where('rb_produk',array('id_kategori_produk'=>$cek['id_kategori_produk']))->num_rows();
  if ($jumlah <= 0){
      echo "<div  style='margin:10%' class='alert alert-info'><center>Maaf, Produk pada Kategori ini belum tersedia..!</center></div>";
  }
}

if ($this->uri->segment(2)=='subkategori'){
  $cek = $this->model_app->edit('rb_kategori_produk_sub',array('kategori_seo_sub'=>$this->uri->segment(3)))->row_array();
  $jumlah= $this->model_app->view_where('rb_produk',array('id_kategori_produk_sub'=>$cek['id_kategori_produk_sub']))->num_rows();
  if ($jumlah <= 0){
      echo "<div  style='margin:10%' class='alert alert-info'><center>Maaf, Produk pada Sub Kategori ini belum tersedia..!</center></div>";
  }
}

  $no = 1;
  echo "<div class='container'>";
  foreach ($record->result_array() as $row){
  $ex = explode(';', $row['gambar']);
  if (trim($ex[0])==''){ $foto_produk = 'no-image.png'; }else{ $foto_produk = $ex[0]; }
  if (strlen($row['nama_produk']) > 38){ $judul = substr($row['nama_produk'],0,38).',..';  }else{ $judul = $row['nama_produk']; }

  $jual = $this->model_reseller->jual_reseller($row['id_reseller'],$row['id_produk'])->row_array();
  $beli = $this->model_reseller->beli_reseller($row['id_reseller'],$row['id_produk'])->row_array();
  if ($beli['beli']-$jual['jual']<=0){ $stok = '<span class="harga" style="color:000">Stok Habis</span>'; }else{ $stok = "<span class='harga' style='color:green'>Stok ".($beli['beli']-$jual['jual'])." $row[satuan]</span>"; }

  $disk = $this->db->query("SELECT * FROM rb_produk_diskon where id_produk='$row[id_produk]'")->row_array();
  $diskon = rupiah(($disk['diskon']/$row['harga_konsumen'])*100,0)."%";
  if ($diskon>0){ 
        $diskon_persen = "<div class='box ofh'><div class='top-cross-ribbon'>$diskon</div></div>"; }else{ $diskon_persen = ''; }
  if ($diskon>=1){ 
    $harga =  "<del style='color:#8a8a8a'><small>Rp ".rupiah($row['harga_konsumen'])."</small></del> Rp ".rupiah($row['harga_konsumen']-$disk['diskon']);
  }else{
    $harga =  "Rp ".rupiah($row['harga_konsumen']);
  }
  echo "<div class='produk col-md-2 col-xs-6' style='box-shadow: 5px 5px 5px lightgrey;
                                border-radius: 5%;
                                padding: 0px;
                                  margin-right: 15px;
                                margin-left: 15px;'>
            <center>
              <div style='height:140px; overflow:hidden; margin-bottom: 5px;'>
                <a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'><img style='border:1px solid #cecece; height:100%; width:100%;border-radius:10%;' src='".base_url()."asset/foto_produk/$foto_produk'></a>
                $diskon_persen
              </div>
              <h4 class='produk-title'><a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'>$judul</a></h4>
              <span class='harga'>$harga</span>
              <i>$stok</i><small style='text-align: left;display: block;'>$row[nama_kota]</small>
            </center><br>
          </div>";
    $no++;
  }
echo "</div>
<div class='pagination'>";
         echo $this->pagination->create_links();
    echo "</div>";

