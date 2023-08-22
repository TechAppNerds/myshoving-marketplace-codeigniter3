<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<style>
    #submit2{
        width: 65%;
        height: 35px;
    }
    input[name=f]{
        resize:none;
        width:100%;
    }
    .block-content{
        overflow: hidden;
        background: #dddddd;
        /* padding: 10px; */
        /* margin-top: -10px; */
        box-shadow: 0 1px 1px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        float: right;
        /* width: 50%; */
    }
    div#writecomment{
        /*display: inline-block; text-align: right; width: 100%;*/
        display: block;
        width: 100%;
        /*width: 80%;*/
        /* max-width: 570px; */
        /* margin: 20px auto; */
        /*display: block;
        margin: 20px 0px 0px 130px;*/
        /*margin: 20px 100px 0px 130px;*/
        margin: 20px 0px 0px 130px;
    }
    div.bodyregister{
        display: block;
        /*width: 80%;
        min-width: 400px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;*/
    }
    div.logoregister{
        /*overflow: hidden;*/
    /* background: #dddddd; */
    /* padding: 10px; */
    /* margin-top: -10px; */
    /* box-shadow: 0 1px 1px rgba(0,0,0,0.08); */
        /*margin-bottom: 20px;*/
    /* width: 50%;*/
        /*float: left;
        display: block;*/
        width: 100%;
        /*height: 1300px;*/
        height: 500px;
        /*background-size: 160%;*/
        /*background-size: 100%;*/
        
        /*background-position: center;*/
        min-width: 40em;
        background-size: contain;
        /*height: 0;*/
        /*background: orange;*/
        background: lightblue;
        background-position: top left;
        background-repeat: no-repeat;
        /*padding-top: 66.64%;*/
    /* padding-bottom: 0%; */
    /* background-position: 50%; */
    /* background-color: #fff; */
    /* left: 0; */
    /* right: 0; */
    /* top: 0; */
    /* bottom: 0; */
    /* z-index: -1; */
    /* position: fixed; */
    /* position: absolute; */
    /* display: inline-block; */
    /* position: relative; */
    /* background-position: center top;*/

        /*padding-bottom: 100.64%;
        background-size: 100% 100%;*/
    }
    .block-content{
        /*padding: 0;*/
        /*overflow: hidden;*/
        background: white;
        box-shadow: 0 1px 1px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        /*float: left;*/
        /*width: 47%;*/
        /*width: 35%;*/
        width: 37%;
        /*margin-top: -1250px;*/
        /*margin-top: -420px;*/
        margin-top: -450px;
        /*margin-top: -1300px;*/
        margin-right: 50px;
        margin-left: 60px;
        padding: 10px;
        border-radius: 3%;
    }
    #writecomment p textarea, .form-control, .content input[type=password], #writecomment p input[type=text], .content input[type=email], .content input[type=number]{
        /* width: 65%; */
        width: 35%;
    }
    #writecomment p input[type=text],#writecomment p input[type=password]{
        /* box-sizing: border-box;
        padding: 8px 10px; */
        box-sizing: border-box;
        padding: 8px 10px;
        display: inline-block;
        /* background: #fff;
        font-size: 13px;
        border: 1px solid #d3d3d3;
        font-family: 'Arial';
        border-radius: 2px; */
    }
    #writecomment p text{
        color: red;
    }
    p.field_username input, p.field_password input, p.field_cpassword input{
        margin-left: 5px;
    }
