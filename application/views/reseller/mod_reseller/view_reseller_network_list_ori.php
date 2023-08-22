<div class='col-md-12'>
	<link rel="stylesheet" type="text/css" href="style_view.css">
	<link href="jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet"/>
	<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.theme.css">
	<div class='box box-info'>
		<div class='box-header with-border'>
			<h3 class='box-title'>DETAIL DATA NETWORK LIST BERDASARKAN PARENT ID</h3>
			<div class='box-body'>
				<?php
					//echo "User name pertama : ".$rows[username];
					//$cari= $this->db->query("SELECT * FROM rb_reseller where id_reseller='".$this->session->id_reseller."'");
					//$datanya=$cari->result_array()
					$cari = $this->db->query("SELECT * FROM rb_reseller where id_reseller='".$this->session->id_reseller."'");
                    if ($cari->num_rows()<=0)
					{
                        echo "<center style='color:red; padding:40px'><i>Id reseller tidak ditemukan</i></center>";
                    }
					else
					{
                        foreach ($cari->result_array() as $row) 
						{
							echo "Berikut adalah data jaringan dibawah user name <b>".$this->session->username." (current level ".$row[level].") :</b><br><br>";
						}
					}
					echo " <table class='table table-striped table-condensed table-bordered'>
                                <tr style='background:#e3e3e3'>
                                    <th>No </th>
                                    <th>Nama Toko / Reseller</th>
                                    <th>Nama pemilik</th>
                                    <th>Level</th>
									<th>Side</th>
                                </tr>";
					$no = 1;
                    //$total_jual = 0;
                    //$total_bonus = 0;
                    $cari_reseller = $this->db->query("SELECT * FROM rb_reseller where parent_id='".$this->session->id_reseller."'");
                    if ($cari_reseller->num_rows()<=0)
					{
                        echo "<tr><td colspan='4'><center style='color:red; padding:40px'><i>Anda Belum Memiliki jaringan!</i></center></td></tr>";
                    }
					else
					{
                        foreach ($cari_reseller->result_array() as $row) 
						{
                            //$pp = $this->db->query("SELECT sum((a.jumlah*a.harga_jual)-a.diskon) as total, sum(a.jumlah) as produk FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where c.status_penjual='reseller' AND b.id_produk_perusahaan!='0' AND id_penjual='".$row['id_reseller']."' AND c.proses='1'")->row_array();
                            //$total_jual = $total_jual+$pp['total'];
                            //$total_bonus = $total_bonus+($set['referral']/100*$pp['total']);
                            /*
							    <td>: Rp ".rupiah($pp['total'])." (".rupiah($pp['produk'])." Produk)</td>
                                <td>: Rp ".rupiah($set['referral']/100*$pp['total'])."</td>
							*/
							echo "<tr><td width='20px'>$no</td>
									<td>$row[nama_reseller]</td>  
									<td>$row[username]</td>
									<td>$row[level]</td>
									<td>$row[side]</td>
								  </tr>";
                            $no++;
                        }						
                    }
					echo "</table>";
				?>
			</div>
		</div>		
	</div>
</div>
    