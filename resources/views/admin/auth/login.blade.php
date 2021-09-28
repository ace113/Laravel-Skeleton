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

        <form class="login-form" action="{{ route('admin.login') }}" method="POST">
            @csrf
            <h3 class="form-title font-green">Sign In</h3>

            @include('partials.message')

            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter email and password. </span>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" id="email" type="email"
                    placeholder="Email" name="email" value="{{old('email')}}" required />
                <span class="help-block">
                    @if ($errors->has('email'))
                        <small>{{ $errors->first('email') }}</small>
                    @endif
                </span>
            </div>

            <div class="form-group">
                <label
                    class="control-label visible-ie8 visible-ie9 {{ $errors->has('password') ? ' has-error' : '' }}">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" id="password"
                    autocomplete="off" placeholder="Password" name="password" required />
                <span class="help-block">
                    <small>
                        @if ($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </small>
                </span>
            </div>
            <div class="">               
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />Remember
                <span></span>
                </label>
                <a href="{{route('admin.password.request')}}" class="forget-password">Forgot Password?</a>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-block green uppercase">Login</button>
            </div>
        </form>
        <!-- END LOGIN FORM -->


      

    </div>
@endsection

@section('additional-scripts')
    <script>
        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                },
                password: {
                    required: "Password is required."
                }
            },
         
            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },           
        });

    //     $('#forget-password').click(function() {
    //         $('.login-form').hide();
    //         $('.forget-form').show();
    //     });

    //     $('#back-btn').click(function() {
    //         $('.login-form').show();
    //         $('.forget-form').hide();
    //     });

    //     $('.forget-form').validate({
    //         errorElement: 'span',
    //         errorClass: 'help-block',
    //         focusInvalid: true,
    //         ignore: "",
    //         rules: {
    //             email: {
    //                 required: true,
    //                 email: true,
    //             }
    //         },
    //         messages: {
    //             email: {
    //                 required: "Email is required."
    //             }
    //         },
    //         highlight: function(element) { // hightlight error inputs
    //             $(element)
    //                 .closest('.form-group').addClass('has-error'); // set error class to the control group
    //         },
    //     });


    //     var forgotPasswordUrl = "{{ route('admin.password.email') }}";
    //     $('#forget-form').on('submit', function(e) {
    //         e.preventDefault();
    //         console.log('hello')
    //         console.log($(this).serialize());

    //         $.ajax({
    //             url: forgotPasswordUrl,
    //             type: "POST",
    //             data: $(this).serialize(),
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             contentType: "application/json; charset=utf-8",
    //             dataType: 'json',
    //             beforeSend: function() {
    //                 $('.help-block').remove();
    //                 $('.form-group').hide();
    //                 $('.form-actions').hide();
    //                 $('.loading-message').show();
    //             },
    //             error: function(error) {
    //                 console.log(`Error ${error}`)
    //             }
    //         }).done(function(data) {
    //             $('.form-group').show();
    //             $('.form-actions').show();
    //             $('.loading-message').hide();

    //             // if status failed
    //             console.log(data);
    //             $('#forget-password-title').after(
    //                 '<div class="alert alert-success"><button class="close" data-close="alert"></button><span>' +
    //                 data['message'] + '</span>');
    //             setTimeout(function() {
    //                 $(".alert").hide();
    //             }, 5000);
    //         }).fail(function(data) {
    //             console.log('failed:' + JSON.stringify(data.responseText))

    //             $('.form-group').show();
    //             $('.form-actions').show();
    //             $('.loading-message').hide();

    //             if (data.status == 422) {
    //                 $('#forget-password-title').after(
    //                     '<div class="alert alert-danger"><button class="close" data-close="alert"></button><span>' +
    //                     data.responseText[0] + '</span>'
    //                 )
    //             }
    //         });
    //     });
    // </script>
@endsection
