  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light py-2 px-4 border-top">
      <!-- Left navbar links -->
      <ul class="navbar-nav py-1">
          <li class="nav-item px-0">
              <a class="nav-link px-0" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>

      </ul>



      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto align-items-center">



          <div class="btn-group">
              <button type="button" class="btn border" data-toggle="dropdown" data-display="static" aria-expanded="false">
                  <span class="inline-flex rounded-md flex d-flex">
                      <img class="w-12 h-12 rounded-full object-cover" height="45px" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                      <div class="ml-3 leading-tight">
                          <div class="text-gray-900">{{ Auth::user()->name }}</div>
                          <div class="text-gray-700 text-sm float-left">{{ Auth::user()->role }}</div>
                      </div>
                      <span class="fa fa-angle-down ml-4 my-auto"></span>
                  </span>
              </button>
              <ul class="dropdown-menu user float-right">
                  <li>

                      <!-- Account Management -->
                      <div class="block px-4 py-2 text-xs text-gray-400">
                          {{ __('Manage Account') }}
                      </div>

                  </li>
                  <li><button class="dropdown-item" type="button">
                          <x-dropdown-link href="{{ route('profile.show') }}">
                              {{ __('Profile') }}
                          </x-dropdown-link>
                      </button></li>
                  <li>
                      <button class="dropdown-item px-auto" type="button">
                          <div class="border-top border-gray-200"></div>
                          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                          <x-dropdown-link href="{{ route('api-tokens.index') }}">
                              {{ __('API Tokens') }}
                          </x-dropdown-link>
                          @endif

                          <!-- Authentication -->
                          {{-- <form method="POST" action="{{ route('logout') }}" x-data>
                          @csrf
                          <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                              {{ __('Log Out') }}
                          </x-dropdown-link>
                          </form> --}}
                          <form action="{{ route('admin.logout') }}" method="POST">
                              @csrf
                              <button class="btn btn-transparent border-none ml-4" type="submit">Logout</button>
                          </form>
                      </button>
                  </li>
              </ul>
          </div>


      </ul>
  </nav>
  <!-- /.navbar -->
