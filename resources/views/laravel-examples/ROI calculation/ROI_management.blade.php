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
                            {{ __('ROI Calculation') }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ __('Track your sales, expenses & return on investment') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <a href="{{ url('ROI-management/create') }}" class="btn bg-gradient-success w-100">
                            <i class="fas fa-plus me-2"></i>{{ __('New ROI Record') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Sales</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        RM {{ number_format($totalSales ?? 0, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-dollar-sign text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Expenses</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        RM {{ number_format($totalExpenses ?? 0, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fas fa-receipt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Net ROI</p>
                                    <h5 class="font-weight-bolder mb-0 {{ ($totalSales - $totalExpenses) >= 0 ? 'text-success' : 'text-danger' }}">
                                        RM {{ number_format(($totalSales ?? 0) - ($totalExpenses ?? 0), 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fas fa-chart-line text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Records</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $roiRecords->total() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-file-alt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROI Records Table --}}
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('ROI Records') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                {{-- Search & Filter Bar --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                                <select 
                                    class="form-control" 
                                    id="product-filter"
                                >
                                    <option value="">-- Filter product --</option>
                                    @if(isset($products))
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (RM {{ number_format($product->price, 2) }} per unit)
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach($roiRecords->pluck('product')->unique('id') as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (RM {{ number_format($product->price, 2) }} per unit)
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="monthFilter">
                            <option value="">All Months</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="yearFilter">
                            <option value="">All Years</option>
                            @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- ROI Table --}}
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Date
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Product
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Qty Sold
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Sales (RM)
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Expenses (RM)
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    ROI (RM)
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roiRecords as $record)
                            <tr>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">
                                        {{ \Carbon\Carbon::parse($record->created_at)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-secondary mb-0">
                                        {{ $record->month }}
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <div class="avatar avatar-sm me-3 bg-gradient-primary">
                                                <i class="fas fa-box text-white text-sm opacity-10"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $record->product->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">RM {{ number_format($record->product->price, 2) }}/unit</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-info">{{ $record->quantity_sold }}</span>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm font-weight-bold mb-0 text-success">
                                        RM {{ number_format($record->total_sales, 2) }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm font-weight-bold mb-0 text-warning">
                                        RM {{ number_format($record->total_expenses, 2) }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm font-weight-bold mb-0 {{ $record->roi >= 0 ? 'text-success' : 'text-danger' }}">
                                        RM {{ number_format($record->roi, 2) }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- View Receipt Button --}}
                                        @if($record->receipt_images)
                                            <button type="button" 
                                                    class="btn btn-sm btn-info text-white" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#receiptModal{{ $record->id }}"
                                                    title="View Receipts">
                                                <i class="fas fa-image me-1"></i>Receipts
                                            </button>
                                        @endif
                                        
                                        {{-- Edit Button --}}
                                        <a href="{{ url('ROI-management/edit/' . $record->id) }}" 
                                           class="btn btn-sm btn-primary text-white" 
                                           title="Edit record">
                                            <i class="fas fa-pencil-alt me-1"></i>Edit
                                        </a>
                                        
                                        {{-- Delete Button --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $record->id }}"
                                                title="Delete record">
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Receipt Images Modal --}}
                            @if($record->receipt_images)
                            <div class="modal fade" id="receiptModal{{ $record->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-gradient-info">
                                            <h5 class="modal-title text-white">Receipt Images</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Receipt images content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="text-sm mb-0">No ROI records found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productFilter = document.getElementById('product-filter');
    const monthFilter = document.getElementById('monthFilter');
    const yearFilter = document.getElementById('yearFilter');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const selectedProduct = productFilter.value;
        const selectedMonth = monthFilter.value;
        const selectedYear = yearFilter.value;

        tableRows.forEach(row => {
            if (row.cells.length === 1) return; // Skip "No records" row
            
            const productCell = row.cells[1];
            const productName = productCell.querySelector('h6').textContent.trim();
            const dateText = row.cells[0].textContent;
            
            // Extract month and year from date
            const dateMatch = dateText.match(/(\d{1,2})\s+(\w+)\s+(\d{4})/);
            const rowMonth = dateMatch ? new Date(Date.parse(dateMatch[2] + ' 1, 2000')).getMonth() + 1 : null;
            const rowYear = dateMatch ? dateMatch[3] : null;
            
            // Get selected product name for comparison
            const selectedProductName = selectedProduct ? productFilter.options[productFilter.selectedIndex].text.split(' (')[0] : '';
            
            // Check filters
            const matchesProduct = !selectedProduct || productName === selectedProductName;
            const matchesMonth = !selectedMonth || rowMonth == selectedMonth;
            const matchesYear = !selectedYear || rowYear == selectedYear;
            
            row.style.display = (matchesProduct && matchesMonth && matchesYear) ? '' : 'none';
        });
    }

    productFilter.addEventListener('change', filterTable);
    monthFilter.addEventListener('change', filterTable);
    yearFilter.addEventListener('change', filterTable);
});
</script>