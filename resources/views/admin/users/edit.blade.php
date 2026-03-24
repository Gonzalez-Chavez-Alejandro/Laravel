@extends('layouts.app_admin')

@section('title', 'Gestión - Usuarios Edición')

@section('content')

<!-- CDN de FontAwesome para iconos profesionales -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com">
<!-- CDN de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net"></script>

<style>
    .card-form {
        width: 100%;
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        font-family: 'Inter', sans-serif;
    }

    .header-form h2 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1f2937;
        text-align: center;
    }

    .form-grid {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    label {
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #4b5563;
    }

    input, select {
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        font-size: 15px;
        transition: all 0.2s;
        background: #f9fafb;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    /* CONTENEDOR PASSWORD E ICONO */
    .input-password-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .toggle-eye {
        position: absolute;
        right: 14px;
        top: 40px; /* Ajustado para centrar con el input debajo del label */
        cursor: pointer;
        color: #9ca3af;
        font-size: 18px;
        transition: color 0.2s;
        z-index: 10;
    }

    .toggle-eye:hover {
        color: #2563eb;
    }

    /* BOTONES */
    .btn-toggle-password {
        padding: 10px;
        background: #f3f4f6;
        border: 1px dashed #d1d5db;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 500;
        color: #4b5563;
        transition: all 0.2s;
    }

    .btn-toggle-password:hover {
        background: #e5e7eb;
    }

    .btn-guardar {
        width: 100%;
        margin-top: 25px;
        padding: 14px;
        background: #111827;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-guardar:hover {
        opacity: 0.9;
    }

    /* ANIMACIÓN SECCIÓN PASSWORD */
    #passwordFields {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #passwordFields.active {
        max-height: 400px;
        opacity: 1;
        margin-top: 15px;
    }

    /* Quitar estilos por defecto de navegadores */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear { display: none; }
</style>

<div class="card-form">

    <div class="header-form">
        <h2>Editar Usuario</h2>
    </div>

    <form id="editUserForm" method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Ej. Juan Pérez">
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="correo@ejemplo.com">
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
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña">
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
