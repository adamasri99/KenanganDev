<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;

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
        // In your controller store/update method
        if ($request->hasFile('receipt_images')) {
            foreach ($request->file('receipt_images') as $index => $file) {
                if ($file) {
                    $path = $file->store('receipts', 'public');

                    Receipt::create([
                        'roi_record_id' => $roi->id,
                        'file_path' => $path,
                        'receipt_image' => $path,
                        'receipt_date' => $request->receipt_dates[$index] . '-01',
                    ]);
                }
            }
        }
    }

    public function show($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        return view('laravel-examples.Receipt management.Receipt_show', compact('receipt'));
    }

    public function edit($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        return view('laravel-examples.Receipt management.Receipt_edit', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'receipt_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $receipt = \App\Models\Receipt::findOrFail($id);
        $receipt->update($request->all());

        return redirect('receipt-management')->with('success', 'Receipt updated successfully!');
    }

    public function destroy($id)
    {
        $receipt = \App\Models\Receipt::findOrFail($id);
        if ($receipt->receipt_image) {
            \Storage::disk('public')->delete($receipt->receipt_image);
        }
        $receipt->delete();

        return redirect('receipt-management')->with('success', 'Receipt deleted successfully!');
    }
}
