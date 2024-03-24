  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index:10000 !important">
      <style>
          .parent .nav-icon {
              font-size: 17px !important;
              color: #e6e6e6
          }

      </style>
      <!-- Brand Logo -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-dark">
          <div class="image">

              <img src="{{ asset('backend/dist/img/dms.png') }}" class="img" alt="User Image" style="height: 44px; width:auto;">
          </div>
      </div>
      <!-- Sidebar -->
      <div class="sidebar mt-0">
          <!-- Sidebar user panel (optional) -->

          <div class="form-inline mb-4 mt-0">
              <div class="input-group bg-transparent" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar bg-transparent" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar bg-transparent">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
              <div class="sidebar-search-results">
                  <div class="list-group"><a href="#" class="list-group-item">
                          <div class="search-title"><strong class="text-light">
                              </strong>N<strong class="text-light"></strong>
                              o<strong class="text-light"></strong> <strong class="text-light"></strong>e
                              <strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light">
                              </strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n
                              <strong class="text-light"></strong>t<strong class="text-light"></strong>
                              <strong class="text-light"></strong>f<strong class="text-light"></strong>o
                              <strong class="text-light"></strong>u<strong class="text-light"></strong>n
                              <strong class="text-light"></strong>d<strong class="text-light"></strong>
                              !<strong class="text-light"></strong>
                          </div>
                          <div class="search-path"></div>
                      </a></div>
              </div>
          </div>
          <style>
              .nav-item a p {
                  font-size: 13px !important;
                  color: #f6f6f6;
              }

          </style>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                      <a href="{{ url('admin/dashboard') }}" class="parent nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/products') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Products List
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/sales') }}" class="nav-link {{ request()->is('admin/sales') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Sales List
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/sales/create') }}" class="nav-link {{ request()->is('admin/sales/create') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              New Sales
                          </p>
                      </a>
                  </li>


              </ul>
              </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
