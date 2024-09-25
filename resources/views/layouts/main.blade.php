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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    {{-- CSS --}}
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/switchery/switchery.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/TopLoaderService/TopLoaderService.css" />

    {{-- Global site tag (gtag.js) - Google Analytics --}}
    <script src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    {{-- Google Tag Manager --}}
    <script>
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
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
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
                <svg width="450" height="62" viewBox="0 0 450 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M81.0322 51.0142C80.2804 49.797 79.3853 48.4903 78.3473 47.0942C77.3447 45.6622 76.2353 44.2481 75.0179 42.8519C73.8365 41.4199 72.6014 40.0595 71.3127 38.7708C70.0239 37.4462 68.7351 36.2827 67.4463 35.2803V51.0142H59.0692V13.8006H67.4463V27.8698C69.6303 25.5786 71.8137 23.198 73.9976 20.7278C76.217 18.2218 78.2758 15.9127 80.173 13.8006H90.1074C87.5658 16.8078 85.006 19.7075 82.4284 22.4999C79.8868 25.2922 77.2019 28.1025 74.3735 30.9307C77.3447 33.4008 80.209 36.3364 82.9654 39.7374C85.7578 43.1383 88.425 46.8972 90.9666 51.0142H81.0322ZM122.057 51.0142C121.664 49.7254 121.216 48.4008 120.715 47.0405C120.25 45.6801 119.784 44.3197 119.319 42.9593H104.82C104.355 44.3197 103.872 45.6801 103.37 47.0405C102.905 48.4008 102.475 49.7254 102.081 51.0142H93.382C94.7782 47.0046 96.1029 43.2994 97.3557 39.8984C98.6091 36.4975 99.8259 33.2934 101.007 30.2863C102.225 27.2791 103.406 24.4331 104.551 21.7481C105.733 19.0273 106.95 16.3782 108.203 13.8006H116.204C117.422 16.3782 118.621 19.0273 119.802 21.7481C120.983 24.4331 122.165 27.2791 123.346 30.2863C124.564 33.2934 125.799 36.4975 127.051 39.8984C128.305 43.2994 129.629 47.0046 131.025 51.0142H122.057ZM112.016 22.2314C111.837 22.7684 111.568 23.5023 111.21 24.4331C110.853 25.3638 110.441 26.4378 109.975 27.655C109.51 28.8722 108.991 30.2147 108.418 31.6825C107.881 33.1502 107.326 34.6896 106.753 36.3006H117.332C116.759 34.6896 116.204 33.1502 115.667 31.6825C115.13 30.2147 114.611 28.8722 114.11 27.655C113.645 26.4378 113.233 25.3638 112.875 24.4331C112.517 23.5023 112.23 22.7684 112.016 22.2314ZM145.723 13.8006C146.368 14.982 147.101 16.4497 147.925 18.2039C148.784 19.9223 149.661 21.8018 150.556 23.8424C151.487 25.8471 152.4 27.9056 153.295 30.0178C154.189 32.1299 155.031 34.1168 155.819 35.9784C156.606 34.1168 157.447 32.1299 158.343 30.0178C159.237 27.9056 160.132 25.8471 161.028 23.8424C161.958 21.8018 162.835 19.9223 163.659 18.2039C164.518 16.4497 165.27 14.982 165.914 13.8006H173.539C173.897 16.2708 174.219 19.0452 174.506 22.124C174.828 25.167 175.097 28.3531 175.312 31.6825C175.562 34.976 175.777 38.2875 175.956 41.6168C176.171 44.9462 176.35 48.0786 176.493 51.0142H168.331C168.223 47.3985 168.08 43.4605 167.901 39.2004C167.722 34.9402 167.453 30.6443 167.096 26.3125C166.451 27.8161 165.735 29.4808 164.948 31.3066C164.16 33.1323 163.372 34.9581 162.585 36.7839C161.833 38.6097 161.099 40.3639 160.383 42.0464C159.667 43.6932 159.058 45.1073 158.557 46.2887H152.704C152.203 45.1073 151.594 43.6932 150.878 42.0464C150.162 40.3639 149.41 38.6097 148.623 36.7839C147.871 34.9581 147.101 33.1323 146.314 31.3066C145.526 29.4808 144.81 27.8161 144.166 26.3125C143.808 30.6443 143.539 34.9402 143.36 39.2004C143.181 43.4605 143.038 47.3985 142.931 51.0142H134.769C134.911 48.0786 135.072 44.9462 135.252 41.6168C135.467 38.2875 135.681 34.976 135.896 31.6825C136.146 28.3531 136.415 25.167 136.702 22.124C137.024 19.0452 137.364 16.2708 137.722 13.8006H145.723ZM208.952 51.0142C208.558 49.7254 208.11 48.4008 207.609 47.0405C207.144 45.6801 206.679 44.3197 206.213 42.9593H191.715C191.249 44.3197 190.766 45.6801 190.265 47.0405C189.799 48.4008 189.369 49.7254 188.976 51.0142H180.277C181.673 47.0046 182.997 43.2994 184.25 39.8984C185.503 36.4975 186.72 33.2934 187.902 30.2863C189.119 27.2791 190.301 24.4331 191.446 21.7481C192.627 19.0273 193.845 16.3782 195.098 13.8006H203.099C204.316 16.3782 205.515 19.0273 206.697 21.7481C207.878 24.4331 209.059 27.2791 210.241 30.2863C211.458 33.2934 212.693 36.4975 213.946 39.8984C215.199 43.2994 216.524 47.0046 217.92 51.0142H208.952ZM198.91 22.2314C198.731 22.7684 198.463 23.5023 198.105 24.4331C197.747 25.3638 197.335 26.4378 196.87 27.655C196.404 28.8722 195.885 30.2147 195.312 31.6825C194.775 33.1502 194.221 34.6896 193.648 36.3006H204.226C203.653 34.6896 203.099 33.1502 202.562 31.6825C202.025 30.2147 201.505 28.8722 201.004 27.655C200.539 26.4378 200.128 25.3638 199.769 24.4331C199.411 23.5023 199.125 22.7684 198.91 22.2314ZM233.638 13.371C239.222 13.371 243.5 14.3734 246.472 16.3782C249.443 18.3472 250.929 21.4259 250.929 25.6144C250.929 28.2278 250.32 30.3579 249.103 32.0047C247.922 33.6156 246.203 34.8865 243.948 35.8173C244.7 36.7481 245.487 37.8221 246.311 39.0393C247.134 40.2206 247.939 41.4736 248.727 42.7982C249.55 44.087 250.338 45.4474 251.09 46.8794C251.842 48.2755 252.54 49.6538 253.184 51.0142H243.787C243.106 49.797 242.408 48.5619 241.692 47.3089C241.012 46.056 240.296 44.8388 239.544 43.6574C238.829 42.476 238.112 41.3662 237.396 40.328C236.681 39.2541 235.964 38.2875 235.249 37.4283H231.114V51.0142H222.737V14.3376C224.562 13.9796 226.442 13.729 228.375 13.5858C230.344 13.4426 232.098 13.371 233.638 13.371ZM234.121 20.513C233.512 20.513 232.957 20.5309 232.456 20.5667C231.991 20.6025 231.543 20.6383 231.114 20.6741V30.7696H233.476C236.627 30.7696 238.882 30.3758 240.243 29.5882C241.603 28.8006 242.283 27.4581 242.283 25.5607C242.283 23.735 241.585 22.4462 240.189 21.6944C238.829 20.9068 236.806 20.513 234.121 20.513ZM291.806 38.5023C291.806 40.328 291.591 42.0464 291.162 43.6574C290.768 45.2684 290.052 46.6824 289.014 47.8996C288.011 49.081 286.633 50.0297 284.879 50.7457C283.161 51.4259 280.977 51.766 278.328 51.766C275.893 51.766 273.799 51.4796 272.045 50.9068C270.291 50.2982 268.841 49.6001 267.695 48.8125L270.488 42.3149C271.526 42.9235 272.636 43.4605 273.817 43.9259C274.998 44.3913 276.287 44.624 277.683 44.624C279.724 44.624 281.191 44.1228 282.087 43.1204C282.981 42.118 283.429 40.4354 283.429 38.0727V13.8006H291.806V38.5023ZM314.43 51.766C311.816 51.766 309.561 51.408 307.664 50.692C305.766 49.9402 304.191 48.9199 302.938 47.6311C301.721 46.3065 300.808 44.7493 300.199 42.9593C299.626 41.1335 299.34 39.1288 299.34 36.945V13.8006H307.717V36.2469C307.717 37.7505 307.878 39.0393 308.201 40.1132C308.558 41.1514 309.024 42.0106 309.597 42.6908C310.205 43.3352 310.921 43.8006 311.745 44.087C312.604 44.3734 313.535 44.5166 314.537 44.5166C316.578 44.5166 318.224 43.8901 319.477 42.6371C320.766 41.3841 321.411 39.2541 321.411 36.2469V13.8006H329.788V36.945C329.788 39.1288 329.483 41.1335 328.875 42.9593C328.266 44.7851 327.335 46.3602 326.082 47.6848C324.829 48.9736 323.236 49.976 321.303 50.692C319.37 51.408 317.079 51.766 314.43 51.766ZM361.712 51.0142C361.318 49.7254 360.87 48.4008 360.369 47.0405C359.904 45.6801 359.438 44.3197 358.973 42.9593H344.474C344.009 44.3197 343.526 45.6801 343.025 47.0405C342.559 48.4008 342.129 49.7254 341.736 51.0142H333.037C334.433 47.0046 335.757 43.2994 337.01 39.8984C338.263 36.4975 339.48 33.2934 340.662 30.2863C341.879 27.2791 343.06 24.4331 344.206 21.7481C345.387 19.0273 346.604 16.3782 347.858 13.8006H355.859C357.076 16.3782 358.275 19.0273 359.457 21.7481C360.638 24.4331 361.819 27.2791 363.001 30.2863C364.218 33.2934 365.453 36.4975 366.706 39.8984C367.959 43.2994 369.284 47.0046 370.68 51.0142H361.712ZM351.67 22.2314C351.491 22.7684 351.222 23.5023 350.865 24.4331C350.507 25.3638 350.095 26.4378 349.63 27.655C349.164 28.8722 348.645 30.2147 348.072 31.6825C347.535 33.1502 346.98 34.6896 346.408 36.3006H356.986C356.413 34.6896 355.859 33.1502 355.322 31.6825C354.785 30.2147 354.265 28.8722 353.764 27.655C353.299 26.4378 352.887 25.3638 352.529 24.4331C352.171 23.5023 351.885 22.7684 351.67 22.2314ZM400.467 51.0142C398.068 46.7541 395.473 42.5476 392.68 38.3949C389.888 34.2421 386.916 30.3221 383.766 26.6347V51.0142H375.497V13.8006H382.316C383.498 14.982 384.804 16.4319 386.236 18.1502C387.668 19.8686 389.118 21.7123 390.586 23.6813C392.09 25.6144 393.575 27.6371 395.043 29.7493C396.511 31.8257 397.889 33.8304 399.178 35.7636V13.8006H407.501V51.0142H400.467ZM434.236 20.2445C430.334 20.2445 427.505 21.3364 425.752 23.5202C424.033 25.6681 423.174 28.6216 423.174 32.3805C423.174 34.2063 423.389 35.871 423.818 37.3746C424.248 38.8423 424.892 40.1132 425.752 41.1872C426.611 42.2612 427.685 43.1025 428.974 43.7111C430.262 44.2839 431.766 44.5703 433.484 44.5703C434.415 44.5703 435.203 44.5524 435.847 44.5166C436.527 44.4808 437.118 44.4092 437.619 44.3018V31.3603H445.996V49.7791C444.994 50.1729 443.383 50.5846 441.163 51.0142C438.943 51.4796 436.205 51.7123 432.947 51.7123C430.155 51.7123 427.613 51.2827 425.322 50.4235C423.067 49.5643 421.133 48.3114 419.522 46.6646C417.911 45.0178 416.658 42.9951 415.764 40.5965C414.904 38.198 414.475 35.4593 414.475 32.3805C414.475 29.266 414.958 26.5094 415.925 24.1109C416.891 21.7123 418.215 19.6896 419.898 18.0428C421.581 16.3603 423.55 15.0894 425.805 14.2302C428.096 13.371 430.531 12.9414 433.108 12.9414C434.862 12.9414 436.438 13.0667 437.834 13.3173C439.266 13.5321 440.483 13.8006 441.485 14.1228C442.523 14.4092 443.365 14.7135 444.009 15.0357C444.689 15.3579 445.172 15.6085 445.459 15.7875L443.043 22.4999C441.897 21.8913 440.573 21.3722 439.069 20.9426C437.601 20.4772 435.99 20.2445 434.236 20.2445Z" fill="white"/>
                    <ellipse cx="27.5" cy="32.5" rx="14.5" ry="18.5" fill="white"/>
                    <path d="M32.8013 37.6352C32.8684 37.8813 32.8908 38.1274 32.8908 38.3512C32.9579 39.8055 32.309 41.3718 31.2574 42.3339C30.7652 42.759 29.9597 43.2065 29.3332 43.3855C27.3642 44.0791 25.3952 43.0946 24.2318 41.9535C26.335 41.4613 27.5656 39.9398 27.9683 38.3512C28.2368 36.9863 27.6775 35.8452 27.4537 34.5027C27.23 33.205 27.2747 32.1086 27.7446 30.9228C28.0802 31.5716 28.4382 32.2429 28.8634 32.7575C30.2058 34.5027 32.3314 35.2635 32.8013 37.6352ZM49.2243 32.7575C49.2243 45.0636 39.1557 55.132 26.8496 55.132C14.5435 55.132 4.47491 45.0636 4.47491 32.7575C4.47491 20.4514 14.5435 10.3828 26.8496 10.3828C39.1557 10.3828 49.2243 20.4514 49.2243 32.7575ZM38.395 34.0105L38.1712 33.563C37.8132 32.7575 36.8063 31.3703 36.8063 31.3703C36.4036 30.8557 35.9114 30.3858 35.4639 29.9383C34.278 28.8867 32.9579 28.1483 31.8168 27.0519C29.199 24.5012 28.6172 20.3172 30.2953 17.0952C28.6172 17.498 27.1629 18.393 25.9099 19.3998C21.3678 23.0245 19.5778 29.4013 21.7258 34.8831C21.7929 35.0621 21.8601 35.2411 21.8601 35.4648C21.8601 35.8452 21.5916 36.1809 21.2559 36.3374C20.8308 36.4941 20.4281 36.4046 20.1372 36.1137C20.0122 36.0496 19.9104 35.9479 19.8463 35.8228C17.8997 33.3393 17.5417 29.7593 18.8619 26.9177C15.9307 29.2894 14.3422 33.2945 14.5435 37.0534C14.6778 37.926 14.7673 38.7986 15.0805 39.6713C15.3266 40.7229 15.7965 41.7074 16.3335 42.6919C18.213 45.6901 21.502 47.8605 25.0373 48.2855C28.7962 48.7554 32.8237 48.0842 35.71 45.5111C38.932 42.6024 40.0507 37.9708 38.395 34.0105Z" fill="#A41E11"/>
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
