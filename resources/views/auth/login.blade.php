<x-guest-layout>

<div class="login-container">

    <div class="login-card">

        <x-auth-session-status :status="session('status')" />

        <h2 class="login-title">Iniciar sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >

                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                >

                <x-input-error :messages="$errors->get('password')" />
            </div>

            <!-- Remember -->
            <div class="form-options">

                <label class="remember">
                    <input type="checkbox" name="remember">
                    Recordarme
                </label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif

            </div>

            <button type="submit" class="login-btn">
                Iniciar sesión
            </button>

        </form>

        <p class="register-link">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Registrarse</a>
        </p>

    </div>

</div>

</x-guest-layout>