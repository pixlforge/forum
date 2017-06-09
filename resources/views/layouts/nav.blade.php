<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Threads</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/threads">All Threads</a>
                        <a class="dropdown-item" href="/threads?popular=1">Most Popular</a>
                        @if (auth()->check())
                            <a class="dropdown-item" href="/threads?by={{ auth()->user()->name }}">My Threads</a>
                        @endif
                        <a class="dropdown-item" href="/threads/create">New Thread</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Channels</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($channels as $channel)
                            <a class="dropdown-item" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a>
                        @endforeach()
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (Auth::guest())
                            Account
                        @else
                            {{ Auth::user()->name }}
                        @endif
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if (Auth::guest())
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                            <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                        @else
                            <a href="{{ route('profile', Auth::user()) }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                </li>

            </ul>

        </div>
    </div>
</nav>