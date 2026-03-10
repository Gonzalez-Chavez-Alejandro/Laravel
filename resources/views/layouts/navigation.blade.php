<nav x-data="{ open: false }" class="navbar">
<style>
    /* NAVBAR */
.navbar{
    background: white;
    border-bottom: 2px solid #6b7280;
}

/* CONTENEDOR */
.navbar-container{
    max-width: 1280px;
    margin: auto;
    padding: 0 20px;
}

/* FILA */
.navbar-row{
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 80px;
}

/* IZQUIERDA */
.navbar-left{
    display: flex;
    align-items: center;
    gap: 40px;
}

/* LOGO */
.logo-img{
    height: 48px;
    width: auto;
}

/* LINKS */
.navbar-links{
    display: flex;
    gap: 30px;
}

/* DERECHA */
.navbar-right{
    display: flex;
    align-items: center;
}

/* BOTONES LOGIN REGISTER */
.auth-buttons{
    display: flex;
    gap: 10px;
}

.btn-auth{
    padding: 8px 16px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    text-decoration: none;
    color: #374151;
    font-size: 14px;
    transition: 0.2s;
}

.btn-auth:hover{
    background: #f3f4f6;
}

/* HAMBURGER */
.navbar-hamburger{
    display: none;
}

.hamburger-btn{
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
}

/* RESPONSIVE */
@media (max-width: 768px){

    .navbar-links{
        display: none;
    }

    .navbar-hamburger{
        display: block;
    }

}
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

                <!-- Desktop Links -->
                <div class="navbar-links">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Inicio
                    </x-nav-link>

                    <x-nav-link :href="route('dudas.index')" :active="request()->routeIs('dudas.*')">
                        Temas
                    </x-nav-link>

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Contacto
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side -->
            <div class="navbar-right">

                @auth
                <div class="user-menu">
                    <span>{{ Auth::user()->name }}</span>
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
    </div>

</nav>