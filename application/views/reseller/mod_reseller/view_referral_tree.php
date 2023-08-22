<div class='col-md-12'>
	<div class='box box-info'>
		<div class='box-header with-border'>
			<h3 class='box-title'>DETAIL DATA NETWORK LIST</h3>
			<div class='box-body'>
				<?php
					//echo "User name pertama : ".$rows[username];
					$cari_pos = $this->db->query("SELECT referral,position FROM rb_referral where id_reseller='".$this->session->id_reseller."'")->row_array();
					
					//cari upline dari username saat ini yang login
					echo "Berikut adalah upline dan member referral dibawah username <b>".$this->session->username." :</b><br><br>";
					echo "<table width='80%' border='0' align='center' cellpadding='0' cellspacing='0'>";
					echo "<tr><th align='center'>Account</th><th align='center'>Position</th></tr>";
					
					//cari upline level pertama
					$cari = $this->db->query("SELECT * FROM rb_referral where username='".$cari_pos['referral']."'");
                    if ($cari->num_rows()>0)
					{
						foreach ($cari->result_array() as $row) 
						{
							$id_reff1=$row[id_reseller];
							$user_name1=$row[username];
							$posisi1=$row[position];
							$referral1=$row[referral];												
						}				
					
					}
					
					//cari upline level kedua
					$cari_upline_level2 = $this->db->query("SELECT id_reseller FROM rb_referral where username='".$referral1."'")->row_array();
					
					//tampilkan upline level kedua
					echo "<tr>
							  <td><img src='../icon/people.png' width='40' height='40'/><br/>
								  ".$cari_upline_level2['id_reseller']." - $referral1<br/><br/></td>
							  <td>2 (referral 1)</td>
						 </tr>";				
					
					//tampilkan upline level pertama
					echo "<tr>
							  <td><img src='../icon/people.png' width='40' height='40'/><br/>
								  $id_reff1 - $user_name1<br/><br/></td>
							  <td>$posisi1 (referral 2)</td>
						 </tr>";
						 
					//cari position dari user saat ini di limit 4 member 					
					$cari = $this->db->query("SELECT * FROM rb_referral where referral='".$this->session->username."' order by position asc limit 4");
                    if ($cari->num_rows()<=0)
					{
                        echo "<center style='color:red; padding:40px'><i>Member referral tidak ditemukan</i></center>";
                    }
					else
					{
                        //tampilkan user saat ini yg login						
						echo "<tr><td><img src='../icon/people.png' width='40' height='40'/><br/><b>".$this->session->id_reseller." - ".$this->session->username."</b><br/><br/></td>
							  <td>0 (current)</td></tr>";
						
						foreach ($cari->result_array() as $row) 
						{
							$id_reff=$row[id_reseller];
							$user_name=$row[username];
							$posisi=$row[position];
							
							//tampilkan 4 member kebawah
							echo "<tr>
									  <td><img src='../icon/people.png' width='40' height='40'/><br/>
									      $id_reff - $user_name<br/><br/></td>
									  <td>- $posisi</td>
								 </tr>";
						
						}
					}
					
					/*$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$kiri_nama_username=$row[username];								
						}	
					}*/		
					
					
					//echo "<tr><td><img src='../icon/people.png' width='40' height='40'/></td></tr>";			
										
					echo "</table><br/>Jika referral 1 dan referral 2 sama maka referral tersebut sudah record teratas pada database";
					
					//echo "<br><p align='center'><b><font color='blue'>-----------  Untuk melihat detail jaringan dibawah level 5 ini silakan berkoordinasi dengan upline pada level 5 ini  -----------</p></b></font>";
				?>
			</div>
		</div>		
	</div>
</div>
    