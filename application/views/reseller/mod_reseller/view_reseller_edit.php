<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Profile</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_reseller',$attributes); 
              $ko = $this->db->query("SELECT * FROM rb_kota where kota_id='$rows[kota_id]'")->row_array();
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden'  value='$rows[id_reseller]' name='id'>";
                    if (trim($rows['foto'])==''){ $foto_user = 'blank.png'; }else{ $foto_user = $rows['foto']; }
                    echo "<tr bgcolor='#e3e3e3'><th rowspan='35' width='110px'><center><img style='border:1px solid #cecece; height:85px; width:85px' src='".base_url()."asset/foto_user/$foto_user' class='img-circle img-thumbnail'></center></th></tr>
                    <tr><th width='130px' scope='row'>Username</th>       <td><input class='form-control' type='text' name='a' value='$rows[username]' disabled></td></tr>
                    <tr><th scope='row'>Ganti password</th>                     <td><input class='form-control' type='password' name='b'></td></tr>
                    <tr><th scope='row'>Nama Store Reseller</th>                <td><input class='form-control' type='text' name='c' value='$rows[nama_reseller]'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>                <td>"; if ($rows['jenis_kelamin']=='Laki-laki'){ echo "<input type='radio' value='Laki-laki' name='d' checked> Laki-laki <input type='radio' value='Perempuan' name='d'> Perempuan "; }else{ echo "<input type='radio' value='Laki-laki' name='d'> Laki-laki <input type='radio' value='Perempuan' name='d' checked> Perempuan "; } echo "</td></tr>
                    <tr><th scope='row'>Provinsi</th>                     <td><select class='form-control' name='state' id='state_reseller' required>
                                                                            <option value=''>- Pilih -</option>";
                                                                            $provinsi = $this->model_app->view_ordering('rb_provinsi','provinsi_id');
                                                                            foreach ($provinsi as $row) {
                                                                              if ($ko['provinsi_id']==$row['provinsi_id']){
                                                                                echo "<option value='$row[provinsi_id]' selected>$row[nama_provinsi]</option>";
                                                                              }else{
                                                                                echo "<option value='$row[provinsi_id]'>$row[nama_provinsi]</option>";
                                                                              }
                                                                            }
                                                                          echo "</select></td></tr>
                    <tr><th scope='row'>Kota</th>                         <td><select class='form-control' name='kota' id='city_reseller' required>
                                                                                <option value=''>- Pilih -</option>";
                                                                            $kota = $this->model_app->view_where_ordering('rb_kota',array('provinsi_id'=>$ko['provinsi_id']),'kota_id','DESC');
                                                                            foreach ($kota as $row) {
                                                                              if ($ko['kota_id']==$row['kota_id']){
                                                                                echo "<option value='$row[kota_id]' selected>$row[nama_kota]</option>";
                                                                              }else{
                                                                                echo "<option value='$row[kota_id]'>$row[nama_kota]</option>";
                                                                              }
                                                                            }
                                                                          echo "</select></td></tr>
                    <tr><th scope='row'>Alamat Lengkap</th>               <td><input class='form-control' type='text' name='e' value='$rows[alamat_lengkap]'></td></tr>
                    <tr><th scope='row'>No HP</th>                        <td><input class='form-control' type='number' name='f' value='$rows[no_telpon]'></td></tr>
                    <tr><th scope='row'>No KTP</th>                       <td><input class='form-control' type='text' name='o' value='$rows[no_ktp]'></td></tr>
					<tr><th scope='row'>Alamat Email</th>                 <td><input class='form-control' type='email' name='g' value='$rows[email]'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>                     <td><input class='form-control' type='number' name='h' value='$rows[kode_pos]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>                   <td><textarea class='form-control' name='i'>$rows[keterangan]</textarea></td></tr>
                    <tr><th scope='row'>ID Upline langsung</th>                  <td><input class='form-control' type='text' name='j' value='$rows[upline]' disabled></td></tr>
					<tr><th scope='row'>Nama upline langsung</th>                <td><input class='form-control' type='text' name='k' value='$rows[referral]' disabled></td></tr>
					<tr><th scope='row'>Grup parent ID</th>               <td><input class='form-control' type='text' name='l' value='$rows[parent_id]' disabled></td></tr>";
					//mencari grup parent name
          if ($this->session->userdata("reff")==0) {
            $cari_reseller = $this->db->query("SELECT * FROM rb_reseller where id_reseller='".$rows[parent_id]."'");
          }else{
            $cari_reseller = $this->db->query("SELECT * FROM rb_referral where id_reseller='".$rows[parent_id]."'");
          }					

     //      foreach ($cari_reseller->result_array() as $row) 
					// {
					// 	echo "<tr><th scope='row'>Nama toko</th><td><input class='form-control' type='text' name='m' value='$row[nama_reseller]' disabled></td></tr>";
					// 	//echo "<tr><th scope='row'>Grup parent user name</th><td><input class='form-control' type='text' name='n' value='$row[nama_reseller]' disabled></td></tr>";
					// }
					
					
					// if ($rows[remarks_upline]=='LO'){
					//    $keterangan='Left Outside';
					// }
					// elseif ($rows[remarks_upline]=='RO'){
					//    $keterangan='Right Outside'; //<td><img src='../images/'".$rows[buku_tabungan]."' width='70' height='90'/></td></tr> <td><input class='form-control' type='text' name='r' value='$rows[buku_tabungan]'></td></tr>
					// }
					// else{
					//    $keterangan='Middle';
					// }
					if ($this->session->userdata("reff")==0) {
					echo"<tr><th scope='row'>ID Refferal work</th>   <td><input class='form-control' type='text' name='o' value='$rows[reff_work]' disabled></td></tr>
					<tr><th scope='row'>No posisi di jaringan parent</th>     <td><input class='form-control' type='text' name='p' value='$rows[position]' disabled></td></tr>";
					}else{
            echo"<tr><th scope='row'>ID Refferal work</th>   <td><input class='form-control' type='text' name='o' value='$rows[referral]' disabled></td></tr>";
          }
          echo"<tr><th scope='row'>Nomor rekening</th>               <td><input class='form-control' type='text' name='r' value='$rows[norek_tabungan]'></td></tr>
					<tr><th scope='row'>Foto buku tabungan</th>           <td><img src='".base_url()."/images/".$rows[buku_tabungan]."' width='250' height='150'/></td></tr>
					<tr><th scope='row'>Ganti buku tab</th>				  <td><input class='form-control' type='file' name='s' value='$keterangan'></td></tr>
					<tr><th scope='row'>Ganti Foto</th>                   <td><input type='file' class='form-control' name='gg'>";
                    if ($rows['foto'] != ''){ 
						echo "<i style='color:red'>Foto Profile saat ini : </i><a target='_BLANK' href='".base_url()."asset/foto_user/$rows[foto]'>$rows[foto]</a>"; 
					} 
					echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='index.php'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div>";
