@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Receipt Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Vendor:</strong> {{ $receipt->vendor_name ?? 'N/A' }}</p>
                            <p><strong>Amount:</strong> RM {{ number_format($receipt->amount ?? 0, 2) }}</p>
                            <p><strong>Category:</strong> {{ ucfirst($receipt->category ?? 'Other') }}</p>
                            <p><strong>Date:</strong> {{ $receipt->receipt_date ? \Carbon\Carbon::parse($receipt->receipt_date)->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $receipt->description ?? 'No description' }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($receipt->receipt_image)
                                <img src="{{ asset('storage/' . $receipt->receipt_image) }}" alt="Receipt" class="img-fluid rounded">
                            @else
                                <p class="text-muted">No image available</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ url('receipt-management') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ url('receipt-management/edit/' . $receipt->id) }}" class="btn btn-warning">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection