<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Companies</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Properties</a></li>
                <li><a href="{{route('contactUs')}}" class="nav-link px-2 text-white">Contacts</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
            </form>

            @auth
            {{auth()->user()->name}}
            <div class="text-end">
                <a class="btn btn-outline-light me-2" href="#" onclick="document.getElementById('logoutForm').submit()">Log Out</a>
            </div>
            @endauth

            @guest
            <div class="text-end">
                <a href="{{route('user.login.form')}}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{route('user.register.form')}}" class="btn btn-warning">Sign-up</a>
            </div>
            @endguest
        </div>
    </div>
</header>

<body>

    @yield('content')

    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span>© Copyright {{ now()->format("Y") }} <a href="https://www.yahoobaba.net">Jumaae</a></span>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
</body>