<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Testimoni Pelanggan</h3>
      
    </div><!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped table-condensed">
      <thead>
        <tr>
          <th style='width:30px'>No</th>
          <th>Nama Konsumen</th>
          <th>Testimoni</th>
          <th>Waktu Testimoni</th>
        </tr>
      </thead>
      <tbody>
          <?php  $idbarang=$this->uri->segment(3);?>
          <?php $no=1;foreach($record as $items){ ?>  
          <?php if($items->id_barang==$idbarang){?>
             <tr>
                 <td><?php echo $no?></td>
                <td><?php 
                         $nama_konsumen="";
                         $query = $this->db->query("SELECT nama_lengkap FROM rb_konsumen where id_konsumen ='$items->id_konsumen'");
                        foreach ($query->result_array() as $row){
                            $nama_konsumen=$row['nama_lengkap'];
                        }
                                                 
                        if($nama_konsumen=="")
                        {
                            $query2 = $this->db->query("SELECT nama_reseller FROM rb_reseller where id_reseller ='$items->id_konsumen'");
                            foreach ($query2->result_array() as $row2){
                                 $nama_konsumen=$row2['nama_reseller'];
                                }
                        }
                         if($nama_konsumen=="")
                        {
                            
                            $query3 = $this->db->query("SELECT nama_reseller FROM rb_referral where id_reseller ='$items->id_konsumen'");
                            foreach ($query3->result_array() as $row3){
                                    $nama_konsumen=$row3['nama_reseller'];
                                }
                        }
                        echo $nama_konsumen;
                    
                    ?></td>
                 <td><?php echo $items->isi_testimoni?></td>
                 <td><?php echo $items->waktu_testimoni?></td>
             </tr> 
          <?php $no++;} ?>
          <?php }?>
      </tbody>
    </table><hr>
  </div>