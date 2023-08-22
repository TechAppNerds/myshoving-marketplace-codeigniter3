<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
    	<?php echo $this->session->flashdata('message'); ?>
    	<?php echo $this->session->flashdata('st_tc'); ?>
      <h3 class="box-title">Data Transaksi Nego</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
	    <div class="container">
			<br>
			<table id="example2" class="table table-bordered table-striped table-condensed">
		        <thead>
		          <tr>
		            <th style='width:40px'>No</th>
		            <th>Username Pembeli</th>
		            <th>Nama Produk</th>
		            <th>Jumlah</th>
		            <th>Harga Satuan</th>
		            <th>Satuan</th>
		            <th>Total Harga</th>
		            <th>Status</th>
		            <th>Tanggal Pengajuan</th>
		            <th>Aksi</th>
		          </tr>
		        </thead>
		        <tbody>
		        
		        	<?php
		        	$no = 1;
		        	foreach ($penjual_a as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td>".anchor('reseller/setuju_nego/'.$a['id_nego'].'/'.$a['jumlah'].'',"<div onclick=\"javascript: return confirm('Anda yakin ingin menyetujui nego tersebut?')\" class='btn btn-success btn-sm'><i class='fa fa-check'></i></div>")."&nbsp;".anchor('reseller/tolak_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'  onclick=\"javascript: return confirm('Anda yakin ingin menolak nego tersebut?')\"><i class='fa fa-times'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($penjual_b as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin menyetujui nego tersebut?')\">".anchor('reseller/setuju_nego/'.$a['id_nego'].'/'.$a['jumlah'].'',"<div class='btn btn-success btn-sm'><i class='fa fa-check'></i></div>")."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin menolak nego tersebut?')\">".anchor('reseller/tolak_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-times'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($penjual_a_diterima as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($penjual_b_diterima as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($penjual_a_ditolak as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($penjual_b_ditolak as $a) {
		        		echo "<tr>";
		        		echo "<td>".$no."</td>";
		        		echo "<td>".$a['user']."</td>";
		        		echo "<td>".$a['produk']."</td>";
		        		echo "<td>".$a['jumlah']."</td>";
		        		echo "<td>Rp ".rupiah($a['harga'])."</td>";
		        		echo "<td>".$a['satuan']."</td>";
		        		echo "<td>Rp ".rupiah($a['jumlah']*$a['harga'])."</td>";
		        		echo "<td>".$a['nama_status']."</td>";
		        		echo "<td>".$a['tanggal']."</td>";
		        		echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		$no++;
		        		echo "</tr>";
		        	}
		        	?>
		        </tbody>
		    </table>
	    </div>
    </div>
  </div>
</div>