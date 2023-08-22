<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>E-Tiketing MyShoving.com</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/rwd.table.min.css'>

      <link rel="stylesheet" href="<?php echo base_url()?>asset/ticketing_status/css/style.css">

  <style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  padding: 20px;
}
</style>
</head>

<body>
  <h2>Daftar Detail Tiket</h2>

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive" data-pattern="priority-columns">
        <table summary="This table shows how to create responsive tables using RWD-Table-Patterns' functionality" class="table table-bordered table-hover">
          <caption class="text-center">Daftar Detail Ticket dari Pelanggan :</caption>
          <thead>
            <tr>
              <th>ID Tiket</th>
              <th data-priority="1">Detail Masalah</th>
              <th data-priority="2">Status</th>
              <th data-priority="3">Tanggal Pembaharuan</th>
            </tr>
          </thead>
          <tbody>
              <?php
                    $id_tiket=$this->uri->segment(3);
              ?>
              <?php foreach ($detailtiket as $key1): ?>
                <?php if($key1->id_ticket==$id_tiket){?>
                    <tr>
                      <td><?php echo $key1->id_ticket; ?></td>
                      <td><?php echo $key1->detail_masalah; $detail_masalah=$key1->detail_masalah;?></td>
                      <td><?php echo $key1->status; ?></td>
                      <td><?php echo $key1->tanggal; ?></td>
                    </tr>
                <?php }?>
              <?php endforeach;?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-center">Data E-ticketing MyShoving.com</td>
            </tr>
          </tfoot>
        </table>
      </div><!--end of .table-responsive-->
    </div>
  </div>
    
</div>
      <?php  
               $username = $this->session->userdata('username');
               $level="";
               $query = $this->db->query("SELECT level FROM users where username ='$username'");
                        foreach ($query->result_array() as $row){
                            $level=$row['level'];
                        }
                
              
              ?>
<?php if($level=='admin'||$level=='kontributor') {?>
<div>
  <form action="<?php echo base_url('ChatController/update_tiket')?>" method="post">
    <label for="fname">ID Tiket</label>
    <input type="text" name="idtiket" value="<?php echo  $id_tiket?>"  required>
     <label for="fname">Detail Masalah</label>
    <input type="text"  name="masalah" value="<?php echo  $detail_masalah?>"  required>  
    <label for="country">Status</label>
    <select id="status" name="status" required>
      <option value="Belum Diproses">Belum Diproses</option>
      <option value="Telah Diproses">Telah Diproses</option>
      <option value="Selesai Diproses">Selesai Diproses</option>
      <option value="Gagal Diproses">Gagal Diproses</option>
    </select>
  
    <input type="submit" value="Lakukan Perubahan Status Tiket">
  </form>
</div>
    <?php }?>
<p class="p">Ticketing MyShoving.com</p>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/rwd-table-patterns.js'></script>

    <script src="<?php echo base_url()?>asset/ticketing_statusjs/index.js"></script>

</body>
    
</html>
