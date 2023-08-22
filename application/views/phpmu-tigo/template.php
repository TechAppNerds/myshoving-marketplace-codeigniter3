<!DOCTYPE HTML>
<html lang = "en">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>My Shoving - Marketplace Revolusioner saat ini</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	
	<meta name="robots" content="index, follow">
	<meta name="description" content="<?php echo $description; ?>">
	<meta name="keywords" content="<?php echo $keywords; ?>">
	<!--meta name="author" content="phpmu.com"-->
	<meta name="robots" content="all,index,follow">
	<meta http-equiv="Content-Language" content="id-ID">
	<meta NAME="Distribution" CONTENT="Global">
	<meta NAME="Rating" CONTENT="General">
	<link rel="canonical" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"/>
	<?php if ($this->uri->segment(1)=='berita' AND $this->uri->segment(2)=='detail'){ 
		$rows = $this->model_utama->view_where('berita',array('judul_seo' => $this->uri->segment(3)))->row_array();
	    echo '<meta property="og:title" content="'.$title.'" />
			 <meta property="og:type" content="article" />
			 <meta property="og:url" content="'.base_url().''.$this->uri->segment(3).'" />
			 <meta property="og:image" content="'.base_url().'asset/foto_berita/'.$rows['gambar'].'" />
			 <meta property="og:description" content="'.$description.'"/>';
	} ?>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>asset/images/<?php echo favicon(); ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.xml" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/<?php echo background(); ?>/reset.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/<?php echo background(); ?>/main-stylesheet.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/<?php echo background(); ?>/shortcode.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/<?php echo background(); ?>/fonts.css" />
	<!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/<?php echo background(); ?>/responsive.css" /> -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/style.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/ideaboxWeather.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/slide/slide.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/lightbox/lightbox.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/jscript/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/jscript/jquery-latest.min.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/jscript/theme-scripts.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/background/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<?php if ($this->uri->segment(1)=='main' OR $this->uri->segment(1)==''){ ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/slide/js/jssor.slider-23.1.0.mini.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/<?php echo template(); ?>/slide/js/slide.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script> -->
	<?php } ?>
   
	<!-- <script src="https://members.phpmu.com/asset/js/bootstrap.min.js"></script> -->
	<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	// if (document.contains(document.getElementsByClass("themenumobile"))) {
	 //        document.getElementById("themenumobile").remove();
	// }

	// $(document).ready(function(){
 //        $('#state').change(function(){
 //          var state_id = $(this).val();
 //          $.ajax({
 //            type:"POST",
 //            url:"<?php echo site_url('auth/city'); ?>",
 //            data:"stat_id="+state_id,
 //            success: function(response){
 //              $('#city').html(response);
 //            }
 //          });
 //        });
 //        $('#state_reseller').change(function(){
 //          var state_id = $(this).val();
 //          $.ajax({
 //            type:"POST",
 //            url:"<?php echo site_url('auth/city'); ?>",
 //            data:"stat_id="+state_id,
 //            success: function(response){
 //              $('#city_reseller').html(response);
 //            }
 //          });
 //        });
 //  	});
  
	function toDuit(number) {
	    var number = number.toString(), 
	    duit = number.split('.')[0], 
	    duit = duit.split('').reverse().join('')
	        .replace(/(\d{3}(?!$))/g, '$1,')
	        .split('').reverse().join('');
	    return 'Rp ' + duit ;
    }
	// $(function() {
	// 	$(this).bind("contextmenu", function (e) {
	// 		e.preventDefault();
	// 	});
	// });
	document.onkeydown = function(e) {
        if (e.ctrlKey && (e.keyCode === 85 )) {
            return false;
        }
	};
	// document.addEventListener("contextmenu", function(e) {
	// 	e.preventDefault();
	// }, false);
	</script>
	<style type="text/css">
		.the-menu a.active{ color:red !important; } 
		div.content{ background: white;}
		.produk:hover{ background-color: lightgray; }
		.header {
			position: fixed;
			width: 100%;
			z-index: 1000;
		}
		.main-content{
			display: block;
		    /* margin-top: 150px; */
		    margin-top: 180px;
		    position: relative;
		}
		.header .header-logo{
			/*float: left;*/
			/*display: inline;*/
			/*margin-left: 55px;*/
			margin-left: 4.026354319180088vw;
		}
		.header .header-search{
			display: inline;
		    float: left;
		    /*left: 15%;
		    /*width: 35%;*/
		    top: 25px;
		    position: absolute;
		    /*margin-left: 40px;*/
		    margin-left: 2.9282576866764276vw;
		}
		.header-search form .search-input{
		    /*width: 700px;*/
		    width: 51.24450951683748vw;
		    /*padding: 10px 36px 10px 36px;*/
		    padding: 10px 36px;
		    /*padding: 0.7320644216691069vw 2.6354319180087846vw;*/
		    float: left;
	        margin-right: -34px;
		}
		.header-search form .search-button{
		    /*float: right;*/
		    /*right: -62%;*/
		    /*display: inline-block;*/	    
	        display: inline-grid;
		}
		.header-search form button{
		    float: right;
		    background: deepskyblue;
		    /*height: 35px;*/
		    border-radius: 0px 2px 2px 0px;
		}
		.header .header-addons{
			/*margin-right: 62px;*/
			margin-right: 4.538799414348462vw;
			/*margin-top: -4px;*/
		}		
		div.footer div.wrapper p{
			/*margin-left: 55px;*/
			/*margin-left: 4.026354319180088vw;*/
			/*margin-left: 28px;*/
			margin-left: 2.049780380673499vw;
		    color: gray;
		}
		div.footer div.wrapper ul.right{
		    /* margin-right: 2.049780380673499vw;*/
		    display: flex;
		    justify-content: center;
		    align-items: center;
		    float: none;
		}
		@media screen and (max-width: 1200px){
			div.wrapper{
				margin: 0;
			}
		}
		@media only screen and (max-width: 1180px){
			.header-search form .search-input{
				/*width: 975px;*/
			    width: 71.37628111273793vw;
			}
			/*.header-addons move to bottom*/
			.header .header-addons{
				clear: both;
				float: unset;
				display: flex;
			    justify-content: center;
			    align-items: center;
			    margin: 0;
				/*width: 53vw;1000*/
			}
			.header-addons a.middlemenu{
			    margin: 0 4px;
			}
		}
		@media only screen and (max-width: 1040px){
			.header-search form .search-input{
			    /*width: 775px;*/
			    /*width: 56.734992679355784vw;*/
			    /*width: 950px;*/
			    width: 69.54612005856515vw;
			}
			.header .header-search{
				/*margin-left: 40px;*/
				/*margin: 0 2.9282576866764276vw;*/
			}
		}
		@media only screen and (max-width: 940px){
			.header-search form .search-input{
			    /*width: 925px;*/
			    width: 67.71595900439239vw;
			}
		}
		@media only screen and (max-width: 870px){
			.header-search form .search-input{
			    /*width: 900px;*/
			    width: 65.88579795021963vw;
			}
		}
		@media only screen and (max-width: 820px){
			.header-search form .search-input{
			    /*width: 875px;*/
			    width: 64.05563689604685vw;
			}
		}
		@media only screen and (max-width: 760px){
			.header-search form .search-input{
			    /*width: 850px;*/
			    width: 62.225475841874086vw;
			}
		}
		@media only screen and (max-width: 710px){
			.header-search form .search-input{
			    /*width: 825px;*/
			    width: 60.39531478770132vw;
			}
		}
		@media only screen and (max-width: 680px){
			.header-search form .search-input{
			    /*width: 800px;*/
			    width: 58.565153733528554vw;
			}
		}
		@media only screen and (max-width: 640px){
			.header-search form .search-input{
			    /*width: 775px;*/
			    width: 56.734992679355784vw;
			}
		}
		@media only screen and (max-width: 610px){
			.header-search form .search-input{
			    /*width: 750px;*/
			    width: 54.904831625183014vw;
			}
		}
		@media only screen and (max-width: 580px){
			.header-search form .search-input{
			    /*width: 725px;*/
			    width: 53.07467057101025vw;
			}
		}
		@media only screen and (max-width: 550px){
			.header-search form .search-input{
			    /*width: 700px;*/
			    width: 51.24450951683748vw;
			}
		}
		@media only screen and (max-width: 520px){
			.header-search form .search-input{
			    /*width: 675px;*/
			    width: 49.41434846266471vw;
			}
		}
		@media only screen and (max-width: 500px){
			.header-search form .search-input{
			    /*width: 650px;*/
			    width: 47.58418740849195vw;
			}
		}
		@media only screen and (max-width: 480px){
			.header-search form .search-input{
			    /*width: 625px;*/
			    width: 45.75402635431918vw;
			}
		}
		@media only screen and (max-width: 460px){
			.header-search form .search-input{
			    /*width: 600px;*/
			    width: 43.92386530014641vw;
			}
		}
		@media only screen and (max-width: 440px){
			.header-search form .search-input{
			    /*width: 575px;*/
			    width: 42.09370424597365vw;
			}
		}
		@media only screen and (max-width: 420px){
			.header-search form .search-input{
			    /*width: 550px;*/
			    width: 40.26354319180088vw;
			}
		}
		@media only screen and (max-width: 410px){
			.header-search form .search-input{
			    /*width: 525px;*/
			    width: 38.43338213762811vw;
			}
		}
		@media only screen and (max-width: 400px){
			.header-search form .search-input{
			    /*width: 500px;*/
			    width: 36.603221083455345vw;
			}
		}
		@media only screen and (max-width: 390px){
			.header-search form .search-input{
			    /*width: 475px;*/
			    width: 34.773060029282576vw;
			}
		}
		@media only screen and (max-width: 380px){
			.header-search form .search-input{
			    /*width: 450px;*/
			    width: 32.94289897510981vw;
			}
		}
		@media only screen and (max-width: 370px){
			.header-search form .search-input{
			    /*width: 425px;*/
			    width: 31.112737920937043vw;
			}
		}
		@media only screen and (max-width: 360px){
			.header-search form .search-input{
			    /*width: 400px;*/
			    width: 29.282576866764277vw;
			}
		}
		@media only screen and (max-width: 350px){
			.header-search form .search-input{
			    /*width: 375px;*/
			    width: 27.452415812591507vw;
			}
		}
		@media only screen and (max-width: 340px){
			.header-search form .search-input{
			    /*width: 350px;*/
			    width: 25.62225475841874vw;
			}
		}
		@media only screen and (max-width: 330px){
			.header-search form .search-input{
			    /*width: 325px;*/
			    width: 23.792093704245975vw;
			}
		}
		@media only screen and (max-width: 320px){
			.header-search form .search-input{
			    /*width: 300px;*/
			    width: 21.961932650073205vw;
			}
		}
		@media only screen and (max-width: 310px){
			.header-search form .search-input{
			    /*width: 275px;*/
			    width: 20.13177159590044vw;
			}
		}
		@media only screen and (max-width: 300px){
			.header-search form .search-input{
			    /*width: 250px;*/
			    width: 18.301610541727673vw;
			}
		}
		<?php //#cecece warna background ori ?>
	</style>
