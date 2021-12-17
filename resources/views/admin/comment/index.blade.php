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
                    <span class="caption-subject bold uppercase">Comments List</span>
                </div>
                <div class="div">
                    <div class="pull-right">
                        {{-- <a href="{{route('admin.post.create')}}" class="btn green" title="Add new post"><i
                                class="fa fa-plus"></i></a> --}}       
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <!-- TABLE BEGIN -->
                <table
                    class="table table-striped table-bordered table-hover table-checkable order-column table-manage"
                    id="comment-table">
                    <thead>
                        <tr>
                            <th width="40px">Sn.</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>Model</th>
                            <th>Parent_id</th>                          
                            <th>Created At</th>
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
    var dataUrl = "{{route('admin.comment.index')}}";
    var deleteUrl = "/admin/comment/";
    var statusUrl = "/admin/comment/status";
    var model = "{{$params['model']}}"
    var cid = "{{$params['id']}}"
   
</script>
<script src="{{asset('js/comment-datatable.js')}}"></script>
@endsection