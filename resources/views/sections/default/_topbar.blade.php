<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0 pt-2 mt-2" style="background-color: #0b5ed7">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100">
            <div class="d-flex align-items-center"></div>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown ms-lg-3" wire:ignore>
                    <a class="nav-link dropdown-toggle pt-1 px-0"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-display="static" {{-- Helps with positioning --}}
                       aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <img class="avatar rounded-circle border border-2 border-white"
                                 style="width: 35px; height: 35px; object-fit: cover;"
                                 alt="User Avatar"
                                 src="{{ Auth::user() ? asset('assets/img/team/dr-majid-taghvaei.png') : asset('assets/img/team/medwork-logo.jpg')}}">

                            <div class="ms-2 text-white d-none d-lg-block">
                                <span class="mb-0 font-small fw-bold">{{ Auth::user()?->name ?? 'Guest' }}</span>
                            </div>
                        </div>
                    </a>

                    {{-- Standard Bootstrap 5 dropdown menu --}}
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2 py-2">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user-circle me-2 text-gray-400"></i>
                                {{ __('My Profile') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
