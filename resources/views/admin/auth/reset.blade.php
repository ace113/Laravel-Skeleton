@extends('layouts.auth')

@section('content')
    <!-- BEGIN LOGO -->
    <div class="logo">
        {{-- <a href="index-2.html"> --}}
        {{-- <img src={{url('images/logo.png') }} alt=""/> </a> --}}
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->

        <form class="login-form" action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <h3 class="form-title font-green">Reset Password</h3>

            @include('partials.message')

            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter email and password. </span>
            </div>

            <input type="hidden" name="token" value="{{$token ?? ''}}">

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email"
                    name="email" value="{{ old('email', $email) }}" readonly/>
                <span class="help-block">
                    @if ($errors->has('email'))
                        <small>{{ $errors->first('email') }}</small>
                    @endif
                </span>
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password"
                    placeholder="Password" name="password" />
                <span class="help-block">
                    @if ($errors->has('password'))
                        <small>{{ $errors->first('password') }}</small>
                    @endif
                </span>
            </div>

            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                    placeholder="Re-type Your Password" name="password_confirmation" />
                <span class="help-block">
                    @if ($errors->has('password_confirmation'))
                        <small>{{ $errors->first('password_confirmation') }}</small>
                    @endif
                </span>
            </div>



            <div class="form-actions">
                <button type="submit" class="btn btn-block green uppercase">Reset</button>
            </div>
        </form>


    </div>
@endsection

@section('additional-scripts')

@endsection
