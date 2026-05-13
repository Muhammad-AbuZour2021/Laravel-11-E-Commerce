@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>categorys infomation</h3>
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
                        <a href="{{ route('admin.categorys') }}">
                            <div class="text-tiny">categoryss</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">edit categorys</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1"  action="{{ route('admin.categorys.update') }}" method="POST"
                enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$categorys->id}}">
                    <fieldset class="name">
                        <div class="body-title">categorys Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="categorys name" name="name" tabindex="0"
                            value="{{$categorys->name}}" aria-required="true" required="">
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">

                            @if ($categorys->image)
                            <div class="item" id="imgpreview" >
                                <img src="{{asset('uploads/categorys')}}/{{$categorys->image}}" class="effect8" alt="preview">
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
