<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>

</head>
<body>
<div class="grid grid-cols-6 overflow-hidden p-5">
    <div class="col-span-1">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    لوحة التحكم
                </div>
                <nav class="mt-5 flex-1 px-2 bg-white space-y-1">
                    @foreach(config('dashboard.menu') as $item)
                        <a href="{{$item['route']}}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="{{$item['icon']}} mx-3"></i>
                            {{$item['name']}}
                        </a>
                    @endforeach
                </nav>
            </div>

        </div>
    </div>
    <div class="col-span-5 flex flex-column-reverse flex-1">
        <main class="flex-1">
            <div class="">
                <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        @yield('title')
                    </h1>
                </div>
                @yield('content')
            </div>
        </main>
    </div>
</div>

</body>
</html>
