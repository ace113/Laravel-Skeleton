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
        
        <form action="{{route("admin.password.email")}}" method="POST">
            @csrf
            <h3 class="font-green" id="forget-password-title">Forgot Password</h3>
            @include('partials.message')
            <p>Enter your e-mail address below to reset your password.</p>
            <center>
                <div class="loading-message" style="display:none">
                    <div class="block-spinner-bar">
                        <div class="bounce1" style="background: #4bccd8"></div>
                        <div class="bounce2" style="background: #4bccd8"></div>
                        <div class="bounce3" style="background: #4bccd8"></div>
                    </div>
                </div>
            </center>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control placeholder-no-fix" autocomplete="off" placeholder="Email"
                    name="email" required />
                    <span class="help-block">
                    @if ($errors->has('email'))
                        <small>{{ $errors->first('email') }}</small>
                    @endif
                </span>
            </div>
            <div class="form-actions">
                {{-- <button type="button" id="back-btn" class="btn green btn-outline">Back</button> --}}
                <a href="{{route("admin.login.form")}}" class="btn green btn-outline">Back</a>
                <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->


    </div>
@endsection

@section('additional-scripts')

@endsection
