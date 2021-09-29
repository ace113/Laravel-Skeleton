@extends('layouts.master')

@section('breadcrumbs')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-plus font-dark"></i>
                        <span class="caption-subject bold uppercase">Add role</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form action="{{ route('admin.role.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            @include('admin.role._form')

                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-sm-6">
                                    <div class="noborder">
                                        <input type="submit" value="Submit" class="btn green btn-submit">
                                        <a href="{{ route('admin.role.index') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
@endsection
