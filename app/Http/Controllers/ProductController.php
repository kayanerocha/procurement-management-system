<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Product/Index');
    }

    public function show(Product $product)
    {
        return Inertia::render('Product/Show', ['product' => $product]);
    }

    public function create()
    {
        return Inertia::render('Product/Create');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit', ['product' => $product]);
    }
}
