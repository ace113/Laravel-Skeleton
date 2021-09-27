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

        <form class="login-form" action="{{ route('admin.login') }}" method="post">
            {!! csrf_field() !!}
            <h3 class="form-title font-green">Sign In</h3>
            {{-- @include('admin.general-flash-msg') --}}
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter email and password. </span>


            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" id="email" type="email"
                    placeholder="Email" name="email" />
                <span class="help-block">
                    @if ($errors->has('email'))
                        <strong>{{ $errors->first('email') }}</strong>
                    @endif
                </span>
            </div>

            <div class="form-group">

                <label
                    class="control-label visible-ie8 visible-ie9 {{ $errors->has('password') ? ' has-error' : '' }}">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" id="password"
                    autocomplete="off" placeholder="Password" name="password" />
                <span class="help-block">
                    <strong>
                        @if ($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </strong>
                </span>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">Login</button>
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />Remember
                    <span></span>
                </label>
                <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
            </div>
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <form id="forget-form" class="forget-form">
            {!! csrf_field() !!}
            <h3 class="font-green" id="forget-password-title">Forget Password ?</h3>
            <p> Enter your e-mail address below to reset your password. </p>
            <center>
                <div class="loading-message" style="display: none">
                    <div class="block-spinner-bar">
                        <div class="bounce1" style="background: #4bccd8"></div>
                        <div class="bounce2" style="background: #4bccd8"></div>
                        <div class="bounce3" style="background: #4bccd8"></div>
                    </div>
                </div>
            </center>


            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <div id="forgot-submit"></div>
                <input id="forgot-password-email" class="form-control placeholder-no-fix" type="text" autocomplete="off"
                    placeholder="Email" name="email" />
                    <span class="help-block">
                        <strong>
                            @if ($errors->has('email'))
                                {{ $errors->first('email') }}
                            @endif
                        </strong>
                    </span>
            </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    @endsection

    @section('additional-scripts')
        <script>
            var forgotpasswordlink = "{{ route('admin.password.email') }}";
            $('#forget-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: forgotpasswordlink,
                    data: $('#forget-form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    beforeSend: function() {
                        $('.help-block').remove();
                        $('.form-group').hide();
                        $('.form-actions').hide();
                        $('.loading-message').show();
                    },
                    success: function(data) {
                        console.log(data)
                    }
                }).done(function(data) {
                    $('.form-group').show();
                    $('.form-actions').show();
                    $('.loading-message').hide();
                    $('.help-block').remove();
                    $('#forget-password-title').after(
                        '<div class="alert alert-success"><button class="close" data-close="alert"></button><span> An email has been successfully sent. Please check your email.</span>'
                    );
                    // if (data["status"] == false) {
                    //     $('#forget-password-title').after(
                    //         '<div class="alert alert-danger"><button class="close" data-close="alert"></button><span>' +
                    //         data['errors'] + '</span>')
                    // } else {

                    //     $('#forget-password-title').after(
                    //         '<div class="alert alert-success"><button class="close" data-close="alert"></button><span>' +
                    //         data['message'] + '</span>');
                    //     setTimeout(function() {
                    //         $(".alert").hide();
                    //     }, 5000);

                    // }
                    console.log(data);

                });


            });
        </script>
    @endsection
