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
     		<?php //total saldo   ?>
			<a style='color:#000' href='#'>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="glyphicon glyphicon-briefcase"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Saldo</span>
                  <span class="info-box-number"><?php echo "Rp ".rupiah($saldo_rek['saldo']); ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            </a>
         
			<section class="col-lg-5 connectedSortable">
            
              <div class="box box-info">
                <div class="box-header">
                <i class="fa fa-th-list"></i>
                <h3 class="box-title">Selamat datang Pengguna!</h3>
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
                          <dt>Nama Pengguna</dt>   <dd><?php echo $rows['nama_reseller']; ?></dd>
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

<?php  ?>
            