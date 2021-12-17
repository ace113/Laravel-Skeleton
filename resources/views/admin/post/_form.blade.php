<input type="hidden" name="id" value="{{$post->id??''}}">
<div class="form-group" {{ $errors->has('title') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Title <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title ?? '') }}">
        @if ($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('slug') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Slug <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}">
        @if ($errors->has('slug'))
            <span class="help-block">{{ $errors->first('slug') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('body') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Body <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <textarea name="body" id="body" cols="5" rows="2" class="form-control summernote">{!! old('body', $post->body ?? '') !!}</textarea>
        @if ($errors->has('body'))
            <span class="help-block">{{ $errors->first('body') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Status <span class="text-danger">*</span></label>
    <div class="col-md-6">
        
            <select name="status" id="status" class="form-control">              
                <option value="0" {{old('status', $post->status??'') == 0 ? 'selected': ''}}>Inactive</option>
                <option value="1" {{old('status', $post->status??'') == 1 ? 'selected': ''}}>Active</option>
            </select>

            @if ($errors->has('status'))
            <span class="help-block">{{$errors->first('status')}}</span>
            @endif
        
    </div>
</div>
