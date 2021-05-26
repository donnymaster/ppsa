<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @yield('css')
    <link rel="stylesheet" href="{{ mix('css/icon.css') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        @media print {
            .print-hide {
                display: none !important;
            }
            .box {
                width: 100% !important;
                box-shadow: none;
                border: none;
            }
            .content, .columns {
                width: 100%;
            }
            .recipe-img {
                max-width: 280px;
            }
            .text-center {
                text-align: center;
            }
            .fc-header-toolbar {
                display: none !important;
            }
            .fc-theme-standard .fc-list-day-cushion {
                border: 1px solid !important;
            }
            .fc-scroller {
                border: 1px solid;
            }
        }
    </style>
</head>
