@extends('layouts.app_admin')

@section('title', 'Usuarios')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="contenedor-dudas">

        <!-- HEADER -->
        <div class="header-dudas">

            <div class="contenedor-titulo">
                <a href="{{ route('dashboard') }}" class="btn-regresar">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h1-gestion-dudas">Usuarios</h1>
            </div>

            <div class="acciones-header">

                <div class="search-container">
                    <span class="icono-busqueda">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="buscador" placeholder="Buscar por título..." value="{{ request('buscar') }}"
                        class="input-buscador">
                </div>

            </div>

        </div>
        
        <!-- TABLA -->
        <div class="card-tabla">
            <div class="tabla-responsive">
                <table class="tabla-dudas">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <!-- BADGE ROL -->
                                <td>
                                    <span
                                        class="badge 
                                {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <!-- ACCIONES -->
                                <td>
                                    <div class="acciones-duda">

                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-editar">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form id="delete-{{ $user->id }}"
                                            action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn-eliminar"
                                                onclick="confirmarEliminacion({{ $user->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay usuarios</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <!-- PAGINACIÓN -->
            <div class="paginacion">
                {{ $users->links() }}
            </div>

        </div>

    </div>

    <!-- SWEET ALERT -->
    <script>
        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Eliminar usuario?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-' + id).submit();
                }
            });
        }
    </script>

    <!-- BUSCADOR -->
    <script>
        const buscador = document.getElementById('buscador');

        let timeout;

        buscador.addEventListener('input', function() {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const url = new URL(window.location.href);

                if (this.value) {
                    url.searchParams.set('buscar', this.value);
                } else {
                    url.searchParams.delete('buscar');
                }

                window.location.href = url.toString();
            }, 500);
        });
    </script>

@endsection
