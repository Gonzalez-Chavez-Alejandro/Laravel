@extends('layouts.app_admin')

@section('title', 'Gestión - Usuarios Edición')

@section('content')

    <!-- CDN de FontAwesome para iconos profesionales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com">
    <!-- CDN de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net"></script>

    <style>


    </style>

    <div class="card-form">
        <div class="contenedor-titulo">
            <a href="{{ route('admin.users.index') }}" class="btn-regresar">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-form">
                <h2>Editar Usuario</h2>
            </div>
        </div>


        <form id="editUserForm" method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        placeholder="Ej. Juan Pérez">
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="correo@ejemplo.com">
                </div>

                <div class="form-group">
                    <label>Rol de Usuario</label>
                    <select name="role">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario Estándar</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="button" id="togglePasswordBtn" class="btn-toggle-password">
                        <i class="fa-solid fa-key" style="margin-right: 8px;"></i> Cambiar contraseña
                    </button>
                </div>

            </div>

            <!-- SECCIÓN DE PASSWORDS -->
            <div id="passwordFields">
                <div class="form-group input-password-wrapper">
                    <label>Nueva contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
                    <span class="toggle-eye" onclick="togglePasswordVisibility('password', this)">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>

                <div class="form-group input-password-wrapper" style="margin-top: 15px;">
                    <label>Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Repite la contraseña">
                    <span class="toggle-eye" onclick="togglePasswordVisibility('password_confirmation', this)">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-guardar">
                Actualizar Datos
            </button>

        </form>
    </div>

    <script>
        const btn = document.getElementById('togglePasswordBtn');
        const fields = document.getElementById('passwordFields');
        const form = document.getElementById('editUserForm');

        // Mostrar/Ocultar campos de contraseña
        btn.addEventListener('click', () => {
            fields.classList.toggle('active');
            if (fields.classList.contains('active')) {
                btn.innerHTML = '<i class="fa-solid fa-xmark" style="margin-right: 8px;"></i> Cancelar cambio';
                btn.style.color = '#dc2626';
            } else {
                btn.innerHTML = '<i class="fa-solid fa-key" style="margin-right: 8px;"></i> Cambiar contraseña';
                btn.style.color = '#4b5563';
                // Limpiar inputs si se cancela
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';
            }
        });

        // Función para ver/ocultar texto de contraseña
        function togglePasswordVisibility(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Ejemplo de integración con SweetAlert2 al enviar
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Guardar cambios?',
                text: "Se actualizará la información del usuario",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

@endsection
