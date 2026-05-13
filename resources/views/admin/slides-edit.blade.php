@extends('layouts.admin')

@section('content')

<style>

</style>
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slids</h3>
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
                        <a href="{{ route('admin.slides.add') }}">
                            <div class="text-tiny">Slider</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Slide</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.slides.update') }}" method="POST"
                    enctype="multipart/form-data"> @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{ $slide->id }}">
                    <fieldset class="name">
                        <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Tagline" name="tagline" tabindex="0"
                            value="{{ $slide->tagline }}" aria-required="true" required="">
                    </fieldset>
                    @error('tagline')
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0"
                            value="{{ $slide->titel }}" aria-required="true" required="">

                    </fieldset>
                    @error('title')
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Subtitle" name="subtitle" tabindex="0"
                            value="{{ $slide->Subtitle }}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle')
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title" >Link <span class="tf-color-1">*</span></div>

                        <input  style="width: 100%;"class="w-100" type="text" placeholder="Link" name="link" value="{{ $slide->link }}"
                            required>

                    </fieldset>
                    @error('link')
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($slide->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt=""
                                        class="effect8">
                                </div>
                            @endif
                            <div class="item up-load">
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
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select name="status" class="">
                                <option>select</option>
                                <option value="1" @if ($slide->status == '1') selected @endif>Active</option>
                                <option value="0" @if ($slide->status == '0') selected @endif>Inacive</option>
                            </select>
                        </div>

                    </fieldset>
                    @error('status')
                        <samp class="alert alert-danger text-center">{{ $message }} </samp>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>


    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('#imgpreview img');
                    img.src = e.target.result;
                    document.getElementById('imgpreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
