<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
       $orders = Order::all();
       return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id'),
            ],
            'notes' => [
                'required',
                'max:2000',
            ],
        ]);

        if (!Supplier::find($request->post('supplier_id'))->status) {
            throw ValidationException::withMessages(['supplier_id' => 'Parceiro inativo.']);
        }

        $order = null;

        $data = $request->post();
        $data['status'] = 'Aberto';
        try {
            $order = Order::create($data);
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar produto: $e");

            return response()->json([
                'message' => 'Erro ao criar pedido, entre em contato com um administrador.',
                'supplier' => $order,
            ]);
        }

        return response()->json([
            'message' => 'Pedido criado com sucesso.',
            'supplier' => $order,
        ]);
    }

    public function show(string $id)
    {
        $order = Order::find($id);
        return response()->json($order);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        $request->validate([
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id'),
            ],
            'notes' => [
                'required',
                'max:2000',
            ],
        ]);

        $newOrder = null;
        try {
            $newOrder = $order->update($request->post());
        } catch (Exception $e) {
            Log::error("Erro ao criar pedido: $e");

            return response()->json([
                'message' => 'Erro ao atualizar pedido, entre em contato com um administrador.',
                'supplier' => $order,
            ]);
        }

        return response()->json([
            'message' => 'Pedido criado com sucesso.',
            'supplier' => $newOrder,
        ]);
    }
}
