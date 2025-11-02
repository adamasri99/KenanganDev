<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptManagementController extends Controller
{
    public function index()
    {
        $receipts = \App\Models\Receipt::paginate(10);
        $monthlyCount = \App\Models\Receipt::whereMonth('created_at', now()->month)->count();
        $totalAmount = \App\Models\Receipt::sum('amount');
        $categoryCount = \App\Models\Receipt::distinct('category')->count();
        
        return view('laravel-examples.Receipt management.Receipt_management', compact('receipts', 'monthlyCount', 'totalAmount', 'categoryCount'));
    }

    public function create()
    {
        return view('laravel-examples.receipt-management.create');
    }

    public function store(Request $request)
    {
        // Store logic here
    }

    public function show($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        return view('laravel-examples.receipt-management.show', compact('receipt'));
    }

    public function edit($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        return view('laravel-examples.receipt-management.edit', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        // Update logic here
    }

    public function destroy($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        $receipt->delete();
        
        return redirect()->route('receipt-management.index')->with('success', 'Receipt deleted successfully!');
    }
}