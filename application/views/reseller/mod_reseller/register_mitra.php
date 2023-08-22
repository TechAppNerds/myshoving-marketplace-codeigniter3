<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php 
// $this->session->reff_name="hero114";
// $this->session->id_reseller="1010";
// var_dump($this->session->jumlah);
// var_dump($this->cookie);
// var_dump($cek_reff);

$data=$this->model_app->view_where(($this->session->reff==1?"rb_referral":"rb_reseller"),array('id_reseller'=>$this->session->id_reseller))->row_array();
$cek_id_member=$this->model_app->view_where("rb_reseller",array('username'=>$data["username"]));
?>

<head>
<style>
    input[type=text],input[type=number],input[type=password],input[type=email],textarea,select,option{
        width: 30vw;
    }
    input[type=radio]{
        margin: 0 0 0 10px;
    }
    p .required {
        display: inline-block;
        font-weight: bold;
        /*font-size: 18px;*/
        color: #cf680d;
        margin-left: 5px;
        margin-top: 2px;
    }
</style>
<script language="javascript" type="text/javascript">
    // if (cekpass()) {var cekconfirm=cekpass();}
    // if (CheckPassFormat()) {var cekformatpass=CheckPassFormat();}
    $(document).ready(function(){
        $("input[name=qty]").click(function(){
            if ($("input[name=qty]:checked").val() == 1){
                $("input[name=reffus]").prop('readonly', false);
            }else{
                $("input[name=reffus]").val("<?php echo $data["username"];?>");
                $("input[name=reffus]").prop('readonly', true);
            }
        });
    });

    function nospaces(t){
        if(t.value.match(/\s/g)){
            swal({                
                text: 'Maaf, tidak boleh menggunakan spasi',
                type: 'warning',
            });
            t.value=t.value.replace(/\s/g,'');
        }
    }

    var cekconfirm, cekformatpass;
    function CheckPassFormat(p) {
        var anUpperCase = /[A-Z]/, aLowerCase = /[a-z]/, aNumber = /[0-9]/, aSpecial = /[!|@|#|$|%|^|&|*|(|)|-|_]/;

        if(p.length < 8){
            Swal.fire({
                text: 'Panjang Password minimal 8 karakter',
                type:'error'
            });
            return false;
        }

        var numUpper = 0, numLower = 0, numNums = 0, numSpecials = 0;
        for(let i=0; i<p.length; i++){
            if(anUpperCase.test(p[i])) numUpper++;
            else if(aLowerCase.test(p[i])) numLower++;
            else if(aNumber.test(p[i])) numNums++;
            else if(aSpecial.test(p[i])) numSpecials++;
        }
        if(numUpper < 1 || numLower < 1 || numNums < 1 || numSpecials < 1){
            Swal.fire({
                text: 'Format Password Salah',
                type:'error'
            });
            return false;
        }
        return true;
    }

    function cekpass()
    {
        var password1 = document.getElementById('pass').value;
        var password2 = document.getElementById('cpass').value;

        if (password1!=password2)
        {
            Swal.fire({
                text: 'Password tidak sama, silahkan cek sekali lagi!',
                type:'error'
            });
            return false;
            // alert("Password tidak sama, silahkan cek sekali lagi!");
        }
        return true;
    }

    function enableButton() 
    {
        // alert(CheckPassFormat());
        // if (cekconfirm && cekformatpass) {
            
            // cekconfirm=cekpass();
            // cekformatpass=CheckPassFormat();
            // console.log(cekconfirm);
            // console.log(cekformatpass);
            $("button[name='registermitra']").prop("disabled",$("#setuju").is(":checked")?false:true);
        // }
    }

    // $(document).ready(function(){
    //     $("input[name='qty']").click(function(){
    //         $("label#ctr").html($(this).val());
    //     });
    // });
    
    // if (typeof password1!==undefined&&typeof password2!==undefined&&typeof numUpper!==undefined&&typeof numLower!==undefined&&typeof numNums!==undefined&&typeof numSpecials!==undefined) {
    //     var password1 = document.getElementById('pass').value;
    //     var password2 = document.getElementById('cpass').value;
    //     if (password1==password2 && (numUpper > 0 && numLower > 0 && numNums > 0 && numSpecials > 0) && $("#setuju").is(":checked")) {
    //         $("button[name='registermitra']").prop("disabled",true);
    //     }
    // }
</script>
</head>
<body>
    <form id="mitra_register_form" method="POST" action="<?php echo base_url(); ?>Reseller/register_mitra" enctype="multipart/form-data">
        <div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header with-border'>
                    <h3 class='box-title'><b>Pendaftaran Mitra</b></h3><br/><br/>
                    <div class='box-body'>
                        <!-- <label><a href="<?php echo base_url()."auth/register?userid=".$this->session->username;?>">klik link dibawah ini</a></label>
                        <br/><br/> -->
                        <?php
                            // echo "<script>alert('".$this->session->jumlah."')</script>";
                        ?>
                        <?php if (isset($_GET["no"])) :
                            // echo "<script>alert('".$this->session->jumlah."')</script>";
                            // echo "<script>alert('".$_GET["no"]."')</script>";?>                            
                            <input type="hidden" name="counter" value="<?php echo $_GET["no"];?>" />
                        <?php endif;?>
                        <?php $ctr = $this->session->jumlah!="" ? $this->session->jumlah-$_GET["no"]+1 : 1;?>
                        <label id='daftarke'>Daftar ke = <label id="ctr"><?php echo $ctr;?></label></label><br/><br/>

                        <p>Kode Voucher<span class="required">*</span></p>
                        <input type="password" name="kode" value="" required><br/>
                        <input type="checkbox" class="form-checkbox-svc"> Show Voucher Code<br/><br/>

                        <?php if($_SESSION['ctrreg']=="") { ?>
                            <p>Jumlah daftar<span class="required">*</span></p>
                                <input type='radio' name='qty' value='1' checked='checked'> 1 &nbsp;
                                <input type='radio' name='qty' value='3'> 3 &nbsp;
                                <input type='radio' name='qty' value='7'> 7 <br/><br/>
                        <?php } ?>

                        <p>Username<span class="required">*</span></p>
                        <?php if($cek_id_member->num_rows() < 1):?>
                            <input type="text" name='username' onkeyup="nospaces(this)" value="<?php echo $data[username];?>" required readonly/><br/><br/>
                        <?php else:?>
                            <input type="text" name='username' onkeyup="nospaces(this)" value="<?php echo $this->session->field_username!='' ? $this->session->field_username : $data[username];?>" required/><br/><br/>
                        <?php endif;?>

                        <p>Password<span class="required">*</span></p>
                        <input type="password" class="form-password" name='pass' id='pass' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="password harus terdiri minimal 1 angka, 1 huruf besar, 1 huruf kecil, 1 special karakter dan panjang password minimal 8 karakter" class="required" onblur="CheckPassFormat(this.value)" onkeyup="nospaces(this)" value="<?php echo $this->session->pass1!='' ? $_SESSION['pass1'] : $this->session->pass_reff; ?>" required/><br/><br/>

                        <p>Konfirmasi Password<span class="required">*</span></p>
                        <input type="password" class="form-cpassword" name='cpass' id='cpass' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="password harus terdiri minimal 1 angka, 1 huruf besar, 1 huruf kecil, 1 special karakter dan panjang password minimal 8 karakter" class="required" onkeyup="nospaces(this)" onfocusout="cekpass()" value="<?php echo $this->session->pass2!='' ? $_SESSION['pass2'] : $this->session->pass_reff; ?>" required /><br/>
                        <input type="checkbox" class="form-checkbox"> Show password<br/><br/>

                        <p>Nama Lengkap<span class="required">*</span></p>
                        <input type="text" name='namalengkap' placeholder="Tuliskan Nama Anda / Perusahaan.." class="required" value="<?php echo $_SESSION['namalengkap']; ?>" required/><br/><br/>

                        <p>Jenis Kelamin<span class="required">*</span></p>
                        <input type='radio' name='jk' value='L' checked='checked'> Laki-Laki &nbsp;
                        <input type='radio' name='jk' value='P'> Perempuan <br/><br/>

                        <p>Nomor Handphone<span class="required">*</span></p>
                        <input type="text" name='nohp' onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="10" placeholder="Contoh: 6281*********" class="required" value="<?php echo $this->session->nohp!=''?$_SESSION['nohp']:$data[no_telpon]; ?>" onkeyup="nospaces(this)" required/><br/><br/>

                        <p>E-mail<span class="required"></span></p>
                        <input type="email" name='email' placeholder="alamat.emailanda@mail.com" value="<?php echo $_SESSION['email'];?>" /><br/><br/>

                        <p>Tempat lahir<span class="required">*</p>
                        <input type="text" name='tempat_lahir' placeholder="Tempat lahir anda" class="required" value="<?php echo $this->session->tempatlahir!=''?$_SESSION['tempatlahir']:$data[tempat_lahir];?>" required/><br/><br/>
                        
                        <p>Tanggal Lahir<span class="required">*</span></p>
                        <input type="text" name="tgl_lahir" placeholder="Tanggal lahir anda" class="required" value="<?php echo $this->session->tgl_lahir!=''?$_SESSION['tgl_lahir']:$data[tgl_lahir];?>" required autocomplete="off" /><br/><br/>

                        <p>Nomor KTP<span class="required">*</span></p>
                        <input type="text" name='noktp' onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="16" maxlength="16" placeholder="No. KTP Anda" class="required" value="" required/><br/><br/>

                        <p>Nama di KTP<span class="required">*</span></p>
                        <input type="text" name='namaktp' onkeydown="return (event.keyCode >= 65 && event.keyCode <= 90) || event.keyCode == 8 || event.keyCode==32" minlength="5" placeholder="Nama di KTP Anda" class="required" required/><br/><br/>

                        <p>Foto KTP<span class="required">*</span></p>
                        <input type="file" name="foto_ktp" id="foto_ktp" placeholder="Upload foto KTP anda" onchange="filePreview(foto_ktp)" required/>

                        <div id="uploadFile"></div><br/><br/>

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

                        <p>Provinsi<span class="required">*</span></p>
                        <?php echo "<select style='width:30vw;' class='form-control' name='state' id='state_reseller' required>
                                    <option value='' disabled selected>- Pilih -</option>";
                                    foreach ($provinsi as $rows) {
                                        echo "<option value='$rows[provinsi_id]'>$rows[nama_provinsi]</option>";
                                    }
                                echo "</select>"; ?>
                        <br/><br/>

                        <p>Kota<span class="required">*</span></p>
                        <select style='width:30vw;' class='form-control' name='kota' id='city_reseller' required>
                            <option value='' disabled selected>- Pilih -</option>
                        </select><br/><br/>

                        <p>Alamat<span class="required">*</span></p>
                        <textarea name='alamat' minlength="5" value="<?php echo $_SESSION['alamat'];?>" placeholder="Nama Kecamatan, Desa, Jalan, dan No Rumah anda.." class="required" required></textarea><br/><br/>

                        <script>
                            $("textarea[name=alamat]").val("<?php echo $_SESSION['alamat'];?>");
                        </script>

                        <p>Kode POS<span class="required">*</span></p>
                        <input type="text" name='kodepos' onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="5" placeholder="Masukkan Kode Pos" onkeyup="nospaces(this)" class="required" value="<?php echo $_SESSION['kodepos'];?>" required/><br/><br/>

                        <p>Nomor Rekening</p>
                        <input type="text" name='norek' onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="9" placeholder="No. rekening Anda" class='required' /><br/><br/>

                        <p>Nama Bank</p>
                        <input type="text" name='namabank' minlength="3" placeholder="Nama Bank anda, tulis tanpa kata Bank" class="required" /><br/><br/>

                        <p>Cabang Bank</p>
                        <input type="text" name='cabbank' minlength="3" placeholder="Lokasi Cabang Bank anda, tulis tanpa kata Bank" class="required" /><br/><br/>

                        <p>Buku Tabungan</p>
                        <input type="file" name='bukutab' placeholder="Upload foto no rek anda" /><br/><br/>

                        <!-- <p>NPWP</p>
                        <input type="text" name='nohp' pattern="[0-9]+" minlength="10" placeholder="Jika Ada" class="required" value="" required/><br/><br/> -->

                        <p>Refferal Username</p>
                        <?php 
                            $data_id_member=$cek_id_member->row();
                            $id_member = $cek_id_member->num_rows() > 0 ? $data_id_member->username : $data["referral"];
                        ?>
                        <input type="text" name='reffus' value="<?php echo $id_member;?>" placeholder="refferal anda" onkeyup="nospaces(this)" class="required" required /><br/><br/>

                        <input type="hidden" name="ts" id="ts" size="16" readonly />
                            
                        <script type="text/javascript">
                            var today = new Date();
                            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                            var datetime = date+' '+time;
                            document.getElementById("ts").value = datetime;
                        </script>

                        <p>Ketentuan</p>
                        <textarea name='z' align='justify' style="resize:none;height:200px;" readonly><?php /*1. Biaya menjadi reseller online di website ini Rp.10.000 (sekali saja) dan ditransfer ke &#13;&#10;    rek BCA 8621118811 atas nama anthonius efendy. &#13;&#10;2. Jika sudah melakukan transfer harap melakukan konfirmasi ke nomor &#13;&#10;    WA 089529784689 agar kami bisa segera memproses akun reseller anda. &#13;&#10;3. Biaya reseller tersebut sebagai biaya untuk maintenance server dan hosting ke ISP. &#13;&#10;4. Jika anda memberikan referensi kepada orang lain untuk menjadi reseller di website &#13;&#10;    ini, maka kami akan memberikan biaya jasa promosi website kepada anda sebesar &#13;&#10;    Rp. 5.000. &#13;&#10;5. Dengan klik tombol daftar, maka anda sudah memahami syarat dan ketentuan untuk &#13;&#10;    menjadi reseller di website ini.*/ ?>
                        </textarea><br/><br/>

                        <input type="checkbox" name="setuju" id="setuju" value="setuju" onclick="javascript:enableButton();">
                        <label id="label_agree" style="/*margin: 0px; font-weight: unset;*/">Saya memahami semua ketentuan tersebut diatas</label><br/><br/>
                        
                        <label id="pesanerror"></label>
                        <button type="submit" name="registermitra" class="btn btn-info" disabled="">Daftar Sebagai Mitra</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>