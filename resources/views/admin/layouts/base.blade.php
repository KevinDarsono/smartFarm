<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('meta_title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('/css/css-dist/main.min.css') }}">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/css/lib.css') }}">
    <!-- Masukkan script jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Masukkan script metisMenu -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.6/metisMenu.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Gaya untuk mengatur tata letak grafik */
        .chart-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .chart {
            width: 300px;
            height: 200px;
            margin-right: 10px;
        }
    </style>
    <style>
        .form-container {
            display: flex;
        }

        .form-box {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            margin-right: 20px;
        }

        .form-box:last-child {
            margin-right: 0;
        }
    </style>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
    integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('css')
</head>

<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header ">
        @include('admin.layouts.header')

        <div class="app-main">
            @include('admin.layouts.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @include('admin.layouts.components.page_title')
                    @yield('content')
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts-init/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts-init/toastr.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @stack('js')
    <script>
        window.addEventListener('show-message', function(event) {
            let type = event.detail.type;
            let message = event.detail.message;
            toastr.options = {
                "progressBar": true,
            }
            toastr[type](message, {
                timeOut: 500
            });
        });
    </script>

    @yield("javascript")
</body>

</html>