</style>
<script>
    function cekpass()
    {
        var password1 = document.getElementById('b').value;
        var password2 = document.getElementById('b2').value;
    
        if (password2.length<1) {
            Swal.fire({
                text: 'kolom Confirm Password tidak boleh kosong',
                type:'error'
            });
            $("p.field_cpassword text").html("kolom Confirm Password tidak boleh kosong");
            $("p.field_cpassword input").css("border-color","red");
            return false;
        }else{
            if (password1!=password2)
            {
                swal({                
                    text: 'Password Tidak Sama, Silahkan Cek Sekali Lagi!',
                    type: 'error',
                });
                $("p.field_cpassword text").html("Password Tidak Sama, Silahkan Cek Sekali Lagi!");
                $("p.field_cpassword input").css("border-color","red");
                return false;
            }
        }
        $("p.field_cpassword text").html("");
        $("p.field_cpassword input").css("border-color","blue");
        return true;
    }

    function CheckPassFormat(p) {
        var anUpperCase = /[A-Z]/, aLowerCase = /[a-z]/, aNumber = /[0-9]/, aSpecial = /[!|@|#|$|%|^|&|*|(|)|-|_]/;
        if (p.length < 1) {
            Swal.fire({
                text: 'kolom Password tidak boleh kosong',
                type:'error'
            });
            $("p.field_password text").html("kolom Password tidak boleh kosong");
            $("p.field_password input").css("border-color","red");
            return false;
        }else if(p.length < 8){
            Swal.fire({
                text: 'Panjang Password Minimal 8 Karakter',
                type:'error'
            });
            $("p.field_password text").html("Panjang Password Minimal 8 Karakter");
            $("p.field_password input").css("border-color","red");
            return false;
        }

        var numUpper = 0, numLower = 0, numNums = 0, numSpecials = 0;
        for(let i=0; i<p.length; i++){
            if(anUpperCase.test(p[i])) numUpper++;
            else if(aLowerCase.test(p[i])) numLower++;
            else if(aNumber.test(p[i])) numNums++;
            else numSpecials++;
        }
        // if(numUpper < 1 || numLower < 1 || numNums < 1 || numSpecials < 1){
        // if(numUpper < 1 || numLower < 1 || numNums < 1){
        // alert(numNums < 1);

        // if(numNums < 1 || numUpper < 1 || numLower < 1 || (numUpper < 1 && numLower > 0) || (numUpper > 0 && numLower < 1)){
        // if(numNums < 1 || numUpper < 1 || numLower < 1){
        // alert(numSpecials);
        if (numSpecials > 0) {
            Swal.fire({
                text: 'Format Password Salah',
                type:'error'
            });
            $("p.field_password text").html("Format Password Salah");
            $("p.field_password input").css("border-color","red");
            return false;
        }
        if(numNums < 1 && numUpper < 1 && numLower < 1){
            Swal.fire({
                text: 'Format Password Salah',
                type:'error'
            });
            $("p.field_password text").html("Format Password Salah");
            $("p.field_password input").css("border-color","red");
            return false;
        }
        $("p.field_password text").html("");
        $("p.field_password input").css("border-color","blue");
        return true;
    }

    // function CheckForm() {
    //     if ($("input[name='a']").val()!=""&&$("input[name='b']").val()!=""&&$("input[name='b2']").val()!=""&&$("input[name='f']").val()!=""&&$("input[name='i']").val()!="") {
    //         if (CheckPassFormat($("input[name='b']").val())&&cekpass()&&$('input#setuju').is(':checked')) {
    //             $('input#submit2').prop("disabled",false);
    //         }else $('input#submit2').prop("disabled",true);
    //     }else $('input#submit2').prop("disabled",true);
    // }
    
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
        // $("input[type='text'] input[type='password']").blur(function(){

        //comment dulu
        // $("input[name='a'] input[name='b'] input[name='b2'] input[name='f'] input[name='i']").blur(function(){
        //     CheckForm();
        // });
        // $('input#setuju').click(function(){
        //     CheckForm();
        // });
        //comment dulu
        
        // $("form#form_komentar").submit(function(){
        //     event.preventDefault();

        // });
        // $("input[name='reg_as']").click(function(){
        //     if ($(this).val()=="Pengguna") {
        //         // $(".contact-form-message.ketentuan").hide();
        //         $("label#label_agree").hide();
        //         $("input#setuju").hide();
        //         $(".contact-form-user.kodevoucher").hide();
        //     }else{
        //         // $(".contact-form-message.ketentuan").show();
        //         $("label#label_agree").show();
        //         $("input#setuju").show();
        //         $(".contact-form-user.kodevoucher").show();
        //     }
        // });
        
    });
    
    $(function(){
        //First call for the load
        // checkRadioButtons(); 

        //Second call for change event
        // $("input[name='reg_as']").change(checkRadioButtons); 
        CheckReff();
    });

    function enableButton()
    {
        if ($("input#a").val()!="" && $("input#b").val()!="" && $("input#b2").val()!="" && $("input#f").val()!="" && $("input#i").val()!="" ) $("input#submit2").prop("disabled",$("input#setuju").is(":checked")?false:true);
    }

    var CheckReff= function()
    {
        $.ajax({
            url: "CheckReff",
            type: 'POST',
            data: "referral="+$("p.field_reff input[type=text]").val(),
            success: function(resp) {
                if (resp=="") {
                    $("p.field_reff input[type=text]").css("border-color","blue");
                }else{
                    $("p.field_reff input[type=text]").css("border-color","red");
                }   
                $("p.field_reff text").html(resp);                     
            },
            error: function() {
                console.log('something went wrong');
            }
        });
    }

    // var checkRadioButtons = function() {
    //     if ($("input[name='reg_as']").is(':checked')) {
    //         if ($("input[name='reg_as']").val()=="Pengguna") {
    //             // $(".contact-form-message.ketentuan").hide();
    //             $("label#label_agree").hide();
    //             $("input#setuju").hide();
    //             $(".contact-form-user.kodevoucher").hide();
    //         }else{
    //             // $(".contact-form-message.ketentuan").show();
    //             $("label#label_agree").show();
    //             $("input#setuju").show();
    //             $(".contact-form-user.kodevoucher").show();
    //         }
    //     }
    // }
    function nospaces(t){
        if(t.value.match(/\s/g)){
            swal({                
                text: 'Maaf, Tidak Boleh Menggunakan Spasi',
                type: 'warning',
            });
            t.value=t.value.replace(/\s/g,'');
        }
    }
    function validate(inp,obj)
    {
        if($(obj).val() == '')
        {
            // alert('kolom isian tidak bisa kosong');
            if (inp==0) {
                $("p.field_username text").html("Username harus diisi");
                $("p.field_username input[type=text]").css("border-color","red");
            }
            else if(inp==1) {
                $("p.field_nohp text").html("No HP harus diisi");
                $("p.field_nohp input[type=text]").css("border-color","red");
            }
            else if(inp==2) {
                $("p.field_reff text").html("Referral harus diisi");
                $("p.field_reff input[type=text]").css("border-color","red");
            }
            
            refocus(obj);  //call function to send focus back to the object...
        }else{
            if(inp==0){
                $.ajax({
                    url: "CheckUsername",
                    type: 'POST',
                    data: "username="+$(obj).val(),
                    success: function(resp) {
                        if (resp=="") {
                            $("p.field_username input[type=text]").css("border-color","blue");
                        }else{
                            $("p.field_username input[type=text]").css("border-color","red");
                        }   
                        $("p.field_username text").html(resp);
                    },
                    error: function() {
                        console.log('something went wrong');
                    }
                });
            }else if(inp==1){
                if ($(obj).val().length < 10) {
                    $("p.field_nohp text").html("Panjang Field Minimal 10 Angka");
                    $("p.field_nohp input[type=text]").css("border-color","red");
                }else{
                    $("p.field_nohp text").html("");
                    $("p.field_nohp input[type=text]").css("border-color","blue");
                }
            }
            else if(inp==2){
                CheckReff();
            }
        }
    }        
        
    function refocus(elm) 
    {
        setTimeout(go, 0);

        function go() {
            elm.focus();
        }
    }
