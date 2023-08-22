<?php
  echo "<option value='' disabled selected>- Pilih -</option>";
  foreach ($kota as $row){
      echo "<option value='$row[kota_id]'>$row[nama_kota]</option>";
  }
?>