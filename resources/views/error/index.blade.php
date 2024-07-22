<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>{{ $title ?? '' }}</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/styles/style.css') }}" />
</head>

<body>
    <div class="pd-10 pt-100">
        <div class="error-page text-center" style="display: block; align-items: center; justify-content: center;">
            <h1 class="headline text-danger" id="error-code"></h1>

            <div class="error-content">
                <h3><i class="fa fa-exclamation-triangle text-danger"></i> <span id="error-title"></span></h3>

                <p id="error-message">

                </p>

                <div>
                    @if (!session()->has('user') || trim(session('user')) == '')
                        <a href="{{ url('/') }}">Back To Home</a>
                    @else
                        <a href="{{ url('/rekapitulasi') }}">Back To Dashboard</a>
                    @endif
                </div>
            </div>
            <!-- /.error-content -->
        </div>
    </div>
    <script>
        // Query 404: ?code=404&title=Page+Not+Found&message=It+looks+like+you+found+a+glitch+in+the+matrix...
        // Query 500: ?code=500&title=Internal+Server+Error&message=We+will+fix+it+as+soon+as+possible...
        const urlParams = new URLSearchParams(window.location.search);
        const errorCode = urlParams.get("code");
        const errorTitle = urlParams.get("title");
        const errorMessage = urlParams.get("message");

        const errorMessageElement = document.getElementById("error-message");
        const errorCodeElement = document.getElementById("error-code");
        const errorTitleElement = document.getElementById("error-title");

        errorCodeElement.setAttribute("data-text", errorCode);
        errorCodeElement.innerText = errorCode;
        errorTitleElement.innerText = errorTitle;
        errorMessageElement.innerText = errorMessage;
    </script>

</body>

</html>
