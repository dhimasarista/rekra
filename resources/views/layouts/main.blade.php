<!DOCTYPE html>
<html>

<head>
    {{-- Basic Page Info --}}
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>Hantu Suara</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/vendors/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/vendors/images/favicon-16x16.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/src/plugins/switchery/switchery.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/TopLoaderService/TopLoaderService.css') }}" />

    <!-- JavaScript -->
    <script src="{{ asset('admin/src/plugins/TopLoaderService/TopLoaderService.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('admin/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/js/script.js') }}"></script>

    <!-- Socket.io -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script> --}}
    {{-- <script>
            window.socketIOUrl = "http://localhost:2002";
            const socket = io(window.socketIOUrl);
        </script> --}}

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe>
    </noscript>
</head>

<body class="sidebar-dark">
    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            {{-- <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div> --}}
            {{-- <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search Here" />
                        <div class="dropdown">
                            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
            {{-- <div class="btn-group">
                <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Rekapitulasi
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Hitung Cepat (Saksi)</a>
                    <a class="dropdown-item" href="#">Hitung Cepat (Admin)</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/">C-Hasil</a>
                </div>
            </div> --}}
        </div>

        <div class="header-right">
            {{-- <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div> --}}
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        {{-- <span class="user-icon" style="background-color: white; box-shadow: none"> --}}
                        <span class="user-icon">
                            <i class="bi bi-person"></i>
                            {{-- {{ session()->get('avatar') }} --}}
                        </span>
                        <span class="user-name d-inline">{{ session()->get('name') }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        {{-- <a class="dropdown-item" href="#"><i class="dw dw-user1"></i> Account</a>
                        <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> --}}
                        <a class="dropdown-item" href="/logout"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i
                                class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i
                                class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i
                                class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i
                                class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i
                                class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i
                                class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i
                                class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="left-side-bar">
        <div class="brand-logo pt-10">
            <a href="/">
                <h3 style="color: white">PILKADA 2024</h3>
                {{-- <svg width="709" height="98" viewBox="0 0 709 98" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_705_51)">
                <path d="M7.5 50C7.5 32.3225 7.5 23.4837 12.99 17.99C18.4875 12.5 27.3225 12.5 45 12.5C62.6775 12.5 71.5162 12.5 77.0062 17.99C82.5 23.4875 82.5 32.3225 82.5 50C82.5 67.6775 82.5 76.5162 77.0062 82.0062C71.52 87.5 62.6775 87.5 45 87.5C27.3225 87.5 18.4837 87.5 12.99 82.0062C7.5 76.52 7.5 67.6775 7.5 50Z" fill="white"/>
                <g clip-path="url(#clip1_705_51)">
                <path d="M69.375 49.1242V50.9992C69.375 54.2075 68.7417 57.3842 67.5113 60.3472C66.2809 63.3102 64.4777 66.0011 62.2051 68.2657C59.9325 70.5302 57.2352 72.3239 54.2678 73.5437C51.3005 74.7636 48.1215 75.3856 44.9133 75.3742C32.257 75.3297 21.9445 65.5164 20.7445 53.1602C20.7315 52.9992 20.7603 52.8376 20.8281 52.691C20.8959 52.5445 21.0004 52.4179 21.1315 52.3236C21.2626 52.2293 21.4158 52.1704 21.5763 52.1528C21.7368 52.1351 21.8992 52.1592 22.0477 52.2227C23.7341 52.9306 25.6052 53.0704 27.3781 52.6209C29.151 52.1715 30.7295 51.1572 31.875 49.7312C32.6255 50.6646 33.5666 51.4271 34.6353 51.9678C35.7041 52.5085 36.8759 52.8149 38.0725 52.8666C39.2691 52.9183 40.4629 52.714 41.5743 52.2675C42.6856 51.821 43.689 51.1425 44.5172 50.2773C45.2762 51.5104 46.3082 52.5528 47.5336 53.3242C46.1625 54.3732 45.0516 55.724 44.287 57.2719C43.5224 58.8197 43.1248 60.5229 43.125 62.2492C43.1241 62.5092 43.1773 62.7666 43.2812 63.005C43.385 63.2433 43.5374 63.4575 43.7285 63.6338C43.9196 63.8101 44.1453 63.9448 44.3912 64.0292C44.6371 64.1136 44.8979 64.146 45.157 64.1242C45.6329 64.073 46.0725 63.8462 46.3902 63.4883C46.7078 63.1303 46.8807 62.6668 46.875 62.1883C46.8911 60.2097 47.6883 58.3177 49.0931 56.9243C50.4979 55.531 52.3964 54.7492 54.375 54.7492C54.632 54.7498 54.8864 54.6975 55.1224 54.5956C55.3584 54.4937 55.5709 54.3444 55.7468 54.1569C55.9226 53.9694 56.058 53.7478 56.1446 53.5057C56.2311 53.2637 56.267 53.0065 56.25 52.75C56.208 52.2681 55.9855 51.8198 55.6268 51.4951C55.2682 51.1704 54.8001 50.9933 54.3164 50.9992H52.5C51.0082 50.9992 49.5774 50.4066 48.5225 49.3517C47.4676 48.2968 46.875 46.8661 46.875 45.3742V41.6242H61.875C63.8641 41.6242 65.7718 42.4144 67.1783 43.8209C68.5848 45.2274 69.375 47.1351 69.375 49.1242ZM25.4836 49.1242C28.0242 49.0305 30 46.8672 30 44.3242V38.9336C30 36.3812 28.0242 34.218 25.4836 34.1242C24.8538 34.1012 24.2258 34.2055 23.6372 34.4307C23.0486 34.6559 22.5114 34.9976 22.0579 35.4352C21.6043 35.8728 21.2436 36.3973 20.9975 36.9775C20.7513 37.5576 20.6246 38.1815 20.625 38.8117V44.4367C20.6246 45.067 20.7513 45.6908 20.9975 46.271C21.2436 46.8511 21.6043 47.3757 22.0579 47.8133C22.5114 48.2509 23.0486 48.5925 23.6372 48.8177C24.2258 49.043 24.8538 49.1472 25.4836 49.1242ZM38.6086 49.1242C41.1492 49.0328 43.125 46.8695 43.125 44.3266V33.3109C43.125 30.768 41.1492 28.6047 38.6086 28.5133C37.98 28.4903 37.3531 28.5941 36.7655 28.8185C36.1778 29.0429 35.6413 29.3833 35.1879 29.8193C34.7346 30.2554 34.3736 30.7783 34.1266 31.3568C33.8795 31.9353 33.7515 32.5577 33.75 33.1867V44.4367C33.7496 45.067 33.8763 45.6908 34.1225 46.271C34.3686 46.8511 34.7293 47.3757 35.1829 47.8133C35.6364 48.2509 36.1736 48.5925 36.7622 48.8177C37.3508 49.043 37.9788 49.1472 38.6086 49.1242ZM56.25 33.1867C56.2504 32.5565 56.1237 31.9326 55.8775 31.3525C55.6314 30.7723 55.2707 30.2478 54.8171 29.8102C54.3636 29.3726 53.8264 29.0309 53.2378 28.8057C52.6492 28.5805 52.0212 28.4762 51.3914 28.4992C48.8508 28.593 46.875 30.7562 46.875 33.2992V37.8742H55.3125C55.5611 37.8742 55.7996 37.7754 55.9754 37.5996C56.1512 37.4238 56.25 37.1854 56.25 36.9367V33.1867Z" fill="#A41E11"/>
                </g>
                </g>
                <path d="M145.245 81C143.772 78.7333 142.072 76.3533 140.145 73.86C138.218 71.3667 136.178 68.9583 134.025 66.635C131.928 64.3117 129.747 62.1017 127.48 60.005C125.213 57.9083 122.975 56.095 120.765 54.565V81H110.055V22.095H120.765V46.405C122.635 44.535 124.59 42.5517 126.63 40.455C128.67 38.3017 130.682 36.1483 132.665 33.995C134.705 31.785 136.632 29.66 138.445 27.62C140.258 25.58 141.902 23.7383 143.375 22.095H156.21C154.34 24.2483 152.357 26.4867 150.26 28.81C148.163 31.1333 146.01 33.485 143.8 35.865C141.59 38.1883 139.352 40.5117 137.085 42.835C134.875 45.1583 132.693 47.3683 130.54 49.465C132.92 51.2783 135.328 53.4033 137.765 55.84C140.258 58.22 142.695 60.7983 145.075 63.575C147.455 66.295 149.722 69.1567 151.875 72.16C154.085 75.1067 156.097 78.0533 157.91 81H145.245ZM207.094 81C206.301 78.6767 205.479 76.3817 204.629 74.115C203.779 71.8483 202.958 69.525 202.164 67.145H177.344C176.551 69.525 175.729 71.8767 174.879 74.2C174.086 76.4667 173.293 78.7333 172.499 81H161.364C163.574 74.71 165.671 68.9017 167.654 63.575C169.638 58.2483 171.564 53.205 173.434 48.445C175.361 43.685 177.259 39.1517 179.129 34.845C180.999 30.5383 182.926 26.2883 184.909 22.095H195.024C197.008 26.2883 198.934 30.5383 200.804 34.845C202.674 39.1517 204.544 43.685 206.414 48.445C208.341 53.205 210.296 58.2483 212.279 63.575C214.319 68.9017 216.444 74.71 218.654 81H207.094ZM189.754 33.485C188.451 36.4883 186.949 40.1433 185.249 44.45C183.606 48.7567 181.878 53.4317 180.064 58.475H199.444C197.631 53.4317 195.874 48.7283 194.174 44.365C192.474 40.0017 191.001 36.375 189.754 33.485ZM238.935 22.095C240.182 24.2483 241.57 26.8833 243.1 30C244.63 33.1167 246.188 36.4033 247.775 39.86C249.362 43.26 250.92 46.745 252.45 50.315C254.037 53.8283 255.482 57.0867 256.785 60.09C258.088 57.0867 259.505 53.8283 261.035 50.315C262.565 46.745 264.123 43.26 265.71 39.86C267.297 36.4033 268.855 33.1167 270.385 30C271.915 26.8833 273.303 24.2483 274.55 22.095H284.24C284.75 26.4017 285.232 30.9917 285.685 35.865C286.138 40.6817 286.535 45.64 286.875 50.74C287.272 55.7833 287.612 60.8833 287.895 66.04C288.235 71.14 288.518 76.1267 288.745 81H278.205C277.978 74.1433 277.695 67.0883 277.355 59.835C277.072 52.5817 276.618 45.555 275.995 38.755C275.372 40.0583 274.635 41.6167 273.785 43.43C272.935 45.2433 272.028 47.2267 271.065 49.38C270.102 51.4767 269.11 53.6583 268.09 55.925C267.127 58.1917 266.163 60.4017 265.2 62.555C264.293 64.6517 263.443 66.635 262.65 68.505C261.857 70.3183 261.177 71.8767 260.61 73.18H252.62C252.053 71.8767 251.373 70.29 250.58 68.42C249.787 66.55 248.908 64.5667 247.945 62.47C247.038 60.3167 246.075 58.1067 245.055 55.84C244.092 53.5733 243.128 51.3917 242.165 49.295C241.202 47.1983 240.295 45.2433 239.445 43.43C238.595 41.56 237.858 40.0017 237.235 38.755C236.612 45.555 236.13 52.5817 235.79 59.835C235.507 67.0883 235.252 74.1433 235.025 81H224.485C224.712 76.1267 224.967 71.0833 225.25 65.87C225.59 60.6567 225.93 55.5 226.27 50.4C226.667 45.2433 227.092 40.2567 227.545 35.44C227.998 30.6233 228.48 26.175 228.99 22.095H238.935ZM340.322 81C339.529 78.6767 338.707 76.3817 337.857 74.115C337.007 71.8483 336.185 69.525 335.392 67.145H310.572C309.779 69.525 308.957 71.8767 308.107 74.2C307.314 76.4667 306.52 78.7333 305.727 81H294.592C296.802 74.71 298.899 68.9017 300.882 63.575C302.865 58.2483 304.792 53.205 306.662 48.445C308.589 43.685 310.487 39.1517 312.357 34.845C314.227 30.5383 316.154 26.2883 318.137 22.095H328.252C330.235 26.2883 332.162 30.5383 334.032 34.845C335.902 39.1517 337.772 43.685 339.642 48.445C341.569 53.205 343.524 58.2483 345.507 63.575C347.547 68.9017 349.672 74.71 351.882 81H340.322ZM322.982 33.485C321.679 36.4883 320.177 40.1433 318.477 44.45C316.834 48.7567 315.105 53.4317 313.292 58.475H332.672C330.859 53.4317 329.102 48.7283 327.402 44.365C325.702 40.0017 324.229 36.375 322.982 33.485ZM375.562 21.5C384.062 21.5 390.551 23.0583 395.027 26.175C399.561 29.2917 401.827 34.0517 401.827 40.455C401.827 48.445 397.889 53.8567 390.012 56.69C391.089 57.9933 392.307 59.58 393.667 61.45C395.027 63.32 396.416 65.36 397.832 67.57C399.249 69.7233 400.609 71.9617 401.912 74.285C403.216 76.5517 404.377 78.79 405.397 81H393.412C392.336 78.96 391.174 76.92 389.927 74.88C388.681 72.7833 387.406 70.7717 386.102 68.845C384.856 66.8617 383.609 65.02 382.362 63.32C381.116 61.5633 379.954 60.005 378.877 58.645C378.084 58.7017 377.404 58.73 376.837 58.73C376.271 58.73 375.732 58.73 375.222 58.73H370.037V81H359.327V22.945C361.934 22.3783 364.711 22.01 367.657 21.84C370.604 21.6133 373.239 21.5 375.562 21.5ZM376.327 30.765C374.061 30.765 371.964 30.85 370.037 31.02V50.06H374.712C377.319 50.06 379.614 49.9183 381.597 49.635C383.581 49.3517 385.224 48.8417 386.527 48.105C387.887 47.3683 388.907 46.3767 389.587 45.13C390.267 43.8833 390.607 42.2967 390.607 40.37C390.607 38.5567 390.267 37.0267 389.587 35.78C388.907 34.5333 387.916 33.5417 386.612 32.805C385.366 32.0683 383.864 31.5583 382.107 31.275C380.351 30.935 378.424 30.765 376.327 30.765ZM463.456 61.62C463.456 64.51 463.145 67.2017 462.521 69.695C461.898 72.1883 460.793 74.37 459.206 76.24C457.676 78.11 455.58 79.5833 452.916 80.66C450.31 81.7367 446.995 82.275 442.971 82.275C439.231 82.275 435.973 81.765 433.196 80.745C430.476 79.6683 428.38 78.535 426.906 77.345L430.731 68.93C432.148 69.8933 433.876 70.8283 435.916 71.735C438.013 72.585 440.138 73.01 442.291 73.01C445.918 73.01 448.553 72.1033 450.196 70.29C451.84 68.4767 452.661 65.36 452.661 60.94V22.095H463.456V61.62ZM499.811 82.275C495.787 82.275 492.331 81.7083 489.441 80.575C486.551 79.385 484.142 77.7417 482.216 75.645C480.346 73.5483 478.957 71.0833 478.051 68.25C477.144 65.4167 476.691 62.3 476.691 58.9V22.095H487.486V57.88C487.486 60.5433 487.769 62.8383 488.336 64.765C488.959 66.635 489.809 68.165 490.886 69.355C492.019 70.545 493.322 71.4233 494.796 71.99C496.326 72.5567 498.026 72.84 499.896 72.84C501.766 72.84 503.466 72.5567 504.996 71.99C506.526 71.4233 507.829 70.545 508.906 69.355C510.039 68.165 510.889 66.635 511.456 64.765C512.079 62.8383 512.391 60.5433 512.391 57.88V22.095H523.186V58.9C523.186 62.3 522.704 65.4167 521.741 68.25C520.834 71.0833 519.417 73.5483 517.491 75.645C515.621 77.7417 513.212 79.385 510.266 80.575C507.319 81.7083 503.834 82.275 499.811 82.275ZM575.234 81C574.441 78.6767 573.619 76.3817 572.769 74.115C571.919 71.8483 571.097 69.525 570.304 67.145H545.484C544.691 69.525 543.869 71.8767 543.019 74.2C542.226 76.4667 541.432 78.7333 540.639 81H529.504C531.714 74.71 533.811 68.9017 535.794 63.575C537.777 58.2483 539.704 53.205 541.574 48.445C543.501 43.685 545.399 39.1517 547.269 34.845C549.139 30.5383 551.066 26.2883 553.049 22.095H563.164C565.147 26.2883 567.074 30.5383 568.944 34.845C570.814 39.1517 572.684 43.685 574.554 48.445C576.481 53.205 578.436 58.2483 580.419 63.575C582.459 68.9017 584.584 74.71 586.794 81H575.234ZM557.894 33.485C556.591 36.4883 555.089 40.1433 553.389 44.45C551.746 48.7567 550.017 53.4317 548.204 58.475H567.584C565.771 53.4317 564.014 48.7283 562.314 44.365C560.614 40.0017 559.141 36.375 557.894 33.485ZM633.935 81C632.008 77.77 629.855 74.3133 627.475 70.63C625.095 66.89 622.63 63.15 620.08 59.41C617.53 55.6133 614.923 51.9583 612.26 48.445C609.653 44.875 607.16 41.6733 604.78 38.84V81H594.24V22.095H602.995C605.261 24.475 607.698 27.3083 610.305 30.595C612.911 33.825 615.518 37.1967 618.125 40.71C620.788 44.2233 623.338 47.765 625.775 51.335C628.268 54.8483 630.478 58.135 632.405 61.195V22.095H643.03V81H633.935ZM684.699 30.17C678.636 30.17 673.989 32.0683 670.759 35.865C667.586 39.605 665.999 44.8183 665.999 51.505C665.999 54.6783 666.368 57.5967 667.104 60.26C667.898 62.8667 669.031 65.105 670.504 66.975C672.034 68.845 673.904 70.3183 676.114 71.395C678.381 72.415 681.016 72.925 684.019 72.925C685.889 72.925 687.504 72.8683 688.864 72.755C690.224 72.585 691.301 72.3867 692.094 72.16V50.995H702.804V79.3C701.331 79.8667 698.838 80.49 695.324 81.17C691.811 81.85 687.759 82.19 683.169 82.19C678.919 82.19 675.038 81.51 671.524 80.15C668.011 78.79 665.008 76.8067 662.514 74.2C660.078 71.5933 658.179 68.3917 656.819 64.595C655.459 60.7983 654.779 56.435 654.779 51.505C654.779 46.575 655.516 42.2117 656.989 38.415C658.519 34.6183 660.588 31.4167 663.194 28.81C665.801 26.1467 668.861 24.135 672.374 22.775C675.888 21.415 679.628 20.735 683.594 20.735C686.314 20.735 688.723 20.9333 690.819 21.33C692.973 21.67 694.814 22.0667 696.344 22.52C697.874 22.9733 699.121 23.455 700.084 23.965C701.104 24.475 701.813 24.8433 702.209 25.07L698.979 33.825C697.279 32.805 695.154 31.955 692.604 31.275C690.111 30.5383 687.476 30.17 684.699 30.17Z" fill="white"/>
                <defs>
                <clipPath id="clip0_705_51">
                <rect width="90" height="90" fill="white" transform="translate(0 5)"/>
                </clipPath>
                <clipPath id="clip1_705_51">
                <rect width="60" height="60" fill="white" transform="translate(15 21)"/>
                </clipPath>
                </defs>
                </svg> --}}
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="{{ route('hitung_cepat.rekap') }}"
                            class="dropdown-toggle no-arrow {{ request()->url() == route('hitung_cepat.rekap') ? 'active' : '' }}">
                            <span class="micon dw dw-file"></span><span class="mtext">Rekap Hitung Cepat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hitung_cepat.admin') }}"
                            class="dropdown-toggle no-arrow {{ request()->path() == 'hitung-cepat/admin' ? 'active' : '' }}">
                            <span class="micon dw dw-flash"></span>
                            <span class="mtext">Hitung Cepat (Admin)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hitung_cepat.saksi') }}"
                            class="dropdown-toggle no-arrow {{ request()->path() == 'hitung-cepat/saksi' ? 'active' : '' }}">
                            <span class="micon dw dw-flash"></span>
                            <span class="mtext">Hitung Cepat (Saksi)</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a href="{{ route('hitung_suara.index') }}"
                            class="dropdown-toggle no-arrow {{ request()->path() == 'hitung-suara' ? 'active' : '' }}">
                            <span class="micon dw dw-folder"></span>
                            <span class="mtext">Hitung Suara</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('input.index') }}"
                            class="dropdown-toggle no-arrow {{ Str::contains(request()->route()->getName(), 'input') ? 'active' : '' }}">
                            <span class="micon dw dw-folder"></span>
                            <span class="mtext">Input Suara</span>
                        </a>
                    </li> --}}
                    @if (session()->get('level') == 'master' || session()->get('level') == 'provinsi')
                        <li>
                            <a href="{{ route('rekap.index', ['Type' => 'Provinsi']) }}"
                                class="dropdown-toggle no-arrow {{ request()->fullUrl() == route('rekap.index', ['Type' => 'Provinsi']) ? 'active' : '' }}">
                                <span class="micon dw dw-file"></span><span class="mtext">Rekap Provinsi</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('rekap.index', ['Type' => 'Kabkota']) }}"
                            class="dropdown-toggle no-arrow {{ request()->fullUrl() == route('rekap.index', ['Type' => 'Kabkota']) ? 'active' : '' }}">
                            <span class="micon dw dw-file"></span><span class="mtext">Rekap KabKota</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    @if (session()->get('level') == 'master')
                        <li>
                            <div class="sidebar-small-cap">System Administrator</div>
                        </li>
                        <li>
                            <a href="{{ route('data-pemilih.index', []) }}"
                                class="dropdown-toggle no-arrow {{ request()->is('data-pemilih') ? 'active' : '' }}">
                                <span class="micon dw dw-id-card2"></span>
                                <span class="text">Data Pemilih</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.index', []) }}"
                                class="dropdown-toggle no-arrow {{ request()->is('user') ? 'active' : '' }}">
                                <span class="micon dw dw-settings1"></span>
                                <span class="text">User Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('calon.index', []) }}"
                                class="dropdown-toggle no-arrow {{ request()->is('calon') ? 'active' : '' }}">
                                <span class="micon bi bi-people"></span>
                                <span class="text">Calon</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wilayah.index', []) }}"
                                class="dropdown-toggle no-arrow {{ request()->is('wilayah-pemilihan') ? 'active' : '' }}">
                                <span class="micon dw dw-map1"></span>
                                <span class="text">Wilayah Pemilihan</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        @yield('body')
    </div>
</body>

</html>
