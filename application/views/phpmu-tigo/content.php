<style>
	#iklan {
		box-sizing: border-box;
		text-align: center;
		margin-bottom: 3.2vh;
	}
	.caret{
		margin-top: 3px;
		border-right: 0;
	}
	#list_kategori{
		
	}
	.list_kategori_child{
		/* font-family: "Titillium Web", sans-serif;
		position: relative;
		z-index: 200;
		background: inherit;
		display: block;
		padding: 14px 11px;
		font-weight: 700;
		text-transform: uppercase; */
	}
	li.list_kategori_title a span.glyphicon {
		top: 0;
		padding-right: 10px;
	}
	#list_kategori {
		/* display: flex; */
		display: table;
		position: absolute;
		text-align: left;
		padding: 0;
		margin: 0;
		border: 0;
		line-height: 1;
	}
	li.child-sub{
		border: none;
	}
	#list_kategori > ul > li.list_kategori_title > a {
		color: #f47920;
		font-weight: 700;
		font-size: 16px;
	}
	#list_kategori ul,
	#list_kategori ul li,
	#list_kategori ul ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	#list_kategori ul {
		position: relative;
		z-index: 500;
		float: left;		
		width: 16em;
	}

	#list_kategori ul li {
		/* float: left; */
		min-height: 0.05em;
		line-height: 1em;
		vertical-align: middle;
		position: relative;
		background: #ffffff;		
		padding: 0.875em 0.6875em;
	}
	#list_kategori ul li.has-sub,li.list_kategori_title {
		border: 2px solid #e0e0e0;
	}

	#list_kategori ul li.hover,
	#list_kategori ul li:hover {
		position: relative;
		z-index: 510;
		cursor: default;
	}

	#list_kategori ul ul {
		visibility: hidden;
		position: absolute;
		top: 100%;
		left: 0px;
		z-index: 520;
		width: 100%;
		top: 0;
		left: 99%;
		margin-top: 0.05em;
		/* width: 13em; */
		-webkit-border-radius: 0 3px 3px 0;
		-moz-border-radius: 0 3px 3px 0;
		border-radius: 0 3px 3px 0;
		/* border: 1px solid #34A65F;  */
		border: 2px solid #e0e0e0;
	}

	#list_kategori ul ul li { float: none; }

	#list_kategori ul ul ul {
		top: 0;
		right: 0;
	}

	#list_kategori ul li:hover > ul { visibility: visible; }

	#list_kategori {
		/* width: 13em; */
		/* background: #333333; */
		font-family: 'roboto', Tahoma, Arial, sans-serif;
		zoom: 1;
	}

	#list_kategori:before {
		content: '';
		display: block;
	}

	#list_kategori:after {
		content: '';
		display: table;
		clear: both;
	}

	#list_kategori a {
		/* display: block; */
		/* display: table; */
		/* padding: 1em 1.3em; */
		/* padding: 0.875em 0.6875em; */
		/* color: gray; */
		/* color: #ffffff;
		text-decoration: none;
		text-transform: uppercase; */
	}

	/* #list_kategori > ul { width: 13em; } */

	#list_kategori > ul > li > a {
		/* border-right: 0.3em solid #34A65F;
		color: #ffffff; */
	}

	/* #list_kategori > ul > li > a:hover { color: #ffffff; } */

	#list_kategori > ul > li a:hover,
	#list_kategori > ul > li:hover a { 
		/* background: #34A65F; */
	}

	#list_kategori li { position: relative; }

	#list_kategori ul li.has-sub > a:after {
		/* content: '»';
		position: absolute;
		right: 1em; */
	}

	#list_kategori ul ul li.first {
		-webkit-border-radius: 0 3px 0 0;
		-moz-border-radius: 0 3px 0 0;
		border-radius: 0 3px 0 0;
	}

	#list_kategori ul ul li.last {
		-webkit-border-radius: 0 0 3px 0;
		-moz-border-radius: 0 0 3px 0;
		border-radius: 0 0 3px 0;
		border-bottom: 0;
	}

	/* #list_kategori ul ul a { color: #ffffff; } */

	/* #list_kategori ul ul a:hover { color: #ffffff; } */

	/* #list_kategori ul ul li { border-bottom: 1px solid #0F8A5F; } */

	#list_kategori ul ul li:hover > a {
		/* background: #4eb1ff; */
		/* color: #ffffff; */
	}

	#list_kategori.align-right > ul > li > a {
		/* border-left: 0.3em solid #34A65F; */
		border-right: none;
	}

	#list_kategori.align-right { float: right; }

	#list_kategori.align-right li { text-align: right; }

	#list_kategori.align-right ul li.has-sub > a:before {
		content: '+';
		position: absolute;
		top: 50%;
		left: 15px;
		margin-top: -6px;
	}

	#list_kategori.align-right ul li.has-sub > a:after { content: none; }

	#list_kategori.align-right ul ul {
		visibility: hidden;
		position: absolute;
		top: 0;
		left: -100%;
		z-index: 598;
		width: 100%;
	}

	#list_kategori.align-right ul ul li.first {
		-webkit-border-radius: 3px 0 0 0;
		-moz-border-radius: 3px 0 0 0;
		border-radius: 3px 0 0 0;
	}

	#list_kategori.align-right ul ul li.last {
		-webkit-border-radius: 0 0 0 3px;
		-moz-border-radius: 0 0 0 3px;
		border-radius: 0 0 0 3px;
	}

	#list_kategori.align-right ul ul {
		-webkit-border-radius: 3px 0 0 3px;
		-moz-border-radius: 3px 0 0 3px;
		border-radius: 3px 0 0 3px;
	}

	span.caret{
		float: right;
		top: 0;
	}

	body {font-family: Verdana, sans-serif;}
	.mySlides {display: none;}
	img {vertical-align: middle;}

	/* Slideshow container */
	.slideshow-container {
		max-width: 1000px;
		position: relative;
		margin: auto;
	}

	/* The dots/bullets/indicators */
	.dot {
		height: 15px;
		width: 15px;
		margin: 0 2px;
		background-color: #bbb;
		border-radius: 50%;
		display: inline-block;
		transition: background-color 0.6s ease;
	}

	.active {
		background-color: #717171;
	}

	/* Fading animation */
	.fade {
		-webkit-animation-name: fade;
		-webkit-animation-duration: 3.0s;
		animation-name: fade;
		animation-duration: 3.0s;
	}

	@-webkit-keyframes fade {
		from {opacity: .4} 
		to {opacity: 1}
	}

	@keyframes fade {
		from {opacity: .4} 
		to {opacity: 1}
	}	

	div.mySlides img{
		height: 350px;
		border-radius: 5%;
	}

	.like-btn {
	  display: inline-block;
	  cursor: pointer;
	}

	.like-btn {
	  position: absolute;
	  top: 9px;
	  left: 15px;
	  background: url('./twitter-heart.png');
	  width: 60px;
	  height: 60px;
	  background-size: 2900%;
	  background-repeat: no-repeat;
	}
	div.produk{
		box-shadow: 5px 5px 5px lightgrey;
	    border-radius: 5%;
	    padding: 0px;
        margin-right: 15px;
    	margin-left: 15px;
    	height: 260px;
	}
	h4.produk-title{
		text-align: left;
		margin-bottom: 5px;
	}
	h4.produk-title a{
		color: black;
	}
	span.harga{
	    text-align: left;
    	display: block;
	}
	div.top-right{
		/*right: 0px;
		left: 5px;*/
	  	/*padding-left:1em;
  		position:relative;*/
	}
	div.top-right:before{
	/*	content: "";
		position:absolute;
		left: 0;
		top: calc(50% - 0.35em);
		width: 0.7em;
		height: 0.7em;
		background: linear-gradient(to bottom left, #34495e 50%, transparent 50%);
		border-radius: 0.1em;*/
	}
	div.top-right:after{
		/*content: "";
		position: absolute;
		left: 3.8px;
		top: -0.1px;
		width: 0.92em;
		height: 0.8em;
		margin-right: 10px;
		background: linear-gradient(to top,#34495e 3.5px,transparent 5px);
		border-radius: 0.1em;
		transform: rotate(45deg);
		z-index: -1;*/
	}	
	h1 {
	  padding-left:1em;
	  position:relative;
	}

	div.box {
		border: 1px solid #CCC;
	    padding: 40px 25px;
	    background: #FFF;
	    max-width: 400px;
	    position: relative;
	    border-radius: 3px;
	    margin: 0 auto;
	}
	
	div.box div.top-cross-ribbon {
	    background: #EA4335;
	    padding: 2px 50px;
	    color: #FFF;
	    position: absolute;
	    top: -140px;
	    right: -50px;
	    transform: rotate(45deg);
	    border: 1px dashed #FFF;
	    box-shadow: 0 0 0 3px #EA4335;
	    margin: 5px;
	}

	h1:before {
	  content: "";
	  position:absolute;
	  left: 0;
	  top: calc(50% - 0.35em);
	  width: 0.7em;
	  height: 0.7em;
	  background: linear-gradient(to bottom left, #34495e 50%, transparent 50%);
	  border-radius: 0.1em;
	}
	h1:after {
	  content: "";
	    position: absolute;
	    left: 3.8px;
	    top: -0.1px;
	    width: 0.92em;
	    height: 0.8em;
	    margin-right: 10px;
	    background: linear-gradient(to top,#34495e 3.5px,transparent 5px);
	    border-radius: 0.1em;
	    transform: rotate(45deg);
	    z-index: -1;
	}
	span.wishlist{

	}
</style>
<script>

</script>

<div id="iklan">
	<div id="list_kategori">
		<ul>
			<li class="list_kategori_title"><a><span class='glyphicon glyphicon-th-list'></span>Kategori</a></li>
			<?php 
				$kategori = $this->model_app->view('rb_kategori_produk')->result_object();
				for ($i = 0; $i < sizeof($kategori); $i++) {
					$li = "<li class=".($i <= 7 ? 'has-sub' : 'child-sub').">";
					$a = "<a href='".base_url()."produk/kategori/".$kategori[$i]->kategori_seo."'>".$kategori[$i]->nama_kategori;
					if ($i == 7) {
						echo $li."<a>Kategori Lainnya<span class='caret caret-right'></span></a><ul>";
						$li = "<li class='child-sub'>";
						// $li = "<li class=".($i >= 7 ? 'child-sub' : 'has-sub').">";
					}
					if (strlen(str_replace(' ', '', $kategori[$i]->nama_kategori)) > 0) echo $li.$a;
					$sub_kategori = $this->db->query("SELECT * FROM rb_kategori_produk_sub where id_kategori_produk=".$kategori[$i]->id_kategori_produk);
					if ($sub_kategori->num_rows() >= 1) {
						echo "<span class='caret caret-right'></span></a><ul>";
						foreach ($sub_kategori->result_array() as $row) {
							if (strlen(str_replace(' ', '', $row["nama_kategori_sub"])) > 0)
								echo "<li class='child-sub'><a href='".base_url()."produk/subkategori/$row[kategori_seo_sub]'>$row[nama_kategori_sub]</a></li>";
						} echo "</ul></li>";
					}else echo "</a></li>";
				}
			?>
			<!-- <li class="has-sub"> <a href="#">Menu 1</a>
				<ul>
					<li class="has-sub"> <a href="#">Submenu 1.1</a>
						<ul>
							<li><a href="#">Submenu 1.1.1</a></li>
							<li class="has-sub"><a href="#">Submenu 1.1.2</a>
								<ul>
									<li><a href="#">Submenu 1.1.2.1</a></li>
									<li><a href="#">Submenu 1.1.2.2</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><a href="#">Submenu 1.2</a></li>
				</ul>
			</li>
			<li class="has-sub"> <a href="#">Menu 2</a>
				<ul>
					<li><a href="#">Submenu 2.1</a></li>
					<li><a href="#">Submenu 2.2</a></li>
				</ul>
			</li>
			<li class="has-sub"> <a href="#">Menu 3</a>
				<ul>
					<li><a href="#">Submenu 3.1</a></li>
					<li><a href="#">Submenu 3.2</a></li>
				</ul>
			</li> -->
		</ul>		
	</div>
	<div class="slideshow-container">
		<div class="mySlides fade">
			<a target='_SELF' href='<?php echo $ik1["url"];?>'><img src='<?php echo base_url()."asset/foto_iklanatas/".$ik1["gambar"];?>' style=''></a>
		</div>
		<div class="mySlides fade">
			<a target='_SELF' href='<?php echo $ik2["url"];?>'><img src='<?php echo base_url()."asset/foto_iklanatas/".$ik2["gambar"];?>' style=''></a>
		</div>
		<div class="mySlides fade">
			<a target='_SELF' href='<?php echo $ik3["url"];?>'><img src='<?php echo base_url()."asset/foto_iklanatas/".$ik3["gambar"];?>' style=''></a>
		</div>
		<div class="mySlides fade">
			<a target='_SELF' href='<?php echo $ik4["url"];?>'><img src='<?php echo base_url()."asset/foto_iklanatas/".$ik4["gambar"];?>' style=''></a>
		</div>
		<div class="mySlides fade">
			<a target='_SELF' href='<?php echo $ik5["url"];?>'><img src='<?php echo base_url()."asset/foto_iklanatas/".$ik5["gambar"];?>' style=''></a>
			<!--1=w=40%; h=40%; 
			2=w=100%; h=400px; 
			3=w=40%; h=40%; 
			4=w=40%;315.5px; h=40%; 
				5=w=19.0%; 15%; h=19.0% -->
		</div>
	</div>
	<br>
	<div>
		<span class="dot"></span>
		<span class="dot"></span>
		<span class="dot"></span>
		<span class="dot"></span>
		<span class="dot"></span>
	</div>
</div>

<script>
	var slideIndex = 0;
	showSlides();

	function showSlides() {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("dot");
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		}
		slideIndex++;
		if (slideIndex > slides.length) {
			slideIndex = 1;
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slides[slideIndex-1].style.display = "block";  
		dots[slideIndex-1].className += " active";
		setTimeout(showSlides, 3000); // Change image every 2 seconds
	}
	$(document).ready(function(){
		$('.like-btn').on('click', function() {
		   $(this).toggleClass('is-active');
		});
	});	
</script>
<?php 
/*
$ik1[url]
$ik2[url]
$ik3[url]
$ik4[url]
$ik5[url]
*/
// echo "<div class='paragraph-row hidden-xs'>
// 	<div class='column6'>
// 		<a target='_SELF' href='$ik1[url]'><img src='".base_url()."asset/foto_iklanatas/$ik1[gambar]' style='width:100%;border-radius:5%;'></a>
// 	</div>
// 	<div class='column4' style='margin-left: 1%'>
// 		<div class='paragraph-row'>
// 			<div class='column12'>
// 				<a target='_SELF' href='$ik2[url]'><img src='".base_url()."asset/foto_iklanatas/$ik2[gambar]' style='width:100%; height: 190px;border-radius:5%;'></a>
// 			</div>
// 		</div>
// 		<div class='paragraph-row'>
// 			<div class='column6' style='margin-top:10px'>
// 				<a target='_SELF' href='$ik3[url]'><img src='".base_url()."asset/foto_iklanatas/$ik3[gambar]' style='width:100%; height: 180px;border-radius:5%;'></a>
// 			</div>
// 			<div class='column6' style='margin-top:10px'>
// 				<a target='_SELF' href='$ik4[url]'><img src='".base_url()."asset/foto_iklanatas/$ik4[gambar]' style='width:100%; height: 180px;border-radius:5%;'></a>
// 			</div>
// 		</div>
// 	</div>
// 	<div class='column2' style='margin-left: 1%'>
// 		<a target='_SELF' href='$ik5[url]#'><img src='".base_url()."asset/foto_iklanatas/$ik5[gambar]' style='width:100%; min-height: 380px;border-radius:5%;'></a>
// 	</div>
// </div>
// <br>";

// echo '<div class="w3-content w3-display-container" style="max-width:800px">
// <img class="mySlides" src="'.base_url().'/asset/foto_iklanatas/$ik1[gambar]" style="width:100%; border-radius:5%;">
// <img class="mySlides" src="img_snow_wide.jpg" style="width:100%">
// <img class="mySlides" src="img_mountains_wide.jpg" style="width:100%">
// <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
//   <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
//   <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
//   <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
//   <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
//   <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
// </div>
// </div>';

$no = 1;
$kategori = $this->model_app->view('rb_kategori_produk');
// var_dump($kategori);
foreach ($kategori->result_array() as $kat) {
	// var_dump($kat);
	$produk = $this->model_reseller->produk_perkategori(0,0,$kat['id_kategori_produk'],6);
	    echo "<p class='sidebar-title text-danger produk-title'>$kat[nama_kategori]</p>
	    <div class='container'>";
	    foreach ($produk->result_array() as $row){
	    $ex = explode(';', $row['gambar']);
	    if (trim($ex[0])==''){ $foto_produk = 'no-image.png'; }else{ $foto_produk = $ex[0]; }
	    if (strlen($row['nama_produk']) > 38){ $judul = substr($row['nama_produk'],0,38).',..';  }else{ $judul = $row['nama_produk']; }
	    $jual = $this->model_reseller->jual_reseller($row['id_reseller'],$row['id_produk'])->row_array();
	    $beli = $this->model_reseller->beli_reseller($row['id_reseller'],$row['id_produk'])->row_array();
	    if ($beli['beli']-$jual['jual']<=0){ $stok = '<b style="color:#000">Stok Habis</b>'; }else{ $stok = "<span style='color:green'>Stok ".($beli['beli']-$jual['jual'])." $row[satuan]</span>"; }

	    $disk = $this->model_app->view_where("rb_produk_diskon",array('id_produk'=>$row['id_produk']))->row_array();
	    $diskon = rupiah(($disk['diskon']/$row['harga_konsumen'])*100,0)."%"; //<div class='top-right'>$diskon</div><h1>Heading</h1>
	    if ($diskon>0){ $diskon_persen = "<div class='box ofh'><div class='top-cross-ribbon'>$diskon</div></div>"; }else{ $diskon_persen = ''; }
	    if ($diskon>=1){ 
	    	$harga =  "<del style='color:#8a8a8a'><small style='display: block;font-size: 11px;'>Rp ".rupiah($row['harga_konsumen'])."</small></del> Rp ".rupiah($row['harga_konsumen']-$disk['diskon']);
	    }else{
	    	$harga =  "Rp ".rupiah($row['harga_konsumen']);
	    }
	    echo "<div class='produk col-md-2 col-xs-4' style='box-shadow: 5px 5px 5px lightgrey;
														    border-radius: 5%;
														    padding: 0px;
													        margin-right: 15px;
													    	margin-left: 15px;'>
	              <center>
	                
	                <div style='height:140px; overflow:hidden; margin-bottom: 5px;'>
	                  <a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'><img style='border:1px solid #cecece; height:100%; width:100%;border-radius:10%;' src='".base_url()."asset/foto_produk/$foto_produk'>
	                  </a>
	                  		$diskon_persen
	                </div>
	                <h4 class='produk-title' style='text-align: left;'><a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'>$judul</a></h4>
	                <span class='harga'>$harga</span>
	                <small style='margin-bottom: 10px;text-align: left;display: block;'>$row[nama_kota]</small>
	                <span class='wishlist' id='$kat[id_kategori_produk]'></span>";
	                
	                echo "</center>
	          </div>";

	      
	    }
	    echo "</div>";

	  echo "<div style='clear:both'><br></div>";

	$no++;
	  
}
?>
<!-- <span class='like-btn'><i class='fa fa-heart'></i></span> -->
<br><br>
<div class="block">
<div class="block-content">
	<ul class="article-block-big">
		<?php 
			$no = 1;
			$hot = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('utama' => 'Y','status' => 'Y'),'id_berita','DESC',0,6);
			foreach ($hot->result_array() as $row) {	
			$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
			$tgl = tgl_indo($row['tanggal']);
			echo "<li style='width:180px'>
					<div class='article-photo'>
						<a href='".base_url()."$row[judul_seo]' class='hover-effect'>";
							if ($row['gambar'] ==''){
								echo "<a class='hover-effect' href='".base_url()."$row[judul_seo]'><img style='height:110px; width:200px' src='".base_url()."asset/foto_berita/no-image.jpg' alt='' /></a>";
							}else{
								echo "<a class='hover-effect' href='".base_url()."$row[judul_seo]'><img style='height:110px; width:200px' src='".base_url()."/asset/foto_berita/$row[gambar]' alt='' /></a>";
							}
					echo "</a>
					</div>
					<div class='article-content'>
						<h4><a href='".base_url()."$row[judul_seo]'>$row[judul]</a><a href='".base_url()."$row[judul_seo].html' class='h-comment'>$total_komentar</a></h4>
						<span class='meta'>
							<a href='".base_url()."$row[judul_seo]'><span class='icon-text'>&#128340;</span>$row[jam], $tgl</a>
						</span>
					</div>
				  </li>";
			}
		?>
	</ul>
</div>
</div>

