@extends('layouts.user_type.auth')

@section('content')

<div>
    {{-- Page Header --}}
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" 
             style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <div class="w-100 border-radius-lg shadow-sm bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 74px;">
                            <i class="fas fa-receipt text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">{{ __('Receipt Management') }}</h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ __('Track, organize and manage all your receipts in one place') }}
                        </p>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Receipts</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $receipts->total() ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-file-invoice text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">This Month</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $monthlyCount ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fas fa-calendar-alt text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Amount</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        RM {{ number_format($totalAmount ?? 0, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-money-bill-wave text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Categories</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $categoryCount ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fas fa-tags text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters & Search Section --}}
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>{{ __('Filter & Search') }}</h6>
                        <p class="text-sm mb-0">
                            <i class="fas fa-filter me-1"></i>
                            {{ __('Refine your receipt list') }}
                        </p>
                    </div>
                    <div class="col-lg-6 col-5 my-auto text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="toggleFilters">
                            <i class="fas fa-sliders-h me-1"></i>{{ __('Toggle Filters') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2" id="filterSection">
                <form method="GET" action="{{ url('receipt-management') }}" class="px-4 pt-3">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-xs font-weight-bold">{{ __('Search') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Receipt name, vendor...">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label text-xs font-weight-bold">{{ __('Category') }}</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>Food & Dining</option>
                                <option value="transport" {{ request('category') == 'transport' ? 'selected' : '' }}>Transportation</option>
                                <option value="utilities" {{ request('category') == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                                <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label text-xs font-weight-bold">{{ __('Date From') }}</label>
                            <input type="date" class="form-control" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label text-xs font-weight-bold">{{ __('Date To') }}</label>
                            <input type="date" class="form-control" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label text-xs font-weight-bold">{{ __('Sort By') }}</label>
                            <select class="form-select" name="sort">
                                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Newest)</option>
                                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (Oldest)</option>
                                <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Amount (High-Low)</option>
                                <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Amount (Low-High)</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 mb-0">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @if(request()->hasAny(['search', 'category', 'date_from', 'date_to', 'sort']))
                                <a href="{{ url('receipt-management') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>{{ __('Clear Filters') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                <span class="alert-text text-white"><strong>{{ __('Success!') }}</strong> {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Receipts Table --}}
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>{{ __('All Receipts') }}</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                            <span class="font-weight-bold ms-1">{{ $receipts->total() ?? 0 }} receipts found</span>
                        </p>
                    </div>
                    <div class="col-lg-6 col-5 my-auto text-end">
                        <div class="dropdown float-lg-end pe-4">
                            <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                <li><a class="dropdown-item border-radius-md" href="{{ url('receipt-management/export') }}">
                                    <i class="fas fa-file-excel me-2"></i>Export to Excel
                                </a></li>
                                <li><a class="dropdown-item border-radius-md" href="{{ url('receipt-management/export-pdf') }}">
                                    <i class="fas fa-file-pdf me-2"></i>Export to PDF
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Receipt Info</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receipts as $index => $receipt)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $receipts->firstItem() + $index }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div class="avatar avatar-sm me-3 bg-gradient-primary shadow text-center border-radius-md">
                                                    <i class="fas fa-receipt text-white opacity-10"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $receipt->vendor_name ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($receipt->description ?? 'No description', 40) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $receipt->getCategoryColor() }}">
                                            {{ ucfirst($receipt->category ?? 'Other') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold">RM {{ number_format($receipt->amount ?? 0, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $receipt->receipt_date ? \Carbon\Carbon::parse($receipt->receipt_date)->format('d M Y') : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ url('receipt-management/show/' . $receipt->id) }}" 
                                               class="btn btn-sm btn-info mb-0" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('receipt-management/edit/' . $receipt->id) }}" 
                                               class="btn btn-sm btn-warning mb-0" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top" 
                                               title="Edit Receipt">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger mb-0" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $receipt->id }}" 
                                                    title="Delete Receipt">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Delete Modal --}}
                                <div class="modal fade" id="deleteModal{{ $receipt->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this receipt?</p>
                                                <p class="text-sm text-secondary mb-0">
                                                    <strong>{{ $receipt->vendor_name }}</strong> - RM {{ number_format($receipt->amount ?? 0, 2) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ url('receipt-management/destroy/' . $receipt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-center">
                                            <i class="fas fa-inbox fa-3x text-secondary opacity-3 mb-3"></i>
                                            <h6 class="text-secondary">No receipts found</h6>
                                            <p class="text-xs mb-3">Start by adding your first receipt</p>
                                            <a href="{{ url('receipt-management/create') }}" class="btn btn-sm bg-gradient-primary">
                                                <i class="fas fa-plus me-2"></i>Add Receipt
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($receipts->hasPages())
                <div class="card-footer pb-0">
                    {{ $receipts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle filter section
    document.getElementById('toggleFilters')?.addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush

@endsection