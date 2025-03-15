<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'current_password' => 'required_with:password|string',
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'Senha atual incorreta'], 403);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Perfil atualizado com sucesso',
            'user' => $user
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso']);
    }
}
