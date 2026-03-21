<x-guest-layout>

<div class="login-container">

    <div class="login-card">

        <h2 class="login-title">Crear cuenta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label>Nombre</label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                >

                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
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

            <!-- Confirm Password -->
            <div class="form-group">
                <label>Confirmar Password</label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                >

                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <button type="submit" class="login-btn">
                Crear cuenta
            </button>

        </form>

        <p class="register-link">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </p>

    </div>

</div>

</x-guest-layout>