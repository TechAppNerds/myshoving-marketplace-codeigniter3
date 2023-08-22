<script type="text/javascript">
    
/* ========================================================================
 * bootstrap-spin - v1.0
 * https://github.com/wpic/bootstrap-spin
 * ========================================================================
 * Copyright 2014 WPIC, Hamed Abdollahpour
 *
 * ========================================================================
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

(function ( $ ) {

    $.fn.bootstrapNumber = function( options ) {

        var settings = $.extend({
            upClass: 'default',
            downClass: 'default',
            upText: '+',
            downText: '-',
            center: true
            }, options );

        return this.each(function(e) {
            var self = $(this);
            var clone = self.clone(true, true);

            var min = self.attr('min');
            var max = self.attr('max');
            var step = parseInt(self.attr('step')) || 1;

            function setText(n) {
                if (isNaN(n) || (min && n < min) || (max && n > max)) {
                    return false;
                }

                clone.focus().val(n);
                clone.trigger('change');
                return true;
            }

            var group = $("<div class='input-group'></div>");
            var down = $("<button type='button'>" + settings.downText + "</button>").attr('class', 'btn btn-' + settings.downClass).click(function() {
                setText(parseInt(clone.val() || clone.attr('value')) - step);
            });
            var up = $("<button type='button'>" + settings.upText + "</button>").attr('class', 'btn btn-' + settings.upClass).click(function() {
                setText(parseInt(clone.val() || clone.attr('value')) + step);
            });
            $("<span class='input-group-btn'></span>").append(down).appendTo(group);
            clone.appendTo(group);
            if(clone && settings.center) {
                clone.css('text-align', 'center');
            }
            $("<span class='input-group-btn'></span>").append(up).appendTo(group);

            // remove spins from original
            clone.prop('type', 'text').keydown(function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }

                var c = String.fromCharCode(e.which);
                var n = parseInt(clone.val() + c);

                if ((min && n < min) || (max && n > max)) {
                    e.preventDefault();
                }
            });

            self.replaceWith(group);
        });
    };
} ( jQuery ));

</script>
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
			<table id="example1" class="table table-bordered table-striped table-condensed">
		        <thead>
		          <tr>
		            <th style='width:40px'>No</th>
		            <th>Username Penjual</th>
		            <th>Nama Produk</th>
		            <th>Jumlah</th>
		            <th>Harga Satuan</th>
		            <th>Satuan</th>
		            <th>Total Harga</th>
		            <th>Status</th>
		            <th>Tanggal Pengajuan</th>
		            <th>Hapus</th>
		          </tr>
		        </thead>
		        <tbody>
		        
		        	<?php
		        	$no = 1;
		        	foreach ($pembeli_a as $a) {
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
		        		if($a['id_status_nego']==3){
		        			echo "<td>".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."&nbsp;<div class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal".$a['id_nego']."'>Nego Ulang</div>";
		        			echo '<!-- Modal -->
                                <div class="modal fade" id="myModal'.$a['id_nego'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color:black;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel'.$a['id_nego'].'">Nego</h4>
                                            </div>
                                            <div class="modal-body row">
                                                <form action="'.base_url().'produk/proses_nego/1" method="POST">
                                                <div class="form-group">
                                                	<h4>'.$a["produk"].'</h4>
                                                	<p>'.$a["user"].'</p>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0px;">
                                                    <label class="col-sm-2 control-label">Jumlah</label>
                                                    <div style="width:125px; padding:15px;">
                                                        <input id="colorful3'.$a['id_nego'].'" class="form-control" name="jumlah_nego" type="number" value="'.$a['jumlah'].'" min="'.$a['jumlah'].'" max="'.$a['jumlah_max'].'" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="update_total'.$a['id_nego'].'()"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Harga Satuan</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" id="harga_tawar'.$a['id_nego'].'" class="form-control" name="harga_nego" value="'.$a['harga'].'" min="'.$a['harga'].'"  placeholder="Harga Satuan" max="'.$a['harga_konsumen'].'" onchange="update_total'.$a['id_nego'].'()">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" style="padding-top:15px;">Harga Total</label>
                                                    <div class="col-sm-10">
                                                        <h2 id="harga_total_modal'.$a['id_nego'].'" style="color:green">Rp 1.00</h2>
                                                    </div>
                                                </div>';
                                            echo "<script>

                                                function update_total".$a['id_nego']."(){
                                                  const formatter = new Intl.NumberFormat('en-US', {
                                                      minimumFractionDigits: 2
                                                    })
                                                    var jumlah = document.getElementById('colorful3".$a['id_nego']."').value;
                                                    var harga = document.getElementById('harga_tawar".$a['id_nego']."').value;
                                                    var total = (jumlah * harga);
                                                    document.getElementById('harga_total_modal".$a['id_nego']."').innerHTML = 'Rp '+formatter.format(total);
                                                }
                                            </script>
                                            <div class='form-group'>
                                            <div class='col-sm-12'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary'>Send Negotiation</button>
                                            </div>
                                            </div>
                                            <input type='hidden' name='id_reseller' value='".$a['id_penjual']."'>
                                            <input type='hidden' name='id_produk' value='".$a['id_produk']."'>
                                            <input type='hidden' name='satuan' value='".$a['satuan']."'>
                                            <script>
                                            $('#colorful3".$a['id_nego']."').bootstrapNumber({
											    upClass: 'success',
											    downClass: 'danger'
											});
											$('#colorful3".$a['id_nego']."').on('blur', function(){
											    if ($(this).val().length < 1) $(this).val($(this).attr('min'));
											});
											</script>
                                            </form>
                                            ";
                                            echo '</div>
                                        </div>
                                    </div>
                                </div>';

                                echo "
		        			</td>";
		        		}
		        		else{
		        			echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		}
		        		$no++;
		        		echo "</tr>";
		        	}
		        	foreach ($pembeli_b as $a) {
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
		        		if($a['id_status_nego']==3){
		        			echo "<td>".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."&nbsp;<div class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal".$a['id_nego']."'>Nego Ulang</div>";
		        			echo '<!-- Modal -->
                                <div class="modal fade" id="myModal'.$a['id_nego'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color:black;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel'.$a['id_nego'].'">Nego</h4>
                                            </div>
                                            <div class="modal-body row">
                                                <form action="'.base_url().'produk/proses_nego/1" method="POST">
                                                <div class="form-group">
                                                	<h4>'.$a["produk"].'</h4>
                                                	<p>'.$a["user"].'</p>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0px;">
                                                    <label class="col-sm-2 control-label">Jumlah</label>
                                                    <div style="width:125px; padding:15px;">
                                                        <input id="colorful3'.$a['id_nego'].'" class="form-control" name="jumlah_nego" type="number" value="'.$a['jumlah'].'" min="'.$a['jumlah'].'" max="'.$a['jumlah_max'].'" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="update_total'.$a['id_nego'].'()"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Harga Satuan</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" id="harga_tawar'.$a['id_nego'].'" class="form-control" name="harga_nego" value="'.$a['harga'].'" min="'.$a['harga'].'"  placeholder="Harga Satuan" max="'.$a['harga_konsumen'].'" onchange="update_total'.$a['id_nego'].'()">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" style="padding-top:15px;">Harga Total</label>
                                                    <div class="col-sm-10">
                                                        <h2 id="harga_total_modal'.$a['id_nego'].'" style="color:green">Rp 1.00</h2>
                                                    </div>
                                                </div>';
                                            echo "<script>

                                                function update_total".$a['id_nego']."(){
                                                  const formatter = new Intl.NumberFormat('en-US', {
                                                      minimumFractionDigits: 2
                                                    })
                                                    var jumlah = document.getElementById('colorful3".$a['id_nego']."').value;
                                                    var harga = document.getElementById('harga_tawar".$a['id_nego']."').value;
                                                    var total = (jumlah * harga);
                                                    document.getElementById('harga_total_modal".$a['id_nego']."').innerHTML = 'Rp '+formatter.format(total);
                                                }
                                            </script>
                                            <div class='form-group'>
                                            <div class='col-sm-12'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary'>Send Negotiation</button>
                                            </div>
                                            </div>
                                            <input type='hidden' name='id_reseller' value='".$a['id_penjual']."'>
                                            <input type='hidden' name='id_produk' value='".$a['id_produk']."'>
                                            <input type='hidden' name='satuan' value='".$a['satuan']."'>
                                            <script>
                                            $('#colorful3".$a['id_nego']."').bootstrapNumber({
											    upClass: 'success',
											    downClass: 'danger'
											});
											$('#colorful3".$a['id_nego']."').on('blur', function(){
											    if ($(this).val().length < 1) $(this).val($(this).attr('min'));
											});
											</script>
                                            </form>
                                            ";
                                            echo '</div>
                                        </div>
                                    </div>
                                </div>';

                                echo "
		        			</td>";
		        		}
		        		else{
		        			echo "<td onclick=\"javascript: return confirm('Anda yakin ingin hapus data nego anda?')\">".anchor('reseller/hapus_nego/'.$a['id_nego'].'',"<div class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></div>")."</td>";
		        		}
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
