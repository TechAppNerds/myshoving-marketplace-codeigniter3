<?php $detail = $this->db->query("SELECT * FROM rb_penjualan where id_penjualan='".$this->uri->segment(3)."'")->row_array(); ?>
<script>
function yourfunction(radioid)
{
if(radioid == 1)
{    
   	document.getElementById('one').style.display = '';
    document.getElementById('two').style.display = 'none';
	document.getElementById('three').style.display = 'none';
 }
 else if(radioid == 2)
{  
	document.getElementById('one').style.display = 'none';
	document.getElementById('two').style.display = '';
    document.getElementById('three').style.display = 'none';
}
 else if(radioid == 3)
{  
	
	document.getElementById('one').style.display = 'none';
	document.getElementById('two').style.display = 'none';
    document.getElementById('three').style.display = '';
}
}    
</script>
            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Detail Histori Transaksi Anda</h3>
                  <a class='pull-right btn btn-default btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/historypembelian'>Kembali</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='140px' scope='row'>Kode Pembelian</th>  <td><?php echo "$rows[kode_transaksi]"; ?></td></tr>
                    <tr><th scope='row'>Nama Konsumen</th>                 <td><?php echo "<a href='".base_url().$this->uri->segment(1)."/detail_konsumen/$rows[id_konsumen]'>$rows[nama_lengkap]</a>"; ?></td></tr>
                    <tr><th scope='row'>Waktu Transaksi</th>               <td><?php echo "$rows[waktu_transaksi]"; ?></td></tr>
                    <tr><th scope='row'>Kurir</th>               <td><?php echo "<span style='text-transform:uppercase'>$detail[kurir]</span> - $detail[service]"; ?></td></tr>
                    <tr><th scope='row'>Status</th>                        <td>
                      <?php
                        if ($rows['proses']=='0'){ $proses = '<i class="text-danger">Pending</i>'; $status = 'Proses'; $icon = 'star-empty'; $ubah = 1; }elseif($rows['proses']=='1'){ $proses = '<i class="text-success">Proses</i>'; $status = 'Pending'; $icon = 'star text-yellow'; $ubah = 0; }else{ $proses = '<i class="text-info">Konfirmasi</i>'; $status = 'Proses'; $icon = 'star'; $ubah = 1; } 
                        echo $proses; 
                      ?>
                    </td></tr>
                      <?php
                        $id_transaksi=$this->uri->segment(3);
                            $id_pelanggan="";
                            $query = $this->db->query("SELECT id_pembeli FROM history_penjualan where id_penjualan ='$id_transaksi'");
                                foreach ($query->result_array() as $row){
                                    $id_pelanggan=$row['id_pembeli'];
                                }
                            $id_barang="";
                            $query2 = $this->db->query("SELECT id_produk FROM history_penjualan_detail where id_penjualan ='$id_transaksi'");
                            foreach ($query2->result_array() as $row2){
                                $id_barang=$row2['id_produk'];
                            }
                      
                            $querycek = $this->db->query("SELECT id_testimoni FROM testimoni where id_konsumen ='$id_pelanggan' and id_barang='$id_barang'");
                            $cektesti="";
                            foreach ($querycek->result_array() as $row){
                                $cektesti=$row['id_testimoni'];
                            }
                      
                      ?>
                      <?php 

                      if($cektesti=="" && $this->uri->segment(4)==1){?>
                      <form action="<?php echo base_url('Reseller/insert_testimoni/'.$this->uri->segment(3)."/")?>" method="post">
                            <tr><th>Testimoni</th>
                                <td><p>&#128525;</p><input TYPE='radio' NAME='rating' VALUE='3' onClick="javascript:return yourfunction(1)" required="required"> Suka</td>
                                <td><p>&#128528;</p><input TYPE='radio' NAME='rating' VALUE='2' onClick="javascript:return yourfunction(2)" required="required"> Biasa Saja</td>
                                <td><p>&#128542;</p><input TYPE='radio' NAME='rating' VALUE='1' onClick="javascript:return yourfunction(3)" required="required"> Tidak Suka</td>
                            </tr>
                             <tr><th>Review & Saran</th>
                                <td style="margin:0px"> 

                                <div id = "one" style = "display:none"> 
                                <select name="testimoni">
                                    <option  value="Barang sesuai pesanan">Barang sesuai pesanan</option>
                                    <option  value="Packing barang rapi">Packing barang rapi</option>
                                    <option  value="Recommended seller">Recommended seller</option>
                                    <option  value="Seller ramah dan fast respon">Seller ramah dan fast respon</option>
                                </select>
                                </div>
                                <div id = "two" style = "display:none">
                                <select name="testimoni2" >
                                    <option value="Tidak ada komentar">Tidak ada komentar</option>
                                    <option  value="Barang sudah ditest dan berfungsi">Barang sudah ditest dan berfungsi</option>

                                </select>
                                </div>
                                     <div id = "three" style = "display:none">
                                <select name="testimoni3" >
                                    <option  value="Kualitas barang jelek">Kualitas barang jelek</option>
                                    <option  value="Barang tidak sesuai pesanan">Barang tidak sesuai pesanan</option>
                                    <option  value="Packing barang jelek dan asal-asalan">Packing barang jelek dan asal-asalan</option>
                                </select>
                                </div> 
                                </td>
                            </tr>
                            <!-- Rating -->
                            <tr>
                            <th>Rating</th>
                            <td>
                              <div class="rating">
                                <span><input type="radio" name="star" id="str5" value="5"><label for="str5">★</label></span>
                                <span><input type="radio" name="star" id="str4" value="4"><label for="str4">★</label></span>
                                <span><input type="radio" name="star" id="str3" value="3"><label for="str3">★</label></span>
                                <span><input type="radio" name="star" id="str2" value="2"><label for="str2">★</label></span>
                                <span><input type="radio" name="star" id="str1" value="1"><label for="str1">★</label></span>
                            </div>

                          <script>
                              $(document).ready(function(){
                                  // Check Radio-box
                                  $(".rating input:radio").attr("checked", false);

                                  $('.rating input').click(function () {
                                      $(".rating span").removeClass('checked');
                                      $(this).parent().addClass('checked');
                                  });

                                  $('input:radio').change(
                                    function(){
                                      var userRating = this.value;
                                  }); 
                              });
                          </script>
                          <style type="text/css">
                              .rating {
                                    float:left;
                                }
                                .rating span { float:right; position:relative; }
                                .rating span input {
                                    position:absolute;
                                    top:0px;
                                    left:0px;
                                    opacity:0;
                                }
                                .rating span label {
                                    display:inline-block;
                                    width:30px;
                                    height:30px;
                                    text-align:center;
                                    color:#FFF;
                                    background:#ccc;
                                    font-size:30px;
                                    margin-right:2px;
                                    line-height:30px;
                                    border-radius:50%;
                                    -webkit-border-radius:50%;
                                }
                                .rating span:hover ~ span label,
                                .rating span:hover label,
                                .rating span.checked label,
                                .rating span.checked ~ span label {
                                    background:#F90;
                                    color:#FFF;
                                    cursor:pointer;
                                }
                          </style>
                          <input type="hidden" name="id_penjualan" value="<?php echo $id_transaksi;?>"></input>
                          </td>
                          </tr>
                          <tr><th>Kirim</th><td><input type="submit" value="Kirim Testimoni"></td></tr>
                    </form>

                      <?php } elseif($this->uri->segment(4)==1){?>
                        <tr><th width='140px' scope='row'>Testimoni</th>  <td><?php echo "Anda sudah melakukan testimoni pada transaksi ini." ?></td></tr>
                      <?php }?>
                      
                  </tbody>
                  </table>
                  <hr>
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Jumlah Jual</th>
                        <th>Satuan</th>
                        <th>Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $row){
                    $sub_total = ($row['harga_jual']*$row['jumlah'])-$row['diskon'];
                    echo "<tr><td>$no</td>
                              <td>$row[nama_produk]</td>
                              <td>Rp ".rupiah($row['harga_jual'])."</td>
                              <td>$row[jumlah]</td>
                              <td>$row[satuan]</td>
                              <td>Rp ".rupiah($sub_total)."</td>
                          </tr>";
                      $no++;
                    }
                    $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='".$this->uri->segment(3)."'")->row_array();
                    echo "<tr class='warning'>
                            <td colspan='5'><b>Ongkir</b></td>
                            <td><b>Rp ".rupiah($detail['ongkir'])."</b></td>
                          </tr>
                          <tr class='warning'>
                            <td colspan='5'><b>Belanja</b></td>
                            <td><b>Rp ".rupiah($total['total'])."</b></td>
                          </tr>
                          <tr class='success'>
                            <td colspan='5'><b>Total</b></td>
                            <td><b>Rp ".rupiah($total['total']+$detail['ongkir'])."</b></td>
                          </tr>";
                  ?>
                  </tbody>
                </table>
              </div>