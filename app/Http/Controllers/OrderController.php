<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Order/Index');
    }

    public function show(Order $order)
    {
        return Inertia::render('Order/Show', ['order' => $order]);
    }

    public function create()
    {
        return Inertia::render('Order/Create');
    }

    public function edit(Order $order)
    {
        return Inertia::render('Order/Edit', ['order' => $order]);
    }
}
