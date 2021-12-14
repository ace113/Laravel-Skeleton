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
                    <span class="caption-subject bold uppercase">Posts List</span>
                </div>
                <div class="div">
                    <div class="pull-right">
                        <a href="{{route('admin.post.create')}}" class="btn green" title="Add new post"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <!-- TABLE BEGIN -->
                <table
                    class="table table-striped table-bordered table-hover table-checkable order-column table-manage"
                    id="post-table">
                    <thead>
                        <tr>
                            <th width="40px">Sn.</th>
                            <th>Title</th>
                            <th>Slug</th>                                
                            <th>Body</th>
                            <th>Status</th>
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
    var dataUrl = "{{route('admin.post.index')}}";
    var deleteUrl = "/admin/post/";
    var statusUrl = "/admin/post/status";

   
</script>
<script src="{{asset('js/post-datatable.js')}}"></script>
@endsection