<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'items.*.product_id' => 'required|exists:App\Models\Product,id',
            'items.*.quantity' => 'required|exists:App\Models\Product,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Pedido não cadastrado!',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        try {
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'status' => $data['status']
            ]);

            $order->products()->sync($data['items']);

            return response()->json(['message' => 'Pedido criado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Pedido não criado com sucesso!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return Order::with('products')->find($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Order não existe']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'items.*.product_id' => 'required|exists:App\Models\Product,id',
            'items.*.quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Pedido não atualizado!',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        try {
            $order = Order::find($id);
            $order->products()->sync($data['items']);

            return response()->json(['message' => 'Pedido atualizado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Pedido não atualizado com sucesso!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $merchant = Order::where('id', $id)->first();
            $merchant->delete();
            return response()->json(['message' => 'Order deletado com sucesso!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Não foi possivel remover este produto!']);
        }
    }

}