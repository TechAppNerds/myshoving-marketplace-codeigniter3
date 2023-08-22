<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<style>
	label#selamatdatang{
		font-size: 15px;
	    vertical-align: middle;
	    font-weight: 100;
	    margin: 0px 4px 0px 0px;
	}
	li.marketplace_system, li.hassubs.first{
		font-family: "Titillium Web", sans-serif;
	    position: relative;
	    z-index: 200;
	    background: inherit;
	    display: block;
	    padding: 14px 11px;
	    font-weight: 700;
	    text-transform: uppercase;
	}
	/* ul.the-menu li{
		font-family: "Titillium Web", sans-serif;
		position: relative;
		z-index: 200;
		background: inherit;
		display: block;
		padding: 14px 11px;
		font-weight: 700;
		text-transform: uppercase;
	} */
	ul.the-menu li.marketplace_system ul li,li.hassubs.first ul li{
		background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);
		color: white;
	}
	.main-menu .the-menu li a span:after, .main-menu .the-menu li ul li a span:after{
		content: '';
	}
	.main-menu .the-menu li ul{
		margin-top: 14px;
	}
	.main-menu .the-menu li ul li a span{
		float: right;
	}
	.main-menu .the-menu li a span{
		padding: 0;
	}
	div.header-addons a{
		font-size: 18px;
		vertical-align: middle;
	}
	.main-menu.sticky .the-menu li.city{
		float: right;
	    /* display: inline; */
	    margin-right: 12px;
	    margin-right: 0.8784773060029283vw;
	    /*line-height: 3.35vw;*/
	    line-height: 45px;
	}
</style>
<?php
// var_dump($this->session);
echo "<div class='wrapper'>
		<div class='header-logo'>
			<a href='".base_url()."'>
				<img style='height:50px; float: left;' src='".base_url()."images/logoshoving.png'/>
			</a>
		</div>";
			  // $iden = $this->model_utama->view('identitas')->row_array();
			  // $logo = $this->model_utama->view_ordering_limit('logo','id_logo','DESC',0,1);
			  // foreach ($logo->result_array() as $row) 
			  // {
				//echo "Myshoving Beta Version <br/>";
				//<a href='".base_url()."'><img style='height:40px' src='".base_url()."asset/logo/logo.gif'></a>";
	            //$row[gambar]	<a href='".base_url()."' style='background: url(".base_url()."asset/images/home.png) no-repeat center; font-size:0; width:34px;'><br></a>	  <img style='height:40px; float: left;' src='".base_url()."images/logoshoving.png'/>
			  // } <br><span class='city'> Myshoving Beta Version - ".hari_ini(date('w')).", ".tgl_indo(date('Y-m-d')).", <span id='jam'></span></span>
	// 		<div class='mainmenu hidden-xs'>
	// 	<ul class='mainnav'>        
	//     </ul>
	// </div><input type='submit' value='Search' name='cari' class='search-button'/><div class='header-menu col-lg-6 col-md-6 col-sm-6 col-xs-6'>
		// <i class='search-button'></i> <i class='fa fa-search' aria-hidden='true'></i> <img src='".base_url()."/template/".template()."/background/images/icon-search.png'>
  echo "<div class='header-search col-lg-6 col-md-6 col-sm-6 col-xs-6'>
			".form_open('berita/index')."
				<input type='text' placeholder='inputkan nama barang yang dicari...'' name='kata' class='search-input' required/>
				<button type='submit' name='cari' class='search-button' style='padding: 12px;'>
					<img src='".base_url()."/template/".template()."/background/images/icon-search.png'>
				</button>
			".form_close()."
		</div>
		
		<div class='header-addons'>";
		  if ($this->session->id_konsumen != '') $iduser=$this->session->id_konsumen;
		  elseif ($this->session->id_reseller != '') $iduser=$this->session->id_reseller;
		  $cek = $this->db->query("SELECT * FROM `rb_reseller` where `id_reseller`='".$iduser."'");
		  $total = $cek->num_rows();
		  $cek1 = $this->db->query("SELECT * FROM `rb_referral` where `id_reseller`='".$iduser."'");
		  $total1 = $cek1->num_rows();
		  $datacek = $total >= 1 ? $cek : $cek1;
		  $ksm = $datacek->row_array();
