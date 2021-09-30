<input type="hidden" name="id" value="{{$user->id??''}}">
<div class="form-group" {{ $errors->has('first_name') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">First name <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name ?? '') }}">
        @if ($errors->has('first_name'))
            <span class="help-block">{{ $errors->first('first_name') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('last_name') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Last name <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name ?? '') }}">
        @if ($errors->has('last_name'))
            <span class="help-block">{{ $errors->first('last_name') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('email') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Email <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
        @if ($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('phone') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Mobile Number <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
        @if ($errors->has('phone'))
            <span class="help-block">{{ $errors->first('phone') }}</span>
        @endif
    </div>
</div>
<div class="form-group" {{ $errors->has('password') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Password <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="password" name="password" id="password" class="form-control">
        @if ($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
    </div>
</div>
<div class="form-group" {{ $errors->has('password_confirmation') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Retype Password <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        @if ($errors->has('password_confirmation'))
            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>
</div>



<div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Status <span class="text-danger">*</span></label>
    <div class="col-md-6">
        
            <select name="status" id="status" class="form-control">              
                <option value="0" {{old('status', $user->status??'') == 0 ? 'selected': ''}}>Inactive</option>
                <option value="1" {{old('status', $user->status??'') == 1 ? 'selected': ''}}>Active</option>
            </select>

            @if ($errors->has('status'))
            <span class="help-block">{{$errors->first('status')}}</span>
            @endif
        
    </div>
</div>
