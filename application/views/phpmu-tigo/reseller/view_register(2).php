<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class='panel-body'>
    <ul class='myTabs nav nav-tabs' role='tablist'>
      <li role='presentation' class=''><a href='#reseller' role='tab' id='reseller-tab' data-toggle='tab' aria-controls='reseller' aria-expanded='true'>Pendaftaran Member</a></li>
	  <li role='presentation' class='active'><a href='#konsumen' id='konsumen-tab' role='tab' data-toggle='tab' aria-controls='konsumen' aria-expanded='false'>Pendaftaran Pembeli </a></li>
	</ul><br>
    <div id='myTabContent' class='tab-content'>
        <div role='tabpanel' class='tab-pane fade' id='reseller' aria-labelledby='reseller-tab'>
        <div class='alert alert-warning'><b>PENTING!</b> Lengkapi Form dibawah ini untuk mendaftarkan diri sebagai <b>Member</b>, harap di isi dengan data yang sebenar-benarnya, Terima kasih...</div>
            <div class="block-content">
                <div id="writecomment">
                    <form action="<?php echo base_url(); ?>auth/register" method="POST" enctype="multipart/form-data" id="uploadForm">
                        <p class="contact-form-user">
                            <label for="c_name">Username<span class="required">*</label>
                            <input type="text" name='a' onkeyup="nospaces(this)" required/>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">Password<span class="required">*</label>
                            <input type="password" class="form-password" name='b' id='b' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="required" onkeyup="nospaces(this)" value="<?php echo $_SESSION['pass1']; ?>" required /> 
						</p>
						
						<p class="contact-form-user">
                            <label for="c_name">Re-password<span class="required">*</label>
                            <input type="password" class="form-password" name='b2' id='b2' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="required" onkeyup="nospaces(this)" onfocusout="cekpass()" value="<?php echo $_SESSION['pass2']; ?>" required /> 
							&nbsp;<input type="checkbox" class="form-checkbox"> Show password
						</p>
						
						<script type="text/javascript">
							function cekpass()
							{
								var password1 = document.getElementById('b').value;
								var password2 = document.getElementById('b2').value;
							
								if (password1!=password2)
								{
									alert("Password tidak sama, silahkan cek sekali lagi!");
								}
							}

                            
							
							$(document).ready(function()
							{		
								$('.form-checkbox').click(function()
								{
									if($(this).is(':checked'))
									{
										$('.form-password').attr('type','text');
									}
									else
									{
										$('.form-password').attr('type','password');
									}
								});

                                
							});							
						</script>
						
                        <p class="contact-form-user">
                            <label for="c_name">Nama Toko<span class="required">*</label>
                            <input type="text" name='c' placeholder="Tuliskan Nama Anda / Perusahaan,.." class="required" value="<?php echo $_SESSION['namalengkap']; ?>" required/>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">Jenis Kelamin<span class="required">*</label>
                            <input type='radio' name='d' value='Laki-laki' checked='checked'> Laki-laki &nbsp;
                            <input type='radio' name='d' value='Perempuan'> Perempuan
                        </p>

						<p class="contact-form-user">
                            <label for="c_name">Tempat lahir<span class="required">*</label>
                            <input type="text" name='tempat_lahir' placeholder="Tempat lahir anda" class="required" value="<?php echo $_SESSION['tempatlahir']; ?>" required/>
                        </p>
						<p class="contact-form-user">
                            <label for="c_name">Tanggal lahir<span class="required">*</label>
                            <input type="text" name='tgl_lahir' placeholder="Tanggal lahir anda" class="required" data-minrange="-100" data-maxrange="+0" value="<?php echo $_SESSION['tgl_lahir']; ?>" required/>
                        </p>
						
                        <p class="contact-form-user">
                            <label for="c_name">No Handphone<span class="required">*</label>
                            <input type="number" name='f' minlength="10" placeholder="08**********" class="required" value="<?php echo $_SESSION['nohp']; ?>" required/>
                        </p>
						
						<p class="contact-form-user">
                            <label for="c_name">No KTP<span class="required">*</label>
                            <input type="text" name='k' minlength="12" placeholder="No. KTP Anda" class="required" value="<?php echo $_SESSION['ktp']; ?>" required/>
                        </p>				                      
						
						<p class="contact-form-user">
                            <label for="c_name">No rekening<span class="required"></label>
                            <input type="number" class="required" name='l' minlength="9" placeholder="No. rekening Anda"/>
                        </p>

						<p class="contact-form-user">
                            <label for="c_name">Buku tabungan<span class="required"></label>
                            <input type="file" name='m' placeholder="Upload foto no rek anda"/>
                        </p>
                        
						<p class="contact-form-email">
                            <label for="c_email">E-mail<span class="required">*</span></label>
                            <input type="email" name='g' placeholder="alamat.emailanda@mail.com" onkeyup="nospaces(this)" class="required" value="<?php echo $_SESSION['email']; ?>" required/>
                        </p>

                        <p class="contact-form-message">
                            <label for="c_message">Provinsi<span class="required">*</span></label>
                            <?php echo "<select style='margin-left:5px' class='form-control' name='state' id='state_reseller' required>
                                        <option value='' disabled selected>- Pilih -</option>";
                                        foreach ($provinsi as $rows) {
                                            echo "<option value='$rows[provinsi_id]'>$rows[nama_provinsi]</option>";
                                        }
                                    echo "</select>"; ?>
                        </p>

                        <p class="contact-form-message">
                            <label for="c_message">Alamat<span class="required">*</span></label>
                            <textarea name='e' minlength="10" placeholder="Nama Kecamatan, Desa, Jalan, dan No Rumah anda.." class="required" required><?php echo $_SESSION['alamat']; ?></textarea>
                        </p>
						
						<p class="contact-form-message">
                            <label for="c_message">Kota<span class="required">*</span></label>
                            <select style='margin-left:5px' class='form-control' name='kota' id='city_reseller' required>
                                <option value='' disabled selected>- Pilih -</option>
                            </select>
                        </p>

						<p class="contact-form-user">
                            <label for="c_name">Reff username<span class="required">*</label>
                            <select style='margin-left:5px' class='form-control' name='i' id='i' required>
						<?php
										$cari_reference=$this->db->query("SELECT username FROM rb_reseller");
										foreach ($cari_reference->result_array() as $row_reference)
										{
											$namauser=$row_reference[username];
						?>		
											<option value=<?php echo "$namauser";?>><?php echo "$namauser";?></option>		
						<?php
										}
						// <input type="text" name='i' placeholder="jika tidak ada kode referral, isi dengan company" onkeyup="nospaces(this)" class="required" required/>							
						// </p>
						?>
							</select>
						</p>
					   					   
                        <p class="contact-form-user">
                            <label for="c_name">Kode POS<span class="required">*</label>
                            <input type="number" name='h' placeholder="*******" onkeyup="nospaces(this)" class="required" value="<?php $_SESSION['kodepos'];?>" required/>
                        </p>
						<?php //deteksi otomatis tanggal dan jam saat registrasi member ?>
						<input type="hidden" name="ts" id="ts" size="16" readonly />
						<script type="text/javascript">
                            $('input[name=tgl_lahir]').datepicker({dateFormat: 'dd/mm/yy', 
                                changeMonth: true, 
                                changeYear: true, 
                                yearRange: $('input[name=tgl_lahir]').data('minrange')+':'+$('input[name=tgl_lahir]').data('maxrange')
                            }).val();
                            var today = new Date();
                            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                            var datetime = date+' '+time;
                            document.getElementById("ts").value = datetime;
						</script>
					
						<p class="contact-form-message">
							<label for="c_message">Ketentuan</label>
							<textarea name='z' style="resize:none;width:600px;height:150px" readonly>1. Biaya pendaftaran menjadi reseller online di website ini Rp.10.000 (one time cost). &#13;&#10;2. Biaya pendaftaran tersebut sebagai biaya untuk maintenance server dan hosting ke ISP. &#13;&#10;3. Jika anda memberikan referensi kepada orang lain untuk menjadi reseller di website ini, &#13;&#10;    maka kami akan memberikan biaya jasa promosi website kepada anda sebesar Rp. 5.000. &#13;&#10;4. Dengan klik tombol daftar, maka anda sudah memahami syarat dan ketentuan untuk &#13;&#10;    menjadi reseller di website ini.
							</textarea>
						</p>
						<script type="text/javascript">
                            function enableButton() 
                            {
                                if(document.getElementById('setuju').checked)
                                {
                                    document.getElementById('submit2').disabled='';
                                } 
                                else 
                                {
                                    document.getElementById('submit2').disabled='true';
                                }
                            }
                            $("select#state_reseller").change(function (){
                                $.ajax({
                                    url: "city",
                                    type: 'POST',
                                    data: "stat_id="+$(this).val(),
                                    success: function(resp) {
                                        $("select#city_reseller").html(resp);
                                    },
                                    error: function() {
                                        console.log('something went wrong');
                                    }
                                });
                            });
						</script>
						
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
						<script>
						   function filePreview(input) {
							if (input.files && input.files[0]) {
								var reader = new FileReader();
								reader.onload = function (e) {
									$('#uploadFile + img').remove();
									$('#uploadFile').after('<img src="'+e.target.result+'" width="200" height="130"/>');
								};
								reader.readAsDataURL(input.files[0]);
							}
							
						}	
						</script>
						<p class="contact-form-user">
                            <label for="c_name">Foto KTP<span class="required">*</label>
						</p>
                        <input type="file" name="file" id="file" onchange="filePreview(file)" />
						<br/>
						<div id="uploadFile"></div>							
						<br/>
						<input type="checkbox" name="setuju" id="setuju" value="setuju" onclick="javascript:enableButton();"> Saya memahami semua ketentuan tersebut diatas<br/><br/>
						
						<input type="submit" name="submit2" id="submit2" value="Daftar Sebagai Reseller" disabled>
                    </form>
                </div>
            </div>
            <div style='clear:both'><br></div>
        </div>
		
		<div role='tabpanel' class='tab-pane fade active in' id='konsumen' aria-labelledby='konsumen-tab'>

            <div class='alert alert-info'><b>PENTING!</b> Lengkapi Form dibawah ini untuk mendaftarkan diri Sebagai <b>Pembeli</b>, harap di isi dengan data yang sebenar-benarnya sesuai dengan KTP, Terima kasih...</div>
            <div class="block-content">
                <div id="writecomment">
                    <form action="<?php echo base_url(); ?>auth/register" method="POST" id="form_komentar">
                        <p class="contact-form-user">
                            <label for="c_name">Username<span class="required">*</label>
                            <input type="text" name='a' class="required" onkeyup="nospaces(this)" required/>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">Password<span class="required">*</label>
                            <input type="password" name='b' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="required" onkeyup="nospaces(this)" required/>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">Nama Lengkap<span class="required">*</label>
                            <input type="text" name='c' placeholder="Tuliskan Nama Lengkap,.." class="required" required/>
                        </p>

                        <p class="contact-form-email">
                            <label for="c_email">E-mail<span class="required">*</span></label>
                            <input type="email" name='d' placeholder="alamat.emailanda@mail.com" onkeyup="nospaces(this)" class="required" required/>
                        </p>

                        <p class="contact-form-message">
                            <label for="c_message">Provinsi<span class="required">*</span></label>
                            <?php echo "<select style='margin-left:5px' class='form-control' name='g' id='state' required>
                                            <option value='' disabled selected>- Pilih -</option>";
                                            foreach ($provinsi as $rows) {
                                                echo "<option value='$rows[provinsi_id]'>$rows[nama_provinsi]</option>";
                                            }
                                        echo "</select>"; ?>
                        </p>

                        <p class="contact-form-message">
                            <label for="c_message">Kota<span class="required">*</span></label>
                            <select style='margin-left:5px' class='form-control' name='h' id='city' required>
                                    <option value='' disabled selected>- Pilih -</option>
                            </select>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">Kecamatan<span class="required">*</label>
                            <input type="text" name='i' placeholder="Nama Kecamatan.." class="required" required/>
                        </p>

                        <p class="contact-form-message">
                            <label for="c_message">Alamat<span class="required">*</span></label>
                            <textarea name='e' minlength="10" placeholder="Alamat Desa, Jalan, dan No Rumah/Kantor anda.." class="required" required></textarea>
                        </p>

                        <p class="contact-form-user">
                            <label for="c_name">No Handphone<span class="required">*</label>
                            <input type="number" name='j' minlength="10" placeholder="08**********" class="required" required/>
                        </p>
                        <p><input type="submit" name="submit1" class="styled-button" value="Daftar Sebagai Pembeli"/></p>
                    </form>
                </div>
            </div>
            <div style='clear:both'><br></div>
        </div>
    </div>
</div>