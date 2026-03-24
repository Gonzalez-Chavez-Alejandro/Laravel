<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // LISTAR
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $users = User::when($buscar, function ($query, $buscar) {
            $query->where('name', 'like', "%$buscar%")
                ->orWhere('email', 'like', "%$buscar%");
        })->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // FORM CREAR
    public function create()
    {
        return view('admin.users.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('created', 'Usuario creado correctamente');
    }

    // FORM EDITAR
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ACTUALIZAR
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // 🔥 OPCIONAL: actualizar contraseña solo si se envía
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed'
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('updated', 'Usuario actualizado correctamente');
    }

    // ELIMINAR
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('deleted', 'Usuario eliminado correctamente');
    }
}
