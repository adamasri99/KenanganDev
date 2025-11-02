@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <div class="w-100 border-radius-lg shadow-sm bg-gradient-success d-flex align-items-center justify-content-center" style="height: 74px;">
                            <i class="fas fa-chart-line text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ isset($roi) ? __('Edit ROI Record') : __('New ROI Calculation') }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ __('Record sales & expenses, calculate ROI automatically') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <a href="{{ url('ROI-management') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ isset($roi) ? __('Edit ROI Record') : __('ROI Calculation Details') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                
                <form action="{{ isset($roi) ? url('ROI-management/update/' . $roi->id) : url('ROI-management/store') }}" method="POST" enctype="multipart/form-data" id="roiForm">
                    @csrf
                    @if(isset($roi))
                        @method('PUT')
                    @endif

                    {{-- Error Messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                                <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Step 1: Product Selection & Quantity --}}
                    <div class="card bg-gradient-light mb-4">
                        <div class="card-body">
                            <h6 class="text-dark mb-3">
                                <i class="fas fa-box-open me-2"></i>Step 1: Select Product & Quantity
                            </h6>
                            
                            <div class="row">
                                {{-- Product Selection --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product-select" class="form-control-label">{{ __('Select Product') }} <span class="text-danger">*</span></label>
                                        <div class="@error('product_id') border border-danger rounded-3 @enderror">
                                            <select 
                                                class="form-control" 
                                                id="product-select" 
                                                name="product_id"
                                                onchange="calculateValues()"
                                                required
                                            >
                                                <option value="">-- Select a product --</option>
                                                @foreach($products as $product)
                                                    <option 
                                                        value="{{ $product->id }}" 
                                                        data-price="{{ $product->price }}"
                                                        {{ old('product_id', $roi->product_id ?? '') == $product->id ? 'selected' : '' }}
                                                    >
                                                        {{ $product->name }} (RM {{ number_format($product->price, 2) }} per unit)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Quantity Sold --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity-sold" class="form-control-label">{{ __('Quantity Sold') }} <span class="text-danger">*</span></label>
                                        <div class="@error('quantity_sold') border border-danger rounded-3 @enderror">
                                            <input 
                                                class="form-control" 
                                                value="{{ old('quantity_sold', $roi->quantity_sold ?? '') }}" 
                                                type="number" 
                                                min="1"
                                                placeholder="Enter quantity sold" 
                                                id="quantity-sold" 
                                                name="quantity_sold"
                                                oninput="calculateValues()"
                                                required
                                            >
                                            @error('quantity_sold')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Sales (Auto-calculated) --}}
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="alert alert-success mb-0" role="alert">
                                        <strong><i class="fas fa-calculator me-2"></i>Total Sales (Auto-calculated):</strong>
                                        <span class="float-end fs-5" id="total-sales-display">RM 0.00</span>
                                        <input type="hidden" name="total_sales" id="total-sales" value="{{ old('total_sales', $roi->total_sales ?? '0') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Upload Receipt Images --}}
                    <div class="card bg-gradient-light mb-4">
                        <div class="card-body">
                            <h6 class="text-dark mb-3">
                                <i class="fas fa-receipt me-2"></i>Step 2: Upload Receipt Images (Optional)
                            </h6>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="receipt-images" class="form-control-label">{{ __('Receipt Images') }} <span class="text-muted">(Multiple files allowed)</span></label>
                                        <div class="@error('receipt_images.*') border border-danger rounded-3 @enderror">
                                            <input 
                                                class="form-control" 
                                                type="file" 
                                                id="receipt-images" 
                                                name="receipt_images[]"
                                                accept="image/*"
                                                multiple
                                            >
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-info-circle"></i> You can select multiple images at once. Supported formats: JPG, PNG, PDF
                                            </small>
                                            @error('receipt_images.*')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Image Preview --}}
                                    <div id="image-preview" class="mt-3 d-none">
                                        <label class="form-control-label">{{ __('Preview:') }}</label>
                                        <div id="preview-container" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    {{-- Show existing images if editing --}}
                                    @if(isset($roi) && $roi->receipt_images)
                                        <div class="mt-3">
                                            <label class="form-control-label">{{ __('Current Receipt Images:') }}</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach(json_decode($roi->receipt_images) as $image)
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Receipt" class="border rounded" style="width: 120px; height: 120px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Enter Expenses --}}
                    <div class="card bg-gradient-light mb-4">
                        <div class="card-body">
                            <h6 class="text-dark mb-3">
                                <i class="fas fa-money-bill-wave me-2"></i>Step 3: Enter Total Expenses
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total-expenses" class="form-control-label">{{ __('Total Expenses (RM)') }} <span class="text-danger">*</span></label>
                                        <div class="@error('total_expenses') border border-danger rounded-3 @enderror">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text">RM</span>
                                                <input 
                                                    class="form-control" 
                                                    value="{{ old('total_expenses', $roi->total_expenses ?? '') }}" 
                                                    type="number" 
                                                    step="0.01"
                                                    min="0"
                                                    placeholder="0.00" 
                                                    id="total-expenses" 
                                                    name="total_expenses"
                                                    oninput="calculateValues()"
                                                    required
                                                >
                                            </div>
                                            @error('total_expenses')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                            <small class="text-muted">
                                                <i class="fas fa-lightbulb"></i> Enter the total amount from your receipt(s)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="record-date" class="form-control-label">{{ __('Record Date') }} <span class="text-danger">*</span></label>
                                        <div class="@error('record_date') border border-danger rounded-3 @enderror">
                                            <input 
                                                class="form-control form-control-lg" 
                                                value="{{ old('record_date', isset($roi) ? $roi->record_date : date('Y-m-d')) }}" 
                                                type="date" 
                                                id="record-date" 
                                                name="record_date"
                                                required
                                            >
                                            @error('record_date')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ROI Summary Card --}}
                    <div class="card bg-gradient-success text-white mb-4">
                        <div class="card-body p-4">
                            <h5 class="text-white mb-3">
                                <i class="fas fa-chart-line me-2"></i>ROI Calculation Summary
                            </h5>
                            <div class="row text-center">
                                <div class="col-md-4 border-end border-white">
                                    <p class="text-sm mb-1 text-white opacity-8">Total Sales</p>
                                    <h3 class="text-white mb-0 font-weight-bold" id="summary-sales">RM 0.00</h3>
                                </div>
                                <div class="col-md-4 border-end border-white">
                                    <p class="text-sm mb-1 text-white opacity-8">Total Expenses</p>
                                    <h3 class="text-white mb-0 font-weight-bold" id="summary-expenses">RM 0.00</h3>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-sm mb-1 text-white opacity-8">Net ROI (Profit/Loss)</p>
                                    <h3 class="mb-0 font-weight-bolder" id="summary-roi">RM 0.00</h3>
                                    <input type="hidden" name="roi" id="roi-value" value="{{ old('roi', $roi->roi ?? '0') }}">
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <small class="text-white opacity-8">
                                    <i class="fas fa-info-circle"></i> Formula: ROI = Total Sales - Total Expenses
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('ROI-management') }}" class="btn btn-lg btn-light">
                            <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-lg bg-gradient-success text-white">
                            <i class="fas fa-save me-2"></i>{{ isset($roi) ? __('Update Record') : __('Save Record') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateValues() {
    const productSelect = document.getElementById('product-select');
    const quantityInput = document.getElementById('quantity-sold');
    const expensesInput = document.getElementById('total-expenses');
    
    const price = parseFloat(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-price')) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    const expenses = parseFloat(expensesInput.value) || 0;
    
    const totalSales = price * quantity;
    const roi = totalSales - expenses;
    
    document.getElementById('total-sales-display').textContent = 'RM ' + totalSales.toFixed(2);
    document.getElementById('total-sales').value = totalSales.toFixed(2);
    document.getElementById('summary-sales').textContent = 'RM ' + totalSales.toFixed(2);
    document.getElementById('summary-expenses').textContent = 'RM ' + expenses.toFixed(2);
    document.getElementById('summary-roi').textContent = 'RM ' + roi.toFixed(2);
    document.getElementById('roi-value').value = roi.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    document.getElementById('receipt-images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        previewContainer.innerHTML = '';
        
        if (e.target.files.length > 0) {
            imagePreview.classList.remove('d-none');
            Array.from(e.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.innerHTML = `<img src="${event.target.result}" alt="Receipt ${index + 1}" class="border rounded shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">`;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            imagePreview.classList.add('d-none');
        }
    });
    
    // Initial calculation on page load
    calculateValues();
});
</script>
@endpush

@endsection