        <section class="sidebar">
          <!-- Sidebar user panel -->
          <?php
            $cek_reff=$this->db->query("select * from rb_reseller where username='".$this->session->username."'");
            // var_dump($cek_reff);
            // echo "<script>alert('".$cek_reff->num_rows()."')<script>";
            if ($this->session->userdata("reff")==0) {
              $log = $this->model_app->edit('rb_reseller',array('id_reseller'=>$this->session->id_reseller))->row_array(); 
            }else{
              $log = $this->model_app->edit('rb_referral',array('id_reseller'=>$this->session->id_reseller))->row_array(); 
            }
            
            if ($log['foto']==''){ $foto = 'blank.png'; }else{ $foto = $log['foto']; }
              echo "<div class='user-panel'>
                <div class='pull-left image'>
                  <img src='".base_url()."asset/foto_user/$foto' class='img-circle' alt='User Image'>
                </div>
                <div class='pull-left info'>
                  <p>$log[nama_reseller]</p>
                  <a href=''><i class='fa fa-circle text-success'></i> Online</a>
                </div>
              </div>";
          ?>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU RESELLER</li>
            <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="<?php echo base_url(); ?>reseller/register_mitra<?php echo $this->session->ctrreg!=''?"?no=".$this->session->ctrreg:""; ?>"> <i class="fa fa-handshake-o"></i> <span><?php echo $cek_reff->num_rows()<1?"Jadi Mitra Sekarang Yuk":"Pendaftaran Mitra <br/> &emsp; &ensp; &nbsp; dibawah anda"; ?></span></a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-user"></i> <span>Akun Saya</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url(); ?>reseller/edit_reseller/<?php echo $this->session->id_reseller; ?>"><i class="fa fa-circle-o"></i>Edit Profile</a></li>
                <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/akunpembeli"><i class='fa fa-circle-o'></i>Akun Pembeli</a></li>
                <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/akuntoko"><i class='fa fa-circle-o'></i>Akun Toko</a></li>
              </ul>
            </li>
             <li class="treeview">
                <a href="#"><i class="fa fa-th-large"></i> <span>Data Produk</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php 
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/produk'><i class='fa fa-circle-o'></i> Data Produk Anda</a></li>";
                    ?>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-th-large"></i> <span>Referensi</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php 
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/rekening'><i class='fa fa-circle-o'></i> No Rekening Anda</a></li>";
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/keterangan'><i class='fa fa-circle-o'></i> Info/Keterangan</a></li>";
                    ?>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#"><i class="fa fa-shopping-cart"></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php 
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/pembelian'><i class='fa fa-circle-o'></i> Pembelian Ke Pusat</a></li>";
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/penjualan'><i class='fa fa-circle-o'></i> Penjualan ke Konsumen</a></li>";
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/pembayaran_konsumen'><i class='fa fa-circle-o'></i> Pembayaran Konsumen</a></li>";
						echo "<li><a href='".base_url().$this->uri->segment(1)."/penarikan_dana'><i class='fa fa-circle-o'></i> Penarikan Dana</a></li>";
             echo "<li><a href='".base_url().$this->uri->segment(1)."/nego'><i class='fa fa-circle-o'></i> Nego</a></li>";
						if (($this->session->id_reseller==2)||($this->session->id_reseller==1)) //jika yg login id company atau company1
						{
							echo "<li><a href='".base_url().$this->uri->segment(1)."/cek_transfer'><i class='fa fa-circle-o'></i> Cek bukti transfer</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/create_voucher'><i class='fa fa-circle-o'></i> Create voucher code</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/release_user'><i class='fa fa-circle-o'></i> Release user</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/update_tarik'><i class='fa fa-circle-o'></i> Update status transfer</a></li>";
							
						}
					?>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#"><i class="fa fa-book"></i> <span>Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php 
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/keuangan'><i class='fa fa-circle-o'></i>Data Keuangan</a></li>";
						//echo "<li><a href='".base_url()."application/views/reseller/mod_reseller/view_reseller_keuangan.php'><i class='fa fa-circle-o'></i> Data Keuangan</a></li>";
						echo "<li><a href='".base_url().$this->uri->segment(1)."/network_list'><i class='fa fa-circle-o'></i>Data reseller dari Anda</a></li>";						
						if (($this->session->id_reseller==2)||($this->session->id_reseller==1))
						{
                            echo "<li><a href='".base_url().$this->uri->segment(1)."/network_list2'><i class='fa fa-circle-o'></i>Network list based tree</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/mutasi_perusahaan'><i class='fa fa-circle-o'></i>Mutasi rek perusahaan</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/alokasi_member'><i class='fa fa-circle-o'></i>Mutasi Rp.3.000/ member join</a></li>";
							echo "<li><a href='".base_url().$this->uri->segment(1)."/alokasi_penampungan'><i class='fa fa-circle-o'></i>Mutasi penampungan</a></li>";
						}
						if ($this->session->id_reseller>=1000)
						{
						    echo "<li><a href='".base_url().$this->uri->segment(1)."/network_list3'><i class='fa fa-circle-o'></i>Network list</a></li>"; 
						}
                    ?>
                </ul>
            </li>
            <!-- <li><a href="<?php echo base_url(); ?>reseller/edit_reseller/<?php echo $this->session->id_reseller; ?>"><i class="fa fa-user"></i> <span>Edit Profile</span></a></li>     -->        
            <li><a href="<?php echo base_url(); ?>reseller/logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
          </ul>
        </section>