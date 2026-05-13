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
                <h3>categorys</h3>
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
                        <div class="text-tiny">categorys</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.categorys.add') }}"><i class="icon-plus"></i>Add
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
                                @foreach ($categorys as $category)
                                    <tr>
                                        <td>{{ $nmber++ }}</td>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('uploads/categorys') }}/{{ $category->image }}"
                                                    alt="{{ $category->name }}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $category->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                        <td><a href="#" target="_blank">0</a></td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.categorys.edit', $category->id) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <div class="list-icon-function">
                                                    <a href="#" class="item text-danger delete open-delete-modal"
                                                        data-categorys_id="{{ $category->id }}"
                                                        data-category_name="{{ $category->name }}" data-toggle="modal"
                                                        data-target="#delete_categorys">
                                                        <i class="icon-trash-2"></i>
                                                    </a>

                                                </div>

                                          
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
    <div class="modal fade" id="delete_categorys">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete category</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.categorys.delete') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="categorys_id" id="categorys_id" value="">
                        <input class="form-control" name="category_name" id="category_name" type="text" readonly>
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

        {{ $categorys->links('pagination::bootstrap-5') }}
    </div>


    <script>
        $('#delete_categorys').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var categorys_id = button.data('categorys_id')
            var category_name = button.data('category_name')
            var modal = $(this)
            modal.find('.modal-body #categorys_id').val(categorys_id);
            modal.find('.modal-body #category_name').val(category_name);

        })
    </script>

    @stack('script')

@endsection
