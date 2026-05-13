@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <!-- Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>

            <ul class="breadcrumbs flex items-center flex-wrap gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Products</div></li>
            </ul>
        </div>

        <!-- Box -->
        <div class="wg-box">

            <!-- Search + Add -->
            <div class="flex items-center justify-between gap10 flex-wrap">

                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET">
                        <fieldset class="name">
                            <input type="text" name="name" placeholder="Search products..." required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                    <i class="icon-plus"></i> Add New
                </a>
            </div>

            <!-- Table -->
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Sale</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $i = 1; @endphp

                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/thumbnails/'.$product->image) }}" width="50">
                                </div>
                                <div class="name">
                                    <strong>{{ $product->name }}</strong>
                                    <div class="text-tiny">{{ $product->slug }}</div>
                                </div>
                            </td>

                            <td>{{ $product->regular_price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->SKU }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ $product->brand->name ?? '-' }}</td>
                            <td>{{ $product->featured ? 'Yes' : 'No' }}</td>
                            <td>{{ $product->stock_status }}</td>
                            <td>{{ $product->quantity }}</td>

                            <td>
                                <div class="list-icon-function">

                                    <a href="#">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.product.edit', $product->id) }}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button"
                                            class="item text-danger open-delete-modal"
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">

                                        <i class="icon-trash-2"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Product</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">

                    <p>Are you sure you want to delete this product?</p>

                    <input type="hidden" id="product_id">

                    <input type="text"
                           class="form-control mt-2"
                           id="product_name"
                           readonly>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection


<!-- ================= SCRIPT ================= -->
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let modal = document.getElementById('deleteModal');

    modal.addEventListener('show.bs.modal', function (event) {

        let button = event.relatedTarget;

        let id = button.getAttribute('data-id');
        let name = button.getAttribute('data-name');

        modal.querySelector('#product_id').value = id;
        modal.querySelector('#product_name').value = name;

        // 🔥 route الصحيح
        let url = "/admin/products/" + id;
        document.getElementById('deleteForm').action = url;
    });

});
</script>
@endpush
