<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Rentals Management System') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }} "> <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>

<body>

    <div id="menubar">
        <!-- Menu Bar -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="menu">
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li><a href="{{route('user.index')}}">Users</a></li>
                        <li><a href="{{route('company.index')}}">Companies</a></li>
                        <li><a href="{{route('property.index')}}">Properties</a></li>
                        <li><a href="{{route('room.index')}}">Rooms</a></li>
                        <li><a href="{{route('roomAssignment.index')}}">Assignments</a></li>
                        <li><a href="{{route('rent.index')}}">Rents</a></li>
                        <li><a href="{{route('payment.index')}}">Payments</a></li>
                        <li><a href="">Reports</a></li>
                        <li><a href="">Settings</a></li>
                        <li>

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Hi {{ auth()->user()->name }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('user.edit', auth()->user()->id)}}">Update profile</a>
                                    {{-- <a class="dropdown-item" href="">Change Password</a> --}}
                                    <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit()">Log Out</a>
                                </div>
                                <form method="post" id="logoutForm" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </div>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- /Menu Bar -->


    @yield('content')
    @include('layouts.partials.chat')

    @stack('scripts')

    <!-- FOOTER -->
    <div id="footer" class="mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span>© Copyright {{ now()->format("Y") }} <a href="">Jumaae</a></span>
                </div>
            </div>
        </div>
    </div>
    <!-- /FOOTER -->
    <a href='https://nodejs-chat-fi0c.onrender.com/' style="visibility: hidden;"></a>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
</body>

</html>