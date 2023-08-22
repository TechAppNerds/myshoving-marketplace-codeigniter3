<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/fontawesome.min.css"> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/template/phpmu-tigo/background/fonticons/fontawesome-5.13.0-web.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/fontawesome.min.css" integrity="sha256-CuUPKpitgFmSNQuPDL5cEfPOOJT/+bwUlhfumDJ9CI4=" crossorigin="anonymous" /> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<?php 
// var_dump($this->session);
// var_dump($cek_reff);
            // echo "<script>alert('".$cek_reff->num_rows()."')<script>";
$pembelian = $this->model_reseller->pembelian($this->session->id_reseller)->row_array();
$penjualan_perusahaan = $this->model_reseller->penjualan_perusahaan($this->session->id_reseller)->row_array();
$penjualan = $this->model_reseller->penjualan($this->session->id_reseller)->row_array();
$modal_perusahaan = $this->model_reseller->modal_perusahaan($this->session->id_reseller)->row_array();
$modal_pribadi = $this->model_reseller->modal_pribadi($this->session->id_reseller)->row_array();
//print_r($this->session->userdata);

if ($this->session->userdata('reff')==0) {  
  $saldo_rek = $this->model_reseller->cek_saldo($this->session->id_reseller)->row_array();
  //$saldo_rek=$this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$this->session->id_reseller." ORDER BY tanggal DESC LIMIT 1")->row_array();
}
$set = $this->db->query("SELECT * FROM rb_setting where aktif='Y'")->row_array();
?>

<style type="text/css">
  #header-box{
    width: 20%;
  }
  .info-box-content{
    /*padding: 5px 5px;*/
    height: 90px;
    padding: 2px;
  }
  .info-box-text{
    white-space: unset;
    overflow: unset;
  }
  span.info-box-icon img{
    vertical-align: unset;
  }
  .swal2-popup .swal2-title {
    font-size: 1.65em;
    max-width: none;
  }
</style>

<?php //total saldo   ?>
<a style='color:#000' href='#'>
  <div class="col-md-2 col-sm-6 col-xs-12" id="header-box">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><img src="<?php echo base_url();?>asset/images/money.png" width="75" height="85"/></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Saldo</span>
        <span class="info-box-number"><?php echo "Rp ".rupiah($saldo_rek['saldo']); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</a>
			
<a style='color:#000' href='#'>
  <div class="col-md-2 col-sm-6 col-xs-12" id="header-box">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Belanja</span>
        <span class="info-box-number"><?php echo "Rp ".rupiah($pembelian['total']); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</a>
			
<a style='color:#000' href='#'>
  <div class="col-md-2 col-sm-6 col-xs-12" id="header-box">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-folder-open"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Penjualan</span>
        <span class="info-box-number"><?php echo "Rp ".rupiah($penjualan_perusahaan['total']); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</a>

<a style='color:#000' href='#'>
  <div class="col-md-2 col-sm-6 col-xs-12" id="header-box">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-briefcase"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Modal Penjualan</span>
        <span class="info-box-number"><?php echo "Rp ".rupiah($modal_perusahaan['total']); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</a>
           
<a style='color:#000' href='#'>
  <div class="col-md-2 col-sm-6 col-xs-12" id="header-box">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-star"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Produk Pribadi</span>
        <span class="info-box-number"> <?php echo "Rp ".rupiah($penjualan['total']); ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</a>
         
<section class="col-lg-5 connectedSortable">
  <div class="box box-info">
    <div class="box-header">
    <i class="fa fa-th-list"></i>
    <h3 class="box-title">Selamat datang Reseller!</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
    Silahkan mengelola Semua data melalui menu yang sudah kita sediakan dibelah kiri anda, berikut data profile anda : <br><br>
      <?php 
      $iden = $this->model_app->edit('identitas',array('id_identitas'=>'1'))->row_array();
      if ($this->session->userdata('reff')==0) {
        $rows = $this->model_app->edit('rb_reseller',array('id_reseller'=>$this->session->id_reseller))->row_array();
      }else{
        $rows = $this->model_app->edit('rb_referral',array('id_reseller'=>$this->session->id_reseller))->row_array();
      }
      if (trim($rows['foto'])==''){ $foto_user = 'users.gif'; }else{ $foto_user = $rows['foto']; } ?>
      <dl class="dl-horizontal">
          <dt>Username</dt>   <dd><?php echo $rows['username']; ?></dd>
          <dt>Password</dt>   <dd>********************</dd>
          <dt>Nama Reseller</dt>   <dd><?php echo $rows['nama_reseller']; ?></dd>
          <dt>Jenis Kelamin</dt>   <dd><?php echo $rows['jenis_kelamin']; ?></dd>
          <dt>Alamat</dt>   <dd><?php echo $rows['alamat_lengkap']; ?></dd>
          <dt>No Telp/Hp</dt>   <dd><?php echo $rows['no_telpon']; ?></dd>
          <dt>Alamat Email</dt>   <dd><?php echo $rows['email']; ?></dd>
          <dt>Kode POS</dt>   <dd><?php echo $rows['kode_pos']; ?></dd>
          <dt>Referral</dt>   <dd><?php echo $rows['referral']; ?></dd>
      </dl>
      <hr style='margin:7px'>
      <a class='btn btn-default btn-block' href="<?php echo base_url().$this->uri->segment(1); ?>/edit_reseller/<?php echo $this->session->id_reseller; ?>">Edit Profile</a>
      <a target='_BLANK' class='btn btn-success btn-block' href="<?php echo base_url(); ?>produk/produk_reseller/<?php echo $this->session->id_reseller; ?>">Lihat Lapak anda!</a>
      <br><br>
    </div>
  </div>
