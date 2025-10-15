<meta charset="utf-8" />
<title>Krishna Travels</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- Bootstrap Css -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" id="app-style" type="text/css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .boldclass {
        font-weight: bold;
    }

    .form-check-input {
        width: 2em;
        height: 1em;
        background-color: #e4e4e4;
        border-radius: 1em;
        position: relative;
        appearance: none;
        outline: none;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .form-check-input:checked {
        background-color: #4caf50;
    }

    .form-check-input::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 0.8em;
        height: 0.8em;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out;
    }

    .form-check-input:checked::before {
        transform: translateX(1em);
    }

    .error {
        color: red;
    }

    .d-none {
        display: none;
    }

    .read-more-toggle {
        cursor: pointer;
        font-weight: 600;
        display: block;
        margin-top: 8px;
    }

    .html-read-more-content {
        width: 100%;
        max-width: 350px;
        white-space: normal;
        word-wrap: break-word;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .html-read-more-content {
            max-width: 100%;
        }
    }

    .text-uppercase {
        text-transform: uppercase;
    }
</style>
@yield('style')

<script src="{{ asset('assets/js/plugin.js') }}"></script>