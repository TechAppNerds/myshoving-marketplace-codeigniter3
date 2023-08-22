<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    input[name=f]{
        resize:none;
        width:100%;
    }
</style>
<div class='panel-body'>
    <ul class='myTabs nav nav-tabs' role='tablist'>
      <li role='presentation' class='active'><a href='#reseller' role='tab' id='reseller-tab' data-toggle='tab' aria-controls='reseller' aria-expanded='true'>Pendaftaran Member</a></li>
    </ul><br>
    <div id='myTabContent' class='tab-content'>
        <div role='tabpanel' class='tab-pane fade active in' id='reseller' aria-labelledby='reseller-tab'>
            <div class='alert alert-warning'><b>PENTING!</b> Lengkapi Form dibawah ini untuk mendaftarkan diri sebagai <b>Member</b>, harap di isi dengan data yang sebenar-benarnya, Terima kasih...</div>
                <div class="block-content">
                    <div id="writecomment">
                        <form action="<?php echo base_url(); ?>auth/register" method="POST" id="form_komentar" enctype="multipart/form-data">
                            <p class="contact-form-user">
                                <label for="c_name">Username<span class="required">*</label>
                                <input type="text" name='a' onkeyup="nospaces(this)" required/>
                            </p>

                            <p class="contact-form-user">
                                <label for="c_name">Password<span class="required">*</label>
                                <input type="password" class="form-password" name='b' id='b' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="password harus terdiri minimal 1 angka, 1 huruf besar, 1 huruf kecil, 1 special karakter dan panjang password minimal 8 karakter" class="required" onkeyup="nospaces(this)" value="<?php echo $_SESSION['pass1']; ?>" required/>
                            </p>

                            <p class="contact-form-user">
                                <label for="c_name">Re-password<span class="required">*</label>
                                <input type="password" class="form-password" name='b2' id='b2' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="password harus terdiri minimal 1 angka, 1 huruf besar, 1 huruf kecil, 1 special karakter dan panjang password minimal 8 karakter" class="required" onkeyup="nospaces(this)" onfocusout="cekpass()" value="<?php echo $_SESSION['pass2']; ?>" required /> 
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
                                <input type="text" name="tgl_lahir" placeholder="Tanggal lahir anda" class="required" value="<?php echo $_SESSION['tgl_lahir']; ?>" required/>
                            </p>
                            
                            <script type="text/javascript">
                                $('input[name=tgl_lahir]').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '1950:2021'}).val();
                                $('input[name=tanggal_lahir]').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '1950:2021'}).val();
                            </script>
                            
                            <p class="contact-form-user">
                                <label for="c_name">No Handphone<span class="required">*</label>
                                <input type="text" name='f' pattern="[0-9]+" minlength="10" placeholder="Country Code + Handphone Number (example: 6281*********)" class="required" value="<?php echo $_SESSION['nohp']; ?>" required/>
                            </p>
                            
                            <p class="contact-form-user">
                                <label for="c_name">No KTP<span class="required">*</label>
                                <input type="text" name='k' minlength="12" placeholder="No. KTP Anda" class="required" value="<?php echo $_SESSION['ktp']; ?>" required/>
                            </p>
                            
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
                                <input type="file" name="foto_ktp" id="foto_ktp" placeholder="Upload foto KTP anda" onchange="filePreview(foto_ktp)" required/>
                            </p>
                            
                            <div id="uploadFile"></div><br/><br/>
                            
                            <p class="contact-form-user">
                                <label for="c_name">Nama di KTP<span class="required">*</label>
                                <input type="text" name='ktp' minlength="5" placeholder="Nama di KTP Anda" class="required" required/>
                            </p>
                            
                            <p class="contact-form-user">
                                <label for="c_name">No rekening<span class="required"></label>
                                <input type="number" name='l' minlength="9" placeholder="No. rekening Anda" class='required' />
                            </p>

                            <p class="contact-form-user">
                                <label for="c_name">Nama Bank<span class="required"></label>
                                <input type="text" name='bank' minlength="3" placeholder="Nama Bank anda, tulis tanpa kata Bank" class="required" />
                            </p>
                            
                            <p class="contact-form-user">
                                <label for="c_name">Buku tabungan<span class="required"></label>
                                <input type="file" name='m' placeholder="Upload foto no rek anda" />
                            </p>
                            
                            <p class="contact-form-email">
                                <label for="c_email">E-mail<span class="required"></span></label>
                                <input type="email" name='g' placeholder="alamat.emailanda@mail.com" class="required" value="<?php echo $_SESSION['email']; ?>" />
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
                                <label for="c_message">Kota<span class="required">*</span></label>
                                            <select style='margin-left:5px' class='form-control' name='kota' id='city_reseller' required>
                                                    <option value='' disabled selected>- Pilih -</option>
                                            </select>
                            </p>

                            <p class="contact-form-message">
                                <label for="c_message">Alamat<span class="required">*</span></label>
                                <textarea name='e' minlength="10" placeholder="Nama Kecamatan, Desa, Jalan, dan No Rumah anda.." class="required" required><?php echo $_SESSION['alamat']; ?></textarea>
                            </p>
                            
                            <p class="contact-form-user">
                                <label for="c_name">Kode POS<span class="required">*</label>
                                <input type="number" name='h' pattern="[0-9]+" minlength="5" placeholder="*******" onkeyup="nospaces(this)" class="required" value="<?php $_SESSION['kodepos'];?>" required/>
                            </p>
                            
                            <p class="contact-form-user">
                                <label for="c_name">Reff username<span class="required">*</label>
                                                            
                            <?php							
								$id_member=$_GET['userid'];
								//echo "<script>alert('".$id_member."');</script>";

								if($id_member=="")
								{
									$id_member="company";
								?>			
									<input type="text" name='i' value="<?php echo $id_member;?>" placeholder="refferal anda" onkeyup="nospaces(this)" class="required" required />								
								<?php
								}
								else
								{
								?>
									<input type="text" name='i' value="<?php echo $id_member;?>" placeholder="refferal anda" onkeyup="nospaces(this)" class="required" required readonly />								
								<?php
								}
								?>
                            </p>
                        
                            <!-- deteksi otomatis tanggal dan jam saat registrasi member-->
                            <input type="hidden" name="ts" id="ts" size="16" readonly />
                            
                            <script type="text/javascript">
                                    var today = new Date();
                                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                                    var datetime = date+' '+time;
                                    document.getElementById("ts").value = datetime;
                            </script>
                        
                            <p class="contact-form-message">
                                <label for="c_message">Ketentuan</label>
                                <textarea name='z' align='justify' style="resize:none;width:100%;height:200px" readonly>1. Biaya menjadi reseller online di website ini Rp.10.000 (sekali saja) dan ditransfer ke &#13;&#10;    rek BCA 8621118811 atas nama anthonius efendy. &#13;&#10;2. Jika sudah melakukan transfer harap melakukan konfirmasi ke nomor &#13;&#10;    WA 089529784689 agar kami bisa segera memproses akun reseller anda. &#13;&#10;3. Biaya reseller tersebut sebagai biaya untuk maintenance server dan hosting ke ISP. &#13;&#10;4. Jika anda memberikan referensi kepada orang lain untuk menjadi reseller di website &#13;&#10;    ini, maka kami akan memberikan biaya jasa promosi website kepada anda sebesar &#13;&#10;    Rp. 5.000. &#13;&#10;5. Dengan klik tombol daftar, maka anda sudah memahami syarat dan ketentuan untuk &#13;&#10;    menjadi reseller di website ini.
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
                            <input type="checkbox" name="setuju" id="setuju" value="setuju" onclick="javascript:enableButton();"> Saya memahami semua ketentuan tersebut diatas<br/><br/>
                            
                            <input type="submit" name="submit2" id="submit2" value="Daftar Sebagai Reseller" disabled>
                        </form>
                    </div>
                </div>
            <div style='clear:both'><br></div>
        </div>
    </div>
</div>