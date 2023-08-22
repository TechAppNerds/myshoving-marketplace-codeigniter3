<div class="col-xs-12">  
  	<div class="box">
    	<div class="box-header">
    		<h3 class="box-title">Data Wishlist</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
	    	<div class="container">
	    	<table class="table table-bordered table-striped table-condensed">
		        <thead>
		          <tr>
		            <th style='width:40px'>No</th>
		            <th>Nama Produk</th>
		            <th>Username Penjual</th>
		            <th>Harga</th>
		            <th>Jumlah Stock</th>
		            <th>Satuan</th>
		            <th>Aksi</th>
		          </tr>
		        </thead>
		        <tbody>
		        <?php
		        $no = 1;
		        foreach ($wish as $w) {
		        	echo "<tr>";
		        	echo "<td>".$no."</td>";
		        	echo "<td>".$w['nama_produk']."</td>";
		        	echo "<td>".$w['username']."</td>";
		        	echo "<td>".$w['harga_konsumen']."</td>";
		        	echo "<td>".$w['stock_barang']."</td>";
		        	echo "<td>".$w['satuan']."</td>";
		        	echo "<td>".anchor('reseller/hapus_wish/'.$w['id_wishlist'].'',"<div  onclick=\"javascript: return confirm('Anda yakin ingin menghapus wish?')\" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>").anchor('http://www.myshoving.com/produk/detail/'.$w["produk_seo"].'',"
		        		<div class='btn btn-warning btn-sm'><i class='fa fa-search'></i></div>")."
		        	</td>";
		        	echo "</tr>";
		        	$no++;
		        }
		        ?>
		        </tbody>
			</table>
	    	</div>
		</div>
	</div>
</div>