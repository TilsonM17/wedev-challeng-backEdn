<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'is_admin' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Usuario não cadastrado!',
                'errors' => $validator->errors()
            ], 422);
        }

        User::create($validator->validated());

        return response()->json(['message' => 'Usuario cadastrado com sucesso!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'is_admin' => 'required|boolean',
        ]);

        if ($validator->fails() || empty($id)) {
            return response()->json([
                'message' => 'Usuario não podera ser atualizado sem todas as informações!',
                'errors' => $validator->errors()
            ], 422);
        }

        User::where('id', $id)->update($validator->validated());

        return response()->json(['message' => 'Usuario atualizado com sucesso!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->delete();
            return response()->json(['message' => 'Usuario deletado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Não foi possivel remover este usuario!']);
        }
    }
}
