<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>E-Tiketing MyShoving.com</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/rwd.table.min.css'>

      <link rel="stylesheet" href="<?php echo base_url()?>asset/ticketing_status/css/style.css">

  
</head>

<body>
  <h2>Daftar Tiket Pelanggan Secara Keseluruhan</h2>

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive" data-pattern="priority-columns">
        <table summary="This table shows how to create responsive tables using RWD-Table-Patterns' functionality" class="table table-bordered table-hover">
          <caption class="text-center">Daftar Ticket dari Pelanggan :</caption>
          <thead>
            <tr>
              <th>ID Tiket</th>
              <th data-priority="1">Permasalahan</th>
              <th data-priority="2">Username</th>
              <th data-priority="3">E-mail</th>
              <th data-priority="4">Handphone</th>
              <th data-priority="5">Customer Service</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($tiket as $key1): ?>
            <tr>
              <td><a href="<?php echo base_url('ChatController/detail/'.$key1->id_ticket) ?>"><?php echo $key1->id_ticket; ?></a></td>
              <td><?php echo $key1->masalah; ?></td>
              <td><?php echo $key1->username; ?></td>
              <td><?php echo $key1->email; ?></td>
              <td><?php echo $key1->handphone; ?></td>
              <td><?php echo $key1->customer_service; ?></td>
            </tr>
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

<p class="p">Ticketing MyShoving.com</p>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/rwd-table-patterns.js'></script>

    <script src="<?php echo base_url()?>asset/ticketing_statusjs/index.js"></script>

</body>
</html>
