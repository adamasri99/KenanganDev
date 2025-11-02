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
                        <div class="w-100 border-radius-lg shadow-sm bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 74px;">
                            <i class="fas fa-box text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ isset($product) ? __('Edit Product') : __('Add New Product') }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ __('Manage your gift items') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <a href="{{ route('product-management') }}" class="btn btn-outline-primary w-100">
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
                <h6 class="mb-0">{{ isset($product) ? __('Edit Product') : __('Product Information') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                
                <form action="{{ isset($product) ? route('product-management.update', $product->id) : route('product-management.store') }}" method="POST">

                    @csrf
                    @if(isset($product))
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

                    <div class="row">
                        {{-- Product Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product-name" class="form-control-label">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                                <div class="@error('name') border border-danger rounded-3 @enderror">
                                    <input 
                                        class="form-control" 
                                        value="{{ old('name', $product->name ?? '') }}" 
                                        type="text" 
                                        placeholder="e.g., Envelope" 
                                        id="product-name" 
                                        name="name"
                                        required
                                    >
                                    @error('name')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product-price" class="form-control-label">{{ __('Price per Unit (RM)') }} <span class="text-danger">*</span></label>
                                <div class="@error('price') border border-danger rounded-3 @enderror">
                                    <div class="input-group">
                                        <span class="input-group-text">RM</span>
                                        <input 
                                            class="form-control" 
                                            value="{{ old('price', $product->price ?? '') }}" 
                                            type="number" 
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00" 
                                            id="product-price" 
                                            name="price"
                                            required
                                        >
                                    </div>
                                    @error('price')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('product-management') }}" class="btn btn-light me-2">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn bg-gradient-primary">
                            {{ isset($product) ? __('Update Product') : __('Save Product') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
