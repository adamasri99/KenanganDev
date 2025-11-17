@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Receipt</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('receipt-management/update/' . $receipt->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vendor_name">Vendor Name</label>
                                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="{{ $receipt->vendor_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $receipt->amount }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="food" {{ $receipt->category == 'food' ? 'selected' : '' }}>Food</option>
                                        <option value="transport" {{ $receipt->category == 'transport' ? 'selected' : '' }}>Transport</option>
                                        <option value="entertainment" {{ $receipt->category == 'entertainment' ? 'selected' : '' }}>Entertainment</option>
                                        <option value="shopping" {{ $receipt->category == 'shopping' ? 'selected' : '' }}>Shopping</option>
                                        <option value="other" {{ $receipt->category == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receipt_date">Receipt Date</label>
                                    <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="{{ $receipt->receipt_date }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $receipt->description }}</textarea>
                        </div>
                        
                        @if($receipt->receipt_image)
                            <div class="form-group">
                                <label>Current Image</label>
                                <div>
                                    <img src="{{ asset('storage/' . $receipt->receipt_image) }}" alt="Receipt" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Update Receipt</button>
                            <a href="{{ url('receipt-management') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection