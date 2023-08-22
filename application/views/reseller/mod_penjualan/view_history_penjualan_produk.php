            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">History Pembelian Anda</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Konsumen</th>
                        <th>Kurir</th>
                        <th>Status</th>
                        <th>Total + Ongkir</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
//                        $username = $this->session->userdata('username');
//                        $idsekarang="";
//                        $query = $this->db->query("SELECT id_reseller FROM rb_reseller where username ='".$username."'");
//                        foreach ($query->result_array() as $row){
//                             $idsekarang=$row['id_reseller'];
//                         }
//                        if($idsekarang=="")
//                        {
//                           $query = $this->db->query("SELECT id_reseller FROM rb_referral where username ='".$username."'");
//                           foreach ($query->result_array() as $row){
//                             $idsekarang=$row['id_reseller'];
//                            }
//                        }
//                   
//                        echo $idsekarang;
                    $no = 1;
                    foreach ($record->result_array() as $row){
//                      if($row->id_penjual=='1') {
                            if ($row['proses']=='0'){
                                $proses = '<i class="text-danger">Pending</i>'; $status = 'Proses'; $icon = 'star-empty'; $ubah = 1; 
                            }
                        elseif($row['proses']=='1'){
                            $proses = '<i class="text-success">Proses</i>'; $status = 'Pending'; $icon = 'star text-yellow'; $ubah = 0; 
                        }else{
                            $proses = '<i class="text-info">Konfirmasi</i>'; $status = 'Proses'; $icon = 'star'; $ubah = 1; 
                        }
                            $total = $this->db->query("SELECT sum((a.harga_jual*a.jumlah)-a.diskon) as total FROM `rb_penjualan_detail` a where a.id_penjualan='$row[id_penjualan]'")->row_array();
                        // if($row['proses']=='1'){
                            echo "<tr><td>$no</td>
                                      <td>$row[kode_transaksi]</td>
                                      <td><a href='".base_url()."reseller/detail_konsumen/$row[id_konsumen]'>$row[nama_lengkap]</a></td>
                                      <td><span style='text-transform:uppercase'>$row[kurir]</span> - $row[service]</td>
                                      <td>$proses</td>
                                      <td style='color:red;'>Rp ".rupiah($total['total']+$row['ongkir'])."</td>
                                      <td><center>
                                        <a class='btn btn-success btn-xs' title='Detail Data' href='".base_url()."reseller/detail_history_pembelian/$row[id_penjualan]/".$row['proses']."'><span class='glyphicon glyphicon-search'></span> Detail</a>
                                        <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url()."reseller/delete_penjualan/$row[id_penjualan]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                      </center></td>
                                  </tr>";
                              $no++;
                            // }
                        }
//                    }
                  ?>
                  </tbody>
                </table>
              </div>
              </div>
              </div>
              