<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <div class="d-flex align-items-center">
            <a href="{{ route('dashboard') }}">
                <h3 class="fw-semibold">Sghkita.</h3>
            </a>
            <span class="bg-primary text-white px-2">com</span>
        </div>

    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="{{route('dashboard')}}">
                    <span class="icon">
                        <svg id="Home" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Home" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Home" transform="translate(2.000000, 1.000000)" fill="currentColor">
                                    <path
                                        d="M11.7168,14.2913 C12.9208,14.2913 13.9008,15.2643 13.9008,16.4603 L13.9008,19.5363 C13.9008,19.7933 14.1068,19.9993 14.3708,20.0053 L16.2768,20.0053 C17.7788,20.0053 18.9998,18.7993 18.9998,17.3173 L18.9998,8.5933 C18.9928,8.0833 18.7498,7.6033 18.3328,7.2843 L11.7398,2.0263 C10.8548,1.3253 9.6168,1.3253 8.7288,2.0283 L2.1808,7.2823 C1.7478,7.6113 1.5048,8.0913 1.4998,8.6103 L1.4998,17.3173 C1.4998,18.7993 2.7208,20.0053 4.2228,20.0053 L6.1468,20.0053 C6.4178,20.0053 6.6378,19.7903 6.6378,19.5263 C6.6378,19.4683 6.6448,19.4103 6.6568,19.3553 L6.6568,16.4603 C6.6568,15.2713 7.6308,14.2993 8.8258,14.2913 L11.7168,14.2913 Z M16.2768,21.5053 L14.3528,21.5053 C13.2508,21.4793 12.4008,20.6143 12.4008,19.5363 L12.4008,16.4603 C12.4008,16.0913 12.0938,15.7913 11.7168,15.7913 L8.8308,15.7913 C8.4618,15.7933 8.1568,16.0943 8.1568,16.4603 L8.1568,19.5263 C8.1568,19.6013 8.1468,19.6733 8.1258,19.7413 C8.0178,20.7313 7.1718,21.5053 6.1468,21.5053 L4.2228,21.5053 C1.8938,21.5053 -0.0002,19.6263 -0.0002,17.3173 L-0.0002,8.6033 C0.0098,7.6093 0.4678,6.6993 1.2588,6.1003 L7.7938,0.8553 C9.2328,-0.2847 11.2378,-0.2847 12.6738,0.8533 L19.2558,6.1033 C20.0288,6.6923 20.4868,7.6003 20.4998,8.5823 L20.4998,17.3173 C20.4998,19.6263 18.6058,21.5053 16.2768,21.5053 L16.2768,21.5053 Z"
                                        id="Fill-1"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Beranda</span>
                </a>
            </li>
            @if(auth()->user()->can('view transaction'))
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_2"
                    aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg id="Wallet" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Wallet" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Wallet" transform="translate(2.000000, 3.000000)" fill="currentColor">
                                    <path
                                        d="M14.6416,3.55271368e-15 C17.9486,3.55271368e-15 20.6386,2.69 20.6386,5.998 L20.6386,13.175 C20.6386,16.482 17.9486,19.173 14.6416,19.173 L5.9976,19.173 C2.6906,19.173 -0.0004,16.482 -0.0004,13.175 L-0.0004,5.998 C-0.0004,2.69 2.6906,3.55271368e-15 5.9976,3.55271368e-15 L14.6416,3.55271368e-15 Z M14.6416,1.5 L5.9976,1.5 C3.5176,1.5 1.4996,3.518 1.4996,5.998 L1.4996,13.175 C1.4996,15.655 3.5176,17.673 5.9976,17.673 L14.6416,17.673 C17.1216,17.673 19.1386,15.655 19.1386,13.175 L19.1386,12.895 L15.8407,12.8956 C13.9437,12.8956 12.3997,11.3526 12.3987,9.4566 C12.3987,7.5586 13.9427,6.0146 15.8407,6.0136 L19.1386,6.013 L19.1386,5.998 C19.1386,3.518 17.1216,1.5 14.6416,1.5 Z M19.1386,7.513 L15.8407,7.5136 C14.7697,7.5146 13.8987,8.3856 13.8987,9.4556 C13.8987,10.5246 14.7707,11.3956 15.8407,11.3956 L19.1386,11.395 L19.1386,7.513 Z M16.2983,8.6436 C16.7123,8.6436 17.0483,8.9796 17.0483,9.3936 C17.0483,9.8076 16.7123,10.1436 16.2983,10.1436 L15.9863,10.1436 C15.5723,10.1436 15.2363,9.8076 15.2363,9.3936 C15.2363,8.9796 15.5723,8.6436 15.9863,8.6436 L16.2983,8.6436 Z M10.6846,4.5381 C11.0986,4.5381 11.4346,4.8741 11.4346,5.2881 C11.4346,5.7021 11.0986,6.0381 10.6846,6.0381 L5.2856,6.0381 C4.8716,6.0381 4.5356,5.7021 4.5356,5.2881 C4.5356,4.8741 4.8716,4.5381 5.2856,4.5381 L10.6846,4.5381 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Transaksi</span>
                </a>
                <ul id="ddmenu_2" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('transaction.index', ['account' => '101']) }}">Front Office</a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.index', ['account' => '102']) }}">BCA</a>
                    </li>
                    <li>

                        <a href="{{ route('transaction.index', ['account' => '103']) }}">BCA Payroll</a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.index') }}">Lainya</a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->can('view accounting'))
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_4"
                    aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg id="Chart" width="24" height="24" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.48315 10.5109C7.89737 10.5109 8.23315 10.8467 8.23315 11.2609V17.9546C8.23315 18.3688 7.89737 18.7046 7.48315 18.7046C7.06894 18.7046 6.73315 18.3688 6.73315 17.9546V11.2609C6.73315 10.8467 7.06894 10.5109 7.48315 10.5109Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.0369 7.30734C12.4511 7.30734 12.7869 7.64313 12.7869 8.05734V17.9552C12.7869 18.3695 12.4511 18.7052 12.0369 18.7052C11.6227 18.7052 11.2869 18.3695 11.2869 17.9552V8.05734C11.2869 7.64313 11.6227 7.30734 12.0369 7.30734Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.5157 14.0482C16.93 14.0482 17.2657 14.384 17.2657 14.7982V17.955C17.2657 18.3692 16.93 18.705 16.5157 18.705C16.1015 18.705 15.7657 18.3692 15.7657 17.955V14.7982C15.7657 14.384 16.1015 14.0482 16.5157 14.0482Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.96051 5.96045C3.66147 7.25949 3.05005 9.42738 3.05005 13.0368C3.05005 16.6463 3.66147 18.8142 4.96051 20.1132C6.25956 21.4123 8.42744 22.0237 12.0369 22.0237C15.6463 22.0237 17.8142 21.4123 19.1133 20.1132C20.4123 18.8142 21.0237 16.6463 21.0237 13.0368C21.0237 9.42738 20.4123 7.25949 19.1133 5.96045C17.8142 4.6614 15.6463 4.04999 12.0369 4.04999C8.42744 4.04999 6.25956 4.6614 4.96051 5.96045ZM3.89985 4.89979C5.6437 3.15594 8.34424 2.54999 12.0369 2.54999C15.7295 2.54999 18.4301 3.15594 20.1739 4.89979C21.9178 6.64364 22.5237 9.34418 22.5237 13.0368C22.5237 16.7295 21.9178 19.43 20.1739 21.1739C18.4301 22.9177 15.7295 23.5237 12.0369 23.5237C8.34424 23.5237 5.6437 22.9177 3.89985 21.1739C2.156 19.43 1.55005 16.7295 1.55005 13.0368C1.55005 9.34418 2.156 6.64364 3.89985 4.89979Z"
                                fill="currentColor" />
                        </svg>
                        <path d="M7.4831 10.261V16.9547" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M12.0369 7.05737V16.9553" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16.5157 13.7982V16.9551" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2.30005 12.0369C2.30005 4.73479 4.73479 2.30005 12.0369 2.30005C19.339 2.30005 21.7737 4.73479 21.7737 12.0369C21.7737 19.339 19.339 21.7737 12.0369 21.7737C4.73479 21.7737 2.30005 19.339 2.30005 12.0369Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">Accounting</span>
                </a>
                <ul id="ddmenu_4" class="collapse dropdown-nav">
                    <li>
                        <a href="{{route('accounting.profitLoss')}}"> Laba Rugi </a>
                    </li>
                    <li>
                        <a href="{{route('accounting.balanceSheet')}}"> Neraca </a>
                    </li>
                    <li>
                        <a href="{{route('account.index')}}">Akun </a>
                    </li>
                    <li>
                        <a href="{{route('category.index')}}">Jenis Transaksi </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('view reservation'))
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_5"
                    aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg id="Folder" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Folder" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Folder" transform="translate(2.000000, 2.000000)" fill="currentColor">
                                    <path
                                        d="M7.6426,9.59232693e-14 C8.5936,0.001 9.4996,0.455 10.0676,1.214 L10.9786,2.426 C11.2676,2.81 11.7266,3.039 12.2066,3.04 L15.0356,3.04 C18.8976,3.04 20.6966,5.019 20.6966,9.268 L20.6686,14.235 C20.6676,18.203 18.2016,20.669 14.2316,20.669 L6.4496,20.669 C2.4716,20.669 -0.0004,18.202 -0.0004,14.232 L-0.0004,6.433 C-0.0004,2.164 1.8986,9.59232693e-14 5.6426,9.59232693e-14 L7.6426,9.59232693e-14 Z M7.6416,1.5 L5.6426,1.5 C2.7386,1.5 1.4996,2.976 1.4996,6.433 L1.4996,14.232 C1.4996,17.416 3.2576,19.169 6.4496,19.169 L14.2316,19.169 C17.4156,19.169 19.1686,17.416 19.1686,14.232 L19.1686,14.229 L19.1966,9.264 C19.1966,5.865 18.0306,4.54 15.0356,4.54 L12.2056,4.54 C11.2566,4.539 10.3506,4.086 9.7806,3.328 L8.8676,2.114 C8.5806,1.729 8.1216,1.501 7.6416,1.5 Z M14.7158,12.2128 C15.1298,12.2128 15.4658,12.5488 15.4658,12.9628 C15.4658,13.3768 15.1298,13.7128 14.7158,13.7128 L5.9808,13.7128 C5.5668,13.7128 5.2308,13.3768 5.2308,12.9628 C5.2308,12.5488 5.5668,12.2128 5.9808,12.2128 L14.7158,12.2128 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Tamu Grup</span>
                </a>
                <ul id="ddmenu_5" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('customer.index') }}">Customer</a>
                    </li>
                    <li>
                        <a href="{{ route('reservations.index') }}">Reservasi</a>
                    </li>
                    <li>
                        <a href="{{ route('sales.index') }}">Sales</a>
                    </li>
                    <li>
                        <a href="{{ route('res_category.index') }}">Jenis Pesanan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('checkins.index') }}">
                    <span class="icon">
                        <svg id="Document" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Document" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Document" transform="translate(3.000000, 2.000000)" fill="currentColor">
                                    <path
                                        d="M12.9087,8.17124146e-14 C16.0527,8.17124146e-14 18.1647,2.153 18.1647,5.357 L18.1647,14.553 C18.1647,17.785 16.1177,19.887 12.9497,19.907 L5.2567,19.91 C2.1127,19.91 -0.0003,17.757 -0.0003,14.553 L-0.0003,5.357 C-0.0003,2.124 2.0467,0.023 5.2147,0.004 L12.9077,8.17124146e-14 L12.9087,8.17124146e-14 Z M12.9087,1.5 L5.2197,1.504 C2.8917,1.518 1.4997,2.958 1.4997,5.357 L1.4997,14.553 C1.4997,16.968 2.9047,18.41 5.2557,18.41 L12.9447,18.407 C15.2727,18.393 16.6647,16.951 16.6647,14.553 L16.6647,5.357 C16.6647,2.942 15.2607,1.5 12.9087,1.5 Z M12.7158,13.4737 C13.1298,13.4737 13.4658,13.8097 13.4658,14.2237 C13.4658,14.6377 13.1298,14.9737 12.7158,14.9737 L5.4958,14.9737 C5.0818,14.9737 4.7458,14.6377 4.7458,14.2237 C4.7458,13.8097 5.0818,13.4737 5.4958,13.4737 L12.7158,13.4737 Z M12.7158,9.2872 C13.1298,9.2872 13.4658,9.6232 13.4658,10.0372 C13.4658,10.4512 13.1298,10.7872 12.7158,10.7872 L5.4958,10.7872 C5.0818,10.7872 4.7458,10.4512 4.7458,10.0372 C4.7458,9.6232 5.0818,9.2872 5.4958,9.2872 L12.7158,9.2872 Z M8.2505,5.1104 C8.6645,5.1104 9.0005,5.4464 9.0005,5.8604 C9.0005,6.2744 8.6645,6.6104 8.2505,6.6104 L5.4955,6.6104 C5.0815,6.6104 4.7455,6.2744 4.7455,5.8604 C4.7455,5.4464 5.0815,5.1104 5.4955,5.1104 L8.2505,5.1104 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Checkin</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('invoices.index') }}">
                    <span class="icon">
                        <svg id="Document" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Document" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Document" transform="translate(3.000000, 2.000000)" fill="currentColor">
                                    <path
                                        d="M12.9087,8.17124146e-14 C16.0527,8.17124146e-14 18.1647,2.153 18.1647,5.357 L18.1647,14.553 C18.1647,17.785 16.1177,19.887 12.9497,19.907 L5.2567,19.91 C2.1127,19.91 -0.0003,17.757 -0.0003,14.553 L-0.0003,5.357 C-0.0003,2.124 2.0467,0.023 5.2147,0.004 L12.9077,8.17124146e-14 L12.9087,8.17124146e-14 Z M12.9087,1.5 L5.2197,1.504 C2.8917,1.518 1.4997,2.958 1.4997,5.357 L1.4997,14.553 C1.4997,16.968 2.9047,18.41 5.2557,18.41 L12.9447,18.407 C15.2727,18.393 16.6647,16.951 16.6647,14.553 L16.6647,5.357 C16.6647,2.942 15.2607,1.5 12.9087,1.5 Z M12.7158,13.4737 C13.1298,13.4737 13.4658,13.8097 13.4658,14.2237 C13.4658,14.6377 13.1298,14.9737 12.7158,14.9737 L5.4958,14.9737 C5.0818,14.9737 4.7458,14.6377 4.7458,14.2237 C4.7458,13.8097 5.0818,13.4737 5.4958,13.4737 L12.7158,13.4737 Z M12.7158,9.2872 C13.1298,9.2872 13.4658,9.6232 13.4658,10.0372 C13.4658,10.4512 13.1298,10.7872 12.7158,10.7872 L5.4958,10.7872 C5.0818,10.7872 4.7458,10.4512 4.7458,10.0372 C4.7458,9.6232 5.0818,9.2872 5.4958,9.2872 L12.7158,9.2872 Z M8.2505,5.1104 C8.6645,5.1104 9.0005,5.4464 9.0005,5.8604 C9.0005,6.2744 8.6645,6.6104 8.2505,6.6104 L5.4955,6.6104 C5.0815,6.6104 4.7455,6.2744 4.7455,5.8604 C4.7455,5.4464 5.0815,5.1104 5.4955,5.1104 L8.2505,5.1104 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Invoice</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('view kasbon'))
            <li class="nav-item">
                <a href="{{route('kasbon.index')}}">
                    <span class="icon">
                        <svg id="Wallet" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Wallet" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Wallet" transform="translate(2.000000, 3.000000)" fill="currentColor">
                                    <path
                                        d="M14.6416,3.55271368e-15 C17.9486,3.55271368e-15 20.6386,2.69 20.6386,5.998 L20.6386,13.175 C20.6386,16.482 17.9486,19.173 14.6416,19.173 L5.9976,19.173 C2.6906,19.173 -0.0004,16.482 -0.0004,13.175 L-0.0004,5.998 C-0.0004,2.69 2.6906,3.55271368e-15 5.9976,3.55271368e-15 L14.6416,3.55271368e-15 Z M14.6416,1.5 L5.9976,1.5 C3.5176,1.5 1.4996,3.518 1.4996,5.998 L1.4996,13.175 C1.4996,15.655 3.5176,17.673 5.9976,17.673 L14.6416,17.673 C17.1216,17.673 19.1386,15.655 19.1386,13.175 L19.1386,12.895 L15.8407,12.8956 C13.9437,12.8956 12.3997,11.3526 12.3987,9.4566 C12.3987,7.5586 13.9427,6.0146 15.8407,6.0136 L19.1386,6.013 L19.1386,5.998 C19.1386,3.518 17.1216,1.5 14.6416,1.5 Z M19.1386,7.513 L15.8407,7.5136 C14.7697,7.5146 13.8987,8.3856 13.8987,9.4556 C13.8987,10.5246 14.7707,11.3956 15.8407,11.3956 L19.1386,11.395 L19.1386,7.513 Z M16.2983,8.6436 C16.7123,8.6436 17.0483,8.9796 17.0483,9.3936 C17.0483,9.8076 16.7123,10.1436 16.2983,10.1436 L15.9863,10.1436 C15.5723,10.1436 15.2363,9.8076 15.2363,9.3936 C15.2363,8.9796 15.5723,8.6436 15.9863,8.6436 L16.2983,8.6436 Z M10.6846,4.5381 C11.0986,4.5381 11.4346,4.8741 11.4346,5.2881 C11.4346,5.7021 11.0986,6.0381 10.6846,6.0381 L5.2856,6.0381 C4.8716,6.0381 4.5356,5.7021 4.5356,5.2881 C4.5356,4.8741 4.8716,4.5381 5.2856,4.5381 L10.6846,4.5381 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Kasbon</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('view manage user'))
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_15"
                    aria-controls="ddmenu_15" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg id="Folder" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Iconly/Light-Outline/Folder" stroke="none" stroke-width="1.5" fill="none"
                                fill-rule="evenodd">
                                <g id="Folder" transform="translate(2.000000, 2.000000)" fill="currentColor">
                                    <path
                                        d="M7.6426,9.59232693e-14 C8.5936,0.001 9.4996,0.455 10.0676,1.214 L10.9786,2.426 C11.2676,2.81 11.7266,3.039 12.2066,3.04 L15.0356,3.04 C18.8976,3.04 20.6966,5.019 20.6966,9.268 L20.6686,14.235 C20.6676,18.203 18.2016,20.669 14.2316,20.669 L6.4496,20.669 C2.4716,20.669 -0.0004,18.202 -0.0004,14.232 L-0.0004,6.433 C-0.0004,2.164 1.8986,9.59232693e-14 5.6426,9.59232693e-14 L7.6426,9.59232693e-14 Z M7.6416,1.5 L5.6426,1.5 C2.7386,1.5 1.4996,2.976 1.4996,6.433 L1.4996,14.232 C1.4996,17.416 3.2576,19.169 6.4496,19.169 L14.2316,19.169 C17.4156,19.169 19.1686,17.416 19.1686,14.232 L19.1686,14.229 L19.1966,9.264 C19.1966,5.865 18.0306,4.54 15.0356,4.54 L12.2056,4.54 C11.2566,4.539 10.3506,4.086 9.7806,3.328 L8.8676,2.114 C8.5806,1.729 8.1216,1.501 7.6416,1.5 Z M14.7158,12.2128 C15.1298,12.2128 15.4658,12.5488 15.4658,12.9628 C15.4658,13.3768 15.1298,13.7128 14.7158,13.7128 L5.9808,13.7128 C5.5668,13.7128 5.2308,13.3768 5.2308,12.9628 C5.2308,12.5488 5.5668,12.2128 5.9808,12.2128 L14.7158,12.2128 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text">Kelola User</span>
                </a>
                <ul id="ddmenu_15" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('user.index') }}">User</a>
                    </li>
                    <li>
                        <a href="{{ route('roles.index') }}">Role & Permission</a>
                    </li>
                </ul>
            </li>
            @endif
            <!-- <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_wig"
                    aria-controls="ddmenu_wig" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13401 2 5 5.13401 5 9C5 10.073 5.33828 11.0548 5.95283 11.8553L4.28699 13.4334C3.5971 14.1306 3.2068 15.0586 3.2068 16.0374V20.7795H8.31867V16.6184H15.6813V20.7795H20.7932V16.0374C20.7932 15.0586 20.4029 14.1306 19.713 13.4334L18.0472 11.8553C18.6617 11.0548 19 10.073 19 9C19 5.13401 15.866 2 12 2ZM12 4C15.3137 4 18 6.68629 18 10C18 10.8974 17.7033 11.744 17.1762 12.3624L12.8238 6.63757C12.2967 5.91915 11.7003 5.38254 11 5.1218V4.12749L12 4ZM12 14H10V16H12V14ZM12 10H10V12H12V10Z" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="text">WIG</span>
                </a>
                <ul id="ddmenu_wig" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('wigcheckins.index') }}">Checkin</a>
                    </li>
                    <li>
                        <a href="">Invoice</a>
                    </li>
                </ul>
            </li> -->

            <!-- <li class="nav-item">
                <a href="{{ route('invoices.index') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 2H7C6.44772 2 6 2.44772 6 3V21C6 21.5523 6.44772 22 7 22H21C21.5523 22 22 21.5523 22 21V3C22 2.44772 21.5523 2 21 2ZM18 4V6H10V4H18ZM18 8V10H10V8H18ZM18 12V14H10V12H18ZM9 19H8V15H9V19Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <span class="text">Invoice</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('checkins.index') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.33-8 4v1h16v-1c0-2.67-5.33-4-8-4zm0-10c1.85 0 3.5.62 4.9 1.67-.41.33-.74.73-1.1 1.1C15.5 6.62 13.85 6 12 6c-1.85 0-3.5.62-4.9 1.67-.41-.33-.74-.73-1.1-1.1C8.5 6.62 10.15 6 12 6zM4 16c0-1.76 3.17-3.34 8-3.34S20 14.24 20 16v1H4v-1z" />
                        </svg>
                    </span>
                    <span class="text">Checkin Group</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('checkins.index') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM10 17.27l-5.27-5.27 1.41-1.41L10 14.46l8.87-8.87 1.41 1.41L10 17.27z" />
                        </svg>
                    </span>
                    <span class="text">Checkin WIG</span>
                </a>
            </li> -->
            {{-- <span class="divider">
                <hr />
            </span> --}}

            {{-- <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_55"
                    aria-controls="ddmenu_55" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.48663 1.1466C5.77383 0.955131 6.16188 1.03274 6.35335 1.31994L6.87852 2.10769C7.20508 2.59755 7.20508 3.23571 6.87852 3.72556L6.35335 4.51331C6.16188 4.80052 5.77383 4.87813 5.48663 4.68666C5.19943 4.49519 5.12182 4.10715 5.31328 3.81994L5.83845 3.03219C5.88511 2.96221 5.88511 2.87105 5.83845 2.80106L5.31328 2.01331C5.12182 1.72611 5.19943 1.33806 5.48663 1.1466Z" />
                            <path
                                d="M2.49999 5.83331C2.03976 5.83331 1.66666 6.2064 1.66666 6.66665V10.8333C1.66666 13.5948 3.90523 15.8333 6.66666 15.8333H9.99999C12.1856 15.8333 14.0436 14.431 14.7235 12.4772C14.8134 12.4922 14.9058 12.5 15 12.5H16.6667C17.5872 12.5 18.3333 11.7538 18.3333 10.8333V8.33331C18.3333 7.41284 17.5872 6.66665 16.6667 6.66665H15C15 6.2064 14.6269 5.83331 14.1667 5.83331H2.49999ZM14.9829 11.2496C14.9942 11.1123 15 10.9735 15 10.8333V7.91665H16.6667C16.8967 7.91665 17.0833 8.10319 17.0833 8.33331V10.8333C17.0833 11.0634 16.8967 11.25 16.6667 11.25H15L14.9898 11.2498L14.9829 11.2496Z" />
                            <path
                                d="M8.85332 1.31994C8.6619 1.03274 8.27383 0.955131 7.98663 1.1466C7.69943 1.33806 7.62182 1.72611 7.81328 2.01331L8.33848 2.80106C8.38507 2.87105 8.38507 2.96221 8.33848 3.03219L7.81328 3.81994C7.62182 4.10715 7.69943 4.49519 7.98663 4.68666C8.27383 4.87813 8.6619 4.80052 8.85332 4.51331L9.37848 3.72556C9.70507 3.23571 9.70507 2.59755 9.37848 2.10769L8.85332 1.31994Z" />
                            <path
                                d="M10.4867 1.1466C10.7738 0.955131 11.1619 1.03274 11.3533 1.31994L11.8785 2.10769C12.2051 2.59755 12.2051 3.23571 11.8785 3.72556L11.3533 4.51331C11.1619 4.80052 10.7738 4.87813 10.4867 4.68666C10.1994 4.49519 10.1218 4.10715 10.3133 3.81994L10.8385 3.03219C10.8851 2.96221 10.8851 2.87105 10.8385 2.80106L10.3133 2.01331C10.1218 1.72611 10.1994 1.33806 10.4867 1.1466Z" />
                            <path
                                d="M2.49999 16.6667C2.03976 16.6667 1.66666 17.0398 1.66666 17.5C1.66666 17.9602 2.03976 18.3334 2.49999 18.3334H14.1667C14.6269 18.3334 15 17.9602 15 17.5C15 17.0398 14.6269 16.6667 14.1667 16.6667H2.49999Z" />
                        </svg>
                    </span>
                    <span class="text">Icons</span>
                </a>
                <ul id="ddmenu_55" class="collapse dropdown-nav">
                    <li>
                        <a href="icons.html"> LineIcons </a>
                    </li>
                    <li>
                        <a href="mdi-icons.html"> MDI Icons </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_5"
                    aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.16666 3.33335C4.16666 2.41288 4.91285 1.66669 5.83332 1.66669H14.1667C15.0872 1.66669 15.8333 2.41288 15.8333 3.33335V16.6667C15.8333 17.5872 15.0872 18.3334 14.1667 18.3334H5.83332C4.91285 18.3334 4.16666 17.5872 4.16666 16.6667V3.33335ZM6.04166 5.00002C6.04166 5.3452 6.32148 5.62502 6.66666 5.62502H13.3333C13.6785 5.62502 13.9583 5.3452 13.9583 5.00002C13.9583 4.65485 13.6785 4.37502 13.3333 4.37502H6.66666C6.32148 4.37502 6.04166 4.65485 6.04166 5.00002ZM6.66666 6.87502C6.32148 6.87502 6.04166 7.15485 6.04166 7.50002C6.04166 7.8452 6.32148 8.12502 6.66666 8.12502H13.3333C13.6785 8.12502 13.9583 7.8452 13.9583 7.50002C13.9583 7.15485 13.6785 6.87502 13.3333 6.87502H6.66666ZM6.04166 10C6.04166 10.3452 6.32148 10.625 6.66666 10.625H9.99999C10.3452 10.625 10.625 10.3452 10.625 10C10.625 9.65485 10.3452 9.37502 9.99999 9.37502H6.66666C6.32148 9.37502 6.04166 9.65485 6.04166 10ZM9.99999 16.6667C10.9205 16.6667 11.6667 15.9205 11.6667 15C11.6667 14.0795 10.9205 13.3334 9.99999 13.3334C9.07949 13.3334 8.33332 14.0795 8.33332 15C8.33332 15.9205 9.07949 16.6667 9.99999 16.6667Z" />
                        </svg>
                    </span>
                    <span class="text"> Forms </span>
                </a>
                <ul id="ddmenu_5" class="collapse dropdown-nav">
                    <li>
                        <a href="form-elements.html"> From Elements </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="tables.html">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.66666 4.16667C1.66666 3.24619 2.41285 2.5 3.33332 2.5H16.6667C17.5872 2.5 18.3333 3.24619 18.3333 4.16667V9.16667C18.3333 10.0872 17.5872 10.8333 16.6667 10.8333H3.33332C2.41285 10.8333 1.66666 10.0872 1.66666 9.16667V4.16667Z" />
                            <path
                                d="M1.875 13.75C1.875 13.4048 2.15483 13.125 2.5 13.125H17.5C17.8452 13.125 18.125 13.4048 18.125 13.75C18.125 14.0952 17.8452 14.375 17.5 14.375H2.5C2.15483 14.375 1.875 14.0952 1.875 13.75Z" />
                            <path
                                d="M2.5 16.875C2.15483 16.875 1.875 17.1548 1.875 17.5C1.875 17.8452 2.15483 18.125 2.5 18.125H17.5C17.8452 18.125 18.125 17.8452 18.125 17.5C18.125 17.1548 17.8452 16.875 17.5 16.875H2.5Z" />
                        </svg>
                    </span>
                    <span class="text">Tables</span>
                </a>
            </li> --}}
            {{-- <span class="divider">
                <hr />
            </span>

            <li class="nav-item">
                <a href="notification.html">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.8333 2.50008C10.8333 2.03984 10.4602 1.66675 9.99999 1.66675C9.53975 1.66675 9.16666 2.03984 9.16666 2.50008C9.16666 2.96032 9.53975 3.33341 9.99999 3.33341C10.4602 3.33341 10.8333 2.96032 10.8333 2.50008Z" />
                            <path
                                d="M17.5 5.41673C17.5 7.02756 16.1942 8.33339 14.5833 8.33339C12.9725 8.33339 11.6667 7.02756 11.6667 5.41673C11.6667 3.80589 12.9725 2.50006 14.5833 2.50006C16.1942 2.50006 17.5 3.80589 17.5 5.41673Z" />
                            <path
                                d="M11.4272 2.69637C10.9734 2.56848 10.4947 2.50006 10 2.50006C7.10054 2.50006 4.75003 4.85057 4.75003 7.75006V9.20873C4.75003 9.72814 4.62082 10.2393 4.37404 10.6963L3.36705 12.5611C2.89938 13.4272 3.26806 14.5081 4.16749 14.9078C7.88074 16.5581 12.1193 16.5581 15.8326 14.9078C16.732 14.5081 17.1007 13.4272 16.633 12.5611L15.626 10.6963C15.43 10.3333 15.3081 9.93606 15.2663 9.52773C15.0441 9.56431 14.8159 9.58339 14.5833 9.58339C12.2822 9.58339 10.4167 7.71791 10.4167 5.41673C10.4167 4.37705 10.7975 3.42631 11.4272 2.69637Z" />
                            <path
                                d="M7.48901 17.1925C8.10004 17.8918 8.99841 18.3335 10 18.3335C11.0016 18.3335 11.9 17.8918 12.511 17.1925C10.8482 17.4634 9.15183 17.4634 7.48901 17.1925Z" />
                        </svg>
                    </span>
                    <span class="text">Notifications</span>
                </a>
            </li> --}}

        </ul>
    </nav>
</aside>