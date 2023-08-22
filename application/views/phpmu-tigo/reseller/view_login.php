<script type="text/javascript">
    function nospaces(t){
        if(t.value.match(/\s/g)){
            swal({                
                text: 'Maaf, tidak boleh menggunakan spasi',
                type: 'warning',
            });
            t.value=t.value.replace(/\s/g,'');
        }
    }
</script>
<p class='sidebar-title text-danger produk-title'> Login Users</p>
<div class='alert alert-info'>Masukkan username dan password pada form berikut untuk login,...</div>
<?php echo $this->session->flashdata('message'); ?><br>
<div class="logincontainer">
    <form method="post" action="<?php echo base_url(); ?>auth/login" role="form" id='formku'>
        <div class="form-group">
            <label for="inputEmail">Username</label>
            <input type="text" name="a" class="required form-control" placeholder="Masukkan Username" autofocus="" minlength='5' onkeyup="nospaces(this)">
        </div>
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" name="b" class="form-control required" placeholder="Masukkan Password" autocomplete="off" onkeyup="nospaces(this)">
        </div>
        <div align="center">
            <input name='login' type="submit" class="btn btn-primary" value="Login"> 
            <a href="#" class="btn btn-default" data-toggle='modal' data-target='#lupass'>Lupa Password?</a><br><br> Anda Belum Punya akun? <a href="<?php echo base_url(); ?>auth/register" title="Mari gabung bersama Kami" class="link">Daftar Disini.</a>
        </div>
    </form>
</div>