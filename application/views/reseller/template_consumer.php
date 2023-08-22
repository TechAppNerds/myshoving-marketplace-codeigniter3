<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WELCOME CONSUMER</title>
    <meta name="author" content="phpmu.com">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>asset/images/<?php echo favicon(); ?>" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <style type="text/css"> .files{ position:absolute; z-index:2; top:0; left:0; filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity:0; background-color:transparent; color:transparent; } </style>
    <script type="text/javascript" src="<?php echo base_url(); ?>/asset/admin/plugins/jQuery/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <style type="text/css">
      #example thead tr, #table1 thead tr, #example1 thead tr, #example2 thead tr{ background-color: #e3e3e3; } .checkbox-scroll { border:1px solid #ccc; width:100%; height: 114px; padding-left:8px; overflow-y: scroll; }
    </style>
    <script type="text/javascript">
      function blinktext() 
      {
        var f = document.getElementById('announcement');
        if (f) {
          setInterval(function() {
            f.style.visibility = (f.style.visibility == 'hidden' ? '' : 'hidden');
          }, 2000);
        }
      }

      // var timer = 0;
      // function set_interval() {
      //   // the interval 'timer' is set as soon as the page loads
      //   timer = setInterval("auto_logout()", 3000);
      //   // the figure '10000' above indicates how many milliseconds the timer be set to.
      //   // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
      //   // So set it to 300000
      // }

      // function reset_interval() {
      //   //resets the timer. The timer is reset on each of the below events:
      //   // 1. mousemove   2. mouseclick   3. key press 4. scroliing
      //   //first step: clear the existing timer

      //   if (timer != 0) {
      //     clearInterval(timer);
      //     timer = 0;
      //     // second step: implement the timer again
      //     timer = setInterval("auto_logout()", 3000);
      //     // completed the reset of the timer
      //   }
      //   // alert("a");
      // }

      // function auto_logout() {
      //   // this function will redirect the user to the logout script
      //   window.location = "<?php echo base_url();?>/Reseller";
      // }

      // timer = function() {
      //   alert(timer);
      // }

      $(document).ready(function(){
        $('input[name=tgl_lahir]').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '1950:2021'}).val();
        $("input#foto_ktp").change(function() {
          $("#uploadFile").css("margin-top",$("input#foto_ktp").val()?"36px":"0px");
        });
        $('.form-checkbox').click(function()
        {
            $('.form-password').attr('type',$(this).is(':checked')?'text':'password');
            $('.form-cpassword').attr('type',$(this).is(':checked')?'text':'password');            
        });
        $('.form-checkbox-svc').click(function()
        {
            $('input[name="kode"]').attr('type',$(this).is(':checked')?'text':'password');
        });
        $('#state_reseller').change(function(){
          $.ajax({
            type:"POST",
            url:"<?php echo site_url('auth/city'); ?>",
            data:"stat_id="+$(this).val(),
            success: function(response){
              $('#city_reseller').html(response);
            },
            error: function() {
                console.log('something went wrong');
            }
          });
        });
        $("body").on("mousemove click keypress", () => {
          $.ajax({
            url:"<?php echo site_url('reseller/reset_idle'); ?>",
          });
        });
        $(window).scroll(function(){
          $.ajax({
            url:"<?php echo site_url('reseller/reset_idle'); ?>",
          });
        });
      });
    </script>
  </head>

  <?php
  if ($this->session->userdata("reff")==0) {
    $blokir=$this->db->query("SELECT blokir FROM rb_reseller where id_reseller=".$this->session->id_reseller)->row_array();
  }
  // else{
  //   $blokir=$this->db->query("SELECT blokir FROM rb_referral where id_reseller=".$this->session->id_reseller)->row_array();
  // }
    // function reset_interval()
    // {
      // echo "<script>alert('".$this->session->sess_expiration."')</script>";
  // var_dump($this->session);
  // echo $this->session->sess_expiration;
    // }
  ?>

  <!-- <body class="hold-transition skin-blue sidebar-mini" onload="blinktext()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()"> -->
  <body class="hold-transition skin-blue sidebar-mini" onload="blinktext()">
    <div class="wrapper">
      <header class="main-header">
          <?php include "main-header.php"; ?>
      </header>

      <aside class="main-sidebar">
          <?php include "menu-consumer.php"; ?>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1> Dashboard <small>Control panel </small> 
            <?php if($blokir["blokir"]=='Y') echo '<p id="announcement" align="left"><font color="red" size="3"><b>segera lakukan aktivasi member dengan transfer sebesar 10.000 ke rekening perusahaan BCA : 8621118811 atas nama Anthonius Effendy SE</b></font></p>'; ?>
          </h1>
        </section>

        <section class="content">
            <?php echo $contents; ?>
        </section>
        <div style='clear:both'></div>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
          <?php include "footer.php"; ?>
      </footer>

    </div><!-- ./wrapper -->
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>asset/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>asset/admin/dist/js/app.min.js"></script>
    <script>
    $('.datepicker').datepicker();
    $('#rangepicker').daterangepicker();
      $(function () { 
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        $('#example3').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "info": true,
          "autoWidth": false,
          "pageLength": 10,
          "order": [[ 4, "desc" ]]
        });

      });

      var url = window.location;
      // for sidebar menu entirely but not cover treeview
      $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
      }).parent().addClass('active');

      // for treeview
      $('ul.treeview-menu a').filter(function() {
        return this.href == url;
      }).closest('.treeview').addClass('active');

      $(function () {
        $(".textarea").wysihtml5();
      });
  </script>


  <div class="modal fade" id="rekening" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel">Rekening Perusahaan</h5>
      </div>
      <div class="modal-body">
      <div class='alert alert-danger'><center>Silahkan Transfer Tagihan untuk transaksi pembelian anda ke no rekening dibawah ini dan selanjutnya lakukan konfirmasi pembayaran. Terima kasih,.. </center></div><hr style='margin:3px'>
      <table class='table table-condensed'>
                  <?php 
                    $rekening = $this->model_app->view('rb_rekening');
                    $no = 1;
                    foreach ($rekening->result_array() as $row){
                      echo "<tr class='info'><td width=150px><b>Nama Bank</b></td>   <td>$row[nama_bank]</td></tr>
                      <tr><td><b>No Rekening</b></td>       <td>$row[no_rekening]</td></tr>
                      <tr><td><b>Pemilik Rekening</b></td>  <td>$row[pemilik_rekening]</td></tr>";
                      if ($no==1){ echo "<tr><td colspan='2'><br></td></tr>";}
                      $no++;
                    }
                  ?>
      </table><br>
      <div style='clear:both'></div>
      </div>
    </div>
  </div>
</div>
  </body>
</html>
