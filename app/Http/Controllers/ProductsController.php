<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required' ,
            'merchant_id' => 'required|exists:App\Models\Merchant,id',
        ]);

        $is_admin = Merchant::isMerchantAdmin();
        if (! $is_admin) {
            return response()->json([
                'message' => 'Você não tem permissão para cadastrar um produto',
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Product não cadastrado!',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        Product::create($data);

        return response()->json(['message' => 'Produto cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return Product::find($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Product não existe']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'merchant_id' => 'required|exists:App\Models\Merchant,id',
            'price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $is_admin = Merchant::isMerchantAdmin();
        if (! $is_admin) {
            return response()->json([
                'message' => 'Produto somente podera ser atualizado por admins!',
            ], 422);
        }

        if ($validator->fails() || empty($id)) {
            return response()->json([
                'message' => 'Product não podera ser atualizado sem todas as informações!',
                'errors' => $validator->errors()
            ], 422);
        }

        Product::where('id', $id)->update($validator->validated());

        return response()->json(['message' => 'Product atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $merchant = Product::where('id', $id)->first();
            $merchant->delete();
            return response()->json(['message' => 'Product deletado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Não foi possivel remover este produto!']);
        }
    }

}
