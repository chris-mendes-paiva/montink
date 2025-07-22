<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

         {{-- 1. jQuery Core (O MAIS IMPORTANTE E PRIMEIRO DE TUDO!) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- OU, se você baixou localmente para public/js/: --}}
    {{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script> --}}

    {{-- 2. Bootstrap JS (Seus componentes como "collapse" dependem dele) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    {{-- 3. DataTables Core JS --}}
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    {{-- Garanta que o caminho para jquery.dataTables.js esteja correto e o arquivo exista em public/js/ --}}

    {{-- 4. DataTables jQuery UI Integration JS (Se estiver usando o tema jQuery UI) --}}
    <script src="{{ asset('js/dataTables.jqueryui.js') }}"></script>
    {{-- Garanta que o caminho para dataTables.jqueryui.js esteja correto e o arquivo exista em public/js/ --}}

    {{-- 5. Outros plugins do DataTables e bibliotecas auxiliares que você usa em @include('layouts.js') --}}
    {{-- Seu `resources/views/layouts/js.blade.php` deve conter APENAS: --}}
    {{-- buttons.html5.min.js, buttons.flash.min.js, buttons.print.min.js, buttons.colVis.min.js, --}}
    {{-- jquery.multi-select.js, jszip.min.js, pdfmake.min.js, vfs_fonts.js, sweetalert2@10.js, --}}
    {{-- jquery.bootstrap-duallistbox.min.js --}}
    @include('layouts.js')

    {{-- 6. SEUS SCRIPTS PERSONALIZADOS (como o que está na sua view `produtos`) --}}
    {{-- Este @yield('scripts') é onde o conteúdo do @section('scripts') da sua view `produtos` será injetado. --}}
    {{-- Ele DEVE vir DEPOIS de todos os scripts das bibliotecas. --}}
    @yield('scripts')
    </div>
</body>
</html>
