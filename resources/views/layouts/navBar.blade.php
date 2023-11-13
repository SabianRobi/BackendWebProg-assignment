<nav class="page-navbar" data-spy="affix" data-offset-top="10">
    <ul class="nav-navbar container">
        <li class="nav-item"><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="{{ route('welcome') }}#about" class="nav-link">About us</a></li>
        <li class="nav-item">
            <a href="{{ route('welcome') }}" class="nav-link">
                <i class="fa-solid fa-desktop" id="logo"></i>
            </a>
        </li>
        <li class="nav-item"><a href="{{ route('welcome') }}#items" class="nav-link">Items</a></li>
        <li class="nav-item">
            <div class="dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user" id="profile"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    @guest
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li>Welcome, {{ Auth::user()->name }}</li>
                        @if (Auth::user()->is_admin)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('labels.create') }}">Add label</a></li>
                            <li><a class="dropdown-item" href="{{ route('items.create') }}">Add item</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                Logout
                            </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    @endguest
                </ul>
            </div>
        </li>
    </ul>
</nav>
