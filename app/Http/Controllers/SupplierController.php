<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index()
    {
        return Inertia::render('Supplier/Index');
    }

    public function create()
    {
        return Inertia::render('Supplier/Create');
    }

    public function edit(Supplier $supplier)
    {
        return Inertia::render('Supplier/Edit', ['supplier' => $supplier]);
    }
}
