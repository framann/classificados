<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">Otika</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown <?php ($this->router->fetch_class() == 'home' ? 'active' : '') ?>">
              <a href="<?php echo base_url('restrita'); ?>" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown <?php ($this->router->fetch_class() == 'anuncios' ? 'active' : '') ?>">
              <a href="<?php echo base_url('restrita/anuncios'); ?>" class="nav-link"><i data-feather="tag"></i><span>Anuncios</span></a>
            </li>
            <li class="dropdown <?php ($this->router->fetch_class() == 'usuarios' ? 'active' : '') ?>">
              <a href="<?php echo base_url('restrita-usuarios'); ?>" class="nav-link"><i data-feather="users"></i><span>Anunciantes</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Categorias</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo base_url('restrita/master'); ?>">Categorias pai</a></li>
                <li><a class="nav-link" href="<?php echo base_url('restrita/categorias'); ?>">Categorias filhas</a></li>
              </ul>
            </li>
             <li class="dropdown <?php ($this->router->fetch_class() == 'sistema' ? 'active' : '') ?>">
              <a href="<?php echo base_url('restrita-sistema'); ?>" class="nav-link"><i data-feather="settings"></i><span>Sistema</span></a>
            </li>

        </ul>
    </aside>
</div>