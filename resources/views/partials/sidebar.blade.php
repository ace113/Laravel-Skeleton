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

             <li class="nav-item {{ classActivePath('admin.dashboard') }}">
                 <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                     <i class="icon-home"></i>
                     <span class="title">Dashboard</span>
                     <span class="selected"></span>
                 </a>
             </li>

             <li
                 class="nav-item {{ classActivePath('admin.role') }}{{ classActivePath('admin.permission') }}{{ classActivePath('admin.user') }}">
                 <a href="javascript:;" class="nav-link nav-toggle">
                     <i class="icon-users"></i>
                     <span class="title">User Management</span>
                     <span class="arrow"></span>
                     <span class="selected"></span>
                 </a>
                 <ul
                     class="sub-menu {{ subMenuOpen('admin.role') }}{{ subMenuOpen('admin.permission') }}{{ subMenuOpen('admin.user') }}">
                     @can('role_access')
                         <li class="nav-item {{ classActivePath('admin.role') }}">
                             <a href="{{ route('admin.role.index') }}" class="nav-link">
                                 <i class="icon-check"></i>
                                 <span class="title">{{ trans('Role') }}</span>
                             </a>
                         </li>
                     @endcan
                     @can('permission_access')
                         <li class="nav-item {{ classActivePath('admin.permission') }}">
                             <a href="{{ route('admin.permission.index') }}" class="nav-link nav-toggle">
                                 <i class="icon-user-following"></i>
                                 <span class="title">Permission</span>
                             </a>
                         </li>
                     @endcan
                     <li class="nav-item {{ classActivePath('admin.user') }}">
                         <a href="{{ route('admin.user.index') }}" class="nav-link nav-toggle">
                             <i class="icon-users"></i>
                             <span class="title">Users</span>
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item {{ classActivePath('admin.page') }}">
                 @can('page_access')
                     <a href="{{ route('admin.page.index') }}" class="nav-link">
                         <i class="icon-doc"></i>
                         <span class="title">Pages</span>
                         <span class="selected"></span>
                     </a>
                 @endcan
             </li>        
             <li class="nav-item {{ classActivePath('admin.post')}}{{classActivePath('admin.comment') }}">
                 <a href="javascript:;" class="nav-link nav-toggle">
                     <i class="icon-settings"></i>
                     <span class="title">Blogs</span>
                     <span class="arrow"></span>
                     <span class="selected"></span>
                 </a>
                 <ul class="sub-menu {{ subMenuOpen('admin.post')}}{{subMenuOpen('admin.comment') }}">
                     <li class="nav-item">
                         <a href="{{ route('admin.post.index') }}" class="nav-link nav-toggle">
                             <i class="icon-list"></i>
                             <span class="title">Post</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('admin.comment.index') }}" class="nav-link nav-toggle">
                             <i class="fa fa-comment"></i>
                             <span class="title">Comments</span>
                         </a>
                     </li>
                 </ul>
             </li>
             <li class="nav-item {{ classActivePath('admin.edit') }}">
                 <a href="javascript:;" class="nav-link nav-toggle">
                     <i class="icon-settings"></i>
                     <span class="title">Settings</span>
                     <span class="arrow"></span>
                     <span class="selected"></span>
                 </a>
                 <ul class="sub-menu {{ subMenuOpen('admin.edit') }}">
                     <li class="nav-item">
                         <a href="{{ route('admin.edit.profile') }}" class="nav-link nav-toggle">
                             <i class="icon-list"></i>
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
