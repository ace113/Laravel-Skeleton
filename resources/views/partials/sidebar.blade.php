 <!-- BEGIN SIDEBAR -->
 <div class="page-sidebar-wrapper">
     <!-- BEGIN SIDEBAR -->

     <div class="page-sidebar navbar-collapse collapse">

         <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
             data-slide-speed="200" style="padding-top: 20px">

             <li class="sidebar-toggler-wrapper hide">
                 <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                 <div class="sidebar-toggler"> </div>
                 <!-- END SIDEBAR TOGGLER BUTTON -->
             </li>     

             <li class="nav-item start active open">
                 <a href="{{route('admin.dashboard')}}" class="nav-link nav-toggle">
                     <i class="icon-home"></i>
                     <span class="title">Dashboard</span>
                     <span class="selected"></span>
                 </a>
             </li>

             <li class="nav-item start open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">User Management</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @can('role_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.role.index') }}" class="nav-link">
                            <i class="fa fa-file"></i>
                            <span class="title">{{trans('Role')}}</span>
                        </a>
                    </li>
                    @endcan
                    @can('permission_access')
                    <li class="nav-item">
                        <a href="" class="nav-link nav-toggle">
                            <i class="icon-user"></i>
                            <span class="title">Permission</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a href="" class="nav-link nav-toggle">
                            <i class="icon-user"></i>
                            <span class="title">Users</span>
                        </a>
                    </li>
                </ul>
            </li>

             <li class="nav-item">
                 <a href="{{ route('admin.page.index') }}" class="nav-link">
                     <i class="fa fa-file"></i>
                     <span class="title">Pages</span>
                 </a>
             </li>        
             <li class="nav-item start open">
                 <a href="javascript:;" class="nav-link nav-toggle">
                     <i class="icon-settings"></i>
                     <span class="title">Settings</span>
                     <span class="arrow"></span>
                 </a>
                 <ul class="sub-menu">
                     <li class="nav-item">
                         <a href="{{ route('admin.edit.profile') }}" class="nav-link nav-toggle">
                             <i class="icon-user"></i>
                             <span class="title">Profile</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('admin.edit.password') }}" class="nav-link nav-toggle">
                             <i class="icon-user"></i>
                             <span class="title">Change Password</span>
                         </a>
                     </li>
                 </ul>
             </li>
         </ul>
         <!-- END SIDEBAR MENU -->
         <!-- END SIDEBAR MENU -->
     </div>
     <!-- END SIDEBAR -->
 </div>
 <!-- END SIDEBAR -->
