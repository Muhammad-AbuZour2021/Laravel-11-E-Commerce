@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brand infomation</h3>
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
                        <a href="{{ route('admin.brands') }}">
                            <div class="text-tiny">Brands</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">edit Brand</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1"  action="{{ route('admin.brands.update') }}" method="POST"
                enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$brand->id}}">
                    <fieldset class="name">
                        <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Brand name" name="name" tabindex="0"
                            value="{{$brand->name}}" aria-required="true" required="">
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($brand->image)
                            <div class="item" id="imgpreview" >
                                <img src="{{asset('uploads/brands')}}/{{$brand->image}}" class="effect8" alt="preview">
                            </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="image">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="image" name="image">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            console.log(file);
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.querySelector('#imgpreview img');
                    img.src = e.target.result;
                    document.getElementById('imgpreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

@endsection