</head>

<body>
	<?php /*echo "<script>alert('idr=".$this->session->id_reseller."');</script>";*/ 
	// var_dump($this->session); ?>
<div id='Back-to-top'>
       
  <img alt='Scroll to top' src='http://members.phpmu.com/asset/css/img/top.png'/>
</div>
<div class="boxed">	
	<div class="header">
		<?php include "header.php"; ?>
	</div>
	
	<div class="content">
		<div class="wrapper">	
			<!--div class="breaking-news">
				<span class="the-title">Breaking News</span>
				<ul>
					<?php
					 /* $terkini = $this->model_utama->view_where_ordering_limit('berita',array('status' => 'Y'),'id_berita','DESC',0,10);
					  foreach ($terkini->result_array() as $row) 
					  {
						echo "<li><a href='".base_url()."$row[judul_seo]'>$row[judul]</a></li>";
					  }*/
					  //uncomment untuk aktifkan breaking news
					?>
				</ul>
			</div-->
			<div class="main-content">
				<?php 
					echo $contents;
				?>
				<div class="clear-float"></div>
			</div>
		</div>
	</div>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {margin:0;height:500px;}

        .icon-bar {
          position: fixed;
          top: 90%;
          left: 93%;
          -webkit-transform: translateY(-50%);
          -ms-transform: translateY(-50%);
          transform: translateY(-50%);
             z-index: 999;
           
        }

        .icon-bar a {
          display: block;
          text-align: center;
          padding: 16px;
          transition: all 0.3s ease;
          color: white;
          font-size: 20px;
             border-radius: 40%;
        }

        .icon-bar a:hover {
          background-color: #000;
            
        }

        .chat {
          background: #3B5998;
          color: white;
             border-radius: 40%;
        }


        .content {
          /*margin-left: 75px;*/
        }
    </style>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
    <div class="icon-bar">
      <a href="<?php echo base_url('ChatController/detailchat')?>" class="chat" target="_blank" ><i class="fa fa-comment" style='font-size:48px'></i></a> 
    </div>
	<footer>
		<div class="footer">
			<?php 
				include "footer.php";
				$this->model_utama->kunjungan(); 
			?>
		</div>
	</footer>