// echo "<script>alert('".$this->session->userdata("id_reseller")."');</script>";
          if ($this->session->id_reseller != ''){
            $_SESSION['id_konsumen']=$this->session->id_reseller; ?>
            <style type="text/css">
	            @media only screen and (min-width: 1181px){
			        .header .header-addons {
			            /*margin-right: 28px;*/
		                margin-right: 2.049780380673499vw;
			        }
			    }
	        </style>
	<?php echo "<a class='btn btn-xs' style='padding:10px 4px; margin-right: 10px;' href='".base_url()."produk/keranjang'> <img style='width: 50px; margin-right: -5px;' src='".base_url()."images/cart.png'> <span class='badge'>".rupiah($isi_keranjang['jumlah'])."</span></a> ";

		echo "<label id='selamatdatang'>Selamat Datang!</label> <a style='color:#000' href='".base_url()."reseller/home'>$ksm[username]</a>
				<a class='middlemenu' style='margin-left: 4px;'>|</a>
        	  	<a href='".base_url()."reseller/logout'><i class='fa fa-power-off' style='vertical-align: baseline;'></i></a>";
            	  // echo "<script>window.alert('".$this->session->idp."')</script>"; &raquo;
            	  // <a style='color:#000' href='".base_url()."members/logout'>Logout</a><br>
            $isi_keranjang = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_penjualan_detail where id_penjualan='".$this->session->idp."'")->row_array();
			// echo "<a href='".base_url()."members/keranjang'><b> Keranjang Belanja <span class='badge'>".rupiah($isi_keranjang['jumlah'])."</span></b></a> &nbsp; ";
          }else{
          	$isi_keranjang = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_penjualan_temp where session='".$this->session->idp."'")->row_array();
			echo "<a class='btn btn-xs' style='padding:10px 4px; margin-right: 10px;' href='".base_url()."produk/keranjang'> <img style='width: 50px; margin-right: -5px;' src='".base_url()."images/cart.png'> <span class='badge'>".rupiah($isi_keranjang['jumlah'])."</span></a> ";
            //button login dan daftar <a class='btn btn-xs btn-default' style='width:60px; color:#000' href='".base_url()."' target='_self'>Home</a>
			echo "<a href='".base_url()."reseller' target='_self'>Masuk</a>
				  <a class='middlemenu' style='margin-left: 4px;'>|</a>
                  <a href='".base_url()."auth/register?userid=' target='_self'>Daftar</a>";
          }
	echo "</div>
	</div>

	<div class='main-menu sticky'>
		<div class='wrapper'>
			<ul class='the-menu'>				
				<li class='marketplace_system'>
		    		<span>Berita</span>
		    		<ul>
		    			<li><a href='".base_url()."kategori/detail/politik'>Politik</a></li>
		    			<li><a href='".base_url()."kategori/detail/ekonomi'>Ekonomi</a></li>
						<li><a href='".base_url()."kategori/detail/seni--budaya'>Seni & Budaya</a></li>
						<li><a href='".base_url()."kategori/detail/teknologi'>Teknologi</a></li>
						<li><a href='".base_url()."kategori/detail/internasional'>Internasional</a></li>
	    			</ul>
				</li>
				<li><a href='".base_url()."playlist'>Video</a></li>
				<li><a href='".base_url()."albums'>Berita Foto</a></li>
				<li><a href='".base_url()."download'>Download</a></li>
				<li><a href='".base_url()."agenda'>Agenda</a></li>
				<li><a href='".base_url()."konsultasi'>Konsultasi</a></li>
				<li><a href='".base_url()."kontributor'>Kontributor</a></li>
				<li><a href='".base_url()."testimoni'>Testimoni</a></li>
				<li class='marketplace_system'>
		    		<span>Marketplace System</span>
		    		<ul>
		    			<li><a href='".base_url()."produk'>Semua Produk</a></li>
		    			<li><a href='".base_url()."produk/reseller'>Semua Pelapak</a></li>
		    			<li><a href='".base_url()."konfirmasi/tracking'>Tracking</a></li>
		    			<li><a href='".base_url()."konfirmasi'>Konfirmasi Orders</a></li>
		    			<li><a href='".base_url()."members/orders_report'>Orders Report</a></li>
	    			</ul>
				</li>";
			    // echo "<li class='hassubs first'><span class='glyphicon glyphicon-th-list' style='padding-right: 10px;'></span>Kategori<ul>";
		    	// $kategori = $this->model_app->view('rb_kategori_produk');
				// foreach ($kategori->result_array() as $rows)
				// {
				// 	$sub_kategori = $this->db->query("SELECT * FROM rb_kategori_produk_sub where id_kategori_produk=".$rows["id_kategori_produk"]);
				// 	if ($sub_kategori->num_rows() >= 1){
				// 		echo "<li><a href='".base_url()."produk/kategori/$rows[kategori_seo]'> $rows[nama_kategori] <span class='caret caret-right'></span></a>
				// 			  <ul>";
				// 			   foreach ($sub_kategori->result_array() as $row) {
				// 				   	if (strlen(str_replace(' ', '', $row["nama_kategori_sub"])) > 0) {
				// 				   		echo "<li><a href='".base_url()."produk/subkategori/$row[kategori_seo_sub]'>$row[nama_kategori_sub]</a></li>";
				// 				   	}
				// 			   }
				// 			  echo "</ul></li>";
				// 	}else{
				// 		echo "<li><a href='".base_url()."produk/kategori/$rows[kategori_seo]'> $rows[nama_kategori]</a></li>";
				// 	}
				// }
				// echo "</ul></li>";
				echo "<li class='city'>
				    <span class='city'>My Shoving Beta Version - ".hari_ini(date('w')).", ".tgl_indo(date('Y-m-d')).", <span id='jam'></span></span>
			    </li>
			</ul>
		</div>
	</div>";
// var_dump($isi_keranjang);
// var_dump($this->session);


echo "<div class='secondary-menu'> <span class='city' style='vertical-align: middle;'>
	<div class='wrapper'>
		<ul>";
			$tag = $this->model_utama->view_ordering_limit('tag','id_tag','RANDOM',0,14);
			foreach ($tag->result_array() as $row) {
				echo "<li><a href='".base_url()."tag/detail/$row[tag_seo]'>$row[nama_tag]</a></li>";
			}
		echo "</ul>
	</div>
</div>";