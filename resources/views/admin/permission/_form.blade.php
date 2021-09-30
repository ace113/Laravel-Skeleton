<input type="hidden" name="id" value="{{$permission->id??''}}">
<div class="form-group" {{ $errors->has('title') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Title<span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $permission->title ?? '') }}">
        @if ($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
        @endif
    </div>
</div>


