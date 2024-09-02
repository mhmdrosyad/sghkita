<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('dashboard') }}">
            {{-- <img src="assets/images/logo/logo.svg" alt="logo" /> --}}
            <h3>{{ config('app.name') }}</h3>
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            @if(auth()->user()->can('view dashboard'))
            <li class="nav-item">
                <a href="{{route('dashboard')}}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.74999 18.3333C12.2376 18.3333 15.1364 15.8128 15.7244 12.4941C15.8448 11.8143 15.2737 11.25 14.5833 11.25H9.99999C9.30966 11.25 8.74999 10.6903 8.74999 10V5.41666C8.74999 4.7263 8.18563 4.15512 7.50586 4.27556C4.18711 4.86357 1.66666 7.76243 1.66666 11.25C1.66666 15.162 4.83797 18.3333 8.74999 18.3333Z" />
                            <path
                                d="M17.0833 10C17.7737 10 18.3432 9.43708 18.2408 8.75433C17.7005 5.14918 14.8508 2.29947 11.2457 1.75912C10.5629 1.6568 10 2.2263 10 2.91665V9.16666C10 9.62691 10.3731 10 10.8333 10H17.0833Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @endif
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_2"
                    aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.8097 1.66667C11.8315 1.66667 11.8533 1.6671 11.875 1.66796V4.16667C11.875 5.43232 12.901 6.45834 14.1667 6.45834H16.6654C16.6663 6.48007 16.6667 6.50186 16.6667 6.5237V16.6667C16.6667 17.5872 15.9205 18.3333 15 18.3333H5.00001C4.07954 18.3333 3.33334 17.5872 3.33334 16.6667V3.33334C3.33334 2.41286 4.07954 1.66667 5.00001 1.66667H11.8097ZM6.66668 7.70834C6.3215 7.70834 6.04168 7.98816 6.04168 8.33334C6.04168 8.67851 6.3215 8.95834 6.66668 8.95834H10C10.3452 8.95834 10.625 8.67851 10.625 8.33334C10.625 7.98816 10.3452 7.70834 10 7.70834H6.66668ZM6.04168 11.6667C6.04168 12.0118 6.3215 12.2917 6.66668 12.2917H13.3333C13.6785 12.2917 13.9583 12.0118 13.9583 11.6667C13.9583 11.3215 13.6785 11.0417 13.3333 11.0417H6.66668C6.3215 11.0417 6.04168 11.3215 6.04168 11.6667ZM6.66668 14.375C6.3215 14.375 6.04168 14.6548 6.04168 15C6.04168 15.3452 6.3215 15.625 6.66668 15.625H13.3333C13.6785 15.625 13.9583 15.3452 13.9583 15C13.9583 14.6548 13.6785 14.375 13.3333 14.375H6.66668Z" />
                            <path
                                d="M13.125 2.29167L16.0417 5.20834H14.1667C13.5913 5.20834 13.125 4.74197 13.125 4.16667V2.29167Z" />
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
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_4"
                    aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.66666 5.41669C1.66666 3.34562 3.34559 1.66669 5.41666 1.66669C7.48772 1.66669 9.16666 3.34562 9.16666 5.41669C9.16666 7.48775 7.48772 9.16669 5.41666 9.16669C3.34559 9.16669 1.66666 7.48775 1.66666 5.41669Z" />
                            <path
                                d="M1.66666 14.5834C1.66666 12.5123 3.34559 10.8334 5.41666 10.8334C7.48772 10.8334 9.16666 12.5123 9.16666 14.5834C9.16666 16.6545 7.48772 18.3334 5.41666 18.3334C3.34559 18.3334 1.66666 16.6545 1.66666 14.5834Z" />
                            <path
                                d="M10.8333 5.41669C10.8333 3.34562 12.5123 1.66669 14.5833 1.66669C16.6544 1.66669 18.3333 3.34562 18.3333 5.41669C18.3333 7.48775 16.6544 9.16669 14.5833 9.16669C12.5123 9.16669 10.8333 7.48775 10.8333 5.41669Z" />
                            <path
                                d="M10.8333 14.5834C10.8333 12.5123 12.5123 10.8334 14.5833 10.8334C16.6544 10.8334 18.3333 12.5123 18.3333 14.5834C18.3333 16.6545 16.6544 18.3334 14.5833 18.3334C12.5123 18.3334 10.8333 16.6545 10.8333 14.5834Z" />
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

                </ul>
            </li>
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_5"
                    aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <!-- Ikon kalender baru -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M16 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M21 8V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 14H8.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M12 14H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M16 14H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8 18H8.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M12 18H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M16 18H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">Booking Group</span>
                </a>
                <ul id="ddmenu_5" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('reservations.index') }}">Reservation</a>
                    </li>
                    <li>
                        <a href="{{ route('customer.index') }}">Customer</a>
                    </li>
                    <li>
                        <a href="{{ route('sales.index') }}">Sales</a>
                    </li>
                    <li>
                        <a href="{{ route('res_category.index') }}">Jenis Reservasi</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('checkins.index') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M3 5C3 4.44772 3.44772 4 4 4H20C20.5523 4 21 4.44772 21 5V19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19V5ZM4 6V19H20V6H4ZM16.7071 9.29289C16.3166 8.90237 15.6834 8.90237 15.2929 9.29289L11 13.5858L10.2071 12.7929C9.81658 12.4024 9.18342 12.4024 8.79289 12.7929C8.40237 13.1834 8.40237 13.8166 8.79289 14.2071L10.7929 16.2071C11.1834 16.5976 11.8166 16.5976 12.2071 16.2071L17.2071 11.2071C17.5976 10.8166 17.5976 10.1834 17.2071 9.29289C16.9024 8.90237 16.3166 8.90237 15.7071 9.29289L16.7071 9.29289Z" />
                        </svg>
                    </span>
                    <span class="text">Checkin</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('invoices.index') }}">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M19 6.41L18.59 6 13 11.59V16h4.41l5.59-5.59L19 6.41zM11.59 10L9 12.59V14h1.41L14 10.41 11.59 10zM3 21h18v-2H3v2zm0-16V3h8V1H1v18h2V5z" />
                        </svg>
                    </span>
                    <span class="text">Invoice</span>
                </a>
            </li>

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

            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_3"
                    aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.9211 10.1294C15.1652 9.88534 15.1652 9.48967 14.9211 9.24559L10.7544 5.0789C10.5103 4.83482 10.1147 4.83482 9.87057 5.0789C9.62649 5.32297 9.62649 5.71871 9.87057 5.96278L12.9702 9.06251H1.97916C1.63398 9.06251 1.35416 9.34234 1.35416 9.68751C1.35416 10.0327 1.63398 10.3125 1.97916 10.3125H12.9702L9.87057 13.4123C9.62649 13.6563 9.62649 14.052 9.87057 14.2961C10.1147 14.5402 10.5103 14.5402 10.7544 14.2961L14.9211 10.1294Z" />
                            <path
                                d="M11.6383 15.18L15.805 11.0133C16.5373 10.2811 16.5373 9.09391 15.805 8.36166L11.6383 4.195C11.2722 3.82888 10.7923 3.64582 10.3125 3.64582V3.02082C10.3125 2.10035 11.0587 1.35416 11.9792 1.35416H16.9792C17.8997 1.35416 18.6458 2.10035 18.6458 3.02082V16.3542C18.6458 17.2747 17.8997 18.0208 16.9792 18.0208H11.9792C11.0587 18.0208 10.3125 17.2747 10.3125 16.3542V15.7292C10.7923 15.7292 11.2722 15.5461 11.6383 15.18Z" />
                        </svg>
                    </span>
                    <span class="text">Akun</span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav">
                    <li>
                        <a href="{{route('account.index')}}">Akun </a>
                    </li>
                    <li>
                        <a href="{{route('category.index')}}">Jenis Transaksi </a>
                    </li>
                </ul>
            </li>
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