@if (auth()->check())
    <header class="p-3 mb-3 border-bottom bg-light">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.discover') }}</a></li>
                    <li><a href="{{ route('avatars.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.avatar_shop') }}</a></li>
                    <li><a href="{{ route('coins.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.topup') }}</a></li>
                    <li><a href="{{ route('chats.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.chats') }}</a></li>
                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('profile/' . auth()->user()->picture) }}" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="{{ route('chats.index', ['locale' => app()->getLocale()]) }}">{{ __('navbar.friend_list') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('friends.friend_requests', ['locale' => app()->getLocale()]) }}">{{ __('navbar.friend_request') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.avatar', ['locale' => app()->getLocale()]) }}">{{ __('navbar.my_avatars') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.settings', ['locale' => app()->getLocale()]) }}">{{ __('navbar.settings') }}</a></li>
                        <li><a class="dropdown-item" href="#">{{ __('navbar.profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-coins">
                            <a class="dropdown-item" href="{{ route('coins.index', ['locale' => app()->getLocale()]) }}">{{ __('navbar.your_coin', ['coins' => auth()->user()->coins]) }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('auth.logout', ['locale' => app()->getLocale()]) }}">{{ __('navbar.sign_out') }} | <small>{{ auth()->user()->name }}</small></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
@else
    <header class="p-3 bg-light">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.discover') }}</a></li>
                    <li><a href="{{ route('avatars.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.avatar_shop') }}</a></li>
                    <li><a href="{{ route('coins.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.topup') }}</a></li>
                    <li><a href="{{ route('chats.index', ['locale' => app()->getLocale()]) }}" class="nav-link px-2 text-dark">{{ __('navbar.chats') }}</a></li>
                </ul>

                <div class="text-end">
                    <a href="{{ route('auth.login', ['locale' => app()->getLocale()]) }}" type="button" class="btn btn-outline-dark me-2">{{ __('navbar.login') }}</a>
                    <a href="{{ route('auth.register', ['locale' => app()->getLocale()]) }}" type="button" class="btn btn-outline-dark">{{ __('navbar.register') }}</a>
                </div>
            </div>
        </div>
    </header>
@endif
