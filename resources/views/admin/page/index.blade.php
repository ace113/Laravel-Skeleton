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
                    <span class="caption-subject bold uppercase">Pages List</span>
                </div>
                <div class="div">
                    <div class="pull-right">
                        <a href="{{route('admin.page.create')}}" class="btn green" title="Add new page"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <!-- TABLE BEGIN -->
                <table
                    class="table table-striped table-bordered table-hover table-checkable order-column table-manage"
                    id="datatable">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>Title</th>
                            <th>Slug</th>                                
                            <th>Body</th>
                            <th>Status</th>
                            <th></th>
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
    var dataUrl = "{{route('admin.page.index')}}";
    var deleteUrl = "/admin/page/";
    var statusUrl = "/admin/page/status";

    var columnData = [{
                data: "DT_RowIndex",
                searchable: false
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'body',
                name: 'body'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];

    console.log(column);
</script>
<script src="{{asset('js/datatable.js')}}"></script>
@endsection