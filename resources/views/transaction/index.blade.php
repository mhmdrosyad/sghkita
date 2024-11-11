<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div>
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Transaksi @isset($account) {{ $account->name }} @endisset
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('import transaction'))
                        <button type="button" class="main-btn success-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#importModal"><svg id="Upload" width="24" height="24" viewBox="0 0 26 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.1208 15C11.7066 15 11.3708 14.6642 11.3708 14.25V2.209C11.3708 1.79479 11.7066 1.459 12.1208 1.459C12.5351 1.459 12.8708 1.79479 12.8708 2.209V14.25C12.8708 14.6642 12.5351 15 12.1208 15Z"
                                    fill="#ffffff" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.67559 5.66713C8.3821 5.37484 8.38112 4.89997 8.67342 4.60647L11.5894 1.67847C11.7302 1.53715 11.9214 1.45771 12.1208 1.45771C12.3203 1.45771 12.5115 1.53715 12.6523 1.67847L15.5683 4.60647C15.8605 4.89997 15.8596 5.37484 15.5661 5.66713C15.2726 5.95942 14.7977 5.95845 14.5054 5.66495L12.1208 3.27056L9.73625 5.66495C9.44396 5.95845 8.96909 5.95942 8.67559 5.66713Z"
                                    fill="#ffffff" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.45009 9.71174C5.02564 8.93503 5.96655 8.54673 7.69884 8.38705C8.11131 8.34903 8.41485 7.98384 8.37683 7.57137C8.33881 7.15891 7.97362 6.85536 7.56116 6.89338C5.71345 7.0637 4.21436 7.51041 3.24491 8.81869C2.31546 10.073 2 11.9628 2 14.6402C2 18.19 2.55654 20.3726 4.37994 21.4927C5.249 22.0265 6.3253 22.2624 7.55739 22.377C8.78465 22.4912 10.259 22.4912 11.9684 22.4912H12.0316C13.741 22.4912 15.2154 22.4912 16.4426 22.377C17.6747 22.2624 18.751 22.0265 19.6201 21.4927C21.4435 20.3726 22 18.19 22 14.6402C22 11.9628 21.6845 10.073 20.7551 8.81869C19.7856 7.51041 18.2866 7.0637 16.4388 6.89338C16.0264 6.85536 15.6612 7.15891 15.6232 7.57137C15.5851 7.98384 15.8887 8.34903 16.3012 8.38705C18.0334 8.54673 18.9744 8.93503 19.5499 9.71174C20.1655 10.5424 20.5 11.9876 20.5 14.6402C20.5 18.1914 19.9015 19.5593 18.8349 20.2145C18.259 20.5683 17.4565 20.7762 16.3036 20.8835C15.1535 20.9905 13.7472 20.9912 12 20.9912C10.2528 20.9912 8.84654 20.9905 7.69636 20.8835C6.54345 20.7762 5.741 20.5683 5.16506 20.2145C4.09846 19.5593 3.5 18.1914 3.5 14.6402C3.5 11.9876 3.83454 10.5424 4.45009 9.71174Z"
                                    fill="#ffffff" />
                            </svg></button>
                        @endif
                        {{-- <button type="button" class="main-btn bg-black text-white btn-hover" data-bs-toggle="modal"
                            data-bs-target="#mutationModal">
                            <svg id="Swap" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Iconly/Light-Outline/Swap" stroke="none" stroke-width="1.5" fill="none"
                                    fill-rule="evenodd">
                                    <g id="Swap" transform="translate(2.000000, 3.000000)" fill="currentColor"
                                        fill-rule="nonzero">
                                        <path
                                            d="M14.8395556,2.79644444 C15.2192513,2.79644444 15.5330465,3.07859833 15.5827089,3.44467389 L15.5895556,3.54644444 L15.5894444,15.3464726 L18.3856681,12.5390079 C18.6778838,12.2454387 19.1527562,12.2443414 19.4463254,12.536557 C19.7132066,12.8022076 19.7383753,13.2188142 19.5211999,13.5129283 L19.4487763,13.5972143 L15.3709986,17.693881 C15.3464168,17.7180211 15.3213999,17.7399418 15.2950011,17.760148 L15.3709986,17.693881 C15.3342073,17.7308427 15.2945247,17.7631658 15.2526764,17.7908505 C15.2380745,17.7999472 15.2228988,17.8092337 15.2073803,17.8179836 C15.192972,17.8266679 15.1783233,17.834288 15.1634892,17.8413922 C15.148845,17.8478739 15.1339884,17.8544143 15.118889,17.8604777 C15.0997073,17.8686809 15.0800315,17.8756262 15.0601522,17.8817269 C15.0484288,17.8848604 15.0364235,17.8882265 15.0243005,17.8912974 C15.0027008,17.8972283 14.9809959,17.9017061 14.9591656,17.905217 C14.9489509,17.9063797 14.9382341,17.9078677 14.9274475,17.9091268 C14.9028036,17.912512 14.8783824,17.914169 14.8539425,17.9146385 C14.8491144,17.9141774 14.8443402,17.9142222 14.8395556,17.9142222 L14.8249464,17.9146385 C14.8005065,17.914169 14.7760852,17.912512 14.7517766,17.9096676 L14.8395556,17.9142222 C14.7986978,17.9142222 14.758603,17.9109551 14.7195184,17.9046679 C14.697893,17.9017061 14.6761881,17.8972283 14.6546776,17.8917834 C14.6433047,17.8883828 14.6319048,17.8852023 14.6206178,17.8817627 C14.5991231,17.8757703 14.5777614,17.8682115 14.5567098,17.859657 C14.545179,17.8543529 14.5340666,17.8494986 14.5230984,17.8443867 C14.5058214,17.8370019 14.4885033,17.8281256 14.4714803,17.8185321 C14.4561316,17.8091843 14.4409972,17.7999211 14.4262289,17.7901493 C14.4146795,17.7832209 14.403311,17.775239 14.3921221,17.7669047 L14.38411,17.760148 C14.3577112,17.7399418 14.3326943,17.7180211 14.3092255,17.6945523 L14.3078903,17.693881 L10.2301126,13.5972143 C9.93789691,13.3036451 9.93899421,12.8287726 10.2325634,12.536557 C10.4994446,12.2709064 10.9161631,12.2476632 11.2092704,12.4661956 L11.2932208,12.5390079 L14.0894444,15.3484726 L14.0895556,3.54644444 C14.0895556,3.13223088 14.425342,2.79644444 14.8395556,2.79644444 Z M4.91111111,0.0828888889 L4.92572031,0.0824725917 C4.95016016,0.0829421425 4.97458142,0.0845991149 4.9988901,0.0874435089 L4.91111111,0.0828888889 C4.95196891,0.0828888889 4.99206364,0.0861560044 5.03114829,0.0924432382 C5.05252489,0.0953649609 5.07398385,0.0997808997 5.09525352,0.105141884 C5.10775881,0.108810912 5.12050889,0.112388929 5.13311678,0.116290525 C5.15281108,0.121842481 5.17186863,0.128591039 5.19068227,0.136132446 C5.20428775,0.142189126 5.21806041,0.148208961 5.23161013,0.154622861 C5.2477162,0.161586715 5.26357535,0.169781296 5.27918633,0.178579019 C5.29255463,0.186809701 5.30579023,0.194827845 5.31874994,0.203235228 C5.33208412,0.211163902 5.34543761,0.220443425 5.35854453,0.23020638 L5.44277634,0.303230107 L9.52055411,4.39989677 C9.81276976,4.693466 9.81167246,5.16833847 9.51810323,5.46055411 C9.25122211,5.7262047 8.8345036,5.74944789 8.54139629,5.53091556 L8.45744589,5.45810323 L5.66044443,2.64747259 L5.66111111,14.4506667 C5.66111111,14.8648802 5.32532467,15.2006667 4.91111111,15.2006667 C4.53141535,15.2006667 4.21762015,14.9185128 4.16795773,14.5524372 L4.16111111,14.4506667 L4.16044443,2.64847259 L1.36499856,5.45810323 C1.09934797,5.72498435 0.682741336,5.75015312 0.388627226,5.5329777 L0.304341218,5.46055411 C0.0374600991,5.19490353 0.0122913202,4.77829689 0.229466745,4.48418278 L0.301890331,4.39989677 L4.37966811,0.303230107 L4.42382941,0.262733147 C4.43420037,0.253861239 4.44481627,0.245267362 4.45566556,0.236963061 L4.37966811,0.303230107 C4.41645933,0.26626846 4.45614195,0.23394528 4.49799027,0.206260568 C4.51259217,0.197163935 4.52776785,0.18787746 4.54328632,0.179127548 C4.55769462,0.170443182 4.57234336,0.162823149 4.58717742,0.155718919 C4.60182165,0.149237168 4.61667823,0.142696806 4.63177771,0.136633386 C4.6509594,0.128430202 4.67063512,0.121484924 4.69051448,0.11538422 C4.70261061,0.112136116 4.71499668,0.10867364 4.72750764,0.105525481 C4.74765636,0.0999915861 4.76802381,0.0957608899 4.78850453,0.0923821975 C4.80082097,0.0908416564 4.8128924,0.089161741 4.82505216,0.087772622 C4.84820393,0.0845920569 4.87195476,0.0829806414 4.89572437,0.0824924621 C4.9009706,0.0829393182 4.90603496,0.0828888889 4.91111111,0.0828888889 Z"
                                            id="Combined-Shape"></path>
                                    </g>
                                </g>
                            </svg></i>Mutasi</button> --}}
                        @if((auth()->user()->can('add fo transaction') && request('account') == 101) ||
                        (auth()->user()->can('add bank transaction') && request('account') != 101))
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal">
                            <svg id="Paper Download" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Iconly/Light-Outline/Paper-Download" stroke="none" stroke-width="1.5" fill="none"
                                    fill-rule="evenodd">
                                    <g id="Paper-Download" transform="translate(3.000000, 2.000000)" fill="#ffffff">
                                        <path
                                            d="M10.9759,0.0003 C11.0189361,0.0003 11.0611293,0.00393081447 11.1021898,0.0109026311 L11.2373,0.0117 C11.4413,0.0117 11.6363,0.0947 11.7783,0.2417 L16.8443,5.5187 C16.9773,5.6577 17.0523975,5.8447 17.0523975,6.0377 L17.0523975,15.2277 C17.0683,17.7367 15.1123,19.7757 12.5993,19.8657 L4.4593,19.8657 C2.01907143,19.8132429 0.0620036735,17.8413539 0.00166566764,15.4259384 L0.0013,4.4907 C0.0603,2.0097 2.1083,0.0117 4.5703,0.0117 L10.8496102,0.0109026311 C10.8906707,0.00393081447 10.9328639,0.0003 10.9759,0.0003 Z M10.2253,1.5113 L4.5733,1.5117 C2.9163,1.5117 1.5403,2.8537 1.5013,4.5087 L1.5013,15.2277 C1.4653,16.9287 2.8053,18.3287 4.4903,18.3657 L12.5733,18.3657 C14.2423,18.3057 15.5633,16.9287 15.5523682,15.2327 L15.5523,6.9833 L13.5439,6.9843 C11.7129,6.9793 10.2259,5.4873 10.2259,3.6593 L10.2253,1.5113 Z M8.1427,7.1592 C8.5567,7.1592 8.8927,7.4952 8.8927,7.9092 L8.8923,12.1313 L9.9547,11.0652 C10.2467,10.7712 10.7217,10.7712 11.0157,11.0632 C11.3087,11.3552 11.3097,11.8302 11.0177,12.1242 L8.69868485,14.4534107 C8.63986655,14.5183509 8.56983878,14.572952 8.49166525,14.6141503 C8.48469429,14.6163108 8.47837822,14.6195223 8.47201882,14.6226425 C8.44292729,14.63842 8.41217241,14.6510784 8.38047683,14.6616767 C8.37737971,14.6612876 8.3743521,14.6622811 8.37131793,14.6632554 C8.29932117,14.6877294 8.22245806,14.7002 8.1427,14.7002 C8.06516774,14.7002 7.99037112,14.6884157 7.92000474,14.6665417 C7.90894836,14.66235 7.89716364,14.6584007 7.88548731,14.6541617 C7.86364857,14.6468807 7.84271825,14.6381034 7.82229373,14.6284305 C7.81008812,14.6221419 7.79806643,14.6160807 7.78621136,14.6096938 C7.7625033,14.5973032 7.73927243,14.583035 7.71692024,14.5675846 C7.70928341,14.5620458 7.70171439,14.556612 7.69424304,14.5510303 C7.662043,14.5272038 7.63189764,14.5006625 7.6040333,14.4718985 L5.2657,12.1242 C4.9737,11.8302 4.9747,11.3552 5.2677,11.0632 C5.5617,10.7712 6.0367,10.7712 6.3287,11.0652 L7.3923,12.1333 L7.3927,7.9092 C7.3927,7.4952 7.7287,7.1592 8.1427,7.1592 Z M11.7253,2.3523 L11.7259,3.6593 C11.7259,4.6633 12.5419,5.4813 13.5459,5.4843 L14.7303,5.4833 L11.7253,2.3523 Z"
                                            id="Combined-Shape"></path>
                                    </g>
                                </g>
                            </svg>Transaksi Masuk
                        </button>
                        <button type="button" class="main-btn warning-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModalOut">
                            <svg id="Paper Upload" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Iconly/Light/Paper-Upload" stroke="none" stroke-width="1.5" fill="none"
                                    fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                                    <g id="Paper-Upload" transform="translate(3.500000, 2.000000)" stroke="#ffffff"
                                        stroke-width="1.5">
                                        <path
                                            d="M11.2366,0.761771154 L4.5846,0.761771154 C2.5046,0.7538 0.8006,2.4108 0.7506,4.4908 L0.7506,15.2278 C0.7056,17.3298 2.3736,19.0698 4.4746,19.1148 C4.5116,19.1148 4.5486,19.1158 4.5846,19.1148 L12.5726,19.1148 C14.6626,19.0408 16.3146,17.3188 16.302665,15.2278 L16.302665,6.0378 L11.2366,0.761771154 Z"
                                            id="Stroke-1"></path>
                                        <path
                                            d="M10.9749,0.7501 L10.9749,3.6591 C10.9749,5.0791 12.1239,6.2301 13.5439,6.2341 L16.2979,6.2341"
                                            id="Stroke-3"></path>
                                        <line x1="8.1409" y1="7.9088" x2="8.1409" y2="13.9498" id="Stroke-5"></line>
                                        <polyline id="Stroke-7" points="10.4866 10.2643 8.1416 7.9093 5.7966 10.2643">
                                        </polyline>
                                    </g>
                                </g>
                            </svg>Transaksi Keluar
                        </button>
                        {{-- <form action="{{ route('balance.current.month') }}" method="POST">
                            @csrf
                            <button class="main-btn warning-btn btn-hover" type="submit" class="btn btn-primary">
                                Balance Saldo Bulan Ini
                            </button>
                        </form> --}}
                        @endif
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box success-alert" role="alert">
                    <div class=" alert">
                        <p class="text-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @endif
                <div class="row mt-5">
                    <form action="{{ route('transaction.index') }}" method="get" class="col-lg-4">
                        @isset($account)
                        <input type="hidden" name="account" value="{{ $account->code }}">
                        @endisset
                        <div class="d-flex gap-3 align-items-center">
                            <div class="col-lg-8">
                                <div class="input-style-1">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="start_date" value="{{ $startDateFormatted }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="input-style-1">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="end_date" value="{{ $endDateFormatted }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="main-btn primary-btn btn-hover">
                                    <svg id="Filter 2" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="Iconly/Light-Outline/Filter-2" stroke="none" stroke-width="1.5"
                                            fill="none" fill-rule="evenodd">
                                            <g id="Filter-2" transform="translate(2.000000, 2.000000)" fill="#ffffff">
                                                <path
                                                    d="M6.7734,9.5987 C6.7914,9.6147 6.8084,9.6297 6.8254,9.6477 C7.9044,10.7537 8.4994,12.2187 8.4994,13.7737 L8.4994,17.7577 L10.7354,16.5397 C10.9114,16.4437 11.0204,16.2557 11.0204,16.0487 L11.0204,13.7617 C11.0204,12.2127 11.6094,10.7527 12.6784,9.6527 L17.5154,4.5077 C17.8284,4.1747 18.0004,3.7377 18.0004,3.2767 L18.0004,2.3407 C18.0004,1.8767 17.6344,1.4997 17.1864,1.4997 L2.3154,1.4997 C1.8664,1.4997 1.5004,1.8767 1.5004,2.3407 L1.5004,3.2767 C1.5004,3.7377 1.6724,4.1747 1.9854,4.5067 L6.7734,9.5987 Z M8.1464,19.5007 C7.9444,19.5007 7.7444,19.4467 7.5624,19.3387 C7.2104,19.1287 6.9994,18.7577 6.9994,18.3457 L6.9994,13.7737 C6.9994,12.6387 6.5764,11.5697 5.8054,10.7507 C5.7824,10.7317 5.7594,10.7107 5.7394,10.6887 L0.8934,5.5357 C0.3174,4.9237 0.0004,4.1207 0.0004,3.2767 L0.0004,2.3407 C0.0004,1.0497 1.0394,-0.0003 2.3154,-0.0003 L17.1864,-0.0003 C18.4614,-0.0003 19.5004,1.0497 19.5004,2.3407 L19.5004,3.2767 C19.5004,4.1197 19.1834,4.9217 18.6094,5.5347 L13.7624,10.6887 C12.9594,11.5167 12.5204,12.6057 12.5204,13.7617 L12.5204,16.0487 C12.5204,16.8047 12.1114,17.4967 11.4534,17.8567 L8.6924,19.3607 C8.5204,19.4537 8.3334,19.5007 8.1464,19.5007 L8.1464,19.5007 Z"
                                                    id="Fill-1"></path>
                                            </g>
                                        </g>
                                    </svg>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-wrapper table-responsive border p-3">
                    <table id="ledgerTable" class="table striped-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Waktu</th>
                                <th>Uraian</th>
                                <th>Jenis Transaksi</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
                                <th>Fo</th>
                                @if(auth()->user()->can('edit transaction'))
                                <th>Aksi</th>
                                @endif
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 fw-semibold d-flex gap-3">
                    <div>Saldo Awal: <span class="bg-primary text-white px-2">{{number_format($startingBalance, 0, ',',
                            '.')}}</span>
                    </div>
                    <div>Saldo Akhir: <span class="bg-danger text-white px-2">{{number_format($totalBalance, 0, ',',
                            '.')}}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Uang Masuk</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}">
                        @csrf
                        @isset($account)
                        <input name="account_code" type="hidden" value="{{$account->code}}" />
                        @endisset
                        @if(auth()->user()->can('view accounting'))
                        <div class="input-style-1">
                            <label>Tanggal Transaksi</label>
                            <input name="tanggal" type="datetime-local" placeholder="masukkan uraian" required />
                        </div>
                        @endif
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan uraian" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input type="text" id="number-input" name="nominal" onkeyup="formatNumber(this)" />
                            {{-- <input name="nominal" type="number" autocomplete="off" required /> --}}
                        </div>
                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="category_code" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($inCategories))
                                    @foreach($inCategories as $category)
                                    @if($category->type == 'in' || $category->type == 'mutation')
                                    <option value="{{$category->code}}">{{$category->code}} - {{$category->name}}
                                    </option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModalOut" tabindex="-1" aria-labelledby="addModalOutLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Uang Keluar</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}" enctype="multipart/form-data">
                        @csrf
                        @isset($account)
                        <input name="account_code" type="hidden" value="{{$account->code}}" />
                        @endisset
                        @if(auth()->user()->can('view accounting'))
                        <div class="input-style-1">
                            <label>Tanggal Transaksi</label>
                            <input name="tanggal" type="datetime-local" placeholder="masukkan uraian" required />
                        </div>
                        @endif
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan uraian" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input type="text" id="number-input" name="nominal" onkeyup="formatNumber(this)" />
                            {{-- <input name="nominal" type="number" autocomplete="off" required /> --}}
                        </div>


                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize selectpicker" name="category_code"
                                    data-live-search="true" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($outCategories))
                                    @foreach($outCategories as $category)
                                    @if($category->type == 'out' || $category->type == 'mutation')
                                    <option data-tokens="{{$category->code}}" value="{{$category->code}}">
                                        {{$category->code}} - {{$category->name}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <label class="mb-3 fw-bold">Foto Nota</label>
                        <div class="mb-3 d-flex justify-content-center">
                            <div id="my_camera"></div>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="main-btn primary-btn btn-hover mb-3" type=button value="Take Snapshot"
                                onClick="take_snapshot()">Tangkap</button>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <div id="results"></div>
                        </div>
                        <input type="hidden" name="image" id="imageInput" required>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mutationModal" tabindex="-1" aria-labelledby="mutationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Mutasi</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}">
                        @csrf
                        @if(auth()->user()->can('view accounting'))
                        <div class="input-style-1">
                            <label>Tanggal Transaksi</label>
                            <input name="tanggal" type="datetime-local" placeholder="masukkan uraian" required />
                        </div>
                        @endif
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan nama akun" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input type="text" id="number-input" name="nominal" onkeyup="formatNumber(this)" />
                            {{-- <input name="nominal" type="number" autocomplete="off" required /> --}}
                        </div>
                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="category_code" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($mutationCategories))
                                    @foreach($mutationCategories as $category)
                                    <option value="{{$category->code}}">{{$category->code}} - {{$category->name}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Import Cash Flow</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transaction.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-style-1">
                            <label>Bulan</label>
                            <input name="periode" type="text" placeholder="MM-YYYY" required />
                        </div>
                        <div class="input-style-1">
                            <label>Upload File Ecel:</label>
                            <input name="file" type="file" required />
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Nota Transaksi</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="lni lni-cross-circle"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Note Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
        {{-- <script language="JavaScript">
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        
            function take_snapshot() {
                Webcam.snap(function(data_uri) {
                    document.getElementById('results').innerHTML = 
                        '<img src="'+data_uri+'"/>';
                    document.getElementById('imageInput').value = data_uri;
                });
            }
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var imageModal = document.getElementById('imageModal');
                imageModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var imageUrl = button.getAttribute('data-image');
                    var modalImage = imageModal.querySelector('#modalImage');
                    modalImage.src = imageUrl;
                });
            });
        </script>

        @if(auth()->user()->can('edit transaction'))
        <script>
            $(document).ready(function() {
                var table = $('#ledgerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('transaction.index') }}",
                        data: function (d) {
                            d.account = "{{ request('account') }}";
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                        }
                    },
                    
                    columns: [
                        { data: 'id', name: 'id', visible: false },
                        { data: 'entry_date', name: 'entry_date' },
                        { data: 'description', name: 'transaction.description' },
                        { data: 'category_name', name: 'transaction.category.name' },
                        { data: 'debit', name: 'debit' },
                        { data: 'credit', name: 'credit' },
                        { data: 'balance', name: 'balance' },
                        { data: 'fo', name: 'fo' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                        { data: 'view_image', name: 'view_image' },
                    ],
                    order: [[0, 'asc']]
                });

                $('#ledgerTable').on('click', '.delete-button', function() {
                    var id = $(this).data('id');
                    var url = '/transaction/delete/' + id;
                    
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Kamu tidak bisa mengembalikan data yang hilang!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tetap hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success,
                                            'success'
                                        )
                                        table.ajax.reload();
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.error,
                                            'error'
                                        )
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the account.',
                                        'error'
                                    )
                                }
                            });
                        }
                    });
                });
            });
        </script>
        @else
        <script>
            $(document).ready(function() {
                var table = $('#ledgerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('transaction.index') }}",
                        data: function (d) {
                            d.account = "{{ request('account') }}";
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                        }
                    },
                    
                    columns: [
                        { data: 'id', name: 'id', visible: false },
                        { data: 'entry_date', name: 'entry_date' },
                        { data: 'description', name: 'transaction.description' },
                        { data: 'category_name', name: 'transaction.category.name' },
                        { data: 'debit', name: 'debit' },
                        { data: 'credit', name: 'credit' },
                        { data: 'balance', name: 'balance' },
                        { data: 'fo', name: 'fo' },
                        { data: 'view_image', name: 'view_image' },
                    ],
                    order: [[0, 'asc']]
                });

                $('#ledgerTable').on('click', '.delete-button', function() {
                    var id = $(this).data('id');
                    var url = '/transaction/delete/' + id;
                    
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Kamu tidak bisa mengembalikan data yang hilang!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tetap hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success,
                                            'success'
                                        )
                                        table.ajax.reload();
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.error,
                                            'error'
                                        )
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the account.',
                                        'error'
                                    )
                                }
                            });
                        }
                    });
                });
            });
        </script>
        @endif

        <script>
            function formatNumber(input) {
                // Pertahankan tanda minus jika ada
                let value = input.value;
                let isNegative = value.startsWith('-');
                
                // Hapus semua karakter non-angka kecuali tanda minus di awal
                value = value.replace(/\D/g, '');
                
                // Format angka dengan NumberFormat
                if (isNegative) {
                    input.value = '-' + new Intl.NumberFormat('id-ID').format(value);
                } else {
                    input.value = new Intl.NumberFormat('id-ID').format(value);
                }
            }
        </script>

    </x-slot>
</x-app-layout>