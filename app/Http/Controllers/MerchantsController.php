<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MerchantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Merchant::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_name' => 'required|string',
            'is_admin' => [
                'required',
                Rule::exists('users')->where(function (Builder $query) {
                    return $query->where('is_admin', true);
                }),
            ],
            'admin_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Merchant não cadastrado!',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        unset($data['is_admin']);
        $user = User::find($data['admin_id']);
        unset($data['admin_id']);

        $user->merchant()->create($data);

        return response()->json(['message' => 'Usuario cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return Merchant::find($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Merchant não existe']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'merchant_name' => 'required|string'
        ]);

        if ($validator->fails() || empty($id)) {
            return response()->json([
                'message' => 'Usuario não podera ser atualizado sem todas as informações!',
                'errors' => $validator->errors()
            ], 422);
        }

        Merchant::where('id', $id)->update($validator->validated());

        return response()->json(['message' => 'Usuario atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $merchant = Merchant::where('id', $id)->first();
            $merchant->delete();
            return response()->json(['message' => 'Usuario deletado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Não foi possivel remover este usuario!']);
        }
    }
}
