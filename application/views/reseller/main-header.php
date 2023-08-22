<style type="text/css">
  .sekolah{
    float: left;
    background-color: transparent;
    background-image: none;
    padding: 15px 15px;
    font-family: fontAwesome;
    color: #fff;
  }
  .sekolah:hover{
    color: #fff;
  }
</style>

<!-- Logo -->
<a href="<?php echo base_url();?>reseller/home" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"></span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>Reseller dashboard</b></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    
    <ul class="nav navbar-nav">
       <li class="dropdown messages-menu">
        <a href="<?php echo base_url('ChatController/detailchat')?>" target="_blank" class="dropdown-toggle">
          <i class="fa fa-envelope-o"></i> Halaman Customer Service
        </a>
      </li>
      <li><a target='_SELF' href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-new-window"></i></a></li>
    </ul>
  </div>
</nav>