<p class='sidebar-title block-title'> Konfirmasi Pembayaran Pesanan Anda</p>

<?php 
if ($rows['kode_transaksi']!='') {
  $proses=$rows["proses"];
}
if ($this->uri->segment(3)=='success' OR $proses!=0){
    echo "<div class='alert alert-success' style='margin:10% 0px'><center>Success Melakukan Konfirmasi pembayaran... <br>
                                                                          mohon info via WA ke nomor 081249847899 akan segera kami cek dan proses!</center></div>";
}else{
    $attributes = array('class'=>'form-horizontal','role'=>'form');
    $ongk = $this->db->query("SELECT * FROM rb_penjualan where id_penjualan='$rows[id_penjualan]'")->row_array();
    echo form_open_multipart('konfirmasi/index',$attributes); 
    if ($rows["kode_transaksi"]=="") {
      echo "<div class='alert alert-danger'>Masukkan No Invoice atau No Transaksi Terlebih dahulu!</div>";
    }
    echo "<table class='table table-condensed'>
        <tbody>
          <input type='hidden' name='id' value='$rows[id_penjualan]'>";
          if ($rows['kode_transaksi']=='') {
            echo "<tr><th scope='row' width='120px'>No Invoice</th>       <td><input type='text' name='a' class='form-control' style='width:100%' value='$rows[kode_transaksi]' placeholder='TRX-0000000000' required>";
          }else{
            echo "<tr><th scope='row' width='120px'>No Invoice</th>       <td><input type='text' name='a' class='form-control' style='width:100%' value='$rows[kode_transaksi]' placeholder='TRX-0000000000' required readonly>";
          }          
          if ($rows['kode_transaksi']!=''){
            echo "<tr><th scope='row'>Total</th>                  <td><input type='text' name='b' class='form-control' style='width:50%' value='Rp ".rupiah($total['total']+$ongk['ongkir'])."' required readonly>
            <tr><th scope='row'>Transfer Ke</th>                  <td><select name='c' class='form-control'>";
                                              //set rekening semua pelapak ke rekening perusahaan
            $cari_rekening=$this->db->query("SELECT * FROM rb_rekening");
            foreach ($cari_rekening->result_array() as $row_rekening)
            {
              //$rekening=$row_rekening[no_rekening];																	
                                                  //$pemilik=$row_rekening[pemilik_rekening];																	
              echo "<option value='$row_rekening[id_rekening]'>$row_rekening[nama_bank] - $row_rekening[no_rekening], A/N : $row_rekening[pemilik_rekening]</option>";
                                              }
            echo "</select></td></tr>
            <tr><th width='130px' scope='row'>Nama Pengirim</th>  <td><input type='text' class='form-control' style='width:70%' name='d' required></td></tr>
            <tr><th scope='row'>Tanggal Transfer</th>             <td><input type='text' class='datepicker form-control' style='width:40%' name='e' data-date-format='yyyy-mm-dd' value='".date('Y-m-d')."' required readonly></td></tr>
            <tr><th scope='row'>Bukti Transfer</th>               <td><input type='file' name='f' required></td></tr>";
          }
        echo "</tbody>
      </table>

    <div class='box-footer'>";
        if ($rows['kode_transaksi']!=''){
          echo "<button type='submit' name='submit' class='btn btn-info'>Kirimkan</button>";
        }else{
          echo "<button type='submit' name='submit1' class='btn btn-info'>Cek Invoice</button>";
        }
    echo "</div>";
    echo form_close();
}
