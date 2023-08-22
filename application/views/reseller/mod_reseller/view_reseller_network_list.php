<div class='col-md-12'>
	<link rel="stylesheet" type="text/css" href="style_view.css">
	<link href="jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet"/>
	<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.theme.css">
	<div class='box box-info'>
		<div class='box-header with-border'>
			<h3 class='box-title'>DETAIL DATA RESELLER DARI ANDA </h3>
			<div class='box-body'>
				<?php
					echo "Berikut adalah data Reseller dari Anda :</b><br><br>";
					
					echo " <table class='table table-striped table-condensed table-bordered'>
                                <tr style='background:#e3e3e3'>
                                    <th>No </th>
                                    <th>ID reseller</th>
                                    <th>Nama reseller</th>
                                    <th>Jenis kelamin</th>
									<th>Alamat</th>
									<th>Kode pos</th>
									<th>Telepon</th>
									<th>Email</th>
									<th>Tgl daftar</th>
                                </tr>";
                    $no = 1;
					if ($this->session->userdata("reff")==0) {
						$cari = $this->db->query("SELECT * FROM rb_reseller where reff_work=".$this->session->id_reseller);
					} else {											
						$cari = $this->db->query("SELECT * FROM rb_referral where referral=".$this->session->id_reseller);
					}
                    if ($cari->num_rows()<=0)
					{
                        echo "<center style='color:red; padding:40px'><i>Data reseller dari anda tidak ditemukan</i></center>";
                    }
					else
					{
                        foreach ($cari->result_array() as $row) 
						{
							echo "<tr><td width='20px'>$no</td>
									<td>$row[id_reseller]</td>  
									<td>$row[nama_reseller]</td>
									<td>$row[jenis_kelamin]</td>
									<td>$row[alamat_lengkap]</td>
									<td>$row[kode_pos]</td>
									<td>$row[no_telpon]</td>
									<td>$row[email]</td>
									<td>$row[tanggal_daftar]</td>
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
    