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
<body style="background-color: #4f4f4f">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: #4f4f4f">
            <a class="navbar-brand" href="{{ route('computer_select') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        @if(\Illuminate\Support\Facades\Session::get('computer_id'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('computer.play') }}">{{ __('My Computer') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('shop') }}">{{ __('Shop') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('computer.inventory') }}">{{ __('Inventory') }}</a>
                            </li>
                            @if(count($mines) > 0)
                            <li class="nav-item dropdown">
                                <a id="programsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Programs') }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="programsDropdown">
                                    @foreach($mines as $mine)
                                        <a class="dropdown-item" href="{{ route('programs.miner', strtolower($mine->name)) }}">{{ __($mine->name) }}</a>
                                    @endforeach
                                </div>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('company.index') }}">{{ __('Company') }}</a>
                            </li>
                        @endif
                    @endauth
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
                        @if(isset($crypto_currencies))
                        <li class="nav-item dropdown balance-dropdown">
                            <a id="balanceDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->getBalance() }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="balanceDropdown">
                                @foreach($crypto_currencies as $currency => $value)
                                    <a class="dropdown-item" href="#" disabled>{{ number_format($value, 4) . ' ' . $currency }}</a>
                                @endforeach
                            </div>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" style="cursor: default">{{ Auth::user()->getBalance() }}</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }} <span class="caret"></span>
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
        </nav>

        <main class="py-4">
            @yield('content')
        </main>


        @include('modals.modals')
    </div>
</body>
</html>
