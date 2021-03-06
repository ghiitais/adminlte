<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Intranet
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                @auth
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{url('/actualites')}}">Actualités <span class="sr-only">(current)</span></a>
                                </li>
                                @endauth
                                @auth

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Annuaire
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{url('/services')}}">Services</a>
                                        <a class="dropdown-item" href="{{url('/collaborateurs')}}">Collaborateurs</a>

                                    </div>

                                </li>
                                @endauth

                                <li class="nav-item">
                                  @auth
                                    @if(\Auth::user()->is_admin == 1 )
                                    <a class="nav-link" href="{{url('admin/demandes')}}"> Demandes </a>
                                        @elseif(\Auth::user()->is_manager == 1)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Demandes
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{url('/mes_demandes')}}">Mes demandes</a>
                                                <a class="dropdown-item" href="{{url('manager/demandes')}}">Demandes des collaborateurs</a>
                                            </div>

                                        </li>

                                        @elseif(\Auth::user()->is_assistante == 1)
                                            <a class="nav-link" href="{{url('assistante/demandes_active')}}"> Demandes </a>
                                    @else
                                        <a class="nav-link" href="{{url('mes_demandes')}}"> Demandes </a>
                                    @endif

                                      @endauth
                                </li>
                                @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Evènements</a>
                                </li>
                                    @endauth
                                    @auth
                                        @if(\Illuminate\Support\Facades\Auth::user()-> is_admin == 1)

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Configurations
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{url('/ajouter_managers')}}">Managers</a>
                                                <a class="dropdown-item" href="{{url('/home')}}">Types de demandes</a>

                                            </div>

                                        </li>
                                            @endif
                                @endauth

                      <li class="nav-item">
                                    <a class="nav-link" href="{{url('ticketsShow')}}"> Tickets </a>
                                </li>


                            </ul>
                        </div>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   <img class="rounded-circle" src="/uploads/avatars/{{Auth::user()->avatar}}" style="width: 40px; height: 40px; left: 30px; top: 10px; ">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="/profile"> <i class="fa fa-user"></i> Profil </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> Se déconnecter </a>

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
    </div>
    @yield('script')
</body>
</html>
