@extends('layouts.master')

@section('additional-css')
    <style>
        .profile-userpic img {
            border-radius: 50% !important;
            margin: 0 auto;
            object-fit: cover !important;
            width: 200px;
            height: 200px;
        }

        .profile-heading {
            margin-bottom: 2rem !important;
        }

        .user-name {
            font-size: 2.75rem;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .nav-tabs {
            border-bottom: 1px solid rgba(54, 198, 211, 0.1) !important;
           
        }

        .table {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: none !important;
        }

        .table td,
        .table th {
            border-top: 0 !important;
            padding: 10px !important;
        }

    </style>
@endsection

@section('content')
    <div class="row" style="margin-top:20px">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-tag font-dark"></i>
                        <span class="caption-subject bold uppercase">User Profile | Account</span>
                    </div>
                    <div class="div">
                        <div class="pull-right">
                            {{-- <a href="{{route('admin.user.create')}}" class="btn green" title="Add new user"><i
                                class="fa fa-plus"></i></a> --}}
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 4rem;">
                            <div class="profile-userpic">
                                <img src="{{ url($user->image_url) }}" alt="" class="img-responsive">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="profile-heading">
                                <div class="user-name">
                                    {{ $user->fullName }}
                                    <div class="float-right">
                                        @can('user_toggle_access')
                                        <button type="button" class="btn change-status {{$user->status ? 'btn-info': 'btn-danger'}}" data-id="{{$user->id}}">{{$user->status ? 'Active' : 'Disabled'}}</button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="user-role">
                                    {{ $user->email ?? '' }}
                                </div>
                            </div>
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Account Info</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    {{-- tab pane 1 --}}
                                    <div class="tab-pane active" id="tab_1_1">
                                        <table class="table">
                                            <tr>
                                                <th>First Name</th>
                                                <td>{{ $user->first_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Name</th>
                                                <td>{{ $user->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ '+977-' . $user->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{ $user->gender ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td>{{ $user->role->name ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    {{-- tab pane 2 --}}
                                    <div class="tab-pane" id="tab_1_2">
                                        This is timeline
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END  PORTLET-->
        </div>
    </div>
@endsection

@section('additional-scripts')
<script>
    const statusUrl = "/admin/user/status";
    const changeStatus = document.querySelector('.change-status');
    $(document).on('click', '.change-status', function () {
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            closeOnConfirm: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: statusUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    }
                }).done(function (result) {                    
                    if(result.status == 1){
                        if(changeStatus.innerText == "Active"){                            
                            changeStatus.classList.add('btn-danger');
                            changeStatus.classList.remove('btn-info');
                            changeStatus.innerText = "Disabled"
                        }else{                           
                            changeStatus.classList.add('btn-info')
                            changeStatus.classList.remove('btn-danger')
                            changeStatus.innerText = "Active";
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
