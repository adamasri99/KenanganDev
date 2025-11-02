@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <div class="w-100 border-radius-lg shadow-sm bg-gradient-primary d-flex align-items-center justify-content-center"
                                style="height: 74px;">
                                <i class="fas fa-box text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ isset($product) ? __('Edit Product') : __('Product Management') }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ __('Manage your gift items') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Products</h5>
                            </div>
                            <a href="{{ route('product-management.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp; New Product</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Product Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Price (RM)</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Creation Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products ?? [] as $product)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">RM
                                                    {{ number_format($product->price, 2) }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $product->created_at->format('d/m/Y') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    {{-- Edit Button --}}
                                                    <a href="{{ route('product-management.edit', $product->id) }}"
                                                        class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit product">
                                                        <i class="fas fa-pencil-alt me-1"></i>Edit
                                                    </a>

                                                    {{-- Delete Button --}}
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $product->id }}"
                                                        title="Delete product">
                                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                                    </button>
                                                </div>
                                            </td>

                                            {{-- Delete Confirmation Modal (Place this outside the table, before @endforeach) --}}
                                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-gradient-danger">
                                                            <h5 class="modal-title text-white"
                                                                id="deleteModalLabel{{ $product->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Confirm
                                                                Delete
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center py-3">
                                                                <i class="fas fa-trash-alt text-danger"
                                                                    style="font-size: 3rem;"></i>
                                                                <h5 class="mt-3 mb-2">Delete "{{ $product->name }}"?</h5>
                                                                <p class="text-muted mb-0">This action cannot be undone. Are
                                                                    you sure you want to delete this product?</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancel
                                                            </button>
                                                            <form
                                                                action="{{ route('product-management.destroy', $product->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash-alt me-1"></i>Yes, Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <p class="text-muted mb-0">No products found</p>
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
    </div>
@endsection
