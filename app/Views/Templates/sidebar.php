<div class="left-side-bar">
  <div class="brand-logo">
    <a href="index.html">
      <img src="<?= base_url(); ?>deskapp-master/vendors/images/deskapp-logo.svg" alt="" class="dark-logo" />
      <img src="<?= base_url(); ?>deskapp-master/vendors/images/deskapp-logo-white.svg" alt="" class="light-logo" />
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>
  <div class="menu-block customscroll">
    <div class="sidebar-menu">
      <ul id="accordion-menu">

        <li>
          <a href="calendar.html" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Dashboard</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url('admin/user'); ?>" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Data User</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/car') ?>" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Data Mobil</span>
          </a>
        </li>
        <li>
          <a href="calendar.html" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Boking & Transaksi</span>
          </a>
        </li>

        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon bi bi-house"></span><span class="mtext">Setting Home Page</span>
          </a>
          <ul class="submenu">
            <li><a href="index.html">Banner</a></li>
            <li><a href="index2.html">Slide Banner</a></li>
            <li><a href="index3.html">Hero Section</a></li>
          </ul>
        </li>

        <li>
          <a href="calendar.html" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Profile</span>
          </a>
        </li>
        <li>
          <a href="calendar.html" class="dropdown-toggle no-arrow">
            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>