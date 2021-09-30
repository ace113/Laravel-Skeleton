@extends('layouts.master')

@section('content')
    <div class="row" style="margin-top: 20px">
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-key"></i>
                        <span class="caption-subject bold uppercase">Change Password</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!--begin::form-->
                    <form action="{{ route('admin.update.password') }}" method="POST" class="form"
                        id="admin_change_password">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
                                    <label for="old-password" class="control-label">Current Password</label>
                                    <input type="password" name="old_password" id="old_password"
                                        class="form-control {{ $errors->has('old_password') ? 'has-error' : '' }}"
                                        placeholder="Password">
                                    <span class="help-block">
                                        @if ($errors->has('old_password'))
                                            <small>{{ $errors->first('old_password') }}</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="passowrd" class="control-label">New Password</label>
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <input type="password" name="password" id="password"
                                        class="form-control {{ $errors->has('password') ? 'has-error' : '' }}"
                                        placeholder="New Password">
                                    <span class="help-block">
                                        @if ($errors->has('password'))
                                            <small>{{ $errors->first('password') }}</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    <label for="password_confirmation" class="control-form">Retype New
                                        Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"
                                        placeholder="Retype New Password">
                                    <span class="help-block">
                                        @if ($errors->has('password_confirmation'))
                                            <small>{{ $errors->first('password_confirmation') }}</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn green">Submit</button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn default">Cancel</a>
                                </div>
                                <div class="col-md-6"> </div>
                            </div>
                        </div>
                    </form>
                    <!--end::form-->
                </div>
            </div>
        </div>
    @endsection

    @section('additional-scripts')

    @endsection
