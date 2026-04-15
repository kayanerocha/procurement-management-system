<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\LinkSupplierToProduct;
use App\Jobs\UnlinkSupplierToProduct;
use App\Jobs\UpdateProductSupplier;
use App\Models\Product;
use App\Models\Supplier;
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

            return response()->json(
                [
                    'message' => 'Erro ao atualizar fornecedor, entre em contato com um administrador.',
                    'supplier' => $product,
                ],
                500
            );
        }

        return response()->json([
            'message' => 'Produto cadastrado com sucesso.',
            'supplier' => $newProduct,
        ]);
    }

    public function linkedSuppliers(Request $request, string $id)
    {
        $product = Product::find($id);
        return response()->json($product->suppliers);
    }

    public function unrelatedSuppliers(Request $request, string $id)
    {
        $product = Product::find($id);
        $suppliers = Supplier::whereDoesntHave('products', function ($query) use ($id) {
            $query->where('products.id', (int) $id);
        })->get();
        return response()->json($suppliers);
    }

    public function linkSuppliers(Request $request, string $productId)
    {
        try {
            $selectedSuppliers = $request->post('selectedSuppliers');     
            
            dispatch(new LinkSupplierToProduct($productId, $selectedSuppliers));
            
            return response()->json(
                [
                    'message' => 'Processamento em andamento.'
                ],
                202
            );  
        } catch (Exception $e) {
            Log::error("Erro ao desvincular parceiros: $e");

            return response()->json(
                [
                    'message' => 'Erro ao desvincular parceiros, contate um administrador.',
                ],
                500
            );
        }
    }

    public function unlinkSuppliers(Request $request, string $productId)
    {
        try {
            $selectedSuppliers = $request->post('selectedSuppliers');     
            
            dispatch(new UnlinkSupplierToProduct($productId, $selectedSuppliers));
            
            return response()->json(
                [
                    'message' => 'Processamento em andamento.'
                ],
                202
            );  
        } catch (Exception $e) {
            Log::error("Erro ao vincular parceiros: $e");

            return response()->json(
                [
                    'message' => 'Erro ao vincular parceiros, contate um administrador.',
                ],
                500
            );
        }
    }
}
