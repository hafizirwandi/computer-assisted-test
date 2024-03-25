  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo">
                  <img style="width:50px" src="{{ asset('logo-tutwurihandayani.png') }}" alt="">
              </span>
              <span class="app-brand-text demo menu-text fw-bold">CAT</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
          </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
          @auth('web')
              <li class="menu-item {{ request()->routeIs('home*') ? 'active' : '' }}">
                  <a href="{{ route('home') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-smart-home"></i>
                      <div data-i18n="Home">Home</div>
                  </a>
              </li>

              <li class="menu-item {{ request()->routeIs('user*') ? 'active' : '' }}">
                  <a href="{{ route('user') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-users"></i>
                      <div data-i18n="User">User</div>
                  </a>
              </li>

              <li class="menu-item {{ isDropdown(['role*', 'permission*']) }}">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                      <i class="menu-icon tf-icons ti ti-settings"></i>
                      <div data-i18n="Role & Permission">Role & Permission</div>
                  </a>
                  <ul class="menu-sub">
                      <li class="menu-item {{ request()->routeIs('role*') ? 'active' : '' }}">
                          <a href="{{ route('role') }}" class="menu-link">
                              <div data-i18n="Roles">Role</div>
                          </a>
                      </li>
                      <li class="menu-item {{ request()->routeIs('permission*') ? 'active' : '' }}">
                          <a href="{{ route('permission') }}" class="menu-link">
                              <div data-i18n="Permission">Permission</div>
                          </a>
                      </li>
                  </ul>
              </li>


              <li class="menu-item {{ request()->routeIs('sekolah*') ? 'active' : '' }}">
                  <a href="{{ route('sekolah') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-school"></i>
                      <div data-i18n="User">Sekolah</div>
                  </a>
              </li>
              <li class="menu-item {{ request()->routeIs('matapelajaran*') ? 'active' : '' }}">
                  <a href="{{ route('matapelajaran') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-books"></i>
                      <div data-i18n="User">Matapelajaran</div>
                  </a>
              </li>
              <li class="menu-item {{ request()->routeIs('soal*') ? 'active' : '' }}">
                  <a href="{{ route('soal') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-microscope"></i>
                      <div data-i18n="User">Soal</div>
                  </a>
              </li>

              <li class="menu-item {{ request()->routeIs('siswa*') ? 'active' : '' }}">
                  <a href="{{ route('siswa') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-user-circle"></i>
                      <div data-i18n="User">Siswa</div>
                  </a>
              </li>

              <li class="menu-item {{ request()->routeIs('pengaturan-ujian*') ? 'active' : '' }}">
                  <a href="{{ route('pengaturan-ujian') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-forms"></i>
                      <div data-i18n="User">Pengaturan Ujian</div>
                  </a>
              </li>

              <li class="menu-item {{ request()->routeIs('reset-ujian*') ? 'active' : '' }}">
                  <a href="{{ route('reset-ujian') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-refresh"></i>
                      <div data-i18n="User">Reset Ujian</div>
                  </a>
              </li>

              <li class="menu-item">
                  <a href="" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-file-description"></i>
                      <div data-i18n="User">Dokumentasi</div>
                  </a>
              </li>
          @endauth
          {{-- Auth::siswa --}}
          @auth('siswa')
              <li class="menu-item {{ request()->routeIs('home.siswa*') ? 'active' : '' }}">
                  <a href="{{ route('home.siswa') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-smart-home"></i>
                      <div data-i18n="Home">Home</div>
                  </a>
              </li>
              <li class="menu-item {{ request()->routeIs('cat') ? 'active' : '' }}">
                  <a href="{{ route('cat') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-device-desktop"></i>
                      <div data-i18n="User">CAT</div>
                  </a>
              </li>
              <li class="menu-item {{ request()->routeIs('cat.nilai*') ? 'active' : '' }}">
                  <a href="{{ route('cat.nilai') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-star"></i>
                      <div data-i18n="User">Nilai</div>
                  </a>
              </li>
              <li class="menu-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
                  <a href="{{ route('profile') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-user"></i>
                      <div data-i18n="User">Profil</div>
                  </a>
              </li>
          @endauth

      </ul>
  </aside>


  @php

      function isDropdown($trees)
      {
          $temp = false;
          foreach ($trees as $r) {
              $temp = request()->routeIs($r);
              if ($temp) {
                  return 'active open';
                  break;
              }
          }
      }

  @endphp
