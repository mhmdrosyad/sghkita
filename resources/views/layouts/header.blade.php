<header class="header border-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-15">
                        <button id="menu-toggle" class="btn px-0">
                            <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                                class="line" viewBox="0 0 24 24" width="24" height="24">
                                <polyline points="2 17 7 12 2 7" stroke="#0E2045" fill="none" stroke-width="1.25px">
                                </polyline>
                                <line x1="8" x2="22" y1="5" y2="5" stroke="#0E2045" fill="none" stroke-width="1.25px">
                                </line>
                                <line x1="12" x2="22" y1="12" y2="12" stroke="#0E2045" fill="none"
                                    stroke-width="1.25px"></line>
                                <line x1="8" x2="22" y1="19" y2="19" stroke="#0E2045" fill="none" stroke-width="1.25px">
                                </line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- profile start -->
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <div class="image">
                                        <img src="/images/profile/no-photo.jpg" alt="" />
                                    </div>
                                    <div>
                                        <h6 class="fw-500">{{ Auth::user()->name }}</h6>
                                        {{-- <p>{{ Auth::user()->name }}</p> --}}
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border" aria-labelledby="profile">
                            <li>
                                <div class="author-info flex items-center !p-1">
                                    <div class="image">
                                        <img src="/images/profile/no-photo.jpg" alt="image">
                                    </div>
                                    <div class="content">
                                        <h4 class="text-sm">{{ Auth::user()->name }}</h4>
                                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                            href="#">{{ Auth::user()->username }}</a>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="divider"></li>
                            <li>
                                <a href="#0">
                                    <i class="lni lni-user"></i> View Profile
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <i class="lni lni-alarm"></i> Notifications
                                </a>
                            </li>
                            <li>
                                <a href="#0"> <i class="lni lni-inbox"></i> Messages </a>
                            </li>
                            <li>
                                <a href="#0"> <i class="lni lni-cog"></i> Settings </a>
                            </li> --}}
                            <li class="divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <a id="logout" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="lni lni-exit"></i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- profile end -->
                </div>
            </div>
        </div>
    </div>
</header>