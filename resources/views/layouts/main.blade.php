<!DOCTYPE html>
<html>

<head>
    {{-- Basic Page Info --}}
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>Kamar Juang</title>
    {{-- Site favicon --}}
    <link rel="icon" type="image/x-cion" sizes="16x16" href="./favicon.svg" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    {{-- Google Font --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" /> --}}
    {{-- CSS --}}
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/switchery/switchery.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/TopLoaderService/TopLoaderService.css" />

    {{-- Global site tag (gtag.js) - Google Analytics --}}
    {{-- <script src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script> --}}
    {{-- <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script> --}}
    {{-- Google Tag Manager --}}
    {{-- <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS"); --}}
    </script>
    <script src="../admin/src/plugins/TopLoaderService/TopLoaderService.js"></script>
    <script src="../admin/vendors/scripts/core.js"></script>
    <script src="../admin/vendors/scripts/script.min.js"></script>
    <script src="../admin/vendors/scripts/process.js"></script>
    <script src="../admin/vendors/scripts/layout-settings.js"></script>
    <script src="../admin/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../admin/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../admin/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="../admin/src/plugins/sweetalert2/sweetalert2.js"></script>
    <script src="../admin/js/script.js"></script>
    {{-- <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>
        window.socketIOUrl = "http://localhost:2002";
        const socket = io(window.socketIOUrl);
    </script>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
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
                <svg width="711" height="98" viewBox="0 0 711 98" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 52C7.5 34.3225 7.5 25.4837 12.99 19.99C18.4875 14.5 27.3225 14.5 45 14.5C62.6775 14.5 71.5162 14.5 77.0062 19.99C82.5 25.4875 82.5 34.3225 82.5 52C82.5 69.6775 82.5 78.5162 77.0062 84.0062C71.52 89.5 62.6775 89.5 45 89.5C27.3225 89.5 18.4837 89.5 12.99 84.0062C7.5 78.52 7.5 69.6775 7.5 52Z" fill="white"/>
                    <path d="M63.75 54.5017C63.75 70.4992 50.415 74.5005 43.7512 74.5005C37.9125 74.5005 26.25 70.4992 26.25 54.5017C26.25 47.538 30.2363 43.1242 33.585 40.9005C35.115 39.8842 37.02 40.533 37.1175 42.3667C37.335 46.383 40.4287 49.608 42.8287 46.3792C45.0187 43.4242 46.1025 39.4117 46.1025 37.0005C46.1025 33.4492 49.695 31.1955 52.5037 33.3705C57.9712 37.608 63.75 44.7105 63.75 54.5017Z" stroke="#A41E11" stroke-width="4.16667"/>
                    <path d="M147.245 81C145.772 78.7333 144.072 76.3533 142.145 73.86C140.218 71.3667 138.178 68.9583 136.025 66.635C133.928 64.3117 131.747 62.1017 129.48 60.005C127.213 57.9083 124.975 56.095 122.765 54.565V81H112.055V22.095H122.765V46.405C124.635 44.535 126.59 42.5517 128.63 40.455C130.67 38.3017 132.682 36.1483 134.665 33.995C136.705 31.785 138.632 29.66 140.445 27.62C142.258 25.58 143.902 23.7383 145.375 22.095H158.21C156.34 24.2483 154.357 26.4867 152.26 28.81C150.163 31.1333 148.01 33.485 145.8 35.865C143.59 38.1883 141.352 40.5117 139.085 42.835C136.875 45.1583 134.693 47.3683 132.54 49.465C134.92 51.2783 137.328 53.4033 139.765 55.84C142.258 58.22 144.695 60.7983 147.075 63.575C149.455 66.295 151.722 69.1567 153.875 72.16C156.085 75.1067 158.097 78.0533 159.91 81H147.245ZM209.094 81C208.301 78.6767 207.479 76.3817 206.629 74.115C205.779 71.8483 204.958 69.525 204.164 67.145H179.344C178.551 69.525 177.729 71.8767 176.879 74.2C176.086 76.4667 175.293 78.7333 174.499 81H163.364C165.574 74.71 167.671 68.9017 169.654 63.575C171.638 58.2483 173.564 53.205 175.434 48.445C177.361 43.685 179.259 39.1517 181.129 34.845C182.999 30.5383 184.926 26.2883 186.909 22.095H197.024C199.008 26.2883 200.934 30.5383 202.804 34.845C204.674 39.1517 206.544 43.685 208.414 48.445C210.341 53.205 212.296 58.2483 214.279 63.575C216.319 68.9017 218.444 74.71 220.654 81H209.094ZM191.754 33.485C190.451 36.4883 188.949 40.1433 187.249 44.45C185.606 48.7567 183.878 53.4317 182.064 58.475H201.444C199.631 53.4317 197.874 48.7283 196.174 44.365C194.474 40.0017 193.001 36.375 191.754 33.485ZM240.935 22.095C242.182 24.2483 243.57 26.8833 245.1 30C246.63 33.1167 248.188 36.4033 249.775 39.86C251.362 43.26 252.92 46.745 254.45 50.315C256.037 53.8283 257.482 57.0867 258.785 60.09C260.088 57.0867 261.505 53.8283 263.035 50.315C264.565 46.745 266.123 43.26 267.71 39.86C269.297 36.4033 270.855 33.1167 272.385 30C273.915 26.8833 275.303 24.2483 276.55 22.095H286.24C286.75 26.4017 287.232 30.9917 287.685 35.865C288.138 40.6817 288.535 45.64 288.875 50.74C289.272 55.7833 289.612 60.8833 289.895 66.04C290.235 71.14 290.518 76.1267 290.745 81H280.205C279.978 74.1433 279.695 67.0883 279.355 59.835C279.072 52.5817 278.618 45.555 277.995 38.755C277.372 40.0583 276.635 41.6167 275.785 43.43C274.935 45.2433 274.028 47.2267 273.065 49.38C272.102 51.4767 271.11 53.6583 270.09 55.925C269.127 58.1917 268.163 60.4017 267.2 62.555C266.293 64.6517 265.443 66.635 264.65 68.505C263.857 70.3183 263.177 71.8767 262.61 73.18H254.62C254.053 71.8767 253.373 70.29 252.58 68.42C251.787 66.55 250.908 64.5667 249.945 62.47C249.038 60.3167 248.075 58.1067 247.055 55.84C246.092 53.5733 245.128 51.3917 244.165 49.295C243.202 47.1983 242.295 45.2433 241.445 43.43C240.595 41.56 239.858 40.0017 239.235 38.755C238.612 45.555 238.13 52.5817 237.79 59.835C237.507 67.0883 237.252 74.1433 237.025 81H226.485C226.712 76.1267 226.967 71.0833 227.25 65.87C227.59 60.6567 227.93 55.5 228.27 50.4C228.667 45.2433 229.092 40.2567 229.545 35.44C229.998 30.6233 230.48 26.175 230.99 22.095H240.935ZM342.322 81C341.529 78.6767 340.707 76.3817 339.857 74.115C339.007 71.8483 338.185 69.525 337.392 67.145H312.572C311.779 69.525 310.957 71.8767 310.107 74.2C309.314 76.4667 308.52 78.7333 307.727 81H296.592C298.802 74.71 300.899 68.9017 302.882 63.575C304.865 58.2483 306.792 53.205 308.662 48.445C310.589 43.685 312.487 39.1517 314.357 34.845C316.227 30.5383 318.154 26.2883 320.137 22.095H330.252C332.235 26.2883 334.162 30.5383 336.032 34.845C337.902 39.1517 339.772 43.685 341.642 48.445C343.569 53.205 345.524 58.2483 347.507 63.575C349.547 68.9017 351.672 74.71 353.882 81H342.322ZM324.982 33.485C323.679 36.4883 322.177 40.1433 320.477 44.45C318.834 48.7567 317.105 53.4317 315.292 58.475H334.672C332.859 53.4317 331.102 48.7283 329.402 44.365C327.702 40.0017 326.229 36.375 324.982 33.485ZM377.562 21.5C386.062 21.5 392.551 23.0583 397.027 26.175C401.561 29.2917 403.827 34.0517 403.827 40.455C403.827 48.445 399.889 53.8567 392.012 56.69C393.089 57.9933 394.307 59.58 395.667 61.45C397.027 63.32 398.416 65.36 399.832 67.57C401.249 69.7233 402.609 71.9617 403.912 74.285C405.216 76.5517 406.377 78.79 407.397 81H395.412C394.336 78.96 393.174 76.92 391.927 74.88C390.681 72.7833 389.406 70.7717 388.102 68.845C386.856 66.8617 385.609 65.02 384.362 63.32C383.116 61.5633 381.954 60.005 380.877 58.645C380.084 58.7017 379.404 58.73 378.837 58.73C378.271 58.73 377.732 58.73 377.222 58.73H372.037V81H361.327V22.945C363.934 22.3783 366.711 22.01 369.657 21.84C372.604 21.6133 375.239 21.5 377.562 21.5ZM378.327 30.765C376.061 30.765 373.964 30.85 372.037 31.02V50.06H376.712C379.319 50.06 381.614 49.9183 383.597 49.635C385.581 49.3517 387.224 48.8417 388.527 48.105C389.887 47.3683 390.907 46.3767 391.587 45.13C392.267 43.8833 392.607 42.2967 392.607 40.37C392.607 38.5567 392.267 37.0267 391.587 35.78C390.907 34.5333 389.916 33.5417 388.612 32.805C387.366 32.0683 385.864 31.5583 384.107 31.275C382.351 30.935 380.424 30.765 378.327 30.765ZM465.456 61.62C465.456 64.51 465.145 67.2017 464.521 69.695C463.898 72.1883 462.793 74.37 461.206 76.24C459.676 78.11 457.58 79.5833 454.916 80.66C452.31 81.7367 448.995 82.275 444.971 82.275C441.231 82.275 437.973 81.765 435.196 80.745C432.476 79.6683 430.38 78.535 428.906 77.345L432.731 68.93C434.148 69.8933 435.876 70.8283 437.916 71.735C440.013 72.585 442.138 73.01 444.291 73.01C447.918 73.01 450.553 72.1033 452.196 70.29C453.84 68.4767 454.661 65.36 454.661 60.94V22.095H465.456V61.62ZM501.811 82.275C497.787 82.275 494.331 81.7083 491.441 80.575C488.551 79.385 486.142 77.7417 484.216 75.645C482.346 73.5483 480.957 71.0833 480.051 68.25C479.144 65.4167 478.691 62.3 478.691 58.9V22.095H489.486V57.88C489.486 60.5433 489.769 62.8383 490.336 64.765C490.959 66.635 491.809 68.165 492.886 69.355C494.019 70.545 495.322 71.4233 496.796 71.99C498.326 72.5567 500.026 72.84 501.896 72.84C503.766 72.84 505.466 72.5567 506.996 71.99C508.526 71.4233 509.829 70.545 510.906 69.355C512.039 68.165 512.889 66.635 513.456 64.765C514.079 62.8383 514.391 60.5433 514.391 57.88V22.095H525.186V58.9C525.186 62.3 524.704 65.4167 523.741 68.25C522.834 71.0833 521.417 73.5483 519.491 75.645C517.621 77.7417 515.212 79.385 512.266 80.575C509.319 81.7083 505.834 82.275 501.811 82.275ZM577.234 81C576.441 78.6767 575.619 76.3817 574.769 74.115C573.919 71.8483 573.097 69.525 572.304 67.145H547.484C546.691 69.525 545.869 71.8767 545.019 74.2C544.226 76.4667 543.432 78.7333 542.639 81H531.504C533.714 74.71 535.811 68.9017 537.794 63.575C539.777 58.2483 541.704 53.205 543.574 48.445C545.501 43.685 547.399 39.1517 549.269 34.845C551.139 30.5383 553.066 26.2883 555.049 22.095H565.164C567.147 26.2883 569.074 30.5383 570.944 34.845C572.814 39.1517 574.684 43.685 576.554 48.445C578.481 53.205 580.436 58.2483 582.419 63.575C584.459 68.9017 586.584 74.71 588.794 81H577.234ZM559.894 33.485C558.591 36.4883 557.089 40.1433 555.389 44.45C553.746 48.7567 552.017 53.4317 550.204 58.475H569.584C567.771 53.4317 566.014 48.7283 564.314 44.365C562.614 40.0017 561.141 36.375 559.894 33.485ZM635.935 81C634.008 77.77 631.855 74.3133 629.475 70.63C627.095 66.89 624.63 63.15 622.08 59.41C619.53 55.6133 616.923 51.9583 614.26 48.445C611.653 44.875 609.16 41.6733 606.78 38.84V81H596.24V22.095H604.995C607.261 24.475 609.698 27.3083 612.305 30.595C614.911 33.825 617.518 37.1967 620.125 40.71C622.788 44.2233 625.338 47.765 627.775 51.335C630.268 54.8483 632.478 58.135 634.405 61.195V22.095H645.03V81H635.935ZM686.699 30.17C680.636 30.17 675.989 32.0683 672.759 35.865C669.586 39.605 667.999 44.8183 667.999 51.505C667.999 54.6783 668.368 57.5967 669.104 60.26C669.898 62.8667 671.031 65.105 672.504 66.975C674.034 68.845 675.904 70.3183 678.114 71.395C680.381 72.415 683.016 72.925 686.019 72.925C687.889 72.925 689.504 72.8683 690.864 72.755C692.224 72.585 693.301 72.3867 694.094 72.16V50.995H704.804V79.3C703.331 79.8667 700.838 80.49 697.324 81.17C693.811 81.85 689.759 82.19 685.169 82.19C680.919 82.19 677.038 81.51 673.524 80.15C670.011 78.79 667.008 76.8067 664.514 74.2C662.078 71.5933 660.179 68.3917 658.819 64.595C657.459 60.7983 656.779 56.435 656.779 51.505C656.779 46.575 657.516 42.2117 658.989 38.415C660.519 34.6183 662.588 31.4167 665.194 28.81C667.801 26.1467 670.861 24.135 674.374 22.775C677.888 21.415 681.628 20.735 685.594 20.735C688.314 20.735 690.723 20.9333 692.819 21.33C694.973 21.67 696.814 22.0667 698.344 22.52C699.874 22.9733 701.121 23.455 702.084 23.965C703.104 24.475 703.813 24.8433 704.209 25.07L700.979 33.825C699.279 32.805 697.154 31.955 694.604 31.275C692.111 30.5383 689.476 30.17 686.699 30.17Z" fill="white"/>
                    </svg>

            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="{{ route('hitung_cepat.rekap') }}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-file"></span><span class="mtext">Rekap Hitung Cepat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hitung_cepat.saksi') }}"
                            class="dropdown-toggle no-arrow {{ request()->path() == "hitung-cepat/saksi" ? 'active' : '' }}">
                            <span class="micon dw dw-flash"></span>
                            <span class="mtext">Hitung Cepat (Saksi)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hitung_cepat.admin') }}"
                            class="dropdown-toggle no-arrow {{ request()->path() == "hitung-cepat/admin" ? 'active' : '' }}">
                            <span class="micon dw dw-flash"></span>
                            <span class="mtext">Hitung Cepat (Admin)</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a href="{{ route('input.index') }}"
                            class="dropdown-toggle no-arrow {{ Str::contains(request()->route()->getName(), 'input') ? 'active' : '' }}">
                            <span class="micon dw dw-folder"></span>
                            <span class="mtext">Input Suara</span>
                        </a>
                    </li>
                    @if (session()->get('level') == 'master' || session()->get('level') == 'provinsi')
                        <li>
                            <a href="{{ route('rekap.index', ['Type' => 'Provinsi']) }}"
                                class="dropdown-toggle no-arrow {{ Str::contains(request()->route()->getName(), 'rekapitulasi') ? 'active' : '' }}">
                                <span class="micon dw dw-file"></span><span class="mtext">Rekap Provinsi</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('rekap.index', ['Type' => 'Kabkota']) }}"
                            class="dropdown-toggle no-arrow {{ Str::contains(request()->route()->getName(), 'rekapitulasi') ? 'active' : '' }}">
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
