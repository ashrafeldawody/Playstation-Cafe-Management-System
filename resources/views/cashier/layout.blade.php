<html lang="ar" dir="rtl">
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">جيم اون</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">الأجهزة</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">الكافية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ايراد اليوم</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">المصروفات</a>
                </li>
            </ul>

        </div>
    </div>
</nav>


    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
