<div class='col-md-12'>
	<div class='box box-info'>
		<div class='box-header with-border'>
			<h3 class='box-title'>DETAIL DATA NETWORK LIST BERDASARKAN DOWNLINE LANGSUNG</h3>
			<div class='box-body'>
				<?php
					$cari = $this->db->query("SELECT * FROM rb_reseller where id_reseller='".$this->session->id_reseller."'");
                    if ($cari->num_rows()<=0)
					{
                        echo "<center style='color:red; padding:40px'><i>Id reseller tidak ditemukan</i></center>";
                    }
					else
					{
                        foreach ($cari->result_array() as $row) 
						{
							echo "Berikut adalah data jaringan dibawah user name <b>".$this->session->username." :</b><br><br>";
							$posisi=$row[position];
							$user_name=$row[username];
							$nama_reseller=$row[nama_reseller];
							
						}
					}
										
					//echo " <table border='0' class='table table-condensed' cellpadding='2'>
					echo "<table width='1000' border='0' align='center' cellpadding='0' cellspacing='0'>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
                                </tr>";					
					//level 1
					echo "<tr><td><font color='red'><b>Level :1 </b></font></td>";
					echo "<tr><td></td><td></td><td></td><td></td><td align='center'>&nbsp &nbsp &nbsp<img src='../icon/people.png' width='40' height='60'/></td></tr>";
					echo "<tr><td></td><td></td><td></td><td></td><td align='center'>&nbsp &nbsp &nbsp<font color='blue'><b>".$user_name."</b></font></td></tr>";
					echo "<tr><td></td><td></td><td></td><td></td><td align='center'>&nbsp &nbsp &nbsp<font color='blue'><b>".$nama_reseller."</b></font></td></tr>";
					echo "<tr><td><font color='red'><b>Level : 2</b></font></td></tr>";
					
					$no = 1;
					$posisi=$posisi*2;
                    					
					//level 2
					echo "<tr><td></td><td></td><td></td><td></td><td><img src='../icon/people.png' width='40' height='60'/></td>
					          <td></td><td></td><td></td><td><img src='../icon/people.png' width='40' height='60'/></td></tr>";
							  
						
					//level 2 (directline dibawah upline langsung)
					//cari posisi downline nomor 2
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
                            $kiri_nama_reseller=$row[nama_reseller];
							$kiri_nama_username=$row[username];								
						}	
					}		
					
					$posisi=$posisi+1;
					
					//cari posisi downline nomor 3
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
                            $kanan_nama_reseller=$row[nama_reseller];
							$kanan_nama_username=$row[username];								
						}	
					}
					
					echo "<tr><td></td><td></td><td></td><td></td><td><font color='green'><b>$kiri_nama_reseller</b></font></td><td></td><td></td><td></td><td><font color='green'><b>$kanan_nama_reseller</b></font></td></tr>";
					echo "<tr><td></td><td></td><td></td><td></td><td><font color='green'><b>$kiri_nama_username</b></font></td><td></td><td></td><td></td><td><font color='green'><b>$kanan_nama_username</b></font></td></tr>";
					
					//echo "</tr></tr></tr>";
					echo "</table>";
				?>
			</div>
		</div>		
	</div>
</div>
    