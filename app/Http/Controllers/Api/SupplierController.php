<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $suppliers = Supplier::all();
       return response()->json($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'cnpj' => [
                'required',
                Rule::unique('suppliers', 'cnpj'),
                'min:14',
                'max:14',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('suppliers', 'email'),
                'max:50',
            ],
            'phone' => [
                'required',
                Rule::unique('suppliers', 'phone'),
                'min:11',
                'max:11',
            ],
            'status' => 'required|boolean|between:0,1'
        ]);

        $supplier = null;
        try {
            $supplier = Supplier::create($request->post());
        } catch (Exception $e) {
            Log::error("Erro ao cadastrar fornecedor: $e");

            return response()->json([
                'message' => 'Erro ao cadastrar fornecedor, entre em contato com um administrador.',
                'supplier' => $supplier,
            ]);
        }

        return response()->json([
            'message' => 'Fornecedor cadastrado com sucesso.',
            'supplier' => $supplier,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'cnpj' => [
                'required',
                Rule::unique('suppliers', 'cnpj'),
                'min:14',
                'max:14',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('suppliers', 'email'),
                'max:50',
            ],
            'phone' => [
                'required',
                Rule::unique('suppliers', 'phone'),
                'min:11',
                'max:11',
            ],
            'status' => 'required|boolean|between:0,1'
        ]);

        $supplier = null;
        try {
            $supplier = Supplier::find($id)->update($request->post());
        } catch (Exception $e) {
            Log::error("Erro ao atualizar fornecedor: $e");

            return response()->json([
                'message' => 'Erro ao atualizar fornecedor, entre em contato com um administrador.',
                'supplier' => $supplier,
            ]);
        }

        return response()->json([
            'message' => 'Fornecedor atualizado com sucesso.',
            'supplier' => $supplier,
        ]);
    }

    public function activeSuppliers()
    {
        Log::info('aqui');
        throw new Exception();
        $suppliers = Supplier::where('status', 1)->get();
        Log::info($suppliers);
        return response()->json($suppliers);
    }
}
