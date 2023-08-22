<?php
echo "<div class='wrapper'>
	<ul class='right'>";
		$topmenu2 = $this->model_utama->view_where('menu',array('position' => 'Top','aktif' => 'Ya'),'urutan','ASC',0,5);
			foreach ($topmenu2->result_array() as $row) {
			echo "<li><a href='$row[link]'>$row[nama_menu]</a></li>";
		}
	echo "</ul>";
	// echo "<p><a target='_BLANK' href='http://www.myshoving.com'><font style='color:blue'>www.myshoving.com</font></a></p>";
echo "<p><font>© 2019 - 2020, My Shoving</font></p>
</div>";