@extends('layouts.admin')
@section('content')
    <style>
<style>
    /* شكل المودال الأساسي */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        transform: translateY(-50px);
        opacity: 0;
    }

    .modal.fade.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }
</style>

    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brands</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Brands</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.brands.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Products</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nmber = 1;
                                @endphp
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $nmber++ }}</td>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('uploads/brands') }}/{{ $brand->image }}"
                                                    alt="{{ $brand->name }}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $brand->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $brand->slug }}</td>
                                        <td><a href="#" target="_blank">0</a></td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <div class="list-icon-function">
                                                    <a href="#" class="item text-danger delete open-delete-modal"
                                                        data-brands_id="{{ $brand->id }}"
                                                        data-brand_name="{{ $brand->name }}" data-toggle="modal"
                                                        data-target="#delete_brands">
                                                        <i class="icon-trash-2"></i>
                                                    </a>

                                                </div>

                                                {{-- <form action="#" method="POST">
                                                    <div class="item text-danger delete">
                                                        <i class="icon-trash-2"></i>
                                                    </div>
                                                </form> --}}
                                                {{--
 																<a class="dropdown-item" href="#" data-brands_id="{{ $invoice->id }}"
																	data-toggle="modal" data-target="#delete_brands"><i
																		class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذفالفاتورة</a> --}}

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal effects -->
    <div class="modal fade" id="delete_brands">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Brand</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.brands.delete') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="brands_id" id="brands_id" value="">
                        <input class="form-control" name="brand_name" id="brand_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>

    <!-- jQuery -->
    <script src="{{ asset('my/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('my/bootstrap.bundle.min.js') }}"></script>
    <div class="bottom-page">

        {{ $brands->links('pagination::bootstrap-5') }}
    </div>


    <script>
        $('#delete_brands').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var brands_id = button.data('brands_id')
            var brand_name = button.data('brand_name')
            var modal = $(this)
            modal.find('.modal-body #brands_id').val(brands_id);
            modal.find('.modal-body #brand_name').val(brand_name);

        })
    </script>

    @stack('script')

@endsection
