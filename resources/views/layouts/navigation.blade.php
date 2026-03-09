<nav x-data="{ open: false }" class="bg-white border-b-2 border-gray-500">
   
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-15 items-center">

            <!-- Left side -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center h-20">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-16 w-auto" />
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex h-20">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dudas.index')" :active="request()->routeIs('dudas.*')">
                        {{ __('Temas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Contacto') }}
                    </x-nav-link>
                </div>
            </div>

           
            <div class="hidden sm:flex sm:items-center sm:ms-4">

                {{-- ================= AUTH ================= --}}
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                                       text-gray-500 bg-white hover:text-gray-700
                                       focus:outline-none transition ease-in-out duration-150">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                
                @guest
                    <div class="flex items-center gap-2">

                       
                        @if (request()->routeIs('login'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700
                                      border border-gray-300 rounded-md
                                      hover:bg-gray-100 transition">
                                {{ __('Register') }}
                            </a>

                           
                        @elseif (request()->routeIs('register'))
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700
                                      border border-gray-300 rounded-md
                                      hover:bg-gray-100 transition">
                                {{ __('Login') }}
                            </a>

                           
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700
                                      border border-gray-300 rounded-md
                                      hover:bg-gray-100 transition">
                                {{ __('Login') }}
                            </a>

                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700
                                      border border-gray-300 rounded-md
                                      hover:bg-gray-100 transition">
                                {{ __('Register') }}
                            </a>
                        @endif

                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md
                           text-gray-400 hover:text-gray-500 hover:bg-gray-100
                           focus:outline-none focus:bg-gray-100 focus:text-gray-500
                           transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">

                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth

                @guest
                    @if (request()->routeIs('login'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @elseif (request()->routeIs('register'))
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                @endguest

            </div>
        </div>
    </div>
</nav>
