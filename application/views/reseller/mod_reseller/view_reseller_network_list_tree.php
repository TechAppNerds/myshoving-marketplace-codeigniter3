<div class='col-md-12'>
	<div class='box box-info'>
		<div class='box-header with-border'>
			<h3 class='box-title'>DETAIL DATA NETWORK LIST</h3>
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
							echo "Berikut adalah data reseller dibawah username <b>".$this->session->username." :</b><br><br>";
							$posisi=$row[position];
							$user_name=$row[username];
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
					echo "<tr><td><font color='red'><b>Level : 1 </b></font></td>";
					echo "<tr><td></td><td></td><td></td><td></td><td></td><td align='right'><img src='../icon/people.png' width='40' height='40'/></td></tr>";
					echo "<tr><td></td><td></td><td></td><td></td><td></td><td align='right'><font color='blue'><b>".$user_name."</b></font></td></tr>";

					//level 2
					$no = 1;
					$posisi=$posisi*2;
					echo "<tr><td><font color='red'><b>Level : 2</b></font></td></tr>";					
					echo "<tr><td></td><td></td><td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td>
					          <td></td><td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td></tr>";
							  
						
					//level 2 (directline dibawah upline langsung)
					//cari posisi downline nomor 2
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
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
							$kanan_nama_username=$row[username];								
						}	
					}
					
					$posisi=(($posisi-1)*2);										
							
					//cari posisi downline nomor 4
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username4=$row[username];								
						}	
					}
						
					$posisi=$posisi+1;
					//cari posisi downline nomor 5
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username5=$row[username];								
						}	
					}

					$posisi=$posisi+1;
					//cari posisi downline nomor 6
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username6=$row[username];								
						}	
					}

					$posisi=$posisi+1;
					//cari posisi downline nomor 7
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username7=$row[username];								
						}	
					}
					
					$posisi=(($posisi-3)*2);
					//cari posisi downline nomor 8
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username8=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 9
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username9=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 10
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username10=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 11
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username11=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 12
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username12=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 13
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username13=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 14
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username14=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 15
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username15=$row[username];								
						}	
					}
					
					$posisi=(($posisi-7)*2);
					//cari posisi downline nomor 16
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username16=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 17
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username17=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 18
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username18=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 19
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username19=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 20
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username20=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 21
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username21=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 22
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username22=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 23
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username23=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 24
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username24=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 25
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username25=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 26
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username26=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 27
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username27=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 28
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username28=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 29
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username29=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 30
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username30=$row[username];								
						}	
					}
					
					$posisi=$posisi+1;
					//cari posisi downline nomor 31
					$cari_reseller = $this->db->query("SELECT * FROM rb_reseller where position=".$posisi);
					if ($cari_reseller->num_rows()>0)
					{                 
                        foreach ($cari_reseller->result_array() as $row) 
						{
							$username31=$row[username];								
						}	
					}
					
					echo "<tr><td></td><td></td><td></td><td></td><td><font color='green'><b>$kiri_nama_username</b></font></td><td></td><td></td><td></td><td><font color='green'><b>$kanan_nama_username</b></font></td></tr>";
						
					
										
					//level 3 
					echo "<tr><td align='left'><font color='red'><b>Level : 3</b></font></td></tr>";
					echo "<tr><td>&nbsp</td>";
					echo "<tr><td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td>
					          <td></td><td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td></td><td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td></tr>";
					
					echo "<tr><td></td><td></td><td><font color='green'><b>$username4</td><td></td><td><font color='green'><b>$username5</b></font></td><td></td><td></td><td></td><td><font color='green'><b>$username6</b></font></td><td></td><td></td><td><font color='green'><b>$username7</b></font></td></tr>";
					
					//level 4
					echo "<tr><td>&nbsp</td>";
					
					echo "<tr><td align='left'><font color='red'><b>Level : 4</b></font></td></tr>";
					echo "<tr><td>&nbsp</td>";
					echo "<tr><td></td><td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
					          
							  <td></td><td><img src='../icon/people.png' width='40' height='40'/></td>							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  
							  <td></td><td><img src='../icon/people.png' width='40' height='40'/></td>							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  
							  <td></td><td></td><td><img src='../icon/people.png' width='40' height='40'/></td>							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td></tr>";					
					
					echo "<tr><td></td><td><font color='green'><b>$username8</b></font></td>
					          <td><font color='green'><b>$username9</b></font></td>
							  
							  <td></td><td><font color='green'><b>$username10</b></font></td>
							  <td><font color='green'><b>$username11</b></font></td>
							  
							  <td></td><td><font color='green'><b>$username12</b></font></td>
							  <td><font color='green'><b>$username13</b></font></td>
							  
							  <td></td><td></td><td><font color='green'><b>$username14</b></font></td>
							  <td><font color='green'><b>$username15</b></font></td></tr>";				  
					
					
					//level 5
					echo "<tr><td>&nbsp</td>";
					
					echo "<tr><td align='left'><font color='red'><b>Level : 5</b></font></td></tr>";
					echo "<tr><td>&nbsp</td>";
					echo "<tr><td><img src='../icon/people.png' width='40' height='40'/></td>
					          <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							 
  							  <td><img src='../icon/people.png' width='40' height='40'/></td>
						      <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
						      <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td><td></td>
							  
							  <td><img src='../icon/people.png' width='40' height='40'/></td>
							  <td><img src='../icon/people.png' width='40' height='40'/></td></tr>";
									
							  
					echo "<tr><td><font color='green'><b>$username16</td>
					          <td><font color='green'><b>$username17</b></font></td><td></td>
							 
  							  <td><font color='green'><b>$username18</td>
						      <td><font color='green'><b>$username19</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username20</td>
							  <td><font color='green'><b>$username21</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username22</td>
						      <td><font color='green'><b>$username23</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username24</td>
							  <td><font color='green'><b>$username25</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username26</td>
							  <td><font color='green'><b>$username27</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username28</td>
							  <td><font color='green'><b>$username29</b></font></td><td></td>
							  
							  <td><font color='green'><b>$username30</td>
							  <td><font color='green'><b>$username31</b></font></td></tr>";
										
					echo "</table>";
					echo "<br><p align='center'><b><font color='blue'>-----------  Untuk melihat detail jaringan dibawah level 5 ini silakan berkoordinasi dengan upline pada level 5 ini  -----------</p></b></font>";
				?>
			</div>
		</div>		
	</div>
</div>
    