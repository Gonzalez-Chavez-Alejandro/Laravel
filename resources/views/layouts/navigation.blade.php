<nav x-data="{ open: false }" class="navbar">
    <style>

    </style>
    <div class="navbar-container">
        <div class="navbar-row">

            <!-- Left side -->
            <div class="navbar-left">

                <!-- Logo -->
                <div class="navbar-logo">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="logo-img" />
                    </a>
                </div>

                <!-- Links -->
                <div class="navbar-links">
                    <x-nav-link class="nav-item" :href="route('home')" :active="request()->routeIs('home')">
                        Inicio
                    </x-nav-link>

                    <x-nav-link class="nav-item" :href="route('dudas.index')" :active="request()->routeIs('dudas.*')">
                        Temas
                    </x-nav-link>

                    <x-nav-link class="nav-item" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Contacto
                    </x-nav-link>
                </div>

            </div>

            <!-- Right side -->
            <div class="navbar-right">

                @auth
                    <div x-data="{ openUser: false }" class="user-menu">

                        <!-- Botón usuario -->
                        <button @click="openUser = !openUser" class="user-button">
                            {{ Auth::user()->name }}
                            <span class="arrow">▾</span>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="openUser" @click.outside="openUser=false" class="user-dropdown">

                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="item-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Perfil
                            </a>

                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="item-icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                                    </svg>
                                    Panel
                                </a>
                            @endif



                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout">

                                    <span class="logout-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                        </svg>
                                    </span>

                                    Cerrar sesión

                                </button>
                            </form>

                        </div>

                    </div>
                @endauth

                @guest
                    <div class="auth-buttons">

                        <a href="{{ route('login') }}" class="btn-auth">
                            Login
                        </a>

                        <a href="{{ route('register') }}" class="btn-auth">
                            Register
                        </a>

                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="navbar-hamburger">
                <button @click="open = !open" class="hamburger-btn">
                    ☰
                </button>
            </div>

        </div>
        <!-- MOBILE MENU -->
        <div x-show="open" class="mobile-menu">

            <x-nav-link class="mobile-link" :href="route('home')" :active="request()->routeIs('home')">
                Inicio
            </x-nav-link>

            <x-nav-link class="mobile-link" :href="route('dudas.index')" :active="request()->routeIs('dudas.*')">
                Temas
            </x-nav-link>

            <x-nav-link class="mobile-link" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Contacto
            </x-nav-link>

        </div>
    </div>

</nav>
