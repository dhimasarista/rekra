<!DOCTYPE html>
<html>

<head>
    {{-- Basic Page Info --}}
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>Rekra</title>
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
                        <span class="user-name d-inline">Hai, {{ session()->get('name') }}</span>
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
            <a href="/">Rekra 2024
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
