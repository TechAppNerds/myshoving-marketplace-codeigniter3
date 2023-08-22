<div class='col-md-12'>
	<link rel="stylesheet" type="text/css" href="style_view.css">
	<link href="jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet"/>
	<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.theme.css">
	<div class='box box-info'>
		<div class='box-header with-border'>
			<center><h3 class='box-title'>MUTASI REKENING PENAMPUNGAN PERUSAHAAN (ALOKASI Rp.2.000 UTK 20 TITIK)</h3></center>
			<div class='box-body'>
				<?php
					echo "Berikut adalah data mutasi rekening alokasi sisa dari bonus 20 level yang telah dibagi perusahaan :</b><br><br>";
					
					echo " <table class='table table-striped table-condensed table-bordered'>
                                <tr style='background:#e3e3e3'>
                                    <th>No </th>
									<th>Tanggal</th>
                                    <th>ID reseller</th>
                                    <th>Keterangan</th>
                                    <th>Type</th>
									<th>Nilai</th>
									<th>Saldo</th>
									<th>Jenis transaksi</th>									
                                </tr>";
					
					$no = 1;					
					$cari = $this->db->query("SELECT * FROM `mutasi_penampungan` order by saldo desc");
                    if ($cari->num_rows()<=0)
					{
                        echo "<center style='color:red; padding:40px'><i>Data mutasi rek tidak ditemukan</i></center>";
                    }
					else
					{
                        foreach ($cari->result_array() as $row) 
						{
							echo "<tr><td width='20px'>$no</td>
									<td>$row[tanggal]</td>
									<td>$row[id_reseller]</td>  
									<td>$row[keterangan]</td>
									<td>$row[type]</td>
									<td>$row[nilai]</td>
									<td>$row[saldo]</td>
									<td>$row[jenis_trn]</td>									
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
    