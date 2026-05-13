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
                        <a href="{{ route('admin.users') }}">
                            <div class="text-tiny">Users</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">edit User</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <fieldset class="name">
                        <div class="body-title">User Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="User name" name="name" tabindex="0"
                            value="{{ $user->name }}" aria-required="true" required="">
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name" style="background-color: #f4f4f4;">
                        <div class="body-title">Email (Locked)</div>
                        <input class="flex-grow" type="email" value="{{ $user->email }}" readonly>
                    </fieldset>

                    <fieldset class="name" style="background-color: #f4f4f4;">
                        <div class="body-title">Mobile (Locked)</div>
                        <input class="flex-grow" type="text" value="{{ $user->mobile }}" readonly>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">User Type <span class="tf-color-1">*</span></div>
                        <select class="flex-grow" name="utype" tabindex="0" aria-required="true" required="">
                            <option value="USR" {{ $user->utype == 'USR' ? 'selected' : '' }}>User</option>
                            <option value="ADM" {{ $user->utype == 'ADM' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </fieldset>
                    @error('utype')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Password <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="password" placeholder="Password" name="password" tabindex="0"
                            value="" aria-required="true" required="">
                    </fieldset>
                    @error('password')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Confirm Password <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="password" placeholder="Confirm Password" name="password_confirmation"
                            tabindex="0" value="" aria-required="true" required="">
                    </fieldset>
                    @error('password_confirmation')
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
@endsection