</div>
<!-- Scripts -->

<script type='text/javascript'>
$(document).ready(function(){
	// $("li.marketplace_system").on("click",function(){
	// 	alert("a");
	// 	$("li.marketplace_system").classList.remove("show");
	// });
});
$(function() { 
	$(window).scroll(function() {
    if($(this).scrollTop()>400) { $('#Back-to-top').fadeIn(); }else { $('#Back-to-top').fadeOut();}});
    $('#Back-to-top').click(function() {
        $('body,html')
        .animate({scrollTop:0},300)
        .animate({scrollTop:40},200)
        .animate({scrollTop:0},130)
        .animate({scrollTop:15},100)
        .animate({scrollTop:0},70);
        });
});

function jam(){
	var waktu = new Date();
	var jam = waktu.getHours();
	var menit = waktu.getMinutes();
	var detik = waktu.getSeconds();
	 
	if (jam < 10){ jam = "0" + jam; }
	if (menit < 10){ menit = "0" + menit; }
	if (detik < 10){ detik = "0" + detik; }
	var jam_div = document.getElementById('jam');
	jam_div.innerHTML = jam + ":" + menit + ":" + detik;
	setTimeout("jam()", 1000);
} jam();

</script>

	<script type="text/javascript">
      (function (jQuery) {
	      $.fn.ideaboxWeather = function (settings) {
		      var defaults = {
			      modulid   :'Swarakalibata',
			      width :'100%',
			      themecolor    :'#2582bd',
			      todaytext :'Hari Ini',
			      radius    :true,
			      location  :' Jakarta',
			      daycount  :7,
			      imgpath   :'img_cuaca/', 
			      template  :'vertical',
			      lang  :'id',
			      metric    :'C', 
			      days  :["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"],
			      dayssmall :["Mg","Sn","Sl","Rb","Km","Jm","Sa"]
			  };
		      var settings = $.extend(defaults, settings);

		      return this.each(function () {
			      settings.modulid = "#" + $(this).attr("id");
			      $(settings.modulid).css({"width":settings.width,"background":settings.themecolor});

			      if (settings.radius) $(settings.modulid).addClass("ow-border");

			      getWeather();
			      resizeEvent();

			      $(window).on("resize",function(){resizeEvent();});

			      function resizeEvent(){
				      var mW=$(settings.modulid).width();

				      if (mW<200) {$(settings.modulid).addClass("ow-small");}
				      else {$(settings.modulid).removeClass("ow-small");}
				  }

			      function getWeather(){
			      	$.get("http://api.openweathermap.org/data/2.5/forecast/daily?q="+settings.location+"&mode=xml&units=metric&cnt="+settings.daycount+"&lang="+settings.lang+"&appid=b318ee3082fcae85097e680e36b9c749", function(data) {
				      var $XML = $(data);
				      var sstr = "";
				      var location = $XML.find("name").text();
				      $XML.find("time").each(function(index,element) {
					      var $this = $(this);
					      var d = new Date($(this).attr("day"));
					      var n = d.getDay();
					      var metrics = "";
					      if (settings.metric=="F") { metrics = Math.round($this.find("temperature").attr("day") * 1.8 + 32)+"°F"; }
					      else { metrics = Math.round($this.find("temperature").attr("day"))+"°C"; }

					      if (index==0){
						      if (settings.template=="vertical"){
						      sstr=sstr+'<div class="ow-today">'+
						      '<span><img src="<?php echo base_url(); ?>asset/'+settings.imgpath+$this.find("symbol").attr("var")+'.png"/></span>'+
						      '<h2>'+metrics+'<span>'+ucFirst($this.find("symbol").attr("name"))+'</span><b>'+location+' - '+settings.todaytext+'</b></h2>'+
						      '</div>';}
						      else{
						      sstr=sstr+'<div class="ow-today">'+
						      '<span><img src="<?php echo base_url(); ?>asset/'+settings.imgpath+$this.find("symbol").attr("var")+'.png"/></span>'+
						      '<h2>'+metrics+'<span>'+ucFirst($this.find("symbol").attr("name"))+'</span><b>'+location+' - '+settings.todaytext+'</b></h2>'+
						      '</div>';}
						  }
					      else{
						      if (settings.template=="vertical"){
						      sstr=sstr+'<div class="ow-days">'+
						      '<span>'+settings.days[n]+'</span>'+
						      '<p><img src="<?php echo base_url(); ?>asset/'+settings.imgpath+$this.find("symbol").attr("var")+'.png" title="'+ucFirst($this.find("symbol").attr("name"))+'"> <b>'+metrics+'</b></p>'+
						      '</div>';}
						      else{
						      sstr=sstr+'<div class="ow-dayssmall" style="width:'+100/(settings.daycount-1)+'%">'+
						      '<span title='+settings.days[n]+'>'+settings.dayssmall[n]+'</span>'+
						      '<p><img src="<?php echo base_url(); ?>asset/'+settings.imgpath+$this.find("symbol").attr("var")+'.png" title="'+ucFirst($this.find("symbol").attr("name"))+'"></p>'+
						      '<b>'+metrics+'</b>'+
						      '</div>';}
						  }
					  });

				      $(settings.modulid).html(sstr); 
			      	});
			      }

			      function ucFirst(string) {return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();}
			  });
	      };
      })(jQuery);

      $(document).ready(function(){
      $('#example1').ideaboxWeather({
      location      :' Jakarta, ID'});});
    </script>

    <script>
	$(function(){
	    var url = window.location.pathname, 
	        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
	        // now grab every link from the navigation
	        $('.the-menu a').each(function(){
	            // and test its normalized href against the url pathname regexp
	            if(urlRegExp.test(this.href.replace(/\/$/,''))){
	                $(this).addClass('active');
	            }
	        });

	});
	</script>
    
 
	<!--Start of Tawk.to Script-->
<!--

    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5e39a1b1a89cda5a18841991/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
-->

    <!--End of Tawk.to Script-->
</body>
</html>