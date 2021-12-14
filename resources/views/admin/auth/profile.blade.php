@extends('layouts.master')

@section('content')
<div class="row" style="margin-top: 20px">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-user"></i>
                    <span class="caption-subject bold uppercase">Profile</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!--begin::form-->
                <form action="{{ route('admin.update.profile') }}" method="POST" class="form"
                    id="admin_profile" enctype="multipart/form-data">
                    @csrf                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <label for="first_name" class="control-label">First Name</label>
                                <input type="text" name="first_name" id="first_name"
                                    class="form-control {{ $errors->has('first_name') ? 'has-error' : '' }}"
                                    placeholder="First Name" value="{{old('first_name', $admin->first_name)}}">
                                <span class="help-block">
                                    @if ($errors->has('first_name'))
                                        <small>{{ $errors->first('first_name') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label for="last_name" class="control-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name"
                                    class="form-control {{ $errors->has('last_name') ? 'has-error' : '' }}"
                                    placeholder="Last Name" value="{{old('last_name', $admin->last_name)}}">
                                <span class="help-block">
                                    @if ($errors->has('last_name'))
                                        <small>{{ $errors->first('last_name') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control {{ $errors->has('email') ? 'has-error' : '' }}"
                                    placeholder="Email" value="{{old('email', $admin->email)}}">
                                <span class="help-block">
                                    @if ($errors->has('email'))
                                        <small>{{ $errors->first('email') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <label for="phone" class="control-label">Mobile Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control {{ $errors->has('phone') ? 'has-error' : '' }}"
                                    placeholder="Mobile Number" value="{{old('phone', $admin->phone)}}">
                                <span class="help-block">
                                    @if ($errors->has('phone'))
                                        <small>{{ $errors->first('phone') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                                <label for="image" class="control-label">Avatar</label>
                                @if($admin->image_url)
                                    <img src="{{url($admin->image_url)}}" alt="" class="img-responsive img-fluid">
                                
                                @endif
                                <input type="file" name="img" id="image" class="form-control">
                                <span class="help-block">
                                    @if ($errors->has('image'))
                                        <small>{{ $errors->first('image') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>                  

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn green">Update</button>
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