</section><!-- /.Left col -->

<section class="col-lg-7 connectedSortable">
  <div class="box box-info">
    <div class="box-header">
    <!-- <i class="fa fa-th-list"></i> -->
      <h3 class="box-title">Refferal Link</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>        
    </div>
    <div class="box-body">
      <input type="text" style="width: 85%;" name="FieldLink" id="FieldLink" value="http://www.myshoving.com/auth/register?userid=<?php echo $this->session->username; ?>" readonly>
      <input type="submit" name="btnCopyLink" id="btnCopyLink" value="Copy Link">
    </div>
  </div>
</section><!-- /.Left col -->

<script type="text/javascript">
  $("#btnCopyLink").on("click",()=>{
    $("#FieldLink").select();
    document.getElementById("FieldLink").setSelectionRange(0, $("#FieldLink").val().length);
    document.execCommand("copy");
    swal({
      title: 'Copied : '+$("#FieldLink").val(),
      type: 'success',
    });
  });
</script>

            <section class="col-lg-7 connectedSortable">

              <div class="box box-success">
              <div class="box-header">
              <i class="fa fa-th-list"></i>
              <h3 class="box-title">10 Transaksi Penjualan Terbaru</h3>
                  <div class="box-tools pull-right">
                     <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Transaksi</th>
                        <th>Kurir</th>
                        <th>Status</th>
                        <th>Total + Ongkir</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    $record = $this->model_reseller->penjualan_list_konsumen_top($this->session->id_reseller,'reseller');
                    foreach ($record->result_array() as $row){
                    if ($row['proses']=='0'){ $proses = '<i class="text-danger">Pending</i>'; $status = 'Proses'; $icon = 'star-empty'; $ubah = 1; }elseif($row['proses']=='1'){ $proses = '<i class="text-success">Proses</i>'; $status = 'Pending'; $icon = 'star text-yellow'; $ubah = 0; }else{ $proses = '<i class="text-info">Konfirmasi</i>'; $status = 'Proses'; $icon = 'star'; $ubah = 1; }
                    $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='$row[id_penjualan]'")->row_array();
                    echo "<tr><td>$no</td>
                              <td><a href='".base_url().$this->uri->segment(1)."/detail_penjualan/$row[id_penjualan]'>$row[kode_transaksi]</a></td>
                              <td><span style='text-transform:uppercase'>$row[kurir]</span> - $row[service]</td>
                              <td>$proses</td>
                              <td style='color:red;'>Rp ".rupiah($total['total']+$row['ongkir'])."</td>
                          </tr>";
                      $no++;
                    }
                  ?>
                  </tbody>
                </table>
                <a class='btn btn-default btn-block' href='<?php echo base_url().$this->uri->segment(1); ?>/penjualan'>Lihat Semua</a>
              </div>
              </div>
            </section><!-- right col -->
			
			<section class="col-lg-7 connectedSortable">

              <div class="box box-success">
              <div class="box-header">
              <i class="fa fa-th-list"></i>
				<?php 
        if ($this->session->userdata('reff')==0) {  

					$status_blokir=$this->db->query("SELECT blokir FROM rb_reseller where id_reseller='".$this->session->id_reseller."'")->row_array();
					if($status_blokir['blokir']!="Y") {	?> 	
						<h3 class="box-title">10 Transaksi Mutasi Rekening Terbaru</h3> 
				<?php
					}
					else
					{
				?>
						<h3 class="box-title">Transaksi Mutasi Rekening</h3>
				<?php						
					}
				?>
				  <div class="box-tools pull-right">
                     <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
					<?php 
                    $no = 1;
                    // echo "<script>alert('".$this->session->userdata('reff');."');</script>";
					
            //echo"<script>alert('".$status_blokir['blokir']."');</script>";
  					if($status_blokir['blokir']!="Y")
  					{
  					?>	
  						<table class="table table-bordered table-striped table-condensed">
  							<thead>
  							  <tr>
  								<th style='width:30px'>No</th>
  								<th style='width:40px'>Jenis</th>
  								<th style='width:120px'>Tanggal transaksi</th>
  								<th style='width:70px'>Type</th>
  								<th style='width:190px'>Keterangan</th>
  								<th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Nilai</th>
  								<th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Saldo</th>						
  							  </tr>
  							</thead>
  							<tbody>
  					<?php 
  						
              $mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$this->session->id_reseller." ORDER BY tanggal DESC LIMIT 10");
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
  					}
  					else
  					{
  					?>	
  						<table class="table table-bordered table-striped table-condensed">
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
  					}
        }
            // echo "<script>alert('".$_GET["reff"]."');</script>";
            /*if($status_blokir['blokir']!="Y")
            {
            ?>  
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                  <th style='width:30px'>No</th>
                  <th style='width:40px'>Jenis</th>
                  <th style='width:120px'>Tanggal transaksi</th>
                  <th style='width:70px'>Type</th>
                  <th style='width:190px'>Keterangan</th>
                  <th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Nilai</th>
                  <th style='width:80px'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Saldo</th>           
                  </tr>
                </thead>
                <tbody>
            <?php 
              
              $mutasi = $this->db->query("SELECT * FROM mutasi_rek where id_reseller=".$this->session->id_reseller." ORDER BY tanggal DESC LIMIT 10");
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
            }
            else
            {
            ?>  
              <table class="table table-bordered table-striped table-condensed">
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
            }*/

        
                  ?>
      </tbody>
    </table>                
  </div>
  </div>
</section>
<?php  ?>
            