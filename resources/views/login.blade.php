@php
    $errors = ['message' => 'not found'];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../admin/vendor/TopLoaderService/TopLoaderService.css" />
    <script src="../admin/vendor/TopLoaderService/TopLoaderService.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="../admin/vendor/jquery/jquery.min.js"></script>
    <script src="../admin/src/plugins/sweetalert2/sweetalert2.js"></script>
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/TopLoaderService/TopLoaderService.css" />
    <script>
        const ErrorResponse = (data) => {
            if (data) {
                if (typeof data.message === 'string') {
                    // Jika ada properti 'message' dengan tipe string
                    return data.message;
                } else {
                    // Jika tidak ada properti 'message' atau bukan string, cek properti lainnya
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const value = data[key];
                            if (Array.isArray(value) && value.length > 0 && typeof value[0] === 'string') {
                                // Jika properti ini adalah array yang berisi string
                                return value[0]; // Ambil pesan pertama dari array
                            }
                        }
                    }
                }
            }
        }
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            // timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    </script>
    <style>
        * {
            margin: 0px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .LoginPageContainer {
            height: 100vh;
            overflow: auto;
        }

        .LoginPageInnerContainer {
            display: flex;
            min-height: 100%;
        }

        .LoginPageInnerContainer .ImageContianer {
            width: 50%;
            /* background-image: url('https://images.prismic.io/turing/652ec7adfbd9a45bcec81a41_Laravel_1f3f0a9d0c.webp?auto=format%2Ccompress&fit=max&w=3840'); */
            background-image: url("../admin/src/images/bg.jpg");
            background-size: cover;
            background-position: center;
            min-height: 100%;
            padding: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .LoginPageInnerContainer .ImageContianer .GroupImage {
            width: 100%;
            display: block;
        }

        .LoginPageInnerContainer .LoginFormContainer {
            flex-grow: 2;
            background-color: white;
            min-height: 100%;
            padding: 5%;
            background: url(https://i.imgur.com/BKyjjFa.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .LoginPageInnerContainer .LoginFormContainer .LogoContainer .logo {
            height: 60px;
            margin-bottom: 30px;
        }

        .LoginPageInnerContainer .LoginFormContainer .header {
            font-size: 32px;
            font-weight: 500;
        }

        .LoginPageInnerContainer .LoginFormContainer .subHeader {
            color: #9aa4ad;
            margin-top: 5px;
            margin-bottom: 40px;
        }

        .LoginPageInnerContainer .LoginFormContainer .inputContainer {
            color: #3f3f45;
            margin: 20px 0px;
        }

        .LoginPageInnerContainer .LoginFormContainer .inputContainer .label {
            display: flex;
            width: 100%;
            justify-content: flex-start;
            align-items: center;
            margin-right: 7px;
            margin-bottom: 10px;
        }

        .LoginPageInnerContainer .LoginFormContainer .inputContainer .label .labelIcon {
            width: 20px;
            margin-right: 10px;
            display: block;
        }

        .LoginPageInnerContainer .LoginFormContainer .inputContainer .input {
            display: block;
            width: calc(100% - 20px);
            font-size: 15px;
            padding: 10px;
            border: 1px solid #d6d7db;
            border-radius: 5px;
            margin-top: 5px;
            outline: 0px !important;
        }

        .LoginPageInnerContainer .LoginFormContainer .OptionsContainer {
            display: flex;
            justify-content: space-between;
        }

        .LoginFormContainer {
            display: flex;
            align-items: center;
        }

        .LoginFormInnerContainer {
            max-width: 500px;
        }

        .LoginPageInnerContainer .LoginFormContainer .checkbox {
            width: 15px;
            height: 15px;
            margin: 0px;
            display: block;
            border: 1px solid #d6d7db;
        }

        .LoginPageInnerContainer .LoginFormContainer .checkboxContainer {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .LoginPageInnerContainer .LoginFormContainer .checkboxContainer label {
            display: block;
            padding: 0px 5px;
            color: #9aa4ad;
        }

        .LoginPageInnerContainer .LoginFormContainer .ForgotPasswordLink {
            color: #e7483b;
            text-decoration: none;
        }

        .LoginFormContainer .LoginFormInnerContainer .LoginButton {
            margin-top: 30px;
            display: block;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            color: white;
            background-color: #000000;
            border: 0px;
            outline: 0px;
            cursor: pointer;
        }

        .LoginFormContainer .LoginFormInnerContainer .LoginButton:active {
            background-color: #4520ff;
        }

        .LoginFormContainer .LoginFormInnerContainer .GuestButton {
            text-align: center;
            margin-top: 30px;
            display: block;
            width: 100%;
            font-weight: bold;
            color: black;
            opacity: 0.9;
            border: 0px;
            outline: 0px;
            cursor: pointer;
        }

        .LoginFormContainer .LoginFormInnerContainer .GuestButton:hover {

            color: #3f3f45;
        }


        @@media only screen and (max-width: 1200px) {
            .LoginPageInnerContainer .ImageContianer {
                width: 50%;
            }
        }

        @@media only screen and (max-width: 800px) {
            .LoginPageInnerContainer .ImageContianer {
                display: none;
            }

            .LoginFormContainer {
                justify-content: center;
            }
        }

        .LoginPageContainer::-webkit-scrollbar {
            width: 5px;
        }

        .LoginPageContainer::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .LoginPageContainer::-webkit-scrollbar-thumb {
            background: #2e1f7a;
        }

        .LoginPageContainer::-webkit-scrollbar-thumb:hover {
            background: #4520ff;
        }

        #guest-button {
            margin: 40px;
            /* text-decoration: none; */
            color: white;
        }

        #guest-button:hover {
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="LoginPageContainer">
        <div class="LoginPageInnerContainer">
            <div class="ImageContianer"></div>
            <div class="LoginFormContainer">
                <div class="LoginFormInnerContainer">
                    <div class="LogoContainer" style="text-align: center">
                        {{-- <img src="https://www.pngkey.com/png/full/529-5291672_sample-logo-png-transparent-background.png" class="logo"> --}}
                        <h1>
                            <i>
                                <svg width="350" height="98" viewBox="0 0 711 98" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="90" height="90" transform="translate(0 7)" fill="white"/>
                                    <path opacity="0.8" d="M7.5 52C7.5 34.3225 7.5 25.4837 12.99 19.99C18.4875 14.5 27.3225 14.5 45 14.5C62.6775 14.5 71.5162 14.5 77.0062 19.99C82.5 25.4875 82.5 34.3225 82.5 52C82.5 69.6775 82.5 78.5162 77.0062 84.0062C71.52 89.5 62.6775 89.5 45 89.5C27.3225 89.5 18.4837 89.5 12.99 84.0062C7.5 78.52 7.5 69.6775 7.5 52Z" fill="#D61300"/>
                                    <path d="M63.75 54.5017C63.75 70.4992 50.415 74.5005 43.7512 74.5005C37.9125 74.5005 26.25 70.4992 26.25 54.5017C26.25 47.538 30.2363 43.1242 33.585 40.9005C35.115 39.8842 37.02 40.533 37.1175 42.3667C37.335 46.383 40.4287 49.608 42.8287 46.3792C45.0187 43.4242 46.1025 39.4117 46.1025 37.0005C46.1025 33.4492 49.695 31.1955 52.5037 33.3705C57.9712 37.608 63.75 44.7105 63.75 54.5017Z" stroke="white" stroke-width="4.16667"/>
                                    <path d="M147.245 81C145.772 78.7333 144.072 76.3533 142.145 73.86C140.218 71.3667 138.178 68.9583 136.025 66.635C133.928 64.3117 131.747 62.1017 129.48 60.005C127.213 57.9083 124.975 56.095 122.765 54.565V81H112.055V22.095H122.765V46.405C124.635 44.535 126.59 42.5517 128.63 40.455C130.67 38.3017 132.682 36.1483 134.665 33.995C136.705 31.785 138.632 29.66 140.445 27.62C142.258 25.58 143.902 23.7383 145.375 22.095H158.21C156.34 24.2483 154.357 26.4867 152.26 28.81C150.163 31.1333 148.01 33.485 145.8 35.865C143.59 38.1883 141.352 40.5117 139.085 42.835C136.875 45.1583 134.693 47.3683 132.54 49.465C134.92 51.2783 137.328 53.4033 139.765 55.84C142.258 58.22 144.695 60.7983 147.075 63.575C149.455 66.295 151.722 69.1567 153.875 72.16C156.085 75.1067 158.097 78.0533 159.91 81H147.245ZM209.094 81C208.301 78.6767 207.479 76.3817 206.629 74.115C205.779 71.8483 204.958 69.525 204.164 67.145H179.344C178.551 69.525 177.729 71.8767 176.879 74.2C176.086 76.4667 175.293 78.7333 174.499 81H163.364C165.574 74.71 167.671 68.9017 169.654 63.575C171.638 58.2483 173.564 53.205 175.434 48.445C177.361 43.685 179.259 39.1517 181.129 34.845C182.999 30.5383 184.926 26.2883 186.909 22.095H197.024C199.008 26.2883 200.934 30.5383 202.804 34.845C204.674 39.1517 206.544 43.685 208.414 48.445C210.341 53.205 212.296 58.2483 214.279 63.575C216.319 68.9017 218.444 74.71 220.654 81H209.094ZM191.754 33.485C190.451 36.4883 188.949 40.1433 187.249 44.45C185.606 48.7567 183.878 53.4317 182.064 58.475H201.444C199.631 53.4317 197.874 48.7283 196.174 44.365C194.474 40.0017 193.001 36.375 191.754 33.485ZM240.935 22.095C242.182 24.2483 243.57 26.8833 245.1 30C246.63 33.1167 248.188 36.4033 249.775 39.86C251.362 43.26 252.92 46.745 254.45 50.315C256.037 53.8283 257.482 57.0867 258.785 60.09C260.088 57.0867 261.505 53.8283 263.035 50.315C264.565 46.745 266.123 43.26 267.71 39.86C269.297 36.4033 270.855 33.1167 272.385 30C273.915 26.8833 275.303 24.2483 276.55 22.095H286.24C286.75 26.4017 287.232 30.9917 287.685 35.865C288.138 40.6817 288.535 45.64 288.875 50.74C289.272 55.7833 289.612 60.8833 289.895 66.04C290.235 71.14 290.518 76.1267 290.745 81H280.205C279.978 74.1433 279.695 67.0883 279.355 59.835C279.072 52.5817 278.618 45.555 277.995 38.755C277.372 40.0583 276.635 41.6167 275.785 43.43C274.935 45.2433 274.028 47.2267 273.065 49.38C272.102 51.4767 271.11 53.6583 270.09 55.925C269.127 58.1917 268.163 60.4017 267.2 62.555C266.293 64.6517 265.443 66.635 264.65 68.505C263.857 70.3183 263.177 71.8767 262.61 73.18H254.62C254.053 71.8767 253.373 70.29 252.58 68.42C251.787 66.55 250.908 64.5667 249.945 62.47C249.038 60.3167 248.075 58.1067 247.055 55.84C246.092 53.5733 245.128 51.3917 244.165 49.295C243.202 47.1983 242.295 45.2433 241.445 43.43C240.595 41.56 239.858 40.0017 239.235 38.755C238.612 45.555 238.13 52.5817 237.79 59.835C237.507 67.0883 237.252 74.1433 237.025 81H226.485C226.712 76.1267 226.967 71.0833 227.25 65.87C227.59 60.6567 227.93 55.5 228.27 50.4C228.667 45.2433 229.092 40.2567 229.545 35.44C229.998 30.6233 230.48 26.175 230.99 22.095H240.935ZM342.322 81C341.529 78.6767 340.707 76.3817 339.857 74.115C339.007 71.8483 338.185 69.525 337.392 67.145H312.572C311.779 69.525 310.957 71.8767 310.107 74.2C309.314 76.4667 308.52 78.7333 307.727 81H296.592C298.802 74.71 300.899 68.9017 302.882 63.575C304.865 58.2483 306.792 53.205 308.662 48.445C310.589 43.685 312.487 39.1517 314.357 34.845C316.227 30.5383 318.154 26.2883 320.137 22.095H330.252C332.235 26.2883 334.162 30.5383 336.032 34.845C337.902 39.1517 339.772 43.685 341.642 48.445C343.569 53.205 345.524 58.2483 347.507 63.575C349.547 68.9017 351.672 74.71 353.882 81H342.322ZM324.982 33.485C323.679 36.4883 322.177 40.1433 320.477 44.45C318.834 48.7567 317.105 53.4317 315.292 58.475H334.672C332.859 53.4317 331.102 48.7283 329.402 44.365C327.702 40.0017 326.229 36.375 324.982 33.485ZM377.562 21.5C386.062 21.5 392.551 23.0583 397.027 26.175C401.561 29.2917 403.827 34.0517 403.827 40.455C403.827 48.445 399.889 53.8567 392.012 56.69C393.089 57.9933 394.307 59.58 395.667 61.45C397.027 63.32 398.416 65.36 399.832 67.57C401.249 69.7233 402.609 71.9617 403.912 74.285C405.216 76.5517 406.377 78.79 407.397 81H395.412C394.336 78.96 393.174 76.92 391.927 74.88C390.681 72.7833 389.406 70.7717 388.102 68.845C386.856 66.8617 385.609 65.02 384.362 63.32C383.116 61.5633 381.954 60.005 380.877 58.645C380.084 58.7017 379.404 58.73 378.837 58.73C378.271 58.73 377.732 58.73 377.222 58.73H372.037V81H361.327V22.945C363.934 22.3783 366.711 22.01 369.657 21.84C372.604 21.6133 375.239 21.5 377.562 21.5ZM378.327 30.765C376.061 30.765 373.964 30.85 372.037 31.02V50.06H376.712C379.319 50.06 381.614 49.9183 383.597 49.635C385.581 49.3517 387.224 48.8417 388.527 48.105C389.887 47.3683 390.907 46.3767 391.587 45.13C392.267 43.8833 392.607 42.2967 392.607 40.37C392.607 38.5567 392.267 37.0267 391.587 35.78C390.907 34.5333 389.916 33.5417 388.612 32.805C387.366 32.0683 385.864 31.5583 384.107 31.275C382.351 30.935 380.424 30.765 378.327 30.765ZM465.456 61.62C465.456 64.51 465.145 67.2017 464.521 69.695C463.898 72.1883 462.793 74.37 461.206 76.24C459.676 78.11 457.58 79.5833 454.916 80.66C452.31 81.7367 448.995 82.275 444.971 82.275C441.231 82.275 437.973 81.765 435.196 80.745C432.476 79.6683 430.38 78.535 428.906 77.345L432.731 68.93C434.148 69.8933 435.876 70.8283 437.916 71.735C440.013 72.585 442.138 73.01 444.291 73.01C447.918 73.01 450.553 72.1033 452.196 70.29C453.84 68.4767 454.661 65.36 454.661 60.94V22.095H465.456V61.62ZM501.811 82.275C497.787 82.275 494.331 81.7083 491.441 80.575C488.551 79.385 486.142 77.7417 484.216 75.645C482.346 73.5483 480.957 71.0833 480.051 68.25C479.144 65.4167 478.691 62.3 478.691 58.9V22.095H489.486V57.88C489.486 60.5433 489.769 62.8383 490.336 64.765C490.959 66.635 491.809 68.165 492.886 69.355C494.019 70.545 495.322 71.4233 496.796 71.99C498.326 72.5567 500.026 72.84 501.896 72.84C503.766 72.84 505.466 72.5567 506.996 71.99C508.526 71.4233 509.829 70.545 510.906 69.355C512.039 68.165 512.889 66.635 513.456 64.765C514.079 62.8383 514.391 60.5433 514.391 57.88V22.095H525.186V58.9C525.186 62.3 524.704 65.4167 523.741 68.25C522.834 71.0833 521.417 73.5483 519.491 75.645C517.621 77.7417 515.212 79.385 512.266 80.575C509.319 81.7083 505.834 82.275 501.811 82.275ZM577.234 81C576.441 78.6767 575.619 76.3817 574.769 74.115C573.919 71.8483 573.097 69.525 572.304 67.145H547.484C546.691 69.525 545.869 71.8767 545.019 74.2C544.226 76.4667 543.432 78.7333 542.639 81H531.504C533.714 74.71 535.811 68.9017 537.794 63.575C539.777 58.2483 541.704 53.205 543.574 48.445C545.501 43.685 547.399 39.1517 549.269 34.845C551.139 30.5383 553.066 26.2883 555.049 22.095H565.164C567.147 26.2883 569.074 30.5383 570.944 34.845C572.814 39.1517 574.684 43.685 576.554 48.445C578.481 53.205 580.436 58.2483 582.419 63.575C584.459 68.9017 586.584 74.71 588.794 81H577.234ZM559.894 33.485C558.591 36.4883 557.089 40.1433 555.389 44.45C553.746 48.7567 552.017 53.4317 550.204 58.475H569.584C567.771 53.4317 566.014 48.7283 564.314 44.365C562.614 40.0017 561.141 36.375 559.894 33.485ZM635.935 81C634.008 77.77 631.855 74.3133 629.475 70.63C627.095 66.89 624.63 63.15 622.08 59.41C619.53 55.6133 616.923 51.9583 614.26 48.445C611.653 44.875 609.16 41.6733 606.78 38.84V81H596.24V22.095H604.995C607.261 24.475 609.698 27.3083 612.305 30.595C614.911 33.825 617.518 37.1967 620.125 40.71C622.788 44.2233 625.338 47.765 627.775 51.335C630.268 54.8483 632.478 58.135 634.405 61.195V22.095H645.03V81H635.935ZM686.699 30.17C680.636 30.17 675.989 32.0683 672.759 35.865C669.586 39.605 667.999 44.8183 667.999 51.505C667.999 54.6783 668.368 57.5967 669.104 60.26C669.898 62.8667 671.031 65.105 672.504 66.975C674.034 68.845 675.904 70.3183 678.114 71.395C680.381 72.415 683.016 72.925 686.019 72.925C687.889 72.925 689.504 72.8683 690.864 72.755C692.224 72.585 693.301 72.3867 694.094 72.16V50.995H704.804V79.3C703.331 79.8667 700.838 80.49 697.324 81.17C693.811 81.85 689.759 82.19 685.169 82.19C680.919 82.19 677.038 81.51 673.524 80.15C670.011 78.79 667.008 76.8067 664.514 74.2C662.078 71.5933 660.179 68.3917 658.819 64.595C657.459 60.7983 656.779 56.435 656.779 51.505C656.779 46.575 657.516 42.2117 658.989 38.415C660.519 34.6183 662.588 31.4167 665.194 28.81C667.801 26.1467 670.861 24.135 674.374 22.775C677.888 21.415 681.628 20.735 685.594 20.735C688.314 20.735 690.723 20.9333 692.819 21.33C694.973 21.67 696.814 22.0667 698.344 22.52C699.874 22.9733 701.121 23.455 702.084 23.965C703.104 24.475 703.813 24.8433 704.209 25.07L700.979 33.825C699.279 32.805 697.154 31.955 694.604 31.275C692.111 30.5383 689.476 30.17 686.699 30.17Z" fill="black"/>
                                    </svg>

                            </i>
                        </h1>
                        <br>
                    </div>
                    <header class="header">Masuk</header>
                    <header class="subHeader">Selamat Datang di <b>Kamar Juang</b>. Silahkan Login Terlebih Dahulu.</header>

                    <form>
                        @csrf
                        <div class="inputContainer">
                            <label class="label" for="username">
                                <i class="labelIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 256 256">
                                        <path fill="currentColor"
                                            d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z" />
                                    </svg>
                                </i>
                                <span>Nama Pengguna</span></label>
                            <input class="input" type="text" name="username" placeholder="Masukkan Nama Pengguna"
                                required>
                        </div>
                        <div class="inputContainer">
                            <label class="label" for="password">
                                <i class="labelIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 48 48">
                                        <circle cx="33.4" cy="14.8" r="3.9" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M20.4 20.4a11.47 11.47 0 0 1 5.2-13.3a11.31 11.31 0 0 1 14.1 2.3a11.32 11.32 0 0 1-13 17.9" />
                                        <path fill="none" stroke="currentColor"
                                            d="M20.4 20.4L5.5 37v5.4h6.1l.7-4.2l6.5-.4l.5-5.5l5.5-.1l1.8-4.8" />
                                    </svg>
                                </i>
                                <span>Kata Sandi</span></label>
                            <input name="password" class="input" type="password" placeholder="Masukkan Kata Sandi"
                                required>
                        </div>
                        <div style="color: red;">
                            <span id="error-message"></span>
                        </div>
                        <br>
                        {{-- todo: buat simpan kredensial, dimana ketika tercentang, maka akan menyimpan ke local storage --}}
                        <div class="OptionsContainer">
                            <div class="checkboxContainer">
                                <input type="checkbox" id="RememberMe" class="checkbox" name="remember"> <label
                                    for="RememberMe">Simpan Kredensial</label>
                            </div>
                            <a class="ForgotPasswordLink">Forgot Password?</a>
                        </div>
                        <button class="LoginButton" id="login-button">Login</button>
                        {{-- <a href="/guest" class="GuestButton">Guest</a> --}}
                    </form>
                    <script src="../admin/src/scripts/jquery.min.js"></script>
                    <script src="../admin/src/plugins/TopLoaderService/TopLoaderService.js"></script>
                    <script>
                        document.getElementById("login-button").addEventListener("click", (e) => {
                            e.preventDefault()
                            TopLoaderService.start();
                            $.ajax({
                                url: '/login',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                data: {
                                    username: $("input[name='username'").val(),
                                    password: $("input[name='password'").val()
                                },
                                dataType: "json",
                                success: function(response) {
                                    // Menampilkan pesan sukses jika ada
                                    // $("#error-message").text(response.message);
                                    // Mengarahkan ke halaman utama setelah login berhasil
                                    window.location.replace("{{ route('index', []) }}");
                                },
                                error: function(xhr, status, error) {
                                    // $("#error-message").text();
                                    Toast.fire({
                                        icon: "error",
                                        title: ErrorResponse(xhr.responseJSON)
                                    });
                                    if (xhr.status === 419) {
                                        location.reload()
                                    }
                                },
                                complete: function(data) {
                                    console.log(data);
                                    TopLoaderService.end();
                                }
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
