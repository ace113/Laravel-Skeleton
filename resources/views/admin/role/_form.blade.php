<input type="hidden" name="id" value="{{ $role->id ?? '' }}">
<div class="form-group" {{ $errors->has('name') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Name <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name ?? '') }}">
        @if ($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('slug') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Slug <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $role->slug ?? '') }}">
        @if ($errors->has('slug'))
            <span class="help-block">{{ $errors->first('slug') }}</span>
        @endif
    </div>
</div>

<div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}>
    <label class="col-md-3 control-label">Status <span class="text-danger">*</span></label>
    <div class="col-md-6">

        <select name="status" id="status" class="form-control">
            <option value="0" {{ old('status', $role->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
            <option value="1" {{ old('status', $role->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
        </select>

        @if ($errors->has('status'))
            <span class="help-block">{{ $errors->first('status') }}</span>
        @endif

    </div>
</div>

<div class="form-group">
    <div class="col-md-2"></div>
    <div class="col-md-6">
        <h4>
            Permissions
            <span>
                <a href="javascript:void(0);" class="per_select_all">Select All</a>
            </span>
            <span>
                /
            </span>
            <span>
                <a href="javascript:void(0);" class="per_deselect_all">Deselect All</a>
            </span>
        </h4>
    </div>
</div>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <div class="icheck-list">
            @foreach ($permissions as $permission)
                <label>
                    <input type="checkbox" class="icheck permission-check" name="permission[]"
                        data-checkbox="icheckbox_square-green" value="{{$permission->id}}" {{in_array($permission->id, $selectedPermissions) ? 'checked': ""}}> {{ ucwords($permission->title) }}
                </label>
            @endforeach
        </div>
    </div>
</div>
