@extends('layouts.master')

@section('additional-css')
    
@endsection

@section('content')
<div class="row" style="margin-top:20px">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-tag font-dark"></i>
                    <span class="caption-subject bold uppercase">Permissions List</span>
                </div>
                <div class="div">
                    <div class="pull-right">
                        <a href="{{route('admin.permission.create')}}" class="btn green" title="Add new permission"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <!-- TABLE BEGIN -->
                <table
                    class="table table-striped table-bordered table-hover table-checkable order-column table-manage"
                    id="permission-table">
                    <thead>
                        <tr>
                            <th width="40px">Sn.</th>
                            <th>Permissions</th>
                            <th>Slug</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>                               
                    </tbody>
                </table>
                <!--TABLE END-->
            </div>
        </div>
        <!-- END  PORTLET-->
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    var dataUrl = "{{route('admin.permission.index')}}";
    var deleteUrl = "/admin/permission/";
    var statusUrl = "/admin/permission/status";

   
</script>
<script src="{{asset('js/permission-datatable.js')}}"></script>
@endsection