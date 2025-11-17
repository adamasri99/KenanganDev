<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ROIManagementController extends Controller
{
    public function index()
    {
        $roiRecords = \App\Models\RoiRecord::with('product')->paginate(10);
        $totalSales = \App\Models\RoiRecord::sum('total_sales');
        $totalExpenses = \App\Models\RoiRecord::sum('total_expenses');
        
        return view('laravel-examples.ROI calculation.ROI_management', compact('totalSales', 'totalExpenses', 'roiRecords'));
    }

    public function create()
    {
        $products = \App\Models\Product::all();
        return view('laravel-examples.ROI calculation.ROI_create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'total_expenses' => 'required|numeric|min:0',
            'record_date' => 'required|date'
        ]);

        $product = \App\Models\Product::find($request->product_id);
        $totalSales = $product->price * $request->quantity_sold;
        $roi = $totalSales - $request->total_expenses;
        $month = date('F Y', strtotime($request->record_date));

        $roiRecord = \App\Models\RoiRecord::create([
            'product_id' => $request->product_id,
            'quantity_sold' => $request->quantity_sold,
            'total_sales' => $totalSales,
            'total_expenses' => $request->total_expenses,
            'roi' => $roi,
            'month' => $month,
            'notes' => $request->notes
        ]);

        // Handle receipt images
        if ($request->hasFile('receipt_images')) {
            foreach ($request->file('receipt_images') as $index => $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('receipts', $fileName, 'public');
                
                \App\Models\Receipt::create([
                    'roi_record_id' => $roiRecord->id,
                    'file_path' => 'receipts/' . $fileName,
                    'receipt_image' => 'receipts/' . $fileName,
                    'receipt_date' => isset($request->receipt_dates[$index]) ? $request->receipt_dates[$index] . '-01' : null
                ]);
            }
        }

        return redirect('ROI-management')->with('success', 'ROI record created successfully!');
    }

    public function edit($id)
    {
        $roi = \App\Models\RoiRecord::findOrFail($id);
        $products = \App\Models\Product::all();
        return view('laravel-examples.ROI calculation.ROI_edit', compact('roi', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'total_expenses' => 'required|numeric|min:0',
            'record_date' => 'required|date'
        ]);

        $roiRecord = \App\Models\RoiRecord::findOrFail($id);
        $product = \App\Models\Product::find($request->product_id);
        $totalSales = $product->price * $request->quantity_sold;
        $roi = $totalSales - $request->total_expenses;
        $month = date('F Y', strtotime($request->record_date));

        $roiRecord->update([
            'product_id' => $request->product_id,
            'quantity_sold' => $request->quantity_sold,
            'total_sales' => $totalSales,
            'total_expenses' => $request->total_expenses,
            'roi' => $roi,
            'month' => $month,
            'notes' => $request->notes
        ]);

        if ($request->hasFile('receipt_images')) {
            foreach ($request->file('receipt_images') as $index => $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('receipts', $fileName, 'public');
                
                \App\Models\Receipt::create([
                    'roi_record_id' => $roiRecord->id,
                    'file_path' => 'receipts/' . $fileName,
                    'receipt_image' => 'receipts/' . $fileName,
                    'receipt_date' => isset($request->receipt_dates[$index]) ? $request->receipt_dates[$index] . '-01' : null
                ]);
            }
        }

        return redirect('ROI-management')->with('success', 'ROI record updated successfully!');
    }

    public function destroy($id)
    {
        $roiRecord = \App\Models\RoiRecord::findOrFail($id);
        $roiRecord->delete();
        
        return redirect('ROI-management')->with('success', 'ROI record deleted successfully!');
    }
}