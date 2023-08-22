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
            <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU PEMBELI</li>
            <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/akunpembeli"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-user"></i> <span>Akun Saya</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url(); ?>reseller/edit_consumer/<?php echo $this->session->id_reseller; ?>"><i class="fa fa-circle-o"></i>Edit Profile</a></li>
                <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/akunpembeli"><i class='fa fa-circle-o'></i>Akun Pembeli</a></li>
                <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/akuntoko"><i class='fa fa-circle-o'></i>Akun Toko</a></li>
              </ul>
            </li>
            <li><a href="<?php echo base_url().$this->uri->segment(1); ?>/wishlist"><i class="fa fa-heart"></i> <span>Wishlist</span></a></li>
            
            <li class="treeview">
                <a href="#"><i class="fa fa-shopping-cart"></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php 
                        echo "<li><a href='".base_url().$this->uri->segment(1)."/historypembelian'><i class='fa fa-circle-o'></i> History Pembelian</a></li>";
                       echo "<li><a href='".base_url().$this->uri->segment(1)."/negokonsumen'><i class='fa fa-circle-o'></i> Nego</a></li>";
					?>
                </ul>
            </li>
            <!-- <li><a href="<?php echo base_url(); ?>reseller/edit_reseller/<?php echo $this->session->id_reseller; ?>"><i class="fa fa-user"></i> <span>Edit Profile</span></a></li>     -->        
            <li><a href="<?php echo base_url(); ?>reseller/logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
          </ul>
        </section>