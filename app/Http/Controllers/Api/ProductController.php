<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
       $products = Product::all();
       return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'description' => [
                'required',
                'max:500',
            ],
            'internal_code' => [
                'required',
                Rule::unique('products', 'internal_code'),
                'max:10',
            ],
            'status' => 'required|boolean|between:0,1'
        ]);

        $product = null;
        try {
            $product = Product::create($request->post());
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar produto: $e");

            return response()->json([
                'message' => 'Erro ao cadastrar fornecedor, entre em contato com um administrador.',
                'supplier' => $product,
            ]);
        }

        return response()->json([
            'message' => 'Fornecedor cadastrado com sucesso.',
            'supplier' => $product,
        ]);
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $request->validate([
            'name' => 'required|min:2|max:50',
            'description' => [
                'required',
                'max:500',
            ],
            'internal_code' => [
                'required',
                Rule::when($product->internal_code != $request->post('internal_code'), Rule::unique('products', 'internal_code')),
                'max:10',
            ],
            'status' => 'required|boolean|between:0,1'
        ]);

        $newProduct = null;
        try {
            $newProduct = $product->update($request->post());
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar produto: $e");

            return response()->json([
                'message' => 'Erro ao atualizar fornecedor, entre em contato com um administrador.',
                'supplier' => $product,
            ]);
        }

        return response()->json([
            'message' => 'Produto cadastrado com sucesso.',
            'supplier' => $newProduct,
        ]);
    }
}
