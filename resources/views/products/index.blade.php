@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Add new product button --}}
        <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-primary" id="createProductBtn">Create new product</button>
        </div>

        {{-- Message --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }} </div>
        @endif

        @if ($errors->has('error'))
            <div class="alert alert-danger" role="alert"> {{ $errors->first('error') }} </div>
        @endif

        {{-- Render table of products --}}
        {!! $html->table(['class' => 'table table-bordered', 'id' => 'products-table'], true) !!}

        {{-- Update Modal --}}
        <x-product-form modal="updateProductModal" form="updateProductForm" method="patch" />

        {{-- Create Modal --}}
        <x-product-form modal="createProductModal" form="createProductForm" method="post" />

        {{-- Delete modal --}}
        <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductLabel">
            <div class="modal-dialog" role="document">
                <form class="modal-content" id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm delete product</h5>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fs-4">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Do you confirm to delete this product? This action can not be undone!</p>
                        <p>Product information:</p>
                        <div class="mt-2 ms-2">
                            <p id="p-id" class="mb-1"></p>
                            <p id="p-name" class="mb-1"></p>
                            <p id="p-image" class="mb-1"></p>
                            <p id="p-price" class="mb-1"></p>
                            <p id="p-description" class="mb-1"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $html->scripts() }}
    <script src="{{ asset('js/updateProduct.js') }}"></script>
@endpush