</script>
<div class='panel-body'>
    <!-- <ul class='myTabs nav nav-tabs' role='tablist'>
      <li role='presentation' class='active'><a href='#reseller' role='tab' id='reseller-tab' data-toggle='tab' aria-controls='reseller' aria-expanded='true'>Pendaftaran User</a></li>
      <li role='presentation' class=''><a href='#konsumen' role='tab' id='konsumen-tab' data-toggle='tab' aria-controls='konsumen' aria-expanded='false'>Pendaftaran Partner</a></li>
    </ul><br> -->    
      <!-- <li role='presentation' class='active'><a href='#konsumen' id='konsumen-tab' role='tab' data-toggle='tab' aria-controls='konsumen' aria-expanded='true'>Pendaftaran Pembeli </a></li>
      <li role='presentation' class=''><a href='#reseller' role='tab' id='reseller-tab' data-toggle='tab' aria-controls='reseller' aria-expanded='false'>Pendaftaran Member</a></li>     -->  
    <div id='myTabContent' class='tab-content'>
        <!-- <div class='alert alert-warning'><b>PENTING!</b> Lengkapi Form dibawah ini untuk mendaftarkan diri sebagai <b>Member</b>, harap di isi dengan data yang sebenar-benarnya, Terima kasih...</div> -->
        <div class="bodyregister">

        <div role='tabpanel' class='tab-pane fade active in' id='reseller' aria-labelledby='reseller-tab'>
            <div class="logoregister" style="background-image: url('<?php echo base_url(); ?>images/girl-silhouette.png');">
                <!-- <img src="<?php echo base_url();?>images/logo_register.jpg"/> -->
            </div>
                <div class="block-content">
                    <div id="writecomment">
                        <form action="<?php echo base_url(); ?>auth/register" method="POST" id="form_komentar" enctype="multipart/form-data">
                            <!-- <p class="contact-form-user">
                                <label for="c_name">Daftar Sebagai<span class="required">*</label>
                                    <input type='radio' name='reg_as' value='Pengguna' checked='checked'> Pengguna &nbsp;
                                    <input type='radio' name='reg_as' value='Mitra'> Mitra &nbsp;
                            </p> -->
                            <!-- <p class="contact-form-user kodevoucher">
                                <label for="c_voucher">Kode Voucher</label>
                                <input type="text" name='v' placeholder="kode voucher anda bila ada" onkeyup="nospaces(this)"/>
                            </p> -->
                            <h1 style="font-size: 28px; margin-left: 10px;">Daftar Sekarang</h1>
                            <label style="margin-left: -20px;margin-bottom: 30px;">Sudah punya akun My Shoving? <a href="<?php echo base_url();?>/reseller" style="color: #551A8B;">Masuk</a></label><br/>
                            <p class="field_username">
                                <label>Username<span class="required">*</label>
                                <input type="text" name='a' id='a' onkeyup="nospaces(this)" onblur="validate(0,this)" required autocomplete="off"/>
                                <!-- &nbsp; &emsp;  -->
                                <text></text>
                            </p>

                            <p class="field_password">
                                <label>Password<span class="required">*</label>
                                <input type="password" class="form-password" name='b' id='b' class="required" onkeyup="nospaces(this)" onfocusout="CheckPassFormat(this.value)" value="" required/>
                                <!-- &nbsp; &emsp;  -->
                                <text></text>
                            </p>

                            <p class="field_cpassword">
                                <label>Re-password<span class="required">*</label>
                                <input type="password" class="form-password" name='b2' id='b2' class="required" onkeyup="nospaces(this)" onfocusout="cekpass()" value="" required /> 
                                <!-- &nbsp; &emsp;  -->
                                <text></text>
                                &nbsp;
                                <br/>
                                <input type="checkbox" class="form-checkbox"> Show password
                            </p>
                            
                            <p class="field_nohp">
                                <label>No Handphone<span class="required">*</label>
                                <!-- <input type="text" name='f' pattern="[0-9]+" minlength="10" placeholder="Contoh: 6281*********" class="required" value="" required/> -->
                                <input type="text" name='f' id='f' onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="10" placeholder="Contoh: 6281*********" class="required" value="" onkeyup="nospaces(this)" onblur="validate(1,this)" required/>
                                <text></text>
                            </p>
                            
                            <p class="field_reff">
                                <label>Reff username<span class="required">*</label>
                            <?php                           
                                $id_member=strtolower($_GET['userid']);
                                if ($id_member=="") { ?>
                                    <input type="text" name='i' id='i' value="company" placeholder="refferal anda" onkeyup="nospaces(this)" class="required" onblur="validate(2,this)" required />
                                <?php 
                                } else {
                                    // $username_reseller=$this->db->query("select username from rb_reseller where id_reseller=".$id_member)->row_array();
                                    // echo $username_reseller[username];
                                ?>
                                <input type="text" name='i' id='i' value="<?php echo $id_member;?>" placeholder="refferal anda" onkeyup="nospaces(this)" class="required" onblur="validate(2,this)" required readonly />
                                <?php }?>
                                <text></text>
                            </p>

                            <input type="hidden" name="userid" value="<?php echo $id_member;?>" readonly />

                            <input type="checkbox" name="setuju" id="setuju" value="setuju" onclick="javascript:enableButton();"> <label id="label_agree" style="margin: 0px; font-weight: unset;">Saya memahami semua ketentuan tersebut diatas</label><br/><br/>
                            
                            <input type="submit" name="submit2" id="submit2" value="Daftar" disabled>
                        </form>
                    </div>
                </div>
            <div style='clear:both'><br></div>
        </div>
    </div>
    </div>
</div>