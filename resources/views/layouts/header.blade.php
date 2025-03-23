<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid px-2 px-md-4 align-items-center">
            <a class="navbar-brand d-flex" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Categories </a>
                    </li>
                </ul>

                <div class="d-flex">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary me-2">
                            <i class="fa-solid fa-user-plus"> </i>
                            {{ __('Sign Up') }}
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fa-solid fa-sign-in-alt"> </i>
                            {{ __('Sign In') }}
                        </a>
                    @else
{{--                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Личный кабинет</a>--}}
                        Authorized
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-sign-out-alt"></i> {{ __('Sign Out') }}
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>
